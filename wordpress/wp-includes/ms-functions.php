<?php
/**
 * Multisite WordPress API
 *
 * @package WordPress
 * @subpackage Multisite
 * @since 3.0.0
 */

/**
 * Gets the network's site and user counts.
 *
 * @since MU 1.0
 *
 * @return array Site and user count for the network.
 */
function get_sitestats() {
	$stats = array(
		'blogs' => get_blog_count(),
		'users' => get_user_count(),
	);

	return $stats;
}

/**
 * Get one of a user's active blogs
 *
 * Returns the user's primary blog, if they have one and
 * it is active. If it's inactive, function returns another
 * active blog of the user. If none are found, the user
 * is added as a Subscriber to the Dashboard Blog and that blog
 * is returned.
 *
 * @since MU 1.0
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @param int $user_id The unique ID of the user
 * @return WP_Site|void The blog object
 */
function get_active_blog_for_user( $user_id ) {
	global $wpdb;
	$blogs = get_blogs_of_user( $user_id );
	if ( empty( $blogs ) )
		return;

	if ( !is_multisite() )
		return $blogs[$wpdb->blogid];

	$primary_blog = get_user_meta( $user_id, 'primary_blog', true );
	$first_blog = current($blogs);
	if ( false !== $primary_blog ) {
		if ( ! isset( $blogs[ $primary_blog ] ) ) {
			update_user_meta( $user_id, 'primary_blog', $first_blog->userblog_id );
			$primary = get_blog_details( $first_blog->userblog_id );
		} else {
			$primary = get_blog_details( $primary_blog );
		}
	} else {
		//TODO Review this call to add_user_to_blog too - to get here the user must have a role on this blog?
		add_user_to_blog( $first_blog->userblog_id, $user_id, 'subscriber' );
		update_user_meta( $user_id, 'primary_blog', $first_blog->userblog_id );
		$primary = $first_blog;
	}

	if ( ( ! is_object( $primary ) ) || ( $primary->archived == 1 || $primary->spam == 1 || $primary->deleted == 1 ) ) {
		$blogs = get_blogs_of_user( $user_id, true ); // if a user's primary blog is shut down, check their other blogs.
		$ret = false;
		if ( is_array( $blogs ) && count( $blogs ) > 0 ) {
			foreach ( (array) $blogs as $blog_id => $blog ) {
				if ( $blog->site_id != $wpdb->siteid )
					continue;
				$details = get_blog_details( $blog_id );
				if ( is_object( $details ) && $details->archived == 0 && $details->spam == 0 && $details->deleted == 0 ) {
					$ret = $blog;
					if ( get_user_meta( $user_id , 'primary_blog', true ) != $blog_id )
						update_user_meta( $user_id, 'primary_blog', $blog_id );
					if ( !get_user_meta($user_id , 'source_domain', true) )
						update_user_meta( $user_id, 'source_domain', $blog->domain );
					break;
				}
			}
		} else {
			return;
		}
		return $ret;
	} else {
		return $primary;
	}
}

/**
 * The number of active users in your installation.
 *
 * The count is cached and updated twice daily. This is not a live count.
 *
 * @since MU 2.7
 *
 * @return int
 */
function get_user_count() {
	return get_site_option( 'user_count' );
}

/**
 * The number of active sites on your installation.
 *
 * The count is cached and updated twice daily. This is not a live count.
 *
 * @since MU 1.0
 *
 * @param int $network_id Deprecated, not supported.
 * @return int
 */
function get_blog_count( $network_id = 0 ) {
	if ( func_num_args() )
		_deprecated_argument( __FUNCTION__, '3.1.0' );

	return get_site_option( 'blog_count' );
}

/**
 * Get a blog post from any site on the network.
 *
 * @since MU 1.0
 *
 * @param int $blog_id ID of the blog.
 * @param int $post_id ID of the post you're looking for.
 * @return WP_Post|null WP_Post on success or null on failure
 */
function get_blog_post( $blog_id, $post_id ) {
	switch_to_blog( $blog_id );
	$post = get_post( $post_id );
	restore_current_blog();

	return $post;
}

/**
 * Adds a user to a blog.
 *
 * Use the {@see 'add_user_to_blog'} action to fire an event when users are added to a blog.
 *
 * @since MU 1.0
 *
 * @param int    $blog_id ID of the blog you're adding the user to.
 * @param int    $user_id ID of the user you're adding.
 * @param string $role    The role you want the user to have
 * @return true|WP_Error
 */
function add_user_to_blog( $blog_id, $user_id, $role ) {
	switch_to_blog($blog_id);

	$user = get_userdata( $user_id );

	if ( ! $user ) {
		restore_current_blog();
		return new WP_Error( 'user_does_not_exist', __( 'The requested user does not exist.' ) );
	}

	if ( !get_user_meta($user_id, 'primary_blog', true) ) {
		update_user_meta($user_id, 'primary_blog', $blog_id);
		$details = get_blog_details($blog_id);
		update_user_meta($user_id, 'source_domain', $details->domain);
	}

	$user->set_role($role);

	/**
	 * Fires immediately after a user is added to a site.
	 *
	 * @since MU
	 *
	 * @param int    $user_id User ID.
	 * @param string $role    User role.
	 * @param int    $blog_id Blog ID.
	 */
	do_action( 'add_user_to_blog', $user_id, $role, $blog_id );
	wp_cache_delete( $user_id, 'users' );
	wp_cache_delete( $blog_id . '_user_count', 'blog-details' );
	restore_current_blog();
	return true;
}

/**
 * Remove a user from a blog.
 *
 * Use the {@see 'remove_user_from_blog'} action to fire an event when
 * users are removed from a blog.
 *
 * Accepts an optional `$reassign` parameter, if you want to
 * reassign the user's blog posts to another user upon removal.
 *
 * @since MU 1.0
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @param int    $user_id  ID of the user you're removing.
 * @param int    $blog_id  ID of the blog you're removing the user from.
 * @param string $reassign Optional. A user to whom to reassign posts.
 * @return true|WP_Error
 */
function remove_user_from_blog($user_id, $blog_id = '', $reassign = '') {
	global $wpdb;
	switch_to_blog($blog_id);
	$user_id = (int) $user_id;
	/**
	 * Fires before a user is removed from a site.
	 *
	 * @since MU
	 *
	 * @param int $user_id User ID.
	 * @param int $blog_id Blog ID.
	 */
	do_action( 'remove_user_from_blog', $user_id, $blog_id );

	// If being removed from the primary blog, set a new primary if the user is assigned
	// to multiple blogs.
	$primary_blog = get_user_meta($user_id, 'primary_blog', true);
	if ( $primary_blog == $blog_id ) {
		$new_id = '';
		$new_domain = '';
		$blogs = get_blogs_of_user($user_id);
		foreach ( (array) $blogs as $blog ) {
			if ( $blog->userblog_id == $blog_id )
				continue;
			$new_id = $blog->userblog_id;
			$new_domain = $blog->domain;
			break;
		}

		update_user_meta($user_id, 'primary_blog', $new_id);
		update_user_meta($user_id, 'source_domain', $new_domain);
	}

	// wp_revoke_user($user_id);
	$user = get_userdata( $user_id );
	if ( ! $user ) {
		restore_current_blog();
		return new WP_Error('user_does_not_exist', __('That user does not exist.'));
	}

	$user->remove_all_caps();

	$blogs = get_blogs_of_user($user_id);
	if ( count($blogs) == 0 ) {
		update_user_meta($user_id, 'primary_blog', '');
		update_user_meta($user_id, 'source_domain', '');
	}

	if ( $reassign != '' ) {
		$reassign = (int) $reassign;
		$post_ids = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_author = %d", $user_id ) );
		$link_ids = $wpdb->get_col( $wpdb->prepare( "SELECT link_id FROM $wpdb->links WHERE link_owner = %d", $user_id ) );

		if ( ! empty( $post_ids ) ) {
			$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->posts SET post_author = %d WHERE post_author = %d", $reassign, $user_id ) );
			array_walk( $post_ids, 'clean_post_cache' );
		}

		if ( ! empty( $link_ids ) ) {
			$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->links SET link_owner = %d WHERE link_owner = %d", $reassign, $user_id ) );
			array_walk( $link_ids, 'clean_bookmark_cache' );
		}
	}

	restore_current_blog();

	return true;
}

/**
 * Get the permalink for a post on another blog.
 *
 * @since MU 1.0
 *
 * @param int $blog_id ID of the source blog.
 * @param int $post_id ID of the desired post.
 * @return string The post's permalink
 */
function get_blog_permalink( $blog_id, $post_id ) {
	switch_to_blog( $blog_id );
	$link = get_permalink( $post_id );
	restore_current_blog();

	return $link;
}

/**
 * Get a blog's numeric ID from its URL.
 *
 * On a subdirectory installation like example.com/blog1/,
 * $domain will be the root 'example.com' and $path the
 * subdirectory '/blog1/'. With subdomains like blog1.example.com,
 * $domain is 'blog1.example.com' and $path is '/'.
 *
 * @since MU 2.6.5
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @param string $domain
 * @param string $path   Optional. Not required for subdomain installations.
 * @return int 0 if no blog found, otherwise the ID of the matching blog
 */
function get_blog_id_from_url( $domain, $path = '/' ) {
	$domain = strtolower( $domain );
	$path = strtolower( $path );
	$id = wp_cache_get( md5( $domain . $path ), 'blog-id-cache' );

	if ( $id == -1 ) // blog does not exist
		return 0;
	elseif ( $id )
		return (int) $id;

	$args = array(
		'domain' => $domain,
		'path' => $path,
		'fields' => 'ids',
	);
	$result = get_sites( $args );
	$id = array_shift( $result );

	if ( ! $id ) {
		wp_cache_set( md5( $domain . $path ), -1, 'blog-id-cache' );
		return 0;
	}

	wp_cache_set( md5( $domain . $path ), $id, 'blog-id-cache' );

	return $id;
}

// Admin functions

/**
 * Checks an email address against a list of banned domains.
 *
 * This function checks against the Banned Email Domains list
 * at wp-admin/network/settings.php. The check is only run on
 * self-registrations; user creation at wp-admin/network/users.php
 * bypasses this check.
 *
 * @since MU
 *
 * @param string $user_email The email provided by the user at registration.
 * @return bool Returns true when the email address is banned.
 */
function is_email_address_unsafe( $user_email ) {
	$banned_names = get_site_option( 'banned_email_domains' );
	if ( $banned_names && ! is_array( $banned_names ) )
		$banned_names = explode( "\n", $banned_names );

	$is_email_address_unsafe = false;

	if ( $banned_names && is_array( $banned_names ) ) {
		$banned_names = array_map( 'strtolower', $banned_names );
		$normalized_email = strtolower( $user_email );

		list( $email_local_part, $email_domain ) = explode( '@', $normalized_email );

		foreach ( $banned_names as $banned_domain ) {
			if ( ! $banned_domain )
				continue;

			if ( $email_domain == $banned_domain ) {
				$is_email_address_unsafe = true;
				break;
			}

			$dotted_domain = ".$banned_domain";
			if ( $dotted_domain === substr( $normalized_email, -strlen( $dotted_domain ) ) ) {
				$is_email_address_unsafe = true;
				break;
			}
		}
	}

	/**
	 * Filters whether an email address is unsafe.
	 *
	 * @since 3.5.0
	 *
	 * @param bool   $is_email_address_unsafe Whether the email address is "unsafe". Default false.
	 * @param string $user_email              User email address.
	 */
	return apply_filters( 'is_email_address_unsafe', $is_email_address_unsafe, $user_email );
}

/**
 * Sanitize and validate data required for a user sign-up.
 *
 * Verifies the validity and uniqueness of user names and user email addresses,
 * and checks email addresses against admin-provided domain whitelists and blacklists.
 *
 * The {@see 'wpmu_validate_user_signup'} hook provides an easy way to modify the sign-up
 * process. The value $result, which is passed to the hook, contains both the user-provided
 * info and the error messages created by the function. {@see 'wpmu_validate_user_signup'}
 * allows you to process the data in any way you'd like, and unset the relevant errors if
 * necessary.
 *
 * @since MU
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @param string $user_name  The login name provided by the user.
 * @param string $user_email The email provided by the user.
 * @return array Contains username, email, and error messages.
 */
function wpmu_validate_user_signup($user_name, $user_email) {
	global $wpdb;

	$errors = new WP_Error();

	$orig_username = $user_name;
	$user_name = preg_replace( '/\s+/', '', sanitize_user( $user_name, true ) );

	if ( $user_name != $orig_username || preg_match( '/[^a-z0-9]/', $user_name ) ) {
		$errors->add( 'user_name', __( 'Usernames can only contain lowercase letters (a-z) and numbers.' ) );
		$user_name = $orig_username;
	}

	$user_email = sanitize_email( $user_email );

	if ( empty( $user_name ) )
	   	$errors->add('user_name', __( 'Please enter a username.' ) );

	$illegal_names = get_site_option( 'illegal_names' );
	if ( ! is_array( $illegal_names ) ) {
		$illegal_names = array(  'www', 'web', 'root', 'admin', 'main', 'invite', 'administrator' );
		add_site_option( 'illegal_names', $illegal_names );
	}
	if ( in_array( $user_name, $illegal_names ) ) {
		$errors->add( 'user_name',  __( 'Sorry, that username is not allowed.' ) );
	}

	/** This filter is documented in wp-includes/user.php */
	$illegal_logins = (array) apply_filters( 'illegal_user_logins', array() );

	if ( in_array( strtolower( $user_name ), array_map( 'strtolower', $illegal_logins ) ) ) {
		$errors->add( 'user_name',  __( 'Sorry, that username is not allowed.' ) );
	}

	if ( is_email_address_unsafe( $user_email ) )
		$errors->add('user_email',  __('You cannot use that email address to signup. We are having problems with them blocking some of our email. Please use another email provider.'));

	if ( strlen( $user_name ) < 4 )
		$errors->add('user_name',  __( 'Username must be at least 4 characters.' ) );

	if ( strlen( $user_name ) > 60 ) {
		$errors->add( 'user_name', __( 'Username may not be longer than 60 characters.' ) );
	}

	// all numeric?
	if ( preg_match( '/^[0-9]*$/', $user_name ) )
		$errors->add('user_name', __('Sorry, usernames must have letters too!'));

	if ( !is_email( $user_email ) )
		$errors->add('user_email', __( 'Please enter a valid email address.' ) );

	$limited_email_domains = get_site_option( 'limited_email_domains' );
	if ( is_array( $limited_email_domains ) && ! empty( $limited_email_domains ) ) {
		$emaildomain = substr( $user_email, 1 + strpos( $user_email, '@' ) );
		if ( ! in_array( $emaildomain, $limited_email_domains ) ) {
			$errors->add('user_email', __('Sorry, that email address is not allowed!'));
		}
	}

	// Check if the username has been used already.
	if ( username_exists($user_name) )
		$errors->add( 'user_name', __( 'Sorry, that username already exists!' ) );

	// Check if the email address has been used already.
	if ( email_exists($user_email) )
		$errors->add( 'user_email', __( 'Sorry, that email address is already used!' ) );

	// Has someone already signed up for this username?
	$signup = $wpdb->get_row( $wpdb->prepare("SELECT * FROM $wpdb->signups WHERE user_login = %s", $user_name) );
	if ( $signup != null ) {
		$registered_at =  mysql2date('U', $signup->registered);
		$now = current_time( 'timestamp', true );
		$diff = $now - $registered_at;
		// If registered more than two days ago, cancel registration and let this signup go through.
		if ( $diff > 2 * DAY_IN_SECONDS )
			$wpdb->delete( $wpdb->signups, array( 'user_login' => $user_name ) );
		else
			$errors->add('user_name', __('That username is currently reserved but may be available in a couple of days.'));
	}

	$signup = $wpdb->get_row( $wpdb->prepare("SELECT * FROM $wpdb->signups WHERE user_email = %s", $user_email) );
	if ( $signup != null ) {
		$diff = current_time( 'timestamp', true ) - mysql2date('U', $signup->registered);
		// If registered more than two days ago, cancel registration and let this signup go through.
		if ( $diff > 2 * DAY_IN_SECONDS )
			$wpdb->delete( $wpdb->signups, array( 'user_email' => $user_email ) );
		else
			$errors->add('user_email', __('That email address has already been used. Please check your inbox for an activation email. It will become available in a couple of days if you do nothing.'));
	}

	$result = array('user_name' => $user_name, 'orig_username' => $orig_username, 'user_email' => $user_email, 'errors' => $errors);

	/**
	 * Filters the validated user registration details.
	 *
	 * This does not allow you to override the username or email of the user during
	 * registration. The values are solely used for validation and error handling.
	 *
	 * @since MU
	 *
	 * @param array $result {
	 *     The array of user name, email and the error messages.
	 *
	 *     @type string   $user_name     Sanitized and unique username.
	 *     @type string   $orig_username Original username.
	 *     @type string   $user_email    User email address.
	 *     @type WP_Error $errors        WP_Error object containing any errors found.
	 * }
	 */
	return apply_filters( 'wpmu_validate_user_signup', $result );
}

/**
 * Processes new site registrations.
 *
 * Checks the data provided by the user during blog signup. Verifies
 * the validity and uniqueness of blog paths and domains.
 *
 * This function prevents the current user from registering a new site
 * with a blogname equivalent to another user's login name. Passing the
 * $user parameter to the function, where $user is the other user, is
 * effectively an override of this limitation.
 *
 * Filter {@see 'wpmu_validate_blog_signup'} if you want to modify
 * the way that WordPress validates new site signups.
 *
 * @since MU
 *
 * @global wpdb   $wpdb
 * @global string $domain
 *
 * @param string         $blogname   The blog name provided by the user. Must be unique.
 * @param string         $blog_title The blog title provided by the user.
 * @param WP_User|string $user       Optional. The user object to check against the new site name.
 * @return array Contains the new site data and error messages.
 */
function wpmu_validate_blog_signup( $blogname, $blog_title, $user = '' ) {
	global $wpdb, $domain;

	$current_site = get_current_site();
	$base = $current_site->path;

	$blog_title = strip_tags( $blog_title );

	$errors = new WP_Error();
	$illegal_names = get_site_option( 'illegal_names' );
	if ( $illegal_names == false ) {
		$illegal_names = array( 'www', 'web', 'root', 'admin', 'main', 'invite', 'administrator' );
		add_site_option( 'illegal_names', $illegal_names );
	}

	/*
	 * On sub dir installs, some names are so illegal, only a filter can
	 * spring them from jail.
	 */
	if ( ! is_subdomain_install() ) {
		$illegal_names = array_merge( $illegal_names, get_subdirectory_reserved_names() );
	}

	if ( empty( $blogname ) )
		$errors->add('blogname', __( 'Please enter a site name.' ) );

	if ( preg_match( '/[^a-z0-9]+/', $blogname ) ) {
		$errors->add( 'blogname', __( 'Site names can only contain lowercase letters (a-z) and numbers.' ) );
	}

	if ( in_array( $blogname, $illegal_names ) )
		$errors->add('blogname',  __( 'That name is not allowed.' ) );

	if ( strlen( $blogname ) < 4 && !is_super_admin() )
		$errors->add('blogname',  __( 'Site name must be at least 4 characters.' ) );

	// do not allow users to create a blog that conflicts with a page on the main blog.
	if ( !is_subdomain_install() && $wpdb->get_var( $wpdb->prepare( "SELECT post_name FROM " . $wpdb->get_blog_prefix( $current_site->blog_id ) . "posts WHERE post_type = 'page' AND post_name = %s", $blogname ) ) )
		$errors->add( 'blogname', __( 'Sorry, you may not use that site name.' ) );

	// all numeric?
	if ( preg_match( '/^[0-9]*$/', $blogname ) )
		$errors->add('blogname', __('Sorry, site names must have letters too!'));

	/**
	 * Filters the new site name during registration.
	 *
	 * The name is the site's subdomain or the site's subdirectory
	 * path depending on the network settings.
	 *
	 * @since MU
	 *
	 * @param string $blogname Site name.
	 */
	$blogname = apply_filters( 'newblogname', $blogname );

	$blog_title = wp_unslash(  $blog_title );

	if ( empty( $blog_title ) )
		$errors->add('blog_title', __( 'Please enter a site title.' ) );

	// Check if the domain/path has been used already.
	if ( is_subdomain_install() ) {
		$mydomain = $blogname . '.' . preg_replace( '|^www\.|', '', $domain );
		$path = $base;
	} else {
		$mydomain = "$domain";
		$path = $base.$blogname.'/';
	}
	if ( domain_exists($mydomain, $path, $current_site->id) )
		$errors->add( 'blogname', __( 'Sorry, that site already exists!' ) );

	if ( username_exists( $blogname ) ) {
		if ( ! is_object( $user ) || ( is_object($user) && ( $user->user_login != $blogname ) ) )
			$errors->add( 'blogname', __( 'Sorry, that site is reserved!' ) );
	}

	// Has someone already signed up for this domain?
	$signup = $wpdb->get_row( $wpdb->prepare("SELECT * FROM $wpdb->signups WHERE domain = %s AND path = %s", $mydomain, $path) ); // TODO: Check email too?
	if ( ! empty($signup) ) {
		$diff = current_time( 'timestamp', true ) - mysql2date('U', $signup->registered);
		// If registered more than two days ago, cancel registration and let this signup go through.
		if ( $diff > 2 * DAY_IN_SECONDS )
			$wpdb->delete( $wpdb->signups, array( 'domain' => $mydomain , 'path' => $path ) );
		else
			$errors->add('blogname', __('That site is currently reserved but may be available in a couple days.'));
	}

	$result = array('domain' => $mydomain, 'path' => $path, 'blogname' => $blogname, 'blog_title' => $blog_title, 'user' => $user, 'errors' => $errors);

	/**
	 * Filters site details and error messages following registration.
	 *
	 * @since MU
	 *
	 * @param array $result {
	 *     Array of domain, path, blog name, blog title, user and error messages.
	 *
	 *     @type string         $domain     Domain for the site.
	 *     @type string         $path       Path for the site. Used in subdirectory installs.
	 *     @type string         $blogname   The unique site name (slug).
	 *     @type string         $blog_title Blog title.
	 *     @type string|WP_User $user       By default, an empty string. A user object if provided.
	 *     @type WP_Error       $errors     WP_Error containing any errors found.
	 * }
	 */
	return apply_filters( 'wpmu_validate_blog_signup', $result );
}

/**
 * Record site signup information for future activation.
 *
 * @since MU
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @param string $domain     The requested domain.
 * @param string $path       The requested path.
 * @param string $title      The requested site title.
 * @param string $user       The user's requested login name.
 * @param string $user_email The user's email address.
 * @param array  $meta       By default, contains the requested privacy setting and lang_id.
 */
function wpmu_signup_blog( $domain, $path, $title, $user, $user_email, $meta = array() )  {
	global $wpdb;

	$key = substr( md5( time() . rand() . $domain ), 0, 16 );
	$meta = serialize($meta);

	$wpdb->insert( $wpdb->signups, array(
		'domain' => $domain,
		'path' => $path,
		'title' => $title,
		'user_login' => $user,
		'user_email' => $user_email,
		'registered' => current_time('mysql', true),
		'activation_key' => $key,
		'meta' => $meta
	) );

	/**
	 * Fires after site signup information has been written to the database.
	 *
	 * @since 4.4.0
	 *
	 * @param string $domain     The requested domain.
	 * @param string $path       The requested path.
	 * @param string $title      The requested site title.
	 * @param string $user       The user's requested login name.
	 * @param string $user_email The user's email address.
	 * @param string $key        The user's activation key
	 * @param array  $meta       By default, contains the requested privacy setting and lang_id.
	 */
	do_action( 'after_signup_site', $domain, $path, $title, $user, $user_email, $key, $meta );
}

/**
 * Record user signup information for future activation.
 *
 * This function is used when user registration is open but
 * new site registration is not.
 *
 * @since MU
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @param string $user       The user's requested login name.
 * @param string $user_email The user's email address.
 * @param array  $meta       By default, this is an empty array.
 */
function wpmu_signup_user( $user, $user_email, $meta = array() ) {
	global $wpdb;

	// Format data
	$user = preg_replace( '/\s+/', '', sanitize_user( $user, true ) );
	$user_email = sanitize_email( $user_email );
	$key = substr( md5( time() . rand() . $user_email ), 0, 16 );
	$meta = serialize($meta);

	$wpdb->insert( $wpdb->signups, array(
		'domain' => '',
		'path' => '',
		'title' => '',
		'user_login' => $user,
		'user_email' => $user_email,
		'registered' => current_time('mysql', true),
		'activation_key' => $key,
		'meta' => $meta
	) );

	/**
	 * Fires after a user's signup information has been written to the database.
	 *
	 * @since 4.4.0
	 *
	 * @param string $user       The user's requested login name.
	 * @param string $user_email The user's email address.
	 * @param string $key        The user's activation key
	 * @param array  $meta       Additional signup meta. By default, this is an empty array.
	 */
	do_action( 'after_signup_user', $user, $user_email, $key, $meta );
}

/**
 * Notify user of signup success.
 *
 * This is the notification function used when site registration
 * is enabled.
 *
 * Filter {@see 'wpmu_signup_blog_notification'} to bypass this function or
 * replace it with your own notification behavior.
 *
 * Filter {@see 'wpmu_signup_blog_notification_email'} and
 * {@see 'wpmu_signup_blog_notification_subject'} to change the content
 * and subject line of the email sent to newly registered users.
 *
 * @since MU
 *
 * @param string $domain     The new blog domain.
 * @param string $path       The new blog path.
 * @param string $title      The site title.
 * @param string $user       The user's login name.
 * @param string $user_email The user's email address.
 * @param string $key        The activation key created in wpmu_signup_blog()
 * @param array  $meta       By default, contains the requested privacy setting and lang_id.
 * @return bool
 */
function wpmu_signup_blog_notification( $domain, $path, $title, $user, $user_email, $key, $meta = array() ) {
	/**
	 * Filters whether to bypass the new site email notification.
	 *
	 * @since MU
	 *
	 * @param string|bool $domain     Site domain.
	 * @param string      $path       Site path.
	 * @param string      $title      Site title.
	 * @param string      $user       User login name.
	 * @param string      $user_email User email address.
	 * @param string      $key        Activation key created in wpmu_signup_blog().
	 * @param array       $meta       By default, contains the requested privacy setting and lang_id.
	 */
	if ( ! apply_filters( 'wpmu_signup_blog_notification', $domain, $path, $title, $user, $user_email, $key, $meta ) ) {
		return false;
	}

	// Send email with activation link.
	if ( !is_subdomain_install() || get_current_site()->id != 1 )
		$activate_url = network_site_url("wp-activate.php?key=$key");
	else
		$activate_url = "http://{$domain}{$path}wp-activate.php?key=$key"; // @todo use *_url() API

	$activate_url = esc_url($activate_url);
	$admin_email = get_site_option( 'admin_email' );
	if ( $admin_email == '' )
		$admin_email = 'support@' . $_SERVER['SERVER_NAME'];
	$from_name = get_site_option( 'site_name' ) == '' ? 'WordPress' : esc_html( get_site_option( 'site_name' ) );
	$message_headers = "From: \"{$from_name}\" <{$admin_email}>\n" . "Content-Type: text/plain; charset=\"" . get_option('blog_charset') . "\"\n";
	$message = sprintf(
		/**
		 * Filters the message content of the new blog notification email.
		 *
		 * Content should be formatted for transmission via wp_mail().
		 *
		 * @since MU
		 *
		 * @param string $content    Content of the notification email.
		 * @param string $domain     Site domain.
		 * @param string $path       Site path.
		 * @param string $title      Site title.
		 * @param string $user       User login name.
		 * @param string $user_email User email address.
		 * @param string $key        Activation key created in wpmu_signup_blog().
		 * @param array  $meta       By default, contains the requested privacy setting and lang_id.
		 */
		apply_filters( 'wpmu_signup_blog_notification_email',
			__( "To activate your blog, please click the following link:\n\n%s\n\nAfter you activate, you will receive *another email* with your login.\n\nAfter you activate, you can visit your site here:\n\n%s" ),
			$domain, $path, $title, $user, $user_email, $key, $meta
		),
		$activate_url,
		esc_url( "http://{$domain}{$path}" ),
		$key
	);
	// TODO: Don't hard code activation link.
	$subject = sprintf(
		/**
		 * Filters the subject of the new blog notification email.
		 *
		 * @since MU
		 *
		 * @param string $subject    Subject of the notification email.
		 * @param string $domain     Site domain.
		 * @param string $path       Site path.
		 * @param string $title      Site title.
		 * @param string $user       User login name.
		 * @param string $user_email User email address.
		 * @param string $key        Activation key created in wpmu_signup_blog().
		 * @param array  $meta       By default, contains the requested privacy setting and lang_id.
		 */
		apply_filters( 'wpmu_signup_blog_notification_subject',
			__( '[%1$s] Activate %2$s' ),
			$domain, $path, $title, $user, $user_email, $key, $meta
		),
		$from_name,
		esc_url( 'http://' . $domain . $path )
	);
	wp_mail( $user_email, wp_specialchars_decode( $subject ), $message, $message_headers );
	return true;
}

/**
 * Notify user of signup success.
 *
 * This is the notification function used when no new site has
 * been requested.
 *
 * Filter {@see 'wpmu_signup_user_notification'} to bypass this function or
 * replace it with your own notification behavior.
 *
 * Filter {@see 'wpmu_signup_user_notification_email'} and
 * {@see 'wpmu_signup_user_notification_subject'} to change the content
 * and subject line of the email sent to newly registered users.
 *
 * @since MU
 *
 * @param string $user       The user's login name.
 * @param string $user_email The user's email address.
 * @param string $key        The activation key created in wpmu_signup_user()
 * @param array  $meta       By default, an empty array.
 * @return bool
 */
function wpmu_signup_user_notification( $user, $user_email, $key, $meta = array() ) {
	/**
	 * Filters whether to bypass the email notification for new user sign-up.
	 *
	 * @since MU
	 *
	 * @param string $user       User login name.
	 * @param string $user_email User email address.
	 * @param string $key        Activation key created in wpmu_signup_user().
	 * @param array  $meta       Signup meta data.
	 */
	if ( ! apply_filters( 'wpmu_signup_user_notification', $user, $user_email, $key, $meta ) )
		return false;

	// Send email with activation link.
	$admin_email = get_site_option( 'admin_email' );
	if ( $admin_email == '' )
		$admin_email = 'support@' . $_SERVER['SERVER_NAME'];
	$from_name = get_site_option( 'site_name' ) == '' ? 'WordPress' : esc_html( get_site_option( 'site_name' ) );
	$message_headers = "From: \"{$from_name}\" <{$admin_email}>\n" . "Content-Type: text/plain; charset=\"" . get_option('blog_charset') . "\"\n";
	$message = sprintf(
		/**
		 * Filters the content of the notification email for new user sign-up.
		 *
		 * Content should be formatted for transmission via wp_mail().
		 *
		 * @since MU
		 *
		 * @param string $content    Content of the notification email.
		 * @param string $user       User login name.
		 * @param string $user_email User email address.
		 * @param string $key        Activation key created in wpmu_signup_user().
		 * @param array  $meta       Signup meta data.
		 */
		apply_filters( 'wpmu_signup_user_notification_email',
			__( "To activate your user, please click the following link:\n\n%s\n\nAfter you activate, you will receive *another email* with your login." ),
			$user, $user_email, $key, $meta
		),
		site_url( "wp-activate.php?key=$key" )
	);
	// TODO: Don't hard code activation link.
	$subject = sprintf(
		/**
		 * Filters the subject of the notification email of new user signup.
		 *
		 * @since MU
		 *
		 * @param string $subject    Subject of the notification email.
		 * @param string $user       User login name.
		 * @param string $user_email User email address.
		 * @param string $key        Activation key created in wpmu_signup_user().
		 * @param array  $meta       Signup meta data.
		 */
		apply_filters( 'wpmu_signup_user_notification_subject',
			__( '[%1$s] Activate %2$s' ),
			$user, $user_email, $key, $meta
		),
		$from_name,
		$user
	);
	wp_mail( $user_email, wp_specialchars_decode( $subject ), $message, $message_headers );
	return true;
}

/**
 * Activate a signup.
 *
 * Hook to {@see 'wpmu_activate_user'} or {@see 'wpmu_activate_blog'} for events
 * that should happen only when users or sites are self-created (since
 * those actions are not called when users and sites are created
 * by a Super Admin).
 *
 * @since MU
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @param string $key The activation key provided to the user.
 * @return array|WP_Error An array conta
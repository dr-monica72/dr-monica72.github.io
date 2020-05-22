<?php
return array (
  'uuid' => '2e35bbde-353d-2e2b-0692-2a3a2caad9d2',
  'type' => 'contact',
  'recipients' => 'visiontohealth72@gmail.com',
  'subject' => 'Contact Form',
  'reply' => 'Your message was sent. Thank you.',
  'buttonText' => 'Send e-mail',
  'captchaEnabled' => true,
  'visibilityMode' => 'all',
  'styles' => 
  array (
    'margin' => '0 0 0 0',
    'padding' => '5px 10px 5px 10px',
    'background' => '',
    'backgroundColor' => 'transparent',
    'backgroundPosition' => 'top left',
    'backgroundStretch' => 'tile',
    'backgroundOpacity' => '100',
    'borderRadius' => '0 0 0 0',
    'boxShadow' => 'none',
    'textColor' => 'inherit',
    'textStroke' => false,
    'linkColor' => 'inherit',
    'linkStroke' => false,
    'h1Color' => 'inherit',
    'h1Stroke' => false,
    'h2Color' => 'inherit',
    'h2Stroke' => false,
  ),
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'name',
      'type' => 'textfield',
      'title' => 'Name',
      'required' => true,
    ),
    1 => 
    array (
      'name' => 'mail',
      'type' => 'email',
      'title' => 'E-mail',
      'required' => true,
    ),
    2 => 
    array (
      'name' => 'message',
      'type' => 'textarea',
      'title' => 'Message',
      'required' => true,
    ),
  ),
  'badCaptcha' => 'The text you entered does not match the text provided in the picture.',
  'wrongRequest' => 'Wrong request',
  'isPassCaptcha' => false,
  'recaptchaPrivateKey' => '6LcIkNMSAAAAAL_dH5rlWS0XsGfXg9IODumFDHeK',
);
?>
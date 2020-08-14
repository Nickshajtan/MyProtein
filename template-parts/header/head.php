<?php
/*
* Contain meta information
*
*/
?>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="language" content="<?php echo get_locale(); ?>">
	<meta name="theme-color" content="black">
    <?php if( defined('SITE_INFO') && !empty( SITE_INFO ) ) : ?>
        <meta name="copyright" content="<?php echo SITE_INFO; ?>">
    <?php endif; ?>
    <!--	Apple     -->
    <?php if( defined('SITE_INFO') && !empty( SITE_INFO ) ) : ?>
        <meta name="apple-mobile-web-app-title" content="<?php echo SITE_INFO; ?>">
    <?php endif; ?>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <!--	End Apple     -->
    <!--    Android   -->
    <?php if( defined('SITE_INFO') && !empty( SITE_INFO ) ) : ?>
        <meta name="application-name" content="<?php echo SITE_INFO; ?>">
    <?php endif; ?>
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#000000">
    <!--    End Android   -->
    <!--    Windows   -->
    <?php if( defined('SITE_INFO') && !empty( SITE_INFO ) ) : ?>
        <meta name="application-name" content="<?php echo SITE_INFO; ?>">
    <?php endif; ?>
    <meta name="msapplication-TileColor" content="#dddddd">
    <meta name="msapplication-window" content="width=1024;height=768">
    <?php if( defined('SITE_NAME') && !empty( SITE_NAME ) ) : ?>
        <meta name="msapplication-tooltip" content="<?php echo SITE_NAME; ?>">
    <?php endif; ?>
    <!--    End Windows   -->
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
	<?php $customizing = get_option('hcc-theme-wp-customizing'); 
    if( $customizing && current_theme_supports('custom-background') ) :

      $body_style = '';
      $background_image = ( !empty( get_background_image() ) ) ? get_background_image() : false;

      if( $background_image ) :
        $position_x       = get_theme_mod( 'background_position_x', get_theme_support( 'custom-background', 'default-position-x' ) );
        $position_x       = ( !empty( $position_x ) ) ? 'background-position-x: ' . $position_x . ';' : '';
        $position_y       = get_theme_mod( 'background_position_y', get_theme_support( 'custom-background', 'default-position-y' ) );
        $position_y       = ( !empty( $position_x ) ) ? 'background-position-y: ' . $position_y . ';' : '';
        $size             = get_theme_mod( 'background_size',       get_theme_support( 'custom-background', 'default-size' ) );
        $size             = ( !empty( $position_x ) ) ? 'background-size: ' . $size . ';' : '';
        $repeat           = get_theme_mod( 'background_repeat',     get_theme_support( 'custom-background', 'default-repeat' ) );
        $repeat           = ( !empty( $position_x ) ) ? 'background-position-x: ' . $repeat . ';' : '';
        $attachment       = get_theme_mod( 'background_attachment', get_theme_support( 'custom-background', 'default-attachment' ) );
        $attachment       = ( !empty( $position_x ) ) ? 'background-position-x: ' . $attachment . ';' : '';

        $body_style  = '<style>';
        $body_style .= 'body {';
        $body_style .= 'background-image: url(' . $background_image . ');';
        $body_style .= $position_x;
        $body_style .= $position_y;
        $body_style .= $size;
        $body_style .= $repeat;
        $body_style .= $attachment;
        $body_style .= '}</style>';

        echo $body_style;
      endif;

    endif; ?>
</head>
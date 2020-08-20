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
	<?php wp_head(); ?>
</head>
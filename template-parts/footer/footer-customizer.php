<?php
/*
 * If site customizer enabled this file implement customizer settings styles
 *
 */

$body_style = '';
      $background_image = ( current_theme_supports('custom-background') && !empty( get_background_image() ) ) ? get_background_image() : false;

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

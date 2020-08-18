<?php 
/*
 * Frontend switcher for colors theme sets  
 *
 */

$scheme_switch = get_option('options_acf_color_theme_switcher');

if( $scheme_switch ) : ?>
<div class="switcher d-block sun">
            <div class="light-theme"></div>
            <div class="dark-theme"></div>
</div>
<?php endif; ?>

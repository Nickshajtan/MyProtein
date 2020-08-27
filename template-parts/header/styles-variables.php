<?php
/*
 * Use this file for customizer styles vars
 * 
 *
 */

/**
 * Convert HEX to RGB
 * 
 * @parm string $hex          Color
 * @parm bool $return_string  Result as string or array
 * @return array|string|bool  In case of error false
 */
function hcc_styles_hexToRgb($hex, $return_string = true, $return_value = false) 
{
	$hex = trim($hex, ' #');
 
	$size = strlen($hex);	
	if ($size == 3 || $size == 4) {
		$parts = str_split($hex, 1);
		$hex = '';
		foreach ($parts as $row) {
			$hex .= $row . $row;
		}		
	}
 
	$dec = hexdec($hex);
	$rgb = array();
	if ($size == 3 || $size == 6) {
		$rgb['red']   = 0xFF & ($dec >> 0x10);
		$rgb['green'] = 0xFF & ($dec >> 0x8);
		$rgb['blue']  = 0xFF & $dec;
 
        if( $return_value ) {
          return implode(',', $rgb);
        }
      
		if ($return_string) {
			return 'rgb(' . implode(',', $rgb) . ')';
		}
	} elseif ($size == 4 || $size == 8) {
		$rgb['red']   = 0xFF & ($dec >> 0x16);
		$rgb['green'] = 0xFF & ($dec >> 0x10);
		$rgb['blue']  = 0xFF & ($dec >> 0x8);
		$rgb['alpha'] = 0xFF & $dec;
 
		if ($return_string) {
			$rgb['alpha'] = round(($rgb['alpha'] / (255 / 100)) / 100, 2);
			return 'rgba(' . implode(',', $rgb) . ')';
		} else {
			$rgb['alpha'] = 127 - ($rgb['alpha'] >> 1);
		}		
	} else {
		return false;
	}
	
	return $rgb;
}

?>
<style>
  :root {
    /*** Colors ***/
    --colorOne:   <?php echo hcc_styles_hexToRgb('#FFE95D', true); ?>;
    --colorTwo:   <?php echo hcc_styles_hexToRgb('#FFC65D', true); ?>;
    --colorThree: <?php echo hcc_styles_hexToRgb('#7FE553', true); ?>;
    --colorFour:  <?php echo hcc_styles_hexToRgb('#40951B', true); ?>;
    --colorFive:  <?php echo hcc_styles_hexToRgb('#8FDDD4', true); ?>;
    
    --colorText:     <?php echo hcc_styles_hexToRgb('#1B1B1B', true); ?>;
    --colorHeaders:  <?php echo hcc_styles_hexToRgb('#1B1B1B', true); ?>;
    /*** Colors End ***/
    /*** Color RGB Strings ***/
    --colorStrOne:   <?php echo hcc_styles_hexToRgb('#FFE95D', true, true); ?>;
    --colorStrTwo:   <?php echo hcc_styles_hexToRgb('#FFC65D', true, true); ?>;
    --colorStrThree: <?php echo hcc_styles_hexToRgb('#7FE553', true, true); ?>;
    --colorStrFour:  <?php echo hcc_styles_hexToRgb('#40951B', true, true); ?>;
    --colorStrFive:  <?php echo hcc_styles_hexToRgb('#8FDDD4', true, true); ?>;
    /*** Color RGB Strings End ***/
    /*** Fonts ***/
    --fontsOne:   'Montserrat';
    --fontsTwo:   'Oswald';
    --fontsThree: 'Roboto';
    /*** Fonts End ***/
  }
</style>

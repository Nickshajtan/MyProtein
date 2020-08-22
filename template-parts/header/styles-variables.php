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
    --colorOne:   <?php echo hcc_styles_hexToRgb('#000', true, true); ?>;
    --colorTwo:   <?php echo hcc_styles_hexToRgb('#fff', true, true); ?>;
    --colorThree: <?php echo hcc_styles_hexToRgb('#ddd', true, true); ?>;
    --colorFour:  <?php echo hcc_styles_hexToRgb('#333', true, true); ?>;
  }
</style>

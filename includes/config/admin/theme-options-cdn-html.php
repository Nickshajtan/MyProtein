   	<table class="form-table">
			<tr valign="top">
		       <th><?php echo __('Paste your CDN styles', 'hcc'); ?></th>
               <td>
                  <p class="description"><?php echo __('Use "%space%" as separator.', 'hcc'); ?></p>
                  <p>
                    <label for="hcc-theme-cdn-styles">
                      <?php $text = get_option('hcc-theme-cdn-styles');
                            $text = ( !empty( $text ) ) ? trim( $text) : ''; ?>
                      <textarea id="hcc-theme-cdn-styles" name="hcc-theme-cdn-styles" cols="10" rows="8"><?php echo $text; ?></textarea>
                    </label>
                  </p>
               </td>
			</tr>
			<tr>
				<th><?php echo __('Paste your CDN scripts', 'hcc'); ?></th>
                <td>
                  <p class="description"><?php echo __('Use "%space%" as separator.', 'hcc'); ?></p>
                  <p>
                    <label for="hcc-theme-cdn-scripts">
                     <?php $text = get_option('hcc-theme-cdn-scripts');
                           $text = ( !empty( $text ) ) ? trim( $text) : ''; ?>
                      <textarea id="hcc-theme-cdn-scripts" name="hcc-theme-cdn-scripts" cols="10" rows="8"><?php echo $text; ?></textarea>
                    </label>
                  </p>
                </td>
			</tr>
    </table>
    <style>
      textarea { 
        max-width: 100%;
        width: 100%;
        display: block;
      }
    </style>

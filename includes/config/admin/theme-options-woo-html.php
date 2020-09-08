   	<table class="form-table">
			<tr valign="top">
				<th><?php echo 'Woocommerce ' . __('cache', 'hcc'); ?></th>
				<td>
					<p class="description"><?php echo __("Disable browser caching for WOO ajax basket.", 'hcc'); ?></p>
					<?php $cleaner = get_option('hcc-theme-woo-cache'); ?>
					<p> <label> <input name="hcc-theme-woo-cache" type="checkbox" value="1" <?php checked( '1', $cleaner); ?>/> <?php echo __('Use', 'hcc'); ?> </label></p> 
				</td>
			</tr>
		</table>

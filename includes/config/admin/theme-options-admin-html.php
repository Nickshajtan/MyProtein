   	<table class="form-table">
			<tr valign="top">
				<th><?php echo __('Instructions page', 'hcc'); ?></th>
				<td>
					<p class="description"><?php echo __('Instructions admin page visibility', 'hcc'); ?></p>
					<?php $instructions_page = get_option('hcc-theme-admin-instructions'); ?>
					<p><label>
                        <input name="hcc-theme-admin-instructions" type="checkbox" value="1" <?php checked( '1', $instructions_page ); ?>/>
					    <?php echo __('Enable', 'hcc'); ?>
				    </label></p> 
				</td>
			</tr>
    </table>

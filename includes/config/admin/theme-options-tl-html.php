   	<table class="form-table">
			<tr valign="top">
				<th><?php echo __('Life reload', 'hcc'); ?></th>
				<td>
					<p class="description"><?php echo __('BrowserSync life reloading. By default use :3000 port, if you wish to setup it you should change configure files.', 'hcc'); ?></p>
					<?php $browsersync = get_option('hcc-theme-tl-reload'); ?>
					<p><label>
                        <input name="hcc-theme-tl-reload" type="checkbox" value="1" <?php checked( '1', $browsersync ); ?>/>
					    <?php echo __('Disable', 'hcc'); ?>
				    </label></p> 
				</td>
			</tr>
    </table>

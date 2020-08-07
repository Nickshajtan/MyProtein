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
			<tr>
			  <th><?php echo __('Use libs including', 'hcc'); ?></th>
			  <td>
			    <p class="description"><?php echo __('Disabling JS/CSS/PHP libs including for default theme setup.', 'hcc'); ?></p>
			    <?php $libs = get_option('hcc-theme-tl-libs-off'); ?>
				<p><label>
                        <input name="hcc-theme-tl-libs-off" type="checkbox" value="1" <?php checked( '1', $libs ); ?>/>
					    <?php echo __('Disable', 'hcc'); ?>
				 </label></p> 
			  </td>
			</tr>
			<?php if( !$libs ) :
            $syntax = get_option('hcc-theme-tl-libs-syntax'); ?>
			<tr>
			  <th><?php echo __('Libs including syntax', 'hcc'); ?></th>
			  <td>
                <p class="description"><?php echo __('Choose PHP including syntax from "Cases" or "If/Else". Default by "Cases".', 'hcc'); ?></p>
			    <p><label>
                        <input name="hcc-theme-tl-libs-syntax" type="checkbox" value="1" <?php checked( '1', $syntax ); ?>/>
					    <?php echo __('Choose "If/Else"', 'hcc'); ?>
		         </label></p> 
			  </td>
			</tr>
			<?php endif; ?>
    </table>

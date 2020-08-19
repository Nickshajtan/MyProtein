   	<table class="form-table">
			<tr valign="top">
				<th><?php echo __('Life reload', 'hcc'); ?></th>
				<td>
					<p class="description"><?php echo __('BrowserSync life reloading. By default use :3000 port, if you wish to setup it you should change configure files.', 'hcc'); ?></p>
					<?php $browsersync = get_option('hcc-theme-tl-reload'); ?>
					<p><label>
                        <input name="hcc-theme-tl-reload" type="checkbox" value="1" <?php checked( '1', $browsersync ); ?>/>
					    <?php echo __('Enable', 'hcc'); ?>
				    </label></p> 
				</td>
			</tr>
			<tr>
				<th><?php echo __('Use frontend preloader', 'hcc'); ?></th>
				<td>
					<p class="description"><?php echo __('Enable default theme preloader.', 'hcc'); ?></p>
					<?php $loader = get_option('hcc-theme-tl-preloader'); ?>
					<p><label>
                        <input name="hcc-theme-tl-preloader" type="checkbox" value="1" <?php checked( '1', $loader ); ?>/>
					    <?php echo __('Enable', 'hcc'); ?>
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
			<tr>
			  <th><?php echo __('Use GZIP/ZLIB', 'hcc'); ?></th>
			  <td>
			    <p class="description"><?php echo __('Enable PHP ZLIB compression', 'hcc'); ?></p>
			    <?php $zlib = get_option('hcc-theme-tl-zlib'); ?>
			    <p><label>
                        <input name="hcc-theme-tl-zlib" type="checkbox" value="1" <?php checked( '1', $zlib ); ?>/>
					    <?php echo __('Enable', 'hcc'); ?>
				 </label></p> 
			  </td>
			</tr>
			<tr>
              <th></th>
			  <td>
			    <p class="description"><?php echo __('Enable PHP GZIP compression', 'hcc'); ?></p>
			    <?php $gzip = get_option('hcc-theme-tl-gzip'); ?>
			    <p><label>
                        <input name="hcc-theme-tl-gzip" type="checkbox" value="1" <?php checked( '1', $gzip ); ?>/>
					    <?php echo __('Enable', 'hcc'); ?>
				 </label></p> 
			  </td>
			</tr>
    </table>

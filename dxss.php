<div class="wrap">
	<h2><img width="32" height="32" src="<?php echo $dxss_pluginpath; ?>images/dx-share-selection.png" align="absmiddle"/>&nbsp;DX Share Selection <span class="smallText">v<?php echo DXSS_VERSION; ?></span></h2>

	<div id="leftContent">
		<form method="post">
			<div class="content">
				<div class="dxss-settings">
					<h4>General</h4>
					<section class="initial-settings">
						<p>
							<label for="widget-title">Widget Title</label>
							<input name="dxss_title" id="dxss_title" type="text" value="<?php echo $dxss_title; ?>"/>
						</p>
						<p>
							<?php _e( 'Share Items', 'dxss' ); ?>
						</p>
						<p>
							<select name="select" id="addList"></select>
							<input type="button" id="addCustom" class="toolBt button" value="<?php _e( 'Add custom button', 'dxss' ); ?>"/>
							<input type="button" id="addSearch" class="toolBt button" value="<?php _e( 'Add search button', 'dxss' ); ?>"/>
							<input type="button" class="toolBt openWpsrLinks button" value="<?php _e( 'More buttons', 'dxss' ); ?>"/>
							<input type="button" class="toolBt openHelp button" value="<?php _e( 'Help', 'dxss' ); ?>"/>
						</p>
						<p class="textarea-preview-wrapper">
							<textarea name="dxss_lists" id="dxss_lists"><?php echo esc_html($dxss_lists); ?></textarea>
							<span class="test-preview"></span>
						</p>
						<p>
							<span class="smallText"><?php _e( 'Format : Name, Share/Search URL, Icon URL', 'dxss' ); ?></span></td>
						</p>
					</section>

					<div id="colorpicker" class="picker"></div>

					<section class="color-settings">
						<h4 clas="color-settings-heading"><?php _e( 'Customize', 'dxss' ); ?></h4>
						<p>
							<label for="dxss_borderColor"><?php _e( 'Border Color', 'dxss' ); ?></label>
							<input name="dxss_borderColor" id="dxss_borderColor" class="color" type="text" value="<?php echo $dxss_borderColor; ?>"/>
						</p>
						<p>
							<label for="dxss_bgColor"><?php _e( 'Background Color', 'dxss' ); ?></label>
							<input name="dxss_bgColor" id="dxss_bgColor" class="color" type="text" value="<?php echo $dxss_bgColor; ?>"/>
						</p>
						<p>
							<label for="dxss_titleColor"><?php _e( 'Title Background color', 'dxss' ); ?></label>
							<input name="dxss_titleColor" id="dxss_titleColor" class="color" type="text" value="<?php echo $dxss_titleColor; ?>"/>
						</p>
						<p>
							<label for="dxss_hoverColor"><?php _e( 'Hover Color', 'dxss' ); ?></label>
							<input name="dxss_hoverColor" id="dxss_hoverColor" class="color" type="text" value="<?php echo $dxss_hoverColor; ?>"/>
						</p>
						<p>
							<label for="dxss_textColor"><?php _e( 'Text Color', 'dxss' ); ?></label>
							<input name="dxss_textColor" id="dxss_textColor" class="color" type="text" value="<?php echo $dxss_textColor; ?>"/>
						</p>
						<p>
							<label><?php _e( 'Extra Class', 'dxss' ); ?></label>
							<input name="dxss_extraClass" type="text" value="<?php echo $dxss_extraClass; ?>"/>
						</p>
						<div class="restore-button-parent"><input type="button" id="restore-customize" class="toolBt button" value="<?php _e('Restore Customize Settings', 'dxss'); ?>" /></div>
					</section>
					<section class="optional-settings">
						<h4><?php _e( 'Optional', 'dxss' ); ?></h4>
						<p>
							<label for="dxss_scriptPlace"><?php _e( 'Load scripts in', 'dxss' ); ?></label>
							<select id="dxss_scriptPlace" name="dxss_scriptPlace">
								<option <?php echo $dxss_scriptPlace == '0' ? ' selected="selected"' : ''; ?> value="0"><?php _e( 'Header', 'dxss' ); ?></option>
								<option <?php echo $dxss_scriptPlace == '1' ? ' selected="selected"' : ''; ?> value="1"><?php _e( 'Footer', 'dxss' ); ?></option>
							</select>
						</p>
						<p>
							<label for="dxss_truncateChars"><?php _e( 'Truncate Text', 'dxss' ); ?></label>
							<input name="dxss_truncateChars" type="text" id="dxss_truncateChars" value="<?php echo $dxss_truncateChars; ?>"/>
							<small class="smallText"><?php _e( 'Selected texts are truncated when <code>%ts</code> is used in the URL', 'dxss' ); ?></small>
						</p>
						<p>
							<label for="target-content"><?php _e( 'Target Content', 'dxss' ); ?></label>
							<input name="dxss_element" id="target-content" type="text" value="<?php echo $dxss_element; ?>"/></br>
							<small class="smallText"><?php _e('The DX Share Selection will work only with this jQuery selector'); ?></small>
						</p>
						<p>
							<label for="bilty"><?php _e( 'Bitly Settings', 'dxss' ); ?></label>
							<input name="dxss_bitly" type="text" value="<?php echo $dxss_bitly; ?>" id="bilty"/>
							<small class="smallText"><?php _e('Bitly Username, API key. Used for <code>{surl}</code>', 'dxss'); ?></small>
						</p>
						<div class="restore-button-parent"><input type="button" id="restore-optional" class="toolBt button" value="<?php _e('Restore Optional Settings', 'dxss'); ?>" /></div>
					</section>
				</div>

				<h4><?php _e( 'Preview', 'dxss' ); ?></h4>
				<div class="section preview">
					<small class="smallText"><?php _e( 'Select a text to show the widget', 'dxss' ); ?></small><br/>
					Lorem ipsum et natum omnesque vel, id audire repudiandae mei, eirmod tritani ex usu. Ius ex wisi labores nonummy, omnis fuisset persequeris no ius. Eam modus persecuti ex, qui in alienum vulputate, kasd elitr an cum. Corpora molestiae forensibus quo ei, autem dicam vivendo ne
					eum. Id numquam nominavi similique usu.
				</div>

				<input class="button-primary" type="submit" name="dxss_submit" id="dxss_submit" value="	    <?php _e( 'Update', 'dxss' ); ?>     "/>
			</div>
		</form>
	</div>

	<div class="lightBox helpWindow bottomShadow">
		<input type="button" class="closeHelp close button" value="Close"/>
		<h3><?php _e( 'Help', 'dxss' ); ?></h3>
		<hr/>
		<div class="wrap">
			<p><?php _e( 'The format for adding a custom button to the widget is', 'dxss' ); ?><br/>
				<?php _e( '<code>Name of the button</code>, <code>Share / Search URL</code>, <code>Icon URL</code>', 'dxss' ); ?></p>

			<b><?php _e( 'Note:', 'dxss' ); ?></b><br/>
			<ol>
				<li><?php _e( 'Use <code>%s</code> in the Share/Search URL to use the selected text.', 'dxss' ); ?></li>
				<li><?php _e( 'Use <code>%ts</code> in the URL to use the truncated selected text (115 characters. Used in Twitter URL).', 'dxss' ); ?></li>
				<li><?php _e( 'Use the text <code>favicon</code> in the Icon URL to automatically get the button icon.', 'dxss' ); ?></li>
				<li><?php _e( 'Use <code>{url}</code> in the URL to get the current page url.', 'dxss' ); ?></li>
				<li><?php _e( 'Use <code>{surl}</code> in the URL to get the shortened current page URL.', 'dxss' ); ?></li>
				<li><?php _e( 'Use <code>{title}</code> in the URL to get the current page title.', 'dxss' ); ?></li>
			</ol>
			<p class="smallText"><?php _e( 'Popular and recommended buttons are given in by default. Just select the button from the dropdown list. Above settings are required only if you want to add a custom button or change the template', 'dxss' ); ?></p>
		</div>
	</div>

	<div class="lightBox wpsrBox bottomShadow">
		<?php if ( function_exists( 'wp_socializer' ) ): ?>
			<input type="button" class="closeLinks close button" value="Close"/>
			<h3><?php _e( 'Insert more social buttons', 'dxss' ); ?></h3>
			<small class="smallText"><?php _e( 'These buttons are taken from wp-socializer plugin. You can now use these buttons for wp-selected-text-searcher', 'dxss' ); ?></small>
			<div class="listSearch"><input type="text" id="dxss_list_search" title="<?php _e( 'Search ...', 'dxss' ); ?>" size="35"/>
			</div>
			<hr/>
			<div class="wrap">
				<ol class="dxss_wpsr_sites">
					<?php dxss_wpsr_get_links(); ?>
				</ol>
			</div>
		<?php else: ?>
			<input type="button" class="closeLinks close button" value="Close"/>
			<h3><?php _e( 'Install WP Socializer plugin', 'dxss' ); ?></h3>
			<hr/>
			<p><?php _e( 'Sorry, you need to install <b>WP Socializer plugin</b> to get the additional social buttons links and data.', 'dxss' ); ?></p>
			<p><?php _e( 'You can install the powerful WP Socializer plugin in one click securely by clicking the Install button below.', 'dxss' ); ?></p>
			<?php
			$installUrl = 'https://wordpress.org/plugins/wp-socializer/';
			?>
			<p align="center"><a href="<?php echo $installUrl; ?>" target="_blank" class="button-primary"><?php _e( 'Install Plugin', 'dxss' ); ?></a></p>
			<b><?php _e( 'Note:', 'dxss' ); ?></b><br/>
			<small class="smallText"><?php _e( 'DX share Selection requires to install WP Socializer to link the additional 98 buttons. <a href="https://wordpress.org/plugins/wp-socializer/" target="_blank">See here</a> for more info', 'dxss' ); ?></small>
		<?php endif; ?>
	</div>


</div>

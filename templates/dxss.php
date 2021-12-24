<?php
/**
 * Contains the html for the Share Selection popup.
 *
 * @package DX-Share-Selection
 */

?>

<h2 class="dxss-header"><img width="32" height="32" src="<?php echo esc_url( DXSS_URL ); ?>images/dx-share-selection.png" style="vertical-align: middle;"/>&nbsp;DX Share Selection <span class="smallText header-small">v<?php echo esc_html( DXSS_VERSION ); ?></span></h2>
<div class="wrap main-wrap">
	<div id="leftContent">
		<form method="post">
			<div class="content">
				<div class="dxss-settings">
					<h4><?php esc_html_e( 'General', 'dxss' ); ?></h4>
					<section class="section initial-settings">
						<div class="widget-title">
							<label for="dxss_title"><?php esc_html_e( 'Widget Title', 'dxss' ); ?></label>
							<input class="dxss-settings-input" name="dxss_title" id="dxss_title" type="text" value="<?php echo esc_attr( $dxss_settings['title'] ); ?>"/>
						</div>
						<div class="default-buttons-list">
							<div class="smallText buttons-text"><?php esc_html_e( 'Add buttons', 'dxss' ); ?></div>
							<div id="addList"></div>
						</div>
						<div class="other-buttons-list">
							<div class="smallText buttons-text"><?php esc_html_e( 'Other buttons', 'dxss' ); ?></div>
							<div>
								<input type="button" id="addCustom" class="toolBt button" value="<?php esc_attr_e( 'Add custom button', 'dxss' ); ?>"/>
								<input type="button" id="addSearch" class="toolBt button" value="<?php esc_attr_e( 'Add search button', 'dxss' ); ?>"/>
								<input type="button" class="toolBt openWpsrLinks button" value="<?php esc_attr_e( 'More buttons', 'dxss' ); ?>"/>
								<input type="button" class="toolBt openHelp button" value="<?php esc_attr_e( 'Help', 'dxss' ); ?>"/>
							</div>
						</div>
						<div>
							<textarea class="dxss-settings-input" name="dxss_lists" id="dxss_lists"><?php echo esc_html( $dxss_settings['lists'] ); ?></textarea>
						</div>
						<span class="smallText"><?php esc_html_e( 'Format : Name, Share/Search URL, Icon URL', 'dxss' ); ?></span>
					</section>
					<h4 class="color-settings-heading"><?php esc_html_e( 'Customize', 'dxss' ); ?></h4>
					<section class="section color-settings">
						<div class="colors-wrapper">
							<div id="colorpicker" class="picker"></div>
							<p>
								<label class="center-label" for="dxss_borderColor"><?php esc_html_e( 'Border Color', 'dxss' ); ?></label>
								<input name="dxss_borderColor" id="dxss_borderColor" class="color dxss-settings-input" type="text" value="<?php echo esc_attr( $dxss_settings['borderColor'] ); ?>"/>
							</p>
							<p>
								<label class="center-label" for="dxss_bgColor"><?php esc_html_e( 'Background Color', 'dxss' ); ?></label>
								<input name="dxss_bgColor" id="dxss_bgColor" class="color dxss-settings-input" type="text" value="<?php echo esc_html( $dxss_settings['bgColor'] ); ?>"/>
							</p>
							<p>
								<label class="center-label" for="dxss_titleColor"><?php esc_html_e( 'Title Background color', 'dxss' ); ?></label>
								<input name="dxss_titleColor" id="dxss_titleColor" class="color dxss-settings-input" type="text" value="<?php echo esc_html( $dxss_settings['titleColor'] ); ?>"/>
							</p>
							<p>
								<label class="center-label" for="dxss_titleTextColor"><?php esc_html_e( 'Title Text Color', 'dxss' ); ?></label>
								<input name="dxss_titleTextColor" id="dxss_titleTextColor" class="color dxss-settings-input" type="text" value="<?php echo esc_html( $dxss_settings['titleTextColor'] ); ?>"/>
							</p>
							<p>
								<label class="center-label" for="dxss_hoverColor"><?php esc_html_e( 'Hover Color', 'dxss' ); ?></label>
								<input name="dxss_hoverColor" id="dxss_hoverColor" class="color dxss-settings-input" type="text" value="<?php echo esc_html( $dxss_settings['hoverColor'] ); ?>"/>
							</p>
							<p>
								<label class="center-label" for="dxss_textColor"><?php esc_html_e( 'Text Color', 'dxss' ); ?></label>
								<input name="dxss_textColor" id="dxss_textColor" class="color dxss-settings-input" type="text" value="<?php echo esc_html( $dxss_settings['textColor'] ); ?>"/>
							</p>
							<p class="p-with-small">
								<label class="smalltext-label" for="dxss_extraClass"><?php esc_html_e( 'Extra Class', 'dxss' ); ?></label>
								<span class="inner-span">
									<input name="dxss_extraClass" id="dxss_extraClass" class="dxss-settings-input" type="text" value="<?php echo esc_html( $dxss_settings['extraClass'] ); ?>"/>
									<small class="smallText"><?php esc_html_e( 'This class will be added to the main Share Selection div', 'dxss' ); ?></small>
								</span>
							</p>
						</div>
						<div class="restore-button-parent"><input type="button" id="restore-customize" class="toolBt button dxss-restore-button" value="<?php esc_html_e( 'Restore Customize Settings', 'dxss' ); ?>" /></div>
					</section>
					<h4><?php esc_html_e( 'Optional', 'dxss' ); ?></h4>
					<section class="section optional-settings">
						<p class="p-with-small">
							<label class="smalltext-label" ><?php esc_html_e( 'Load scripts in', 'dxss' ); ?></label>
							<span class="inner-span">
								<select id="dxss_scriptPlace" name="dxss_scriptPlace">
									<option <?php echo intval( $dxss_settings['scriptPlace'] ) === 0 ? ' selected="selected"' : ''; ?> value="0"><?php esc_html_e( 'Header', 'dxss' ); ?></option>
									<option <?php echo intval( $dxss_settings['scriptPlace'] ) === 1 ? ' selected="selected"' : ''; ?> value="1"><?php esc_html_e( 'Footer', 'dxss' ); ?></option>
								</select>
								<small class="smallText"><?php esc_html_e( 'Choose where to load the main scripts', 'dxss' ); ?></small>
							</span>
						</p>
						<p class="p-with-small">
							<label class="smalltext-label" ><?php esc_html_e( 'Truncate Text', 'dxss' ); ?></label>
							<span class="inner-span">
								<input class="dxss-settings-input" name="dxss_truncateChars" id="dxss_truncateChars" type="text" value="<?php echo esc_attr( $dxss_settings['truncateChars'] ); ?>"/>
								<small class="smallText"><?php _e( 'Selected texts are truncated when <code>%ts</code> is used in the URL', 'dxss' ); ?></small>
							</span>
						</p>
						<p class="p-with-small">
							<label class="smalltext-label" ><?php esc_html_e( 'Target Content', 'dxss' ); ?></label>
							<span class="inner-span">
								<input name="dxss_element" id="dxss_element" type="text" value="<?php echo esc_attr( $dxss_settings['element'] ); ?>"/>
								<small class="smallText"><?php esc_html_e( 'The DX Share Selection will work only with this jQuery selector', 'dxss' ); ?></small>
							</span>
						</p>
						<p class="p-with-small">
							<label class="smalltext-label" ><?php esc_html_e( 'Bitly Token', 'dxss' ); ?></label>
							<span class="inner-span">
								<input name="dxss_bitly_token" type="text" value="<?php echo ! empty( $dxss_settings['bitly_token'] ) ? esc_html( DXSS_Encryption::$dumb_token_view ) : ''; ?>" autocomplete="off"/>
								<small class="smallText"><?php _e( 'Bitly API Access Token. Used for <code>{surl}</code>', 'dxss' ); ?> <a href="https://bitly.is/accesstoken" target="_blank"><?php esc_html_e( 'Generate here', 'dxss' ); ?></a></small>
							</span>
						</p>
						<p class="p-checkbox">
							<label><?php _e('Deactivate on Desktop', 'dxss'); ?></label>
							<input type="checkbox" name="dxss_deact_desktop" value="activate" <?php echo checked( 'activate', $dxss_settings['deactDesktop'], false ) ?>>
						</p>
						<p class="p-checkbox">
							<label><?php _e('Deactivate on Mobile', 'dxss'); ?></label>
							<input type="checkbox" name="dxss_deact_mobile" value="activate" <?php echo checked( 'activate', $dxss_settings['deactMobile'], false ) ?>>
						</p>
						<div class="restore-button-parent"><input type="button" id="restore-optional" class="toolBt button dxss-restore-button" value="<?php esc_attr_e( 'Restore Optional Settings', 'dxss' ); ?>" /></div>
					</section>
					<input class="button-primary" type="submit" name="dxss_submit" id="dxss_submit" value="<?php esc_attr_e( 'Save Changes', 'dxss' ); ?>"/>
				</div>
			</div>
		</form>
	</div>
	<div id="rightContent">
		<h4 class="preview-text"><?php esc_html_e( 'Preview', 'dxss' ); ?>:</h4>
		<div class="test-preview section"></div>
	</div>
	<div class="modal-overlay">
		<div class="modal custom-button-window">
			<input type="button" class="close-custom-button close button" value="Close"/>
			<h3><?php esc_html_e( 'Add Custom Button', 'dxss' ); ?></h3>
			<hr/>
			<div class="wrap">
				<div class="customName">
					<label for="dxss_custom_name"><?php esc_html_e( '*Enter the name of the button.', 'dxss' ); ?>:</label>
					<input class="popup-input" type="text" id="dxss_custom_name" title="<?php esc_attr_e( 'Button Name', 'dxss' ); ?>" placeholder="Google, Wikipedia..." size="35"/>
				</div>
				<div class="customURL">
					<label for="dxss_custom_url"><?php esc_html_e( '*Enter the Share URL of the site.', 'dxss' ); ?></label>
					<label for="dxss_custom_url"><?php esc_html_e( 'Use %s in the URL for the selected text.', 'dxss' ); ?></label>
					<label for="dxss_custom_url"><?php esc_html_e( 'See help for more terms', 'dxss' ); ?>:</label>
					<input class="popup-input" type="text" id="dxss_custom_url" title="<?php esc_attr_e( 'Button URL', 'dxss' ); ?>" placeholder="https://..." size="35"/>
				</div>
				<div class="customIcon">
					<label for="dxss_custom_icon"><?php esc_html_e( 'Enter the Icon URL.', 'dxss' ); ?></label>
					<label for="dxss_custom_icon"><?php esc_html_e( 'Use "favicon" to automatically get the Icon', 'dxss' ); ?>:</label>
					<input class="popup-input" type="text" id="dxss_custom_icon" title="<?php esc_attr_e( 'Button Icon', 'dxss' ); ?>" placeholder="favicon" size="35"/>
				</div>
				<div class="buttons-wrapper">
					<input type="button" class="close-custom-button close button" value="Cancel"/>
					<input type="button" class="add-custom-button add button" value="Add Button"/>
				</div>
			</div>
		</div>
		<div class="modal search-button-window">
			<input type="button" class="close-search-button close button" value="Close"/>
			<h3><?php esc_html_e( 'Add Search Button', 'dxss' ); ?></h3>
			<hr/>
			<div class="wrap">
				<div class="searchName">
					<label for="dxss_search_name"><?php esc_html_e( '*Enter the name of the button', 'dxss' ); ?>:</label>
					<input class="popup-input" type="text" id="dxss_search_name" title="<?php esc_attr_e( 'Button Name', 'dxss' ); ?>" placeholder="Search my Blog" size="35"/>
				</div>
				<div class="searchURL">
					<label for="dxss_search_url"><?php esc_html_e( '*Enter the Search URL of your site.', 'dxss' ); ?></label>
					<label for="dxss_search_url"><?php esc_html_e( 'Use %s in the URL for the selected text.', 'dxss' ); ?></label>
					<label for="dxss_search_url"><?php esc_html_e( 'See help for more terms', 'dxss' ); ?>:</label>
					<input class="popup-input" type="text" id="dxss_search_url" title="<?php esc_attr_e( 'Button URL', 'dxss' ); ?>" placeholder="https://domain.com/?s=%s" size="35"/>
				</div>
				<div class="searchIcon">
					<label for="dxss_search_icon"><?php esc_html_e( 'Enter the Icon URL.', 'dxss' ); ?></label>
					<label for="dxss_search_icon"><?php esc_html_e( 'Use "favicon" to automatically get the Icon', 'dxss' ); ?>:</label>
					<input class="popup-input" type="text" id="dxss_search_icon" title="<?php esc_attr_e( 'Button Icon', 'dxss' ); ?>" placeholder="favicon" size="35"/>
				</div>
				<div class="buttons-wrapper">
					<input type="button" class="close-search-button close button" value="Cancel"/>
					<input type="button" class="add-search-button add button" value="Add Button"/>
				</div>
			</div>
		</div>
		<div class="modal helpWindow">
			<input type="button" class="closeHelp close button" value="Close"/>
			<h3><?php esc_html_e( 'Help', 'dxss' ); ?></h3>
			<hr/>
			<div class="wrap">
				<p><?php esc_html_e( 'The format for adding a custom button to the widget is', 'dxss' ); ?><br/>
					<?php _e( '<code>Name of the button</code>, <code>Share / Search URL</code>, <code>Icon URL</code>', 'dxss' ); ?></p>

				<b><?php esc_html_e( 'Note:', 'dxss' ); ?></b><br/>
				<ol>
					<li><?php _e( 'Use <code>%s</code> in the Share/Search URL to use the selected text.', 'dxss' ); ?></li>
					<li><?php _e( 'Use <code>%ts</code> in the URL to use the truncated selected text (115 characters. Used in Twitter URL).', 'dxss' ); ?></li>
					<li><?php _e( 'Use the text <code>favicon</code> in the Icon URL to automatically get the button icon.', 'dxss' ); ?></li>
					<li><?php _e( 'Use <code>{url}</code> in the URL to get the current page url.', 'dxss' ); ?></li>
					<li><?php _e( 'Use <code>{surl}</code> in the URL to get the shortened current page URL.', 'dxss' ); ?></li>
					<li><?php _e( 'Use <code>{title}</code> in the URL to get the current page title.', 'dxss' ); ?></li>
				</ol>
				<p class="smallText"><?php esc_html_e( 'Popular and recommended buttons are given in by default. Just select the button from the list. Above settings are required only if you want to add a custom button or change the template', 'dxss' ); ?></p>
			</div>
		</div>
		<div class="modal wpsrBox">
			<?php if ( class_exists( 'WPSR_Lists' ) ) : ?>
				<input type="button" class="closeLinks close button" value="Close"/>
				<h3><?php esc_html_e( 'Insert more social buttons', 'dxss' ); ?></h3>
				<small class="smallText"><?php esc_html_e( 'These buttons are taken from wp-socializer plugin. You can now use these buttons for wp-selected-text-searcher', 'dxss' ); ?></small>
				<div class="listSearch"><input class="popup-input" type="text" id="dxss_list_search" title="<?php esc_attr_e( 'Search ...', 'dxss' ); ?>" size="35"/>
				</div>
				<hr/>
				<div class="wrap">
					<ol class="dxss_wpsr_sites">
						<?php DXSS_WPSR::dxss_wpsr_get_links(); ?>
					</ol>
				</div>
			<?php else : ?>
				<input type="button" class="closeLinks close button" value="Close"/>
				<h3><?php esc_html_e( 'Install WP Socializer plugin', 'dxss' ); ?></h3>
				<hr/>
				<p><?php _e( 'Sorry, you need to install <b>WP Socializer plugin</b> to get the additional social buttons links and data.', 'dxss' ); ?></p>
				<p><?php esc_html_e( 'You can install the powerful WP Socializer plugin in one click securely by clicking the Install button below.', 'dxss' ); ?></p>
				<?php
				$install_url = 'https://wordpress.org/plugins/wp-socializer/';
				?>
				<p style="align:center"><a href="<?php echo esc_url( $install_url ); ?>" target="_blank" class="button-primary"><?php esc_html_e( 'Install Plugin', 'dxss' ); ?></a></p>
				<b><?php esc_html_e( 'Note:', 'dxss' ); ?></b><br/>
				<small class="smallText"><?php _e( 'DX share Selection requires to install WP Socializer to link the additional 98 buttons. <a href="https://wordpress.org/plugins/wp-socializer/" target="_blank">See here</a> for more info', 'dxss' ); ?></small>
			<?php endif; ?>
		</div>
	</div>
	<div class="sidebars">
		<?php include_once( 'sidebar-right-help.php' );?>
		<?php include_once( 'sidebar-right-plugins.php' );?>
	</div>
</div>

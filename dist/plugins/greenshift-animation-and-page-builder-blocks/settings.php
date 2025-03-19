<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('GSPB_GreenShift_Settings')) {

	class GSPB_GreenShift_Settings
	{
		private $allowed_font_ext = [
			'woff2',
			'woff',
			'tiff',
			'ttf',
		];

		private $global_settings = array();

		public function __construct()
		{
			$this->global_settings = get_option('gspb_global_settings');
			add_filter('body_class', array($this, 'gspb_front_body_class'));
			
			add_filter('admin_body_class', array($this, 'gspb_admin_body_class'));
			add_action('admin_menu', array($this, 'greenshift_admin_page'));
			add_action('wp_footer', array($this, 'greenshift_additional__footer_elements'));
			add_action('wp_head', array($this, 'greenshift_additional__header_elements'));
			add_action('wp_ajax_gspb_generate_stylebook', array($this, 'gspb_generate_stylebook'));
			add_action('admin_init', array($this, 'gspb_stylebook_redirect'));
			add_action('admin_enqueue_scripts', array($this, 'greenshift_admin_enqueue_scripts'));
			add_filter('block_categories_all', array($this, 'gspb_greenShift_category'), 11, 2);
			add_filter('block_editor_settings_all', array($this, 'gspb_generate_custom_block_settings'), 10, 2);
			if (!defined('REHUB_ADMIN_DIR')) {
				//Show Reusable blocks column
				add_filter('manage_wp_block_posts_columns', array($this, 'gspb_template_screen_add_column'));
				add_action('manage_wp_block_posts_custom_column', array($this, 'gspb_template_screen_fill_column'), 1000, 2);
				// Force Block editor for Reusable Blocks even when Classic editor plugin is activated
				add_filter('use_block_editor_for_post', array($this, 'gspb_template_gutenberg_post'), 1000, 2);
				add_filter('use_block_editor_for_post_type', array($this, 'gspb_template_gutenberg_post_type'), 1000, 2);
				//Shortcode output for reusable blocks
				add_shortcode('wp_reusable_render', array($this, 'gspb_template_shortcode_function'));
				//Ajax render action
				add_action('wp_ajax_gspb_el_reusable_load', array($this, 'gspb_el_reusable_load'));
				add_action('wp_ajax_nopriv_gspb_el_reusable_load', array($this, 'gspb_el_reusable_load'));
				//settings fonts actions
				add_action('wp_ajax_gspb_settings_add_font', array($this, 'gspb_settings_add_font'));
			}
		}

		public function gspb_front_body_class($classes)
		{
			$classes[] = 'gspbody';
			$classes[] = 'gspb-bodyfront';
			$global_settings = $this->global_settings;
			if (!empty($global_settings['dark_mode_on'])) {
				if (isset($_COOKIE['darkmode'])){
					$classes[] = 'darkmode';
				}
			}
			return $classes;
		}
		public function gspb_admin_body_class($classes)
		{
			$classes .= ' gspbody gspb-bodyadmin ';
			return $classes;
		}

		function gspb_generate_custom_block_settings($settings, $block_editor_context)
		{
			$global_settings = $this->global_settings;
			if (empty($global_settings['anchors_disable'])) {
				$settings['generateAnchors'] = true;
			}
			if (!empty($global_settings['simplified_panels'])) {
				$settings['canLockBlocks'] = current_user_can( 'manage_options' );
			}
			return $settings;
		}

		public function gspb_greenShift_category($categories, $post)
		{
			$global_settings = $this->global_settings;
			if ((!empty($global_settings['show_element_block']) && ($global_settings['show_element_block'] === 'bothelement' || $global_settings['show_element_block'] === 'element'))) {
				return array_merge(
					array(
						array(
							'slug'  => 'GreenLightLayout',
							'title' => __('GreenLight Layout Elements', 'greenshift-animation-and-page-builder-blocks'),
						),
						array(
							'slug'  => 'GreenLightContent',
							'title' => __('GreenLight Content Elements', 'greenshift-animation-and-page-builder-blocks'),
						),
						array(
							'slug'  => 'GreenLightExtra',
							'title' => __('GreenLight Extra Elements', 'greenshift-animation-and-page-builder-blocks'),
						),
						array(
							'slug'  => 'GreenLightTags',
							'title' => __('GreenLight Tags Elements', 'greenshift-animation-and-page-builder-blocks'),
						),
						array(
							'slug'  => 'GreenShiftLayout',
							'title' => __('GreenShift Layout Blocks', 'greenshift-animation-and-page-builder-blocks'),
						),
						array(
							'slug'  => 'GreenShiftContent',
							'title' => __('GreenShift Content Blocks', 'greenshift-animation-and-page-builder-blocks'),
						),
						array(
							'slug'  => 'GreenShiftExtra',
							'title' => __('GreenShift Extra Blocks', 'greenshift-animation-and-page-builder-blocks'),
						),
					),
					$categories
				);
			}else{
				return array_merge(
					array(
						array(
							'slug'  => 'GreenShiftLayout',
							'title' => __('GreenShift Layout Blocks', 'greenshift-animation-and-page-builder-blocks'),
						),
						array(
							'slug'  => 'GreenShiftContent',
							'title' => __('GreenShift Content Blocks', 'greenshift-animation-and-page-builder-blocks'),
						),
						array(
							'slug'  => 'GreenShiftExtra',
							'title' => __('GreenShift Extra Blocks', 'greenshift-animation-and-page-builder-blocks'),
						),
						array(
							'slug'  => 'GreenLightLayout',
							'title' => __('GreenLight Layout Elements', 'greenshift-animation-and-page-builder-blocks'),
						),
						array(
							'slug'  => 'GreenLightContent',
							'title' => __('GreenLight Content Elements', 'greenshift-animation-and-page-builder-blocks'),
						),
						array(
							'slug'  => 'GreenLightExtra',
							'title' => __('GreenLight Extra Elements', 'greenshift-animation-and-page-builder-blocks'),
						),
						array(
							'slug'  => 'GreenLightTags',
							'title' => __('GreenLight Tags Elements', 'greenshift-animation-and-page-builder-blocks'),
						),
					),
					$categories
				);
			}
		}

		public function greenshift_admin_enqueue_scripts()
		{
			$current_page = isset($_GET['page']) ? $_GET['page'] : '';

			// Check if the current admin page URL starts with 'greenshift'
			if (strpos($current_page, 'greenshift') === 0) {
				wp_enqueue_style( 'greenShift-admin-css' );
			}
		}

		public function greenshift_admin_page()
		{

			$parent_slug = 'greenshift_dashboard';

			if (!defined('REHUB_ADMIN_DIR')) {
				add_menu_page(
					esc_html__('Reusable Templates', 'greenshift-animation-and-page-builder-blocks'),
					esc_html__('Reusable Templates', 'greenshift-animation-and-page-builder-blocks'),
					'manage_options',  // Capability required to access the menu item
					'edit.php?post_type=wp_block',  // URL of the custom link
					'',
					'dashicons-screenoptions',  // Icon URL (optional)
					71  // Position of the menu item (use a number to set the position; 6 will place the item below "Settings")
				);
			}


			add_menu_page(
				'GreenShift',
				'GreenShift',
				'manage_options',
				$parent_slug,
				array($this, 'welcome_page'),
				plugin_dir_url(__FILE__) . 'libs/gspbLogo.svg',
				70
			);

			add_submenu_page(
				$parent_slug,
				esc_html__('Settings', 'greenshift-animation-and-page-builder-blocks'),
				esc_html__('Settings', 'greenshift-animation-and-page-builder-blocks'),
				'manage_options',
				'greenshift',
				array($this, 'settings_page')
			);

			add_submenu_page(
				$parent_slug,
				esc_html__('Addons', 'greenshift-animation-and-page-builder-blocks'),
				esc_html__('Addons', 'greenshift-animation-and-page-builder-blocks'),
				'manage_options',
				'greenshift_dashboard-addons',
				array($this, 'addons_page')
			);

			add_submenu_page(
				$parent_slug,
				esc_html__('Upgrade', 'greenshift-animation-and-page-builder-blocks'),
				esc_html__('Upgrade', 'greenshift-animation-and-page-builder-blocks'),
				'manage_options',
				'greenshift_upgrade',
				array($this, 'upgrade_page')
			);

			add_submenu_page(
				$parent_slug,
				esc_html__('Contact Us', 'greenshift-animation-and-page-builder-blocks'),
				esc_html__('Contact Us', 'greenshift-animation-and-page-builder-blocks'),
				'manage_options',
				'greenshift_contact',
				array($this, 'contact_page')
			);
			add_submenu_page(
				$parent_slug,
				esc_html__('Import/Export', 'greenshift-animation-and-page-builder-blocks'),
				esc_html__('Import/Export', 'greenshift-animation-and-page-builder-blocks'),
				'manage_options',
				'greenshift_import',
				array($this, 'import_page')
			);
			add_submenu_page(
				$parent_slug,
				esc_html__('Demo Import', 'greenshift-animation-and-page-builder-blocks'),
				esc_html__('Demo Import', 'greenshift-animation-and-page-builder-blocks'),
				'manage_options',
				'greenshift_demo',
				array($this, 'import_demo')
			);

			$stylebook_post_id = get_option('gspb_stylebook_id');

			if ($stylebook_post_id) {

				$editposturl = admin_url('post.php?post=' . $stylebook_post_id . '&action=edit');

				add_submenu_page(
					$parent_slug,
					esc_html__('Stylebook', 'greenshift-animation-and-page-builder-blocks'),
					esc_html__('Stylebook', 'greenshift-animation-and-page-builder-blocks'),
					'manage_options',
					$editposturl
				);
			} else {

				add_submenu_page(
					$parent_slug,
					esc_html__('Stylebook', 'greenshift-animation-and-page-builder-blocks'),
					esc_html__('Stylebook', 'greenshift-animation-and-page-builder-blocks'),
					'manage_options',
					'greenshift_stylebook',
					array($this, 'stylebook_page_callback')
				);
			}
		}

		public function welcome_page()
		{
			require_once GREENSHIFT_DIR_PATH . 'templates/admin/welcome-page.php';
		}

		public function contact_page()
		{
			require_once GREENSHIFT_DIR_PATH . 'templates/admin/contact-page.php';
		}

		public function import_page()
		{
			require_once GREENSHIFT_DIR_PATH . 'templates/admin/import-page.php';
		}

		public function import_demo()
		{
			require_once GREENSHIFT_DIR_PATH . 'templates/admin/import-demo.php';
		}

		public function addons_page()
		{
			require_once GREENSHIFT_DIR_PATH . 'templates/admin/addon-page.php';
		}

		public function upgrade_page()
		{
			require_once GREENSHIFT_DIR_PATH . 'templates/admin/upgrade-page.php';
		}

		public function stylebook_page_callback()
		{
?>
			<style>
				#greenshift_stylebook_btn {
					margin-top: 30px;
					width: 220px;
					height: 40px;
					font-size: 1rem;
					line-height: 1rem;
				}

				.stylbook_btn_wrapper {
					position: relative;
					display: flex;
					align-items: center;
				}
			</style>
			<script>
				jQuery(document).ready(function($) {
					// Stylebook ajax request
					$("#stylebook_generation").submit(function(e) {
						e.preventDefault();

						$('#ajax-response').html('');

						const targetForm = e.target;
						const payload = new FormData(targetForm);
						payload.append("action", "gspb_generate_stylebook")
						$.ajax({
								method: "POST",
								url: ajaxurl,
								processData: false,
								contentType: false,
								data: payload,
								beforeSend: function(response) {
									$(".spinner").addClass("is-active");
								}
							})
							.success(function(response) {
								$(".spinner").removeClass("is-active");
								if (response.data.status == "success") {
									const post_link = response?.data?.post_link;
									if (post_link) {
										const postEditLink = post_link.replace(/&amp;/g, '&');
										window.location.href = postEditLink;
									}
								}
								if (response.data.status == "error") {
									$('#ajax-response').append('<div class="notice notice-error"><p>' + response.data.msg + '</p></div>');
								}
							})
							.error(function(response) {
								$(".spinner").removeClass("is-active");
								$('#ajax-response').append('<div class="notice notice-error"><p>Something went wrong.</p></div>');
							});

					});
				});
			</script>
			<div class="stylebook_form_wrap" style="padding:25px">
				<h1><?php _e('GreenShift Stylebook', 'greenshift-animation-and-page-builder-blocks'); ?></h1>
				<div id="ajax-response"> </div>
				<form id="stylebook_generation" method="post" class="stylbook_btn_wrapper">
					<?php wp_nonce_field('gspb_generate_stylebook', 'gspb_stylebook'); ?>
					<div class="stylbook_btn_wrapper">
						<input type="submit" id="greenshift_stylebook_btn" name="greenshift_stylebook_btn" value=<?php _e('Create Stylebook', 'greenshift-animation-and-page-builder-blocks'); ?> class="button button-primary button-large">
						<span class="spinner"></span>
					</div>
				</form>
			</div>
		<?php
		}

		public function gspb_stylebook_redirect()
		{
			if (isset($_GET['post_type']) && $_GET['post_type'] === 'gspbstylebook') {
				wp_safe_redirect(admin_url('?page=greenshift_dashboard'));
				exit;
			}
		}

		public function gspb_generate_stylebook()
		{

			$response = array();

			if (!isset($_POST['gspb_stylebook'])  || !wp_verify_nonce(sanitize_text_field( wp_unslash($_POST['gspb_stylebook'])), 'gspb_generate_stylebook')) {

				$response =  array(
					'status' => 'error',
					'msg' => 'User Security not varified.'
				);
			} else {
				$stylebook_post_id = get_option('gspb_stylebook_id');

				if (!$stylebook_post_id || !get_edit_post_link($stylebook_post_id)) {

					// Create post object
					$stylebook_post = array(
						'post_title'    => 'Greenshift Stylebook',
						'post_type'	   	=> 'gspbstylebook',
						'post_name'		=>	'greenshift-stylebook',
						'post_content'	=>	'<!-- wp:greenshift-blocks/stylebook /-->',
						'post_status'   => 'publish',
					);

					// Insert the post into the database
					$stylebook_post_id = wp_insert_post($stylebook_post);

					if (!is_wp_error($stylebook_post_id)) {

						$response =  array(
							'status' => 'success',
							'post_link' => get_edit_post_link($stylebook_post_id)
						);

						update_option('gspb_stylebook_id', $stylebook_post_id);

						// we need to flush this because post is created programatically.
						flush_rewrite_rules();
					} else {

						$response =  array(
							'status' => 'error',
							'msg' => $stylebook_post_id->get_error_message()
						);

						return $response;
					}
				} else {

					$response =  array(
						'status' => 'success',
						'post_link' => get_edit_post_link($stylebook_post_id)
					);
				}
			}

			wp_send_json_success($response);
		}

		public function settings_page()
		{

			if (!current_user_can('manage_options')) {
				wp_die('Unauthorized user');
			}

			// Get the active tab from the $_GET param
			$default_tab = null;
			$tab  = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : $default_tab;

		?>

			<div class="wp-block-greenshift-blocks-container alignfull gspb_container gspb_container-gsbp-ead11204-4841" id="gspb_container-id-gsbp-ead11204-4841">
				<div class="wp-block-greenshift-blocks-container gspb_container gspb_container-gsbp-cbc3fa8c-bb26" id="gspb_container-id-gsbp-cbc3fa8c-bb26">

					<?php $activetab = 'settings'; ?>
					<?php include(GREENSHIFT_DIR_PATH . 'templates/admin/navleft.php'); ?>

					<div class="wp-block-greenshift-blocks-container gspb_container gspb_container-gsbp-89d45563-1559" id="gspb_container-id-gsbp-89d45563-1559">

						<div class="wp-block-greenshift-blocks-container gspb_container gspb_container-gsbp-efb64efe-d083" id="gspb_container-id-gsbp-efb64efe-d083">
							<h2 id="gspb_heading-id-gsbp-ca0b0ada-6561" class="gspb_heading gspb_heading-id-gsbp-ca0b0ada-6561 "><?php esc_html_e("Settings", 'greenshift-animation-and-page-builder-blocks'); ?></h2>
						</div>

						<div class="class-tabs-gs wp-block-greenshift-blocks-container gspb_container gspb_container-gsbp-01099b45-f36b" id="gspb_container-id-gsbp-01099b45-f36b">
							<a href="?page=greenshift" id="gspb_text-id-gsbp-2c96ad79-8324" class="gspb_text gspb_text-id-gsbp-2c96ad79-8324 <?php if ($tab === null) : ?>gs-tab-active<?php endif; ?>"><?php esc_html_e("Font Options", 'greenshift-animation-and-page-builder-blocks'); ?></a>
							<a href="?page=greenshift&tab=breakpoints" id="gspb_text-id-gsbp-557ed921-38fe" class="gspb_text gspb_text-id-gsbp-557ed921-38fe <?php if ($tab === 'breakpoints') : ?>gs-tab-active<?php endif; ?>"><?php esc_html_e("Breakpoints", 'greenshift-animation-and-page-builder-blocks'); ?></a>
							<a href="?page=greenshift&tab=save_css" id="gspb_text-id-gsbp-94bd1cf0-c77b" class="gspb_text gspb_text-id-gsbp-94bd1cf0-c77b <?php if ($tab === 'save_css') : ?>gs-tab-active<?php endif; ?> "><?php esc_html_e("CSS Options", 'greenshift-animation-and-page-builder-blocks'); ?></a>
							<a href="?page=greenshift&tab=scripts" id="gspb_text-id-gsbp-f27becf0-4d87" class="gspb_text gspb_text-id-gsbp-f27becf0-4d87   <?php if ($tab === 'scripts') : ?>gs-tab-active<?php endif; ?>"><?php esc_html_e("Script Options", 'greenshift-animation-and-page-builder-blocks'); ?></a>
							<a href="?page=greenshift&tab=header" id="gspb_text-id-gsbp-f27becf0-4d87" class="gspb_text gspb_text-id-gsbp-f27becf0-4d87   <?php if ($tab === 'header') : ?>gs-tab-active<?php endif; ?>"><?php esc_html_e("Header/Footer code", 'greenshift-animation-and-page-builder-blocks'); ?></a>
							<a href="?page=greenshift&tab=interface" id="gspb_text-id-gsbp-f27becf0-4d87" class="gspb_text gspb_text-id-gsbp-f27becf0-4d87   <?php if ($tab === 'interface') : ?>gs-tab-active<?php endif; ?>"><?php esc_html_e("Interface", 'greenshift-animation-and-page-builder-blocks'); ?></a>
							<a href="?page=greenshift&tab=keys" id="gspb_text-id-gsbp-f27becf0-4d87" class="gspb_text gspb_text-id-gsbp-f27becf0-4d87   <?php if ($tab === 'keys') : ?>gs-tab-active<?php endif; ?>"><?php esc_html_e("API Keys", 'greenshift-animation-and-page-builder-blocks'); ?></a>
						</div>


						<div class="wp-block-greenshift-blocks-container gspb_container gspb_container-gsbp-7b4f8e8f-1a69" id="gspb_container-id-gsbp-7b4f8e8f-1a69">
							<div class="greenshift_form">
								<?php
								switch ($tab):
									case 'save_css':

										if (isset($_POST['gspb_save_settings'])) {
											if (!wp_verify_nonce(sanitize_text_field( wp_unslash($_POST['gspb_settings_field'])), 'gspb_settings_page_action')) {
												esc_html_e("Sorry, your nonce did not verify.", 'greenshift-animation-and-page-builder-blocks');
												return;
											}
											update_option('gspb_css_save', sanitize_text_field($_POST['gspb_settings_option']));

											$default_settings = get_option('gspb_global_settings');

											$sanitised = array();
											if (!empty($_POST['reusablestyles'])) {
												foreach ($_POST['reusablestyles'] as $key => $value) {
													$sanitised['reusablestyles'][$key] = array(
														"style" => sanitize_textarea_field($value['style']),
														"blockname" =>  sanitize_text_field($value['blockname']),
													);
												}
												$newargs = wp_parse_args($sanitised, $default_settings);
												update_option('gspb_global_settings', $newargs);
											}
											if (isset($_POST['dark_mode_on'])) {
												$newargs = wp_parse_args(array('dark_mode_on' => true), $default_settings);
												update_option('gspb_global_settings', $newargs);
											} else {
												$newargs = wp_parse_args(array('dark_mode_on' => false), $default_settings);
												update_option('gspb_global_settings', $newargs);
											}
											if (isset($_POST['enable_head_inline'])) {
												$newargs = wp_parse_args(array('enable_head_inline' => true), $default_settings);
												update_option('gspb_global_settings', $newargs);
											} else {
												$newargs = wp_parse_args(array('enable_head_inline' => false), $default_settings);
												update_option('gspb_global_settings', $newargs);
											}
										}

										$global_settings = get_option('gspb_global_settings');
										$css_tsyle_option = get_option('gspb_css_save');
										$dark_mode_on = !empty($global_settings['dark_mode_on']) ? $global_settings['dark_mode_on'] : '';
										$enable_head_inline = !empty($global_settings['enable_head_inline']) ? $global_settings['enable_head_inline'] : '';
										?>
										<div class="gspb_settings_form">
											<form method="POST">
												<div class="greenshift_form">
													<?php wp_nonce_field('gspb_settings_page_action', 'gspb_settings_field'); ?>
													<div class="wp-block-greenshift-blocks-infobox gspb_infoBox gspb_infoBox-id-gsbp-158b5f3e-b35c" id="gspb_infoBox-id-gsbp-158b5f3e-b35c">
														<div class="gs-box notice_type icon_type">
															<div class="gs-box-icon"><svg class="" style="display:inline-block;vertical-align:middle" width="32" height="32" viewBox="0 0 704 1024" xmlns="http://www.w3.org/2000/svg">
																	<path style="fill:#565D66" d="M352 160c-105.88 0-192 86.12-192 192 0 17.68 14.32 32 32 32s32-14.32 32-32c0-70.6 57.44-128 128-128 17.68 0 32-14.32 32-32s-14.32-32-32-32zM192.12 918.34c0 6.3 1.86 12.44 5.36 17.68l49.020 73.68c5.94 8.92 15.94 14.28 26.64 14.28h157.7c10.72 0 20.72-5.36 26.64-14.28l49.020-73.68c3.48-5.24 5.34-11.4 5.36-17.68l0.1-86.36h-319.92l0.080 86.36zM352 0c-204.56 0-352 165.94-352 352 0 88.74 32.9 169.7 87.12 231.56 33.28 37.98 85.48 117.6 104.84 184.32v0.12h96v-0.24c-0.020-9.54-1.44-19.020-4.3-28.14-11.18-35.62-45.64-129.54-124.34-219.34-41.080-46.86-63.040-106.3-63.22-168.28-0.4-147.28 119.34-256 255.9-256 141.16 0 256 114.84 256 256 0 61.94-22.48 121.7-63.3 168.28-78.22 89.22-112.84 182.94-124.2 218.92-2.805 8.545-4.428 18.381-4.44 28.594l-0 0.006v0.2h96v-0.1c19.36-66.74 71.56-146.36 104.84-184.32 54.2-61.88 87.1-142.84 87.1-231.58 0-194.4-157.6-352-352-352z"></path>
																</svg></div>
															<div class="gs-box-text">
																<?php esc_html_e("Use Inline in block only if you have some issues with not updating styles of blocks or cache. Once saved as inline in block, styles can be overwritten only when you update post with blocks", 'greenshift-animation-and-page-builder-blocks'); ?>
															</div>
														</div>
													</div>
													<table class="form-table">
														<tr>
															<td> <label for="css_system"><?php esc_html_e("Css location", 'greenshift-animation-and-page-builder-blocks'); ?></label> </td>
															<td>
																<select name="gspb_settings_option">
																	<option value="inline" <?php selected($css_tsyle_option, 'inline'); ?>><?php esc_html_e("Inline in Head", 'greenshift-animation-and-page-builder-blocks'); ?> </option>
																	<option value="inlineblock" <?php selected($css_tsyle_option, 'inlineblock'); ?>> <?php esc_html_e("Inline in block", 'greenshift-animation-and-page-builder-blocks'); ?> </option>
																</select>
															</td>
														</tr>
														<tr>
															<td> <label for="dark_mode_on"><?php esc_html_e("Enable detection of dark mode before site loading", 'greenshift-animation-and-page-builder-blocks'); ?></label> </td>
															<td>
																<input type="checkbox" name="dark_mode_on" id="dark_mode_on" <?php echo $dark_mode_on == true ? 'checked' : ''; ?> />
															</td>
														</tr>
														<tr>
															<td> <label for="enable_head_inline"><?php esc_html_e("On-Fly Inline Merged CSS (Beta, works only in block themes)", 'greenshift-animation-and-page-builder-blocks'); ?></label> </td>
															<td>
																<input type="checkbox" name="enable_head_inline" id="enable_head_inline" <?php echo $enable_head_inline == true ? 'checked' : ''; ?> />
															</td>
														</tr>
													</table>

													<input type="submit" name="gspb_save_settings" value="<?php esc_html_e("Save settings"); ?>" class="button button-primary button-large">
												</div>

											</form>
										</div>
										<?php
									break;
									case 'interface':

										if (isset($_POST['gspb_save_settings'])) {
											if (!wp_verify_nonce(sanitize_text_field( wp_unslash($_POST['gspb_settings_field'])), 'gspb_settings_page_action')) {
												esc_html_e("Sorry, your nonce did not verify.", 'greenshift-animation-and-page-builder-blocks');
												return;
											}
											$default_settings = get_option('gspb_global_settings');
											if(empty($default_settings)){
												$default_settings = array();
											}

											if (isset($_POST['cf_utility_on'])) {
												$default_settings['cf_utility_on'] = true;
											} else {
												$default_settings['cf_utility_on'] = false;
											}

											if (isset($_POST['anchors_disable'])) {
												$default_settings['anchors_disable'] = true;
											} else {
												$default_settings['anchors_disable'] = false;
											}

											if (isset($_POST['row_padding_disable'])) {
												$default_settings['row_padding_disable'] = true;
											} else {
												$default_settings['row_padding_disable'] = false;
											}

											if (isset($_POST['dark_accent_scheme'])) {
												$default_settings['dark_accent_scheme'] = true;
											} else {
												$default_settings['dark_accent_scheme'] = false;
											}
											if (isset($_POST['hide_local_styles'])) {
												$default_settings['hide_local_styles'] = true;
											} else {
												$default_settings['hide_local_styles'] = false;
											}
											if (isset($_POST['simplified_panels'])) {
												$default_settings['simplified_panels'] = true;
											} else {
												$default_settings['simplified_panels'] = false;
											}
											if (isset($_POST['show_element_block'])) {
												$default_settings['show_element_block'] = sanitize_text_field($_POST['show_element_block']);
											}
											if (isset($_POST['default_unit'])) {
												$default_settings['default_unit'] = sanitize_text_field($_POST['default_unit']);
											}
											update_option('gspb_global_settings', $default_settings);
										}

										$global_settings = get_option('gspb_global_settings');
										$cf_utility_on = !empty($global_settings['cf_utility_on']) ? $global_settings['cf_utility_on'] : '';
										$anchors_disable = !empty($global_settings['anchors_disable']) ? $global_settings['anchors_disable'] : '';
										$dark_accent_scheme = !empty($global_settings['dark_accent_scheme']) ? $global_settings['dark_accent_scheme'] : '';
										$hide_local_styles = !empty($global_settings['hide_local_styles']) ? $global_settings['hide_local_styles'] : '';
										$simplified_panels = !empty($global_settings['simplified_panels']) ? $global_settings['simplified_panels'] : '';
										$show_element_block = !empty($global_settings['show_element_block']) ? $global_settings['show_element_block'] : '';
										$default_unit = !empty($global_settings['default_unit']) ? $global_settings['default_unit'] : '';
										$row_padding_disable = !empty($global_settings['row_padding_disable']) ? $global_settings['row_padding_disable'] : '';
										?>
										<div class="gspb_settings_form">
											<form method="POST">
												<div class="greenshift_form">
													<?php wp_nonce_field('gspb_settings_page_action', 'gspb_settings_field'); ?>
													<div class="wp-block-greenshift-blocks-infobox gspb_infoBox gspb_infoBox-id-gsbp-158b5f3e-b35c" id="gspb_infoBox-id-gsbp-158b5f3e-b35c">
														<div class="gs-box notice_type icon_type">
															<div class="gs-box-icon"><svg class="" style="display:inline-block;vertical-align:middle" width="32" height="32" viewBox="0 0 704 1024" xmlns="http://www.w3.org/2000/svg">
																	<path style="fill:#565D66" d="M352 160c-105.88 0-192 86.12-192 192 0 17.68 14.32 32 32 32s32-14.32 32-32c0-70.6 57.44-128 128-128 17.68 0 32-14.32 32-32s-14.32-32-32-32zM192.12 918.34c0 6.3 1.86 12.44 5.36 17.68l49.020 73.68c5.94 8.92 15.94 14.28 26.64 14.28h157.7c10.72 0 20.72-5.36 26.64-14.28l49.020-73.68c3.48-5.24 5.34-11.4 5.36-17.68l0.1-86.36h-319.92l0.080 86.36zM352 0c-204.56 0-352 165.94-352 352 0 88.74 32.9 169.7 87.12 231.56 33.28 37.98 85.48 117.6 104.84 184.32v0.12h96v-0.24c-0.020-9.54-1.44-19.020-4.3-28.14-11.18-35.62-45.64-129.54-124.34-219.34-41.080-46.86-63.040-106.3-63.22-168.28-0.4-147.28 119.34-256 255.9-256 141.16 0 256 114.84 256 256 0 61.94-22.48 121.7-63.3 168.28-78.22 89.22-112.84 182.94-124.2 218.92-2.805 8.545-4.428 18.381-4.44 28.594l-0 0.006v0.2h96v-0.1c19.36-66.74 71.56-146.36 104.84-184.32 54.2-61.88 87.1-142.84 87.1-231.58 0-194.4-157.6-352-352-352z"></path>
																</svg></div>
															<div class="gs-box-text">
																<?php esc_html_e("Install Smart Code AI free plugin to enable code editor in block HTML/CSS panels", 'greenshift-animation-and-page-builder-blocks'); ?>
																<a target="_blank" href="<?php echo admin_url('plugin-install.php?s=Greenshift%2520Smart%2520Code%2520AI&tab=search&type=term');?>" target="_blank"><?php esc_html_e("Download", 'greenshift-animation-and-page-builder-blocks'); ?></a>
															</div>
														</div>
													</div>
													<table class="form-table">
														<tr>
															<td> <label for="cf_utility_on"><?php esc_html_e("Support for Core Framework Utility classes", 'greenshift-animation-and-page-builder-blocks'); ?></label> </td>
															<td>
																<input type="checkbox" name="cf_utility_on" id="cf_utility_on" <?php echo $cf_utility_on == true ? 'checked' : ''; ?> />
															</td>
														</tr>
														<tr>
															<td> <label for="anchors_disable"><?php esc_html_e("Disable core Headings anchor generation", 'greenshift-animation-and-page-builder-blocks'); ?></label> </td>
															<td>
																<input type="checkbox" name="anchors_disable" id="anchors_disable" <?php echo $anchors_disable == true ? 'checked' : ''; ?> />
															</td>
														</tr>
														<tr>
															<td> <label for="row_padding_disable"><?php esc_html_e("Disable default Column padding in Row block", 'greenshift-animation-and-page-builder-blocks'); ?></label> </td>
															<td>
																<input type="checkbox" name="row_padding_disable" id="row_padding_disable" <?php echo $row_padding_disable == true ? 'checked' : ''; ?> />
															</td>
														</tr>
														<tr>
															<td> <label for="dark_accent_scheme"><?php esc_html_e("Dark Accent UI for block panels", 'greenshift-animation-and-page-builder-blocks'); ?></label> </td>
															<td>
																<input type="checkbox" name="dark_accent_scheme" id="dark_accent_scheme" <?php echo $dark_accent_scheme == true ? 'checked' : ''; ?> />
															</td>
														</tr>
														<tr>
															<td> <label for="show_element_block"><?php esc_html_e("Priority for GreenLight Element Blocks in Inserter", 'greenshift-animation-and-page-builder-blocks'); ?></label> </td>
															<td>
																<select name="show_element_block">
																	<option value="both" <?php selected($show_element_block, 'both'); ?>><?php esc_html_e("Show both, priority on regular Greenshift blocks", 'greenshift-animation-and-page-builder-blocks'); ?> </option>
																	<option value="bothelement" <?php selected($show_element_block, 'bothelement'); ?>><?php esc_html_e("Show both, priority on GreenLight Element blocks", 'greenshift-animation-and-page-builder-blocks'); ?> </option>
																	<option value="element" <?php selected($show_element_block, 'element'); ?>> <?php esc_html_e("Show only GreenLight Element blocks", 'greenshift-animation-and-page-builder-blocks'); ?> </option>
																	<option value="regular" <?php selected($show_element_block, 'regular'); ?>> <?php esc_html_e("Show only Greenshift blocks", 'greenshift-animation-and-page-builder-blocks'); ?> </option>
																</select>
															</td>
														</tr>
														<tr>
															<td> <label for="default_unit"><?php esc_html_e("Default unit for values", 'greenshift-animation-and-page-builder-blocks'); ?></label> </td>
															<td>
																<select name="default_unit">
																	<option value="px" <?php selected($default_unit, 'px'); ?>>px</option>
																	<option value="em" <?php selected($default_unit, 'em'); ?>>em</option>
																	<option value="rem" <?php selected($default_unit, 'rem'); ?>>rem</option>
																</select>
															</td>
														</tr>
														<tr>
															<td> <label for="hide_local_styles"><?php esc_html_e("Close Local style option in Element block by default", 'greenshift-animation-and-page-builder-blocks'); ?></label> </td>
															<td>
																<input type="checkbox" name="hide_local_styles" id="hide_local_styles" <?php echo $hide_local_styles == true ? 'checked' : ''; ?> />
															</td>
														</tr>
														<tr>
															<td> <label for="simplified_panels"><?php esc_html_e("Simplified panels for non admin user roles", 'greenshift-animation-and-page-builder-blocks'); ?></label> </td>
															<td>
																<input type="checkbox" name="simplified_panels" id="simplified_panels" <?php echo $simplified_panels == true ? 'checked' : ''; ?> />
															</td>
														</tr>
													</table>

													<input type="submit" name="gspb_save_settings" value="<?php esc_html_e("Save settings"); ?>" class="button button-primary button-large">
												</div>

											</form>
										</div>
										<?php
									break;
									case 'breakpoints':
										$global_settings = get_option('gspb_global_settings');
										$gsbp_breakpoints = apply_filters('greenshift_responsive_breakpoints', array(
											'mobile' 	=> 576,
											'tablet' 	=> 768,
											'desktop' =>  992
										));

										if (isset($_POST['gspb_save_settings']) && isset($_POST['gspb_settings_field']) && wp_verify_nonce(sanitize_text_field( wp_unslash($_POST['gspb_settings_field'])), 'gspb_settings_page_action')) {
											$breakpoints = array(
												"mobile" =>  sanitize_text_field($_POST['mobile']),
												"tablet" =>  sanitize_text_field($_POST['tablet']),
												"desktop" =>  sanitize_text_field($_POST['desktop']),
												"row" =>  sanitize_text_field($_POST['row']),
											);
											$global_settings['breakpoints'] = $breakpoints;

											if (!empty($_POST['enable_landscape'])) {
												$global_settings['enable_landscape'] = true;
											} else {
												if(isset($global_settings['enable_landscape'])){
													unset($global_settings['enable_landscape']);
												}
											}
											update_option('gspb_global_settings', $global_settings);
										}
										$enable_landscape = !empty($global_settings['enable_landscape']) ? $global_settings['enable_landscape'] : '';
									?>
										<form method="POST" class="greenshift_form">
											<?php wp_nonce_field('gspb_settings_page_action', 'gspb_settings_field'); ?>
											<table class="form-table">

												<tr>
													<td> <?php esc_html_e("Mobile", 'greenshift-animation-and-page-builder-blocks'); ?> </td>
													<td>
														<input name="mobile" type="text" value="<?php if (isset($global_settings['breakpoints']['mobile'])) {
															echo esc_attr($global_settings['breakpoints']['mobile']);
															}  ?>" placeholder="<?php echo (int)$gsbp_breakpoints['mobile']; ?>" />
													</td>
												</tr>
												<tr>
													<td> <?php esc_html_e("Tablet", 'greenshift-animation-and-page-builder-blocks'); ?> </td>
													<td>
														<input name="tablet" type="text" value="<?php if (isset($global_settings['breakpoints']['tablet'])) {
															echo esc_attr($global_settings['breakpoints']['tablet']);
															} ?>" placeholder="<?php echo (int)$gsbp_breakpoints['tablet']; ?>" />
													</td>
												</tr>
												<tr>
													<td> <?php esc_html_e("Desktop", 'greenshift-animation-and-page-builder-blocks'); ?> </td>
													<td>
														<input name="desktop" type="text" value="<?php if (isset($global_settings['breakpoints']['desktop'])) {
															echo esc_attr($global_settings['breakpoints']['desktop']);
														} ?>" placeholder="<?php echo (int)$gsbp_breakpoints['desktop']; ?>" />
													</td>
												</tr>
												<tr>
													<td> <?php esc_html_e("Default Row Content Width", 'greenshift-animation-and-page-builder-blocks'); ?> </td>
													<td>
														<input name="row" type="text" value="<?php if (isset($global_settings['breakpoints']['row'])) {
															echo esc_attr($global_settings['breakpoints']['row']);
														} ?>" placeholder="<?php echo apply_filters('gspb_default_row_width_px', 1200); ?>" />
													</td>
												</tr>
												<tr>
													<td> <label for="enable_landscape"><?php esc_html_e("Enable Landscape point", 'greenshift-animation-and-page-builder-blocks'); ?></label> </td>
													<td>
														<input type="checkbox" name="enable_landscape" id="enable_landscape" <?php echo $enable_landscape == true ? 'checked' : ''; ?> />
													</td>
												</tr>
											</table>
											<input type="submit" name="gspb_save_settings" value="Save" class="button button-primary button-large">
										</form>
									<?php
										break;
									case 'scripts':
										wp_enqueue_style('gsadminsettings');
										wp_enqueue_script('gsadminsettings');
										$global_settings = get_option('gspb_global_settings');
										if (isset($_POST['gspb_save_settings'])) { // Delay script saving
											if (!wp_verify_nonce(sanitize_text_field( wp_unslash($_POST['gspb_settings_field'])), 'gspb_settings_page_action')) {
												esc_html_e("Sorry, your nonce did not verify.", 'greenshift-animation-and-page-builder-blocks');
												return;
											}

											$is_dealyjson = isset($_POST['delay_js_on']) && $_POST['delay_js_on'] == "on" ? 1 : 0;
											$jsdelay = array(
												"delay_js_on" => $is_dealyjson,
												"delay_js_page_on" =>  sanitize_text_field($_POST['delay_js_page_on']),
												"delay_js_page_list" =>  sanitize_text_field($_POST['delay_js_page_list']),
											);
											$global_settings['jsdelay'] = $jsdelay;

											update_option('gspb_global_settings', $global_settings);
										}
										//Form for delay script saving
										$delay_js_on = !empty($global_settings['jsdelay']['delay_js_on']) ? $global_settings['jsdelay']['delay_js_on'] : '';
										$delay_js_page_on = !empty($global_settings['jsdelay']['delay_js_page_on']) ? $global_settings['jsdelay']['delay_js_page_on'] : '';
										$delay_js_page_list = !empty($global_settings['jsdelay']['delay_js_page_list']) ? $global_settings['jsdelay']['delay_js_page_list'] : '';

										$show_page_option = $delay_js_on && ($delay_js_page_on == "includefor" || $delay_js_page_on  == "excludefor") ? true : false;

									?>
										<div class="gspb_settings_form">
											<form method="POST">
												<h2><?php esc_html_e("Javascript Files Delay", 'greenshift-animation-and-page-builder-blocks'); ?></h2>
												<div class="greenshift_form">
													<div class="wp-block-greenshift-blocks-infobox gspb_infoBox gspb_infoBox-id-gsbp-158b5f3e-b35c" id="gspb_infoBox-id-gsbp-158b5f3e-b35c">
														<div class="gs-box notice_type icon_type">
															<div class="gs-box-icon"><svg class="" style="display:inline-block;vertical-align:middle" width="32" height="32" viewBox="0 0 704 1024" xmlns="http://www.w3.org/2000/svg">
																	<path style="fill:#565D66" d="M352 160c-105.88 0-192 86.12-192 192 0 17.68 14.32 32 32 32s32-14.32 32-32c0-70.6 57.44-128 128-128 17.68 0 32-14.32 32-32s-14.32-32-32-32zM192.12 918.34c0 6.3 1.86 12.44 5.36 17.68l49.020 73.68c5.94 8.92 15.94 14.28 26.64 14.28h157.7c10.72 0 20.72-5.36 26.64-14.28l49.020-73.68c3.48-5.24 5.34-11.4 5.36-17.68l0.1-86.36h-319.92l0.080 86.36zM352 0c-204.56 0-352 165.94-352 352 0 88.74 32.9 169.7 87.12 231.56 33.28 37.98 85.48 117.6 104.84 184.32v0.12h96v-0.24c-0.020-9.54-1.44-19.020-4.3-28.14-11.18-35.62-45.64-129.54-124.34-219.34-41.080-46.86-63.040-106.3-63.22-168.28-0.4-147.28 119.34-256 255.9-256 141.16 0 256 114.84 256 256 0 61.94-22.48 121.7-63.3 168.28-78.22 89.22-112.84 182.94-124.2 218.92-2.805 8.545-4.428 18.381-4.44 28.594l-0 0.006v0.2h96v-0.1c19.36-66.74 71.56-146.36 104.84-184.32 54.2-61.88 87.1-142.84 87.1-231.58 0-194.4-157.6-352-352-352z"></path>
																</svg></div>
															<div class="gs-box-text">
																<div><?php esc_html_e("Attention! This is experimental feature", "greenshift-animation-and-page-builder-blocks"); ?></div>
															</div>
														</div>
													</div>

													<?php wp_nonce_field('gspb_settings_page_action', 'gspb_settings_field'); ?>
													<table class="form-table">
														<tr>
															<td colspan="2">
																<input type="checkbox" name="delay_js_on" id="delay_js_on" <?php echo $delay_js_on == true ? 'checked' : ''; ?> />
																<label for="delay_js_on"><?php esc_html_e("Enable script delay for Greenshift's scripts", 'greenshift-animation-and-page-builder-blocks'); ?></label>
															</td>
														</tr>
														<tr class="delay_js_optionsrow" <?php echo $delay_js_on == true ? 'style="display: table-row;"' : ''; ?>>
															<td> <label for="css_system"><?php esc_html_e("Javascript delay options", 'greenshift-animation-and-page-builder-blocks'); ?></label> </td>
															<td>
																<select id="delay_js_page_on" name="delay_js_page_on">
																	<option value="all" <?php selected($delay_js_page_on, 'all'); ?>><?php esc_html_e("Enable on whole site", 'greenshift-animation-and-page-builder-blocks'); ?> </option>
																	<option value="includefor" <?php selected($delay_js_page_on, 'includefor'); ?>> <?php esc_html_e("Enable only on selected pages", 'greenshift-animation-and-page-builder-blocks'); ?> </option>
																	<option value="excludefor" <?php selected($delay_js_page_on, 'excludefor'); ?>> <?php esc_html_e("Enable on whole site except selected pages", 'greenshift-animation-and-page-builder-blocks'); ?> </option>
																</select>
															</td>
														</tr>
														<tr class="delay_js_pagerow" <?php echo $show_page_option == true ? 'style="display: table-row;"' : ''; ?>>
															<td>
																<label for="delay_js_page_list"><?php esc_html_e("Page Urls (one per line).", 'greenshift-animation-and-page-builder-blocks'); ?></label>
															</td>
															<td>
																<textarea style="width:100%; min-height:100px;" id="delay_js_page_list" name="delay_js_page_list"><?php echo esc_html($delay_js_page_list); ?></textarea>
																<div style="margin-bottom:15px"><?php esc_html_e("Specify URLs of pages (one per line).", 'greenshift-animation-and-page-builder-blocks'); ?></div>
															</td>
														</tr>
													</table>


													<input type="submit" name="gspb_save_settings" value="<?php esc_html_e("Save settings"); ?>" class="button button-primary button-large javascript_delay_submit">
												</div>
											</form>
										</div>
									<?php
										//End Form for delay script saving
										break;

									case 'keys':

										if (isset($_POST['gspb_save_settings'])) { // Delay script saving
											if (!wp_verify_nonce(sanitize_text_field( wp_unslash($_POST['gspb_settings_field'])), 'gspb_settings_page_action')) {
												esc_html_e("Sorry, your nonce did not verify.", 'greenshift-animation-and-page-builder-blocks');
												return;
											}
											$sanitised = array();

											if (isset($_POST['googleapi']) || isset($_POST['openaiapi']) || isset($_POST['openaiapimodel']) || isset($_POST['claudeapi']) || isset($_POST['deepseekapi'])) {
												$global_settings = get_option('gspb_global_settings');
												if (isset($_POST['googleapi'])) {
													$sanitised['googleapi'] = sanitize_text_field($_POST['googleapi']);
												}
												if (isset($_POST['openaiapi'])) {
													$sanitised['openaiapi'] = sanitize_text_field($_POST['openaiapi']);
												}
												if (isset($_POST['openaiapimodel'])) {
													$sanitised['openaiapimodel'] = sanitize_text_field($_POST['openaiapimodel']);
												}
												if (isset($_POST['claudeapi'])) {
													$sanitised['claudeapi'] = sanitize_text_field($_POST['claudeapi']);
												}
												if (isset($_POST['deepseekapi'])) {
													$sanitised['deepseekapi'] = sanitize_text_field($_POST['deepseekapi']);
												}
												$newargs = wp_parse_args($sanitised, $global_settings);
												update_option('gspb_global_settings', $newargs);
											}
										}
										$global_settings = get_option('gspb_global_settings');
										//Form for delay script saving
										$googleapi = !empty($global_settings['googleapi']) ? $global_settings['googleapi'] : '';
										$openaiapi = !empty($global_settings['openaiapi']) ? $global_settings['openaiapi'] : '';
										$openaiapimodel = !empty($global_settings['openaiapimodel']) ? $global_settings['openaiapimodel'] : '';
										$claudeapi = !empty($global_settings['claudeapi']) ? $global_settings['claudeapi'] : '';
										$deepseekapi = !empty($global_settings['deepseekapi']) ? $global_settings['deepseekapi'] : '';

									?>
										<div class="gspb_settings_form">
											<form method="POST">
												<div class="greenshift_form">
													<?php wp_nonce_field('gspb_settings_page_action', 'gspb_settings_field'); ?>
													<table class="form-table">
														<tbody>
															<tr class="googleapikey">
																<td>
																	<label for="googleapi"><?php esc_html_e("Google API Key", 'greenshift-animation-and-page-builder-blocks'); ?></label>
																</td>
																<td>
																	<textarea style="width:100%; min-height:50px;border-color:#ddd" id="googleapi" name="googleapi"><?php echo esc_html($googleapi); ?></textarea>
																	<div style="margin-bottom:15px"><a href="https://developers.google.com/maps/documentation/javascript/get-api-key"><?php esc_html_e("Get an API Key", 'greenshift-animation-and-page-builder-blocks'); ?></a></div>
																</td>
															</tr>
															<tr class="openaiapikey">
																<td>
																	<label for="openaiapi"><?php esc_html_e("Open AI API Key", 'greenshift-animation-and-page-builder-blocks'); ?></label>
																</td>
																<td>
																	<textarea style="width:100%; min-height:50px;border-color:#ddd" id="openaiapi" name="openaiapi"><?php echo esc_html($openaiapi); ?></textarea>
																	<div style="margin-bottom:15px"><a href="https://platform.openai.com/account/api-keys"><?php esc_html_e("Get an API Key", 'greenshift-animation-and-page-builder-blocks'); ?></a></div>
																</td>
															</tr>
															<tr class="claudeapikey">
																<td>
																	<label for="claudeapi"><?php esc_html_e("Claude API Key", 'greenshift-animation-and-page-builder-blocks'); ?></label>
																</td>
																<td>
																	<textarea style="width:100%; min-height:50px;border-color:#ddd" id="claudeapi" name="claudeapi"><?php echo esc_html($claudeapi); ?></textarea>
																	<div style="margin-bottom:15px"><a href="https://console.anthropic.com/"><?php esc_html_e("Get an API Key", 'greenshift-animation-and-page-builder-blocks'); ?></a></div>
																</td>
															</tr>
															<tr class="deepseekapikey">
																<td>
																	<label for="deepseekapi"><?php esc_html_e("Deepseek API Key", 'greenshift-animation-and-page-builder-blocks'); ?></label>
																</td>
																<td>
																	<textarea style="width:100%; min-height:50px;border-color:#ddd" id="deepseekapi" name="deepseekapi"><?php echo esc_html($deepseekapi); ?></textarea>
																	<div style="margin-bottom:15px"><a href="https://platform.deepseek.com/api_keys"><?php esc_html_e("Get an API Key", 'greenshift-animation-and-page-builder-blocks'); ?></a></div>
																</td>
															</tr>
															<tr class="openaiapimodel">
																<td>
																	<label for="openaiapimodel"><?php esc_html_e("Select Model for AI", 'greenshift-animation-and-page-builder-blocks'); ?></label>
																</td>
																<td>
																	<select name="openaiapimodel">
																		<option value="gpt-3.5-turbo" <?php selected($openaiapimodel, 'gpt-3.5-turbo'); ?>> gpt-3.5-turbo </option>
																		<option value="gpt-4" <?php selected($openaiapimodel, 'gpt-4'); ?>> gpt-4 </option>
																		<option value="gpt-4-turbo" <?php selected($openaiapimodel, 'gpt-4-turbo'); ?>> gpt-4-turbo </option>
																		<option value="gpt-4-32k" <?php selected($openaiapimodel, 'gpt-4-32k'); ?>> gpt-4-32k </option>
																		<option value="gpt-4o" <?php selected($openaiapimodel, 'gpt-4o'); ?>> gpt-4o </option>
																		<option value="gpt-4o-mini" <?php selected($openaiapimodel, 'gpt-4o-mini'); ?>> gpt-4o-mini </option>
																		<option value="o1" <?php selected($openaiapimodel, 'o1'); ?>> o1 </option>
																		<option value="o1-mini" <?php selected($openaiapimodel, 'o1-mini'); ?>> o1-mini </option>
																		<option value="o1-preview" <?php selected($openaiapimodel, 'o1-preview'); ?>> o1-preview </option>
																		<option value="claude-3-5-sonnet-20241022" <?php selected($openaiapimodel, 'claude-3-5-sonnet-20241022'); ?>> claude-3-5-sonnet-20241022 </option>
																		<option value="claude-3-5-haiku-20241022" <?php selected($openaiapimodel, 'claude-3-5-haiku-20241022'); ?>> claude-3-5-haiku-20241022 </option>
																		<option value="deepseek-chat" <?php selected($openaiapimodel, 'deepseek-chat'); ?>> deepseek-chat </option>
																	</select>
																</td>
															</tr>
														</tbody>
													</table>


													<input type="submit" name="gspb_save_settings" value="<?php esc_html_e("Save settings"); ?>" class="button button-primary button-large">
												</div>
											</form>
										</div>
									<?php
										//End Form for delay script saving
										break;
										case 'header':
											$theme_settings = get_option('greenshift_theme_options');
											
											if (isset($_POST['gspb_save_settings_header'])) { // Delay script saving
												if (!wp_verify_nonce(sanitize_text_field( wp_unslash($_POST['gspb_settings_field'])), 'gspb_settings_page_action')) {
													esc_html_e("Sorry, your nonce did not verify.", 'greenshift-animation-and-page-builder-blocks');
													return;
												}
												$sanitised = array();
												
												if (isset($_POST['custom_code_in_head'])) {
													$theme_settings['custom_code_in_head'] = wp_kses(wp_unslash($_POST['custom_code_in_head']), [
														'meta' => [
															'charset' => [],
															'content' => [],
															'http-equiv' => [],
															'name' => [],
															'property' => []
														],
														'style' => [
															'media' => [],
															'type' => []
														],
														'script' => [
															'async' => [],
															'charset' => [],
															'defer' => [],
															'src' => [],
															'type' => []
														],
														'link' => [
															'href' => [],
															'rel' => [],
															'type' => []
														],
														'img' => [
															'alt' => [],
															'height' => [],
															'src' => [],
															'width' => [],
															'style' => []
														],
														'noscript' => []
													]);
												}
												if (isset($_POST['custom_code_before_closed_body'])) {
													$theme_settings['custom_code_before_closed_body'] = wp_kses(wp_unslash($_POST['custom_code_before_closed_body']), [
														'meta' => [
															'charset' => [],
															'content' => [],
															'http-equiv' => [],
															'name' => [],
															'property' => []
														],
														'style' => [
															'media' => [],
															'type' => []
														],
														'script' => [
															'async' => [],
															'charset' => [],
															'defer' => [],
															'src' => [],
															'type' => [],
															'data-project' => []
														],
														'link' => [
															'href' => [],
															'rel' => [],
															'type' => []
														],
														'img' => [
															'alt' => [],
															'height' => [],
															'src' => [],
															'width' => [],
															'style' => []
														],
														'noscript' => []
													]);
												}
												if (isset($_POST['custom_code_in_head']) || isset($_POST['custom_code_before_closed_body'])) {
													update_option('greenshift_theme_options', $theme_settings);
												}
											}
										?>
										<h2><?php esc_html_e("Footer and Head Hooks", 'greenshift-animation-and-page-builder-blocks'); ?></h2>
										<div class="greenshift_form">
											<?php
											$custom_code_in_head = !empty($theme_settings['custom_code_in_head']) ? wp_unslash($theme_settings['custom_code_in_head']) : '';
											$custom_code_before_closed_body = !empty($theme_settings['custom_code_before_closed_body']) ? wp_unslash($theme_settings['custom_code_before_closed_body']) : '';
											?>
											<form method="POST">
												<?php wp_nonce_field('gspb_settings_page_action', 'gspb_settings_field'); ?>
												<table class="form-table">
													<tr>
														<th> <label for="custom_code_in_head"><?php esc_html_e("Custom code in head section", 'greenshift'); ?></label> </th>
														<td>
															<textarea name="custom_code_in_head" id="" cols="30" rows="10" style="width: 100%"><?php echo $custom_code_in_head ?></textarea>
														</td>
													</tr>
													<tr>
														<th> <label for="custom_code_before_closed_body"><?php esc_html_e("Custom code before closed Body", 'greenshift'); ?></label> </th>
														<td>
															<textarea name="custom_code_before_closed_body" id="" cols="30" rows="10" style="width: 100%"><?php echo $custom_code_before_closed_body ?></textarea>
														</td>
													</tr>
												</table>
												<input type="submit" name="gspb_save_settings_header" value="<?php esc_html_e('Save', 'greenshift-animation-and-page-builder-blocks') ?>" class="button button-primary button-large">
											</form>
										</div>
										<?php
											//End Form for delay script saving
											break;
									default:
										wp_enqueue_style('gsadminsettings');
										wp_enqueue_script('gsadminsettings');
										if (isset($_POST['gspb_save_settings_general']) && isset($_POST['gspb_settings_field']) && wp_verify_nonce(sanitize_text_field( wp_unslash($_POST['gspb_settings_field'])), 'gspb_settings_page_action')) { // local font saving
											$this->gspb_save_general_form($_POST, $_FILES);
										}

									?>
										<div class="wp-block-greenshift-blocks-infobox gspb_infoBox gspb_infoBox-id-gsbp-158b5f3e-b35c" id="gspb_infoBox-id-gsbp-158b5f3e-b35c">
											<div class="gs-box notice_type icon_type">
												<div class="gs-box-icon"><svg class="" style="display:inline-block;vertical-align:middle" width="32" height="32" viewBox="0 0 704 1024" xmlns="http://www.w3.org/2000/svg">
														<path style="fill:#565D66" d="M352 160c-105.88 0-192 86.12-192 192 0 17.68 14.32 32 32 32s32-14.32 32-32c0-70.6 57.44-128 128-128 17.68 0 32-14.32 32-32s-14.32-32-32-32zM192.12 918.34c0 6.3 1.86 12.44 5.36 17.68l49.020 73.68c5.94 8.92 15.94 14.28 26.64 14.28h157.7c10.72 0 20.72-5.36 26.64-14.28l49.020-73.68c3.48-5.24 5.34-11.4 5.36-17.68l0.1-86.36h-319.92l0.080 86.36zM352 0c-204.56 0-352 165.94-352 352 0 88.74 32.9 169.7 87.12 231.56 33.28 37.98 85.48 117.6 104.84 184.32v0.12h96v-0.24c-0.020-9.54-1.44-19.020-4.3-28.14-11.18-35.62-45.64-129.54-124.34-219.34-41.080-46.86-63.040-106.3-63.22-168.28-0.4-147.28 119.34-256 255.9-256 141.16 0 256 114.84 256 256 0 61.94-22.48 121.7-63.3 168.28-78.22 89.22-112.84 182.94-124.2 218.92-2.805 8.545-4.428 18.381-4.44 28.594l-0 0.006v0.2h96v-0.1c19.36-66.74 71.56-146.36 104.84-184.32 54.2-61.88 87.1-142.84 87.1-231.58 0-194.4-157.6-352-352-352z"></path>
													</svg></div>
												<div class="gs-box-text">
													<?php esc_html_e("Attention! Local font is global option and it can reduce performance in some cases. Do not use more than 2 global fonts. Please, check", 'greenshift-animation-and-page-builder-blocks'); ?> <a href="https://greenshiftwp.com/how-to-use-local-fonts-in-greenshift-for-gdpr/" target="_blank"><?php esc_html_e("Documentation", 'greenshift-animation-and-page-builder-blocks'); ?></a>
												</div>
											</div>
										</div>
										<?php
										$allowed_font_ext = $this->allowed_font_ext;
										require_once GREENSHIFT_DIR_PATH . 'templates/admin/settings_general_form.php'; ?>
								<?php
										break;
								endswitch;
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
<?php
		}

		// settings fonts
		public function gspb_settings_add_font()
		{
			$i = $_POST['i'];
			$allowed_font_ext = $this->allowed_font_ext;
			ob_start();
			require_once GREENSHIFT_DIR_PATH . 'templates/admin/settings_general_font_item.php';
			$html = ob_get_contents();
			ob_get_clean();
			wp_send_json(['html' => $html]);
		}

		public function gspb_save_general_form($data, $files)
		{
			$global_settings = get_option('gspb_global_settings');

			$fonts_urls = $this->gspb_save_files($files);
			$arr = [];
			for ($i = 0; (int)$data['fonts_count'] > $i; $i++) {
				//$item_arr = ['label' => sanitize_text_field($data['font_specific_style_name'][$i])];
				foreach ($this->allowed_font_ext as $ext) {
					$item_arr[$ext] = !empty($fonts_urls[$i][$ext]) ? $fonts_urls[$i][$ext] : sanitize_text_field($data[$ext][$i]);
				}
				$item_arr['preloaded'] = !empty($data['font_family_preload'][$i]) ? sanitize_text_field($data['font_family_preload'][$i]) : '';
				$arr[sanitize_text_field($data['font_family_name'][$i])] = $item_arr;
			}
			$new_localfont = json_encode($arr);
			$global_settings['localfont'] = $new_localfont;

			$localfontcss = '';
			if (!empty($arr)) {
				foreach ($arr as $i => $value) {
					$localfontcss .= '@font-face {';
					$localfontcss .= 'font-family: "' . $i . '";';
					$localfontcss .= 'src: ';
					if (!empty($value['woff2'])) {
						$localfontcss .= 'url(' . $value["woff2"] . ') format("woff2"), ';
					}
					if (!empty($value['woff'])) {
						$localfontcss .= 'url(' . $value["woff"] . ') format("woff"), ';
					}
					if (!empty($value['ttf'])) {
						$localfontcss .= 'url(' . $value["ttf"] . ') format("truetype"), ';
					}
					if (!empty($value['tiff'])) {
						$localfontcss .= 'url(' . $value["tiff"] . ') format("tiff"), ';
					}
					$localfontcss .= ';';
					$localfontcss .= 'font-display: swap;}';
				}
				$localfontcss = str_replace(', ;', ';', $localfontcss);
				$global_settings['localfontcss'] = $localfontcss;

				$upload_dir = wp_upload_dir();
				require_once ABSPATH . 'wp-admin/includes/file.php';
				global $wp_filesystem;
				$dir = trailingslashit($upload_dir['basedir']) . 'GreenShift/'; // Set storage directory path

				WP_Filesystem(); // WP file system

				if (!$wp_filesystem->is_dir($dir)) {
					$wp_filesystem->mkdir($dir);
				}

				$gspb_json_filename = 'settings_backup.json';
				$gspb_backup_data = json_encode($global_settings, JSON_PRETTY_PRINT);

				if (!$wp_filesystem->put_contents($dir . $gspb_json_filename, $gspb_backup_data)) {
					throw new Exception(esc_html__('JSON is not saved due the permission!!!', 'greenshift-animation-and-page-builder-blocks'));
				}
			}
			update_option('gspb_global_settings', $global_settings);
		}

		public function gspb_save_files($files)
		{
			$result = [];
			$upload = wp_upload_dir();
			$upload_dir = $upload['basedir'] . '/GreenShift/fonts';
			$upload_url = $upload['baseurl'] . '/GreenShift/fonts';

			foreach (array_keys($files) as $filename) {
				foreach ($files[$filename]["error"] as $key => $error) {
					if ($error == UPLOAD_ERR_OK) {
						$tmp_name = $files[$filename]["tmp_name"][$key];
						$name = basename($files[$filename]["name"][$key]);
						$ext = pathinfo($name, PATHINFO_EXTENSION);
						$font_dir = $upload_dir . '/font_' . ($key + 1) . '/' . $ext;

						$this->gspb_rm_rec($font_dir); //clean up dir before download

						if (!wp_mkdir_p($font_dir)) {
							return false;
						}

						if(!in_array($ext, $this->allowed_font_ext)) continue;

						if (move_uploaded_file($tmp_name, "$font_dir/$name")) {
							$result[$key][$ext] = $upload_url . '/font_' . ($key + 1) . '/' . $ext . '/' . $name;
						}
					}
				}
			}

			return $result;
		}

		public function gspb_rm_rec($path)
		{
			if (is_file($path)) return unlink($path);
			if (is_dir($path)) {
				foreach (scandir($path) as $p) if (($p != '.') && ($p != '..'))
					$this->gspb_rm_rec($path . '/' . $p);
				return rmdir($path);
			}
			return false;
		}

		//Columns in Reusable section
		function gspb_template_screen_add_column($columns)
		{
			$newcols = array(
				'cb' => '<input type="checkbox" />',
				'title' => esc_html__('Block title', 'greenshift-animation-and-page-builder-blocks'),
				'gs-reusable-preview' => esc_html__('Usage', 'greenshift-animation-and-page-builder-blocks'),
			);
			return apply_filters('greenshift_reusable_blocks_list', array_merge($columns, $newcols));
		}

		//Render function for Columns in Reusable Sections
		function gspb_template_screen_fill_column($column, $ID)
		{
			global $post;
			switch ($column) {

				case 'gs-reusable-preview':

					echo '<p><input type="text" style="width:350px" value="[wp_reusable_render id=\'' . $ID . '\']" readonly=""></p>';
					echo '<p>' . esc_html__('If you use template inside other dynamic ajax blocks', 'greenshift-animation-and-page-builder-blocks') . '<br><input type="text" style="width:350px" value="[wp_reusable_render inlinestyle=1 id=\'' . $ID . '\']" readonly="">';
					echo '<p>' . esc_html__('Shortcode for Ajax render:', 'greenshift-animation-and-page-builder-blocks') . '<br><input type="text" style="width:350px" value="[wp_reusable_render ajax=1 height=100px id=\'' . $ID . '\']" readonly="">';
					echo '<p>' . esc_html__('Hover trigger:', 'greenshift-animation-and-page-builder-blocks') . ' <code>gs-el-onhover load-block-' . $ID . '</code>';
					echo '<p>' . esc_html__('Click trigger:', 'greenshift-animation-and-page-builder-blocks') . ' <code>gs-el-onclick load-block-' . $ID . '</code>';
					echo '<p>' . esc_html__('On view trigger:', 'greenshift-animation-and-page-builder-blocks') . ' <code>gs-el-onview load-block-' . $ID . '</code>';
					break;

				default:
					break;
			}
		}

		//Render shortcode function
		function gspb_template_shortcode_function($atts)
		{
			extract(shortcode_atts(
				array(
					'id' => '',
					'ajax' => '',
					'height' => '',
					'inlinestyle' => ''
				),
				$atts
			));
			if (!isset($id) || empty($id)) {
				return '';
			}
			if (!is_numeric($id)) {
				$postget = get_page_by_path($id, OBJECT, array('wp_block'));
				if (is_object($postget)) {
					$id = $postget->ID;
				} else {
					return;
				}
			}
			$style = '';
			$post_css = get_post_meta((int)$id, '_gspb_post_css', true);
			if(!empty($post_css)){
				$dynamic_style = '<style>' . wp_kses_post($post_css) . '</style>';
				$dynamic_style = gspb_get_final_css($dynamic_style);
				$dynamic_style = gspb_quick_minify_css($dynamic_style);
				$dynamic_style = htmlspecialchars_decode($dynamic_style);
				$style .= $dynamic_style;
			}
			if (!empty($ajax)) {
				wp_enqueue_style('wp-block-library');
				wp_enqueue_style('gspreloadercss');
				wp_enqueue_script('gselajaxloader');
				$scriptvars = array(
					'reusablenonce' => wp_create_nonce('gsreusable'),
					'ajax_url' => admin_url('admin-ajax.php', 'relative'),
				);
				wp_localize_script('gselajaxloader', 'gsreusablevars', $scriptvars);
				$content = '<div class="gs-ajax-load-block gs-ajax-load-block-' . (int)$id . '"></div>';

				$content_post = get_post($id);
				if (!is_object($content_post)) return false;
				if($content_post->post_type != 'wp_block') return false;
				$contentpost = $content_post->post_content;
				if ($inlinestyle && has_blocks($contentpost)) {
					$blocks = parse_blocks($contentpost);
					$style .= '<style>';
					$style .= gspb_get_inline_styles_blocks($blocks);
					$style .= '</style>';
				}
				if (!empty($height)) {
					$content = '<div style="min-height:' . esc_attr($height) . '">' . $content . $style . '</div>';
				} else {
					$content = '<div>' . $content . $style . '</div>';
				}
			} else {
				$content_post = get_post($id);
				if (!is_object($content_post)) return false;
				if($content_post->post_type != 'wp_block') return false;
				$content = $content_post->post_content;
				if ($inlinestyle) {
					if (has_blocks($content)) {
						$blocks = parse_blocks($content);
						$style .= '<style>';
						$style .= gspb_get_inline_styles_blocks($blocks);
						$style .= '</style>';
					}
				}
				$content = do_blocks($content);
				$content = do_shortcode($content);
				$content = preg_replace('%<p>&nbsp;\s*</p>%', '', $content);
				$content = preg_replace('/^(?:<br\s*\/?>\s*)+/', '', $content);
				$content = $content . $style;
			}
			return $content;
		}

		//Load reusable Ajax function
		function gspb_el_reusable_load()
		{
			check_ajax_referer('gsreusable', 'security');
			$post_id = intval($_POST['post_id']);
			$content_post = get_post($post_id);
			$content = '';
			if(is_object($content_post)){
				$content = $content_post->post_content;
				$content = apply_filters('the_content', $content);
				$content = str_replace('strokewidth', 'stroke-width', $content);
				$content = str_replace('strokedasharray', 'stroke-dasharray', $content);
				$content = str_replace('stopcolor', 'stop-color', $content);
				$content = str_replace('loading="lazy"', '', $content);
				if($content_post->post_type != 'wp_block') $content = 'Please use this feature only for reusable blocks';
			}
			if ($content) {
				wp_send_json_success($content);
			} else {
				wp_send_json_success('fail');
			}
			wp_die();
		}

		//Show gutenberg editor on reusable section even if Classic editor plugins enabled
		function gspb_template_gutenberg_post($use_block_editor, $post)
		{
			if (empty($post->ID)) return $use_block_editor;
			if ('wp_block' === get_post_type($post->ID)) return true;
			return $use_block_editor;
		}
		function gspb_template_gutenberg_post_type($use_block_editor, $post_type)
		{
			if ('wp_block' === $post_type) return true;
			return $use_block_editor;
		}

		function greenshift_additional__header_elements()
		{
			$theme_settings = get_option('greenshift_theme_options');
			if (!empty($theme_settings['custom_code_in_head'])) {
				echo wp_kses(wp_unslash($theme_settings['custom_code_in_head']), [
					'meta' => [
						'charset' => [],
						'content' => [],
						'http-equiv' => [],
						'name' => [],
						'property' => []
					],
					'style' => [
						'media' => [],
						'type' => []
					],
					'script' => [
						'async' => [],
						'charset' => [],
						'defer' => [],
						'src' => [],
						'type' => [],
						'data-project' => []
					],
					'link' => [
						'href' => [],
						'rel' => [],
						'type' => []
					],
					'img' => [
						'alt' => [],
						'height' => [],
						'src' => [],
						'width' => [],
						'style' => []
					],
					'iframe' => [
						'height' => [],
						'src' => [],
						'width' => [],
						'style' => []
					],
					'noscript' => []
				]);
			}
			$sitesettings = get_option('gspb_global_settings');
			$localfonts = (!empty($sitesettings['localfont'])) ? $sitesettings['localfont'] : '';
			if ($localfonts) {
				$localfonts = json_decode($localfonts, true);
				if (is_array($localfonts)) {
					foreach ($localfonts as $localfont) {
						if (!empty($localfont['preloaded'])) {
							$allowed_font_ext = $this->allowed_font_ext;
							foreach ($allowed_font_ext as $ext) {
								if (!empty($localfont[$ext])) {
									echo '<link rel="preload" href="' . $localfont[$ext] . '" as="font" type="font/' . $ext . '" crossorigin>';
								}
							}
						}
					}
				}
			}
			if (!empty($sitesettings['sitesettings']['smoothscroll'])) {
				echo '<style>html.lenis, html.lenis body {height: auto;}.lenis.lenis-smooth {scroll-behavior: auto !important;}.lenis.lenis-smooth [data-lenis-prevent] {overscroll-behavior: contain;}.lenis.lenis-stopped {overflow: hidden;}.lenis.lenis-smooth iframe {pointer-events: none;}</style>';
			}
			if (!empty($sitesettings['sitesettings']['pagetransition']) && !empty($sitesettings['sitesettings']['pagetransitioneffect'])) {
				echo '<style>
					@view-transition {navigation: auto;}
					@media (prefers-reduced-motion) {
						::view-transition-group(*), ::view-transition-old(*), ::view-transition-new(*) {
							animation: none !important;
						}
					}
				</style>';
				if($sitesettings['sitesettings']['pagetransitioneffect'] != 'none'){
					echo '<style>
						::view-transition-old(root) {animation: 1s gs-pagetransition-out 0s var(--gs-root-pagetransition-easing, ease);}
						::view-transition-new(root) {animation: 1s gs-pagetransition-in 0s var(--gs-root-pagetransition-easing, ease);}
					</style>';
				}
				if (!empty($sitesettings['sitesettings']['pagetransitioneffect'])) {
					if($sitesettings['sitesettings']['pagetransitioneffect'] == 'fade'){
						echo '<style>
							@keyframes gs-pagetransition-out {from {opacity: 1;}to {opacity: 0;}}
							@keyframes gs-pagetransition-in {from {opacity: 0;}to {opacity: 1;}}
						</style>';
					}
					else if($sitesettings['sitesettings']['pagetransitioneffect'] == 'slide-bottom'){
						echo '<style>
							@keyframes gs-pagetransition-out {from {opacity: 1;translate: 0;}to {opacity: 0;translate: 0 5rem;}}
							@keyframes gs-pagetransition-in {from {opacity: 0;translate: 0 -5rem;}to {opacity: 1;translate: 0;}}
						</style>';
					}
					else if($sitesettings['sitesettings']['pagetransitioneffect'] == 'slide-left'){
						echo '<style>
							@keyframes gs-pagetransition-out {from {opacity: 1;translate: 0;}to {opacity: 0;translate: -5rem 0;}}
							@keyframes gs-pagetransition-in {from {opacity: 0;translate: 5rem 0;}to {opacity: 1;translate: 0;}}
						</style>';
					}
					else if($sitesettings['sitesettings']['pagetransitioneffect'] == 'slide-right'){
						echo '<style>
							@keyframes gs-pagetransition-out {from {opacity: 1;translate: 0;}to {opacity: 0;translate: 5rem 0;}}
							@keyframes gs-pagetransition-in {from {opacity: 0;translate: -5rem 0;}to {opacity: 1;translate: 0;}}
						</style>';
					}
					else if($sitesettings['sitesettings']['pagetransitioneffect'] == 'zoom'){
						echo '<style>
							@keyframes gs-pagetransition-out {from {opacity: 1;scale: 1;}to {opacity: 0;scale: 1.2;}}
							@keyframes gs-pagetransition-in {from {opacity: 0;scale: 0.8;}to {opacity: 1;scale: 1;}}
						</style>';
					}
					else if($sitesettings['sitesettings']['pagetransitioneffect'] == 'parallax-out'){
						echo '<style>
							::view-transition-old(root) {
								animation: 1s gs-pagetransition-out 0s var(--gs-root-pagetransition-easing, ease) both;
							}
							::view-transition-new(root) {
								animation: 1s gs-pagetransition-in 0s var(--gs-root-pagetransition-easing, ease) both;
							}
							@keyframes gs-pagetransition-out {
								from { opacity: 1; transform: translateY(0); }
								to { opacity: 0.5; transform: translateY(-50%); }
							}
							@keyframes gs-pagetransition-in {
								from { opacity: 0; transform: translateY(100%); }
								to { opacity: 1; transform: translateY(0); }
							}
						</style>';
					}
					else if($sitesettings['sitesettings']['pagetransitioneffect'] == 'push'){
						echo '<style>
							::view-transition-old(root) {
								animation: 1s gs-pagetransition-out 0s var(--gs-root-pagetransition-easing, ease) both;
							}
							::view-transition-new(root) {
								animation: 1s gs-pagetransition-in 0s var(--gs-root-pagetransition-easing, ease) both;
							}
							@keyframes gs-pagetransition-out {
								from { transform: translateY(0); }
								to { transform: translateY(-100%); }
							}
							@keyframes gs-pagetransition-in {
								from { transform: translateY(100%); }
								to { transform: translateY(0); }
							}
						</style>';
					}
					else{	
						echo '<style>
							@keyframes gs-pagetransition-out {from {opacity: 1;translate: 0;}to {opacity: 0;translate: 0 -5rem;}}
							@keyframes gs-pagetransition-in {from {opacity: 0;translate: 0 5rem;}to {opacity: 1;translate: 0;}}
						</style>';
					}
				}
				if (!empty($sitesettings['sitesettings']['pagetransitionsafe'])) {
					echo '<style>';
					$safeselectors = explode(',', $sitesettings['sitesettings']['pagetransitionsafe']);
					foreach ($safeselectors as $selector) {
						echo $selector . ' { view-transition-name: ' . str_replace(array('.', '#'), '', esc_attr($selector)) . '; }';
					}
					echo '</style>';
				}else{
					echo '<style>
					header{
						view-transition-name: header;
					}
					footer{
						view-transition-name: footer;
					}
					#wpadminbar{
						view-transition-name: topbar;
					}
				</style>';
				}
			}
		}

		function greenshift_additional__footer_elements()
		{
			if (defined('GREENSHIFTGSAP_DIR_URL')) {
				$sitesettings = $this->global_settings;
				if (!empty($sitesettings['sitesettings']['mousefollow'])) {
					$color = !empty($sitesettings['sitesettings']['mousecolor']) ? $sitesettings['sitesettings']['mousecolor'] : '#2184f9';
					echo '<div class="gsmouseball"></div><div class="gsmouseballsmall"></div><style>.gsmouseball{width:33px;height:33px;position:fixed;top:0;left:0;z-index:99999;border:1px solid ' . esc_attr($color) . ';border-radius:50%;pointer-events:none;opacity:0}.gsmouseballsmall{width:4px;height:4px;position:fixed;top:0;left:0;background:' . esc_attr($color) . ';border-radius:50%;pointer-events:none;opacity:0; z-index:99999}</style>';
					wp_enqueue_script('gsap-mousefollow-init');
				}
				if (!empty($sitesettings['sitesettings']['smoothscroll'])) {
					wp_enqueue_script('gs-smooth-scroll');
				}
			}
			$theme_settings = get_option('greenshift_theme_options');
			if (!empty($theme_settings['custom_code_before_closed_body'])) {
				echo wp_kses(wp_unslash($theme_settings['custom_code_before_closed_body']), [
					'meta' => [
						'charset' => [],
						'content' => [],
						'http-equiv' => [],
						'name' => [],
						'property' => []
					],
					'style' => [
						'media' => [],
						'type' => []
					],
					'script' => [
						'async' => [],
						'charset' => [],
						'defer' => [],
						'src' => [],
						'type' => []
					],
					'link' => [
						'href' => [],
						'rel' => [],
						'type' => []
					],
					'img' => [
						'alt' => [],
						'height' => [],
						'src' => [],
						'width' => [],
						'style' => []
					],
					'iframe' => [
						'height' => [],
						'src' => [],
						'width' => [],
						'style' => []
					],
					'noscript' => []
				]);
			}
		}
	}
}

function gspb_get_inline_styles_blocks($blocks)
{
	$inlinestyle = '';
	foreach ($blocks as $block) {
		gspb_greenShift_block_script_assets('', $block);
		if (function_exists('greenShiftGsap_block_script_assets')) {
			greenShiftGsap_block_script_assets('', $block);
		}
		if (!empty($block['innerBlocks'])) {
			$blocks = $block['innerBlocks'];
			$inlinestyle .= gspb_get_inline_styles_blocks($blocks);
		}
	}
	return $inlinestyle;
}

//////////////////////////////////////////////////////////////////
// File Manager
//////////////////////////////////////////////////////////////////

if (!function_exists('greenshift_download_file_localy')) {
	function greenshift_download_file_localy($file_uri, $save_dir, $file_name, $file_ext = null, $check_type = '')
	{
		$file_path = trailingslashit($save_dir) . $file_name;
		if (file_exists($file_path)) {
			return $file_name;
		}
		$args = array(
			'timeout' => 30,
			'httpversion' => '1.1',
			'user-agent'  => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.101 Safari/537.36',
			'sslverify'   => true,
		);

		$response = wp_remote_get($file_uri, $args);

		if (is_wp_error($response) || (int) wp_remote_retrieve_response_code($response) !== 200) {
			return false;
		}

		if ($file_ext === null) {
			$headers = wp_remote_retrieve_headers($response);
			if (empty($headers['content-type'])) return false;

			$types = array_search($headers['content-type'], wp_get_mime_types());

			if (!$types) return false;

			$exts = explode('|', $types);
			$file_ext = $exts[0];
			$file_name .= '.' . $file_ext;
		}

		$file_name = wp_unique_filename($save_dir, $file_name);
		if ($check_type) {
			$filetype = wp_check_filetype($file_name);
			if ($filetype['type'] != $check_type)
				return false;
		}

		$image_string = wp_remote_retrieve_body($response);
		if (!file_put_contents($file_path, $image_string))
			return false;

		return $file_name;
	}
}

if (!function_exists('greenshift_save_file_localy')) {
	function greenshift_save_file_localy($file_uri, $img_title = '', $check_type = '')
	{
		if(!current_user_can('manage_options')) return false;
		$newfilename = basename($file_uri);
		$ext = pathinfo(basename($file_uri), PATHINFO_EXTENSION);

		$ext = ($ext) ? $ext : null;

		if($ext == 'svg') return false;

		if (empty($newfilename)) {
			$newfilename = preg_replace('/[^a-zA-Z0-9\-]/', '', $newfilename);
			$newfilename = strtolower($newfilename);
		}

		$uploads = wp_upload_dir();

		if ($newfilename = greenshift_download_file_localy($file_uri, $uploads['path'], $newfilename, $ext, $check_type)) {
			return $newfilename;
		} else {
			return false;
		}
	}
}

if (!function_exists('greenshift_replace_ext_images')) {
	function greenshift_replace_ext_images($content, $format = 'json')
	{
		$pattern = '#https?://[^/\s]+/\S+\.(jpg|png|gif|webp|svg|jpeg|json)#';
		if ($format == 'json') {
			$content = json_decode($content, true);
		}
		$result = preg_replace_callback($pattern, function ($match) {
			if (is_array($match)) {
				$url = $match[0];
				if (strpos($url, get_bloginfo('url')) !== 0) {
					$urlnew = greenshift_save_file_localy($url);
					$uploads = wp_upload_dir();
					$image = trailingslashit($uploads['url']) . $urlnew;
					return $image;
				} else {
					return $url;
				}
			}
		}, $content);
		if ($format == 'json') {
			$result = json_encode($result);
		}
		return $result;
	}
}

?>
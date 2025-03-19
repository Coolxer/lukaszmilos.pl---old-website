<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

//////////////////////////////////////////////////////////////////
// Functions to render conditional styles
//////////////////////////////////////////////////////////////////
$global_gs_options = get_option('gspb_global_settings');
function gspb_get_breakpoints()
{
	// defaults breakpoints.
	$gsbp_breakpoints = apply_filters('greenshift_responsive_breakpoints', array(
		'mobile' 	=> 576,
		'tablet' 	=> 768,
		'desktop' =>  992
	));

	$gs_settings = get_option('gspb_global_settings');

	if (!empty($gs_settings)) {
		$gsbp_custom_breakpoints = (!empty($gs_settings['breakpoints'])) ? $gs_settings['breakpoints'] : '';

		if (!empty($gsbp_custom_breakpoints['mobile'])) {
			$gsbp_breakpoints['mobile'] = trim($gsbp_custom_breakpoints['mobile']);
		}

		if (!empty($gsbp_custom_breakpoints['tablet'])) {
			$gsbp_breakpoints['tablet'] = trim($gsbp_custom_breakpoints['tablet']);
		}

		if (!empty($gsbp_custom_breakpoints['desktop'])) {
			$gsbp_breakpoints['desktop'] = trim($gsbp_custom_breakpoints['desktop']);
		}
	}

	return array(
		'mobile' 			=> intval($gsbp_breakpoints['mobile']),
		'mobile_down' 		=> intval($gsbp_breakpoints['mobile']) - 0.02,
		'tablet' 			=> intval($gsbp_breakpoints['tablet']),
		'tablet_down' 		=> intval($gsbp_breakpoints['tablet']) - 0.02,
		'desktop' 			=> intval($gsbp_breakpoints['desktop']),
		'desktop_down'		=> intval($gsbp_breakpoints['desktop']) - 0.02,
	);
}

function gspb_get_final_css($gspb_css_content)
{
	$get_breakpoints = gspb_get_breakpoints();

	if ($get_breakpoints['mobile'] != 576) {
		$gspb_css_content = str_replace('@media (max-width: 575.98px)', '@media (max-width: ' . $get_breakpoints["mobile_down"] . 'px)', $gspb_css_content);
		$gspb_css_content = str_replace('@media (min-width: 576px)', '@media (min-width: ' . $get_breakpoints["mobile"] . 'px)', $gspb_css_content);
		$gspb_css_content = str_replace('@media (max-width:575.98px)', '@media (max-width: ' . $get_breakpoints["mobile_down"] . 'px)', $gspb_css_content);
		$gspb_css_content = str_replace('@media (min-width:576px)', '@media (min-width: ' . $get_breakpoints["mobile"] . 'px)', $gspb_css_content);
	}

	if ($get_breakpoints['tablet'] != 768) {
		$gspb_css_content = str_replace('and (max-width: 767.98px)', 'and (max-width: ' . $get_breakpoints["tablet_down"] . 'px)', $gspb_css_content);
		$gspb_css_content = str_replace('@media (min-width: 768px)', '@media (min-width: ' . $get_breakpoints["tablet"] . 'px)', $gspb_css_content);
		$gspb_css_content = str_replace('and (max-width:767.98px)', 'and (max-width: ' . $get_breakpoints["tablet_down"] . 'px)', $gspb_css_content);
		$gspb_css_content = str_replace('@media (min-width:768px)', '@media (min-width: ' . $get_breakpoints["tablet"] . 'px)', $gspb_css_content);
		$gspb_css_content = str_replace('@media (max-width:767.98px)', '@media (max-width: ' . $get_breakpoints["tablet_down"] . 'px)', $gspb_css_content);
		$gspb_css_content = str_replace('@media (max-width: 767.98px)', '@media (max-width: ' . $get_breakpoints["tablet_down"] . 'px)', $gspb_css_content);
	}

	if ($get_breakpoints['desktop'] != 992) {
		$gspb_css_content = str_replace('and (max-width: 991.98px)', 'and (max-width: ' . $get_breakpoints["desktop_down"] . 'px)', $gspb_css_content);
		$gspb_css_content = str_replace('and (max-width:991.98px)', 'and (max-width: ' . $get_breakpoints["desktop_down"] . 'px)', $gspb_css_content);
		$gspb_css_content = str_replace('@media (min-width: 992px)', '@media (min-width: ' . $get_breakpoints["desktop"] . 'px)', $gspb_css_content);
		$gspb_css_content = str_replace('@media (min-width:992px)', '@media (min-width: ' . $get_breakpoints["desktop"] . 'px)', $gspb_css_content);
		$gspb_css_content = str_replace('@media (max-width:991.98px)', '@media (max-width: ' . $get_breakpoints["desktop_down"] . 'px)', $gspb_css_content);
		$gspb_css_content = str_replace('@media (max-width: 991.98px)', '@media (max-width: ' . $get_breakpoints["desktop_down"] . 'px)', $gspb_css_content);
	}

	return $gspb_css_content;
}

//////////////////////////////////////////////////////////////////
// CSS minify
//////////////////////////////////////////////////////////////////
function gspb_quick_minify_css($css)
{
	$css = preg_replace('/\s+/', ' ', $css);
	$css = preg_replace('/\/\*[^\!](.*?)\*\//', '', $css);
	$css = preg_replace('/(,|:|;|\{|}) /', '$1', $css);
	$css = preg_replace('/ (,|;|\{|})/', '$1', $css);
	$css = preg_replace('/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css);
	//$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );
	return trim($css);
}


//////////////////////////////////////////////////////////////////
// Functions to render conditional scripts
//////////////////////////////////////////////////////////////////

// Hook: Frontend assets.
add_action('init', 'gspb_greenShift_register_scripts_blocks');
add_filter('render_block', 'gspb_greenShift_block_script_assets', 10, 2);

$enable_head_inline = !empty($global_gs_options['enable_head_inline']) ? $global_gs_options['enable_head_inline'] : '';
//$enable_head_inline = function_exists('wp_is_block_theme') && wp_is_block_theme();

if($enable_head_inline){
	add_filter('render_block', 'gspb_greenShift_block_inline_head', 10, 2);
}else{
	add_filter('render_block', 'gspb_greenShift_block_inline_styles', 10, 2);
}

function gspb_greenShift_register_scripts_blocks(){

	//lazyload
	wp_register_script(
		'gs-lazyload',
		GREENSHIFT_DIR_URL . 'libs/lazysizes/index.js',
		array(),
		'5.3.2',
		true
	);
	wp_register_script(
		'jslazyload',
		GREENSHIFT_DIR_URL . 'libs/lazyloadjs/lazyload-scripts.min.js',
		array(),
		'1.0',
		true
	);

	// aos script
	wp_register_script(
		'greenShift-aos-lib',
		GREENSHIFT_DIR_URL . 'libs/aos/aoslight.js',
		array(),
		'3.7',
		true
	);

	wp_register_script(
		'greenShift-aos-lib-clip',
		GREENSHIFT_DIR_URL . 'libs/aos/aoslightclip.js',
		array(),
		'3.7',
		true
	);

	wp_register_script(
		'greenShift-scrollable-init',
		GREENSHIFT_DIR_URL . 'libs/scrollable/init.js',
		array(),
		'2.2',
		true
	);

	wp_register_script(
		'greenshift-drag-init',
		GREENSHIFT_DIR_URL . 'libs/scrollable/drag.js',
		array(),
		'1.3',
		true
	);

	// accordion
	wp_register_script(
		'gs-accordion',
		GREENSHIFT_DIR_URL . 'libs/accordion/index.js',
		array(),
		'1.8',
		true
	);

	// toc
	wp_register_script(
		'gs-toc',
		GREENSHIFT_DIR_URL . 'libs/toc/index.js',
		array(),
		'1.4',
		true
	);

	// swiper
	wp_register_script(
		'gstablesort',
		GREENSHIFT_DIR_URL . 'libs/table/sortable.js',
		array(),
		'1.0',
		true
	);

	// swiper
	wp_register_script(
		'gsswiper',
		GREENSHIFT_DIR_URL . 'libs/swiper/swiper-bundle.min.js',
		array(),
		'9.3.3',
		true
	);
	wp_register_script(
		'gs-swiper-init',
		GREENSHIFT_DIR_URL . 'libs/swiper/init.js',
		array(),
		'8.9.9.3',
		true
	);
	wp_localize_script(
		'gs-swiper-init',
		'gs_swiper',
		array(
			'breakpoints' => gspb_get_breakpoints()
		)
	);
	wp_register_script(
		'gs-swiper-loader',
		GREENSHIFT_DIR_URL . 'libs/swiper/loader.js',
		array(),
		'7.3.5',
		true
	);
	wp_localize_script(
		'gs-swiper-loader',
		'gs_swiper_params',
		array(
			'pluginURL' => GREENSHIFT_DIR_URL,
			'breakpoints' => gspb_get_breakpoints()
		)
	);
	wp_register_style('gsswiper', GREENSHIFT_DIR_URL . 'libs/swiper/swiper-bundle.min.css', array(), '8.4');

	// tabs
	wp_register_script(
		'gstabs',
		GREENSHIFT_DIR_URL . 'libs/tabs/tabs.js',
		array(),
		'1.6',
		true
	);

	// toggler
	wp_register_script(
		'gstoggler',
		GREENSHIFT_DIR_URL . 'libs/toggler/index.js',
		array(),
		'1.3',
		true
	);

	wp_register_script(
		'gssmoothscrollto',
		GREENSHIFT_DIR_URL . 'libs/scrollto/index.js',
		array(),
		'1.1',
		true
	);

	wp_register_script(
		'gs-smooth-scroll',
		GREENSHIFT_DIR_URL . 'libs/motion/smoothscroll.js',
		array(),
		'1.2',
		true
	);

	// video
	wp_register_script(
		'gsvimeo',
		GREENSHIFT_DIR_URL . 'libs/video/vimeo.js',
		array(),
		'1.5',
		true
	);
	wp_register_script(
		'gsvideo',
		GREENSHIFT_DIR_URL . 'libs/video/index.js',
		array(),
		'1.9.6',
		true
	);

	// lightbox
	wp_register_script(
		'gslightbox',
		GREENSHIFT_DIR_URL . 'libs/lightbox/simpleLightbox.min.js',
		array(),
		'1.1',
		true
	);
	wp_register_style('gslightbox', GREENSHIFT_DIR_URL . 'libs/lightbox/simpleLightbox.min.css', array(), '1.6');

	// counter
	wp_register_script(
		'gscounter',
		GREENSHIFT_DIR_URL . 'libs/counter/index.js',
		array(),
		'1.6',
		true
	);

	// countdown
	wp_register_script(
		'gscountdown',
		GREENSHIFT_DIR_URL . 'libs/countdown/index.js',
		array(),
		'1.2',
		true
	);

	// share
	wp_register_script(
		'gsshare',
		GREENSHIFT_DIR_URL . 'libs/social-share/index.js',
		array(),
		'1.2',
		true
	);

	wp_register_script(
		'gssnack',
		GREENSHIFT_DIR_URL . 'libs/social-share/snack.js',
		array(),
		'1.1',
		true
	);

	// cook
	wp_register_script(
		'gspbcook',
		GREENSHIFT_DIR_URL . 'libs/cook/index.js',
		array(),
		'1.0',
		true
	);
	wp_register_script(
		'gspbcookbtn',
		GREENSHIFT_DIR_URL . 'libs/cook/btn.js',
		array('gspbcook'),
		'1.1',
		true
	);

	// sliding panel
	wp_register_script(
		'gsslidingpanel',
		GREENSHIFT_DIR_URL . 'libs/slidingpanel/index.js',
		array(),
		'2.8.1',
		true
	);

	// flipbox
	wp_register_script(
		'gsflipboxpanel',
		GREENSHIFT_DIR_URL . 'libs/flipbox/index.js',
		array(),
		'1.0',
		true
	);

	//animated text
	wp_register_script(
		'gstextanimate',
		GREENSHIFT_DIR_URL . 'libs/animatedtext/index.js',
		array(),
		'1.1',
		true
	);

	wp_register_script(
		'gstypewriter',
		GREENSHIFT_DIR_URL . 'libs/animatedtext/typewriter.js',
		array(),
		'1.0',
		true
	);

	//Inview
	wp_register_script(
		'greenshift-inview',
		GREENSHIFT_DIR_URL . 'libs/inview/index.js',
		array(),
		'1.4',
		true
	);
	wp_register_script(
		'greenshift-inview-bg',
		GREENSHIFT_DIR_URL . 'libs/inview/bg.js',
		array(),
		'1.0',
		true
	);

	//register scripts
	wp_register_script(
		'gsslightboxfront',
		GREENSHIFT_DIR_URL . 'libs/imagelightbox/imagelightbox.js',
		array(),
		'1.1',
		true
	);
	wp_register_style(
		'gsslightboxfront',
		GREENSHIFT_DIR_URL . 'libs/imagelightbox/imagelightbox.css',
		array(),
		'1.1'
	);
	wp_register_style(
		'gssnack',
		GREENSHIFT_DIR_URL . 'libs/social-share/snack.css',
		array(),
		'1.1'
	);

	//Model viewer
	wp_register_script(
		'gsmodelviewer',
		GREENSHIFT_DIR_URL . 'libs/modelviewer/model-viewer.min.js',
		array(),
		'3.1.3',
		true
	);
	wp_register_script(
		'gsmodelinit',
		GREENSHIFT_DIR_URL . 'libs/modelviewer/index.js',
		array(),
		'1.11.4',
		true
	);
	wp_localize_script(
		'gsmodelinit',
		'gs_model_params',
		array(
			'pluginURL' => GREENSHIFT_DIR_URL
		)
	);

	wp_register_script(
		'gschartinit',
		GREENSHIFT_DIR_URL . 'libs/apexchart/init.js',
		array(),
		'1.0',
		true
	);
	wp_localize_script(
		'gschartinit',
		'gs_chart_params',
		array(
			'pluginURL' => GREENSHIFT_DIR_URL
		)
	);

	wp_register_style(
		'gssmoothscrollto',
		GREENSHIFT_DIR_URL . 'libs/scrollto/index.css',
		array(),
		'1.0'
	);

	wp_register_script(
		'gspbswitcher',
		GREENSHIFT_DIR_URL . 'libs/switcher/index.js',
		array(),
		'1.0',
		true
	);

	wp_register_script(
		'gspbswitcheraria',
		GREENSHIFT_DIR_URL . 'libs/switcher/accessebility.js',
		array(),
		'1.0',
		true
	);

	wp_register_script(
		'cursor-follow',
		GREENSHIFT_DIR_URL . 'libs/cursor/follow.js',
		array(),
		'1.1',
		true
	);

	wp_register_script(
		'cursor-shift',
		GREENSHIFT_DIR_URL . 'libs/cursor/shift.js',
		array(),
		'1.0',
		true
	);

	wp_register_script(
		'gs-lightbox',
		GREENSHIFT_DIR_URL . 'libs/greenlightbox/index.js',
		array(),
		'1.2',
		true
	);

	wp_register_script(
		'gs-lighttooltip',
		GREENSHIFT_DIR_URL . 'libs/greentooltip/index.js',
		array(),
		'1.3',
		true
	);

	wp_register_script(
		'gs-textanimate',
		GREENSHIFT_DIR_URL . 'libs/greentextanimate/index.js',
		array(),
		'1.0',
		true
	);

	wp_register_script(
		'gs-greensyncpanels',
		GREENSHIFT_DIR_URL . 'libs/greensyncpanels/index.js',
		array(),
		'1.3',
		true
	);

	wp_register_script(
		'gs-greenpanel',
		GREENSHIFT_DIR_URL . 'libs/greenpanel/index.js',
		array(),
		'1.6',
		true
	);

	wp_register_script(
		'gs-lightcounter',
		GREENSHIFT_DIR_URL . 'libs/greencounter/index.js',
		array(),
		'1.0',
		true
	);

	wp_register_script(
		'gs-lightcountdown',
		GREENSHIFT_DIR_URL . 'libs/greencountdown/index.js',
		array(),
		'1.0',
		true
	);

	wp_register_script(
		'greenshift-twin-slide',
		GREENSHIFT_DIR_URL . 'libs/utility/twinslide.js',
		array(),
		'1.0',
		true
	);

	wp_register_script(
		'greenshift-split-text',
		GREENSHIFT_DIR_URL . 'libs/utility/splittext.js',
		array(),
		'1.0',
		true
	);

	wp_register_script(
		'greenshift-scroll-scrub',
		GREENSHIFT_DIR_URL . 'libs/utility/scroll-scrub.js',
		array(),
		'1.2',
		true
	);

	wp_register_script(
		'scroll-view-polyfill',
		GREENSHIFT_DIR_URL . 'libs/utility/scroll-timeline-init.js',
		array(),
		'1.0',
		true
	);
	wp_localize_script(
		'scroll-view-polyfill',
		'gspb_scroll_params',
		array(
			'gspbLibraryUrl' => GREENSHIFT_DIR_URL
		)
	);

	wp_register_script(
		'anchor-polyfill',
		GREENSHIFT_DIR_URL . 'libs/utility/anchor-init.js',
		array(),
		'1.1',
		true
	);
	wp_localize_script(
		'anchor-polyfill',
		'gspb_anchor_params',
		array(
			'gspbLibraryUrl' => GREENSHIFT_DIR_URL
		)
	);

	wp_register_script(
		'gspb_map',
		GREENSHIFT_DIR_URL . 'libs/map/index.js',
		array(),
		'1.1',
		true
	);

	wp_register_script(
		'gspb_osmap',
		'https://unpkg.com/leaflet@1.9.3/dist/leaflet.js',
		array(),
		'1.9.3',
		true
	);

	wp_register_style(
		'gspb_osmap_style',
		'https://unpkg.com/leaflet@1.9.3/dist/leaflet.css',
		array(),
		'1.9.3'
	);

	wp_register_script(
		'gspb_spline3d',
		GREENSHIFT_DIR_URL . 'libs/spline3d/index.js',
		array(),
		'1.1',
		true
	);

	wp_register_script(
		'gspb_api',
		GREENSHIFT_DIR_URL . 'libs/api/index.js',
		array(),
		'1.3',
		true
	);

	wp_register_script(
		'gspb_interactions',
		GREENSHIFT_DIR_URL . 'libs/interactionlayer/index.js',
		array(),
		'4.3',
		true
	);

	wp_register_script(
		'gspb_motion_spring',
		GREENSHIFT_DIR_URL . 'build/gspbMotionSpring.js',
		array(),
		'10.18',
		true
	);

	wp_register_script(
		'gspb_motion_one',
		GREENSHIFT_DIR_URL . 'build/gspbMotion.js',
		array(),
		'10.3',
		true
	);

	// gspb library css
	wp_register_style(
		'greenShift-library-editor',
		GREENSHIFT_DIR_URL . 'build/gspbLibrary.css',
		'',
		'10.8.6.6'
	);
	wp_register_style(
		'greenShift-block-css', // Handle.
		GREENSHIFT_DIR_URL . 'build/index.css', // Block editor CSS.
		array('greenShift-library-editor', 'wp-edit-blocks'),
		'10.8.6.6'
	);
	wp_register_style(
		'greenShift-stylebook-css', // Handle.
		GREENSHIFT_DIR_URL . 'build/gspbStylebook.css', // Block editor CSS.
		array(),
		'10.8.6.6'
	);
	wp_register_style(
		'greenShift-admin-css', // Handle.
		GREENSHIFT_DIR_URL . 'templates/admin/style.css', // admin css
		array(),
		'10.8.6.6'
	);

	//Script for ajax reusable loading
	wp_register_script('gselajaxloader',  GREENSHIFT_DIR_URL . 'libs/reusable/index.js', array(), '2.4', true);
	wp_register_style('gspreloadercss',  GREENSHIFT_DIR_URL . 'libs/reusable/preloader.css', array(), '1.2');


	//register blocks on server side with block.json
	register_block_type(__DIR__ . '/blockrender/accordion');
	register_block_type(__DIR__ . '/blockrender/accordionitem');
	register_block_type(__DIR__ . '/blockrender/column');
	register_block_type(__DIR__ . '/blockrender/container');
	register_block_type(__DIR__ . '/blockrender/counter');
	register_block_type(__DIR__ . '/blockrender/countdown');
	register_block_type(__DIR__ . '/blockrender/heading');
	register_block_type(__DIR__ . '/blockrender/icon-box');
	register_block_type(__DIR__ . '/blockrender/iconList');
	register_block_type(__DIR__ . '/blockrender/image');
	register_block_type(__DIR__ . '/blockrender/infobox');
	register_block_type(__DIR__ . '/blockrender/progressbar');
	register_block_type(__DIR__ . '/blockrender/row');
	register_block_type(__DIR__ . '/blockrender/svg-shape');
	register_block_type(__DIR__ . '/blockrender/swiper');
	register_block_type(__DIR__ . '/blockrender/swipe');
	register_block_type(__DIR__ . '/blockrender/tab');
	register_block_type(__DIR__ . '/blockrender/tabs');
	register_block_type(__DIR__ . '/blockrender/titlebox');
	register_block_type(__DIR__ . '/blockrender/toggler');
	register_block_type(__DIR__ . '/blockrender/video');
	register_block_type(__DIR__ . '/blockrender/modelviewer');
	register_block_type(__DIR__ . '/blockrender/spline3d');
	register_block_type(__DIR__ . '/blockrender/button');
	register_block_type(__DIR__ . '/blockrender/buttonbox');
	register_block_type(__DIR__ . '/blockrender/switcher');
	register_block_type(__DIR__ . '/blockrender/text');
	//register_block_type(__DIR__ . '/blockrender/element');

	// admin settings scripts and styles
	wp_register_script('gsadminsettings',  GREENSHIFT_DIR_URL . 'libs/admin/settings.js', array(), '1.2', true);
	wp_register_style('gsadminsettings',  GREENSHIFT_DIR_URL . 'libs/admin/settings.css', array(), '1.1');
	wp_localize_script(
		'gsadminsettings',
		'greenShift_params',
		array(
			'ajaxUrl' => admin_url('admin-ajax.php')
		)
	);

	// Register Stylebook
	$blocktemplate = array(
		array( 'greenshift-blocks/stylebook', array() ),
	);
	$args = array(
		'public'                =>	true,
		'show_in_rest'          =>  true,
		'hierarchical'          =>  false,
		'exclude_from_search'	=>	true,
		'publicly_queryable' 	=>  false,
		'show_in_menu'			=> 	false,
		'show_in_nav_menus'		=> 	false,
		'show_in_admin_bar'		=> 	false,
		'supports'              =>  array( 'editor' ),
		'has_archive'           =>  false,
		'delete_with_user'      =>  false,	
		'template' 				=>  $blocktemplate,
		'template_lock'         =>  'all',
		'label'    				=>  __( 'GreenShift Stylebook', 'greenshift-animation-and-page-builder-blocks' ),
	);
	register_post_type( 'gspbstylebook', $args );

	$argscomponent = array(
		'public'                =>	true,
		'show_in_rest'          =>  true,
		'hierarchical'          =>  false,
		'exclude_from_search'	=>	true,
		'publicly_queryable' 	=>  false,
		'show_in_menu'			=> 	false,
		'show_in_nav_menus'		=> 	false,
		'show_in_admin_bar'		=> 	false,
		'supports'              =>  array( 'editor', 'title' ),
		'has_archive'           =>  false,
		'delete_with_user'      =>  false,	
		'template' 				=>  array(
			array( 'greenshift-blocks/componentcreate', array() ),
		),
		'template_lock'         =>  'insert',
		'label'    				=>  __( 'Reusable Component', 'greenshift-animation-and-page-builder-blocks' ),
	);
	//register_post_type( 'gspbcomponent', $argscomponent );
}

//////////////////////////////////////////////////////////////////
// Register server side
//////////////////////////////////////////////////////////////////
require_once GREENSHIFT_DIR_PATH . 'blockrender/social-share/block.php';
require_once GREENSHIFT_DIR_PATH . 'blockrender/toc/block.php';
require_once GREENSHIFT_DIR_PATH . 'blockrender/map/block.php';
require_once GREENSHIFT_DIR_PATH . 'blockrender/element/block.php';


function gspb_greenShift_block_script_assets($html, $block)
{
	// phpcs:ignore

	//Main styles for blocks are loaded via Redux. Can be found in src/customJS/editor/store/index.js

	if (!is_admin()) {

		$blockname = $block['blockName'];

		// looking lazy load
		if ($blockname === 'greenshift-blocks/image') {

			if (!empty($block['attrs']) && isset($block['attrs']['additional'])) {
				if($block['attrs']['additional'] == 'lazyload'){
					wp_enqueue_script('gs-lazyload');
				}
			}
			if (!empty($block['attrs']['lightbox'])) {
				wp_enqueue_script('gsslightboxfront');
				wp_enqueue_style('gsslightboxfront');
			}
			if(!empty($block['attrs']['disablelazy'])){
				$html = str_replace('src=', 'fetchpriority="high" src=', $html);
			}
			if(!empty($block['attrs']['href'])){
				$html = str_replace('rel="noopener"', '', $html);
			}
			if (function_exists('GSPB_make_dynamic_image') && !empty($block['attrs']['dynamicimage']['dynamicEnable'])) {
				$mediaurl = !empty($block['attrs']['mediaurl']) ? $block['attrs']['mediaurl'] : '';
				$html = GSPB_make_dynamic_image($html, $block['attrs'], $block, $block['attrs']['dynamicimage'], $mediaurl);
			}
		}

		// looking for accordion
		else if ($blockname === 'greenshift-blocks/accordion') {
			wp_enqueue_script('gs-accordion');

			$p = new \WP_HTML_Tag_Processor( $html );
			$itrigger = 0;
			while ( $p->next_tag() ) {
				// Skip an element if it's not supposed to be processed.
				if ( method_exists('WP_HTML_Tag_Processor', 'has_class') && ($p->has_class( 'gs-accordion-item__title' )) ) {
					$p->set_attribute( 'id', 'gs-trigger-'.greenshift_sanitize_id_key($block['attrs']['id']).'-'.$itrigger);
					$itrigger ++;
				}
			}
			$html = $p->get_updated_html();

			$p = new \WP_HTML_Tag_Processor( $html );
			$icontent = 0;
			while ( $p->next_tag() ) {
				// Skip an element if it's not supposed to be processed.
				if ( method_exists('WP_HTML_Tag_Processor', 'has_class') && ($p->has_class( 'gs-accordion-item__content' )) ) {
					$p->set_attribute( 'aria-labelledby', 'gs-trigger-'.greenshift_sanitize_id_key($block['attrs']['id']).'-'.$icontent);
					$icontent ++;
				}
			}
			$html = $p->get_updated_html();

		}else if ($blockname === 'greenshift-blocks/switchtoggle') {
			$html = str_replace('class="gspb__switcher-element"', 'tabindex="0"  class="gspb__switcher-element"', $html);
			wp_enqueue_script('gspbswitcheraria');
			if (!empty($block['attrs']['enablelocalstorege'])) {
				wp_enqueue_script('gspbswitcher');
				wp_enqueue_script('gspbcook');
			}
		}

		// looking for toc
		else if ($blockname === 'greenshift-blocks/toc') {
			wp_enqueue_script('gs-toc');
		}

		// looking for toc
		else if ($blockname === 'greenshift-blocks/spline3d') {
			if (function_exists('GSPB_make_dynamic_from_metas') && !empty($block['attrs']['dynamicMetas']['source']['dynamicEnable'])) {
				$field = !empty($block['attrs']['dynamicMetas']['source']['dynamicField']) ? $block['attrs']['dynamicMetas']['source']['dynamicField'] : '';
				$repeaterField = !empty($block['attrs']['dynamicMetas']['source']['repeaterField']) ? $block['attrs']['dynamicMetas']['source']['repeaterField'] : '';
				if ($repeaterField && !empty($block['attrs']['dynamicMetas']['source']['repeaterArray'][$repeaterField])) {
					$source = GSPB_get_value_from_array_field($repeaterField, $block['attrs']['dynamicMetas']['source']['repeaterArray']);
					$source = GSPB_field_array_to_value($source, ', ');
				} else if ($field) {
					$source = GSPB_make_dynamic_from_metas($field);
				}
				if(!$source){return '';}
				$p = new WP_HTML_Tag_Processor( $html );
				if ( $p->next_tag( 'spline-viewer' )) {
					$p->set_attribute( 'url', $source);
				}
				$html = $p->get_updated_html();
			}
			wp_enqueue_script('gspb_spline3d');
		}

		// looking for toggler
		else if ($blockname === 'greenshift-blocks/toggler') {
			wp_enqueue_script('gstoggler');
			$id = !empty($block['attrs']['id']) ? 'gs-toggler'.greenshift_sanitize_id_key($block['attrs']['id']) : '';
			$openlabel = !empty($block['attrs']['openlabel']) ? esc_attr($block['attrs']['openlabel']) : 'Show more';
			$closelabel = !empty($block['attrs']['closelabel']) ? esc_attr($block['attrs']['closelabel']) : 'Show less';

			$html = str_replace('class="gs-toggler-wrapper"', 'class="gs-toggler-wrapper"'. ' id="'.$id.'"', $html);
			$html = str_replace('class="gs-tgl-show"', 'class="gs-tgl-show"'. ' tabindex="0" role="button" aria-label="'.$openlabel.'" aria-controls="'.$id.'"', $html);
			$html = str_replace('class="gs-tgl-hide"', 'class="gs-tgl-hide"'. ' tabindex="0" role="button" aria-label="'.$closelabel.'" aria-controls="'.$id.'"', $html);
		}

		// looking for counter
		else if ($blockname === 'greenshift-blocks/counter') {
			if (function_exists('GSPB_make_dynamic_from_metas') && !empty($block['attrs']['dynamicMetas']['end']['dynamicEnable'])) {
				$field = !empty($block['attrs']['dynamicMetas']['end']['dynamicField']) ? $block['attrs']['dynamicMetas']['end']['dynamicField'] : '';
				$repeaterField = !empty($block['attrs']['dynamicMetas']['end']['repeaterField']) ? $block['attrs']['dynamicMetas']['end']['repeaterField'] : '';
				if ($repeaterField && !empty($block['attrs']['dynamicMetas']['end']['repeaterArray'][$repeaterField])) {
					$end = GSPB_get_value_from_array_field($repeaterField, $block['attrs']['dynamicMetas']['end']['repeaterArray']);
					$end = GSPB_field_array_to_value($end, ', ');
				} else if ($field) {
					$end = GSPB_make_dynamic_from_metas($field);
				}
				if(empty($end)){return '';}
				$p = new WP_HTML_Tag_Processor( $html );
				if ( $p->next_tag( array( 'class_name' => 'gs-counter' ) ) ) {
					$p->set_attribute( 'data-end', $end);
				}
				$html = $p->get_updated_html();
			}
			wp_enqueue_script('gscounter');
		} else if ($blockname === 'greenshift-blocks/progressbar') {
			if (!empty($block['attrs']['enableAnimation'])) {
				wp_enqueue_script('greenshift-inview');
			}
			if (!empty($block['attrs']['dynamicEnable']) && function_exists('GSPB_make_dynamic_from_metas')) {
				global $post;
				$postid = '';
				if (is_object($post)) {
					$postid = $post->ID;
				}
				if ($postid) {
					$field = !empty($block['attrs']['dynamicField']) ? $block['attrs']['dynamicField'] : '';
					$repeaterField = !empty($block['attrs']['repeaterField']) ? $block['attrs']['repeaterField'] : '';
					if ($repeaterField && !empty($block['attrs']['repeaterArray'][$repeaterField])) {
						$fieldvalue = GSPB_get_value_from_array_field($repeaterField, $block['attrs']['repeaterArray']);
						$fieldvalue = GSPB_field_array_to_value($fieldvalue, ', ');
					} else {
						$fieldvalue = GSPB_make_dynamic_from_metas($field);
					}
					$maxvalue = (!empty($block['attrs']['maxvalue']) && $block['attrs']['maxvalue'] !== 0) ? $block['attrs']['maxvalue'] : 100;

					if ($fieldvalue) {
						$fieldvalue = floatval($fieldvalue);
						if (!empty($block['attrs']['typebar']) && $block['attrs']['typebar'] == 'circle') {
							$value = ($block['attrs']['progress'] * (100 / $maxvalue)) + 0.3;
							$replacedvalue = ($fieldvalue * (100 / $maxvalue)) + 0.3;
							$html = str_replace('stroke-dasharray:' . $value . '', 'stroke-dasharray:' . $replacedvalue . '', $html);
							$html = str_replace('<div class="gspb-progressbar_circle_value">' . $block['attrs']['progress'] . '</div>', '<div class="gspb-progressbar_circle_value">' . $fieldvalue . '</div>', $html);
						} else {
							$value = $block['attrs']['progress'] * (100 / $maxvalue) . '%';
							$replacedvalue = $fieldvalue * (100 / $maxvalue) . '%';
							$html = str_replace('width:' . $value . '', 'width:' . $replacedvalue . '', $html);
							if (empty($block['attrs']['label'])) {
								$html = str_replace('<div class="gs-progressbar__label">' . $block['attrs']['progress'] . '/' . $maxvalue . '</div>', '<div class="gs-progressbar__label">' . $fieldvalue . '/' . $maxvalue . '</div>', $html);
							}
						}
					}else{
						return '';
					}
				}else{
					return '';
				}
			}
		}

		// looking for sliding panel
		else if ($blockname === 'greenshift-blocks/button' || $blockname === 'greenshift-blocks/buttonbox') {
			if (!empty($block['attrs']['overlay']['inview'])) {
				wp_enqueue_script('greenshift-inview');
			}
			if (!empty($block['attrs']['cookname'])) {
				wp_enqueue_script('gspbcookbtn');
			}
			if (!empty($block['attrs']['scrollsmooth'])) {
				wp_enqueue_script('gssmoothscrollto');
			}
			if (!empty($block['attrs']['slidingPanel'])) {
				wp_enqueue_script('gsslidingpanel');
				if($blockname == 'greenshift-blocks/button'){
					$position = !empty($block['attrs']['slidePosition']) ? $block['attrs']['slidePosition'] : '';
					$html = str_replace('id="gspb_button-id-' . $block['attrs']['id'], 'data-paneltype="' . $position . '" id="gspb_button-id-' . greenshift_sanitize_id_key($block['attrs']['id']), $html);
					$html = str_replace('class="gspb_slidingPanel"', 'data-panelid="gspb_button-id-' . greenshift_sanitize_id_key($block['attrs']['id']) . '" class="gspb_slidingPanel"', $html);
				}
				if($blockname == 'greenshift-blocks/buttonbox'){
					$html = str_replace('class="gspb_slidingPanel"', 'aria-hidden="true"  class="gspb_slidingPanel"', $html);
					$html = str_replace('<div class="gspb_slidingPanel-close"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M13 11.8l6.1-6.3-1-1-6.1 6.2-6.1-6.2-1 1 6.1 6.3-6.5 6.7 1 1 6.5-6.6 6.5 6.6 1-1z"></path></svg></div>', '<button class="gspb_slidingPanel-close"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M13 11.8l6.1-6.3-1-1-6.1 6.2-6.1-6.2-1 1 6.1 6.3-6.5 6.7 1 1 6.5-6.6 6.5 6.6 1-1z"></path></svg></button>', $html);
					$html = str_replace('href="#"', 'href="#popup"', $html);
				}
			}
			if (!empty($block['attrs']['buttonLink'])) {
				$link = $block['attrs']['buttonLink'];
				if (strpos($link, "#") !== false) {
					wp_enqueue_style('gssmoothscrollto');
				}
				$linknew = apply_filters('greenshiftseo_url_filter', $link);
				$linknew = apply_filters('rh_post_offer_url_filter', $linknew);
				$html = str_replace($link, $linknew, $html);
			}
			if (function_exists('GSPB_make_dynamic_link') && !empty($block['attrs']['dynamicEnable'])) {
				$field = !empty($block['attrs']['dynamicField']) ? $block['attrs']['dynamicField'] : '';
				$repeaterField = !empty($block['attrs']['repeaterField']) ? $block['attrs']['repeaterField'] : '';
				if ($repeaterField && !empty($block['attrs']['repeaterArray'][$repeaterField])) {
					$replacedlink = GSPB_get_value_from_array_field($repeaterField, $block['attrs']['repeaterArray']);
					$replacedlink = GSPB_field_array_to_value($replacedlink, ', ');
					$replacedlink = apply_filters('greenshiftseo_url_filter', $replacedlink);
					if($replacedlink){
						$html = preg_replace('/href\s*=\s*"([^"]*)"/i', 'href="' . $replacedlink . '"', $html);
					}
				} else {
					$html = GSPB_make_dynamic_link($html, $block['attrs'], $block, $field, $block['attrs']['buttonLink']);
				}
			}
			if (function_exists('GSPB_make_dynamic_flatvalue') && !empty($block['attrs']['dynamicMetas']['buttonContent']['dynamicEnable'])) {
				$field = !empty($block['attrs']['dynamicMetas']['buttonContent']['dynamicField']) ? $block['attrs']['dynamicMetas']['buttonContent']['dynamicField'] : '';
				$repeaterfield = !empty($block['attrs']['dynamicMetas']['buttonContent']['repeaterField']) ? $block['attrs']['dynamicMetas']['buttonContent']['repeaterField'] : '';
				if ($repeaterfield && !empty($block['attrs']['dynamicMetas']['buttonContent']['repeaterArray'][$repeaterfield])) {
					$replacedlabel = GSPB_get_value_from_array_field($repeaterfield, $block['attrs']['dynamicMetas']['buttonContent']['repeaterArray']);
					$replacedlabel = GSPB_field_array_to_value($replacedlabel, ', ');
					if (strpos($block['attrs']['buttonContent'], "{DYNAMIC}") !== false) {
						$pattern = '/{DYNAMIC}/';
						$replacedlabel = preg_replace($pattern, $replacedlabel, $block['attrs']['buttonContent']);
					}
					if(!empty($block['attrs']['buttonContent'])){
						$html = str_replace('>' . $block['attrs']['buttonContent'] . '<', '>' . $replacedlabel . '<', $html);
					}else{
						$html = str_replace('<span class="gspb-buttonbox-title"></span>', '<span class="gspb-buttonbox-title">'.$replacedlabel.'</span>', $html);
					}
					
				} else if ($field) {
					$replacedlabel = GSPB_make_dynamic_flatvalue('>' . $block['attrs']['buttonContent'] . '<', $block['attrs'], $block, $field, $block['attrs']['buttonContent'], true);
					if (strpos($block['attrs']['buttonContent'], "{DYNAMIC}") !== false) {
						$pattern = '/{DYNAMIC}/';
						$replacedlabel = preg_replace($pattern, $replacedlabel, $block['attrs']['buttonContent']);
					}
					if(!empty($block['attrs']['buttonContent'])){
						$html = str_replace('>' . $block['attrs']['buttonContent'] . '<', '>' . $replacedlabel . '<', $html);
					}else{
						$html = str_replace('<span class="gspb-buttonbox-title"></span>', '<span class="gspb-buttonbox-title">'.$replacedlabel.'</span>', $html);
					}
				}
			}
		} else if ($blockname == 'greenshift-blocks/map') {
			wp_enqueue_script('gspb_map');
			//load google maps api script

			//load openstreet map scripts and styles
			if (isset($block['attrs']['maptype']) && $block['attrs']['maptype'] === 'gmap') {
				$sitesettings = get_option('gspb_global_settings');
				$googleApikey = (!empty($sitesettings['googleapi'])) ? esc_attr($sitesettings['googleapi']) : '';
				$googleApikey = apply_filters('gspb_google_api_key', $googleApikey);
				$src = 'https://maps.googleapis.com/maps/api/js?callback=initMap&&key=' . $googleApikey;
				wp_enqueue_script('gspb_googlemaps',  $src,  array('gspb_map'),  false, true);
			} else {
				wp_enqueue_style('gspb_osmap_style');
				wp_enqueue_script('gspb_osmap');
			}
		}

		// looking for container
		else if ($blockname === 'greenshift-blocks/container') {
			if (!empty($block['attrs']['overlay']['inview'])) {
				wp_enqueue_script('greenshift-inview');
			}
			if (!empty($block['attrs']['background']['lazy'])) {
				wp_enqueue_script('greenshift-inview-bg');
			}
			if (!empty($block['attrs']['flipbox'])) {
				wp_enqueue_script('gsflipboxpanel');
			}
			if (!empty($block['attrs']['containerLink'])) {
				$link = $block['attrs']['containerLink'];
				$linknew = apply_filters('greenshiftseo_url_filter', $link);
				$linknew = apply_filters('rh_post_offer_url_filter', $linknew);
				$html = str_replace($link, $linknew, $html);
			}
			if (!empty($block['attrs']['mobileSmartScroll']) && !empty($block['attrs']['carouselScroll'])) {
				wp_enqueue_script('greenShift-scrollable-init');
			}
			if (!empty($block['attrs']['mobileSmartScroll']) && !empty($block['attrs']['dragEnable'])) {
				wp_enqueue_script('greenshift-drag-init');
			}
			if (!empty($block['attrs']['shapeDivider']['topShape']['animate']) || !empty($block['attrs']['shapeDivider']['bottomShape']['animate'])) {
				wp_enqueue_script('greenShift-aos-lib');
				// init aos library
			}
			if (function_exists('GSPB_make_dynamic_link') && !empty($block['attrs']['dynamicEnable'])) {
				$field = !empty($block['attrs']['dynamicField']) ? $block['attrs']['dynamicField'] : '';
				$html = GSPB_make_dynamic_link($html, $block['attrs'], $block, $field, $block['attrs']['containerLink']);
			}
			if(!empty($block['attrs']['isVariation']) && $block['attrs']['isVariation'] == 'marquee'){
				$pattern = '/<div class="gspb_marquee_content">(.*?)<span class="gspb_marquee_content_end"><\/span><\/div>/s';
				$html = preg_replace_callback($pattern, function ($matches) {
					// Original div
					$originalDiv = '<div class="gspb_marquee_content">'.$matches[1].'</div>';
					
					// Duplicated div with aria-hidden="true"
					$duplicatedDiv = '<div class="gspb_marquee_content" aria-hidden="true">'.$matches[1].'</div>';
				
					// Return original and duplicated div
					return $originalDiv . $duplicatedDiv;
				}, $html);
			}
		}

		// looking for row
		else if ($blockname === 'greenshift-blocks/row') {
			if (!empty($block['attrs']['overlay']['inview'])) {
				wp_enqueue_script('greenshift-inview');
			}
			if (!empty($block['attrs']['background']['lazy'])) {
				wp_enqueue_script('greenshift-inview-bg');
			}
			if (!empty($block['attrs']['mobileSmartScroll']) && !empty($block['attrs']['carouselScroll'])) {
				wp_enqueue_script('greenShift-scrollable-init');
			}
			if (!empty($block['attrs']['shapeDivider']['topShape']['animate']) || !empty($block['attrs']['shapeDivider']['bottomShape']['animate'])) {
				wp_enqueue_script('greenShift-aos-lib');
				// init aos library
			}
		} else if ($blockname === 'greenshift-blocks/row-column') {
			if (!empty($block['attrs']['overlay']['inview'])) {
				wp_enqueue_script('greenshift-inview');
			}
			if (!empty($block['attrs']['background']['lazy'])) {
				wp_enqueue_script('greenshift-inview-bg');
			}
		}

		// looking for countdown
		else if ($blockname === 'greenshift-blocks/countdown') {
			if(!empty($block['attrs']['isWoo']) || (!empty($block['attrs']['type']) && $block['attrs']['type'] == 'woo')){
				global $post;
				$endtime = get_post_meta($post->ID, '_sale_price_dates_to', true);
				$starttime = get_post_meta($post->ID, '_sale_price_dates_from', true);
				$currentDate = new DateTime();
				if($endtime){
					$p = new WP_HTML_Tag_Processor( $html );
					if ( $p->next_tag( array( 'class_name' => 'gs-countdown' ) ) ) {
						$p->set_attribute( 'data-endtime', $endtime);
					}
					$html = $p->get_updated_html();

					$providedDate = DateTime::createFromFormat('U', $endtime); 
					if ($currentDate > $providedDate) {
						return "";
					}
				}else{
					return "";
				}
				if($starttime){
					$providedDate = DateTime::createFromFormat('U', $starttime);
					if ($currentDate < $providedDate) {
						return "";
					}
				}

			}else if(!empty($block['attrs']['type']) && $block['attrs']['type'] == 'fake'){
				$hoursSale = !empty($block['attrs']['hoursSale']) ? $block['attrs']['hoursSale'] : 10;
				$timememory = get_transient('gs_countdown_sale'.$block['attrs']['id']);
				$timememoryHours = get_transient('gs_countdown_sale_hours'.$block['attrs']['id']);
				$formattedDateTime = '';
				if(!$timememory || $timememoryHours != $hoursSale){
					$currentTimestamp = current_time('mysql', true);
					$newTimestamp = new DateTime($currentTimestamp);
					$newTimestamp->modify('+' . $hoursSale . ' hours');	
					$formattedDateTime = $newTimestamp->format('Y-m-d\TH:i:s');
					set_transient('gs_countdown_sale'.$block['attrs']['id'], $formattedDateTime, $hoursSale * 60 * 60);
					set_transient('gs_countdown_sale_hours'.$block['attrs']['id'], $hoursSale, $hoursSale * 60 * 60);
				}else{
					$formattedDateTime = $timememory;
				}

				$p = new WP_HTML_Tag_Processor( $html );
				if ( $p->next_tag( array( 'class_name' => 'gs-countdown' ) ) ) {
					$p->set_attribute( 'data-endtime', $formattedDateTime);
				}
				$html = $p->get_updated_html();
			}
			else{
				if (!empty($block['attrs']['endtime'])) {
					$endtime = $block['attrs']['endtime'];
					if (function_exists('GSPB_make_dynamic_from_metas') && !empty($block['attrs']['dynamicMetas']['endtime']['dynamicEnable'])) {
						$field = !empty($block['attrs']['dynamicMetas']['endtime']['dynamicField']) ? $block['attrs']['dynamicMetas']['endtime']['dynamicField'] : '';
						$repeaterField = !empty($block['attrs']['dynamicMetas']['endtime']['repeaterField']) ? $block['attrs']['dynamicMetas']['endtime']['repeaterField'] : '';
						if ($repeaterField && !empty($block['attrs']['dynamicMetas']['endtime']['repeaterArray'][$repeaterField])) {
							$endtime = GSPB_get_value_from_array_field($repeaterField, $block['attrs']['dynamicMetas']['endtime']['repeaterArray']);
							$endtime = GSPB_field_array_to_value($endtime, ', ');
						} else if ($field) {
							$endtime = GSPB_make_dynamic_from_metas($field);
						}
						$p = new WP_HTML_Tag_Processor( $html );
						if ( $p->next_tag( array( 'class_name' => 'gs-countdown' ) ) ) {
							$p->set_attribute( 'data-endtime', $endtime);
						}
						$html = $p->get_updated_html();
					}
					if(!$endtime) return '';
					if(!empty($block['attrs']['removeExpired'])){
						if (ctype_digit($endtime)) {
							$providedDate = DateTime::createFromFormat('U', $endtime);
						} elseif (DateTime::createFromFormat('Y-m-d\TH:i:s', $endtime) !== false) {
							$providedDate = DateTime::createFromFormat('Y-m-d\TH:i:s', $endtime);
						}elseif (DateTime::createFromFormat('Y-m-d H:i:s', $endtime) !== false) {
							$providedDate = DateTime::createFromFormat('Y-m-d H:i:s', $endtime);
						} else {
							$providedDate = DateTime::createFromFormat('Y-m-d', $endtime);
						}
						$currentDate = new DateTime(); 
						if ($currentDate > $providedDate) {
							return "";
						}
					}
	
				}
				if (!empty($block['attrs']['starttime'])) {
					$starttime = $block['attrs']['starttime'];
					if (function_exists('GSPB_make_dynamic_from_metas') && !empty($block['attrs']['dynamicMetas']['starttime']['dynamicEnable'])) {
						$field = !empty($block['attrs']['dynamicMetas']['starttime']['dynamicField']) ? $block['attrs']['dynamicMetas']['starttime']['dynamicField'] : '';
						$repeaterField = !empty($block['attrs']['dynamicMetas']['starttime']['repeaterField']) ? $block['attrs']['dynamicMetas']['starttime']['repeaterField'] : '';
						if ($repeaterField && !empty($block['attrs']['dynamicMetas']['starttime']['repeaterArray'][$repeaterField])) {
							$starttime = GSPB_get_value_from_array_field($repeaterField, $block['attrs']['dynamicMetas']['starttime']['repeaterArray']);
							$starttime = GSPB_field_array_to_value($starttime, ', ');
						} else if ($field) {
							$starttime = GSPB_make_dynamic_from_metas($field);
						}
					}
					if(!$starttime) return '';
					if (ctype_digit($starttime)) {
						$providedDate = DateTime::createFromFormat('U', $starttime);
					} elseif (DateTime::createFromFormat('Y-m-d\TH:i:s', $starttime) !== false) {
						$providedDate = DateTime::createFromFormat('Y-m-d\TH:i:s', $starttime);
					}elseif (DateTime::createFromFormat('Y-m-d H:i:s', $starttime) !== false) {
						$providedDate = DateTime::createFromFormat('Y-m-d H:i:s', $starttime);
					} else {
						$providedDate = DateTime::createFromFormat('Y-m-d', $starttime);
					}
					$currentDate = new DateTime(); 
					if ($currentDate < $providedDate) {
						return "";
					}
					
				}
			}
			wp_enqueue_script('gscountdown');
		}

		// looking for social share
		else if ($blockname === 'greenshift-blocks/social-share') {
			wp_enqueue_script('gsshare');
		}

		// looking for swiper
		else if ($blockname === 'greenshift-blocks/swiper') {
			if (!empty($block['attrs']['smartloader'])) {
				wp_enqueue_script('gs-swiper-loader');
			} else {
				wp_enqueue_script('gsswiper');
				wp_enqueue_script('gs-swiper-init');
			}
		}

		// looking for tabs
		else if ($blockname === 'greenshift-blocks/tabs') {
			if (!empty($block['attrs']['swiper'])) {
				wp_enqueue_style('gsswiper');
				wp_enqueue_script('gsswiper');
			}
			wp_enqueue_script('gstabs');
			//Accesability Improvements
			$p = new WP_HTML_Tag_Processor( $html );
			$itab = 0;
			while ( $p->next_tag() ) {
				// Skip an element if it's not supposed to be processed.
				if ( method_exists('WP_HTML_Tag_Processor', 'has_class') && $p->has_class( 't-panel' ) ) {
					$p->set_attribute( 'id', 'gspb-tab-item-content-'.greenshift_sanitize_id_key($block['attrs']['id']).'-'.$itab);
					$p->set_attribute( 'aria-labelledby', 'gspb-tab-item-btn-'.greenshift_sanitize_id_key($block['attrs']['id']).'-'.$itab);
					$p->set_attribute( 'role', 'tabpanel');
					$p->set_attribute( 'tabindex', '0');
					$itab ++;
				}
			}
			$html = $p->get_updated_html();
		}

		// looking for animated text
		else if ($blockname === 'greenshift-blocks/heading') {
			if (!empty($block['attrs']['enableanimate'])) {
				if(!empty($block['attrs']['animationtype']) && $block['attrs']['animationtype'] === 'typewriter'){
					wp_enqueue_script('gstypewriter');
				}else{
					wp_enqueue_script('gstextanimate');
				}
			}
			if (!empty($block['attrs']['background']['lazy'])) {
				wp_enqueue_script('greenshift-inview-bg');
			}
			if (!empty($block['attrs']['className'])) {
				$html = str_replace('class="gspb_heading', 'class="' . esc_attr($block['attrs']['className']) . ' gspb_heading', $html);
			}
			if (function_exists('GSPB_make_dynamic_text') && !empty($block['attrs']['dynamictext']['dynamicEnable'])) {
				if (!empty($block['attrs']['enableanimate'])) {
					$html = GSPB_make_dynamic_text($html, $block['attrs'], $block, $block['attrs']['dynamictext'], $block['attrs']['textbefore']);
				} else {
					$html = GSPB_make_dynamic_text($html, $block['attrs'], $block, $block['attrs']['dynamictext'], $block['attrs']['headingContent']);
				}
			}
		} else if ($blockname === 'greenshift-blocks/text') {
			if (!empty($block['attrs']['background']['lazy'])) {
				wp_enqueue_script('greenshift-inview-bg');
			}
			if (function_exists('GSPB_make_dynamic_text') && !empty($block['attrs']['dynamictext']['dynamicEnable']) && !empty($block['attrs']['textContent'])) {
				$html = GSPB_make_dynamic_text($html, $block['attrs'], $block, $block['attrs']['dynamictext'], $block['attrs']['textContent']);
			}
		}

		// looking for 3d modelviewer
		else if ($blockname === 'greenshift-blocks/modelviewer') {
			if (function_exists('GSPB_make_dynamic_from_metas') && !empty($block['attrs']['dynamicMetas']['td_url']['dynamicEnable'])) {
				$field = !empty($block['attrs']['dynamicMetas']['td_url']['dynamicField']) ? $block['attrs']['dynamicMetas']['td_url']['dynamicField'] : '';
				$repeaterField = !empty($block['attrs']['dynamicMetas']['td_url']['repeaterField']) ? $block['attrs']['dynamicMetas']['td_url']['repeaterField'] : '';
				if ($repeaterField && !empty($block['attrs']['dynamicMetas']['td_url']['repeaterArray'][$repeaterField])) {
					$td_url = GSPB_get_value_from_array_field($repeaterField, $block['attrs']['dynamicMetas']['td_url']['repeaterArray']);
					$td_url = GSPB_field_array_to_value($td_url, ', ');
				} else if ($field) {
					$td_url = GSPB_make_dynamic_from_metas($field);
				}
				if(!$td_url){return '';}
				$p = new WP_HTML_Tag_Processor( $html );
				if ( $p->next_tag( 'model-viewer' )) {
					$p->set_attribute( 'src', $td_url);
				}
				$html = $p->get_updated_html();
			}
			if (function_exists('GSPB_make_dynamic_from_metas') && !empty($block['attrs']['dynamicMetas']['usdz_url']['dynamicEnable'])) {
				$field = !empty($block['attrs']['dynamicMetas']['usdz_url']['dynamicField']) ? $block['attrs']['dynamicMetas']['usdz_url']['dynamicField'] : '';
				$repeaterField = !empty($block['attrs']['dynamicMetas']['usdz_url']['repeaterField']) ? $block['attrs']['dynamicMetas']['usdz_url']['repeaterField'] : '';
				if ($repeaterField && !empty($block['attrs']['dynamicMetas']['usdz_url']['repeaterArray'][$repeaterField])) {
					$usdz_url = GSPB_get_value_from_array_field($repeaterField, $block['attrs']['dynamicMetas']['usdz_url']['repeaterArray']);
					$usdz_url = GSPB_field_array_to_value($usdz_url, ', ');
				} else if ($field) {
					$usdz_url = GSPB_make_dynamic_from_metas($field);
				}
				$p = new WP_HTML_Tag_Processor( $html );
				if ( $p->next_tag( 'model-viewer' )) {
					$p->set_attribute( 'ios-src', $usdz_url);
				}
				$html = $p->get_updated_html();
			}
			$html = str_replace('ar="true"', 'ar', $html);
			if (empty($block['attrs']['td_load_iter'])) {
				wp_enqueue_script('gsmodelviewer');
			}
			wp_enqueue_script('gsmodelinit');
		}

		//looking for video
		else if ($blockname === 'greenshift-blocks/video') {
			$thumbposter = '';
			if (!empty($block['attrs']['provider']) && $block['attrs']['provider'] === "vimeo") {
				wp_enqueue_script('gsvimeo');
			}
			wp_enqueue_script('gsvideo');
			if (isset($block['attrs']['overlayLightbox']) && $block['attrs']['overlayLightbox']) {
				wp_enqueue_style('gslightbox');
				wp_enqueue_script('gslightbox');
			}
			if (function_exists('GSPB_make_dynamic_video') && !empty($block['attrs']['dynamicEnable'])) {
				$field = !empty($block['attrs']['dynamicField']) ? $block['attrs']['dynamicField'] : '';
				$repeaterField = !empty($block['attrs']['repeaterField']) ? $block['attrs']['repeaterField'] : '';
				$p = new WP_HTML_Tag_Processor( $html );
				if ($repeaterField && !empty($block['attrs']['repeaterArray'][$repeaterField])) {
					$replaced = GSPB_get_value_from_array_field($repeaterField, $block['attrs']['repeaterArray']);
					$replaced = GSPB_field_array_to_value($replaced, ', ');
					if($replaced){
						if ( $p->next_tag( array( 'class_name' => 'gs-video-element' ) ) ) {
							$p->set_attribute( 'data-src', $replaced);
						}
						if ( $p->next_tag( array( 'class_name' => 'gs-video-element' ) ) ) {
							$p->set_attribute( 'data-src', $replaced);
						}
						if($p->next_tag( array( 'tag_name' => 'meta') ) && $p->get_attribute( 'itemprop' ) == 'embedUrl' ) {
							$p->set_attribute( 'content', $replaced);
						}
						//Poster
						if($block['attrs']['provider'] != 'video'){
							if(!empty($block['attrs']['poster'])){
								if(function_exists('gs_parse_video_url')){
									$thumbposter = gs_parse_video_url($replaced, 'maxthumb');
								}
							}
						}
					}else{
						return '';
					}
				} else {
					if ($field) {
						$src = !empty($block['attrs']['src']) ? $block['attrs']['src'] : '';
						$replaced = GSPB_make_dynamic_video($html, $block['attrs'], $block, $field, $src, true);
						if($replaced){
							if ( $p->next_tag( array( 'class_name' => 'gs-video-element' ) ) ) {
								$p->set_attribute( 'data-src', $replaced);
							}
							if($p->next_tag( array( 'tag_name' => 'meta') ) && $p->get_attribute( 'itemprop' ) == 'embedUrl' ) {
								$p->set_attribute( 'content', $replaced);
							}

							//Poster
							if($block['attrs']['provider'] != 'video'){
								if(!empty($block['attrs']['poster'])){
									if(function_exists('gs_parse_video_url')){
										$thumbposter = gs_parse_video_url($replaced, 'maxthumb');
									}
								}
							}

						}else{
							return '';
						}
					}
				}
				$html = $p->get_updated_html();
			}
			if(!empty($block['attrs']['overlayLazy'])){
				$p = new WP_HTML_Tag_Processor( $html );
				if ( $p->next_tag( 'img' )) {
					$p->set_attribute( 'loading', 'lazy');
				}
				$html = $p->get_updated_html();
			}
			if($thumbposter){
				$html = str_replace($block['attrs']['poster'], $thumbposter, $html);
			}
			if(!empty($block['attrs']['disableSmartLoading'])){
				$html = str_replace('data-mute="true"', 'data-mute="true" muted', $html);
				$html = str_replace('data-loop="true"', 'data-loop="true" loop', $html);
				$html = str_replace('data-playsinline="true"', 'data-playsinline="true" playsinline', $html);
				$html = str_replace('data-autoplay="true"', 'data-autoplay="true" autoplay', $html);
				$html = str_replace('data-controls="true"', 'data-controls="true" controls', $html);

			}
		}
		// looking for toggler
		else if ($blockname === 'greenshift-blocks/svgshape' && !empty($block['attrs']['customshape'])) {
			$html = str_replace('strokewidth', 'stroke-width', $html);
			$html = str_replace('strokedasharray', 'stroke-dasharray', $html);
			$html = str_replace('stopcolor', 'stop-color', $html);
		}

		// aos script
		if (!empty($block['attrs']['animation']['type']) && empty($block['attrs']['animation']['usegsap']) && empty($block['attrs']['animation']['onclass_active'])) {
			if(!empty($block['attrs']['animation']['type']) && ($block['attrs']['animation']['type'] == 'display-in' || $block['attrs']['animation']['type'] == 'display-in-slide' || $block['attrs']['animation']['type'] == 'display-in-zoom' || $block['attrs']['animation']['type'] == 'custom' || $block['attrs']['animation']['type'] == 'clip-down' || $block['attrs']['animation']['type'] == 'clip-up' || $block['attrs']['animation']['type'] == 'clip-left' || $block['attrs']['animation']['type'] == 'clip-right' || $block['attrs']['animation']['type'] == 'slide-left' || $block['attrs']['animation']['type'] == 'slide-right' || $block['attrs']['animation']['type'] == 'slide-top' || $block['attrs']['animation']['type'] == 'slide-bottom' )){
				wp_enqueue_script('greenShift-aos-lib-clip');
			}else{
				wp_enqueue_script('greenShift-aos-lib');
			}
			if(!empty($block['attrs']['animation']['onscrub'])){
				wp_enqueue_script('greenshift-scroll-scrub');
			}
			if(!empty($block['attrs']['animation']['onsplit'])){
				wp_enqueue_script('greenshift-split-text');
			}
		}

		//Load polyfills from classes
		if (!empty($block['attrs']['dynamicGClasses'])) {
			foreach ($block['attrs']['dynamicGClasses'] as $class) {
				if(!empty($class['attributes']['styleAttributes']['animationTimeline'])){
					wp_enqueue_script('scroll-view-polyfill');
				}
				if(!empty($class['attributes']['styleAttributes']['anchorName'])){
					wp_enqueue_script('anchor-polyfill');
				}
				if(!empty($class['selectors'])){
					foreach($class['selectors'] as $selector){
						if(!empty($selector['attributes']['styleAttributes']['animationTimeline'])){
							wp_enqueue_script('scroll-view-polyfill');
						}
						if(!empty($selector['attributes']['styleAttributes']['anchorName'])){
							wp_enqueue_script('anchor-polyfill');
						}
					}
				}
			}
		}


		if(!empty($block['attrs']['interactionLayers'])){
			//Animations
			foreach($block['attrs']['interactionLayers'] as $layer){
				$actions = $layer['actions'];
				if(!empty($actions)){
					foreach($actions as $action){
						if(!empty($action['actionname']) && $action['actionname'] == 'animation'){
							wp_enqueue_script('gspb_motion_one');
							if(!empty($action['aprops']) && is_array($action['aprops'])){
								foreach($action['aprops'] as $prop){
									if(!empty($prop['type']) && $prop['type'] == 'easing' && !empty($prop['value']) && $prop['value'] == 'spring'){
										wp_enqueue_script('gspb_motion_spring');
									}
								}
							}
						}
						if(!empty($action['actionname']) && $action['actionname'] == 'customapi'){
							wp_enqueue_script('gspb_api');
						}
					}
				}
			}
			//Interactions script
			wp_enqueue_script('gspb_interactions');

			//Other scripts
			foreach($block['attrs']['interactionLayers'] as $layer){
				$actions = $layer['actions'];
				if(!empty($actions)){
					foreach($actions as $action){
						if(!empty($action['actionname']) && $action['actionname'] == 'lightbox'){
							wp_enqueue_script('gs-lightbox');
						}
						if(!empty($action['actionname']) && ($action['actionname'] == 'panel' || $action['actionname'] == 'popup')){
							wp_enqueue_script('gs-greenpanel');
						}
						if(!empty($action['actionname']) && ($action['actionname'] == 'popover')){
							wp_add_inline_script('gspb_interactions', '
							let popovers = document.querySelectorAll("[popover-control]");
							if(popovers && popovers.length > 0){
								popovers.forEach(popover => {
									let actions = popover.getAttribute("data-gspbactions");
									let trigger = "";
									if(actions){
										actions = JSON.parse(actions);
										actions.forEach(action => {
											if(action?.actions){
												action.actions.forEach(subaction => {
													if(subaction?.actionname === "popover" && action?.triggerData?.trigger){
														trigger = action.triggerData.trigger;
													}
												});
											}
										});
									}
									let targetselector = popover.getAttribute("popover-control");
									let target = document.getElementById(targetselector);
									if(trigger == "mouse-enter"){
										popover.addEventListener("mouseleave", (event) => {
											popover.classList.remove("gs-popover-open");
											if(target){
												target.classList.remove("active");
												target.hidePopover();
											}
										});
										let windowWidth = window.innerWidth;
										if(windowWidth < 768){
											popover.addEventListener("click", (event) => {
												popover.classList.toggle("gs-popover-open");
												if(target){
													target.classList.toggle("active");
													target.togglePopover();
												}
											});
										}
									}
									document.addEventListener("keydown", (event) => {
										if(event.key === "Escape"){
											popover.classList.remove("gs-popover-open");
											if(target){
												target.classList.remove("active");
												target.hidePopover();
											}
										}
									});
								});
							}
							');
						}
					}
				}
			}
		}
	}

	return $html;
}
function gspb_greenShift_block_inline_styles($html, $block){
	if (!is_admin()) {

		if (!empty($block['attrs']['dynamicGClasses'])) {
			foreach ($block['attrs']['dynamicGClasses'] as $class) {
				if(!empty($class['type'])){
					$type = $class['type'];
					if($type == 'preset' && !empty($class['value'])){
						$css = greenshift_get_style_from_class_array($class['value'], $type, $inline = true);
						if($css){
							$class_style = $css;
							$class_style = gspb_get_final_css($class_style);
							$class_style = htmlspecialchars_decode($class_style);
							$class_style = '<style>' . wp_strip_all_tags($class_style) . '</style>';
							$html = $html . $class_style;
						}
					}
				}
			}
		}

		if (!empty($block['attrs']['inlineCssStyles']) || ($block['blockName'] == 'core/block' && !empty($block['attrs']['ref'])) ) {
			if($block['blockName'] == 'core/block' && !empty($block['attrs']['ref'])){
				$dynamic_style = get_post_meta((int)$block['attrs']['ref'], '_gspb_post_css', true);
				$dynamic_style = apply_filters('gspb_reusable_inline_styles', $dynamic_style);
			}else{
				$dynamic_style = $block['attrs']['inlineCssStyles'];
			}
			$dynamic_style = gspb_get_final_css($dynamic_style);
			$dynamic_style = gspb_quick_minify_css($dynamic_style);
			$dynamic_style = htmlspecialchars_decode($dynamic_style);
			if (function_exists('GSPB_make_dynamic_image') && !empty($block['attrs']['background']['dynamicEnable'])) {
				$dynamic_style = GSPB_make_dynamic_image($dynamic_style, $block['attrs'], $block, $block['attrs']['background'], $block['attrs']['background']['image']);
			}
			$dynamic_style = '<style>' . wp_strip_all_tags($dynamic_style) . '</style>';
			$html = $dynamic_style . $html;
		}
	}
	return $html;
}
function gspb_greenShift_block_inline_head($html, $block){
	if (!is_admin()) {

		if (!empty($block['attrs']['dynamicGClasses'])) {
			foreach ($block['attrs']['dynamicGClasses'] as $class) {
				if(!empty($class['type'])){
					$type = $class['type'];
					if(($type == 'preset' || $type == 'global') && !empty($class['value'])){
						$css = greenshift_get_style_from_class_array($class['value'], $type, $inline = false);
						if($css){
							$class_style = '<style>' . wp_kses_post($css) . '</style>';
							$class_style = gspb_get_final_css($class_style);
							$class_style = htmlspecialchars_decode($class_style);
							$html = $html . $class_style;
						}
					}
				}
			}
		}

		if (!empty($block['attrs']['inlineCssStyles']) || ($block['blockName'] == 'core/block' && !empty($block['attrs']['ref'])) ) {
			$styleStore = GreenShiftStyleStore::getInstance();
			if($block['blockName'] == 'core/block' && !empty($block['attrs']['ref'])){
				$dynamic_style = get_post_meta((int)$block['attrs']['ref'], '_gspb_post_css', true);
			}else{
				$dynamic_style = wp_kses_post($block['attrs']['inlineCssStyles']);
			}
			$dynamic_style = gspb_get_final_css($dynamic_style);
			$dynamic_style = gspb_quick_minify_css($dynamic_style);
			$dynamic_style = htmlspecialchars_decode($dynamic_style);
			if (function_exists('GSPB_make_dynamic_image') && !empty($block['attrs']['background']['dynamicEnable'])) {
				$dynamic_style = GSPB_make_dynamic_image($dynamic_style, $block['attrs'], $block, $block['attrs']['background'], $block['attrs']['background']['image']);
			}
			if($block['blockName'] == 'core/block' && !empty($block['attrs']['ref'])){
				$styleStore->addClassStyle('ref_'.greenshift_sanitize_id_key($block['attrs']['ref']), $dynamic_style);
			}else{
				$styleStore->addClassStyle(greenshift_sanitize_id_key($block['attrs']['id']), $dynamic_style);
			}
			//echo $styleStore->getStyles();
		}
	}
	return $html;
}

//////////////////////////////////////////////////////////////////
// Enqueue Gutenberg block assets for backend editor.
//////////////////////////////////////////////////////////////////



// Hook: Editor assets.
add_action('enqueue_block_editor_assets', 'gspb_greenShift_editor_assets');

function gspb_greenShift_editor_assets()
{
	// phpcs:ignor

	$index_asset_file = include(GREENSHIFT_DIR_PATH . 'build/index.asset.php');
	$library_asset_file = include(GREENSHIFT_DIR_PATH . 'build/gspbLibrary.asset.php');

	wp_register_script(
		'greenShift-site-editor-js',
		GREENSHIFT_DIR_URL . 'build/gspbSiteEditor.js',
		array('greenShift-library-script','wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-data', 'wp-plugins'),
		$library_asset_file['version'],
		false
	);
	wp_set_script_translations('greenShift-site-editor-js', 'greenshift-animation-and-page-builder-blocks');
	wp_enqueue_script('greenShift-site-editor-js');

	// gspb library script
	wp_register_script(
		'greenShift-library-script',
		GREENSHIFT_DIR_URL . 'build/gspbLibrary.js',
		array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-data', 'wp-plugins'),
		$library_asset_file['version'],
		false
	);
	wp_set_script_translations('greenShift-library-script', 'greenshift-animation-and-page-builder-blocks');

	// Custom Editor JavaScript
	wp_register_script(
		'greenShift-editor-js',
		GREENSHIFT_DIR_URL . 'build/gspbCustomEditor.js',
		array('greenShift-library-script', 'jquery', 'wp-data', 'wp-element'),
		$index_asset_file['version'],
		true
	);
	wp_set_script_translations('greenShift-editor-js', 'greenshift-animation-and-page-builder-blocks');

	$gspb_css_save = get_option('gspb_css_save');
	$sitesettings = get_option('gspb_global_settings');
	$row = (!empty($sitesettings['breakpoints']['row'])) ? (int)$sitesettings['breakpoints']['row'] : 1200;
	$localfont = (!empty($sitesettings['localfont'])) ? $sitesettings['localfont'] : array();
	$googleapi = (!empty($sitesettings['googleapi'])) ? esc_attr($sitesettings['googleapi']) : '';
	$default_attributes = (!empty($sitesettings['default_attributes'])) ? $sitesettings['default_attributes'] : '';
	$global_classes = (!empty($sitesettings['global_classes'])) ? $sitesettings['global_classes'] : [];
	$global_interactions = (!empty($sitesettings['global_interactions'])) ? $sitesettings['global_interactions'] : [];
	$framework_classes = (!empty($sitesettings['framework_classes'])) ? $sitesettings['framework_classes'] : [];
	$preset_classes = greenshift_render_preset_classes();
	$global_variables = (!empty($sitesettings['variables'])) ? $sitesettings['variables'] : [];
	$colours = (!empty($sitesettings['colours'])) ? $sitesettings['colours'] : '';
	$elements = (!empty($sitesettings['elements'])) ? $sitesettings['elements'] : '';
	$gradients = (!empty($sitesettings['gradients'])) ? $sitesettings['gradients'] : '';
	$hide_local_styles = (!empty($sitesettings['hide_local_styles'])) ? $sitesettings['hide_local_styles'] : '';
	$row_padding_disable = (!empty($sitesettings['row_padding_disable'])) ? $sitesettings['row_padding_disable'] : '';
	$default_unit = (!empty($sitesettings['default_unit'])) ? $sitesettings['default_unit'] : '';
	$variables = greenshift_render_variables($global_variables);
	$addonlink = admin_url('admin.php?page=greenshift_upgrade');
	$show_element_block = (!empty($sitesettings['show_element_block'])) ? $sitesettings['show_element_block'] : '';
	$simplified_panels = (!empty($sitesettings['simplified_panels'])) ? $sitesettings['simplified_panels'] : '';
	if($simplified_panels){
		if(!current_user_can('manage_options')){
			$simplified_panels = true;
		}else{
			$simplified_panels = false;
		}
	}
	$updatelink = $addonlink;
	$theme = wp_get_theme();
	if ($theme->parent_theme) {
		$template_dir =  basename(get_template_directory());
		$theme = wp_get_theme($template_dir);
	}
	$themename = $theme->get('TextDomain');
	$local_wp_fonts = greenshift_get_wp_local_fonts();

	//Framework custom classes
	$custom_options = [];
	$custom_options = apply_filters('greenshift_framework_classes', $custom_options);
	if(!empty($custom_options)){
		$preset_classes = array_merge($preset_classes, $custom_options);
	}

	//Core Framework Utility
	$cf_utility_on = !empty($sitesettings['cf_utility_on']) ? $sitesettings['cf_utility_on'] : '';
	if($cf_utility_on && class_exists('CoreFramework\Helper')){
		//$cf_classes = get_option('core_framework_grouped_classes');
		$cf_classes = false; // removing this option in favor of CF core component
		if(!empty($cf_classes)){
			foreach($cf_classes as $cf_sections){
				if(!empty($cf_sections)){
					foreach ($cf_sections as $key=>$section){
						$array_classes = [];
						if(!empty($section)){
							$unique_classes = array_unique($section);
							foreach ($unique_classes as $class){
								$array_classes[] = [
									'value'=> $class,
									'label'=> $class,
									'type' => "framework"
								];
							}
							if(!empty($array_classes)){
								$preset_classes[] = [
									'label' => $key,
									'options' => $array_classes
								];
							}
						}
					}
				}
			}
		}

		$helper = new CoreFramework\Helper(); 
		$variablesCF = $helper->getVariables();
		$variablesCFArray = [];
    
		foreach ($variablesCF as $key => $value) {
			switch ($key) {
				case 'colorStyles':
					foreach ($value as $item) {
						$variablesCFArray[] = [
							'label' => ucfirst($item),
							'value' => 'var(--' . $item . ')',
							'variable' => '--' . $item,
							'variable_value' => '',  // You can add actual value here if available
							'group' => 'color'
						];
					}
					break;
					
				case 'typographyStyles':
					foreach ($value as $item) {
						$variablesCFArray[] = [
							'label' => strtoupper(str_replace('text-', '', $item)) . '',
							'value' => 'var(--' . $item . ')',
							'variable' => '--' . $item,
							'variable_value' => '',  // You can add actual value here if available
							'group' => 'size'
						];
					}
					break;
					
				case 'spacingStyles':
					foreach ($value as $item) {
						$size = strtoupper(str_replace('space-', '', $item));
						$variablesCFArray[] = [
							'label' => $size,
							'value' => 'var(--' . $item . ')',
							'variable' => '--' . $item,
							'variable_value' => '',  // You can add actual value here if available
							'group' => 'spacing'
						];
					}
					break;
					
				case 'designStyles':
					foreach ($value as $item) {
						$variablesCFArray[] = [
							'label' => ucfirst($item),
							'value' => 'var(--' . $item . ')',
							'variable' => '--' . $item,
							'variable_value' => '',  // You can add actual value here if available
							'group' => 'design'
						];
					}
					break;
					
				case 'layoutsStyles':
					foreach ($value as $item) {
						$variablesCFArray[] = [
							'label' => ucfirst($item),
							'value' => 'var(--' . $item . ')',
							'variable' => '--' . $item,
							'variable_value' => '',  // You can add actual value here if available
							'group' => 'layout'
						];
					}
					break;
					
				case 'componentsStyles':
					foreach ($value as $item) {
						$variablesCFArray[] = [
							'label' => ucfirst($item),
							'value' => 'var(--' . $item . ')',
							'variable' => '--' . $item,
							'variable_value' => '',  // You can add actual value here if available
							'group' => 'component'
						];
					}
					break;
					
				case 'otherStyles':
					foreach ($value as $item) {
						$variablesCFArray[] = [
							'label' => ucfirst($item),
							'value' => 'var(--' . $item . ')',
							'variable' => '--' . $item,
							'variable_value' => '',  // You can add actual value here if available
							'group' => 'other'
						];
					}
					break;
					
				default:
					foreach ($value as $item) {
						$variablesCFArray[] = [
							'label' => ucfirst($item),
							'value' => 'var(--' . $item . ')',
							'variable' => '--' . $item,
							'variable_value' => '',  // You can add actual value here if available
							'group' => 'extra'
						];
					}
					// Do nothing for keys without specified group
					break;
			}
		}

		if(!empty($variablesCFArray)){
			$variables = array_merge($variables, $variablesCFArray);
		}
	}

	$stylebook_post_id = get_option( 'gspb_stylebook_id' );
	if( $stylebook_post_id ){
		$stylebook_url = get_edit_post_link( $stylebook_post_id );
		if(!$stylebook_url){
			$stylebook_url = admin_url('admin.php?page=greenshift_stylebook');
		}
	}else{
		$stylebook_url = admin_url('admin.php?page=greenshift_stylebook');
	}

	//$updatelink = str_replace('greenshift_dashboard-addons', 'greenshift_dashboard-pricing', $addonlink);
	wp_localize_script(
		'greenShift-library-script',
		'greenShift_params',
		array(
			'ajaxUrl' => admin_url('admin-ajax.php'),
			'pluginURL' => GREENSHIFT_DIR_URL,
			'rowDefault' => apply_filters('gspb_default_row_width_px', $row),
			'theme' => $themename,
			'isRehub' => ($themename == 'rehub-theme'),
			'isSaveInline' => (!empty($gspb_css_save) && $gspb_css_save == 'inlineblock') ? '1' : '',
			'default_attributes' => $default_attributes,
			'addonLink' => $addonlink,
			'updateLink' => $updatelink,
			'localfont' => apply_filters('gspb_local_font_array', $localfont),
			'googleapi' => apply_filters('gspb_google_api_key', $googleapi),
			'global_classes' => apply_filters('gspb_global_classes', $global_classes),
			'global_interactions' => apply_filters('gspb_global_interactions', $global_interactions),
			'framework_classes' => apply_filters('gspb_framework_classes', $framework_classes),
			'preset_classes' => $preset_classes,
			'colours' => $colours,
			'elements' => $elements,
			'variables' => $variables,
			'gradients' => $gradients,
			'enabledcroll' => (function_exists('greenshift_check_cron_exec')) ? '1' : '',
			'stylebook_url' => $stylebook_url,
			'hide_local_styles' => $hide_local_styles,
			'simplified_panels' => $simplified_panels,
			'row_padding_disable' => $row_padding_disable,
			'show_element_block' => $show_element_block,
			'default_unit' => $default_unit,
			'local_wp_fonts' => $local_wp_fonts,
			'nonce' => wp_create_nonce('gspb_nonce'),
		)
	);

	// Blocks Assets Scripts
	wp_register_script(
		'greenShift-block-js', // Handle.
		GREENSHIFT_DIR_URL . 'build/index.js',
		array('greenShift-editor-js', 'greenShift-library-script', 'wp-block-editor', 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-data'),
		$index_asset_file['version'],
		true
	);
	wp_set_script_translations('greenShift-block-js', 'greenshift-animation-and-page-builder-blocks');
	wp_enqueue_script('greenShift-block-js');

	if('gspbstylebook' == get_post_type()){
		wp_enqueue_script('greenShift-stylebook-js', GREENSHIFT_DIR_URL . 'build/gspbStylebook.js', array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-data'), $index_asset_file['version'], true);
		wp_set_script_translations('greenShift-stylebook-js', 'greenshift-animation-and-page-builder-blocks');
	}

	//wp_enqueue_script('anchor-polyfill');
	//wp_enqueue_script('scroll-view-polyfill');

}


//////////////////////////////////////////////////////////////////
// Helper Functions to save conditional assets to meta
//////////////////////////////////////////////////////////////////

// Meta Data For CSS Post.

function gspb_register_post_meta()
{
	register_meta(
		'post',
		'_gspb_post_css',
		array(
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'string',
			'auth_callback' => function () {
				return current_user_can('edit_posts');
			}
		)
	);
}
add_action('init', 'gspb_register_post_meta', 10);

add_action('wp_enqueue_scripts', 'gspb_save_inline_css', apply_filters('greenshift_dynamic_css_priority', 10));
function gspb_save_inline_css()
{
	// Get the css registred for the post
	$post_id          = get_queried_object_id();
	$gspb_css_content = get_post_meta($post_id, '_gspb_post_css', true);

	if ($gspb_css_content) {
		$gspb_saved_css_content = gspb_get_final_css($gspb_css_content);
		$final_css = $gspb_saved_css_content;

		wp_register_style('greenshift-post-css', false);
		wp_enqueue_style('greenshift-post-css');
		wp_add_inline_style('greenshift-post-css', $final_css);
	}
}

//PolyLang Fix
add_filter('pll_copy_post_metas', 'gspb_exclude_specific_meta_field', 999, 4);
function gspb_exclude_specific_meta_field($metas, $sync, $from, $to) {
    // Check if the specified meta field is present in the array
    if (in_array('_gspb_post_css', $metas)) {
        // Remove the specified meta field from the array
        unset($metas[array_search('_gspb_post_css', $metas)]);
    }
    return $metas;
}

//////////////////////////////////////////////////////////////////
// Global assets init
//////////////////////////////////////////////////////////////////

add_action('enqueue_block_assets', 'gspb_global_assets');
function gspb_global_assets()
{

	//root styles
	$options = get_option('gspb_global_settings');
	$gs_global_css = '';
			
	if (!is_admin()) {
		//Front assets

		//Custom CSS
		if (!empty($options['custom_css'])) {
			$custom_css = $options['custom_css'];
			$gs_global_css = $gs_global_css . $custom_css;
		}
		
		//Local fonts
		if (!empty($options['localfontcss'])) {
			$gs_global_css = $gs_global_css . $options['localfontcss'];
		}

		//Colors
		if (!empty($options['colours'])) {
			$color_css = ':root{';
			foreach ($options['colours'] as $key=>$element) {
				if (!empty($element)) {
					$color_css .= '--gs-color'.$key . ':' . $element . ';';
				}
			}
			$color_css .= '}';
			$gs_global_css = $gs_global_css . $color_css;
		}

		//Dark mode colors
		if (!empty($options['darkmodecolors'])) {
			$dark_color_css = ':root[data-color-mode*="dark"], body.darkmode{';
			foreach ($options['darkmodecolors'] as $key=>$element) {
				if (!empty($element)) {
					$dark_color_css .= $key . ':' . $element . ';';
				}
			}
			$dark_color_css .= '}';
			$gs_global_css = $gs_global_css . $dark_color_css;
		}

		//Gradients
		if (!empty($options['gradients'])) {
			$gradient_css = ':root{';
			foreach ($options['gradients'] as $key=>$element) {
				if (!empty($element)) {
					$gradient_css .= '--gs-gradient'.$key . ':' . $element . ';';
				}
			}
			$gradient_css .= '}';
			$gs_global_css = $gs_global_css . $gradient_css;
		}

		//Elements
		if (!empty($options['elements'])) {
			foreach ($options['elements'] as $element) {
				if (!empty($element['css'])) {
					$gs_global_css = $gs_global_css . $element['css'];
				}
			}
		}

		//Variables
		$variablearray = !empty($options['variables']) ? $options['variables'] : '';
		$variables = greenshift_render_variables($variablearray);
		if(!empty($variables)){
			$variables_css = '';
			foreach ($variables as $key=>$variable) {
				if (!empty($variable['variable']) && !empty($variable['variable_value'])) {
					$variables_css .= $variable['variable'] . ':' . $variable['variable_value'] . ';';
				}
			}
			if($variables_css){
				$variables_css = ':root{'.$variables_css.'}';
				$gs_global_css = $gs_global_css . $variables_css;
			}
		}

		//Global classes if we don't use Merged Inline Option
		$global_classes = !empty($options['global_classes']) ? $options['global_classes'] : '';
		$enable_head_inline = !empty($options['enable_head_inline']) ? $options['enable_head_inline'] : '';
		if(!empty($global_classes) && !$enable_head_inline){
			$global_class_style = '';
			foreach ($global_classes as $class) {
				if(!empty($class['css'])){
					$global_class_style .= $class['css'];
				}
				if(!empty($class['selectors'])){
					foreach ($class['selectors'] as $selector) {
						if(!empty($selector['css'])){
							$global_class_style .= $selector['css'];
						}
					}
				}
			}
			if($global_class_style){
				$gs_global_css = $gs_global_css . $global_class_style;
			}
		}
	
		if ($gs_global_css) {
			$gs_global_css = gspb_get_final_css($gs_global_css);
			$gs_global_css = gspb_quick_minify_css($gs_global_css);
			$gs_global_css = htmlspecialchars_decode($gs_global_css);
			wp_register_style('greenshift-global-css', false);
			wp_enqueue_style('greenshift-global-css');
			wp_add_inline_style('greenshift-global-css', $gs_global_css);
		}

		//Style presets and global class render if we use Merged Inline Option
		$styleStore = GreenShiftStyleStore::getInstance();
		$styles = $styleStore->renderStyles();
		$classstyles = $styleStore->renderClassStyles();
		if($styles || $classstyles){
			$styles = $styles . $classstyles;
			wp_register_style('greenshift-style-presets', false);
			wp_enqueue_style('greenshift-style-presets');
			wp_add_inline_style('greenshift-style-presets', $styles);
		}

		if (!empty($options['global_interactions']) && is_array($options['global_interactions'])) {
			$has_value = false;			
			$script = '';
			foreach ($options['global_interactions'] as $index => $value) {
				if(!empty($value)){
					$has_value = true;
					$script .= 'GSPB_Trigger_Actions("front", document.querySelectorAll(".'.esc_attr($index).'"), window, document, null, \''.json_encode($value).'\');';
				}
			}
			if($has_value){
				wp_enqueue_script('gspb_motion_one');
				wp_enqueue_script('gspb_interactions');
				wp_add_inline_script('gspb_interactions', $script, 'after');
			}
		}

	}else{
		//Here we inject our scripts into editor > WP 6.3

		$stylesrender = '';

		$hidelandscape = apply_filters('greenshift_hide_landscape_breakpoint', false);
		if($hidelandscape){
			if(empty($options['enable_landscape'])){
				$stylesrender .= '.gspb_inspector_device-icons__icon[data-device="landscape-mobile"], .gspb_inspector_toggle_landscapemobile_hide{display:none !important;}';
			}
		}

		if (!empty($options['custom_css'])) {
			$custom_css = $options['custom_css'];
			$gs_global_css = $gs_global_css . $custom_css;
		}

		if (!empty($options['localfontcss'])) {
			$gs_global_css = $gs_global_css . $options['localfontcss'];
		}
	
		if ($gs_global_css) {
			$gs_global_css = gspb_get_final_css($gs_global_css);
			$stylesrender .= $gs_global_css;
		}

		$presets = greenshift_render_preset_classes();
		foreach ($presets as $key=>$option) {
			if(!empty($option['options']) && is_array($option['options'])){
				foreach ($option['options'] as $class) {
					if(!empty($class['css'])){
						$stylesrender .= $class['css'];
					}
				}
			}
		}

		if($stylesrender){
			wp_register_style('greenshift-editor-css', false);
			wp_enqueue_style('greenshift-editor-css');
			wp_add_inline_style('greenshift-editor-css', $stylesrender);
		}

		$global_classes = !empty($options['global_classes']) ? $options['global_classes'] : '';
		if(!empty($global_classes)){
			foreach ($global_classes as $class) {
				$global_class_style = '';
				$global_class_value = '';
				if(!empty($class['value'])){
					$global_class_value = $class['value'];
				}	
				if(!empty($class['css'])){
					$global_class_style .= $class['css'];
				}
				if(!empty($class['selectors'])){
					foreach ($class['selectors'] as $selector) {
						if(!empty($selector['css'])){
							$global_class_style .= $selector['css'];
						}
					}
				}
				if(!empty($global_class_style) && $global_class_value){
					$cleanTopvalue = preg_replace('/[^a-zA-Z0-9]/', '', $global_class_value);

					wp_register_style('greenshift-global-class-id-'.$cleanTopvalue, false);
					wp_enqueue_style('greenshift-global-class-id-'.$cleanTopvalue);
					wp_add_inline_style('greenshift-global-class-id-'.$cleanTopvalue, $global_class_style);

				}
			}
		}

		if (!empty($options['elements'])) {
			foreach ($options['elements'] as $key=>$element) {
				if (!empty($element['admincss'])) {
					$element_css =  $element['admincss'];
					wp_register_style('greenshift-global-element-id-'.$key, false);
					wp_enqueue_style('greenshift-global-element-id-'.$key);
					wp_add_inline_style('greenshift-global-element-id-'.$key, $element_css);
				}
			}
		}

		if (!empty($options['colours'])) {
			$color_css = 'body{';
			foreach ($options['colours'] as $key=>$element) {
				if (!empty($element)) {
					$color_css .= '--gs-color'.$key . ':' . $element . ';';
				}
			}
			$color_css .= '}';
			wp_register_style('greenshift-global-colors', false);
			wp_enqueue_style('greenshift-global-colors');
			wp_add_inline_style('greenshift-global-colors', $color_css);
		}

		if (!empty($options['darkmodecolors'])) {
			$nightcolor_css = ':root[data-color-mode*="dark"], body.darkmode, .editor-styles-wrapper:has(.gspb_inspector_btn--darkmode--active),
			body:has(.gspb_inspector_btn--darkmode--active) .editor-styles-wrapper{';
			foreach ($options['darkmodecolors'] as $key=>$element) {
				if (!empty($element)) {
					$nightcolor_css .= $key . ':' . $element . ';';
				}
			}
			$nightcolor_css .= '}';
			wp_register_style('greenshift-global-night-colors', false);
			wp_enqueue_style('greenshift-global-night-colors');
			wp_add_inline_style('greenshift-global-night-colors', $nightcolor_css);
		}

		if (!empty($options['gradients'])) {
			$gradient_css = 'body{';
			foreach ($options['gradients'] as $key=>$element) {
				if (!empty($element)) {
					$gradient_css .= '--gs-gradient'.$key . ':' . $element . ';';
				}
			}
			$gradient_css .= '}';
			wp_register_style('greenshift-global-gradients', false);
			wp_enqueue_style('greenshift-global-gradients');
			wp_add_inline_style('greenshift-global-gradients', $gradient_css);
		}

		$variablearray = !empty($options['variables']) ? $options['variables'] : '';
		$variables = greenshift_render_variables($variablearray);
		if(!empty($variables)){
			$variables_css = '';
			foreach ($variables as $key=>$variable) {
				if (!empty($variable['variable']) && !empty($variable['variable_value'])) {
					$variables_css .= $variable['variable'] . ':' . $variable['variable_value'] . ';';
				}
			}
			if($variables_css){
				$variables_css = ':root{'.$variables_css.'}';
				wp_register_style('greenshift-global-variables', false);
				wp_enqueue_style('greenshift-global-variables');
				wp_add_inline_style('greenshift-global-variables', $variables_css);
			}
		}

		//Swiper lib
		wp_enqueue_script('gsswiper');
		//animated text
		wp_enqueue_script('gstextanimate');
		// interactions
		wp_enqueue_script('gspb_motion_spring');
		wp_enqueue_script('gspb_motion_one');
		wp_enqueue_script('gspb_interactions');


		if (!empty($options['global_interactions']) && is_array($options['global_interactions'])) {
			$has_value = false;			
			$script = '';
			foreach ($options['global_interactions'] as $index => $value) {
				if(!empty($value)){
					$has_value = true;
					$script .= 'GSPB_Trigger_Actions("front", document.querySelectorAll(".'.esc_attr($index).'"), window, document, null, \''.json_encode($value).'\');';
				}
			}
			if($has_value){
				wp_add_inline_script('gspb_interactions', $script, 'after');
			}
		}

		if(!empty($options['dark_accent_scheme'])){
			wp_enqueue_style('greenShift-dark-accent-css', GREENSHIFT_DIR_URL . 'templates/admin/dark_accent_ui.css', array(), '1.0');
		}
	}
}

//////////////////////////////////////////////////////////////////
// REST routes to save and get settings
//////////////////////////////////////////////////////////////////

function greenshift_app_pass_validation( $request ) {
    // Verify the application password
    if ( wp_validate_application_password(false) ) {
        // Application password is valid, grant access
        return true;
    } else {
        // Application password is invalid, deny access
        return new WP_Error( 'rest_forbidden', esc_html__( 'Invalid application password.', 'greenshift-animation-and-page-builder-blocks' ), array( 'status' => 401 ) );
    }
}

add_action('rest_api_init', 'gspb_register_route');
function gspb_register_route()
{

	register_rest_route(
		'greenshift/v1',
		'/global_settings/',
		array(
			array(
				'methods'             => 'GET',
				'callback'            => 'gspb_get_global_settings',
				'permission_callback' => function () {
					return current_user_can('manage_options');
				},
				'args'                => array(),
			),
			array(
				'methods'             => 'POST',
				'callback'            => 'gspb_update_global_settings',
				'permission_callback' => function () {
					return current_user_can('manage_options');
				},
				'args'                => array(),
			),
		)
	);

	register_rest_route(
		'greenshift/v1',
		'/public_assets/',
		array(
			array(
				'methods'             => 'GET',
				'callback'            => 'gspb_get_public_assets',
				'permission_callback' => function () {
					return true;
				},
				'args'                => array(),
			),
		)
	);

	register_rest_route(
		'greenshift/v1',
		'/figma_settings/',
		array(
			array(
				'methods'             => 'GET',
				'callback'            => 'gspb_get_global_settings',
				'permission_callback' => 'greenshift_app_pass_validation',
				'args'                => array(),
			),
			array(
				'methods'             => 'GET',
				'callback'            => 'gspb_get_license_settings',
				'permission_callback' => 'greenshift_app_pass_validation',
				'args'                => array(),
			),
			array(
				'methods'             => 'POST',
				'callback'            => 'gspb_update_global_settings',
				'permission_callback' => 'greenshift_app_pass_validation',
				'args'                => array(),
			),
		)
	);

	register_rest_route(
		'greenshift/v1',
		'/license_settings/',
		array(
			array(
				'methods'             => 'GET',
				'callback'            => 'gspb_get_license_settings',
				'permission_callback' => 'greenshift_app_pass_validation',
				'args'                => array(),
			),
		)
	);

	register_rest_route(
		'greenshift/v1',
		'/css_settings/',
		array(
			array(
				'methods'             => 'POST',
				'callback'            => 'gspb_update_css_settings',
				'permission_callback' => function () {
					return current_user_can('edit_posts');
				},
				'args'                => array(),
			),
		)
	);

	register_rest_route(
		'greenshift/v1',
		'/global_wp_settings/',
		array(
			array(
				'methods'             => 'POST',
				'callback'            => 'gspb_update_global_wp_settings',
				'permission_callback' => function () {
					return current_user_can('edit_posts');
				},
				'args'                => array(),
			),
		)
	);

	register_rest_route('greenshift/v1', '/convert-svgstring-from-svg-image/', [
		[
			'methods' => 'GET',
			'callback' => 'gspb_convert_svgstring_from_svg_image',
			'permission_callback' => function (WP_REST_Request $request) {
				return current_user_can('edit_posts');
			},
			'args' => array(
				'imageid' => array(
					'type' => 'string',
					'required' => true,
				)
			),
		]
	]);

}

function gspb_get_license_settings()
{

	try {
		$licenses = greenshift_edd_check_all_licenses();
		return array(
			'success'  => true,
			'license' => $licenses
		);
	} catch (Exception $e) {
		return array(
			'success' => false,
			'message' => $e->getMessage(),
		);
	}
}

function gspb_get_global_settings()
{

	try {
		$settings = get_option('gspb_global_settings');
		return array(
			'success'  => true,
			'settings' => $settings
		);
	} catch (Exception $e) {
		return array(
			'success' => false,
			'message' => $e->getMessage(),
		);
	}
}

function gspb_get_public_assets()
{
	try {
		$settings = get_option('gspb_global_settings');
		$assets = [];
		$assets['colours'] = !empty($settings['colours']) ? $settings['colours'] : [];
		$assets['gradients'] = !empty($settings['gradients']) ? $settings['gradients'] : [];
		$assets['localfont'] = !empty($settings['localfont']) ? $settings['localfont'] : [];
		$assets['localfontcss'] = !empty($settings['localfontcss']) ? $settings['localfontcss'] : [];
		$assets['elements'] = !empty($settings['elements']) ? $settings['elements'] : [];

		return array(
			'success'  => true,
			'settings' => $assets,
		);
	} catch (Exception $e) {
		return array(
			'success' => false,
			'message' => $e->getMessage(),
		);
	}
}

function gspb_update_global_settings($request)
{

	try {
		$params = $request->get_params();
		$defaults = get_option('gspb_global_settings');
		$settings = '';

		if ($defaults === false) {
			add_option('gspb_global_settings', $params);
			$settings = $params;
		} else {
			$newargs = wp_parse_args($params, $defaults);
			update_option('gspb_global_settings', $newargs);
			$settings = $newargs;
		}

		if(!empty($params['global_classes'])){
			$default_global_classes = get_option('greenshift_global_classes');
			if ($default_global_classes === false) {
				add_option('greenshift_global_classes', $params['global_classes']);
			} else {
				update_option('greenshift_global_classes', $params['global_classes']);
			}
		}

		$upload_dir = wp_upload_dir();
		require_once ABSPATH . 'wp-admin/includes/file.php';
		global $wp_filesystem;
		$dir = trailingslashit($upload_dir['basedir']) . 'GreenShift/'; // Set storage directory path
		WP_Filesystem(); // WP file system
		if (!$wp_filesystem->is_dir($dir)) {
			$wp_filesystem->mkdir($dir);
		}

		$gspb_json_filename = 'settings_backup.json';
		$gspb_backup_data = json_encode( $settings, JSON_PRETTY_PRINT );

		if (!$wp_filesystem->put_contents($dir . $gspb_json_filename, $gspb_backup_data)) {
			throw new Exception(__('JSON is not saved due the permission!!!', 'greenshift-animation-and-page-builder-blocks'));
		}

		if(!empty($params['figma_fonts'])){
			$figma_fonts = $params['figma_fonts'];
			$localfont = !empty($defaults['localfont']) ? json_decode($defaults['localfont'], true) : [];
			$localfontcss = !empty($defaults['localfontcss']) ? $defaults['localfontcss'] : '';
			$newfonts = false;

			foreach($figma_fonts as $key=>$value){
				$fontName = !empty($value['fontFamily']) ? $value['fontFamily'] : '';
				if(!$fontName || in_array($fontName, $localfont)){
					continue;
				}
				$fontFile = !empty($value['fontFile']) ? $value['fontFile'] : '';
				if(!$fontFile){
					continue;
				}
				$fontExtension = pathinfo($value['fontFile'], PATHINFO_EXTENSION);
				$allowed_font_ext = [
					'woff2',
					'woff',
					'tiff',
					'ttf',
				]; 
				if(!$fontExtension || !in_array($fontExtension, $allowed_font_ext)){
					continue;
				}


				$newfilename = basename($fontFile);
				$ext = $fontExtension;
		
				if ($newfilename = greenshift_download_file_localy($fontFile, $dir, $newfilename, $ext)) {
					$fonturl = trailingslashit($upload_dir['url']) .$newfilename;
					$localfont[$fontName] = [
						'woff2' => ($fontExtension == 'woff2') ? $fonturl : '',
						'woff' => ($fontExtension == 'woff') ? $fonturl : '',
						'tiff' => ($fontExtension == 'tiff') ? $fonturl : '',
						'ttf' => ($fontExtension == 'ttf') ? $fonturl : '',
					];

					$localfontcss .= '@font-face {';
						$localfontcss .= 'font-family: "' . $fontName . '";';
						$localfontcss .= 'src: ';
						if ($fontExtension == 'woff2') {
							$localfontcss .= 'url(' . $fonturl . ') format("woff2"), ';
						}
						if ($fontExtension == 'woff') {
							$localfontcss .= 'url(' . $fonturl . ') format("woff"), ';
						}
						if ($fontExtension == 'ttf') {
							$localfontcss .= 'url(' . $fonturl . ') format("truetype"), ';
						}
						if ($fontExtension == 'tiff') {
							$localfontcss .= 'url(' . $fonturl . ') format("tiff"), ';
						}
						$localfontcss .= ';';
					$localfontcss .= 'font-display: swap;}';
					$newfonts = true;
				} else {
					continue;
				}

			}

			if($newfonts){
				$localfontcss = str_replace(', ;', ';', $localfontcss);
				$localfont = json_encode($localfont);
				$settings['localfont'] = $localfont;
				$settings['localfontcss'] = $localfontcss;
				update_option('gspb_global_settings', $settings);
			}
			
		}

		if(!empty($params['figma_colors']) && is_array($params['figma_colors'])){
			$figma_colors = $params['figma_colors'];
			$colours = !empty($defaults['colours']) ? $defaults['colours'] : [];

			foreach($figma_colors as $key=>$value){
				$colours[$key] = $value;
			}

			$colours = json_encode($colours);
			$settings['colours'] = $colours;
			update_option('gspb_global_settings', $settings);
		}

		if(!empty($params['figma_classes']) && is_array($params['figma_classes'])){
			$figma_classes = $params['figma_classes'];
			$classes = !empty($defaults['global_classes']) ? $defaults['global_classes'] : [];
			$classes_values = array_column($classes, 'value');

			foreach($figma_classes as $key=>$value){
				if(!empty($value['value'])){
					$index = array_search($value['value'], $classes_values);
					if($index){
						$classes[$index] = $value;
					}else{
						$classes[] = $value;
					}
				}
			}
			$defaults['global_classes'] = $classes;
			update_option('gspb_global_settings', $defaults);
		}

		if(isset($params['custom_css'])){
			$defaults['custom_css'] = $params['custom_css'];
			update_option('gspb_global_settings', $defaults);
		}

		if(isset($params['framework_classes'])){
			if(!is_array($params['framework_classes'])){
				$params['framework_classes'] = [];
			}
			$defaults['framework_classes'] = $params['framework_classes'];
			update_option('gspb_global_settings', $defaults);
		}

		if(!empty($params['figma_gradients']) && is_array($params['figma_gradients'])){
			$figma_gradients = $params['figma_gradients'];
			$gradients = !empty($defaults['gradients']) ? $defaults['gradients'] : [];

			foreach($figma_gradients as $key=>$value){
				$gradients[$key] = $value;
			}
			$gradients = json_encode($gradients);
			$settings['gradients'] = $gradients;
			update_option('gspb_global_settings', $settings);
		}

		if(!empty($params['figma_elements']) && is_array($params['figma_elements'])){
			$figma_elements = $params['figma_elements'];
			$elements = json_encode($figma_elements);
			$settings['elements'] = $elements;
			update_option('gspb_global_settings', $settings);
		}

		return json_encode(array(
			'success' => true,
			'message' => 'Global settings updated!',
		));
	} catch (Exception $e) {
		return json_encode(array(
			'success' => false,
			'message' => $e->getMessage(),
		));
	}
}

function gspb_update_css_settings($request)
{

	try {
		$css = sanitize_text_field($request->get_param('css'));
		$id = sanitize_text_field($request->get_param('id'));
		if ($css) {
			update_post_meta($id, '_gspb_post_css', $css);
		}

		return json_encode(array(
			'success' => true,
			'message' => 'Post css updated!',
		));
	} catch (Exception $e) {
		return json_encode(array(
			'success' => false,
			'message' => $e->getMessage(),
		));
	}
}

function gspb_update_global_wp_settings($request)
{

	try {
		$params = $request->get_params();
		$settings = wp_get_global_settings();
		if(!empty($params['colors'])){
			$colors = [];
			foreach($params['colors'] as $key=>$value){
				$colors[$key] = sanitize_text_field($value['color']);
			}

			$theme = wp_get_theme();
			if ($theme->parent_theme) {
				$template_dir = basename(get_template_directory());
				$theme = wp_get_theme($template_dir);
			}
			$themename = $theme->get('TextDomain');
	
			// Define post parameters
			$post_type = 'wp_global_styles';
			$post_name = 'wp-global-styles-'.$themename;
		
			$stylesObject = get_page_by_path($post_name, OBJECT, $post_type);
			$stylesPostId = is_object($stylesObject) ? $stylesObject->ID : '';
		
			if ($stylesPostId) {
		
				$post_id = $stylesPostId;
				$content = $stylesObject->post_content;
				$contentclean = json_decode($content, true);
				if(empty($contentclean)){
					$contentclean = array();
				}
				if (empty($contentclean['settings']['color']['palette']['theme'])) {
					$contentclean['settings']['color']['palette']['theme'] = $settings['color']['palette']['theme'];
					$contentclean["isGlobalStylesUserThemeJSON"] = true;
					$contentclean["version"] = 3;
				}
				if(!empty($colors)){
					foreach($colors as $key=>$value){
						$contentclean['settings']['color']['palette']['theme'][$key]['color'] = $value;
					}
				}
		
				// Update post data as needed
				$post_data = array(
					'ID'   =>  $stylesPostId,
					'post_name' => $post_name, // Replace with the new slug
					'post_status' => 'publish',
					'post_title' => $stylesObject->post_title, // Replace with the new title
					'post_content' => wp_slash(json_encode($contentclean)), // Replace with the new content
				);
		
				// Update the post
				wp_update_post($post_data);
			} else {
				$contentclean = array();
				$contentclean['settings']['color']['palette']['theme'] = $settings['color']['palette']['theme'];
				$contentclean["isGlobalStylesUserThemeJSON"] = true;
				$contentclean["version"] = 3;
				if(!empty($colors)){
					foreach($colors as $key=>$value){
						$contentclean['settings']['color']['palette']['theme'][$key]['color'] = $value;
					}
				}
				$content = json_encode($contentclean);
				$post_id = wp_insert_post(array(
					'post_name' => $post_name,
					'post_title' => "Custom Styles",
					'post_type' => $post_type,
					'post_content' => $content,
					'post_status' => 'publish',
				));
		
				$category_domain = 'wp_theme';
				$category_slug = $themename;
				$category_slug = str_replace( '"', '', $category_slug );
		
				wp_set_object_terms($post_id, $category_slug, $category_domain, false);
			}
		}

		return json_encode(array(
			'success' => true,
			'message' => 'Settings updated!',
		));
	} catch (Exception $e) {
		return json_encode(array(
			'success' => false,
			'message' => $e->getMessage(),
		));
	}
}

function gspb_convert_svgstring_from_svg_image(WP_REST_Request $request)
{
	$imageid = intval($request->get_param('imageid'));

	$result = '';

	if($imageid){
		$path = wp_get_original_image_path( $imageid );
		require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
		require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';
		$filesystem = new WP_Filesystem_Direct( true );

		$content = $filesystem->get_contents($path);
		$result = ['svg' => $content];
	}

	return json_encode($result);

}

//////////////////////////////////////////////////////////////////
// USDZ support until WP will have it
//////////////////////////////////////////////////////////////////

function gspb_enable_extended_upload($mime_types = array())
{
	$mime_types['txt'] = 'application/text';
	$mime_types['glb']  = 'application/octet-stream';
	$mime_types['usdz']  = 'application/octet-stream';
	$mime_types['splinecode'] = 'application/octet-stream';
	$mime_types['gltf']  = 'text/plain';
	return $mime_types;
}
add_filter('upload_mimes', 'gspb_enable_extended_upload');


//////////////////////////////////////////////////////////////////
// Template Library
//////////////////////////////////////////////////////////////////

const TEMPLATE_SERVER_URL = 'https://greenshift.wpsoul.net/';

add_action('wp_ajax_gspb_get_layouts', 'gspb_get_all_layouts');
add_action('wp_ajax_gspb_get_layout_by_id', 'gspb_get_layout');
add_action('wp_ajax_gspb_get_categories', 'gspb_get_categories');
add_action('wp_ajax_gspb_get_saved_block', 'gspb_get_saved_block');

if (!function_exists('gspb_get_all_layouts')) {
	function gspb_get_all_layouts()
	{
		$get_args  = array('timeout' => 200, 'sslverify' => false);
		$category  = intval($_POST['category_id']);
		$page      = !empty($_POST['page']) ? intval($_POST['page']) : 1;
		$per_page  = 12;
		$term      = isset($_POST['term']) ? sanitize_text_field($_POST['term']) : null;
		$tag       = isset($_POST['tag']) ? sanitize_text_field($_POST['tag']) : null;
		// if term is available, category will be only term 
		if (isset($term) && $term !== "All") {
			$category = $term;
		}

		$apiUrl    = TEMPLATE_SERVER_URL . '/wp-json/wp/v2/posts/?_embed&categories=' . $category . '&per_page=' . $per_page . '&page=' . $page;
		// Append tag to the API URL if it's available and not equal to "All"
		if (!is_null($tag) && $tag !== '' && $tag !== 'All') {
			$apiUrl .= '&tags=' . $tag;
		}

		$response  = wp_safe_remote_get($apiUrl, $get_args);
		$body      = wp_remote_retrieve_body($response);
		$headers   = wp_remote_retrieve_headers($response);
		$request_result = $body;


		if ($request_result === '') {
			return false;
		} else {
			$total_pages = isset($headers['x-wp-totalpages']) ? intval($headers['x-wp-totalpages']) : 1;
			$decoded_data = json_decode($request_result, true);

			$response_data = array(
				'total_pages' => $total_pages,
				'data' => $decoded_data,
			);

			echo json_encode($response_data);
		}

		wp_die();
	}
}

function gspb_isIncludedDomain($url, $included_domains) {
    $parsed_url = parse_url($url);
    if (!isset($parsed_url['host'])) {
        return false; // Not a valid URL
    }
    
    $host = $parsed_url['host'];

    foreach ($included_domains as $domain) {
        if (substr($host, -strlen($domain)) === $domain) {
            return true;
        }
    }

    return false;
}

if (!function_exists('gspb_get_layout')) {
	function gspb_get_layout()
	{
		if(!current_user_can('manage_options')) return false;
		check_ajax_referer('gspb_nonce', 'security');
		$get_args = array(
			'timeout'   => 200,
			'sslverify' => false,
		);
		$id       = intval($_POST['gspb_layout_id']);
		$public_assets_url = '';
		if(!empty($_POST['download_url']) || !empty($_POST['download_url_animated'])){
			if(!empty($_POST['download_animated']) && $_POST['download_animated'] == 'yes' && !empty($_POST['download_url_animated'])){
				$apiUrl   = esc_url($_POST['download_url_animated']);
			}else{
				$apiUrl   = esc_url($_POST['download_url']);
			}
			$included_domains = ["wpsoul.net", "greenshiftwp.com", "wpsoul.com"];
			if (gspb_isIncludedDomain($apiUrl, $included_domains)) {
				// It's fine, we get link from trusted domains
			} else {
				return '';
			}

			$urlarray = explode('/wp-json', $apiUrl);
			if(is_array($urlarray) && !empty($urlarray[0]) && !empty($_POST['download_assets']) && $_POST['download_assets'] == 'yes'){
				$siteUrl = $urlarray[0];
				$public_assets_url = $siteUrl . '/wp-json/greenshift/v1/public_assets';
			}
		}else{
			$apiUrl   = TEMPLATE_SERVER_URL . '/wp-json/greenshift/v1/layout/' . $id;
		}
		$response = wp_safe_remote_get($apiUrl, $get_args);
		$request_result = wp_remote_retrieve_body($response);
		if ($request_result == '') {
			return false;
		} else {
			if($public_assets_url){
				$public_assets = wp_safe_remote_get($public_assets_url, $get_args);
				$public_assets_result = wp_remote_retrieve_body($public_assets);
				if ($public_assets_result != '') {
					$defaults = get_option('gspb_global_settings');
					$public_assets_result = json_decode($public_assets_result, true);
					$public_assets_result = !empty($public_assets_result['settings']) ? $public_assets_result['settings'] : [];

					if(!empty($public_assets_result['colours'])){
						$figma_colors = $public_assets_result['colours'];
						$colours = !empty($defaults['colours']) ? $defaults['colours'] : [];
			
						foreach($figma_colors as $key=>$value){
							$colours[$key] = $value;
						}
						$colours = $colours;
						$settings['colours'] = $colours;
						update_option('gspb_global_settings', $settings);
					}
					if(!empty($public_assets_result['gradients'])){
						$figma_gradients = $public_assets_result['gradients'];
						$gradients = !empty($defaults['gradients']) ? $defaults['gradients'] : [];
			
						foreach($figma_gradients as $key=>$value){
							$gradients[$key] = $value;
						}
						$gradients = $gradients;
						$settings['gradients'] = $gradients;
						update_option('gspb_global_settings', $settings);
					}
					if(!empty($public_assets_result['localfont'])){

						$fonts = json_decode($public_assets_result['localfont'], true);
						$localfont = !empty($defaults['localfont']) ? json_decode($defaults['localfont'], true) : [];
						$localfontcss = !empty($defaults['localfontcss']) ? $defaults['localfontcss'] : '';
						$newfonts = false;
			
						foreach($fonts as $key=>$value){
							$fontName = $key;
							if(!$fontName || in_array($fontName, $localfont)){
								continue;
							}
							$fontFile = '';
							foreach ($value as $fonturl){
								if(!empty($fonturl)){
									$fontFile = $fonturl;
									break;
								}
							}
							if(!$fontFile){
								continue;
							}
							$fontExtension = pathinfo($fontFile, PATHINFO_EXTENSION);
							$allowed_font_ext = [
								'woff2',
								'woff',
								'tiff',
								'ttf',
							]; 
							if(!$fontExtension || !in_array($fontExtension, $allowed_font_ext)){
								continue;
							}
							$newfilename = basename($fontFile);
							$ext = $fontExtension;
							$upload_dir = wp_upload_dir();
							$dir = trailingslashit($upload_dir['basedir']) . 'GreenShift/'; 
							if ($newfilename = greenshift_download_file_localy($fontFile, $dir, $newfilename, $ext)) {
								$fonturl = trailingslashit($upload_dir['url']) .$newfilename;
								$localfont[$fontName] = [
									'woff2' => ($fontExtension == 'woff2') ? $fonturl : '',
									'woff' => ($fontExtension == 'woff') ? $fonturl : '',
									'tiff' => ($fontExtension == 'tiff') ? $fonturl : '',
									'ttf' => ($fontExtension == 'ttf') ? $fonturl : '',
								];
			
								$localfontcss .= '@font-face {';
									$localfontcss .= 'font-family: "' . $fontName . '";';
									$localfontcss .= 'src: ';
									if ($fontExtension == 'woff2') {
										$localfontcss .= 'url(' . $fonturl . ') format("woff2"), ';
									}
									if ($fontExtension == 'woff') {
										$localfontcss .= 'url(' . $fonturl . ') format("woff"), ';
									}
									if ($fontExtension == 'ttf') {
										$localfontcss .= 'url(' . $fonturl . ') format("truetype"), ';
									}
									if ($fontExtension == 'tiff') {
										$localfontcss .= 'url(' . $fonturl . ') format("tiff"), ';
									}
									$localfontcss .= ';';
								$localfontcss .= 'font-display: swap;}';
								$newfonts = true;
							} else {
								continue;
							}
			
						}
			
						if($newfonts){
							$localfontcss = str_replace(', ;', ';', $localfontcss);
							$localfont = json_encode($localfont);
							$settings['localfont'] = $localfont;
							$settings['localfontcss'] = $localfontcss;
							update_option('gspb_global_settings', $settings);
						}

					}
					if(!empty($public_assets_result['elements']) && is_array($public_assets_result['elements'])){
						$figma_elements = $public_assets_result['elements'];
						$elements = $figma_elements;
						$settings['elements'] = $elements;
						update_option('gspb_global_settings', $settings);
					}
				}
			}
			$request_result = greenshift_replace_ext_images($request_result);
			$type = sanitize_text_field($_POST['type']);
			if($type == 'home' || $type == 'header' || $type == 'footer' || $type == 'single' || $type == 'archive' || $type == 'archiveproduct' || $type == 'singleproduct' || $type == 'searchproduct'){
				$pageid = (int)$_POST['pageid'];
				$post_content = json_decode($request_result, true);
				$post_content = wp_slash($post_content);
				if($type == 'single' || $type == 'archive' || $type == 'archiveproduct' || $type == 'singleproduct'|| $type == 'searchproduct'){
					$post_content = '<!-- wp:template-part {"slug":"header","theme":"greenshift","tagName":"header","className":"site-header"} /-->'.$post_content.'<!-- wp:template-part {"slug":"footer","theme":"greenshift","tagName":"footer","className":"site-footer is-style-no-margin"} /-->';
				}
				
				wp_update_post(array(
					'ID' => $pageid,
					'post_content' => $post_content,
				));
				if($type == 'home'){
					$cssUrl = str_replace('layout', 'layoutcss', $apiUrl);
					$responsecss = wp_safe_remote_get($cssUrl, $get_args);
					$request_resultcss = wp_remote_retrieve_body($responsecss);
					if ($request_resultcss) {
						$layout_styles = strip_tags($request_resultcss);
						$layout_styles = trim($layout_styles, '"');
						update_post_meta($pageid, '_gspb_post_css', $layout_styles);
					}
				}
				echo $request_result;
			}else{
			echo $request_result;
			}
		}
		wp_die();
	}
}

if (!function_exists('gspb_get_categories')) {
	function gspb_get_categories()
	{
		$get_args = array(
			'timeout'   => 200,
			'sslverify' => false,
		);
		$id       = intval($_POST['category_id']);
		$apiUrl   = TEMPLATE_SERVER_URL . '/wp-json/wp/v2/categories?parent=' . $id;
		$response = wp_safe_remote_get($apiUrl, $get_args);
		$request_result = wp_remote_retrieve_body($response);
		if ($request_result == '') {
			return false;
		} else {
			echo wp_remote_retrieve_body($response);
		}
		wp_die();
	}
}

function gspb_get_saved_block()
{
	$args = array(
		'post_type'   => 'wp_block',
		'post_status' => 'publish',
		'posts_per_page' => 100
	);
	$id       = (!empty($_POST['block_id'])) ? intval($_POST['block_id']) : '';
	$id       = (!empty($_POST['gspb_layout_id'])) ? intval($_POST['gspb_layout_id']) : $id;
	if ($id) {
		$args['p'] = $id;
	}
	$r         = wp_parse_args(null, $args);
	$get_posts = new WP_Query();
	$wp_blocks = $get_posts->query($r);
	$response = array(
		'blocks' => $wp_blocks,
		'admin' => admin_url()
	);
	wp_send_json_success($response);
}


//////////////////////////////////////////////////////////////////
// Model viewer script type
//////////////////////////////////////////////////////////////////

add_filter('script_loader_tag','greenshift_new_add_type_to_script', 10, 3);
function greenshift_new_add_type_to_script($tag, $handle, $source){
    if ('gsmodelviewer' === $handle) {
        $tag = '<script id="gsmodelviewerscript" src="'. $source .'" type="module"></script>';
    } 
	if ('gsmodelinit' === $handle) {
        $tag = '<script src="'. $source .'" type="module"></script>';
    } 
	if ('gs-spline-init' === $handle) {
        $tag = '<script src="'. $source .'" type="module"></script>';
    } 
	if ('anchor-polyfill' === $handle) {
        $tag = '<script src="'. $source .'" type="module"></script>';
    } 
    return $tag;
}

//add_filter( 'wp_default_autoload_value', 'gspb_large_value_autoload', 10, 2 );
function gspb_large_value_autoload( $autoload, $option ) {
    if ( 'gspb_global_settings' === $option ) {
        return true;
    }
    return $autoload;
}
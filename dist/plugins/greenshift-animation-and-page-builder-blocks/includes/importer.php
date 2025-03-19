<?php
/**
 * The importer.
 */
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Group array by given key.
 */
function greenshift_design_import_group_by($key, $data)
{
	$result = array();

	foreach ($data as $val) {
		if (array_key_exists($key, $val)) {
			$result[$val[$key]][] = $val;
		} else {
			$result[""][] = $val;
		}
	}

	return $result;
}


/**
 * Wrap given string in XML CDATA tag.
 */
function greenshift_import_wxr_cdata($str)
{
	if (!seems_utf8($str)) {
		$str = utf8_encode($str);
	}
	// $str = ent2ncr(esc_html($str));
	$str = '<![CDATA[' . str_replace(']]>', ']]]]><![CDATA[>', $str) . ']]>';

	return $str;
}


/**
 * Return the URL of the site.
 */
function greenshift_import_wxr_site_url()
{
	if (is_multisite()) {
		// Multisite: the base URL.
		return network_home_url();
	} else {
		// WordPress (single site): the blog URL.
		return get_bloginfo_rss('url');
	}
}

/**
 * Output list of taxonomy terms, in XML tag format, associated with a post.
 */
function greenshift_import_wxr_post_taxonomy($post)
{
	$output = '';
	$taxonomies = get_object_taxonomies($post->post_type);
	if (empty($taxonomies)) {
		return;
	}
	$terms = wp_get_object_terms($post->ID, $taxonomies);
	foreach ((array) $terms as $term) {
		$output .= '
		<category domain="' . $term->taxonomy . '" nicename="' . $term->slug . '">"' . greenshift_import_wxr_cdata($term->name) . '"</category>';
	}

	return $output;
}


/**
 * The download/export XML file output.
 */
function greenshift_import_download()
{

	require_once ABSPATH . 'wp-admin/includes/export.php';
	// Run some checks before allowing a WXR export file to be baked and returned.
	if (isset($_GET['greenshift_import_download']) && isset($_GET['design_import_posts']) && current_user_can('export') && isset($_GET['greenshift_import_nonce'])) {


		check_admin_referer('greenshift_import_download', 'greenshift_import_nonce');

		$design_type = $_GET['greenshift_import_download'];
		$design_import_posts_export = $_GET['design_import_posts'];

		if(empty($design_type) || empty($design_import_posts_export)){
			exit;
		}

		$importcontent = '';

		if($design_type == 'settings'){
			$data = get_option( 'gspb_global_settings', array() );
			$data = wp_array_slice_assoc($data, $design_import_posts_export);
			$importcontent = json_encode( $data, JSON_PRETTY_PRINT );
		}
		else{
			$importcontent = '<?xml version="1.0" encoding="' . get_bloginfo('charset') . '" ?>
				<!-- This is a WordPress eXtended RSS file generated as an export of your site design. -->
				<!-- It contains information about your site design templates, template parts, and custom styles. -->
				<!-- You may use this file to transfer that content from one site to another. -->
				<!-- The information in this file is intended to be used with the theme you selected as the basis of your design. -->
	
				<!-- To import this information into a WordPress site follow these steps: -->
				<!-- 1. Log in to that site as an administrator. -->
				<!-- 2. Install and activate the "Greenshift" plugin. -->
				<!-- 3. Go to Greenshift - Import/Export dashboard menu. -->
				<!-- 4. Use the Import function to upload this file using the form provided on that page. -->
				<!-- 5. The templates, template parts, reusable templates and custom styles -->
				<!--    contained in this file will be imported into your site. -->
	
				<rss version="2.0"
					xmlns:excerpt="http://wordpress.org/export/' . WXR_VERSION . '/excerpt/"
					xmlns:content="http://purl.org/rss/1.0/modules/content/"
					xmlns:wfw="http://wellformedweb.org/CommentAPI/"
					xmlns:dc="http://purl.org/dc/elements/1.1/"
					xmlns:wp="http://wordpress.org/export/' . WXR_VERSION . '/"
				>
	
				<channel>
					<title>' . get_bloginfo_rss('name') . '</title>
					<link>' . get_bloginfo_rss('url') . '</link>
					<description>' . get_bloginfo_rss('description') . '</description>
					<pubDate>' . gmdate('D, d M Y H:i:s +0000') . '</pubDate>
					<language>' . get_bloginfo_rss('language') . '</language>
					<wp:wxr_version>' . WXR_VERSION . '</wp:wxr_version>
					<wp:base_site_url>' . greenshift_import_wxr_site_url() . '</wp:base_site_url>
					<wp:base_blog_url>' . get_bloginfo_rss('url') . '</wp:base_blog_url>
				';
	
			$args = array(
				'numberposts' => -1,
				'include' => $design_import_posts_export,
				'orderby' => 'post_type',
				'post_status' => 'publish',
				'post_type' => array('wp_template', 'wp_template_part', 'wp_global_styles', 'wp_block'),
			);
			$export_posts = get_posts($args);
			if ($export_posts) {
				foreach ($export_posts as $post) {
					setup_postdata($post);
					$is_sticky = is_sticky($post->ID) ? 1 : 0;
					$importcontent .= '
						<item>
							<title>' . greenshift_import_wxr_cdata($post->post_title) . '</title>
							<link>' . get_permalink($post->ID) . '</link>
							<pubDate>' . mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true, $post->ID), false) . '</pubDate>
							<dc:creator>' . greenshift_import_wxr_cdata(get_the_author_meta('login')) . '</dc:creator>
							<guid isPermaLink="false">' . get_the_guid($post->ID) . '</guid>
							<description></description>
							<content:encoded>' . greenshift_import_wxr_cdata($post->post_content) . '</content:encoded>
							<excerpt:encoded>' . greenshift_import_wxr_cdata($post->post_excerpt) . '</excerpt:encoded>
							<wp:post_id>' . (int) $post->ID . '</wp:post_id>
							<wp:post_date>' . greenshift_import_wxr_cdata($post->post_date) . '</wp:post_date>
							<wp:post_date_gmt>' . greenshift_import_wxr_cdata($post->post_date_gmt) . '</wp:post_date_gmt>
							<wp:post_modified>' . greenshift_import_wxr_cdata($post->post_modified) . '</wp:post_modified>
							<wp:post_modified_gmt>' . greenshift_import_wxr_cdata($post->post_modified_gmt) . '</wp:post_modified_gmt>
							<wp:comment_status>' . greenshift_import_wxr_cdata($post->comment_status) . '</wp:comment_status>
							<wp:ping_status>' . greenshift_import_wxr_cdata($post->ping_status) . '</wp:ping_status>
							<wp:post_name>' . greenshift_import_wxr_cdata($post->post_name) . '</wp:post_name>
							<wp:status>' . greenshift_import_wxr_cdata($post->post_status) . '</wp:status>
							<wp:post_parent>' . (int) $post->post_parent . '</wp:post_parent>
							<wp:menu_order>' . (int) $post->menu_order . '</wp:menu_order>
							<wp:post_type>' . greenshift_import_wxr_cdata($post->post_type) . '</wp:post_type>
							<wp:post_password>' . greenshift_import_wxr_cdata($post->post_password) . '</wp:post_password>
							<wp:is_sticky>' . (int) $is_sticky . '</wp:is_sticky>'
										. greenshift_import_wxr_post_taxonomy($post) . '
						</item>
						';
				}
				wp_reset_postdata();
			}
			$importcontent .= '</channel></rss>';
		}

		$sitename = sanitize_key(get_bloginfo('name'));
		if (!empty($sitename)) {
			$sitename .= '.';
		}
		$date = gmdate('Y-m-d-H.i.s');
		$ext = '.xml';
		if($design_type == 'settings'){
			$ext = '.json';
		}
		$filename = 'greenshift_import.' . $sitename . $date . $ext;

		// set header information
		header('Content-Description: File Transfer');
		header('Content-Disposition: attachment; filename=' . $filename);
		if($design_type == 'settings'){
			header( 'Content-Type: application/json;' );
		}else{
			header('Content-Type: text/xml; charset=' . get_option('blog_charset'), true);
		}

		echo ''.$importcontent;
		exit;
	}
}
add_action('admin_post_greenshift_export', 'greenshift_import_download');


/**
 * Import a design.
 *
 * @since 1.0.0
 */
function greenshift_design_importer($file='') {

	$label_updated = __( 'Updated', 'greenshift-animation-and-page-builder-blocks' );
	$label_imported = __( 'Imported', 'greenshift-animation-and-page-builder-blocks' );

	if($file){
		$xml = simplexml_load_file($file);
	}else{
		$file = wp_import_handle_upload();
	
		if ( isset( $file['error'] ) ) {
			echo '<p><strong>' . esc_html__( 'Sorry, there has been an error.', 'greenshift-animation-and-page-builder-blocks' ) . '</strong><br />';
			echo esc_html( $file['error'] ) . '</p>';
			return false;
		} else if ( ! file_exists( $file['file'] ) ) {
			echo '<p><strong>' . esc_html__( 'Sorry, there has been an error.', 'greenshift-animation-and-page-builder-blocks' ) . '</strong><br />';
			printf( esc_html__( 'The export file could not be found at <code>%s</code>. It is likely that this was caused by a permissions problem.', 'greenshift-animation-and-page-builder-blocks' ), esc_html( $file['file'] ) );
			echo '</p>';
			return false;
		}
	
		$file_id = (int) $file['id'];
	
		$xml = simplexml_load_file( $file['file'] );
	}

	if( ! $xml ) {
		echo '<p><strong>' . esc_html__( 'Sorry, there has been an error.', 'greenshift-animation-and-page-builder-blocks' ) . '</strong><br />';
		return false;
	}

	$namespaces = $xml->getDocNamespaces();
	
	if ( ! isset( $namespaces['wp'] ) ) {
		$namespaces['wp'] = 'http://wordpress.org/export/' . WXR_VERSION . '/';
	}
	if ( ! isset( $namespaces['dc'] ) ) {
		$namespaces['dc'] = 'http://purl.org/dc/elements/1.1/';
	}
	if ( ! isset( $namespaces['content'] ) ) {
		$namespaces['content'] = 'http://purl.org/rss/1.0/modules/content/';
	}
	if ( ! isset( $namespaces['excerpt'] ) ) {
		$namespaces['excerpt'] = 'http://wordpress.org/export/' . WXR_VERSION . '/excerpt/';
	}
	if ( ! isset( $namespaces['wfw'] ) ) {
		$namespaces['wfw'] = 'http://wellformedweb.org/CommentAPI/';
	}

	$base_blog_url = greenshift_import_sanitize_data( $xml->channel->children( $namespaces['wp'] )->base_blog_url, '' );
	$thumbnails_old_ids = array();
	$thumbnails_new_ids = array();
	$thumbnailsterms_old_ids = array();
	$thumbnailsterms_new_ids = array();
	$menu_id = '';
	$header_id = '';
	$menu_old_id = '';
	$updated_types = array();
	$new_types = array();

	echo '<ul class="updated-posts">';

	foreach ( $xml->channel->children( $namespaces['wp'] )->term as $item ) {
		$namespace_wp = $item->children( $namespaces['wp'] );
		$term_taxonomy = greenshift_import_sanitize_data( $namespace_wp->term_taxonomy, 'term_taxonomy' );
		$term_slug = greenshift_import_sanitize_data( $namespace_wp->term_slug, 'term_slug' );
		$term_name = greenshift_import_sanitize_data( $namespace_wp->term_name, 'term_name' );
		$parent = greenshift_import_sanitize_data( $namespace_wp->parent, 'parent' );

		$termmeta_fields = array();
		if(!empty($namespace_wp->termmeta)){
			foreach ( $namespace_wp->termmeta as $termmeta ) {
				$meta_key = greenshift_import_sanitize_data( $termmeta->meta_key, '' );
				$meta_value = greenshift_import_sanitize_data( $termmeta->meta_value, '' );
				$termmeta_fields[$meta_key] = greenshift_replace_ext_images($meta_value, 'raw');
			}
		}

		$parent_id      = empty( $parent ) ? 0 : term_exists( $parent, $term_taxonomy );

		$term_exists = term_exists( $term_slug, $term_taxonomy );
		$term_id     = is_array( $term_exists ) ? $term_exists['term_id'] : $term_exists;
		if ( ! $term_id ) {
			$t = wp_insert_term( $term_name, $term_taxonomy, array( 'slug' => $term_slug, 'parent' => $parent_id ) );
			if ( ! is_wp_error( $t ) ) {
				$term_id = $t['term_id'];
			}
		}
		if(!empty($termmeta_fields)){
			foreach($termmeta_fields as $meta_key => $meta_value){
				if($meta_key === 'thumbnail_id'){
					$thumbnailsterms_old_ids[$meta_value][] = $term_id;
				}
				update_term_meta( $term_id, $meta_key, $meta_value );
			}
		}
	}

	foreach ( $xml->channel->item as $item ) {

		$namespace_wp = $item->children( $namespaces['wp'] );
		$namespace_content = $item->children( $namespaces['content'] );
		$namespace_excerpt = $item->children( $namespaces['excerpt'] );

		$post_title = greenshift_import_sanitize_data( $item->title, 'title' );	
		$post_content = greenshift_import_sanitize_data( $namespace_content->encoded, 'post_content', false );
		$excerpt_content = greenshift_import_sanitize_data( $namespace_excerpt->encoded, 'post_excerpt', false );
		$post_name = greenshift_import_sanitize_data( $namespace_wp->post_name, 'post_name' );
		$post_status = greenshift_import_sanitize_data( $namespace_wp->status, 'post_status' );
		$post_type = greenshift_import_sanitize_data( $namespace_wp->post_type, 'post_type' );
		$comment_status = greenshift_import_sanitize_data( $namespace_wp->comment_status, 'comment_status' );
		$ping_status = greenshift_import_sanitize_data( $namespace_wp->ping_status, 'ping_status' );
		$oldID = greenshift_import_sanitize_data( $namespace_wp->post_id, 'post_id' );

		$post_type_name = '';
		if ( $post_type === 'wp_template' ) {
			$post_type_name = __( 'template', 'greenshift-animation-and-page-builder-blocks' );
		} elseif ( $post_type === 'wp_template_part' ) {
			$post_type_name = __( 'template part', 'greenshift-animation-and-page-builder-blocks' );
		} elseif ( $post_type === 'wp_global_styles' ) {
			$post_type_name = __( 'custom styles', 'greenshift-animation-and-page-builder-blocks' );
		}elseif ( $post_type === 'wp_block' ) {
			$post_type_name = __( 'reusable templates', 'greenshift-animation-and-page-builder-blocks' );
		}elseif ( $post_type === 'post' ) {
			$post_type_name = __( 'posts', 'greenshift-animation-and-page-builder-blocks' );
		}elseif ( $post_type === 'page' ) {
			$post_type_name = __( 'pages', 'greenshift-animation-and-page-builder-blocks' );
		}elseif ( $post_type === 'product' ) {
			$post_type_name = __( 'products', 'greenshift-animation-and-page-builder-blocks' );
		}else{
			$post_type_name = $post_type;
		}

		if ( $post_type === 'wp_template' || $post_type === 'wp_template_part' || $post_type === 'wp_block' || $post_type === 'post' || $post_type === 'page' || $post_type === 'product' ) {
			if ( ! empty( $base_blog_url ) ) {
				$post_content = greenshift_import_block_attrs_replace( $base_blog_url, $post_content );
			}
		}

		$terms = array();
		$theme_slug = '';
		$theme_name = '';
		$meta_fields = array();
		foreach ( $item->category as $category ) {
			$category_domain = greenshift_import_sanitize_data( $category['domain'], '' );
			$category_slug = greenshift_import_sanitize_data( $category['nicename'], '' );
			$category_name = greenshift_import_sanitize_data( $category, '' );
			$category_slug = str_replace( '"', '', $category_slug );
			$category_name = str_replace( '"', '', $category_name );
			$category_domain = str_replace( '"', '', $category_domain );
			$term_exists = term_exists( $category_slug, $category_domain );
			$term_id     = is_array( $term_exists ) ? $term_exists['term_id'] : $term_exists;
			if ( ! $term_id ) {
				$t = wp_insert_term( $category_name, $category_domain, array( 'slug' => $category_slug ) );
				if ( ! is_wp_error( $t ) ) {
					$term_id = $t['term_id'];
				}
			}
			$terms[$category_domain][] = $category_slug;
			if ( $category_domain === 'wp_theme' ) {
				$theme_slug = $category_slug;
				$theme_slug = str_replace( '"', '', $theme_slug );
			}
		}
		if ( $theme_slug ) {
			$theme_name = wp_get_theme( $theme_slug );
		}
		if(!empty($namespace_wp->postmeta)){
			foreach ( $namespace_wp->postmeta as $postmeta ) {
				$meta_key = greenshift_import_sanitize_data( $postmeta->meta_key, '' );
				$meta_value = greenshift_import_sanitize_data( $postmeta->meta_value, '' );
				$meta_fields[$meta_key] = greenshift_replace_ext_images($meta_value, 'raw');
				
			}
		}

		$post_exist = greenshift_import_post_exists( $post_name, $post_type, $theme_slug );
		if ( $post_exist['post_id'] && $post_exist['action'] === 'update' ) {
			$update_post_args = array(
				'ID' => $post_exist['post_id'],
				'post_content' => $post_content,
				'meta_input'		=> $meta_fields,
				'post_excerpt' => $excerpt_content,
				'tax_input'			=> $terms,
			);
			if($post_type === 'attachment'){
				$get_attachment_title = get_the_title($post_exist['post_id']);
				if($post_title !== $get_attachment_title){
					$remote_url = ! empty( $namespace_wp->attachment_url ) ? greenshift_import_sanitize_data($namespace_wp->attachment_url, 'attachment_url') : greenshift_import_sanitize_data($item->guid, 'guid');
					// try to use _wp_attached file for upload folder placement to ensure the same location as the export site
					// e.g. location is 2003/05/image.jpg but the attachment post_date is 2010/09, see media_handle_upload()
					$update_post_args['upload_date'] = $namespace_wp->post_date;
					if ( isset( $meta_fields ) ) {
						foreach ( $meta_fields as $meta_key => $meta_value ) {
							if ( '_wp_attached_file' == $meta_key ) {
								if ( preg_match( '%^[0-9]{4}/[0-9]{2}%', $meta_value, $matches ) ) {
									$update_post_args['upload_date'] = $matches[0];
								}
								break;
							}
						}
					}
					$update_post_id = greenshift_process_attachment( $update_post_args, $remote_url );
					$thumbnails_new_ids[$oldID] = $update_post_id;
					$thumbnailsterms_new_ids[$oldID] = $update_post_id;
				}else{
					$update_post_id = $post_exist['post_id'];
					$thumbnails_new_ids[$oldID] = $update_post_id;
					$thumbnailsterms_new_ids[$oldID] = $update_post_id;
				}

			}else{
				$update_post_id = wp_update_post( wp_slash( $update_post_args ) );
			}
			if ( $update_post_id ) {
				foreach ( $meta_fields as $meta_key => $meta_value){
					if($meta_key === '_thumbnail_id'){
						$thumbnails_old_ids[$meta_value][] = $update_post_id;
					}
				}
				if($post_type == 'wp_navigation'){
					$menu_id = $update_post_id;
					$menu_old_id = $oldID;
				}
				if($post_type == 'wp_template_part' && $post_name == 'header'){
					$header_id = $update_post_id;
				}
				if(!empty($terms)){
					foreach($terms as $term_domain => $term_slugs){
						wp_set_object_terms( $update_post_id, $term_slugs, $term_domain, true );
					}
				}
				$updated_types[] = $post_type_name;
				if ( $post_type === 'wp_template' || $post_type === 'wp_template_part' ) {
					echo '<li class="updated hideimport"><span class="dashicons-before dashicons-saved"></span> ' . esc_html( $label_updated ) . ' ' . esc_html( $theme_name ) . ' ' . esc_html( $post_title ) . '</li>';
				} else {
					echo '<li class="updated hideimport"><span class="dashicons-before dashicons-saved"></span> ' . esc_html( $label_updated ) . ' ' . esc_html( $theme_name ) . ' ' . esc_html( $post_type_name ) . '('.esc_html( $post_title ).')</li>';
				}
			}
		} elseif ( $post_exist['action'] === 'insert' ) {
			$insert_post_args = array(
				'post_title'		=> $post_title,
				'post_content'		=> $post_content,
				'comment_status'	=> $comment_status,
				'ping_status'		=> $ping_status,
				'post_name'			=> $post_name,
				'post_status'		=> $post_status,
				'post_type'			=> $post_type,
				'tax_input'			=> $terms,
				'meta_input'		=> $meta_fields,
				'post_excerpt' 		=> $excerpt_content,
			);
			if($post_type === 'attachment'){
				$remote_url = ! empty( $namespace_wp->attachment_url ) ? greenshift_import_sanitize_data($namespace_wp->attachment_url, 'attachment_url') : greenshift_import_sanitize_data($item->guid, 'guid');
				// try to use _wp_attached file for upload folder placement to ensure the same location as the export site
				// e.g. location is 2003/05/image.jpg but the attachment post_date is 2010/09, see media_handle_upload()
				$insert_post_args['upload_date'] = $namespace_wp->post_date;
				if ( isset( $meta_fields ) ) {
					foreach ( $meta_fields as $meta_key => $meta_value ) {
						if ( '_wp_attached_file' == $meta_key ) {
							if ( preg_match( '%^[0-9]{4}/[0-9]{2}%', $meta_value, $matches ) ) {
								$insert_post_args['upload_date'] = $matches[0];
							}
							break;
						}
					}
				}
				$new_post_id = greenshift_process_attachment( $insert_post_args, $remote_url );
				$thumbnails_new_ids[$oldID] = $new_post_id;
				$thumbnailsterms_new_ids[$oldID] = $new_post_id;
			}else{
				$new_post_id = wp_insert_post( wp_slash( $insert_post_args ), true );
			}
			if ( $new_post_id ) {
				foreach ( $meta_fields as $meta_key => $meta_value){
					if($meta_key === '_thumbnail_id'){
						$thumbnails_old_ids[$meta_value][] = $new_post_id;
					}
				}
				if($post_type == 'wp_navigation'){
					$menu_id = $new_post_id;
					$menu_old_id = $oldID;
				}
				if($post_type == 'wp_template_part' && $post_name == 'header'){
					$header_id = $new_post_id;
				}
				if(!empty($terms)){
					foreach($terms as $term_domain => $term_slugs){
						wp_set_object_terms( $new_post_id, $term_slugs, $term_domain, true );
					}
				}
				global $wpdb;
				$wpdb->update( $wpdb->prefix . 'posts', array( 'post_name' => $post_name ), array( 'ID' => $new_post_id ), '%s', '%d' );

				$new_types[] = $post_type_name;

				if ( $post_type === 'wp_template' || $post_type === 'wp_template_part' ) {
					echo '<li class="imported hideimport is-font-weight-600"><span class="dashicons-before dashicons-saved"></span> ' . esc_html( $label_imported ) . ' ' . esc_html( $theme_name ) . ' ' . esc_html ( $post_title ) . '</li>';
				} else {
					echo '<li class="imported hideimport is-font-weight-600"><span class="dashicons-before dashicons-saved"></span> ' . esc_html( $label_imported ) . ' ' . esc_html( $theme_name ) . ' ' . esc_html( $post_type_name ) . '('.esc_html( $post_title ).')</li>';
				}
			}
		}

	}

	if(!empty($updated_types)){
		$updated_types = array_unique($updated_types);
		$updated_types = implode(', ', $updated_types);
		echo '<li class="imported is-font-weight-600"><span class="dashicons-before dashicons-saved"></span> ' . esc_html( $label_updated ) . ': ' . $updated_types .'</li>';
	}

	if(!empty($new_types)){
		$new_types = array_unique($new_types);
		$new_types = implode(', ', $new_types);
		echo '<li class="imported is-font-weight-600"><span class="dashicons-before dashicons-saved"></span> ' . esc_html( $label_imported ) . ': ' . $new_types .'</li>';
	}

	if(!empty($thumbnails_old_ids)){
		foreach($thumbnails_old_ids as $thumbnail_id=>$posts){
			foreach($posts as $post_id){
				if(!empty($thumbnails_new_ids[$thumbnail_id])){
					$new_thumbnail_id = $thumbnails_new_ids[$thumbnail_id];
					update_post_meta( $post_id, '_thumbnail_id', $new_thumbnail_id );
					$gallery_ids = get_post_meta( $post_id, '_product_image_gallery', true );
					if(!empty($gallery_ids)){
						$gallery_ids = explode(',', $gallery_ids);
						foreach($gallery_ids as $key=>$gallery_id){
							if(!empty($thumbnails_new_ids[$gallery_id])){
								$new_product_thumbnail_id = $thumbnails_new_ids[$gallery_id];
								$gallery_ids[$key] = $new_product_thumbnail_id;
							}
						}
						$gallery_ids = implode(',', $gallery_ids);
						update_post_meta( $post_id, '_product_image_gallery', $gallery_ids );
					}
				}
			}
		}
		echo '<li class="imported is-font-weight-600"><span class="dashicons-before dashicons-saved"></span> ' . esc_html__("Updated Featured Images", "greenshift-animation-and-page-builder-blocks") .'</li>';
	}

	if(!empty($thumbnailsterms_old_ids)){
		foreach($thumbnailsterms_old_ids as $thumbnail_id=>$terms){
			foreach($terms as $term_id){
				if(!empty($thumbnailsterms_new_ids[$thumbnail_id])){
					$new_thumbnail_id = $thumbnailsterms_new_ids[$thumbnail_id];
					update_term_meta( $term_id, 'thumbnail_id', $new_thumbnail_id );
				}
			}
		}
		echo '<li class="imported is-font-weight-600"><span class="dashicons-before dashicons-saved"></span> ' . esc_html__("Updated Category Images", "greenshift-animation-and-page-builder-blocks") .'</li>';
	}

	if($menu_id && $header_id && $menu_old_id){
		$content = get_the_content(null, false, $header_id);
		$content = str_replace($menu_old_id, $menu_id, $content);
		$my_post = array(
			'ID'           => $header_id,
			'post_content' => wp_slash($content),
		);
		wp_update_post($my_post);
		echo '<li class="imported is-font-weight-600"><span class="dashicons-before dashicons-saved"></span> ' . esc_html__("Updated header menu", "greenshift-animation-and-page-builder-blocks") .'</li>';
	}

	echo '</ul>';

}


/**
 * Sanitize data, and return strings that can be used for conditional checks.
 */
function greenshift_import_sanitize_data( $input, $field, $unslash = true ) {
	$input = str_replace( array( '<![CDATA[', ']]>' ), '', $input );
	if ( $unslash ) {
		$output = wp_unslash( sanitize_post_field( $field, $input, 0, 'db' ) );
	} else {
		$output = $input;
	}
	return $output;
}


/**
 * Check if this post already exists.
 */
function greenshift_import_post_exists( $post_name = '', $post_type = '', $theme_slug = '' ) {

	global $wpdb;

	if ( $post_name === '' ) {
		$todo = array( 'post_id' => 0, 'action' => 'nowt' );
	} else {
		if ( $post_type === 'wp_template' || $post_type === 'wp_template_part' ) {

			$post_id_update = 0;

			$template_posts = $wpdb->get_results( "SELECT ID FROM $wpdb->posts WHERE post_name = '" . $post_name . "' AND post_type = '" . $post_type . "'" );

			if ( $template_posts ) {
				foreach ( $template_posts as $template_post ) {
					$post_id = $template_post->ID;
					$terms = get_the_terms( $post_id, 'wp_theme' );
					if ( $terms && $terms[0]->slug === $theme_slug ) {
						$post_id_update = $post_id;
						break;
					}
				}
				if ( $post_id_update ) {
					$todo = array( 'post_id' => $post_id_update, 'action' => 'update' );
				} else {
					$todo = array( 'post_id' => 0, 'action' => 'insert' );
				}
			} else {
				$todo = array( 'post_id' => 0, 'action' => 'insert' );
			}

		} else  {

			$post_id = $wpdb->get_row( "SELECT ID FROM $wpdb->posts WHERE post_name = '" . $post_name . "' AND post_type = '" . $post_type . "'" );
			if ( $post_id ) {
				$todo = array( 'post_id' => $post_id->ID, 'action' => 'update' );
			} else {
				$todo = array( 'post_id' => 0, 'action' => 'insert' );
			}

		}	
	}

	return $todo;

}


function greenshift_import_block_attrs_replace( $base_blog_url, $content ) {
	$blocks = parse_blocks( $content );
	$replace_blocks = array();
	$replace_img_classes = array();
	$all_blocks = array();
	$queue      = array();
	foreach ( $blocks as $block ) {
		$queue[] = $block;
		if ( ! empty( $block['blockName'] ) && ! empty( $block['attrs'] ) && substr( $block['blockName'], 0, 5 ) === 'core/' ) {
			$block_name = str_replace( 'core/', 'wp:', $block['blockName'] );
			$block_output = $block_name.' ';
			$block_attrs = $block['attrs'];
			$block_attrs_new = $block_attrs;
			if ( $block_name === 'wp:image' && ! empty( $block_attrs_new['id'] ) ) {
				$replace_img_classes[] = array( 'old' => 'wp-image-' . $block_attrs_new['id'] , 'new' => '' );
			}
			unset( $block_attrs_new['id'] );
			$block_output_new = $block_output . wp_unslash( json_encode( $block_attrs_new ) );
			$block_output .= wp_unslash( json_encode( $block_attrs ) );
			if ( $block_output_new !== $block_output ) {
				$replace_blocks[] = array( 'old' => $block_output, 'new' => $block_output_new );
			}
		}
	}

	while ( count( $queue ) > 0 ) {
		$block = $queue[0];
		array_shift( $queue );
		$all_blocks[] = $block;

		if ( ! empty( $block['innerBlocks'] ) ) {
			foreach ( $block['innerBlocks'] as $inner_block ) {
				$queue[] = $inner_block;
				if ( ! empty( $inner_block['blockName'] ) && ! empty( $inner_block['attrs'] ) && substr( $inner_block['blockName'], 0, 5 ) === 'core/' ) {
					$inner_block_name = str_replace( 'core/', 'wp:', $inner_block['blockName'] );
					$inner_block_output = $inner_block_name.' ';
					$inner_block_attrs = $inner_block['attrs'];
					$inner_block_attrs_new = $inner_block_attrs;
					if ( $inner_block_name === 'wp:image' && ! empty( $inner_block_attrs_new['id'] ) ) {
						$replace_img_classes[] = array( 'old' => 'wp-image-' . $inner_block_attrs_new['id'] , 'new' => '' );
					}
					unset( $inner_block_attrs_new['id'] );
					$inner_block_output_new = $inner_block_output . wp_unslash( json_encode( $inner_block_attrs_new ) );
					$inner_block_output .= wp_unslash( json_encode( $inner_block_attrs ) );
					if ( $inner_block_output_new !== $inner_block_output ) {
						$replace_blocks[] = array( 'old' => $inner_block_output, 'new' => $inner_block_output_new );
					}
				}
			}
		}
	}
	$to_replace = array_merge( $replace_blocks, $replace_img_classes );
	/**
	 * Remove 'id' attributes from blocks such as image, nav link.
	 */
	foreach ( $to_replace as $block_replace ) {
		$content = str_replace( $block_replace['old'], $block_replace['new'], $content );
	}

	if ( ! empty( $base_blog_url ) ) {
		$base_blog_url_this = get_bloginfo_rss( 'url' );

		$content = str_replace( '"url":"'.$base_blog_url, '"url":"'.$base_blog_url_this, $content );
		$content = str_replace( 'href="'.$base_blog_url, 'href="'.$base_blog_url_this, $content );
	}

	$content = greenshift_replace_ext_images($content, 'raw');

	return $content;
}

function greenshift_process_attachment( $post, $url ) {

		// Extract the file name from the URL.
		$path      = parse_url( $url, PHP_URL_PATH );
		$file_name = '';
		if ( is_string( $path ) ) {
			$file_name = basename( $path );
		}

		if ( ! $file_name ) {
			$file_name = md5( $url );
		}

		$tmp_file_name = wp_tempnam( $file_name );
		if ( ! $tmp_file_name ) {
			return new WP_Error( 'import_no_file', __( 'Could not create temporary file.', 'greenshift-animation-and-page-builder-blocks' ) );
		}

		// Fetch the remote URL and write it to the placeholder file.
		$remote_response = wp_safe_remote_get(
			$url,
			array(
				'timeout'  => 300,
				'stream'   => true,
				'filename' => $tmp_file_name,
				'headers'  => array(
					'Accept-Encoding' => 'identity',
				),
			)
		);

		if ( is_wp_error( $remote_response ) ) {
			@unlink( $tmp_file_name );
			return new WP_Error(
				'import_file_error',
				sprintf(
					/* translators: 1: The WordPress error message. 2: The WordPress error code. */
					__( 'Request failed due to an error: %1$s (%2$s)', 'greenshift-animation-and-page-builder-blocks' ),
					esc_html( $remote_response->get_error_message() ),
					esc_html( $remote_response->get_error_code() )
				)
			);
		}

		$remote_response_code = (int) wp_remote_retrieve_response_code( $remote_response );

		// Make sure the fetch was successful.
		if ( 200 !== $remote_response_code ) {
			@unlink( $tmp_file_name );
			return new WP_Error(
				'import_file_error',
				sprintf(
					/* translators: 1: The HTTP error message. 2: The HTTP error code. */
					__( 'Remote server returned the following unexpected result: %1$s (%2$s)', 'greenshift-animation-and-page-builder-blocks' ),
					get_status_header_desc( $remote_response_code ),
					esc_html( $remote_response_code )
				)
			);
		}

		$headers = wp_remote_retrieve_headers( $remote_response );

		// Request failed.
		if ( ! $headers ) {
			@unlink( $tmp_file_name );
			return new WP_Error( 'import_file_error', __( 'Remote server did not respond', 'greenshift-animation-and-page-builder-blocks' ) );
		}

		$filesize = (int) filesize( $tmp_file_name );

		if ( 0 === $filesize ) {
			@unlink( $tmp_file_name );
			return new WP_Error( 'import_file_error', __( 'Zero size file downloaded', 'greenshift-animation-and-page-builder-blocks' ) );
		}

		if ( ! isset( $headers['content-encoding'] ) && isset( $headers['content-length'] ) && $filesize !== (int) $headers['content-length'] ) {
			@unlink( $tmp_file_name );
			return new WP_Error( 'import_file_error', __( 'Downloaded file has incorrect size', 'greenshift-animation-and-page-builder-blocks' ) );
		}

		$max_size = (int) apply_filters( 'import_attachment_size_limit', 0 );
		if ( ! empty( $max_size ) && $filesize > $max_size ) {
			@unlink( $tmp_file_name );
			return new WP_Error( 'import_file_error', sprintf( __( 'Remote file is too large, limit is %s', 'greenshift-animation-and-page-builder-blocks' ), size_format( $max_size ) ) );
		}

		// Handle the upload like _wp_handle_upload() does.
		$wp_filetype     = wp_check_filetype_and_ext( $tmp_file_name, $file_name );
		$ext             = empty( $wp_filetype['ext'] ) ? '' : $wp_filetype['ext'];
		$type            = empty( $wp_filetype['type'] ) ? '' : $wp_filetype['type'];
		$proper_filename = empty( $wp_filetype['proper_filename'] ) ? '' : $wp_filetype['proper_filename'];

		// Check to see if wp_check_filetype_and_ext() determined the filename was incorrect.
		if ( $proper_filename ) {
			$file_name = $proper_filename;
		}

		if ( ( ! $type || ! $ext ) && ! current_user_can( 'unfiltered_upload' ) ) {
			return new WP_Error( 'import_file_error', __( 'Sorry, this file type is not permitted for security reasons.', 'greenshift-animation-and-page-builder-blocks' ) );
		}

		$uploads = wp_upload_dir( $post['upload_date'] );
		if ( ! ( $uploads && false === $uploads['error'] ) ) {
			return new WP_Error( 'upload_dir_error', $uploads['error'] );
		}

		// Move the file to the uploads dir.
		$file_name     = wp_unique_filename( $uploads['path'], $file_name );
		$new_file      = $uploads['path'] . "/$file_name";
		$move_new_file = copy( $tmp_file_name, $new_file );

		if ( ! $move_new_file ) {
			@unlink( $tmp_file_name );
			return new WP_Error( 'import_file_error', __( 'The uploaded file could not be moved', 'greenshift-animation-and-page-builder-blocks' ) );
		}

		// Set correct file permissions.
		$stat  = stat( dirname( $new_file ) );
		$perms = $stat['mode'] & 0000666;
		chmod( $new_file, $perms );

		$upload = array(
			'file'  => $new_file,
			'url'   => $uploads['url'] . "/$file_name",
			'type'  => $wp_filetype['type'],
			'error' => false,
		);


	if ( is_wp_error( $upload ) ) {
		return $upload;
	}

	$info = wp_check_filetype( $upload['file'] );
	if ( $info ) {
		$post['post_mime_type'] = $info['type'];
	} else {
		return new WP_Error( 'attachment_processing_error', __( 'Invalid file type', 'greenshift-animation-and-page-builder-blocks' ) );
	}

	$post['guid'] = $upload['url'];

	// as per wp-admin/includes/upload.php
	$post_id = wp_insert_attachment( $post, $upload['file'] );
	wp_update_attachment_metadata( $post_id, wp_generate_attachment_metadata( $post_id, $upload['file'] ) );

	return $post_id;
}
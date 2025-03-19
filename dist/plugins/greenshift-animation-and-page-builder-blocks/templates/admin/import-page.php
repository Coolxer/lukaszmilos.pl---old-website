<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
if (!current_user_can('manage_options')) {
    wp_die('Unauthorized user');
}

?>


<div class="wp-block-greenshift-blocks-container alignfull gspb_container gspb_container-gsbp-ead11204-4841" id="gspb_container-id-gsbp-ead11204-4841">
    <div class="wp-block-greenshift-blocks-container gspb_container gspb_container-gsbp-cbc3fa8c-bb26" id="gspb_container-id-gsbp-cbc3fa8c-bb26">

        <?php $activetab = 'import'; ?>
        <?php include(GREENSHIFT_DIR_PATH . 'templates/admin/navleft.php'); ?>


        <div class="wp-block-greenshift-blocks-container gspb_container gspb_container-gsbp-89d45563-1559" id="gspb_container-id-gsbp-89d45563-1559">
            <div class="wp-block-greenshift-blocks-container gspb_container gspb_container-gsbp-efb64efe-d083" id="gspb_container-id-gsbp-efb64efe-d083">
                <h2 id="gspb_heading-id-gsbp-ca0b0ada-6561" class="gspb_heading gspb_heading-id-gsbp-ca0b0ada-6561 "><?php esc_html_e("Import/Export", 'greenshift-animation-and-page-builder-blocks'); ?></h2>
            </div>

            <?php $tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'fse'; ?>
            <div class="class-tabs-gs wp-block-greenshift-blocks-container gspb_container gspb_container-gsbp-01099b45-f36b" id="gspb_container-id-gsbp-01099b45-f36b">
                <a href="?page=greenshift_import&tab=fse" id="gspb_text-id-gsbp-2c96ad79-8324" class="gspb_text gspb_text-id-gsbp-2c96ad79-8324 <?php echo ($tab == 'fse') ? 'gs-tab-active' : ''; ?>"><?php esc_html_e('FSE Templates', 'greenshift-animation-and-page-builder-blocks'); ?></a>
                <a href="?page=greenshift_import&tab=reusable" id="gspb_text-id-gsbp-557ed921-38fe" class="gspb_text gspb_text-id-gsbp-557ed921-38fe <?php echo ($tab == 'reusable') ? 'gs-tab-active' : ''; ?>"><?php esc_html_e('Reusable Templates', 'greenshift-animation-and-page-builder-blocks'); ?></a>
                <a href="?page=greenshift_import&tab=global" id="gspb_text-id-gsbp-557ed921-38fe" class="gspb_text gspb_text-id-gsbp-557ed921-38fe <?php echo ($tab == 'global') ? 'gs-tab-active' : ''; ?>"><?php esc_html_e('Greenshift Global', 'greenshift-animation-and-page-builder-blocks'); ?></a>
            </div>

            <div class="wp-block-greenshift-blocks-container gspb_container gspb_container-gsbp-7b4f8e8f-1a69" id="gspb_container-id-gsbp-7b4f8e8f-1a69">
                <div class="wrap gspb_welcome_div_container">
                    <style>
                        .wp-admin .design-import input[type="file"] {
                            font-weight: 600;
                            background-color: rgba(255, 255, 255, 0.5);
                            border: 1px dashed rgba(0, 0, 0, 0.2);
                            border-radius: 6px;
                            padding: 8px;
                            display: block;
                            margin-top: 1em;
                        }

                        .design-import .has-2-columns {
                            margin-top: 1em;
                            width: calc(100% - 8px);
                            display: grid;
                            grid-template-columns: 49% 49%;
                            grid-column-gap: 2%;
                        }

                        .is-column-upload {
                            padding-right: 20px;
                            border-right: 1px solid #f1f1f1;
                        }

                        .is-column-download {
                            padding-left: 15px
                        }

                        .design-import h2 {
                            font-size: 1.3em;
                            font-weight: 400;
                            margin: 0;
                            padding: 9px 0 14px;
                            line-height: 1.3;
                        }

                        .design-import form.download-form fieldset,
                        .design-import ul.updated-posts {
                            background-color: rgba(255, 255, 255, 0.5);
                            margin-top: 1em;
                            border-radius: 6px;
                        }

                        .design-import .is-font-size-larger {
                            font-size: 1.2em;
                        }

                        .design-import .is-font-weight-400 {
                            font-weight: 400;
                        }

                        .design-import .is-font-weight-600 {
                            font-weight: 600;
                        }

                        .design-import .is-export-designs-group {
                            display: grid;
                        }

                        .design-import .is-design-theme-group.is-current-theme {
                            grid-row: 1;
                        }

                        .design-import .is-design-theme-group {
                            margin: 1em 0;
                            border: 1px dashed rgba(0, 0, 0, 0.2);
                            border-radius: 6px;
                        }

                        .design-import .is-design-theme-name {
                            margin-top: 1em;
                            margin-left: 1em;
                        }

                        .rtl .design-import .is-design-theme-name {
                            margin-right: 1em;
                            margin-left: 0;
                        }

                        .design-import .is-design-option {
                            margin: 0 0 0.5em 2em;
                        }

                        .rtl .design-import .is-design-option {
                            margin: 0 2em 0.5em 0;
                        }

                        .design-import .notice.is-designs-not-available {
                            padding: 0.5em 1em;
                        }

                        .design-import ul.updated-posts li.updated .dashicons-saved,
                        .design-import ul.updated-posts li.updated a {
                            color: #2271b1;
                        }

                        .design-import .is-theme-active,
                        .design-import ul.updated-posts li.imported .dashicons-saved,
                        .design-import ul.updated-posts li.imported a {
                            color: #2ab122;
                        }

                        @media (max-width: 1120px) {
                            .design-import .has-2-columns {
                                grid-template-columns: 100%;
                                grid-column-gap: 0;
                                grid-row-gap: 2em;
                            }
                        }
                    </style>
                    <script>
                        jQuery(document).ready(function($) {
                            $('#design-import-posts-all').on('click', function() {
                                if (this.checked) {
                                    $('.design_import_posts').each(function() {
                                        this.checked = true;
                                    });
                                } else {
                                    $('.design_import_posts').each(function() {
                                        this.checked = false;
                                    });
                                }
                            });
                            $('.design_import_posts').on('click', function() {
                                if ($('.design_import_posts:checked').length == $('.design_import_posts').length) {
                                    $('#design-import-posts-all').prop('checked', true);
                                } else {
                                    $('#design-import-posts-all').prop('checked', false);
                                }
                            });
                        });
                    </script>

                    <div class="gs-padd">
                        <?php
                        if (!current_user_can('export') || !current_user_can('import')) {
                            wp_die('<div class="notice notice-warning notice-priority"><p>' . esc_html__('Please ask your site administrator to enable import and export capabilities for your user account.', 'greenshift-animation-and-page-builder-blocks') . '</p></div>');
                        }

                        if (!wp_is_block_theme() && $tab == 'fse') {
                            echo('<div class="notice notice-warning notice-priority"><p>' . sprintf(
                                /* translators: %1$s: opening <a> tag with themes.php admin link, %2$s: closing </a> tag */
                                esc_html__('This site does not have Full Site Editing enabled. Please install and activate a %1$sblock theme%2$s. Recommended theme - %3$sGreenshift%2$s', 'greenshift-animation-and-page-builder-blocks'),
                                '<a href="' . admin_url('themes.php') . '">',
                                '</a>',
                                '<a href="https://wordpress.org/themes/greenshift/" target="_blank">',
                            ) . '</p></div>');
                        }
                        ?>
                        <div class="wp-block-greenshift-blocks-infobox gspb_infoBox gspb_infoBox-id-gsbp-158b5f3e-b35c" id="gspb_infoBox-id-gsbp-158b5f3e-b35c">
                            <div class="gs-box notice_type icon_type">
                                <div class="gs-box-icon"><svg class="" style="display:inline-block;vertical-align:middle" width="32" height="32" viewBox="0 0 704 1024" xmlns="http://www.w3.org/2000/svg">
                                        <path style="fill:#565D66" d="M352 160c-105.88 0-192 86.12-192 192 0 17.68 14.32 32 32 32s32-14.32 32-32c0-70.6 57.44-128 128-128 17.68 0 32-14.32 32-32s-14.32-32-32-32zM192.12 918.34c0 6.3 1.86 12.44 5.36 17.68l49.020 73.68c5.94 8.92 15.94 14.28 26.64 14.28h157.7c10.72 0 20.72-5.36 26.64-14.28l49.020-73.68c3.48-5.24 5.34-11.4 5.36-17.68l0.1-86.36h-319.92l0.080 86.36zM352 0c-204.56 0-352 165.94-352 352 0 88.74 32.9 169.7 87.12 231.56 33.28 37.98 85.48 117.6 104.84 184.32v0.12h96v-0.24c-0.020-9.54-1.44-19.020-4.3-28.14-11.18-35.62-45.64-129.54-124.34-219.34-41.080-46.86-63.040-106.3-63.22-168.28-0.4-147.28 119.34-256 255.9-256 141.16 0 256 114.84 256 256 0 61.94-22.48 121.7-63.3 168.28-78.22 89.22-112.84 182.94-124.2 218.92-2.805 8.545-4.428 18.381-4.44 28.594l-0 0.006v0.2h96v-0.1c19.36-66.74 71.56-146.36 104.84-184.32 54.2-61.88 87.1-142.84 87.1-231.58 0-194.4-157.6-352-352-352z"></path>
                                    </svg></div>
                                <div class="gs-box-text">
                                    <?php esc_html_e('Before using the importer, it is recommended to save and back up your current design using the Export function.', 'greenshift-animation-and-page-builder-blocks'); ?>
                                    <?php
                                        $terms = get_terms( array(
                                            'taxonomy' => 'wp_theme',
                                            'hide_empty' => false, // Show terms even if they have no posts associated with them.
                                        ) );

                                        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                                            foreach ( $terms as $term ) {
                                                // Check if the term name contains a double quote symbol.
                                                if ( strpos( $term->name, '"' ) !== false ) {
                                                    // Remove double quotes from the term name.
                                                    $new_name = str_replace( '"', '', $term->name );

                                                    // Update the term with the new name.
                                                    $updated_term = wp_update_term( $term->term_id, 'wp_theme', array(
                                                        'name' => $new_name,
                                                    ) );

                                                    if ( ! is_wp_error( $updated_term ) ) {
                                                        echo 'Fixed term ID before importing: ' . $term->term_id . ': ' . esc_html( $new_name ) . '<br>';
                                                    } else {
                                                        echo 'Error updating term ID ' . $term->term_id . ': ' . $updated_term->get_error_message() . '<br>';
                                                    }
                                                }
                                            }
                                        }

                                        ?>
                                </div>
                            </div>
                        </div>
                        <div class="greenshift_form">
                            <div class="wrap design-import">
                                <div class="has-2-columns">

                                    <?php if ($tab == 'fse') : ?>

                                        <div class="column is-column-upload">
                                            <h2><span class="dashicons-before dashicons-upload"></span> <?php esc_html_e('Import your FSE templates.', 'greenshift-animation-and-page-builder-blocks'); ?></h2>
                                            <?php
                                            if (isset($_GET['design_import']) && is_admin() && current_user_can('import') && isset($_GET["_wpnonce"])) {
                                                check_admin_referer('import-upload', '_wpnonce');
                                                greenshift_design_importer();
                                            } else {
                                            ?>
                                                <?php wp_import_upload_form('admin.php?page=greenshift_import&amp;design_import=1'); ?>
                                                <p></p>
                                            <?php
                                            }
                                            ?>
                                        </div>

                                        <div class="column is-column-download">
                                            <h2><span class="dashicons-before dashicons-download"></span> <?php esc_html_e('Export your Full Site Editing design.', 'greenshift-animation-and-page-builder-blocks'); ?></h2>
                                            <p><?php esc_html_e('Click the button below to generate XML file', 'greenshift-animation-and-page-builder-blocks'); ?></p>
                                            <p><?php esc_html_e('Once you&#8217;ve saved the download file, you can use the Import option in another site to import the design from this site.', 'greenshift-animation-and-page-builder-blocks'); ?></p>
                                            <?php
                                            $args = array(
                                                'numberposts' => -1,
                                                'orderby' => 'post_type',
                                                'post_status' => 'publish',
                                                'post_type' => array('wp_template', 'wp_template_part', 'wp_global_styles'),
                                            );
                                            $export_posts = get_posts($args);

                                            if (!empty($export_posts)) {
                                                $nonce = wp_create_nonce('greenshift_import_download');
                                            ?>

                                                <form method="get" class="download-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                                                    <fieldset>
                                                        <input type="hidden" name="action" value="greenshift_export">
                                                        <input type="hidden" name="page" value="greenshift_import" />
                                                        <input type="hidden" name="greenshift_import_download" value="templates" />
                                                        <input type="hidden" name="greenshift_import_nonce" value="<?php echo esc_attr($nonce); ?>" />
                                                        <p class="is-font-weight-600"><label for="design-import-posts-all">
                                                                <input type="checkbox" id="design-import-posts-all" class="design-import-posts-all" value="all" />
                                                                <span><?php esc_html_e('Select all', 'greenshift-animation-and-page-builder-blocks'); ?></span>
                                                            </label></p>
                                                        <div class="is-export-designs-group">
                                                            <?php

                                                            // start - display all saved templates, parts, and global styles
                                                            $current_theme = wp_get_theme()->get_stylesheet();
                                                            $themes_designs = array();

                                                            foreach ($export_posts as $post) {
                                                                $post_terms = wp_get_post_terms($post->ID, 'wp_theme');

                                                                if ($post_terms) {
                                                                    foreach ($post_terms as $post_term) {
                                                                        $themecurrentname = $post_term->name;
                                                                        if ($themecurrentname == 'woocommerce/woocommerce' && $current_theme == 'greenshift') {
                                                                            $themecurrentname = 'greenshift';
                                                                        }
                                                                        $themes_designs[] = array(
                                                                            'id' => $post->ID,
                                                                            'title' => $post->post_title,
                                                                            'type' => $post->post_type,
                                                                            'theme' => $themecurrentname
                                                                        );
                                                                    }
                                                                } else {
                                                                    $themes_designs[] = array(
                                                                        'id' => $post->ID,
                                                                        'title' => $post->post_title,
                                                                        'type' => $post->post_type,
                                                                        'theme' => 'Undefinedtheme'
                                                                    );
                                                                }
                                                            }

                                                            // group by theme
                                                            $themes_designs_group_by = greenshift_design_import_group_by('theme', $themes_designs);
                                                            ksort($themes_designs_group_by);

                                                            foreach ($themes_designs_group_by as $theme_name => $theme_posts) {

                                                                // only want to list data from block themes
                                                                if (wp_get_theme($theme_name)->is_block_theme()) {
                                                                    $theme_active_div_class = '';
                                                                    $theme_active_span = '';
                                                                    if ($current_theme === $theme_name) {
                                                                        $theme_active_div_class = ' is-current-theme';
                                                                        $theme_active_span = '<span class="is-theme-active is-font-weight-400">' . esc_html__(' (active theme)', 'greenshift-animation-and-page-builder-blocks') . '</span>';
                                                                    }

                                                                    echo '<div class="is-design-theme-group' . $theme_active_div_class . '">';
                                                                    if ($theme_name === '' || $theme_name === 'Undefinedtheme') {
                                                                        echo '<p class="is-design-theme-name is-font-weight-600"><em>' . esc_html__('Unknown theme', 'greenshift-animation-and-page-builder-blocks') . '</em></p>';
                                                                    } else {
                                                                        echo '<p class="is-design-theme-name is-font-weight-600">' . esc_html(wp_get_theme($theme_name)) . $theme_active_span . '</p>';
                                                                    }
                                                                    foreach ($theme_posts as $theme_post) {
                                                                        if ($theme_post['type'] === 'wp_template') {
                                                                            $type_name = esc_html__(' (template)', 'greenshift-animation-and-page-builder-blocks');
                                                                        } elseif ($theme_post['type'] === 'wp_template_part') {
                                                                            $type_name = esc_html__(' (template part)', 'greenshift-animation-and-page-builder-blocks');
                                                                        } else {
                                                                            $type_name = '';
                                                                        }
                                                                        echo '<p class="is-design-option"><label for="design_import_posts">
                                                <input type="checkbox" name="design_import_posts[]" class="design_import_posts" value="' . $theme_post['id'] . '" />
                                                <span class="is-font-weight-600">' . $theme_post['title'] . '</span>' . $type_name . '
                                            </label></p>
                                            ';
                                                                    }
                                                                    echo '</div>';
                                                                }
                                                            }
                                                            // end - display all saved templates, parts, and global styles
                                                            ?>
                                                        </div>
                                                    </fieldset>
                                                    <?php submit_button(esc_html__('Download Export File', 'greenshift-animation-and-page-builder-blocks')); ?>
                                                </form>
                                            <?php
                                            } else {
                                            ?>
                                                <p class="notice is-designs-not-available"><em><?php esc_html_e('You currently do not have any customized Templates, Template Parts, or Custom Styles saved in the WordPress database.', 'greenshift-animation-and-page-builder-blocks'); ?></em></p>
                                            <?php submit_button(esc_html__('Download Export File', 'greenshift-animation-and-page-builder-blocks'), 'primary', 'submit', true, array('disabled' => true));
                                            }
                                            ?>
                                        </div>

                                    <?php elseif ($tab === 'reusable') : ?>
                                        <div class="column is-column-upload">
                                            <h2><span class="dashicons-before dashicons-upload"></span> <?php esc_html_e('Import your reusable templates.', 'greenshift-animation-and-page-builder-blocks'); ?></h2>
                                            <?php
                                            if (isset($_GET['design_import']) && is_admin() && current_user_can('import') && isset($_GET["_wpnonce"])) {
                                                check_admin_referer('import-upload', '_wpnonce');
                                                greenshift_design_importer();
                                            } else {
                                            ?>
                                                <?php wp_import_upload_form('admin.php?page=greenshift_import&amp;design_import=1'); ?>
                                                <p></p>
                                            <?php
                                            }
                                            ?>
                                        </div>

                                        <div class="column is-column-download">
                                            <h2><span class="dashicons-before dashicons-download"></span> <?php esc_html_e('Export your reusable templates.', 'greenshift-animation-and-page-builder-blocks'); ?></h2>
                                            <p><?php esc_html_e('Click the button below to generate XML file', 'greenshift-animation-and-page-builder-blocks'); ?></p>
                                            <p><?php esc_html_e('Once you&#8217;ve saved the download file, you can use the Import option in another site to import the design from this site.', 'greenshift-animation-and-page-builder-blocks'); ?></p>
                                            <?php
                                            $args = array(
                                                'numberposts' => -1,
                                                'orderby' => 'post_type',
                                                'post_status' => 'publish',
                                                'post_type' => array('wp_block'),
                                            );
                                            $export_posts = get_posts($args);

                                            if (!empty($export_posts)) {
                                                $nonce = wp_create_nonce('greenshift_import_download');
                                            ?>

                                                <form method="get" class="download-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                                                    <fieldset>
                                                        <input type="hidden" name="action" value="greenshift_export">
                                                        <input type="hidden" name="page" value="greenshift_import" />
                                                        <input type="hidden" name="greenshift_import_download" value="templates" />
                                                        <input type="hidden" name="greenshift_import_nonce" value="<?php echo esc_attr($nonce); ?>" />
                                                        <p class="is-font-weight-600"><label for="design-import-posts-all">
                                                                <input type="checkbox" id="design-import-posts-all" class="design-import-posts-all" value="all" />
                                                                <span><?php esc_html_e('Select all', 'greenshift-animation-and-page-builder-blocks'); ?></span>
                                                            </label></p>
                                                        <div class="is-export-designs-group">
                                                            <?php

                                                            // start - display all saved templates, parts, and global styles
                                                            $reusableblocks = array();

                                                            foreach ($export_posts as $post) {
                                                                $reusableblocks[] = array(
                                                                    'id' => $post->ID,
                                                                    'title' => $post->post_title,
                                                                );
                                                            }

                                                            if (!empty($reusableblocks)) {
                                                                foreach ($reusableblocks as $index => $block) {
                                                                    echo '<p class="is-design-option"><label for="design_import_posts">
                                                    <input type="checkbox" name="design_import_posts[]" class="design_import_posts" value="' . $block['id'] . '" />
                                                    <span class="is-font-weight-600">' . $block['title'] . '</span></label></p>';
                                                                }
                                                            } else {
                                                                echo '<p class="is-design-option">
                                                <span class="is-font-weight-600">' . esc_html__('No reusable blocks found.', 'greenshift-animation-and-page-builder-blocks') . '</p>';
                                                            }

                                                            ?>
                                                        </div>
                                                    </fieldset>
                                                    <?php submit_button(esc_html__('Download Export File', 'greenshift-animation-and-page-builder-blocks')); ?>
                                                </form>
                                            <?php
                                            } else {
                                            ?>
                                                <p class="notice is-designs-not-available"><em><?php esc_html_e('You currently do not have any customized Templates, Template Parts, or Custom Styles saved in the WordPress database.', 'greenshift-animation-and-page-builder-blocks'); ?></em></p>
                                            <?php submit_button(esc_html__('Download Export File', 'greenshift-animation-and-page-builder-blocks'), 'primary', 'submit', true, array('disabled' => true));
                                            }
                                            ?>
                                        </div>
                                    <?php elseif ($tab === 'global') : ?>
                                        <div class="column is-column-upload">
                                            <h2><span class="dashicons-before dashicons-upload"></span> <?php esc_html_e('Import your Greenshift global settings', 'greenshift-animation-and-page-builder-blocks'); ?></h2>
                                            <?php
                                            if (isset($_POST['importaction']) && $_POST['importaction'] === 'greenshift_import_settings') {
                                                if (!isset($_FILES['import_file'])) {
                                                    echo '<p style="color:red">' . esc_html__('Please select a JSON file to import.', 'greenshift-animation-and-page-builder-blocks') . '</p>';
                                                } else {

                                                    check_admin_referer('greenshift_import_settings', 'greenshift_import_settings_nonce');
                                                    $json_file_name = $_FILES['import_file']['name'];
                                                    $json_file_path = $_FILES['import_file']['tmp_name'];

                                                    // Read JSON file
                                                    $json_data = file_get_contents($json_file_path);
                                                    $data = json_decode($json_data, true);
                                                    $data = greenshift_sanitize_multi_array($data);
                                                    $default_settings = get_option('gspb_global_settings');
                                                    $newargs = wp_parse_args($data, $default_settings);

                                                    update_option('gspb_global_settings', $newargs);


                                                    echo '<p style="color:green">' . esc_html__('Data imported successfully from', 'greenshift-animation-and-page-builder-blocks') . ' ' . $json_file_name . '</p>';
                                                }
                                            } else {
                                            ?>
                                                <?php $nonceimport = wp_create_nonce('greenshift_import_settings'); ?>
                                                <form method="post" enctype="multipart/form-data">
                                                    <input type="file" name="import_file">
                                                    <input type="hidden" name="importaction" value="greenshift_import_settings">
                                                    <input type="hidden" name="greenshift_import_settings_nonce" value="<?php echo esc_attr($nonceimport); ?>" />
                                                    <?php submit_button(esc_html__('Import Data', 'greenshift-animation-and-page-builder-blocks')); ?>
                                                </form>
                                            <?php
                                            }
                                            ?>
                                        </div>

                                        <div class="column is-column-download">
                                            <h2><span class="dashicons-before dashicons-download"></span> <?php esc_html_e('Export your Greenshift global settings', 'greenshift-animation-and-page-builder-blocks'); ?></h2>
                                            <p><?php esc_html_e('Click the button below to generate json file', 'greenshift-animation-and-page-builder-blocks'); ?></p>
                                            <p><?php esc_html_e('Once you&#8217;ve saved the download file, you can use the Import option in another site to import the design from this site.', 'greenshift-animation-and-page-builder-blocks'); ?></p>
                                            <?php
                                            $export_posts = get_option('gspb_global_settings');

                                            if (!empty($export_posts)) {
                                                $nonce = wp_create_nonce('greenshift_import_download');
                                            ?>

                                                <form method="get" class="download-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                                                    <fieldset>
                                                        <input type="hidden" name="action" value="greenshift_export">
                                                        <input type="hidden" name="page" value="greenshift_import" />
                                                        <input type="hidden" name="greenshift_import_download" value="settings" />
                                                        <input type="hidden" name="greenshift_import_nonce" value="<?php echo esc_attr($nonce); ?>" />
                                                        <p class="is-font-weight-600"><label for="design-import-posts-all">
                                                                <input type="checkbox" id="design-import-posts-all" class="design-import-posts-all" value="all" />
                                                                <span><?php esc_html_e('Select all', 'greenshift-animation-and-page-builder-blocks'); ?></span>
                                                            </label></p>
                                                        <div class="is-export-designs-group">
                                                            <?php

                                                            // start - display all saved templates, parts, and global styles
                                                            $reusableblocks = array();

                                                            foreach ($export_posts as $key => $post) {
                                                                $name = 'option';
                                                                if ($key == 'jsdelay') {
                                                                    $name = esc_html__('Script Management', 'greenshift-animation-and-page-builder-blocks');;
                                                                } else if ($key == 'breakpoints') {
                                                                    $name = esc_html__('Breakpoints', 'greenshift-animation-and-page-builder-blocks');
                                                                } else if ($key == '_locale') {
                                                                    $name = esc_html__('Localization', 'greenshift-animation-and-page-builder-blocks');
                                                                } else if ($key == 'reusablestyles') {
                                                                    $name = esc_html__('Reusable Styles', 'greenshift-animation-and-page-builder-blocks');
                                                                } else if ($key == 'presets') {
                                                                    $name = esc_html__('Presets', 'greenshift-animation-and-page-builder-blocks');
                                                                } else if ($key == 'localfont') {
                                                                    $name = esc_html__('Local fonts', 'greenshift-animation-and-page-builder-blocks');
                                                                } else if ($key == 'localfontcss') {
                                                                    $name = esc_html__('Local font styles', 'greenshift-animation-and-page-builder-blocks');
                                                                } else if ($key == 'colours') {
                                                                    $name = esc_html__('Greenshift global colors', 'greenshift-animation-and-page-builder-blocks');
                                                                } else if ($key == 'global_classes') {
                                                                    $name = esc_html__('Global Classes', 'greenshift-animation-and-page-builder-blocks');
                                                                } else if ($key == 'elements') {
                                                                    $name = esc_html__('System Elements design', 'greenshift-animation-and-page-builder-blocks');
                                                                } else if ($key == 'typography') {
                                                                    $name = esc_html__('Greenshift typography', 'greenshift-animation-and-page-builder-blocks');
                                                                } else if ($key == 'globalcss') {
                                                                    $name = esc_html__('Greenshift global styles', 'greenshift-animation-and-page-builder-blocks');
                                                                } else if ($key == 'sitesettings') {
                                                                    $name = esc_html__('Greenshift Site settings', 'greenshift-animation-and-page-builder-blocks');
                                                                } else if ($key == 'googleapi') {
                                                                    $name = esc_html__('Google API Key', 'greenshift-animation-and-page-builder-blocks');
                                                                } else if ($key == 'default_attributes') {
                                                                    $name = esc_html__('Custom Default attributes', 'greenshift-animation-and-page-builder-blocks');
                                                                }
                                                                $reusableblocks[] = array(
                                                                    'id' => $key,
                                                                    'title' => $name,
                                                                );
                                                            }

                                                            if (!empty($reusableblocks)) {
                                                                foreach ($reusableblocks as $index => $block) {
                                                                    echo '<p class="is-design-option"><label for="design_import_posts">
                                                    <input type="checkbox" name="design_import_posts[]" class="design_import_posts" value="' . $block['id'] . '" />
                                                    <span class="is-font-weight-600">' . $block['title'] . '</span></label></p>';
                                                                }
                                                            } else {
                                                                echo '<p class="is-design-option">
                                                <span class="is-font-weight-600">' . esc_html__('No reusable blocks found.', 'greenshift-animation-and-page-builder-blocks') . '</p>';
                                                            }

                                                            ?>
                                                        </div>
                                                    </fieldset>
                                                    <?php submit_button(esc_html__('Download Export File', 'greenshift-animation-and-page-builder-blocks')); ?>
                                                </form>
                                            <?php
                                            } else {
                                            ?>
                                                <p class="notice is-designs-not-available"><em><?php esc_html_e('You currently do not have any customized Templates, Template Parts, or Custom Styles saved in the WordPress database.', 'greenshift-animation-and-page-builder-blocks'); ?></em></p>
                                            <?php submit_button(esc_html__('Download Export File', 'greenshift-animation-and-page-builder-blocks'), 'primary', 'submit', true, array('disabled' => true));
                                            }
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
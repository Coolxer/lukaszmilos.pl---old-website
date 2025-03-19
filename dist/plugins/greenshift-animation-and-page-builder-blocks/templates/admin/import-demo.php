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

        <?php $activetab = 'demo'; ?>
        <?php include(GREENSHIFT_DIR_PATH . 'templates/admin/navleft.php'); ?>


        <div class="wp-block-greenshift-blocks-container gspb_container gspb_container-gsbp-89d45563-1559" id="gspb_container-id-gsbp-89d45563-1559">
            <div class="wp-block-greenshift-blocks-container gspb_container gspb_container-gsbp-efb64efe-d083" id="gspb_container-id-gsbp-efb64efe-d083">
                <h2 id="gspb_heading-id-gsbp-ca0b0ada-6561" class="gspb_heading gspb_heading-id-gsbp-ca0b0ada-6561 "><?php esc_html_e("Import Demo Site", 'greenshift-animation-and-page-builder-blocks'); ?></h2>
            </div>


            <div class="wp-block-greenshift-blocks-container gspb_container gspb_container-gsbp-7b4f8e8f-1a69" id="gspb_container-id-gsbp-7b4f8e8f-1a69">
                <div class="gspb_welcome_div_container">
                    <style>
                        .design-import {
                            display: flex;
                            gap: 35px
                        }

                        .demo_import_btns {
                            display: flex;
                            gap: 20px;
                        }

                        .design-import>div {
                            max-width: 50%;
                        }

                        .design-import>div img {
                            max-width: 100%;
                        }

                        .design-import .button {
                            padding: 0 15px;
                            font-size: 15px
                        }


                        .design-import h2 {
                            font-size: 1.6em;
                            font-weight: 400;
                            margin: 0;
                            padding: 0 0 10px 0;
                            line-height: 1.3;
                        }

                        .demo_content p {
                            font-size: 17px;
                            line-height: 28px
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

                        .addon_active {
                            font-size: 0.9em;
                            color: green;
                        }

                        .addon_required a {
                            font-size: 0.9em;
                            color: red;
                        }

                        .import_progress,
                        .hideimport {
                            display: none;
                        }

                        .import_progress.active,
                        .hideimport.active {
                            display: block;
                        }

                        .demo_content .import_progress_loading {
                            display: flex;
                            gap: 15px;
                            font-size: 15px;
                            line-height: 20px;
                            color: #2171b1;
                            padding: 20px;
                            background: #f5f7f7;
                        }

                        .demo_content .import_progress_loading svg {
                            min-width: 20px;
                            width: 20px;
                        }

                        .hideimportbutton {
                            display: inline-block;
                            cursor: pointer;
                            text-decoration: underline;
                        }
                    </style>
                    <script>
                        jQuery(document).ready(function($) {
                            $(document).ready(function() {
                                $('.button').click(function(event) {
                                    event.preventDefault(); //Prevents form submission
                                    $('.import_progress').addClass('active'); //Adds class 'active' to element '.import-process'
                                    $(this).closest('form').submit(); //Submits the form after adding the class 'active'
                                });

                                $('.hideimportbutton').click(function(event) {
                                    $('.hideimport').toggleClass('active');
                                });
                            });
                        });
                    </script>

                    <?php $licenses = greenshift_edd_check_all_licenses(); ?>
                    <?php $is_allinone = false; ?>
                    <?php if (!empty($licenses['all_in_one']) && $licenses['all_in_one'] == 'valid') {
                        $licensesfull = get_option('gspb_edd_licenses');
                        if (!empty($licensesfull['all_in_one']['expires'] && $licensesfull['all_in_one']['expires'] == 'lifetime') && isset($licensesfull['all_in_one']['license_limit']) && $licensesfull['all_in_one']['license_limit'] === 0) {
                            $is_allinone = true;
                        }
                    }
                    ?>

                    <?php $is_woo_license = ((!empty($licenses['all_in_one']) && $licenses['all_in_one'] == 'valid') || (!empty($licenses['woocommerce_addon']) && $licenses['woocommerce_addon'] == 'valid') || (!empty($licenses['all_in_one_woo']) && $licenses['all_in_one_woo'] == 'valid')) ? true : false; ?>
                    <?php $is_woo_active = ($is_woo_license && defined('GREENSHIFTWOO_DIR_URL')) ? true : false; ?>

                    <?php $is_query_license = ((!empty($licenses['all_in_one']) && $licenses['all_in_one'] == 'valid') || (!empty($licenses['query_addon']) && $licenses['query_addon'] == 'valid') || (!empty($licenses['all_in_one_woo']) && $licenses['all_in_one_woo'] == 'valid')) ? true : false; ?>
                    <?php $is_query_active = ($is_query_license && defined('GREENSHIFTQUERY_DIR_URL')) ? true : false; ?>
                    <div class="wp-block-greenshift-blocks-infobox gspb_infoBox gspb_infoBox-id-gsbp-158b5f3e-b35c" id="gspb_infoBox-id-gsbp-158b5f3e-b35c">
                            <div class="gs-box notice_type icon_type">
                                <div class="gs-box-icon"><svg class="" style="display:inline-block;vertical-align:middle" width="32" height="32" viewBox="0 0 704 1024" xmlns="http://www.w3.org/2000/svg">
                                        <path style="fill:#565D66" d="M352 160c-105.88 0-192 86.12-192 192 0 17.68 14.32 32 32 32s32-14.32 32-32c0-70.6 57.44-128 128-128 17.68 0 32-14.32 32-32s-14.32-32-32-32zM192.12 918.34c0 6.3 1.86 12.44 5.36 17.68l49.020 73.68c5.94 8.92 15.94 14.28 26.64 14.28h157.7c10.72 0 20.72-5.36 26.64-14.28l49.020-73.68c3.48-5.24 5.34-11.4 5.36-17.68l0.1-86.36h-319.92l0.080 86.36zM352 0c-204.56 0-352 165.94-352 352 0 88.74 32.9 169.7 87.12 231.56 33.28 37.98 85.48 117.6 104.84 184.32v0.12h96v-0.24c-0.020-9.54-1.44-19.020-4.3-28.14-11.18-35.62-45.64-129.54-124.34-219.34-41.080-46.86-63.040-106.3-63.22-168.28-0.4-147.28 119.34-256 255.9-256 141.16 0 256 114.84 256 256 0 61.94-22.48 121.7-63.3 168.28-78.22 89.22-112.84 182.94-124.2 218.92-2.805 8.545-4.428 18.381-4.44 28.594l-0 0.006v0.2h96v-0.1c19.36-66.74 71.56-146.36 104.84-184.32 54.2-61.88 87.1-142.84 87.1-231.58 0-194.4-157.6-352-352-352z"></path>
                                    </svg></div>
                                <div class="gs-box-text">
                                    <?php esc_html_e('Before using the importer, it is recommended to save and back up your current design using the Export function.', 'greenshift-animation-and-page-builder-blocks'); ?>
                                </div>
                            </div>
                        </div>
                    <div class="gs-padd">
                        <?php
                        if (!current_user_can('export') || !current_user_can('import')) {
                            echo('<div class="notice notice-warning notice-priority"><p>' . esc_html__('Please ask your site administrator to enable import and export capabilities for your user account.', 'greenshift-animation-and-page-builder-blocks') . '</p></div>');
                        }

                        $theme = wp_get_theme();
                        if ($theme->parent_theme) {
                            $template_dir =  basename(get_template_directory());
                            $theme = wp_get_theme($template_dir);
                        }
                        $themename = $theme->get('TextDomain');

                        ?>
                        <?php if($themename != 'greenshift'):?>
                            <div class="wp-block-greenshift-blocks-infobox gspb_infoBox gspb_infoBox-id-gsbp-158b5f3e-b35c" id="gspb_infoBox-id-gsbp-158b5f3e-b35c">
                            <div class="gs-box notice_type icon_type">
                                <div class="gs-box-icon"><svg class="" style="display:inline-block;vertical-align:middle" width="32" height="32" viewBox="0 0 704 1024" xmlns="http://www.w3.org/2000/svg">
                                        <path style="fill:#565D66" d="M352 160c-105.88 0-192 86.12-192 192 0 17.68 14.32 32 32 32s32-14.32 32-32c0-70.6 57.44-128 128-128 17.68 0 32-14.32 32-32s-14.32-32-32-32zM192.12 918.34c0 6.3 1.86 12.44 5.36 17.68l49.020 73.68c5.94 8.92 15.94 14.28 26.64 14.28h157.7c10.72 0 20.72-5.36 26.64-14.28l49.020-73.68c3.48-5.24 5.34-11.4 5.36-17.68l0.1-86.36h-319.92l0.080 86.36zM352 0c-204.56 0-352 165.94-352 352 0 88.74 32.9 169.7 87.12 231.56 33.28 37.98 85.48 117.6 104.84 184.32v0.12h96v-0.24c-0.020-9.54-1.44-19.020-4.3-28.14-11.18-35.62-45.64-129.54-124.34-219.34-41.080-46.86-63.040-106.3-63.22-168.28-0.4-147.28 119.34-256 255.9-256 141.16 0 256 114.84 256 256 0 61.94-22.48 121.7-63.3 168.28-78.22 89.22-112.84 182.94-124.2 218.92-2.805 8.545-4.428 18.381-4.44 28.594l-0 0.006v0.2h96v-0.1c19.36-66.74 71.56-146.36 104.84-184.32 54.2-61.88 87.1-142.84 87.1-231.58 0-194.4-157.6-352-352-352z"></path>
                                    </svg></div>
                                <div class="gs-box-text">
                                    <?php echo(sprintf(
                                /* translators: %1$s: opening <a> tag with themes.php admin link, %2$s: closing </a> tag */
                                esc_html__('Please install and activate a %1$sGreenshift theme%2$s to use demo sites.', 'greenshift-animation-and-page-builder-blocks'),
                                '<a href="https://wordpress.org/themes/greenshift/" target="_blank">',
                                '</a>') . ''); ?>
                                </div>
                            </div>
                        </div>
                        <?php endif;?>
                        <div class="greenshift_form">
                            <div class="design-import">
                                <div class="demo_image">
                                    <img src="<?php echo GREENSHIFT_DIR_URL . 'templates/admin/img/demo1.jpg'; ?>" alt="demo-import">
                                </div>
                                <div class="demo_content">
                                    <h2>Woocommerce Demo shop</h2>
                                    <p><?php esc_html_e("WooCommerce Full Site Editing Theme offers an unparalleled level of customization control.  So if you're ready to take your ecommerce business to the next level, consider using the WooCommerce Full Site Editing Theme as your starting point.", 'greenshift-animation-and-page-builder-blocks'); ?></p>
                                    <p class="addon_require">

                                        <?php if ($is_woo_active) { ?>
                                            <span class="addon_active"><?php esc_html_e("Woocommerce addon is active.", 'greenshift-animation-and-page-builder-blocks'); ?></span><br />
                                        <?php } else { ?>
                                            <span class="addon_required"><a href="<?php echo admin_url('admin.php?page=greenshift_upgrade'); ?>"><?php esc_html_e("Woocommerce addon is required", 'greenshift-animation-and-page-builder-blocks'); ?></a></span><br />
                                        <?php } ?>
                                        <?php if ($is_query_active) { ?>
                                            <span class="addon_active"><?php esc_html_e("Query addon is active.", 'greenshift-animation-and-page-builder-blocks'); ?></span><br />
                                        <?php } else { ?>
                                            <span class="addon_required"><a href="<?php echo admin_url('admin.php?page=greenshift_upgrade'); ?>"><?php esc_html_e("Query addon is required", 'greenshift-animation-and-page-builder-blocks'); ?></a></span><br />
                                        <?php } ?>

                                    </p>
                                    <div class="demo_import_btns">
                                        <form class="importform" method="post" action="<?php echo esc_url(wp_nonce_url('admin.php?page=greenshift_demo&amp;design_import=1', 'import-upload')); ?>">
                                            <p>
                                                <input type="hidden" name="importfile" value="https://shop.greenshiftwp.com/demo/woodemo.xml" />
                                            </p>
                                            <input type="submit" class="button button-primary" value="<?php esc_html_e("Import Demo", 'greenshift-animation-and-page-builder-blocks'); ?>" <?php echo (!$is_woo_active || !$is_query_active) ? "disabled" : ""; ?>>
                                        </form>
                                        <form class="importform" method="post" action="<?php echo esc_url(wp_nonce_url('admin.php?page=greenshift_demo&amp;design_import=1', 'import-upload')); ?>">
                                            <p>
                                                <input type="hidden" name="importfile" value="https://shop.greenshiftwp.com/demo/wootemplates.xml" />
                                            </p>
                                            <input type="submit" class="button button-secondary" value="<?php esc_html_e("Import Only FSE templates", 'greenshift-animation-and-page-builder-blocks'); ?>" <?php echo (!$is_woo_active || !$is_query_active) ? "disabled" : ""; ?>>
                                        </form>
                                    </div>
                                    <div style="margin-bottom:15px"></div>
                                    <?php
                                    echo '                    
                        <div class="import_progress">
                        <p class="import_progress_loading">
                            <svg stroke="#2171b1" version="1.1" id="L2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                                <circle fill="none" stroke-width="4" stroke-miterlimit="10" cx="50" cy="50" r="48"></circle>
                                <line fill="none" stroke-linecap="round" stroke-width="4" stroke-miterlimit="10" x1="50" y1="50" x2="85" y2="50.5">
                                    <animateTransform attributeName="transform" dur="2s" type="rotate" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
                                </line>
                                <line fill="none" stroke-linecap="round" stroke-width="4" stroke-miterlimit="10" x1="50" y1="50" x2="49.5" y2="74">
                                    <animateTransform attributeName="transform" dur="15s" type="rotate" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
                                </line>
                            </svg>
                            ' . esc_html__("Import is in progress. Do not close this page until you get message about import results", "greenshift-animation-and-page-builder-blocks") . '
                        </p>
                    </div>'; ?>
                                    <?php
                                    if (isset($_GET['design_import']) && isset($_POST['importfile']) && current_user_can('import') && isset($_GET["_wpnonce"])) {
                                        check_admin_referer('import-upload', '_wpnonce');
                                        echo '<div class="hideimportbutton">' . esc_html__("Show details", "greenshift-animation-and-page-builder-blocks") . ' +</div>';
                                        @greenshift_design_importer($_POST['importfile']);
                                    }
                                    ?>
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
<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

$plugin_data = get_plugin_data(GREENSHIFT_DIR_PATH . 'plugin.php');
//delete_option('gspb_global_settings');

if (isset($plugin_data['Version'])) {
    $plugin_version = $plugin_data['Version'];
}

$stylebook_post_id = get_option('gspb_stylebook_id');
if ($stylebook_post_id) {
    $stylebooklink = get_edit_post_link($stylebook_post_id);
} else {
    $stylebooklink = admin_url('admin.php?page=greenshift_stylebook');
}
?>

<?php $licenses = get_option('gspb_edd_licenses'); ?>
<?php $is_allinone = false; ?>
<?php if (!empty($licenses['all_in_one']) && $licenses['all_in_one']['status'] == 'valid' && $licenses['all_in_one']['expires'] == 'lifetime') {
    $is_allinone = true;
}

$pluginName = "";
if (!empty($licenses)) {
    foreach ($licenses as $item) {
        if ($item["status"] === "valid") {
            $pluginName = $item["plugin_name"];
            break;
        }
    }
}

?>
<div class="wp-block-greenshift-blocks-container gspb_container gspb_container-gsbp-ecfa9f32-682f" id="gspb_container-id-gsbp-ecfa9f32-682f">
    <div class="wp-block-greenshift-blocks-container gspb_container gspb_container-gsbp-306c24ec-8b8e" id="gspb_container-id-gsbp-306c24ec-8b8e">
        <div class="wp-block-greenshift-blocks-container gspb_container gspb_container-gsbp-e6dccbfa-f119" id="gspb_container-id-gsbp-e6dccbfa-f119">
            <div class="wp-block-greenshift-blocks-image gspb_image gspb_image-id-gsbp-1286d0f0-1ae9" id="gspb_image-id-gsbp-1286d0f0-1ae9"><img decoding="async" loading="lazy" src="<?php echo GREENSHIFT_DIR_URL . 'templates/admin/img/icon.png'; ?>" data-src="" alt="" height="22"></div>


            <div id="gspb_text-id-gsbp-d1cca294-fdf1" class="gspb_text gspb_text-id-gsbp-d1cca294-fdf1 "><mark style="background-color:rgba(0, 0, 0, 0);color:#714b8f" class="has-inline-color"><?php if ($plugin_version) echo 'V' . $plugin_version; ?></mark> – <?php if ($pluginName) {echo esc_attr($pluginName);
            } else {
                esc_html_e("Free version", 'greenshift-animation-and-page-builder-blocks');
            } ?> </div>
        </div>

        <?php if (!$is_allinone) : ?>
            <div class="gspb_button_wrapper gspb_button-id-gsbp-f10bf7a1-69a3" id="gspb_button-id-gsbp-f10bf7a1-69a3"><a href="<?php echo admin_url('admin.php?page=greenshift_upgrade');?>" class="wp-block-greenshift-blocks-buttonbox gspb-buttonbox wp-element-button" rel="noopener"><span class="gspb-buttonbox-textwrap"><span class="gspb-buttonbox-text">
                <span class="gspb-buttonbox-title">
                    <?php if ($pluginName) : ?>
                        <?php esc_html_e("Upgrade Plan", 'greenshift-animation-and-page-builder-blocks'); ?>
                    <?php else : ?>
                        <?php esc_html_e("Upgrade Now", 'greenshift-animation-and-page-builder-blocks'); ?>
                    <?php endif; ?>
                </span></span></span></a>
            </div>
        <?php endif; ?>

        <div class="wp-block-greenshift-blocks-iconlist gspb_iconsList gspb_iconsList-id-gsbp-843b958c-d873" id="gspb_iconsList-id-gsbp-843b958c-d873">
            <div class="gspb_iconsList__item<?php echo $activetab == 'start' ? ' active' : ''; ?>" data-id="0"><a class="gspb_iconsList__link" href="<?php echo admin_url('admin.php?page=greenshift_dashboard');?>" rel="noopener"></a><svg class="" style="display:inline-block;vertical-align:middle" width="18" height="18" viewBox="0 0 704 1024" xmlns="http://www.w3.org/2000/svg">
                    <path style="fill:#565D66" d="M352 160c-105.88 0-192 86.12-192 192 0 17.68 14.32 32 32 32s32-14.32 32-32c0-70.6 57.44-128 128-128 17.68 0 32-14.32 32-32s-14.32-32-32-32zM192.12 918.34c0 6.3 1.86 12.44 5.36 17.68l49.020 73.68c5.94 8.92 15.94 14.28 26.64 14.28h157.7c10.72 0 20.72-5.36 26.64-14.28l49.020-73.68c3.48-5.24 5.34-11.4 5.36-17.68l0.1-86.36h-319.92l0.080 86.36zM352 0c-204.56 0-352 165.94-352 352 0 88.74 32.9 169.7 87.12 231.56 33.28 37.98 85.48 117.6 104.84 184.32v0.12h96v-0.24c-0.020-9.54-1.44-19.020-4.3-28.14-11.18-35.62-45.64-129.54-124.34-219.34-41.080-46.86-63.040-106.3-63.22-168.28-0.4-147.28 119.34-256 255.9-256 141.16 0 256 114.84 256 256 0 61.94-22.48 121.7-63.3 168.28-78.22 89.22-112.84 182.94-124.2 218.92-2.805 8.545-4.428 18.381-4.44 28.594l-0 0.006v0.2h96v-0.1c19.36-66.74 71.56-146.36 104.84-184.32 54.2-61.88 87.1-142.84 87.1-231.58 0-194.4-157.6-352-352-352z"></path>
                </svg><span class="gspb_iconsList__item__text"><?php esc_html_e("Get Started", 'greenshift-animation-and-page-builder-blocks'); ?></span></div>
            <?php echo do_action('greenshift_admin_menu'); ?>
            <div class="gspb_iconsList__item" data-id="5"><a class="gspb_iconsList__link" href="<?php echo '' . $stylebooklink; ?>" rel="noopener"></a><svg class="" style="display:inline-block;vertical-align:middle" width="18" height="18" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                    <path style="fill:#565D66" d="M1008 768h-624v-80c0-26.6-21.4-48-48-48h-96c-26.6 0-48 21.4-48 48v80h-176c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h176v80c0 26.6 21.4 48 48 48h96c26.6 0 48-21.4 48-48v-80h624c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zM320 896h-64v-192h64v192zM1008 192h-496v-80c0-26.6-21.4-48-48-48h-96c-26.6 0-48 21.4-48 48v80h-304c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h304v80c0 26.6 21.4 48 48 48h96c26.6 0 48-21.4 48-48v-80h496c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zM448 320h-64v-192h64v192zM1008 480h-176v-80c0-26.6-21.4-48-48-48h-96c-26.6 0-48 21.4-48 48v80h-624c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h624v80c0 26.6 21.4 48 48 48h96c26.6 0 48-21.4 48-48v-80h176c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zM768 608h-64v-192h64v192z"></path>
                </svg><span class="gspb_iconsList__item__text"><?php esc_html_e("Stylebook", 'greenshift-animation-and-page-builder-blocks'); ?></span>
            </div>
            <div class="gspb_iconsList__item<?php echo $activetab == 'settings' ? ' active' : ''; ?>" data-id="1"><a class="gspb_iconsList__link" href="<?php echo admin_url('admin.php?page=greenshift');?>" rel="noopener"></a><svg class="" style="display:inline-block;vertical-align:middle" width="18" height="18" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                    <path style="fill:#565D66" d="M965.392 598.552l-65.22-37.654c1.958-14.684 3.075-31.661 3.075-48.899s-1.117-34.215-3.284-50.863l0.209 1.964 65.22-37.654c19.152-11.056 28.39-33.804 22.092-55.002-22.428-75.498-62.35-143.456-115.070-199.19-15.268-16.14-39.634-19.672-58.874-8.564l-65.124 37.596c-24.475-18.797-52.351-35.208-82.151-47.995l-2.527-0.965v-75.228c0-22.26-15.304-41.608-36.968-46.734-75.288-17.818-154.236-17.82-229.54 0-21.662 5.126-36.968 24.472-36.968 46.734v75.228c-32.327 13.752-60.203 30.162-85.603 49.641l0.925-0.681-65.124-37.596c-19.242-11.108-43.608-7.576-58.874 8.564-52.72 55.734-92.642 123.694-115.070 199.19-6.298 21.198 2.94 43.944 22.092 55.002l65.22 37.654c-1.958 14.684-3.075 31.661-3.075 48.899s1.117 34.215 3.284 50.863l-0.209-1.964-65.22 37.654c-19.152 11.056-28.39 33.804-22.092 55.002 22.428 75.496 62.35 143.456 115.070 199.19 15.268 16.14 39.634 19.672 58.874 8.566l65.124-37.596c24.474 18.798 52.351 35.207 82.151 47.994l2.527 0.964v75.228c0 22.26 15.304 41.608 36.968 46.734 75.29 17.818 154.236 17.82 229.54 0 21.662-5.126 36.968-24.472 36.968-46.734v-75.228c32.326-13.752 60.203-30.162 85.604-49.64l-0.926 0.682 65.124 37.596c19.24 11.108 43.606 7.576 58.874-8.566 52.72-55.734 92.642-123.694 115.070-199.19 6.298-21.198-2.94-43.944-22.092-55.002zM834.434 799.474l-92.618-53.48c-53.976 46.142-73.118 57.752-142.078 82.118v106.958c-26.375 5.694-56.676 8.955-87.738 8.955s-61.363-3.261-90.578-9.459l2.84 0.504v-106.958c-67.242-23.758-86.71-34.79-142.078-82.118l-92.618 53.48c-39.42-44.18-69.378-95.978-87.858-151.916l92.658-53.48c-13.070-70.834-13.076-93.288 0-164.158l-92.658-53.48c18.48-55.938 48.44-107.738 87.858-151.938l92.618 53.52c54.754-46.868 74.126-58.13 142.078-82.138v-106.956c26.376-5.703 56.675-8.97 87.738-8.97s61.363 3.267 90.575 9.475l-2.837-0.505v106.958c67.956 24.010 87.33 35.274 142.078 82.138l92.618-53.52c39.418 44.198 69.378 95.998 87.858 151.938l-92.658 53.48c13.072 70.852 13.076 93.288 0 164.158l92.658 53.48c-18.48 55.936-48.438 107.736-87.858 151.914zM512 320c-105.87 0-192 86.13-192 192s86.13 192 192 192 192-86.13 192-192-86.13-192-192-192zM512 640c-70.58 0-128-57.42-128-128s57.42-128 128-128 128 57.42 128 128-57.42 128-128 128z"></path>
                </svg><span class="gspb_iconsList__item__text"><?php esc_html_e("Global Settings", 'greenshift-animation-and-page-builder-blocks'); ?></span></div>
            <div class="gspb_iconsList__item<?php echo $activetab == 'addons' ? ' active' : ''; ?>" data-id="2"><a class="gspb_iconsList__link" href="<?php echo admin_url('admin.php?page=greenshift_dashboard-addons');?>" rel="noopener"></a><svg class="" style="display:inline-block;vertical-align:middle" width="18" height="18" viewBox="0 0 1152 1024" xmlns="http://www.w3.org/2000/svg">
                    <path style="fill:#565D66" d="M1133.638 454.754l-208.884-287.218c-17.658-24.078-45.844-39.536-77.64-39.536l-542.228 0c-0-0-0.001-0-0.001-0-31.795 0-59.98 15.458-77.449 39.268l-0.188 0.268-208.886 287.218c-11.474 15.625-18.362 35.239-18.362 56.463 0 0 0 0.001 0 0.001l-0-0v288.782c0 53.020 42.98 96 96 96h960c53.020 0 96-42.98 96-96v-288.782c0-0 0-0.001 0-0.001 0-21.223-6.888-40.838-18.55-56.731l0.188 0.268zM279.006 205.178c5.896-8.014 15.285-13.162 25.877-13.178l0.003-0h542.23c10.204 0 19.878 4.926 25.88 13.178l176.596 242.822h-273.146l-64 128h-272.892l-64-128h-273.146l176.598-242.822zM1088 544v256c0 17.646-14.356 32-32 32h-960c-17.644 0-32-14.354-32-32v-256c0-17.674 14.326-32 32-32h240l64 128h352l64-128h240c17.674 0 32 14.326 32 32z"></path>
                </svg><span class="gspb_iconsList__item__text"><?php esc_html_e("Addons", 'greenshift-animation-and-page-builder-blocks'); ?></span></div>
            <div class="gspb_iconsList__item<?php echo $activetab == 'license' ? ' active' : ''; ?>" data-id="3"><a class="gspb_iconsList__link" href="<?php echo admin_url('admin.php?page=greenshift-license');?>" rel="noopener"></a><svg class="" style="display:inline-block;vertical-align:middle" width="18" height="18" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                    <path style="fill:#565D66" d="M512 160c-123.712 0-224 100.288-224 224s100.288 224 224 224 224-100.288 224-224-100.288-224-224-224zM512 544c-88.384 0-160-71.616-160-160s71.616-160 160-160 160 71.616 160 160-71.616 160-160 160zM864.672 557.952c25.696-51.52 40.544-109.248 40.544-170.528 0-213.984-176.064-387.424-393.216-387.424s-393.216 173.44-393.216 387.392c0 61.28 14.848 119.008 40.544 170.528l-159.584 272.352c0 0 101.216 20.32 203.904 41.44 68.48 76.224 136.64 152.288 136.64 152.288l146.752-250.432c8.32 0.544 16.576 1.248 24.992 1.248s16.672-0.704 24.992-1.248l146.72 250.432c0 0 68.16-76.064 136.64-152.288 102.688-21.12 203.904-41.44 203.904-41.44l-159.616-272.32zM332.672 907.84c0 0-49.152-46.624-95.36-91.52-65.536-18.624-131.648-37.632-131.648-37.632l92.736-158.272c53.536 69.792 130.272 121.024 219.104 142.656l-84.832 144.768zM512 704.256c-176.576 0-319.68-143.424-319.68-320.352s143.104-320.352 319.68-320.352 319.68 143.424 319.68 320.352-143.104 320.352-319.68 320.352zM786.72 816.32c-46.208 44.896-95.36 91.52-95.36 91.52l-84.8-144.768c88.8-21.632 165.568-72.864 219.104-142.656l92.736 158.272c-0.032 0-66.144 19.008-131.68 37.632z"></path>
                </svg><span class="gspb_iconsList__item__text"><?php esc_html_e("License Manager", 'greenshift-animation-and-page-builder-blocks'); ?></span></div>
            <div class="gspb_iconsList__item<?php echo $activetab == 'import' ? ' active' : ''; ?>" data-id="4"><a class="gspb_iconsList__link" href="<?php echo admin_url('admin.php?page=greenshift_import');?>" rel="noopener"></a><svg class="" style="display:inline-block;vertical-align:middle" width="18" height="18" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                    <path style="fill:#565D66" d="M819.52 819.2h-179.52c-14.139 0-25.6-11.461-25.6-25.6s11.461-25.6 25.6-25.6h179.52c84.518 0 153.28-68.762 153.28-153.28s-68.762-153.28-153.28-153.28c-18.005 0-35.626 3.086-52.368 9.173-11.168 4.056-23.654-0.099-30.163-10.035-6.507-9.938-5.323-23.048 2.859-31.659 18.154-19.106 28.152-44.15 28.152-70.518 0-56.464-45.936-102.4-102.4-102.4-32.858 0-62.912 15.187-82.456 41.667-11.704 15.859-18.533 34.638-19.746 54.307-0.67 10.867-8.141 20.122-18.622 23.069-10.482 2.946-21.682-1.059-27.915-9.984l-0.238-0.342c-5.49-7.795-11.549-15.443-17.952-22.653-48.587-54.694-118.374-86.064-191.47-86.064-141.158 0-256 114.842-256 256 0 141.16 114.842 256 256 256h128c14.138 0 25.6 11.461 25.6 25.6s-11.462 25.6-25.6 25.6h-128c-169.39 0-307.2-137.81-307.2-307.2s137.81-307.2 307.2-307.2c82.050 0 160.621 32.933 218.142 90.901 4.47-9.989 10.026-19.52 16.608-28.438 28.867-39.112 75.090-62.462 123.65-62.462 84.696 0 153.6 68.904 153.6 153.6 0 17.976-3.099 35.542-9.035 52.050 3.11-0.139 6.23-0.21 9.357-0.21 112.75 0 204.48 91.73 204.48 204.48-0.002 112.75-91.731 204.48-204.482 204.48z"></path>
                    <path style="fill:#565D66" d="M658.101 621.899l-102.4-102.4c-9.997-9.997-26.206-9.997-36.203 0l-102.4 102.4c-9.997 9.997-9.997 26.206 0 36.203 9.998 9.997 26.206 9.997 36.205 0l58.698-58.698v194.195c0 14.139 11.461 25.6 25.6 25.6s25.6-11.461 25.6-25.6v-194.195l58.699 58.698c4.998 4.998 11.549 7.498 18.101 7.498s13.102-2.499 18.101-7.499c9.998-9.997 9.998-26.205 0-36.202z"></path>
                </svg><span class="gspb_iconsList__item__text"><?php esc_html_e("Import/Export", 'greenshift-animation-and-page-builder-blocks'); ?></span></div>
            <div class="gspb_iconsList__item<?php echo $activetab == 'demo' ? ' active' : ''; ?>" data-id="4"><a class="gspb_iconsList__link" href="<?php echo admin_url('admin.php?page=greenshift_demo');?>" rel="noopener"></a>

                <svg class="" width="18" height="18" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" style="display: inline-block; vertical-align: middle;">
                    <path style="fill:#565D66" d="M864 0h-704c-70.688 0-128 57.312-128 128v768c0 70.688 57.312 128 128 128h704c70.688 0 128-57.312 128-128v-768c0-70.688-57.312-128-128-128zM928 896c0 35.328-28.672 64-64 64h-704c-35.328 0-64-28.672-64-64v-64h832v64zM928 768h-832v-640c0-35.328 28.672-64 64-64h704c35.328 0 64 28.672 64 64v640zM648.576 425.024l-104.576 126.496v-391.52c0-17.664-14.304-32-32-32s-32 14.336-32 32v392.736l-105.568-127.712c-12.544-12.576-32.864-12.576-45.408 0-12.576 12.608-12.576 32.96 0 45.568l158.112 191.36c6.72 6.688 15.584 9.568 24.352 9.088 8.736 0.48 17.632-2.4 24.352-9.088l158.112-191.36c12.576-12.608 12.576-32.96 0-45.568-12.512-12.544-32.864-12.544-45.376 0z" style="fill: rgb(86, 93, 102);"></path>
                </svg>

                <span class="gspb_iconsList__item__text"><?php esc_html_e("Demo Site Import", 'greenshift-animation-and-page-builder-blocks'); ?></span>
            </div>
        </div>
    </div>

    <div class="gs-settings-contact-sidebar">
        <div><a class="gs-settings-contact-sidebar-social" href="https://www.facebook.com/groups/greenshiftwp">
                <svg xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" height="15px" viewBox="0 0 509 509">
                    <g fill-rule="nonzero">
                        <path fill="#0866FF" d="M509 254.5C509 113.94 395.06 0 254.5 0S0 113.94 0 254.5C0 373.86 82.17 474 193.02 501.51V332.27h-52.48V254.5h52.48v-33.51c0-86.63 39.2-126.78 124.24-126.78 16.13 0 43.95 3.17 55.33 6.33v70.5c-6.01-.63-16.44-.95-29.4-.95-41.73 0-57.86 15.81-57.86 56.91v27.5h83.13l-14.28 77.77h-68.85v174.87C411.35 491.92 509 384.62 509 254.5z" />
                        <path fill="#fff" d="M354.18 332.27l14.28-77.77h-83.13V227c0-41.1 16.13-56.91 57.86-56.91 12.96 0 23.39.32 29.4.95v-70.5c-11.38-3.16-39.2-6.33-55.33-6.33-85.04 0-124.24 40.16-124.24 126.78v33.51h-52.48v77.77h52.48v169.24c19.69 4.88 40.28 7.49 61.48 7.49 10.44 0 20.72-.64 30.83-1.86V332.27h68.85z" />
                    </g>
                </svg> Facebook
            </a></div>
        <div><a class="gs-settings-contact-sidebar-social" href="https://twitter.com/GreenshiftWP">
                <svg xmlns="http://www.w3.org/2000/svg" height="15px" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 512 512">
                    <path d="M256 0c141.385 0 256 114.615 256 256S397.385 512 256 512 0 397.385 0 256 114.615 0 256 0z" />
                    <path fill="#fff" fill-rule="nonzero" d="M318.64 157.549h33.401l-72.973 83.407 85.85 113.495h-67.222l-52.647-68.836-60.242 68.836h-33.423l78.052-89.212-82.354-107.69h68.924l47.59 62.917 55.044-62.917zm-11.724 176.908h18.51L205.95 176.493h-19.86l120.826 157.964z" />
                </svg> XTwitter
            </a></div>
        <div class="gspb_button_wrapper gspb_button-id-gsbp-4d513305-5349" id="gspb_button-id-gsbp-4d513305-5349"><a class="wp-block-greenshift-blocks-buttonbox gspb-buttonbox wp-element-button" href="<?php echo admin_url('admin.php?page=greenshift_contact');?>" rel="noopener"><span class="gspb-buttonbox-textwrap"><span class="gspb-buttonbox-text"><span class="gspb-buttonbox-title"><?php esc_html_e("Support/Contact Us", 'greenshift-animation-and-page-builder-blocks'); ?></span></span></span></a></div>
    </div>
</div>
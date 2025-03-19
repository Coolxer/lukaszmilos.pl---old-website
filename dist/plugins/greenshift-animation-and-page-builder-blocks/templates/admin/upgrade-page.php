<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap gspb_upgrade_div_container">
    <style>
        #wpcontent {
            background: #fff;
            padding: 0 !important;
        }

        h2.gspb_heading {
            margin: 25px 0 30px 0 !important;
        }

        .gspb_heading_subtitle {
            margin-top: 15px !important;
        }

        .wrap {
            margin: 0 auto;
        }

        .wrap .notice,
        .wrap .error {
            display: none
        }

        .wrap h2 {
            font-size: 1.4em;
            margin-bottom: 1.5em;
            margin-top: 0;
            font-weight: bold;
        }

        .gs-intro-video {
            margin-bottom: 40px
        }

        .wrap h1 {
            text-align: left;
            padding: 15px 20px;
            margin: -1px -1px 60px -1px;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            box-shadow: 0 3px 8px rgb(0 0 0 / 5%);
        }

        .gs-padd {
            font-size: 15px;
            line-height: 24px;
        }

        .rtl .gs-padd {
            text-align: right
        }

        .wp-core-ui .button-primary {
            background-color: #2184f9
        }

        .nav-tab {
            font-size: 16px;
            border: none;
            padding: 10px 16px;
            background: none;
            border-bottom: 2px solid transparent;
        }

        .nav-tab-active,
        .nav-tab-active:focus,
        .nav-tab-active:focus:active,
        .nav-tab:hover {
            border-bottom: 2px solid #2184f9;
            background: #fff;
            color: #2184f9;
        }

        .nav-tab-wrapper {
            padding-left: 20px;
            background: white;
            border-bottom: 1px solid #edeff5;
        }

        .nav-tab-wrapper>div {
            margin: 0 auto;
            max-width: 950px
        }

        .wrap .fs-notice {
            margin: 0 25px 35px 25px !important
        }

        .wrap .fs-plugin-title {
            display: none !important
        }

        .gs_main_text {
            font-size: 15px;
            margin-bottom: 12px;
        }

        .gs_main_text a {
            color: #2184f9
        }

        .mb30 {
            margin-bottom: 30px
        }
    </style>

    <style>

.gspb-badge {
    position: absolute;
    top: 10px;
    right: 0;
    background: #71ae00;
    color: white;
    text-transform: uppercase;
    padding: 5px 10px;
    border-radius: 3px 0 0 3px;
    font-weight: bold;
    border-right: 0;
    box-shadow: 0 2px 1px -1px rgb(0 0 0 / 30%);
}
        #gspb_row-id-gsbp-6bf4e066-ce14.gspb_row {
            justify-content: space-between;
            margin-top: 0px;
            margin-bottom: 0px;
            position: relative;
            display: flex;
            flex-wrap: wrap;
        }

        #gspb_row-id-gsbp-6bf4e066-ce14.gspb_row>.gspb_row__content {
            display: flex;
            justify-content: space-between;
            margin: 0 auto;
            width: 100%;
            flex-wrap: wrap;
        }

        #gspb_row-id-gsbp-6bf4e066-ce14.gspb_row div[class^=gspb_row__col] {
            flex-direction: column;
            position: relative;
        }

        #gspb_row-id-gsbp-6bf4e066-ce14.gspb_row .gspb_row__col--24,
        #gspb_row-id-gsbp-6bf4e066-ce14.gspb_row .gspb_row__col--12,
        #gspb_row-id-gsbp-6bf4e066-ce14.gspb_row .gspb_row__col--11,
        #gspb_row-id-gsbp-6bf4e066-ce14.gspb_row .gspb_row__col--10,
        #gspb_row-id-gsbp-6bf4e066-ce14.gspb_row .gspb_row__col--9,
        #gspb_row-id-gsbp-6bf4e066-ce14.gspb_row .gspb_row__col--8,
        #gspb_row-id-gsbp-6bf4e066-ce14.gspb_row .gspb_row__col--7,
        #gspb_row-id-gsbp-6bf4e066-ce14.gspb_row .gspb_row__col--6,
        #gspb_row-id-gsbp-6bf4e066-ce14.gspb_row .gspb_row__col--5,
        #gspb_row-id-gsbp-6bf4e066-ce14.gspb_row .gspb_row__col--4,
        #gspb_row-id-gsbp-6bf4e066-ce14.gspb_row .gspb_row__col--3,
        #gspb_row-id-gsbp-6bf4e066-ce14.gspb_row .gspb_row__col--2,
        #gspb_row-id-gsbp-6bf4e066-ce14.gspb_row .gspb_row__col--1 {
            padding: 15px min(3vw, 20px);
            box-sizing: border-box;
        }

        #gspb_row-id-gsbp-6bf4e066-ce14.gspb_row>.gspb_row__content {
            max-width: 1250px;
        }

        #gspb_row-id-gsbp-6bf4e066-ce14.gspb_row .gspb_shape-divider-container {
            overflow: hidden;
            position: absolute;
            left: 0;
            z-index: -1;
            width: 100%;
            line-height: 0;
            pointer-events: none
        }

        #gspb_row-id-gsbp-6bf4e066-ce14.gspb_row .gspb_shape-divider-container svg {
            width: 100%;
        }

        #gspb_row-id-gsbp-6bf4e066-ce14.gspb_row .gspb_shape-divider-container--top {
            top: 0;
        }

        #gspb_row-id-gsbp-6bf4e066-ce14.gspb_row .gspb_shape-divider-container--top {
            top: 125px;
        }

        #gspb_row-id-gsbp-6bf4e066-ce14.gspb_row {
            margin-top: 40px;
            margin-bottom: 80px;
        }

        #gspb_row-id-gsbp-6bf4e066-ce14.gspb_row {
            z-index: 0;
        }
    </style>


    <?php $licenses = greenshift_edd_check_all_licenses(); ?>
    <?php $is_allinone = false; ?>
    <?php if (!empty($licenses['all_in_one']) && $licenses['all_in_one'] == 'valid') {
        $licensesfull = get_option('gspb_edd_licenses');
        if (!empty($licensesfull['all_in_one']['expires'] && $licensesfull['all_in_one']['expires'] == 'lifetime') && isset($licensesfull['all_in_one']['license_limit']) && $licensesfull['all_in_one']['license_limit'] === 0) {
            $is_allinone = true;
        }
    }
    ?>

    <div class="gs-padd">
        <div class="greenshift_form">
        <?php if ($is_allinone) : ?>
                <div class="gspb_welcome_div_container">
                    <style>
                        .wrap {
                            background: white;
                            max-width: 900px;
                            margin: 2.5em auto;
                            border: 1px solid #dbdde2;
                            box-shadow: 0 10px 20px #ececec;
                            text-align: center
                        }

                        .wrap .notice,
                        .wrap .error {
                            display: none
                        }

                        .wrap h2 {
                            font-size: 1.5em;
                            margin-bottom: 1em;
                            font-weight: bold
                        }

                        .gs-introtext {
                            font-size: 14px;
                            max-width: 500px;
                            margin: 0 auto 30px auto
                        }

                        .gs-intro-video iframe {
                            box-shadow: 10px 10px 20px rgb(0 0 0 / 15%);
                        }

                        .gs-intro-video {
                            margin-bottom: 15px
                        }

                        .wrap h1 {
                            text-align: left;
                            padding: 15px 20px;
                            margin: -1px -1px 0 -1px;
                            font-size: 13px;
                            font-weight: bold;
                            text-transform: uppercase;
                            box-shadow: 0 3px 8px rgb(0 0 0 / 5%);
                        }

                        .wrap .fs-notice {
                            margin: 0 25px 25px 25px !important
                        }

                        .wrap .fs-plugin-title {
                            display: none !important
                        }

                        .gridrows {
                            display: grid;
                            grid-template-columns: repeat(2, minmax(0, 1fr));
                            gap: 20px
                        }

                        .gridrows div {
                            padding: 20px;
                            border: 1px solid #e4eff9;
                            background: #f3f8ff;
                            font-size: 16px
                        }

                        .gridrows div a {
                            text-decoration: none
                        }

                        .gs-padd {
                            padding: 25px
                        }
                    </style>
                    <h1><?php esc_html_e("All in ONE Lifetime - Active", 'greenshift-animation-and-page-builder-blocks'); ?></h1>
                    <div class="gs-padd">
                        <p><img src="<?php echo GREENSHIFT_DIR_URL . 'edd/img/top.webp'; ?>" height="200" width="200" /></p>
                        <p class="gs-introtext"><?php esc_html_e("Congratulations, You have our Best available plan", 'greenshift-animation-and-page-builder-blocks'); ?></p>
                    </div>
                </div>
            <?php else : ?>
            <div id="gspb_row-id-gsbp-6bf4e066-ce14" class="gspb_row gspb_row-id-gsbp-6bf4e066-ce14 wp-block-greenshift-blocks-row alignfull gspb_row-id-gsbp-6bf4e066-ce14">
                <div class="gspb_shape-divider-container gspb_shape-divider-container--top"><svg data-style="23" x="0px" y="0px" viewBox="0 0 1200 480" preserveAspectRatio="none">
                        <path class="gspb_st2 gspb_shape_2" data-style="23" d="M0,480 L0,128 C650.666667,262.933333 1050.66667,220.266667 1200,0 L1200,480 L0,480 Z" fill="url(#sfirsttopgsbp-6bf4e066-ce14)"></path>
                        <path class="gspb_st1 gspb_shape_1" data-style="23" d="M0,480 L0,274.666667 C722.666667,350.933333 1122.66667,266.044444 1200,20 L1200,480 L0,480 Z" fill="url(#ssecondtopgsbp-6bf4e066-ce14)"></path>
                        <path class="gspb_st0 gspb_shape_0" data-style="23" d="M0,480 L0,421.333333 C800,421.333333 1200,294.222222 1200,40 L1200,480 L0,480 Z" fill="url(#sthirdtopgsbp-6bf4e066-ce14)"></path>
                        <defs>
                            <linearGradient id="sfirsttopgsbp-6bf4e066-ce14">
                                <stop style="stop-color:#dee9fb26" offset="0%"></stop>
                                <stop style="stop-color:#ffd800" offset="100%"></stop>
                            </linearGradient>
                            <linearGradient id="ssecondtopgsbp-6bf4e066-ce14">
                                <stop style="stop-color:#edf5ff" offset="67%"></stop>
                                <stop style="stop-color:#7000f4" offset="100%"></stop>
                            </linearGradient>
                            <linearGradient id="sthirdtopgsbp-6bf4e066-ce14">
                                <stop style="stop-color:#fefefe" offset="0%"></stop>
                                <stop style="stop-color:#ffffff" offset="100%"></stop>
                            </linearGradient>
                        </defs>
                    </svg></div>
                <div class="gspb_row__content">
                    <style>
                        #gspb_col-id-gsbp-dad1d489-ef98.gspb_row__col--12 {
                            width: 100%;
                        }

                        @media (max-width:575.98px) {
                            #gspb_col-id-gsbp-dad1d489-ef98.gspb_row__col--12 {
                                width: 100%;
                            }
                        }

                        @media (max-width:575.98px) {
                            .gspb_row.wp-block-greenshift-blocks-row #gspb_col-id-gsbp-dad1d489-ef98.gspb_row__col--12 {
                                padding-top: 0px;
                                padding-right: 0px;
                                padding-bottom: 0px;
                                padding-left: 0px;
                            }
                        }
                    </style>
                    <div id="gspb_col-id-gsbp-dad1d489-ef98" class="gspb_row__col--12 wp-block-greenshift-blocks-row-column  gspb_col-id-gsbp-dad1d489-ef98">
                        <style>
                            #gspb_heading-id-gsbp-e95a13f1-4654,
                            #gspb_heading-id-gsbp-e95a13f1-4654 .wp-block,
                            #gspb_heading-id-gsbp-e95a13f1-4654 .gsap-g-line {
                                text-align: center !important;
                            }

                            #gspb_heading-id-gsbp-e95a13f1-4654,
                            #gspb_heading-id-gsbp-e95a13f1-4654 .wp-block {
                                color: #7000f4;
                            }

                            #gspb_heading-id-gsbp-e95a13f1-4654 {
                                margin-bottom: 20px;
                            }
                        </style>
                        <div id="gspb_heading-id-gsbp-e95a13f1-4654" class="gspb_heading gspb_heading-id-gsbp-e95a13f1-4654 ">SAVE MONEY WITH BUNDLES</div>


                        <style>
                            #gspb_heading-id-gsbp-f8cb7ee3-6475,
                            #gspb_heading-id-gsbp-f8cb7ee3-6475 .wp-block {
                                font-size: 44px;
                                line-height: 48px;
                            }

                            #gspb_heading-id-gsbp-f8cb7ee3-6475,
                            #gspb_heading-id-gsbp-f8cb7ee3-6475 .wp-block,
                            #gspb_heading-id-gsbp-f8cb7ee3-6475 .gsap-g-line {
                                text-align: center !important;
                            }

                            #gspb_heading-id-gsbp-f8cb7ee3-6475 {
                                margin-bottom: 50px;
                            }
                        </style>
                        <div id="gspb_heading-id-gsbp-f8cb7ee3-6475" class="gspb_heading gspb_heading-id-gsbp-f8cb7ee3-6475 "><strong>Get everything together</strong></div>


                        <style>
                            #gspb_container-id-gsbp-99f4fb65-0d34.gspb_container {
                                position: relative;
                                flex-direction: column;
                                box-sizing: border-box;
                            }

                            #gspb_container-id-gsbp-99f4fb65-0d34.gspb_container .gspb_container__content {
                                margin: auto;
                            }

                            #gspb_container-id-gsbp-99f4fb65-0d34.gspb_container>p:last-of-type {
                                margin-bottom: 0
                            }

                            #gspb_container-id-gsbp-99f4fb65-0d34.gspb_container {
                                display: grid;
                                grid-template-columns: repeat(3, minmax(0, 1fr));
                                row-gap: 20px;
                                column-gap: 40px;
                            }

                            @media (max-width:991.98px) {
                                #gspb_container-id-gsbp-99f4fb65-0d34.gspb_container {
                                    grid-template-columns: repeat(1, minmax(0, 1fr));
                                    row-gap: 50px;
                                }
                            }

                            @media (max-width:767.98px) {
                                #gspb_container-id-gsbp-99f4fb65-0d34.gspb_container {
                                    grid-template-columns: repeat(1, minmax(0, 1fr));
                                    row-gap: 50px;
                                }
                            }

                            @media (max-width:575.98px) {
                                #gspb_container-id-gsbp-99f4fb65-0d34.gspb_container {
                                    grid-template-columns: repeat(1, minmax(0, 1fr));
                                    row-gap: 60px;
                                }
                            }

                            #gspb_container-id-gsbp-99f4fb65-0d34.gspb_container {
                                padding-top: 20px;
                                padding-bottom: 20px;
                            }
                        </style>
                        <div id="gspb_container-id-gsbp-99f4fb65-0d34" class="gspb_container gspb_container-gsbp-99f4fb65-0d34 wp-block-greenshift-blocks-container">
                            <style>
                                #gspb_container-id-gsbp-d6862809-361c.gspb_container {
                                    position: relative;
                                    flex-direction: column;
                                    box-sizing: border-box;
                                }

                                #gspb_container-id-gsbp-d6862809-361c.gspb_container .gspb_container__content {
                                    margin: auto;
                                }

                                #gspb_container-id-gsbp-d6862809-361c.gspb_container>p:last-of-type {
                                    margin-bottom: 0
                                }

                                #gspb_container-id-gsbp-d6862809-361c.gspb_container {
                                    padding-top: 20px;
                                    padding-right: 30px;
                                    padding-bottom: 20px;
                                    padding-left: 30px;
                                }

                                #gspb_container-id-gsbp-d6862809-361c.gspb_container {
                                    background-color: #f1fbf5;
                                }
                            </style>
                            <div id="gspb_container-id-gsbp-d6862809-361c" class="gspb_container gspb_container-gsbp-d6862809-361c wp-block-greenshift-blocks-container">
                                <style>
                                    #gspb_heading-id-gsbp-239514b7-dfb6,
                                    #gspb_heading-id-gsbp-239514b7-dfb6 .wp-block {
                                        font-size: 32px;
                                    }

                                    #gspb_heading-id-gsbp-239514b7-dfb6 {
                                        margin-bottom: 30px;
                                        padding-bottom: 30px;
                                    }

                                    #gspb_heading-id-gsbp-239514b7-dfb6 {
                                        border-bottom-style: solid;
                                        border-bottom-width: 1px;
                                        border-bottom-color: #2c2c2c;
                                    }

                                    #gspb_heading-id-gsbp-239514b7-dfb6 .gspb_heading_subtitle,
                                    #gspb_subheading-id-gsbp-239514b7-dfb6 {
                                        display: block;
                                        font-size: 17px;
                                        line-height: 22px;
                                        margin-top: 5px
                                    }

                                    #gspb_heading-id-gsbp-239514b7-dfb6 .gspb_heading_subtitle,
                                    #gspb_subheading-id-gsbp-239514b7-dfb6,
                                    #gspb_heading-id-gsbp-239514b7-dfb6 .gspb_heading_subtitle,
                                    #gspb_subheading-id-gsbp-239514b7-dfb6 .wp-block {
                                        color: #3d3d3d;
                                    }
                                </style>
                                <?php if (!empty($licenses['all_in_one_design']) && $licenses['all_in_one_design'] == 'valid') : ?>
                                    <div class="gspb-badge">Active</div>
                                <?php endif; ?>
                                <h2 id="gspb_heading-id-gsbp-239514b7-dfb6" class="gspb_heading gspb_heading-id-gsbp-239514b7-dfb6 "><strong>Design Pack</strong><span class="gspb_heading_subtitle">Build complex layouts easily</span></h2>


                                <style>
                                    #gspb_iconsList-id-gsbp-6b7c292f-cbad.gspb_iconsList .gspb_iconsList__item__text {
                                        margin-left: 15px;
                                    }

                                    #gspb_iconsList-id-gsbp-6b7c292f-cbad.gspb_iconsList .gspb_iconsList__item {
                                        display: flex;
                                        flex-direction: row;
                                        align-items: center;
                                        position: relative;
                                    }

                                    #gspb_iconsList-id-gsbp-6b7c292f-cbad.gspb_iconsList .gspb_iconsList__item svg path {
                                        fill: #2184f9 !important
                                    }

                                    #gspb_iconsList-id-gsbp-6b7c292f-cbad.gspb_iconsList .gspb_iconsList__item {
                                        margin-bottom: 10px;
                                    }

                                    #gspb_iconsList-id-gsbp-6b7c292f-cbad.gspb_iconsList [data-id='0'] svg,
                                    #gspb_iconsList-id-gsbp-6b7c292f-cbad.gspb_iconsList [data-id='0'] svg path {
                                        fill: #00d084 !important;
                                    }

                                    #gspb_iconsList-id-gsbp-6b7c292f-cbad.gspb_iconsList [data-id='1'] svg,
                                    #gspb_iconsList-id-gsbp-6b7c292f-cbad.gspb_iconsList [data-id='1'] svg path {
                                        fill: #00d084 !important;
                                    }

                                    #gspb_iconsList-id-gsbp-6b7c292f-cbad.gspb_iconsList [data-id='2'] svg,
                                    #gspb_iconsList-id-gsbp-6b7c292f-cbad.gspb_iconsList [data-id='2'] svg path {
                                        fill: #00d084 !important;
                                    }

                                    #gspb_iconsList-id-gsbp-6b7c292f-cbad.gspb_iconsList [data-id='3'] svg,
                                    #gspb_iconsList-id-gsbp-6b7c292f-cbad.gspb_iconsList [data-id='3'] svg path {
                                        fill: #00d084 !important;
                                    }
                                </style>
                                <div id="gspb_iconsList-id-gsbp-6b7c292f-cbad" class="gspb_iconsList gspb_iconsList-id-gsbp-6b7c292f-cbad wp-block-greenshift-blocks-iconlist">
                                    <div class="gspb_iconsList__item" data-id="0"><svg class="" style="display:inline-block;vertical-align:middle" width="18" height="18" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                                            <path style="fill:#565D66" d="M871.696 166.932l-526.088 526.088-193.304-193.304c-9.372-9.372-24.568-9.372-33.942 0l-56.568 56.568c-9.372 9.372-9.372 24.568 0 33.942l266.842 266.842c9.372 9.372 24.568 9.372 33.942 0l599.626-599.626c9.372-9.372 9.372-24.568 0-33.942l-56.568-56.568c-9.372-9.372-24.568-9.372-33.94 0z"></path>
                                        </svg><span class="gspb_iconsList__item__text"><a href="https://shop.greenshiftwp.com/downloads/query-addon/" target="_blank" rel="noreferrer noopener">Query Addon and listings</a></span></div>
                                    <div class="gspb_iconsList__item" data-id="1"><svg class="" style="display:inline-block;vertical-align:middle" width="18" height="18" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                                            <path style="fill:#565D66" d="M871.696 166.932l-526.088 526.088-193.304-193.304c-9.372-9.372-24.568-9.372-33.942 0l-56.568 56.568c-9.372 9.372-9.372 24.568 0 33.942l266.842 266.842c9.372 9.372 24.568 9.372 33.942 0l599.626-599.626c9.372-9.372 9.372-24.568 0-33.942l-56.568-56.568c-9.372-9.372-24.568-9.372-33.94 0z"></path>
                                        </svg><span class="gspb_iconsList__item__text"><a href="https://shop.greenshiftwp.com/downloads/advanced-animation-addon/">Animation Addon</a></span></div>
                                    <div class="gspb_iconsList__item" data-id="2"><svg class="" style="display:inline-block;vertical-align:middle" width="18" height="18" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                                            <path style="fill:#565D66" d="M871.696 166.932l-526.088 526.088-193.304-193.304c-9.372-9.372-24.568-9.372-33.942 0l-56.568 56.568c-9.372 9.372-9.372 24.568 0 33.942l266.842 266.842c9.372 9.372 24.568 9.372 33.942 0l599.626-599.626c9.372-9.372 9.372-24.568 0-33.942l-56.568-56.568c-9.372-9.372-24.568-9.372-33.94 0z"></path>
                                        </svg><span class="gspb_iconsList__item__text">Animated Section Library</span></div>
                                    <div class="gspb_iconsList__item" data-id="3"><svg class="" style="display:inline-block;vertical-align:middle" width="18" height="18" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                                            <path style="fill:#565D66" d="M871.696 166.932l-526.088 526.088-193.304-193.304c-9.372-9.372-24.568-9.372-33.942 0l-56.568 56.568c-9.372 9.372-9.372 24.568 0 33.942l266.842 266.842c9.372 9.372 24.568 9.372 33.942 0l599.626-599.626c9.372-9.372 9.372-24.568 0-33.942l-56.568-56.568c-9.372-9.372-24.568-9.372-33.94 0z"></path>
                                        </svg><span class="gspb_iconsList__item__text">Premium Support</span></div>
                                </div>


                                <style>
                                    .gspb_button-id-gsbp-db16fef3-8cee {
                                        display: flex;
                                        justify-content: flex-start;
                                    }

                                    .gspb_button-id-gsbp-db16fef3-8cee .gspb-buttonbox-text {
                                        display: flex;
                                        flex-direction: column;
                                    }

                                    .gspb_button-id-gsbp-db16fef3-8cee>.gspb-buttonbox {
                                        display: inline-block;
                                        padding: 13px 26px;
                                        background-color: #00d084;
                                        text-decoration: none !important;
                                        color: #fff;
                                        font-size: 16px;
                                        line-height: 16px;
                                        position: relative;
                                        z-index: 0;
                                        cursor: pointer;
                                        box-sizing: border-box
                                    }

                                    .gspb_button-id-gsbp-db16fef3-8cee>.gspb-buttonbox {
                                        margin-top: 20px;
                                        margin-bottom: 20px;
                                        padding-top: 20px;
                                        padding-right: 20px;
                                        padding-bottom: 20px;
                                        padding-left: 20px;
                                    }

                                    .gspb_button-id-gsbp-db16fef3-8cee>.gspb-buttonbox {
                                        background-color: #000000;
                                    }

                                    .gspb_button-id-gsbp-db16fef3-8cee>.gspb-buttonbox {
                                        width: 100%;
                                    }

                                    .gspb_button-id-gsbp-db16fef3-8cee>.gspb-buttonbox,
                                    .gspb_button-id-gsbp-db16fef3-8cee>.gspb-buttonbox .wp-block,
                                    .gspb_button-id-gsbp-db16fef3-8cee>.gspb-buttonbox .gsap-g-line {
                                        text-align: center !important;
                                    }

                                    .gspb_button-id-gsbp-db16fef3-8cee>.gspb-buttonbox:hover {
                                        box-shadow: 0 15px 30px 0 rgba(119, 123, 146, 0.1);
                                    }

                                    .gspb_button-id-gsbp-db16fef3-8cee>.gspb-buttonbox {
                                        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
                                    }

                                    .gspb_button-id-gsbp-db16fef3-8cee>.gspb-buttonbox:hover {
                                        transform: scale(1.06);
                                    }
                                </style>
                                <div id="gspb_button-id-gsbp-db16fef3-8cee" class="gspb_button_wrapper gspb_button-id-gsbp-db16fef3-8cee wp-block-greenshift-blocks-button"><a class="gspb-buttonbox" href="https://shop.greenshiftwp.com/downloads/design-pack/" target="_blank" rel="noopener"><span class="gspb-buttonbox-textwrap"><span class="gspb-buttonbox-text"><span class="gspb-buttonbox-title">from $39.99</span></span></span></a></div>


                                <style>
                                    #gspb_iconsList-id-gsbp-ccada676-253a.gspb_iconsList .gspb_iconsList__item__text {
                                        margin-left: 15px;
                                    }

                                    #gspb_iconsList-id-gsbp-ccada676-253a.gspb_iconsList .gspb_iconsList__item {
                                        display: flex;
                                        flex-direction: row;
                                        align-items: center;
                                        position: relative;
                                    }

                                    #gspb_iconsList-id-gsbp-ccada676-253a.gspb_iconsList .gspb_iconsList__item svg path {
                                        fill: #2184f9 !important
                                    }

                                    #gspb_iconsList-id-gsbp-ccada676-253a.gspb_iconsList .gspb_iconsList__item {
                                        margin-bottom: 6px;
                                    }

                                    #gspb_iconsList-id-gsbp-ccada676-253a.gspb_iconsList [data-id='0'] svg,
                                    #gspb_iconsList-id-gsbp-ccada676-253a.gspb_iconsList [data-id='0'] svg path {
                                        fill: #de1414 !important;
                                    }

                                    #gspb_iconsList-id-gsbp-ccada676-253a.gspb_iconsList [data-id='1'] svg,
                                    #gspb_iconsList-id-gsbp-ccada676-253a.gspb_iconsList [data-id='1'] svg path {
                                        fill: #de1414 !important;
                                    }
                                </style>
                                <div id="gspb_iconsList-id-gsbp-ccada676-253a" class="gspb_iconsList gspb_iconsList-id-gsbp-ccada676-253a wp-block-greenshift-blocks-iconlist">
                                    <div class="gspb_iconsList__item" data-id="0"><svg class="" style="display:inline-block;vertical-align:middle" width="18" height="18" viewBox="0 0 896 1024" xmlns="http://www.w3.org/2000/svg">
                                            <path style="fill:#565D66" d="M647.12 102.4c-41.6 38.6-79.16 79.18-112.44 119.94-54.52-75.1-122.12-151.28-198.68-222.34-196.52 182.34-336 419.92-336 563.2 0 254.5 200.58 460.8 448 460.8s448-206.3 448-460.8c0-106.54-103.96-326.28-248.88-460.8zM608.18 783.7c-43.32 30.32-96.74 48.3-154.46 48.3-144.3 0-261.72-95.48-261.72-250.5 0-77.22 48.62-145.26 145.58-261.5 13.86 15.96 197.66 250.68 197.66 250.68l117.26-133.76c8.28 13.7 15.82 27.1 22.54 39.94 54.7 104.38 31.62 237.94-66.86 306.84z"></path>
                                        </svg><span class="gspb_iconsList__item__text">5 Sites – from $49.99</span></div>
                                    <div class="gspb_iconsList__item" data-id="1"><svg class="" style="display:inline-block;vertical-align:middle" width="18" height="18" viewBox="0 0 1152 1024" xmlns="http://www.w3.org/2000/svg">
                                            <path style="fill:#565D66" d="M927.4 0h-702.8c-8.4 0-16.2 4.4-20.6 11.6l-200.6 325.6c-5.4 8.8-4.4 20.2 2.4 28l552 650.4c9.6 11.2 26.8 11.2 36.4 0l552-650.4c6.8-7.8 7.6-19.2 2.4-28l-200.6-325.6c-4.4-7.2-12.2-11.6-20.6-11.6zM900.2 72l148.6 248h-166l-113.6-248h131zM690 72l113.6 248h-455.4l113.8-248h228zM251.8 72h131l-113.6 248h-166l148.6-248zM122.4 384h146l163.6 384-309.6-384zM346.4 384h459l-229.4 527.6-229.6-527.6zM720 768l163.6-384h146l-309.6 384z"></path>
                                        </svg><span class="gspb_iconsList__item__text">Unlimited – from $79.99</span></div>
                                </div>
                            </div>


                            <style>
                                #gspb_container-id-gsbp-f8f4bccd-4800.gspb_container {
                                    position: relative;
                                    flex-direction: column;
                                    box-sizing: border-box;
                                }

                                #gspb_container-id-gsbp-f8f4bccd-4800.gspb_container .gspb_container__content {
                                    margin: auto;
                                }

                                #gspb_container-id-gsbp-f8f4bccd-4800.gspb_container>p:last-of-type {
                                    margin-bottom: 0
                                }

                                #gspb_container-id-gsbp-f8f4bccd-4800.gspb_container {
                                    transform: scale(1.1);
                                }

                                #gspb_container-id-gsbp-f8f4bccd-4800.gspb_container {
                                    padding-top: 20px;
                                    padding-right: 30px;
                                    padding-bottom: 20px;
                                    padding-left: 30px;
                                }

                                @media (max-width:991.98px) {
                                    #gspb_container-id-gsbp-f8f4bccd-4800.gspb_container {
                                        padding-top: 20px;
                                        padding-right: 60px;
                                        padding-bottom: 20px;
                                        padding-left: 60px;
                                    }
                                }

                                @media (max-width:767.98px) {
                                    #gspb_container-id-gsbp-f8f4bccd-4800.gspb_container {
                                        padding-top: 20px;
                                        padding-right: 50px;
                                        padding-bottom: 20px;
                                        padding-left: 50px;
                                    }
                                }

                                #gspb_container-id-gsbp-f8f4bccd-4800.gspb_container {
                                    background-color: #fbf4ff;
                                }
                            </style>
                            <div id="gspb_container-id-gsbp-f8f4bccd-4800" class="gspb_container gspb_container-gsbp-f8f4bccd-4800 wp-block-greenshift-blocks-container">
                                <style>
                                    #gspb_heading-id-gsbp-09309dbe-68e6,
                                    #gspb_heading-id-gsbp-09309dbe-68e6 .wp-block {
                                        font-size: 32px;
                                    }

                                    #gspb_heading-id-gsbp-09309dbe-68e6 {
                                        margin-bottom: 30px;
                                        padding-bottom: 30px;
                                    }

                                    #gspb_heading-id-gsbp-09309dbe-68e6 {
                                        border-bottom-style: solid;
                                        border-bottom-width: 1px;
                                        border-bottom-color: #2c2c2c;
                                    }

                                    #gspb_heading-id-gsbp-09309dbe-68e6 .gspb_heading_subtitle,
                                    #gspb_subheading-id-gsbp-09309dbe-68e6 {
                                        display: block;
                                        font-size: 17px;
                                        line-height: 22px;
                                        margin-top: 5px
                                    }

                                    #gspb_heading-id-gsbp-09309dbe-68e6 .gspb_heading_subtitle,
                                    #gspb_subheading-id-gsbp-09309dbe-68e6,
                                    #gspb_heading-id-gsbp-09309dbe-68e6 .gspb_heading_subtitle,
                                    #gspb_subheading-id-gsbp-09309dbe-68e6 .wp-block {
                                        color: #3d3d3d;
                                    }
                                </style>
                                <?php if (!empty($licenses['all_in_one_design']) && $licenses['all_in_one_design'] == 'valid') : ?>
                                    <div class="gspb-badge">Active</div>
                                <?php endif; ?>
                                <h2 id="gspb_heading-id-gsbp-09309dbe-68e6" class="gspb_heading gspb_heading-id-gsbp-09309dbe-68e6 "><strong><strong>All in One</strong></strong><span class="gspb_heading_subtitle"><strong>Get everything + future addons</strong></span></h2>


                                <style>
                                    #gspb_iconsList-id-gsbp-cbc009aa-6bed.gspb_iconsList .gspb_iconsList__item__text {
                                        margin-left: 15px;
                                    }

                                    #gspb_iconsList-id-gsbp-cbc009aa-6bed.gspb_iconsList .gspb_iconsList__item {
                                        display: flex;
                                        flex-direction: row;
                                        align-items: center;
                                        position: relative;
                                    }

                                    #gspb_iconsList-id-gsbp-cbc009aa-6bed.gspb_iconsList .gspb_iconsList__item svg path {
                                        fill: #2184f9 !important
                                    }

                                    #gspb_iconsList-id-gsbp-cbc009aa-6bed.gspb_iconsList .gspb_iconsList__item {
                                        margin-bottom: 10px;
                                    }

                                    #gspb_iconsList-id-gsbp-cbc009aa-6bed.gspb_iconsList [data-id='0'] svg,
                                    #gspb_iconsList-id-gsbp-cbc009aa-6bed.gspb_iconsList [data-id='0'] svg path {
                                        fill: #00d084 !important;
                                    }

                                    #gspb_iconsList-id-gsbp-cbc009aa-6bed.gspb_iconsList [data-id='1'] svg,
                                    #gspb_iconsList-id-gsbp-cbc009aa-6bed.gspb_iconsList [data-id='1'] svg path {
                                        fill: #00d084 !important;
                                    }

                                    #gspb_iconsList-id-gsbp-cbc009aa-6bed.gspb_iconsList [data-id='2'] svg,
                                    #gspb_iconsList-id-gsbp-cbc009aa-6bed.gspb_iconsList [data-id='2'] svg path {
                                        fill: #00d084 !important;
                                    }

                                    #gspb_iconsList-id-gsbp-cbc009aa-6bed.gspb_iconsList [data-id='3'] svg,
                                    #gspb_iconsList-id-gsbp-cbc009aa-6bed.gspb_iconsList [data-id='3'] svg path {
                                        fill: #00d084 !important;
                                    }

                                    #gspb_iconsList-id-gsbp-cbc009aa-6bed.gspb_iconsList [data-id='4'] svg,
                                    #gspb_iconsList-id-gsbp-cbc009aa-6bed.gspb_iconsList [data-id='4'] svg path {
                                        fill: #00d084 !important;
                                    }
                                </style>
                                <div id="gspb_iconsList-id-gsbp-cbc009aa-6bed" class="gspb_iconsList gspb_iconsList-id-gsbp-cbc009aa-6bed wp-block-greenshift-blocks-iconlist">
                                    <div class="gspb_iconsList__item" data-id="0"><svg class="" style="display:inline-block;vertical-align:middle" width="18" height="18" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                                            <path style="fill:#565D66" d="M871.696 166.932l-526.088 526.088-193.304-193.304c-9.372-9.372-24.568-9.372-33.942 0l-56.568 56.568c-9.372 9.372-9.372 24.568 0 33.942l266.842 266.842c9.372 9.372 24.568 9.372 33.942 0l599.626-599.626c9.372-9.372 9.372-24.568 0-33.942l-56.568-56.568c-9.372-9.372-24.568-9.372-33.94 0z"></path>
                                        </svg><span class="gspb_iconsList__item__text">All from Design and SEO</span></div>
                                    <div class="gspb_iconsList__item" data-id="1"><svg class="" style="display:inline-block;vertical-align:middle" width="18" height="18" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                                            <path style="fill:#565D66" d="M871.696 166.932l-526.088 526.088-193.304-193.304c-9.372-9.372-24.568-9.372-33.942 0l-56.568 56.568c-9.372 9.372-9.372 24.568 0 33.942l266.842 266.842c9.372 9.372 24.568 9.372 33.942 0l599.626-599.626c9.372-9.372 9.372-24.568 0-33.942l-56.568-56.568c-9.372-9.372-24.568-9.372-33.94 0z"></path>
                                        </svg><span class="gspb_iconsList__item__text"><a href="https://shop.greenshiftwp.com/downloads/greenshift-chart-plugin/" target="_blank" rel="noreferrer noopener">Chart Addon</a></span></div>
                                    <div class="gspb_iconsList__item" data-id="2"><svg class="" style="display:inline-block;vertical-align:middle" width="18" height="18" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                                            <path style="fill:#565D66" d="M871.696 166.932l-526.088 526.088-193.304-193.304c-9.372-9.372-24.568-9.372-33.942 0l-56.568 56.568c-9.372 9.372-9.372 24.568 0 33.942l266.842 266.842c9.372 9.372 24.568 9.372 33.942 0l599.626-599.626c9.372-9.372 9.372-24.568 0-33.942l-56.568-56.568c-9.372-9.372-24.568-9.372-33.94 0z"></path>
                                        </svg><span class="gspb_iconsList__item__text"><a href="https://shop.greenshiftwp.com/downloads/woocommerce-addon/" target="_blank" rel="noreferrer noopener">Woocommerce Addon</a></span></div>
                                    <div class="gspb_iconsList__item" data-id="3"><svg class="" style="display:inline-block;vertical-align:middle" width="18" height="18" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                                            <path style="fill:#565D66" d="M871.696 166.932l-526.088 526.088-193.304-193.304c-9.372-9.372-24.568-9.372-33.942 0l-56.568 56.568c-9.372 9.372-9.372 24.568 0 33.942l266.842 266.842c9.372 9.372 24.568 9.372 33.942 0l599.626-599.626c9.372-9.372 9.372-24.568 0-33.942l-56.568-56.568c-9.372-9.372-24.568-9.372-33.94 0z"></path>
                                        </svg><span class="gspb_iconsList__item__text">FSE Shop template</span></div>
                                    <div class="gspb_iconsList__item" data-id="4"><svg class="" style="display:inline-block;vertical-align:middle" width="18" height="18" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                                            <path style="fill:#565D66" d="M871.696 166.932l-526.088 526.088-193.304-193.304c-9.372-9.372-24.568-9.372-33.942 0l-56.568 56.568c-9.372 9.372-9.372 24.568 0 33.942l266.842 266.842c9.372 9.372 24.568 9.372 33.942 0l599.626-599.626c9.372-9.372 9.372-24.568 0-33.942l-56.568-56.568c-9.372-9.372-24.568-9.372-33.94 0z"></path>
                                        </svg><span class="gspb_iconsList__item__text">Premium Support</span></div>
                                </div>


                                <style>
                                    .gspb_button-id-gsbp-86ef8289-fb15 {
                                        display: flex;
                                        justify-content: flex-start;
                                    }

                                    .gspb_button-id-gsbp-86ef8289-fb15 .gspb-buttonbox-text {
                                        display: flex;
                                        flex-direction: column;
                                    }

                                    .gspb_button-id-gsbp-86ef8289-fb15>.gspb-buttonbox {
                                        display: inline-block;
                                        padding: 13px 26px;
                                        background-color: #00d084;
                                        text-decoration: none !important;
                                        color: #fff;
                                        font-size: 16px;
                                        line-height: 16px;
                                        position: relative;
                                        z-index: 0;
                                        cursor: pointer;
                                        box-sizing: border-box
                                    }

                                    .gspb_button-id-gsbp-86ef8289-fb15>.gspb-buttonbox {
                                        margin-top: 20px;
                                        margin-bottom: 20px;
                                        padding-top: 20px;
                                        padding-bottom: 20px;
                                    }

                                    .gspb_button-id-gsbp-86ef8289-fb15>.gspb-buttonbox {
                                        background-image: linear-gradient(135deg, rgb(64, 129, 246) 0%, rgb(128, 104, 250) 18%, rgb(255, 128, 170) 38%, rgb(255, 103, 88) 56%, rgb(255, 101, 24) 65%, rgb(255, 177, 36) 76%);
                                    }

                                    .gspb_button-id-gsbp-86ef8289-fb15>.gspb-buttonbox {
                                        width: 100%;
                                    }

                                    .gspb_button-id-gsbp-86ef8289-fb15>.gspb-buttonbox,
                                    .gspb_button-id-gsbp-86ef8289-fb15>.gspb-buttonbox .wp-block {
                                        font-size: 17px;
                                    }

                                    .gspb_button-id-gsbp-86ef8289-fb15>.gspb-buttonbox,
                                    .gspb_button-id-gsbp-86ef8289-fb15>.gspb-buttonbox .wp-block,
                                    .gspb_button-id-gsbp-86ef8289-fb15>.gspb-buttonbox .gsap-g-line {
                                        text-align: center !important;
                                    }

                                    .gspb_button-id-gsbp-86ef8289-fb15>.gspb-buttonbox,
                                    .gspb_button-id-gsbp-86ef8289-fb15>.gspb-buttonbox .wp-block {
                                        font-weight: bold !important;
                                    }

                                    .gspb_button-id-gsbp-86ef8289-fb15>.gspb-buttonbox {
                                        border-top-left-radius: 3px;
                                        border-top-right-radius: 3px;
                                        border-bottom-right-radius: 3px;
                                        border-bottom-left-radius: 3px;
                                    }

                                    .gspb_button-id-gsbp-86ef8289-fb15>.gspb-buttonbox>.gspb_backgroundOverlay {
                                        border-top-left-radius: 3px;
                                        border-top-right-radius: 3px;
                                        border-bottom-right-radius: 3px;
                                        border-bottom-left-radius: 3px;
                                    }

                                    .gspb_button-id-gsbp-86ef8289-fb15>.gspb-buttonbox {
                                        box-shadow: 0 1px 2px 0 #450070c7, 0px 18px 10px -10px #ff71003d;
                                    }

                                    .gspb_button-id-gsbp-86ef8289-fb15>.gspb-buttonbox:hover {
                                        box-shadow: 0 1px 1px 0px #ba52ffad;
                                    }

                                    .gspb-buttonbox {
                                        background-size: 200% 200%;
                                    }

                                    .gspb-buttonbox:hover {
                                        background-position: 100% 0
                                    }

                                    .gspb_button-id-gsbp-86ef8289-fb15>.gspb-buttonbox {
                                        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
                                    }

                                    .gspb_button-id-gsbp-86ef8289-fb15>.gspb-buttonbox:hover {
                                        transform: translateY(3px);
                                    }
                                </style>
                                <div id="gspb_button-id-gsbp-86ef8289-fb15" class="gspb_button_wrapper gspb_button-id-gsbp-86ef8289-fb15 wp-block-greenshift-blocks-button"><a class="gspb-buttonbox" href="https://shop.greenshiftwp.com/downloads/all-in-one/" target="_blank" rel="noopener"><span class="gspb-buttonbox-textwrap"><span class="gspb-buttonbox-text"><span class="gspb-buttonbox-title">from $59.99</span></span></span></a></div>


                                <style>
                                    #gspb_iconsList-id-gsbp-06b6c366-8a26.gspb_iconsList .gspb_iconsList__item__text {
                                        margin-left: 15px;
                                    }

                                    #gspb_iconsList-id-gsbp-06b6c366-8a26.gspb_iconsList .gspb_iconsList__item {
                                        display: flex;
                                        flex-direction: row;
                                        align-items: center;
                                        position: relative;
                                    }

                                    #gspb_iconsList-id-gsbp-06b6c366-8a26.gspb_iconsList .gspb_iconsList__item svg path {
                                        fill: #2184f9 !important
                                    }

                                    #gspb_iconsList-id-gsbp-06b6c366-8a26.gspb_iconsList .gspb_iconsList__item {
                                        margin-bottom: 6px;
                                    }

                                    #gspb_iconsList-id-gsbp-06b6c366-8a26.gspb_iconsList [data-id='0'] svg,
                                    #gspb_iconsList-id-gsbp-06b6c366-8a26.gspb_iconsList [data-id='0'] svg path {
                                        fill: #de1414 !important;
                                    }

                                    #gspb_iconsList-id-gsbp-06b6c366-8a26.gspb_iconsList [data-id='1'] svg,
                                    #gspb_iconsList-id-gsbp-06b6c366-8a26.gspb_iconsList [data-id='1'] svg path {
                                        fill: #de1414 !important;
                                    }
                                </style>
                                <div id="gspb_iconsList-id-gsbp-06b6c366-8a26" class="gspb_iconsList gspb_iconsList-id-gsbp-06b6c366-8a26 wp-block-greenshift-blocks-iconlist">
                                    <div class="gspb_iconsList__item" data-id="0"><svg class="" style="display:inline-block;vertical-align:middle" width="18" height="18" viewBox="0 0 896 1024" xmlns="http://www.w3.org/2000/svg">
                                            <path style="fill:#565D66" d="M647.12 102.4c-41.6 38.6-79.16 79.18-112.44 119.94-54.52-75.1-122.12-151.28-198.68-222.34-196.52 182.34-336 419.92-336 563.2 0 254.5 200.58 460.8 448 460.8s448-206.3 448-460.8c0-106.54-103.96-326.28-248.88-460.8zM608.18 783.7c-43.32 30.32-96.74 48.3-154.46 48.3-144.3 0-261.72-95.48-261.72-250.5 0-77.22 48.62-145.26 145.58-261.5 13.86 15.96 197.66 250.68 197.66 250.68l117.26-133.76c8.28 13.7 15.82 27.1 22.54 39.94 54.7 104.38 31.62 237.94-66.86 306.84z"></path>
                                        </svg><span class="gspb_iconsList__item__text">5 Sites – from $89.99</span></div>
                                    <div class="gspb_iconsList__item" data-id="1"><svg class="" style="display:inline-block;vertical-align:middle" width="18" height="18" viewBox="0 0 1152 1024" xmlns="http://www.w3.org/2000/svg">
                                            <path style="fill:#565D66" d="M927.4 0h-702.8c-8.4 0-16.2 4.4-20.6 11.6l-200.6 325.6c-5.4 8.8-4.4 20.2 2.4 28l552 650.4c9.6 11.2 26.8 11.2 36.4 0l552-650.4c6.8-7.8 7.6-19.2 2.4-28l-200.6-325.6c-4.4-7.2-12.2-11.6-20.6-11.6zM900.2 72l148.6 248h-166l-113.6-248h131zM690 72l113.6 248h-455.4l113.8-248h228zM251.8 72h131l-113.6 248h-166l148.6-248zM122.4 384h146l163.6 384-309.6-384zM346.4 384h459l-229.4 527.6-229.6-527.6zM720 768l163.6-384h146l-309.6 384z"></path>
                                        </svg><span class="gspb_iconsList__item__text">Unlimited – from $129.99</span></div>
                                </div>
                            </div>


                            <style>
                                #gspb_container-id-gsbp-40a198c1-0196.gspb_container {
                                    position: relative;
                                    flex-direction: column;
                                    box-sizing: border-box;
                                }

                                #gspb_container-id-gsbp-40a198c1-0196.gspb_container .gspb_container__content {
                                    margin: auto;
                                }

                                #gspb_container-id-gsbp-40a198c1-0196.gspb_container>p:last-of-type {
                                    margin-bottom: 0
                                }

                                #gspb_container-id-gsbp-40a198c1-0196.gspb_container {
                                    padding-top: 20px;
                                    padding-right: 30px;
                                    padding-bottom: 20px;
                                    padding-left: 30px;
                                }

                                #gspb_container-id-gsbp-40a198c1-0196.gspb_container {
                                    background-color: #fff6c0;
                                }
                            </style>
                            <div id="gspb_container-id-gsbp-40a198c1-0196" class="gspb_container gspb_container-gsbp-40a198c1-0196 wp-block-greenshift-blocks-container">
                                <style>
                                    #gspb_heading-id-gsbp-1b36757e-6fa4,
                                    #gspb_heading-id-gsbp-1b36757e-6fa4 .wp-block {
                                        font-size: 32px;
                                    }

                                    #gspb_heading-id-gsbp-1b36757e-6fa4 {
                                        margin-bottom: 30px;
                                        padding-bottom: 30px;
                                    }

                                    #gspb_heading-id-gsbp-1b36757e-6fa4 {
                                        border-bottom-style: solid;
                                        border-bottom-width: 1px;
                                        border-bottom-color: #2c2c2c;
                                    }

                                    #gspb_heading-id-gsbp-1b36757e-6fa4 .gspb_heading_subtitle,
                                    #gspb_subheading-id-gsbp-1b36757e-6fa4 {
                                        display: block;
                                        font-size: 17px;
                                        line-height: 22px;
                                        margin-top: 5px
                                    }

                                    #gspb_heading-id-gsbp-1b36757e-6fa4 .gspb_heading_subtitle,
                                    #gspb_subheading-id-gsbp-1b36757e-6fa4,
                                    #gspb_heading-id-gsbp-1b36757e-6fa4 .gspb_heading_subtitle,
                                    #gspb_subheading-id-gsbp-1b36757e-6fa4 .wp-block {
                                        color: #3d3d3d;
                                    }
                                </style>
                                <?php if (!empty($licenses['all_in_one_seo']) && $licenses['all_in_one_seo'] == 'valid') : ?>
                                    <div class="gspb-badge">Active</div>
                                <?php endif; ?>
                                <h2 id="gspb_heading-id-gsbp-1b36757e-6fa4" class="gspb_heading gspb_heading-id-gsbp-1b36757e-6fa4 "><strong>SEO Pack</strong><span class="gspb_heading_subtitle"><strong>Profitable blocks with high conversion</strong></span></h2>


                                <style>
                                    #gspb_iconsList-id-gsbp-6085b501-cfe3.gspb_iconsList .gspb_iconsList__item__text {
                                        margin-left: 15px;
                                    }

                                    #gspb_iconsList-id-gsbp-6085b501-cfe3.gspb_iconsList .gspb_iconsList__item {
                                        display: flex;
                                        flex-direction: row;
                                        align-items: center;
                                        position: relative;
                                    }

                                    #gspb_iconsList-id-gsbp-6085b501-cfe3.gspb_iconsList .gspb_iconsList__item svg path {
                                        fill: #2184f9 !important
                                    }

                                    #gspb_iconsList-id-gsbp-6085b501-cfe3.gspb_iconsList .gspb_iconsList__item {
                                        margin-bottom: 10px;
                                    }

                                    #gspb_iconsList-id-gsbp-6085b501-cfe3.gspb_iconsList [data-id='0'] svg,
                                    #gspb_iconsList-id-gsbp-6085b501-cfe3.gspb_iconsList [data-id='0'] svg path {
                                        fill: #00d084 !important;
                                    }

                                    #gspb_iconsList-id-gsbp-6085b501-cfe3.gspb_iconsList [data-id='1'] svg,
                                    #gspb_iconsList-id-gsbp-6085b501-cfe3.gspb_iconsList [data-id='1'] svg path {
                                        fill: #00d084 !important;
                                    }

                                    #gspb_iconsList-id-gsbp-6085b501-cfe3.gspb_iconsList [data-id='2'] svg,
                                    #gspb_iconsList-id-gsbp-6085b501-cfe3.gspb_iconsList [data-id='2'] svg path {
                                        fill: #00d084 !important;
                                    }

                                    #gspb_iconsList-id-gsbp-6085b501-cfe3.gspb_iconsList [data-id='3'] svg,
                                    #gspb_iconsList-id-gsbp-6085b501-cfe3.gspb_iconsList [data-id='3'] svg path {
                                        fill: #00d084 !important;
                                    }
                                </style>
                                <div id="gspb_iconsList-id-gsbp-6085b501-cfe3" class="gspb_iconsList gspb_iconsList-id-gsbp-6085b501-cfe3 wp-block-greenshift-blocks-iconlist">
                                    <div class="gspb_iconsList__item" data-id="0"><svg class="" style="display:inline-block;vertical-align:middle" width="18" height="18" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                                            <path style="fill:#565D66" d="M871.696 166.932l-526.088 526.088-193.304-193.304c-9.372-9.372-24.568-9.372-33.942 0l-56.568 56.568c-9.372 9.372-9.372 24.568 0 33.942l266.842 266.842c9.372 9.372 24.568 9.372 33.942 0l599.626-599.626c9.372-9.372 9.372-24.568 0-33.942l-56.568-56.568c-9.372-9.372-24.568-9.372-33.94 0z"></path>
                                        </svg><span class="gspb_iconsList__item__text"><a href="https://shop.greenshiftwp.com/downloads/query-addon/" target="_blank" rel="noreferrer noopener">Query Addon and listings</a></span></div>
                                    <div class="gspb_iconsList__item" data-id="1"><svg class="" style="display:inline-block;vertical-align:middle" width="18" height="18" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                                            <path style="fill:#565D66" d="M871.696 166.932l-526.088 526.088-193.304-193.304c-9.372-9.372-24.568-9.372-33.942 0l-56.568 56.568c-9.372 9.372-9.372 24.568 0 33.942l266.842 266.842c9.372 9.372 24.568 9.372 33.942 0l599.626-599.626c9.372-9.372 9.372-24.568 0-33.942l-56.568-56.568c-9.372-9.372-24.568-9.372-33.94 0z"></path>
                                        </svg><span class="gspb_iconsList__item__text"><a href="https://shop.greenshiftwp.com/downloads/marketing-and-seo-addon/" target="_blank" rel="noreferrer noopener">SEO and Marketing Addon</a></span></div>
                                    <div class="gspb_iconsList__item" data-id="2"><svg class="" style="display:inline-block;vertical-align:middle" width="18" height="18" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                                            <path style="fill:#565D66" d="M871.696 166.932l-526.088 526.088-193.304-193.304c-9.372-9.372-24.568-9.372-33.942 0l-56.568 56.568c-9.372 9.372-9.372 24.568 0 33.942l266.842 266.842c9.372 9.372 24.568 9.372 33.942 0l599.626-599.626c9.372-9.372 9.372-24.568 0-33.942l-56.568-56.568c-9.372-9.372-24.568-9.372-33.94 0z"></path>
                                        </svg><span class="gspb_iconsList__item__text">Link Hider and statistic addon</span></div>
                                    <div class="gspb_iconsList__item" data-id="3"><svg class="" style="display:inline-block;vertical-align:middle" width="18" height="18" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                                            <path style="fill:#565D66" d="M871.696 166.932l-526.088 526.088-193.304-193.304c-9.372-9.372-24.568-9.372-33.942 0l-56.568 56.568c-9.372 9.372-9.372 24.568 0 33.942l266.842 266.842c9.372 9.372 24.568 9.372 33.942 0l599.626-599.626c9.372-9.372 9.372-24.568 0-33.942l-56.568-56.568c-9.372-9.372-24.568-9.372-33.94 0z"></path>
                                        </svg><span class="gspb_iconsList__item__text">Premium Support</span></div>
                                </div>


                                <style>
                                    .gspb_button-id-gsbp-db2576fe-9a15 {
                                        display: flex;
                                        justify-content: flex-start;
                                    }

                                    .gspb_button-id-gsbp-db2576fe-9a15 .gspb-buttonbox-text {
                                        display: flex;
                                        flex-direction: column;
                                    }

                                    .gspb_button-id-gsbp-db2576fe-9a15>.gspb-buttonbox {
                                        display: inline-block;
                                        padding: 13px 26px;
                                        background-color: #00d084;
                                        text-decoration: none !important;
                                        color: #fff;
                                        font-size: 16px;
                                        line-height: 16px;
                                        position: relative;
                                        z-index: 0;
                                        cursor: pointer;
                                        box-sizing: border-box
                                    }

                                    .gspb_button-id-gsbp-db2576fe-9a15>.gspb-buttonbox {
                                        margin-top: 20px;
                                        margin-bottom: 20px;
                                        padding-top: 20px;
                                        padding-right: 20px;
                                        padding-bottom: 20px;
                                        padding-left: 20px;
                                    }

                                    .gspb_button-id-gsbp-db2576fe-9a15>.gspb-buttonbox {
                                        background-color: #000000;
                                    }

                                    .gspb_button-id-gsbp-db2576fe-9a15>.gspb-buttonbox {
                                        width: 100%;
                                    }

                                    .gspb_button-id-gsbp-db2576fe-9a15>.gspb-buttonbox,
                                    .gspb_button-id-gsbp-db2576fe-9a15>.gspb-buttonbox .wp-block,
                                    .gspb_button-id-gsbp-db2576fe-9a15>.gspb-buttonbox .gsap-g-line {
                                        text-align: center !important;
                                    }

                                    .gspb_button-id-gsbp-db2576fe-9a15>.gspb-buttonbox:hover {
                                        box-shadow: 0 15px 30px 0 rgba(119, 123, 146, 0.1);
                                    }

                                    .gspb_button-id-gsbp-db2576fe-9a15>.gspb-buttonbox {
                                        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
                                    }

                                    .gspb_button-id-gsbp-db2576fe-9a15>.gspb-buttonbox:hover {
                                        transform: scale(1.06);
                                    }
                                </style>
                                <div id="gspb_button-id-gsbp-db2576fe-9a15" class="gspb_button_wrapper gspb_button-id-gsbp-db2576fe-9a15 wp-block-greenshift-blocks-button"><a class="gspb-buttonbox" href="https://shop.greenshiftwp.com/downloads/seo-pack/" target="_blank" rel="noopener"><span class="gspb-buttonbox-textwrap"><span class="gspb-buttonbox-text"><span class="gspb-buttonbox-title">from $49.99</span></span></span></a></div>


                                <style>
                                    #gspb_iconsList-id-gsbp-285a4c84-b9f4.gspb_iconsList .gspb_iconsList__item__text {
                                        margin-left: 15px;
                                    }

                                    #gspb_iconsList-id-gsbp-285a4c84-b9f4.gspb_iconsList .gspb_iconsList__item {
                                        display: flex;
                                        flex-direction: row;
                                        align-items: center;
                                        position: relative;
                                    }

                                    #gspb_iconsList-id-gsbp-285a4c84-b9f4.gspb_iconsList .gspb_iconsList__item svg path {
                                        fill: #2184f9 !important
                                    }

                                    #gspb_iconsList-id-gsbp-285a4c84-b9f4.gspb_iconsList .gspb_iconsList__item {
                                        margin-bottom: 6px;
                                    }

                                    #gspb_iconsList-id-gsbp-285a4c84-b9f4.gspb_iconsList [data-id='0'] svg,
                                    #gspb_iconsList-id-gsbp-285a4c84-b9f4.gspb_iconsList [data-id='0'] svg path {
                                        fill: #de1414 !important;
                                    }

                                    #gspb_iconsList-id-gsbp-285a4c84-b9f4.gspb_iconsList [data-id='1'] svg,
                                    #gspb_iconsList-id-gsbp-285a4c84-b9f4.gspb_iconsList [data-id='1'] svg path {
                                        fill: #de1414 !important;
                                    }
                                </style>
                                <div id="gspb_iconsList-id-gsbp-285a4c84-b9f4" class="gspb_iconsList gspb_iconsList-id-gsbp-285a4c84-b9f4 wp-block-greenshift-blocks-iconlist">
                                    <div class="gspb_iconsList__item" data-id="0"><svg class="" style="display:inline-block;vertical-align:middle" width="18" height="18" viewBox="0 0 896 1024" xmlns="http://www.w3.org/2000/svg">
                                            <path style="fill:#565D66" d="M647.12 102.4c-41.6 38.6-79.16 79.18-112.44 119.94-54.52-75.1-122.12-151.28-198.68-222.34-196.52 182.34-336 419.92-336 563.2 0 254.5 200.58 460.8 448 460.8s448-206.3 448-460.8c0-106.54-103.96-326.28-248.88-460.8zM608.18 783.7c-43.32 30.32-96.74 48.3-154.46 48.3-144.3 0-261.72-95.48-261.72-250.5 0-77.22 48.62-145.26 145.58-261.5 13.86 15.96 197.66 250.68 197.66 250.68l117.26-133.76c8.28 13.7 15.82 27.1 22.54 39.94 54.7 104.38 31.62 237.94-66.86 306.84z"></path>
                                        </svg><span class="gspb_iconsList__item__text">5 Sites – from $79.99</span></div>
                                    <div class="gspb_iconsList__item" data-id="1"><svg class="" style="display:inline-block;vertical-align:middle" width="18" height="18" viewBox="0 0 1152 1024" xmlns="http://www.w3.org/2000/svg">
                                            <path style="fill:#565D66" d="M927.4 0h-702.8c-8.4 0-16.2 4.4-20.6 11.6l-200.6 325.6c-5.4 8.8-4.4 20.2 2.4 28l552 650.4c9.6 11.2 26.8 11.2 36.4 0l552-650.4c6.8-7.8 7.6-19.2 2.4-28l-200.6-325.6c-4.4-7.2-12.2-11.6-20.6-11.6zM900.2 72l148.6 248h-166l-113.6-248h131zM690 72l113.6 248h-455.4l113.8-248h228zM251.8 72h131l-113.6 248h-166l148.6-248zM122.4 384h146l163.6 384-309.6-384zM346.4 384h459l-229.4 527.6-229.6-527.6zM720 768l163.6-384h146l-309.6 384z"></path>
                                        </svg><span class="gspb_iconsList__item__text">Unlimited – from $89.99</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>
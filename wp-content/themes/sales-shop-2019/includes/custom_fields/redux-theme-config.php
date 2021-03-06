<?php

/**
 * ReduxFramework Barebones Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */

if (!class_exists('Redux')) {
    return;
}

// This is your option name where all the Redux data is stored.
$opt_name = "ss_theme_option";

/**
 * ---> SET ARGUMENTS
 * All the possible arguments for Redux.
 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
 * */

$theme = wp_get_theme(); // For use with some settings. Not necessary.

$args = [
    // TYPICAL -> Change these values as you need/desire
    'opt_name' => $opt_name,
    // This is where your data is stored in the database and also becomes your global variable name.
    'display_name' => $theme->get('Name'),
    // Name that appears at the top of your panel
    'display_version' => $theme->get('Version'),
    // Version that appears at the top of your panel
    'menu_type' => 'menu',
    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu' => true,
    // Show the sections below the admin menu item or not
    'menu_title' => __('Theme Options', 'redux-framework'),
    'page_title' => __('Theme Options for sales shop', 'redux-framework'),
    // You will need to generate a Google API key to use this feature.
    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
    'google_api_key' => '',
    // Set it you want google fonts to update weekly. A google_api_key value is required.
    'google_update_weekly' => false,
    // Must be defined to add google fonts to the typography module
    'async_typography' => true,
    // Use a asynchronous font on the front end or font string
    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
    'admin_bar' => true,
    // Show the panel pages on the admin bar
    'admin_bar_icon' => 'dashicons-portfolio',
    // Choose an icon for the admin bar menu
    'admin_bar_priority' => 50,
    // Choose an priority for the admin bar menu
    'global_variable' => '',
    // Set a different name for your global variable other than the opt_name
    'dev_mode' => false,
    // Show the time the page took to load, etc
    'update_notice' => true,
    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
    'customizer' => true,
    // Enable basic customizer support
    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

    // OPTIONAL -> Give you extra features
    'page_priority' => null,
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent' => 'themes.php',
    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    'page_permissions' => 'manage_options',
    // Permissions needed to access the options panel.
    'menu_icon' => '',
    // Specify a custom URL to an icon
    'last_tab' => '',
    // Force your panel to always open to a specific tab (by id)
    'page_icon' => 'icon-themes',
    // Icon displayed in the admin panel next to your menu_title
    'page_slug' => 'theme_options',
    // Page slug used to denote the panel
    'save_defaults' => true,
    // On load save the defaults to DB before user clicks save or not
    'default_show' => false,
    // If true, shows the default value next to each field that is not the default value.
    'default_mark' => '',
    // What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export' => true,
    // Shows the Import/Export panel when not used as a field.

    // CAREFUL -> These options are for advanced use only
    'transient_time' => 60 * MINUTE_IN_SECONDS,
    'output' => true,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag' => true,
    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database' => '',
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!

    'use_cdn' => true,
    // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

    //'compiler'             => true,

    // HINTS
    'hints' => [
        'icon' => 'el el-question-sign',
        'icon_position' => 'right',
        'icon_color' => 'lightgray',
        'icon_size' => 'normal',
        'tip_style' => [
            'color' => 'light',
            'shadow' => true,
            'rounded' => false,
            'style' => '',
        ],
        'tip_position' => [
            'my' => 'top left',
            'at' => 'bottom right',
        ],
        'tip_effect' => [
            'show' => [
                'effect' => 'slide',
                'duration' => '500',
                'event' => 'mouseover',
            ],
            'hide' => [
                'effect' => 'slide',
                'duration' => '500',
                'event' => 'click mouseleave',
            ],
        ],
    ]
];

// ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
//    $args['admin_bar_links'][] = array(
//        'id'    => 'redux-docs',
//        'href'  => 'http://docs.reduxframework.com/',
//        'title' => __( 'Documentation', 'redux-framework' ),
//    );
//
//    $args['admin_bar_links'][] = array(
//        //'id'    => 'redux-support',
//        'href'  => 'https://github.com/ReduxFramework/redux-framework/issues',
//        'title' => __( 'Support', 'redux-framework' ),
//    );
//
//    $args['admin_bar_links'][] = array(
//        'id'    => 'redux-extensions',
//        'href'  => 'reduxframework.com/extensions',
//        'title' => __( 'Extensions', 'redux-framework' ),
//    );

// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
//    $args['share_icons'][] = array(
//        'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
//        'title' => 'Visit us on GitHub',
//        'icon'  => 'el el-github'
//        //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
//    );
//    $args['share_icons'][] = array(
//        'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
//        'title' => 'Like us on Facebook',
//        'icon'  => 'el el-facebook'
//    );
//    $args['share_icons'][] = array(
//        'url'   => 'http://twitter.com/reduxframework',
//        'title' => 'Follow us on Twitter',
//        'icon'  => 'el el-twitter'
//    );
//    $args['share_icons'][] = array(
//        'url'   => 'http://www.linkedin.com/company/redux-framework',
//        'title' => 'Find us on LinkedIn',
//        'icon'  => 'el el-linkedin'
//    );

// Panel Intro text -> before the form
//    if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
//        if ( ! empty( $args['global_variable'] ) ) {
//            $v = $args['global_variable'];
//        } else {
//            $v = str_replace( '-', '_', $args['opt_name'] );
//        }
//        $args['intro_text'] = sprintf( __( '<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'redux-framework' ), $v );
//    } else {
//        $args['intro_text'] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'redux-framework' );
//    }

$args['intro_text'] = __('<p>Theme options for sales shop.</p>', 'redux-framework');

// Add content after the form.
$args['footer_text'] = __('<p>Developed by Dmitry Krugovoy and dendrofen.</p>', 'redux-framework');

Redux::setArgs($opt_name, $args);

/*
 * ---> END ARGUMENTS
 */

/*
 * ---> START HELP TABS
 */

//    $tabs = array(
//        array(
//            'id'      => 'redux-help-tab-1',
//            'title'   => __( 'Theme Information 1', 'redux-framework' ),
//            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'redux-framework' )
//        ),
//        array(
//            'id'      => 'redux-help-tab-2',
//            'title'   => __( 'Theme Information 2', 'redux-framework' ),
//            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'redux-framework' )
//        )
//    );
//    Redux::setHelpTab( $opt_name, $tabs );
//
//    // Set the help sidebar
//    $content = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework' );
//    Redux::setHelpSidebar( $opt_name, $content );


/*
 * <--- END HELP TABS
 */


/*
 *
 * ---> START SECTIONS
 *
 */

/*

    As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


 */

Redux::setSection($opt_name, [
    'title' => __('Basic Theme Options', 'redux-framework'),
    'id' => 'basic',
    'desc' => __('Basic fields as subsections.', 'redux-framework'),
    'icon' => 'el el-home'
]);

Redux::setSection($opt_name, [
    'title' => __('Header Options', 'redux-framework'),
    'desc' => __('In this section, you can change the theme options displayed in the header.', 'redux-framework'),
    'id' => 'header-options',
    'subsection' => true,
    'fields' => [
        [
            'id' => 'logo-upload',
            'type' => 'media',
            'title' => __('Logo Uploader', 'redux-framework'),
            'subtitle' => __('Uploader your logo', 'redux-framework'),
            'compiler' => 'true'
        ],
        [
            'id' => 'slogan',
            'type' => 'editor',
            'title' => __('Slogan', 'redux-framework'),
            'subtitle' => __('Enter your site slogan', 'redux-framework'),
        ],
        // [
        //     'id' => 'header-menu-start',
        //     'type' => 'section',
        //     'title' => __('Menu', 'redux-framework'),
        //     'subtitle' => __('Menu that appeared in header block.', 'redux-framework'),
        //     'indent' => true, 
        // ],
        [
            'id' => 'header-menu',
            'type' => 'select',
            'title' => __('Header menu', 'redux-framework'),
            'subtitle' => __('Select menu to be appeared in header', 'redux-framework'),
            'data' => 'menu',
        ],
        // [
        //     'id' => 'header-menu-end',
        //     'type' => 'section',
        //     'indent' => false,
        // ],
    ]
]);

Redux::setSection($opt_name, [
    'title' => __('Footer Options', 'redux-framework'),
    'desc' => __('In this section, you can change the theme options displayed in the footer.', 'redux-framework'),
    'id' => 'footer-options',
    'subsection' => true,
    'fields' => [
        [
            'id' => 'footer-logo',
            'type' => 'media',
            'title' => __('Logo Uploader', 'redux-framework'),
            'subtitle' => __('Uploader your logo', 'redux-framework'),
            'compiler' => 'true'
        ],
        [
            'id' => 'footer-follow-section-start',
            'type' => 'section',
            'title' => __('Follow Us', 'redux-framework'),
            'subtitle' => __('Change block Follow us.', 'redux-framework'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ],
        [
            'id' => 'footer-facebook-url',
            'type' => 'text',
            'title' => __('Link to facebook', 'redux-framework'),
            'validate' => 'url'
        ],
        [
            'id' => 'footer-whatsup-url',
            'type' => 'text',
            'title' => __('Link to whatsup', 'redux-framework'),
            'validate' => 'url'
        ],
        [
            'id' => 'footer-linkedin-url',
            'type' => 'text',
            'title' => __('Link to linkedin', 'redux-framework'),
            'validate' => 'url'
        ],
        [
            'id' => 'category-contact-section-end',
            'type' => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ],
        //footer menu columns
        [
            'id' => 'footer-link-columns-start',
            'type' => 'section',
            'title' => __('Footer columns with links', 'redux-framework'),
            'subtitle' => __('Change columns with links.', 'redux-framework'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ],
        [
            'id' => 'footer-menu-first',
            'type' => 'select',
            'title' => __('First column menu', 'redux-framework'),
            'data' => 'menu',
        ],
        [
            'id' => 'footer-menu-second',
            'type' => 'select',
            'title' => __('Second column menu', 'redux-framework'),
            'data' => 'menu',
        ],
        [
            'id' => 'footer-menu-third',
            'type' => 'select',
            'title' => __('Third column menu', 'redux-framework'),
            'data' => 'menu',
        ],
        [
            'id' => 'footer-link-columns-end',
            'type' => 'section',
            'indent' => false,
        ],
        [
            'id' => 'footer-copyright-text',
            'type' => 'text',
            'title' => __('Copyright', 'redux-framework'),
            'subtitle' => __('Enter copyright', 'redux-framework'),
        ],
    ]
]);

Redux::setSection($opt_name, [
    'title' => __('Footer Contact Us', 'redux-framework'),
    'desc' => __('In this section you can change the theme settings displayed in the footer',
        'redux-framework'),
    'id' => 'footer_forms',
    'subsection' => true,
    'fields' => [
        [
            'id' => 'footer-contact-us-section-start',
            'type' => 'section',
            'title' => __('Contact Us', 'redux-framework'),
            'subtitle' => __('Block settings', 'redux-framework'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ],
        [
            'id' => 'footer-contact-us-title',
            'type' => 'text',
            'title' => __('Block title', 'redux-framework'),
            'subtitle' => __('Enter title text', 'redux-framework'),
        ],
        [
            'id' => 'footer-contact-us-text',
            'type' => 'text',
            'title' => __('Block text', 'redux-framework'),
            'subtitle' => __('Enter block text', 'redux-framework'),
        ],
        [
            'id' => 'footer-contact-us-items-start',
            'type' => 'section',
            'title' => __('Contact us items', 'redux-framework'),
            'subtitle' => __('Settings for items that are bellow of contact us text', 'redux-framework'),
            'indent' => true, 
        ],
        [
            'id' => 'footer-contact-us-mail',
            'type' => 'text',
            'title' => __('Mail block', 'redux-framework'),
            'subtitle' => __('Enter text appeared in mail item', 'redux-framework'),
        ],
        [
            'id' => 'footer-contact-us-phone',
            'type' => 'text',
            'title' => __('Phone block', 'redux-framework'),
            'subtitle' => __('Enter text appeared in phone item', 'redux-framework'),
        ],
        [
            'id' => 'footer-contact-us-help',
            'type' => 'text',
            'title' => __('Help block', 'redux-framework'),
            'subtitle' => __('Enter text appeared in help item', 'redux-framework'),
        ],
        [
            'id' => 'footer-contact-us-shop',
            'type' => 'text',
            'title' => __('Shop block', 'redux-framework'),
            'subtitle' => __('Enter text appeared in shop item', 'redux-framework'),
        ],
        [
            'id' => 'footer-contact-us-items-end',
            'type' => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ],
        [
            'id' => 'footer-contact-us-section-end',
            'type' => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ],
        [
            'id' => 'footer-subscribe-section-start',
            'type' => 'section',
            'title' => __('Subscribe', 'redux-framework'),
            'subtitle' => __('Form block settings', 'redux-framework'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ],
        [
            'id' => 'footer-subscribe-form',
            'type' => 'text',
            'title' => __('Form Shortcode', 'redux-framework'),
            'subtitle' => __('Enter contact form 7 shortcode', 'redux-framework'),
        ],
        [
            'id' => 'footer-subscribe-section-end',
            'type' => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ],
    ]
]);

Redux::setSection($opt_name, [
    'title' => __('Coupon Options', 'redux-framework'),
    'desc' => __('In this section, you can change the coupon options.', 'redux-framework'),
    'id' => 'coupon-options',
    'subsection' => true,
    'fields' => [
        [
            'id' => 'coupon-validity',
            'type' => 'text',
            'title' => __('Validity', 'redux-framework'),
            'subtitle' => __('Validity of the coupon from the date of sale', 'redux-framework'),
            'desc' => __('days', 'redux-framework'),
            'validate' => 'numeric',
            'default' => '30'
        ],
    ]
]);

Redux::setSection($opt_name, [
    'title' => __('Pagination Options', 'redux-framework'),
    'desc' => __('In this section you can change the pagination options on the site pages.', 'redux-framework'),
    'id' => 'pagination-options',
    'subsection' => true,
    'fields' => [
        [
            'id' => 'category-section-start',
            'type' => 'section',
            'title' => __('Category Page', 'redux-framework'),
            'subtitle' => __('Pagination options on the category page.', 'redux-framework'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ],
        [
            'id' => 'category-pagination',
            'type' => 'button_set',
            'title' => __('Type of loading', 'redux-framework'),
            'subtitle' => __('Select the type of content loading on the page', 'redux-framework'),
            //Must provide key => value pairs for radio options
            'options' => [
                '1' => 'lazy load',
                '2' => 'pagination'
            ],
            'default' => '1'
        ],
        [
            'id' => 'category-pagination-amount',
            'type' => 'text',
            'title' => __('Amount of elements', 'redux-framework'),
            'subtitle' => __('Number of loadable items at a time', 'redux-framework'),
            'validate' => 'numeric',
            'default' => '5'
        ],
        [
            'id' => 'category-section-end',
            'type' => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ],
        [
            'id' => 'shop-section-start',
            'type' => 'section',
            'title' => __('Shop Page', 'redux-framework'),
            'subtitle' => __('Pagination options on the shop page.', 'redux-framework'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ],
        [
            'id' => 'shop-pagination',
            'type' => 'button_set',
            'title' => __('Type of loading', 'redux-framework'),
            'subtitle' => __('Select the type of content loading on the page', 'redux-framework'),
            //Must provide key => value pairs for radio options
            'options' => [
                '1' => 'lazy load',
                '2' => 'pagination'
            ],
            'default' => '1'
        ],
        [
            'id' => 'shop-pagination-amount',
            'type' => 'text',
            'title' => __('Amount of elements', 'redux-framework'),
            'subtitle' => __('Number of loadable items at a time', 'redux-framework'),
            'validate' => 'numeric',
            'default' => '5'
        ],
        [
            'id' => 'shop-section-end',
            'type' => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ],
        [
            'id' => 'search-section-start',
            'type' => 'section',
            'title' => __('Search results Page', 'redux-framework'),
            'subtitle' => __('Pagination options on the search results page.', 'redux-framework'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ],
        [
            'id' => 'search-pagination',
            'type' => 'button_set',
            'title' => __('Type of loading', 'redux-framework'),
            'subtitle' => __('Select the type of content loading on the page', 'redux-framework'),
            //Must provide key => value pairs for radio options
            'options' => [
                '1' => 'lazy load',
                '2' => 'pagination'
            ],
            'default' => '1'
        ],
        [
            'id' => 'search-pagination-amount',
            'type' => 'text',
            'title' => __('Amount of elements', 'redux-framework'),
            'subtitle' => __('Number of loadable items at a time', 'redux-framework'),
            'validate' => 'numeric',
            'default' => '5'
        ],
        [
            'id' => 'search-section-end',
            'type' => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ],
        [
            'id' => 'seller-page-section-start',
            'type' => 'section',
            'title' => __('Seller Page', 'redux-framework'),
            'subtitle' => __('Customize the "Load more" button on the seller page.', 'redux-framework'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ],
        [
            'id' => 'seller-page-pagination-amount',
            'type' => 'text',
            'title' => __('Amount of elements', 'redux-framework'),
            'subtitle' => __('Number of loadable items at a time', 'redux-framework'),
            'validate' => 'numeric',
            'default' => '5'
        ],
        [
            'id' => 'seller-page-section-end',
            'type' => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ],
        [
            'id' => 'seller-dashboard-section-start',
            'type' => 'section',
            'title' => __('Seller Dashboard', 'redux-framework'),
            'subtitle' => __('Pagination options on the Seller Dashboard.', 'redux-framework'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ],
        [
            'id' => 'seller-dashboard-pagination-amount',
            'type' => 'text',
            'title' => __('Amount of elements', 'redux-framework'),
            'subtitle' => __('Number of coupons displayed on one page', 'redux-framework'),
            'validate' => 'numeric',
            'default' => '5'
        ],
        [
            'id' => 'seller-dashboard-section-end',
            'type' => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ],
        [
            'id' => 'buyer-section-start',
            'type' => 'section',
            'title' => __('Buyer Dashboard', 'redux-framework'),
            'subtitle' => __('Pagination options on the Buyer Dashboard.', 'redux-framework'),
            'indent' => true, // Indent all options below until the next 'section' option is set.
        ],
        [
            'id' => 'buyer-tab-my-coupons-pagination-amount',
            'type' => 'text',
            'title' => __('My Coupons tab', 'redux-framework'),
            'subtitle' => __('Number of coupons displayed on one page', 'redux-framework'),
            'validate' => 'numeric',
            'default' => '5'
        ],
        [
            'id' => 'buyer-tab-historical-coupons-pagination-amount',
            'type' => 'text',
            'title' => __('Historical Coupons tab', 'redux-framework'),
            'subtitle' => __('Number of coupons displayed on one page', 'redux-framework'),
            'validate' => 'numeric',
            'default' => '5'
        ],
        [
            'id' => 'buyer-section-end',
            'type' => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ],
    ]
]);

Redux::setSection($opt_name, [
    'title' => __('Popup Register', 'redux-framework'),
    'desc' => __('In this section you can change popup options that will be displayed to non-registered users.',
        'redux-framework'),
    'id' => 'popup-register-options',
    'subsection' => true,
    'fields' => [
        [
            'id' => 'popup-register-enable',
            'type' => 'switch',
            'title' => __('Enable Popup', 'redux-framework'),
            'default' => 0,
        ],
        [
            'id' => 'popup-register-show-time',
            'type' => 'text',
            'required' => ['popup-register-enable', '=', '1'],
            'title' => __('Opening time', 'redux-framework'),
            'subtitle' => __('Time lapse before opening popup', 'redux-framework'),
            'desc' => __('seconds', 'redux-framework'),
            'validate' => 'numeric',
            'default' => '30'
        ],
        [
            'id' => 'popup-register-image',
            'type' => 'media',
            'title' => __('Image Uploader', 'redux-framework'),
            'subtitle' => __('Picture on the left in a popup', 'redux-framework'),
            'compiler' => 'true'
        ],
        [
            'id' => 'popup-register-title',
            'type' => 'text',
            'required' => ['popup-register-enable', '=', '1'],
            'title' => __('Title', 'redux-framework'),
            'placeholder' => 'Enter a title',
        ],
        [
            'id' => 'popup-register-body',
            'type' => 'textarea',
            'required' => ['popup-register-enable', '=', '1'],
            'title' => __('Subtitle', 'redux-framework'),
            'placeholder' => 'Enter a subtitle',
        ]
    ]
]);

//Shop options start
Redux::setSection($opt_name, [
    'title' => __('Shop Options', 'redux-framework'),
    'id' => 'shop',
    'desc' => __('Shop settings, and values', 'redux-framework'),
    'icon' => 'el el-shopping-cart'
]);

Redux::setSection($opt_name, [
    'title' => __('Promoted shares', 'redux-framework'),
    'desc' => __('In this section you can select item which will be involved in action.',
        'redux-framework'),
    'id' => 'promoted-shares-options',
    'subsection' => true,
    'fields' => [
        [
            'id' => 'promoted-product-id',
            'type' => 'text',
            'title' => __('Promoted product', 'redux-framework'),
            'subtitle' => __('Enter Product ID which will be appearing on promoted shares block', 'redux-framework'),
            'desc' => __('id', 'redux-framework'),
            'validate' => 'numeric',
            'default' => '30'
        ],
    ]
]);
//Shop options end

Redux::setSection($opt_name, [
    'title' => __('Exchange Rates', 'redux-framework'),
    'desc' => __('In this section you can change the exchange rate.', 'redux-framework'),
    'id' => 'exchange-rates',
    'icon' => 'el el-usd',
    'fields' => [
        [
            'id' => 'default-currency',
            'type' => 'button_set',
            'title' => __('Default currency', 'redux-framework'),
            'subtitle' => __('Choose the default currency', 'redux-framework'),
            'desc' => __('This currency will be used on the site by default', 'redux-framework'),
            //Must provide key => value pairs for radio options
            'options' => [
                '1' => 'GNF',
                '2' => 'USD',
                '3' => 'EUR'
            ],
            'default' => '1'
        ],
        [
            'id' => 'gnf-rate',
            'type' => 'text',
            'title' => __('GNF', 'redux-framework'),
            'subtitle' => __('Enter the guinean franc rate', 'redux-framework'),
            'validate' => 'comma_numeric',
            'default' => '1'
        ],
        [
            'id' => 'usd-rate',
            'type' => 'text',
            'title' => __('USD', 'redux-framework'),
            'subtitle' => __('Enter us dollar rate', 'redux-framework'),
            'validate' => 'comma_numeric',
            'default' => '0.00011'
        ],
        [
            'id' => 'eur-rate',
            'type' => 'text',
            'title' => __('EUR', 'redux-framework'),
            'subtitle' => __('Enter the euro rate', 'redux-framework'),
            'validate' => 'comma_numeric',
            'default' => '0.000095'
        ],
    ]
]);

/*
 * <--- END SECTIONS
 */

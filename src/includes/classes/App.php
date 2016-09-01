<?php
/**
 * Application.
 *
 * @author @jaswsinc
 * @copyright WP Sharks™
 */
declare (strict_types = 1);
namespace WebSharks\WpSharks\WpSiteSearch\Pro\Classes;

use WebSharks\WpSharks\WpSiteSearch\Pro\Classes;
use WebSharks\WpSharks\WpSiteSearch\Pro\Interfaces;
use WebSharks\WpSharks\WpSiteSearch\Pro\Traits;
#
use WebSharks\WpSharks\WpSiteSearch\Pro\Classes\AppFacades as a;
use WebSharks\WpSharks\WpSiteSearch\Pro\Classes\SCoreFacades as s;
use WebSharks\WpSharks\WpSiteSearch\Pro\Classes\CoreFacades as c;
#
use WebSharks\WpSharks\Core\Classes as SCoreClasses;
use WebSharks\WpSharks\Core\Interfaces as SCoreInterfaces;
use WebSharks\WpSharks\Core\Traits as SCoreTraits;
#
use WebSharks\Core\WpSharksCore\Classes as CoreClasses;
use WebSharks\Core\WpSharksCore\Classes\Core\Base\Exception;
use WebSharks\Core\WpSharksCore\Interfaces as CoreInterfaces;
use WebSharks\Core\WpSharksCore\Traits as CoreTraits;
#
use function assert as debug;
use function get_defined_vars as vars;

/**
 * Application.
 *
 * @since $v Initial release.
 */
class App extends SCoreClasses\App
{
    /**
     * Version.
     *
     * @since $v
     *
     * @var string Version.
     */
    const VERSION = '160901.50260'; //v//

    /**
     * Constructor.
     *
     * @since $v Initial release.
     *
     * @param array $instance Instance args.
     */
    public function __construct(array $instance = [])
    {
        $instance_base = [
            '©di' => [
                '©default_rule' => [
                    'new_instances' => [
                    ],
                ],
            ],

            '§specs' => [
                '§in_wp'           => false,
                '§is_network_wide' => false,

                '§type' => 'plugin',
                '§file' => dirname(__FILE__, 4).'/plugin.php',
            ],
            '©brand' => [
                '©acronym' => 'WPSS',
                '©name'    => 'WP Site Search',

                '©slug' => 'wp-site-search',
                '©var'  => 'wp_site_search',

                '©short_slug' => 'wp-ss',
                '©short_var'  => 'wp_ss',

                '©text_domain' => 'wp-site-search',
            ],

            '§pro_option_keys' => [],

            '§default_options' => [
                # Basics.

                'page_id'           => 0,
                'q_var'             => 'q',
                'redirect_searches' => 1,

                # Google CSE settings.

                'google_cse_title'       => 'Site Search',
                'google_cse_description' => 'Search this site.',

                'google_cse_site_pattern'        => '',
                'google_cse_image_search_enable' => 0,
                'google_cse_facets'              => '',

                'google_cse_non_profit'        => 0,
                'google_cse_adsense_client_id' => 'partner-pub-7789239515831279',

                # Font (overall).

                'google_cse_font_family' => 'inherit',

                # Theme (overall).

                'google_cse_text_color' => '#000000',

                'google_cse_title_color'        => '#0000CC',
                'google_cse_title_hover_color'  => '#0000CC',
                'google_cse_title_active_color' => '#0000CC',

                'google_cse_url_color'     => '#008000',
                'google_cse_visited_color' => '#1A2554',

                # Theme (search box).

                'google_cse_sb_input_border_color' => '#D9D9D9',

                'google_cse_sb_tab_border_color'     => '#DFDFDF',
                'google_cse_sb_tab_background_color' => '#DFDFDF',

                'google_cse_sb_tab_selected_border_color'     => '#1A2554',
                'google_cse_sb_tab_selected_background_color' => '#F0F0F0',

                # Theme (search results).

                'google_cse_sr_border_color'     => '#FFFFFF',
                'google_cse_sr_background_color' => '#FFFFFF',

                'google_cse_sr_border_hover_color'     => '#FFFFFF',
                'google_cse_sr_background_hover_color' => '#FFFFFF',

                # Theme (ad results).

                'google_cse_sr_ads_border_color'     => '#F8FEF3',
                'google_cse_sr_ads_background_color' => '#F8FEF3',

                # Theme (search result promotions).

                'google_cse_srp_border_color'     => '#FFFFFF',
                'google_cse_srp_background_color' => '#FFFFFF',

                'google_cse_srp_title_color'         => '#0000CC',
                'google_cse_srp_title_hover_color'   => '#0000CC',
                'google_cse_srp_title_active_color'  => '#0000CC',
                'google_cse_srp_title_visited_color' => '#1A2554',

                'google_cse_srp_snippet_color' => '#000000',
                'google_cse_srp_url_color'     => '#008000',
            ],
        ];
        parent::__construct($instance_base, $instance);
    }

    /**
     * Early hook setup handler.
     *
     * @since $v Initial release.
     */
    protected function onSetupEarlyHooks()
    {
        parent::onSetupEarlyHooks();

        s::addAction('vs_upgrades', [$this->Utils->Installer, 'onVsUpgrades']);
        s::addAction('other_install_routines', [$this->Utils->Installer, 'onOtherInstallRoutines']);
    }

    /**
     * Other hook setup handler.
     *
     * @since $v Initial release.
     */
    protected function onSetupOtherHooks()
    {
        parent::onSetupOtherHooks();

        if ($this->Wp->is_admin) {
            add_action('admin_menu', [$this->Utils->MenuPage, 'onAdminMenu']);
        }
        add_action('template_redirect', [$this->Utils->Redirect, 'onTemplateRedirect']);

        add_action('wp_loaded', [$this->Utils->GoogleCse, 'onWpLoaded']);
        add_shortcode('google_cse', [$this->Utils->Shortcode, 'onGoogleCseShortcode']);

        add_action('wp_enqueue_scripts', [$this->Utils->StylesScripts, 'onWpEnqueueScripts']);
    }
}

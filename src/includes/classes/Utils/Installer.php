<?php
/**
 * Install utils.
 *
 * @author @jaswsinc
 * @copyright WP Sharks™
 */
declare (strict_types = 1);
namespace WebSharks\WpSharks\WpSiteSearch\Pro\Classes\Utils;

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
 * Install utils.
 *
 * @since $v Initial release.
 */
class Installer extends SCoreClasses\SCore\Base\Core
{
    /**
     * Other install routines.
     *
     * @since $v Initial release.
     *
     * @param array $history Install history.
     */
    public function onOtherInstallRoutines(array $history)
    {
        $this->createSearchPage();
    }

    /**
     * Create search page.
     *
     * @since $v Initial release.
     */
    protected function createSearchPage()
    {
        if (s::getOption('page_id')) {
            return; // Done already.
        }
        $page_id = (int) wp_insert_post([
            'post_parent' => 0,
            'post_type'   => 'page',

            'post_status' => 'publish',
            'post_name'   => 'search',

            'post_title'   => __('Search', 'wp-site-search'),
            'post_content' => '[google_cse /]', // Via shortcode.

            'post_author' => get_current_user_id() ?: 1,

            'comment_status' => 'closed',
            'ping_status'    => 'closed',
        ]);
        if ($page_id) {
            s::updateOptions(['page_id' => $page_id]);
        }
    }

    /**
     * Version-specific upgrades.
     *
     * @since $v Initial release.
     *
     * @param array $history Install history.
     */
    public function onVsUpgrades(array $history)
    {
        // Do something here.
        // VS upgrades run 'before' any other installer.
        // if (version_compare($history['last_version'], '000000', '<')) {
        //     $this->App->Utils->VsUpgrades->fromLt000000();
        // }
    }
}

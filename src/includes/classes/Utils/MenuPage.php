<?php
/**
 * Menu page utils.
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
 * Menu page utils.
 *
 * @since $v Initial release.
 */
class MenuPage extends SCoreClasses\SCore\Base\Core
{
    /**
     * On `admin_menu` hook.
     *
     * @since $v Initial release.
     */
    public function onAdminMenu()
    {
        s::addMenuPageItem([
            'parent_page'   => 'options-general.php',
            'menu_title'    => __('Site Search', 'wp-site-search'),
            'template_file' => 'admin/menu-pages/options/default.php',

            'meta_links' => ['restore' => true],
            'tabs'       => [
                'default' => sprintf(__('%1$s', 'wp-site-search'), esc_html($this->App->Config->©brand['©name'])),
                'design'  => __('Design / Colors', 'wp-site-search'),
            ],
        ]);
    }
}

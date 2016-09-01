<?php
/**
 * Styles/scripts.
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
 * Styles/scripts.
 *
 * @since 160901.56373 Styles/scripts.
 */
class StylesScripts extends SCoreClasses\SCore\Base\Core
{
    /**
     * Scripts/styles.
     *
     * @since 160901.56373 Styles/scripts.
     */
    public function onWpEnqueueScripts()
    {
        if (!is_singular()) {
            return; // Not applicable.
        } elseif (!($WP_Post = get_post())) {
            return; // Not possible.
        } elseif (mb_strpos($WP_Post->post_content, '[google_cse') === false) {
            return; // Not necessary.
        }
        $brand_slug    = $this->App->Config->©brand['©slug'];
        $font_family   = s::getOption('google_cse_font_family');
        $inline_styles = '.'.$brand_slug.'-google-cse > * > .gsc-control-cse { font-family: '.$font_family.'; }'."\n".
            '.'.$brand_slug.'-google-cse > * > .gsc-control-cse .gsc-table-result { font-family: inherit; }';

        wp_enqueue_style($this->App->Config->©brand['©slug'], c::appUrl('/client-s/css/site/google-cse.min.css'), [], $this->App::VERSION);
        wp_add_inline_style($this->App->Config->©brand['©slug'], $inline_styles);
    }
}

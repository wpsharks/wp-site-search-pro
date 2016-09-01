<?php
/**
 * Shortcode utils.
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
 * Shortcode utils.
 *
 * @since 160901.56373 Initial release.
 */
class Shortcode extends SCoreClasses\SCore\Base\Core
{
    /**
     * `[google_cse] /]` shortcode.
     *
     * @since 160901.56373 Initial release.
     *
     * @param array|string $atts      Shortcode attributes.
     * @param string|null  $content   Shortcode content.
     * @param string       $shortcode Shortcode name.
     */
    public function onGoogleCseShortcode($atts = [], $content = '', $shortcode = ''): string
    {
        static $counter = 0; // Initialize.
        ++$counter; // Auto-increment counter.

        $atts      = is_array($atts) ? $atts : [];
        $content   = (string) $content;
        $shortcode = (string) $shortcode;

        $default_atts = [ // See: <http://jas.xyz/2crfsFl>
            'enableHistory'      => 'true',
            'queryParameterName' => s::getOption('q_var'),
            'gaQueryParameter'   => s::getOption('q_var'),

            'enableAutoComplete'         => 'true',
            'autoCompleteMatchType'      => 'any',
            'autoCompleteMaxCompletions' => '10',
        ];
        $raw_atts = $atts; // Copy.
        $atts     = c::unescHtml($atts);
        $atts     = array_merge($default_atts, $atts);

        if ($shortcode) { // NOTE: We don't use `shortcode_atts()` on purpose.
            $atts = apply_filters('shortcode_atts_'.$shortcode, $atts, $default_atts, $raw_atts, $shortcode);
        } // However, this will still apply the filter like `shortcode_atts()` would do.

        $class      = $this->App->Config->©brand['©slug'].'-google-cse';
        $js_snippet = $gcse_search_tag_attrs = $gcse_search_tag = '';

        if ($counter === 1) { // JS snippet.
            add_action('wp_footer', function () {
                $js_snippet = c::getTemplate('site/shortcodes/google-cse/js-snippet.html')->parse();
                echo $js_snippet = str_replace('%%cref%%', a::googleCseUrl(), $js_snippet);
            });
        }
        foreach ($atts as $_name => $_value) { // See: <http://jas.xyz/2crfsFl>
            if ($_name && is_string($_name)) { // Must have a valid HTML attribute name.
                $gcse_search_tag_attrs .= ' data-'.$_name.'="'.esc_attr($_value).'"';
            }
        } // unset($_name, $_value); // Housekeeping.

        $gcse_search_tag = '<div class="gcse-search"'.$gcse_search_tag_attrs.'></div>';
        return $output   = '<div class="'.esc_attr($class).'">'.$gcse_search_tag.'</div>';
    }
}

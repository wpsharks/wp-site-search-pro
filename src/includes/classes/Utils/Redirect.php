<?php
/**
 * Redirect utils.
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
 * Redirect utils.
 *
 * @since 160901.56373 CSE utils.
 */
class Redirect extends SCoreClasses\SCore\Base\Core
{
    /**
     * On `template_redirect` hook.
     *
     * @since 160901.56373 CSE utils.
     */
    public function onTemplateRedirect()
    {
        if (c::isCli()) {
            return; // Not possible.
        } elseif (!s::getOption('redirect_searches')) {
            return; // Not redirecting.
        } elseif (!($q_var = s::getOption('q_var'))) {
            return; // Not possible; no `q` var.
        } elseif (empty($_REQUEST['s']) && empty($_REQUEST[$q_var])) {
            return; // Nothing to do here.
        } elseif (is_feed()) {
            return; // Not applicable.
        }
        // Don't allow both to be the same.
        $q_var = $q_var === 's' ? 'q' : $q_var;

        $s_value = (string) ($_REQUEST['s'] ?? '');
        $s_value = $s_value ? c::mbTrim(c::unslash($s_value)) : '';

        $q_value = (string) ($_REQUEST[$q_var] ?? '');
        $q_value = $q_value ? c::mbTrim(c::unslash($q_value)) : '';

        if (!$s_value && !$q_value) {
            return; // Nothing to do here.
        }
        $page_id = s::getOption('page_id'); // `/search` page.
        $url     = $page_id ? get_permalink($page_id) : '';

        if (!$page_id || !$url) {
            return; // Not possible.
        } elseif ($q_value && is_page($page_id)) {
            return; // Already here.
        }
        $s_value = $q_value ?: $s_value; // `q` wins.

        $url = c::removeUrlQueryArgs(['s', $q_var], $url);
        $url = c::addUrlQueryArgs([$q_var => $s_value], $url);

        wp_redirect($url, 301).exit();
    }
}

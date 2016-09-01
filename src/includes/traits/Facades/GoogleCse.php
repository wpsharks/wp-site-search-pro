<?php
/**
 * Google CSE.
 *
 * @author @jaswsinc
 * @copyright WP Sharks™
 */
declare (strict_types = 1);
namespace WebSharks\WpSharks\WpSiteSearch\Pro\Traits\Facades;

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
 * Google CSE.
 *
 * @since $v Initial release.
 */
trait GoogleCse
{
    /**
     * @since $v Initial release.
     *
     * @param mixed ...$args Variadic args to underlying utility.
     *
     * @see Classes\Utils\GoogleCse::options()
     */
    public static function googleCseOptions(...$args)
    {
        return $GLOBALS[static::class]->Utils->GoogleCse->options(...$args);
    }

    /**
     * @since $v Initial release.
     *
     * @param mixed ...$args Variadic args to underlying utility.
     *
     * @see Classes\Utils\GoogleCse::hash()
     */
    public static function googleCseHash(...$args)
    {
        return $GLOBALS[static::class]->Utils->GoogleCse->hash(...$args);
    }

    /**
     * @since $v Initial release.
     *
     * @param mixed ...$args Variadic args to underlying utility.
     *
     * @see Classes\Utils\GoogleCse::url()
     */
    public static function googleCseUrl(...$args)
    {
        return $GLOBALS[static::class]->Utils->GoogleCse->url(...$args);
    }

    /**
     * @since $v Initial release.
     *
     * @param mixed ...$args Variadic args to underlying utility.
     *
     * @see Classes\Utils\GoogleCse::generate()
     */
    public static function generateGoogleCse(...$args)
    {
        return $GLOBALS[static::class]->Utils->GoogleCse->generate(...$args);
    }
}

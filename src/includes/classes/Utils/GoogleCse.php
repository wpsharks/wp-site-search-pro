<?php
/**
 * CSE utils.
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
 * CSE utils.
 *
 * @since 160901.56373 CSE utils.
 */
class GoogleCse extends SCoreClasses\SCore\Base\Core
{
    /**
     * On `wp_loaded` hook.
     *
     * @since 160901.56373 CSE utils.
     */
    public function onWpLoaded()
    {
        if (c::isCli()) {
            return; // Not applicable.
        } elseif (empty($_SERVER['REQUEST_URI'])) {
            return; // Not applicable.
        } elseif (mb_strpos($_SERVER['REQUEST_URI'], '/google-cse.xml') === false) {
            return; // Not applicable.
        } elseif (!preg_match('/\/google\-cse\.xml$/u', c::currentPath())) {
            return; // Not applicable.
        }
        $xml = $this->generate();

        c::prepareForFileOutput();
        status_header(200);

        header('pragma: cache');
        header('cache-control: public, max-age=600');
        header('expires: '.gmdate('D, d M Y H:i:s', time() + 600).' GMT');

        header('content-type: text/xml; charset=utf-8');
        header('content-length: '.strlen($xml));

        exit($xml);
    }

    /**
     * URL to CSE definition file.
     *
     * @since 160901.56373 CSE utils.
     *
     * @return string URL to CSE definition file.
     */
    public function url(): string
    {
        return home_url('/'.$this->hash().'/google-cse.xml');
    }

    /**
     * Options.
     *
     * @since 160901.56373 CSE utils.
     *
     * @return array Options.
     */
    public function options(): array
    {
        if (($options = &$this->cacheKey(__FUNCTION__)) !== null) {
            return $options; // Cached this already.
        }
        $options = []; // Initialize options.

        foreach (s::options() as $_key => $_value) {
            if (mb_strpos($_key, 'google_cse_') === 0) {
                $options[mb_substr($_key, 11)] = $_value;
            }
        } // unset($_key, $_value); // Housekeeping.

        return $options;
    }

    /**
     * SHA-1 hash.
     *
     * @since 160901.56373 CSE utils.
     *
     * @return string SHA-1 hash.
     */
    public function hash(): string
    {
        if (($hash = &$this->cacheKey(__FUNCTION__)) !== null) {
            return $hash; // Cached this already.
        }
        return $hash = sha1(serialize($this->options()).$this->App::VERSION);
    }

    /**
     * Generate.
     *
     * @since 160901.56373 CSE utils.
     *
     * @return string XML file.
     */
    public function generate(): string
    {
        $o         = $this->options();
        $hash      = $this->hash();
        $transient = s::getTransient('google_cse');

        if ($transient && $transient['hash'] === $hash) {
            return $transient['xml'];
        }
        $transient = ['hash' => $hash]; // Initialize.

        $nodes = [
            'CustomSearchEngine' => [
                'volunteers' => 'false',
                'visible'    => 'false',

                'encoding' => 'utf-8',
                'language' => ' ', // Browser locale.
                // See: <https://developers.google.com/custom-search/docs/ref_languages>

                'enable_suggest'    => 'true',
                'enable_promotions' => 'true',

                'Title'       => [$o['title']],
                'Description' => [$o['description']],

                'Context' => [
                    'BackgroundLabels' => [
                        'Label' => [
                            'name' => 'site',
                            'mode' => 'FILTER',
                        ],
                    ],
                ],

                'AdSense' => [
                    'Client' => [
                        'id' => $o['adsense_client_id'],
                    ],
                ],

                'ImageSearchSettings' => [
                    'enable' => $o['image_search_enable'] ? 'true' : 'false',
                ],

                'autocomplete_settings' => [
                    'match_mode'         => '1',
                    'convert_promotions' => 'true',
                ],

                '0_sort_by_keys' => [
                    'key'   => '',
                    'label' => __('Relevance', 'wp-site-search'),
                ],
                '1_sort_by_keys' => [
                    'key'   => 'date',
                    'label' => __('Date', 'wp-site-search'),
                ],

                'cse_advance_settings' => [
                    'enable_speech'       => 'true',
                    'enable_facet_search' => 'true',

                    'web_search_options' => [
                        'show_structured_data' => 'false',
                    ],
                    'custom_search_control_options' => [
                        'refinement_style' => 'google.search.SearchControl.REFINEMENT_AS_TAB',
                    ],
                ],

                'LookAndFeel' => [
                    'element_layout' => '1', // Combo (full-width).

                    'ads_layout' => '1', // Undocumented at this time.
                    'nonprofit'  => $o['non_profit'] ? 'true' : 'false',

                    'url_length'           => 'full', // Or `domain`.
                    'promotion_url_length' => 'full', // Or `domain`.

                    'element_branding'     => 'show',
                    'enable_cse_thumbnail' => 'false',

                    'theme'        => '1', // Google classic.
                    'custom_theme' => 'true', // Enables colors below.
                    'text_font'    => $o['font_family'], // Font family.

                    'Colors' => [
                        'text' => $o['text_color'],

                        'url'     => $o['url_color'],
                        'visited' => $o['visited_color'],

                        'title'        => $o['title_color'],
                        'title_hover'  => $o['title_hover_color'],
                        'title_active' => $o['title_active_color'],
                    ],
                    'SearchControls' => [
                        'input_border_color' => $o['sb_input_border_color'],

                        'tab_border_color'     => $o['sb_tab_border_color'],
                        'tab_background_color' => $o['sb_tab_background_color'],

                        'tab_selected_border_color'     => $o['sb_tab_selected_border_color'],
                        'tab_selected_background_color' => $o['sb_tab_selected_background_color'],
                    ],
                    'Results' => [
                        'border_color'     => $o['sr_border_color'],
                        'background_color' => $o['sr_background_color'],

                        'border_hover_color'     => $o['sr_border_hover_color'],
                        'background_hover_color' => $o['sr_background_hover_color'],

                        'ads_border_color'     => $o['sr_ads_border_color'],
                        'ads_background_color' => $o['sr_ads_background_color'],
                    ],
                    'Promotions' => [
                        'border_color'     => $o['srp_border_color'],
                        'background_color' => $o['srp_background_color'],

                        'title_color'         => $o['srp_title_color'],
                        'title_hover_color'   => $o['srp_title_hover_color'],
                        'title_active_color'  => $o['srp_title_active_color'],
                        'title_visited_color' => $o['srp_title_visited_color'],

                        'snippet_color' => $o['srp_snippet_color'],
                        'url_color'     => $o['srp_url_color'],
                    ],
                ],
            ],
        ];
        $fa                                     = $this->facetsAnnotations($o);
        $nodes['CustomSearchEngine']['Context'] = array_merge($nodes['CustomSearchEngine']['Context'], $fa['facets']);
        $nodes['Annotations']                   = $fa['annotations'];

        $transient['xml'] = c::arrayToXml('GoogleCustomizations', $nodes);
        s::setTransient('google_cse', $transient, DAY_IN_SECONDS);

        return $transient['xml'];
    }

    /**
     * Facets/Annotations.
     *
     * @since 160901.56373 CSE utils.
     *
     * @param $o array CSE options.
     *
     * @return array `[facets, annotations]`.
     */
    protected function facetsAnnotations(array $o): array
    {
        if (!$o['site_pattern']) {
            $o['site_pattern'] = preg_replace('/^https?\:\/\//ui', '', home_url('/'));
            $o['site_pattern'] = c::mbRTrim($o['site_pattern'], '/').'/*';
        }
        $facets                      = [];
        $annotations['0_Annotation'] = [
            'about' => $o['site_pattern'],
            'Label' => ['name' => 'site'],
        ];
        if ($o['facets']) { // Line-delimited list of facets.
            $_facets = preg_split('/['."\r\n".']+/u', $o['facets'], -1, PREG_SPLIT_NO_EMPTY);
            // e.g., `Example Facet|www.example.com/facet/*` (line-delimited).

            foreach ($_facets as $_facet) {
                if (mb_strpos($_facet, '|') === false) {
                    continue; // Invalid facet.
                }
                list($_title, $_pattern) = explode('|', $_facet, 2);
                $_var                    = c::nameToVar($_title);

                $facets[count($facets).'_Facet'] = [
                    'FacetItem' => [
                        'title' => $_title,
                        'Label' => [
                            'name'                   => $_var,
                            'mode'                   => 'FILTER',
                            'IgnoreBackgroundLabels' => ['true'],
                        ],
                    ],
                ];
                $annotations[count($annotations).'_Annotation'] = [
                    'about' => $_pattern,
                    'Label' => ['name' => $_var],
                ];
            } // unset($_facets, $_facet, $_title, $_pattern, $_var);
        }
        return compact('facets', 'annotations'); // Both facets & annotations.
    }
}

<?php
/**
 * Template.
 *
 * @author @jaswsinc
 * @copyright WP Sharks™
 */
declare (strict_types = 1);
namespace WebSharks\WpSharks\WpSiteSearch\Pro;

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

$Form = $this->s::menuPageForm('§save-options');
?>
<?= $Form->openTag(); ?>

    <?= $Form->openTable(
        __('General Options', 'wp-site-search'),
        sprintf(__('You can browse our <a href="%1$s" target="_blank">knowledge base</a> to learn more about these options.', 'wp-site-search'), esc_url(s::brandUrl('/kb')))
    ); ?>

        <?= $Form->selectRow([
            'label' => __('Search Page', 'wp-site-search'),
            'tip'   => __('Choose a Page where searches can be performed.<hr />This Page is created automatically by the plugin. It contains a WordPress Shortcode that powers site search functionality.<hr /><code>[google_cse /]</code>', 'wp-site-search'),

            'name'    => 'page_id',
            'value'   => s::getOption('page_id'),
            'options' => s::postSelectOptions([
                'include_post_types'    => ['page'],
                'include_post_statuses' => ['publish'],
                'current_post_ids'      => [s::getOption('page_id')],
            ]),
        ]); ?>

        <?= $Form->selectRow([
            'label' => __('Handle WP Searches?', 'wp-site-search'),
            'tip'   => __('If enabled, all WordPress searches using <code>?s=[query]</code> will be redirected to your Search Page with <code>?q=[query]</code>', 'wp-site-search'),

            'name'    => 'redirect_searches',
            'value'   => s::getOption('redirect_searches'),
            'options' => [
                0 => __('No', 'wp-site-search'),
                1 => __('Yes', 'wp-site-search'),
            ],
        ]); ?>

        <?= $Form->inputRow([
            'type'        => 'text',
            'label'       => __('Query Variable', 'wp-site-search'),
            'placeholder' => __('q', 'wp-site-search'), // Keep this simple; i.e., just the ideal value.
            'tip'         => __('Variable your Search Page receives for a new incoming search query; e.g., for <code>?q=[query]</code>, just type <code>q<code> into this field.', 'wp-site-search'),
            'note'        => __('<code>q</code> is suggested for best compatibility with WordPress, AdSense, and Google Analytics.', 'wp-site-search'),

            'name'  => 'q_var',
            'value' => s::getOption('q_var'),
        ]); ?>

        <?= $Form->inputRow([
            'type'        => 'text',
            'label'       => __('Search Pattern', 'wp-site-search'),
            'placeholder' => sprintf(__('*.%1$s/*', 'wp-site-search'), esc_attr($this->App->Config->©urls['©hosts']['©roots']['©app'])),
            'tip'         => __('Tells Google which site you would like to search.<hr />You can use <code>*</code> asterisks in your pattern as a wildcard that will match anything.', 'wp-site-search'),

            'name'  => 'google_cse_site_pattern',
            'value' => s::getOption('google_cse_site_pattern'),
        ]); ?>

        <?= $Form->selectRow([
            'label' => __('Enable Image Search?', 'wp-site-search'),
            'tip'   => __('For most sites, this should be disabled in favor of a simpler search interface when it\'s off.', 'wp-site-search'),

            'name'    => 'google_cse_image_search_enable',
            'value'   => s::getOption('google_cse_image_search_enable'),
            'options' => [
                0 => __('No', 'wp-site-search'),
                1 => __('Yes', 'wp-site-search'),
            ],
        ]); ?>

        <?= $Form->textareaRow([
            'type'        => 'text',
            'label'       => __('Additional Tabs', 'wp-site-search'),
            'placeholder' => sprintf(__('Topics|*.%1$s/*/topic/*', 'wp-site-search'), esc_attr($this->App->Config->©urls['©hosts']['©roots']['©app']))."\n".
                             sprintf(__('Articles|*.%1$s/article/*', 'wp-site-search'), esc_attr($this->App->Config->©urls['©hosts']['©roots']['©app']))."\n".
                             sprintf(__('Products|*.%1$s/product/*', 'wp-site-search'), esc_attr($this->App->Config->©urls['©hosts']['©roots']['©app'])),
            'tip'  => __('A list of additional patterns that become search tabs.<hr />This allows a user to refine their search. Each line in this configuration becomes a new tab in the search interface.', 'wp-site-search'),
            'note' => __('e.g., <code>Title</code>|<code>pattern</code> ... (one per line).', 'wp-site-search'),

            'name'  => 'google_cse_facets',
            'value' => s::getOption('google_cse_facets'),
        ]); ?>

        <?= $Form->selectRow([
            'label' => __('Disable AdSense Ads?', 'wp-site-search'),
            'tip'   => __('This asks Google not to show ads in your search results.', 'wp-site-search'),
            'note'  => __('According to Google, you must be a registered non-profit to disable ads.', 'wp-site-search'),

            'name'    => 'google_cse_non_profit',
            'value'   => s::getOption('google_cse_non_profit'),
            'options' => [
                0 => __('No, I will earn revenue from ads.', 'wp-site-search'),
                1 => __('Yes, disable ads. I\'m a non-profit organization.', 'wp-site-search'),
            ],
        ]); ?>

        <?= $Form->inputRow([
            'type'        => 'text',
            'label'       => __('AdSense Publisher ID', 'wp-site-search'),
            'placeholder' => __('partner-pub-7789239515831279', 'wp-site-search'),
            'tip'         => __('If you have a Google AdSense account, set this to your own AdSense publisher ID.<hr />This allows you to earn revenue from ad impressions that result from users searching your site.', 'wp-site-search'),

            'name'  => 'google_cse_adsense_client_id',
            'value' => s::getOption('google_cse_adsense_client_id'),
        ]); ?>

    <?= $Form->closeTable(); ?>

    <?= $Form->submitButton(); ?>
<?= $Form->closeTag(); ?>

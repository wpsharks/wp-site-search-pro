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
        __('Design Options', 'wp-site-search'),
        sprintf(__('You can browse our <a href="%1$s" target="_blank">knowledge base</a> to learn more .', 'wp-site-search'), esc_url(s::brandUrl('/kb')))
    ); ?>

        <?= $Form->inputRow([
            'type'        => 'text',
            'label'       => __('Font Family', 'wp-site-search'),
            'placeholder' => __("'Gill Sans', Arial, sans-serif", 'wp-site-search'),
            'tip'         => __('This is a comma-delimited list of font families, using CSS.<hr />Use <code>inherit</code> to inherit the font-family that your WordPress theme uses.', 'wp-site-search'),

            'name'  => 'google_cse_font_family',
            'value' => s::getOption('google_cse_font_family'),
        ]); ?>

        <tr><td colspan="2" style="padding:0;"><hr /></td></tr>

        <?= $Form->inputRow([
            'type'        => 'color',
            'label'       => __('Default Text', 'wp-site-search'),
            'placeholder' => __('#000000', 'wp-site-search'),

            'name'  => 'google_cse_text_color',
            'value' => s::getOption('google_cse_text_color'),
        ]); ?>

        <tr><td colspan="2" style="padding:0;"><hr /></td></tr>

        <?= $Form->inputRow([
            'type'        => 'color',
            'label'       => __('Result Title', 'wp-site-search'),
            'placeholder' => __('#0000CC', 'wp-site-search'),

            'name'  => 'google_cse_title_color',
            'value' => s::getOption('google_cse_title_color'),
        ]); ?>

        <?= $Form->inputRow([
            'type'        => 'color',
            'label'       => __('Result Title (On Hover)', 'wp-site-search'),
            'placeholder' => __('#0000CC', 'wp-site-search'),

            'name'  => 'google_cse_title_hover_color',
            'value' => s::getOption('google_cse_title_hover_color'),
        ]); ?>

        <?= $Form->inputRow([
            'type'        => 'color',
            'label'       => __('Result Title (When Active)', 'wp-site-search'),
            'placeholder' => __('#0000CC', 'wp-site-search'),

            'name'  => 'google_cse_title_active_color',
            'value' => s::getOption('google_cse_title_active_color'),
        ]); ?>

        <tr><td colspan="2" style="padding:0;"><hr /></td></tr>

        <?= $Form->inputRow([
            'type'        => 'color',
            'label'       => __('Result URL', 'wp-site-search'),
            'placeholder' => __('#008000', 'wp-site-search'),

            'name'  => 'google_cse_url_color',
            'value' => s::getOption('google_cse_url_color'),
        ]); ?>

        <?= $Form->inputRow([
            'type'        => 'color',
            'label'       => __('Result URL (When Visited)', 'wp-site-search'),
            'placeholder' => __('#1A2554', 'wp-site-search'),

            'name'  => 'google_cse_visited_color',
            'value' => s::getOption('google_cse_visited_color'),
        ]); ?>

        <tr><td colspan="2" style="padding:0;"><hr /></td></tr>

        <?= $Form->inputRow([
            'type'        => 'color',
            'label'       => __('Query Input Border', 'wp-site-search'),
            'placeholder' => __('#D9D9D9', 'wp-site-search'),

            'name'  => 'google_cse_sb_input_border_color',
            'value' => s::getOption('google_cse_sb_input_border_color'),
        ]); ?>

        <tr><td colspan="2" style="padding:0;"><hr /></td></tr>

        <?= $Form->inputRow([
            'type'        => 'color',
            'label'       => __('Tab Border', 'wp-site-search'),
            'placeholder' => __('#DFDFDF', 'wp-site-search'),

            'name'  => 'google_cse_sb_tab_border_color',
            'value' => s::getOption('google_cse_sb_tab_border_color'),
        ]); ?>

        <?= $Form->inputRow([
            'type'        => 'color',
            'label'       => __('Tab Background', 'wp-site-search'),
            'placeholder' => __('#DFDFDF', 'wp-site-search'),

            'name'  => 'google_cse_sb_tab_background_color',
            'value' => s::getOption('google_cse_sb_tab_background_color'),
        ]); ?>

        <tr><td colspan="2" style="padding:0;"><hr /></td></tr>

        <?= $Form->inputRow([
            'type'        => 'color',
            'label'       => __('Tab Border (When Selected)', 'wp-site-search'),
            'placeholder' => __('#1A2554', 'wp-site-search'),

            'name'  => 'google_cse_sb_tab_selected_border_color',
            'value' => s::getOption('google_cse_sb_tab_selected_border_color'),
        ]); ?>

        <?= $Form->inputRow([
            'type'        => 'color',
            'label'       => __('Tab Background (When Selected)', 'wp-site-search'),
            'placeholder' => __('#F0F0F0', 'wp-site-search'),

            'name'  => 'google_cse_sb_tab_selected_background_color',
            'value' => s::getOption('google_cse_sb_tab_selected_background_color'),
        ]); ?>

        <tr><td colspan="2" style="padding:0;"><hr /></td></tr>

        <?= $Form->inputRow([
            'type'        => 'color',
            'label'       => __('Result Border', 'wp-site-search'),
            'placeholder' => __('#FFFFFF', 'wp-site-search'),

            'name'  => 'google_cse_sr_border_color',
            'value' => s::getOption('google_cse_sr_border_color'),
        ]); ?>

        <?= $Form->inputRow([
            'type'        => 'color',
            'label'       => __('Result Background', 'wp-site-search'),
            'placeholder' => __('#FFFFFF', 'wp-site-search'),

            'name'  => 'google_cse_sr_background_color',
            'value' => s::getOption('google_cse_sr_background_color'),
        ]); ?>

        <tr><td colspan="2" style="padding:0;"><hr /></td></tr>

        <?= $Form->inputRow([
            'type'        => 'color',
            'label'       => __('Result Border (On Hover)', 'wp-site-search'),
            'placeholder' => __('#FFFFFF', 'wp-site-search'),

            'name'  => 'google_cse_sr_border_hover_color',
            'value' => s::getOption('google_cse_sr_border_hover_color'),
        ]); ?>

        <?= $Form->inputRow([
            'type'        => 'color',
            'label'       => __('Result Background (On Hover)', 'wp-site-search'),
            'placeholder' => __('#FFFFFF', 'wp-site-search'),

            'name'  => 'google_cse_sr_background_hover_color',
            'value' => s::getOption('google_cse_sr_background_hover_color'),
        ]); ?>

        <tr><td colspan="2" style="padding:0;"><hr /></td></tr>

        <?= $Form->inputRow([
            'type'        => 'color',
            'label'       => __('AdSense Ad Border', 'wp-site-search'),
            'placeholder' => __('#F8FEF3', 'wp-site-search'),

            'name'  => 'google_cse_sr_ads_border_color',
            'value' => s::getOption('google_cse_sr_ads_border_color'),
        ]); ?>

        <?= $Form->inputRow([
            'type'        => 'color',
            'label'       => __('AdSense Ad Background', 'wp-site-search'),
            'placeholder' => __('#F8FEF3', 'wp-site-search'),

            'name'  => 'google_cse_sr_ads_background_color',
            'value' => s::getOption('google_cse_sr_ads_background_color'),
        ]); ?>

        <tr><td colspan="2" style="padding:0;"><hr /></td></tr>

        <?= $Form->inputRow([
            'type'        => 'color',
            'label'       => __('Promotion Border', 'wp-site-search'),
            'placeholder' => __('#FFFFFF', 'wp-site-search'),

            'name'  => 'google_cse_srp_border_color',
            'value' => s::getOption('google_cse_srp_border_color'),
        ]); ?>

        <?= $Form->inputRow([
            'type'        => 'color',
            'label'       => __('Promotion Background', 'wp-site-search'),
            'placeholder' => __('#FFFFFF', 'wp-site-search'),

            'name'  => 'google_cse_srp_background_color',
            'value' => s::getOption('google_cse_srp_background_color'),
        ]); ?>

        <tr><td colspan="2" style="padding:0;"><hr /></td></tr>

        <?= $Form->inputRow([
            'type'        => 'color',
            'label'       => __('Promotion Title', 'wp-site-search'),
            'placeholder' => __('#0000CC', 'wp-site-search'),

            'name'  => 'google_cse_srp_title_color',
            'value' => s::getOption('google_cse_srp_title_color'),
        ]); ?>

        <?= $Form->inputRow([
            'type'        => 'color',
            'label'       => __('Promotion Title (On Hover)', 'wp-site-search'),
            'placeholder' => __('#0000CC', 'wp-site-search'),

            'name'  => 'google_cse_srp_title_hover_color',
            'value' => s::getOption('google_cse_srp_title_hover_color'),
        ]); ?>

        <?= $Form->inputRow([
            'type'        => 'color',
            'label'       => __('Promotion Title (When Active)', 'wp-site-search'),
            'placeholder' => __('#0000CC', 'wp-site-search'),

            'name'  => 'google_cse_srp_title_active_color',
            'value' => s::getOption('google_cse_srp_title_active_color'),
        ]); ?>

        <?= $Form->inputRow([
            'type'        => 'color',
            'label'       => __('Promotion Title (When Visited)', 'wp-site-search'),
            'placeholder' => __('#1A2554', 'wp-site-search'),

            'name'  => 'google_cse_srp_title_visited_color',
            'value' => s::getOption('google_cse_srp_title_visited_color'),
        ]); ?>

        <tr><td colspan="2" style="padding:0;"><hr /></td></tr>

        <?= $Form->inputRow([
            'type'        => 'color',
            'label'       => __('Promotion Snippet', 'wp-site-search'),
            'placeholder' => __('#000000', 'wp-site-search'),

            'name'  => 'google_cse_srp_snippet_color',
            'value' => s::getOption('google_cse_srp_snippet_color'),
        ]); ?>

        <?= $Form->inputRow([
            'type'        => 'color',
            'label'       => __('Promotion URL', 'wp-site-search'),
            'placeholder' => __('#008000', 'wp-site-search'),

            'name'  => 'google_cse_srp_url_color',
            'value' => s::getOption('google_cse_srp_url_color'),
        ]); ?>

    <?= $Form->closeTable(); ?>

    <?= $Form->submitButton(); ?>
<?= $Form->closeTag(); ?>

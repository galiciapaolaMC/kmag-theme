<?php

namespace CN\App\Components;

use CN\App\Fields\Util;

/**
 * Class ComboBox
 *
 * @package CN\App\Components
 */
class ComboBox
{

    /**
     * Gets tax terms and formats for combobox/getComboboxHtml function input
     *
     * @param string $taxonomy_slug
     * @param array $post_types - by slug
     *
     * @return array [
     *      'label' => string,
     *      'value' => string,
     *      'selected' => boolean
     * ]
     */
    public static function getTaxItemsForCombobox($taxonomy_slug, $args = [])
    {
        $defaults = [
            'taxonomy' => $taxonomy_slug,
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => true
        ];

        $final_args = wp_parse_args($args, $defaults);
        $terms = get_terms($final_args);

        $items = [];
        foreach ($terms as $term) {
            $items[$term->slug] = [
                'label' => $term->name,
                'value' => $term->slug,
                'selected' => false
            ];
        }

        return $items;
    }

    /**
     * Takes a list of items and formats them in a ul list of single selectable
     * checkboxes which are attached to listenable js event changes.
     * 
     * @param array  $items
     * @param string $items[]['label']
     * @param string $items[]['value']
     * @param bool   $items[]['selected']
     * @param bool $show_icons - adds icons to the list items
     *
     * @return string
     */
    public static function buildSingleSelectListHtml($items, $show_icons = false)
    {
        $list_html = '';

        foreach ($items as $item) {
            $list_html .= sprintf(
                '<li>
                    <label class="item%4$s">
                        <span class="item__label-text">%5$s%1$s</span>
                        <input class="uk-checkbox" type="checkbox" value="%2$s"%3$s>
                    </label>
                </li>',
                $item['label'],
                $item['value'],
                $item['selected'] ? ' checked' : '',
                $item['selected'] ? ' uk-active' : '',
                $show_icons ? ' ' . Util::getIconHTML($item['value']) : '',
            );
        }

        $list_html = '<ul>' . $list_html . '</ul>';

        return $list_html;
    }

    /**
     * Takes a list of items and formats them in a ul list of multiple selectable
     * checkboxes which are attached to listenable js event changes.
     * 
     * @param array  $items[]
     * @param string $items[]['label']
     * @param string $items[]['value']
     * @param bool   $items[]['selected']
     *
     * @return string
     */
    public static function buildMultiSelectListHtml($items)
    {
        $list_html = '';

        foreach ($items as $key => $item) {
            $list_html .= sprintf(
                '<li>
                    <label class="item">
                        <span class="item__label-text">%1$s</span>
                        <input class="uk-checkbox" type="checkbox" value="%2$s"%3$s>
                    </label>
                </li>',
                $item['label'],
                $key,
                $item['selected'] ? ' checked' : ''
            );
        }

        $apply_button_li_html = sprintf(
            '<li>
                <label class="item item--action">
                    <button class="btn btn--secondary" role="button" data-button="apply" disabled>%1$s</button>
                </label>
            </li>',
            __('Apply', 'kmag'),
        );

        $list_html = '<ul>' . $apply_button_li_html . $list_html . '</ul>';

        return $list_html;
    }

    /**
     * Separates a list of items into groups and formats them in a ul list
     * 
     * @param array  $items[]
     * @param string $items[]['label']
     * @param string $items[]['value']
     * @param bool   $items[]['selected']
     *
     * @return string
     */
    public static function buildMultiSelectProductsListHtml($items)
    {
        $list_html = '';
        $grouped_items = [];
        foreach (PERFORMANCE_PRODUCTS_GROUP_LIST as $group_key => $group) {
            if (!in_array($group_key, $grouped_items)) {
                $grouped_items[$group_key] = [];
            }

            foreach ($items as $item_key => $item) {
                if (in_array($item_key, $group['items'])) {
                    $grouped_items[$group_key][$item_key] = $item;
                }
            }
        }
        foreach ($grouped_items as $key => $group) {
            if (count($group) === 0) {
                continue;
            }

            $list_html .= sprintf(
                '<li>
                    <label class="item item--title">%1$s</label>
                </li>',
                esc_html(PERFORMANCE_PRODUCTS_GROUP_LIST[$key]['label'])
            );

            foreach ($group as $key => $item) {
                $list_html .= sprintf(
                    '<li>
                        <label class="item">
                            <span class="item__label-text">%1$s</span>
                            <input class="uk-checkbox" type="checkbox" value="%2$s"%3$s>
                        </label>
                    </li>',
                    $item['label'],
                    $key,
                    $item['selected'] ? ' checked' : ''
                );
            }
        }

        $apply_button_li_html = sprintf(
            '<li>
                <label class="item item--action">
                    <button class="btn btn--secondary" role="button" data-button="apply" disabled>%1$s</button>
                </label>
            </li>',
            __('Apply', 'kmag'),
        );

        $list_html = '<ul>' . $apply_button_li_html . $list_html . '</ul>';

        return $list_html;
    }

    /**
     * Takes a list of items and formats them for a uikit style combobox.
     *
     * @param array  $args
     * @param string $args['label-html'] - Combobox label above button
     * @param string $args['list-html'] - string of html to insert into dropdown
     * @param string $args['id'] - Combobox id
     * @param bool   $args['is-multi'] - Whether or not to allow multiple selections 
     *
     * @return string
     */
    public static function getComboboxHtml($args)
    {
        $id = $args['id'] ?? '';
        $label_html = $args['label-html'] ?? '';
        $list_html = $args['list-html'] ?? '';
        $is_multi_select = $args['is-multi'] ?? false;

        $id = sanitize_title($id);

        $combobox_html = sprintf(
            '<button
                class="uk-button uk-button-default"
                role="combobox"
                type="button"
                id="combo-%2$s"
                aria-labelledby="combo-%2$s-label"
                aria-controls="listbox-%2$s"
                aria-expanded="false"
                aria-haspopup="listbox"
                %3$s
            >
                <div class="cn-dropdown__label">%1$s</div>
                <svg class="icon icon-arrow-down" aria-label="%1$s">
                    <use xlink:href="#icon-arrow-down"></use>
                </svg>
            </button>',
            __('Select', 'kmag'),
            $id,
            empty($list_html) ? 'disabled="disabled"' : '',
        );

        $listbox_html = sprintf(
            '<div
                role="listbox"
                id="listbox-%2$s"
                aria-labelledby="combo-%2$s-label"
                tabindex="-1"
                uk-dropdown="pos: bottom-left; boundary: !.boundary; shift: false; flip: false; mode:click;"
            >
                <div class="uk-nav uk-dropdown-nav">
                    %1$s
                </div>
            </div>',
            $list_html,
            $id,
        );

        $listbox_label_html = '';
        if (!empty($label_html)) {
            $listbox_label_html = sprintf(
                '<label>%1$s</label>',
                esc_html($label_html),
            );
        }

        $html = sprintf(
            '<div class="cn-dropdown %1$s" data-filter="%2$s"%3$s>
                %4$s
                %5$s
                %6$s
            </div>',
            $is_multi_select ? ' cn-dropdown--multi-select' : 'cn-dropdown--single-select',
            $id,
            $is_multi_select ? ' data-multi-select="true"' : '',
            $listbox_label_html,
            $combobox_html,
            $listbox_html,
        );

        return $html;
    }
}

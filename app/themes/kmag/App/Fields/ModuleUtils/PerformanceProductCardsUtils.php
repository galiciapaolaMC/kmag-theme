<?php

namespace CN\App\Fields\ModuleUtils;

use CN\App\Fields\Util;

/**
 * Class PerformanceProductCardsUtils
 *
 * @package CN\App\Fields
 */
class PerformanceProductCardsUtils
{
    public static function getProductCategoryTranslation($product_category)
    {
        switch ($product_category) {
            case 'performance-fertilizer':
                return __('Performance Fertilizer', 'kmag');
            case 'biological-fertilizer-compliment':
                return __('Biological Fertilizer Compliment', 'kmag');
            case 'suplemental-fertilizer':
                return __('Suplemental Fertilizer', 'kmag');
            default:
                return '';
        }
    }

    public static function renderPerformanceProductCard($card, $variant) {
        $style = $card['bg-color'] ? 'style="background-color: ' . $card['bg-color'] . ';"' : '';
        $card_center = $variant === 'tagline-and-description' ? self::renderDescriptorVariant($card) : self::renderClassificationVariant($card);
        $product_image_html = $card['product-image'] ? '<img class="product-cards__product-image" alt="' . $card['name'] . ' Product Image" src="' . $card['product-image'] . '">' : '';
        $variant_class = 'product-cards__inner-wrap--' . $variant . '';
        $text_color_class = $card['text-color'] === 'light' ? 'product-cards__card--light-text' : 'product-cards__card--dark-text';
        return '
        <div class="product-cards__card '. $text_color_class .'" data-card-product="' . $card['slug'] . '">
            <div class="product-cards__inner-wrap '. $variant_class .'" ' . $style . '>
                <div class="product-cards__icon-wrap">
                    <img class="icon" src="' . $card['product-logo'] . '" alt="product logo" />
                </div>
                ' . $card_center . '
                <div class="product-cards__button-wrap">
                    <a href="' . $card['url'] . '" class="btn product-cards__button"> Go to ' . $card['name'] . '</a> 
                </div>
                ' . $product_image_html . '
            </div>
        </div>
        ';
    } 

    public static function renderProductTypeIconSection($card) {
        $rounding_class = $card['product-type'] === 'nutrient-enhancer' ? 'round' : '';
        $symbol = $card['product-type'] === 'nutrient-enhancer' ? 'NE' : 'BI';
        $productType = $card['product-type'] === 'nutrient-enhancer' ? __('Nutrient Enhancer', 'kmag') : __('Beneficial Input', 'kmag');
        return '
            <div class="product-cards__nutrient-wrap nutrient-badge">
                <div class="product-cards__nutrient-badge ' . $rounding_class . '">
                    <div class="product-cards__badge-wrap">
                        <p class="product-cards__enhancer-symbol">'. $symbol .'</p>
                        <p class="product-cards__enhancer-name">' . $productType . '</p>
                    </div>
                </div>
            </div>
        ';
    }

    public static function renderNutrientIconSection($card) {
        $nutrients = $card['nutrients'];
        $nutrient_html = '<div class="product-cards__nutrient-wrap">';
        foreach ($nutrients as $nutrient) {
            $nutrient_name = $nutrient['name'];
            $nutrient_symbol = $nutrient['symbol'];
            $nutrient_html .= '
                <div class="product-cards__nutrient">
                    <p class="nutrient-symbol">' . $nutrient_symbol . '</p>
                    <p class="nutrient-name">' . $nutrient_name . '</p>
                </div>
            ';
        }
        $nutrient_html .= '</div>';
        return $nutrient_html;
    }

    public static function renderDescriptorVariant($card) {
        return '
            <h2 class="product-cards__title">' . $card['tagline'] . '</h2>
            <p class="product-cards__paragraph">' . $card['description'] . '</p>
        ';
    }

    public static function renderClassificationVariant($card) {
        $icon_section_html = $card['icon-section'] === 'product-type' ? self::renderProductTypeIconSection($card) : self::renderNutrientIconSection($card);
        
        return '
            <h3 class="product-cards__fertilizer-type">' . self::getProductCategoryTranslation($card['product-category']) . '</h3>
        ' . $icon_section_html . '';
    }
}

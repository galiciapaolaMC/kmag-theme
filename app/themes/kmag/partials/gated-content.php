<?php
/**
 *  Gated Content partial template
 */

use CN\App\Fields\ACF;
use CN\App\Fields\Options;

$options = Options::getSiteOptions();
$delay = ACF::getField('gate-delay', $options);
$gda_test_gate = ACF::getField('gated-content_gda-test-gate', $data);
$headline = ACF::getField('gated-content_gate-headline', $data);

$crops = [['alfalfa','Alfalfa'], ['barley','Barley'], ['canola','Canola'], ['citrus','Citrus'], ['corn','Corn'],
        ['cotton','Cotton'], ['dry-beans','Dry Beans (including Chickpeas and Lentils)'], ['fruit','Fruit'],
        ['sorghum','Sorghum'], ['oats','Oats'], ['onions','Onions'], ['peanuts','Peanuts'], ['peas','Peas'],
        ['potato','Potato'], ['rice','Rice'], ['specialty/other','Specialty/Other'], ['soybean','Soybean'],
        ['spring-cereals','Spring Cereals'], ['spring-wheat','Spring Wheat'], ['sugar-beets','Sugar Beets'],
        ['sugar-cane','Sugar Cane'], ['sunflower','Sunflower'], ['tree-fruit-nuts-vines','Tree fruit, Nuts, Vines'],
        ['turf','Turf'], ['vegetables','Vegetables'], ['winter-wheat','Winter Wheat'], ['hay','Hay']];

$default_form = '<div class="gated-content__form-wrapper">
                <div id="gated-form">
                    <div class="gated-content__validation-wrapper">
                        <div class="gated-content__validation-message hide unshow">' . __('Please Complete All Fields.', 'kmag') . '</div>
                    </div>
                    <form id="gate-form">
                        <div class="uk-grid-collapse uk-child-width-1-2@m gated-content__form-row" uk-grid>
                            <div class="gated-content__input-wrapper">
                                <input type="text" placeholder="' . __('First Name', 'kmag') . '" name="first-name">
                            </div>
                            <div class="gated-content__input-wrapper">
                                <input type="text" placeholder="' . __('Last Name', 'kmag') . '" name="last-name">
                            </div>
                        </div>
                        <div class="uk-grid-collapse uk-child-width-1-2@m gated-content__form-row" uk-grid>
                            <div class="gated-content__full-input-wrapper">
                                <input type="text" pattern="^[0-9]{3}-?[0-9]{3}-?[0-9]{4}$" placeholder="' . __('Phone', 'kmag')  . ' (xxx-xxx-xxxx)" name="phone">
                            </div>
                        </div>
                        <div class="uk-grid-collapse gated-content__form-row" uk-grid>
                            <div class="gated-content__full-input-wrapper">
                                <input type="text" placeholder="' . __('Postal Code', 'kmag') . '" name="postal-code">
                            </div>
                            <div class="gated-content__full-input-wrapper">
                                <input type="text" pattern="^(.*)@(.*)\.(.*)$" placeholder="' . __('Email', 'kmag') . ' (xx@xx.xx)" name="email">
                            </div>
                            <div class="gated-content__dropdown-wrapper">
                                <button class="uk-button uk-button-default gated-content__dropdown-button" role="combobox" type="button" id="gated-occupation-select" aria-controls="gated-occupation-dropdown" aria-expanded="false" aria-haspopup="true">
                                    <div class="gated-content__dropdown-button-placeholder occupation">' . __('Occupation', 'kmag') . '</div>
                                    <span class="gated-content__dropdown-button-content occupation"></span>
                                    <svg class="icon icon-arrow-down">
                                        <use xlink:href="#icon-arrow-down"></use>
                                    </svg>
                                </button>
                                <div role="listbox" id="gated-occupation-dropdown" tabindex="-1" uk-dropdown="pos: bottom-center; boundary: !.boundary; shift: false; flip: false; mode:click;" class="uk-dropdown uk-animation-fade gated-content__dropdown">
                                    <ul class="uk-nav uk-dropdown-nav gated-content__occupation-dropdown">
                                        <li class="dropdown-li" data-name="' . __('Agronomist', 'kmag') . '"><span>' . __('Agronomist', 'kmag') . '</span></li>
                                        <li class="dropdown-li" data-name="' . __('Crop Consultant', 'kmag') . '"><span>' . __('Crop Consultant', 'kmag') . '</span></li>
                                        <li class="dropdown-li" data-name="' . __('Grower', 'kmag') . '"><span>' . __('Grower', 'kmag') . '</span></li>
                                        <li class="dropdown-li" data-name="' . __('Other', 'kmag') . '"><span>' . __('Other', 'kmag') . '</span></li>
                                        <li class="dropdown-li" data-name="' . __('Retailer', 'kmag') . '"><span>' . __('Retailer', 'kmag') . '</span></li>
                                        <li class="dropdown-li" data-name="' . __('Student', 'kmag') . '"><span>' . __('Student', 'kmag') . '</span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="gated-content__dropdown-wrapper">
                                <button class="uk-button uk-button-default gated-content__dropdown-button" role="combobox" type="button" id="gated-crop-select" aria-controls="gated-crop-dropdown" aria-expanded="false" aria-haspopup="true">
                                    <div class="gated-content__dropdown-button-placeholder crops">' . __('Crops Grown', 'kmag') . '</div>
                                    <span class="gated-content__dropdown-button-content crops"></span>
                                    <svg class="icon icon-arrow-down">
                                        <use xlink:href="#icon-arrow-down"></use>
                                    </svg>
                                </button>
                                <div role="listbox" id="gated-crop-dropdown" tabindex="-1" uk-dropdown="pos: bottom-center; boundary: !.boundary; shift: false; flip: false; mode:click;" class="uk-dropdown uk-animation-fade gated-content__dropdown">
                                    <ul class="uk-nav uk-dropdown-nav gated-content__crop-dropdown">';

                                    foreach ($crops as $crop) {
                                        $default_form .= '<li class="dropdown-li" data-name="' . $crop[1] . '">
                                                            <svg class="icon icon-' . $crop[0] . '">
                                                                <use xlink:href="#icon-' . $crop[0] . '"></use>
                                                            </svg>
                                                            <span>' . $crop[1] . '</span>
                                                        </li>';
                                    }


                $default_form .= '</ul>
                            </div>                                
                        </div>
                        <div class="gated-content__dropdown-wrapper">
                            <button class="uk-button uk-button-default gated-content__dropdown-button" role="combobox" type="button" id="gated-acreage-select" aria-controls="gated-acreage-dropdown" aria-expanded="false" aria-haspopup="true">
                                <div class="gated-content__dropdown-button-placeholder acreage">' . __('Acreage', 'kmag') . '</div>
                                <span class="gated-content__dropdown-button-content acreage"></span>
                                <svg class="icon icon-arrow-down">
                                    <use xlink:href="#icon-arrow-down"></use>
                                </svg>
                            </button>
                             <div role="listbox" id="gated-acreage-dropdown" tabindex="-1" uk-dropdown="pos: bottom-center; boundary: !.boundary; shift: false; flip: false; mode:click;" class="uk-dropdown uk-animation-fade gated-content__dropdown">
                                <ul class="uk-nav uk-dropdown-nav gated-content__acreage-dropdown">
                                    <li class="dropdown-li" data-name="' . __('1-249', 'kmag') . '"><span>' . __('1-249', 'kmag') . '</span></li>
                                    <li class="dropdown-li" data-name="' . __('250-499', 'kmag') . '"><span>' . __('250-499', 'kmag') . '</span></li>
                                    <li class="dropdown-li" data-name="' . __('500-999', 'kmag') . '"><span>' . __('500-999', 'kmag') . '</span></li>
                                    <li class="dropdown-li" data-name="' . __('1000-2499', 'kmag') . '"><span>' . __('1000-2499', 'kmag') . '</span></li>
                                    <li class="dropdown-li" data-name="' . __('2500+', 'kmag') . '"><span>' . __('2500+', 'kmag') . '</span></li>
                                </ul>
                            </div>                           
                        </div>
                        <div class="gated-content__checkbox-wrapper">
                            <input class="gated-content__checkbox" id="optin-checkbox" type="checkbox" name="optin">
                            <label for="optin-checkbox">' . __('By filling in this form and clicking Subscribe for Access, you acknowledge our', 'kmag') . ' <a href="https://mosaicco.com/privacy-policy">' . __('privacy policy') . '</a>.</label>
                        </div>
                        <div class="gated-content__checkbox-wrapper sms-checkbox">
                            <input class="gated-content__checkbox" id="sms-checkbox" type="checkbox" name="sms">
                            <label for="sms-checkbox">' . __('By checking this box, I agree to receive Crop Nutrition and Soil Health tools and resources from The Mosaic Company via Mosaic Agronomic Alerts text messages. Message frequency varies. Text HELP to SOILS (76457) for help. Test STOP to SOILS (76457) to end. Msg&Data Rates May Apply. By opting in, I authorize The Mosaic Company to deliver SMS messages using an automatic telephone dialing system and I understand that I am not required to opt in as a condition of purchasing any property, goods, or services. By leaving this box unchecked, you will not be opted in for SMS messages at this time. ', 'kmag') . '<a href="/terms-and-conditions/">' . __('Click to read Terms And Conditions') . '</a>, <a href="https://mosaicco.com/privacy-policy">' . __('Privacy Policy') . '</a>.</label>
                        </div>
                        <div class="gated-content__full-input-wrapper mobile-phone-input-wrapper" data-wrapper-visible="false">
                            <input type="text" pattern="^[0-9]{3}-?[0-9]{3}-?[0-9]{4}$" placeholder="' . __('Mobile Phone', 'kmag')  . ' (xxx-xxx-xxxx)" name="mobile-phone">
                        </div>
                        <div class="gated-content__submit-wrapper">
                            <button type="submit" class="btn gated-content__submit-button">' . __('Subscribe for Access', 'kmag') . '</button>
                        </div>
                    </div>
                </form>
                </div>
                 <div id="success-message">
                     <div id="success-message__close">x</div>
                     <div id="success-message__message"><h2>' . __('Thank You for Registering', 'kmag') . '</h2></div>
                 </div>
            </div>';

$gda_test_form = '<div class="gated-content__form-wrapper">
                 <div id="gated-form">
                     <div class="gated-content__validation-wrapper">
                         <div class="gated-content__validation-message hide unshow">' . __('Please Complete All Fields.', 'kmag') . '</div>
                     </div>
                     <form id="gate-form">
                         <div class="uk-grid-collapse uk-child-width-1-2@m gated-content__form-row" uk-grid>
                             <div class="gated-content__input-wrapper">
                                 <input type="text" placeholder="' . __('First Name', 'kmag') . '" name="first-name">
                             </div>
                             <div class="gated-content__input-wrapper">
                                 <input type="text" placeholder="' . __('Last Name', 'kmag') . '" name="last-name">
                             </div>
                         </div>
                         <div class="uk-grid-collapse uk-child-width-1-2@m gated-content__form-row" uk-grid>
                             <div class="gated-content__input-wrapper">
                                 <input type="text" placeholder="' . __('Company Name', 'kmag') . '" name="company-name">
                             </div>
                             <div class="gated-content__input-wrapper">
                                 <input type="text" pattern="^[0-9]{3}-?[0-9]{3}-?[0-9]{4}$" required placeholder="' . __('Work Phone', 'kmag')  . ' (xxx-xxx-xxxx)" name="phone">
                             </div>
                         </div>
                         <div class="uk-grid-collapse gated-content__form-row" uk-grid>
                             <div class="gated-content__full-input-wrapper">
                                 <input type="text" pattern="^(.*)@(.*)\.(.*)$" required placeholder="' . __('Work Email', 'kmag') . ' (xx@xx.xx)" name="email">
                             </div>
                             <div class="gated-content__input-wrapper">
                                 <input type="text" placeholder="' . __('Role', 'kmag') . '" name="role">
                             </div>
                             <div class="gated-content__checkbox-wrapper">
                                 <input id="optin-checkbox" type="checkbox" name="optin">
                                 <label for="optin-checkbox">' . __('By filling in this form and clicking Register, you acknowledge our', 'kmag') . ' <a href="https://mosaicco.com/privacy-policy">' . __('privacy policy') . '</a>.</label>
                             </div>
                             <div class="gated-content__submit-wrapper">
                                 <button type="submit" class="btn gated-content__submit-button">' . __('Subscribe for Access', 'kmag') . '</button>
                             </div>
                         </div>
                     </form>
                 </div>
                 <div id="success-message">
                     <div id="success-message__close">x</div>
                     <div id="success-message__message"><h2>' . __('Thank You for Registering', 'kmag') . '</h2></div>
                 </div>
             </div>';

if ($gda_test_gate) {
    $gate_form = $gda_test_form;
    $duration = ACF::getField('gda-gate-duration', $options);
    $gate = 'gda-gate';
} else {
    $gate_form = $default_form;
    $duration = ACF::getField('gate-duration', $options);
    $gate = 'default-gate';
}

wp_localize_script('cn-theme', 'gatedContent', [
    'delay' => $delay,
    'duration' => $duration,
    'gate' => $gate
]);

echo do_shortcode('[mc_modal trigger_type="event" event_name="gated-content-event" modal_height="sm"]<div class="gated-content__form"><h3>' . esc_html($headline) . '</h3>' . $gate_form . '</div>[/mc_modal]'); 
?>

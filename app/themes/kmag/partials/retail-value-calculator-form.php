<?php

use CN\App\SalesForce\Api;

/**
 * Retail Value Form partial template
 */

function translate_form_label($label)
{
    return __($label, 'kmag');
}

// support 555-555-5555 or 555.555.5555
$rvc_phone_pattern = '([0-9]{3}-[0-9]{3}-[0-9]{4})|([0-9]{3}.[0-9]{3}.[0-9]{4})';
$rvc_api_url = 'https://webto.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8';
$form_has_posted = $_SERVER['REQUEST_METHOD'] === 'POST';
$oid = '00D30000000o0sW';
// Form briefly submits to this page, the data is sent to salesforce, and then javascript redirects to the success page designated by the shortcode
if ($form_has_posted)
{
    $form_data = $_POST;

    $headers = array(
        'Content-Type' => 'application/x-www-form-urlencoded',
        'Referer' => get_permalink()
    );

    $response = null;

    try {
        $api_response = wp_remote_post($rvc_api_url, array(
            'headers' => $headers,
            'body' => $form_data
        ));

        if (is_wp_error($api_response)) {
            throw new Exception(__('WP Error.', 'kmag'), 401);
        } else {
            $response = json_decode($api_response["body"]);

            wp_localize_script('cn-theme', 'rvc_response', array(
                'form_submission_result' => 'submitted' 
            ));
        }
    } catch (Exception $e) {
        printf(
            __('Request failed: %1$s. Code: %2$s.', 'kmag'),
            $e->getMessage(),
            $e->getCode()
        );
    }
}
?>

<?php if(!$form_has_posted ) { ?>
<div class="retail-value-calculator-form">
    <form action="" method="POST" id="rvc_form" class="retail-value-calculator-form__form">
        <fieldset>
            <input type="hidden" name="oid" value="<?php echo esc_attr($oid); ?>" />
            <input type="hidden" name="lead_source" value="Retail Value Calculator Request Form" />
            <input type="hidden" name="country_code" :value="countryCode" />
            <label>
                <span>
                    <?php echo translate_form_label('Company Name'); ?><sup>*</sup>
                </span>
                <input type="text" name="company_name" id="company_name" required/>
            </label>
            <label>
                <span>
                    <?php echo translate_form_label('Title'); ?><sup>*</sup>
                </span>
                <input type="text" name="title" id="title" required/>
            </label>
            <div class="side-by-side">
                <label>
                    <span>
                        <?php echo translate_form_label('First Name'); ?><sup>*</sup>
                    </span>
                    <input type="text" name="first_name" id="first_name" required/>
                </label>
                <label>
                    <span>
                        <?php echo translate_form_label('Last Name'); ?><sup>*</sup>
                    </span>
                    <input type="text" name="last_name" id="last_name" required/>
                </label>
            </div>
            <label>
                <span>
                    <?php echo translate_form_label('Phone'); ?>
                </span>
                <input type="tel" name="phone" id="phone" placeholder="555-555-5555" pattern="<?php echo $rvc_phone_pattern ?>"/>
            </label>
            <label>
                <span>
                    <?php echo translate_form_label('Company Email'); ?><sup>*</sup>
                </span>
                <input type="email" name="email" id="email" required/>
            </label>
        </fieldset>
        <fieldset>
            <label>
                <span>
                    <?php echo translate_form_label('Product'); ?><sup>*</sup>
                </span>
                <div class="rvc-select-container">
                    <select name="Product_Sold__c" id="product" required>
                        <option selected="selected" value="">
                            <?php echo translate_form_label('What product do you sell?'); ?>
                        </option>
                            
                        <option value="MicroEssentials SZ">
                            <?php echo translate_form_label('MicroEssentials SZ'); ?>
                        </option>
                            
                        <option value="MicroEssentials S15">
                            <?php echo translate_form_label('MicroEssentials S15'); ?>
                        </option>
                            
                        <option value="MicroEssentials S10">
                            <?php echo translate_form_label('MicroEssentials S10'); ?>
                        </option>
                    </select>

                    <svg class="icon icon-select-dropdown" aria-hidden="true">
                        <use xlink:href="#icon-select-dropdown"></use>
                    </svg>
                </div>
            </label>
        </fieldset>
        <fieldset class="final-field-set">
            <label>
                <span>
                    <?php echo translate_form_label('Company Address'); ?><sup>*</sup>
                </span>
                <input type="text" name="address" id="address" required/>
            </label>
            <label>
                <span>
                    <?php echo translate_form_label('Address 2'); ?>
                </span>
                <input type="text" name="address2" id="address2"/>
            </label>
            <label>
                <span>
                    <?php echo translate_form_label('City'); ?><sup>*</sup>
                </span>
                <input type="text" name="city" id="city" required/>
            </label>
            <div class="side-by-side">
                <label>
                    <span>
                        <?php echo translate_form_label('State/Province') ?><sup>*</sup>
                    </span>
                    <div class="rvc-select-container">
                        <select name="state" id="state" required>
                            <option selected="selected" value="">
                                <?php _e('State', 'kmag') ?>
                            </option>
                            <option value="AA">
                                <?php _e('Armed Forces Americas', 'kmag') ?>
                            </option>
                            <option value="AE">
                                <?php _e('Armed Forces Europe', 'kmag') ?>
                            </option>
                            <option value="AK">
                                <?php _e('Alaska', 'kmag') ?>
                            </option>
                            <option value="AL">
                                <?php _e('Alabama', 'kmag') ?>
                            </option>
                            <option value="AP">
                                <?php _e('Armed Forces Pacific', 'kmag') ?>
                            </option>
                            <option value="AR">
                                <?php _e('Arkansas', 'kmag') ?>
                            </option>
                            <option value="AS">
                                <?php _e('American Samoa', 'kmag') ?>
                            </option>
                            <option value="AZ">
                                <?php _e('Arizona', 'kmag') ?>
                            </option>
                            <option value="CA">
                                <?php _e('California', 'kmag') ?>
                            </option>
                            <option value="CO">
                                <?php _e('Colorado', 'kmag') ?>
                            </option>
                            <option value="CT">
                                <?php _e('Connecticut', 'kmag') ?>
                            </option>
                            <option value="DC">
                                <?php _e('District of Columbia', 'kmag') ?>
                            </option>
                            <option value="DE">
                                <?php _e('Delaware', 'kmag') ?>
                            </option>
                            <option value="FL">
                                <?php _e('Florida', 'kmag') ?>
                            </option>
                            <option value="FM">
                                <?php _e('Federated Micronesia', 'kmag') ?>
                            </option>
                            <option value="GA">
                                <?php _e('Georgia', 'kmag') ?>
                            </option>
                            <option value="GU">
                                <?php _e('Guam', 'kmag') ?>
                            </option>
                            <option value="HI">
                                <?php _e('Hawaii', 'kmag') ?>
                            </option>
                            <option value="IA">
                                <?php _e('Iowa', 'kmag') ?>
                            </option>
                            <option value="ID">
                                <?php _e('Idaho', 'kmag') ?>
                            </option>
                            <option value="IL">
                                <?php _e('Illinois', 'kmag') ?>
                            </option>
                            <option value="IN">
                                <?php _e('Indiana', 'kmag') ?>
                            </option>
                            <option value="KS">
                                <?php _e('Kansas', 'kmag') ?>
                            </option>
                            <option value="KY">
                                <?php _e('Kentucky', 'kmag') ?>
                            </option>
                            <option value="LA">
                                <?php _e('Louisiana', 'kmag') ?>
                            </option>
                            <option value="MA">
                                <?php _e('Massachusetts', 'kmag') ?>
                            </option>
                            <option value="MD">
                                <?php _e('Maryland', 'kmag') ?>
                            </option>
                            <option value="ME">
                                <?php _e('Maine', 'kmag') ?>
                            </option>
                            <option value="MH">
                                <?php _e('Marshall Islands', 'kmag') ?>
                            </option>
                            <option value="MI">
                                <?php _e('Michigan', 'kmag') ?>
                            </option>
                            <option value="MN">
                                <?php _e('Minnesota', 'kmag') ?>
                            </option>
                            <option value="MO">
                                <?php _e('Missouri', 'kmag') ?>
                            </option>
                            <option value="MP">
                                <?php _e('Northern Mariana Islands', 'kmag') ?>
                            </option>
                            <option value="MS">
                                <?php _e('Mississippi', 'kmag') ?>
                            </option>
                            <option value="MT">
                                <?php _e('Montana', 'kmag') ?>
                            </option>
                            <option value="NC">
                                <?php _e('North Carolina', 'kmag') ?>
                            </option>
                            <option value="ND">
                                <?php _e('North Dakota', 'kmag') ?>
                            </option>
                            <option value="NE">
                                <?php _e('Nebraska', 'kmag') ?>
                            </option>
                            <option value="NH">
                                <?php _e('New Hampshire', 'kmag') ?>
                            </option>
                            <option value="NJ">
                                <?php _e('New Jersey', 'kmag') ?>
                            </option>
                            <option value="NM">
                                <?php _e('New Mexico', 'kmag') ?>
                            </option>
                            <option value="NV">
                                <?php _e('Nevada', 'kmag') ?>
                            </option>
                            <option value="NY">
                                <?php _e('New York', 'kmag') ?>
                            </option>
                            <option value="OH">
                                <?php _e('Ohio', 'kmag') ?>
                            </option>
                            <option value="OK">
                                <?php _e('Oklahoma', 'kmag') ?>
                            </option>
                            <option value="OR">
                                <?php _e('Oregon', 'kmag') ?>
                            </option>
                            <option value="PA">
                                <?php _e('Pennsylvania', 'kmag') ?>
                            </option>
                            <option value="PR">
                                <?php _e('Puerto Rico', 'kmag') ?>
                            </option>
                            <option value="PW">
                                <?php _e('Palau', 'kmag') ?>
                            </option>
                            <option value="RI">
                                <?php _e('Rhode Island', 'kmag') ?>
                            </option>
                            <option value="SC">
                                <?php _e('South Carolina', 'kmag') ?>
                            </option>
                            <option value="SD">
                                <?php _e('South Dakota', 'kmag') ?>
                            </option>
                            <option value="TN">
                                <?php _e('Tennessee', 'kmag') ?>
                            </option>
                            <option value="TX">
                                <?php _e('Texas', 'kmag') ?>
                            </option>
                            <option value="UM">
                                <?php _e('United States Minor Outlying Islands', 'kmag') ?>
                            </option>
                            <option value="UT">
                                <?php _e('Utah', 'kmag') ?>
                            </option>
                            <option value="VA">
                                <?php _e('Virginia', 'kmag') ?>
                            </option>
                            <option value="VI">
                                <?php _e('US Virgin Islands', 'kmag') ?>
                            </option>
                            <option value="VT">
                                <?php _e('Vermont', 'kmag') ?>
                            </option>
                            <option value="WA">
                                <?php _e('Washington', 'kmag') ?>
                            </option>
                            <option value="WI">
                                <?php _e('Wisconsin', 'kmag') ?>
                            </option>
                            <option value="WV">
                                <?php _e('West Virginia', 'kmag') ?>
                            </option>
                            <option value="WY">
                                <?php _e('Wyoming', 'kmag') ?>
                            </option>
                            <option value="AB">
                                <?php _e('Alberta', 'kmag') ?>
                            </option>
                            <option value="BC">
                                <?php _e('British Columbia', 'kmag') ?>
                            </option>
                            <option value="MB">
                                <?php _e('Manitoba', 'kmag') ?>
                            </option>
                            <option value="NB">
                                <?php _e('New Brunswick', 'kmag') ?>
                            </option>
                            <option value="NL">
                                <?php _e('Newfoundland and Labrador', 'kmag') ?>
                            </option>
                            <option value="NS">
                                <?php _e('Nova Scotia', 'kmag') ?>
                            </option>
                            <option value="NT">
                                <?php _e('Northwest Territories', 'kmag') ?>
                            </option>
                            <option value="NU">
                                <?php _e('Nunavut', 'kmag') ?>
                            </option>
                            <option value="ON">
                                <?php _e('Ontario', 'kmag') ?>
                            </option>
                            <option value="PE">
                                <?php _e('Prince Edward Island', 'kmag') ?>
                            </option>
                            <option value="QC">
                                <?php _e('Quebec', 'kmag') ?>
                            </option>
                            <option value="SK">
                                <?php _e('Saskatchewan', 'kmag') ?>
                            </option>
                            <option value="YT">
                                <?php _e('Yukon Territories', 'kmag') ?>
                            </option>      
                        </select>
                        <svg class="icon icon-select-dropdown" aria-hidden="true">
                            <use xlink:href="#icon-select-dropdown"></use>
                        </svg>
                    </div>
                </label>
                <label>
                    <span>
                        <?php echo translate_form_label('Postal Code') ?><sup>*</sup>
                    </span>
                    <input type="text" name="postal_code" id="postal_code" required />
                </label>
            </div>
        </fieldset>
        <div class="retail-value-calculator-form__footer">
            <label class="retail-value-calculator-form__agree-checkbox">
                <input type="checkbox" required/>
                <div class="checkbox-label-container">
                    <span>
                        <?php echo translate_form_label('By checking the box you accept the Terms and Conditions and the Privacy Policy') ?>
                    </span>
                    <span>
                        <?php echo translate_form_label('View '); ?> <a href="/terms-and-conditions/"> <?php echo translate_form_label('Terms and Conditions'); ?> </a> <?php echo translate_form_label(' and the '); ?> <a href="https://mosaicco.com/privacy-policy"> <?php echo translate_form_label('Privacy Policy'); ?> </a>
                    </span>
                </div>
            </label>
            <button class="btn btn--tertiary" type="submit"> <?php _e('Submit Request', 'kmag'); ?> </button>
        </div>
    </form>
</div>
<?php } else { ?>
<div>
    <h1> <?php _e('Processing form', 'kmag'); ?> </h1>
    <p> <?php _e('Your form is being processed and you will be redirected to another page.', 'kmag') ?></p>
</div>

<?php }

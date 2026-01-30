/* eslint no-undef: 0 */

import {getCookie, setCookie, setExpiringCookie} from './manageCookies';

const BYPASS_PARAM_NAME = 'gbp';

const initGatedContent = () => {
    const gatedContentTemplate = document.querySelector('.gated-content__gated-asset');
    const bypassEnabled = checkForGateBypass();
    
    // return early if we're not using the gated content template or the user is bypassing the gate with url params
    if (!gatedContentTemplate || bypassEnabled) {
        return false;
    } 
    
    const gate = window.gatedContent.gate;
    const hasPassedGate = gate === 'default-gate' ? getCookie('has_passed_gate') : getCookie('gda_has_passed_gate');
    console.log(gatedContentTemplate, bypassEnabled, hasPassedGate);

    // case when gated content exists, but the user already filled out the gate once
    if (gatedContentTemplate && hasPassedGate) {
        const subscriberId = getCookie('subscriber_key')
        setUrlParameters(subscriberId);
        return;
    }

    initializeGatedContent();
};

const checkForGateBypass = () => {
    return window.location.search.includes(BYPASS_PARAM_NAME);
}

const setPassedGateCookie = (gate) => {
    let gateCookie = gate === 'default-gate' ? 'has_passed_gate' : 'gda_has_passed_gate';

    let expires = new Date();
    const days = window.gatedContent.duration || 1;
    expires.setTime(expires.getTime() + (days*24*60*60*1000));
    setExpiringCookie(gateCookie, true, expires);
};

const setSubscriberKeyCookie = (data) => {
    const subscriberKey = JSON.parse(data.data).LeadIdOrcontactId;
    if(subscriberKey) {
        setCookie('subscriber_key', subscriberKey);
    }
};

const standardizePhoneNumber = phoneNumber => {
    if (!phoneNumber) {
        return phoneNumber;
    }

    let digitsOnly = "";
    // loop through each character and verify that it's a digit
    for (let i = 0; i < phoneNumber.length; i++) {
        if (!isNaN(parseInt(phoneNumber[i]))) {
            digitsOnly += phoneNumber[i];
        }
    }

    // format number into xxx-xxx-xxxx
    return digitsOnly.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
}

const serializeGateFormValues = () => {
    const shortlink = document.querySelector('link[rel="shortlink"]')?.href;
    const pageId = shortlink?.match(/\?p=(\d+)/)?.[1];

    const cropSelect = document.querySelectorAll('.gated-content__crop-dropdown li.selected');
    let crops = [];
    
    cropSelect.forEach((item) => {
        crops.push(item.dataset.name);
    });

    let occupation = document.querySelector('.gated-content__occupation-dropdown li.selected');
    occupation = occupation ? occupation.dataset.name : null;

    let acreage = document.querySelector('.gated-content__acreage-dropdown li.selected');
    acreage = acreage ? acreage.dataset.name : null

    const optin = document.getElementsByName('optin')[0].checked ? 1 : 0;
    const smsOptin = document.getElementsByName('sms')[0].checked ? 1 : 0;

    const stringFields = {
        firstName: {
            value: document.getElementsByName('first-name')[0].value,
            required: true
        },
        lastName: {
            value: document.getElementsByName('last-name')[0].value,
            required: true
        },
        phoneNumber:  {
            value: standardizePhoneNumber(document.getElementsByName('phone')[0].value),
            required: true
        },
        alternateNumber: {
            value: standardizePhoneNumber(document.getElementsByName('mobile-phone')[0].value),
            required: smsOptin 
        },
        postalCode: {
            value: document.getElementsByName('postal-code')[0].value,
            required: true 
        },
        email: {
            value: document.getElementsByName('email')[0].value,
            required: true
        },
        occupation: {
            value: occupation,
            required: true,
        },
        acreage: {
            value: acreage,
            required: true
        }
    }

    const requriedFieldsAreFilled = Object.entries(stringFields).every(([key, entry]) => {
        const { value, required } = entry;

        if (required) {
            return value || value === 0;
        } 

        // if it's not required, the field is valid
        return true;
    });

    if (requriedFieldsAreFilled && crops.length > 0 && optin) {
        const reqBody = {
            firstName: stringFields.firstName.value,
            lastName: stringFields.lastName.value,
            phone: stringFields.phoneNumber.value,
            mobilePhone: stringFields.alternateNumber.value,
            postalCode: stringFields.postalCode.value,
            email: stringFields.email.value,
            occupation: stringFields.occupation.value,
            crops: crops,
            acreage: stringFields.acreage.value,
            smsOptin: smsOptin,
            pageId
        }
        console.log('req body', reqBody);
        return reqBody;
    }

    return null;
};

const serializeGDAGateFormValues = () => {
    const stringFields = [
        document.getElementsByName('first-name')[0].value,
        document.getElementsByName('last-name')[0].value,
        document.getElementsByName('company-name')[0].value,
        standardizePhoneNumber(document.getElementsByName('phone')[0].value),
        document.getElementsByName('email')[0].value,
        document.getElementsByName('role')[0].value
    ];

    const isNotBlank = (stringField) => stringField.trim();
    const haveStringFields = stringFields.every(isNotBlank);

    const optin = document.getElementsByName('optin')[0].checked ? 1 : 0;

    if (haveStringFields && optin) {
        return {
            firstName: stringFields[0],
            lastName: stringFields[1],
            companyName: stringFields[2],
            phone: stringFields[3],
            email: stringFields[4],
            role: stringFields[5]
        };
    }

    return null;
};

const submitGateForm = (gate) => {
    const location = window.location;
    const protocol  = location.protocol;
    const hostname  = location.hostname;
    const restBase  = protocol + '//' + hostname + '/wp-json/gated_content/v1';
    const submitButton = document.querySelector('.gated-content__submit-button');
    let requiredFields = null;
    
    if (gate === 'default-gate') {
        requiredFields = serializeGateFormValues(); 
    } else {
        requiredFields = serializeGDAGateFormValues();  
    }

    if (requiredFields) {
        const data = {
          'action': gate,
          'form': requiredFields
        };

        const options = {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': gated_content_api.apiNonce
          },
          credentials: 'same-origin',
          body: JSON.stringify(data)
        };
        submitButton.disabled = true;
        const originalSubmitText = submitButton.innerHTML;
        submitButton.innerHTML = 'Submitting...';
        fetch(restBase + '/send', options)
            .then(response => {
                const res = response.json()
                console.log(res);
                return res;
            })
            .then(data => {
                console.log('Gate submission successful - subscriber ID:', data);
                if ('data' in data) {
                    const parsedData = JSON.parse(data.data);
                    const { LeadIdOrcontactId } = parsedData;
                    setUrlParameters(LeadIdOrcontactId);

                }
                setSubscriberKeyCookie(data);
                setPassedGateCookie(gate);
                submitButton.innerHTML = originalSubmitText;
                submitButton.disabled = false;
                displaySuccessWindow();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    } else {
        const message = document.querySelector('.gated-content__validation-message');
        message.classList.remove('hide');
        message.classList.remove('unshow');
    }
};

const setUrlParameters = subscriberId => {
    const campaignId = document.querySelector('[data-campaign-id]')?.getAttribute('data-campaign-id');
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set('utm_campaign', campaignId);
    urlParams.set('subscriber', subscriberId);
    const subscriberIdSet = new Event('gate-successful');
    window.dispatchEvent(subscriberIdSet);
    const newUrl = window.location.origin + window.location.pathname + '?' + urlParams.toString();
    window.history.pushState({}, '', newUrl);
}

const displaySuccessWindow = () => {
    const mc_modal_close = new Event('mc-modal-close');
    const form = document.getElementById('gated-form');
    const formTitle = document.getElementsByClassName('gated-content__form')[0].querySelector('h3');
    const successMessage = document.getElementById("success-message");
    const outerModal = document.getElementsByClassName('mc-modal__foreground')[0];
    const innerModal = document.getElementsByClassName('gated-content__form')[0];

    formTitle.style.display = 'none';
    form.style.display = 'none';
    successMessage.style.display = 'block';
    outerModal.style.borderRadius = "15px"
    innerModal.style.padding = "0px"

    document.getElementById('success-message__close').onclick = function(){
        window.dispatchEvent(mc_modal_close);
    };
}

const changeCropPlaceholder = (action, text) => {
    const btnPlaceholder = document.querySelector('.gated-content__dropdown-button-placeholder.crops');
    const btnContent = document.querySelector('.gated-content__dropdown-button-content.crops');
    const current = btnContent.textContent.split(',  ');
    const title = 'Crops Grown';

    if (action === 'add') {
        btnPlaceholder.classList.add('hide');
        btnContent.classList.add('hide');
        if (btnContent.textContent === '') {
            setTimeout(() => {
                btnContent.textContent = text;
                btnContent.classList.remove('hide');
            },200);
        } else {
            current.push(text);
            btnContent.textContent = current.join(',  ');
            btnContent.classList.remove('hide');
        }
    } else {
        const trimmed = current.filter((el, i) => {
            return el !== text;
        });
        btnContent.classList.add('hide');
        if (trimmed.length === 0) {
            btnContent.textContent = '';
            setTimeout(() => {
                btnPlaceholder.classList.remove('hide');
            },200);
        } else {
            setTimeout(() => {
                btnContent.textContent = trimmed.join(',  ');
                btnContent.classList.remove('hide');
            },200);
        }
    }
};

const changePlaceholder = (placeholder, action, text) => {
    const btnPlaceholder = document.querySelector(`.gated-content__dropdown-button-placeholder.${placeholder}`);
    const btnContent = document.querySelector(`.gated-content__dropdown-button-content.${placeholder}`);
    if (action === 'add') {
        btnPlaceholder.classList.add('hide');
        btnContent.classList.add('hide');
        setTimeout(() => {
            btnContent.textContent = text;
            btnContent.classList.remove('hide');
        }, 200);
    } else {
        btnContent.classList.add('hide');
        const capitalized = placeholder.charAt(0).toUpperCase() + placeholder.slice(1);
        btnPlaceholder.textContent = capitalized;
        setTimeout(() => {
            btnPlaceholder.classList.remove('hide');
        }, 200);
        btnContent.textContent = '';
    }
};

const handleCropClick = (e) => {
    const cropItem = e.currentTarget;
    const text = cropItem.dataset.name;

    if (!cropItem.classList.contains('selected')) {
        changeCropPlaceholder('add', text);
        cropItem.classList.add('selected');
    } else {
        cropItem.classList.remove('selected');
        changeCropPlaceholder('remove', text);
    }
};

const handleDropdownClick = (element, dropdown) => {
    const occupationSelected = document.querySelector('.gated-content__occupation-dropdown li.selected');
    const occupationBtn = document.getElementById('gated-occupation-select');
    const acreageSelected = document.querySelector('.gated-content__acreage-dropdown li.selected');
    const acreageBtn = document.getElementById('gated-acreage-select');

    let dropdownElement = {};
    let dropdownBtn = {};
    
    if (dropdown === 'occupation') {
        dropdownElement = occupationSelected;
        dropdownBtn = occupationBtn;
    } else {
        dropdownElement = acreageSelected;
        dropdownBtn = acreageBtn;
    }

    if (!element.classList.contains('selected')) {
        if (dropdownElement) {
            dropdownElement.classList.remove('selected');
        }
        const text = element.dataset.name;
        element.classList.add('selected');
        changePlaceholder(dropdown, 'add', text);
    } else {
        element.classList.remove('selected');
        changePlaceholder(dropdown, 'remove');
    }

    dropdownBtn.click();
};

const toggleMobilePhoneField = () => {
    const mobilePhoneInputField = document.querySelector('.mobile-phone-input-wrapper');
    const isVisible = mobilePhoneInputField.dataset.wrapperVisible === 'true';

    if (isVisible) {
        mobilePhoneInputField.dataset.wrapperVisible = 'false';
    } else {
        mobilePhoneInputField.dataset.wrapperVisible = 'true';
    }
}

const initializeGatedContent = () => {
    const gateForm = document.getElementById('gate-form');
    const gate = window.gatedContent.gate;
    const delay = window.gatedContent.delay + '000';
    const openModal = new Event('gated-content-event');
    const hasPassedGate = gate === 'default-gate' ? getCookie('has_passed_gate') : getCookie('gda_has_passed_gate');
    const occupationDropdown = document.querySelectorAll('.gated-content__occupation-dropdown li');
    const cropDropdown = document.querySelectorAll('.gated-content__crop-dropdown li');
    const acreageDropdown = document.querySelectorAll('.gated-content__acreage-dropdown li');

    if (!hasPassedGate) {
        setTimeout(() => {
            window.dispatchEvent(openModal);
        }, (delay * 1));

        gateForm.addEventListener('submit', (e) => {
            e.preventDefault();
            submitGateForm(gate);
        });

        if (gate === 'default-gate') {
            const smsCheckbox = document.getElementById('sms-checkbox');

            if (smsCheckbox) {
                smsCheckbox.addEventListener('change', toggleMobilePhoneField);
            }

            cropDropdown.forEach((crop) => {
                crop.addEventListener('click', handleCropClick);
            });
        
            occupationDropdown.forEach((item) => {
                item.addEventListener('click', (e) => {
                    const element = e.currentTarget;
                    handleDropdownClick(element, 'occupation'); 
                });
            });
        
            acreageDropdown.forEach((item) => {
                item.addEventListener('click', (e) => {
                    const element = e.currentTarget;
                    handleDropdownClick(element, 'acreage');
                });
            });
        }
    }
};

export default initGatedContent;

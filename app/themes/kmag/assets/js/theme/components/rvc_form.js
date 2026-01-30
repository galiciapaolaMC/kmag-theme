import { COUNTRY_CODES } from "../../constants";

const initScript = () => {
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('rvc_form');
        
        if (form) {
            const stateEls = document.getElementsByName('state')
            let stateEl = null;
            if (stateEls.length > 0) {
                stateEl = stateEls[0];
            }
            const countryEls = document.getElementsByName('country_code');
            let countryEl = null;
            if (countryEls.length > 0) {
                countryEl = countryEls[0];
            }

            form.addEventListener('submit', evt => {
                evt.preventDefault();
                let country = '';
                const stateVal = stateEl?.value;
                // set country code hidden input based on state code
                if (stateVal) {
                    country = COUNTRY_CODES.find(c => c?.regions?.some(s => s.value === stateVal));
                    countryEl.value = country?.code ? country.code : '';
                }

                form.submit();
            })
        }

        if (!('rvc_data' in window) || !('rvc_response' in window)) {
            return;
        }

        const { confirmation_page_slug } = window.rvc_data;
        const { form_submission_result } = window.rvc_response;

        // if the form has been submitted and the page is reloading redirect to the success page designated by the shortcode
        if (confirmation_page_slug !== null && form_submission_result === 'submitted') {
            const currentUrl = window.location.href;
            const urlObject = new URL(currentUrl);

            const domain = urlObject.hostname;
            const protocol = urlObject.protocol;
            window.location.href = `${protocol}//${domain}/${confirmation_page_slug}`;
        }
    });
}

export default initScript;
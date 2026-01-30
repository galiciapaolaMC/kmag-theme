import { setCookie } from './manageCookies';

const EVENT_ORIGIN = 'https://explore.cropnutrition.com';
const EVENT_NAME = 'pass_form_data';

const initPathFactory = () => {
  const getPostMessage = e => {
    if (e.origin === EVENT_ORIGIN) {
      console.log('post message event', e);
      const { data } = e;
      const { SubscriberKey: subscriberKey, event_name: eventName, utm_campaign: campaign } = data;

      if (eventName === EVENT_NAME && subscriberKey !== null) {
        setCookie('subscriber_key', subscriberKey);
        setCookie('campaign_id', campaign);
        const customEvent = new CustomEvent("postMessageReceived", {
          bubbles: true,
          cancelable: true,
          detail: {
            subscriberKey,
            campaign
          }
        });
        window.dispatchEvent(customEvent);
      }
    }
  }

  window.addEventListener('message', getPostMessage);
}

export default initPathFactory;
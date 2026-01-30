
/* eslint no-undef: 0 */

import { getCookie, setCookie } from "./manageCookies";

const generateLeadScore = (campaignId, leadId) => {
  const { protocol, hostname } = window.location;
  const restBase = `${protocol}//${hostname}/wp-json/score_page/v1`;

  const shortlink = document.querySelector('link[rel="shortlink"]')?.href;
  const page_id = shortlink?.match(/\?p=(\d+)/)?.[1];
  console.log(page_id, checkCacheForScoreName(page_id));
  if (!page_id || checkCacheForScoreName(page_id)) {
    return;
  }

  const payload = {
    Campaign__c: campaignId,
    Lead__c: leadId,
    page_id: page_id
  };
  console.log('before send payload', payload);
  const options = {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-WP-Nonce': gated_content_api.apiNonce
    },
    credentials: 'same-origin',
    body: JSON.stringify(payload)
  };

  fetch(`${restBase}/send`, options)
      .then(response => response.json())
      .then(data => {
        console.log('page-load score created:');
        console.log(data);
        setScoreCache(page_id);
      })
      .catch(error => {
        console.error('Error:', error);
      });
}

// handler for when scored page loads
const handleScoredPageLoad = e => {
  console.log('post message received handler', e);
  
  const urlParams = new URLSearchParams(window.location.search);

  const campaignId = urlParams.get('utm_campaign');
  const leadId = urlParams.get('subscriber');
  
  console.log('info from event', {
    campaignId,
    leadId
  });
  if (campaignId && leadId) {
    generateLeadScore(campaignId, leadId);
  }
}

const handlePageLevelScoredAction = e => {  
  const urlParams = new URLSearchParams(window.location.search);

  const campaignId = urlParams.get('utm_campaign');
  const leadId = urlParams.get('subscriber');
  console.log('handle page level', leadId);

  console.log('info from event', {
    campaignId,
    leadId
  });
  if (campaignId && leadId) {
    generateLeadScore(campaignId, leadId);
  }
}

const checkCacheForScoreName = scoreName => {

  if (!scoreName) {
    return false;
  }

  const cacheString = getCookie('score-cache');
  console.log('cache-string', cacheString);
  if (cacheString) {
    const cache = JSON.parse(decodeURIComponent(cacheString));
    return cache.includes(scoreName);
  }
  
  return false;
}

const setScoreCache = scoreName => {
  const cacheString = getCookie('score-cache');
  let cache = [];
  if (cacheString) {
    cache = JSON.parse(decodeURIComponent(cacheString));
  }
  if (scoreName && !cache.includes(scoreName)) {
    cache.push(scoreName); 
  }
  setCookie('score-cache', JSON.stringify(cache));
}

const handleGatePageLoad = e => {
  // give time for the url params to update before calling this.
  setTimeout(() => {
    handleScoredPageLoad(e);
  }, 150);
}

const getPageScoreActionType = () => {
  return document.querySelector('[data-score-action]')?.getAttribute('data-score-action');
}

const initializeEventListeners = () => {
  const scoreType = getPageScoreActionType();
  console.log('score-type', scoreType);

  if (scoreType === 'page-load') {
    window.addEventListener('load', handleScoredPageLoad);
    window.addEventListener('gate-successful', handleGatePageLoad);
  } else if (scoreType === 'video-watch') {
    const videos = document.querySelectorAll('video');
    videos.forEach(video => {
      video.addEventListener('play', handlePageLevelScoredAction);
    });
    window.addEventListener('vimeo-play', handlePageLevelScoredAction);
  } else if (scoreType === 'calculate-click') {
    document.addEventListener('calculate-click', handlePageLevelScoredAction);
  } else if (scoreType === 'dealer-search') {
    const searchButton = document.querySelector('button[type="submit"][data-button="submit"]');
    searchButton.addEventListener('click', handlePageLevelScoredAction);
  }
}

const initScoring = () => {
  initializeEventListeners();
}

export default initScoring;

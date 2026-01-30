import { getSelectedCrop } from "./manageCookies";

const initNutrientDeficiencies = () => {
  const nutrientDeficiencyModules = document.querySelectorAll('.nutrient-deficiencies');

  // loop through each instance of the module and initialize javascript individually
  nutrientDeficiencyModules.forEach(initModuleInstance);
}

const initModuleInstance = moduleInstance => {
  const tabs = moduleInstance.querySelectorAll('.nutrient-deficiencies__tab');
  const panels = moduleInstance.querySelectorAll('.nutrient-deficiencies__tab-panel');
  const cropTextNode = moduleInstance.querySelector('[data-crop-val]');
  
  const resetSelectedState = () => {
    // reset state of other tabs and panels
    tabs.forEach(tab => {
      tab.setAttribute('aria-selected', 'false'); 
    });
    panels.forEach(tabPanel => {
      tabPanel.setAttribute('aria-expanded', 'false');
    });
  }

  const setCropVal = cropVal => {
    // handle multiple words, capitalize first letter and set the html
    const arr = cropVal.split('-');
    let value = '';

    if (arr.length === 1) {
      value = `${cropVal.charAt(0).toUpperCase()}${cropVal.slice(1)}`;
    } else {
      const firstWord = `${arr[0].charAt(0).toUpperCase()}${arr[0].slice(1)}`;
      const secondWord = `${arr[1].charAt(0).toUpperCase()}${arr[1].slice(1)}`;
      value = `${firstWord} ${secondWord}`;
    }
    cropTextNode.innerHTML = value;
  }

  const setStateFromCookie = () => {
    const crop = getSelectedCrop();
    if (crop) {
      const tab = moduleInstance.querySelector(`.nutrient-deficiencies__tab[data-tab-crop="${crop}"]`);

      // only set the state if the crop cookie value matches a tab in our module
      if (tab) {
        const tabPanelId = tab.getAttribute('aria-controls');
        const tabPanel = moduleInstance.querySelector(`#${tabPanelId}`);
        resetSelectedState();
        tab.setAttribute('aria-selected', true);
        tabPanel.setAttribute('aria-expanded', true);
        setCropVal(tab.getAttribute('data-tab-crop'));
      } else {
        resetSelectedState();
        tabs[0].setAttribute('aria-selected', true);
        panels[0].setAttribute('aria-expanded', true);
        setCropVal(tabs[0].getAttribute('data-tab-crop'));

      }
    }
  }

  const onTabClick = e => {
    e.stopPropagation();
    const thisTab = e.target.closest('.nutrient-deficiencies__tab');

    const tabPanelId = thisTab.getAttribute('aria-controls');
    const tabCrop = thisTab.getAttribute('data-tab-crop');
    const associatedTabPanel = document.querySelector(`#${tabPanelId}`);

    resetSelectedState();
    setCropVal(tabCrop);

    // set new tab and associated panel to active
    thisTab.setAttribute('aria-selected', 'true');
    associatedTabPanel.setAttribute('aria-expanded', 'true');
  }

  // set up event listeners/handlers
  window.addEventListener('crop_has_changed', setStateFromCookie)

  tabs.forEach(tab => {
    tab.addEventListener('click', onTabClick)
  })

  // run initial setup functions
  setStateFromCookie();
}

export default initNutrientDeficiencies;
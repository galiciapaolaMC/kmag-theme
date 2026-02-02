const ACTIVE_CLASS = 'uk-active';
const ANIMATION_CLASS = 'uk-animation-fade';
const HIDDEN_CLASS = 'uk-hidden';

const moduleEls = document.querySelectorAll('.agrifact-filter');

const hasItemMatch = (activeItems, cardItems) => {
  let hasMatch = false;

  if (activeItems.length === 0) {
    hasMatch = true;
  } else {
    cardItems.forEach((item) => {
      if (activeItems.includes(item)) {
        hasMatch = true;
        return;
      }
    });
  }

  return hasMatch;
};

const updateButtonStates = (buttonEls, buttonEl) => {
  buttonEls.forEach((el) => {
    el.classList.remove(ACTIVE_CLASS);
  });
  buttonEl.classList.add(ACTIVE_CLASS);
};

export default () => {
  if (!moduleEls) {
    return;
  }

  moduleEls.forEach((moduleEl) => {
    const template = document.getElementById('primary-campaign');
    const filterEl = moduleEl.querySelector('.filter');
    let userSettings = null;

    if (!filterEl) {
      return;
    }
    
    const globalCrop = userSettings ? userSettings[1] : null;

    let moduleIsLoaded = false;
    let activeCrops = [];
    let activeProducts = [];
    const noResultsEl = filterEl.querySelector('.filter__no-results');
    const cardEls = filterEl.querySelectorAll('.filter__content > div');

    cardEls.forEach((cardEl) => {
      cardEl.classList.add(HIDDEN_CLASS);
    });

    // Filters cards based on single selected crop and optional multi-selected products
    const filterCards = () => {
      const visibleCards = [];

      cardEls.forEach((cardEl) => {
        const cardCrops = cardEl.dataset.crops?.split(',');
        const hasCropMatch = hasItemMatch(activeCrops, cardCrops);

        const cardProducts = cardEl.dataset.products?.split(',');
        const hasProductMatch = hasItemMatch(activeProducts, cardProducts);

        if (hasCropMatch && hasProductMatch) {
          cardEl.classList.remove(HIDDEN_CLASS);
          cardEl.classList.add(ANIMATION_CLASS);
          visibleCards.push(cardEl);
        } else {
          cardEl.classList.add(HIDDEN_CLASS);
          cardEl.classList.remove(ANIMATION_CLASS);
        }
      });

      // If no cards are visible, show the no results message
      if (visibleCards.length === 0) {
        noResultsEl.classList.remove(HIDDEN_CLASS);
        noResultsEl.classList.add(ANIMATION_CLASS);
      } else {
        noResultsEl.classList.add(HIDDEN_CLASS);
        noResultsEl.classList.remove(ANIMATION_CLASS);
      }
    };

    // FILTER BUTTONS: crops filter list behavior
    const filterButtonEls = filterEl.querySelectorAll(
      '.filter__buttons button'
    );
    if (filterButtonEls.length > 0) {
      const availableCrops = Array.from(filterButtonEls).map((buttonEl) => {
        return buttonEl.dataset.crop;
      });
      
      // Default active crops to first available crop
      activeCrops = [availableCrops[0]];

      // Preset active crops
      if (globalCrop && availableCrops.includes(globalCrop)) {
        activeCrops = [globalCrop];
      } else if (globalCrop) {
        moduleEl.classList.add(HIDDEN_CLASS);
      }

      filterButtonEls.forEach((buttonEl) => {
        // Preselect button if global crop is set to its crop
        if (globalCrop && activeCrops.length > 0) {
          if (buttonEl.dataset.crop === globalCrop) {
            updateButtonStates(filterButtonEls, buttonEl);
          }
        }

        buttonEl.addEventListener('click', () => {
          const buttonCrop = buttonEl.dataset.crop ?? null;
          activeCrops = buttonCrop ? [buttonCrop] : [];
          updateButtonStates(filterButtonEls, buttonEl);
          filterCards();
        });
      });
    }

    // Single select crops
    const cropDropdownEl = filterEl.querySelector('[data-filter="crops"]');
    if (cropDropdownEl !== null) {
      const cropsListEls = cropDropdownEl.querySelectorAll('[value]');
      const availableCrops = Array.from(cropsListEls).map((cbEl) => {
        return cbEl.value;
      });

      cropDropdownEl.addEventListener(
        'dropdown-loaded',
        () => {
          // Maybe preselect active crop based on global crop selection
          if (globalCrop && availableCrops.includes(globalCrop)) {
            Array.from(cropsListEls).forEach((el) => {
              if (globalCrop === el.value) {
                el.click();
              }
            });
          } else if (globalCrop) {
            moduleEl.classList.add(HIDDEN_CLASS);
          }
        },
        false
      );

      cropDropdownEl.addEventListener(
        'values-changed',
        (e) => {
          activeCrops = e.detail.values() ?? [];
          filterCards();
        },
        false
      );
    }

    // Multi select products
    const productDropdownEl = filterEl.querySelector(
      '[data-filter="products"]'
    );
    if (productDropdownEl !== null) {
      const applyButtonEl = productDropdownEl.querySelector(
        '.item--action button'
      );

      productDropdownEl.addEventListener(
        'values-changed',
        (e) => {
          activeProducts = e.detail.values() ?? [];
          
          filterCards();
          moduleIsLoaded = true;
        },
        false
      );
    }

    filterCards();
  });
};

import UIkit from '../UIKit';

const ACTIVE_CLASS = 'uk-active';

// Handle single checkbox data
const updateSingleSelectionList = (list, value) => {
  const newList = [];

  if (!list.includes(value)) {
    newList.push(value);
  }

  return newList;
};

// Handle single checkbox DOM
const handleSingleSelectionClick = (valueEls, valueEl) => {
  const isChecked = valueEl.checked;

  if (isChecked) {
    valueEls.forEach((el) => {
      el.checked = false;
      el.closest('label').classList.remove(ACTIVE_CLASS);
    });
    valueEl.checked = true;
    valueEl.closest('label').classList.add(ACTIVE_CLASS);
  } else {
    valueEl.checked = false;
    valueEl.closest('label').classList.remove(ACTIVE_CLASS);
  }
};

// Handle multi checkbox DOM clear behavior
const clearMultiSelectionCheckboxes = (valueEls) => {
  valueEls.forEach((el) => {
    el.checked = false;
    el.closest('label').classList.remove(ACTIVE_CLASS);
  });
};

export default () => {
  const cnDropdownEls = document.querySelectorAll('.cn-dropdown');

  if (cnDropdownEls.length === 0) {
    return;
  }

  cnDropdownEls.forEach((dropdownEl) => {
    // Used to track selected values to be passed through event dispatcher
    let selectedValues = [];

    // Event dispatcher to pass value changes to other modules
    const valuesChangedEvent = new CustomEvent('values-changed', {
      bubbles: true,
      detail: {
        values: () => selectedValues,
      },
    });

    const isMultiSelect = dropdownEl.getAttribute('data-multi-select') ?? false;
    const ukDropdownEl = dropdownEl.querySelector('[uk-dropdown]');
    const triggerLabelEl = dropdownEl.querySelector('.cn-dropdown__label');
    const applyButtonEl = dropdownEl.querySelector('[data-button="apply"]');
    const initialTriggerLabelValue = triggerLabelEl.innerHTML ?? '';

    const updateTriggerLabel = () => {
      if (selectedValues.length === 0) {
        triggerLabelEl.innerHTML = initialTriggerLabelValue;
      } else if (selectedValues.length === 1) {
        const matched = dropdownEl
          .querySelector(`[value="${selectedValues[0]}"]`)
          ?.parentElement?.querySelector('.item__label-text');
        triggerLabelEl.innerHTML = matched.innerHTML;
      } else {
        triggerLabelEl.innerHTML = 'Multiple Selected';
      }
    };

    // Elements with values to keep track of
    const valueEls = dropdownEl.querySelectorAll('input[type="checkbox"]');
    const selectedValueEls = dropdownEl.querySelectorAll(
      'input[type="checkbox"][checked]'
    );

    // Setup input/label click events
    valueEls.forEach((valueEl) => {
      valueEl.addEventListener('click', (e) => {
        const value = e.target.getAttribute('value');
        
        if (!isMultiSelect) {
          selectedValues = updateSingleSelectionList(selectedValues, value);
          handleSingleSelectionClick(valueEls, valueEl);
          updateTriggerLabel();
          valueEl.dispatchEvent(valuesChangedEvent);
          UIkit.dropdown(ukDropdownEl).hide();
        } else {
          applyButtonEl.removeAttribute('disabled');
        }
      });
    });

    // Prepopulate selectedValues array based on elements' checked attributes
    selectedValueEls.forEach((selectedValueEl) => {
      selectedValues.push(selectedValueEl.getAttribute('value'));
    });

    // Clear values event
    dropdownEl.addEventListener('clear-drodpown-values', () => {
      selectedValues = [];
      clearMultiSelectionCheckboxes(valueEls);
      updateTriggerLabel();
      dropdownEl.dispatchEvent(valuesChangedEvent);
    });

    // Tell anyone listening that the dropdown has loaded
    const loadedEvent = new Event('dropdown-loaded', {
      bubbles: true, // 🫧
    });
    dropdownEl.dispatchEvent(loadedEvent);

    // Tell anyone listening what the initial values are
    dropdownEl.dispatchEvent(valuesChangedEvent);

    updateTriggerLabel();

    if (isMultiSelect && applyButtonEl) {
      applyButtonEl.addEventListener('click', () => {
        UIkit.dropdown(ukDropdownEl).hide();
        const checkedEls = dropdownEl.querySelectorAll('input:checked');
        const values = Array.from(checkedEls).map((el) =>
          el.getAttribute('value')
        );
        selectedValues = values;
        dropdownEl.dispatchEvent(valuesChangedEvent);
        updateTriggerLabel();
        
        if (checkedEls.length === 0) {
          applyButtonEl.setAttribute('disabled', true);
        }
      });
    }
  });
};

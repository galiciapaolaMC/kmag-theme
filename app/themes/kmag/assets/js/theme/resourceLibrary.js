/* eslint-env jquery */
const $ = jQuery;

const ajax_info = window.ajax_info || {};

const initResourceLibrary = () => {
  if (typeof $ === "undefined") {
    console.log("jQuery is not loaded.");
    return false;
  }

  const resourceLibraryContainerEl = document.querySelector('.resource-library-container');
  if (!resourceLibraryContainerEl) {
    return false;
  }

  // Initialize
  dynamicallyUpdateSearchValue();
  handleDropdownLabelClick();
  handleSearchFilterFormSubmit();
  handleClearAllFiltersClick();
  handleSearchIconClick();
  handleSearchClearIconClick();
  handleSearchFilterChange();
  updateClearOptions();
  loadMoreResults();
  reloadOnCropCookieChange();
};
// Form Submit Handler
function handleSearchFilterFormSubmit() {
  const searchFilterForm = $("[data-form='resource-library']");

  const filters = [
    "crops",
    "nutrients",
    "agro-topics",
    "products",
    "resource-type",
  ];

  $(document).on(
    "submit",
    "[data-form='resource-library']",
    function (e, clearAllFlag, searchString) {
      e.preventDefault();

      const updatedSearchFilterForm = $("[data-form='resource-library']");

      let activeQueryCount = getActiveQueryCount();

      let clearall =
        clearAllFlag === true || activeQueryCount === 0 ? "yes" : "";
      let search = "";

      if (searchString || searchString === "") {
        search = searchString;
      } else if (clearall === "yes") {
        search = "";
      } else {
        search = updatedSearchFilterForm.find("#search").val();
      }

      const getSelectedValues = (name) => {
        const values = [];
        $.each($(`input[name='${name}']:checked`), function () {
          values.push($(this).attr("id"));
        });
        return values;
      };

      const crops = getSelectedValues("crops");
      const nutrients = getSelectedValues("nutrients");
      const agroTopics = getSelectedValues("agronomy-topics");
      const products = getSelectedValues("products");
      const resourceType = getSelectedValues("resource-type");

      const combinedTags = [...crops, ...nutrients, ...agroTopics, ...products];

      const url = new URL(window.location.href);

      // fix for updating url with values separated by "," and not "%2C"
      if(combinedTags.length > 0){
        url.searchParams.set("tags", "LIST_OF_TAGS_PLACEHOLDER");
      }
    
      if(resourceType.length > 0) {
        url.searchParams.set("resourceType", "LIST_OF_IDS_PLACEHOLDER");
      }

      let newUrlString = [];
      newUrlString = url
        .toString()
        .replace("LIST_OF_TAGS_PLACEHOLDER", combinedTags.join(","))
        .replace("LIST_OF_IDS_PLACEHOLDER", resourceType.join(","));

      window.history.pushState(null, null, newUrlString);

      const data = {
        action: "cn_ajax_filter_search",
        search: search,
        tags: combinedTags.join(","),
        resourceType: resourceType.join(","),
        clearall: clearall,
      };

      const resultsContainer = $(".rl-content-wrapper #rl-ajax-filter-search-results");
      const filtersContainer = $(".rl-content-wrapper #filters-wrapper");
      const defaultContentContainer = $("div.page-bg");

      $.ajax({
        url: ajax_info.ajax_url,
        data: data,
        success: function (response) {
          if (response !== "") {
            defaultContentContainer.empty();
            resultsContainer.css("display", "grid");
            filtersContainer.html(response.filters_html);
            $(".rl-content-wrapper .dropdown-wrapper").addClass("hidden");
            $(".rl-content-wrapper .clear-filter").css("display", "block");
            resultsContainer.html(response.results_html);

            //initialize again after ajax data update
            dynamicallyUpdateSearchValue();
            handleClearAllFiltersClick();
            handleSearchIconClick();
            handleSearchClearIconClick();
            handleSearchFilterChange();
            updateClearOptions();
          } else {
            const html =
              "<div class='no-result'>No records found. Try a different filter or search keyword</div>";
            $(".rl-content-wrapper div#rl-ajax-filter-search-results").html(html);
          }
        },
      });
    }
  );
}

// Function to handle the popstate event
window.onpopstate = function(event) {
  location.reload();
};

// Dropdown label click Handler
function handleDropdownLabelClick() {
  $(document).on("click", ".rl-content-wrapper .dropdown-label", function () {

    let $activeLabel = $(this);
    let $activeDropdown = $activeLabel.siblings('.rl-content-wrapper .dropdown-wrapper');

    // Close other open elements
    $('.rl-content-wrapper .dropdown-wrapper').not($activeDropdown).hide();
    $('.rl-content-wrapper .dropdown-label').not($activeLabel).removeClass("open");
  
    // Toggle open/close state of clicked element & content
    $activeLabel.toggleClass("open");
    $activeDropdown.toggle();

});
}

// get Active query count = if this is 0, all results are loaded
function getActiveQueryCount() {
  const searchField = $(".rl-content-wrapper .search-input #search");
  const allFilters = $(".rl-content-wrapper .filters-wrapper .filter");
  let activeQueryCount = 0;

  // if search query active, increase the count
  if (searchField.val() !== "") {
    activeQueryCount++;
  }

  // increase activeQueryCount if any filter is active
  allFilters.each(function () {
    $(this)
      .find("input[type=checkbox]")
      .each(function (index, value) {
        const checkedState = $(this).prop("checked");
        if (checkedState === true) {
          activeQueryCount++;
        }
      });
  });

  return activeQueryCount;
}

// Clear All Filters Handler
function handleClearAllFiltersClick() {
  const searchFilterForm = $("[data-form='resource-library']");

  $(document).on("click", ".rl-content-wrapper #clear-all", function (e) {
    e.preventDefault();

    const url = new URL(window.location.href);

    $(".rl-content-wrapper .clear-filter").css("display", "none");
    url.searchParams.delete("resourceType");
    url.searchParams.delete("tags");
    window.history.pushState(null, null, url);

    $(".rl-content-wrapper .indi-filter").html("");

    $(".rl-content-wrapper .options-wrapper input[type=checkbox]").each(function (index, checkbox) {
      checkbox.checked = false;
    });

    document.getElementById("search").value = "";
    $(".rl-content-wrapper .search-input .close-icon").removeClass("show");
    $(".rl-content-wrapper .search-icon").removeClass("hide");
    $(".rl-content-wrapper .search-icon").addClass("show");

    const clearallFlag = true;
    searchFilterForm.trigger("submit", [clearallFlag]);
  });
}

// function to update search query as input value does not change when form is replaced via ajax
function dynamicallyUpdateSearchValue() {
  // Get the input field and store the initial value
  let searchInputField = $(".rl-content-wrapper .search-bar");

  // Listen for input event on the input field
  $(document).on("input", searchInputField, function () {
    // Update the value attribute with the current input value
    searchInputField.attr("value", searchInputField.val());
  });
}

// Search Icon Click Handler
function handleSearchIconClick() {
  const searchFilterForm = $("[data-form='resource-library']");

  $(document).on("click", ".rl-content-wrapper .search-icon", function (e) {
    e.preventDefault();
    const value = $(".rl-content-wrapper #search").val();

    if (value.length !== 0) {
      $(".rl-content-wrapper .validation-msg").html("");
      searchFilterForm.trigger("submit", [false, value]);
      $(".rl-content-wrapper .search-icon-wrapper").removeClass("show");
      $(".rl-content-wrapper .search-icon-wrapper").addClass("hide");
      $(".rl-content-wrapper .search-close-icon-wrapper").addClass("show");
    } else {
      $(".rl-content-wrapper .validation-msg").html(
        '<p class="val-error">Please enter search query.</p>'
      );
    }
  });
}

// Search CLEAR Icon Click Handler
function handleSearchClearIconClick() {
  const searchFilterForm = $("[data-form='resource-library']");

  $(document).on("click", ".rl-content-wrapper .search-close-icon-wrapper .close-icon, .rl-content-wrapper .selected-filter#search", function () {
    $(".rl-content-wrapper .search-close-icon-wrapper").removeClass("show");
    $(".rl-content-wrapper .search-icon-wrapper").removeClass("hide");
    $(".rl-content-wrapper .search-icon-wrapper").addClass("show");
    searchFilterForm.trigger("submit", [false, ""]);
  });
}

// Update Clear Options
function updateClearOptions() {
  const searchField = $(".rl-content-wrapper .search-input #search");
  const allFilters = $(".rl-content-wrapper .filters-wrapper .filter");
  let activeQueryCount = 0;

  $(".rl-content-wrapper .indi-filter").empty();

  // Individual Clear Options -search
  if (searchField.val() !== "") {
    const newRemoveSearchTag =
    `<a class="selected-filter" id="search" >
        Keyword Search
        <svg class="icon icon-remove-filter">
           <use xlink:href="#icon-remove-filter"></use>
        </svg>
      </a>
    `;
    $(".rl-content-wrapper .indi-filter").append(newRemoveSearchTag);
    activeQueryCount++;
  } else {
    $(".rl-content-wrapper .indi-filter #search").remove();
  }

  // Individual Clear Options - other filters
  allFilters.each(function () {
    $(this)
      .find("input[type=checkbox]")
      .each(function (index, value) {
        const checkedState = $(this).prop("checked");
        let fieldValue = $(this).val();
        const id = $(this).attr("id");
        const fieldName = $(this).attr("name");

        if (fieldName === "resource-type") {
          fieldValue = $(this).siblings("label").text();
        }

        if (checkedState === true) {
          activeQueryCount++;
          const newRemoveTag =
            '<a class="selected-filter" id="' +
            id +
            '" >' +
            fieldValue +
            '<svg class="icon icon-remove-filter"><use xlink:href="#icon-remove-filter"></use></svg></a>';
          $(".rl-content-wrapper .indi-filter").append(newRemoveTag);
        } else {
          $(".rl-content-wrapper .indi-filter #" + id).remove();
        }
      });
  });

  // Clear All Option
  if (activeQueryCount === 0) {
    $(".rl-content-wrapper .clear-filter").css("display", "none");
  }

  return activeQueryCount;
}

// search field or filter change handler - removing/adding clear tags
function handleSearchFilterChange() {
  const searchFilterForm = $("[data-form='resource-library']");

  $(document).on("click", ".rl-content-wrapper .selected-filter", function () {
    const selectedFilterId = $(this).attr("id");
    $(this).remove();
    $("input[id=" + selectedFilterId + "]").prop("checked", false);
    searchFilterForm.submit();
  });
}

// Load more option
function loadMoreResults() {
  $(document).on("click", ".rl-content-wrapper .load-more-button", function (e) {
    e.preventDefault();

    let that = $(this);

    $(this).parent().remove();

    const searchFilterForm = $("[data-form='resource-library']");

    const getSelectedValues = (name) => {
      const values = [];
      $.each($(`input[name='${name}']:checked`), function () {
        values.push($(this).val());
      });
      return values;
    };

    var page = Number($(that).attr("data-page"));
    var newPage = page + 1;

    const search = searchFilterForm.find("#search").val();
    const crops = getSelectedValues("crops");
    const nutrients = getSelectedValues("nutrients");
    const agroTopics = getSelectedValues("agronomy-topics");
    const products = getSelectedValues("products");
    const resourceType = getSelectedValues("resource-type");

    const combinedTags = [...crops, ...nutrients, ...agroTopics, ...products];

    const data = {
      action: "cn_ajax_filter_search",
      page: newPage,
      search: search,
      tags: combinedTags.join(","),
      resourceType: resourceType.join(","),
    };

    const resultsContainer = $(".rl-content-wrapper #rl-ajax-filter-search-results");

    $.ajax({
      url: ajax_info.ajax_url,
      data: data,
      error: function (response) {
        console.log(response);
      },
      success: function (response) {
        resultsContainer.append(response.results_html);
        $(".rl-content-wrapper .load-more-button").attr("data-page", newPage);
      },
    });
  });
}

// load page after cookie is set or reset
function reloadOnCropCookieChange () {
  $(document).on("click", ".rl-content-wrapper .header__enjoy-website, .rl-content-wrapper  .header__crop-region-button", function(e){
    e.preventDefault();
    let closeButtonText = $(".rl-content-wrapper .header__crop-region-button-region").html();
    if (window.location.pathname === '/resource-library/' && $(this).hasClass('header__enjoy-website')) {
      window.location.reload('/resource-library/');
    } else if (window.location.pathname === '/resource-library/' && (this.classList.contains('header__crop-region-button') && closeButtonText == "Close")) {
      window.location.reload('/resource-library/');
    }
  })
} 

export default initResourceLibrary;

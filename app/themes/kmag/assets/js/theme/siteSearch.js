/* eslint-env jquery */
const $ = jQuery;

const ajax_info = window.ajax_info || {};

const initSiteSearch = () => {
  if (typeof $ === "undefined") {
    console.log("jQuery is not loaded.");
    return false;
  }


  const urlParams = getUrlParams();
  const searchQuery = urlParams.q;

    // Initialize
    dynamicallyUpdateSearchValue();
    handleNavSearchButtonClick();
    handleSearchFieldSearchIconClick();
    handleSearchFieldClearIconClick();
    handleSearchFormSubmit();
    loadMoreResults();
    handleSearchWindowCloseClick();
    handleGoBackClick();
    handleViewAllClick();

    $(document).ready(function() {
      if(searchQuery !== undefined && searchQuery !== null && searchQuery !== "") {
        $(".main-container, body").addClass('popup-open');
        if (!$(".header__site-search").hasClass("open")) {
          $(".header__site-search").addClass("open");
        }
        $("[data-form='site-search']").trigger("submit");
      }
    })

};


// Form Submit Handler
function handleSearchFormSubmit() {
  $(document).on(
    "submit",
    "[data-form='site-search']",
    function (e) {
      e.preventDefault();

      const urlParams = getUrlParams();
      const updatedSiteSearchForm = $("[data-form='site-search']");

      const search = updatedSiteSearchForm.find("#ss-search").val();
      const searchCategory = urlParams.searchCategory;

      const url = new URL(window.location.href);
    
      if(search && search.length > 0) {
        url.searchParams.set("q", search);
      }

      if(searchCategory && searchCategory.length > 0) {
        url.searchParams.set("searchCategory", searchCategory);
      }

      const newUrlString = url.toString();

      window.history.pushState(null, null, newUrlString);

      const data = {
        action: "cn_ajax_site_search",
        q: search,
        searchCategory: searchCategory,
      };

      const resultsContainer = $(".header__site-search #ss-ajax-site-search-results");
      const searchFieldContainer = $(".header__site-search #ss-wrapper");

      $.ajax({
        url: ajax_info.ajax_url,
        data: data,
        beforeSend: function(){
          $('.loading-icon').show();
        },  
        complete: function(){
            $('.loading-icon').hide();
        },
        success: function (response) {
          if (response !== "") {

            resultsContainer.css("display", "block");
            searchFieldContainer.html(response.searchbox_html);
            resultsContainer.html(response.results_html);

            //initialize again after ajax data update
            dynamicallyUpdateSearchValue();
            handleSearchFieldSearchIconClick();
            handleSearchFieldClearIconClick();
          } else {
            const html =
              "<div class='no-result'>No records found. Try a different search keyword</div>";
            $("div#ss-ajax-site-search-results").html(html);
          }
        },
      });
    }
  );
}

//getting url params esp. category type value
function getUrlParams() {
  const urlParams = new URLSearchParams(window.location.search);
  const params = {};

  urlParams.forEach((value, key) => {
    const decodedKey = decodeURIComponent(key);
    const decodedValue = decodeURIComponent(value);

    if (decodedKey in params) {
      if (Array.isArray(params[decodedKey])) {
        params[decodedKey].push(decodedValue);
      } else {
        params[decodedKey] = [params[decodedKey], decodedValue];
      }
    } else {
      params[decodedKey] = decodedValue;
    }
  });

  return params;

}


// function to update search query as input value does not change when form is replaced via ajax
function dynamicallyUpdateSearchValue() {
  // Get the input field and store the initial value
  const searchInputField = $("#ss-search");

  // Listen for input event on the input field
  $(document).on("input", searchInputField, function () {
    // Update the value attribute with the current input value
    searchInputField.attr("value", searchInputField.val());
  });
}


// Search button click Handler
function handleNavSearchButtonClick() {
  $(document).on("click", ".header__search", function (e) {
e.preventDefault();
    $(".main-container, body").addClass('popup-open');
    if (!$(".header__site-search").hasClass("open")) {
      $(".header__site-search").addClass("open");
    }
  });
}


// handle window close on search results page
function handleSearchWindowCloseClick() {

  $(document).on("click", ".search-results .btn-search-results-close, .btn-search-close", function () {

    $(".mega-toggle-block").trigger("click");

    const url = new URL(window.location.href);

    url.searchParams.delete("searchCategory");
    url.searchParams.delete("q");
    window.history.pushState(null, null, url);

    $("#ss-search-container .close-icon").trigger("click");
    $("#ss-ajax-site-search-results").empty();
    $(".ss-results-info-wrapper").remove();
    $(".header__go-back-search-results").hide();

    if ($(".header__site-search").hasClass("open")) {
      $(".header__site-search").removeClass("open");
    }

    $("body").removeClass('popup-open');
  });
}


// Search Icon Click Handler
function handleSearchFieldSearchIconClick() {
  const searchForm = $("[data-form='site-search']");

  $(document).on("click", "#ss-search-container .search-icon", function (e) {
    e.preventDefault();
    const searchValue = $("#ss-search-container #ss-search").val();

    if (searchValue.length !== 0) {
      $("#ss-search-container .validation-msg").html("");
      searchForm.trigger("submit", [false, searchValue]);
      $("#ss-search-container .search-icon-wrapper").removeClass("show");
      $("#ss-search-container .search-icon-wrapper").addClass("hide");
      $("#ss-search-container .search-close-icon-wrapper").addClass("show");
    } else {
      $("#ss-search-container .validation-msg").html(
        '<p class="val-error">Please enter search query.</p>'
      );
    }
  });
}


// Search CLEAR Icon Click Handler
function handleSearchFieldClearIconClick() {

  $(document).on("click", "#ss-search-container .close-icon", function () {
    const url = new URL(window.location.href);

    url.searchParams.delete("searchCategory");
    url.searchParams.delete("q");
    window.history.pushState(null, null, url);

    $("#ss-search-container .search-close-icon-wrapper").removeClass("show");
    $("#ss-search-container .search-icon-wrapper").removeClass("hide");
    $("#ss-search-container .search-icon-wrapper").addClass("show");
    $("#ss-search").val("");
    $("#ss-search").attr("value", "");
  });
}


// Load more option
function loadMoreResults() {
  $(document).on("click", ".header__site-search .load-more-button", function (e) {
    e.preventDefault();

    let that = $(this);

    $(this).parent().remove();

    const siteSearchForm = $(".header__site-search [data-form='site-search']");

    const page = Number($(that).attr("data-page"));
    const newPage = page + 1;

    const search = siteSearchForm.find("#ss-search").val();

    const urlParams = getUrlParams();
    const searchCategory = urlParams.searchCategory;

    const data = {
      action: "cn_ajax_site_search",
      page: newPage,
      q: search,
      searchCategory: searchCategory,
      loadmore: "yes"
    };

    const resultsContainer = $(".header__site-search .ss-cards-wrapper");

    $.ajax({
      url: ajax_info.ajax_url,
      data: data,
      error: function (response) {
        console.log(response);
      },
      success: function (response) {
        resultsContainer.append(response.results_html);
        $(".header__site-search .load-more-button").attr("data-page", newPage);
      },
    });
  });
}


// Go Back from Single Category results page to multi category page
function handleGoBackClick() {
  $(document).on("click", ".header__go-back-search-results", function () {
    
    const savedUrl = localStorage.getItem("prevUrl");

    window.history.pushState('', '', savedUrl);
    
    const urlParams = new URLSearchParams(window.location.search);
              
    const data = {
                  action: "cn_ajax_site_search",
                  q: urlParams.get('q'),
                };

    const resultsContainer = $(".header__site-search #ss-ajax-site-search-results");
    const searchFieldContainer = $(".header__site-search #ss-wrapper");
    const backButtonContainer = $(".header__site-search .header__go-back-search-results");

    $.ajax({
      url: ajax_info.ajax_url,
      data: data,
      beforeSend: function () {
        $('.loading-icon').show();
      },
      complete: function () {
        $('.loading-icon').hide();
      },
      success: function (response) {
        if (response !== "") {
          resultsContainer.css("display", "block");
          searchFieldContainer.html(response.searchbox_html);
          resultsContainer.html(response.results_html);

          //initialize again after ajax data update
          dynamicallyUpdateSearchValue();
          handleSearchFieldSearchIconClick();
          handleSearchFieldClearIconClick();
                
          backButtonContainer.removeClass('show').addClass('hide').hide();
                
        } else {
          const html = "<div class='no-result'>No records found. Try a different search keyword</div>";
          $("div#ss-ajax-site-search-results").html(html);
        }
      }
    });
  });
}

// set urls in localStorage
function handleViewAllClick() {
  $(document).on("click", "#ss-ajax-site-search-results .view-btn a", function (e) {

    e.preventDefault();
    localStorage.setItem("prevUrl", window.location.href);
           
    window.history.pushState('', '', $(this).attr('href'));

    const urlParams = new URLSearchParams($(this).attr('href'));
          
    const data = {
      action: "cn_ajax_site_search",
      q: urlParams.get('q'),
      searchCategory: urlParams.get('searchCategory')
    };

    const headerSearchEl = document.querySelector('.header__site-search');
    headerSearchEl.scrollTop = 0;
          
    const resultsContainer = $(".header__site-search #ss-ajax-site-search-results");
    const searchFieldContainer = $(".header__site-search #ss-wrapper");
    const backButtonContainer = $(".header__site-search .header__go-back-search-results");
    
    $.ajax({
      url: ajax_info.ajax_url,
      data: data,
      beforeSend: function () {
        $('.loading-icon').show();
      },
      complete: function () {
        $('.loading-icon').hide();
      },
      success: function (response) {
        if (response !== "") {
          resultsContainer.css("display", "block");
          searchFieldContainer.html(response.searchbox_html);
          resultsContainer.html(response.results_html);

          //initialize again after ajax data update
          dynamicallyUpdateSearchValue();
          handleSearchFieldSearchIconClick();
          handleSearchFieldClearIconClick();
                
                backButtonContainer.removeClass('hide').addClass('show').show();
                
        } else {
          const html = "<div class='no-result'>No records found. Try a different search keyword</div>";
          $("div#ss-ajax-site-search-results").html(html);
        }
      }
    });
  });
}


export default initSiteSearch;
/* eslint-env jquery */
const $ = jQuery;

const initMainNavigation = () => {
  if (typeof $ === 'undefined') {
    console.log('jQuery is not loaded.');
    return false; 
  }

  let userScroll = false;
  let lastScrollTop = 0;
  const navbarHeight = $('header').outerHeight();
  const icons    = $('li.menu_icon');
  const background_gradient = $('.background-gradient');

  if (background_gradient.length > 0) {
    $('header').addClass('gradient-active');
  }

  $(window).scroll(function(event){
    userScroll = true;
  });

  setInterval(function() {
      if (userScroll) {
          hasScrolled();
          userScroll = false;
      }
  }, 10);

  function hasScrolled() {
    let scrollPosition = $('html').scrollTop();
      
      if(Math.abs(lastScrollTop - scrollPosition) <= 10)
          return;

      if (scrollPosition > lastScrollTop && scrollPosition > navbarHeight){
          $('header').removeClass('nav-down').addClass('nav-up');
      } else {
          if(scrollPosition + $(window).height() < $(document).height()) {
              $('header').removeClass('nav-up').addClass('nav-down').removeClass('gradient-active');
          }
      }

      if (background_gradient.length > 0) {
        if (scrollPosition === 0) {
          $('header').addClass('gradient-active');
        }
      }
      
      lastScrollTop = scrollPosition;
  }

  icons.each(function(i,el) {
    const classList = $(el).attr('class');
    const list = classList.split(/\s+/);
    $.each(list, function(ind, val) {
      if (val.indexOf('icon-') >= 0 && val !== 'menu_icon' && val.indexOf('mega-icon-') < 0) {
        const iconClass = val;
        $(el).children('a').prepend(
          `<svg class="icon ${iconClass}" aria-label="hidden">
            <use xlink:href="#${iconClass}"></use>
          </svg>`);
      }
    });
  });

  if ($(window).outerWidth() <= 960) {
    $('.mega-toggle-animated').on('click', function(e) {
      $('.header__go-back-mobile').hide();
      $('.mega-sub-menu').removeClass('mobile-active-submenu');
      $('.mega-menu-item').removeClass('mega-toggle-on');

      setTimeout(function() {
        if ($('.mega-menu-toggle').hasClass('mega-menu-open')) {
          $('.header__crop-region-button').addClass('mobile-active');
          $('header').addClass('mobile-open');
        } else {
          $('.header__crop-region-button').removeClass('mobile-active');
          $('header').removeClass('mobile-open');
        }
      }, 10);
    });

    $('ul#mega-menu-primary').on('mmm:showMobileMenu', function() {
      $('li.mega-menu-item').on('open_panel', function() {
        $(this).find('.mega-sub-menu').addClass('mobile-active-submenu');
        $('.header__go-back-mobile').show();
        $('.mega-menu-toggle.mega-menu-open').addClass('toggle-inactive');
      });
    });

    $('.header__go-back-mobile').on('click', function(e) {
      $('.header__go-back-mobile').hide();

      setTimeout(function() {
        $('.mega-menu-toggle.mega-menu-open').removeClass('toggle-inactive');
      },100);
    });
  }
};

export default initMainNavigation;

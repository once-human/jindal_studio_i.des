
"use strict";

window.liquidPageLoaded = false;
window.liquidIsElementor = window.liquidIsElementor || document.body.classList.contains('elementor-page');

window.liquidElements = $ => {
  "use strict";

  window.$liquidWindow = $(window);
  window.$liquidHtml = $('html');
  window.$liquidBody = $('body');
  window.$liquidSiteWrap = $('#wrap');
  window.$liquidContents = $('#lqd-site-content');
  window.$liquidContentsWrap = $('#lqd-contents-wrap');
  window.$liquidMainHeader = $('.main-header');
  window.$liquidMainFooter = $('.main-footer');
  window.$liquidSectionsWrapper = $liquidContentsWrap;
  const isPfSinglePage = $liquidBody.hasClass('single-liquid-portfolio');
  const $secWrap = $('.elementor-section-wrap', $liquidContentsWrap).first();
  window.$liquidSectionsWrapper = $secWrap.legth ? $secWrap : $('> .elementor', $liquidContentsWrap).first();

  if (isPfSinglePage) {
    window.$liquidSectionsWrapper = $('.pf-single-contents');
  }

  const elementorSectionsSelector = `
	> .elementor-section-wrap > .elementor-section,
	> .elementor-section,
	> .e-con,
	> .e-con > .e-con-inner > .e-con,
	> .e-container,
	> .e-container > .e-container,
	> .elementor-section-wrap > .elementor-top-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-inner-section,
	> .elementor-top-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-inner-section`;
  const footerSections = $('> .elementor', $liquidMainFooter).find(elementorSectionsSelector);
  window.$liquidSections = $liquidSectionsWrapper.find(elementorSectionsSelector).add(footerSections);

  if (isPfSinglePage) {
    window.$liquidSections = window.$liquidSections.add(window.$liquidSectionsWrapper.find('> .elementor').find(elementorSectionsSelector));
  }

  window.liquidBodyBg = window.$liquidBody.css('backgroundColor');
  window.liquidContentsBg = window.$liquidContents.css('backgroundColor');
  window.liquidMainFooterBg = window.$liquidMainFooter.css('backgroundColor');
};

liquidElements(jQuery);
window.liquidHeaderIsElementor = $liquidMainHeader.children('.elementor:not(.lqd-mobile-sec)').length;
window.liquidLazyloadEnabled = $liquidBody.hasClass('lazyload-enabled');
window.liquidAvailableLightboxes = [];

window.liquidIsMobile = function () {
  "use strict";

  return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 0 || navigator.platform === 'iPad';
};

if (liquidIsMobile()) {
  document.documentElement.classList.add('vc_mobile');
}

;

window.liquidMobileNavBreakpoint = function () {
  "use strict";

  if (window.liquidParams && window.liquidParams.mobileNavBreakpoint) {
    return window.liquidParams.mobileNavBreakpoint;
  } else {
    return $liquidBody.data('mobile-nav-breakpoint') || 1199;
  }
};

window.liquidWindowWidth = function () {
  "use strict";

  return window.innerWidth;
};

window.liquidWindowHeight = function () {
  "use strict";

  return window.innerHeight;
};

window.liquidDocHeight = function () {
  "use strict";

  return document.body.clientHeight;
};

const restArguments = function (func, startIndex) {
  "use strict";

  startIndex = startIndex == null ? func.length - 1 : +startIndex;
  return function () {
    var length = Math.max(arguments.length - startIndex, 0),
        rest = Array(length),
        index = 0;

    for (; index < length; index++) {
      rest[index] = arguments[index + startIndex];
    }

    switch (startIndex) {
      case 0:
        return func.call(this, rest);

      case 1:
        return func.call(this, arguments[0], rest);

      case 2:
        return func.call(this, arguments[0], arguments[1], rest);
    }

    var args = Array(startIndex + 1);

    for (index = 0; index < startIndex; index++) {
      args[index] = arguments[index];
    }

    args[startIndex] = rest;
    return func.apply(this, args);
  };
};

const liquidDelay = restArguments(function (func, wait, args) {
  "use strict";

  return setTimeout(function () {
    return func.apply(null, args);
  }, wait);
});

const liquidNow = Date.now || function () {
  "use strict";

  return new Date().getTime();
};

window.liquidThrottle = function (func, wait, options) {
  "use strict";

  var timeout, context, args, result;
  var previous = 0;
  if (!options) options = {};

  var later = function () {
    previous = options.leading === false ? 0 : liquidNow();
    timeout = null;
    result = func.apply(context, args);
    if (!timeout) context = args = null;
  };

  var throttled = function () {
    var now = liquidNow();
    if (!previous && options.leading === false) previous = now;
    var remaining = wait - (now - previous);
    context = this;
    args = arguments;

    if (remaining <= 0 || remaining > wait) {
      if (timeout) {
        clearTimeout(timeout);
        timeout = null;
      }

      previous = now;
      result = func.apply(context, args);
      if (!timeout) context = args = null;
    } else if (!timeout && options.trailing !== false) {
      timeout = setTimeout(later, remaining);
    }

    return result;
  };

  throttled.cancel = function () {
    clearTimeout(timeout);
    previous = 0;
    timeout = context = args = null;
  };

  return throttled;
};

window.liquidDebounce = function (func, wait, immediate) {
  "use strict";

  var timeout, result;

  var later = function (context, args) {
    timeout = null;
    if (args) result = func.apply(context, args);
  };

  var debounced = restArguments(function (args) {
    if (timeout) clearTimeout(timeout);

    if (immediate) {
      var callNow = !timeout;
      timeout = setTimeout(later, wait);
      if (callNow) result = func.apply(this, args);
    } else {
      timeout = liquidDelay(later, wait, this, args);
    }

    return result;
  });

  debounced.cancel = function () {
    clearTimeout(timeout);
    timeout = null;
  };

  return debounced;
};

window.liquidGetMousePos = (ev, basedOnElement) => {
  "use strict";

  let posx = 0;
  let posy = 0;
  if (!ev) ev = window.event;

  if (ev.pageX || ev.pageY) {
    posx = ev.pageX;
    posy = ev.pageY;
  } else if (ev.clientX || ev.clientY) {
    posx = ev.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
    posy = ev.clientY + document.body.scrollTop + document.documentElement.scrollTop;
  }

  if (basedOnElement) {
    const rect = ev.currentTarget.getBoundingClientRect();
    posx = posx - rect.left - window.scrollX;
    posy = posy - rect.top - window.scrollY;
  }

  return {
    x: posx,
    y: posy
  };
};

window.liquidLerp = (a, b, n) => {
  "use strict";

  return (1 - n) * a + n * b;
};
class LiquidIO {
  constructor(el, callback, opts = {}) {
    this.el = el;
    this.opts = opts;
    this.setupIO(callback);
  }

  setupIO(callback) {
    new IntersectionObserver(([entry], observer) => {
      if (entry.isIntersecting && callback) {
        if (this.opts.disconnect) {
          observer.disconnect();
        }

        callback();
      }
    }, { ...this.opts
    }).observe(this.el);
  }

}
class LiquidSectionsDetails {
  constructor() {
    this.sections = [];
    this.footerBg = tinycolor(liquidMainFooterBg).getAlpha() === 0 ? liquidBodyBg : liquidMainFooterBg;
  }

  static getInstance() {
    if (!this.instance) {
      this.instance = new LiquidSectionsDetails();
    }

    return this.instance;
  }

  static getDetails() {
    const instance = this.getInstance();
    return new Promise(async resolve => {
      if (instance.sections.length < 1) {
        instance.sections = [];
        const liquidContentsRect = await instance.getElementRect({
          element: $liquidContents[0]
        });
        await Promise.all(instance.init(liquidContentsRect, instance));
        const mainContentSections = instance.sections.filter(section => section.isInMainContent);

        if (mainContentSections.length < 1) {
          const DOM = {
            element: $liquidContents[0],
            $element: $liquidContents
          };
          await instance.createDetailsObj(liquidContentsRect, liquidContentsRect, DOM, true).then(detailsObj => {
            instance.sections.unshift(detailsObj);
          });
        }

        instance.addParentSections(instance);
        instance.addInnerSections(instance);
        await instance.addLuminosity(instance);
      }

      resolve(instance.sections);
    });
  }

  init(liquidContentsRect, instance) {
    const promises = [];
    $liquidSections.each((i, row) => {
      const promise = new Promise(resolve => {
        const DOM = {
          element: row,
          $element: jQuery(row),
          parent: row.parentElement
        };
        this.getElementRect(DOM).then(rowRect => {
          this.createDetailsObj(liquidContentsRect, rowRect, DOM, false).then(detailsObj => {
            instance.sections[i] = detailsObj;
            resolve(detailsObj);
          });
        });
      });
      promises.push(promise);
    });
    return promises;
  }

  getElementRect(DOM) {
    return new Promise(resolve => {
      new IntersectionObserver(([entry], observer) => {
        fastdom.measure(() => {
          observer.disconnect();
          resolve(entry.boundingClientRect);
        });
      }).observe(DOM.element);
    });
  }

  createDetailsObj(liquidContentsRect, rowRect, DOM, isLiquidContentElement) {
    return new Promise(resolve => {
      fastdom.measure(async () => {
        const {
          scrollY,
          scrollX
        } = window;
        const styles = getComputedStyle(DOM.element);
        const obj = {};
        obj.el = DOM.element;
        obj.$el = DOM.$element;
        obj.rect = {
          initialOffset: {
            x: rowRect.x + scrollX,
            y: rowRect.y + scrollY
          },
          width: rowRect.width,
          height: rowRect.height,
          x: rowRect.x,
          y: rowRect.y
        };
        obj.backgroundColor = styles.backgroundColor;

        if (isLiquidContentElement) {
          obj.isMainContentElement = true;
          return resolve(obj);
        }

        const footerParent = DOM.element.closest('.main-footer');
        const topContainer = DOM.$element.parents('.e-container, .e-con');
        obj.borderColor = styles.borderColor;
        obj.isOuterSection = DOM.element.classList.contains('elementor-top-section') || !!!topContainer.length;
        obj.isInnerSection = DOM.element.classList.contains('elementor-inner-section') || !!topContainer.length;
        obj.isInFooter = footerParent != null;
        obj.isInMainContent = DOM.element.closest('#lqd-site-content') != null;
        obj.isHidden = obj.rect.width < 1 && obj.rect.height < 1;
        obj.predefinedLuminosity = null;
        obj.parentSection = null;
        obj.innerSections = [];

        if (obj.el.hasAttribute('data-section-luminosity')) {
          obj.predefinedLuminosity = obj.el.getAttribute('data-section-luminosity');
        }

        if (obj.isInFooter) {
          obj.parentFooter = footerParent;

          if (footerParent.hasAttribute('data-sticky-footer')) {
            const footerOffsetTop = liquidContentsRect.height;
            const footerHeight = document.body.offsetHeight - (liquidContentsRect.y + scrollY) - liquidContentsRect.height;
            const elPositionTop = Math.abs(window.innerHeight - footerHeight - obj.rect.y);
            obj.rect.initialOffset.y = footerOffsetTop + elPositionTop;
            obj.rect.y = footerOffsetTop + elPositionTop;
          }
        }

        resolve(obj);
      });
    });
  }

  addParentSections(instance) {
    const innerSections = instance.sections.filter(sec => sec.isInnerSection);
    innerSections.forEach(innerSec => {
      const parentSec = innerSec.el.closest('.elementor-top-section') || innerSec.$el.parents('.e-container, .e-con');
      instance.sections.forEach(sec => {
        if (sec.el === parentSec) {
          innerSec.parentSection = sec;
        }
      });
    });
  }

  addInnerSections(instance) {
    const innerSections = instance.sections.filter(sec => sec.isInnerSection);
    instance.sections.forEach((outerSec, i) => {
      if (outerSec.isInnerSection) return;
      innerSections.forEach(innerSec => {
        if (innerSec.parentSection && innerSec.parentSection.el === outerSec.el) {
          instance.sections[i].innerSections.push(innerSec);
        }
      });
    });
  }

  getLuminosity(obj, instance) {
    let {
      backgroundColor
    } = obj;

    if (obj.isInnerSection && obj.parentSection && tinycolor(backgroundColor).getAlpha() === 0) {
      backgroundColor = obj.parentSection.backgroundColor;
    }

    if (tinycolor(backgroundColor).getAlpha() === 0) {
      if (obj.isInFooter) {
        backgroundColor = instance.footerBg;
      } else {
        backgroundColor = window.liquidContentsBg;
      }
    }

    return tinycolor(backgroundColor).isDark() ? 'dark' : 'light';
  }

  async addLuminosity(instance) {
    instance.sections.forEach(async sec => {
      sec.isBgTransparent = tinycolor(sec.backgroundColor).getAlpha() === 0;
      sec.luminosity = sec.predefinedLuminosity ? sec.predefinedLuminosity : instance.getLuminosity(sec, instance);
      await fastdomPromised.mutate(() => {
        sec.el.setAttribute('data-section-luminosity', sec.luminosity);
      });
    });
  }

}

;
(function ($) {
  'use strict';

  const pluginName = 'liquidPreloader';
  let defaults = {
    animationType: 'fade',
    animationTargets: 'self',
    dir: 'x',
    stagger: 0,
    duration: 1400
  };

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = $.extend({}, defaults, options);
      this.element = element;
      this.$element = $(element);
      this.animationTargets = this.getAnimationTargets();
      this.onPreloaderHiddenEvent = new CustomEvent('lqd-preloader-anim-done');
      this.onPageLoad();
    }

    getAnimationTargets() {
      const {
        animationTargets
      } = this.options;

      if (animationTargets === 'self') {
        return this.element;
      } else {
        return document.querySelectorAll(animationTargets);
      }
    }

    getAnimationProperties() {
      const {
        animationType
      } = this.options;
      return this[`${animationType}Properties`]();
    }

    fadeProperties() {
      const animateIn = {
        opacity: [0, 1]
      };
      const animateOut = {
        opacity: [1, 0]
      };
      return {
        animateIn,
        animateOut
      };
    }

    slideProperties() {
      const {
        dir
      } = this.options;
      const animateIn = {
        [dir]: ['100%', '0%']
      };
      const animateOut = {
        [dir]: ['0%', '-100%']
      };
      return {
        animateIn,
        animateOut
      };
    }

    scaleProperties() {
      const animateIn = {
        [`scale${this.options.dir.toUpperCase()}`]: [0, 1]
      };
      const animateOut = {
        [`scale${this.options.dir.toUpperCase()}`]: [1, 0]
      };
      return {
        animateIn,
        animateOut
      };
    }

    onPageLoad() {
      $liquidBody.addClass('lqd-page-loaded lqd-preloader-animations-started');
      $liquidBody.removeClass('lqd-page-leaving lqd-page-not-loaded');
      this.hidePreloader();
    }

    hidePreloader() {
      const stagger = this.options.stagger / 1000;
      const duration = this.options.duration / 1000;
      const timeline = gsap.timeline({
        duration,
        ease: 'expo.out',
        stagger: stagger,
        onComplete: () => {
          this.$element.hide();
          $liquidBody.removeClass('lqd-preloader-animations-started');
          $liquidBody.addClass('lqd-preloader-animations-done');
          $(this.animationTargets).css('transform', '');
          document.dispatchEvent(this.onPreloaderHiddenEvent);
        }
      });
      $(this.animationTargets).each((i, targetElement) => {
        const $targetElement = $(targetElement);

        if (targetElement.hasAttribute('data-animations')) {
          const animations = $targetElement.data('animations');
          timeline.to(targetElement, { ...animations
          }, stagger * i);
        } else {
          const animationProperties = this.getAnimationProperties().animateOut;
          timeline.fromTo(targetElement, {
            [Object.keys(animationProperties)[0]]: Object.values(animationProperties)[0][0]
          }, {
            [Object.keys(animationProperties)[0]]: Object.values(animationProperties)[0][1]
          }, stagger * i);
        }
      });
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('preloader-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

$liquidWindow.on('pageshow load', ev => {
  if ('elementorFrontend' in window && elementorFrontend.isEditMode()) return;
  liquidPageLoaded || jQuery('.lqd-preloader-wrap').liquidPreloader();
  liquidPageLoaded = true;
});
(function ($) {
  'use strict';

  const pluginName = 'liquidSubmenu';
  let defaults = {
    toggleType: "fade",
    handler: "mouse-in-out",
    animationSpeed: 200
  };

  class Plugin {
    constructor(element, options) {
      this.element = element;
      this.$element = $(element);
      this.options = { ...defaults,
        ...options
      };
      this._defaults = defaults;
      this._name = pluginName;
      this.rects = [];
      this.isModernMobileNav = document.body.hasAttribute('data-mobile-nav-style') && document.body.getAttribute('data-mobile-nav-style') === 'modern';
      this.windowWidth = fastdom.measure(liquidWindowWidth)();
      this.itemsAreFullwidth = this.element.classList.contains('lqd-menu-items-block');
      this.init();
    }

    init() {
      const {
        handler
      } = this.options;
      const $submenuParent = $(this.$element.find('.menu-item-has-children, .page_item_has_children').get().reverse());
      $submenuParent.each(async (i, subParent) => {
        const isMegamenu = subParent.classList.contains('megamenu');
        const submenu = subParent.querySelector('.nav-item-children, .children');
        if (!submenu) return;

        if (handler === 'click') {
          this.element.classList.add('lqd-submenu-toggle-click');
        } else if (handler === 'mouse-in-out') {
          this.element.classList.add('lqd-submenu-toggle-hover');
        }

        if (!liquidIsMobile() && !this.itemsAreFullwidth) {
          if (!isMegamenu) {
            await this.measure(i, submenu, subParent);
          } else {
            this.getMegamenuBackgroundLuminance(subParent);
          }
        } else {
          subParent.classList.add('position-applied');
        }

        this.eventHandlers(i, submenu, subParent);
      });
      return this;
    }

    async measure(i, submenu, subParent) {
      await this.getRects(i, submenu, subParent);
      await this.positioning(i, submenu, subParent);
    }

    eventHandlers(i, submenu, submenuParent) {
      const {
        handler
      } = this.options;
      const $toggleLink = $(submenuParent).children('a');
      const $mobileNavExpander = $('.submenu-expander', $toggleLink);

      if ($mobileNavExpander.length) {
        $mobileNavExpander.off();
        $mobileNavExpander.on('click', event => {
          event.preventDefault();
          event.stopPropagation();
          this.mobileNav.call(this, $(event.currentTarget).closest('li'));
        });
      }

      if (handler === 'click') {
        $toggleLink.off();
        $toggleLink.on('click', this.handleToggle.bind(this, 'toggle'));
        $(document).on('click', this.closeActiveSubmenu.bind(this));
        $(document).keyup(event => {
          if (event.keyCode == 27) {
            this.closeActiveSubmenu(event);
          }
        });
      } else {
        $(submenuParent).off();
        $(submenuParent).on('mouseenter', this.handleToggle.bind(this, 'show'));
        $(submenuParent).on('mouseleave', this.handleToggle.bind(this, 'hide'));
      }

      document.addEventListener('lqd-header-sticky-change', async () => {
        await this.measure(i, submenu, submenuParent);
      });
      return this;
    }

    handleToggle(state, event) {
      const {
        toggleType,
        handler
      } = this.options;
      const $link = $(event.currentTarget);
      const submenu = $link.is('a') ? $link.siblings('.nav-item-children, .children') : $link.children('.nav-item-children, .children');
      const isMegamenu = $link.is('.megamenu') ? true : false;
      const megamenuBg = isMegamenu && $link.attr('data-bg-color');
      const megamenuScheme = isMegamenu && $link.attr('data-megamenu-bg-scheme');
      const $elementorHeaderWidgets = liquidIsElementor && $liquidMainHeader.find('> .elementor:not(.lqd-mobile-sec) > .elementor-section').not('.lqd-stickybar-wrap').find('> .elementor-container > .elementor-column > .elementor-widget-wrap > [data-element_type="widget"]');

      if (submenu.length) {
        event.preventDefault();
        submenu.closest('li').toggleClass(`is-active ${handler === 'mouse-in-out' && 'is-hovered'}`, state === 'show').siblings().removeClass(`is-active ${handler === 'mouse-in-out' && 'is-hovered'}`);

        if (toggleType === 'fade' && state === 'show') {
          this.fadeIn(submenu, isMegamenu, megamenuScheme, megamenuBg, $elementorHeaderWidgets);
        } else if (toggleType === 'fade' && state === 'hide') {
          this.fadeOut(submenu, isMegamenu, megamenuScheme, megamenuBg, $elementorHeaderWidgets);
        }

        if (toggleType === 'slide' && state === 'show') {
          this.slideDown(submenu, isMegamenu, megamenuScheme, megamenuBg, $elementorHeaderWidgets);
        } else if (toggleType === 'slide' && state === 'hide') {
          this.slideUp(submenu, isMegamenu, megamenuScheme, megamenuBg, $elementorHeaderWidgets);
        }

        if (toggleType === 'fade' && state === 'toggle') {
          this.fadeToggle(submenu, isMegamenu, megamenuScheme, megamenuBg, $elementorHeaderWidgets);
        }

        if (toggleType === 'slide' && state === 'toggle') {
          this.slideToggle(submenu, isMegamenu, megamenuScheme, megamenuBg, $elementorHeaderWidgets);
        }
      }
    }

    fadeToggle(submenu, isMegamenu, megamenuScheme, megamenuBg, $elementorHeaderWidgets) {
      if (isMegamenu) {
        if ($elementorHeaderWidgets && megamenuScheme !== 'transparent' && !$liquidMainHeader.hasClass('is-stuck')) {
          $elementorHeaderWidgets.removeClass(`lqd-active-row-dark lqd-active-row-light`);
          $elementorHeaderWidgets.addClass(`lqd-active-row-${megamenuScheme}`);
        }

        $liquidMainHeader[0].style.setProperty('--lqd-megamenu-background-color', megamenuBg);
        $liquidMainHeader.removeClass('megamenu-scheme-dark megamenu-scheme-light megamenu-scheme-transparent');
        $liquidMainHeader.toggleClass(`megamenu-item-active megamenu-scheme-${megamenuScheme}`);
      }
    }

    fadeIn(submenu, isMegamenu, megamenuScheme, megamenuBg, $elementorHeaderWidgets) {
      if (isMegamenu) {
        if ($elementorHeaderWidgets && megamenuScheme !== 'transparent' && !$liquidMainHeader.hasClass('is-stuck')) {
          $elementorHeaderWidgets.removeClass(`lqd-active-row-dark lqd-active-row-light`);
          $elementorHeaderWidgets.addClass(`lqd-active-row-${megamenuScheme}`);
        }

        $liquidMainHeader[0].style.setProperty('--lqd-megamenu-background-color', megamenuBg);
        $liquidMainHeader.removeClass('megamenu-scheme-dark megamenu-scheme-light megamenu-scheme-transparent');
        $liquidMainHeader.addClass(`megamenu-item-active megamenu-scheme-${megamenuScheme}`);
      }

      if (submenu.find('[data-lqd-flickity]').length) {
        submenu.find('[data-lqd-flickity]').flickity('resize');
      }
    }

    fadeOut(submenu, isMegamenu, megamenuScheme, megamenuBg, $elementorHeaderWidgets) {
      if (isMegamenu) {
        if ($elementorHeaderWidgets) {
          $elementorHeaderWidgets.removeClass(`lqd-active-row-dark lqd-active-row-light`);
        }

        $liquidMainHeader.removeClass('megamenu-scheme-dark megamenu-scheme-light megamenu-scheme-transparent');
        $liquidMainHeader.removeClass('megamenu-item-active');
      }
    }

    slideToggle(submenu, isMegamenu, megamenuScheme, megamenuBg, $elementorHeaderWidgets) {
      submenu.closest('li').siblings().find('.nav-item-children, .children').stop().slideUp(this.options.animationSpeed);
      submenu.stop().slideToggle(this.options.animationSpeed);

      if (isMegamenu) {
        if ($elementorHeaderWidgets && megamenuScheme !== 'transparent' && !$liquidMainHeader.hasClass('is-stuck')) {
          $elementorHeaderWidgets.removeClass(`lqd-active-row-dark lqd-active-row-light`);
          $elementorHeaderWidgets.addClass(`lqd-active-row-${megamenuScheme}`);
        }

        $liquidMainHeader[0].style.setProperty('--lqd-megamenu-background-color', megamenuBg);
        $liquidMainHeader.removeClass('megamenu-scheme-dark megamenu-scheme-light megamenu-scheme-transparent');
        $liquidMainHeader.toggleClass(`megamenu-item-active megamenu-scheme-${megamenuScheme}`);
      }
    }

    slideDown(submenu, isMegamenu, megamenuScheme, megamenuBg, $elementorHeaderWidgets) {
      submenu.closest('li').siblings().find('.nav-item-children, .children').stop().slideUp(this.options.animationSpeed);
      submenu.stop().slideDown(this.options.animationSpeed);

      if (isMegamenu) {
        if ($elementorHeaderWidgets && megamenuScheme !== 'transparent' && !$liquidMainHeader.hasClass('is-stuck')) {
          $elementorHeaderWidgets.removeClass(`lqd-active-row-dark lqd-active-row-light`);
          $elementorHeaderWidgets.addClass(`lqd-active-row-${megamenuScheme}`);
        }

        $liquidMainHeader[0].style.setProperty('--lqd-megamenu-background-color', megamenuBg);
        $liquidMainHeader.removeClass('megamenu-scheme-dark megamenu-scheme-light megamenu-scheme-transparent');
        $liquidMainHeader.addClass(`megamenu-item-active megamenu-scheme-${megamenuScheme}`);
      }
    }

    slideUp(submenu, isMegamenu, megamenuScheme, megamenuBg, $elementorHeaderWidgets) {
      submenu.stop().slideUp(this.options.animationSpeed);

      if (isMegamenu) {
        if ($elementorHeaderWidgets) {
          $elementorHeaderWidgets.removeClass(`lqd-active-row-dark lqd-active-row-light`);
        }

        $liquidMainHeader.removeClass('megamenu-scheme-dark megamenu-scheme-light megamenu-scheme-transparent');
        $liquidMainHeader.removeClass('megamenu-item-active');
      }
    }

    getMegamenuBackgroundLuminance(subParent) {
      const megamenuRowsWrap = subParent.querySelector('.lqd-megamenu-rows-wrap');
      let backgroundColor;
      fastdom.measure(() => {
        const styles = getComputedStyle(megamenuRowsWrap);
        backgroundColor = tinycolor(styles.backgroundColor);
      });
      fastdom.mutate(() => {
        subParent.setAttribute('data-bg-color', backgroundColor);

        if (backgroundColor.getAlpha() === 0) {
          return subParent.setAttribute('data-megamenu-bg-scheme', 'transparent');
        }

        if (backgroundColor.isLight()) {
          return subParent.setAttribute('data-megamenu-bg-scheme', 'light');
        }

        if (backgroundColor.isDark()) {
          return subParent.setAttribute('data-megamenu-bg-scheme', 'dark');
        }
      });
    }

    closeActiveSubmenu(event) {
      const {
        toggleType,
        animationSpeed
      } = this.options;

      if (event.keyCode) {
        const mainNav = $(this.element);

        if (toggleType == 'fade') {
          mainNav.find('.active').removeClass('active').find('.nav-item-children, .children').stop().fadeOut(animationSpeed);
        } else {
          mainNav.find('.active').removeClass('active').find('.nav-item-children, .children').stop().slideUp(animationSpeed);
        }
      } else {
        const submenuParent = $(this);

        if (!submenuParent.is(event.target) && !submenuParent.has(event.target).length) {
          submenuParent.removeClass('active');

          if (toggleType == 'fade') {
            submenuParent.find('.nav-item-children, .children').stop().fadeOut(animationSpeed);
          } else {
            submenuParent.find('.nav-item-children, .children').stop().slideUp(animationSpeed);
          }
        }
      }
    }

    mobileNav(submenuParent) {
      const $submenuParent = $(submenuParent);
      const $submenu = $submenuParent.children('.nav-item-children, .children');
      const $navbarInner = $submenuParent.closest('.navbar-collapse-inner');
      const submenuParentWasActive = $submenuParent.hasClass('is-active');
      $submenuParent.toggleClass('is-active');
      $submenuParent.siblings().removeClass('is-active').find('.nav-item-children, .children').stop().slideUp(200);
      $submenu.stop().slideToggle(300, () => {
        if (this.isModernMobileNav && !submenuParentWasActive && $navbarInner.length) {
          $navbarInner.animate({
            scrollTop: $navbarInner.scrollTop() + ($submenuParent.offset().top - $navbarInner.offset().top)
          });
        }
      });
    }

    async getRects(i, submenu, submenuParent) {
      this.rects[i] = {
        submenuRect: {},
        subParentRect: {}
      };
      return fastdomPromised.measure(() => {
        return new Promise(resolve => {
          new IntersectionObserver(([entry], observer) => {
            const {
              boundingClientRect
            } = entry;
            observer.disconnect();
            resolve(boundingClientRect);
          }).observe(submenu);
        });
      }).then(submenuRect => {
        this.rects[i].submenuRect = submenuRect;
        return new Promise(resolve => {
          new IntersectionObserver(([entry], observer) => {
            const {
              boundingClientRect
            } = entry;
            observer.disconnect();
            resolve(boundingClientRect);
          }).observe(submenuParent);
        });
      }).then(subParentRect => {
        this.rects[i].subParentRect = subParentRect;
      });
    }

    positioning(i, submenu, submenuParent) {
      return fastdomPromised.mutate(() => {
        const submenuRect = this.rects[i].submenuRect;
        const subParentRect = this.rects[i].subParentRect;

        if (submenuRect.left + submenuRect.width >= this.windowWidth) {
          submenu.classList.add('to-left');
        }

        submenuParent.style.setProperty('--item-height', `${subParentRect.height}px`);
        submenuParent.classList.add('position-applied');
      });
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('submenu-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('.main-nav, .lqd-custom-menu').liquidSubmenu();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidMobileNav';
  let defaults = {};

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.element = element;
      this.$element = $(element);
      this.$mobileSec = $('.lqd-mobile-sec', $liquidMainHeader);
      this.$mobileSecInner = $('.lqd-mobile-sec-inner', this.$mobileSec);
      this.$mobileNavCollapse = $('.mobile-navbar-collapse', this.$mobileSec);
      this.$navItems = [];
      this.init();
    }

    init() {
      this.removeStyleTags();
      this.addHeightVar();
      this.mobileModules();

      if ('elementorFrontend' in window && !elementorFrontend.isEditMode()) {
        this.$mobileSec.addClass('elementor');
      }
    }

    removeStyleTags() {
      fastdom.mutate(() => {
        this.$mobileSec.find('.navbar-collapse style[data-type=vc_shortcodes-custom-css]').remove();
      });
    }

    addHeightVar() {
      fastdom.mutate(() => {
        if (this.$mobileSecInner.length) {
          document.documentElement.style.setProperty('--lqd-mobile-sec-height', `${this.$mobileSecInner[0].offsetHeight}px`);
        }
      });
    }

    mobileModules() {
      const $mobileModules = $('.lqd-show-on-mobile', this.element);
      if (!$mobileModules.length) return;
      const $mobileModulesContainer = $('.lqd-mobile-modules-container', this.$mobileSec);
      fastdom.mutate(() => {
        $mobileModulesContainer.removeClass('empty');
        $mobileModules.each((i, mobileModule) => {
          const $module = $(mobileModule);
          if (!$module.children().length) return false;
          const $clonedModule = $module.clone(true);
          const $triggerElement = $('[data-target]', $clonedModule);

          if ($triggerElement.length) {
            const target = $triggerElement.attr('data-target');
            const $targetEelement = $(target, $clonedModule);
            $targetEelement.attr({
              'id': `${target.replace('#', '')}-cloned`
            });
            $triggerElement.attr({
              'data-target': `${target}-cloned`,
              'aria-controls': `${target.replace('#', '')}-cloned`
            });
            $targetEelement.on('show.bs.collapse', () => {
              $targetEelement.add($triggerElement).addClass('is-active');
            });
            $targetEelement.on('hide.bs.collapse', () => {
              $targetEelement.add($triggerElement).removeClass('is-active');
            });
          }

          $clonedModule.appendTo($mobileModulesContainer);

          if (!$clonedModule.hasClass('header-module')) {
            $clonedModule.wrap('<div class="header-module" />');
          }
        });
      });
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('mobilenav-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function () {
  if (document.body.hasAttribute('data-mobile-header-builder')) return;
  $liquidMainHeader.liquidMobileNav();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidButton';
  let defaults = {};

  class Plugin {
    constructor(element, options) {
      this.element = element;
      this.options = $.extend({}, defaults, options);
      this._defaults = defaults;
      this._name = pluginName;
      this.init();
    }

    init() {
      this.gradientBorderRoundness();
    }

    gradientBorderRoundness() {
      const self = this;
      const element = $(self.element);

      if (element.find('.btn-gradient-border').length && element.hasClass('circle') && element.is(':visible')) {
        const svgBorder = element.find('.btn-gradient-border').children('rect');
        const buttonHeight = element.height();
        svgBorder.attr({
          rx: buttonHeight / 2,
          ry: buttonHeight / 2
        });
      }
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = $(this).data('plugin-options') || options;

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {});
(function ($) {
  'use strict';

  const pluginName = 'liquidFitText';
  let defaults = {
    compressor: 1,
    minFontSize: Number.NEGATIVE_INFINITY,
    maxFontSize: Number.POSITIVE_INFINITY
  };

  function Plugin(element, options) {
    this.element = element;
    this.options = $.extend({}, defaults, options);
    this._defaults = defaults;
    this._name = pluginName;
    this.init();
  }

  Plugin.prototype = {
    init() {
      this.setMinFontSize();
      this.setMaxFontSize();
      this.resizer();
      this.onWindowResize();
    },

    setMinFontSize() {
      const minFontSize = this.options.minFontSize;
      const elementFontSize = $(this.element).css('fontSize');

      if (minFontSize == 'currentFontSize') {
        this.options.minFontSize = elementFontSize;
      }
    },

    setMaxFontSize() {
      const maxFontSize = this.options.maxFontSize;
      const elementFontSize = $(this.element).css('fontSize');

      if (maxFontSize == 'currentFontSize') {
        this.options.maxFontSize = elementFontSize;
      }
    },

    resizer() {
      const options = this.options;
      const compressor = options.compressor;
      const maxFontSize = options.maxFontSize;
      const minFontSize = options.minFontSize;
      const $element = $(this.element);
      const elementWidth = $element.parent('.ld-fancy-heading').length ? $element.parent().width() : $element.width();
      $element.css('font-size', Math.max(Math.min(elementWidth / (compressor * 10), parseFloat(maxFontSize)), parseFloat(minFontSize)));
    },

    onWindowResize() {
      $(window).on('resize.fittext orientationchange.fittext', this.resizer.bind(this));
    }

  };

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = $(this).data('fittext-options') || options;

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('[data-fittext]').liquidFitText();
});
jQuery(document).ready(function ($) {
  if (liquidLazyloadEnabled) {
    const globalLazyLoadOffset = window.liquidParams?.lazyLoadOffset;
    const threshold = globalLazyLoadOffset >= 0 ? globalLazyLoadOffset : 500;
    window.liquidLazyload = new LazyLoad({
      elements_selector: '.ld-lazyload',
      threshold,
      callback_loaded: el => {
        const $element = $(el);
        const $masonryParent = $element.closest('[data-liquid-masonry=true]');
        const $flexParent = $element.closest('.flex-viewport');
        const $webGLHoverParent = $element.closest('[data-webglhover]');
        const $revealParent = $element.closest('[data-reveal]');
        $element.parent().not('#wrap, #lqd-site-content').addClass('loaded');
        $element.closest('[data-responsive-bg=true]').liquidResponsiveBG();

        if ($masonryParent.length && $masonryParent.data('isotope')) {
          $masonryParent.isotope('layout');
        }

        if ($flexParent.length && $flexParent.parent().data('flexslider')) {
          $flexParent.height($element.height());
        }

        if ($webGLHoverParent.length) {
          $webGLHoverParent.liquidWebGLHover();
        }

        if ($revealParent.length) {
          $revealParent.liquidReveal();
        }
      }
    });
  }
});
(function ($) {
  'use strict';

  const pluginName = 'liquidInView';
  let defaults = {
    delayTime: 0,
    onImagesLoaded: false,
    toggleBehavior: 'stay',
    classnames: ['is-in-view']
  };

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = $.extend({}, defaults, options);
      this.element = element;
      this.$element = $(element);
      this.$sentinel = null;
      this.isVisible = false;
      this.imagesAlreadyLoaded = false;
      this.isFixedPos = fastdom.measure(() => this.$element.css('position') === 'fixed')();
      this.windowWidth = fastdom.measure(liquidWindowWidth)();
      this.windowHeight = fastdom.measure(liquidWindowHeight)();
      this.initIO();
    }

    initIO() {
      const {
        toggleBehavior
      } = this.options;
      new IntersectionObserver(([entry], observer) => {
        fastdomPromised.measure(() => {
          return {
            boundingClientRect: entry.boundingClientRect,
            scrollY: window.scrollY
          };
        }).then(({
          boundingClientRect,
          scrollY
        }) => {
          fastdom.mutate(() => {
            if (toggleBehavior === 'toggleInView') {
              if (scrollY + this.windowHeight >= boundingClientRect.top + scrollY) {
                this.isVisible = true;
                this.callFns();
              } else if (scrollY <= boundingClientRect.bottom + scrollY) {
                this.isVisible = false;
                this.callFns();
              }
            }

            if (entry.isIntersecting && toggleBehavior === 'stay') {
              observer.disconnect();
              this.isVisible = true;
              this.callFns();
            } else if (!entry.isIntersecting && toggleBehavior === 'toggleOutOfView') {
              this.onOutOfView();
            }
          });
        });
      }, {
        threshold: toggleBehavior === 'toggleInView' ? [0, 0.25, 0.5, 0.75, 1] : [0]
      }).observe(!this.isFixedPos ? this.element : this.$element.parent()[0]);
    }

    callFns() {
      if (!this.options.onImagesLoaded && !this.imagesAlreadyLoaded) {
        this.run();
      } else {
        imagesLoaded(this.element, () => {
          this.imagesAlreadyLoaded = true;
          this.run();
        });
      }
    }

    run() {
      const {
        delayTime
      } = this.options;
      delayTime <= 0 ? this.onInView() : this.timeoutId = setTimeout(this.onInView.bind(this), delayTime);
    }

    onInView() {
      this.$element.toggleClass(this.options.classnames.join(' '), this.isVisible);
      clearTimeout(this.timeoutId);
    }

    onOutOfView() {
      const {
        toggleBehavior
      } = this.options;

      if (toggleBehavior === 'toggleOutOfView') {
        this.isVisible = false;
      }

      if (!this.isVisible) {
        this.$element.removeClass(this.options.classnames.join(' '));
      }
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = $(this).data('inview-options') || options;

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  if (!$liquidContents.length) {
    return $('[data-inview]').liquidInView();
  }

  ;

  const init = () => {
    if ($liquidBody.hasClass('lqd-preloader-activated')) {
      document.addEventListener('lqd-preloader-anim-done', () => {
        $('[data-inview]').liquidInView();
      });
    } else {
      $('[data-inview]').liquidInView();
    }
  };

  if (!$liquidContents[0].hasAttribute('data-liquid-stack')) {
    init();
  } else {
    const stackOptions = $liquidContents.attr('data-stack-options');

    if (stackOptions) {
      const optionsJson = JSON.parse(stackOptions);
      const {
        disableOnMobile
      } = optionsJson;

      if (disableOnMobile && (liquidIsMobile() || liquidWindowWidth() <= liquidMobileNavBreakpoint())) {
        init();
      }
    }
  }
});
(function ($) {
  'use strict';

  const pluginName = 'liquidFullscreenNav';
  let defaults = {};

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.DOM = {};
      this.DOM.element = element;
      this.DOM.$element = $(element);
      this.init();
    }

    init() {
      this.DOM.$element.children('.header-modules-container').find('.lqd-head-col').removeClass('lqd-head-col');
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('fullscreen-nav-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('.navbar-fullscreen').liquidFullscreenNav();
});
(function ($) {
  'use strict';

  const $body = $('body');
  const pluginName = 'liquidToggle';
  let defaults = {
    type: 'click',
    cloneTriggerInTarget: false,
    closeOnOutsideClick: true,
    toggleDelay: 300
  };

  class Plugin {
    constructor(element, options) {
      this.element = element;
      this.$element = $(element);
      this.options = { ...defaults,
        ...options
      };
      this._defaults = defaults;
      this._name = pluginName;
      this.$targetElement = $(this.$element.attr('data-target') || this.$element.attr('data-bs-target'));
      this.$parentElement = this.$element.parent();
      this.isInVerticalBar = this.$element.closest('.lqd-stickybar-wrap').length;
      this.isSearchModule = this.$parentElement.hasClass('ld-module-search');
      this.isCartModule = this.$parentElement.hasClass('ld-module-cart');
      this.$clonedTrigger = null;
      this.isOpened = false;
      this.isInHeader = $liquidMainHeader.has(this.element).length;
      this.windowWidth = fastdom.measure(liquidWindowWidth)();
      this.targetRect = {};

      if (this.$element.hasClass('lqd-custom-menu-dropdown-btn') && this.$element.parents('.header-module').length) {
        this.options.type = 'hoverFade';
      }

      this.init();
    }

    async init() {
      const $targetToPosition = this.$targetElement.not('.navbar-collapse');

      if (!this.isInVerticalBar && $targetToPosition.length && !liquidIsMobile()) {
        $targetToPosition[0].classList.add('positioning');
        await this.measure($targetToPosition[0]);
        await this.positioning($targetToPosition[0]);
      }

      this.addBodyClassnames();
      this.eventHandlers();
      this.cloneTriggerInTarget();
      this.cloneTargetInBody();
    }

    measure(targetElement) {
      return fastdomPromised.measure(() => {
        return new Promise(resolve => {
          new IntersectionObserver(([entry], observer) => {
            observer.disconnect();
            resolve(entry.boundingClientRect);
          }).observe(targetElement);
        });
      }).then(rect => {
        this.targetRect = rect;
      });
    }

    positioning(targetElement) {
      return fastdomPromised.mutate(() => {
        if (this.targetRect.width + this.targetRect.left >= this.windowWidth) {
          targetElement.classList.remove('left');
          targetElement.classList.add('right');
        }

        if (this.targetRect.left < 0) {
          targetElement.classList.remove('right');
          targetElement.classList.add('left');
        }

        targetElement.classList.remove('positioning');
      });
    }

    addBodyClassnames() {
      if (this.$parentElement[0].hasAttribute('data-module-style')) {
        $body.addClass(this.$parentElement.attr('data-module-style'));
      }
    }

    eventHandlers() {
      const {
        type
      } = this.options;

      if (type === 'hover') {
        this.$element.on('mouseenter', () => {
          this.$targetElement.collapse('show');
        });
        this.$element.add(this.$targetElement).on('mouseleave', () => {
          this.$targetElement.collapse('hide');
        });
      } else if (type === 'hoverFade' && !liquidIsMobile()) {
        fastdom.mutate(() => {
          let timeout = false;
          this.$targetElement.addClass('lqd-dropdown-fade-onhover');
          this.$element.add(this.$targetElement).on('mouseenter', () => {
            this.$targetElement.addClass('is-active');
            this.$targetElement.trigger('shown.bs.collapse');
            timeout && clearTimeout(timeout);
          });
          this.$element.add(this.$targetElement).on('mouseleave', () => {
            timeout = setTimeout(() => {
              this.$targetElement.removeClass('is-active');
              this.$targetElement.trigger('hidden.bs.collapse');
              timeout && clearTimeout(timeout);
            }, this.options.toggleDelay);
          });
        });
      }

      this.$targetElement.on('show.bs.collapse', this.onShow.bind(this));
      this.$targetElement.on('shown.bs.collapse', this.onShown.bind(this));
      this.$targetElement.on('hide.bs.collapse', this.onHide.bind(this));
      this.$targetElement.on('hidden.bs.collapse', this.onHidden.bind(this));
      $(document).on('click', event => {
        this.closeAll.call(this, event);
      });
      $(document).on('keyup', event => {
        if (event.key === 'Escape') {
          this.closeAll.call(this, event);
        }
      });

      if (this.isInHeader) {
        document.addEventListener('lqd-header-sticky-visibility-change', e => {
          if (this.isOpened && e.detail.state === 'hide') {
            this.$targetElement.collapse('hide');
          }
        });
      }
    }

    onShow(e) {
      const targetAttr = this.$element.attr('data-target') || this.$element.attr('data-bs-target');
      $('html').addClass('module-expanding');

      if (this.isSearchModule) {
        $('html').addClass('lqd-module-search-expanded');
      } else if (this.isCartModule) {
        $('html').addClass('lqd-module-cart-expanded');
      }

      this.$targetElement.add(this.element).add(this.$clonedTrigger).addClass('is-active');

      if (targetAttr.replace('#', '') === $(e.target).attr('id')) {
        this.toggleClassnames();
        this.focusOnSearch();
      }

      this.isOpened = true;
    }

    onShown() {
      $('html').removeClass('module-expanding');

      if (window.liquidLazyload) {
        window.liquidLazyload.update();
      }
    }

    onHide(e) {
      const targetAttr = this.$element.attr('data-target') || this.$element.attr('data-bs-target');
      $('html').addClass('module-collapsing');
      this.$targetElement.add(this.element).add(this.$clonedTrigger).removeClass('is-active');

      if (targetAttr.replace('#', '') === $(e.target).attr('id')) {
        this.toggleClassnames();
      }

      this.isOpened = false;
    }

    onHidden() {
      $('html').removeClass('module-collapsing lqd-module-search-expanded lqd-module-cart-expanded');
    }

    toggleClassnames() {
      $.each(this.options.changeClassnames, (element, classname) => {
        $(element).toggleClass(classname, !this.isOpened);
      });

      if (!this.options.changeClassnames && this.$targetElement.hasClass('navbar-fullscreen')) {
        $liquidHtml.toggleClass('overflow-hidden', !this.isOpened);
      }
    }

    focusOnSearch() {
      const self = this;

      if (self.$targetElement.find('input[type=search]').length) {
        setTimeout(function () {
          self.$targetElement.find('input[type=search]').focus().select();
        }, 150);
      }
    }

    shouldIGetClosed($target) {
      const {
        closeOnOutsideClick
      } = this.options;

      if (typeof closeOnOutsideClick === 'boolean') {
        return closeOnOutsideClick;
      } else {
        const {
          ifNotIn
        } = closeOnOutsideClick;
        const $ifNotInEl = $(ifNotIn);
        return !$ifNotInEl.has($target).length ? true : false;
      }
    }

    closeAll(event) {
      const {
        closeOnOutsideClick
      } = this.options;
      const shouldIGetClosed = this.shouldIGetClosed(this.$targetElement);

      if (event.keyCode) {
        if (closeOnOutsideClick && shouldIGetClosed) {
          this.$targetElement.collapse('hide');
        } else if (typeof closeOnOutsideClick === 'boolean' && closeOnOutsideClick) {
          this.$targetElement.collapse('hide');
        }
      } else if (!this.$targetElement.is(event.target) && !this.$targetElement.has(event.target).length) {
        if (closeOnOutsideClick && shouldIGetClosed) {
          this.$targetElement.collapse('hide');
        } else if (typeof closeOnOutsideClick === 'boolean' && closeOnOutsideClick) {
          this.$targetElement.collapse('hide');
        }
      }
    }

    cloneTriggerInTarget() {
      if (this.$targetElement.attr('id') === 'lqd-mobile-sec-nav' && $body.attr('data-mobile-nav-style') === 'modern' || this.options.cloneTriggerInTarget || this.$targetElement.hasClass('navbar-fullscreen')) {
        this.$clonedTrigger = this.$element.clone(true).prependTo(this.$targetElement);
      }
    }

    cloneTargetInBody() {
      if (this.$targetElement.attr('id') === 'lqd-mobile-sec-nav' && $body.attr('data-mobile-nav-style') === 'modern') {
        this.$targetElement.children('.main-nav, .header-module').wrapAll('<div class="navbar-collapse-inner"></div>');
      }
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('toggle-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('[data-ld-toggle]').liquidToggle();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidResponsiveBG';
  let defaults = {};

  class Plugin {
    constructor(element, options) {
      this.element = element;
      this.$element = $(element);
      this.options = $.extend({}, defaults, options);
      this._defaults = defaults;
      this._name = pluginName;
      this.targetImage = null;
      this.targetImage = this.element.querySelector('img');
      this.init();
    }

    init() {
      if (typeof undefined === typeof this.targetImage || null === this.targetImage) {
        console.error('There should be an image to get the source from it.');
        return false;
      }

      this.setBgImage();
      imagesLoaded(this.targetImage).on('done', this.onLoad.bind(this));
    }

    getCurrentSrc() {
      let imageSrc = this.targetImage.currentSrc ? this.targetImage.currentSrc : this.targetImage.src;

      if (/data:image\/svg\+xml/.test(imageSrc)) {
        imageSrc = this.targetImage.dataset.src;
      }

      return imageSrc;
    }

    setBgImage() {
      this.$element.css({
        backgroundImage: `url( ${this.getCurrentSrc()} )`
      });
    }

    reInitparallaxBG() {
      const parallaxFigure = this.$element.children('.lqd-parallax-container').find('.lqd-parallax-figure');

      if (parallaxFigure.length) {
        parallaxFigure.css({
          backgroundImage: `url( ${this.getCurrentSrc()} )`
        });
      }
    }

    onLoad() {
      this.reInitparallaxBG();
      this.$element.addClass('loaded');
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('responsive-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  if (!$liquidBody.hasClass('lazyload-enabled')) {
    $('[data-responsive-bg=true]').liquidResponsiveBG();
  }
});
(function ($) {
  'use strict';

  const contentsIsLiquidBg = $liquidContents.length && $liquidContents[0].getAttribute('data-liquid-bg-options');
  const contentsInteractWithHeader = contentsIsLiquidBg && (JSON.parse(contentsIsLiquidBg).interactWithHeader === true || JSON.parse(contentsIsLiquidBg).interactWithHeader === 'true');
  const pluginName = 'liquidStickyHeader';
  let defaults = {
    stickyTrigger: 'this',
    dynamicColors: false,
    disableOnMobile: false,
    smartSticky: false
  };

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.DOM = {
        element: element,
        $element: $(element),
        $stickySections: null,
        sentinel: null,
        placeholder: null,
        $stickyElements: null
      };
      this.DOM.$stickySections = liquidIsElementor ? $('> .elementor:not(.lqd-mobile-sec) > .elementor-section, > .elementor:not(.lqd-mobile-sec) > .e-container, > .elementor:not(.lqd-mobile-sec) > .e-con', element).not('.lqd-hide-onstuck, .lqd-stickybar-wrap') : $('.lqd-head-sec-wrap', element).not('.lqd-hide-onstuck');
      this.isInTitlebar = this.DOM.element.parentElement.classList.contains('titlebar');
      this.isOverlay = this.DOM.element.classList.contains('main-header-overlay');
      this.DOM.sentinel = null;
      this.DOM.placeholder = this.DOM.$element.prev('.lqd-sticky-placeholder')[0];
      this.DOM.$stickyElements = this.getStickyElements();
      this.stickyElsDetails = null;
      this.stickySectionsHeight = 0;
      this.smartStickyStuff = {
        state: null,
        prevScrollY: 0,
        scrolledDistance: 0,
        tolerance: {
          up: 25,
          down: 3
        },
        toleranceExceeded: false
      };
      this.wasStuck = false;
      this.isStuck = false;
      this.init();
    }

    async init() {
      await this.addSentinel();
      !this.DOM.placeholder && (await this.addPlaceholder());
      await this.getStickySectionsHeight();
      await this.getStickyElsDetails();
      this.DOM.element.setAttribute('data-sticky-values-measured', 'true');
      this.sentinelIO();
      this.headerIO();
      this.addStickySectionsHeight();
      this.initDynamicColors();
      this.handleResizeEvents();
      this.eventListeners();
    }

    eventListeners() {
      document.addEventListener('lqd-header-sticky-change', e => {
        const isStuck = e.detail.stuck;
        this.updateStickyStates(isStuck);
        this.isStuck && this.addStickySectionsHeight();
      });

      if (this.options.smartSticky) {
        $liquidWindow.on('scroll.lqdSmartStickyHeader', this.handleSmartSticky.bind(this));
      }
    }

    updateStickyStates(isStuck) {
      fastdom.mutate(() => {
        this.wasStuck = this.isStuck;
        this.isStuck = isStuck;
        this.DOM.element.classList.toggle('is-stuck', this.isStuck);
        this.DOM.element.classList.toggle('is-not-stuck', !this.isStuck);

        if (!this.isOverlay || this.isInTitlebar) {
          this.DOM.placeholder.classList.toggle('d-none', !this.isStuck);
        }

        ;

        if (this.options.smartSticky) {
          if (!this.isStuck) {
            this.smartStickyStuff.state = null;
            this.DOM.element.classList.remove('lqd-smart-sticky-show', 'lqd-smart-sticky-hide', 'lqd-just-stuck');
          } else {
            this.DOM.element.classList.add('lqd-smart-sticky-hide');

            if (!this.wasStuck) {
              this.DOM.element.classList.add('lqd-just-stuck');
            }
          }
        }
      });
    }

    async getStickySectionsHeight() {
      const promises = [];
      this.DOM.$stickySections.each((i, el) => {
        const promise = new Promise(resolve => {
          fastdom.measure(() => {
            new IntersectionObserver(([entry], observer) => {
              observer.disconnect();
              resolve(entry.boundingClientRect);
            }).observe(el);
          });
        });
        promises.push(promise);
      });
      const rects = await Promise.all(promises);
      rects.forEach(rect => this.stickySectionsHeight += rect.height);
    }

    addStickySectionsHeight() {
      fastdomPromised.mutate(() => {
        document.body.style.setProperty('--lqd-sticky-header-height', `${this.stickySectionsHeight}px`);
      });
    }

    addPlaceholder() {
      return fastdomPromised.mutate(() => {
        const placeholder = document.createElement('div');
        placeholder.setAttribute('class', 'lqd-sticky-placeholder d-none');
        this.DOM.placeholder = placeholder;
        this.DOM.element.before(placeholder);
      });
    }

    addSentinel() {
      return fastdomPromised.mutate(() => {
        const sentinelTemplate = document.querySelector('#lqd-temp-sticky-header-sentinel');
        const sentinel = sentinelTemplate.content.firstElementChild.cloneNode(true);
        const {
          stickyTrigger
        } = this.options;
        const firstRow = document.body.classList.contains('single-post') ? document.querySelector('.lqd-post-cover') : $liquidSections.filter(':visible').first()[0];
        let trigger = document.body;

        if (stickyTrigger === 'first-section') {
          const titlebar = document.querySelector('.titlebar');

          if (titlebar) {
            trigger = titlebar;
          } else if (firstRow && !firstRow.parentElement.classList.contains('main-footer')) {
            trigger = firstRow;
          } else {
            this.options.stickyTrigger = 'this';
          }
        }

        trigger.appendChild(sentinel);
        this.DOM.sentinel = sentinel;
      });
    }

    sentinelIO() {
      new IntersectionObserver(([entry]) => {
        fastdom.measure(() => {
          let targetInfo = entry.boundingClientRect;
          let rootBoundsInfo = entry.rootBounds;

          if (!rootBoundsInfo) {
            rootBoundsInfo = {
              top: 0,
              bottom: window.innerHeight
            };
          }

          if (!this.isStuck && rootBoundsInfo && targetInfo.bottom < rootBoundsInfo.top) {
            this.fireEvent('stickyChange', true);
          } else if (this.isStuck && rootBoundsInfo && targetInfo.bottom >= rootBoundsInfo.top && targetInfo.bottom < rootBoundsInfo.bottom) {
            this.fireEvent('stickyChange', false);
          }
        });
      }).observe(this.DOM.sentinel);
    }

    headerIO() {
      const {
        stickyTrigger
      } = this.options;
      fastdomPromised.measure(() => {
        const targetInfo = {
          height: this.DOM.element.offsetHeight
        };
        return targetInfo;
      }).then(({
        height,
        top
      }) => {
        fastdom.mutate(() => {
          document.body.style.setProperty('--lqd-sticky-header-placeholder-height', `${height}px`);

          if (stickyTrigger === 'this') {
            document.body.style.setProperty('--lqd-sticky-header-sentinel-top', `var(--lqd-sticky-header-placeholder-height)`);
          }
        });
      });
    }

    stickyVisibilityChange(state) {
      let classnamesToRemove = ['lqd-smart-sticky-hide', 'lqd-just-stuck'];
      let classnamesToAdd = ['lqd-smart-sticky-show'];

      if (state === 'hide') {
        classnamesToRemove = ['lqd-smart-sticky-show'];
        classnamesToAdd = ['lqd-smart-sticky-hide'];
      }

      this.smartStickyStuff.state = state;
      this.DOM.element.classList.remove(...classnamesToRemove);
      this.DOM.element.classList.add(...classnamesToAdd);
      this.fireEvent('stickyVisibility', state);
    }

    handleSmartSticky() {
      fastdomPromised.measure(() => {
        const {
          scrollY
        } = window;
        const scrollDirection = scrollY > this.smartStickyStuff.prevScrollY ? 'down' : 'up';
        return {
          scrollY,
          scrollDirection
        };
      }).then(({
        scrollY,
        scrollDirection
      }) => {
        this.smartStickyStuff.scrolledDistance = Math.abs(scrollY - this.smartStickyStuff.prevScrollY);
        fastdom.mutate(() => {
          if (this.isStuck && this.smartStickyStuff.toleranceExceeded) {
            if (scrollDirection === 'up' && this.smartStickyStuff.state !== 'show') {
              this.stickyVisibilityChange('show');
            } else if (scrollDirection === 'down' && this.smartStickyStuff.state !== 'hide') {
              this.stickyVisibilityChange('hide');
            }
          }

          this.smartStickyStuff.prevScrollY = scrollY;
          this.smartStickyStuff.toleranceExceeded = this.smartStickyStuff.scrolledDistance > this.smartStickyStuff.tolerance[scrollDirection];
        });
      });
    }

    fireEvent(type = 'stickyChange', state) {
      fastdom.mutate(() => {
        if (type === 'stickyChange') {
          document.dispatchEvent(new CustomEvent('lqd-header-sticky-change', {
            bubbles: false,
            detail: {
              stuck: state,
              target: this.DOM.element
            }
          }));
        }

        if (type === 'stickyVisibility') {
          document.dispatchEvent(new CustomEvent('lqd-header-sticky-visibility-change', {
            bubbles: false,
            detail: {
              state,
              target: this.DOM.element
            }
          }));
        }
      });
    }

    getStickyElements() {
      const $stickyModules = liquidIsElementor ? this.DOM.$element.find('> .elementor:not(.lqd-mobile-sec) > .elementor-section, > .elementor:not(.lqd-mobile-sec) > .e-container, > .elementor:not(.lqd-mobile-sec) > .e-con').not('.lqd-hide-onstuck').find('> .elementor-container > .elementor-column > .elementor-widget-wrap > [data-element_type="widget"], > .elementor-element').not('.elementor-widget-ld_modal_window') : this.DOM.$element.find('.lqd-head-sec-wrap, .lqd-stickybar-wrap').not('.lqd-hide-onstuck').find('.lqd-head-col > .header-module');
      const $elements = this.DOM.element.hasAttribute('data-liquid-bg') ? $stickyModules.add(this.DOM.$element).not('.navbar-brand-solid') : $stickyModules.add(this.DOM.$element);
      return $elements;
    }

    async getStickyElsDetails() {
      const promises = [];
      const windowWidth = liquidWindowWidth();
      this.DOM.$stickyElements.each((i, stickyEl) => {
        const promise = new Promise(resolve => {
          new IntersectionObserver(([entry], observer) => {
            fastdom.measure(() => {
              observer.disconnect();
              let {
                boundingClientRect
              } = entry;
              let obj = {};
              obj.el = entry.target;
              obj.moduleEl = stickyEl;
              let {
                x,
                y,
                width,
                height
              } = boundingClientRect;

              if (x < 0) {
                x = 0;
              } else if (x >= windowWidth) {
                x = windowWidth - width - entry.target.parentElement.offsetWidth;
              }

              if (y < 0) {
                y = y + window.scrollY;
              }

              obj.rect = {
                width,
                height,
                x,
                y
              };
              obj.currentColor = 'default';
              resolve(obj);
            });
          }).observe(stickyEl === this.DOM.element ? this.DOM.element : stickyEl);
        });
        promises.push(promise);
      });
      const stickyElDetailsArray = await Promise.all(promises);
      this.stickyElsDetails = stickyElDetailsArray;
    }

    getSections(visibleSections) {
      let sections = [];
      visibleSections.forEach(sec => {
        let section = sec;

        if (sec.isInnerSection) {
          section = sec.parentSection;
          if (!section) return;
          const sectionBgcolor = sec.backgroundColor.replace(/, /g, ',').split(' ')[0];
          const parentBgColor = section.backgroundColor.replace(/, /g, ',').split(' ')[0];
          const sectionBgAlpha = tinycolor(sectionBgcolor).getAlpha();
          const parentBgAlpha = tinycolor(parentBgColor).getAlpha();

          if ((sectionBgAlpha !== 0 || sec.predefinedLuminosity) && parentBgAlpha === 0) {
            section = sec;
            sections = sections.filter(sect => sect.el !== section.parentSection.el);
          }
        }

        const sectionExists = sections.some(sect => sect.el === section.el);
        !sectionExists && sections.push(section);
      });
      return sections;
    }

    initDynamicColors() {
      if (!this.options.dynamicColors || contentsInteractWithHeader) return;
      LiquidSectionsDetails.getDetails().then(lqdSections => {
        const visibleSections = lqdSections.filter(sec => !sec.isHidden);
        const sections = this.getSections(visibleSections);
        const onscroll = liquidThrottle(this.onScroll.bind(this, sections), 150, {
          leading: true
        });
        this.onScroll(sections);
        $liquidWindow.off('scroll.lqdStickyHeader');
        $liquidWindow.on('scroll.lqdStickyHeader', onscroll);
      });
    }

    onScroll(sections) {
      for (let sectionsItterator = 0; sectionsItterator < sections.length; sectionsItterator++) {
        fastdomPromised.measure(() => {
          const sec = sections[sectionsItterator];
          const rect = { ...sec.rect
          };
          rect.y = rect.initialOffset.y - window.scrollY;
          rect.x = rect.initialOffset.x - window.scrollX;

          for (let stickyItterator = 0; stickyItterator < this.stickyElsDetails.length; stickyItterator++) {
            if (this.isCollide(this.stickyElsDetails[stickyItterator].rect, rect)) {
              this.changeAttrs(sec, this.stickyElsDetails[stickyItterator]);
            }
          }
        });
      }
    }

    changeAttrs(rowObj, moduleObj) {
      const {
        luminosity
      } = rowObj;
      const {
        moduleEl
      } = moduleObj;
      fastdom.mutate(() => {
        if (luminosity === 'light' && moduleObj.currentColor !== 'dark') {
          moduleObj.currentColor = 'dark';
          moduleEl.classList.add('lqd-active-row-light');
          moduleEl.classList.remove('lqd-active-row-dark');
        } else if (luminosity === 'dark' && moduleObj.currentColor !== 'light') {
          moduleObj.currentColor = 'light';
          moduleEl.classList.add('lqd-active-row-dark');
          moduleEl.classList.remove('lqd-active-row-light');
        }
      });
    }

    isCollide(a, b) {
      return !(a.y + a.height < b.y || a.y > b.y + b.height || a.x + a.width < b.x || a.x + a.width / 2 > b.x + b.width);
    }

    handleResizeEvents() {
      $liquidWindow.on('resize', this.onResize.bind(this));
      $(document).on('lqd-masonry-layout-init', this.onResize.bind(this));
    }

    onResize() {
      this.headerIO();
      this.initDynamicColors();
    }

    drawIndicators(sec) {
      const $indicator = $(`<div class="lqd-section-ind pos-abs pointer-events-none" style="width: ${sec.rect.width}px; height: ${sec.rect.height}px; border: 3px solid red; top: ${sec.rect.y}px; left: ${sec.rect.x}px; z-index: 10;"><span style="display: inline-block; background: var(--color-primary); color: #fff; padding: 0.35em 1em;">${sec.luminosity}</span></div>`);
      $indicator.appendTo($liquidBody);
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('sticky-options'),
        ...options
      };
      if (pluginOptions.disableOnMobile && liquidIsMobile()) return;

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  const $stickyHeader = $('[data-sticky-header]');
  const pageStackEnabled = $liquidContents[0].hasAttribute('data-liquid-stack');
  const pageStackDisabledOnMobile = pageStackEnabled && $liquidContents[0].hasAttribute('data-stack-options') && JSON.parse($liquidContents[0].getAttribute('data-stack-options')).disableOnMobile === true;

  if ($liquidContents.length) {
    if (!pageStackEnabled || pageStackEnabled && liquidIsMobile() && pageStackDisabledOnMobile) {
      $stickyHeader.liquidStickyHeader();
    } else if ($liquidContents[0].hasAttribute('data-liquid-stack')) {
      $stickyHeader.attr('data-sticky-values-measured', 'true');
    }
  }
});
(function ($) {
  'use strict';

  const pluginName = 'liquidStickyFooter';
  let defaults = {
    shadow: 0,
    parallax: false
  };

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.element = element;
      this.$element = $(element);
      this.footerHeight = 0;
      this.windowWidth = fastdom.measure(() => window.innerWidth)();
      this.windowHeight = fastdom.measure(() => window.innerHeight)();
      this.init();
    }

    measure() {
      return fastdomPromised.measure(() => {
        if (this.windowWidth < 768) {
          this.footerHeight = 0;
        } else {
          this.footerHeight = this.element.offsetHeight - 2;
          this.windowWidth = window.innerWidth;
          this.windowHeight = window.innerHeight;
        }
      });
    }

    init() {
      imagesLoaded(this.element, async () => {
        await this.measure();
        this.addMargin();

        this._addShadow();

        this._handleResize();
      });
    }

    addMargin() {
      fastdomPromised.mutate(() => {
        if (this.footerHeight >= this.windowHeight) {
          return this.$element.addClass('lqd-footer-cant-stick');
        }
      });
    }

    _addShadow() {
      const {
        shadow
      } = this.options;

      if (shadow > 0) {
        document.body.classList.add(`lqd-sticky-footer-shadow-${shadow}`);
      }
    }

    _handleResize() {
      const onResize = liquidDebounce(this._onResize.bind(this), 400);
      $liquidWindow.on('resize', onResize);
    }

    async _onResize() {
      await this.measure();
      this.addMargin();
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('sticky-footer-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  if (liquidIsMobile()) return;
  $('[data-sticky-footer=true]').liquidStickyFooter();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidCustomCursor';
  let defaults = {
    outerCursorSpeed: 0.2,
    outerCursorHide: false
  };

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.clientX = -100;
      this.clientY = -100;
      this.magneticCords = {
        x: 0,
        y: 0
      };
      this.element = element;
      this.$element = $(element);
      this.initiated = false;
      this.innerCursor = document.querySelector(".lqd-cc--inner");
      this.outerCursor = document.querySelector(".lqd-cc--outer");
      this.dragCursor = document.querySelector(".lqd-cc-drag");
      this.exploreCursor = document.querySelector(".lqd-cc-explore");
      this.arrowCursor = document.querySelector(".lqd-cc-arrow");
      this.iconCursor = document.querySelector(".lqd-cc-custom-icon");
      this.cursorEls = document.querySelectorAll(".lqd-cc--el");
      this.extraCursors = document.querySelectorAll(".lqd-extra-cursor");
      this.lastMovedOtherEl = null;
      this.lastMovedOtherInnerEl = null;
      this.scaleOuterCursor = null;
      this.scaleOuterCursorX = null;
      this.scaleOuterCursorY = null;
      this.activeEl = null;
      const outerSize = window.liquidParams?.ccOuterSize || getComputedStyle(document.body).getPropertyValue('--lqd-cc-size-outer');
      this.outerCursorSize = parseInt(outerSize || 0, 10);
      this.activeCircleBg = window.liquidParams?.ccActiveCircleBg || getComputedStyle(document.body).getPropertyValue('--lqd-cc-active-bg');
      this.activeCircleBc = window.liquidParams?.ccActiveCircleBc || getComputedStyle(document.body).getPropertyValue('--lqd-cc-active-bc');
      this.innerQuickSetX = gsap.quickSetter(this.innerCursor, 'x', 'px');
      this.innerQuickSetY = gsap.quickSetter(this.innerCursor, 'y', 'px');
      this.outerQuickToX = gsap.quickTo(this.outerCursor, 'x', {
        duration: this.options.outerCursorSpeed
      });
      this.outerQuickToY = gsap.quickTo(this.outerCursor, 'y', {
        duration: this.options.outerCursorSpeed
      });
      this.extrasQuickToX = gsap.quickTo([...this.cursorEls, ...this.extraCursors], 'x', {
        duration: 0.1
      });
      this.extrasQuickToY = gsap.quickTo([...this.cursorEls, ...this.extraCursors], 'y', {
        duration: 0.1
      });
      this.init();
    }

    init() {
      if (this.options.outerCursorHide) {
        $liquidHtml.addClass('lqd-cc-outer-hidden');
      }

      this.initCursor();
      this.initHovers();
      document.body.classList.add('lqd-cc-init');
    }

    initCursor() {
      const pos = {
        x: window.innerWidth / 2,
        y: window.innerHeight / 2
      };
      document.addEventListener("mousemove", e => {
        this.clientX = e.clientX;
        this.clientY = e.clientY;
      });
      gsap.ticker.add(() => {
        if (!this.initiated) {
          this.initiated = true;
          this.fadeOutInnerCursor = false;
          this.fadeOutInnerCursor = false;
        }

        const dt = 1.0 - Math.pow(1.0 - 0.4, gsap.ticker.deltaRatio());
        pos.x += (this.clientX - pos.x) * dt;
        pos.y += (this.clientY - pos.y) * dt;
        this.innerQuickSetX(pos.x);
        this.innerQuickSetY(pos.y);
        this.extrasQuickToX(this.clientX);
        this.extrasQuickToY(this.clientY);

        if (!this.isStuck && !this.isMagnetic) {
          this.outerQuickToX(this.clientX - this.outerCursorSize / 2);
          this.outerQuickToY(this.clientY - this.outerCursorSize / 2);
        }

        if (this.isStuck && this.activeEl) {
          const rect = this.activeEl.getBoundingClientRect();
          let {
            left,
            top,
            width,
            height
          } = rect;
          left += width / 2 - this.outerCursorSize / 2;
          top += height / 2 - this.outerCursorSize / 2;
          this.outerQuickToX(left);
          this.outerQuickToY(top);
        }

        if (this.isMagnetic) {
          this.outerQuickToX(this.magneticCords.x);
          this.outerQuickToY(this.magneticCords.y);
        }

        if (this.scaleOuterCursor) {
          gsap.to(this.outerCursor, {
            scaleX: () => this.scaleOuterCursorX || 1,
            scaleY: () => this.scaleOuterCursorY || 1
          });
        }

        if (this.fadeOutInnerCursor) {
          gsap.to(this.innerCursor, {
            opacity: 0
          });
        } else {
          gsap.to(this.innerCursor, {
            opacity: 1
          });
        }

        if (this.fadeOutOuterCursor) {
          gsap.to(this.outerCursor, {
            opacity: 0
          });
        } else {
          gsap.to(this.outerCursor, {
            opacity: 1
          });
        }
      });
    }

    initHovers() {
      document.addEventListener('lqd-carousel-initialized', e => {
        const {
          carouselData
        } = e.detail;
        const flkty = carouselData.flickityData;

        if (flkty.nextButton) {
          this.initCarouselNavCursor([flkty.nextButton.element, flkty.prevButton.element]);
        }

        ;
        if (!flkty.options.draggable) return;
        flkty.on('dragMove', e => {
          this.clientX = e.clientX;
          this.clientY = e.clientY;
        });
        flkty.on('pointerDown', () => {
          this.cursorEls.forEach(el => el.classList.add('lqd-carousel-pointer-down'));
        });
        flkty.on('pointerUp', () => {
          this.cursorEls.forEach(el => el.classList.remove('lqd-carousel-pointer-down'));
        });
        this.initSolidCircles(flkty.viewport, this.dragCursor);
      });
      this.initPageLinksCursor();
      this.initExtraCursor();
      this.initSolidCircles('.lqd-cc-label-trigger', this.exploreCursor);
      this.initArrowCursor('.lqd-dist-gal-menu a, .lqd-imgtxt-slider-link, .lqd-af-slide__link ~ a');
      this.initCustomIconCursor('.lqd-cc-icon-trigger', 'lqd-cc__active-icon');
      this.initButtonShapeCursors();
      this.initNavTriggerCursor();
      this.initMenuItemsCursor();
    }

    initPageLinksCursor() {
      const linksMouseEnter = () => {
        gsap.to(this.innerCursor, {
          scale: 2.25,
          backgroundColor: this.activeCircleBg,
          ease: 'power2.out'
        });
        gsap.to(this.outerCursor, {
          scale: 1.2,
          borderColor: this.activeCircleBc,
          ease: 'power2.out'
        });
      };

      const linksMouseLeave = () => {
        gsap.to(this.innerCursor, {
          scale: 1,
          backgroundColor: '',
          ease: 'power2.out'
        });
        gsap.to(this.outerCursor, {
          scale: 1,
          borderColor: '',
          ease: 'power2.out'
        });
      };

      const pageLinks = [...document.querySelectorAll("a")].filter(el => {
        return !el.classList.contains('lqd-cc-icon-trigger') && !el.classList.contains('lqd-cc-label-trigger') && !el.classList.contains('lqd-imgtxt-slider-link') && !el.closest('.carousel-items') && !el.closest('.lqd-slsh-alt') && !el.closest('.lqd-dist-gal-menu') && !$(el).siblings('.lqd-af-slide__link').length;
      });
      pageLinks.forEach(item => {
        item.addEventListener("mouseenter", linksMouseEnter);
        item.addEventListener("mouseleave", linksMouseLeave);
      });
    }

    initCarouselNavCursor(navElementsArray) {
      const carouselNavEnter = (navEl, navElStyle) => {
        this.activeEl = navEl;
        this.isStuck = true;
        this.scaleOuterCursor = true;
        this.fadeOutInnerCursor = true;
        gsap.to(this.outerCursor, {
          borderColor: navElStyle.borderColor,
          borderRadius: navElStyle.borderRadius
        });
        this.moveOtherElements(navEl, [...navEl.querySelectorAll('i'), ...navEl.querySelectorAll('svg')], true);
      };

      const carouselNavLeave = () => {
        this.activeEl = null;
        this.isStuck = false;
        this.fadeOutInnerCursor = false;
        gsap.to(this.outerCursor, {
          borderColor: '',
          borderRadius: ''
        });
        this.moveOtherElements();
      };

      navElementsArray.forEach(item => {
        fastdomPromised.measure(() => {
          const navElStyle = getComputedStyle(item);
          return {
            navElStyle
          };
        }).then(({
          navElStyle
        }) => {
          item.addEventListener("mouseenter", carouselNavEnter.bind(this, item, navElStyle));
          item.addEventListener("mouseleave", carouselNavLeave.bind(this));
          item.addEventListener('click', e => {
            const timeout = setTimeout(() => {
              if (item.disabled) {
                carouselNavLeave();
              }

              clearTimeout(timeout);
            }, 10);
          });
        });
      });
    }

    initExtraCursor() {
      const extraCursorEnter = extraCursor => {
        this.fadeOutInnerCursor = true;
        this.fadeOutOuterCursor = true;
        extraCursor.classList.add('lqd-is-active');
        gsap.to(extraCursor, {
          scale: 1,
          opacity: 1,
          duration: 0.65,
          ease: 'expo.out'
        });
      };

      const extraCursorLeave = extraCursor => {
        this.fadeOutInnerCursor = false;
        this.fadeOutOuterCursor = false;
        extraCursor.classList.remove('lqd-is-active');
        gsap.to(extraCursor, {
          scale: 0.15,
          opacity: 0,
          duration: 0.65,
          ease: 'expo.out'
        });
      };

      this.extraCursors.forEach(item => {
        const itemParent = item.parentElement;
        itemParent.addEventListener("mousemove", extraCursorEnter.bind(this, item));
        itemParent.addEventListener("mouseleave", extraCursorLeave.bind(this, item));
      });
    }

    initSolidCircles(selectors, elementSetActiveClassname) {
      if (!selectors) return;

      const solidCircleEnter = () => {
        this.fadeOutInnerCursor = true;
        this.fadeOutOuterCursor = true;
        elementSetActiveClassname.classList.add('lqd-is-active');
      };

      const solidCircleLeavve = () => {
        this.fadeOutInnerCursor = false;
        this.fadeOutOuterCursor = false;
        elementSetActiveClassname.classList.remove('lqd-is-active');
      };

      const init = item => {
        item.addEventListener("mouseenter", solidCircleEnter);
        item.addEventListener("mouseleave", solidCircleLeavve);
      };

      if (typeof selectors === 'string') {
        document.querySelectorAll(selectors).forEach(item => init(item));
      } else {
        init(selectors);
      }
    }

    initArrowCursor(selectors) {
      const onEnter = () => {
        this.fadeOutInnerCursor = true;
        this.fadeOutOuterCursor = true;
        this.arrowCursor.classList.add('lqd-is-active');
      };

      const onLeave = () => {
        this.fadeOutInnerCursor = false;
        this.fadeOutOuterCursor = false;
        this.arrowCursor.classList.remove('lqd-is-active');
      };

      const init = item => {
        item.addEventListener("mouseenter", onEnter);
        item.addEventListener("mouseleave", onLeave);
      };

      if (typeof selectors === 'string') {
        document.querySelectorAll(selectors).forEach(item => init(item));
      } else {
        init(selectors);
      }
    }

    initCustomIconCursor(selectors) {
      const onEnter = color => {
        this.fadeOutInnerCursor = true;
        this.fadeOutOuterCursor = true;
        color && this.iconCursor.style.setProperty('--cc-icon-color', color);
        this.iconCursor.classList.add('lqd-is-active');
      };

      const onLeave = () => {
        this.fadeOutInnerCursor = false;
        this.fadeOutOuterCursor = false;
        this.iconCursor.style.removeProperty('--cc-icon-color');
        this.iconCursor.classList.remove('lqd-is-active');
      };

      document.querySelectorAll(selectors).forEach(item => {
        const color = item.getAttribute('data-cc-icon-color');
        item.addEventListener("mouseenter", onEnter.bind(this, color));
        item.addEventListener("mouseleave", onLeave);
      });
    }

    initButtonShapeCursors() {
      const buttonShapeEnter = (icon, iconStyles) => {
        this.isMagnetic = true;
        this.scaleOuterCursor = true;
        this.fadeOutInnerCursor = true;
        gsap.to(this.outerCursor, {
          borderColor: iconStyles.borderColor,
          borderRadius: iconStyles.borderRadius
        });
        this.moveOtherElements(icon, [...icon.querySelectorAll('i'), ...icon.querySelectorAll('svg')]);
      };

      const buttonShapeLeave = () => {
        this.isMagnetic = false;
        this.fadeOutInnerCursor = false;
        gsap.to(this.outerCursor, {
          borderColor: '',
          borderRadius: ''
        });
        this.moveOtherElements();
      };

      const buttonWithIcon = document.querySelectorAll('.btn-icon-shaped');
      buttonWithIcon.forEach(btn => {
        const icon = btn.querySelector('.btn-icon');
        if (!icon) return;
        fastdomPromised.measure(() => {
          const iconStyles = getComputedStyle(icon);
          return {
            iconStyles
          };
        }).then(({
          iconStyles
        }) => {
          btn.addEventListener("mouseenter", buttonShapeEnter.bind(this, icon, iconStyles));
          btn.addEventListener("mouseleave", buttonShapeLeave.bind(this));
        });
      });
    }

    initNavTriggerCursor() {
      const navTriggerEnter = (outerEl, innerEl) => {
        this.isMagnetic = true;
        this.scaleOuterCursor = true;
        this.fadeOutInnerCursor = true;
        this.fadeOutOuterCursor = true;
        this.moveOtherElements(outerEl, innerEl);
      };

      const navTriggerLeave = () => {
        this.isMagnetic = false;
        this.fadeOutInnerCursor = false;
        this.fadeOutOuterCursor = false;
        this.moveOtherElements();
      };

      const navTriggers = document.querySelectorAll('.nav-trigger');
      const moduleTriggers = document.querySelectorAll('.ld-module-trigger');
      navTriggers.forEach(navTrigger => {
        const $navTrigger = $(navTrigger);
        const bars = navTrigger.querySelector('.bars');
        const barsInner = navTrigger.querySelector('.bars-inner');
        const toggleData = $navTrigger.data('plugin_liquidToggle');

        if (toggleData && toggleData.options.type !== 'hover') {
          navTrigger.addEventListener("mouseenter", navTriggerEnter.bind(this, bars, barsInner));
          navTrigger.addEventListener("mouseleave", navTriggerLeave);
        }
      });
      moduleTriggers.forEach(moduleTrigger => {
        const $moduleTrigger = $(moduleTrigger);
        const txt = moduleTrigger.querySelector('.ld-module-trigger-txt');
        const icon = moduleTrigger.querySelector('.ld-module-trigger-icon');
        const toggleData = $moduleTrigger.data('plugin_liquidToggle');

        if (toggleData && toggleData.options.type !== 'hover') {
          moduleTrigger.addEventListener("mouseenter", () => {
            navTriggerEnter(moduleTrigger, txt);
            navTriggerEnter(moduleTrigger, icon);
          });
          moduleTrigger.addEventListener("mouseleave", navTriggerLeave);
        }
      });
    }

    initMenuItemsCursor() {
      const menuItemEnter = menuItem => {
        this.moveOtherElements(menuItem);
      };

      const menuItemLeave = () => {
        this.moveOtherElements();
      };

      const magneticMenuItems = document.querySelectorAll('.lqd-magnetic-items');
      magneticMenuItems.forEach(el => {
        const ul = el.querySelector('ul');
        const menuItems = ul.querySelectorAll(':scope > li > a');
        menuItems.forEach(menuItem => {
          menuItem.addEventListener("mouseenter", menuItemEnter.bind(this, menuItem));
          menuItem.addEventListener("mouseleave", menuItemLeave.bind(this));
        });
      });
    }

    moveOtherElements(movingEl, innerMovingEl, onlyMoveInnerEl) {
      let movingElRect = null;

      if (!movingEl) {
        this.lastMovedOtherEl && gsap.to(this.lastMovedOtherEl, {
          duration: 0.4,
          x: 0,
          y: 0,
          clearProps: 'all'
        });
        this.lastMovedOtherInnerEl && gsap.to(this.lastMovedOtherInnerEl, {
          duration: 0.35,
          x: 0,
          y: 0,
          clearProps: 'all'
        });
        this.scaleOuterCursor = null;
        this.scaleOuterCursorX = null;
        this.scaleOuterCursorY = null;
        $liquidWindow.off('mousemove.lqdCCMoveOthers');
        return;
      }

      ;
      this.lastMovedOtherEl = movingEl;
      this.lastMovedOtherInnerEl = innerMovingEl;
      $liquidWindow.on('mousemove.lqdCCMoveOthers', e => {
        !movingElRect && (movingElRect = movingEl.getBoundingClientRect());
        const dist = {
          x: movingElRect.left + movingElRect.width / 2 - this.clientX,
          y: movingElRect.top + movingElRect.height / 2 - this.clientY
        };
        const angle = Math.atan2(dist.x, dist.y);
        const hypotenuse = Math.sqrt(dist.x * dist.x + dist.y * dist.y);
        this.magneticCords = {
          x: movingElRect.left + movingElRect.width / 2 - this.outerCursorSize / 2 - Math.sin(angle) * hypotenuse / 3,
          y: movingElRect.top + movingElRect.width / 2 - this.outerCursorSize / 2 - Math.cos(angle) * hypotenuse / 3
        };
        !onlyMoveInnerEl && gsap.to(movingEl, {
          duration: 0.4,
          x: -(Math.sin(angle) * hypotenuse) / 8,
          y: -(Math.cos(angle) * hypotenuse) / 8
        });
        innerMovingEl && gsap.to(innerMovingEl, {
          duration: 0.35,
          x: -(Math.sin(angle) * hypotenuse) / 8,
          y: -(Math.cos(angle) * hypotenuse) / 8
        });

        if (this.scaleOuterCursor) {
          this.scaleOuterCursorX = movingElRect.width / this.outerCursorSize;
          this.scaleOuterCursorY = movingElRect.height / this.outerCursorSize;
        }
      });
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('cc-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  if (liquidIsMobile() || 'elementorFrontend' in window && elementorFrontend.isEditMode()) return;

  const addCustomCursorMarkup = () => {
    const $elements = $('[data-lqd-custom-cursor]');
    $elements.each((i, el) => {
      const $ccSpan = $(`<span class="lqd-extra-cursor pos-fix pointer-events-none"></span>`);
      $(el).prepend($ccSpan);
    });
  };

  addCustomCursorMarkup();
  $('[data-lqd-cc]').liquidCustomCursor();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidAccordion';
  let defaults = {};

  function Plugin(element, options) {
    this.element = element;
    this.$element = $(element);
    this.options = $.extend({}, defaults, options);
    this._defaults = defaults;
    this._name = pluginName;
    this.init();
  }

  Plugin.prototype = {
    init: function () {
      this.setHashOnLoad();
      this.eventHandlers();
    },
    setHashOnLoad: function () {
      const element = $(this.element);

      if (location.hash !== '' && element.find(location.hash).length) {
        const activeItemParent = element.find(location.hash).closest('.accordion-item');
        activeItemParent.find(location.hash).addClass('in');
        activeItemParent.find('.accordion-heading').find('a').attr('aria-expanded', 'true').removeClass('collapsed');
        activeItemParent.siblings().find('.in').removeClass('in');
        activeItemParent.siblings().find('.accordion-heading').find('a').attr('aria-expanded', 'false').addClass('collapsed');
      }
    },
    eventHandlers: function () {
      this.$element.find('.accordion-collapse').on('show.bs.collapse', event => {
        this.onShow.call(this, event);
      });
      this.$element.find('.accordion-collapse').on('shown.bs.collapse', event => {
        this.onShown.call(this, event);
      });
      this.$element.find('.accordion-collapse').on('hide.bs.collapse', event => {
        this.onHide.call(this, event);
      });
    },
    onShow: function (event) {
      this.toggleActiveClass(event, 'show');
      this.setHashOnLoad(event);
      const $collapse = $(event.target);

      if ($collapse.closest('.vc_vc_accordion_tab').length) {
        $collapse.closest('.vc_vc_accordion_tab').siblings().find('.accordion-collapse').collapse('hide');
      }
    },

    onHide(event) {
      this.toggleActiveClass(event, 'hide');
    },

    toggleActiveClass(event, state) {
      const parent = $(event.target).closest('.accordion-item');

      if (state === 'show') {
        parent.addClass('active').siblings().removeClass('active');
      }

      if (state === 'hide') {
        parent.removeClass('active');
      }
    },

    setHashOnShow(event) {
      if (history.pushState) {
        history.pushState(null, null, '#' + $(event.target).attr('id'));
      } else {
        location.hash = '#' + $(event.target).attr('id');
      }
    },

    onShown: function (event) {
      const collapse = $(event.target);
      const $parent = collapse.closest('.accordion-item');
      const $window = $(window);
      const parentOffsetTop = $parent.offset().top;
      this.initPlugins($parent);

      if (parentOffsetTop <= $window.scrollTop() - 15) {
        $('html, body').animate({
          scrollTop: parentOffsetTop - 45
        }, 800);
      }
    },

    initPlugins($shownAccordionItem) {
      $('[data-split-text]', $shownAccordionItem).liquidSplitText();
    },

    destroy() {
      this.$element.find('.accordion-collapse').off('show.bs.collapse shown.bs.collapse hide.bs.collapse');
    }

  };

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('accordion-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('.accordion').liquidAccordion();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidAjaxLoadMore';
  let defaults = {
    trigger: "inview"
  };

  class Plugin {
    constructor(element, options) {
      this.element = element;
      this.$element = $(element);
      this.options = $.extend({}, defaults, options);
      this._defaults = defaults;
      this._name = pluginName;
      this.observer = null;
      this.init();
    }

    init() {
      const {
        trigger
      } = this.options;
      trigger == 'inview' && this.setupIntersectionObserver();
      trigger == 'click' && this.onClick();
    }

    onClick() {
      this.$element.on('click', this.loadItems.bind(this));
    }

    setupIntersectionObserver() {
      this.observer = new IntersectionObserver(enteries => {
        enteries.forEach(entery => {
          if (entery.isIntersecting) {
            this.loadItems();
          }
        });
      }, {
        threshold: [1]
      });
      this.observer.observe(this.element);
    }

    loadItems(event) {
      event && event.preventDefault();
      const self = this;
      const options = self.options;
      const target = self.$element.attr('href');
      self.$element.addClass('items-loading');
      $.ajax({
        type: 'GET',
        url: target,
        error: function (MLHttpRequest, textStatus, errorThrown) {
          alert(errorThrown);
        },
        success: function (data) {
          const $data = $(data);
          const $newItemsWrapper = $data.find(options.wrapper);
          const $newItems = $newItemsWrapper.find(options.items);
          const $wrapper = $(options.wrapper);
          const nextPageUrl = $data.find('[data-ajaxify=true]').attr('href');
          imagesLoaded($newItems.get(), function () {
            if (nextPageUrl && target != nextPageUrl) {
              self.$element.attr('href', nextPageUrl);
            } else {
              self.observer && self.observer.unobserve(self.element);
              self.$element.removeClass('items-loading').addClass('all-items-loaded');
            }

            $newItems.appendTo($wrapper);

            if ($wrapper.get(0).hasAttribute('data-liquid-masonry')) {
              const pluginData = $wrapper.data('plugin_liquidMasonry');
              const isoData = pluginData && pluginData.isoData;
              isoData && isoData.appended($newItems);
            }

            self.onSuccess($wrapper);
          });
        }
      });
    }

    onSuccess($wrapper) {
      if (!$('body').hasClass('lazyload-enabled')) {
        $('[data-responsive-bg=true]', $wrapper).liquidResponsiveBG();
      }

      if ($('body').hasClass('lazyload-enabled')) {
        window.liquidLazyload = new LazyLoad({
          elements_selector: '.ld-lazyload',
          callback_loaded: e => {
            $(e).closest('[data-responsive-bg=true]').liquidResponsiveBG();
            $(e).parent().not('#wrap, #lqd-site-content').addClass('loaded');
          }
        });
      }

      $('[data-split-text]', $wrapper).filter((i, element) => !$(element).parents('[data-custom-animations]').length && !element.hasAttribute('data-custom-animations')).liquidSplitText();
      $('[data-fittext]', $wrapper).liquidFitText();
      $('[data-custom-animations]', $wrapper).map((i, element) => {
        const $element = $(element);
        const $customAnimationParent = $element.parents('.wpb_wrapper[data-custom-animations]');

        if ($customAnimationParent.length) {
          $element.removeAttr('data-custom-animations');
          $element.removeAttr('data-ca-options');
        }
      });
      $('[data-custom-animations]', $wrapper).filter((i, element) => {
        const $element = $(element);
        const $rowBgparent = $element.closest('.vc_row[data-row-bg]');
        const $slideshowBgParent = $element.closest('.vc_row[data-slideshow-bg]');
        return !$rowBgparent.length && !$slideshowBgParent.length;
      }).liquidCustomAnimations();
      $('[data-lqd-flickity]', $wrapper).liquidCarousel();
      $('[data-parallax]', $wrapper).liquidParallax();
      $('[data-hover3d=true]', $wrapper).liquidHover3d();
      this.$element.removeClass('items-loading');
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('ajaxify-options'),
        options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  if ($('body').hasClass('compose-mode')) return false;
  $('[data-ajaxify=true]').liquidAjaxLoadMore();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidAnimatedFrames';
  let defaults = {
    current: 0,
    scrollable: false,
    forceDisablingWindowScroll: false,
    autoplay: false,
    autoplayTimeout: 4000
  };

  class Plugin {
    constructor(element, options) {
      this.element = element;
      this.$element = $(element);
      this.options = $.extend({}, defaults, options);
      this._defaults = defaults;
      this._name = pluginName;
      this.DOM = {};
      this.DOM.el = element;
      this.DOM.slides = Array.from(this.DOM.el.querySelectorAll('.lqd-af-slides > div'));
      this.DOM.nav = this.DOM.el.querySelector('.lqd-af-slidenav');
      this.DOM.nums = this.DOM.el.querySelector('.lqd-af-slidenum');
      this.DOM.numsCurrent = this.DOM.el.querySelector('.lqd-af-slidenum__current');
      this.DOM.numsTotal = this.DOM.el.querySelector('.lqd-af-slidenum__total');
      this.DOM.nextCtrl = this.DOM.nav.querySelector('.lqd-af-slidenav__item--next');
      this.DOM.prevCtrl = this.DOM.nav.querySelector('.lqd-af-slidenav__item--prev');
      this.slidesTotal = this.DOM.slides.length;
      this.current = this.options.current;
      this.startY = 0;
      this.currentY = 0;
      this.dragY = 0;
      this.userInteracted = false;
      this.autoplayTimeout = null;
      this.init();
      this.animateNumbers();
      this.initEvents();
      this.autoplay();
    }

    init() {
      const currentSlide = this.DOM.slides[this.current];
      currentSlide.classList.add('lqd-af-slide--current');
      this.DOM.el.classList.add('lqd-af--initial');
      this.onSlideLoaded(currentSlide);
    }

    animateNumbers(i = 0) {
      this.DOM.numsCurrent.querySelector('span').style.transform = `translateY(${i * 100 * -1}%)`;
    }

    initEvents() {
      if (this.slidesTotal <= 1) return;
      $(this.DOM.nextCtrl).off('click.lqdAnimateFrames', this.navigate);
      $(this.DOM.prevCtrl).off('click.lqdAnimateFrames', this.navigate);
      $(this.DOM.nextCtrl).on('click.lqdAnimateFrames', this.navigate.bind(this, 'next', true));
      $(this.DOM.prevCtrl).on('click.lqdAnimateFrames', this.navigate.bind(this, 'prev', true));
      $(document).on('keydown.lqdAnimateFrames', ev => {
        const keyCode = ev.originalEvent.key;

        if (keyCode === 'ArrowUp') {
          this.navigate('prev', true);
        } else if (keyCode === 'ArrowDown') {
          this.navigate('next', true);
        }
      });
      if (!this.options.scrollable) return false;
      this.initDrag();
      const onWheel = liquidThrottle(event => {
        const delta = Math.sign(event.originalEvent.deltaY);
        $('html, body').animate({
          scrollTop: this.$element.offset().top - (window.innerHeight - this.element.offsetHeight) / 2
        }, 350);
        this.lockWindowScroll();

        if (delta < 0) {
          this.navigate('prev', true);
        } else if (delta > 0) {
          this.navigate('next', true);
        }
      }, 800, {
        leading: true
      });
      this.$element.on('wheel.lqdAnimateFrames mousewheel.lqdAnimateFrames', onWheel);
      this.$element.on('mouseenter.lqdAnimateFrames', () => {
        this.lockWindowScroll();
      });
      this.$element.on('mouseleave.lqdAnimateFrames', () => {
        this.unlockWindowScroll();
      });
    }

    initDrag() {
      this.$element.on('mousedown touchstart', this.pointerStart.bind(this));
      this.$element.on('mousemove touchmove', this.pointerMove.bind(this));
      this.$element.on('mouseup touchend', this.pointerEnd.bind(this));
    }

    pointerStart(event) {
      this.startY = event.pageY || event.originalEvent.changedTouches[0].pageY;
      this.currentY = this.startY;
      this.$element.addClass('pointer-down');
    }

    pointerMove(event) {
      this.currentY = event.pageY || event.originalEvent.changedTouches[0].pageY;
      this.dragY = parseInt(this.startY - this.currentY, 10);
    }

    pointerEnd() {
      this.dragY = parseInt(this.startY - this.currentY, 10);

      if (this.dragY >= 20) {
        this.navigate('next');
      } else if (this.dragY <= -20) {
        this.navigate('prev');
      }

      this.element.classList.remove('pointer-down');
    }

    navigate(dir = 'next', navigatedByUser) {
      if (this.isAnimating) return false;

      if (navigatedByUser) {
        this.userInteracted = true;
      }

      this.isAnimating = true;

      if (this.autoplayTimeout) {
        clearTimeout(this.autoplayTimeout);
      }

      this.element.classList.add('lqd-af--navigating', 'lqd-af--navigation-init');
      dir === 'next' && this.element.classList.add('lqd-af--moving-up');
      dir === 'prev' && this.element.classList.add('lqd-af--moving-down');
      const currentSlide = this.DOM.slides[this.current];
      const currentSlideImg = currentSlide.querySelector('.lqd-af-slide__img');
      const currentSlideImgInner = currentSlideImg.querySelector('.lqd-af-slide__img__inner');
      const currentSlideFigureEl = currentSlideImg.querySelector('figure');
      const figureAnimations = gsap.timeline({
        duration: 1,
        onComplete: () => {
          currentSlide.classList.remove('lqd-af-slide--movin-out');
        }
      });
      figureAnimations.fromTo(currentSlideFigureEl, {
        scale: 1
      }, {
        scale: 1.25,
        ease: CustomEase.create("custom", "M0,0,C0.4,0,0.2,1,1,1")
      }, 0);
      figureAnimations.fromTo(currentSlideImgInner, {
        scale: 1
      }, {
        scale: 0.5,
        ease: CustomEase.create("custom", "M0,0,C0.4,0,0.2,1,1,1")
      }, 0.015);
      figureAnimations.to(currentSlideImg, {
        duration: 0.85,
        ease: CustomEase.create("custom", "M0,0,C0.395,0,0.1,1,1,1"),
        y: dir === 'next' ? '-100%' : '100%'
      }, 0.35);
      currentSlide.classList.add('lqd-af-slide--movin-out');
      const currentSlideContentTimeline = gsap.timeline({
        duration: 1,
        delay: 0.5,
        ease: CustomEase.create("custom", "M0,0,C0.4,0,0.1,1,1,1"),
        onComplete: () => {
          currentSlide.classList.remove('lqd-af-slide--current');
          this.DOM.el.classList.add('lqd-af--initial');
        }
      });
      currentSlideContentTimeline.fromTo(currentSlide.querySelector('.lqd-af-slide__title-text'), {
        y: '0%'
      }, {
        y: dir === 'next' ? '-105%' : '105%'
      }, dir === 'next' ? 0 : 0.35);
      currentSlideContentTimeline.fromTo(currentSlide.querySelector('.lqd-af-slide__mask-rect'), {
        scaleX: 1
      }, {
        scaleX: 0
      }, dir === 'next' ? 0.15 : 0.35);
      currentSlideContentTimeline.fromTo(currentSlide.querySelector('.lqd-af-slide__desc'), {
        opacity: 1,
        y: '0%'
      }, {
        opacity: 0,
        y: dir === 'next' ? '-100%' : '100%'
      }, 0.25);
      currentSlideContentTimeline.fromTo(currentSlide.querySelector('.lqd-af-slide__link'), {
        opacity: 1,
        y: '0%'
      }, {
        opacity: 0,
        y: dir === 'next' ? '-75%' : '75%'
      }, dir === 'next' ? 0.35 : 0);
      this.current = dir === 'next' ? this.current < this.slidesTotal - 1 ? this.current + 1 : 0 : this.current > 0 ? this.current - 1 : this.slidesTotal - 1;
      this.animateNumbers(this.current);
      const newSlide = this.DOM.slides[this.current];
      newSlide.classList.add('lqd-af-slide--current', 'lqd-af-slide--movin-in');
      this.DOM.el.classList.add('lqd-af--initial');
      this.onSlideLoaded(newSlide);
      const newSlideImg = newSlide.querySelector('.lqd-af-slide__img');
      const newSlideContent = gsap.timeline({
        duration: 1,
        delay: 0.35,
        ease: CustomEase.create("custom", "M0,0,C0.4,0,0.1,1,1,1"),
        onComplete: () => {
          newSlide.classList.remove('lqd-af-slide--movin-in');
        }
      });
      newSlideContent.fromTo(newSlideImg, {
        y: dir === 'next' ? '100%' : '-100%'
      }, {
        y: 0,
        duration: 0.85,
        ease: CustomEase.create("custom", "M0,0,C0.395,0,0.1,1,1,1")
      }, 0);
      newSlideContent.fromTo(newSlide.querySelector('.lqd-af-slide__title-text'), {
        y: dir === 'next' ? '105%' : '-105%'
      }, {
        y: '0%'
      }, dir === 'next' ? 0.5 : 0.65);
      newSlideContent.fromTo(newSlide.querySelector('.lqd-af-slide__mask-rect'), {
        scaleX: 0
      }, {
        scaleX: 1
      }, dir === 'next' ? 0.5 : 0.65);
      newSlideContent.fromTo(newSlide.querySelector('.lqd-af-slide__desc'), {
        opacity: 0,
        y: dir === 'next' ? '100%' : '-100%'
      }, {
        opacity: 1,
        y: '0%'
      }, 0.4);
      newSlideContent.fromTo(newSlide.querySelector('.lqd-af-slide__link'), {
        opacity: 0,
        y: dir === 'next' ? '75%' : '-75%'
      }, {
        opacity: 1,
        y: '0%'
      }, dir === 'next' ? 0.5 : 0.3);
      figureAnimations.then(this.animateShapeOut.bind(this, dir));
    }

    animateShapeOut() {
      const currentSlide = this.DOM.slides[this.current];
      const currentSlideImg = currentSlide.querySelector('.lqd-af-slide__img');
      const currentSlideImgInner = currentSlideImg.querySelector('.lqd-af-slide__img__inner');
      const currentSlideFigureEl = currentSlideImg.querySelector('figure');
      gsap.to([currentSlideImgInner, currentSlideFigureEl], {
        scale: 1,
        duration: 0.8,
        ease: CustomEase.create("custom", "M0,0,C0.4,0,0.2,1,1,1"),
        onComplete: () => {
          this.isAnimating = false;
          this.element.classList.remove('lqd-af--navigating', 'lqd-af--moving-up', 'lqd-af--moving-down');
          !this.options.forceDisablingWindowScroll && document.documentElement.classList.remove('overflow-hidden');
          this.autoplay();
        }
      });
    }

    autoplay() {
      if (!this.options.autoplay || this.userInteracted || this.slidesTotal <= 1) return;
      this.autoplayTimeout = setTimeout(() => {
        this.navigate();
      }, this.options.autoplayTimeout);
    }

    onSlideLoaded(slide) {
      const $slide = $(slide);
      const $vids = $slide.find('video');
      $vids.each(function () {
        const $vid = $(this);
        $vid.find('source').each(function () {
          const $source = $(this);
          $source.attr('src', $source.attr('data-src'));
        });
        $vid[0].load();
        $vid[0].play();
      });
    }

    lockWindowScroll() {
      if (!this.options.forceDisablingWindowScroll || 'elementorFrontend' in window && elementorFrontend.isEditMode()) return;
      $liquidHtml.addClass('overflow-hidden');
    }

    unlockWindowScroll() {
      if (!this.options.forceDisablingWindowScroll || 'elementorFrontend' in window && elementorFrontend.isEditMode()) return;
      $liquidHtml.removeClass('overflow-hidden');
    }

    destroy() {
      $(this.DOM.nextCtrl).off('click.lqdAnimateFrames');
      $(this.DOM.prevCtrl).off('click.lqdAnimateFrames');
      $(document).off('keydown.lqdAnimateFrames');
      this.$element.off('mouseenter.lqdAnimateFrames');
      this.$element.off('mouseleave.lqdAnimateFrames');
      this.$element.off('wheel.lqdAnimateFrames');
      this.$element.off('mousewheel.lqdAnimateFrames');
      $liquidHtml.removeClass('overflow-hidden');
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('af-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('[data-liquid-animatedframes=true]').liquidAnimatedFrames();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidAsymmetricSlider';
  let defaults = {};

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.element = element;
      this.$element = $(element);
      this.DOM = {
        titlesWrap: this.element.querySelector('.lqd-asym-slider-title-wrap'),
        infosWrap: this.element.querySelector('.lqd-asym-slider-info-wrap'),
        imagesWrap: this.element.querySelector('.lqd-asym-slider-img-wrap'),
        titles: [...this.element.querySelectorAll('.lqd-asym-slider-title')],
        infos: [...this.element.querySelectorAll('.lqd-asym-slider-info')],
        images: [...this.element.querySelectorAll('.lqd-asym-slider-img')],
        prevBtn: this.element.querySelector('.lqd-asym-slider-prev'),
        nextBtn: this.element.querySelector('.lqd-asym-slider-next')
      };
      this.isPlaying = false;
      this.currentSlide = 0;
      this.nextSlide = null;
      this.prevSlide = null;
      this.totalSlides = this.DOM.images.length - 1;
      const promises = [];
      const $firstHeading = $(this.DOM.titlesWrap).find('h2').first();
      const elementFontFamily = $firstHeading.css('font-family').replace(/"/g, '').replace(/'/g, '').split(',')[0];
      const elementFontWeight = $firstHeading.css('font-weight');
      const elementFontStyle = $firstHeading.css('font-style');
      promises.push(new Promise(resolve => imagesLoaded(this.element, resolve)));
      const font = new FontFaceObserver(elementFontFamily, {
        weight: elementFontWeight,
        style: elementFontStyle
      });
      promises.push(font.load());
      Promise.all(promises).finally(() => {
        this.init();
      });
    }

    init() {
      this.updateHeights();
      this.events();
      this.playInitial();
      this.element.classList.add('lqd-asym-slider-ready');
    }

    events() {
      this.DOM.prevBtn.addEventListener('click', this.prev.bind(this));
      this.DOM.nextBtn.addEventListener('click', this.next.bind(this));
      window.addEventListener('resize', liquidDebounce(this.updateHeights.bind(this), 1000));
    }

    updateHeights() {
      this.DOM.imagesWrap.style.height = `${this.DOM.images[this.currentSlide].offsetHeight}px`;
    }

    beforePlay() {
      this.element.classList.add('lqd-asym-slider-changing');
      this.DOM.titles[this.nextSlide].classList.add('is-next');
      this.DOM.titles[this.nextSlide].classList.remove('active');
      this.DOM.images[this.nextSlide].classList.add('is-next');
      this.DOM.images[this.nextSlide].classList.remove('active');
      this.DOM.infos[this.nextSlide].classList.add('is-next');
      this.DOM.infos[this.nextSlide].classList.remove('active');
      this.isPlaying = true;
    }

    afterPlay() {
      this.element.classList.remove('lqd-asym-slider-changing');
      this.DOM.titles[this.nextSlide].classList.remove('is-next');
      this.DOM.titles[this.nextSlide].classList.add('active');
      this.DOM.titles[this.prevSlide].classList.remove('active');
      this.DOM.images[this.nextSlide].classList.remove('is-next');
      this.DOM.images[this.nextSlide].classList.add('active');
      this.DOM.images[this.prevSlide].classList.remove('active');
      this.DOM.infos[this.nextSlide].classList.remove('is-next');
      this.DOM.infos[this.nextSlide].classList.add('active');
      this.DOM.infos[this.prevSlide].classList.remove('active');
      this.isPlaying = false;
    }

    playInitial() {
      this.nextSlide = this.currentSlide;
      this.playTitle('init');
      this.playInfo('init');
      this.playImages('init');
    }

    prev() {
      if (this.isPlaying) return;
      this.currentSlide = this.nextSlide ? this.nextSlide : 0;
      this.prevSlide = this.currentSlide;
      this.nextSlide = this.currentSlide === 0 ? this.totalSlides : this.currentSlide - 1;
      this.beforePlay();
      this.playTitle('prev');
      this.playInfo('prev');
      this.playImages('prev').then(() => {
        this.afterPlay();
      });
    }

    next() {
      if (this.isPlaying) return;
      this.currentSlide = this.nextSlide ? this.nextSlide : 0;
      this.prevSlide = this.currentSlide;
      this.nextSlide = this.currentSlide === this.totalSlides ? 0 : this.currentSlide + 1;
      this.beforePlay();
      this.playTitle('next');
      this.playInfo('next');
      this.playImages('next').then(() => {
        this.afterPlay();
      });
    }

    playTitle(dir) {
      const currentTitle = this.DOM.titles[this.currentSlide];
      const nextTitle = this.DOM.titles[this.nextSlide];
      const currentTitleChars = currentTitle.querySelectorAll('.lqd-chars');
      const nextTitleChars = nextTitle.querySelectorAll('.lqd-chars');
      const timeline = gsap.timeline({
        defaults: {
          duration: 1
        },
        delay: dir === 'next' ? 0.15 : 0
      });

      if (dir === 'prev') {
        timeline.fromTo([...currentTitleChars].reverse(), {
          y: '0%',
          rotation: 0,
          opacity: 1
        }, {
          y: '100%',
          rotation: 15,
          opacity: 0,
          ease: 'expo.inOut',
          stagger: 0.025
        }).fromTo([...nextTitleChars].reverse(), {
          y: '-100%',
          rotation: 15,
          opacity: 0
        }, {
          y: '0%',
          rotation: 0,
          opacity: 1,
          ease: 'expo.out',
          stagger: 0.025
        }, 0.75);
      } else if (dir === 'next') {
        timeline.fromTo(currentTitleChars, {
          y: '0%',
          rotation: 0,
          opacity: 1
        }, {
          y: '-100%',
          rotation: 15,
          opacity: 0,
          ease: 'expo.inOut',
          stagger: 0.025
        }).fromTo(nextTitleChars, {
          y: '100%',
          rotation: 15,
          opacity: 0
        }, {
          y: '0%',
          rotation: 0,
          opacity: 1,
          ease: 'expo.out',
          stagger: 0.025
        }, 0.75);
      } else {
        timeline.fromTo(currentTitleChars, {
          x: 35,
          opacity: 0
        }, {
          x: 0,
          opacity: 1,
          ease: 'expo.inOut',
          stagger: 0.045
        });
      }
    }

    playInfo(dir) {
      const currentInfo = this.DOM.infos[this.currentSlide];
      const currentInfoH4 = currentInfo.querySelector('h4');
      const currentInfoP = currentInfo.querySelector('p');
      const currentInfoHr = currentInfo.querySelector('hr');
      const nextInfo = this.DOM.infos[this.nextSlide];
      const nextInfoH4 = nextInfo.querySelector('h4');
      const nextInfoP = nextInfo.querySelector('p');
      const nextInfoHr = nextInfo.querySelector('hr');
      const timeline = gsap.timeline({
        defaults: {
          ease: 'expo.inOut',
          duration: 1.5
        },
        delay: dir === 'prev' ? 0.3 : 0.15
      });

      if (dir === 'prev') {
        timeline.fromTo(currentInfoH4, {
          x: 0,
          opacity: 1
        }, {
          x: 15,
          opacity: 0
        }, 0).fromTo(currentInfoHr, {
          scaleX: 1,
          opacity: 1
        }, {
          scaleX: 0.6,
          opacity: 0
        }, 0).fromTo(currentInfoP, {
          x: 0,
          opacity: 1
        }, {
          x: 15,
          opacity: 0
        }, 0.15).fromTo(nextInfoH4, {
          x: -15,
          opacity: 0
        }, {
          x: 0,
          opacity: 1
        }, 0.15).fromTo(nextInfoHr, {
          scaleX: 0.6,
          opacity: 0
        }, {
          scaleX: 1,
          opacity: 1
        }, 0.15).fromTo(nextInfoP, {
          x: -15,
          opacity: 0
        }, {
          x: 0,
          opacity: 1
        }, 0.3);
      } else if (dir === 'next') {
        timeline.fromTo(currentInfoH4, {
          x: 0,
          opacity: 1
        }, {
          x: -15,
          opacity: 0
        }, 0).fromTo(currentInfoHr, {
          scaleX: 1,
          opacity: 1
        }, {
          scaleX: 0.6,
          opacity: 0
        }, 0.15).fromTo(currentInfoP, {
          x: 0,
          opacity: 1
        }, {
          x: -15,
          opacity: 0
        }, 0.15).fromTo(currentInfoP, {
          x: 0,
          opacity: 1
        }, {
          x: -15,
          opacity: 0
        }, 0.15).fromTo(nextInfoH4, {
          x: 15,
          opacity: 0
        }, {
          x: 0,
          opacity: 1
        }, 0.15).fromTo(nextInfoHr, {
          scaleX: 0.6,
          opacity: 0
        }, {
          scaleX: 1,
          opacity: 1
        }, 0.15).fromTo(nextInfoP, {
          x: 15,
          opacity: 0
        }, {
          x: 0,
          opacity: 1
        }, 0.3);
      } else {
        timeline.fromTo(currentInfoH4, {
          x: 30,
          opacity: 0
        }, {
          x: 0,
          opacity: 1
        }, 0).fromTo(currentInfoHr, {
          scaleX: 0.6,
          opacity: 0
        }, {
          scaleX: 1,
          opacity: 1
        }, 0).fromTo(currentInfoP, {
          x: 30,
          opacity: 0
        }, {
          x: 0,
          opacity: 1
        }, 0.15);
      }
    }

    playImages(dir) {
      const currentImage = this.DOM.images[this.currentSlide];
      const currentImageInner = currentImage.querySelector('.lqd-asym-slider-img-inner');
      const nextImage = this.DOM.images[this.nextSlide];
      const nextImageInner = nextImage.querySelector('.lqd-asym-slider-img-inner');
      const timeline = gsap.timeline({
        defaults: {
          ease: 'expo.inOut',
          duration: 1.5
        },
        delay: dir === 'prev' ? 0.15 : 0
      });

      if (dir === 'prev') {
        timeline.fromTo(currentImageInner, {
          x: '0%',
          scale: 1
        }, {
          x: '-100%',
          scale: 1.2
        }, 0).fromTo(currentImage, {
          x: '0%'
        }, {
          x: '100%'
        }, 0).fromTo(nextImage, {
          x: '-100%'
        }, {
          x: '0%'
        }, 0).fromTo(nextImageInner, {
          x: '100%',
          scale: 1.2
        }, {
          x: '0%',
          scale: 1
        }, 0);
      } else if (dir === 'next') {
        timeline.fromTo(currentImageInner, {
          x: '0%',
          scale: 1
        }, {
          x: '100%',
          scale: 1.2
        }, 0).fromTo(currentImage, {
          x: '0%'
        }, {
          x: '-100%'
        }, 0).fromTo(nextImage, {
          x: '100%'
        }, {
          x: '0%'
        }, 0).fromTo(nextImageInner, {
          x: '-100%',
          scale: 1.2
        }, {
          x: '0%',
          scale: 1
        }, 0);
      } else {
        timeline.fromTo(currentImageInner, {
          x: '100%',
          scale: 1.2
        }, {
          x: '0%',
          scale: 1
        }, 0).fromTo(currentImage, {
          x: '-100%'
        }, {
          x: '0%'
        }, 0);
      }

      return timeline;
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('asym-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('[data-asym-slider]').liquidAsymmetricSlider();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidBackToTop';
  let defaults = {};

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.element = element;
      this.$element = $(element);
      this.init();
    }

    init() {
      this.firstSectionIO();
    }

    firstSectionIO() {
      let $firstSection = $liquidSectionsWrapper.children().not('style, p').first();
      const firstSectionIsSticky = $firstSection.css('position') === 'sticky';

      if ($firstSection.is(':hidden') || firstSectionIsSticky) {
        $firstSection = $firstSection.siblings().not('style, p').first();
      }

      if (!$firstSection.length) return;
      new IntersectionObserver(([entry]) => {
        const {
          boundingClientRect,
          rootBounds
        } = entry;
        let activate = rootBounds && rootBounds.top >= boundingClientRect.bottom - boundingClientRect.height / 2;

        if (firstSectionIsSticky) {
          activate = rootBounds && rootBounds.bottom >= boundingClientRect.top;
        }

        if (activate) {
          this.$element.addClass('is-visible');
        } else {
          this.$element.removeClass('is-visible');
        }
      }, {
        threshold: firstSectionIsSticky ? [0] : [0, 0.5, 1]
      }).observe($firstSection.get(0));
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('back-to-top-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  if (!$('html').hasClass('pp-enabled')) {
    $('[data-back-to-top]').liquidBackToTop();
  }
});
(function ($) {
  'use strict';

  const pluginName = 'liquidBgColor';
  let defaults = {
    getBgFromSelector: 'backgroundColor',
    setBgTo: 'self',
    manipulateColor: null,
    changeBorderColor: false,
    interactWithHeader: false,
    makeGradient: false
  };

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.element = element;
      this.$element = $(element);
      this.$stickyModules = this._getStickyModules();
      this.setBgToEls = this.options.setBgTo === 'self' ? [this.element] : $(this.options.setBgTo, this.element).get();
      this.$bgEl = false;
      this.rowsRect = [];
      this.colors = [];
      this.direction = 0;
      this.$element.is($liquidContents) && this._addBgElement();
      LiquidSectionsDetails.getDetails().then(sections => {
        $(sections).imagesLoaded(this._init(sections));
      });
    }

    _init(liquidSections) {
      const sections = liquidSections.filter(sec => !sec.isHidden && !sec.isInFooter).filter(sec => !sec.isInnerSection);
      sections.forEach(async (sec, i) => {
        await this._getColors(sec);
        Promise.all(this._getRects(sec, i)).then(() => {
          this._setupIO(sec, i);

          if (this.$bgEl) {
            this.element.classList.add('bg-transparent');
            sec.el.classList.add('bg-transparent');
            sec.isInnerSection && sec.parentSection && sec.parentSection.el.classList.add('bg-transparent');
          }
        });
      });
    }

    _getStickyModules() {
      let stickyModules = false;

      if ($liquidMainHeader.length && $liquidMainHeader[0].hasAttribute('data-sticky-header')) {
        stickyModules = $liquidMainHeader.find('> .elementor').find('> .elementor-section, > .e-container, > .elementor-section, > .e-con').not('.lqd-hide-onstuck').find('[data-element_type="widget"]');
      }

      return stickyModules;
    }

    _addBgElement() {
      if (this.$bgEl) return;
      const overflowClassname = liquidIsMobile() ? 'overflow-hidden' : '';
      const posClassname = liquidIsMobile() ? 'pos-fix' : 'pos-sticky';
      const heightClassname = liquidIsMobile() ? 'h-100' : 'h-vh-100';
      this.$bgEl = $(`<div class="lqd-liquid-bg-el-wrap lqd-overlay pointer-events-none z-index--1 ${overflowClassname}"><div class="lqd-liquid-bg-el ${posClassname} pos-tl w-100 ${heightClassname} pointer-events-none"></div></div>`);
      this.$bgEl.prependTo(this.$element);
      this.setBgToEls = [this.$bgEl.children()[0]];
      $liquidMainFooter.css({
        position: 'relative',
        zIndex: 2
      });
    }

    _getColors(lqdSection) {
      return fastdomPromised.measure(() => {
        const {
          getBgFromSelector,
          manipulateColor
        } = this.options;
        const obj = {};
        let color = lqdSection[getBgFromSelector].replace(/, /g, ',').split(' ')[0];
        let dataLuminosityAttr = lqdSection.$el.attr('data-section-luminosity');

        if (lqdSection.isInnerSection && lqdSection.parentSection) {
          if (lqdSection.isBgTransparent && !lqdSection.parentSection.isBgTransparent) {
            color = lqdSection.parentSection[getBgFromSelector].replace(/, /g, ',').split(' ')[0];
          }
        }

        if (lqdSection.isBgTransparent) {
          color = $liquidContents.css('backgroundColor');
        }

        if (manipulateColor && manipulateColor.length > 0) {
          for (let i = 0; i < manipulateColor.length; i++) {
            color = tinycolor(color)[Object.keys(manipulateColor[i])[0]](Object.values(manipulateColor[i])[0]).toString();
          }
        }

        obj.color = color;
        obj.luminosity = dataLuminosityAttr != null && !manipulateColor ? dataLuminosityAttr : tinycolor(color).getLuminance() <= 0.4 ? 'dark' : 'light';
        this.colors.push(obj);
      });
    }

    _interactWithHeader(colorLuminosity) {
      const $elements = $liquidMainHeader.add(this.$stickyModules).filter((i, el) => {
        const $el = $(el);
        return !$el.children('.navbar-brand-solid').length && !$el.hasClass('navbar-brand-solid') && !$el.find('> .elementor-widget-container > .navbar-brand-solid').length;
      });

      if (colorLuminosity === 'dark') {
        $elements.addClass('lqd-active-row-dark').removeClass('lqd-active-row-light');
      } else {
        $elements.addClass('lqd-active-row-light').removeClass('lqd-active-row-dark');
      }
    }

    _interactWithColors(element, targetColorLuminosity) {
      const $el = $(element);

      if ($el.hasClass('btn-icon') || $el.hasClass('btn-solid')) {
        const buttonColor = targetColorLuminosity === 'dark' ? '#fff' : '#000';
        $el.css({
          transition: 'box-shadow 0.3s, transform 0.3s, color 0.3s',
          color: buttonColor
        });
      }

      if ($el.hasClass('navbar-brand-inner')) {
        const $parentModule = $el.closest('.elementor-element');

        if (targetColorLuminosity === 'dark') {
          $parentModule.addClass('lqd-active-row-dark').removeClass('lqd-active-row-light');
        } else {
          $parentModule.addClass('lqd-active-row-light').removeClass('lqd-active-row-dark');
        }
      }
    }

    _getRects(lqdSection, loopIndex) {
      const promises = [];
      const secPromise = new Promise(resolve => {
        new IntersectionObserver(([entry], observer) => {
          observer.disconnect();
          this.rowsRect[loopIndex] = entry.boundingClientRect;
          resolve();
        }).observe(lqdSection.el);
      });
      promises.push(secPromise);
      return promises;
    }

    _setupIO(lqdSection, loopIndex) {
      const timeline = gsap.timeline();
      const start = loopIndex === 0 ? 'top bottom' : `top+=${this.rowsRect[loopIndex].y - lqdSection.rect.y} bottom`;
      this.setBgToEls.forEach(element => {
        const onUpdate = () => {
          const i = this.direction < 1 && loopIndex > 0 ? loopIndex - 1 : loopIndex;
          this.options.interactWithHeader && this.$stickyModules && this._interactWithHeader(this.colors[i].luminosity);

          this._interactWithColors(element, this.colors[i].luminosity);
        };

        timeline.fromTo(element, {
          backgroundColor: loopIndex === 0 ? this.colors[loopIndex].color : this.colors[loopIndex - 1].color
        }, {
          backgroundColor: this.colors[loopIndex].color,
          onUpdate,
          onComplete: () => {
            element.style.transition = '';
          }
        }, 0);
      });
      ScrollTrigger.create({
        animation: timeline,
        trigger: lqdSection.el,
        start,
        end: `+=${Math.min(window.innerHeight / 2, this.rowsRect[loopIndex].height)}`,
        scrub: 0.05,
        onUpdate: st => {
          this.direction = st.direction;
        }
      });
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('liquid-bg-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('[data-liquid-bg]').liquidBgColor();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidAnimatedIcon';
  let defaults = {
    objContainer: '.iconbox-icon-container',
    color: '#f42958',
    hoverColor: null,
    type: 'delayed',
    delay: 0,
    duration: 100,
    resetOnHover: false,
    file: null
  };

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = $.extend({}, defaults, options);
      this.element = element;
      this.$element = $(element);
      this.options.file && this.init();
    }

    init() {
      this.animateIcon();
      return this;
    }

    animateIcon() {
      const {
        type,
        duration,
        file,
        objContainer
      } = this.options;
      const gid = this.$element.attr('id') || Math.round(Math.random() * 1000000);
      const containerEl = this.$element.find(objContainer).attr('id', `${gid.replace(/ld_icon_box/, 'ld_icon_container')}`);
      new Vivus(containerEl.attr('id'), {
        file,
        type,
        duration,
        start: 'manual',
        onReady: vivus => {
          this.onReady.call(this, vivus);
        }
      }).setFrameProgress(1);
    }

    onReady(vivus) {
      const $parentCarousel = this.$element.closest('.carousel-items');
      const carouselData = $parentCarousel.data('plugin_liquidCarousel');
      this.addColors(vivus);
      this.animate(vivus);

      if ($parentCarousel.length && carouselData != null && carouselData.flickityData != null) {
        carouselData.flickityData.resize();
      }
    }

    addColors(svg) {
      const obj = $(svg.el);
      const {
        color,
        hoverColor
      } = this.options;
      const gid = Math.round(Math.random() * 1000000);
      let hoverGradientValues = hoverColor;
      let strokeHoverGradients = document.createElementNS('http://www.w3.org/2000/svg', 'style');
      let gradientValues = color != null ? color.split(':') : '#000';
      let strokegradients = null;

      if (undefined === gradientValues[1]) {
        gradientValues[1] = gradientValues[0];
      }

      strokegradients = '<defs xmlns="http://www.w3.org/2000/svg">' + '<linearGradient gradientUnits="userSpaceOnUse" id="grad' + gid + '" x1="0%" y1="0%" x2="0%" y2="100%">' + '<stop offset="0%" stop-color="' + gradientValues[0] + '" />' + '<stop offset="100%" stop-color="' + gradientValues[1] + '" />' + '</linearGradient>' + '</defs>';
      const xmlStrokegradients = new DOMParser().parseFromString(strokegradients, "text/xml");
      obj.prepend(xmlStrokegradients.documentElement);

      if (typeof undefined !== typeof hoverGradientValues && null !== hoverGradientValues) {
        hoverGradientValues = hoverGradientValues.split(':');

        if (undefined === hoverGradientValues[1]) {
          hoverGradientValues[1] = hoverGradientValues[0];
        }

        strokeHoverGradients.innerHTML = '#' + this.$element.attr('id') + ':hover .iconbox-icon-container defs stop:first-child{stop-color:' + hoverGradientValues[0] + ';}' + '#' + this.$element.attr('id') + ':hover .iconbox-icon-container defs stop:last-child{stop-color:' + hoverGradientValues[1] + ';}';
        obj.prepend(strokeHoverGradients);
      }

      obj.find('path, rect, ellipse, circle, polygon, polyline, line').attr({
        'stroke': 'url(#grad' + gid + ')',
        'fill': 'none'
      });
      this.$element.addClass('iconbox-icon-animating');
      return this;
    }

    animate(vivusObj) {
      const options = this.options;
      const delayTime = parseInt(options.delay, 10);
      const {
        duration
      } = options;
      vivusObj.reset().stop();
      new IntersectionObserver(([entry], observer) => {
        const vivusStatus = vivusObj.getStatus();

        if (entry.isIntersecting && vivusStatus === 'start' && vivusStatus !== 'progress') {
          observer.disconnect();
          this.resetAnimate(vivusObj, delayTime, duration);
          this.eventHandlers(vivusObj, delayTime, duration);
        }
      }).observe(this.element);
      return this;
    }

    eventHandlers(vivusObj, delayTime, duration) {
      const {
        options
      } = this;
      $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', event => {
        const $target = $($(event.currentTarget).attr('href'));

        if ($target.find(this.element).length) {
          this.resetAnimate.call(this, vivusObj, delayTime, duration);
        }
      });

      if (options.resetOnHover) {
        this.$element.on('mouseenter.lqdIconbox', () => {
          if (vivusObj.getStatus() === 'end') {
            this.resetAnimate(vivusObj, 0, duration);
          }
        });
      }
    }

    resetAnimate(vivusObj, delay, duration) {
      vivusObj.stop().reset();
      const timeout = setTimeout(() => {
        vivusObj.play(duration / 100);
        clearTimeout(timeout);
      }, delay);
    }

    destroy() {
      this.$element.off('mouseenter.lqdIconbox');
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('plugin-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('[data-animate-icon]').liquidAnimatedIcon();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidCarousel';
  let defaults = {
    bypassCheck: false,
    carouselEl: null,
    contain: false,
    imagesLoaded: true,
    percentPosition: true,
    prevNextButtons: false,
    pageDots: true,
    adaptiveHeight: false,
    cellAlign: "left",
    groupCells: true,
    dragThreshold: 0,
    wrapAround: false,
    autoplay: false,
    fullwidthSide: false,
    navArrow: 1,
    filters: false,
    filtersCounter: false,
    doSomethingCrazyWithFilters: false,
    equalHeightCells: false,
    middleAlignContent: false,
    randomVerOffset: false,
    parallax: false,
    parallaxEl: 'img',
    dotsIndicator: 'classic',
    numbersStyle: 'circle',
    addSlideNumbersToArrows: false,
    marquee: false,
    marqueeTickerSpeed: 2,
    fade: false,
    prevNextButtonsOnlyOnMobile: false,
    columnsAutoWidth: false,
    watchCSS: false,
    forceApply: false,
    skipWrapItems: false,
    buttonsAppendTo: 'self',
    appendingBtnRel: null,
    dotsAppendTo: 'self'
  };

  function Plugin(element, options) {
    this._defaults = defaults;
    this._name = pluginName;
    this.options = { ...defaults,
      ...options
    };
    this.flickityData = null;
    this.isRTL = $('html').attr('dir') === 'rtl';

    if (liquidIsMobile()) {
      this.options.dragThreshold = 5;
    }

    this.element = element;
    this.$element = $(element);
    this.$carouselContainer = this.$element.closest('.carousel-container').length ? this.$element.closest('.carousel-container') : this.$element.parent();
    this.sliderElement = null;
    this.carouselNavElement = null;
    this.carouselDotsElement = null;
    this.carouselMobileDotsElement = null;
    this.$carouselCurrentSlide = null;
    this.$carouselCurrentSlideInner = null;
    this.$carouselTotalSlides = null;
    this.$carouselSlidesShape = null;
    this.carouselSlidesPathLength = null;
    this.windowWidth = liquidWindowWidth();

    if (this.options.dotsIndicator === 'numbers') {
      if (getComputedStyle(this.element).getPropertyValue('--carousel-path-length')) {
        this.carouselSlidesPathLength = getComputedStyle(this.element).getPropertyValue('--carousel-path-length');
      } else {
        if (this.options.numbersStyle === 'circle') {
          this.carouselSlidesPathLength = 471;
        } else {
          this.carouselSlidesPathLength = 200;
        }
      }
    }

    this.$carouselEl = this.options.carouselEl ? $(this.options.carouselEl, this.element) : this.$element;
    this.carouselEl = this.$carouselEl.get(0);
    this.carouselInitPromise = new Promise(resolve => {
      this.$element.on('lqd-carousel-initialized', resolve.bind(this, this));
    });

    if (this.options.marquee) {
      this.options.wrapAround = true;
    }

    if (this.options.forceApply) {
      this.initFlicky();
    } else {
      this.setIO();
    }
  }

  Plugin.prototype = {
    setIO() {
      new IntersectionObserver(([entry], observer) => {
        if (entry.isIntersecting) {
          this.initFlicky();
          observer.unobserve(entry.target);
        }
      }, {
        rootMargin: '35%'
      }).observe(this.element);
    },

    initFlicky() {
      const options = { ...this.options,
        rightToLeft: this.isRTL || this.options.rightToLeft
      };
      imagesLoaded(this.element, () => {
        this.wrapItems();
        this.setEqualHeightCells();
        this.$carouselEl.flickity(options);
        this.flickityData = this.$carouselEl.data('flickity');
        options.adaptiveHeight && $('.flickity-viewport', this.element).css('transition', 'height 0.3s');
        this.onImagesLoaded();
        this.$element.addClass('lqd-carousel-ready');
      });
    },

    onImagesLoaded() {
      if (!this.flickityData) return;
      this.sliderElement = this.element.querySelector('.flickity-slider');
      this.initPlugins();
      this.columnsAutoWidth();
      this.setElementNavArrow();
      this.carouselNav();
      this.navOffsets();
      this.carouselDots();
      this.carouselMobileDots();
      this.carouselDotsNumbers();
      this.addSlideNumbersToArrows();
      this.addSlidesCurrentNumbers();
      this.randomVerOffset();
      this.fullwidthSide();
      this.controllingCarousels();
      this.marquee();
      this.filtersInit();
      this.windowResize();
      this.events();
      this.dispatchEvents();
    },

    initPlugins() {
      this.element.hasAttribute('data-custom-animations') && this.$element.liquidCustomAnimations();
    },

    dispatchEvents() {
      const e = new CustomEvent('lqd-carousel-initialized', {
        detail: {
          carouselData: this
        }
      });
      document.dispatchEvent(e);
      this.$element.trigger('lqd-carousel-initialized', this.element);
    },

    windowResize() {
      const onResize = liquidDebounce(this.doOnWindowResize.bind(this), 200);
      $(window).on('resize.lqdCarousel', onResize);
    },

    doOnWindowResize() {
      if (this.windowWidth !== window.innerWidth) {
        this.windowWidth = window.innerWidth;
        this.fullwidthSide();
        this.columnsAutoWidth();
      }
    },

    events() {
      this.flickityData.on('dragStart', () => {
        if (typeof Fresco !== 'undefined') {
          Fresco && Fresco.disable();
        }
      });
      this.flickityData.on('dragEnd', () => {
        if (typeof Fresco !== 'undefined') {
          setTimeout(() => {
            Fresco && Fresco.enable();
          }, 0);
        }
      });
      if (this.options.marquee) return;
      this.flickityData.on('settle', () => {
        this.sliderElement.style.willChange = 'auto';
      });
      this.flickityData.on('scroll', () => {
        this.sliderElement.style.willChange = 'transform';
        this.doSomethingCrazyWithFilter();
        this.parallax();
        this.changeSlidesNumbers();
        this.changeSlidesShape();
      });
      $(document).on('added_to_cart', (event, frags, id, $btn) => {
        if (this.$carouselEl.has($btn)) {
          this.flickityData.resize();
        }
      });
      $('[data-toggle=tab]').on('hidden.bs.tab shown.bs.tab', event => {
        const $link = $(event.target);
        const $target = $($($link.attr('href')), $link.parent().next('.lqd-tabs-content'));
        const $carouselEl = $target.find('[data-lqd-flickity]');
        let carouselData = $carouselEl.data('plugin_liquidCarousel');

        if (event.type === 'shown') {
          $carouselEl.on('lqd-carousel-initialized', () => {
            carouselData = $carouselEl.data('plugin_liquidCarousel');
            const $navEl = $(carouselData.carouselNavElement);
            $navEl.siblings('.carousel-nav').addClass('screen-reader-text').stop().fadeOut(300);
            $navEl.removeClass('screen-reader-text').stop().fadeIn(300);
          });

          if (carouselData) {
            const $navEl = $(carouselData.carouselNavElement);
            $navEl.siblings('.carousel-nav').addClass('screen-reader-text').stop().fadeOut(300);
            $navEl.removeClass('screen-reader-text').stop().fadeIn(300);
          }
        }
      });
    },

    wrapItems() {
      const {
        middleAlignContent,
        equalHeightCells,
        randomVerOffset,
        skipWrapItems
      } = this.options;
      if (skipWrapItems) return;
      const $firstChild = this.$carouselEl.children().first();

      if ($firstChild.hasClass('flickity-viewport') || $firstChild.hasClass('flickity-viewport-wrap')) {
        const $cells = $firstChild.find('.flickity-slider').children();
        $cells.each((i, cell) => {
          const $cell = $(cell);
          const $cellContent = $cell.find('.carousel-item-content').first();
          const hasOneChild = $cellContent.children().not('style').length === 1;

          if (hasOneChild) {
            $cell.addClass('has-one-child');
          }
        });
        return;
      }

      ;
      this.$carouselEl.children('p, style').insertBefore(this.$carouselEl);
      const $cells = this.$carouselEl.children();
      $cells.each((i, cell) => {
        const $cell = $(cell);
        if ($cell.hasClass('vc_ld_carousel_section') || $cell.hasClass('vc_ld_carousel_marquee_section') || $cell.hasClass('vc_container-anchor') || $cell.hasClass('lqd-sticky-stack-nav') || $cell.is('pre')) return;
        const cellHasInner = $cell.children().hasClass('carousel-item-inner');
        const $cellToSearch = cellHasInner ? $cell.find('.carousel-item-content') : $cell;
        const columnClassnames = $cell.attr('class') && $cell.attr('class').split(' ').filter(classname => classname.includes('vc_hidden-') || classname.includes('hidden-') || classname.includes('col-') || classname.includes('vc_col-'));
        const hasOneChild = $cellToSearch.children().not('style, .vc_controls-container').length === 1;

        if ($cell.hasClass('carousel-item')) {
          middleAlignContent && equalHeightCells && !randomVerOffset && $cell.addClass('align-items-center');
          hasOneChild && $cell.addClass('has-one-child');

          if (!$cell.children('.carousel-item-inner').length) {
            $cell.wrapInner('<div class="carousel-item-inner" />');
          }

          if (!$cell.children('.carousel-item-inner').children('.carousel-item-content').length) {
            $cell.children().wrapInner('<div class="carousel-item-content" />');
          }
        } else {
          $cell.wrap(`<div class="carousel-item ${hasOneChild ? 'has-one-child' : ''} ${columnClassnames && columnClassnames.join(' ')} ${middleAlignContent && equalHeightCells && !randomVerOffset ? 'align-items-center' : ''}" />`).wrap(`<div class="carousel-item-inner" />`).wrap(`<div class="carousel-item-content" />`);
        }
      });
    },

    columnsAutoWidth() {
      if (!this.options.columnsAutoWidth) return;

      for (let i = 0; i < this.flickityData.cells.length; i++) {
        const cell = this.flickityData.cells[i];
        const $cellEl = $(cell.element);
        if ($cellEl.hasClass('width-is-set')) return;
        const $cellContentWrapper = $cellEl.find('.carousel-item-content');
        let $cellChildren = $cellContentWrapper.children().not('style, p').first();
        $cellEl.css('width', 'auto');

        if ($cellChildren.hasClass('ld-fancy-heading')) {
          $cellChildren = $cellChildren.children();
        }

        let width = $cellChildren.length ? $cellChildren.outerWidth() : $cellContentWrapper.outerWidth();
        $cellContentWrapper.css('width', width);
        this.flickityData.resize();
        this.flickityData.reposition();
      }
    },

    carouselNav() {
      if (!this.options.prevNextButtons || !this.flickityData.prevButton || !this.flickityData.nextButton) return;
      let appendingSelector = this.options.buttonsAppendTo;

      if (appendingSelector === 'parent_row') {
        appendingSelector = liquidIsElementor ? this.$element.closest('.elementor-section') : this.$element.closest('.vc_row');
      }

      if (appendingSelector === 'parent_el') {
        appendingSelector = this.$element.parent();
      }

      if (appendingSelector === 'self') {
        appendingSelector = this.$carouselContainer;
      }

      const $prevBtn = $(this.flickityData.prevButton.element);
      const $nextBtn = $(this.flickityData.nextButton.element);
      const $appendingSelector = $(appendingSelector);
      const $carouselNav = $(`<div class="carousel-nav"></div>`);
      const carouselNavClassnames = [];
      let carouselId = this.options.carouselEl ? this.$element.attr('id') : this.$carouselContainer.attr('id');

      if (liquidIsElementor) {
        carouselId = `elementor-element elementor-element-${this.$element.closest('.elementor-element').attr('data-id')}`;
      }

      $.each($(this.$carouselContainer.get(0).classList), (i, className) => {
        if (className.indexOf('carousel-nav-') >= 0) carouselNavClassnames.push(className);
      });
      $carouselNav.addClass([...carouselNavClassnames, carouselId].join(' '));
      this.$carouselContainer.removeClass(carouselNavClassnames.join(' '));
      $carouselNav.append([$prevBtn, $nextBtn]);

      if (appendingSelector != null) {
        if ($appendingSelector.hasClass('vc_column_container')) {
          const $wpbWrapperElement = $appendingSelector.children('.vc_column-inner').children('.wpb_wrapper');
          $carouselNav.appendTo($wpbWrapperElement);
        } else if ($appendingSelector.hasClass('elementor-column')) {
          const $wrappingEl = $appendingSelector.children('.elementor-widget-wrap');
          $wrappingEl.children('.elementor-empty-view').remove();
          $carouselNav.appendTo($wrappingEl);
        } else {
          if (this.options.appendingBtnRel) {
            $carouselNav.appendTo(this.$carouselEl[this.options.appendingBtnRel](appendingSelector));
          } else {
            $carouselNav.appendTo(appendingSelector);
          }
        }

        $appendingSelector.addClass('carousel-nav-appended');
      } else {
        $carouselNav.appendTo(this.$carouselContainer);
      }

      this.carouselNavElement = $carouselNav.get(0);
      this.options.prevNextButtonsOnlyOnMobile && this.carouselNavElement.classList.add('visible-xs', 'visible-sm');
    },

    carouselDots() {
      if (!this.options.pageDots) return;
      const {
        dotsAppendTo,
        hasPageDotsFromOptions,
        carouselEl
      } = this.options;
      const dotsHolder = this.flickityData.pageDots.holder;
      const carouselDots = $(`<div class="carousel-dots ${hasPageDotsFromOptions ? 'carousel-dots-from-options' : 'carousel-dots-to-hide'}"></div>`);
      let carouselId = carouselEl ? this.$carouselEl.attr('id') : this.$carouselContainer.attr('id');
      let appendingSelector = dotsAppendTo;

      if (liquidIsElementor) {
        carouselId = `elementor-element elementor-element-${this.$element.closest('.elementor-element').attr('data-id')}`;
      }

      if (appendingSelector === 'parent_row') {
        appendingSelector = liquidIsElementor ? this.$element.closest('.elementor-section') : this.$element.closest('.vc_row');
      }

      if (appendingSelector === 'self') {
        appendingSelector = this.$carouselContainer;
      }

      carouselDots.append(dotsHolder);
      const carouselDotsClassnames = [carouselId];
      $.each($(this.$carouselContainer.get(0).classList), (i, className) => {
        if (className.indexOf('carousel-dots-') >= 0) carouselDotsClassnames.push(className);
      });
      carouselDots.addClass(carouselDotsClassnames.join(' '));

      if (appendingSelector != null) {
        if ($(appendingSelector).hasClass('vc_column_container')) {
          const $wpbWrapperElement = $(appendingSelector).children('.vc_column-inner ').children('.wpb_wrapper');
          carouselDots.appendTo($wpbWrapperElement);
        } else if ($(appendingSelector).hasClass('elementor-column')) {
          const $wrappingEl = $(appendingSelector).children('.elementor-widget-wrap');
          $wrappingEl.children('.elementor-empty-view').remove();
          carouselDots.appendTo($wrappingEl);
        } else {
          carouselDots.appendTo(appendingSelector);
        }

        $(appendingSelector).addClass('carousel-dots-appended');
      } else {
        carouselDots.appendTo(this.$carouselContainer);
      }

      this.carouselDotsElement = carouselDots.get(0);
    },

    carouselMobileDots() {
      if (!this.options.pageDots || this.options.marquee) return;
      const {
        carouselEl
      } = this.options;
      const carouselId = carouselEl ? this.$carouselEl.attr('id') : this.$carouselContainer.attr('id');
      const mobileDotsClassnames = [carouselId];
      $.each($(this.$carouselContainer.get(0).classList), (i, className) => {
        if (className.indexOf('carousel-dots-mobile-') >= 0) mobileDotsClassnames.push(className);
      });
      const $dotsHolder = $(this.flickityData.pageDots.holder).clone(true);
      const $carouselMobileDots = $(`<div class="carousel-dots-mobile carousel-dots-style4 ${mobileDotsClassnames.join(' ')}"></div>`);
      $carouselMobileDots.append($dotsHolder);

      if (this.carouselDotsElement && this.$carouselEl.has(this.carouselDotsElement).length) {
        $carouselMobileDots.insertBefore(this.carouselDotsElement);
      } else {
        $carouselMobileDots.appendTo(this.$carouselContainer);
        $(this.carouselDotsElement).addClass('carousel-dots-hidden-onmobile');
      }

      this.carouselMobileDotsElement = $carouselMobileDots.get(0);
      const dots = this.carouselMobileDotsElement.querySelectorAll('.dot');
      dots.forEach((dot, i) => {
        dot.addEventListener('click', () => {
          this.flickityData.select(i);
          this.carouselMobileDotsClasslist(dot, i);
        });
      });
      this.flickityData.on('select', i => this.carouselMobileDotsClasslist.call(this, dots[i], i));
    },

    carouselMobileDotsClasslist(activeItem, activeItemIndex) {
      if (!activeItem) return;
      activeItem.classList.add('is-selected');
      const inActives = [...this.carouselMobileDotsElement.querySelectorAll('.dot')].filter((inactiveItem, inactiveIndex) => activeItemIndex !== inactiveIndex);
      inActives.forEach(inactiveItem => {
        inactiveItem.classList.remove('is-selected');
      });
    },

    carouselDotsNumbers() {
      if (!this.options.pageDots || this.options.dotsIndicator !== 'numbers') return;
      const {
        flickityData
      } = this;
      const {
        numbersStyle
      } = this.options;
      const $dotsHolder = $(flickityData.pageDots.holder);
      let $svgMarkup;

      if (numbersStyle === 'circle') {
        const $numbers = this.createSlideNumbers(false);
        $svgMarkup = $(`<div class="lqd-carousel-slides-numbers d-inline-flex pos-rel">
					<svg xmlns="http://www.w3.org/2000/svg" width="150" height="152" viewBox="-2 0 154 150" class="w-100 h-100">
						<circle fill="none" cx="75" cy="75" r="74.5"/>
						<path fill="none" stroke-dashoffset="${this.carouselSlidesPathLength}" stroke-dasharray="${this.carouselSlidesPathLength}" stroke-width="3" x="2" d="M75,150 C116.421356,150 150,116.421356 150,75 C150,33.5786438 116.421356,0 75,0 C33.5786438,0 0,33.5786438 0,75 C0,116.421356 33.5786438,150 75,150 Z"/>
					</svg>
				</div>`);
        $numbers.prependTo($svgMarkup);
      } else if (numbersStyle === 'line') {
        const $numbers = this.createSlideNumbers(true);
        $svgMarkup = $(`<div class="lqd-carousel-slides-numbers d-inline-flex pos-rel lqd-carousel-numbers-line">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke-width="2" width="${this.carouselSlidesPathLength}" height="1" viewBox="0 0 ${this.carouselSlidesPathLength} 1">
				<path opacity="0.15" d="M1 1 ${this.carouselSlidesPathLength} 1 ${this.carouselSlidesPathLength} 2 1 2z"></path>
				<path stroke-dashoffset="${this.carouselSlidesPathLength}" stroke-dasharray="${this.carouselSlidesPathLength}" d="M1 1 ${this.carouselSlidesPathLength} 1 ${this.carouselSlidesPathLength} 2 1 2z"></path>
				</svg>
				</div>`);
        $numbers.prependTo($svgMarkup);
      }

      $dotsHolder.appendTo($svgMarkup);
      $svgMarkup.appendTo(this.carouselDotsElement);
      this.$carouselTotalSlides = $('.lqd-carousel-slides-total', $svgMarkup);
      this.$carouselCurrentSlide = $('.lqd-carousel-slides-current', $svgMarkup);
      this.$carouselSlidesShape = $('svg', $svgMarkup);
    },

    addSlideNumbersToArrows() {
      if (!this.options.prevNextButtons || !this.options.addSlideNumbersToArrows) return;
      const {
        prevButton
      } = this.flickityData;
      const prevButtonEl = prevButton.element;
      const $numbers = this.createSlideNumbers();
      $numbers.insertAfter(prevButtonEl);
      this.$carouselTotalSlides = $('.lqd-carousel-slides-total', $(prevButtonEl).next('.lqd-carousel-slides'));
      this.$carouselCurrentSlide = $('.lqd-carousel-slides-current', $(prevButtonEl).next('.lqd-carousel-slides'));
    },

    createSlideNumbers(isZeroBased) {
      const totalSlides = (this.flickityData.slides.length < 10 && isZeroBased ? '0' : '') + this.flickityData.slides.length;
      const $markup = $(`<div class="lqd-carousel-slides d-flex align-items-center justify-content-center lqd-overlay">
				<div class="lqd-carousel-slides-current d-inline-block overflow-hidden ws-nowrap text-center"></div>
				<svg width="32" height="32" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" style="width: 1em; height: 1em;"><path fill="currentColor" d="M6 15.77a1 1 0 0 1 1-1h18.05a1 1 0 1 1 0 2h-18.04a1 1 0 0 1-1.01-1z"></path></svg>
				<div class="lqd-carousel-slides-total">${totalSlides}</div>
			</div>`);
      return $markup;
    },

    addSlidesCurrentNumbers() {
      if (this.options.dotsIndicator !== 'numbers' && !this.options.addSlideNumbersToArrows) {
        return false;
      }

      ;
      const {
        flickityData
      } = this;
      const {
        numbersStyle
      } = this.options;
      const isZeroBased = numbersStyle === 'line';
      const $currentInner = $('<div class="lqd-carousel-slides-current-inner d-inline-block" />');

      for (let i = 1; i <= flickityData.slides.length; i++) {
        $currentInner.append(`<span class="d-inline-block">${i < 10 && isZeroBased ? '0' : ''}${i}</span>`);
      }

      $currentInner.appendTo(this.$carouselCurrentSlide);
      this.$carouselCurrentSlideInner = $currentInner;
    },

    changeSlidesNumbers() {
      if (this.options.dotsIndicator !== 'numbers' && !this.options.addSlideNumbersToArrows) {
        return false;
      }

      ;
      const {
        flickityData
      } = this;
      const slidesPercentage = Math.floor(Math.abs(Math.floor(flickityData.x + flickityData.cursorPosition)) / Math.abs(Math.floor(flickityData.slidesWidth)) * 100);
      const slidesLength = flickityData.slides.length;
      const translateVal = slidesPercentage / slidesLength * (slidesLength - 1);
      this.$carouselCurrentSlideInner.css({
        transform: `translateX(${Math.min(Math.max(translateVal, 0), 100) * -1}%)`
      });
    },

    changeSlidesShape() {
      if (!this.options.pageDots || this.options.dotsIndicator !== 'numbers') {
        return false;
      }

      const {
        flickityData
      } = this;
      const $pathElement = this.$carouselSlidesShape.find('path').last();
      const pathLength = this.carouselSlidesPathLength;
      const slidesPercentage = Math.floor(Math.abs(Math.floor(flickityData.x + flickityData.cursorPosition)) / Math.abs(Math.floor(flickityData.slidesWidth)) * 100);
      const dashOffset = pathLength - slidesPercentage / 100 * pathLength;
      $pathElement.css('stroke-dashoffset', Math.abs(dashOffset));
    },

    fullwidthSide() {
      if (!this.options.fullwidthSide) return;
      const viewportEl = $(this.flickityData.viewport);
      const elementWidth = this.flickityData.size.width - parseInt(this.$element.css('padding-left'), 10);
      const viewportElOffset = viewportEl.offset();
      const windowWidth = liquidWindowWidth();
      const viewportElOffsetRight = windowWidth - (elementWidth + viewportElOffset.left);
      const margin = !this.isRTL ? 'marginRight' : 'marginLeft';
      const padding = !this.isRTL ? 'paddingRight' : 'paddingLeft';
      let existingViewportWrap = viewportEl.parent('.flickity-viewport-wrap');
      let viewportElWrap = existingViewportWrap.length ? existingViewportWrap : $('<div class="flickity-viewport-wrap overflow-hidden" />');

      if (!existingViewportWrap.length) {
        viewportEl.wrap(viewportElWrap);
        viewportEl.removeClass('overflow-hidden');
        viewportElWrap = viewportEl.parent();
        viewportEl.css('overflow', 'visible');
      }

      viewportElWrap.css({
        [margin]: '',
        [padding]: ''
      });
      viewportElWrap.css({
        [margin]: viewportElOffsetRight >= 0 ? (viewportElOffsetRight - 1) * -1 : viewportElOffsetRight - 1,
        [padding]: Math.abs(viewportElOffsetRight - 1)
      });
      this.flickityData.resize();
    },

    randomVerOffset() {
      if (this.options.randomVerOffset) {
        const cellsArray = this.flickityData.cells;
        let maxHeight = 0;

        for (let i = 0; i < cellsArray.length; i++) {
          const $cell = $(cellsArray[i].element);
          const itemHeight = cellsArray[i].size.height;

          if (itemHeight > maxHeight) {
            maxHeight = itemHeight;
          }

          const maxOffset = maxHeight - itemHeight;
          const offset = (Math.random() * maxOffset).toFixed();
          $cell.children('.carousel-item-inner').css("top", offset + "px");
        }
      }
    },

    navOffsets() {
      const {
        options
      } = this;
      const {
        navOffsets
      } = options;
      const $carouselNavElement = $(this.carouselNavElement);

      if (navOffsets && $carouselNavElement && this.flickityData.options.prevNextButtons) {
        const prevButton = $(this.flickityData.prevButton.element);
        const nextButton = $(this.flickityData.nextButton.element);

        if (navOffsets.nav) {
          for (const offset in navOffsets.nav) {
            let val = navOffsets.nav[offset].trim();
            val.match(/^-?\d*(\.\d+){0,1}(%|in|cm|mm|em|rem|ex|pt|pc|px|vw|vh|vmin|vmax)$/) || (val = isNaN(parseFloat(val)) ? "" : parseFloat(val) + "px");
            $carouselNavElement.css(offset.trim(), val);
          }
        }

        prevButton.css({
          left: navOffsets.prev
        });
        nextButton.css({
          right: navOffsets.next
        });
      }
    },

    setElementNavArrow() {
      if (!this.options.prevNextButtons) {
        return false;
      }

      const navArrowsArray = this.navArrows;
      const prevButton = this.flickityData.prevButton ? this.flickityData.prevButton.element : null;
      const nextButton = this.flickityData.nextButton ? this.flickityData.nextButton.element : null;
      let elementNavArrow = this.options.navArrow;
      let prevIcon;
      let nextIcon;

      if (typeof elementNavArrow !== 'object') {
        elementNavArrow = elementNavArrow - 1;

        if (!this.isRTL) {
          prevIcon = $(navArrowsArray[elementNavArrow].prev);
          nextIcon = $(navArrowsArray[elementNavArrow].next);
        } else {
          prevIcon = $(navArrowsArray[elementNavArrow].next);
          nextIcon = $(navArrowsArray[elementNavArrow].prev);
        }
      } else {
        prevIcon = $(this.options.navArrow.prev);
        nextIcon = $(this.options.navArrow.next);
      }

      if (prevButton || nextButton) {
        $(prevButton).find('svg').remove().end().append(prevIcon);
        $(nextButton).find('svg').remove().end().append(nextIcon);
      }
    },

    navArrows: [{
      prev: '<svg width="27" height="16" viewBox="0 0 27 16" xmlns="http://www.w3.org/2000/svg"> <path d="M2.5 7.75H27V9H2.5L9 15L8 16L0 8.5L8 0L9 1L2.5 7.75Z" /> </svg>',
      next: '<svg width="27" height="16" viewBox="0 0 27 16" xmlns="http://www.w3.org/2000/svg"> <path d="M24.5 7.75H0V9H24.5L18 15L19 16L27 8.5L19 0L18 1L24.5 7.75Z"/> </svg>'
    }, {
      prev: '<svg width="32" height="18" viewBox="0 0 32 18" xmlns="http://www.w3.org/2000/svg"> <path d="M8.77638 0.223663L10.2018 1.64911L3.85885 7.99209H32V10.008H3.85885L10.2018 16.3509L8.77638 17.7763L1.71102e-06 8.99997L8.77638 0.223663Z"/> </svg> ',
      next: '<svg width="32" height="18" viewBox="0 0 32 18" xmlns="http://www.w3.org/2000/svg"> <path d="M23.2236 0.223663L21.7982 1.64911L28.1412 7.99209H0V10.008H28.1412L21.7982 16.3509L23.2236 17.7763L32 8.99997L23.2236 0.223663Z"/> </svg>'
    }, {
      prev: '<svg width="20" height="18" viewBox="0 0 32 28" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12.9881 0.478424L0.377096 13.0899C-0.12566 13.5922 -0.12566 14.4072 0.377096 14.91L12.9881 27.5214C13.2395 27.7728 13.5685 27.8985 13.8979 27.8985C14.2274 27.8985 14.5564 27.7728 14.8077 27.5214C15.3105 27.0191 15.3105 26.2041 14.8077 25.7018L4.39347 15.2871H30.7132C31.424 15.2871 32.0001 14.7105 32.0001 14.0002C32.0001 13.2898 31.4239 12.7133 30.7132 12.7133H4.39338L14.8077 2.29851C15.3105 1.79619 15.3105 0.981181 14.8077 0.478424C14.305 -0.0238953 13.4909 -0.0238953 12.9881 0.478424Z"/> </svg>',
      next: '<svg width="20" height="18" viewBox="0 0 32 28" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" clip-rule="evenodd" d="M19.012 0.478424L31.623 13.0899C32.1257 13.5921 32.1257 14.4072 31.623 14.9099L19.012 27.5214C18.7606 27.7728 18.4316 27.8985 18.1021 27.8985C17.7727 27.8985 17.4437 27.7728 17.1923 27.5214C16.6896 27.0191 16.6896 26.2041 17.1923 25.7018L27.6066 15.287H1.28687C0.57605 15.287 0 14.7105 0 14.0002C0 13.2898 0.576111 12.7132 1.28687 12.7132H27.6067L17.1923 2.29849C16.6896 1.79617 16.6896 0.981171 17.1923 0.478424C17.6951 -0.0238953 18.5092 -0.0238953 19.012 0.478424Z"/> </svg>'
    }, {
      prev: '<svg width="10" height="19" viewBox="0 0 33 60" xmlns="http://www.w3.org/2000/svg"> <path d="M1.41739 28L28.823 0.670159C29.7209 -0.224745 31.1747 -0.22324 32.0711 0.674788C32.9668 1.5727 32.9645 3.02725 32.0664 3.92285L6.29209 29.626L32.0674 55.3291C32.9653 56.2248 32.9676 57.6784 32.072 58.5765C31.6226 59.0266 31.0339 59.2517 30.4452 59.2517C29.8581 59.2517 29.2717 59.0281 28.8231 58.5811L1.41739 31.252C0.984926 30.8217 0.742248 30.2361 0.742248 29.626C0.742248 29.0159 0.98562 28.4311 1.41739 28Z"/> </svg>',
      next: '<svg width="10" height="19" viewBox="0 0 33 60" xmlns="http://www.w3.org/2000/svg"> <path d="M32.0671 28L4.66149 0.670159C3.76358 -0.224745 2.30984 -0.22324 1.41343 0.674788C0.517715 1.5727 0.52003 3.02725 1.41806 3.92285L27.1924 29.626L1.41713 55.3291C0.519219 56.2248 0.516905 57.6784 1.4125 58.5765C1.86186 59.0266 2.45056 59.2517 3.03926 59.2517C3.62645 59.2517 4.21283 59.0281 4.66138 58.5811L32.0671 31.252C32.4996 30.8217 32.7422 30.2361 32.7422 29.626C32.7422 29.0159 32.4989 28.4311 32.0671 28Z"/> </svg>'
    }, {
      prev: '<svg width="16" height="17" viewBox="0 0 16 17" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" clip-rule="evenodd" d="M15.612 16.0721C15.6116 16.2693 15.4515 16.4289 15.2542 16.4286C15.1593 16.4286 15.0684 16.3908 15.0014 16.3236L7.14431 8.46655C7.00489 8.32706 7.00489 8.101 7.14431 7.96154L15.0014 0.104495C15.141 -0.0351572 15.3674 -0.0351572 15.5071 0.104495C15.6467 0.244147 15.6467 0.47055 15.5071 0.610202L7.90217 8.21436L15.5071 15.8186C15.5744 15.8857 15.6122 15.977 15.612 16.0721ZM9.18351 16.0721C9.18314 16.2693 9.02297 16.4289 8.82573 16.4286C8.73118 16.4286 8.64051 16.3911 8.57358 16.3243L0.716562 8.46727C0.577143 8.32778 0.577143 8.10171 0.716562 7.96226L8.57361 0.105214C8.71199 -0.0284448 8.9314 -0.0284448 9.06981 0.105214C9.21167 0.242255 9.21562 0.468357 9.07858 0.610219L1.47368 8.21438L9.07858 15.8186C9.14591 15.8857 9.18368 15.977 9.18351 16.0721Z"/> </svg>',
      next: '<svg width="16" height="17" viewBox="0 0 16 17" xmlns="http://www.w3.org/2000/svg"> <path d="M0.612 16.0721C0.61237 16.2693 0.772547 16.4289 0.969787 16.4286C1.06467 16.4286 1.15564 16.3908 1.22264 16.3236L9.07969 8.46655C9.21911 8.32706 9.21911 8.101 9.07969 7.96154L1.22264 0.104495C1.08299 -0.0351572 0.856586 -0.0351572 0.716933 0.104495C0.577281 0.244147 0.577281 0.47055 0.716933 0.610202L8.32183 8.21436L0.716933 15.8186C0.649602 15.8857 0.611834 15.977 0.612 16.0721Z"/> <path d="M7.04049 16.0721C7.04085 16.2693 7.20103 16.4289 7.39827 16.4286C7.49282 16.4286 7.58349 16.3911 7.65042 16.3243L15.5074 8.46727C15.6469 8.32778 15.6469 8.10171 15.5074 7.96226L7.65039 0.105214C7.51201 -0.0284448 7.2926 -0.0284448 7.15419 0.105214C7.01233 0.242255 7.00838 0.468357 7.14542 0.610219L14.7503 8.21438L7.14542 15.8186C7.07809 15.8857 7.04032 15.977 7.04049 16.0721Z"/> </svg>'
    }, {
      prev: '<svg width="16" height="16" xmlns="http://www.w3.org/2000/svg"> <polygon transform="rotate(180 7.999999999999999,8) " points="9.3,1.3 7.9,2.7 12.2,7 0,7 0,9 12.2,9 7.9,13.3 9.3,14.7 16,8 "/> </svg>',
      next: '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16 16" xml:space="preserve" width="16" height="16"><polygon points="9.3,1.3 7.9,2.7 12.2,7 0,7 0,9 12.2,9 7.9,13.3 9.3,14.7 16,8 "></polygon></svg>'
    }],

    setEqualHeightCells() {
      if (!this.options.equalHeightCells || this.element.classList.contains('flickity-equal-cells')) return;
      const {
        carouselEl
      } = this;

      Flickity.prototype._createResizeClass = function () {
        carouselEl.classList.add('flickity-equal-cells');
      };

      Flickity.createMethods.push('_createResizeClass');
      var resize = Flickity.prototype.resize;

      Flickity.prototype.resize = function () {
        carouselEl.classList.remove('flickity-equal-cells');
        resize.call(this);
        carouselEl.classList.add('flickity-equal-cells');
      };
    },

    parallax() {
      if (!this.options.parallax || liquidIsMobile()) {
        return false;
      }

      this.flickityData.cells.forEach((cell, i) => {
        const multiply = !this.isRTL ? -1 : 1;
        const x = (cell.target + this.flickityData.x) * multiply / 3;
        const $cellElement = $(cell.element);
        const $cellImage = $cellElement.find(this.options.parallaxEl);

        if (!$cellImage.parent('.ld-carousel-parallax-wrap').length) {
          $cellImage.wrap('<div class="ld-carousel-parallax-wrap overflow-hidden"></div>');
        }

        if ($cellImage.is(':only-child')) {
          $cellImage.css({
            willChange: 'transform',
            '-webkit-transform': `translateX(${x}px)`,
            'transform': `translateX(${x}px)`
          });
        }
      });
    },

    controllingCarousels() {
      const {
        options
      } = this;
      const {
        controllingCarousels
      } = options;

      if (typeof controllingCarousels !== typeof undefined && controllingCarousels !== null && controllingCarousels.length) {
        const $controlledCarousels = $(controllingCarousels.map(carousel => $(carousel).children('[data-lqd-flickity]')));
        $.each($controlledCarousels, (i, controlledCarousel) => {
          const $controlledCarousel = $(controlledCarousel);
          $controlledCarousel.imagesLoaded(() => {
            const controlledCarouselData = $controlledCarousel.data('plugin_liquidCarousel');

            if (controlledCarouselData) {
              controlledCarouselData.carouselInitPromise.then(() => {
                $controlledCarousel.parent().addClass('is-controlled-carousel');
                controlledCarouselData.carouselMobileDotsElement && controlledCarouselData.carouselMobileDotsElement.classList.add('hidden');
                this.flickityData.on('change', i => {
                  controlledCarouselData.flickityData.select(i);
                });
                controlledCarouselData.flickityData.on('change', i => {
                  this.flickityData.select(i);
                });
              });
            }
          });
        });
      }
    },

    getCellsArray() {
      return this.flickityData.cells.map(cell => cell.element);
    },

    doSomethingCrazyWithFilter() {
      if (!this.options.doSomethingCrazyWithFilters || liquidIsMobile() || liquidWindowWidth() <= 992) return false;
      const header = $('.lqd-pf-carousel-header', this.$carouselContainer).get(0);
      if (!header) return false;
      const {
        x
      } = this.flickityData;
      const firstVisibleCell = this.flickityData.cells.filter(cell => $(cell.element).is(':visible'))[0];
      const firstCellWidth = firstVisibleCell.size.width;
      const opacityVal = gsap.utils.normalize(-firstCellWidth, 0, x);
      const rotationVal = gsap.utils.mapRange(0, -firstCellWidth, 0, -100, x);
      const zVal = gsap.utils.mapRange(0, -firstCellWidth, 0, -300, x);
      $(header).parent().addClass('perspective');
      gsap.to(header, {
        opacity: opacityVal,
        z: zVal,
        rotationY: rotationVal,
        duration: 0.6,
        ease: 'expo.out'
      });
    },

    filtersInit() {
      if (!this.options.filters) return;
      const {
        filtersCounter,
        filters
      } = this.options;
      const $filters = $(filters);
      const $filterItems = $('[data-filter]', $filters);
      const $filterDropdown = $filters.siblings('.lqd-filter-dropdown');
      $filterItems.each((i, filterItem) => {
        const $filterItem = $(filterItem);
        const filterValue = $filterItem.attr('data-filter');
        filtersCounter && this.addFilterCounts($filterItem, filterValue);
        $filterItem.on('click', () => {
          if (!$filterItem.hasClass('active')) {
            $filterItem.addClass('active').siblings().removeClass('active');
            this.filterAnimateStart(filterValue);
          }
        });

        if ($filterDropdown.length) {
          $('select', $filterDropdown).on('selectmenuchange', (event, ui) => {
            const filterVal = ui.item.value;
            this.filterAnimateStart(filterVal);
          });
        }
      });
    },

    addFilterCounts($filterItem, filterValue) {
      const count = filterValue === '*' ? this.flickityData.cells.length : $(filterValue, this.element).length;
      const $counter = $(`
				<sup class="lqd-filter-counter">
					<span>${count}</span>
				</sup>`);
      $counter.appendTo($filterItem);
    },

    filterAnimateStart(filterValue) {
      const visibleCells = this.getCellsArray().filter(element => !element.classList.contains('hidden'));
      gsap.to(visibleCells, {
        x: '-=10%',
        opacity: 0,
        ease: 'power4.inOut',
        duration: 0.6,
        stagger: 0.1,
        clearProps: 'x',
        onStart: () => {
          if (this.options.equalHeightCells) {
            const $cells = $(this.flickityData.cells);
            const currentHeight = this.flickityData.size.height;
            $cells.css('minHeight', currentHeight);
          }

          $(visibleCells).css({
            transition: 'none'
          });
        },
        onComplete: this.filterItems.bind(this, filterValue)
      });
    },

    filterItems(filterValue) {
      const cells = this.getCellsArray();
      this.$element.find('.hidden').removeClass('hidden');

      if (filterValue != '*') {
        $(cells).not(filterValue).addClass('hidden');
      }

      this.flickityData.resize();
      this.flickityData.reposition();
      this.filterAnimateComplete();
    },

    filterAnimateComplete() {
      const visibleCells = this.getCellsArray().filter(element => !element.classList.contains('hidden'));
      const timeline = gsap.timeline({
        defaults: {
          duration: 0.6,
          ease: 'power4.out'
        },
        onComplete: () => {
          $(visibleCells).css({
            transition: '',
            opacity: ''
          });
        }
      });
      visibleCells.forEach(cell => {
        const currentX = gsap.getProperty(cell, 'x', '%');
        timeline.fromTo(cell, {
          x: '+=10%'
        }, {
          x: currentX,
          opacity: 1
        }, '<+=0.1');
      });

      if (this.carouselMobileDotsElement) {
        this.carouselMobileDotsElement.remove();
        this.carouselMobileDots();
      }
    },

    marquee() {
      if (!this.options.marquee) return;
      this.marqueeIsPaused = true;
      this.flickityData.x = 0;

      const IO = () => {
        new IntersectionObserver(([entry]) => {
          if (entry.isIntersecting) {
            this.sliderElement.style.willChange = 'transform';
            this.marqueePlay.call(this);
          } else {
            this.sliderElement.style.willChange = '';
            this.marqueePause.call(this);
          }
        }, {
          rootMargin: '50%'
        }).observe(this.element);
      };

      if (this.options.pauseAutoPlayOnHover) {
        this.element.addEventListener('mouseenter', this.marqueePause.bind(this), false);
        this.element.addEventListener('focusin', this.marqueePause.bind(this), false);
        this.element.addEventListener('mouseleave', this.marqueePlay.bind(this), false);
        this.element.addEventListener('focusout', this.marqueePlay.bind(this), false);
      }

      this.flickityData.on('dragStart', this.marqueePause.bind(this));
      this.flickityData.on('dragEnd', !this.options.pauseAutoPlayOnHover && this.marqueePlay.bind(this));
      IO();
    },

    marqueePlay() {
      if (this.marqueeIsPaused) {
        this.marqueeIsPaused = false;
        window.requestAnimationFrame(this.marqueeUpdate.bind(this));
      }
    },

    marqueePause() {
      this.marqueeIsPaused = true;
    },

    marqueeUpdate() {
      if (this.marqueeIsPaused) return;

      if (this.flickityData.slides) {
        this.flickityData.x = (this.flickityData.x - this.options.marqueeTickerSpeed) % this.flickityData.slideableWidth;
        this.flickityData.settle(this.flickityData.x);
      }

      window.requestAnimationFrame(this.marqueeUpdate.bind(this));
    },

    destroy() {
      $(window).off('resize.lqdCarousel');
    }

  };

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('lqd-flickity'),
        ...options
      };

      if (pluginOptions.pageDots) {
        pluginOptions.hasPageDotsFromOptions = true;
      } else {
        pluginOptions.hasPageDotsFromOptions = false;
      }

      if (!pluginOptions.forceDisablePageDots) {
        pluginOptions.pageDots = true;
      }

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  const disabledOnMobile = document.body.hasAttribute('data-disable-carousel-onmobile');
  const $carouselElements = $('[data-lqd-flickity]');

  if (liquidIsMobile() && disabledOnMobile) {
    $carouselElements.find('.flickity-viewport').css('overflow-x', 'auto');
    return;
  }

  ;
  $carouselElements.liquidCarousel();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidCarouselStack';
  let defaults = {
    distDragBack: 150,
    distDragMax: 450,
    isRandom: false,
    onUpdateStack: function (current) {
      return false;
    }
  };

  class Plugin {
    constructor(element, options) {
      this.element = element;
      this.$element = $(element);
      this.$container = $('.carousel-items', this.element);
      this.$prevBtn = $('.lqd-carousel-stack-prev', this.element);
      this.$nextBtn = $('.lqd-carousel-stack-next', this.element);
      this.options = $.extend({}, defaults, options);
      this._defaults = defaults;
      this._name = pluginName;
      this.isInit = false;
      this.moveVector = {};
      this.draggie = null;

      this._init();
    }

    shuffle(array) {
      let m = array.length;
      let t;
      let i;

      while (m) {
        i = Math.floor(Math.random() * m--);
        t = array[m];
        array[m] = array[i];
        array[i] = t;
      }

      return array;
    }

    setTransformStyle(el, tval) {
      el.style.WebkitTransform = tval;
      el.style.msTransform = tval;
      el.style.transform = tval;
    }

    initSetting() {
      this.itemsCount = this.items.length;

      this._setContainerHeight();

      this._setStackStyle();

      if (this.itemsCount <= 1) return;

      if (!this.isInit) {
        this._initDragg();

        this._initEvents();
      }

      this.isInit = true;
    }

    _init() {
      this.items = this.$container.children().get();

      if (this.options.isRandom) {
        this.shuffle(this.items);
      }

      this.current = 0;
      this.initSetting();
    }

    _initEvents() {
      const onResize = liquidDebounce(this.onResize.bind(this), 750);
      this.draggie.on('dragMove', (event, pointer, moveVector) => {
        this._onDragMove.call(this, event, moveVector);
      });
      this.draggie.on('dragEnd', event => {
        this._onDragEnd.call(this, event);
      });
      this.$prevBtn.on('click', this.goToPrev.bind(this));
      this.$nextBtn.on('click', this.goToNext.bind(this));
      $liquidWindow.on('resize.lqdCarouselStack', onResize);
    }

    _setContainerHeight() {
      this.element.style.height = `${this._firstItem().offsetHeight}px`;
    }

    _setStackStyle(direction) {
      var item1 = this._firstItem(),
          item2 = this._secondItem(),
          item3 = this._thirdItem();

      this.items.forEach(item => item.classList.remove('is-first', 'is-second', 'is-third'));

      if (item1) {
        item1.style.zIndex = 4;
        item1.classList.add('is-first');
        gsap.to(item1, {
          ease: 'power4.out',
          duration: 0.6,
          x: 0,
          y: 0,
          z: 0
        });
      }

      if (item2) {
        item2.style.zIndex = 3;
        item2.classList.add('is-second');
        gsap.to(item2, {
          startAt: {
            x: 0,
            y: 0,
            z: () => {
              if (!direction || direction === 'next') {
                return -180;
              } else {
                return 0;
              }
            }
          },
          x: 0,
          y: 0,
          z: () => {
            if (!direction || direction === 'next') {
              return -80;
            } else {
              return -80;
            }
          },
          ease: 'power4.out',
          duration: 0.6
        });
      }

      if (item3) {
        item3.style.zIndex = 2;
        item3.classList.add('is-third');
        gsap.to(item3, {
          startAt: {
            x: 0,
            y: 0,
            z: () => {
              if (!direction || direction === 'next') {
                return -280;
              } else {
                return 0;
              }
            }
          },
          x: 0,
          y: 0,
          z: () => {
            if (!direction || direction === 'next') {
              return -180;
            } else {
              return -180;
            }
          },
          duration: 0.6,
          ease: 'power4.out'
        });
      }
    }

    _moveAway(direction) {
      const tVal = this._getTranslateVal(direction);

      let item1;
      let initiated = false;

      this._disableDragg();

      if (!direction || direction === 'next') {
        item1 = this.draggie.element;
      } else {
        item1 = this.draggie.element.previousElementSibling || this.items[this.itemsCount - 1];
        this.draggie.element.style.zIndex = 3;
        item1.style.zIndex = 4;
      }

      gsap.killTweensOf(item1);
      const item1Tween = gsap.to(item1, {
        startAt: {
          z: tVal.z[0],
          opacity: () => {
            if (direction !== 'prev') {
              return 1;
            } else {
              return 0;
            }
          }
        },
        duration: 0.6,
        ease: 'power4.out',
        x: tVal.x,
        y: tVal.y || 0,
        z: tVal.z[1],
        opacity: () => {
          if (direction !== 'prev') {
            return 0;
          } else {
            return 1;
          }
        },
        onUpdate: () => {
          if (item1Tween.progress() >= 0.5 && !initiated) {
            initiated = true;
            this.onEndTransFn(direction);
          }
        },
        onComplete: () => {
          this.onCompleteTransFn(item1);
        }
      });

      const item2 = this._secondItem();

      const item3 = this._thirdItem();

      if (item2) {
        gsap.to(item2, {
          ease: 'power4.out',
          duration: 0.6,
          x: 0,
          y: 0,
          z: -80
        });
      }

      if (item3) {
        gsap.to(item3, {
          ease: 'power4.out',
          duration: 0.6,
          x: 0,
          y: 0,
          z: -180
        });
      }
    }

    onEndTransFn(direction) {
      gsap.to(this.draggie.element, {
        x: 0,
        y: 0,
        z: -180,
        ease: 'power4.out',
        duration: 0.6,
        onComplete: () => {
          this.draggie.element.style.transform = '';
        }
      });

      if (!direction || direction === 'next') {
        this.draggie.element.style.left = this.draggie.element.style.top = '0px';
        this.draggie.element.style.zIndex = -1;
        this.current = this.current < this.itemsCount - 1 ? this.current + 1 : 0;
      } else {
        this.draggie.element.style.zIndex = 4;
        this.current = this.current > 0 ? this.current - 1 : this.itemsCount - 1;
      }

      this._setStackStyle(direction);

      this._initDragg();

      this._initEvents();

      this.options.onUpdateStack(this.current);
    }

    onCompleteTransFn(animatedTarget) {
      animatedTarget.style.opacity = '';
    }

    _moveBack() {
      const item2 = this._secondItem();

      const item3 = this._thirdItem();

      gsap.to(this.draggie.element, {
        startAt: {
          x: this.moveVector.x,
          y: this.moveVector.y
        },
        ease: 'power4.out',
        duration: 0.6,
        x: 0,
        y: 0,
        z: 0
      });
      this.draggie.element.style.left = '0px';
      this.draggie.element.style.top = '0px';

      if (item2) {
        gsap.to(item2, {
          ease: 'power4.out',
          duration: 0.6,
          x: 0,
          y: 0,
          z: -80
        });
      }

      if (item3) {
        gsap.to(item3, {
          ease: 'power4.out',
          duration: 0.6,
          x: 0,
          y: 0,
          z: -180
        });
      }
    }

    _onDragMove(event, moveVector) {
      this.moveVector = moveVector;

      if (this._outOfBounds()) {
        this._moveAway();
      } else {
        const item2 = this._secondItem();

        const item3 = this._thirdItem();

        if (item2) {
          gsap.to(item2, {
            ease: 'power4.out',
            duration: 0.3,
            x: this.moveVector.x * 0.6,
            y: this.moveVector.y * 0.6
          });
        }

        if (item3) {
          gsap.to(item3, {
            ease: 'power4.out',
            duration: 0.3,
            x: this.moveVector.x * 0.3,
            y: this.moveVector.y * 0.3
          });
        }
      }
    }

    _onDragEnd() {
      if (this._outOfBounds()) return;

      if (this._outOfSight()) {
        this._setContainerHeight();

        this._moveAway();
      } else {
        this._moveBack();
      }
    }

    _initDragg() {
      this.draggie = new Draggabilly(this.items[this.current], {
        handle: '.lqd-carousel-handle'
      });
    }

    _disableDragg() {
      this.draggie.disable();
    }

    _outOfBounds() {
      return Math.abs(this.moveVector.x) > this.options.distDragMax || Math.abs(this.moveVector.y) > this.options.distDragMax;
    }

    _outOfSight() {
      return Math.abs(this.moveVector.x) > this.options.distDragBack || Math.abs(this.moveVector.y) > this.options.distDragBack;
    }

    _getTranslateVal(direction) {
      var h = Math.sqrt(Math.pow(this.moveVector.x, 2) + Math.pow(this.moveVector.y, 2)),
          a = Math.asin(Math.abs(this.moveVector.y) / h) / (Math.PI / 180),
          hL = h + this.options.distDragBack,
          dx = Math.cos(a * (Math.PI / 180)) * hL,
          dy = Math.sin(a * (Math.PI / 180)) * hL,
          tx = dx - Math.abs(this.moveVector.x),
          ty = dy - Math.abs(this.moveVector.y);

      if (!direction) {
        return {
          x: this.moveVector.x > 0 ? tx : tx * -1,
          y: this.moveVector.y > 0 ? ty : ty * -1,
          z: [0, 0]
        };
      } else if (direction === 'prev') {
        return {
          x: 0,
          y: 0,
          z: [80, 0]
        };
      } else if (direction === 'next') {
        return {
          x: 0,
          y: 0,
          z: [0, 80]
        };
      }
    }

    _firstItem() {
      return this.items[this.current];
    }

    _secondItem() {
      if (this.itemsCount >= 2) {
        return this.current + 1 < this.itemsCount ? this.items[this.current + 1] : this.items[Math.abs(this.itemsCount - (this.current + 1))];
      }
    }

    _thirdItem() {
      if (this.itemsCount >= 3) {
        return this.current + 2 < this.itemsCount ? this.items[this.current + 2] : this.items[Math.abs(this.itemsCount - (this.current + 2))];
      }
    }

    _lastItem() {
      if (this.itemsCount >= 3) {
        return this._thirdItem();
      } else {
        return this._secondItem();
      }
    }

    goToPrev() {
      this._moveAway('prev');
    }

    goToNext() {
      this._moveAway('next');
    }

    add(el) {
      this.$container.appendChild(el);
      this.items.push(el);
      this.initSetting();
    }

    getSize() {
      return this.itemsCount;
    }

    getCurrent() {
      return this.current;
    }

    getCurrentItem() {
      return this.items[this.current];
    }

    insert(el, index) {
      this.$container.insertBefore(el, this.$container.childNodes[index]);
      this.items.splice(index, 0, el);
      this.initSetting();
    }

    remove(index) {
      if (this.items.length === 0) {
        return;
      }

      if (this.current >= index) {
        this.current--;
      }

      this.$container.removeChild(this.$container.childNodes[index]);
      this.items.splice(index, 1);

      if (this.current >= this.items.length) {
        this.current = 0;
      }

      this.initSetting();
    }

    onResize() {
      this._setContainerHeight();
    }

    destroy() {
      $(window).off('resize.lqdCarouselStack');
      this.$prevBtn.off('click');
      this.$nextBtn.off('click');
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('carousel-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  if (liquidWindowWidth() <= 768) return;
  $('.lqd-carousel-stack').liquidCarouselStack();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidCarouselV3d';
  let defaults = {
    itemsSelector: '.carousel-item'
  };

  function Plugin(element, options) {
    this.element = element;
    this.options = $.extend({}, defaults, options);
    this._defaults = defaults;
    this._name = pluginName;
    this.build();
  }

  Plugin.prototype = {
    build: function () {
      this.init();
    },
    init: function () {
      const self = this;
      const element = $(self.element);
      const items = self.options.itemsSelector;
      self.prepareitems();
      const activeItem = $(items, element).first();
      const bottomItem = activeItem.next();
      const topItem = bottomItem.next();
      self.dragY = 0;
      self.startY = 0;
      self.currentY = 0;
      self.setActive(activeItem, element);
      self.initAnim(element, activeItem, topItem, bottomItem);
      self.initDrag();
      self.initClicks();
      element.addClass('carousel-initialized');
      return self;
    },

    prepareitems() {
      const self = this;
      const items = $(self.options.itemsSelector, self.element);

      if (items.length <= 2 && items.length >= 1) {
        const firstItem = items[0];

        for (let i = items.length; i <= 2; i++) {
          $(firstItem).clone(true).appendTo($(self.element).find('.carousel-items'));
        }
      }
    },

    setActive: function (activeItem, element) {
      const currentTopItem = $('.is-top', element);
      const currentActiveItem = $('.is-active', element);
      const currentBottomItem = $('.is-bottom', element);

      if (currentTopItem.length) {
        currentTopItem.addClass('was-top');
      }

      if (currentActiveItem.length) {
        currentActiveItem.addClass('was-active');
      }

      if (currentBottomItem.length) {
        currentBottomItem.addClass('was-bottom');
      }

      activeItem.addClass('is-active').removeClass('is-top is-bottom').siblings().removeClass('is-active');
      this.setBottom(activeItem);
      this.setTop(activeItem);
    },
    setBottom: function (activeItem) {
      const element = $(this.element);
      const items = this.options.itemsSelector;
      const firstItem = $(items, element).first();
      let bottomItem = activeItem.next();

      if (!bottomItem.length && activeItem.is(':last-child')) {
        bottomItem = firstItem;
      }

      bottomItem.addClass('is-bottom').removeClass('is-active is-top was-active').siblings().removeClass('is-bottom');
    },
    setTop: function (activeItem) {
      const element = $(this.element);
      const items = this.options.itemsSelector;
      const lastItem = $(items, element).last();
      let topItem = activeItem.prev();

      if (!topItem.length && activeItem.is(':first-child')) {
        topItem = lastItem;
      }

      topItem.addClass('is-top').removeClass('is-active is-bottom was-active').siblings().removeClass('is-top');
    },
    initAnim: function (element, activeItem, topItem, bottomItem) {
      this.animInited = false;

      if (!this.animInited) {
        const timeline = gsap.timeline({
          duration: 0
        });
        timeline.to(element.get(0).querySelectorAll('.carousel-item:not(.is-active):not(.is-bottom)'), {
          yPercent: -60,
          z: 0,
          scale: 0.9
        }, 0).to(activeItem.get(0), {
          z: 50,
          scale: 1
        }, 0).to(bottomItem.get(0), {
          yPercent: 50,
          z: 0,
          scale: 0.9
        }, 0);
        this.animInited = true;
      }
    },

    initClicks() {
      $(this.element).on('click', '.is-top', this.moveItems.bind(this, 'prev'));
      $(this.element).on('click', '.is-bottom', this.moveItems.bind(this, 'next'));
    },

    initDrag: function () {
      const self = this;
      const element = $(self.element);
      element.on('mousedown', self.pointerStart.bind(self));
      element.on('mousemove', self.pointerMove.bind(self));
      element.on('mouseup', self.pointerEnd.bind(self));
    },
    pointerStart: function (event) {
      const self = this;
      const element = $(self.element);
      self.startY = event.pageY || event.touches[0].pageY;
      self.currentY = self.startY;
      element.addClass('pointer-down');
    },
    pointerMove: function (event) {
      const self = this;
      self.currentY = event.pageY || event.touches[0].pageY;
      self.dragY = parseInt(self.startY - self.currentY, 10);
    },
    pointerEnd: function () {
      const element = $(this.element);
      this.dragY = parseInt(this.startY - this.currentY, 10);

      if (this.dragY >= 20) {
        this.moveItems('next');
      } else if (this.dragY <= -20) {
        this.moveItems('prev');
      }

      element.removeClass('pointer-down');
    },
    moveItems: function (dir) {
      if ($(this.element).hasClass('items-moving')) return;
      const element = $(this.element);
      const items = $(this.options.itemsSelector);
      const bottomItem = $('.is-bottom', element);
      const topItem = $('.is-top', element);
      const animationTimeline = gsap.timeline({
        duration: 0.65,
        onUpdate: () => {
          $(items, element).addClass('is-moving');
        },
        onComplete: () => {
          $(items, element).removeClass('is-moving was-top was-active was-bottom');
          $(this.element).removeClass('items-moving');
        }
      });
      if (dir == 'next') this.setActive(bottomItem, element);else if (dir == 'prev') this.setActive(topItem, element);
      const newActiveItem = $('.is-active', element);
      const newBottomItem = $('.is-bottom', element);
      const newTopItem = $('.is-top', element);

      if (dir == 'next') {
        this.moveNext(animationTimeline, newActiveItem, newBottomItem, newTopItem);
      } else if (dir == 'prev') {
        this.movePrev(animationTimeline, newActiveItem, newBottomItem, newTopItem);
      }
    },
    moveNext: function (animationTimeline, newActiveItem, newBottomItem, newTopItem) {
      $(this.element).addClass('items-moving');
      animationTimeline.fromTo(newTopItem.get(0), {
        rotateX: -18
      }, {
        yPercent: -60,
        z: 0,
        rotateX: 0,
        scale: 0.9
      }, 0).fromTo(newActiveItem.get(0), {
        rotateX: -18
      }, {
        yPercent: 0,
        z: 50,
        rotateX: 0,
        scale: 1
      }, 0).fromTo(newBottomItem.get(0), {
        rotateX: -18
      }, {
        yPercent: 50,
        z: 0,
        rotateX: 0,
        scale: 0.9
      }, 0);
    },
    movePrev: function (animationTimeline, newActiveItem, newBottomItem, newTopItem) {
      $(this.element).addClass('items-moving');
      animationTimeline.fromTo(newTopItem.get(0), {
        rotateX: 18
      }, {
        yPercent: -60,
        z: 0,
        rotateX: 0,
        scale: 0.9
      }, 0).fromTo(newActiveItem.get(0), {
        rotateX: 18
      }, {
        yPercent: 0,
        z: 50,
        rotateX: 0,
        scale: 1
      }, 0).fromTo(newBottomItem.get(0), {
        rotateX: 18
      }, {
        yPercent: 50,
        z: 0,
        rotateX: 0,
        scale: 0.9
      }, 0);
    }
  };

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('plugin-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('.carousel-vertical-3d').liquidCarouselV3d();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidMegamenu';
  let defaults = {};

  class Plugin {
    constructor(element, options) {
      this.options = { ...defaults,
        ...options
      };
      this._defaults = defaults;
      this._name = pluginName;
      this.element = element;
      this.$element = $(this.element);
      this.mobileNavBreakPoint = fastdom.measure(liquidMobileNavBreakpoint)();
      this.tabletBreakpoint = this.mobileNavBreakPoint <= 992 ? 992 : this.mobileNavBreakPoint;
      this.elementBoundingRect = null;
      this.megamenuBoundingRect = null;
      this.megamenuFinalPos = {};
      this.breakpoints = {
        [this.mobileNavBreakPoint - 60]: [this.mobileNavBreakPoint + 1, Infinity],
        940: [992, this.tabletBreakpoint]
      };
      this.$customMenuParent = this.$element.parent().parent('.lqd-custom-menu');
      this.isInCustomMenu = this.$customMenuParent.length && !this.$element.parent().hasClass('inline-nav');
      this.submenu = this.element.querySelector('.nav-item-children');
      this.megamenuRowsWrap = this.submenu.querySelector('.lqd-megamenu-rows-wrap');
      this.megamenuRows = this.megamenuRowsWrap.querySelectorAll(':scope > .elementor > .elementor-section, :scope > .elementor > .e-container, :scope > .elementor > .e-con');
      this.isContentStretched = this.megamenuRowsWrap.classList.contains('container-fluid');
      this.isFullwidth = this.element.classList.contains('megamenu-fullwidth');
      this.windowWidth = fastdom.measure(liquidWindowWidth)();
      this.columnsWidth = 0;
      this.positionApplied = false;
      this.dropdownInfoPromise = new Promise(resolve => {
        this.element.addEventListener('megamenu-position-applied', async () => {
          resolve({
            element: this.element,
            dropdown: this.submenu,
            elementBoundingRect: this.elementBoundingRect,
            megamenuBoundingRect: await this.getMegamenuBoundingRect(),
            megamenuFinalPos: this.megamenuFinalPos
          });
        });
      });
      new IntersectionObserver(([entry], observer) => {
        if (entry.isIntersecting) {
          observer.disconnect();
          this.init();
        }
      }).observe(this.element);
    }

    init() {
      if (this.isInCustomMenu && !this.$customMenuParent.hasClass('lqd-custom-menu-mobile-collapsible') && this.$element.closest('ul').siblings('.lqd-custom-menu-dropdown-btn').length && !this.$element.closest('ul').hasClass('is-active')) {
        this.$element.closest('ul').on('shown.bs.collapse', this.sizing.bind(this));
      } else {
        this.sizing();
      }
    }

    async sizing() {
      if (this.positionApplied) return;
      await this.getColumnsWidth();
      !this.isFullwidth && (await this.setContainerWidth());
      this.elementBoundingRect = await this.getElementBoundingRect();
      this.megamenuBoundingRect = await this.getMegamenuBoundingRect();
      this.positioning();
      this.resizeWindow();

      if (this.isContentStretched) {
        this.element.classList.add('megamenu-content-stretch');
      }
    }

    async getColumnsWidth() {
      if (!this.megamenuRows) {
        return 0;
      }

      ;
      const promises = [];
      this.megamenuRows.forEach(row => {
        const columns = row.querySelectorAll(':scope > .e-container, :scope > .e-con, :scope > .elementor-container > .elementor-column');

        if (!columns) {
          return 0;
        }

        ;
        const promise = new Promise(resolve => {
          let columnsWidth = 0;
          columns.forEach(async column => {
            const styles = getComputedStyle(column);
            const {
              paddingLeft,
              paddingRight
            } = styles;
            columnsWidth += column.offsetWidth + (parseInt(paddingLeft, 10) + parseInt(paddingRight, 10));
          });
          resolve(columnsWidth);
        });
        promises.push(promise);
      });
      const widths = await Promise.all(promises);
      this.columnsWidth = Math.max(...widths);
    }

    setContainerWidth() {
      return fastdomPromised.mutate(() => {
        this.megamenuRowsWrap.style.width = `${this.columnsWidth}px`;
      });
    }

    getGlobalContainerDimensions() {
      const windowWidth = this.windowWidth;
      const dimensions = {
        width: 0,
        offsetLeft: 0
      };
      $.each(this.breakpoints, (containerWidth, windowWidths) => {
        if (windowWidth >= windowWidths[0] && windowWidth <= windowWidths[1]) {
          dimensions.width = parseInt(containerWidth, 10);
          dimensions.offsetLeft = (windowWidth - containerWidth) / 2;
        }
      });
      return dimensions;
    }

    getElementBoundingRect() {
      const rect = {
        width: 0,
        height: 0,
        top: 0,
        left: 0
      };
      return new Promise(resolve => {
        new IntersectionObserver(([entry], observer) => {
          const {
            boundingClientRect
          } = entry;
          observer.disconnect();
          rect.width = boundingClientRect.width;
          rect.height = boundingClientRect.height;
          rect.top = boundingClientRect.top;
          rect.left = boundingClientRect.left;
          resolve(rect);
        }).observe(this.element);
      });
    }

    async getMegamenuBoundingRect() {
      const $carousels = this.$element.find('[data-lqd-flickity]');
      const promises = [];
      const rect = {
        width: 0,
        height: 0,
        top: 0,
        left: 0
      };

      if ($carousels.length) {
        $carousels.each((i, carousel) => {
          $(carousel).liquidCarousel({
            forceApply: true
          });
          const carouselData = $(carousel).data('plugin_liquidCarousel');

          if (carouselData) {
            promises.push(carouselData.carouselInitPromise);
          }
        });
      }

      if (promises.length > 0) {
        await Promise.all(promises);
      }

      return new Promise(resolve => {
        new IntersectionObserver(([entry], observer) => {
          const {
            boundingClientRect
          } = entry;
          observer.disconnect();
          rect.width = boundingClientRect.width;
          rect.height = boundingClientRect.height;
          rect.top = boundingClientRect.top;
          rect.left = boundingClientRect.left;
          resolve(rect);
        }).observe(this.megamenuRowsWrap);
      });
    }

    async resetPositioning() {
      await new Promise(resolve => {
        this.windowWidth = liquidWindowWidth();
        this.columnsWidth = 0;
        this.positionApplied = false;
        this.element.classList.remove('position-applied');
        this.megamenuRowsWrap.style.width = '';
        this.submenu.style.width = '';
        this.submenu.style.left = '';
        this.submenu.style.right = '';
        this.submenu.style.top = '';
        this.submenu.style.marginLeft = '';
        resolve();
      });
    }

    positioning() {
      const elementWidth = this.elementBoundingRect.width;
      const elementOffsetLeft = this.elementBoundingRect.left;
      const megamenuContainerWidth = this.megamenuBoundingRect.width;
      const globalContainerDimensions = fastdom.measure(this.getGlobalContainerDimensions, this)();
      const globalContainerWidth = globalContainerDimensions.width;
      const globalContainerOffsetLeft = globalContainerDimensions.offsetLeft;
      const menuItemisInGlobalContainerRange = elementOffsetLeft <= globalContainerWidth + globalContainerOffsetLeft;
      let left = 0;
      let right = 0;
      let top = 0;
      let megamenuOffsetLeft = 0;
      fastdomPromised.mutate(() => {
        if (!this.isFullwidth) {
          if (megamenuContainerWidth === globalContainerWidth && menuItemisInGlobalContainerRange) {
            left = globalContainerOffsetLeft - elementOffsetLeft;
            this.submenu.style.left = `${left}px`;
          }

          if (menuItemisInGlobalContainerRange) {
            left = globalContainerOffsetLeft + (globalContainerWidth / 2 - megamenuContainerWidth / 2) - elementOffsetLeft;
            this.submenu.style.left = `${left}px`;
            megamenuOffsetLeft = left;
          }

          if (megamenuOffsetLeft > elementOffsetLeft) {
            left = elementOffsetLeft - elementOffsetLeft;
            this.submenu.style.left = `${left}px`;
          }

          if (megamenuOffsetLeft + megamenuContainerWidth < elementOffsetLeft + elementWidth) {
            left = elementOffsetLeft + elementWidth - (megamenuOffsetLeft + megamenuContainerWidth) + megamenuOffsetLeft - elementOffsetLeft;
            this.submenu.style.left = `${left}px`;
          }
        } else {
          left = elementOffsetLeft * -1;
          this.submenu.style.left = `${left}px`;
        }

        this.megamenuFinalPos.left = left;

        if (this.isInCustomMenu) {
          const elementOffsetTop = this.elementBoundingRect.top;
          const elementHeight = this.elementBoundingRect.height;
          const megamenuOffsetTop = this.megamenuBoundingRect.top;
          const megamenuHeight = this.megamenuBoundingRect.height;

          if (elementOffsetTop + elementHeight > megamenuOffsetTop + megamenuHeight) {
            top = elementOffsetTop - megamenuOffsetTop;
            this.submenu.style.top = `${top}px`;
            this.megamenuFinalPos.top = top;
          }

          if (this.isFullwidth) {
            if (this.megamenuBoundingRect.left + megamenuContainerWidth > this.windowWidth) {
              right = (this.windowWidth - (elementOffsetLeft + elementWidth)) * -1;
              this.submenu.style.width = 'auto';
              this.submenu.style.right = `${right}px`;
              this.megamenuFinalPos.right = right;
            }
          }
        }

        this.positionApplied = true;
        this.element.classList.add('position-applied');
        this.element.dispatchEvent(new CustomEvent('megamenu-position-applied', {
          bubbles: false,
          detail: {
            element: this.element
          }
        }));
      });
    }

    resizeWindow() {
      const onResize = liquidDebounce(this.onResizeWindow.bind(this), 300);
      $(window).on('resize', onResize);
      $(document).on('lqd-header-sticky-change', () => {
        if (this.$element.is(':visible') && this.isInCustomMenu && this.$element.closest('.main-header').length) {
          onResize();
        }
      });
    }

    async onResizeWindow() {
      await this.resetPositioning();
      await this.getColumnsWidth();
      !this.isFullwidth && (await this.setContainerWidth());
      this.elementBoundingRect = await this.getElementBoundingRect();
      this.megamenuBoundingRect = await this.getMegamenuBoundingRect();
      this.positioning();
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('megamenu-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('.megamenu').filter((i, el) => {
    const $el = $(el);
    return !$el.closest('.navbar-fullscreen').length && !$el.parent().hasClass('lqd-mobile-main-nav') && !$el.parent().hasClass('lqd-menu-items-block');
  }).liquidMegamenu();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidMegamenuSlide';
  let defaults = {};

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.DOM = {};
      this.DOM.element = element;
      this.DOM.$element = $(element);
      this.DOM.$megamenuItems = this.DOM.$element.find('.megamenu').filter((i, el) => !$(el).parent().hasClass('lqd-mobile-main-nav') && !$(el).parent().hasClass('lqd-menu-items-block'));
      this.DOM.$megamenuSiblings = this.DOM.$megamenuItems.eq(0).siblings().not('.megamenu');
      this.dropdownsInfo = [];
      this.$megamenusParent = false;
      this.lastActiveIndex = false;
      this.activeIndex = false;
      this.wasRevealed = false;
      this.timeout = false;
      this.getMegamenuDropdowns().then(infos => {
        this.dropdownsInfo = infos.filter(info => info.dropdown != null);
        this.$megamenusParent = $(infos[0].element.parentNode);
        this.buildMarkup();
        this.init();
      });
    }

    async getMegamenuDropdowns() {
      const promises = [];
      this.DOM.$megamenuItems.each((i, megamenuItem) => {
        const $megamenuItem = $(megamenuItem);
        const megamenuData = $megamenuItem.data('plugin_liquidMegamenu');

        if (megamenuData) {
          promises.push(megamenuData.dropdownInfoPromise);
        }
      });
      return await Promise.all(promises);
    }

    buildMarkup() {
      this.$megamenusParent.append(`
				<li class="lqd-megamenu-slide-stuff pos-abs pos-bl pos-r pointer-events-none">
					<div class="lqd-megamenu-slide-stuff-wrap pos-abs pos-l pos-r">
						<span class="lqd-megamenu-slide-arrow pos-abs pos-tl"></span>
						<span class="lqd-megamenu-slide-bg pos-abs pos-tl">
							<span class="lqd-megamenu-slide-bg-inner pos-abs pos-tl"></span>
						</span>
					</div>
				</li>
			`);
    }

    init() {
      this.eventListeners();
    }

    eventListeners() {
      this.DOM.$megamenuItems.each((i, megamenuItem) => {
        megamenuItem.addEventListener('mouseenter', this.onMegamenuItemEnter.bind(this, i));
        megamenuItem.addEventListener('mouseleave', this.onMegamenuItemLeave.bind(this, i));
      });
      this.DOM.$megamenuSiblings.each((i, menuItem) => {
        menuItem.addEventListener('mouseenter', this.resetReveal.bind(this));
      });
      this.DOM.element.addEventListener('mouseleave', this.resetReveal.bind(this));
    }

    onMegamenuItemEnter(itemIndex) {
      let elementBoundingRect;
      let megamenuBoundingRect;
      let megamenuFinalPos;
      let arrowPos;
      elementBoundingRect = this.dropdownsInfo[itemIndex].elementBoundingRect;
      megamenuBoundingRect = this.dropdownsInfo[itemIndex].megamenuBoundingRect;
      megamenuFinalPos = this.dropdownsInfo[itemIndex].megamenuFinalPos;
      arrowPos = elementBoundingRect.left + elementBoundingRect.width / 2;

      if (!this.wasRevealed) {
        this.DOM.element.classList.add('lqd-megamenu-slide-reveal');
        this.DOM.element.style.setProperty('--lqd-megamenu-init-width', megamenuBoundingRect.width);
        this.DOM.element.style.setProperty('--lqd-megamenu-init-height', megamenuBoundingRect.height);
      } else {
        this.DOM.element.classList.remove('lqd-megamenu-slide-reveal');
      }

      this.DOM.$megamenuItems.eq(itemIndex).removeClass('lqd-megamenu-item-slide-out');
      this.activeIndex = itemIndex;
      this.DOM.element.style.setProperty('--lqd-megamenu-slide-arrow-pos', `${arrowPos}px`);
      this.DOM.element.style.setProperty('--lqd-megamenu-current-width', megamenuBoundingRect.width);
      this.DOM.element.style.setProperty('--lqd-megamenu-current-height', megamenuBoundingRect.height);
      this.DOM.element.style.setProperty('--lqd-megamenu-x', `${megamenuFinalPos.left || 0}px`);
      this.DOM.element.style.setProperty('--lqd-megamenu-y', `${megamenuFinalPos.top || 0}px`);

      if (this.lastActiveIndex >= 0 && this.activeIndex >= 0) {
        if (this.lastActiveIndex < this.activeIndex) {
          this.DOM.element.classList.add('lqd-megamenu-slide-from-right');
        } else if (this.lastActiveIndex > this.activeIndex) {
          this.DOM.element.classList.remove('lqd-megamenu-slide-from-right');
        }
      }

      this.wasRevealed = true;
      $liquidMainHeader.addClass('lqd-megamenu-slide-active');
    }

    onMegamenuItemLeave(itemIndex) {
      this.activeIndex = false;
      this.lastActiveIndex = itemIndex;
      this.DOM.element.classList.remove('lqd-megamenu-slide-reveal');
      this.DOM.element.classList.remove('lqd-megamenu-slide-from-right');
      this.DOM.$megamenuItems.eq(itemIndex).addClass('lqd-megamenu-item-slide-out');
      $liquidMainHeader.removeClass('lqd-megamenu-slide-active');
      this.timeout = setTimeout(() => {
        if (this.activeIndex === false || this.activeIndex < 0) {
          this.resetReveal();
        }

        clearTimeout(this.timeout);
      }, 180);
    }

    resetReveal() {
      this.activeIndex = false;
      this.wasRevealed = false;
      this.DOM.element.classList.remove('lqd-megamenu-slide-reveal');
      this.DOM.element.classList.remove('lqd-megamenu-slide-from-right');
      $liquidMainHeader.removeClass('lqd-megamenu-slide-active');
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('megamenu-slide-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('[data-megamenu-slide]').filter((i, el) => $(el).find('.megamenu').length).liquidMegamenuSlide();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidCountdown';
  let defaults = {
    daysLabel: "Days",
    hoursLabel: "Hours",
    minutesLabel: "Minutes",
    secondsLabel: "Seconds",
    timezone: null
  };

  class Plugin {
    constructor(element, options) {
      this.element = element;
      this.$element = $(element);
      this.options = $.extend({}, defaults, options);
      this._defaults = defaults;
      this._name = pluginName;
      this.init();
    }

    init() {
      const {
        options
      } = this;
      const {
        until,
        timezone
      } = options;
      this.$element.countdown({
        until: new Date(until.replace(/-/g, "/")),
        padZeroes: true,
        timezone,
        layout: '<span class="countdown-row">' + '<span class="countdown-section">' + '<span class="countdown-amount">{dn}</span>' + '<span class="countdown-period">' + options.daysLabel + '</span>' + '</span>' + '<span class="countdown-sep">:</span>' + '<span class="countdown-section">' + '<span class="countdown-amount">{hn}</span>' + '<span class="countdown-period">' + options.hoursLabel + '</span>' + '</span>' + '<span class="countdown-sep">:</span>' + '<span class="countdown-section">' + '<span class="countdown-amount">{mn}</span>' + '<span class="countdown-period">' + options.minutesLabel + '</span>' + '</span>' + '<span class="countdown-sep">:</span>' + '<span class="countdown-section">' + '<span class="countdown-amount">{sn}</span>' + '<span class="countdown-period">' + options.secondsLabel + '</span>' + '</span>' + '</span>'
      });
      return this;
    }

    destroy() {
      this.$element.countdown('destroy');
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = $(this).data('countdown-options') || options;

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery, window, document);

jQuery(document).ready(function ($) {
  $('[data-plugin-countdown=true]').liquidCountdown();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidCounter';
  let defaults = {
    targetNumber: 0,
    startDelay: 0,
    blurEffect: false
  };

  function Plugin(element, options) {
    this._defaults = defaults;
    this._name = pluginName;
    this.options = $.extend({}, defaults, options);
    this.element = element;
    this.$element = $(element);
    this.init();
  }

  Plugin.prototype = {
    init: function () {
      this.createMarkup();
      this.setupIO();
    },
    formatNumberWithCommas: function (number) {
      return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    },
    formatNumberWithSpaces: function (number) {
      return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
    },
    formatCounterAnimator: function (number) {
      return number.toString().replace(/(\d)/g, '<span class="lqd-counter-animator d-inline-flex pos-rel overflow-hidden"><span class="lqd-animator-value">$1</span></span>');
    },
    createMarkup: function () {
      const counter = $(this.element).children('span').not('.lqd-counter-element-hover');
      const options = this.options;
      const counterVal = options.targetNumber;
      const formatWithCommas = /,+/.test(counterVal);
      const formatWithSpaces = /\s+/.test(counterVal);
      if (formatWithCommas) counter.html(this.formatCounterAnimator(this.formatNumberWithCommas(counterVal)));else if (formatWithSpaces) counter.html(this.formatCounterAnimator(this.formatNumberWithSpaces(counterVal)));else counter.html(this.formatCounterAnimator(counterVal));
      counter.find('.lqd-counter-animator').each(function (i, animator) {
        const $animator = $(animator);
        const animatorValue = $animator.find('.lqd-animator-value').text();
        $animator.append(`<div class="lqd-animator-numbers lqd-overlay overflow-hidden" data-value="${animatorValue}">
	<ul class="reset-ul w-100 h-100 pos-rel">
		<li class="m-0">0</li>
		<li class="m-0">1</li>
		<li class="m-0">2</li>
		<li class="m-0">3</li>
		<li class="m-0">4</li>
		<li class="m-0">5</li>
		<li class="m-0">6</li>
		<li class="m-0">7</li>
		<li class="m-0">8</li>
		<li class="m-0">9</li>
	</ul>
</div>`);
      });
    },
    addBlurEffect: function (blurID) {
      if (this.options.blurEffect) {
        const ulElement = $('.lqd-animator-numbers ul', this.element);
        ulElement.each((i, element) => {
          const $ul = $(element);

          if ($ul.parent().data('value') != 0) {
            $ul.css({
              'filter': "url('#counter-blur-" + blurID + "')"
            });
          }
        });
      }
    },
    animateCounter: function () {
      const startDelay = this.options.startDelay / 1000;
      const blurID = Math.round(gsap.utils.random(0, 100));
      const blurSVG = $(`<svg class="counter-blur-svg" xmlns="http://www.w3.org/2000/svg" version="1.1" width="0" height="0">
	<defs>
		<filter id="counter-blur-${blurID}">
			<feGaussianBlur id="counter-blur-filter-${blurID}" in="SourceGraphic" stdDeviation="0,0" />
		</filter>
	</defs>
</svg>`);
      this.addBlurEffect(blurID);
      this.$element.find('.lqd-animator-numbers').each((i, animator) => {
        const $animator = $(animator);
        const counterValue = parseInt($animator.data('value'), 10);
        let stdDeviation = {
          x: 0,
          y: 0
        };
        let blurFilter;
        gsap.to($animator.find('ul').get(0), {
          y: counterValue * -100 + '%',
          ease: 'power2.out',
          delay: startDelay,
          duration: 1.2,
          onComplete: () => {
            this.$element.addClass('counter-animated');
          }
        });

        if (this.options.blurEffect) {
          if (!$('.counter-blur-svg', this.element).length) {
            blurSVG.appendTo(this.element);
          }

          blurFilter = blurSVG.find(`#counter-blur-filter-${blurID}`).get(0);
          gsap.to(stdDeviation, {
            startAt: {
              y: 50 + counterValue * 10
            },
            ease: 'power4.out',
            duration: 1.2,
            delay: startDelay,
            y: 0.01,
            onUpdate: () => {
              blurFilter.setAttribute('stdDeviation', '0,' + stdDeviation.y);
            },
            onComplete: () => {
              $('.lqd-animator-numbers ul', this.element).css('filter', '');
            }
          });
        }
      });
    },
    setupIO: function () {
      new LiquidIO(this.element, this.animateCounter.bind(this), {
        threshold: 0.8,
        disconnect: true
      });
    }
  };

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('counter-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('[data-enable-counter]').liquidCounter();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidDynamicShape';
  let defaults = {};

  class Plugin {
    constructor(element, options) {
      this.options = $.extend({}, defaults, options);
      this._defaults = defaults;
      this._name = pluginName;
      this.DOM = {};
      this.DOM.element = element;
      this.DOM.svgEl = this.DOM.element.querySelector('svg');
      this.DOM.pathEl = this.DOM.element.querySelector('path');
      this.paths = this.DOM.pathEl.getAttribute('pathdata:id').trim().split(';');
      this.paths.splice(this.paths.length, 0, this.DOM.pathEl.getAttribute('d'));
      this.timeline = null;
      this.createTimeline();
      this.init();
    }

    createTimeline() {
      const keyframes = this.paths.map(path => {
        return {
          d: path.trim()
        };
      });
      this.timeline = gsap.timeline({
        repeat: -1,
        yoyo: true
      }).pause();

      for (let i = 0; i < keyframes.length; i++) {
        this.timeline.to(this.DOM.pathEl, {
          attr: {
            d: keyframes[i].d
          },
          duration: 2
        });
      }
    }

    init() {
      this.animate();
    }

    animate() {
      this.timeline.play();
    }

    pause() {
      this.timeline.pause();
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('mi-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  if (liquidIsMobile()) return;
  $('[data-dynamic-shape]').filter((i, element) => {
    const $element = $(element);
    const $fullpageSection = $element.closest('.vc_row.pp-section');
    return !$fullpageSection.length;
  }).liquidDynamicShape();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidFormInputs';
  let defaults = {
    dropdownAppendTo: null
  };

  class Plugin {
    constructor(element, options) {
      this.element = element;
      this.$element = $(element);
      this.options = { ...defaults,
        ...options
      };
      this._defaults = defaults;
      this._name = pluginName;
      this.init();
    }

    init() {
      this.icons();
      this.initDatePicker();
      this.initSelect();
      this.initSpinner();
      this.inputsEventHandlers();
    }

    icons() {
      if (this.$element.hasClass('wpcf7-form')) {
        this.$element.find('.wpcf7-form-control-wrap').siblings('i').each((i, icon) => {
          $(icon).appendTo($(icon).prev('.wpcf7-form-control-wrap'));
        });
      }
    }

    initDatePicker() {
      const dateInputs = this.$element.find('.date-picker, input.wpcf7-form-control[type=date]');
      dateInputs.each((i, element) => {
        const $element = $(element);

        if ($element.attr('type') === 'date') {
          const $clonedElement = $element.clone(true);
          $clonedElement.attr('type', 'text');
          $clonedElement.insertAfter($element);
          $element.css('display', 'none');
          $clonedElement.datepicker({
            dateFormat: 'yy-mm-dd',
            onSelect: date => {
              $element.val(date);
            }
          });
        } else {
          $(element).datepicker();
        }
      });
    }

    initSelect() {
      const $selectElement = this.$element.find('select').not('.select2-hidden-accessible, .select, .woo-rating, #bbp_stick_topic_select, #bbp_topic_status_select, #bbp_forum_id, .woocommerce-widget-layered-nav-dropdown, .elementor-field-textual, .wc-pao-addon-select, .quform-field');
      let {
        dropdownAppendTo
      } = this.options;

      if ($selectElement.hasClass('orderby') || $selectElement.hasClass('search-field') || $selectElement.hasClass('wpcf7-form-control') || $selectElement.hasClass('liquid-schedule-filter')) {
        dropdownAppendTo = 'self';
      }

      if (!$selectElement.closest('.variations').length) {
        $selectElement.each((i, element) => {
          const $element = $(element);
          const slct = $element.selectmenu({
            change: () => {
              $element.trigger('change');
            }
          });

          if (dropdownAppendTo) {
            let $appendToEl;

            if (dropdownAppendTo === 'self') {
              $appendToEl = $('<div class="lqd-select-dropdown" />').insertAfter($element);
            } else {
              $appendToEl = $(dropdownAppendTo, this.element).length ? $(dropdownAppendTo, this.element) : $(dropdownAppendTo);
            }

            slct.selectmenu('option', 'appendTo', $appendToEl);
          }

          $element.on('change', () => {
            $element.selectmenu('refresh');
          });
        });
      } else {
        const $selectElExtra = $('<span class="lqd-select-ext" />');
        $selectElement.wrap('<span class="lqd-select-wrap pos-rel" />');
        $selectElExtra.insertAfter($selectElement);
      }
    }

    initSpinner() {
      const splinners = this.$element.find('input.spinner, input[type=number].qty');
      splinners.each((i, element) => {
        const $element = $(element);
        $element.spinner({
          spin: (event, ui) => {
            $element.val(ui.value);
            $element.trigger('change');
          }
        });
      });
    }

    getInputParent(focusedInput) {
      if (focusedInput.closest('p').length) {
        return focusedInput.closest('p');
      } else {
        return focusedInput.closest('div');
      }
    }

    inputsEventHandlers() {
      $('input, textarea', this.$element).on('focus', this.inputOnFocus.bind(this));
      $('input, textarea', this.$element).on('blur', this.inputOnBlur.bind(this));
    }

    inputOnFocus(event) {
      const inputParent = this.getInputParent($(event.target));
      inputParent.addClass('input-focused');
    }

    inputOnBlur(event) {
      const input = $(event.target);
      const inputParent = this.getInputParent(input);

      if (input.val() !== '') {
        inputParent.addClass('input-filled');
      } else {
        inputParent.removeClass('input-filled');
      }

      inputParent.removeClass('input-focused');
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('form-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('form, .lqd-filter-dropdown, .widget').not('[name="chbs-form"]').liquidFormInputs();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidHover3d';
  let defaults = {};

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.element = element;
      this.$element = $(element);
      this.hoverables = this.element.querySelectorAll('[data-stacking-factor]');
      this.rect = {};
      this.maxRotation = 8;
      this.maxTranslation = 4;
      this.build();
    }

    build() {
      fastdom.measure(() => {
        new IntersectionObserver(([entry], observer) => {
          observer.disconnect();
          const {
            boundingClientRect
          } = entry;
          this.rect = {
            width: boundingClientRect.width,
            height: boundingClientRect.height
          };
          this.init();
          this.$element.addClass('hover-3d-applied');
        }).observe(this.element);
      });
    }

    measure() {
      return fastdomPromised.measure(() => {
        return new Promise(resolve => {
          new IntersectionObserver(([entry], observer) => {
            observer.disconnect();
            resolve(entry.boundingClientRect);
          }).observe(this.element);
        });
      }).then(rect => {
        this.rect = {
          width: rect.width,
          height: rect.height
        };
      });
    }

    init() {
      this.eventHandlers();
    }

    eventHandlers() {
      this.$element.on('mousemove.lqdHover3d', this.hover.bind(this));
      this.$element.on('mouseleave.lqdHover3d', this.leave.bind(this));
      $liquidWindow.on('resize.lqdHover3d', this.onWindowLoad.bind(this));
    }

    async onWindowLoad() {
      await this.measure();
    }

    animate(config, isIn) {
      fastdom.mutate(() => {
        if (isIn) {
          this.element.classList.add('mouse-in');
        } else {
          this.element.classList.remove('mouse-in');
        }

        this.hoverables.forEach(hoverable => {
          const stackingFactor = hoverable.getAttribute('data-stacking-factor');
          hoverable.style.transition = 'none';
          gsap.to(hoverable, {
            x: config.xTranslationPercentage * -1 * (config.maxTranslationX * stackingFactor),
            y: config.yTranslationPercentage * -1 * (config.maxTranslationY * stackingFactor),
            rotateX: config.xRotationPercentage * -1 * (config.maxRotationX * stackingFactor),
            rotateY: config.yRotationPercentage * -1 * (config.maxRotationY * stackingFactor),
            duration: 0.8,
            ease: 'power2.out'
          });
        });
      });
    }

    calculateRotationPercentage(offset, dimension) {
      return -2 / dimension * offset + 1;
    }

    calculateTranslationPercentage(offset, dimension) {
      return -2 / dimension * offset + 1;
    }

    hover(e) {
      const mouseOffsetInside = {
        x: e.pageX - this.$element.offset().left,
        y: e.pageY - this.$element.offset().top
      };
      const transVals = {
        xRotationPercentage: this.calculateRotationPercentage(mouseOffsetInside.y, this.rect.height),
        yRotationPercentage: this.calculateRotationPercentage(mouseOffsetInside.x, this.rect.width) * -1,
        xTranslationPercentage: this.calculateTranslationPercentage(mouseOffsetInside.x, this.rect.width),
        yTranslationPercentage: this.calculateTranslationPercentage(mouseOffsetInside.y, this.rect.height)
      };
      this.animate({
        maxTranslationX: this.maxTranslation,
        maxTranslationY: this.maxTranslation,
        maxRotationX: this.maxRotation,
        maxRotationY: this.maxRotation,
        xRotationPercentage: transVals.xRotationPercentage,
        yRotationPercentage: transVals.yRotationPercentage,
        xTranslationPercentage: transVals.xTranslationPercentage,
        yTranslationPercentage: transVals.yTranslationPercentage
      }, true);
    }

    leave() {
      this.animate({
        maxTranslationX: 0,
        maxTranslationY: 0,
        maxRotationX: 0,
        maxRotationY: 0,
        xRotationPercentage: 0,
        yRotationPercentage: 0,
        xTranslationPercentage: 0,
        yTranslationPercentage: 0
      }, false);
    }

    destroy() {
      this.$element.off('mousemove.lqdHover3d mouseleave.lqdHover3d');
      $liquidWindow.off('resize.lqdHover3d');
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('hover3d-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  if (liquidIsMobile()) return false;
  $('[data-hover3d]').filter((i, element) => !$(element).closest('.lqd-tabs-pane').not('.active').length).liquidHover3d();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidIconboxCircle';
  let defaults = {
    startAngle: 45,
    itemSelector: '.lqd-ib-circ-icn, .one-ib-circ-icn',
    contentsContainer: '.lqd-ib-circ-inner, .one-ib-circ-inner'
  };

  class Plugin {
    constructor(element, options) {
      this.element = element;
      this.options = $.extend({}, defaults, options);
      this._defaults = defaults;
      this._name = pluginName;
      this.$parent = $(this.options.contentsContainer);
      this.$items = $(this.options.itemSelector, this.element);
      this.anglesArray = [this.options.startAngle];
      this.init();
    }

    init() {
      this.addAngles(this.$items);
      this.setTransformOrigin();
      this.setIntersectionObserver();
      this.windowResize();
    }

    getItemsArray() {
      const $items = this.$items;
      const itemsLength = $items.length;
      const itemsArray = [];

      for (let i = 0; i < itemsLength; i++) {
        itemsArray.push($items[i]);
      }

      return itemsArray;
    }

    getElementDimension($element) {
      return {
        width: $element.width(),
        height: $element.height()
      };
    }

    addAngles($elements) {
      const elementsLength = $elements.length;
      $elements.each(i => {
        this.anglesArray.push(360 / elementsLength + this.anglesArray[i]);
      });
    }

    setTransformOrigin() {
      const parentDimensions = this.getElementDimension(this.$parent);
      this.$items.each((i, element) => {
        const $element = $(element);
        $element.css({
          transformOrigin: ''
        });
        $element.css({
          transformOrigin: `${parentDimensions.width / 2}px ${parentDimensions.height / 2}px`
        });
        $element.children().css({
          transform: `rotate(${this.anglesArray[i] * -1}deg)`
        });
      });
    }

    setIntersectionObserver() {
      new IntersectionObserver((enteries, observer) => {
        enteries.forEach(entery => {
          if (entery.isIntersecting) {
            this.animateIcons();
            observer.unobserve(entery.target);
          }
        });
      }, {
        threshold: 0.25
      }).observe(this.element);
    }

    animateIcons() {
      const icons = this.getItemsArray();
      const timeline = gsap.timeline();
      timeline.to(icons, {
        opacity: 1,
        duration: 0.2,
        ease: 'linear',
        stagger: i => i * 0.2
      }, 0.45).to(icons, {
        rotation: i => this.anglesArray[i],
        duration: 1,
        ease: 'power4.inOut',
        stagger: i => i * 0.15
      }, 0);
    }

    windowResize() {
      $(window).on('resize.lqdIconboxCircle', this.setTransformOrigin.bind(this));
    }

    destroy() {
      $(window).off('resize.lqdIconboxCircle');
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('plugin-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('[data-spread-incircle]').liquidIconboxCircle();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidImageComparison';
  let defaults = {};

  class Plugin {
    constructor(element, options) {
      this.element = element;
      this.$element = $(element);
      this.options = $.extend({}, defaults, options);
      this._defaults = defaults;
      this._name = pluginName;
      this.dragging = false;
      this.resizing = false;
      this.$dragElement = this.$element.find('.cd-handle');
      this.$resizeElement = this.$element.find('.cd-resize-img');
      this.dragWidth = this.$dragElement.outerWidth();
      this.containerWidth = this.$element.outerWidth();
      this.init();
    }

    init() {
      this.element.style.setProperty('--container-width', `${this.containerWidth}px`);
      this.initIO();

      this._drags();
    }

    initIO() {
      new IntersectionObserver(enteries => {
        enteries.forEach(entery => {
          if (entery.isIntersecting) {
            this.$element.addClass('is-visible');
          }
        });
      }).observe(this.element, {
        threshold: 0.35
      });
    }

    _drags() {
      this.$dragElement.on("pointerdown.lqdImageComparison", event => {
        event.preventDefault();
        this.$dragElement.addClass('draggable');
        this.$resizeElement.addClass('resizable');
        const x = event.originalEvent.pageX;
        const xPosition = this.$dragElement.offset().left + this.dragWidth - x;
        $(document).on("pointermove.lqdImageComparison", event => {
          if (!this.dragging) {
            this.dragging = true;
            requestAnimationFrame(() => {
              this._animateDraggedHandle(event, xPosition);
            });
          }
        });
      });
      $(document).on("pointerup.lqdImageComparison", () => {
        this.$dragElement.removeClass('draggable');
        this.$resizeElement.removeClass('resizable');
        $(document).off('pointermove.lqdImageComparison');
        this.dragging = false;
      });
    }

    _animateDraggedHandle(event, xPosition) {
      var containerOffset = this.$element.offset().left;
      var minLeft = containerOffset;
      var maxLeft = containerOffset + this.containerWidth;
      var x = event.originalEvent.pageX;
      var leftValue = x + xPosition;

      if (leftValue < minLeft) {
        leftValue = minLeft;
      } else if (leftValue > maxLeft) {
        leftValue = maxLeft;
      }

      var widthValue = (leftValue - containerOffset) * 100 / this.containerWidth + '%';
      this.$dragElement.css('left', widthValue).on("pointerup.lqdImageComparison", () => {
        this.$dragElement.removeClass('draggable');
        this.$resizeElement.removeClass('resizable');
      });
      this.$resizeElement.css('width', widthValue);
      this.dragging = false;
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = $(this).data('plugin-options') || options;

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('.cd-image-container').filter((i, element) => !$(element).closest('.lqd-tabs-pane').not('.active').length).liquidImageComparison();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidLightBox';
  let defaults = {};

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = $.extend({}, defaults, options);
      this.isOpen = false;
      this.$backdrop = false;
      this.lityInstance = false;
      this.element = element;
      this.$element = $(element);
      const href = this.element.getAttribute('href');
      const hrefIsEmpty = !href || href === '' || href.length < 1 || href.replace('#', '').length < 1;
      if (hrefIsEmpty) return;
      this.targets = document.querySelectorAll(this.element.getAttribute('href'));
      this.target = false;
      this.$target = false;
      this.modalTemplate = document.querySelector('body > #lqd-temp-modal-box');
      if (this.targets.length < 1) return;
      this.init();
    }

    async init() {
      await this.buildMarkup();
      this.events();
    }

    buildMarkup() {
      if (!this.modalTemplate) return;
      return fastdomPromised.mutate(() => {
        if (this.targets.length > 1) {
          this.targets.forEach((targetEl, i) => i !== 0 && targetEl.remove());
        }

        const target = this.targets[0];
        const targetId = this.element.getAttribute('href').replace('#', '');
        const modalType = target.getAttribute('data-modal-type') || 'default';

        if (window.liquidAvailableLightboxes.find(lightboxId => lightboxId === targetId)) {
          this.target = target;
        } else {
          const templateTopEl = this.modalTemplate.content.firstElementChild.cloneNode(true);
          const lityWrap = templateTopEl.children[0];
          const targetWrapper = target.closest('.elementor-element');
          const elementorWrapper = target.closest('.elementor');

          if (elementorWrapper) {
            templateTopEl.classList.add(...elementorWrapper.getAttribute('class').split(' ').filter(classname => classname.indexOf('elementor-') !== -1));
          }

          lityWrap.setAttribute('data-modal-type', modalType);
          lityWrap.setAttribute('id', targetId);
          target.removeAttribute('id');
          target.removeAttribute('data-modal-type');

          if (targetWrapper) {
            lityWrap.classList.add(...targetWrapper.getAttribute('class').split(' '));
          }

          lityWrap.querySelector('.lqd-lity-content').appendChild(target);
          document.body.appendChild(templateTopEl);
          window.liquidAvailableLightboxes.push(targetId);
          this.target = lityWrap;
        }

        this.$target = $(this.target);
        this.$backdrop = this.$target.children('.lqd-lity-backdrop');
        this.modalType = modalType;
      });
    }

    events() {
      $(document).on('lqd-lity:open', this.onOpen.bind(this));
      $(document).on('lqd-lity:close', this.onClose.bind(this));
      $('[data-lqd-lity-close]', this.target).on('click', this.onCloseBtnClick.bind(this));
      this.$backdrop.on('click', this.onBackdropClick.bind(this));
    }

    onCloseBtnClick() {
      if (!this.isOpen) {
        return this.$element.trigger('click');
      }

      if (this.isOpen && this.lityInstance) {
        return this.lityInstance.close();
      }
    }

    onOpen(event, instance) {
      if (this.modalType === 'box') {
        this.boxModalPosition();
      }

      this.lityInstance = instance;
      this.$element.addClass('pointer-events-none');
      this.isOpen = true;
    }

    onClose() {
      const $video = this.$target.find('video');
      const $audio = this.$target.find('audio');

      if ($video.length) {
        const video = $video.get(0);
        video.oncanplay = video.pause();
      }

      if ($audio.length) {
        const audio = $audio.get(0);
        audio.oncanplay = audio.pause();
      }

      this.$element.blur();
      this.$element.removeClass('pointer-events-none');
      this.isOpen = false;
    }

    boxModalPosition() {
      if (!this.$target.length) return;
      const buttonOffset = this.$element.offset();
      const modalWidth = this.$target.outerWidth();
      const modalHeight = this.$target.outerHeight();
      const offset = buttonOffset.left + this.$element.outerWidth() - 60;
      const windowWidth = window.innerWidth;

      if (this.$element.closest('.lqd-stickybar-wrap').length) {
        this.$target.css({
          position: 'fixed',
          top: buttonOffset.top - window.scrollY - modalHeight - 25
        });
      } else {
        this.$target.css({
          top: buttonOffset.top - modalHeight - 25
        });
      }

      this.$target.css({
        left: offset,
        right: offset + modalWidth >= windowWidth ? windowWidth - offset : 'auto'
      });

      if (offset + modalWidth >= windowWidth) {
        this.$target.addClass('to-left');
        this.$target.css({
          left: 'auto',
          right: windowWidth - offset - 60
        });
      }
    }

    onBackdropClick() {
      if (!this.isOpen || !this.lityInstance) return;
      this.lityInstance.close();
    }

    destroy() {
      return fastdomPromised.mutate(() => {
        if (!this.$target || !this.$target.length) return;
      });
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('lightbox-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery, window, document);

jQuery(document).ready(function ($) {
  $('[data-lqd-lity]').liquidLightBox();
});
;

(function ($) {
  'use strict';

  const pluginName = 'liquidMap';
  let defaults = {
    address: '7420 Shore Rd, Brooklyn, NY 11209, USA',
    marker: null,
    style: 'wy',
    marker_style: 'default',
    className: 'lqd-custom-map-marker pos-abs border-radius-circle',
    markers: null,
    map: {
      zoom: 16,
      mapTypeId: 'roadmap',
      disableDefaultUI: true,
      panControl: false,
      zoomControl: true,
      mapTypeControl: false,
      streetViewControl: false,
      scrollwheel: false
    }
  };
  const styles = {
    "wy": [{
      "featureType": "all",
      "elementType": "geometry.fill",
      "stylers": [{
        "weight": "2.00"
      }]
    }, {
      "featureType": "all",
      "elementType": "geometry.stroke",
      "stylers": [{
        "color": "#9c9c9c"
      }]
    }, {
      "featureType": "all",
      "elementType": "labels.text",
      "stylers": [{
        "visibility": "on"
      }]
    }, {
      "featureType": "landscape",
      "elementType": "all",
      "stylers": [{
        "color": "#f2f2f2"
      }]
    }, {
      "featureType": "landscape",
      "elementType": "geometry.fill",
      "stylers": [{
        "color": "#ffffff"
      }]
    }, {
      "featureType": "landscape.man_made",
      "elementType": "geometry.fill",
      "stylers": [{
        "color": "#ffffff"
      }]
    }, {
      "featureType": "poi",
      "elementType": "all",
      "stylers": [{
        "visibility": "off"
      }]
    }, {
      "featureType": "road",
      "elementType": "all",
      "stylers": [{
        "saturation": -100
      }, {
        "lightness": 45
      }]
    }, {
      "featureType": "road",
      "elementType": "geometry.fill",
      "stylers": [{
        "color": "#eeeeee"
      }]
    }, {
      "featureType": "road",
      "elementType": "labels.text.fill",
      "stylers": [{
        "color": "#7b7b7b"
      }]
    }, {
      "featureType": "road",
      "elementType": "labels.text.stroke",
      "stylers": [{
        "color": "#ffffff"
      }]
    }, {
      "featureType": "road.highway",
      "elementType": "all",
      "stylers": [{
        "visibility": "simplified"
      }]
    }, {
      "featureType": "road.arterial",
      "elementType": "labels.icon",
      "stylers": [{
        "visibility": "off"
      }]
    }, {
      "featureType": "transit",
      "elementType": "all",
      "stylers": [{
        "visibility": "off"
      }]
    }, {
      "featureType": "water",
      "elementType": "all",
      "stylers": [{
        "color": "#46bcec"
      }, {
        "visibility": "on"
      }]
    }, {
      "featureType": "water",
      "elementType": "geometry.fill",
      "stylers": [{
        "color": "#c8d7d4"
      }]
    }, {
      "featureType": "water",
      "elementType": "labels.text.fill",
      "stylers": [{
        "color": "#070707"
      }]
    }, {
      "featureType": "water",
      "elementType": "labels.text.stroke",
      "stylers": [{
        "color": "#ffffff"
      }]
    }],
    "blueEssence": [{
      "featureType": "landscape.natural",
      "elementType": "geometry.fill",
      "stylers": [{
        "visibility": "on"
      }, {
        "color": "#e0efef"
      }]
    }, {
      "featureType": "poi",
      "elementType": "geometry.fill",
      "stylers": [{
        "visibility": "on"
      }, {
        "hue": "#1900ff"
      }, {
        "color": "#c0e8e8"
      }]
    }, {
      "featureType": "road",
      "elementType": "geometry",
      "stylers": [{
        "lightness": 100
      }, {
        "visibility": "simplified"
      }]
    }, {
      "featureType": "road",
      "elementType": "labels",
      "stylers": [{
        "visibility": "off"
      }]
    }, {
      "featureType": "transit.line",
      "elementType": "geometry",
      "stylers": [{
        "visibility": "on"
      }, {
        "lightness": 700
      }]
    }, {
      "featureType": "water",
      "elementType": "all",
      "stylers": [{
        "color": "#7dcdcd"
      }]
    }],
    "lightMonochrome": [{
      "featureType": "administrative.locality",
      "elementType": "all",
      "stylers": [{
        "hue": "#2c2e33"
      }, {
        "saturation": 7
      }, {
        "lightness": 19
      }, {
        "visibility": "on"
      }]
    }, {
      "featureType": "landscape",
      "elementType": "all",
      "stylers": [{
        "hue": "#ffffff"
      }, {
        "saturation": -100
      }, {
        "lightness": 100
      }, {
        "visibility": "simplified"
      }]
    }, {
      "featureType": "poi",
      "elementType": "all",
      "stylers": [{
        "hue": "#ffffff"
      }, {
        "saturation": -100
      }, {
        "lightness": 100
      }, {
        "visibility": "off"
      }]
    }, {
      "featureType": "road",
      "elementType": "geometry",
      "stylers": [{
        "hue": "#bbc0c4"
      }, {
        "saturation": -93
      }, {
        "lightness": 31
      }, {
        "visibility": "simplified"
      }]
    }, {
      "featureType": "road",
      "elementType": "labels",
      "stylers": [{
        "hue": "#bbc0c4"
      }, {
        "saturation": -93
      }, {
        "lightness": 31
      }, {
        "visibility": "on"
      }]
    }, {
      "featureType": "road.arterial",
      "elementType": "labels",
      "stylers": [{
        "hue": "#bbc0c4"
      }, {
        "saturation": -93
      }, {
        "lightness": -2
      }, {
        "visibility": "simplified"
      }]
    }, {
      "featureType": "road.local",
      "elementType": "geometry",
      "stylers": [{
        "hue": "#e9ebed"
      }, {
        "saturation": -90
      }, {
        "lightness": -8
      }, {
        "visibility": "simplified"
      }]
    }, {
      "featureType": "transit",
      "elementType": "all",
      "stylers": [{
        "hue": "#e9ebed"
      }, {
        "saturation": 10
      }, {
        "lightness": 69
      }, {
        "visibility": "on"
      }]
    }, {
      "featureType": "water",
      "elementType": "all",
      "stylers": [{
        "hue": "#e9ebed"
      }, {
        "saturation": -78
      }, {
        "lightness": 67
      }, {
        "visibility": "simplified"
      }]
    }],
    "assassinsCreedIV": [{
      "featureType": "all",
      "elementType": "all",
      "stylers": [{
        "visibility": "on"
      }]
    }, {
      "featureType": "all",
      "elementType": "labels",
      "stylers": [{
        "visibility": "off"
      }, {
        "saturation": "-100"
      }]
    }, {
      "featureType": "all",
      "elementType": "labels.text.fill",
      "stylers": [{
        "saturation": 36
      }, {
        "color": "#000000"
      }, {
        "lightness": 40
      }, {
        "visibility": "off"
      }]
    }, {
      "featureType": "all",
      "elementType": "labels.text.stroke",
      "stylers": [{
        "visibility": "off"
      }, {
        "color": "#000000"
      }, {
        "lightness": 16
      }]
    }, {
      "featureType": "all",
      "elementType": "labels.icon",
      "stylers": [{
        "visibility": "off"
      }]
    }, {
      "featureType": "administrative",
      "elementType": "geometry.fill",
      "stylers": [{
        "color": "#000000"
      }, {
        "lightness": 20
      }]
    }, {
      "featureType": "administrative",
      "elementType": "geometry.stroke",
      "stylers": [{
        "color": "#000000"
      }, {
        "lightness": 17
      }, {
        "weight": 1.2
      }]
    }, {
      "featureType": "landscape",
      "elementType": "geometry",
      "stylers": [{
        "color": "#000000"
      }, {
        "lightness": 20
      }]
    }, {
      "featureType": "landscape",
      "elementType": "geometry.fill",
      "stylers": [{
        "color": "#4d6059"
      }]
    }, {
      "featureType": "landscape",
      "elementType": "geometry.stroke",
      "stylers": [{
        "color": "#4d6059"
      }]
    }, {
      "featureType": "landscape.natural",
      "elementType": "geometry.fill",
      "stylers": [{
        "color": "#4d6059"
      }]
    }, {
      "featureType": "poi",
      "elementType": "geometry",
      "stylers": [{
        "lightness": 21
      }]
    }, {
      "featureType": "poi",
      "elementType": "geometry.fill",
      "stylers": [{
        "color": "#4d6059"
      }]
    }, {
      "featureType": "poi",
      "elementType": "geometry.stroke",
      "stylers": [{
        "color": "#4d6059"
      }]
    }, {
      "featureType": "road",
      "elementType": "geometry",
      "stylers": [{
        "visibility": "on"
      }, {
        "color": "#7f8d89"
      }]
    }, {
      "featureType": "road",
      "elementType": "geometry.fill",
      "stylers": [{
        "color": "#7f8d89"
      }]
    }, {
      "featureType": "road.highway",
      "elementType": "geometry.fill",
      "stylers": [{
        "color": "#7f8d89"
      }, {
        "lightness": 17
      }]
    }, {
      "featureType": "road.highway",
      "elementType": "geometry.stroke",
      "stylers": [{
        "color": "#7f8d89"
      }, {
        "lightness": 29
      }, {
        "weight": 0.2
      }]
    }, {
      "featureType": "road.arterial",
      "elementType": "geometry",
      "stylers": [{
        "color": "#000000"
      }, {
        "lightness": 18
      }]
    }, {
      "featureType": "road.arterial",
      "elementType": "geometry.fill",
      "stylers": [{
        "color": "#7f8d89"
      }]
    }, {
      "featureType": "road.arterial",
      "elementType": "geometry.stroke",
      "stylers": [{
        "color": "#7f8d89"
      }]
    }, {
      "featureType": "road.local",
      "elementType": "geometry",
      "stylers": [{
        "color": "#000000"
      }, {
        "lightness": 16
      }]
    }, {
      "featureType": "road.local",
      "elementType": "geometry.fill",
      "stylers": [{
        "color": "#7f8d89"
      }]
    }, {
      "featureType": "road.local",
      "elementType": "geometry.stroke",
      "stylers": [{
        "color": "#7f8d89"
      }]
    }, {
      "featureType": "transit",
      "elementType": "geometry",
      "stylers": [{
        "color": "#000000"
      }, {
        "lightness": 19
      }]
    }, {
      "featureType": "water",
      "elementType": "all",
      "stylers": [{
        "color": "#2b3638"
      }, {
        "visibility": "on"
      }]
    }, {
      "featureType": "water",
      "elementType": "geometry",
      "stylers": [{
        "color": "#2b3638"
      }, {
        "lightness": 17
      }]
    }, {
      "featureType": "water",
      "elementType": "geometry.fill",
      "stylers": [{
        "color": "#24282b"
      }]
    }, {
      "featureType": "water",
      "elementType": "geometry.stroke",
      "stylers": [{
        "color": "#24282b"
      }]
    }, {
      "featureType": "water",
      "elementType": "labels",
      "stylers": [{
        "visibility": "off"
      }]
    }, {
      "featureType": "water",
      "elementType": "labels.text",
      "stylers": [{
        "visibility": "off"
      }]
    }, {
      "featureType": "water",
      "elementType": "labels.text.fill",
      "stylers": [{
        "visibility": "off"
      }]
    }, {
      "featureType": "water",
      "elementType": "labels.text.stroke",
      "stylers": [{
        "visibility": "off"
      }]
    }, {
      "featureType": "water",
      "elementType": "labels.icon",
      "stylers": [{
        "visibility": "off"
      }]
    }],
    "unsaturatedBrowns": [{
      "elementType": "geometry",
      "stylers": [{
        "hue": "#ff4400"
      }, {
        "saturation": -68
      }, {
        "lightness": -4
      }, {
        "gamma": 0.72
      }]
    }, {
      "featureType": "road",
      "elementType": "labels.icon"
    }, {
      "featureType": "landscape.man_made",
      "elementType": "geometry",
      "stylers": [{
        "hue": "#0077ff"
      }, {
        "gamma": 3.1
      }]
    }, {
      "featureType": "water",
      "stylers": [{
        "hue": "#00ccff"
      }, {
        "gamma": 0.44
      }, {
        "saturation": -33
      }]
    }, {
      "featureType": "poi.park",
      "stylers": [{
        "hue": "#44ff00"
      }, {
        "saturation": -23
      }]
    }, {
      "featureType": "water",
      "elementType": "labels.text.fill",
      "stylers": [{
        "hue": "#007fff"
      }, {
        "gamma": 0.77
      }, {
        "saturation": 65
      }, {
        "lightness": 99
      }]
    }, {
      "featureType": "water",
      "elementType": "labels.text.stroke",
      "stylers": [{
        "gamma": 0.11
      }, {
        "weight": 5.6
      }, {
        "saturation": 99
      }, {
        "hue": "#0091ff"
      }, {
        "lightness": -86
      }]
    }, {
      "featureType": "transit.line",
      "elementType": "geometry",
      "stylers": [{
        "lightness": -48
      }, {
        "hue": "#ff5e00"
      }, {
        "gamma": 1.2
      }, {
        "saturation": -23
      }]
    }, {
      "featureType": "transit",
      "elementType": "labels.text.stroke",
      "stylers": [{
        "saturation": -64
      }, {
        "hue": "#ff9100"
      }, {
        "lightness": 16
      }, {
        "gamma": 0.47
      }, {
        "weight": 2.7
      }]
    }],
    "classic": [{
      "featureType": "administrative.country",
      "elementType": "geometry",
      "stylers": [{
        "visibility": "simplified"
      }, {
        "hue": "#ff0000"
      }]
    }],
    "evenLighter": [{
      "featureType": "administrative",
      "elementType": "labels.text.fill",
      "stylers": [{
        "color": "#6195a0"
      }]
    }, {
      "featureType": "landscape",
      "elementType": "all",
      "stylers": [{
        "color": "#f2f2f2"
      }]
    }, {
      "featureType": "landscape",
      "elementType": "geometry.fill",
      "stylers": [{
        "color": "#ffffff"
      }]
    }, {
      "featureType": "poi",
      "elementType": "all",
      "stylers": [{
        "visibility": "off"
      }]
    }, {
      "featureType": "poi.park",
      "elementType": "geometry.fill",
      "stylers": [{
        "color": "#e6f3d6"
      }, {
        "visibility": "on"
      }]
    }, {
      "featureType": "road",
      "elementType": "all",
      "stylers": [{
        "saturation": -100
      }, {
        "lightness": 45
      }, {
        "visibility": "simplified"
      }]
    }, {
      "featureType": "road.highway",
      "elementType": "all",
      "stylers": [{
        "visibility": "simplified"
      }]
    }, {
      "featureType": "road.highway",
      "elementType": "geometry.fill",
      "stylers": [{
        "color": "#f4d2c5"
      }, {
        "visibility": "simplified"
      }]
    }, {
      "featureType": "road.highway",
      "elementType": "labels.text",
      "stylers": [{
        "color": "#4e4e4e"
      }]
    }, {
      "featureType": "road.arterial",
      "elementType": "geometry.fill",
      "stylers": [{
        "color": "#f4f4f4"
      }]
    }, {
      "featureType": "road.arterial",
      "elementType": "labels.text.fill",
      "stylers": [{
        "color": "#787878"
      }]
    }, {
      "featureType": "road.arterial",
      "elementType": "labels.icon",
      "stylers": [{
        "visibility": "off"
      }]
    }, {
      "featureType": "transit",
      "elementType": "all",
      "stylers": [{
        "visibility": "off"
      }]
    }, {
      "featureType": "water",
      "elementType": "all",
      "stylers": [{
        "color": "#eaf6f8"
      }, {
        "visibility": "on"
      }]
    }, {
      "featureType": "water",
      "elementType": "geometry.fill",
      "stylers": [{
        "color": "#eaf6f8"
      }]
    }],
    "shadesOfGray": [{
      "featureType": "all",
      "elementType": "labels.text.fill",
      "stylers": [{
        "saturation": 36
      }, {
        "color": "#000000"
      }, {
        "lightness": 40
      }]
    }, {
      "featureType": "all",
      "elementType": "labels.text.stroke",
      "stylers": [{
        "visibility": "on"
      }, {
        "color": "#000000"
      }, {
        "lightness": 16
      }]
    }, {
      "featureType": "all",
      "elementType": "labels.icon",
      "stylers": [{
        "visibility": "off"
      }]
    }, {
      "featureType": "administrative",
      "elementType": "geometry.fill",
      "stylers": [{
        "color": "#000000"
      }, {
        "lightness": 20
      }]
    }, {
      "featureType": "administrative",
      "elementType": "geometry.stroke",
      "stylers": [{
        "color": "#000000"
      }, {
        "lightness": 17
      }, {
        "weight": 1.2
      }]
    }, {
      "featureType": "landscape",
      "elementType": "geometry",
      "stylers": [{
        "color": "#000000"
      }, {
        "lightness": 20
      }]
    }, {
      "featureType": "poi",
      "elementType": "geometry",
      "stylers": [{
        "color": "#000000"
      }, {
        "lightness": 21
      }]
    }, {
      "featureType": "road.highway",
      "elementType": "geometry.fill",
      "stylers": [{
        "color": "#000000"
      }, {
        "lightness": 17
      }]
    }, {
      "featureType": "road.highway",
      "elementType": "geometry.stroke",
      "stylers": [{
        "color": "#000000"
      }, {
        "lightness": 29
      }, {
        "weight": 0.2
      }]
    }, {
      "featureType": "road.arterial",
      "elementType": "geometry",
      "stylers": [{
        "color": "#000000"
      }, {
        "lightness": 18
      }]
    }, {
      "featureType": "road.local",
      "elementType": "geometry",
      "stylers": [{
        "color": "#000000"
      }, {
        "lightness": 16
      }]
    }, {
      "featureType": "transit",
      "elementType": "geometry",
      "stylers": [{
        "color": "#000000"
      }, {
        "lightness": 19
      }]
    }, {
      "featureType": "water",
      "elementType": "geometry",
      "stylers": [{
        "color": "#000000"
      }, {
        "lightness": 17
      }]
    }]
  };

  class LqdGMap {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.options.map = { ...defaults.map,
        ...options.map
      };
      this.element = element;
      this.$element = $(element);
      this.init(element, this.options);
    }

    init() {
      this.build();
      this.adjustHeight();
      return this;
    }

    build() {
      const mapOpts = { ...this.options.map,
        styles: styles[this.options.style]
      };
      const map = new google.maps.Map(this.element, mapOpts);
      const geocoder = new google.maps.Geocoder();
      geocoder.geocode({
        "address": this.options.address
      }, (results, status) => {
        if (status == google.maps.GeocoderStatus.OK) {
          const result = results[0].geometry.location;
          const latitude = results[0].geometry.location.lat();
          const longitude = results[0].geometry.location.lng();

          if (this.options.marker_style === 'html') {
            this.$element.addClass('marker-html');
          }

          if (this.options.markers == null) {
            this.addMarker(result, map);
          } else {
            for (var i = 0; i < this.options.markers.length; i++) {
              this.addMarker(new google.maps.LatLng(this.options.markers[i][0], this.options.markers[i][1]), map);
            }
          }

          map.setCenter(new google.maps.LatLng(latitude, longitude));
          $('.lightbox-link[data-type=inline]').on('mfpOpen', function (e) {
            setTimeout(function () {
              map.setCenter(new google.maps.LatLng(latitude, longitude));
            }, 500);
          });
          $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
            setTimeout(function () {
              map.setCenter(new google.maps.LatLng(latitude, longitude));
            }, 500);
          });
        }
      });
      $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
        setTimeout(function () {
          google.maps.event.trigger(map, 'resize');
        }, 500);
      });
      return this;
    }

    addMarker(pos, map) {
      if (this.options.marker_style === 'image' || this.options.marker_style === 'default') {
        new google.maps.Marker({
          position: pos,
          map: map,
          visible: true,
          icon: this.options.marker,
          zIndex: 9999999
        });
      } else if (this.options.marker_style === 'html') {
        if (typeof google !== typeof undefined && typeof google.maps !== typeof undefined) {
          new LqdCustomMarker(pos, map, this.options.className);
        }
      }
    }

    adjustHeight() {
      const $parent = this.$element.parent('.ld-gmap-container');
      const $vcRowParent = $parent.parents('.vc_row').last();

      if (!$parent.siblings().length && $vcRowParent.hasClass('vc_row-o-equal-height')) {
        $parent.height($parent.parent().outerHeight());
      }
    }

  }

  ;

  function LqdCustomMarker(latlng, map, className) {
    this.latlng_ = latlng;
    this.className = className;
    this.setMap && this.setMap(map);
  }

  if (typeof google !== typeof undefined && typeof google.maps !== typeof undefined) {
    LqdCustomMarker.prototype = new google.maps.OverlayView();

    LqdCustomMarker.prototype.draw = function () {
      let div = this.div_;
      let divChild;
      let divChild2;

      if (!div) {
        div = this.div_ = document.createElement('DIV');
        div.className = this.className;
        divChild = document.createElement("div");
        divChild.className = 'lqd-overlay border-radius-circle';
        div.appendChild(divChild);
        divChild2 = document.createElement("div");
        divChild2.className = 'lqd-overlay border-radius-circle';
        div.appendChild(divChild2);
        google.maps.event.addDomListener(div, "click", () => {
          google.maps.event.trigger(this, "click");
        });
        const panes = this.getPanes();
        panes.overlayImage.appendChild(div);
      }

      const point = this.getProjection().fromLatLngToDivPixel(this.latlng_);

      if (point) {
        div.style.left = point.x + 'px';
        div.style.top = point.y + 'px';
      }
    };

    LqdCustomMarker.prototype.remove = function () {
      if (this.div_) {
        this.div_.parentNode.removeChild(this.div_);
        this.div_ = null;
      }
    };

    LqdCustomMarker.prototype.getPosition = function () {
      return this.latlng_;
    };
  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = $(this).data('plugin-options') || options;

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new LqdGMap(this, pluginOptions));
      }
    });
  };
})(jQuery);

$liquidWindow.on('load', () => {
  if (typeof google !== typeof undefined && google !== null) {
    jQuery('[data-plugin-map]').liquidMap();
  }
});
(function ($) {
  'use strict';

  const pluginName = 'liquidMasonry';
  let defaults = {
    bypassCheck: false,
    layoutMode: 'packery',
    itemSelector: '.masonry-item',
    alignMid: false,
    filtersID: null,
    filtersCounter: false
  };

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.element = element;
      this.$element = $(element);
      this.isoData = null;
      this.init();
    }

    init() {
      const $parentTabPane = this.$element.parents('.lqd-tabs-pane');

      if ($parentTabPane.length && $parentTabPane.is(':hidden')) {
        return this.setupIO();
      }

      this.onImagesLoad();
    }

    setupIO() {
      if (this.isoData) return;
      new IntersectionObserver(([entry], observer) => {
        if (entry.isIntersecting) {
          observer.disconnect();
          this.onImagesLoad();
        }
      }).observe(this.element);
    }

    onImagesLoad() {
      imagesLoaded(this.element, this.handleOnImagesLoaded.bind(this));
    }

    handleOnImagesLoaded() {
      this.initIsotope();
      this.initFilters();
      this.eventHandlers();
    }

    initIsotope() {
      const {
        layoutMode,
        itemSelector,
        stamp,
        bypassCheck
      } = this.options;
      this.isoData = new Isotope(this.element, {
        bypassCheck,
        layoutMode,
        itemSelector,
        stamp
      });
      $(document).trigger('lqd-masonry-layout-init', {
        detail: {
          isotopeData: this.isoData
        }
      });
    }

    setStamps() {
      this.setAlignMidStamps();
    }

    setAlignMidStamps() {
      const options = this.options;

      if (options.alignMid) {
        const items = $(options.itemSelector, this.element);
        const columnsCount = this.$element.attr('data-columns');
        const itemsHeights = [];
        let gridSizer = $('.grid-stamp', this.$element);
        $.each(items, (i, item) => {
          const $item = $(item);
          const height = $item.outerHeight();
          itemsHeights.push(height);
        });
        this.highestHeight = Math.max(...itemsHeights);
        this.lowestHeight = Math.min(...itemsHeights);

        if (columnsCount >= 3) {
          gridSizer.clone().insertBefore(items.eq(columnsCount - 1)).addClass('is-right');
          gridSizer = gridSizer.add('.grid-stamp', this.$element);
        }

        gridSizer.height(this.lowestHeight / 2);
        options.stamp = '.grid-stamp';
      }
    }

    initFilters() {
      const {
        filtersID,
        filtersCounter
      } = this.options;

      if (!filtersID) {
        return;
      }

      ;
      const $filterList = $(filtersID);
      const $filterDropdown = $filterList.siblings('.lqd-filter-dropdown');
      $('li', $filterList).each((i, element) => {
        const $li = $(element);
        const filterVal = $li.attr('data-filter');

        if (filtersCounter) {
          const filterItems = $(filterVal, this.element);
          const $counter = $(`
						<sup class="lqd-filter-counter">
							<span>${filterVal === '*' ? this.isoData.items.length : filterItems.length}</span>
						</sup>`);
          $counter.appendTo($li);
        }

        $li.on('click', () => {
          $li.addClass('active').siblings().removeClass('active');
          this.isoData.arrange({
            filter: filterVal
          });
        });
      });

      if ($filterDropdown.length) {
        $('select', $filterDropdown).on('selectmenuchange', (event, ui) => {
          const filterVal = ui.item.value;
          this.isoData.arrange({
            filter: filterVal
          });
        });
      }
    }

    eventHandlers() {
      this.isoData.on('layoutComplete', this.handleLayoutComplete.bind(this));
    }

    handleLayoutComplete() {
      $(document).trigger('lqd-masonry-layout-complete', {
        detail: {
          isotopeData: this.isoData
        }
      });
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('masonry-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  if (!$liquidContents.length) return;

  if (!$liquidContents[0].hasAttribute('data-liquid-stack')) {
    $('[data-liquid-masonry]').liquidMasonry();
  } else {
    const stackOptions = $liquidContents.attr('data-stack-options');

    if (stackOptions) {
      const optionsJson = JSON.parse(stackOptions);
      const {
        disableOnMobile
      } = optionsJson;

      if (disableOnMobile && (liquidIsMobile() || liquidWindowWidth() <= liquidMobileNavBreakpoint())) {
        $('[data-liquid-masonry]').liquidMasonry();
      }
    }
  }
});
(function ($) {
  'use strict';

  const pluginName = 'liquidParticles';
  let defaults = {
    asBG: false,
    "particles": {
      "number": {
        "value": 40,
        "density": {
          "enable": false,
          "value_area": 800
        }
      },
      "color": {
        "value": ["#f7ccaf", "#f6cacd", "dbf5f8", "#c5d8f8", "#c5f8ce", "#f7afbd", "#b2d6ef", "#f1ecb7"]
      },
      "shape": {
        "type": "triangle"
      },
      "size": {
        "value": 55,
        "random": true,
        "anim": {
          "enable": true,
          "speed": 1
        }
      },
      "move": {
        "direction": "right",
        "attract": {
          "enable": true
        }
      },
      "line_linked": {
        "enable": false
      }
    },
    "interactivity": {
      "events": {
        "onhover": {
          "enable": false
        },
        "onclick": {
          "enable": false
        }
      }
    }
  };

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.options.particles = { ...defaults.particles,
        ...options.particles
      };
      this.options.interactivity = { ...defaults.interactivity,
        ...options.interactivity
      };
      this.element = element;
      this.$element = $(element);
      this.build();
    }

    build() {
      this.id = this.element.id;

      if (this.options.interactivity.events.onhover || this.options.interactivity.events.onclick) {
        this.$element.removeClass('pointer-events-none');
        this.$element.addClass('pointer-events-auto');
      }

      this.asSectionBg();
      this.init();
    }

    init() {
      particlesJS(this.id, this.options);
    }

    asSectionBg() {
      if (this.options.asBG) {
        const particlesBgWrap = $('<div class="lqd-particles-bg-wrap lqd-overlay pointer-events-none"></div>');
        const elementContainer = this.$element.parent('.ld-particles-container');
        const parentSection = this.$element.parents('.elementor-section').last() || this.$element.parent('.e-container') || this.$element.closest('.e-con');
        const sectionContainerElement = parentSection.children('.elementor-container');
        const $stickyWrap = parentSection.children('.lqd-sticky-bg-wrap');
        particlesBgWrap.append(elementContainer);

        if ($stickyWrap.length) {
          particlesBgWrap.appendTo($stickyWrap);
        } else if (parentSection.hasClass('pp-section')) {
          particlesBgWrap.prependTo(parentSection);
        } else {
          if (sectionContainerElement.length) {
            particlesBgWrap.insertBefore(sectionContainerElement);
          } else {
            particlesBgWrap.prependTo(parentSection);
          }
        }
      }
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('particles-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('[data-particles=true]').filter((i, element) => {
    const $element = $(element);
    const $fullpageSection = $element.closest('.vc_row.pp-section');
    return !$fullpageSection.length;
  }).liquidParticles();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidPin';
  let defaults = {
    trigger: 'self',
    start: 'top top',
    end: null,
    endTrigger: null,
    duration: 'contentsHeight',
    offset: 0,
    pinSpacing: false,
    pinReparent: false
  };

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.element = element;
      this.$element = $(element);
      this.ST = null;
      this.spacerElement = null;
      this.offset = 0;
      this.end = 0;
      this.rect = {};
      this.pinPromise = new Promise(resolve => {
        this.element.addEventListener('element-was-pinned', resolve(this, this));
      });

      if ($liquidMainHeader.length && $liquidMainHeader[0].hasAttribute('data-sticky-header')) {
        $(document).on('lqd-header-sticky-change', () => {
          !this.ST && setTimeout(this.init.bind(this), 150);
        });
      } else {
        this.init();
      }
    }

    async init() {
      this.rect = await this.measure();
      this.offset = await this.getOffset();
      this.end = await this.getEnd();
      this.pin();
      this.events();
      this.handleResize();
      this.element.dispatchEvent(new CustomEvent('element-was-pinned', {
        bubbles: false
      }));
    }

    measure() {
      return fastdomPromised.measure(() => {
        return this.element.getBoundingClientRect();
      });
    }

    pin() {
      fastdom.mutate(() => {
        const {
          start,
          pinSpacing,
          pinReparent,
          trigger
        } = this.options;
        let breakpoint = '(min-width: 992px)';

        if (this.element.classList.contains('lqd-custom-menu')) {
          breakpoint = 'all';
        } else if (this.element.classList.contains('lqd-add-to-cart-row')) {
          breakpoint = '(max-width: 767px)';
        }

        ScrollTrigger.matchMedia({
          [`${breakpoint}`]: () => {
            this.ST = ScrollTrigger.create({
              trigger: trigger === 'self' ? this.element : $(trigger)[0],
              pin: true,
              start: `${start}+=${this.offset}`,
              endTrigger: this.getEndTrigger(),
              end: this.end,
              pinSpacing,
              pinReparent
            });
            this.spacerElement = this.ST.spacer;
          }
        });
      });
    }

    async getOffset() {
      const {
        offset
      } = this.options;

      if (isNaN(parseInt(offset), 10)) {
        return await this.getOffsetElementsHeight();
      }

      return offset;
    }

    async getOffsetElementsHeight() {
      const {
        options
      } = this;
      const promises = [];
      let offset = 0;
      options.offset.split(',').forEach(el => {
        const element = document.querySelector(el);

        if (element) {
          const promise = new Promise(resolve => {
            new IntersectionObserver(([entry], observer) => {
              observer.disconnect();
              resolve(entry.boundingClientRect.height);
            }).observe(element);
          });
          promises.push(promise);
        }
      });
      const heights = await Promise.all(promises);
      heights.forEach(height => offset += height);
      return offset;
    }

    getEnd() {
      return fastdomPromised.measure(() => {
        let {
          duration,
          end
        } = this.options;

        if (end) {
          return end;
        }

        if (duration === 'contentsHeight' && (this.element.classList.contains('lqd-sticky-bg-wrap') || this.element.classList.contains('lqd-section-borders-wrap'))) {
          const $contentsContainer = this.spacerElement ? $(this.spacerElement).siblings('.ld-container') : this.$element.siblings('.ld-container');
          const contentsContainerHeight = $contentsContainer[0].offsetHeight;
          duration = `+=${contentsContainerHeight}`;
        } else if (duration === 'contentsHeight') {
          duration = `+=${this.rect.height}`;
        }

        if (duration === 'parent' && this.element.classList.contains('vc_column-inner')) {
          duration = `+=${this.element.closest('.ld-row').offsetHeight - this.rect.height}`;
        } else if (duration === 'parent') {
          let contentsHeight = 0;
          this.$element.children().each((i, children) => contentsHeight += $(children).outerHeight(true));
          duration = `+=${this.rect.height - contentsHeight}`;
        }

        if (duration === 'last-link') {
          duration = `bottom top+=${this.offset + this.rect.height}`;
        }

        return duration;
      });
    }

    getEndTrigger() {
      const {
        duration
      } = this.options;
      let {
        endTrigger
      } = this.options;

      if (duration === 'parent') {
        endTrigger = this.spacerElement ? this.spacerElement.parentElement : this.element.parentElement;
      }

      if (duration === 'last-link') {
        const $lastLink = $('a', this.element).last();
        const lastLinkHref = $lastLink.attr('href');

        if (lastLinkHref !== '' && lastLinkHref.startsWith('#') && $(lastLinkHref).length) {
          endTrigger = $(lastLinkHref)[0];
        } else {
          endTrigger = $liquidContents[0];
        }
      }

      return endTrigger;
    }

    events() {
      $(document).on('lqd-header-sticky-change lqd-masonry-layout-complete lqd-carousel-initialized', () => {
        this.ST && this.ST.refresh();
      });
    }

    handleResize() {
      const onResize = liquidDebounce(this.onWindowResize, 250);
      $(window).on('resize', onResize.bind(this));
    }

    async onWindowResize() {
      this.rect = await this.measure();
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('pin-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  const pinElements = $($('[data-pin=true]').get().reverse());
  pinElements.liquidPin();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidProgressbar';
  let defaults = {
    value: 0
  };

  class Plugin {
    constructor(element, options) {
      this.element = element;
      this.$element = $(element);
      this.options = $.extend({}, defaults, options);
      this._defaults = defaults;
      this._name = pluginName;
      this.valueEl = $('.lqd-progressbar-value', element);
      this.prefixEl = $('.lqd-progressbar-prefix', element);
      this.suffixEl = $('.lqd-progressbar-prefix', element);
      this.percentageElement = $('.lqd-progressbar-percentage', element);
      this.barElement = $('.lqd-progressbar-bar', element);
      this.titleElement = $('.lqd-progressbar-title', element);
      this.isRTL = $('html').attr('dir') == 'rtl';
      this.init();
    }

    init() {
      this.setupIntersectionObserver();
    }

    setupIntersectionObserver() {
      new IntersectionObserver(([entry], observer) => {
        if (entry.isIntersecting) {
          this.animatePercentage();
          this.animateProgressbar();
          observer.unobserve(entry.target);
        }
      }, {
        threshold: 1
      }).observe(this.element);
    }

    animatePercentage() {
      const percentage = {
        value: 0
      };
      gsap.to(percentage, {
        value: this.options.value,
        duration: 1.2,
        ease: 'power3.inOut',
        onUpdate: () => {
          this.percentageElement.length && this.valueEl.text(Math.round(percentage.value));
        }
      });
    }

    animateProgressbar() {
      const barElement = this.barElement.get(0);
      const value = this.options.value + '%';
      this.animateHorizontal(barElement, value);
    }

    animateHorizontal(barElement, value) {
      gsap.to(barElement, {
        width: value,
        duration: 1.2,
        ease: 'power3.inOut'
      });
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('progressbar-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('[data-progressbar]').liquidProgressbar();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidResponsiveAccordion';
  let defaults = {
    triggers: ".lqd-tabs-nav a",
    contents: '.lqd-tabs-pane',
    parent: '.lqd-tabs'
  };

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.DOM = {};
      this.DOM.$element = $(element);
      this.DOM.$triggers = this.DOM.$element.find(this.options.triggers);
      this.DOM.$contents = this.DOM.$element.find(this.options.contents);
      this.DOM.responsiveTriggers = [];
      this.init();
    }

    init() {
      this.createTriggers();
      this.appendTriggers();
      this.initCollapse();
    }

    createTriggers() {
      this.DOM.$triggers.each((i, trigger) => {
        const $trigger = $(trigger).clone();
        const $h2 = $('<h2 role="tab" class="lqd-res-acc-trigger" />');
        $h2.append($trigger);
        this.DOM.responsiveTriggers.push($h2);
      });
    }

    appendTriggers() {
      this.DOM.$contents.each((i, content) => {
        $(this.DOM.responsiveTriggers[i]).insertBefore(content);
      });
    }

    initCollapse() {
      $.each(this.DOM.responsiveTriggers, (i, trigger) => {
        const $trigger = $(trigger).children('a');
        const $parent = $trigger.closest(this.options.parent);
        const $contents = $parent.find(this.options.contents);
        $trigger.off('click');
        $trigger.on('click', event => {
          event.preventDefault();
          const $target = $($trigger.attr('href'));
          $trigger.parent().siblings('.lqd-res-acc-trigger').removeClass('is-active');
          $contents.not($target).removeClass('is-active').stop().slideUp(300);
          $target.toggleClass('is-active').stop().slideToggle(300);
          $trigger.parent().toggleClass('is-active');
        });
      });
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('res-acc-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('.woocommerce-tabs').liquidResponsiveAccordion({
    triggers: '.wc-tabs > li > a',
    contents: '.woocommerce-Tabs-panel',
    parent: '.woocommerce-tabs'
  });
});
(function ($) {
  'use strict';

  const pluginName = 'liquidReveal';
  let defaults = {
    isContentHidden: true,
    animteWhenInView: true,
    delay: 0,
    appendMarkup: true,
    direction: 'lr',
    bgcolor: '#f0f0f0',
    duration: 0.5,
    ease: 'power4.inOut',
    initialCoverArea: 0,
    coverArea: 0,
    onCover: function (contentEl, revealerEl) {
      return false;
    },
    onStart: function (contentEl, revealerEl) {
      return false;
    },
    onComplete: function (contentEl, revealerEl) {
      return false;
    },
    onCoverAnimations: null
  };

  class Plugin {
    constructor(element, options) {
      this.options = { ...defaults,
        ...options
      };
      this._defaults = defaults;
      this._name = pluginName;
      this.element = element;
      this.$element = $(element);
      this.$content = this.$element.children().not('.block-revealer__element');
      this.isAnimating = false;
      this.revealer = null;
      this.init();
    }

    init() {
      this._layout();

      if (this.options.animteWhenInView) {
        this.setIntersectionObserver();
      } else {
        imagesLoaded(this.element, this.doTheReveal.bind(this));
      }
    }

    _createDOMEl(type, className, content) {
      var el = document.createElement(type);
      el.className = className || '';
      el.innerHTML = content || '';
      return el;
    }

    _layout() {
      const position = getComputedStyle(this.element).position;

      if (position !== 'fixed' && position !== 'absolute' && position !== 'relative') {
        this.element.style.position = 'relative';
      }

      if (this.options.isContentHidden) {
        this.$content.css('opacity', 0);
      }

      if (this.options.appendMarkup) {
        this.revealer = this._createDOMEl('div', 'block-revealer__element');
        this.element.classList.add('block-revealer');
        this.element.appendChild(this.revealer);
      } else {
        this.revealer = this.element.querySelector('.block-revealer__element');
      }
    }

    _getTransformSettings(direction) {
      var val, origin, origin_2;

      switch (direction) {
        case 'lr':
          val = {
            scaleX: this.options.initialCoverArea / 100
          };
          origin = '0 50%';
          origin_2 = '100% 50%';
          break;

        case 'rl':
          val = {
            scaleX: this.options.initialCoverArea / 100
          };
          origin = '100% 50%';
          origin_2 = '0 50%';
          break;

        case 'tb':
          val = {
            scaleY: this.options.initialCoverArea / 100
          };
          origin = '50% 0';
          origin_2 = '50% 100%';
          break;

        case 'bt':
          val = {
            scaleY: this.options.initialCoverArea / 100
          };
          origin = '50% 100%';
          origin_2 = '50% 0';
          break;

        default:
          val = {
            scaleX: this.options.initialCoverArea / 100
          };
          origin = '0 50%';
          origin_2 = '100% 50%';
          break;
      }

      return {
        val: val,
        origin: {
          initial: origin,
          halfway: origin_2
        }
      };
    }

    reveal() {
      if (this.isAnimating) {
        return false;
      }

      this.isAnimating = true;

      var direction = this.options.direction,
          transformSettings = this._getTransformSettings(direction),
          origin = Object.values(transformSettings.val)[0] > 0 ? transformSettings.origin.halfway : transformSettings.origin.initial,
          coverArea = this.options.coverArea,
          duration = this.options.duration,
          ease = this.options.ease;

      this.revealer.style.WebkitTransform = this.revealer.style.transform = `${Object.keys(transformSettings.val)[0]}(${Object.values(transformSettings.val)[0]})`;
      this.revealer.style.WebkitTransformOrigin = this.revealer.style.transformOrigin = origin;
      var animationSettings_2 = {
        keyframes: [transformSettings.val, {
          [Object.keys(transformSettings.val)[0]]: coverArea / 100
        }],
        duration,
        ease,
        onStart: () => {
          this.$content.css({
            transition: 'none',
            opacity: 1
          });
        },
        onComplete: () => {
          this.isAnimating = false;

          if (typeof this.options.onComplete === 'function') {
            this.options.onComplete(this.content, this.revealer);
          }

          this.$element.addClass('revealing-ended').removeClass('revealing-started');
        }
      };
      var animationSettings = {
        keyframes: [transformSettings.val, {
          [Object.keys(transformSettings.val)[0]]: 1
        }],
        duration: this.options.initialCoverArea === 100 ? 0.01 : duration,
        ease,
        delay: this.options.delay / 1000,
        onComplete: () => {
          this.revealer.style.WebkitTransformOrigin = this.revealer.style.transformOrigin = transformSettings.origin.halfway;

          if (typeof this.options.onCover === 'function') {
            this.options.onCover(this.content, this.revealer);
          }

          this.$element.addClass('element-uncovered');
          gsap.to(this.revealer, { ...animationSettings_2
          });
        }
      };

      if (typeof this.options.onStart === 'function') {
        this.options.onStart(this.content, this.revealer);
      }

      this.$element.addClass('revealing-started');
      gsap.to(this.revealer, { ...animationSettings
      });
    }

    setIntersectionObserver() {
      new IntersectionObserver(([entry], observer) => {
        if (entry.isIntersecting) {
          observer.disconnect();
          $(entry.target).imagesLoaded(this.doTheReveal.bind(this));
        }
      }).observe(this.element);
    }

    doTheReveal() {
      this.reveal();
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('reveal-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  if (!$liquidContents.length) return;
  $('[data-reveal]').filter((i, element) => {
    const lazyloadImg = element.querySelector('.ld-lazyload');
    return !window.$liquidContents[0].hasAttribute('data-liquid-stack') && !lazyloadImg;
  }).liquidReveal();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidSetActiveOnhover';
  let defaults = {
    classname: 'lqd-is-active',
    offClassname: 'lqd-was-active',
    triggerHandlers: ['mouseenter', 'mouseleave'],
    triggers: '> li',
    targets: '',
    lazyLoadImgVid: false
  };

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.DOM = {};
      this.DOM.element = element;
      this.DOM.$element = $(element);
      this.init();
    }

    init() {
      const {
        triggers,
        targets,
        triggerHandlers,
        classname,
        offClassname,
        lazyLoadImgVid
      } = this.options;
      const $triggers = this.DOM.$element.find(triggers);
      const $targets = this.DOM.$element.find(targets);
      $triggers.each((i, trigger) => {
        const $trigger = $(trigger);
        let $target = $targets.eq(i);

        if (!$target.length) {
          $target = $trigger;
        }

        if (triggerHandlers[0] === triggerHandlers[1]) {
          $trigger.on(triggerHandlers[0], () => {
            $target.add(trigger).toggleClass(classname);
          });
        } else {
          $trigger.on(triggerHandlers[0], () => {
            $targets.add($triggers).removeClass(classname);
            $target.add(trigger).addClass(classname);
            $target.add(trigger).removeClass(offClassname);
            lazyLoadImgVid && this.handleLazyload($target);
          });

          if (triggerHandlers[1] != null) {
            $trigger.on(triggerHandlers[1], () => {
              $target.add(trigger).removeClass(classname);
              $target.add(trigger).addClass(offClassname);
            });
          }
        }
      });
    }

    handleLazyload($target) {
      const $imgVids = $target.find('img, source');
      $imgVids.each((i, imgVid) => {
        const $imgVid = $(imgVid);
        const src = $imgVid.attr('data-src');

        if (src) {
          $imgVid.attr('src', src);
        }

        if ($imgVid.is('source') && i === $imgVids.length - 1) {
          const vid = $imgVid.parent('video')[0];
          vid.load();
          vid.play();
        }
      });
    }

    destroy() {
      const {
        triggers
      } = this.options;
      const $triggers = this.DOM.$element.find(triggers);
      $triggers.each((i, trigger) => {
        $(trigger).off();
      });
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('active-onhover-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('[data-active-onhover]').liquidSetActiveOnhover();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidSlideElement';
  let defaults = {
    hiddenElement: null,
    visibleElement: null,
    hiddenElementOnHover: null,
    alignMid: false,
    waitForSplitText: false,
    triggerElement: 'self'
  };

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.element = element;
      this.$element = $(element);
      this.$triggerElement = this.options.triggerElement === 'self' ? this.$element : this.$element.closest(this.options.triggerElement);
      this.timeline = gsap.timeline();

      if (this.options.waitForSplitText) {
        const $splitTextEls = this.$element.find('[data-split-text]');
        const promises = [];

        if ($splitTextEls.length) {
          $splitTextEls.liquidSplitText({
            forceApply: true
          });
          $splitTextEls.each((i, el) => {
            const $el = $(el);
            const splitTextData = $el.data('plugin_liquidSplitText');

            if (splitTextData) {
              promises.push(splitTextData.splitDonePormise);
            }
          });
        }

        if (promises.length > 0) {
          Promise.all(promises).then(this.init.bind(this));
        }
      } else {
        this.init();
      }
    }

    init() {
      this.getElements();

      if (!this.$hiddenElement.length || !this.$visibleElement.length) {
        return;
      }

      imagesLoaded(this.element, () => {
        this.hiddenElementHeight = this.getHiddenElementHeight();
        this.$element.addClass('hide-target');
        this.createTimeline();
        this.moveElements();
        this.eventListeners();
      });
    }

    getElements() {
      this.$hiddenElement = $(this.options.hiddenElement, this.element);
      this.$visibleElement = $(this.options.visibleElement, this.element);
      this.$hiddenElementOnHover = $(this.options.hiddenElementOnHover, this.element);
      this.$hiddenElement.wrap('<div class="ld-slideelement-hidden" />').wrap('<div class="ld-slideelement-hidden-inner" />');
      this.$visibleElement.wrap('<div class="ld-slideelement-visible" />').wrap('<div class="ld-slideelement-visible-inner" />');
      this.$hiddenElementWrap = this.$hiddenElement.closest('.ld-slideelement-hidden');
      this.$hiddenElementInner = this.$hiddenElement.closest('.ld-slideelement-hidden-inner');
      this.$visibleElementWrap = this.$visibleElement.closest('.ld-slideelement-visible');
      this.$visibleElementInner = this.$visibleElement.closest('.ld-slideelement-visible-inner');
    }

    getHiddenElementHeight() {
      let height = 0;
      $.each(this.$hiddenElement, (i, element) => {
        height += $(element).outerHeight(true);
      });
      return height;
    }

    getHiddenElementChilds() {
      return this.$hiddenElementInner.children().map((i, childElement) => $(childElement).parent().get(0));
    }

    getVisibleElementChilds() {
      return this.$visibleElementInner.children().map((i, childElement) => $(childElement).parent().get(0));
    }

    moveElements() {
      const translateVal = this.options.alignMid ? this.hiddenElementHeight / 2 : this.hiddenElementHeight;
      this.$visibleElementWrap.css({
        transform: `translateY(${translateVal}px)`
      });
      this.$hiddenElementWrap.css({
        transform: `translateY(${translateVal}px)`
      });
    }

    createTimeline() {
      const {
        options
      } = this;
      const hiddenElementHeight = this.hiddenElementHeight;
      const childElements = [...this.getVisibleElementChilds(), ...this.getHiddenElementChilds()];
      let translateVal = options.alignMid ? hiddenElementHeight / 2 : hiddenElementHeight;

      if (options.hiddenElementOnHover) {
        const elementHeight = this.$hiddenElementOnHover.outerHeight(true);
        translateVal = options.alignMid ? (hiddenElementHeight + elementHeight) / 2 : hiddenElementHeight + elementHeight;
      }

      this.timeline.to(childElements, {
        y: translateVal * -1,
        opacity: (i, element) => {
          if ($(element).is($(this.$hiddenElementOnHover).parent())) {
            return 0;
          }

          return 1;
        },
        ease: 'power3.out',
        duration: 0.65,
        stagger: 0.065
      }).pause();
    }

    eventListeners() {
      this.$triggerElement.on('mouseenter.lqdSlideElementOnHover', this.onMouseEnter.bind(this));
      this.$triggerElement.on('mouseleave.lqdSlideElementOnHover', this.onMouseLeave.bind(this));
    }

    onMouseEnter() {
      this.timeline.play();
    }

    onMouseLeave() {
      this.timeline.reverse();
    }

    destroy() {
      this.$triggerElement.off('mouseenter.lqdSlideElementOnHover mouseleave.lqdSlideElementOnHover');
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('slideelement-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  const $elements = $('[data-slideelement-onhover]').filter((i, element) => {
    return !$(element).parents('[data-custom-animations]').length && !element.hasAttribute('data-custom-animations') && element.clientHeight > 0;
  });
  $elements.liquidSlideElement();
});
(function ($) {
  'use strict';

  const headerStickyOptions = $liquidMainHeader.length && $liquidMainHeader[0].getAttribute('data-sticky-options');
  const headerIsDynamicColor = headerStickyOptions && JSON.parse(headerStickyOptions).dynamicColors === true;
  const pluginName = 'liquidStack';
  let defaults = {
    sectionSelector: '#lqd-contents-wrap > .vc_row, #lqd-contents-wrap > .vc_section',
    anchors: [],
    easing: 'linear',
    scrollingSpeed: 1200,
    loopTop: false,
    loopBottom: false,
    navigation: false,
    defaultTooltip: 'Section',
    prevNextButtons: true,
    prevNextLabels: {
      prev: 'Previous',
      next: 'Next'
    },
    pageNumber: true,
    effect: 'none',
    disableOnMobile: true,
    normalScrollElements: null,
    normalScrollElementTouchThreshold: 5,
    touchSensitivity: 5
  };
  const $backToTopButton = $('[data-back-to-top], [data-lqd-scroll-indicator]');

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.element = element;
      this.$element = $(element);
      if (this.options.disableOnMobile && (liquidIsMobile() || liquidWindowWidth() <= liquidMobileNavBreakpoint())) return false;
      this.lastScrolledDestiny;
      this.lastAnimation = 0;
      this.scrollings = [];
      this.isTouch = 'ontouchstart' in window || navigator.msMaxTouchPoints > 0 || navigator.maxTouchPoints;
      this.touchStartY = 0;
      this.touchEndY = 0;
      this.prevTime = new Date().getTime();
      this.scrollDelay = 600;
      this.anchors = [];
      this.tooltips = [];
      this.$sectionElements = null;
      this.$ppNav = null;
      this.$ppNavCurrent = null;
      this.$prevNextButtons = $('.lqd-stack-prevnext-wrap');
      this.$pageNumber = $('.lqd-stack-page-number');
      this.$stickyModules = $liquidMainHeader.find('> .elementor > .elementor-section, > .elementor > .e-container, > .elementor > .e-con').not('.lqd-hide-onstuck').find('[data-element_type="widget"]');
      this.$pageNumbersStyle = $liquidBody.hasClass('lqd-stack-nums-style-1') ? 'style1' : $liquidBody.hasClass('lqd-stack-nums-style-2') ? 'style2' : '';
      this.stackInitPromise = new Promise(resolve => {
        this.$element.on('stackinit', resolve.bind(this, this));
      });
      this.$mainNavLocalScroll = $('.main-nav[data-localscroll]');
      LiquidSectionsDetails.getDetails().then(sections => {
        const contentSections = sections.filter(sec => !sec.isInFooter && !sec.isInnerSection);
        const secs = contentSections.map(sec => sec.el);
        this.$sectionElements = $(secs);
        this.build();
        this.addClassnames();
        this.eachSection();
        this.init();
        this.$element.trigger('stackinit');
      });
    }

    moveSectionUp() {
      var prev = this.getActiveSection().$element.prev('.pp-section');

      if (!prev.length && this.options.loopTop) {
        prev = this.$sectionElements.last();
      }

      if (prev.length) {
        this.scrollPage(prev);
      }
    }

    moveSectionDown() {
      var next = this.getActiveSection().$element.next('.pp-section');

      if (!next.length && this.options.loopBottom) {
        next = this.$sectionElements.first();
      }

      if (next.length) {
        this.scrollPage(next);
      }
    }

    moveTo(section) {
      let sec;

      if (isNaN(section)) {
        sec = this.$sectionElements.filter((i, el) => el.getAttribute('data-anchor') === section);
      } else {
        sec = this.$sectionElements.eq(section - 1);
      }

      this.scrollPage(sec);
    }

    getActiveSection() {
      const $element = this.$sectionElements.filter((i, el) => $(el).hasClass('active'));
      const index = this.$sectionElements.get().findIndex(el => el.classList.contains('active'));
      return {
        $element,
        index
      };
    }

    makeScrollable(section) {
      const $section = $(section);
      const $children = $section.children().filter((i, child) => {
        const $childPos = $(child).css('position');
        return $childPos !== 'absolute' && $childPos !== 'fixed';
      });
      const sectionHeight = $section.outerHeight();
      let childrenHeight = 0;

      if ($children.length) {
        $children.each((i, child) => {
          childrenHeight += $(child).outerHeight();
        });
      }

      if (childrenHeight > sectionHeight) {
        const sectionPadding = parseInt($section.css('paddingTop'), 10) + parseInt($section.css('paddingBottom'), 10);
        $section.addClass('pp-scrollable');
        section.style.setProperty('--lqd-section-height', `${childrenHeight + sectionPadding}px`);
      } else {
        $section.removeClass('pp-scrollable');
        section.style.removeProperty('--lqd-section-height');
      }
    }

    addTableClass(section) {
      const $section = $(section);
      $section.addClass('d-flex flex-column flex-nowrap align-content-start');

      if (!$section.children('.pp-section-wrap').length) {
        $section.wrapInner('<div class="pp-section-wrap"><div class="lqd-stack-section-inner"></div></div>');
      }
    }

    getYmovement(destiny) {
      var fromIndex = this.getActiveSection().index;
      var toIndex = this.$sectionElements.index(destiny);
      let dir = 'up';

      if (fromIndex < toIndex) {
        dir = 'down';
      }

      return dir;
    }

    scrollPage(destination) {
      const activeSection = this.getActiveSection();
      var v = {
        destination: destination,
        activeSection: activeSection.$element,
        anchorLink: destination.data('anchor'),
        sectionIndex: this.$sectionElements.index(destination),
        toMove: destination,
        yMovement: this.getYmovement(destination),
        leavingSection: activeSection.index + 1
      };

      if (v.activeSection.is(destination)) {
        return;
      }

      if (typeof v.anchorLink !== 'undefined') {
        this.setURLHash(v.anchorLink, v.sectionIndex);
      }

      this.$sectionElements.removeClass('active');
      this.setActiveSection(v.sectionIndex);
      v.sectionsToMove = this.getSectionsToMove(v);
      v.translate3d = '';

      if (v.yMovement === 'down') {
        if (v.destination.is('.pp-auto-height')) {
          var destinationTransform = v.destination.outerHeight() * -1 + 'px';
          v.translate3d = `translate3d(0px, ${destinationTransform}, 0px)`;
          v.scrolling = destinationTransform;
          v.sectionsToMove = v.activeSection;
        } else {
          v.scrolling = '-100%';
        }

        v.animateSection = v.activeSection;
      } else {
        v.scrolling = '0';
        v.animateSection = destination;
      }

      this.onLeave(v.leavingSection, v.sectionIndex + 1, v.yMovement);
      this.performMovement(v);
      this.activateNavDots(v.sectionIndex);
      this.lastScrolledDestiny = v.anchorLink;
      this.lastAnimation = new Date().getTime();
    }

    performMovement(v) {
      this.transformContainer(v.animateSection, v.translate3d);
      v.sectionsToMove.each(() => {
        this.transformContainer($(this), v.translate3d);
      });
      setTimeout(() => {
        this.afterSectionLoads(v);
      }, this.options.scrollingSpeed);
    }

    afterSectionLoads(v) {
      this.afterLoad(v.anchorLink, v.sectionIndex + 1);
    }

    getSectionsToMove(v) {
      var sectionToMove;

      if (v.yMovement === 'down') {
        sectionToMove = this.$sectionElements.map(function (index) {
          if (index < v.destination.index(this.$sectionElements)) {
            return $(this);
          }
        });
      } else {
        sectionToMove = this.$sectionElements.map(function (index) {
          if (index > v.destination.index(this.$sectionElements)) {
            return $(this);
          }
        });
      }

      return sectionToMove;
    }

    setURLHash(anchorLink) {
      location.hash = anchorLink;
    }

    scrollToAnchor() {
      var value = window.location.hash.replace('#', '');
      var sectionAnchor = value;
      var section = this.$sectionElements.filter((i, el) => $(el).attr('data-anchor') === sectionAnchor);

      if (section.length > 0) {
        this.scrollPage(section);
      }
    }

    isMoving() {
      var timeNow = new Date().getTime();

      if (timeNow - this.lastAnimation < this.scrollDelay + this.options.scrollingSpeed) {
        return true;
      }

      return false;
    }

    hashChangeHandler() {
      var value = window.location.hash.replace('#', '').split('/');
      var sectionAnchor = value[0];

      if (sectionAnchor.length) {
        if (sectionAnchor && sectionAnchor !== this.lastScrolledDestiny) {
          const section = this.$sectionElements.filter((i, el) => $(el).attr('data-anchor') === sectionAnchor);
          this.scrollPage(section);
        }
      }
    }

    getTransforms(translate3d) {
      return {
        '-webkit-transform': translate3d,
        'transform': translate3d
      };
    }

    transformContainer(element, translate3d) {
      element.css(this.getTransforms(translate3d));
    }

    mouseWheelHandler(e) {
      var curTime = new Date().getTime();
      const evt = e.originalEvent;
      var value = evt.wheelDelta || -evt.deltaY || -evt.detail;
      var delta = Math.max(-1, Math.min(1, value));
      var horizontalDetection = typeof evt.wheelDeltaX !== 'undefined' || typeof evt.deltaX !== 'undefined';
      var isScrollingVertically = Math.abs(evt.wheelDeltaX) < Math.abs(evt.wheelDelta) || Math.abs(evt.deltaX) < Math.abs(evt.deltaY) || !horizontalDetection;

      if (this.scrollings.length > 149) {
        this.scrollings.shift();
      }

      this.scrollings.push(Math.abs(value));
      var timeDiff = curTime - this.prevTime;
      this.prevTime = curTime;

      if (timeDiff > 200) {
        this.scrollings = [];
      }

      if (!this.isMoving()) {
        var activeSection = this.getActiveSection().$element;
        var scrollable = this.isScrollable(activeSection);
        var averageEnd = this.getAverage(this.scrollings, 10);
        var averageMiddle = this.getAverage(this.scrollings, 70);
        var isAccelerating = averageEnd >= averageMiddle;

        if (isAccelerating && isScrollingVertically) {
          if (delta < 0) {
            this.scrolling('down', scrollable);
          } else if (delta > 0) {
            this.scrolling('up', scrollable);
          }
        }
      }
    }

    getAverage(elements, number) {
      var sum = 0;
      var lastElements = elements.slice(Math.max(elements.length - number, 1));

      for (var i = 0; i < lastElements.length; i++) {
        sum = sum + lastElements[i];
      }

      return Math.ceil(sum / number);
    }

    scrolling(type, scrollable) {
      var check;
      var scrollSection;

      if (type == 'down') {
        check = 'bottom';
        scrollSection = this.moveSectionDown.bind(this);
      } else {
        check = 'top';
        scrollSection = this.moveSectionUp.bind(this);
      }

      if (scrollable.length > 0) {
        if (this.isScrolled(check, scrollable)) {
          scrollSection();
        } else {
          return true;
        }
      } else {
        scrollSection();
      }
    }

    isScrolled(type, scrollable) {
      if (type === 'top') {
        return !scrollable.scrollTop();
      } else if (type === 'bottom') {
        return scrollable.scrollTop() + 1 + scrollable.innerHeight() >= scrollable[0].scrollHeight;
      }
    }

    isScrollable(activeSection) {
      return activeSection.filter('.pp-scrollable');
    }

    addMouseWheelHandler() {
      this.$element.on('mousewheel wheel', this.mouseWheelHandler.bind(this));
    }

    handleKeys() {
      $(document).keydown(e => {
        if (!this.isMoving()) {
          switch (e.which) {
            case 38:
            case 33:
              this.moveSectionUp();
              break;

            case 40:
            case 34:
              this.moveSectionDown();
              break;

            case 36:
              this.moveTo(1);
              break;

            case 35:
              this.moveTo($('.pp-section').length);
              break;

            default:
              return;
          }
        }
      });
    }

    addTouchHandler() {
      if (this.isTouch) {
        this.$element.off('touchstart').on('touchstart', this.touchStartHandler.bind(this));
        this.$element.off('touchmove').on('touchmove', this.touchMoveHandler.bind(this));
      }
    }

    getEventsPage(e) {
      var events = new Array();
      events.y = typeof e.pageY !== 'undefined' && (e.pageY || e.pageX) ? e.pageY : e.touches[0].pageY;
      return events;
    }

    isReallyTouch(e) {
      return typeof e.pointerType === 'undefined' || e.pointerType != 'mouse';
    }

    touchStartHandler(event) {
      var e = event.originalEvent;

      if (this.isReallyTouch(e)) {
        var touchEvents = this.getEventsPage(e);
        this.touchStartY = touchEvents.y;
      }
    }

    touchMoveHandler(event) {
      var e = event.originalEvent;

      if (this.isReallyTouch(e)) {
        var activeSection = this.getActiveSection().$element;
        var scrollable = this.isScrollable(activeSection);

        if (!scrollable.length) {
          event.preventDefault();
        }

        if (!this.isMoving()) {
          var touchEvents = this.getEventsPage(e);
          this.touchEndY = touchEvents.y;

          if (Math.abs(this.touchStartY - this.touchEndY) > this.$element.height() / 100 * this.options.touchSensitivity) {
            if (this.touchStartY > this.touchEndY) {
              this.scrolling('down', scrollable);
            } else if (this.touchEndY > this.touchStartY) {
              this.scrolling('up', scrollable);
            }
          }
        }
      }
    }

    buildNavigationMarkup() {
      if (this.$ppNav) {
        this.$ppNav.remove();
      }

      this.$ppNav = $(`
				<div id="pp-nav">
					<div class="pp-nav-inner">
						<span class="pp-nav-current"><span></span></span>
						<ul class="pp-nav-ul reset-ul"></ul>
					</div>
				</div>
			`);
      this.$ppNavCurrent = $('.pp-nav-current', this.$ppNav);
      this.$ppNav.children().append(`<span class="pp-nav-total">${this.$sectionElements.length < 10 ? '0' + this.$sectionElements.length : this.$sectionElements.length}</span>`);
      $('body').append(this.$ppNav);
    }

    addNavigationItem(i) {
      this.$ppNavCurrent.find('> span').append(`<span>${i < 10 ? '0' + (i + 1) : i + 1}</span>`);
      this.$ppNav.find('ul').append(`<li data-tooltip="${this.tooltips[i]}">
				<a href="#${this.anchors[i]}">
					<span></span>
					<svg width="29px" height="29px" viewBox="0 0 29 29" stroke="#000" stroke-width="1" fill="none" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
						<path d="M14.5,28 C21.9558441,28 28,21.9558441 28,14.5 C28,7.04415588 21.9558441,1 14.5,1 C7.04415588,1 1,7.04415588 1,14.5 C1,21.9558441 7.04415588,28 14.5,28 Z"></path>
					</svg>
				</a>
				<span class="pp-tooltip">${this.tooltips[i]}</span>
			</li>`);
    }

    activateNavDots(sectionIndex) {
      this.$ppNav.find('li').removeClass('active');
      this.$ppNav.find('li').eq(sectionIndex).addClass('active');
    }

    updateSections($sections) {
      this.$sectionElements = $sections;
      this.buildNavigationMarkup();
      this.addClassnames();
      this.eachSection();
    }

    sectionAppended(section, i) {
      const sec = $(section).get(0);

      if (!i) {
        this.$sectionElements = $([...this.$sectionElements, sec]);
      } else {
        this.$sectionElements = $([...this.$sectionElements].splice(i, 0, sec));
      }

      this.buildNavigationMarkup();
      this.addClassnames();
      this.eachSection();
    }

    setActiveSection(index) {
      this.$sectionElements.removeClass('active');
      this.$sectionElements.eq(index).addClass('active');
    }

    build() {
      this.buildNavigationMarkup();

      if ($liquidMainFooter.length && !window.frameElement) {
        let $toAppendFooter;

        if (liquidIsElementor) {
          $toAppendFooter = $liquidContentsWrap.find(' > .elementor');
        } else {
          $toAppendFooter = $liquidContentsWrap;
        }

        $toAppendFooter.append($liquidMainFooter);
        this.$sectionElements.last().addClass('section-before-footer');
        this.$sectionElements.push($liquidMainFooter[0]);
      }

      $liquidContentsWrap.children('style').appendTo('head');
      $liquidContentsWrap.children('p').insertAfter($liquidSiteWrap);
    }

    addClassnames() {
      const {
        options
      } = this;
      this.$sectionElements.addClass('pp-section');
      $liquidMainFooter.length && $liquidMainFooter.addClass('vc_row pp-auto-height');
      options.navigation && $liquidBody.addClass('lqd-stack-has-nav');
      options.prevNextButtons && $liquidBody.addClass('lqd-stack-has-prevnext-buttons');
      options.pageNumber && $liquidBody.addClass('lqd-stack-has-page-numbers');
      options.effect !== 'none' && $liquidBody.addClass('lqd-stack-effect-enabled');
      $liquidBody.addClass(`lqd-stack-effect-${options.effect}`);
      $liquidHtml.add('html').addClass('html-pp-enabled overflow-hidden');
      $liquidBody.addClass('pp-enabled');
    }

    eachSection() {
      $.each(this.$sectionElements, (i, section) => {
        this.makeScrollable(section);
        this.setAnchors(i, section);
        this.setTooltips(i, section);
        section.classList.contains('main-footer') || this.addNavigationItem(i);
      });
    }

    setAnchors(i, section) {
      let anchor = '';
      let hasAnchorAttr = false;

      if (section.hasAttribute('id')) {
        anchor = section.getAttribute('id');
      } else if (section.hasAttribute('data-tooltip')) {
        anchor = section.getAttribute('data-tooltip').replace(new RegExp(' ', 'g'), '-').toLowerCase();
      } else {
        if (!section.hasAttribute('data-anchor')) {
          anchor = `${this.options.defaultTooltip}-${i + 1}`;
        } else {
          hasAnchorAttr = true;
          anchor = section.getAttribute('data-anchor');
        }
      }

      this.anchors[i] = anchor;

      if (!hasAnchorAttr) {
        $(section).attr('data-anchor', anchor);
      }
    }

    setTooltips(i, section) {
      if (!section.hasAttribute('data-tooltip')) {
        this.tooltips[i] = `${this.options.defaultTooltip} ${i + 1}`;
      } else {
        this.tooltips[i] = section.getAttribute('data-tooltip');
      }
    }

    init() {
      this.addMouseWheelHandler();
      this.handleKeys();
      this.addTouchHandler();

      if (!this.lastScrolledDestiny) {
        this.setActiveSection(0);
        this.activateNavDots(0);
        this.addLuminosityClassnames(0);
      }

      this.scrollToAnchor();
      this.afterRender();
      $(window).on('hashchange', this.hashChangeHandler.bind(this));
    }

    appendPrevNextButtons() {
      const {
        prevNextLabels
      } = this.options;
      this.$prevNextButtons = $('<div class="lqd-stack-prevnext-wrap" />');
      const $prevButton = $(`<button class="lqd-stack-prevnext-button lqd-stack-prev-button">
				<span class="lqd-stack-button-label">${prevNextLabels.prev}</span>
				<span class="lqd-stack-button-ext">
				</span>
			</button>`);
      const $nextButton = $(`<button class="lqd-stack-prevnext-button lqd-stack-next-button">
				<span class="lqd-stack-button-label">${prevNextLabels.next}</span>
				<span class="lqd-stack-button-ext">
				</span>
			</button>`);
      this.$prevNextButtons.append($prevButton.add($nextButton));
      !$liquidBody.children('.lqd-stack-prevnext-wrap').length && $liquidBody.append(this.$prevNextButtons);
    }

    prevNextButtonsEvents() {
      const $prevButton = this.$prevNextButtons.find('.lqd-stack-prev-button');
      const $nextButton = this.$prevNextButtons.find('.lqd-stack-next-button');
      $prevButton.on('click', this.moveSectionUp.bind(this));
      $nextButton.on('click', this.moveSectionDown.bind(this));
    }

    appendPageNumber() {
      let $pageNumber;
      if (this.$pageNumbersStyle === 'style1') $pageNumber = this.appendPageNumbersStyle1();
      if (this.$pageNumbersStyle === 'style2') $pageNumber = this.appendPageNumbersStyle2();

      if (!this.$pageNumber.length) {
        $liquidBody.append($pageNumber);
        this.$pageNumber = $pageNumber;
      }
    }

    appendPageNumbersStyle1() {
      const totalSections = this.$sectionElements.not('.main-footer').length;
      const $pageNumber = $('<div class="lqd-stack-page-number" />');
      const $pageNumnerCounter = $(`<span class="lqd-stack-page-number-counter">
				<span class="lqd-stack-page-number-current"></span>
				<span class="lqd-stack-page-number-passed"></span>
			</span>`);
      const $pageNumnerTotal = $(`<span class="lqd-stack-page-number-total">${totalSections < 10 ? '0' : ''}${totalSections}</span>`);
      $pageNumber.append($pageNumnerCounter);
      $pageNumber.append($pageNumnerTotal);
      return $pageNumber;
    }

    appendPageNumbersStyle2() {
      const $pageNumber = $('<div class="lqd-stack-page-number" />');
      const $ppNavClone = this.$ppNav.find('.pp-nav-ul').clone(true);
      $pageNumber.append($ppNavClone);
      return $pageNumber;
    }

    setPageNumber(index) {
      $liquidBody.attr('data-lqd-stack-page', index);
      this.$pageNumbersStyle === 'style1' && this.setPageNumbersStyle1(index);
      this.$pageNumbersStyle === 'style2' && this.setPageNumbersStyle2(index);
    }

    setPageNumbersStyle1(index) {
      const $currentPageNumber = this.$pageNumber.find('.lqd-stack-page-number-current');
      const $passedPageNumber = this.$pageNumber.find('.lqd-stack-page-number-passed');
      $passedPageNumber.html($currentPageNumber.html());
      $currentPageNumber.html(`${index < 10 ? '0' : ''}${index}`);
    }

    setPageNumbersStyle2(index) {
      const $li = this.$pageNumber.find('li');
      $li.removeClass('active');
      $li.eq(index - 1).addClass('active');
    }

    addDirectionClassname(direction) {
      if (direction === 'down') {
        $liquidBody.removeClass('lqd-stack-moving-up').addClass('lqd-stack-moving-down');
      } else if (direction === 'up') {
        $liquidBody.removeClass('lqd-stack-moving-down').addClass('lqd-stack-moving-up');
      }
    }

    addLuminosityClassnames(index) {
      fastdom.mutate(() => {
        const $elements = !headerIsDynamicColor ? $liquidBody : $liquidBody.add($liquidMainHeader).add(this.$stickyModules);
        $elements.removeClass('lqd-active-row-dark lqd-active-row-light').addClass(`lqd-active-row-${this.$sectionElements.eq(index).attr('data-section-luminosity')}`);
      });
    }

    initShortcodes($destinationRow, isFirstRender) {
      !liquidIsMobile() && $('[data-dynamic-shape]', $destinationRow).liquidDynamicShape();
      $('[data-reveal]', $destinationRow).liquidReveal();
      $('[data-particles=true]', $destinationRow).liquidParticles();
      $('[data-liquid-masonry]', $destinationRow).liquidMasonry();

      if (isFirstRender) {
        this.initInview($destinationRow, true);
      }

      if (liquidIsMobile() && document.body.hasAttribute('data-disable-animations-onmobile')) {
        return $('[data-custom-animations]').addClass('ca-initvalues-applied');
      }

      ;
      $('[data-custom-animations]', $destinationRow).liquidCustomAnimations();
      $destinationRow.is('[data-custom-animations]') && $destinationRow.liquidCustomAnimations();
    }

    initBackToTop(rowIndex) {
      if (rowIndex > 1) {
        $backToTopButton.addClass('is-visible');
      } else {
        $backToTopButton.removeClass('is-visible');
      }

      $('a', $backToTopButton).on('click', event => {
        event.preventDefault();
        this.moveTo(1);
      });
    }

    afterRender() {
      if ($liquidMainFooter.length) {
        $liquidBody.addClass('lqd-stack-has-footer');
      }

      const activeSectionIndex = this.$sectionElements.get().findIndex(section => section.classList.contains('active'));
      this.initShortcodes(this.$sectionElements.eq(activeSectionIndex), true);

      if (!window.frameElement) {
        this.options.prevNextButtons && this.appendPrevNextButtons();
        this.options.prevNextButtons && this.prevNextButtonsEvents();
        this.options.pageNumber && this.appendPageNumber();
        this.setPageNumber(activeSectionIndex + 1);
      }

      $liquidBody.addClass('lqd-stack-initiated');
    }

    onLeave(index, nextIndex, direction) {
      const $destinationRow = $(this.$sectionElements[nextIndex - 1]);
      const $originRow = $(this.$sectionElements[index - 1]);

      if (!$destinationRow.hasClass('main-footer') && !$originRow.hasClass('main-footer')) {
        this.$ppNav.css('pointer-events', 'none');
        $liquidBody.addClass('lqd-stack-moving');
        this.setPageNumber(nextIndex);
        $destinationRow.removeClass('lqd-stack-row-leaving').addClass('lqd-stack-row-entering');
        $originRow.removeClass('lqd-stack-row-entering').addClass('lqd-stack-row-leaving');
        this.addLuminosityClassnames(nextIndex - 1);
        this.$ppNavCurrent.children('span').css({
          transform: `translateY(-${(nextIndex - 1) * 100}%)`
        });
      } else if ($originRow.hasClass('main-footer')) {
        $originRow.addClass('lqd-stack-row-leaving');
      }

      if ($destinationRow.hasClass('main-footer')) {
        $liquidBody.addClass('lqd-stack-footer-active');
        $originRow.css('transform', 'none');
      } else {
        $liquidBody.removeClass('lqd-stack-footer-active');
      }

      this.addDirectionClassname(direction);
      this.initShortcodes($destinationRow, false);
      $backToTopButton.length && this.initBackToTop(nextIndex);

      if (this.$mainNavLocalScroll.length) {
        this.handleMainNavLocalScroll();
      }
    }

    afterLoad(anchorLink, rowIndex) {
      const $destinationRow = $(this.$sectionElements[rowIndex - 1]);
      $(this.$sectionElements).removeClass('lqd-stack-row-entering lqd-stack-row-leaving');
      this.$ppNav.css('pointer-events', '');
      $liquidBody.removeClass('lqd-stack-moving lqd-stack-moving-up lqd-stack-moving-down');
      this.initInview($destinationRow, false);
    }

    initInview($destinationRow, waitForPreloader) {
      if ($liquidBody.hasClass('lqd-preloader-activated') && waitForPreloader) {
        document.addEventListener('lqd-preloader-anim-done', () => {
          $('[data-inview]', $destinationRow).liquidInView();
        });
      } else {
        $('[data-inview]', $destinationRow).liquidInView();
      }
    }

    handleMainNavLocalScroll() {
      const winHash = window.location.hash;

      if (winHash) {
        this.$mainNavLocalScroll.find(`a[href="${winHash}"]`).parent().addClass('is-active').siblings().removeClass('is-active');
        this.$mainNavLocalScroll.closest('.navbar-fullscreen').collapse('hide');
        this.$mainNavLocalScroll.closest('.navbar-collapse').collapse('hide');
        this.$mainNavLocalScroll.closest('.ld-module-dropdown').collapse('hide');
      }
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('stack-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  if (!window.frameElement) {
    $('[data-liquid-stack=true]').liquidStack();
  }
});
(function ($) {
  'use strict';

  const pluginName = 'liquidTab';
  let defaults = {
    deepLink: false,
    trigger: 'click',
    translateNav: false
  };

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.element = element;
      this.$element = $(element);
      this.$tabNav = $('.lqd-tabs-nav', this.element);
      this.$navItems = $('> li > a', this.$tabNav);
      this.$activeItem = this.$navItems.filter((i, el) => $(el).parent().hasClass('active'));
      this.$tabNavArrows = ('.lqd-tabs-nav-arrows', this.element);
      this.$tabNavPrev = $('.lqd-tabs-nav-prev', this.$tabNavArrows);
      this.$tabNavNext = $('.lqd-tabs-nav-next', this.$tabNavArrows);
      this.canChange = true;

      if (this.$activeItem.length && this.options.translateNav) {
        this.activeItemWidth = this.$activeItem.outerWidth();
        this.activeItemHeight = this.$activeItem.outerHeight();
        this.activeItemPosLeft = this.$activeItem.position().left;
      }

      this.init();
    }

    init() {
      const {
        deepLink,
        translateNav
      } = this.options;
      this.$navItems.tab();
      deepLink && this.setHash();
      translateNav && this.translateNav(false);
      this.eventHandlers();
    }

    setHash() {
      const $el = this.$tabNav.find(`a[href="${location.hash}"]`);

      if (location.hash !== '' && $el.length) {
        $el.tab('show');
      }
    }

    eventHandlers() {
      if (this.options.trigger === 'hover' && !liquidIsMobile()) {
        this.$navItems.on('mouseenter.lqdTabs', event => {
          $(event.currentTarget).tab('show');
        });
      }

      this.$element.on('hide.bs.tab', this.onHide.bind(this));
      this.$element.on('show.bs.tab', this.onShow.bind(this));
      this.$element.on('shown.bs.tab', this.onShown.bind(this));
      this.$tabNavPrev.on('click.lqdTabs', this.showPrev.bind(this));
      this.$tabNavNext.on('click.lqdTabs', this.showNext.bind(this));
    }

    onHide(event) {
      this.canChange = false;
    }

    onShow(event) {
      this.$activeItem = $(event.target);
      const {
        deepLink,
        translateNav
      } = this.options;

      if (deepLink) {
        const href = $(event.target).attr('href');
        location.hash = href;
        const scrollPos = $(document).scrollTop();
        $(document).scrollTop(scrollPos);
      }

      if (event.relatedTarget) {
        const $prevActiveItem = $(event.relatedTarget);
        const $prevActiveTarget = $($prevActiveItem.attr('href'));
        $prevActiveTarget.removeClass('active in');
      }

      if (translateNav) {
        this.activeItemWidth = this.$activeItem.outerWidth();
        this.activeItemHeight = this.$activeItem.outerHeight();
        this.activeItemPosLeft = this.$activeItem.position().left;
        this.translateNav(true);
      }
    }

    onShown(event) {
      this.canChange = true;
      const $link = $(event.target);
      const $target = $($link.attr('href'));
      const parentOffsetTop = this.$element.offset().top;
      const stickyHeaderHeight = $('[data-sticky-header].is-stuck')?.outerHeight() || 0;

      if (parentOffsetTop <= $liquidWindow.scrollTop() - 15) {
        $('html, body').stop().animate({
          scrollTop: parentOffsetTop - stickyHeaderHeight - 45
        }, 800);
      }

      this.initPlugins($target);
    }

    translateNav(move) {
      this.element.style.setProperty('--lqd-tabs-nav-active-width', `${this.activeItemWidth}px`);
      this.element.style.setProperty('--lqd-tabs-nav-active-height', `${this.activeItemHeight}px`);

      if (move) {
        this.element.style.setProperty('--lqd-tabs-nav-translate', `${this.activeItemPosLeft}px`);
      }
    }

    showPrev() {
      if (!this.canChange) {
        return;
      }

      this.$activeItem.parent().prev().children('a').tab('show');
    }

    showNext() {
      if (!this.canChange) {
        return;
      }

      this.$activeItem.parent().next().children('a').tab('show');
    }

    initPlugins($target) {
      const $pie_charts = $('.vc_pie_chart:not(.vc_ready)', $target);
      const $round_charts = $('.vc_round-chart', $target);
      const $line_charts = $('.vc_line-chart', $target);
      const $elementor_gallery = $('.elementor-gallery__container', $target);
      if ($pie_charts.length && $.fn.vcChat) $pie_charts.vcChart();
      if ($round_charts.length && $.fn.vcRoundChart) $round_charts.vcRoundChart({
        reload: !1
      });
      if ($line_charts.length && $.fn.vcLineChart) $line_charts.vcLineChart({
        reload: !1
      });
      $('[data-hover3d=true]', $target).liquidHover3d();
      $('[data-split-text]', $target).liquidSplitText();
      $('[data-slideelement-onhover]', $target).liquidSlideElement();
      $('.cd-image-container', $target).liquidImageComparison();
      $elementor_gallery.trigger('resize');
    }

    destroy() {
      this.$navItems.off('mouseenter.lqdTabs');
      this.$element.off('hide.bs.tab show.bs.tab shown.bs.tab', this.onHide.bind(this));
      this.$tabNavPrev.off('click.lqdTabs');
      this.$tabNavNext.off('click.lqdTabs');
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('tabs-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('.lqd-tabs').liquidTab();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidTypewriter';
  let defaults = {
    repeat: true,
    speed: 75
  };

  class Plugin {
    constructor(element, options) {
      this.element = element;
      this.$element = $(element);
      this.options = { ...defaults,
        ...options
      };
      this._defaults = defaults;
      this._name = pluginName;
      this.init();
      this.initIO();
    }

    init() {
      const {
        repeat,
        speed
      } = this.options;
      this.$element.t({
        repeat,
        speed
      });
      this.$element.t('pause', true);
    }

    initIO() {
      new IntersectionObserver(([entry], observer) => {
        if (entry.isIntersecting) {
          this.$element.t('pause', false);
        } else {
          this.$element.t('pause', true);
        }
      }).observe(this.element);
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('plugin-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('[data-typewriter]').liquidTypewriter();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidVideoBg';
  let defaultInlineVideoOptions = {
    startVolume: false,
    controls: false,
    loop: true,
    muted: true,
    hideVideoControlsOnLoad: true,
    hideVideoControlsOnPause: true,
    clickToPlayPause: false,
    disableOnMobile: false
  };
  let defaultYoutubeOptions = {
    autoPlay: true,
    showControls: false,
    loop: true,
    mute: true,
    showYTLogo: false,
    stopMovieOnBlur: false,
    disableOnMobile: false
  };

  class Plugin {
    constructor(element, inlineVideoOptions, youtubeOptions) {
      this.element = element;
      this.$element = $(element);
      this.inlineVideoOptions = { ...defaultInlineVideoOptions,
        ...inlineVideoOptions
      };
      this.youtubeOptions = { ...defaultYoutubeOptions,
        ...youtubeOptions
      };
      this._name = pluginName;
      this.lqdVBG = null;
      this.lqdYTPlayer = null;
      this.init();
    }

    init() {
      const isMobile = liquidIsMobile();

      if (this.$element.is('video') && this.inlineVideoOptions.disableOnMobile && isMobile) {
        this.$element.closest('.lqd-vbg-wrap').addClass('hidden');
      } else if (this.$element.is('video')) {
        this.$element.removeClass('hidden');
        this.initInlineVideo();
      }

      if (!this.$element.is('video') && this.youtubeOptions.disableOnMobile && isMobile) {
        this.$element.closest('.lqd-vbg-wrap').addClass('hidden');
      } else if (!this.$element.is('video')) {
        this.initYoutubeVideo();
      }
    }

    initInlineVideo() {
      const $vBgWrap = this.$element.closest('.lqd-vbg-wrap');
      const elementToObserve = $vBgWrap.length ? $vBgWrap.get(0) : this.element;
      const videoOptions = $.extend({}, this.inlineVideoOptions, {
        stretching: 'responsive',
        success: mediaElement => {
          mediaElement.pause();
          this.initInlineVidIO(elementToObserve);
        }
      });
      this.lqdVBG = new MediaElementPlayer(this.element, videoOptions);
    }

    initYoutubeVideo() {
      const videoOptions = $.extend({}, this.youtubeOptions, {
        containment: this.$element
      });
      this.lqdYTPlayer = this.$element.YTPlayer(videoOptions);
      this.lqdYTPlayer.on('YTPReady', () => {
        this.lqdYTPlayer.YTPPause();
        this.initYTIO();
      });
    }

    initInlineVidIO(elementToObserve) {
      new IntersectionObserver(([entry]) => {
        if (entry.isIntersecting) {
          this.lqdVBG && this.lqdVBG.play();
        } else {
          this.lqdVBG && this.lqdVBG.pause();
        }
      }).observe(elementToObserve);
    }

    initYTIO() {
      new IntersectionObserver(([entry]) => {
        if (entry.isIntersecting) {
          this.lqdYTPlayer && this.lqdYTPlayer.YTPPlay();
        } else {
          this.lqdYTPlayer && this.lqdYTPlayer.YTPPause();
        }
      }).observe(this.element);
    }

  }

  $.fn[pluginName] = function (inlineVideoOptions, youtubeOptions) {
    return this.each(function () {
      const inlineVidOptions = { ...$(this).data('inlinevideo-options'),
        ...inlineVideoOptions
      };
      const YTOptions = { ...$(this).data('youtube-options'),
        ...youtubeOptions
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, inlineVidOptions, YTOptions));
      }
    });
  };
})(jQuery, window, document);

jQuery(document).ready(function ($) {
  $('[data-video-bg]').liquidVideoBg();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidVideoTrigger';
  let defaults = {
    triggerType: ['mouseenter', 'mouseleave'],
    videoPlacement: "parent"
  };

  class Plugin {
    constructor(element, options) {
      this.element = element;
      this.$element = $(element);
      this.options = $.extend({}, defaults, options);
      this._defaults = defaults;
      this._name = pluginName;
      this.videoElement = this.$element[this.options.videoPlacement]().find('video').get(0);
      this.init();
    }

    init() {
      this.videoElement.oncanplay = this.events.call(this);
    }

    events() {
      this.$element.on(this.options.triggerType[0], this.triggerOn.bind(this));
      this.$element.on(this.options.triggerType[1], this.triggerOff.bind(this));
    }

    triggerOn() {
      this.videoElement.play();
    }

    triggerOff() {
      this.videoElement.pause();
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = $(this).data('trigger-options') || options;

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('[data-video-trigger]').liquidVideoTrigger();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidSlideshow';
  let defaults = {
    menuItems: '.lqd-vslider-menu a',
    images: '.lqd-vslider-images figure',
    extras: '.lqd-vslider-ext > ul > li'
  };

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.DOM = {};
      this.DOM.element = element;
      this.DOM.$element = $(element);
      this.DOM.$menuItems = $(this.options.menuItems, this.DOM.$element);
      this.DOM.$images = $(this.options.images, this.DOM.$element);
      this.DOM.$extras = $(this.options.extras, this.DOM.$element);
      this.DOM.$loader = $('.lqd-vslider-loader', this.DOM.$element);
      this.isLoading = false;
      this.prevItem = 0;
      this.currentItem = 0;
      this.init();
    }

    init() {
      this.loadImage();
      this.events();
    }

    events() {
      this.DOM.$menuItems.each((i, item) => {
        $(item).on('click', ev => {
          ev.preventDefault();
          ev.stopPropagation();
          if (this.isLoading) return;
          this.prevItem = this.currentItem;
          this.currentItem = i;
          if (this.prevItem === this.currentItem) return;
          this.loadImage();
        });
      });
    }

    loadImage() {
      const $currentFigure = this.DOM.$images.eq(this.currentItem);
      const $img = $('img', $currentFigure);

      if (!$img.hasClass('loaded')) {
        $img.attr('src', $img.attr('data-src'));
      }

      this.isLoading = true;
      this.DOM.$element.addClass('is-loading');
      imagesLoaded($img[0], this.onImageLoaded.bind(this));
    }

    onImageLoaded() {
      const $currentFigure = this.DOM.$images.eq(this.currentItem);
      const $currentImg = $('img', $currentFigure);
      const $currentExtras = this.DOM.$extras.eq(this.currentItem);
      const $menuLi = this.DOM.$menuItems.eq(this.currentItem).parent();
      this.isLoading = false;
      this.DOM.$element.removeClass('is-loading');
      $currentImg.addClass('loaded');
      this.DOM.$images.removeClass('is-active');
      this.DOM.$menuItems.parent().removeClass('is-active');
      this.DOM.$extras.removeClass('is-active');
      $currentFigure.addClass('is-active');
      $currentExtras.addClass('is-active');
      $menuLi.addClass('is-active');
      this.animateElements();
    }

    animateElements() {
      const $prevExtras = this.DOM.$extras.eq(this.prevItem);
      const $currentExtras = this.DOM.$extras.eq(this.currentItem);
      const $prevExtrasChildElements = $prevExtras.children().not('style');
      const $currentExtrasChildElements = $currentExtras.children().not('style');
      gsap.fromTo($prevExtras[0], {
        opacity: 1
      }, {
        opacity: 0,
        delay: 0.2
      });
      gsap.fromTo($currentExtras[0], {
        opacity: 0
      }, {
        opacity: 1,
        delay: 0.2
      });
      gsap.fromTo($prevExtrasChildElements.get(), {
        xPercent: 0,
        opacity: 1
      }, {
        xPercent: 3,
        opacity: 0,
        stagger: 0.1,
        delay: 0.3
      });
      gsap.fromTo($currentExtrasChildElements.get(), {
        xPercent: -3,
        opacity: 0
      }, {
        xPercent: 0,
        opacity: 1,
        stagger: 0.1,
        delay: 0.3
      });
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('slideshow-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('[data-lqd-slideshow]').liquidSlideshow();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidWoo';
  let defaults = {};

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.DOM = {};
      this.DOM.$element = $(element);
      this.DOM.$headerCart = $('.ld-module-cart');
      this.DOM.$snickersBarTemp = $('#lqd-temp-snickersbar');
      this.DOM.$snickersBar = null;
      this.snickersBarsHeight = 20;
      this.cartItems = [];
      this.init();
    }

    init() {
      this.events();
    }

    events() {
      $(document).on('adding_to_cart', (event, $btn, data) => {
        this.onAddingToCart.call(this, data);
      });
      $(document).on('added_to_cart', (event, frags, cartHash, $btn) => {
        this.onAddedToCart.call(this, frags, $btn);
      });
      $(document).on('removed_from_cart', (event, frags) => {
        this.onRemovedFromCart.call(this, frags);
      });
      $(document).on('updated_wc_div', this.onUpdatedWcDiv.bind(this));
      $('.widget_price_filter form').on('submit', this.onWcanAjaxLoading.bind(this));
      $(document).on('yith-wcan-ajax-loading', this.onWcanAjaxLoading.bind(this));
      $(document).on('yith-wcan-ajax-filtered ajaxComplete', this.onWCanAjaxFiltered.bind(this));
      $(document).on('qv_loader_stop', () => {
        this.formIntputsInit.call(this);
      });
    }

    onAddingToCart(data) {
      this.initSnickersBar(data);
    }

    initSnickersBar(data) {
      const cartItem = this.cartItems.find(item => item.id === data.product_id);

      if (cartItem) {
        const {
          $snickersBarEl,
          snickersBarHeight,
          isVisible
        } = cartItem;
        $snickersBarEl.removeClass('lqd-snickersbar-action-done');

        if (!isVisible) {
          $snickersBarEl.addClass('lqd-snickersbar-in').removeClass('lqd-snickersbar-out');
          cartItem.isVisible = true;
          this.snickersBarsHeight += snickersBarHeight;
        }

        this.hideSnickersBar(cartItem);
      } else {
        this.createSnickersBar(data);
      }

      this.upadteSnickersBarsPos();
    }

    createSnickersBar(data) {
      const {
        product_id,
        product_name
      } = data;
      const snickersClone = this.DOM.$snickersBarTemp[0].content.cloneNode(true);
      const $snickersBar = $('.lqd-snickersbar', snickersClone);
      const $addningMsgTemp = $('.lqd-snickersbar-addding-temp', $snickersBar);
      const $addedMsgTemp = $('.lqd-snickersbar-added-temp', $snickersBar);
      const $msg = $('.lqd-snickersbar-msg', $snickersBar);
      const $msgDone = $('.lqd-snickersbar-msg-done', $snickersBar);
      const $checkIcon = $('<svg width="32" height="29" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 29" style="height: 1.25em; margin-inline-start: .25rem;"><path fill="currentColor" d="M25.74 6.23c0.38 0.34 0.42 0.9 0.09 1.28l-12.77 14.58a0.91 0.91 0 0 1-1.33 0.04l-5.46-5.46a0.91 0.91 0 1 1 1.29-1.29l4.77 4.78 12.12-13.85a0.91 0.91 0 0 1 1.29-0.08z"></path></svg>');
      const $spinIcon = $('<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" style="height: 1em; margin-inline-start: .25rem;"><path fill="currentColor" d="M4.005 16.03c0-5.945 4.344-10.842 10.027-11.802v1.784l4.004-3.006L14.032 0v2.162C7.244 3.142 2.007 8.98 2.007 16.03c0 5.072 2.715 9.503 6.75 11.976l1.745-1.31c-3.85-2.007-6.487-6.03-6.497-10.666zm26.056 0c0-5.072-2.716-9.504-6.75-11.967l-1.745 1.31c3.85 2.006 6.487 6.03 6.487 10.656 0 5.944-4.344 10.86-10.017 11.82v-1.793l-4.004 3.006 4.004 3.006v-2.172c6.788-.98 12.025-6.817 12.025-13.867z"></path></svg>');
      $msg.text($addningMsgTemp.text().replace(/\{\{itemName\}\}/, product_name));
      $msgDone.text($addedMsgTemp.text().replace(/\{\{itemName\}\}/, product_name));
      $snickersBar.attr('data-item-id', product_id);
      $msg.append($spinIcon);
      $msgDone.append($checkIcon);
      $liquidBody.append($snickersBar);
      const newCartItem = {
        id: product_id,
        name: product_name,
        $snickersBarEl: $snickersBar,
        $msgEl: $msg,
        $msgDoneEl: $msgDone,
        snickersBarHeight: $snickersBar.outerHeight(true),
        isVisible: true,
        timeout: null
      };
      this.snickersBarsHeight += newCartItem.snickersBarHeight;
      this.cartItems.push(newCartItem);
    }

    onAddedToCart(frags, $btn) {
      this.updateCartAmount(frags);
      const cartItem = this.cartItems.find(item => item.id === $btn.attr('data-product_id'));

      if (cartItem) {
        const {
          $snickersBarEl
        } = cartItem;
        const $snickersBarExtEl = $('.lqd-snickersbar-ext', $snickersBarEl);
        !$snickersBarExtEl.children('.added_to_cart').length && $snickersBarExtEl.append($btn.siblings('.added_to_cart').clone(true));
        $snickersBarEl.addClass('lqd-snickersbar-action-done');
        this.hideSnickersBar(cartItem);
      }
    }

    hideSnickersBar(cartItem) {
      const {
        $snickersBarEl,
        snickersBarHeight,
        isVisible
      } = cartItem;
      const timeOutVal = getComputedStyle(document.body).getPropertyValue('--lqd-snickersbar-stay-time');

      if (cartItem.timeout) {
        clearTimeout(cartItem.timeout);
        cartItem.timeout = null;
        $snickersBarEl.addClass('lqd-snickersbar-in').removeClass('lqd-snickersbar-out');
        cartItem.isVisible = true;
      } else {
        cartItem.timeout = setTimeout(() => {
          if (isVisible) {
            $snickersBarEl.addClass('lqd-snickersbar-out').removeClass('lqd-snickersbar-in');
            cartItem.isVisible = false;
            this.snickersBarsHeight -= snickersBarHeight;
          }

          this.upadteSnickersBarsPos();
          clearTimeout(cartItem.timeout);
        }, parseFloat(timeOutVal) * 1000);
      }
    }

    upadteSnickersBarsPos() {
      let heights = 0;
      this.cartItems.forEach(item => {
        if (item.isVisible) heights += item.snickersBarHeight;
        item.$snickersBarEl.css('transform', `translateY(${(this.snickersBarsHeight - heights) * -1}px)`);
      });
    }

    onRemovedFromCart(frags) {
      this.updateCartAmount(frags);
      this.lazyLoadUpdate();
    }

    onUpdatedWcDiv() {
      this.formIntputsInit();
    }

    updateCartAmount(frags) {
      const $headerCartAmount = this.DOM.$headerCart.find('.ld-module-trigger-txt .woocommerce-Price-amount');
      const amount = $(frags['span.header-cart-amount']);

      if ($headerCartAmount.length && amount) {
        $headerCartAmount.text(amount.text());
      }
    }

    lazyLoadUpdate() {
      if (window.liquidLazyload) {
        window.liquidLazyload.update();
      }
    }

    formIntputsInit() {
      $('form').liquidFormInputs();
    }

    onWCanAjaxFiltered() {
      this.lazyLoadUpdate();
      $('.widget').removeClass('wcan-ajax-loading');
    }

    onWcanAjaxLoading() {
      $('.widget').addClass('wcan-ajax-loading');
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('woo-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  if ($('.woocommerce').length) {
    $liquidBody.liquidWoo();
  }
});
(function ($) {
  'use strict';

  const pluginName = 'liquidZIndex';
  let defaults = {
    triggers: ['mouseenter', 'mouseleave'],
    setTo: 'self',
    init: 10,
    to: 15,
    duration: 0.6
  };

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.element = element;
      this.$element = $(element);
      this.init();
    }

    init() {
      this;
      this.initEvents();
    }

    initEvents() {
      const {
        triggers
      } = this.options;
      this.$element.on(triggers[0], this.addZIndex.bind(this));
      this.$element.on(triggers[1], this.removeZIndex.bind(this));
    }

    addZIndex() {
      window.liquidParams.currentZIndex += 1;
      gsap.killTweensOf(this.element);
      gsap.set(this.element, {
        zIndex: window.liquidParams.currentZIndex
      });
    }

    removeZIndex() {
      const {
        duration
      } = this.options;
      gsap.to(this.element, {
        zIndex: this.options.init,
        delay: duration,
        ease: 'quint.out',
        duration: 0.15
      });
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('zindex-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('[data-lqd-zindex]').liquidZIndex();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidSectionScroll';
  let defaults = {
    scroller: '.lqd-section-scroll-sections',
    itemsSelector: ':scope > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-section, :scope > .e-container, :scope > .e-con'
  };

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.DOM = {};
      this.DOM.element = element;
      this.DOM.$element = $(element);
      this.DOM.scroller = this.DOM.element.querySelector(`:scope > ${this.options.scroller}`);
      this.DOM.items = [...this.DOM.element.querySelectorAll(this.options.itemsSelector)];
      if (!this.DOM.items || this.DOM.items.length <= 1) return;
      this.DOM.dots = [];
      this.isAnimating = false;
      this.activeItem = 0;
      this.totalItemsHeight = 0;
      this.elementRect = {};
      this.itemsRects = [];
      this.build().then(() => {
        this.appendDots();
        this.events();
      });
    }

    async build() {
      await this.createScroller();
      const rects = await Promise.all([this.getElementRect(), ...this.getItemsRects()]);
      const windowScrollY = window.scrollY;
      const elementRect = rects[0];
      const itemsRects = rects.filter((item, i) => i > 0);
      this.elementRect = {
        width: elementRect.width,
        height: elementRect.height,
        y: elementRect.y + windowScrollY,
        bottom: elementRect.bottom
      };
      itemsRects.forEach((rect, i_1) => {
        this.itemsRects[i_1] = {
          width: rect.width,
          height: rect.height,
          y: rect.y - this.elementRect.y,
          bottom: rect.bottom - this.elementRect.y
        };
        this.totalItemsHeight += rect.height;
      });
    }

    async createScroller() {
      if (this.DOM.scroller) return;
      await fastdomPromised.mutate(() => {
        $(this.DOM.items).wrapAll(`<div class="${this.options.scroller.substring(1)} lqd-overlay" />`);
        this.DOM.scroller = this.DOM.element.querySelector(this.options.scroller);
      });
    }

    getElementRect() {
      return new Promise(resolve => {
        new IntersectionObserver(([entry], observer) => {
          observer.disconnect();
          resolve(entry.boundingClientRect);
        }).observe(this.DOM.element);
      });
    }

    getItemsRects() {
      const promises = [];
      this.DOM.items.forEach(el => {
        const promise = new Promise(resolve => {
          new IntersectionObserver(([entry], observer) => {
            observer.disconnect();
            resolve(entry.boundingClientRect);
          }).observe(el);
        });
        promises.push(promise);
      });
      return promises;
    }

    events() {
      const transitionDuration = 1000;
      let wheelFree = true;
      let isScrollingDown = false;
      let isScrollingUp = false;
      this.DOM.$element.on('wheel mousewheel', event => {
        const {
          deltaY
        } = event.originalEvent;

        if (deltaY < 0) {
          isScrollingUp = true;
          isScrollingDown = false;
        } else if (deltaY > 0) {
          isScrollingUp = false;
          isScrollingDown = true;
        }

        if (this.activeItem === 0 && isScrollingDown || this.activeItem === this.DOM.items.length - 1 && isScrollingUp) {
          $('html, body').animate({
            scrollTop: this.DOM.$element.offset().top - (window.innerHeight - this.DOM.element.offsetHeight) / 2
          }, 350);
        }

        if (!this.isAnimating) {
          if (isScrollingUp && this.activeItem > 0) {
            wheelFree = false;
            this.navigate('prev');
          } else if (isScrollingDown && this.activeItem !== this.DOM.items.length - 1) {
            wheelFree = false;
            this.navigate('next');
          }
        }

        if (!wheelFree || this.isAnimating) {
          event.preventDefault();
          return false;
        }

        ;
      });
      this.DOM.scroller.addEventListener('transitionend', event => {
        if (event.target === this.DOM.scroller) {
          wheelFree = true;
          this.isAnimating = false;
          this.navigateDone();
        }
      });
      this.DOM.element.addEventListener('mouseover', () => {
        if (this.activeItem === 0 && isScrollingDown || this.activeItem === this.DOM.items.length - 1 && isScrollingUp) {
          wheelFree = false;
        }
      });
      this.DOM.element.addEventListener('mouseout', () => {
        wheelFree = true;
      });
      this.DOM.dots.forEach(($dot, i) => {
        $dot.on('click', this.onDotsClick.bind(this, i));
      });
      $liquidWindow.on('resize', liquidDebounce(this.onWindowResize.bind(this), 250));
    }

    appendDots() {
      const $dotsWrapper = $('<div class="lqd-section-scroll-dots d-flex flex-column pos-abs z-index-5" />');
      this.itemsRects.forEach((rect, i) => {
        const $dot = $(`<div class="lqd-section-scroll-dot d-flex align-items-center justify-content-center border-radius-circle pos-rel text-center ${i === 0 ? 'is-active' : ''}"><span></span></div>`);
        $dotsWrapper.append($dot);
        this.DOM.dots.push($dot);
      });
      $dotsWrapper.appendTo(this.DOM.$element);
    }

    navigate(direction) {
      this.isAnimating = true;
      this.DOM.scroller.style.willChange = 'transform';

      switch (direction) {
        case 'prev':
          this.navigatePrev();
          break;

        default:
          this.navigateNext();
          break;
      }
    }

    navigateDone() {
      this.DOM.scroller.style.willChange = 'auto';
    }

    navigateNext() {
      if (this.activeItem < this.DOM.items.length - 1) {
        this.activeItem += 1;
      }

      this.moveScroller();
      this.manageDotsActiveState();
    }

    navigatePrev() {
      if (this.activeItem > 0) {
        this.activeItem -= 1;
      }

      this.moveScroller();
      this.manageDotsActiveState();
    }

    moveScroller() {
      this.DOM.scroller.style.transform = `translate3d(0, ${this.activeItem * 100 * -1}%, 0)`;
    }

    manageDotsActiveState() {
      this.DOM.dots.forEach($dot => $dot.removeClass('is-active'));
      this.DOM.dots[this.activeItem].addClass('is-active');
    }

    onDotsClick(i) {
      this.activeItem = i;
      this.moveScroller();
      this.manageDotsActiveState();
    }

    onWindowResize() {
      this.build();
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('section-scroll-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  if (liquidIsMobile()) return;
  $('[data-lqd-section-scroll=true]').not('.elementor-inner-section').liquidSectionScroll();
});
(function ($) {
  'use strict';

  const pageStacksEnabled = $liquidContents.attr('data-liquid-stack') != null;
  const bodyLSOffset = $liquidBody.attr('data-localscroll-offset');
  const localscrollGlobalOffset = bodyLSOffset != null && bodyLSOffset !== '' ? parseInt(bodyLSOffset, 10) : 0;
  const pluginName = 'liquidLocalScroll';
  let defaults = {
    itemsSelector: 'self',
    scrollSpeed: 600,
    scrollBelowSection: false,
    offsetElements: '#wpadminbar, .main-header[data-sticky-header] .lqd-head-sec-wrap:not(.lqd-hide-onstuck), body.elementor-page .main-header[data-sticky-header] > .elementor > .elementor-section:not(.lqd-hide-onstuck):not(.lqd-stickybar-wrap), .lqd-custom-menu[data-pin]:not(.lqd-sticky-menu-floating)',
    includeParentAsOffset: false,
    trackWindowScroll: false
  };

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.element = element;
      this.$element = $(element);
      this.$items = this.options.itemsSelector === 'self' ? this.$element : $(this.options.itemsSelector, this.$element);
      this.targetsArray = [];
      this.offset = [];
      this.targetsRects = [];
      this.windowHeight = fastdom.measure(liquidWindowHeight)();
      this.firstScroll = true;
      this.fakePercent = true;
      this.scrollTimer = null;
      this.lastScrollFireTime = 0;
      this.CurrentPositionTop = -1;
      this.lastItemPercent = -1;

      if (this.options.includeParentAsOffset && this.element.parentElement.classList.contains('lqd-sticky-menu-floating')) {
        this.options.includeParentAsOffset = false;
      }

      if (!pageStacksEnabled) {
        $liquidContents.imagesLoaded(async () => {
          this.$items.each((i, item) => {
            this.getTargetsArray(i, item);
          });

          if (this.options.trackWindowScroll) {
            this.offset = await this.getOffsets();
          }

          this.targetsRects = await this.getTargetsRects();
          this.init();
        });
      } else {
        this.init();
      }
    }

    async getTargetsRects() {
      const promises = [];
      this.targetsArray.forEach(target => {
        const promise = new Promise(resolve => {
          if (target == null) {
            return resolve(null);
          }

          new IntersectionObserver(([entry], observer) => {
            const {
              boundingClientRect
            } = entry;
            const {
              scrollY
            } = window;
            const rect = {
              y: boundingClientRect.y + scrollY,
              bottom: boundingClientRect.bottom + scrollY,
              height: boundingClientRect.height,
              el: entry.target
            };
            resolve(rect);
            observer.disconnect();
          }).observe(target);
        });
        promises.push(promise);
      });
      const rects = await Promise.all(promises);
      return [...rects];
    }

    async getOffsets() {
      const {
        offsetElements,
        includeParentAsOffset
      } = this.options;
      let offset = localscrollGlobalOffset;

      if (!offsetElements) {
        return offset;
      }

      const $elements = !includeParentAsOffset ? $(offsetElements) : $(offsetElements).add(this.$element.parent());
      const promises = [];
      $elements.each((i, element) => {
        const promise = new Promise(resolve => {
          new IntersectionObserver(([entry], observer) => {
            observer.disconnect();
            resolve(entry.boundingClientRect.height);
          }).observe(element);
        });
        promises.push(promise);
      });
      const heights = await Promise.all(promises);
      heights.forEach(height => offset += height);
      return offset;
    }

    getTargetsArray(itemIndex, item) {
      if (this.options.scrollBelowSection) {
        const $parentRow = this.$element.parents('.elementor-section, .e-container, .e-con').last();
        const $nextRow = $parentRow.nextAll('.elementor-section, .e-container, .e-con').first();
        return this.targetsArray[itemIndex] = $nextRow[0];
      }

      const itemHref = item.getAttribute('href');

      if (!itemHref) {
        return this.targetsArray[itemIndex] = null;
      }

      const {
        hash
      } = item;

      if (!hash || hash == '' || !$(hash).length) {
        return this.targetsArray[itemIndex] = null;
      }

      this.targetsArray[itemIndex] = document.querySelector(hash);
    }

    init() {
      this.$items.each((i, item) => {
        this.events(i, item);
      });

      if (this.options.trackWindowScroll && !pageStacksEnabled) {
        this.onScroll();
        $liquidWindow.on('scroll', this.onScroll.bind(this));
      }
    }

    events(itemIndex, item) {
      $(item).on('click', {
        itemIndex
      }, this.onClick.bind(this));
      $(document).on('lqd-masonry-layout-init', async () => {
        this.targetsRects = await this.getTargetsRects();
      });
    }

    onClick(event) {
      const {
        itemIndex
      } = event.data;
      if (!this.targetsRects[itemIndex]) return;
      const $link = $(event.currentTarget);
      const href = $link.attr('href');
      const y = $(href).offset().top;
      event.preventDefault();
      event.stopPropagation();
      $liquidHtml.removeClass('overflow-hidden');
      $('html, body').animate({
        scrollTop: y - this.offset
      }, this.options.scrollSpeed);
      this.$element.closest('.navbar-fullscreen').collapse('hide');
      this.$element.closest('.navbar-collapse').collapse('hide');
      this.$element.closest('.ld-module-dropdown').collapse('hide');
    }

    onScroll() {
      let minScrollTime = 200;
      let now = new Date().getTime();

      const processScroll = () => {
        let ScrollPos = this.getScrollPos();
        let StagesPositionPercentage = [];
        let currentElement;
        this.targetsRects.forEach(rect => {
          if (!rect) return;
          let Percent = [rect.y, this.getVisibilityPercent(rect, ScrollPos)];

          if (Percent[1] !== 0) {
            StagesPositionPercentage.push(Percent);
          }
        });

        if (StagesPositionPercentage.length === 0) {
          StagesPositionPercentage[0] = [0, 0];
          StagesPositionPercentage[1] = [0, 0];
          this.fakePercent = true;
        } else {
          this.fakePercent = false;
        }

        if (StagesPositionPercentage.length === 1) {
          StagesPositionPercentage[1] = [0, 0];
        }

        let max = StagesPositionPercentage.reduce((a, b) => {
          return Math.max(a[1], b[1]);
        });

        if (isNaN(max)) {
          let TempStagesPositionPercentage = [];
          StagesPositionPercentage.forEach(objectPositionPercentage => {
            this.targetsRects.forEach(rect => {
              if (!rect) return;

              if (rect.y === objectPositionPercentage[0]) {
                let DistanceFromCenter = [rect.y, this.getVisibilityDistanceFromCenter(rect, ScrollPos)];

                if (!TempStagesPositionPercentage.includes(DistanceFromCenter)) {
                  TempStagesPositionPercentage.push(DistanceFromCenter);
                }
              }
            });
          });
          TempStagesPositionPercentage.reduce((a, b) => {
            if (typeof a !== 'undefined' && typeof b != "undefined") {
              max = Math.min(a[1], b[1]);
            }
          });
          StagesPositionPercentage = TempStagesPositionPercentage;
        }

        if (max !== this.lastItemPercent) {
          this.lastItemPercent = max;
          StagesPositionPercentage.forEach(objectPositionPercentage => {
            if (this.firstScroll && !this.fakePercent) {
              objectPositionPercentage[1] = max;
              this.firstScroll = false;
              this.CurrentPositionTop = 0;
              this.lastItemPercent = 0;
            }

            if (objectPositionPercentage[1] === max && objectPositionPercentage[0] !== this.CurrentPositionTop && !this.fakePercent) {
              this.CurrentPositionTop = objectPositionPercentage[0];
              this.$items.parent().removeClass('is-active');
              this.targetsRects.forEach((rect, i) => {
                if (!rect) return;

                if (rect.y === objectPositionPercentage[0]) {
                  currentElement = rect.el;
                  this.$items.eq(i).parent().addClass('is-active');
                }
              });
            }
          });
        }
      };

      if (!this.scrollTimer) {
        if (now - this.lastScrollFireTime > 3 * minScrollTime) {
          processScroll();
          this.lastScrollFireTime = now;
        }

        this.scrollTimer = setTimeout(() => {
          this.scrollTimer = null;
          this.lastScrollFireTime = new Date().getTime();
          processScroll();
        }, minScrollTime);
      } else {
        processScroll();
      }
    }

    checkIsInView(element, ScrollPos = this.getScrollPos()) {
      return element.offsetTop > ScrollPos[0] && element.offsetTop < ScrollPos[1] || element.offsetTop + element.offsetHeight > ScrollPos[0] && element.offsetTop + element.offsetHeight < ScrollPos[1] || element.offsetTop < ScrollPos[0] && element.offsetTop + element.offsetHeight > ScrollPos[1];
    }

    getScrollPos() {
      let offsetTop;
      let offsetBottom;
      offsetTop = window.scrollY || 0;
      offsetBottom = offsetTop + this.windowHeight;
      return [offsetTop, offsetBottom];
    }

    getVisibilityPercent(targetRect, ScrollPos = this.getScrollPos()) {
      if (!this.checkIsInView(targetRect.el, ScrollPos)) return 0;
      let pageTop = ScrollPos[0];
      let pageBottom = ScrollPos[1];
      let visiblePixle = 0;

      if (targetRect.y >= pageTop && targetRect.bottom <= pageBottom) {
        visiblePixle = targetRect.height;
      }

      if (targetRect.y < pageTop && targetRect.bottom <= pageBottom) {
        visiblePixle = targetRect.bottom - pageTop;
      }

      if (targetRect.y >= pageTop && targetRect.bottom > pageBottom) {
        visiblePixle = pageBottom - targetRect.y;
      }

      if (targetRect.y < pageTop && targetRect.bottom > pageBottom) {
        visiblePixle = pageBottom - pageTop;
      }

      return Math.round(visiblePixle / this.windowHeight * 100);
    }

    getVisibilityDistanceFromCenter(targetRect, ScrollPos = this.getScrollPos()) {
      if (!this.checkIsInView(targetRect.el, ScrollPos)) return 0;
      let pageTop = ScrollPos[0];
      let pageCenter = pageTop + this.windowHeight / 2;
      let distFromCenter = 0;

      if (targetRect.y < pageCenter && targetRect.bottom < pageCenter) {
        distFromCenter = pageCenter - targetRect.bottom;
      }

      if (targetRect.y >= pageCenter && targetRect.bottom > pageCenter) {
        distFromCenter = targetRect.bottom - pageCenter;
      }

      if (targetRect.y <= pageCenter && targetRect.bottom >= pageCenter) {
        distFromCenter = 0;
      }

      return distFromCenter;
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('localscroll-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $(window).on('elementor/frontend/init', () => {
    if (typeof elementorFrontend === 'undefined') {
      return;
    }

    elementorFrontend.on('components:init', () => {
      elementorFrontend.utils.anchors.setSettings('selectors.targets', '.to-the-hell');
    });
  });
  $('[data-localscroll]').liquidLocalScroll();
  $('.lqd-mobile-sec-nav .main-nav').liquidLocalScroll({
    itemsSelector: '> li > a'
  });
});
(function ($) {
  'use strict';

  const pluginName = 'liquidSplitText';
  let defaults = {
    type: "words",
    forceApply: false
  };

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.splittedTextList = {
        lines: [],
        words: [],
        chars: []
      };
      this.splitTextInstance = null;
      this.isRTL = $('html').attr('dir') === 'rtl';
      this.element = element;
      this.$element = $(element);
      this.fontInfo = {};
      this.splitDonePormise = new Promise(resolve => {
        this.$element.on('lqdsplittext', resolve.bind(this, this));
      });

      if (!this.options.forceApply) {
        new IntersectionObserver(([entry], observer) => {
          if (entry.isIntersecting) {
            observer.disconnect();
            this.init();
          }
        }, {
          rootMargin: '20%'
        }).observe(this.element);
      } else {
        this.init();
      }
    }

    async init() {
      await this._measure();
      await this._onFontsLoad();

      this._windowResize();
    }

    _measure() {
      return fastdomPromised.measure(() => {
        const styles = getComputedStyle(this.element);
        this.fontInfo.elementFontFamily = styles.fontFamily.replace(/"/g, '').replace(/'/g, '').split(',')[0];
        this.fontInfo.elementFontWeight = styles.fontWeight;
        this.fontInfo.elementFontStyle = styles.fontStyle;
        this.fontInfo.lowecaseFontFamily = this.fontInfo.elementFontFamily.toLowerCase();
      });
    }

    async _onFontsLoad() {
      const font = new FontFaceObserver(this.fontInfo.elementFontFamily, {
        weight: this.fontInfo.elementFontWeight,
        style: this.fontInfo.elementFontStyle
      });
      await font.load().finally(async () => {
        await this._doSplit();
      });
    }

    getSplitTypeArray() {
      const {
        type
      } = this.options;
      const splitTypeArray = type.split(',').map(item => item.replace(' ', ''));

      if (!this.isRTL) {
        return splitTypeArray;
      } else {
        return splitTypeArray.filter(type => type !== 'chars');
      }
    }

    async _doSplit() {
      await this._split();
      await this._unitsOp();
      await this._onSplittingDone();
    }

    _split() {
      const splitType = this.getSplitTypeArray();
      const fancyHeadingInner = this.element.classList.contains('ld-fh-txt') && this.element.querySelector('.ld-fh-txt-inner') != null;
      const el = fancyHeadingInner ? this.element.querySelector('.ld-fh-txt-inner') : this.element;
      let splittedText;
      return fastdomPromised.mutate(() => {
        splittedText = new SplitText(el, {
          type: splitType,
          charsClass: 'split-unit lqd-chars',
          linesClass: 'split-unit lqd-lines',
          wordsClass: 'split-unit lqd-words'
        });
        splitType.forEach(type => {
          splittedText[type].forEach(element => {
            this.splittedTextList[type].push(element);
          });
        });
        this.element.classList.add('split-text-applied');
        this.splitTextInstance = splittedText;
      });
    }

    _unitsOp() {
      return fastdomPromised.mutate(() => {
        for (const [splitType, splittedTextArray] of Object.entries(this.splittedTextList)) {
          if (splittedTextArray && splittedTextArray.length > 0) {
            splittedTextArray.forEach((splitElement, i) => {
              splitElement.style.setProperty(`--${splitType}-index`, i);
              splitElement.style.setProperty(`--${splitType}-last-index`, splittedTextArray.length - 1 - i);
              $(splitElement).wrapInner(`<span class="split-inner" />`);
            });
          }

          ;
        }

        ;
      });
    }

    _onSplittingDone() {
      return fastdomPromised.mutate(() => {
        this.element.dispatchEvent(new CustomEvent('lqdsplittext'));
      });
    }

    _windowResize() {
      $(window).on('resize.lqdSplitText', this._onWindowResize.bind(this));
    }

    _onWindowResize() {
      if (this.splitTextInstance) {
        this.splitTextInstance.revert();
        this.element.classList.remove('split-text-applied');
      }

      this._onAfterWindowResize();
    }

    async _onAfterWindowResize() {
      await this._doSplit();
      await this._onSplittingDone();
      this.$element.find('.split-unit').addClass('lqd-unit-animation-done');
    }

    destroy() {
      $(window).off('resize.lqdSplitText');
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('split-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  const $elements = $('[data-split-text]').filter((i, el) => {
    const $el = $(el);
    const isCustomAnimation = el.hasAttribute('data-custom-animations');
    const hasCustomAnimationParent = $el.closest('[data-custom-animations]').length;
    const hasAccordionParent = $el.closest('.accordion-content').length;
    const hasTabParent = $el.closest('.lqd-tabs-pane').length;
    const webglSlideshowParent = $el.closest('[data-lqd-webgl-slideshow]').length;
    return !isCustomAnimation && !hasCustomAnimationParent && !hasAccordionParent && !hasTabParent && !webglSlideshowParent;
  });
  $elements.liquidSplitText();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidCustomAnimations';
  let defaults = {
    delay: 160,
    startDelay: 0,
    direction: 'forward',
    duration: 1600,
    ease: 'power4.out',
    animationTarget: 'this',
    addPerspective: true,
    perspectiveVal: 1400,
    addChildTimelines: false,
    initValues: {
      x: 0,
      y: 0,
      z: 0,
      rotationX: 0,
      rotationY: 0,
      rotationZ: 0,
      scaleX: 1,
      scaleY: 1,
      skewX: 0,
      skewY: 0,
      opacity: 1,
      transformOriginX: 50,
      transformOriginY: 50,
      transformOriginZ: '0px'
    },
    animations: {
      transformOriginX: 50,
      transformOriginY: 50,
      transformOriginZ: '0px'
    },
    randomizeInitValues: false,
    randomizeTargets: false,
    clearProps: 'transform,opacity,transform-origin'
  };

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.options.duration = this.options.duration / 1000;
      this.options.offDuration = this.options.offDuration / 1000;
      this.options.offDelay = this.options.offDelay / 1000;
      this.options.delay = this.options.delay / 1000;
      this.options.startDelay = this.options.startDelay / 1000;
      this.element = element;
      this.$element = $(element);
      this.animationTargets = [];
      this.animationsTimeline = null;
      this.shouldPause = false;
      this.animationsStarted = false;
      this.needPerspective = this.options.addPerspective && this._needPerspective();
      const $parentCustomAnimation = this.$element.parents('[data-custom-animations]');

      if ($parentCustomAnimation.length && $parentCustomAnimation.attr('data-ca-options') != null) {
        const parentCaOpts = JSON.parse($parentCustomAnimation.attr('data-ca-options'));

        if (parentCaOpts.addChildTimelines) {
          this.shouldPause = true;
        }
      }

      this.animationsInitiatedPromise = new Promise(resolve => {
        this.$element.on('lqdanimationsinitiated', resolve.bind(this, this));
      });
      this.animationsDonePromise = new Promise(resolve => {
        this.$element.on('lqdanimationsdone', resolve.bind(this, this));
      });
      new IntersectionObserver(([entry], observer) => {
        if (entry.isIntersecting) {
          observer.disconnect();

          this._build();
        }
      }, {
        rootMargin: '8%'
      }).observe(this.element);
    }

    async _build() {
      const promises = [];

      if (!this.element.classList.contains('elementor-section') && !this.element.classList.contains('e-container') && !this.element.classList.contains('e-con')) {
        const $splitTextEls = this.$element.find('[data-split-text]');

        if (this.element.hasAttribute('data-split-text')) {
          $splitTextEls.push(this.element);
        }

        if ($splitTextEls.length) {
          $splitTextEls.each((i, el) => {
            const $el = $(el);
            $el.liquidSplitText({
              forceApply: true
            });
            const prom = $el.data('plugin_liquidSplitText');
            prom && promises.push(prom.splitDonePormise);
          });
        }
      }

      if (promises.length > 0) {
        Promise.all(promises).then(() => {
          this._init();
        });
      } else {
        this._init();
      }
    }

    _init() {
      this._getAnimationTargets();

      this._createTimeline();

      this._initValues();

      this._runAnimations();

      this._initPlugins();
    }

    _getAnimationTargets() {
      const {
        direction,
        animationTarget
      } = this.options;
      let targets = null;

      switch (animationTarget) {
        case 'this':
          targets = this.element;
          break;

        case 'all-childs':
          targets = this._getChildElments();
          break;

        default:
          targets = this.element.querySelectorAll(animationTarget);
          break;
      }

      this.animationTargets = Array.from(targets);

      if (direction === 'backward') {
        this.animationTargets = this.animationTargets.reverse();
      } else if (direction === 'random') {
        this.animationTargets = gsap.utils.shuffle(this.animationTargets);
      }
    }

    _getChildElments() {
      let $childs = this.$element.children();
      return this._getInnerChildElements($childs);
    }

    _getInnerChildElements(elements) {
      const elementsArray = [];
      let $elements = $(elements).map((i, element) => {
        const $element = $(element);

        if ($element.hasClass('ld-slideelement-visible') || $element.hasClass('ld-slideelement-hidden')) {
          return $element.children().children().get();
        } else if ($element.hasClass('elementor-container')) {
          return $element.children('.elementor-column').get();
        } else if ($element.hasClass('elementor-widget-wrap')) {
          return $element.children('.elementor-element').get();
        } else {
          return $element.not('style, .lqd-exclude-parent-ca').get();
        }
      });
      $.each($elements, (i, element) => {
        const $element = $(element);

        if (element.hasAttribute('data-custom-animations')) {
          return elementsArray.push(element);
        }

        if (element.querySelector('[data-custom-animations]')) {
          return element.querySelectorAll('[data-custom-animations]').forEach(el => {
            elementsArray.push(el);
          });
        }

        if (element.tagName === 'UL') {
          return $.each($element.children(), (i, li) => {
            elementsArray.push(li);
          });
        }

        if (element.classList.contains('lqd-custom-menu')) {
          return $.each($element.find('> ul > li'), (i, li) => {
            elementsArray.push(li);
          });
        }

        if (element.classList.contains('accordion')) {
          return $.each($element.children(), (i, accordionItem) => {
            elementsArray.push(accordionItem);
          });
        }

        if (element.classList.contains('lqd-pb-container')) {
          return $.each($element.find('.lqd-pb'), (i, processBoxElement) => {
            elementsArray.push(processBoxElement);
          });
        }

        if ($element.find('[data-split-text]').length || element.hasAttribute('data-split-text')) {
          if (element.classList.contains('btn')) {
            return elementsArray.push($element[0]);
          } else {
            return $.each($element.find('.split-inner'), (i, splitInner) => {
              const $innerSplitInner = $(splitInner).find('.split-inner');

              if ($innerSplitInner.length) {
                elementsArray.push($innerSplitInner[0]);
              } else {
                elementsArray.push(splitInner);
              }
            });
          }
        }

        if (!element.classList.contains('ld-particles-container') && !element.classList.contains('elementor-widget-spacer') && !element.hasAttribute('data-split-text') && element.tagName !== 'STYLE') {
          return elementsArray.push($element[0]);
        }
      });
      return elementsArray;
    }

    _needPerspective() {
      const initValues = this.options.initValues;
      const valuesNeedPerspective = ["z", "rotationX", "rotationY"];
      let needPerspective = false;

      for (let prop in initValues) {
        for (let i = 0; i <= valuesNeedPerspective.length - 1; i++) {
          const val = valuesNeedPerspective[i];

          if (prop === val) {
            needPerspective = true;
            break;
          }
        }
      }

      return needPerspective;
    }

    _generateRandomValues(valuesObject) {
      const obj = { ...valuesObject
      };

      for (const ky in valuesObject) {
        if (ky.search('transformOrigin') < 0 && ky.search('opacity') < 0) {
          obj[ky] = () => gsap.utils.random(0, valuesObject[ky]);
        }

        ;
      }

      return obj;
    }

    _createTimeline() {
      const {
        ease,
        duration,
        clearProps
      } = this.options;
      this.animationsTimeline = gsap.timeline({
        paused: this.shouldPause,
        defaults: {
          duration,
          ease,
          clearProps
        },
        onComplete: this._onTimelineAnimationComplete.bind(this)
      });
    }

    async _getChildTimelines() {
      const promises = [];
      this.animationTargets.forEach((el, i) => {
        const $el = $(el);
        let $caEl = $el;

        if ($el.hasClass('elementor-widget-container')) {
          $caEl = $el.parent();
        }

        const customAnimData = $caEl.data(`plugin_${pluginName}`);

        if (customAnimData && customAnimData.animationsInitiatedPromise) {
          promises[i] = customAnimData.animationsInitiatedPromise;
        }
      });

      if (promises.length > 0) {
        const childrenCustomAnimData = await Promise.all(promises);
        childrenCustomAnimData.forEach((childCaData, i) => {
          if (childCaData && childCaData.animationsTimeline) {
            this.animationTargets.splice(i + 1, 0, childCaData.animationsTimeline);
          }
        });
      }
    }

    _initValues() {
      const {
        options
      } = this;
      const {
        randomizeInitValues,
        initValues
      } = options;
      const $animationTargets = $(this.animationTargets);
      const initProps = !randomizeInitValues ? initValues : this._generateRandomValues(initValues);
      $animationTargets.css({
        transition: 'none',
        transitionDelay: 0
      }).addClass('will-change');

      if (this.needPerspective) {
        $animationTargets.parent().parent().addClass('perspective');
        $animationTargets.each((i, animTarget) => {
          const $animTarget = $(animTarget);

          if (!$animTarget.hasClass('lqd-imggrp-single')) {
            $animTarget.parent().addClass('transform-style-3d');
          }
        });
      }

      gsap.set(this.animationTargets, { ...initProps
      });
      this.element.classList.add('ca-initvalues-applied');
      this.$element.trigger('lqdanimationsinitiated', this);
    }

    async _runAnimations() {
      const {
        delay,
        startDelay,
        animations,
        addChildTimelines
      } = this.options;

      if (addChildTimelines) {
        await this._getChildTimelines();
      }

      this.animationTargets.forEach((target, i) => {
        if (!target.vars) {
          this.animationsTimeline.to(target, { ...animations,
            onStart: () => {
              this.animationsStarted = true;
            },
            onComplete: this._onUnitsAnimationsComplete.bind(this, target)
          }, i * delay + startDelay);
        } else {
          target.restart(true);
          this.animationsTimeline.add(target, '<');
        }
      });
    }

    _onTimelineAnimationComplete() {
      if (this.needPerspective) {
        $(this.animationTargets).parent().parent().removeClass('perspective');
        $(this.animationTargets).parent().removeClass('transform-style-3d');
      }

      this.$element.addClass('lqd-animations-done');
      this.$element.trigger('lqdanimationsdone', this);
    }

    _onUnitsAnimationsComplete(element) {
      if (!element) return;
      element.style.transition = '';
      element.style.transitionDelay = '';
      element.classList.remove('will-change');

      if (element.classList.contains('split-inner')) {
        element.parentElement.classList.add('lqd-unit-animation-done');
      } else {
        element.classList.add('lqd-unit-animation-done');
      }
    }

    _initPlugins() {
      this.$element.find('[data-slideelement-onhover]').filter((i, element) => {
        return element.clientHeight > 0;
      }).liquidSlideElement();
      this.element.hasAttribute('data-slideelement-onhover') && this.$element.liquidSlideElement();
    }

    destroy() {
      this.element.classList.remove('ca-initvalues-applied', 'lqd-animations-done', 'transform-style-3d');
      this.animationTargets.forEach(target => {
        if (!target.vars) {
          target.classList.remove('will-change');

          if (target.classList.contains('split-inner')) {
            target.parentElement.classList.remove('lqd-unit-animation-done');
          } else {
            target.classList.remove('lqd-unit-animation-done');
          }

          gsap.set(target, {
            clearProps: 'all'
          });
        } else {
          this.animationsTimeline.killTweensOf(target);
        }
      });

      if (this.animationsTimeline) {
        this.animationsTimeline.kill();
        this.animationsTimeline.clear();
      }

      $.data(this.element, 'plugin_' + pluginName, null);
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const $this = $(this);
      const plugin = `plugin_${pluginName}`;
      const pluginOptions = { ...$this.data('ca-options'),
        ...options
      };
      let {
        initValues,
        animations
      } = pluginOptions;

      function handleTransformOrigins(opts) {
        if (!opts) return;
        const {
          transformOriginX,
          transformOriginY,
          transformOriginZ
        } = opts;

        if (transformOriginX && typeof transformOriginX === 'number') {
          opts.transformOriginX = transformOriginX + '%';
        }

        if (transformOriginY && typeof transformOriginY === 'number') {
          opts.transformOriginY = transformOriginY + '%';
        }

        if (transformOriginZ && typeof transformOriginZ === 'number') {
          opts.transformOriginZ = transformOriginZ + '%';
        }

        if (transformOriginX && transformOriginY && transformOriginZ) {
          opts.transformOrigin = `${opts.transformOriginX} ${opts.transformOriginY} ${opts.transformOriginZ}`;
          delete opts.transformOriginX;
          delete opts.transformOriginY;
          delete opts.transformOriginZ;
        }

        return opts;
      }

      initValues = handleTransformOrigins(initValues);
      animations = handleTransformOrigins(animations);

      if (!$.data(this, plugin)) {
        $.data(this, `plugin_${pluginName}`, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  const anims = $('[data-custom-animations]').filter((i, element) => {
    const $element = $(element);
    const stackOptions = $liquidContents.length && $liquidContents[0].getAttribute('data-stack-options');
    const stackDisableOnMobile = stackOptions && JSON.parse(stackOptions).disableOnMobile === true;
    return (!stackOptions || stackOptions && stackDisableOnMobile && liquidIsMobile()) && !$element.hasClass('carousel-items');
  }).get().reverse();

  if (anims.length < 1) {
    return;
  }

  ;

  if (liquidIsMobile() && document.body.hasAttribute('data-disable-animations-onmobile')) {
    return $(anims).addClass('ca-initvalues-applied');
  }

  ;

  if ($liquidBody.hasClass('lqd-preloader-activated') && $('.lqd-preloader-wrap').length) {
    document.addEventListener('lqd-preloader-anim-done', () => {
      $(anims).liquidCustomAnimations();
    });
  } else {
    $(anims).liquidCustomAnimations();
  }
});
(function ($) {
  'use strict';

  const pluginName = 'liquidTextRotator';
  let defaults = {
    delay: 2,
    duration: 0.8,
    easing: 'power4.inOut',
    animationType: 'slide'
  };

  class Plugin {
    constructor(element, options) {
      this.element = element;
      this.$element = $(element);
      this.options = $.extend({}, defaults, options);
      this._defaults = defaults;
      this._name = pluginName;
      this.activeKeywordIndex = 0;
      this.nextKeywordIndex = 1;
      this.isFirstItterate = true;
      this.basicAnimationTimeline = null;
      this.basicAnimationsResetTimeout = null;
      this.$keywordsContainer = null;
      this.$keywords = null;
      this.keywordsLength = 0;
      this.keywordsWidths = [];
      this.slideInTimeout = null;
      this.slideOutTimeout = null;
      this.build();
    }

    build() {
      const promises = [];
      const $customAnimationParent = this.$element.closest('[data-custom-animations]');
      const $customAnimationChild = this.$element.children('[data-custom-animations]');
      const $splitTextChild = this.$element.children('[data-split-text]');

      if (this.element.hasAttribute('data-split-text')) {
        const data = this.$element.data('plugin_liquidSplitText');
        data && promises.push(data.splitDonePormise);
      }

      if ($splitTextChild.length) {
        const data = $splitTextChild.data('plugin_liquidSplitText');
        data && promises.push(data.splitDonePormise);
      }

      if ($customAnimationParent.length) {
        const data = $customAnimationParent.data('plugin_liquidCustomAnimations');
        data && promises.push(data.animationsDonePromise);
      }

      if ($customAnimationChild.length) {
        const data = $customAnimationChild.data('plugin_liquidCustomAnimations');
        data && promises.push(data.animationsDonePromise);
      }

      if (this.element.hasAttribute('data-custom-animations')) {
        const data = this.$element.data('plugin_liquidCustomAnimations');
        data && promises.push(data.animationsDonePromise);
      }

      if (promises.length) {
        Promise.all(promises).finally(() => {
          this.init();
        });
      } else {
        this.init();
      }
    }

    async init() {
      this._handleWindowResize = liquidDebounce(this._handleWindowResize.bind(this), 350);
      this.$keywordsContainer = $('.txt-rotate-keywords', this.element);

      if (!this.$keywordsContainer.length) {
        return console.warn('Could not find keywords container');
      }

      ;
      this.$keywords = $('.txt-rotate-keyword', this.$keywordsContainer);
      this.$keywords.attr('class', 'txt-rotate-keyword').eq(0).addClass('active');
      this.keywordsLength = this.$keywords.length - 1;
      this.keywordsWidths = await this.getKeywordsWidths();
      this.setContainerWidth(0);
      this.initAnimations();

      this._windowResize();

      this.$element.addClass('text-rotator-activated');
    }

    async getKeywordsWidths() {
      const promises = [];
      this.$keywords.each((i, keyword) => {
        const promise = new Promise(resolve => {
          new IntersectionObserver(([entry], observer) => {
            observer.disconnect();
            const {
              boundingClientRect
            } = entry;
            resolve(boundingClientRect.width);
          }).observe(keyword);
        });
        promises.push(promise);
      });
      const widths = await Promise.all(promises);
      return widths;
    }

    updateActiveIndex() {
      this.activeKeywordIndex = this.activeKeywordIndex + 1 > this.keywordsLength ? 0 : this.activeKeywordIndex + 1;
    }

    updateNextIndex() {
      this.nextKeywordIndex = this.nextKeywordIndex + 1 > this.keywordsLength ? 0 : this.nextKeywordIndex + 1;
    }

    setActiveClass() {
      this.$keywords.removeClass('active');
      this.$keywords.eq(this.activeKeywordIndex).addClass('active');
    }

    setNextClass() {
      this.$keywords.removeClass('is-next');
      this.$keywords.eq(this.nextKeywordIndex).addClass('is-next');
    }

    setContainerWidth(index) {
      const keywordContainer = this.$keywordsContainer[0];
      keywordContainer.style.width = `${this.keywordsWidths[index]}px`;
    }

    slideInNextKeyword() {
      const $nextKeyword = this.$keywords.eq(this.nextKeywordIndex);
      const delay = this.isFirstItterate ? this.options.delay / 2 : this.options.delay;
      this.slideInTimeout = setTimeout(() => {
        this.setContainerWidth(this.nextKeywordIndex);
        $nextKeyword.removeClass('lqd-keyword-slide-out').addClass('lqd-keyword-slide-in');
        this.isFirstItterate = false;
        this.updateNextIndex();
        this.setNextClass();
        this.slideOutAciveKeyword();
        clearTimeout(this.slideInTimeout);
      }, delay * 1000);
    }

    slideOutAciveKeyword() {
      const $activeKeyword = this.$keywords.eq(this.activeKeywordIndex);
      const delay = this.isFirstItterate ? this.options.delay / 2 : this.options.delay;
      $activeKeyword.removeClass('lqd-keyword-slide-in').addClass('lqd-keyword-slide-out');
      this.updateActiveIndex();
      this.setActiveClass();
      this.slideOutTimeout = setTimeout(() => {
        this.slideInNextKeyword();
        clearTimeout(this.slideOutTimeout);
      }, delay * 1000);
    }

    buildBaiscAnimation() {
      this.$element.addClass('txt-rotator-basic');
      this.basicAnimationTimeline = gsap.timeline({
        easing: 'power2.inOut',
        onStart: () => {
          this.isFirstItterate = false;

          if (this.basicAnimationsResetTimeout) {
            clearTimeout(this.basicAnimationsResetTimeout);
          }

          this.setContainerWidth(this.nextKeywordIndex);
        },
        onComplete: () => {
          this.updateActiveIndex();
          this.updateNextIndex();
          this.setActiveClass();
          this.setNextClass();
          this.basicAnimationsResetTimeout = setTimeout(() => this.basicAnimationTimeline && this.basicAnimationTimeline.restart(), this.options.delay * 1000);
        }
      });
      this.$keywords.each((i, keyword) => {
        this.basicAnimationTimeline.to(keyword, {
          duration: 0.125,
          opacity: 1,
          onStart: () => {
            const $keyword = $(keyword);
            this.$keywords.not($keyword).removeClass('active');
            $keyword.addClass('active');
          }
        });
      });
    }

    initAnimations() {
      if (this.options.animationType === 'slide') {
        this.slideInNextKeyword();
      } else {
        this.buildBaiscAnimation();
      }
    }

    _windowResize() {
      $(window).on('resize.lqdTextRotator', this._handleWindowResize.bind(this));
    }

    _handleWindowResize() {
      gsap.killTweensOf(this.$keywordsContainer[0]);
      this.$keywords.each((i, keyword) => {
        gsap.killTweensOf(keyword);
      });
      this.destroy();

      this._onWindowResize();
    }

    _onWindowResize() {
      this.activeKeywordIndex = 0;
      this.nextKeywordIndex = 1;
      this.isFirstItterate = true;
      this.basicAnimationTimeline = null;
      this.basicAnimationsResetTimeout = null;
      this.slideInTimeout && clearTimeout(this.slideInTimeout);
      this.slideOutTimeout && clearTimeout(this.slideOutTimeout);
      this.build();
    }

    destroy() {
      $(window).off('resize.lqdTextRotator');
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('text-rotator-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('[data-text-rotator]').liquidTextRotator();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidParallax';
  let defaults = {
    offset: 0,
    start: "top bottom",
    end: 'bottom top',
    ease: 'linear',
    scrub: 0.55,
    scaleBG: true,
    overflowHidden: false,
    parallaxElement: null,
    staticSentinel: null,
    staticSentinelRel: null
  };
  let defaultParallaxFrom = {};
  let defaultParallaxTo = {};

  class Plugin {
    constructor(element, options, parallaxFrom, parallaxTo) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.element = element;
      this.$element = $(element);
      this.parallaxFromOptions = { ...defaultParallaxFrom,
        ...parallaxFrom
      };
      this.parallaxToOptions = { ...defaultParallaxTo,
        ...parallaxTo
      };
      this.ST = null;
      this.parallaxTimeline = null;
      this.parallaxElement = this.options.parallaxElement ? this.element.querySelectorAll(this.options.parallaxElement) : [this.element];
      this.rect = {};
      this.sentinel = null;
      this.willChangeProps = ['transform'];
      this.needsSentinel = this.element.classList.contains('e-container') || this.element.classList.contains('e-con') || this.element.classList.contains('elementor-section') || this.element.classList.contains('elementor-column') || this.element.closest('.lqd-css-sticky') || this.$element.parents('[data-parallax]').length || this.options.forceAddSentinel || this.options.staticSentinel && this.options.staticSentinelRel;

      if (this.parallaxFromOptions.opacity !== this.parallaxToOptions.opacity) {
        this.willChangeProps.push('opacity');
      }

      this.build();
    }

    async build() {
      const {
        staticSentinel,
        staticSentinelRel
      } = this.options;

      if (this.needsSentinel) {
        if (staticSentinel && staticSentinelRel) {
          this.sentinel = this.$element[staticSentinelRel](staticSentinel)[0];
        } else {
          await this.handleSentinel();
        }
      } else {
        this.sentinel = this.element;
      }

      this.init();
    }

    measure() {
      return fastdomPromised.measure(() => {
        const rect = this.element.getBoundingClientRect();
        this.rect.width = rect.width;
        this.rect.height = rect.height;
        this.rect.top = rect.top + window.scrollY;
        this.rect.left = rect.left + window.scrollX;
      });
    }

    async handleSentinel() {
      this.onWindowResize = liquidDebounce(this.onWindowResize, 500);
      await this.createSentinel();
      this.handleResize();
    }

    createSentinel() {
      return fastdomPromised.mutate(() => {
        this.sentinel = document.createElement('div');
        this.sentinel.setAttribute('class', 'lqd-parallax-sentinel pointer-events-none pos-abs z-index--1 invisible');
        document.body.appendChild(this.sentinel);
      });
    }

    positionSentinel() {
      return fastdomPromised.mutate(() => {
        this.sentinel.style.width = `${this.rect.width}px`;
        this.sentinel.style.height = `${this.rect.height}px`;
        this.sentinel.style.top = `${this.rect.top}px`;
        this.sentinel.style.left = `${this.rect.left}px`;
      });
    }

    async init() {
      await fastdomPromised.measure(async () => {
        await this.measure();
        this.needsSentinel && !this.options.staticSentinel && (await this.positionSentinel());
      });
      fastdomPromised.mutate(() => {
        let {
          start,
          end,
          scrub,
          ease
        } = this.options;
        this.parallaxTimeline = gsap.timeline();
        this.parallaxTimeline.fromTo(this.parallaxElement, { ...this.parallaxFromOptions
        }, {
          ease,
          ...this.parallaxToOptions,
          onComplete: this.switchWillChange.bind(this, 'off'),
          onReverseComplete: this.switchWillChange.bind(this, 'off')
        });
        this.ST = ScrollTrigger.create({
          animation: this.parallaxTimeline,
          trigger: this.sentinel,
          start: () => start,
          end: () => end,
          scrub,
          onRefresh: () => {
            start = this.options.start;
            end = this.options.end;
            this.ST.update();
          },
          onUpdate: this.switchWillChange.bind(this, 'on')
        });
        this.element.dispatchEvent(new CustomEvent('lqd-parallax-initiated'));
      });
    }

    switchWillChange(state) {
      if (state === 'off') {
        return this.parallaxElement.forEach(el => {
          el.style.willChange = 'auto';
        });
      }

      this.parallaxElement.forEach(el => {
        el.style.willChange = this.willChangeProps.join(', ');
      });
    }

    handleResize() {
      $(window).on('resize.lqdParallax', this.onWindowResize.bind(this));
    }

    async onWindowResize() {
      await this.measure();
      this.needsSentinel && !this.options.staticSentinel && (await this.positionSentinel());
    }

    destroy() {
      if (this.options.needsSentinel && this.sentinel) {
        this.sentinel.remove();
      }

      if (this.parallaxTimeline) {
        gsap.killTweensOf(this.parallaxTimeline);
        this.parallaxTimeline.scrollTrigger.kill();
        this.parallaxTimeline.kill();
        gsap.set(this.parallaxElement, {
          clearProps: 'all'
        });
        this.parallaxTimeline.clear();
      }

      $.data(this.element, "plugin_" + pluginName, null);
      $(window).off('resize.lqdParallax');
    }

  }

  $.fn[pluginName] = function (options, fromOpts, toOpts) {
    return this.each(function () {
      const pluginOptions = {
        disableOnMobile: true,
        ...$(this).data('parallax-options'),
        ...options
      };
      const parallaxFrom = { ...$(this).data('parallax-from'),
        ...fromOpts
      };
      const parallaxTo = { ...$(this).data('parallax-to'),
        ...toOpts
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        if (pluginOptions.disableOnMobile && liquidIsMobile()) return;
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions, parallaxFrom, parallaxTo));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('[data-parallax]').not('[data-pin]:not(.vc_row), .rev-slidebg').liquidParallax();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidTransitionDelay';
  let defaults = {
    elements: null,
    startDelay: 0,
    delayBetween: 250,
    random: false,
    reverse: false,
    delayType: 'transition'
  };

  class Plugin {
    constructor(element, options) {
      this.element = element;
      this.$element = $(element);
      this.options = $.extend({}, defaults, options);
      this._defaults = defaults;
      this._name = pluginName;
      const splitTextEls = this.$element.find('[data-split-text]').get();
      const promises = [];

      if (this.element.hasAttribute('data-split-text')) {
        splitTextEls.push(this.element);
      }

      splitTextEls.forEach(el => {
        const elData = $(el).data('plugin_liquidSplitText');

        if (elData) {
          promises.push(elData.splitDonePormise);
        }
      });

      if (promises.length) {
        Promise.all(promises).then(this.init.bind(this));
      } else {
        this.init();
      }
    }

    init() {
      this.addDelays();
    }

    addDelays() {
      const {
        elements,
        delayBetween,
        startDelay,
        delayType,
        reverse
      } = this.options;

      if (elements) {
        const $elements = !reverse ? $(elements, this.element) : $(elements, this.element).get().reverse();
        $.each($elements, (i, element) => {
          const delay = i * delayBetween + startDelay;
          $(element).css({
            [`-webkit-${delayType}-delay`]: `${delay}ms`,
            [`${delayType}-delay`]: `${delay}ms`
          });
        });
      }
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = $(this).data('delay-options') || options;

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('[data-transition-delay=true]').liquidTransitionDelay();
  $('.lqd-submenu-cover .main-nav > .menu-item-has-children:not(.megamenu) > .nav-item-children, .navbar-visible-ontoggle > ul').liquidTransitionDelay({
    elements: '> li',
    delayBetween: 60
  });
});
(function ($) {
  'use strict';

  const pluginName = 'liquidMoveElement';
  let defaults = {
    target: '#selector',
    targetRelation: 'closest',
    type: 'prependTo',
    includeParent: false,
    clone: false
  };

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.element = element;
      this.$element = $(element);
      this.movePromise = new Promise(resolve => {
        this.element.addEventListener('element-was-moved', resolve(this, this));
      });
      this.build();
    }

    build() {
      const promises = [];

      if (this.element.hasAttribute('data-pin')) {
        const pinPlugin = this.$element.data('plugin_liquidPin');

        if (pinPlugin) {
          promises.push(pinPlugin.pinPromise);
        }
      }

      if (promises.length > 0) {
        Promise.all(promises).then(this.init.bind(this));
      } else {
        this.init();
      }
    }

    init() {
      this.getHiddenClasses();
      this.moveElement();
    }

    getHiddenClasses() {
      const parentColumn = this.element.closest('.vc_column_container');

      if (parentColumn) {
        const parentColumnClass = parentColumn.getAttribute('class');
        const classList = parentColumnClass.split(' ').filter(cls => cls.search('vc_hidden') >= 0);

        if (classList.length > 0) {
          this.element.classList.add([...classList]);
        }
      }
    }

    moveElement() {
      fastdom.mutate(() => {
        const {
          target,
          type,
          targetRelation
        } = this.options;
        this.$element[type](this.$element[targetRelation](target));
        this.element.classList.add('element-was-moved');
        this.element.dispatchEvent(new CustomEvent('element-was-moved', {
          bubbles: false
        }));
      });
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = $(this).data('move-element') || options;

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('[data-move-element]').liquidMoveElement();
});
(function ($) {
  'use strict';

  const pluginName = 'liquidScrollIndicator';
  let defaults = {
    start: 'top top',
    end: 'bottom top',
    scrollingTarget: 'body',
    indicatorBase: '.lqd-scrl-indc-line',
    indicatorEl: '.lqd-scrl-indc-el',
    dir: "y",
    scale: false,
    origin: 'null',
    waitForElementMove: false
  };

  class Plugin {
    constructor(element, options) {
      this._defaults = defaults;
      this._name = pluginName;
      this.options = { ...defaults,
        ...options
      };
      this.DOM = {};
      this.DOM.element = element;
      this.DOM.scrollingTarget = this.getScrollingTarget();
      this.DOM.indicatorBase = this.DOM.element.querySelector(this.options.indicatorBase);
      this.DOM.indicatorEl = this.DOM.element.querySelector(this.options.indicatorEl);

      if (this.options.waitForElementMove) {
        const $parentElementMove = $(this.DOM.element).closest('[data-move-element]');

        if ($parentElementMove.length) {
          return $parentElementMove.data('plugin_liquidMoveElement').movePromise.then(() => this.init());
        }
      }

      this.init();
    }

    init() {
      !$liquidContents[0].hasAttribute('data-liquid-stack') ? this.initialTrigger() : this.initMutationObserver();
    }

    getScrollingTarget() {
      const {
        scrollingTarget
      } = this.options;

      switch (scrollingTarget) {
        case 'this':
          return this.DOM.element;

        case 'parentHref':
          return this.$element.closest('a').attr('href');

        case 'siblingsHref':
          return this.$element.siblings('a').first().attr('href');

        default:
          return scrollingTarget.replace('#', '') !== '' && document.querySelector(scrollingTarget);
      }
    }

    initialTrigger() {
      const {
        dir,
        scale,
        start,
        end,
        origin
      } = this.options;
      const {
        indicatorBase,
        scrollingTarget,
        indicatorEl
      } = this.DOM;
      const initScale = `scale${dir.toUpperCase()}`;
      const otherScale = dir === 'x' ? 'scaleY' : 'scaleX';
      let tween;

      if (origin) {
        gsap.set(indicatorEl, {
          transformOrigin: origin
        });
      }

      if (!scale) {
        tween = gsap.to(indicatorEl, {
          [dir]: dir === 'y' ? indicatorBase.offsetHeight : indicatorBase.offsetWidth,
          force3D: false
        });
      } else {
        tween = gsap.fromTo(indicatorEl, {
          [initScale]: 0,
          [otherScale]: 1
        }, {
          scale: 1,
          force3D: false
        });
      }

      ScrollTrigger.create({
        trigger: scrollingTarget,
        animation: tween,
        start,
        end,
        scrub: 0.5
      });
    }

    initMutationObserver() {
      const stackData = $liquidContents.data('plugin_liquidStack');
      if (!stackData || liquidIsMobile() || liquidWindowWidth() <= liquidMobileNavBreakpoint()) return;
      stackData.stackInitPromise.then(plugin => {
        const {
          dir
        } = this.options;
        const {
          indicatorBase,
          indicatorEl
        } = this.DOM;
        const totalSections = [...plugin.$sectionElements].filter(section => !section.classList.contains('main-footer')).length;
        const indicatorBaseSize = dir === 'y' ? indicatorBase.offsetHeight : indicatorBase.offsetWidth;
        new MutationObserver(() => {
          const currentStackPage = document.body.getAttribute('data-lqd-stack-page');
          const indicatorTrans = gsap.utils.mapRange(1, totalSections, 0, indicatorBaseSize, currentStackPage);
          gsap.to(indicatorEl, {
            [dir]: indicatorTrans,
            ease: 'linear',
            duration: 1
          });
        }).observe(document.body, {
          attributeFilter: ['data-lqd-stack-page']
        });
      });
    }

  }

  $.fn[pluginName] = function (options) {
    return this.each(function () {
      const pluginOptions = { ...$(this).data('scrl-indc-options'),
        ...options
      };

      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, pluginOptions));
      }
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  $('[data-lqd-scroll-indicator]').liquidScrollIndicator();
});

//# sourceMappingURL=theme.js.map

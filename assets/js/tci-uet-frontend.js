(function ($) {
    $(window).on('elementor/frontend/init', function (module) {
        "use strict";
        // Attach to TCI UET Stciky Section
        elementorFrontend.hooks.addAction('frontend/element_ready/section', function ($scope) {
            tci_uet_sticky($scope);
        });
        // Attach to Widgets
        elementorFrontend.hooks.addAction('frontend/element_ready/widget', function ($scope) {
            tci_uet_sticky($scope);
            tci_uet_light_box($scope);
        });
        // Attach to TCI UET Search Form Widget
        elementorFrontend.hooks.addAction('frontend/element_ready/TCI_UET_Search_Form.default', function ($scope) {
            var SearchBerHandler = elementorModules.frontend.handlers.Base.extend({
                getDefaultSettings: function getDefaultSettings() {
                    return {
                        selectors: {
                            wrapper: '.elementor-search-form',
                            container: '.elementor-search-form__container',
                            icon: '.elementor-search-form__icon',
                            input: '.elementor-search-form__input',
                            toggle: '.elementor-search-form__toggle',
                            submit: '.elementor-search-form__submit',
                            closeButton: '.dialog-close-button'
                        },
                        classes: {
                            isFocus: 'elementor-search-form--focus',
                            isFullScreen: 'elementor-search-form--full-screen',
                            lightbox: 'elementor-lightbox'
                        }
                    };
                },
                getDefaultElements: function getDefaultElements() {
                    var selectors = this.getSettings('selectors'),
                        elements = {};
                    elements.$wrapper = this.$element.find(selectors.wrapper);
                    elements.$container = this.$element.find(selectors.container);
                    elements.$input = this.$element.find(selectors.input);
                    elements.$icon = this.$element.find(selectors.icon);
                    elements.$toggle = this.$element.find(selectors.toggle);
                    elements.$submit = this.$element.find(selectors.submit);
                    elements.$closeButton = this.$element.find(selectors.closeButton);
                    return elements;
                },
                bindEvents: function bindEvents() {
                    var self = this,
                        $container = self.elements.$container,
                        $closeButton = self.elements.$closeButton,
                        $input = self.elements.$input,
                        $wrapper = self.elements.$wrapper,
                        $icon = self.elements.$icon,
                        skin = this.getElementSettings('skin'),
                        classes = this.getSettings('classes');
                    if ('full_screen' === skin) {
                        // Activate full-screen mode on click
                        self.elements.$toggle.on('click', function () {
                            $container.toggleClass(classes.isFullScreen).toggleClass(classes.lightbox);
                            $input.focus();
                        });
                        // Deactivate full-screen mode on click or on esc.
                        $container.on('click', function (event) {
                            if ($container.hasClass(classes.isFullScreen) && $container[0] === event.target) {
                                $container.removeClass(classes.isFullScreen).removeClass(classes.lightbox);
                            }
                        });
                        $closeButton.on('click', function () {
                            $container.removeClass(classes.isFullScreen).removeClass(classes.lightbox);
                        });
                        elementorFrontend.elements.$document.keyup(function (event) {
                            var ESC_KEY = 27;
                            if (ESC_KEY === event.keyCode) {
                                if ($container.hasClass(classes.isFullScreen)) {
                                    $container.click();
                                }
                            }
                        });
                    } else {
                        // Apply focus style on wrapper element when input is focused
                        $input.on({
                            focus: function focus() {
                                $wrapper.addClass(classes.isFocus);
                            },
                            blur: function blur() {
                                $wrapper.removeClass(classes.isFocus);
                            }
                        });
                    }
                    if ('minimal' === skin) {
                        // Apply focus style on wrapper element when icon is clicked in minimal skin
                        $icon.on('click', function () {
                            $wrapper.addClass(classes.isFocus);
                            $input.focus();
                        });
                    }
                }
            });
            new SearchBerHandler({$element: $scope});
        });
        // Attach to TCI UET Nave Menu Widget
        elementorFrontend.hooks.addAction('frontend/element_ready/TCI_UET_Nav_Menu.default', function ($scope) {
            var MenuHandler = elementorModules.frontend.handlers.Base.extend({
                stretchElement: null,
                getDefaultSettings: function getDefaultSettings() {
                    return {
                        selectors: {
                            menu: '.elementor-nav-menu',
                            anchorLink: '.elementor-nav-menu--main .elementor-item-anchor',
                            dropdownMenu: '.elementor-nav-menu__container.elementor-nav-menu--dropdown',
                            menuToggle: '.elementor-menu-toggle'
                        }
                    };
                },
                getDefaultElements: function getDefaultElements() {
                    var selectors = this.getSettings('selectors'),
                        elements = {};
                    elements.$menu = this.$element.find(selectors.menu);
                    elements.$anchorLink = this.$element.find(selectors.anchorLink);
                    elements.$dropdownMenu = this.$element.find(selectors.dropdownMenu);
                    elements.$dropdownMenuFinalItems = elements.$dropdownMenu.find('.menu-item:not(.menu-item-has-children) > a');
                    elements.$menuToggle = this.$element.find(selectors.menuToggle);
                    return elements;
                },
                bindEvents: function bindEvents() {
                    if (!this.elements.$menu.length) {
                        return;
                    }
                    this.elements.$menuToggle.on('click', this.toggleMenu.bind(this));
                    if (this.getElementSettings('full_width')) {
                        this.elements.$dropdownMenuFinalItems.on('click', this.toggleMenu.bind(this, false));
                    }
                    elementorFrontend.addListenerOnce(this.$element.data('model-cid'), 'resize', this.stretchMenu);
                },
                initStretchElement: function initStretchElement() {
                    this.stretchElement = new elementorModules.frontend.tools.StretchElement({element: this.elements.$dropdownMenu});
                },
                toggleMenu: function toggleMenu(show) {
                    var isDropdownVisible = this.elements.$menuToggle.hasClass('elementor-active');
                    if ('boolean' !== typeof show) {
                        show = !isDropdownVisible;
                    }
                    this.elements.$menuToggle.toggleClass('elementor-active', show);
                    if (show && this.getElementSettings('full_width')) {
                        this.stretchElement.stretch();
                    }
                },
                followMenuAnchors: function followMenuAnchors() {
                    var self = this;
                    self.elements.$anchorLink.each(function () {
                        if (location.pathname === this.pathname && '' !== this.hash) {
                            self.followMenuAnchor(jQuery(this));
                        }
                    });
                },
                followMenuAnchor: function followMenuAnchor($element) {
                    var anchorSelector = $element[0].hash;
                    var offset = -300,
                        $anchor = void 0;
                    try {
                        // `decodeURIComponent` for UTF8 characters in the hash.
                        $anchor = jQuery(decodeURIComponent(anchorSelector));
                    } catch (e) {
                        return;
                    }
                    if (!$anchor.length) {
                        return;
                    }
                    if (!$anchor.hasClass('elementor-menu-anchor')) {
                        var halfViewport = jQuery(window).height() / 2;
                        offset = -$anchor.outerHeight() + halfViewport;
                    }
                    elementorFrontend.waypoint($anchor, function (direction) {
                        if ('down' === direction) {
                            $element.addClass('elementor-item-active');
                        } else {
                            $element.removeClass('elementor-item-active');
                        }
                    }, {offset: '50%', triggerOnce: false});

                    elementorFrontend.waypoint($anchor, function (direction) {
                        if ('down' === direction) {
                            $element.removeClass('elementor-item-active');
                        } else {
                            $element.addClass('elementor-item-active');
                        }
                    }, {offset: offset, triggerOnce: false});
                },
                stretchMenu: function stretchMenu() {
                    if (this.getElementSettings('full_width')) {

                        this.stretchElement.stretch();
                        this.elements.$dropdownMenu.css('top', this.elements.$menuToggle.outerHeight());
                    } else {
                        this.stretchElement.reset();
                    }
                },
                onInit: function onInit() {
                    elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);
                    if (!this.elements.$menu.length) {
                        return;
                    }
                    this.elements.$menu.smartmenus({
                        subIndicatorsText: '<i class="fa"></i>',
                        subIndicatorsPos: 'append',
                        subMenusMaxWidth: '1000px'
                    });
                    this.initStretchElement();
                    this.stretchMenu();
                    if (!elementorFrontend.isEditMode()) {
                        this.followMenuAnchors();
                    }
                },
                onElementChange: function onElementChange(propertyName) {
                    if ('full_width' === propertyName) {
                        this.stretchMenu();
                    }
                }
            });
            new MenuHandler({$element: $scope});
        });
        // Attach to TCI UET Facebook Embed Widgets
        elementorFrontend.hooks.addAction('frontend/element_ready/TCI_UET_Facebook_Embed.default', function ($scope) {
            tci_uet_facebook_sdk($scope);
        });
        // Attach to TCI UET Facebook Like Button Widgets
        elementorFrontend.hooks.addAction('frontend/element_ready/TCI_UET_Facebook_Button.default', function ($scope) {
            tci_uet_facebook_sdk($scope);
        });
        // Attach to TCI UET Facebook Comments Widgets
        elementorFrontend.hooks.addAction('frontend/element_ready/TCI_UET_Facebook_Comments.default', function ($scope) {
            tci_uet_facebook_sdk($scope);
        });
        // Attach to TCI UET Facebook Page Widgets
        elementorFrontend.hooks.addAction('frontend/element_ready/TCI_UET_Facebook_Page.default', function ($scope) {
            tci_uet_facebook_sdk($scope);
        });
    });

    function tci_uet_facebook_sdk($scope) {
        var config = tci_uet_localize.facebook_sdk;
        var loadSDK = function loadSDK() {
            // Don't load in parallel
            config.isLoading = true;
            jQuery.ajax({
                url: 'https://connect.facebook.net/' + config.lang + '/sdk.js',
                dataType: 'script',
                cache: true,
                success: function success() {
                    FB.init({
                        appId: config.app_id,
                        version: 'v2.10',
                        xfbml: false
                    });
                    config.isLoaded = true;
                    config.isLoading = false;
                    jQuery(document).trigger('fb:sdk:loaded');
                }
            });
        };
        loadSDK();
        // On FB SDK is loaded, parse current element
        var parse = function parse() {
            $scope.find('.elementor-widget-container div').attr('data-width', $scope.width() + 'px');
            FB.XFBML.parse($scope[0]);
        };
        if (config.isLoaded) {
            parse();
        } else {
            jQuery(document).on('fb:sdk:loaded', parse);
        }
    }

    function tci_uet_sticky($scope) {
        var StickyHandler = elementorModules.frontend.handlers.Base.extend({
            bindEvents: function bindEvents() {
                elementorFrontend.addListenerOnce(this.getUniqueHandlerID() + 'sticky', 'resize', this.run);
            },
            unbindEvents: function unbindEvents() {
                elementorFrontend.removeListeners(this.getUniqueHandlerID() + 'sticky', 'resize', this.run);
            },
            isActive: function isActive() {
                return undefined !== this.$element.data('sticky');
            },
            activate: function activate() {
                var elementSettings = this.getElementSettings(),
                    stickyOptions = {
                        to: elementSettings.sticky,
                        offset: elementSettings.sticky_offset,
                        effectsOffset: elementSettings.sticky_effects_offset,
                        classes: {
                            sticky: 'elementor-sticky',
                            stickyActive: 'elementor-sticky--active elementor-section--handles-inside',
                            stickyEffects: 'elementor-sticky--effects',
                            spacer: 'elementor-sticky__spacer'
                        }
                    },
                    $wpAdminBar = elementorFrontend.elements.$wpAdminBar;

                if (elementSettings.sticky_parent) {
                    stickyOptions.parent = '.elementor-widget-wrap';
                }

                if ($wpAdminBar.length && 'top' === elementSettings.sticky && 'fixed' === $wpAdminBar.css('position')) {
                    stickyOptions.offset += $wpAdminBar.height();
                }
                console.log(this.$element);
                this.$element.sticky(stickyOptions);
            },
            deactivate: function deactivate() {
                if (!this.isActive()) {
                    return;
                }

                this.$element.sticky('destroy');
            },
            run: function run(refresh) {
                if (!this.getElementSettings('sticky')) {
                    this.deactivate();

                    return;
                }

                var currentDeviceMode = elementorFrontend.getCurrentDeviceMode(),
                    activeDevices = this.getElementSettings('sticky_on');

                if (-1 !== activeDevices.indexOf(currentDeviceMode)) {
                    if (true === refresh) {
                        this.reactivate();
                    } else if (!this.isActive()) {
                        this.activate();
                    }
                } else {
                    this.deactivate();
                }
            },
            reactivate: function reactivate() {
                this.deactivate();

                this.activate();
            },
            onElementChange: function onElementChange(settingKey) {
                if (-1 !== ['sticky', 'sticky_on'].indexOf(settingKey)) {
                    this.run(true);
                }

                if (-1 !== ['sticky_offset', 'sticky_effects_offset', 'sticky_parent'].indexOf(settingKey)) {
                    this.reactivate();
                }
            },
            onInit: function onInit() {
                elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);

                this.run();
            },
            onDestroy: function onDestroy() {
                elementorModules.frontend.handlers.Base.prototype.onDestroy.apply(this, arguments);

                this.deactivate();
            }
        });
        new StickyHandler({$element: $scope});
    }

    function tci_uet_light_box($scope) {
        var TCI_UET_Light_Box = elementorModules.frontend.handlers.Base.extend({
            bindEvents: function bindEvents() {
                elementorFrontend.elements.$document.on('click', this.getSettings('selectors.links'), this.runLinkAction.bind(this));
            },
            initActions: function initActions() {
                this.actions = {
                    lightbox: function lightbox(settings) {
                        return elementorFrontend.utils.lightbox.showModal(settings);
                    }
                }
            },
            runAction: function runAction(url) {
                url = decodeURIComponent(url);
                var actionMatch = url.match(/action=(.+?) /),
                    settingsMatch = url.match(/settings=(.+)/);
                if (!actionMatch) {
                    return;
                }
                var action = this.actions[actionMatch[1]];
                if (!action) {
                    return;
                }
                var settings = {};
                if (settingsMatch) {
                    settings = JSON.parse(atob(settingsMatch[1]));
                }
                for (var _len = arguments.length, restArgs = Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
                    restArgs[_key - 1] = arguments[_key];
                }
                action.apply(undefined, [settings].concat(restArgs));
            },
            runLinkAction: function runLinkAction(event) {
                event.preventDefault();
                this.runAction(event.currentTarget.href, event);
            },
            onInit: function onInit() {
                this.bindEvents();
                this.initActions();
            },
            getDefaultSettings: function getDefaultSettings() {
                return {
                    selectors: {
                        links: 'a[href^="#elementor-action"]'
                    }
                };
            }
        });
        new TCI_UET_Light_Box({$element: $scope}).onInit();
    }

})(jQuery);

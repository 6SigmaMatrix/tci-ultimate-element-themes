(function ($) {
    AstraRender = {
        _ref: null,
        _api_params: {},
        _breakpoint: 768,
        init: function () {
            this._resetPagedCount();
            this._bind();
            this._showFilters();
        },
        /**
         * Binds events for the Astra Sites.
         *
         * @since 1.0.0
         * @access private
         * @method _bind
         */
        _bind: function () {
            $(document).on('astra-sites-api-request-error', AstraRender._addSuggestionBox);
            $(document).on('astra-sites-api-request-fail', AstraRender._addSuggestionBox);
            $(document).on('astra-api-post-loaded-on-scroll', AstraRender._reinitGridScrolled);
            $(document).on('astra-api-post-loaded', AstraRender._reinitGrid);
            $(document).on('astra-api-category-loaded', AstraRender._addFilters);
            $(document).on('astra-api-all-category-loaded', AstraRender._loadFirstGrid);
            // Event's for API request.
            $(document).on('click', '.filter-links a', AstraRender._filterClick);
            $(document).on('keyup input', '#wp-filter-search-input', AstraRender._search);
            $(document).on('scroll', AstraRender._scroll);
        },
        /**
         * On Filter Clicked
         *
         * Prepare Before API Request:
         * - Empty search input field to avoid search term on filter click.
         * - Remove Inline Height
         * - Added 'hide-me' class to hide the 'No more sites!' string.
         * - Added 'loading-content' for body.
         * - Show spinner.
         */
        _filterClick: function (event) {
            event.preventDefault();
            $(this).parents('.filter-links').find('a').removeClass('current');
            $(this).addClass('current');
            // Prepare Before Search.
            $('.no-more-demos').addClass('hide-me');
            $('.astra-sites-suggestions').remove();
            // Empty the search input only click on category filter not on page builder filter.
            if ($(this).parents('.filter-links').hasClass('astra-site-category')) {
                $('#wp-filter-search-input').val('');
            }
            $('#astra-sites').hide().css('height', '');
            $('body').addClass('loading-content');
            $('#astra-sites-admin').find('.spinner').removeClass('hide-me');
            // Show sites.
            AstraRender._showSites();
        },
        /**
         * Search Site.
         *
         * Prepare Before API Request:
         * - Remove Inline Height
         * - Added 'hide-me' class to hide the 'No more sites!' string.
         * - Added 'loading-content' for body.
         * - Show spinner.
         */
        _search: function () {
            $this = jQuery('#wp-filter-search-input').val();
            // Prepare Before Search.
            $('#astra-sites').hide().css('height', '');
            $('.no-more-demos').addClass('hide-me');
            $('.astra-sites-suggestions').remove();
            $('body').addClass('loading-content');
            $('#astra-sites-admin').find('.spinner').removeClass('hide-me');
            window.clearTimeout(AstraRender._ref);
            AstraRender._ref = window.setTimeout(function () {
                AstraRender._ref = null;
                AstraRender._resetPagedCount();
                jQuery('body').addClass('loading-content');
                jQuery('body').attr('data-astra-demo-search', $this);
                AstraRender._showSites();
            }, 500);
        },
        /**
         * On Scroll
         */
        _scroll: function (event) {
            if (!$('body').hasClass('listed-all-sites')) {
                var scrollDistance = jQuery(window).scrollTop();
                var themesBottom = Math.abs(jQuery(window).height() - jQuery('#astra-sites').offset().top - jQuery('#astra-sites').height());
                themesBottom = themesBottom - 100;
                ajaxLoading = jQuery('body').data('scrolling');
                if (scrollDistance > themesBottom && ajaxLoading == false) {
                    AstraRender._updatedPagedCount();
                    if (!$('#astra-sites .no-themes').length) {
                        $('#astra-sites-admin').find('.spinner').addClass('is-active');
                    }
                    jQuery('body').data('scrolling', true);
                    /**
                     * @see _reinitGridScrolled() which called in trigger 'astra-api-post-loaded-on-scroll'
                     */
                    AstraRender._showSites(false, 'astra-api-post-loaded-on-scroll');
                }
            }
        },
        _apiAddParam_status: function () {
            if (astraRenderGrid.sites && astraRenderGrid.sites.status) {
                AstraRender._api_params['status'] = astraRenderGrid.sites.status;
            }
        },
        // Add 'search'
        _apiAddParam_search: function () {
            var search_val = jQuery('#wp-filter-search-input').val() || '';
            if ('' !== search_val) {
                AstraRender._api_params['search'] = search_val;
            }
        },
        _apiAddParam_per_page: function () {
            // Add 'per_page'
            var per_page_val = 15;
            if (astraRenderGrid.sites && astraRenderGrid.sites["par-page"]) {
                per_page_val = parseInt(astraRenderGrid.sites["par-page"]);
            }
            AstraRender._api_params['per_page'] = per_page_val;
        },
        _apiAddParam_astra_site_category: function () {
            // Add 'astra-site-category'
            var selected_category_id = jQuery('.filter-links.astra-site-category').find('.current').data('group') || '';
            if ('' !== selected_category_id && 'all' !== selected_category_id) {
                AstraRender._api_params['astra-site-category'] = selected_category_id;
            } else if ('astra-site-category' in astraRenderGrid.settings) {
                if ($.inArray('all', astraRenderGrid.settings['astra-site-category']) !== -1) {
                    var storedCategories = astraRenderGrid.settings['astra-site-category'];
                    storedCategories = jQuery.grep(storedCategories, function (value) {
                        return value != 'all';
                    });
                    AstraRender._api_params['astra-site-category'] = storedCategories.join(',');
                }
            }
        },
        _apiAddParam_astra_site_page_builder: function () {
            // Add 'astra-site-page-builder'
            var selected_page_builder_id = jQuery('.filter-links.astra-site-page-builder').find('.current').data('group') || '';
            if ('' !== selected_page_builder_id && 'all' !== selected_page_builder_id) {
                AstraRender._api_params['astra-site-page-builder'] = selected_page_builder_id;
            } else if ('astra-site-page-builder' in astraRenderGrid.settings) {
                if ($.inArray('all', astraRenderGrid.settings['astra-site-page-builder']) !== -1) {
                    var storedBuilders = astraRenderGrid.settings['astra-site-page-builder'];
                    storedBuilders = jQuery.grep(storedBuilders, function (value) {
                        return value != 'all';
                    });
                    AstraRender._api_params['astra-site-page-builder'] = storedBuilders.join(',');
                }
            }
        },
        _apiAddParam_page: function () {
            // Add 'page'
            var page_val = parseInt(jQuery('body').attr('data-astra-demo-paged')) || 1;
            AstraRender._api_params['page'] = page_val;
        },
        _apiAddParam_purchase_key: function () {
            if (astraRenderGrid.sites && astraRenderGrid.sites.purchase_key) {
                AstraRender._api_params['purchase_key'] = astraRenderGrid.sites.purchase_key;
            }
        },
        _apiAddParam_site_url: function () {
            if (astraRenderGrid.sites && astraRenderGrid.sites.site_url) {
                AstraRender._api_params['site_url'] = astraRenderGrid.sites.site_url;
            }
        },
        /**
         * Show Sites
         *
         *    Params E.g. per_page=<page-id>&astra-site-category=<category-ids>&astra-site-page-builder=<page-builder-ids>&page=<page>
         *
         * @param  {Boolean} resetPagedCount Reset Paged Count.
         * @param  {String}  trigger         Filtered Trigger.
         */
        _showSites: function (resetPagedCount, trigger) {
            if (undefined === resetPagedCount) {
                resetPagedCount = true
            }
            if (undefined === trigger) {
                trigger = 'astra-api-post-loaded';
            }
            if (resetPagedCount) {
                AstraRender._resetPagedCount();
            }
            // Add Params for API request.
            AstraRender._api_params = {};
            AstraRender._apiAddParam_status();
            AstraRender._apiAddParam_search();
            AstraRender._apiAddParam_per_page();
            AstraRender._apiAddParam_astra_site_category();
            AstraRender._apiAddParam_astra_site_page_builder();
            AstraRender._apiAddParam_page();
            AstraRender._apiAddParam_site_url();
            AstraRender._apiAddParam_purchase_key();
            // API Request.
            var api_post = {
                slug: 'posts?' + decodeURIComponent($.param(AstraRender._api_params)),
                trigger: trigger,
            };
            TCISitesAPI._api_request(api_post);
        },
        /**
         * Get Category Params
         *
         * @param  {string} category_slug Category Slug.
         * @return {mixed}               Add `include=<category-ids>` in API request.
         */
        _getCategoryParams: function (category_slug) {
            // Has category?
            if (category_slug in astraRenderGrid.settings) {
                var storedBuilders = astraRenderGrid.settings[category_slug];
                // Remove `all` from stored list?
                storedBuilders = jQuery.grep(storedBuilders, function (value) {
                    return value != 'all';
                });
                return '?include=' + storedBuilders.join(',');
            }
            return '';
        },
        /**
         * Get All Select Status
         *
         * @param  {string} category_slug Category Slug.
         * @return {boolean}              Return true/false.
         */
        _getCategoryAllSelectStatus: function (category_slug) {
            // Has category?
            if (category_slug in astraRenderGrid.settings) {
                // Has `all` in stored list?
                if ($.inArray('all', astraRenderGrid.settings[category_slug]) === -1) {
                    return false;
                }
            }
            return true;
        },
        /**
         * Show Filters
         */
        _showFilters: function () {
            /**
             * Categories
             */
            /* var category_slug = 'tci-site-page-builder';
             var category = {
                 slug: category_slug + AstraRender._getCategoryParams(category_slug),
                 id: category_slug,
                 class: category_slug,
                 trigger: 'astra-api-category-loaded',
                 wrapper_class: 'filter-links',
                 show_all: false,
             };
             TCISitesAPI._api_request(category);*/
            /**
             * Page Builder
             */
            var category_slug = 'categories';
            var category = {
                slug: category_slug + AstraRender._getCategoryParams(category_slug),
                id: category_slug,
                class: category_slug,
                trigger: 'astra-api-all-category-loaded',
                wrapper_class: 'filter-links',
                show_all: AstraRender._getCategoryAllSelectStatus(category_slug),
            };
            TCISitesAPI._api_request(category);
        },
        /**
         * Load First Grid.
         *
         * This is triggered after all category loaded.
         *
         * @param  {object} event Event Object.
         */
        _loadFirstGrid: function (event, data) {
            AstraRender._addFilters(event, data);
            setTimeout(function () {
                AstraRender._showSites();
            }, 100);
        },
        /**
         * Append filters.
         *
         * @param  {object} event Object.
         * @param  {object} data  API response data.
         */
        _addFilters: function (event, data) {
            event.preventDefault();
            if (jQuery('#' + data.args.id).length) {
                var template = wp.template('tci-site-filters');
                jQuery('#' + data.args.id).html(template(data)).find('li:first a').addClass('current');
            }
        },
        /**
         * Append sites on scroll.
         *
         * @param  {object} event Object.
         * @param  {object} data  API response data.
         */
        _reinitGridScrolled: function (event, data) {
            var template = wp.template('tci-sites-list');
            if (data.items.length > 0) {
                $('body').removeClass('loading-content');
                $('.filter-count .count').text(data.items_count);
                setTimeout(function () {
                    jQuery('#astra-sites').append(template(data));
                    AstraRender._imagesLoaded();
                }, 800);
            } else {
                $('body').addClass('listed-all-sites');
                // $('#astra-sites-admin').find('.spinner').removeClass('is-active');
            }
        },
        /**
         * Update Astra sites list.
         *
         * @param  {object} event Object.
         * @param  {object} data  API response data.
         */
        _reinitGrid: function (event, data) {
            var template = wp.template('tci-sites-list');
            $('body').removeClass('loading-content');
            $('.filter-count .count').text(data.items_count);
            jQuery('body').attr('data-astra-demo-last-request', data.items_count);
            jQuery('#astra-sites').show().html(template(data));
            AstraRender._imagesLoaded();
            $('#astra-sites-admin').find('.spinner').removeClass('is-active');
            if (data.items_count <= 0) {
                $('#astra-sites-admin').find('.spinner').removeClass('is-active');
                $('.no-more-demos').addClass('hide-me');
                $('.astra-sites-suggestions').remove();
            } else {
                $('body').removeClass('listed-all-sites');
            }
        },
        /**
         * Check image loaded with function `imagesLoaded()`
         */
        _imagesLoaded: function () {
            var self = jQuery('#sites-filter.execute-only-one-time a');
            $('.astra-sites-grid').imagesLoaded()
                .always(function (instance) {
                    if (jQuery(window).outerWidth() > AstraRender._breakpoint) {
                        // $('#astra-sites').masonry('reload');
                    }
                    $('#astra-sites-admin').find('.spinner').removeClass('is-active');
                })
                .progress(function (instance, image) {
                    var result = image.isLoaded ? 'loaded' : 'broken';
                });
        },
        /**
         * Add Suggestion Box
         */
        _addSuggestionBox: function () {
            $('#astra-sites-admin').find('.spinner').removeClass('is-active').addClass('hide-me');
            $('#astra-sites-admin').find('.no-more-demos').removeClass('hide-me');
            var template = wp.template('astra-sites-suggestions');
            if (!$('.astra-sites-suggestions').length) {
                $('#astra-sites').append(template);
            }
        },
        /**
         * Update Page Count.
         */
        _updatedPagedCount: function () {
            paged = parseInt(jQuery('body').attr('data-astra-demo-paged'));
            jQuery('body').attr('data-astra-demo-paged', paged + 1);
            window.setTimeout(function () {
                jQuery('body').data('scrolling', false);
            }, 800);
        },
        /**
         * Reset Page Count.
         */
        _resetPagedCount: function () {
            jQuery('body').attr('data-astra-demo-last-request', '1');
            jQuery('body').attr('data-astra-demo-paged', '1');
            jQuery('body').attr('data-astra-demo-search', '');
            jQuery('body').attr('data-scrolling', false);
        }
    };
    /**
     * Initialize AstraRender
     */
    $(function () {
        AstraRender.init();
    });
})(jQuery);
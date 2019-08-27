/**
 * AJAX Request Queue
 *
 * - add()
 * - remove()
 * - run()
 * - stop()
 *
 * @since 1.0.0
 */
var AstraSitesAjaxQueue = (function () {

    var requests = [];

    return {

        /**
         * Add AJAX request
         *
         * @since 1.0.0
         */
        add: function (opt) {
            requests.push(opt);
        },

        /**
         * Remove AJAX request
         *
         * @since 1.0.0
         */
        remove: function (opt) {
            if (jQuery.inArray(opt, requests) > -1)
                requests.splice($.inArray(opt, requests), 1);
        },

        /**
         * Run / Process AJAX request
         *
         * @since 1.0.0
         */
        run: function () {
            var self = this,
                oriSuc;

            if (requests.length) {
                oriSuc = requests[0].complete;

                requests[0].complete = function () {
                    if (typeof (oriSuc) === 'function') oriSuc();
                    requests.shift();
                    self.run.apply(self, []);
                };

                jQuery.ajax(requests[0]);

            } else {

                self.tid = setTimeout(function () {
                    self.run.apply(self, []);
                }, 1000);
            }
        },

        /**
         * Stop AJAX request
         *
         * @since 1.0.0
         */
        stop: function () {

            requests = [];
            clearTimeout(this.tid);
        }
    };

}());

(function ($) {

    var AstraSSEImport = {
        complete: {
            posts: 0,
            media: 0,
            users: 0,
            comments: 0,
            terms: 0,
        },

        updateDelta: function (type, delta) {
            this.complete[type] += delta;

            var self = this;
            requestAnimationFrame(function () {
                self.render();
            });
        },
        updateProgress: function (type, complete, total) {
            var text = complete + '/' + total;

            if ('undefined' !== type && 'undefined' !== text) {
                total = parseInt(total, 10);
                if (0 === total || isNaN(total)) {
                    total = 1;
                }
                var percent = parseInt(complete, 10) / total;
                var progress = Math.round(percent * 100) + '%';
                var progress_bar = percent * 100;
            }
        },
        render: function () {
            var types = Object.keys(this.complete);
            var complete = 0;
            var total = 0;

            for (var i = types.length - 1; i >= 0; i--) {
                var type = types[i];
                this.updateProgress(type, this.complete[type], this.data.count[type]);

                complete += this.complete[type];
                total += this.data.count[type];
            }

            this.updateProgress('total', complete, total);
        }
    };

    AstraSitesAdmin = {

        log_file: '',
        customizer_data: '',
        wxr_url: '',
        options_data: '',
        widgets_data: '',

        init: function () {
            this._resetPagedCount();
            this._bind();
        },

        /**
         * Debugging.
         *
         * @param  {mixed} data Mixed data.
         */
        _log: function (data) {

            if (astraSitesAdmin.debug) {

                var date = new Date();
                var time = date.toLocaleTimeString();

                if (typeof data == 'object') {
                    console.log('%c ' + JSON.stringify(data) + ' ' + time, 'background: #ededed; color: #444');
                } else {
                    console.log('%c ' + data + ' ' + time, 'background: #ededed; color: #444');
                }


            }
        },

        /**
         * Binds events for the Astra Sites.
         *
         * @since 1.0.0
         * @access private
         * @method _bind
         */
        _bind: function () {
            $(document).on('click', '.devices button', AstraSitesAdmin._previewDevice);
            $(document).on('click', '.theme-browser .theme-screenshot, .theme-browser .more-details, .theme-browser .install-theme-preview', AstraSitesAdmin._preview);
            $(document).on('click', '.next-theme', AstraSitesAdmin._nextTheme);
            $(document).on('click', '.previous-theme', AstraSitesAdmin._previousTheme);
            $(document).on('click', '.collapse-sidebar', AstraSitesAdmin._collapse);
            $(document).on('click', '.astra-demo-import', AstraSitesAdmin._importDemo);
            $(document).on('click', '.install-now', AstraSitesAdmin._installNow);
            $(document).on('click', '.close-full-overlay', AstraSitesAdmin._fullOverlay);
            $(document).on('click', '.activate-now', AstraSitesAdmin._activateNow);
            $(document).on('wp-plugin-installing', AstraSitesAdmin._pluginInstalling);
            $(document).on('wp-plugin-install-error', AstraSitesAdmin._installError);
            $(document).on('wp-plugin-install-success', AstraSitesAdmin._installSuccess);

            $(document).on('astra-sites-import-set-site-data-done', AstraSitesAdmin._importCustomizerSettings);
            $(document).on('astra-sites-import-customizer-settings-done', AstraSitesAdmin._importPrepareXML);
            $(document).on('astra-sites-import-xml-done', AstraSitesAdmin._importSiteOptions);
            $(document).on('astra-sites-import-options-done', AstraSitesAdmin._importWidgets);
            $(document).on('astra-sites-import-widgets-done', AstraSitesAdmin._importEnd);
        },

        /**
         * 5. Import Complete.
         */
        _importEnd: function (event) {

            $.ajax({
                url: astraSitesAdmin.ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'astra-sites-import-end',
                },
                beforeSend: function () {
                    $('.button-hero.astra-demo-import').text(astraSitesAdmin.log.importComplete);
                }
            })
                .fail(function (jqXHR) {
                    AstraSitesAdmin._importFailMessage(jqXHR.status + ' ' + jqXHR.responseText);
                    AstraSitesAdmin._log(jqXHR.status + ' ' + jqXHR.responseText);
                })
                .done(function (data) {

                    // 5. Fail - Import Complete.
                    if (false === data.success) {
                        AstraSitesAdmin._importFailMessage(data.data);
                        AstraSitesAdmin._log(data.data);
                    } else {

                        // 5. Pass - Import Complete.
                        AstraSitesAdmin._importSuccessMessage();
                        AstraSitesAdmin._log(astraSitesAdmin.log.success + ' ' + astraSitesAdmin.siteURL);
                    }
                });
        },

        /**
         * 4. Import Widgets.
         */
        _importWidgets: function (event) {

            $.ajax({
                url: astraSitesAdmin.ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'astra-sites-import-widgets',
                    widgets_data: AstraSitesAdmin.widgets_data,
                },
                beforeSend: function () {
                    AstraSitesAdmin._log(astraSitesAdmin.log.importWidgets);
                    $('.button-hero.astra-demo-import').text(astraSitesAdmin.log.importingWidgets);
                },
            })
                .fail(function (jqXHR) {
                    AstraSitesAdmin._importFailMessage(jqXHR.status + ' ' + jqXHR.responseText);
                    AstraSitesAdmin._log(jqXHR.status + ' ' + jqXHR.responseText);
                })
                .done(function (widgets_data) {

                    // 4. Fail - Import Widgets.
                    if (false === widgets_data.success) {
                        AstraSitesAdmin._importFailMessage(widgets_data.data);
                        AstraSitesAdmin._log(widgets_data.data);

                    } else {

                        // 4. Pass - Import Widgets.
                        AstraSitesAdmin._log(astraSitesAdmin.log.importWidgetsSuccess);
                        $(document).trigger('astra-sites-import-widgets-done');
                    }
                });
        },

        /**
         * 3. Import Site Options.
         */
        _importSiteOptions: function (event) {

            $.ajax({
                url: astraSitesAdmin.ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'astra-sites-import-options',
                    options_data: AstraSitesAdmin.options_data,
                },
                beforeSend: function () {
                    AstraSitesAdmin._log(astraSitesAdmin.log.importOptions);
                    $('.button-hero.astra-demo-import').text(astraSitesAdmin.log.importingOptions);
                },
            })
                .fail(function (jqXHR) {
                    AstraSitesAdmin._importFailMessage(jqXHR.status + ' ' + jqXHR.responseText);
                    AstraSitesAdmin._log(jqXHR.status + ' ' + jqXHR.responseText);
                })
                .done(function (options_data) {

                    // 3. Fail - Import Site Options.
                    if (false === options_data.success) {
                        AstraSitesAdmin._log(options_data);
                        AstraSitesAdmin._importFailMessage(options_data.data);
                        AstraSitesAdmin._log(options_data.data);

                    } else {

                        // 3. Pass - Import Site Options.
                        AstraSitesAdmin._log(astraSitesAdmin.log.importOptionsSuccess);
                        $(document).trigger('astra-sites-import-options-done');
                    }
                });
        },

        /**
         * 2. Prepare XML Data.
         */
        _importPrepareXML: function (event) {

            $.ajax({
                url: astraSitesAdmin.ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'astra-sites-import-prepare-xml',
                    wxr_url: AstraSitesAdmin.wxr_url,
                },
                beforeSend: function () {
                    AstraSitesAdmin._log(astraSitesAdmin.log.importXMLPrepare);
                    $('.button-hero.astra-demo-import').text(astraSitesAdmin.log.importXMLPreparing);
                },
            })
                .fail(function (jqXHR) {
                    AstraSitesAdmin._importFailMessage(jqXHR.status + ' ' + jqXHR.responseText);
                    AstraSitesAdmin._log(jqXHR.status + ' ' + jqXHR.responseText);
                })
                .done(function (xml_data) {

                    // 2. Fail - Prepare XML Data.
                    if (false === xml_data.success) {
                        AstraSitesAdmin._log(xml_data);
                        AstraSitesAdmin._importFailMessage(xml_data.data);
                        AstraSitesAdmin._log(xml_data.data);

                    } else {

                        // 2. Pass - Prepare XML Data.
                        AstraSitesAdmin._log(astraSitesAdmin.log.importXMLPrepareSuccess);

                        // Import XML though Event Source.
                        AstraSSEImport.data = xml_data.data;
                        AstraSSEImport.render();

                        AstraSitesAdmin._log(astraSitesAdmin.log.importXML);
                        $('.button-hero.astra-demo-import').text(astraSitesAdmin.log.importingXML);

                        var evtSource = new EventSource(AstraSSEImport.data.url);
                        evtSource.onmessage = function (message) {
                            var data = JSON.parse(message.data);
                            switch (data.action) {
                                case 'updateDelta':
                                    AstraSSEImport.updateDelta(data.type, data.delta);
                                    break;

                                case 'complete':
                                    evtSource.close();

                                    // 2. Pass - Import XML though "Source Event".
                                    AstraSitesAdmin._log(astraSitesAdmin.log.importXMLSuccess);
                                    AstraSitesAdmin._log('----- SSE - XML import Complete -----');

                                    $(document).trigger('astra-sites-import-xml-done');

                                    break;
                            }
                        };
                        evtSource.addEventListener('log', function (message) {
                            var data = JSON.parse(message.data);
                            AstraSitesAdmin._log(data.level + ' ' + data.message);
                        });
                    }
                });
        },

        /**
         * 1. Import Customizer Options.
         */
        _importCustomizerSettings: function (event) {

            $.ajax({
                url: astraSitesAdmin.ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'astra-sites-import-customizer-settings',
                    customizer_data: AstraSitesAdmin.customizer_data,
                },
                beforeSend: function () {
                    AstraSitesAdmin._log(astraSitesAdmin.log.importCustomizer);
                    $('.button-hero.astra-demo-import').text(astraSitesAdmin.log.importingCustomizer);
                },
            })
                .fail(function (jqXHR) {
                    AstraSitesAdmin._importFailMessage(jqXHR.status + ' ' + jqXHR.responseText);
                    AstraSitesAdmin._log(jqXHR.status + ' ' + jqXHR.responseText);
                })
                .done(function (customizer_data) {

                    // 1. Fail - Import Customizer Options.
                    if (false === customizer_data.success) {
                        AstraSitesAdmin._importFailMessage(customizer_data.data);
                        AstraSitesAdmin._log(customizer_data.data);
                    } else {

                        // 1. Pass - Import Customizer Options.
                        AstraSitesAdmin._log(astraSitesAdmin.log.importCustomizerSuccess);

                        $(document).trigger('astra-sites-import-customizer-settings-done');
                    }
                });
        },

        /**
         * Import Success Button.
         *
         * @param  {string} data Error message.
         */
        _importSuccessMessage: function () {

            $('.astra-demo-import').removeClass('updating-message installing')
                .removeAttr('data-import')
                .addClass('view-site')
                .removeClass('astra-demo-import')
                .text(astraSitesAdmin.strings.viewSite)
                .attr('target', '_blank')
                .append('<i class="dashicons dashicons-external"></i>')
                .attr('href', astraSitesAdmin.siteURL);
        },

        /**
         * Preview Device
         */
        _previewDevice: function (event) {
            var device = $(event.currentTarget).data('device');

            $('.theme-install-overlay')
                .removeClass('preview-desktop preview-tablet preview-mobile')
                .addClass('preview-' + device)
                .data('current-preview-device', device);

            AstraSitesAdmin._tooglePreviewDeviceButtons(device);
        },

        /**
         * Toggle Preview Buttons
         */
        _tooglePreviewDeviceButtons: function (newDevice) {
            var $devices = $('.wp-full-overlay-footer .devices');

            $devices.find('button')
                .removeClass('active')
                .attr('aria-pressed', false);

            $devices.find('button.preview-' + newDevice)
                .addClass('active')
                .attr('aria-pressed', true);
        },

        /**
         * Import Error Button.
         *
         * @param  {string} data Error message.
         */
        _importFailMessage: function (message, from) {

            $('.astra-demo-import')
                .addClass('go-pro button-primary')
                .removeClass('updating-message installing')
                .removeAttr('data-import')
                .attr('target', '_blank')
                .append('<i class="dashicons dashicons-external"></i>')
                .removeClass('astra-demo-import');

            // Add the doc link due to import log file not generated.
            if ('undefined' === from) {

                $('.wp-full-overlay-header .go-pro').text(astraSitesAdmin.strings.importFailedBtnSmall);
                $('.wp-full-overlay-footer .go-pro').text(astraSitesAdmin.strings.importFailedBtnLarge);
                $('.go-pro').attr('href', astraSitesAdmin.log.serverConfiguration);

                // Add the import log file link.
            } else {

                $('.wp-full-overlay-header .go-pro').text(astraSitesAdmin.strings.importFailBtn);
                $('.wp-full-overlay-footer .go-pro').text(astraSitesAdmin.strings.importFailBtnLarge)

                // Add the import log file link.
                if ('undefined' !== AstraSitesAdmin.log_file_url) {
                    $('.go-pro').attr('href', AstraSitesAdmin.log_file_url);
                } else {
                    $('.go-pro').attr('href', astraSitesAdmin.log.serverConfiguration);
                }
            }

            var output = '<div class="astra-api-error notice notice-error notice-alt is-dismissible">';
            output += '	<p>' + message + '</p>';
            output += '	<button type="button" class="notice-dismiss">';
            output += '		<span class="screen-reader-text">' + commonL10n.dismiss + '</span>';
            output += '	</button>';
            output += '</div>';

            // Fail Notice.
            $('.install-theme-info').append(output);


            // !important to add trigger.
            // Which reinitialize the dismiss error message events.
            $(document).trigger('wp-updates-notice-added');
        },


        /**
         * Install Now
         */
        _installNow: function (event) {
            event.preventDefault();

            var $button = jQuery(event.target),
                $document = jQuery(document);

            if ($button.hasClass('updating-message') || $button.hasClass('button-disabled')) {
                return;
            }

            if (wp.updates.shouldRequestFilesystemCredentials && !wp.updates.ajaxLocked) {
                wp.updates.requestFilesystemCredentials(event);

                $document.on('credential-modal-cancel', function () {
                    var $message = $('.install-now.updating-message');

                    $message
                        .removeClass('updating-message')
                        .text(wp.updates.l10n.installNow);

                    wp.a11y.speak(wp.updates.l10n.updateCancel, 'polite');
                });
            }

            AstraSitesAdmin._log(astraSitesAdmin.log.installingPlugin + ' ' + $button.data('slug'));

            wp.updates.installPlugin({
                slug: $button.data('slug')
            });
        },

        /**
         * Install Success
         */
        _installSuccess: function (event, response) {

            event.preventDefault();

            AstraSitesAdmin._log(astraSitesAdmin.log.installed + ' ' + response.slug);

            var $message = jQuery('.plugin-card-' + response.slug).find('.button');
            var $siteOptions = jQuery('.wp-full-overlay-header').find('.astra-site-options').val();
            var $enabledExtensions = jQuery('.wp-full-overlay-header').find('.astra-enabled-extensions').val();

            // Transform the 'Install' button into an 'Activate' button.
            var $init = $message.data('init');

            $message.removeClass('install-now installed button-disabled updated-message')
                .addClass('updating-message')
                .html(astraSitesAdmin.strings.btnActivating);

            // Reset not installed plugins list.
            var pluginsList = astraSitesAdmin.requiredPlugins.notinstalled;
            astraSitesAdmin.requiredPlugins.notinstalled = AstraSitesAdmin._removePluginFromQueue(response.slug, pluginsList);

            // WordPress adds "Activate" button after waiting for 1000ms. So we will run our activation after that.
            setTimeout(function () {

                $.ajax({
                    url: astraSitesAdmin.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'tci_method',
                        subaction: 'tci_required_plugin_active',
                        init: $init,
                        options: $siteOptions,
                        enabledExtensions: $enabledExtensions,
                    },
                })
                    .done(function (result) {

                        if (result.success) {

                            var pluginsList = astraSitesAdmin.requiredPlugins.inactive;

                            // Reset not installed plugins list.
                            astraSitesAdmin.requiredPlugins.inactive = AstraSitesAdmin._removePluginFromQueue(response.slug, pluginsList);

                            $message.removeClass('button-primary install-now activate-now updating-message')
                                .attr('disabled', 'disabled')
                                .addClass('disabled')
                                .text(astraSitesAdmin.strings.btnActive);

                            // Enable Demo Import Button
                            AstraSitesAdmin._enable_demo_import_button();

                        } else {

                            $message.removeClass('updating-message');

                        }

                    });

            }, 1200);

        },

        /**
         * Plugin Installation Error.
         */
        _installError: function (event, response) {

            var $card = jQuery('.plugin-card-' + response.slug);

            AstraSitesAdmin._log(response.errorMessage + ' ' + response.slug);

            $card
                .removeClass('button-primary')
                .addClass('disabled')
                .html(wp.updates.l10n.installFailedShort);

            AstraSitesAdmin._importFailMessage(response.errorMessage);
        },

        /**
         * Installing Plugin
         */
        _pluginInstalling: function (event, args) {
            event.preventDefault();

            var $card = jQuery('.plugin-card-' + args.slug);
            var $button = $card.find('.button');

            AstraSitesAdmin._log(astraSitesAdmin.log.installingPlugin + ' ' + args.slug);

            $card.addClass('updating-message');
            $button.addClass('already-started');

        },

        /**
         * Render Demo Preview
         */
        _activateNow: function (eventn) {

            event.preventDefault();

            var $button = jQuery(event.target),
                $init = $button.data('init'),
                $slug = $button.data('slug');

            if ($button.hasClass('updating-message') || $button.hasClass('button-disabled')) {
                return;
            }

            AstraSitesAdmin._log(astraSitesAdmin.log.activating + ' ' + $slug);

            $button.addClass('updating-message button-primary')
                .html(astraSitesAdmin.strings.btnActivating);

            var $siteOptions = jQuery('.wp-full-overlay-header').find('.astra-site-options').val();
            var $enabledExtensions = jQuery('.wp-full-overlay-header').find('.astra-enabled-extensions').val();

            $.ajax({
                url: astraSitesAdmin.ajaxurl,
                type: 'POST',
                data: {
                    action: 'tci_method',
                    subaction: 'tci_required_plugin_active',
                    init: $init,
                    options: $siteOptions,
                    enabledExtensions: $enabledExtensions,
                },
            })
                .done(function (result) {

                    if (result.success) {

                        AstraSitesAdmin._log(astraSitesAdmin.log.activated + ' ' + $slug);

                        var pluginsList = astraSitesAdmin.requiredPlugins.inactive;

                        // Reset not installed plugins list.
                        astraSitesAdmin.requiredPlugins.inactive = AstraSitesAdmin._removePluginFromQueue($slug, pluginsList);

                        $button.removeClass('button-primary install-now activate-now updating-message')
                            .attr('disabled', 'disabled')
                            .addClass('disabled')
                            .text(astraSitesAdmin.strings.btnActive);

                        // Enable Demo Import Button
                        AstraSitesAdmin._enable_demo_import_button();

                    }

                })
                .fail(function () {
                });

        },

        /**
         * Full Overlay
         */
        _fullOverlay: function (event) {
            event.preventDefault();

            jQuery('.theme-install-overlay').css('display', 'none');
            jQuery('.theme-install-overlay').remove();
            jQuery('.theme-preview-on').removeClass('theme-preview-on');
            jQuery('html').removeClass('astra-site-preview-on');
        },

        /**
         * Bulk Plugin Active & Install
         */
        _bulkPluginInstallActivate: function () {
            if (0 === astraSitesAdmin.requiredPlugins.length) {
                return;
            }

            jQuery('.required-plugins')
                .find('.install-now')
                .addClass('updating-message')
                .removeClass('install-now')
                .text(wp.updates.l10n.installing);

            jQuery('.required-plugins')
                .find('.activate-now')
                .addClass('updating-message')
                .removeClass('activate-now')
                .html(astraSitesAdmin.strings.btnActivating);

            var not_installed = astraSitesAdmin.requiredPlugins.notinstalled || '';
            var activate_plugins = astraSitesAdmin.requiredPlugins.inactive || '';

            // First Install Bulk.
            if (not_installed.length > 0) {
                AstraSitesAdmin._installAllPlugins(not_installed);
            }

            // Second Activate Bulk.
            if (activate_plugins.length > 0) {
                AstraSitesAdmin._activateAllPlugins(activate_plugins);
            }

        },

        /**
         * Activate All Plugins.
         */
        _activateAllPlugins: function (activate_plugins) {

            // Activate ALl Plugins.
            AstraSitesAjaxQueue.stop();
            AstraSitesAjaxQueue.run();

            AstraSitesAdmin._log(astraSitesAdmin.log.bulkActivation);

            $.each(activate_plugins, function (index, single_plugin) {

                var $card = jQuery('.plugin-card-' + single_plugin.slug),
                    $button = $card.find('.button'),
                    $siteOptions = jQuery('.wp-full-overlay-header').find('.astra-site-options').val(),
                    $enabledExtensions = jQuery('.wp-full-overlay-header').find('.astra-enabled-extensions').val();

                $button.addClass('updating-message');

                AstraSitesAjaxQueue.add({
                    url: astraSitesAdmin.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'tci_method',
                        subaction: 'tci_required_plugin_active',
                        init: single_plugin.init,
                        options: $siteOptions,
                        enabledExtensions: $enabledExtensions,
                    },
                    success: function (result) {

                        if (result.success) {

                            AstraSitesAdmin._log(astraSitesAdmin.log.activate + ' ' + single_plugin.slug);

                            var $card = jQuery('.plugin-card-' + single_plugin.slug);
                            var $button = $card.find('.button');
                            if (!$button.hasClass('already-started')) {
                                var pluginsList = astraSitesAdmin.requiredPlugins.inactive;

                                // Reset not installed plugins list.
                                astraSitesAdmin.requiredPlugins.inactive = AstraSitesAdmin._removePluginFromQueue(single_plugin.slug, pluginsList);
                            }

                            $button.removeClass('button-primary install-now activate-now updating-message')
                                .attr('disabled', 'disabled')
                                .addClass('disabled')
                                .text(astraSitesAdmin.strings.btnActive);

                            // Enable Demo Import Button
                            AstraSitesAdmin._enable_demo_import_button();
                        } else {
                            AstraSitesAdmin._log(astraSitesAdmin.log.activationError + ' - ' + single_plugin.slug);
                        }
                    }
                });
            });
        },

        /**
         * Install All Plugins.
         */
        _installAllPlugins: function (not_installed) {

            AstraSitesAdmin._log(astraSitesAdmin.log.bulkInstall);

            $.each(not_installed, function (index, single_plugin) {

                var $card = jQuery('.plugin-card-' + single_plugin.slug),
                    $button = $card.find('.button');

                if (!$button.hasClass('already-started')) {

                    // Add each plugin activate request in Ajax queue.
                    // @see wp-admin/js/updates.js
                    wp.updates.queue.push({
                        action: 'install-plugin', // Required action.
                        data: {
                            slug: single_plugin.slug
                        }
                    });
                }
            });

            // Required to set queue.
            wp.updates.queueChecker();
        },

        /**
         * Fires when a nav item is clicked.
         *
         * @since 1.0
         * @access private
         * @method _importDemo
         */
        _importDemo: function () {
            var $this = jQuery(this),
                $theme = $this.closest('.astra-sites-preview').find('.wp-full-overlay-header'),
                apiURL = $theme.data('demo-api') || '',
                plugins = $theme.data('required-plugins');

            var disabled = $this.attr('data-import');

            if (typeof disabled !== 'undefined' && disabled === 'disabled' || $this.hasClass('disabled')) {

                $('.astra-demo-import').addClass('updating-message installing')
                    .text(wp.updates.l10n.installing);

                /**
                 * Process Bulk Plugin Install & Activate
                 */
                AstraSitesAdmin._bulkPluginInstallActivate();

                return;
            }

            // Proceed?
            if (!confirm(astraSitesAdmin.strings.importWarning)) {
                return;
            }

            // Remove all notices before import start.
            $('.install-theme-info > .notice').remove();

            $('.astra-demo-import').attr('data-import', 'disabled')
                .addClass('updating-message installing')
                .text(astraSitesAdmin.strings.importingDemo);

            $this.closest('.theme').focus();

            var $theme = $this.closest('.astra-sites-preview').find('.wp-full-overlay-header');

            var apiURL = apiURL;

            // Site Import by API URL.
            if (apiURL) {
                AstraSitesAdmin._importSite(apiURL);
            }

        },

        /**
         * Start Import Process by API URL.
         *
         * @param  {string} apiURL Site API URL.
         */
        _importSite: function (apiURL) {

            AstraSitesAdmin._log(astraSitesAdmin.log.api + ' : ' + apiURL);
            AstraSitesAdmin._log(astraSitesAdmin.log.importing);

            AstraSitesAdmin._log(astraSitesAdmin.log.processingRequest);

            // 1. Request Site Import
            $.ajax({
                url: astraSitesAdmin.ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'tci_method',
                    subaction: 'tci_demo_import',
                    api_url: apiURL,
                },
                success: function(demo_data){

                    if (demo_data.success == 'done') {
                        //alert(AstraSitesAdmin._log(astraSitesAdmin.log.importComplete));
                        $('.button.astra-demo-import').removeClass('updating-message');
                        $('.button.astra-demo-import').removeClass('installing');
                        $('.button.astra-demo-import').text(astraSitesAdmin.log.importComplete);

                    } else {
                        AstraSitesAdmin._importFailMessage(demo_data.data);
                    }
                }
            }).fail(function (jqXHR) {
                AstraSitesAdmin._importFailMessage(jqXHR.status + ' ' + jqXHR.responseText);
                AstraSitesAdmin._log(jqXHR.status + ' ' + jqXHR.responseText);
            });

        },

        /**
         * Collapse Sidebar.
         */
        _collapse: function () {
            event.preventDefault();

            overlay = jQuery('.wp-full-overlay');

            if (overlay.hasClass('expanded')) {
                overlay.removeClass('expanded');
                overlay.addClass('collapsed');
                return;
            }

            if (overlay.hasClass('collapsed')) {
                overlay.removeClass('collapsed');
                overlay.addClass('expanded');
                return;
            }
        },

        /**
         * Previous Theme.
         */
        _previousTheme: function (event) {
            event.preventDefault();

            currentDemo = jQuery('.theme-preview-on');
            currentDemo.removeClass('theme-preview-on');
            prevDemo = currentDemo.prev('.theme');
            prevDemo.addClass('theme-preview-on');

            AstraSitesAdmin._renderDemoPreview(prevDemo);
        },

        /**
         * Next Theme.
         */
        _nextTheme: function (event) {
            event.preventDefault();
            currentDemo = jQuery('.theme-preview-on')
            currentDemo.removeClass('theme-preview-on');
            nextDemo = currentDemo.next('.theme');
            nextDemo.addClass('theme-preview-on');

            AstraSitesAdmin._renderDemoPreview(nextDemo);
        },

        /**
         * Individual Site Preview
         *
         * On click on image, more link & preview button.
         */
        _preview: function (event) {

            event.preventDefault();

            var self = jQuery(this).parents('.theme');
            self.addClass('theme-preview-on');

            jQuery('html').addClass('astra-site-preview-on');

            AstraSitesAdmin._renderDemoPreview(self);
        },

        /**
         * Check Next Previous Buttons.
         */
        _checkNextPrevButtons: function () {
            currentDemo = jQuery('.theme-preview-on');
            nextDemo = currentDemo.nextAll('.theme').length;
            prevDemo = currentDemo.prevAll('.theme').length;

            if (nextDemo == 0) {
                jQuery('.next-theme').addClass('disabled');
            } else if (nextDemo != 0) {
                jQuery('.next-theme').removeClass('disabled');
            }

            if (prevDemo == 0) {
                jQuery('.previous-theme').addClass('disabled');
            } else if (prevDemo != 0) {
                jQuery('.previous-theme').removeClass('disabled');
            }

            return;
        },

        /**
         * Render Demo Preview
         */
        _renderDemoPreview: function (anchor) {

            var demoId = anchor.data('id') || '',
                apiURL = anchor.data('demo-api') || '',
                demoType = anchor.data('demo-type') || '',
                demoURL = anchor.data('demo-url') || '',
                screenshot = anchor.data('screenshot') || '',
                demo_name = anchor.data('demo-name') || '',
                demo_slug = anchor.data('demo-slug') || '',
                content = anchor.data('content') || '',
                requiredPlugins = anchor.data('required-plugins') || '',
                astraSiteOptions = anchor.find('.astra-site-options').val() || '';
            astraEnabledExtensions = anchor.find('.astra-enabled-extensions').val() || '';

            AstraSitesAdmin._log(astraSitesAdmin.log.preview + ' "' + demo_name + '" URL : ' + demoURL);

            var template = wp.template('tci-site-preview');

            templateData = [{
                id: demoId,
                astra_demo_type: demoType,
                astra_demo_url: demoURL,
                demo_api: apiURL,
                screenshot: screenshot,
                demo_name: demo_name,
                slug: demo_slug,
                content: content,
                required_plugins: JSON.stringify(requiredPlugins),
                astra_site_options: astraSiteOptions,
                astra_enabled_extensions: astraEnabledExtensions,
            }];

            // delete any earlier fullscreen preview before we render new one.
            jQuery('.theme-install-overlay').remove();

            jQuery('#astra-sites-menu-page').append(template(templateData[0]));
            jQuery('.theme-install-overlay').css('display', 'block');
            AstraSitesAdmin._checkNextPrevButtons();

            var desc = jQuery('.theme-details');
            var descHeight = parseInt(desc.outerHeight());
            var descBtn = jQuery('.theme-details-read-more');

            if ($.isArray(requiredPlugins)) {

                if (descHeight >= 55) {

                    // Show button.
                    descBtn.css('display', 'inline-block');

                    // Set height upto 3 line.
                    desc.css('height', 57);

                    // Button Click.
                    descBtn.click(function (event) {

                        if (descBtn.hasClass('open')) {
                            desc.animate({height: 57},
                                300, function () {
                                    descBtn.removeClass('open');
                                    descBtn.html(astraSitesAdmin.strings.DescExpand);
                                });
                        } else {
                            desc.animate({height: descHeight},
                                300, function () {
                                    descBtn.addClass('open');
                                    descBtn.html(astraSitesAdmin.strings.DescCollapse);
                                });
                        }

                    });
                }

                // or
                var $pluginsFilter = jQuery('#plugin-filter'),
                    data = {
                        action: 'tci_method',
                        subaction: 'tci_required_plugin',
                        _ajax_nonce: astraSitesAdmin._ajax_nonce,
                        required_plugins: requiredPlugins
                    };

                // Add disabled class from import button.
                $('.astra-demo-import')
                    .addClass('disabled not-click-able')
                    .removeAttr('data-import');

                jQuery('.required-plugins').addClass('loading').html('<span class="spinner is-active"></span>');

                // Required Required.
                $.ajax({
                    url: astraSitesAdmin.ajaxurl,
                    type: 'POST',
                    data: data,
                })
                    .fail(function (jqXHR) {

                        // Remove loader.
                        jQuery('.required-plugins').removeClass('loading').html('');

                        AstraSitesAdmin._importFailMessage(jqXHR.status + ' ' + jqXHR.responseText, 'plugins');
                        AstraSitesAdmin._log(jqXHR.status + ' ' + jqXHR.responseText);
                    })
                    .done(function (response) {

                        // Release disabled class from import button.
                        $('.astra-demo-import')
                            .removeClass('disabled not-click-able')
                            .attr('data-import', 'disabled');

                        // Remove loader.
                        jQuery('.required-plugins').removeClass('loading').html('');

                        /**
                         * Count remaining plugins.
                         * @type number
                         */
                        var remaining_plugins = 0;

                        /**
                         * Not Installed
                         *
                         * List of not installed required plugins.
                         */
                        if (typeof response.data.notinstalled !== 'undefined') {

                            // Add not have installed plugins count.
                            remaining_plugins += parseInt(response.data.notinstalled.length);

                            jQuery(response.data.notinstalled).each(function (index, plugin) {

                                var output = '<div class="plugin-card ';
                                output += ' 		plugin-card-' + plugin.slug + '"';
                                output += ' 		data-slug="' + plugin.slug + '"';
                                output += ' 		data-init="' + plugin.init + '">';
                                output += '	<span class="title">' + plugin.name + '</span>';
                                output += '	<button class="button install-now"';
                                output += '			data-init="' + plugin.init + '"';
                                output += '			data-slug="' + plugin.slug + '"';
                                output += '			data-name="' + plugin.name + '">';
                                output += wp.updates.l10n.installNow;
                                output += '	</button>';
                                // output += '	<span class="dashicons-no dashicons"></span>';
                                output += '</div>';

                                jQuery('.required-plugins').append(output);

                            });
                        }

                        /**
                         * Inactive
                         *
                         * List of not inactive required plugins.
                         */
                        if (typeof response.data.inactive !== 'undefined') {

                            // Add inactive plugins count.
                            remaining_plugins += parseInt(response.data.inactive.length);

                            jQuery(response.data.inactive).each(function (index, plugin) {

                                var output = '<div class="plugin-card ';
                                output += ' 		plugin-card-' + plugin.slug + '"';
                                output += ' 		data-slug="' + plugin.slug + '"';
                                output += ' 		data-init="' + plugin.init + '">';
                                output += '	<span class="title">' + plugin.name + '</span>';
                                output += '	<button class="button activate-now button-primary"';
                                output += '		data-init="' + plugin.init + '"';
                                output += '		data-slug="' + plugin.slug + '"';
                                output += '		data-name="' + plugin.name + '">';
                                output += wp.updates.l10n.activatePlugin;
                                output += '	</button>';
                                // output += '	<span class="dashicons-no dashicons"></span>';
                                output += '</div>';

                                jQuery('.required-plugins').append(output);

                            });
                        }

                        /**
                         * Active
                         *
                         * List of not active required plugins.
                         */
                        if (typeof response.data.active !== 'undefined') {

                            jQuery(response.data.active).each(function (index, plugin) {

                                var output = '<div class="plugin-card ';
                                output += ' 		plugin-card-' + plugin.slug + '"';
                                output += ' 		data-slug="' + plugin.slug + '"';
                                output += ' 		data-init="' + plugin.init + '">';
                                output += '	<span class="title">' + plugin.name + '</span>';
                                output += '	<button class="button disabled"';
                                output += '			data-slug="' + plugin.slug + '"';
                                output += '			data-name="' + plugin.name + '">';
                                output += astraSitesAdmin.strings.btnActive;
                                output += '	</button>';
                                // output += '	<span class="dashicons-yes dashicons"></span>';
                                output += '</div>';

                                jQuery('.required-plugins').append(output);

                            });
                        }

                        /**
                         * Enable Demo Import Button
                         * @type number
                         */
                        astraSitesAdmin.requiredPlugins = response.data;
                        AstraSitesAdmin._enable_demo_import_button();

                    });

            } else {

                // Enable Demo Import Button
                AstraSitesAdmin._enable_demo_import_button(demoType);
                jQuery('.required-plugins-wrap').remove();
            }

            return;
        },

        /**
         * Enable Demo Import Button.
         */
        _enable_demo_import_button: function (type) {

            type = (undefined !== type) ? type : 'free';

            switch (type) {

                case 'free':
                case 'Free':
                    var all_buttons = parseInt(jQuery('.plugin-card .button').length) || 0,
                        disabled_buttons = parseInt(jQuery('.plugin-card .button.disabled').length) || 0;

                    if (all_buttons === disabled_buttons) {

                        jQuery('.astra-demo-import')
                            .removeAttr('data-import')
                            .removeClass('installing updating-message')
                            .addClass('button-primary')
                            .text(astraSitesAdmin.strings.importDemo);
                    }

                    break;

                /* case 'upgrade':
                     var demo_slug = jQuery('.wp-full-overlay-header').attr('data-demo-slug');

                     jQuery('.astra-demo-import')
                         .addClass('go-pro button-primary')
                         .removeClass('astra-demo-import')
                         .attr('target', '_blank')
                         .attr('href', astraSitesAdmin.getUpgradeURL + demo_slug)
                         .text(astraSitesAdmin.getUpgradeText)
                         .append('<i class="dashicons dashicons-external"></i>');
                     break;

                 default:
                     var demo_slug = jQuery('.wp-full-overlay-header').attr('data-demo-slug');

                     jQuery('.astra-demo-import')
                         .addClass('go-pro button-primary')
                         .removeClass('astra-demo-import')
                         .attr('target', '_blank')
                         .attr('href', astraSitesAdmin.getProURL)
                         .text(astraSitesAdmin.getProText)
                         .append('<i class="dashicons dashicons-external"></i>');
                     break;*/
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

            $('body').addClass('loading-content');
            $('body').attr('data-astra-demo-last-request', '1');
            $('body').attr('data-astra-demo-paged', '1');
            $('body').attr('data-astra-demo-search', '');
            $('body').attr('data-scrolling', false);

        },

        /**
         * Remove plugin from the queue.
         */
        _removePluginFromQueue: function (removeItem, pluginsList) {
            return jQuery.grep(pluginsList, function (value) {
                return value.slug != removeItem;
            });
        }

    };

    /**
     * Initialize AstraSitesAdmin
     */
    $(function () {
        AstraSitesAdmin.init();
    });

})(jQuery);
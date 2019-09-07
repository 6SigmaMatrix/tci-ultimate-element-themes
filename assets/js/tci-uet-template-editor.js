(function ($) {
    'use strict';

    var TCI_UET_Editor_Template,
        TCI_UET_Eidtor_Views,
        TCI_UET_Modules,
        TCI_UET_Controls_Views;

    TCI_UET_Eidtor_Views = {

        Modal_Layout_View: null,
        Modal_Header_View: null,
        Modal_Header_Insert_Button: null,
        Modal_Loading_View: null,
        Modal_Body_View: null,
        Modal_Error_View: null,
        Library_Collection: null,
        Keywords_Model: null,
        Modal_Collection_View: null,
        Modal_Tabs_Collection: null,
        Modal_Tabs_Collection_View: null,
        Filters_Collection_View: null,
        Filters_Item_View: null,
        Modal_Tabs_Item_View: null,
        Modal_Template_Item_View: null,
        Modal_Insert_Template_Behavior: null,
        Modal_Template_Model: null,
        Categories_Collection: null,
        Modal_Preview_View: null,
        Modal_Header_Back: null,
        Modal_Header_Logo: null,
        Keywords_View: null,
        Tab_Model: null,
        Category_Model: null,

        init: function () {
            var self = this;

            self.Modal_Header_View = Marionette.LayoutView.extend({

                id: 'tci-uet-template-modal-header',
                template: '#tmpl-tci-uet-header',
                ui: {
                    closeModal: '#tci-uet-template-modal-header-close-modal'
                },
                events: {
                    'click @ui.closeModal': 'onCloseModalClick'
                },
                regions: {
                    headerLogo: '#tci-uet-template-modal-header-logo-area',
                    headerTabs: '#tci-uet-template-modal-header-tabs',
                    headerActions: '#tci-uet-template-modal-header-actions'
                },
                onCloseModalClick: function () {
                    TCI_UET_Editor_Template.close_TCI_UET_Module();
                }

            });

            self.Modal_Layout_View = Marionette.LayoutView.extend({
                el: "#tci-uet-template-module",
                regions: tci_uet_localize.modalRegions,
                initialize: function () {
                    this.getRegion('modalHeader').show(new self.Modal_Header_View());
                    this.listenTo(TCI_UET_Editor_Template.channels.tabs, 'filter:change', this.switch_tabs);
                    this.listenTo(TCI_UET_Editor_Template.channels.layout, 'preview:change', this.switch_preview);

                },

                switch_tabs: function () {
                    this.show_loading_view();
                    TCI_UET_Editor.set_TCI_UET_Filter('keyword', '');
                    TCI_UET_Editor.request_TCI_UET_Templates(TCI_UET_Editor.get_TCI_UET_Tab());
                },

                switch_preview: function () {

                    var header = this.getHeaderView(),
                        preview = TCI_UET_Editor.get_TCI_UET_Preview();

                    var filter = TCI_UET_Editor.get_TCI_UET_Filter('category'),
                        keyword = TCI_UET_Editor.get_TCI_UET_Filter('keyword');

                    if ('back' === preview) {
                        header.headerLogo.show(new self.Modal_Header_Logo());
                        header.headerTabs.show(new self.Modal_Tabs_Collection_View({
                            collection: TCI_UET_Editor.collections.tabs
                        }));

                        header.headerActions.empty();
                        TCI_UET_Editor.set_TCI_UET_Tab(TCI_UET_Editor.get_TCI_UET_Tab());

                        if ('' != filter) {
                            TCI_UET_Editor.set_TCI_UET_Filter('category', filter);
                            jQuery('#tci-uet-modal-filters-container').find("input[value='" + filter + "']").prop('checked', true);

                        }

                        if ('' != keyword) {
                            TCI_UET_Editor.setFilter('keyword', keyword);
                        }

                        return;
                    }

                    if ('initial' === preview) {
                        header.headerActions.empty();
                        header.headerLogo.show(new self.Modal_Header_Logo());
                        return;
                    }

                    this.getRegion('modalContent').show(new self.Modal_Preview_View({
                        'preview': preview.get('preview'),
                        'url': preview.get('url'),
                        'notice': preview.get('notice')
                    }));

                    header.headerLogo.empty();
                    header.headerTabs.show(new self.Modal_Header_Back());
                    header.headerActions.show(new self.Modal_Header_Insert_Button({
                        model: preview
                    }));

                },
                get_header_view: function () {
                    return this.getRegion('modalHeader').currentView;
                },
                get_content_view: function () {
                    return this.getRegion('modalContent').currentView;
                },
                show_loading_view: function () {
                    this.modalContent.show(new self.Modal_Loading_View());
                },
            });

            self.Modal_Loading_View = Marionette.ItemView.extend({
                id: 'tci-uet-template-modal-loading',
                template: '#tmpl-tci-uet-loading'
            });

            self.Modal_Header_Insert_Button = Marionette.ItemView.extend({

                template: '#tmpl-tci-uet-insert-button',
                id: 'tci-uet-template-modal-insert-button',
                behaviors: {
                    insertTemplate: {
                        behaviorClass: self.Modal_Insert_Template_Behavior
                    }
                }

            });

            self.Modal_Insert_Template_Behavior = Marionette.Behavior.extend({
                ui: {
                    insertButton: '.tci-uet-template-insert'
                },

                events: {
                    'click @ui.insertButton': 'onInsertButtonClick'
                },

                onInsertButtonClick: function () {

                    var templateModel = this.view.model,
                        innerTemplates = templateModel.attributes.dependencies,
                        isPro = templateModel.attributes.pro,
                        innerTemplatesLength = Object.keys(innerTemplates).length,
                        options = {};

                    TCI_UET_Editor.layout.showLoadingView();
                    if (innerTemplatesLength > 0) {
                        for (var key in innerTemplates) {
                            $.ajax({
                                url: ajaxurl,
                                type: 'post',
                                dataType: 'json',
                                data: {
                                    action: 'premium_inner_template',
                                    template: innerTemplates[key],
                                    tab: TCI_UET_Editor.get_TCI_UET_Tab()
                                }
                            });
                        }
                    }

                    if ("valid" === PremiumTempsData.license.status || !isPro) {

                        elementor.templates.request_TemplateContent(
                            templateModel.get('source'),
                            templateModel.get('template_id'),
                            {
                                data: {
                                    tab: TCI_UET_Editor.get_TCI_UET_Tab(),
                                    page_settings: false
                                },
                                success: function (data) {

                                    if (!data.license) {
                                        TCI_UET_Editor.layout.showLicenseError();
                                        return;
                                    }

                                    console.log("%c Template Inserted Successfully!!", "color: #7a7a7a; background-color: #eee;");

                                    TCI_UET_Editor.closeModal();

                                    elementor.channels.data.trigger('template:before:insert', templateModel);

                                    if (null !== TCI_UET_Editor.atIndex) {
                                        options.at = TCI_UET_Editor.atIndex;
                                    }

                                    elementor.sections.currentView.addChildModel(data.content, options);

                                    elementor.channels.data.trigger('template:after:insert', templateModel);

                                    TCI_UET_Editor.atIndex = null;

                                },
                                error: function (err) {
                                    console.log(err);
                                }
                            }
                        );
                    } else {
                        PremiumEditor.layout.showLicenseError();
                    }
                }
            });

            self.Library_Collection = Backbone.Collection.extend({
                model: self.Modal_Template_Model
            });

            self.Modal_Template_Model = Backbone.Model.extend({
                defaults: {
                    template_id: 0,
                    name: '',
                    title: '',
                    thumbnail: '',
                    preview: '',
                    source: '',
                    categories: [],
                    keywords: []
                }
            });

            self.Category_Model = Backbone.Model.extend({
                defaults: {
                    slug: '',
                    title: ''
                }
            });
        }
    }

    TCI_UET_Editor_Template = {

        modal: false,
        layout: false,
        collections: {},
        tabs: {},
        defaultTab: '',
        channels: {},
        atIndex: null,

        init: function () {

            window.elementor.on("preview:loaded", window._.bind(TCI_UET_Editor_Template.on_TCI_UET_Preview_Load, TCI_UET_Editor_Template));
            TCI_UET_Eidtor_Views.init();
            TCI_UET_Controls_Views.init();
            TCI_UET_Modules.init();

        },

        on_TCI_UET_Preview_Load: function () {

            this.init_TCI_UET_Template_Button();
            window.elementor.$previewContents.on('click.addPremiumTemplate', '.tci-uet-add-section-button', _.bind(this.show_TCI_UET_Template_Module, this));

            this.channels = {
                templates: Backbone.Radio.channel('TCI_UET_EDITOR:templates'),
                tabs: Backbone.Radio.channel('TCI_UET_EDITOR:tabs'),
                layout: Backbone.Radio.channel('TCI_UET_EDITOR:layout'),
            };

            // this.tabs = PremiumTempsData.tabs;
            // this.defaultTab = PremiumTempsData.defaultTab;
        },

        init_TCI_UET_Template_Button: function () {

            var $addNewSection = window.elementor.$previewContents.find('.elementor-add-new-section'),
                add_tci_uet_temp_button = "<div class='elementor-add-section-area-button tci-uet-add-section-button' title='Add TCI UET Template'><i class='fa fa-paw'></i></div>",
                $add_TCI_UET_Template;

            if ($addNewSection.length >= 1) {
                $add_TCI_UET_Template = $(add_tci_uet_temp_button).prependTo($addNewSection);
                //console.log($add_TCI_UET_Template);
            }

            window.elementor.$previewContents.on(
                "click.add_TCI_UET_Template",
                ".elementor-editor-section-settings .elementor-editor-element-add",
                function () {
                    console.log(add_TCI_UET_Template);
                    var $this = $(this);
                });

        },

        show_TCI_UET_Template_Module: function () {
            /**
             * Show module.
             * */
            this.get_TCI_UET_Module().show();
            /**
             * Check layout exist or not.
             * */
            if (!this.layout) {
                /**
                 * Create layout.
                 * */
                this.layout = new TCI_UET_Eidtor_Views.Modal_Layout_View();
                this.layout.show_loading_view();
            }

            this.set_TCI_UET_Tab(this.defaultTab, true);
            this.request_TCI_UET_Templates(this.defaultTab);
            this.set_TCI_UET_Preview('initial');

        },

        request_TCI_UET_Templates: function (tabName) {

            var self = this,
                tab = self.tabs[tabName];

            self.set_TCI_UET_Filter('category', false);

            if (tab.data.templates && tab.data.categories) {
                self.layout.showTemplatesView(tab.data.templates, tab.data.categories, tab.data.keywords);
            } else {
                $.ajax({
                    url: tci_uet_localize.tci_uet_ajaxurl,
                    type: 'get',
                    dataType: 'json',
                    data: {
                        action: 'tci_uet_ajax_have_method',
                        tab: tabName
                    },
                    success: function (response) {
                        console.log("%cTemplates Retrieved Successfully!!", "color: #7a7a7a; background-color: #eee;");

                        var templates = new TCI_UET_Eidtor_Views.Library_Collection(response.data.templates),
                            categories = new TCI_UET_Eidtor_Views.Categories_Collection(response.data.categories);

                        self.tabs[tabName].data = {
                            templates: templates,
                            categories: categories,
                            keywords: response.data.keywords
                        };

                        self.layout.showTemplatesView(templates, categories, response.data.keywords);

                    }
                });
            }

        },

        get_TCI_UET_Module: function () {
            /**
             * Check module is exist or not.
             * */
            if (!this.modal) {
                /**
                 * Create the module with the help of lightbox popup.
                 * */
                this.modal = elementor.dialogsManager.createWidget("lightbox", {
                    id: "tci-uet-template-module",
                    className: "elementor-templates-modal",
                    closeButton: false
                });
            }

            return this.modal;
        },

        close_TCI_UET_Module: function () {
            /**
             * Close module.
             * */
            this.get_TCI_UET_Module().hide();
        },

        set_TCI_UET_Tab: function (value, silent) {

            this.channels.tabs.reply('filter:tabs', value);

            if (!silent) {
                this.channels.tabs.trigger('filter:change');
            }

        },

        set_TCI_UET_Preview: function (value, silent) {

            this.channels.layout.reply('preview', value);

            if (!silent) {
                this.channels.layout.trigger('preview:change');
            }
        },

        get_TCI_UET_Filter: function (name) {

            return this.channels.templates.request('filter:' + name);
        },

        set_TCI_UET_Filter: function (name, value) {
            this.channels.templates.reply('filter:' + name, value);
            this.channels.templates.trigger('filter:change');
        },

        get_TCI_UET_Tab: function () {
            return this.channels.tabs.request('filter:tabs');
        },

        get_TCI_UET_Preview: function (name) {
            return this.channels.layout.request('preview');
        },

        get_TCI_UET_Keywords: function () {

            var keywords = [];

            _.each(this.keywords, function (title, slug) {
                tabs.push({
                    slug: slug,
                    title: title
                });
            });

            return keywords;
        },

    }

    TCI_UET_Modules = {

        get_TCI_UET_Data_To_Save: function (data) {
            data.id = window.elementor.config.post_id;
            return data;
        },

        init: function () {
            if (window.elementor.settings.premium_template) {
                window.elementor.settings.premium_template.get_TCI_UET_Data_To_Save = this.get_TCI_UET_Data_To_Save;
            }

            if (window.elementor.settings.premium_page) {
                window.elementor.settings.premium_page.get_TCI_UET_Data_To_Save = this.get_TCI_UET_Data_To_Save;
                window.elementor.settings.premium_page.changeCallbacks = {
                    custom_header: function () {
                        this.save(function () {
                            elementor.reloadPreview();

                            elementor.once('preview:loaded', function () {
                                elementor.getPanelView().setPage('premium_page_settings');
                            });
                        });
                    },

                    custom_footer: function () {
                        this.save(function () {
                            elementor.reloadPreview();

                            elementor.once('preview:loaded', function () {
                                elementor.getPanelView().setPage('premium_page_settings');
                            });
                        });
                    }
                };
            }

        }

    };

    TCI_UET_Controls_Views = {

        TCI_UET_Search_View: null,

        init: function () {

            var self = this;

            self.TCI_UET_Search_View = window.elementor.modules.controls.BaseData.extend({

                onReady: function () {

                    var action = this.model.attributes.action,
                        queryParams = this.model.attributes.query_params;

                    this.ui.select.find('option').each(function (index, el) {
                        $(this).attr('selected', true);
                    });

                    this.ui.select.select2({
                        ajax: {
                            url: function () {
                                var query = '';
                                if (queryParams.length > 0) {
                                    $.each(queryParams, function (index, param) {
                                        if (window.elementor.settings.page.model.attributes[param]) {
                                            query += '&' + param + '=' + window.elementor.settings.page.model.attributes[param];
                                        }
                                    });
                                }
                                return ajaxurl + '?action=' + action + query;
                            },
                            dataType: 'json'
                        },
                        placeholder: 'Please enter 3 or more characters',
                        minimumInputLength: 3
                    });
                },

                onBeforeDestroy: function () {
                    if (this.ui.select.data('select2')) {
                        this.ui.select.select2('destroy');
                    }
                    this.$el.remove();
                }

            });

            window.elementor.addControlView('premium_search', self.TCI_UET_Search_View);

        }

    };

    $(window).on('elementor:init', TCI_UET_Editor_Template.init);

})(jQuery);
jQuery(window).on('elementor:init', function (modules) {
    var Query_ser = elementor.modules.controls.Select2.extend({
        cache: null,
        isTitlesReceived: false,
        getSelect2Placeholder: function getSelect2Placeholder() {
            return {
                id: '',
                text: 'All'
            };
        },
        getSelect2DefaultOptions: function getSelect2DefaultOptions() {
            var self = this;
            return jQuery.extend(elementor.modules.controls.Select2.prototype.getSelect2DefaultOptions.apply(this, arguments), {
                ajax: {
                    transport: function transport(params, success, failure) {
                        var data = {
                            q: params.data.q,
                            filter_type: self.model.get('filter_type'),
                            object_type: self.model.get('object_type'),
                            include_type: self.model.get('include_type'),
                            query: self.model.get('query')
                        };
                        return elementorCommon.ajax.addRequest('panel_posts_control_filter_autocomplete', {
                            data: data,
                            success: success,
                            error: failure
                        });
                    },
                    data: function data(params) {

                        return {
                            q: params.term,
                            page: params.page
                        };
                    },
                    cache: true
                },
                escapeMarkup: function escapeMarkup(markup) {
                    return markup;
                },
                minimumInputLength: 1
            });
        },
        getValueTitles: function getValueTitles() {
            var self = this,
                ids = this.getControlValue(),
                filterType = this.model.get('filter_type');
            if (!ids || !filterType) {
                return;
            }
            if (!_.isArray(ids)) {
                ids = [ids];
            }
            elementorCommon.ajax.loadObjects({
                action: 'query_control_value_titles',
                ids: ids,
                data: {
                    filter_type: filterType,
                    object_type: self.model.get('object_type'),
                    include_type: self.model.get('include_type'),
                    unique_id: '' + self.cid + filterType
                },
                before: function before() {
                    self.addControlSpinner();
                },
                success: function success(data) {
                    self.isTitlesReceived = true;
                    self.model.set('options', data);
                    self.render();
                }
            });
        },
        addControlSpinner: function addControlSpinner() {
            this.ui.select.prop('disabled', true);
            this.$el.find('.elementor-control-title').after('<span class="elementor-control-spinner">&nbsp;<i class="fa fa-spinner fa-spin"></i>&nbsp;</span>');
        },
        onReady: function onReady() {
            // Safari takes it's time to get the original select width
            setTimeout(elementor.modules.controls.Select2.prototype.onReady.bind(this));
            if (!this.isTitlesReceived) {
                this.getValueTitles();
            }
        }
    });
    elementor.addControlView('Query', Query_ser);

    /*var TCI_UET_GlobalWidget = elementorModules.editor.utils.Module.extend({
        globalModels: {},

        panelWidgets: null,

        templatesAreSaved: true,

        addGlobalWidget: function addGlobalWidget(id, args) {
            args = _.extend({}, args, {
                categories: [],
                icon: elementor.config.widgets[args.widgetType].icon,
                widgetType: args.widgetType,
                custom: {
                    templateID: id
                }
            });

            var globalModel = this.createGlobalModel(id, args);

            return this.panelWidgets.add(globalModel);
        },

        createGlobalModel: function createGlobalModel(id, modelArgs) {
            var globalModel = new elementor.modules.elements.models.Element(modelArgs),
                settingsModel = globalModel.get('settings');

            globalModel.set('id', id);

            settingsModel.on('change', _.bind(this.onGlobalModelChange, this));

            return this.globalModels[id] = globalModel;
        },

        onGlobalModelChange: function onGlobalModelChange() {
            this.templatesAreSaved = false;
        },

        setWidgetType: function setWidgetType() {
            elementor.hooks.addFilter('element/view', function (DefaultView, model) {

                if (model.get('templateID')) {
                    return GlobalWidgetView;
                }

                return DefaultView;
            });

            elementor.hooks.addFilter('element/model', function (DefaultModel, attrs) {
                if (attrs.templateID) {
                    return Module_type;
                }

                return DefaultModel;
            });
        },

        registerTemplateType: function registerTemplateType() {
            elementor.templates.registerTemplateType('widget', {
                showInLibrary: false,
                saveDialog: {
                    title: elementorPro.translate('global_widget_save_title'),
                    description: elementorPro.translate('global_widget_save_description')
                },
                prepareSavedData: function prepareSavedData(data) {
                    data.widgetType = data.content[0].widgetType;

                    return data;
                },
                ajaxParams: {
                    success: this.onWidgetTemplateSaved.bind(this)
                }
            });
        },

        addSavedWidgetsToPanel: function addSavedWidgetsToPanel() {
            var self = this;

            self.panelWidgets = new Backbone.Collection();

            _.each(elementorPro.config.widget_templates, function (templateArgs, id) {
                self.addGlobalWidget(id, templateArgs);
            });

            elementor.hooks.addFilter('panel/elements/regionViews', function (regionViews) {
                _.extend(regionViews.global, {
                    view: __webpack_require__(39),
                    options: {
                        collection: self.panelWidgets
                    }
                });

                return regionViews;
            });
        },

        addPanelPage: function addPanelPage() {

            elementor.getPanelView().addPage('globalWidget', {
                view: Add_Global_Module
            });
        },

        getGlobalModels: function getGlobalModels(id) {
            if (!id) {
                return this.globalModels;
            }

            return this.globalModels[id];
        },

        saveTemplates: function saveTemplates() {
            if (!Object.keys(this.globalModels).length) {
                return;
            }

            var templatesData = [],
                self = this;

            _.each(this.globalModels, function (templateModel, id) {
                if ('loaded' !== templateModel.get('settingsLoadedStatus')) {
                    return;
                }

                var data = {
                    content: JSON.stringify([templateModel.toJSON({removeDefault: true})]),
                    source: 'local',
                    type: 'widget',
                    id: id
                };

                templatesData.push(data);
            });

            if (!templatesData.length) {
                return;
            }

            elementorCommon.ajax.addRequest('update_templates', {
                data: {
                    templates: templatesData
                },
                success: function success() {
                    self.templatesAreSaved = true;
                }
            });
        },

        setSaveButton: function setSaveButton() {
            elementor.saver.on('before:save:publish', _.bind(this.saveTemplates, this));
            elementor.saver.on('before:save:private', _.bind(this.saveTemplates, this));
        },

        requestGlobalModelSettings: function requestGlobalModelSettings(globalModel, callback) {
            elementor.templates.requestTemplateContent('local', globalModel.get('id'), {
                success: function success(data) {
                    globalModel.set('settingsLoadedStatus', 'loaded').trigger('settings:loaded');

                    var settings = data.content[0].settings,
                        settingsModel = globalModel.get('settings');

                    // Don't track it in History
                    elementor.history.history.setActive(false);

                    settingsModel.handleRepeaterData(settings);

                    settingsModel.set(settings);

                    if (callback) {
                        callback(globalModel);
                    }

                    elementor.history.history.setActive(true);
                }
            });
        },

        setWidgetContextMenuSaveAction: function setWidgetContextMenuSaveAction() {
            elementor.hooks.addFilter('elements/widget/contextMenuGroups', function (groups, widget) {
                var saveGroup = _.findWhere(groups, {name: 'save'}),
                    saveAction = _.findWhere(saveGroup.actions, {name: 'save'});

                saveAction.callback = widget.save.bind(widget);

                delete saveAction.shortcut;

                return groups;
            });
        },

        onElementorInit: function onElementorInit() {
            this.setWidgetType();

            this.registerTemplateType();

            this.setWidgetContextMenuSaveAction();
        },

        onElementorFrontendInit: function onElementorFrontendInit() {
            this.addSavedWidgetsToPanel();
        },

        onElementorPreviewLoaded: function onElementorPreviewLoaded() {
            this.addPanelPage();
            this.setSaveButton();
        },

        onWidgetTemplateSaved: function onWidgetTemplateSaved(data) {
            elementor.history.history.startItem({
                title: elementor.config.widgets[data.widgetType].title,
                type: elementorPro.translate('linked_to_global')
            });

            var widgetModel = elementor.templates.getLayout().modalContent.currentView.model,
                widgetModelIndex = widgetModel.collection.indexOf(widgetModel);

            elementor.templates.closeModal();

            data.elType = data.type;
            data.settings = widgetModel.get('settings').attributes;

            var globalModel = this.addGlobalWidget(data.template_id, data),
                globalModelAttributes = globalModel.attributes;

            widgetModel.collection.add({
                id: elementor.helpers.getUniqueID(),
                elType: globalModelAttributes.type,
                templateID: globalModelAttributes.template_id,
                widgetType: 'global'
            }, {at: widgetModelIndex}, true);

            widgetModel.destroy();

            var panel = elementor.getPanelView();

            panel.setPage('elements');

            panel.getCurrentPageView().activateTab('global');

            elementor.history.history.endItem();
        }
    });
    const Add_Global_Module = Marionette.ItemView.extend({
        id: 'elementor-panel-global-widget',
        template: '#tmpl-elementor-panel-global-widget',
        ui: {
            editButton: '#elementor-global-widget-locked-edit .elementor-button',
            unlinkButton: '#elementor-global-widget-locked-unlink .elementor-button',
            loading: '#elementor-global-widget-loading'
        },

        events: {
            'click @ui.editButton': 'onEditButtonClick',
            'click @ui.unlinkButton': 'onUnlinkButtonClick'
        },

        initialize: function initialize() {
            this.initUnlinkDialog();
        },

        buildUnlinkDialog: function buildUnlinkDialog() {
            var self = this;

            return elementorCommon.dialogsManager.createWidget('confirm', {
                id: 'elementor-global-widget-unlink-dialog',
                headerMessage: elementorPro.translate('unlink_widget'),
                message: elementorPro.translate('dialog_confirm_unlink'),
                position: {
                    my: 'center center',
                    at: 'center center'
                },
                strings: {
                    confirm: elementorPro.translate('unlink'),
                    cancel: elementorPro.translate('cancel')
                },
                onConfirm: function onConfirm() {
                    self.getOption('editedView').unlink();
                }
            });
        },

        initUnlinkDialog: function initUnlinkDialog() {
            var dialog;

            this.getUnlinkDialog = function () {
                if (!dialog) {
                    dialog = this.buildUnlinkDialog();
                }

                return dialog;
            };
        },

        editGlobalModel: function editGlobalModel() {
            var editedView = this.getOption('editedView');

            elementor.getPanelView().openEditor(editedView.getEditModel(), editedView);
        },

        onEditButtonClick: function onEditButtonClick() {
            var self = this,
                editedView = self.getOption('editedView'),
                editedModel = editedView.getEditModel();

            if ('loaded' === editedModel.get('settingsLoadedStatus')) {
                self.editGlobalModel();

                return;
            }

            self.ui.loading.removeClass('elementor-hidden');

            elementorPro.modules.globalWidget.requestGlobalModelSettings(editedModel, function () {
                self.ui.loading.addClass('elementor-hidden');

                self.editGlobalModel();
            });
        },

        onUnlinkButtonClick: function onUnlinkButtonClick() {
            this.getUnlinkDialog().show();
        }
    });
    var WidgetView = elementor.modules.elements.views.Widget, GlobalWidgetView;
    GlobalWidgetView = WidgetView.extend({

        globalModel: null,

        className: function className() {
            return WidgetView.prototype.className.apply(this, arguments) + ' elementor-global-widget elementor-global-' + this.model.get('templateID');
        },

        initialize: function initialize() {
            var self = this,
                previewSettings = self.model.get('previewSettings'),
                globalModel = self.getGlobalModel();

            if (previewSettings) {
                globalModel.set('settingsLoadedStatus', 'loaded').trigger('settings:loaded');

                var settingsModel = globalModel.get('settings');

                settingsModel.handleRepeaterData(previewSettings);

                settingsModel.set(previewSettings, {silent: true});
            } else {
                var globalSettingsLoadedStatus = globalModel.get('settingsLoadedStatus');

                if (!globalSettingsLoadedStatus) {
                    globalModel.set('settingsLoadedStatus', 'pending');

                    elementorPro.modules.globalWidget.requestGlobalModelSettings(globalModel);
                }

                if ('loaded' !== globalSettingsLoadedStatus) {
                    self.$el.addClass('elementor-loading');
                }

                globalModel.on('settings:loaded', function () {
                    self.$el.removeClass('elementor-loading');

                    self.render();
                });
            }

            WidgetView.prototype.initialize.apply(self, arguments);
        },

        getGlobalModel: function getGlobalModel() {
            if (!this.globalModel) {
                this.globalModel = elementorPro.modules.globalWidget.getGlobalModels(this.model.get('templateID'));
            }

            return this.globalModel;
        },

        getEditModel: function getEditModel() {
            return this.getGlobalModel();
        },

        getHTMLContent: function getHTMLContent(html) {
            if ('loaded' === this.getGlobalModel().get('settingsLoadedStatus')) {
                return WidgetView.prototype.getHTMLContent.call(this, html);
            }

            return '';
        },

        serializeModel: function serializeModel() {
            var globalModel = this.getGlobalModel();

            return globalModel.toJSON.apply(globalModel, _.rest(arguments));
        },

        edit: function edit() {
            elementor.getPanelView().setPage('globalWidget', 'Global Editing', {editedView: this});
        },

        unlink: function unlink() {
            var globalModel = this.getGlobalModel();

            elementor.history.history.startItem({
                title: globalModel.getTitle(),
                type: elementorPro.translate('unlink_widget')
            });

            var newModel = new elementor.modules.elements.models.Element({
                elType: 'widget',
                widgetType: globalModel.get('widgetType'),
                id: elementor.helpers.getUniqueID(),
                settings: elementor.helpers.cloneObject(globalModel.get('settings').attributes),
                defaultEditSettings: elementor.helpers.cloneObject(globalModel.get('editSettings').attributes)
            });

            this._parent.addChildModel(newModel, {at: this.model.collection.indexOf(this.model)});

            var newWidget = this._parent.children.findByModelCid(newModel.cid);

            this.model.destroy();

            elementor.history.history.endItem();

            if (newWidget.edit) {
                newWidget.edit();
            }

            newModel.trigger('request:edit');
        },

        onEditRequest: function onEditRequest() {
            elementor.getPanelView().setPage('globalWidget', 'Global Editing', {editedView: this});
        }
    });
    var Module_type = elementor.modules.elements.models.Element.extend({
        initialize: function initialize() {
            this.set({widgetType: 'global'}, {silent: true});

            elementor.modules.elements.models.Element.prototype.initialize.apply(this, arguments);

            elementorFrontend.config.elements.data[this.cid].on('change', this.onSettingsChange.bind(this));
        },

        initSettings: function initSettings() {
            var globalModel = this.getGlobalModel(),
                settingsModel = globalModel.get('settings');

            this.set('settings', settingsModel);

            elementorFrontend.config.elements.data[this.cid] = settingsModel;

            elementorFrontend.config.elements.editSettings[this.cid] = globalModel.get('editSettings');
        },

        initEditSettings: function initEditSettings() {
        },

        getGlobalModel: function getGlobalModel() {
            var templateID = this.get('templateID');

            return elementorPro.modules.globalWidget.getGlobalModels(templateID);
        },

        getTitle: function getTitle() {
            var title = this.getSetting('_title');

            if (!title) {
                title = this.getGlobalModel().get('title');
            }

            var global = elementorPro.translate('global');

            title = title.replace(new RegExp('\\(' + global + '\\)$'), '');

            return title + ' (' + global + ')';
        },

        getIcon: function getIcon() {
            return this.getGlobalModel().getIcon();
        },

        onSettingsChange: function onSettingsChange(model) {
            if (!model.changed.elements) {
                this.set('previewSettings', model.toJSON({removeDefault: true}), {silent: true});
            }
        },

        onDestroy: function onDestroy() {
            var panel = elementor.getPanelView(),
                currentPageName = panel.getCurrentPageName();

            if (-1 !== ['editor', 'globalWidget'].indexOf(currentPageName)) {
                panel.setPage('elements');
            }
        }
    });
    var add_Global_Module = new Add_Global_Module();
    add_Global_Module.render();
    console.log(elementor.getPanelView());*/
});



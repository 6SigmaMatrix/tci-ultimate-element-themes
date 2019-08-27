Marionette.ItemView.extend({
    id: "elementor-panel-global-widget",
    template: "#tmpl-elementor-panel-global-widget",
    ui: {
        editButton: "#elementor-global-widget-locked-edit .elementor-button",
        unlinkButton: "#elementor-global-widget-locked-unlink .elementor-button",
        loading: "#elementor-global-widget-loading"
    },
    events: {"click @ui.editButton": "onEditButtonClick", "click @ui.unlinkButton": "onUnlinkButtonClick"},
    initialize: function () {
        this.initUnlinkDialog()
    },
    buildUnlinkDialog: function () {
        var e = this;
        return elementorCommon.dialogsManager.createWidget("confirm", {
            id: "elementor-global-widget-unlink-dialog",
            headerMessage: elementorPro.translate("unlink_widget"),
            message: elementorPro.translate("dialog_confirm_unlink"),
            position: {my: "center center", at: "center center"},
            strings: {confirm: elementorPro.translate("unlink"), cancel: elementorPro.translate("cancel")},
            onConfirm: function () {
                e.getOption("editedView").unlink()
            }
        })
    },
    initUnlinkDialog: function () {
        var e;
        this.getUnlinkDialog = function () {
            return e || (e = this.buildUnlinkDialog()), e
        }
    },
    editGlobalModel: function () {
        var e = this.getOption("editedView");
        elementor.getPanelView().openEditor(e.getEditModel(), e)
    },
    onEditButtonClick: function () {
        var e = this, t = e.getOption("editedView").getEditModel();
        "loaded" !== t.get("settingsLoadedStatus") ? (e.ui.loading.removeClass("elementor-hidden"), elementorPro.modules.globalWidget.requestGlobalModelSettings(t, function () {
            e.ui.loading.addClass("elementor-hidden"), e.editGlobalModel()
        })) : e.editGlobalModel()
    },
    onUnlinkButtonClick: function () {
        this.getUnlinkDialog().show()
    }
});
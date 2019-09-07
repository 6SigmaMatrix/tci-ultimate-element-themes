<?php
namespace TCI_UET\TCI_UET_Modules;

class TCI_UET_Global_View {
	public function __construct() {
		$this->tci_uet_global_view_data();
	}

	private function tci_uet_global_view_data() {
		?>
		<script type="text/template" id="tmpl-elementor-panel-global-widget">
			<div id="elementor-global-widget-locked-header" class="elementor-nerd-box elementor-panel-nerd-box">
				<i class="elementor-nerd-box-icon elementor-panel-nerd-box-icon eicon-nerd" aria-invalid="true"></i>
				<div class="elementor-nerd-box-title elementor-panel-nerd-box-title"><?php echo __( 'Your Widget is Now Locked', 'tci-uet' ); ?></div>
				<div class="elementor-nerd-box-message elementor-panel-nerd-box-message"><?php _e( 'Edit this global widget to simultaneously update every place you used it, or unlink it so it gets back to being regular widget.', 'tci-uet' ); ?></div>
			</div>
			<div id="elementor-global-widget-locked-tools">
				<div id="elementor-global-widget-locked-edit" class="elementor-global-widget-locked-tool">
					<div class="elementor-global-widget-locked-tool-description"><?php echo __( 'Edit global widget', 'tci-uet' ); ?></div>
					<button class="elementor-button elementor-button-success"><?php _e( 'Edit', 'tci-uet' ); ?></button>
				</div>
				<div id="elementor-global-widget-locked-unlink" class="elementor-global-widget-locked-tool">
					<div class="elementor-global-widget-locked-tool-description"><?php echo __( 'Unlink from global', 'tci-uet' ); ?></div>
					<button class="elementor-button"><?php _e( 'Unlink', 'tci-uet' ); ?></button>
				</div>
			</div>
			<div id="elementor-global-widget-loading" class="elementor-hidden">
				<i class="fa fa-spin fa-circle-o-notch" aria-hidden="true"></i>
				<span class="elementor-screen-only"><?php _e( 'Loading', 'tci-uet' ); ?></span>
			</div>
		</script>

		<script type="text/template" id="tmpl-elementor-panel-global-widget-no-templates">
			<i class="elementor-nerd-box-icon elementor-panel-nerd-box-icon eicon-nerd" aria-invalid="true"></i>
			<div class="elementor-nerd-box-title elementor-panel-nerd-box-title"><?php _e( 'Save Your First Global Widget', 'tci-uet' ); ?></div>
			<div class="elementor-nerd-box-message elementor-panel-nerd-box-message"><?php _e( 'Save a widget as global, then add it to multiple areas. All areas will be editable from one single place.', 'tci-uet' ); ?></div>
		</script>
		<?php
	}
}

new TCI_UET_Global_View();
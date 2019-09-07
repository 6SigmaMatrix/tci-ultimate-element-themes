<?php
/**
 * Template Item
 */
?>
<script type="text/html" id="tmpl-tci-uet-item">
	<div class="elementor-template-library-template-body">
		<div class="elementor-template-library-template-screenshot">
			<div class="elementor-template-library-template-preview">
				<i class="fa fa-search-plus"></i>
			</div>
			<img src="{{ thumbnail }}" alt="{{ title }}">
		</div>
	</div>
	<div class="elementor-template-library-template-controls">
		<button class="elementor-template-library-template-action tci-uet-template-insert elementor-button elementor-button-success">
			<i class="eicon-file-download"></i>
			<span class="elementor-button-title"><?php echo __( 'Insert', 'tci-uet-addons-for-elementor' ); ?></span>
		</button>
	</div>
</script>

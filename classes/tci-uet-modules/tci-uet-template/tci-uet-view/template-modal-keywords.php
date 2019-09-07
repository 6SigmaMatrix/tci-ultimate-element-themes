<?php
/**
 * Templates Keywords Filter
 */
?>
<script type="text/html" id="tmpl-tci-uet-keywords">
	<# if ( ! _.isEmpty( keywords ) ) { #>
	<label><?php echo __( 'Filter by Widget / Addon', 'tci-uet-addons-for-elementor' ); ?></label>
	<select id="elementor-template-library-filter-subtype" class="elementor-template-library-filter-select tci-uet-library-keywords" data-elementor-filter="subtype">
		<option value=""><?php echo __( 'All Widgets/Addons', 'tci-uet-addons-for-elementor' ); ?></option>
		<# _.each( keywords, function( title, slug ) { #>
		<option value="{{ slug }}">{{ title }}</option>
		<# } ); #>
	</select>
	<# } #>
</script>
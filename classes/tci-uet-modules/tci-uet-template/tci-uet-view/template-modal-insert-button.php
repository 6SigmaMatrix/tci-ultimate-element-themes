<?php
/**
 * Template Insert Button
 */
?>
<script type="text/html" id="tmpl-tci-uet-insert-button">
	<# if ( 'valid' === window.PremiumTempsData.license.status || ! pro ) { #>
	<button class="elementor-template-library-template-action tci-uet-template-insert elementor-button elementor-button-success">
		<i class="eicon-file-download"></i><span class="elementor-button-title"><?php
			echo __( 'Insert', 'tci-uet-addons-for-elementor' );
			?></span>
	</button>
	<# } else { #>
	<a class="template-library-activate-license elementor-button elementor-button-go-pro" href="{{{ window.PremiumTempsData.license.activateLink }}}" target="_blank">
		<i class="fa fa-external-link" aria-hidden="true"></i>
		{{{ window.PremiumTempsData.license.proMessage }}}
	</a>
	<# } #>
</script>
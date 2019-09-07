<?php
/**
 * Template Library Filter Item
 */
?>
<script type="text/html" id="tmpl-tci-uet-filters-item">
	<label class="tci-uet-template-filter-label">
		<input type="radio" value="{{ slug }}" <# if ( '' === slug ) { #> checked<# } #> name="tci-uet-template-filter">
		<span>{{ title.replace('&amp;', '&') }}</span>
	</label>
</script>
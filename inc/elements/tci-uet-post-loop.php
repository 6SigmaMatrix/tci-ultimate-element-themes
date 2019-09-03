<div class="row">
	<?php
	while ( $query->have_posts() ) :
		$query->the_post();
		?>
		<div class="col-xl-<?php echo esc_attr( $settings->get( TCI_UET_SETTINGS . 'post_column' ) ); ?>">
			<?php tci_uet_get_elementor_template( $settings->get( TCI_UET_SETTINGS . 'elementor_template_source' ) ); ?>
		</div>
	<?php
	endwhile;
	wp_reset_postdata();
	?>
</div>



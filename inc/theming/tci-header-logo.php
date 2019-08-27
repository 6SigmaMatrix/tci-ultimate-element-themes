<?php
/**
 * TCI Ultimate Element Themes header logo file
 *
 * @since 0.0.1
 */
?>
<?php if ( has_custom_logo() ) : ?>
	<div class="tci-site-logo"><?php the_custom_logo(); ?></div>
<?php endif; ?>
<?php $blog_info = get_bloginfo( 'name' ); ?>
<?php if ( ! empty( $blog_info ) ) : ?>
	<h1 class="tci-site-title">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
	</h1>
<?php endif; ?>
<?php
$description = get_bloginfo( 'description', 'display' );
if ( ! empty( $description ) ) :
	?>
	<p class="tci-site-description">
		<?php echo $description; ?>
	</p>
<?php endif; ?>

<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="footer-inner">
			<?php if ( has_nav_menu( 'footer' ) ) : ?>
			<nav class="footer-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Menu', 'directoryx-adult' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'menu_id'        => 'footer-menu',
						'container'      => false,
						'depth'          => 1,
						'fallback_cb'    => false,
					)
				);
				?>
			</nav>
			<?php endif; ?>

			<div class="site-info">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
				<span class="sep"> &middot; </span>
				<?php
				$footer_text = get_theme_mod( 'dxadult_footer_text', '' );
				if ( $footer_text ) {
					echo wp_kses_post( $footer_text );
				} else {
					printf(
						/* translators: %s: WordPress. */
						esc_html__( 'Powered by %s', 'directoryx-adult' ),
						'<a href="https://wordpress.org/">WordPress</a>'
					);
				}
				?>
			</div>
		</div>
	</footer>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>

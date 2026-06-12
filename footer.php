<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="footer-inner">
			<?php
			if ( has_nav_menu( 'footer' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'container'      => 'nav',
					'container_class' => 'footer-navigation',
					'depth'          => 1,
				) );
			}
			?>
			<div class="site-info">
				<?php echo esc_html( date( 'Y' ) ); ?> &copy; <?php bloginfo( 'name' ); ?>
			</div>
		</div>
	</footer>

	<div class="mobile-search-overlay">
		<?php get_search_form(); ?>
	</div>

	<nav class="mobile-bottom-nav" role="navigation" aria-label="<?php esc_attr_e( 'Mobile navigation', 'directoryx-adult' ); ?>">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<span class="nav-icon" aria-hidden="true"><?php dxadult_icon( 'home', '20' ); ?></span>
			<?php esc_html_e( 'Home', 'directoryx-adult' ); ?>
		</a>
		<a href="#" class="mobile-search-toggle" aria-label="<?php esc_attr_e( 'Toggle search', 'directoryx-adult' ); ?>">
			<span class="nav-icon" aria-hidden="true"><?php dxadult_icon( 'search', '20' ); ?></span>
			<?php esc_html_e( 'Search', 'directoryx-adult' ); ?>
		</a>
		<a href="<?php echo esc_url( get_post_type_archive_link( 'listing' ) ); ?>">
			<span class="nav-icon" aria-hidden="true"><?php dxadult_icon( 'list', '20' ); ?></span>
			<?php esc_html_e( 'Listings', 'directoryx-adult' ); ?>
		</a>
	</nav>

	<div class="scroll-progress" aria-hidden="true"></div>

	<button class="back-to-top" type="button" aria-label="<?php esc_attr_e( 'Back to top', 'directoryx-adult' ); ?>">
		<?php dxadult_icon( 'arrow-up', '20' ); ?>
	</button>

	<div class="lightbox" role="dialog" aria-label="<?php esc_attr_e( 'Image viewer', 'directoryx-adult' ); ?>" aria-hidden="true" tabindex="-1">
		<button class="lightbox__close" type="button" aria-label="<?php esc_attr_e( 'Close', 'directoryx-adult' ); ?>">&times;</button>
		<img class="lightbox__image" alt="" />
	</div>

	<div class="toast-container" aria-live="polite" aria-atomic="true"></div>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>

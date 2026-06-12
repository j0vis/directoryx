<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="footer-inner">
			<div class="site-info">
				<?php echo esc_html( date( 'Y' ) ); ?> &ndash; &copy; &ndash; <?php bloginfo( 'name' ); ?>
			</div>
		</div>
	</footer>

	<div class="mobile-search-overlay">
		<?php get_search_form(); ?>
	</div>

	<nav class="mobile-bottom-nav" role="navigation" aria-label="<?php esc_attr_e( 'Mobile navigation', 'directoryx-adult' ); ?>">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<span class="nav-icon" aria-hidden="true">&#x2302;</span>
			<?php esc_html_e( 'Home', 'directoryx-adult' ); ?>
		</a>
		<a href="#" class="mobile-search-toggle" aria-label="<?php esc_attr_e( 'Toggle search', 'directoryx-adult' ); ?>">
			<span class="nav-icon" aria-hidden="true">&#x1F50D;</span>
			<?php esc_html_e( 'Search', 'directoryx-adult' ); ?>
		</a>
		<a href="<?php echo esc_url( get_post_type_archive_link( 'listing' ) ); ?>">
			<span class="nav-icon" aria-hidden="true">&#x2630;</span>
			<?php esc_html_e( 'Listings', 'directoryx-adult' ); ?>
		</a>
	</nav>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>

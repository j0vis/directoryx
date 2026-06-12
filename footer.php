<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="footer-inner">
			<div class="site-info">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
				<span class="sep"> &middot; </span>
				&copy; <?php echo esc_html( date( 'Y' ) ); ?>
			</div>
		</div>
	</footer>

	<nav class="mobile-bottom-nav" role="navigation" aria-label="<?php esc_attr_e( 'Mobile navigation', 'directoryx-adult' ); ?>">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<span class="nav-icon" aria-hidden="true">&#x2302;</span>
			<?php esc_html_e( 'Home', 'directoryx-adult' ); ?>
		</a>
		<a href="<?php echo esc_url( home_url( '/?s=' ) ); ?>">
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

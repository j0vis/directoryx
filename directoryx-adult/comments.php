<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$comment_count = get_comments_number();
			printf(
				esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'directoryx-adult' ) ),
				number_format_i18n( $comment_count ),
				'<span>' . get_the_title() . '</span>'
			);
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 48,
				)
			);
			?>
		</ol>

		<?php
		the_comments_pagination(
			array(
				'prev_text' => __( '&larr; Older Comments', 'directoryx-adult' ),
				'next_text' => __( 'Newer Comments &rarr;', 'directoryx-adult' ),
			)
		);
		?>
	<?php endif; ?>

	<?php if ( comments_open() ) : ?>
		<?php
		add_filter(
			'comment_form_default_fields',
			function ( $fields ) {
				unset( $fields['url'] );
				unset( $fields['cookies'] );
				return $fields;
			}
		);
		comment_form();
		?>
	<?php elseif ( get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'directoryx-adult' ); ?></p>
	<?php endif; ?>
</div>

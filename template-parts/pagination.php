<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

the_posts_pagination(
	array(
		'mid_size'  => 2,
		'prev_text' => __( '&larr; Previous', 'directoryx-adult' ),
		'next_text' => __( 'Next &rarr;', 'directoryx-adult' ),
	)
);

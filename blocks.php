<?php
/*
 Template Name: Content Blocks
*/
?>

<?php get_header(); ?>

<?php

// check if the flexible content field has rows of data
if (have_rows('blocks')):

	// loop through the rows of data
	while (have_rows('blocks')) : the_row();

		// this call is contingent on naming content block files the same as the layouts
		get_template_part('blocks/' . get_row_layout());

	endwhile;

endif;

?>

<?php get_footer(); ?>
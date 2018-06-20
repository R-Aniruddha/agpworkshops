<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package understrap  
 */
get_header('sticky'); ?>


<?php while ( have_posts() ) : the_post(); ?>

<h1><?php the_title(); ?></h1>
<?php the_content(); ?>
<?php endwhile; ?>
<?php 
get_footer(); ?>
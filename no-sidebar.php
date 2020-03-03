<?php
/*
Template Name: No Sidebar
*/
global $post;

if (locate_template('page-' . $post->post_name . '.php') != '') {
	get_template_part('page', $post->post_name);
} else {
	get_template_part('templates/page', 'header'); 
	get_template_part('templates/content', 'page'); 
}
?>

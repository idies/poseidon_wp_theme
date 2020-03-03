<?php global $post; ?>
<?php if (locate_template('templates/content-page-' . $post -> post_name . '.php') != '') : ?>
<?php 		get_template_part('templates/content-page', $post -> post_name); ?>
<?php else : ?>	
	<?php while (have_posts()) : the_post(); ?>
		<?php the_content(); ?>
		<?php wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>')); ?>
	<?php endwhile; ?>
	<?php get_template_part('templates/content', 'faq'); ?>
<?php endif; ?>

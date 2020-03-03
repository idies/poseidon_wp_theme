<?php global $post; ?>
<?php if (locate_template('templates/content-single-' . $post -> post_type . '.php') != '') : ?>
<?php 		get_template_part('templates/content-single', $post -> post_type ); ?>
<?php else : ?>	
<?php 	get_template_part('templates/content', 'single'); ?>
<?php endif ; ?>	

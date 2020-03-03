<?php
global $post;

//if page has a special template, show that
if (locate_template('page-' . $post->post_type . '.php') != '') {
	get_template_part('page', $post->post_type);
} else {
?>
<div class="page-header">
  <h1>
    <?php echo roots_title(); ?>
  </h1>
</div>
<?php
}

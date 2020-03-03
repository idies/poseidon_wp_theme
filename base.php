<?php 
global $post;
get_template_part('templates/head'); 
?>
<body data-spy="scroll"  data-target="#sidebar-nav-spy" <?php body_class(''); ?>>
<?php
	if (locate_template('templates/pre-header.php') != '') {
		get_template_part('templates/pre-header');
	}
	do_action('get_header' , 'header');
	
	// Special Header for Named Post
	if ( !empty( $post->post_name ) && locate_template('templates/header-' . $post->post_name . '.php') != '') {
		get_template_part('templates/header', $post->post_name);
		
	// Special Header for Post Type
	} elseif ( !empty( $post->post_type ) && locate_template('templates/header-' . $post->post_type . '.php') != '') {
		get_template_part('templates/header', $post->post_type);
		
	// Generic Header
	} else {
		get_template_part('templates/header');
	}	
?>
  <div class="wrap container" role="document">
    <div class="content row">
      <main class="main" role="main">
		<?php include roots_template_path(); ?>
      </main><!-- /.main -->
      <?php if (roots_display_sidebar()) : ?>
        <aside class="sidebar" role="complementary">
          <?php include roots_sidebar_path(); ?>
        </aside><!-- /.sidebar -->
      <?php endif; ?>
    </div><!-- /.content -->
  </div><!-- /.wrap -->
<?php
	if ( !empty( $post->post_name ) && locate_template('templates/footer-' . $post->post_name . '.php') != '') {
		get_template_part('templates/footer', $post->post_name);
	} else {
		get_template_part('templates/footer'); 
	}
	wp_footer(); 
?>
</body>
</html>
<?php
?>
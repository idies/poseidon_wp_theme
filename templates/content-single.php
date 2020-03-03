<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <header>
      <h1 class="entry-title"><?php the_title(); ?></h1>
      <?php get_template_part('templates/entry-meta'); ?>
    </header>
    <div class="entry-content">
	<?php the_content(); ?>
	<div class="row">
	<div class="col-xs-12">
	<ul class="breadcrumb">
	  <li><a href="<?php echo home_url(); ?>">IDIES</a></li>
<?php if (strcmp( 'post' , $the_post_type = get_post_type() ) === 0 ) $the_post_type = 'news' ; ?>
	  <li><a href="<?php echo home_url() . '/' . $the_post_type ; ?>"><?php echo ucfirst($the_post_type); ?></a></li>
	  <li><?php the_title(); ?></li>
	</ul>
	</div>
	</div>
    </div>
    <footer>
      <?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
    </footer>
  </article>
<?php endwhile; ?>

<?php if ( get_cfc_field( 'jobs-details' , 'filled' ) ) return;?>
<article <?php post_class(); ?> id="article-<?php the_id(); ?>">
  <header>
    <p class="h4 entry-title"><a data-toggle="collapse" class="article-toggle " href="#collapse<?php the_id(); ?>"  aria-expanded="false" aria-controls="collapse<?php the_id(); ?>"><?php echo get_post_format(); ?><?php the_title(); ?></a></p>
  </header>
  <div class="collapse in" id="collapse<?php the_id(); ?>">
  <div class="entry-summary panel panel-default panel-body">
	<?php the_content(); ?>
	<p class="text-right"><a href="<?php the_cfc_field('jobs-details','url');?>" class="btn btn-primary external-link">Visit JHU Jobs</a></p>
  </div>
  </div>
</article>

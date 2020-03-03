<?php 
//Shows the articles in an archive.
?>
 <article <?php post_class(); ?>>
  <header>
    <h3 class="entry-title"><?php echo get_post_format(); ?><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
  </header>
  <div class="entry-summary">
  <div class="row">
  <?php if (has_post_thumbnail()) : ?>
  <?php $pullright = (rand(0,1)) ? 'pull-right': '' ; // randomly align the thumnails right and left (default) ?>
  <div class="col-sm-3 col-xs-hidden <?php echo $pullright; ?>"><?php the_post_thumbnail( 'thumbnail' ); ?></div>
  <div class="col-sm-9 col-xs-12"><?php the_excerpt(); ?></div>
  <?php else : ?>
  <div class="col-xs-12"><?php the_excerpt(); ?></div>
  <?php endif ; ?>
  </div>
  </div>
</article>

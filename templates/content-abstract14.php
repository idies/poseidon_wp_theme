<div class="col-sm-6 col-xs-12"><div class="well well-sm">
<article <?php post_class(); ?>>
  <header>
    <h4 class="entry-title"><?php echo get_post_format(); ?><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
    <?php //get_template_part('templates/entry-meta'); ?>
  </header>
  <div class="entry-summary">
	<?php
	$first=true;
foreach( get_cfc_meta( 'abstract14-authors' ) as $key => $value ){ ?>
<?php 	$name = get_cfc_field( 'abstract14-authors','name', false, $key ); ?>
<?php 
	if (!$first) echo ", ";
	echo "<strong>" . $name . "</strong>";
	$first=false;
}  ?>
<br/>
	<?php the_excerpt(); ?>
  </div>
</article>
</div></div>

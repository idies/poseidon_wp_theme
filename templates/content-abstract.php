<div class="col-sm-6 col-xs-12"><div class="well well-sm">
<article <?php post_class(); ?>>
  <header>
    <h4 class="entry-title"><?php echo get_post_format(); ?><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
    <?php //get_template_part('templates/entry-meta'); ?>
  </header>
  <div class="entry-summary">
	<?php
	$first=true;
foreach( get_cfc_meta( 'abstract-authors' ) as $key => $value ){ ?>
<?php 	$name = get_cfc_field( 'abstract-authors','name', false, $key ); ?>
<?php 	$email = get_cfc_field( 'abstract-authors','email', false, $key ); ?>
<?php 	$presenting = get_cfc_field( 'abstract-authors','presenting', false, $key ); ?>
<?php 
	if (!$first) echo ", ";
	echo "<strong>" . $name . "</strong>";
	if ($presenting && ($presenting == 'true')) echo "<span class='text-warning'><strong>*</strong></span>";
	if ($email) echo " (<a href='mailto:$email'>" . $email . "</a>)"; 
	$first=false;
}  ?>
<br>
	<?php the_excerpt(); ?>
  </div>
</article>
</div></div>

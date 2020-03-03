<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <header>
      <h1 class="entry-title"><?php the_title(); ?></h1>
      <?php //get_template_part('templates/entry-meta'); ?>
    </header>
    <div class="entry-content">
	<dl class="dl-horizontal">
	<dt>Author(s):</dt><dd><?php
	$first=true;
foreach( get_cfc_meta( 'abstract14-authors' ) as $key => $value ){ ?>
<?php 	$name = get_cfc_field( 'abstract14-authors','name', false, $key ); ?>
<?php 
	if (!$first) echo ", ";
	echo "<strong>" . $name . "</strong>";
	$first=false;
}  ?>
</dd>
	</dl>
<?php  if ( $pdf = get_cfc_field( 'poster14-pdf' , 'presentation-pdf' ) ) { ?>
<a href="<?php echo $pdf->guid; ?>" target="_blank" class=" alignright btn btn-primary btn-sm" >View Poster</a>
<?php } ?>
<div class="clearfix"></div>
	<?php the_content(); ?>
    </div>
    <footer>
		<a href="<?php echo site_url() ;?>/abstract14" class="btn btn-primary"><< All Abstracts</a>
	</footer>
  </article>
<?php endwhile; ?>

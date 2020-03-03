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
foreach( get_cfc_meta( 'abstract-authors' ) as $key => $value ){ ?>
<?php 	$name = get_cfc_field( 'abstract-authors','name', false, $key ); ?>
<?php 	$email = get_cfc_field( 'abstract-authors','email', false, $key ); ?>
<?php 	$presenting = get_cfc_field( 'abstract-authors','presenting', false, $key ); ?>
<?php 	$affiliation = get_cfc_field( 'abstract-authors','affiliation', false, $key ); ?>
<?php 
	if (!$first) echo ", ";
	echo "<strong>" . $name . "</strong>";
	if ($presenting && ($presenting == 'true')) echo "<span class='text-warning'><strong>*</strong></span>";
	if ($email) echo " (<a href='mailto:$email'>" . $email . "</a>)"; 
	if ($affiliation) echo ", <em>" . $affiliation . "</em>"; 
	$first=false;
}  ?>.
<br><span class='text-warning'><strong>*</strong></span><em> indicates the presenting author.</em></dd>
	</dl>
<?php  if ( $pdf = get_cfc_field( 'poster-pdf' , 'presentation' ) ) { ?>
<a href="<?php echo $pdf->guid; ?>" target="_blank" class=" alignright btn btn-primary btn-sm" >View Poster</a>
<?php } ?>
<div class="clearfix"></div>
	<?php the_content(); ?>
    </div>
    <footer>
		<a href="<?php echo site_url() ;?>/abstract" class="btn btn-primary"><< All Abstracts</a>
	</footer>
  </article>
<?php endwhile; ?>

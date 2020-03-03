<?php 
/* 
 * Show a single symposium presentation. 
 */ 
while (have_posts()) : the_post(); ?>
<article <?php post_class(); ?>>
<header>
<h2><small><?php the_title(); ?></small></h2>
</header>
<div class="entry-summary">
<div class="row">
<div class="col-xs-12">
<?php
	$subtitle='';
	switch ( get_cfc_field( 'presentation-details' , 'type' ) ) {
		case "Keynote":
			$subtitle = "Keynote Speaker";
			$view = "Slides";
			$back = "talk";
			break;
		case "Seed Fund Update": 
			$subtitle =  "Seed Fund Update";
			$view = "Slides";
			$back = "talk";
			break;
		case "Invited": 
			$subtitle =  "Talk";
			$view = "Slides";
			$back = "talk";
			break;
		case "Seed Talk": 
			$subtitle =  "Talk";
			$view = "Slides";
			$back = "talk";
			break;
		case "Poster": 
			$subtitle = "Poster";
			$view = "Poster";
			$back = "poster";
			break;
		default:
			$subtitle = "";
			$view = "";
			$back = "";
	}
	
	echo "<p><strong>";
	the_cfc_field( 'presentation-details' , 'all-authors' );
	echo "</strong>, <em>";
	the_cfc_field( 'presentation-details' ,'all-affiliations' );
	echo "</em></p>";
	echo "<p class='text-right'><span class='label label-info'>" . $subtitle . "</span></p>";
?>
<?php the_content(); ?>
</div>
<div class="col-xs-6 text-center">
<?php
	$the_presentation = get_cfc_field( 'presentation-details' ,'presentation' );
	if ( !empty( $the_presentation ) ) 
		$the_presentation = wp_get_attachment_url( $the_presentation->ID );
	else 
		$the_presentation = get_cfc_field( 'presentation-details' ,'presentation-url' );
		
	if ( !empty( $the_presentation ) ) 
		echo "<a class='btn btn-primary btn-sm' href='$the_presentation' target='_blank'>View " . $view . "</a>";
?>
</div>
<div class="col-xs-6 text-center">
<?php
	$the_video = get_cfc_field( 'presentation-details' ,'video-url' );
	echo ( !empty( $the_video ) ) ? 
		"<a class='btn btn-primary btn-sm' href='" . get_cfc_field( 'presentation-details' ,'video-url' ) . "' target='_blank'>Video</a>" : 
		"" ;
?>
</div>
</div>
</div>
</article>
<?php endwhile; ?>
<ul class="breadcrumb">
	<li><a href="<?php echo home_url(); ?>">IDIES</a></li>
	<li><a href="<?php echo home_url(); ?>/symposium/">Symposium</a></li>
	<li><a href="<?php echo home_url(); ?>/symposium/<?php the_cfc_field( 'presentation-details' , 'year' ); ?>-annual-symposium/"><?php the_cfc_field( 'presentation-details' , 'year' ); ?> Annual Symposium</a></li>
</ul>

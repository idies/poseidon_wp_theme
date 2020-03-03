<?php
/* 
 * Show the page content then the archive of symposium presentations. 
 * This is a template for a page.
 */ 
?>
<?php 
while (have_posts()) : the_post(); 
	the_content(); 
	echo "<!-- Showing content -->";
endwhile; 

$thisYear = get_query_var( 'idies-year' , 2016 );
$thisType = get_query_var( 'idies-type' , 'agenda' );

if ( !check_wck() ) return;

// Get the presentations custom post type
$args = array( 'post_type' => 'presentation', 
			   'posts_per_page' => -1, 
			   'post_status' => 'publish');
$pposts = get_posts( $args );

$allPresentations=array();

foreach ( $pposts as $post ) :
 
	setup_postdata( $post ); 
	if ($result  = get_the_presentation( $thisYear ) ) $allPresentations[] = $result;

endforeach;


switch ( $thisType ) {
	case 'posters':
		show_posters( $allPresentations );
	break;
	case 'talks':
		show_talks( $allPresentations );
	break;
	case 'speakers':
		show_bios( $allPresentations );
	break;
	case 'agenda':
	default:
		show_agenda( $allPresentations );
		show_posters( $allPresentations , false );
}

wp_reset_postdata(); 
?>

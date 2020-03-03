<?php
/* 
 * Show archive of all symposium presentations. 
 * This is a template for an archive.
 */ 
?>
<?php //Get Query vars from URL 
$thisYear = get_query_var( 'idies-year' , 2018 );
$thisType = get_query_var( 'idies-type' , 'agenda' );
?>
<?php 	
if ( !check_wck() ) return;

$allPresentations=array();
$i=0;
while (have_posts()) : the_post(); 	

	echo "<!-- " . ++$i . " -->\n";
	//$result = get_the_presentation( $thisYear );
	if ($result  = get_the_presentation( $thisYear ) ) $allPresentations[] = $result;

endwhile; 
echo "<!-- " . count( $allPresentations ) . " -->";

if ( empty( $allPresentations ) ) {
	echo "<span class='label label-warning'>No Presentations found for $thisYear</span><br>";
	return;
}

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


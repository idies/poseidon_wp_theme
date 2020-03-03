<?php
/**
 * Functions for displaying Symposium Presentations
 *
 */
 
/* 
 * Get the presentations for this year. 
 */ 
function get_the_presentation( $thisYear ) {

	$thisPresentation = get_cfc_meta( 'presentation-details' );
	
	//Get only the data we need for posters or talks, get all for agenda.
	if ( !( $thisYear === $thisPresentation[0]['year'] ) ) {
		echo "<!-- skipping " . get_the_title() . "-->";
		return; 
	}

	//grab all the data for parsing
	$thisPresentation[0]['the_title'] = get_the_title();
	$thisPresentation[0]['permalink'] = get_the_permalink();
	$thisPresentation[0]['excerpt'] = get_the_excerpt();
	$thisPresentation[0]['abstract'] = get_the_content();
	
	return $thisPresentation[0];
}

/* 
 * Show posters with or without the abstract excerpt 
 */ 
function show_posters( $allPresentations , $excerpt=true ) {

	// Sort and display posters by Title
	uasort( $allPresentations , 'sort_pres_by_title' );
	$thisposter = 0;
	$result = "";
	
	foreach ( $allPresentations as $thisPresentation ) :
		if  ( 'Poster' !== $thisPresentation['type'] ) continue;
		$thisposter++;
		$result .= "<div class='poster-abstracts'>";
		$result .= "<h3><small>Poster #"."$thisposter: <a href='" . $thisPresentation['permalink'] . "'>" . 
			$thisPresentation['the_title'] . "</a></small></h3>";
		$result .= "<strong>" . $thisPresentation['all-authors'] . "</strong>, <em>" . 
			$thisPresentation['all-affiliations'] . "</em><br>";
		$result .= ( $excerpt ) ? $thisPresentation['excerpt'] : '';
		//$result .= ( $excerpt ) ? $thisPresentation['abstract'] : '';
		$result .= "</div>";
	endforeach ;

	if (empty( $result ) ) {
		$result = "<span class='label label-warning'>No posters found. </span><br>";
	} else {
		$result = ( $excerpt ) ? "<h2><small>Poster Abstracts</small></h2>" . $result : "<h2><small>Poster Session</small></h2>" . $result ;
	}
	echo $result;
	return;


}

/* 
 * Show speaker bios
 */ 
function show_bios( $allPresentations ) {
	// Sort and display speaker biographies, order by Author 
	uasort( $allPresentations , 'sort_pres_by_title' );
	$result = "";

	foreach ( $allPresentations as $thisPresentation ) :
		//if  ( in_array( $thisPresentation[ 'type' ] , array( 'Poster' , 'Other' , 'Short Talk' ) ) ) continue;
		if  ( in_array( $thisPresentation[ 'type' ] , array( 'Poster' , 'Other' ) ) ) continue;
		
		$result .= "<div class='talk-speakers'>";
		
		$result .= "<div class='pull-right'>" . 
			wp_get_attachment_image( 
				$thisPresentation['profile-picture'] , 
				"thumbnail" , 
				"", 
				array( "class" => "img-responsive" ) ) 
			. "</div>";

		$result .= ( empty( $thisPresentation['presenting-author'] ) ) ? 
			"<h2><small>" . $thisPresentation['all-authors'] . "</small></h2>" : 
			"<h2><small>" . $thisPresentation['presenting-author'] . "</small></h2>";
			
		if  ( 'Keynote' === $thisPresentation['type'] )  
			$result .= "<strong>KEYNOTE SPEAKER</strong><br>";

		$result .= ( empty( $thisPresentation['position'] ) ) ? "<p>" : "<p><em>" . $thisPresentation['position'] . "</em>, " ;
		$result .= ( empty( $thisPresentation['presenter-affiliation'] ) ) ? 
			$thisPresentation['all-affiliations'] . ".</p>": 
			$thisPresentation['presenter-affiliation'] . ".</p>";

		$result .= $thisPresentation['biography'];
		$result .= "</div>";
		$result .= "<div class='clearfix'></div>";
	endforeach ;
	
	if ( empty( $result ) ) {
		$result = "<span class='label label-warning'>No posters found. </span><br>";
	}
	echo $result;
	return;
}

/* 
 * Show talks with abstract excerpt 
 */ 
function show_talks( $allPresentations , $excerpt=true ) {
	// Sort and display presentations by Title
	uasort( $allPresentations , 'sort_pres_by_title' );
	$result = "";

	foreach ( $allPresentations as $thisPresentation ) :
		if  ( in_array( $thisPresentation[ 'type' ] , array( 'Poster' , 'Other' ) ) ) continue;
		
		$result .= "<div class='talk-abstracts'>";
		
		$result .= "<h3><small><a href='" . $thisPresentation['permalink'] . "'>" . 
			$thisPresentation['the_title'] . "</a></small></h3>";
		if  ( 'Keynote' == $thisPresentation['type'] )  
			$result .= "<strong>KEYNOTE SPEAKER</strong><br>";
		if  ( 'Seed Fund' == $thisPresentation['type'] )  
			$result .= "<strong>Seed Fund Update</strong><br>";
		$result .= $thisPresentation['all-authors'] . ", <em>" . 
			$thisPresentation['all-affiliations'] . "</em><br>";
		$result .= ( $excerpt ) ? $thisPresentation['excerpt'] : '';
		$result .= "</div>";
	endforeach ;

	if ( empty( $result ) ) {
		$result = "<span class='label label-warning'>No talks found.</span><br>";
	} else {
		$result = "<h2><small>Talk Abstracts</small></h2>" . $result ;
	}
	echo $result;
	return;
}

/* 
 * Show agenda
 */ 
function show_agenda( $allPresentations ) {
	// Sort and display talks by start time
	uasort( $allPresentations , 'sort_pres_by_time' );
	$count = 0;
	foreach ( $allPresentations as $thisPresentation ) :
		if ( ( "Poster" === $thisPresentation['type'] )  || ( "00:00" === $thisPresentation['start-time'] ) ) continue;
		$count++;
	endforeach;
	if ( $count == 0 ) {
		echo "<span class='label label-warning'>No agenda found.</span><br>";
		return;
	}	

	// Show everything except Posters that have start/end time
?>
	<h2><small>Agenda</small></h2>
	<table class="table table-condensed idies-agenda">
	<thead></thead>
	<tbody>
<?php
	foreach ( $allPresentations as $thisPresentation ) :
	
		if ( "Poster" === $thisPresentation['type'] ) continue;
		if ( "00:00" === $thisPresentation['start-time'] ) continue;
		
		echo "<tr>";
		echo "<td><span class='idies-hour'>";
		echo $thisPresentation['start-time'];
		echo "</span></td>";
		echo "<td>";

		echo "";		
		switch ($thisPresentation['type']) {
			case ("Other") :
				echo "<span class='idies-break'>" . $thisPresentation['the_title'] . "</span><br>";
				echo "<span class='idies-affiliation'>" . $thisPresentation['abstract'] . "</span>";
			break;
			case ("Keynote") :
				echo "<span class='idies-keynote'>Keynote Speaker</span><br>";
				echo "<span class='idies-title'>" . 
					"<a href='" . $thisPresentation['permalink'] . "'>" . 
					$thisPresentation['the_title'] . 
					"</a></span><br>";
				echo "<span class='idies-speaker'>" . $thisPresentation['all-authors'] . "</span>, ";
				echo "<span class='idies-affiliation'>" . $thisPresentation['all-affiliations'] . "</span>";
				break;
			case ("Seed Fund") :
				echo "<span class='idies-seed'>Seed Fund Update</span><br>";
				echo "<span class='idies-title'>" . 
					"<a href='" . $thisPresentation['permalink'] . "'>" . 
					$thisPresentation['the_title'] . 
					"</a></span><br>";
				echo "<span class='idies-speaker'>" . $thisPresentation['all-authors'] . "</span>, ";
				echo "<span class='idies-affiliation'>" . $thisPresentation['all-affiliations'] . "</span>";
				break;
			case ("Invited") :
			case ("Short Talk") :
				echo "<span class='idies-title'>" . 
					"<a href='" . $thisPresentation['permalink'] . "'>" . 
					$thisPresentation['the_title'] . 
					"</a></span><br>";
				echo "<span class='idies-speaker'>" . $thisPresentation['all-authors'] . "</span>, ";
				echo "<span class='idies-affiliation'>" . $thisPresentation['all-affiliations'] . "</span>";
				break;
			break;
		}
		echo "</td>";
		echo "</tr>";
		
	endforeach ;
?>
	</tbody>
	</table><?php
	
}

/* 
 * User defined Sorting of associative array - by post title
 */ 
function sort_pres_by_title( $a , $b ) {
	
	//sort by primary department
    return ( strcmp( $a['the_title'] , $b['the_title'] ) < 0 ) ? -1 : 1;
}

/* 
 * User defined Sorting of associative array - by start time
 */ 
function sort_pres_by_time( $a , $b ) {
	
	//sort by primary department
    return ( strcmp( $a['start-time'] , $b['start-time'] ) < 0 ) ? -1 : 1;
}
?>

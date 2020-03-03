<div class="well">
<article <?php post_class(); ?>>
  <header>
    <h3 class="entry-title"><?php echo get_post_format(); ?><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
  </header>
  <div class="entry-summary">
  <div class="row">
  <div class="col-xs-12">
<?php 
	$location = ' Where: ';
	$location .= ( get_cfc_field( 'events-details' , 'short-location' ) ) ?
		get_cfc_field( 'events-details' , 'short-location' ) :
		'TBD'; 
	
	$event_date = ' When: ';
	$event_date .= ( $begin_date = new DateTime( get_cfc_field( 'events-details' , 'event-date' ) ) ) ?
		 $begin_date->format('F d, Y') :
		'TBD';
	if ( get_cfc_field( 'events-details' , 'event-end-date' ) ) {
		$event_date .= ( $end_date = new DateTime( get_cfc_field( 'events-details' , 'event-end-date' ) ) ) ?
			 ' to ' . $end_date->format('F d, Y') :
			'';
	}
	
	if ( $show_times = get_cfc_field( 'events-details' , 'show-times' ) ) :
		$event_date .= ( $start_time = get_cfc_field( 'events-details' , 'start-time' ) ) ?
			', ' . $start_time :
			'';
//		$event_date .= ( $end_time = get_cfc_field( 'events-details' , 'end-time' ) ) ?
//			' - ' . $end_time :
			'';
	endif;
	
	echo '<ul class="fa-ul">';
	echo '<li><i class="fa-li fa fa-map"></i><strong>' . $location . '</strong></li>';
	echo '<li><i class="fa-li fa fa-calendar"></i><strong>' . $event_date . '</strong></li>';
	if ( $speaker = get_cfc_field( 'events-details' , 'speaker' ) ) :
		echo "<li><i class='fa-li fa fa-microphone'></i><strong>$speaker</strong></li>";
	endif;
	if ( get_cfc_field( 'events-details' , 'genomics' ) ) :
		echo '<li><i class="fa-li fa fa-at"></i><strong> A Genomics@JHU Seminar</strong></li>';
	endif;
	if ( get_cfc_field( 'events-details' , 'bi-monthly' ) ) :
		echo '<li><img class="idies-glyph"  src="' . get_bloginfo('template_url') . '/assets/img/idies-d-minicon-14.png"> <strong>An IDIES Bi-Monthly Seminar</strong></li>';
	endif;
	echo '</ul>';
?>
<?php the_excerpt(); ?></div>
  </div>
  </div>
</article>
</div>

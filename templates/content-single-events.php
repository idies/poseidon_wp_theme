<?php while (have_posts()) : the_post(); ?>
<article <?php post_class(); ?>>
  <header>
    <h2 class="entry-title"><?php the_title(); ?></h2>
  </header>
  <div class="entry-summary">
  <div class="row">
  <div class="col-xs-12">
<?php 
	$location = ' Where: ';
	$location .= ( get_cfc_field( 'events-details' , 'location' ) ) ?
		get_cfc_field( 'events-details' , 'location' ) :
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
	
	if ( get_cfc_field( 'events-details' , 'genomics' ) ) :
		$info_btn = "<p><a href='/news-events/genomics/' " . 
			"target='_blank' class='btn btn-primary'>Genomics @ JHU Seminar Series</a></p>";
	elseif ( get_cfc_field( 'events-details' , 'bi-monthly' ) ) :
		$info_btn = "<p><a  href='/news-events/bimonthly/' " . 
			"target='_blank' class='btn btn-primary'>IDIES Bi-Monthly Seminar</a></p>";
	else:
		$info_text = ( $info_text = get_cfc_field( 'events-details' , 'more-info' ) ) ?
			 $info_text:
			'';
		$info_btn = ( $url = get_cfc_field( 'events-details' , 'url' ) ) ?
			 "<p><a href='$url' target='_blank' class='btn btn-primary'>$info_text</a></p>":
			'';
	endif;
		
?>
<ul class="fa-ul">
<?php
	if ( $speaker = get_cfc_field( 'events-details' , 'speaker' ) ) :
		echo "<li><i class='fa-li fa fa-microphone'></i><strong>$speaker</strong></li>";
	endif;
	if ( get_cfc_field( 'events-details' , 'genomics' ) ) :
		echo '<li><i class="fa-li fa fa-at"></i><strong>A Genomics@JHU Seminar</strong></li>';
	endif;
	if ( get_cfc_field( 'events-details' , 'bi-monthly' ) ) :
		echo '<li><img class="idies-glyph"  src="' . get_bloginfo('template_url') . '/assets/img/idies-d-minicon-14.png"> <strong>An IDIES Bi-Monthly Seminar</strong></li>';
	endif;
?>
<li><i class="fa-li fa fa-calendar"></i><strong><?php echo $event_date; ?></strong></li>
<li><i class="fa-li fa fa-map"></i><strong><?php echo $location; ?></strong></li>
<?php
	if ( $info = get_cfc_field( 'events-details' , 'info' ) ) :
		echo "<li><i class='fa-li fa fa-info-circle'></i><strong>$info</strong></li>";
	endif;
?>
</ul>
<?php the_content(); ?>
<?php echo $info_btn; ?>
</div>
  </div>
  </div>
</article><?php endwhile; ?>
<p class="text-right"><a href="/news-events/events/" class="btn btn-warning">View All Events</a></p>

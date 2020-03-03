<?php 
global $post;
get_template_part('templates/page', 'header'); 
while (have_posts()) : the_post(); 
	the_content(); 
endwhile; 

$today = time();
$pastHeader=false;
$upcomingHeader=false;

// Set up (past events) pagination.
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

// Get all the seminars.
$event_args = array(
	'paged'				=> $paged,
	'post_type'        => 'events',
	'post_status'      => 'publish',
	'orderby'			=> 'meta_value_num',
	'order'            => 'DESC',
	'meta_key'         => 'timestamp',
	'meta_query'		=> array(
		'key'			=> 'genomics',
		'value'			=> 'Yes',
		'compare'		=> 'LIKE',
	),
);
$events_query = new WP_Query( $event_args );
if ( $events_query->have_posts() ) {
	while ( $events_query->have_posts() ) { 
		$events_query->the_post();	// Start the Loop
		$thistimestamp  = get_post_meta( get_the_id() , 'timestamp' , true );
		if ( !$upcomingHeader && $today < $thistimestamp ) {
			$upcomingHeader = true;
			echo '<h2>Upcoming Seminars</h2>';
		} elseif ( !$pastHeader && $today > $thistimestamp ) {
			$upcomingHeader = true;
			$pastHeader = true;
			echo '<h2>Past Seminars</h2>';
		}
		//echo "<h3>" . $thistimestamp . ": " . date('Y-m-d h:i', $thistimestamp ) . "</h3>";
		get_template_part('templates/content', 'genomics'); 
	} 
	// Show Events Pagination
	?>
<nav class="post-nav">
	<ul class="pager">
		<li class="previous"><?php next_posts_link( 'Earlier Events', $events_query->max_num_pages ); ?></li>
		<li class="next"><?php previous_posts_link( 'More Recent Events' ); ?></li>
	</ul>
</nav>
<?php
	wp_reset_postdata();
} else {
	?><div class="alert alert-warning">No upcoming seminars found</div><?php 
}

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

// Get all the events.
$event_args = array(
	'paged'				=> $paged,
	'post_type'			=> 'events',
	'post_status'		=> 'publish',
	'orderby'			=> 'meta_value_num',
	'order'				=> 'desc',
	'meta_key'			=> 'timestamp',
);
$events_query = new WP_Query( $event_args );

if ( $events_query->have_posts() ) {
	while ( $events_query->have_posts() ) { 
		$events_query->the_post();	// Start the Loop
		$thistimestamp  = get_post_meta( get_the_id() , 'timestamp' , true );
		if ( !$upcomingHeader && $today < $thistimestamp ) {
			$upcomingHeader = true;
			echo '<h2>Upcoming Events</h2>';
		} elseif ( !$pastHeader && $today > $thistimestamp ) {
			$upcomingHeader = true;
			$pastHeader = true;
			echo '<h2>Past Events</h2>';
		}
		get_template_part('templates/content', 'events'); 
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
	?><div class="alert alert-warning">No upcoming events found</div> <?php
}

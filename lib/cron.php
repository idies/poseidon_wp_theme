<?php
/**
 * Set up IDIES wp-cron schedules and tasks
 */

/****************************************************/
/*                ADD CRON SCHEDULES                */
/****************************************************/
add_filter( 'cron_schedules', 'sdss_add_cron_intervals' );
function sdss_add_cron_intervals( $schedules ) {
   
    $schedules['fiveminute'] = array(
        'interval' => 300,
        'display'  => esc_html__( 'Every 5 Minutes' ),
    );
   
    $schedules['oneminute'] = array(
        'interval' => 60,
        'display'  => esc_html__( 'Every Minute' ),
    );
   
    return $schedules;
}

/****************************************************/
/*                DELETE OLD CRON EVENTS                */
/****************************************************/
//wp_clear_scheduled_hook('idies_events_hook');
//wp_clear_scheduled_hook('sm_ping');
//wp_clear_scheduled_hook('do_pings');

/****************************************************/
/*                SET UP CRON EVENTS                */
/****************************************************/
if ( ! wp_next_scheduled( 'idies_events_hook' ) ) {
	wp_schedule_event( time(), 'oneminute', 'idies_events_hook' );
}

/****************************************************/
/*                ADD CRON TASKS                    */
/****************************************************/
//add_action( 'idies_events_hook', 'idies_events_hook_exec' );

/****************************************************/
/*                EXECUTE CRON TASKS             */
/****************************************************/
function idies_events_hook_exec() {
	idies_order_events();
}

/****************************************************/
/*                TASKS                             */
/****************************************************/
function idies_order_events(){
	// Get all the events. Separate them into upcoming and past events. Put events with no date first.
	$msg = '';
	$event_args = array(
		'posts_per_page'	=> -1,
		'offset'   			=> 0,
		'orderby'			=> 'date',
		'post_type'			=> 'events',
		'post_status'		=> 'publish',
	);
	$all_events = new WP_Query( $event_args );
	if ( $all_events->have_posts() ) {
		$msg .= "Have posts. \n";
		while ( $all_events->have_posts() ) {
			$all_events->the_post(); // Enter the Loop
			$enddate = get_post_meta( get_the_id() , 'event-end-date' , true );
			if ( empty( $enddate ) ) $enddate = get_post_meta( get_the_id() , 'event-date' , true );
			$endtime = get_post_meta( get_the_id() , 'end-time' , true );
			$timestamp = DateTime::createFromFormat( "d-m-Y H:i:s" , "$enddate $endtime:00"  );		
			//$msg .= get_the_id() . " " . $timestamp->format('Y-m-d H:i:s') . ". \n";
			$msg .= get_the_id() . " " . $timestamp->getTimestamp() . ". \n";
			update_post_meta( get_the_id() , 'timestamp' , $timestamp->getTimestamp() );
			
		/*/
			
		/*/
		}
		wp_reset_postdata(); // Return to original Loop
	} else {
		$msg .= "Have posts";
	}
	//wp_mail( 'bsouter@jhu.edu', 'WordPress Cron Working', $msg , true ) ;

}
<?php
//Not using this filter currently
// Replaces the get_the_excerpt "more" text with a button
function idies_excerpt_more( $excerpt  ) {
	if ( has_excerpt() && ! is_attachment() ) 
		$excerpt  .= '<p><a class="btn btn-primary" href="'. get_permalink($post->ID) . '"> Read More</a></p>';
	return $excerpt ;
}
//add_filter('get_the_excerpt', 'idies_excerpt_more');

// use widgets_init action hook to execute custom function
add_action( 'widgets_init', 'idies_register_widgets' );

 //register our widget
function idies_register_widgets() {
    register_widget( 'idies_show_posts_by_type_widget' );
}
class idies_show_posts_by_type_widget extends WP_Widget {
	
	//post-type specific display variables
	private $default_vars = array(
		'show_date' => true,
		'blurb_length' => 30,
		);
	private $post_vars = array(
		'show_date' => true,
		'blurb_length' => 30,
		);
	private $jobs_vars = array(
		'show_date' => true,
		'blurb_length' => 20,
		);
	private $funding_vars = array(
		'show_date' => false,
		'blurb_length' => 20,
		);
	private $events_vars = array(
		'show_date' => false,
		'blurb_length' => 30,
		);
	private $default_args = array(
		'posts_per_page' => 2,
		'orderby'=>'date' , 
		);
	private $post_args = array(
		'posts_per_page' => 2,
		'orderby'=>'date' , 
		);
	private $jobs_args = array(
		'posts_per_page' => 2,
		'orderby'=>'date' , 
		//'meta_key'     => 'filled',
		//'meta_value'   => 'Filled',
		//'meta_compare' => 'NOT LIKE',
		);
	private $funding_args = array(
		'posts_per_page' => 2,
		'orderby'=>'rand' , 
		);
	private $events_args = array(
		'posts_per_page' => 2,
		'orderby'=>'date' , 
		'meta_key'			=> 'past',
		'meta_value'		=> 'No',
		);
	
	function __construct() {
		parent::__construct(
			'idies_show_posts_by_type_widget_class', // Base ID
			__( 'IDIES Display Posts by Type', 'text_domain' ), // Name
			array( 'description' => __( 'IDIES Display Posts by Custom Post Type', 'text_domain' ), ) 
		);
	}

	
	  //build the widget settings form
    function form($instance) {
        $defaults = array( 	'title' => '' , 
							'type' => '' , 
						 );
        $instance = wp_parse_args( (array) $instance, $defaults );
        $title = $instance['title'];
        $type = $instance['type'];
        ?>
        <p>Title: <input class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>"  type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
        <p>Type: <input class="widefat" name="<?php echo $this->get_field_name( 'type' ); ?>"  type="text" value="<?php echo esc_attr( $type ); ?>" /></p>
        <?php
    }
	
	 //save the widget settings
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['type'] = strip_tags( $new_instance['type'] );

        return $instance;
    }
	
	//display the widget
    function widget($args, $instance) {
		
		if ( empty( $instance['type'] ) ) return;
		
        $type = $instance['type'];

        $args['type'] = $type;
		$args['title'] = empty( $instance['title'] ) ? '' : "<h3>" . $instance['title'] . "</h3>";
		
		// How to display the posts
		$display_vars = ( property_exists( $this , $type . '_vars' ) ) ? $type . "_vars" : 'default_vars';
		foreach ( $this->$display_vars as $key => $value ) $args[$key] = $value ;
		
		// How to select the posts
		$display_args = ( property_exists( $this , $type . '_args' ) ) ? $type . "_args" : 'default_args';

		$args['archive'] = $this->get_archive_options($type);
		
        extract($args);
		
		// Arguments to find individual posts
		$type_query_args['post_type'] = $type;
		foreach ( $this->$display_args as $key => $value ) $type_query_args[$key] = $value ;

		$args['type_query'] = new WP_Query( $type_query_args );
		
		if ( !( $args['type_query']->have_posts() ) ) return;

		echo $before_widget;

		$display_type = ( method_exists( $this , 'show_' . $type ) ) ? 'show_' . $type : 'show_default' ;
		call_user_func( array( $this , $display_type ) , $args );
			
		echo '<div><a class="btn btn-warning pull-right" style="margin-top: 5px; margin-bottom: 10px" href="' . $archive['slug'] . '">' . $archive['title'] . ' Archive</a></div>';
		echo '<div class="clearfix"></div>';

		echo $after_widget;
			
		return;
    }

	function show_default( $args ) {
		extract( $args );
		
		echo "<div class='show-posts'>";
		echo "<h3>" . $title . "</h3>";
		while ( $type_query->have_posts() ) : $type_query->the_post();
			echo "<div class='show-post-excerpt'>";
			echo "<a href='" . get_permalink(  ) . "'><h4>" . get_the_title(  ) . "</h4></a>";
			if ($show_date) echo '<p class="show-date"><i class="fa fa-calendar"></i> <strong>Posted: ' . get_the_date() . '</strong></p>';
			echo "<p>" . get_the_excerpt(  ) . "</p>";
			echo '<p><a class="btn btn-primary" href="'. get_permalink( get_the_id() ) . '">Read More</a></p>';
			echo "</div>";
		endwhile;
		echo "</div>";
		
		return;
	}
	
	function show_post( $args ) {
		extract( $args );
		
		echo "<div class='show-posts'>";
		echo "<h3>" . $title . "</h3>";
		while ( $type_query->have_posts() ) : $type_query->the_post();
			echo "<div class='show-post-excerpt'>";
			echo "<a href='" . get_permalink(  ) . "'><h4>" . get_the_title(  ) . "</h4></a>";
			if ($show_date) echo '<p class="show-date"><i class="fa fa-calendar"></i> <strong>Posted: ' . get_the_date() . '</strong></p>';
			echo "<p>" . wp_trim_words( get_the_excerpt(  ) , $blurb_length ) . "</p>";
			echo '<p><a class="btn btn-primary" href="'. get_permalink( get_the_id() ) . '">Read More</a></p>';
			echo "</div>";
		endwhile;
		echo "</div>";
		
		return;
	}
	
	function show_funding( $args ) {
		extract( $args );
		
		echo "<div class='show-posts'>";
		echo "<h3>" . $title . "</h3>";
		
		$post_count = 0;
		while ( $type_query->have_posts() && ( $post_count < 3 ) ) : $type_query->the_post();
			if ( get_cfc_field( $type.'-details' , 'archive-after' ) ) {
				$archive_after = date_create( get_cfc_field( $type.'-details' , 'archive-after' ) );
				if ( date_create( NULL ) > $archive_after ) {
					//set this fopp status to 'draft'
					endraftinator_ray( get_the_id() );
					continue;
				}
			} else unset($archive_after);
			echo "<div class='show-post-excerpt'>";
			echo "<a href='" . get_permalink(  ) . "'><h4>" . get_the_title(  ) . "</h4></a>";
			if ($show_date) echo '<p class="show-date"><i class="fa fa-calendar"></i>&nbsp;<strong>Added: ' . get_the_date() . '</strong></p>';
			if ( $the_sponsor = get_cfc_field( $type.'-details' , 'sponsor' ) ) echo '<p><strong>Sponsor: ' . $the_sponsor . '</strong></p>';
			if ( $deadline_cpt = get_cfc_field( $type.'-details' , 'deadlines' ) ) echo '<p><strong>Deadline(s): ' . $deadline_cpt->post_title . '</strong></p>';
			echo "<p>" . wp_trim_words( get_the_excerpt(  ) , $blurb_length ) . "</p>";
			echo '<p><a class="btn btn-primary" href="' . $archive['slug'] . '/#' . get_the_id() . '">Read More</a></p>';
			echo "</div>";
			$post_count++;
		endwhile;
		echo "</div>";
		
		return;	}
	
	function show_jobs( $args ) {
		extract( $args );
		
		echo "<div class='show-posts'>";
		echo "<h3>" . $title . "</h3>";
		while ( $type_query->have_posts() ) : $type_query->the_post();
			if ( get_post_meta( get_the_id() , 'filled' , true ) == 'Filled' ) continue;
			echo "<div class='show-post-excerpt'>";
			echo "<a href='" . get_permalink(  ) . "'><h4>" . get_the_title(  ) . "</h4></a>";
			if ($show_date) echo '<p class="show-date"><i class="fa fa-calendar"></i>&nbsp;<strong> Posted: ' . get_the_date() . '</strong></p>';
			echo "<p>" . wp_trim_words( get_the_excerpt(  ) , $blurb_length ) . "</p>";
			if ( $deadline_cpt = get_cfc_field( $type.'-details' , 'closing-date' ) ) echo '<p><strong>Closing Date: ' . $deadline_cpt->post_title . '</strong></p>';
			echo '<p><a class="btn btn-primary" href="'. get_permalink( get_the_id() ) . '">Read More</a></p>';
			echo "</div>";
		endwhile;
		echo "</div>";
		
		return;	}
	
	function show_events( $args ) {
		extract( $args );
		
		echo "<div class='show-posts'>";
		echo "<h3>" . $title . "</h3>";
		while ( $type_query->have_posts() ) : $type_query->the_post();
		
			$location = ( $location = get_cfc_field( $type.'-details' , 'short-location' ) ) ?
				$location = ' Where: ' . $location :
				$location = '';

			$event_date = ( $event_date = new DateTime( get_cfc_field( $type.'-details' , 'event-date' ) ) ) ?
				$event_date = ' When: ' . $event_date->format('F d, Y') :
				$event_date = '';
				
			$event_time = ( $event_time = get_cfc_field( $type.'-details' , 'event-time' ) ) ?
				$event_time = ', ' . $event_time :
				$event_time = '';

			echo "<div class='show-post-excerpt'>";
			echo "<a href='" . get_permalink(  ) . "'><h4>" . get_the_title(  ) . "</h4></a>";
			echo "<p>" . wp_trim_words( get_the_excerpt(  ) , $blurb_length ) . "</p>";
			echo "<p>";
			if ( $location ) echo '<i class="fa fa-map"></i><strong>' . $location . '</strong><br />';
			if ( $event_date ) echo '<i class="fa fa-calendar"></i><strong>' . $event_date . $event_time . '</strong>';
			echo "</p>";
			echo '<p><a class="btn btn-primary" href="'. get_permalink( get_the_id() ) . '">Read More</a></p>';
			echo "</div>";
		endwhile;
		echo "</div>";
		
		return;	}
		// Gets the options for the names of archive pages from the options set in 
	// the IDIES Options Page.
	function get_archive_options( $type ) {
		
		$archivepages = get_option('archivepages');
		
		foreach ($archivepages as $this_option){
		
			if ( strcmp( $this_option['post-type'] , $type ) === 0 ) {
				
				$archive_options['title'] = $this_option['title'];
				$archive_options['slug'] = $this_option['archive-slug'];
				break;
				
			} else {
				
				$archive_options['title'] = ucfirst( $type );
				$archive_options['slug'] = $type ;
				
			}
		}
		
		return $archive_options;
    }
}
?>

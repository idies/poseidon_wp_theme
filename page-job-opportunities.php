<?php get_template_part('templates/page', 'header'); ?>
<?php
$args = array(
	'posts_per_page'   => -1,
	'offset'   => 0,
	'orderby'          => 'title',
	'order'            => 'ASC',
	'post_type'        => 'jobs',
	'post_status'      => 'publish',
);
$posts_array = get_posts( $args );
?>
<p class="h4 pull-right">
<?php // START EXPANDED - THERE ARE FEW ?>
<button class="btn btn-danger" id="expand-all" data-group="jobs-group">Collapse All</button>
</p>
<div class="clearfix">&nbsp;</div>
<div class="jobs-group">
<?php
$shown = 0;
foreach ( $posts_array as $post ) : setup_postdata( $post ); 
	//if (get_cfc_field( 'jobs-details' , 'filled' )) continue;
		get_template_part('templates/content', 'jobs');
	$shown++;
endforeach;
?>
<?php if ( !$shown ) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no open positions at this time.', 'roots'); ?>
  </div>
<?php endif; ?>
</div>
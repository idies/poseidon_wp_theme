<?php
get_template_part('templates/page', 'header-affiliated-centers'); 

/* 
 * Show affiliated centers on the affiliates page. 
 */ 

while (have_posts()) : the_post(); 
	the_content(); 
endwhile; 

$i=1;

$centers = get_posts( array(
		'posts_per_page'   => -1,
		'orderby'          => 'title',
		'order'          => 'ASC',
		'exclude'		=>	'1168',
		'post_type'        => 'center',
		'post_status'      => 'publish',
	) );


?>
<div>
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" >
		<li role="presentation" ><a href="/affiliates/" class="h4">Faculty Members</a></li>
		<li role="presentation" ><a href="/affiliates/execcomm/" class="h4">Executive Committee</a></li>
		<li role="presentation" ><a href="/affiliates/staff/" class="h4">Staff</a></li>
		<li role="presentation" class="active"><a href="/affiliates/affiliated-centers/" class="h4">Affiliated JHU Centers</a></li>
	</ul>

	<div role="tabpanel" class="tab-pane">
		<div class="row">
			<div class="col-xs-12">
<?php
				foreach ( $centers as $post ) : 
					setup_postdata( $post );
					get_template_part( 'templates/content-affiliated-centers' ); 
				endforeach; 
				wp_reset_postdata();
?>
			</div>
		</div>
	</div>
</div>

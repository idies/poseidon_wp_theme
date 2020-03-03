<?php
get_template_part('templates/page', 'header-people'); 
/* 
 * Show ExecComm page. 
 */ 

while (have_posts()) : the_post(); 
	the_content(); 
endwhile; 

$alexcomm = get_posts( array(
		'posts_per_page'   	=> -1,
		'orderby'          	=> 'meta_value',
		'meta_key'			=> 'last-name',
		'order'          	=> 'ASC',
		'post_type'        	=> 'affiliate',
		'post_status'      	=> 'publish',
		'meta_query' => array(
							'relation' => 'AND',
							array(
								'key'			=> 'executive-committee',
								'value' 		=> 'Yes' ,
								'compare'		=>	'='
							),
							array(
								'key'			=> 'last-name',
								'value' 		=> 'Szalay' ,
								'compare'		=>	'='
							),
						),
	) );
$execcomm = get_posts( array(
		'posts_per_page'   	=> -1,
		'orderby'          	=> 'meta_value',
		'meta_key'			=> 'last-name',
		'order'          	=> 'ASC',
		'post_type'        	=> 'affiliate',
		'post_status'      	=> 'publish',
		'meta_query' => array(
							'relation' => 'AND',
							array(
								'key'			=> 'executive-committee',
								'value' 		=> 'Yes' ,
								'compare'		=>	'='
							),
							array(
								'key'			=> 'last-name',
								'value' 		=> 'Szalay' ,
								'compare'		=>	'!='
							),
						),
	) );
	
global $schools;
$tmp_schools = get_posts( array(
		'posts_per_page'   	=> -1,
		'post_type'        	=> 'school-division',
		'post_status'      	=> 'publish',
	) );
foreach( $tmp_schools as $this_school ) $schools[$this_school->ID] = $this_school;

global $depts;
$tmp_depts = get_posts( array(
		'posts_per_page'   	=> -1,
		'post_type'        	=> 'department',
		'post_status'      	=> 'publish',
	) );
foreach( $tmp_depts as $this_dept ) $depts[$this_dept->ID] = $this_dept;

?>
<div>
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" >
		<li role="presentation" ><a href="/affiliates/" class="h4">Faculty Members</a></li>
		<li role="presentation" class="active"><a href="/affiliates/execcomm" class="h4">Executive Committee</a></li>
		<li role="presentation"><a href="/affiliates/staff/" class="h4">Staff</a></li>
		<li role="presentation" ><a href="/affiliates/affiliated-centers/" class="h4">Affiliated JHU Centers</a></li>
	</ul>
	<div role="tabpanel" class="tab-pane">
		<div class="row">
<?php
			foreach ( $alexcomm as $post ) : 
				setup_postdata( $post );
				get_template_part( 'templates/content-execcomm' );
			endforeach; 
			wp_reset_postdata();
			foreach ( $execcomm as $post ) : 
				setup_postdata( $post );
				get_template_part( 'templates/content-execcomm' );
			endforeach; 
			wp_reset_postdata();
?>
		</div>
	</div>
</div>

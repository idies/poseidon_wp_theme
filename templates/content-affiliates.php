<?php
/* 
 * Show affiliated people on the affiliates page. 
 */ 
?>
<?php 
while (have_posts()) : the_post(); 
	the_content(); 
endwhile; 

// get and flatten schools, centers, depts, and affiliates (putting school info in depts and dept/center info in affiliates

$all_affiliates = idies_get_affiliates( "last" );
$all_affiliates = get_affiliate_wells( $all_affiliates );

$all_departments = idies_get_departments( $all_affiliates );
$all_schools = idies_get_schools( $all_affiliates );

$people_affiliates = idies_filter_affil( $all_affiliates , "staff" , FALSE );

$i=1;

?>
<div>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs">
    <li role="presentation" class="active"><a href="/affiliates/" class="h4">Faculty Members</a></li>
    <li role="presentation"><a href="/affiliates/execcomm" class="h4">Executive Committee</a></li>
	<li role="presentation"><a href="/affiliates/staff/" class="h4">Staff</a></li>
    <li role="presentation" ><a href="/affiliates/affiliated-centers" class="h4">Affiliated JHU Centers</a></li>
  </ul>

  <!-- Tab panes -->
	<div class="tab-content">
  
		<!-- People pane -->
		<div role="tabpanel" class="tab-pane active filterz" id="people">
			<div class="row">
				<div class="col-sm-9 col-xs-12">
					<div class="sortablz" data-sortablz-safemode>
					<div class="filterz-filters"></div>
						<?php show_orderby( $orderby_options = array( 'last' => 'Last Name', 'dept' => 'Department'  , 'school' => 'School' ) , $i++ ) ; ?>
						<div class='row filterz-targets'>
							<div class="filterz-noresults text-center"></div>
							<?php foreach ( $people_affiliates as $this_affiliate) echo $this_affiliate['well']; ?>
						</div>
					</div>
				</div>
				<!-- Show sidebar controls -->
				<div class="col-sm-3 hidden-xs">
					<div class="filterz-overview">Showing <span class="showing"></span> of <span class="total"></span> Members</div>
				</div>
				<div class="col-sm-3 hidden-xs">
					<div class="form-inline filterz-controls">
						<div class="panel panel-default">
							<div class="panel-heading"><h4>Schools <div class="alignright"><a role="button" data-toggle="collapse" href="#people-collapseSch" aria-expanded="false" aria-controls="collapseSch"><i class="fa fa-bars fa-3"></i></a></div></h4></div>
								<div class="panel-body collapse in " id="people-collapseSch">
									<?php // toggles for schools
									foreach($all_schools as $this_key=>$this_school) {
										echo '<div class="form-group">';
										echo "<label><input type='checkbox' role='toggle' data-toggle='filterz' data-group='sch' data-target='$this_key'> <span class='name'>";
										echo $this_school['display_name'] . " </span><span class='count'></span></label>";
										echo '</div><br>';
									} ?>
								</div>
							</div>
<?php
							// create a well for departments
							// show all departments ?>
							<div class="panel panel-default">
							<div class="panel-heading"><h4>Departments <div class="alignright"><a role="button" data-toggle="collapse" href="#people-collapseDept" aria-expanded="false" aria-controls="collapseDept"><i class="fa fa-bars fa-3"></i></a></div></h4></div>
								<div class="panel-body collapse in" id="people-collapseDept">
<?php
									// toggles for departments
								foreach($all_departments as $this_key=>$this_department) {
									echo '<div class="form-group">';
									echo "<label><input type='checkbox' role='toggle' data-toggle='filterz'  data-group='dept' data-target='$this_key'> <span class='name'>";
									echo $this_department['display_name'] . " </span><span class='count'></span></label>";
									echo '</div><br>';
								}
?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php //AFFILIATE FUNCTIONS 


// Show the Order By options
function show_orderby( $options = array() , $i ) {

	echo "<div class='form-horizontal orderby_options text-center panel panel-info'>";
	echo "<div class='panel-heading'>";
	echo "<div class='row '>";
	echo "<div class='col-sm-3 col-xs-12'><strong>Order by: </strong></div>";
	
	$checked = 'checked=true';
	foreach ( $options as $this_option_value => $this_option_name ) {		
		echo "<div class='col-sm-3 col-xs-12'>";
		echo "<label><input type='radio' name='sortablz$i' data-toggle='sortablz' data-sortablz='$this_option_value' $checked >$this_option_name</label>";
		echo "</div>";
		$checked = '';
	}
	
	echo "</div>";
	echo "</div>";
	echo "</div>";
	
	return;
}

// Get an affiliate in a formatted well.
function get_affiliate_well( $this_affiliate , $affil_class = "" , $attributes = "") {
	$result =  "<div class='sortablz-target' >";
	$result .=  "<div class='$affil_class sortablz-contents' $attributes>";
	$result .= "<div class='col-lg-4 col-sm-6 col-xs-12'>";
	$result .= "<div class='well'>";
	$result .= "<p class='bigger'><strong><a href='" . home_url() . "/affiliates/" . $this_affiliate['post_title'] . "'>" . $this_affiliate['display_name'] . "</a></strong></p>";
	if ( !empty( $this_affiliate['idies_title'] ) ) $result .= "<p>" . $this_affiliate['idies_title'] . "</strong></p>";
	$result .= "<p>";
	foreach( $this_affiliate[ 'depts' ] as $this_dept ) $result .= '<em>' . $this_dept['display_name'] . '</em><br />';
	$result .= "</p>\n<p>";
	foreach( $this_affiliate[ 'schools' ] as $this_school ) $result .= '<strong>' . $this_school['display_name'] . '</strong><br />';
	$result .= "</p>\n</div>";
	$result .= "</div>\n</div>\n</div>";
	
	return $result;
}

// Format Affiliate wells, including classes and attributes.
// Add key that contains well markup to $affiliates array and return 
// augmented array.
// 
function get_affiliate_wells( $the_affiliates ) {

	foreach ( $the_affiliates as $this_affiliate) {
	
		//target class allows sidebar controls to show hide schools and departments
		$target_class = ' filterz-target filterz-' . implode( ' filterz-' , array_keys( $this_affiliate[ 'schools' ] ) );
		if ( count( $this_affiliate[ 'depts' ] ) ) $target_class .= ' filterz-' . implode( ' filterz-' , array_keys( $this_affiliate[ 'depts' ] ) );
		
		//sortablz data fields allow toggles to control order of affiliates
		$sortablz_class = " data-last='" . $this_affiliate['last_name'] . "' ";
		$sortablz_class .= ( !empty( $this_affiliate[ 'idies_title' ] ) ) ? " data-title='" . $this_affiliate['idies_title'] . "' " : "";
		if ( count( $this_affiliate['schools'] ) ) {
			$school_keys = array_keys( $this_affiliate['schools'] );
			$sortablz_class .= " data-school='" . $this_affiliate[ 'schools' ][$school_keys[0]][ 'display_name' ] . "' ";
		}
		if ( count( $this_affiliate['depts'] ) ) {
			$dept_keys = array_keys( $this_affiliate['depts'] );
			$sortablz_class .= " data-dept='" . $this_affiliate[ 'depts' ][$dept_keys[0]][ 'display_name' ] . "' ";
		}
		$this_affiliate['well'] = get_affiliate_well( $this_affiliate , $target_class , $sortablz_class );
		$new_affiliates[] = $this_affiliate;
	}
	
	return $new_affiliates;
}

 /*
 *
 * Get Data About Affiliates
 * 
 */
function idies_get_affiliates( $orderby = 'last'  ) {
	
	$affiliate_name = -1; //for debugging
	
	$all_affiliate_info = array();

	$affiliate_args = array(
		'posts_per_page'   => -1,
		'offset'   		   => 0,
		'meta_key'			=> 'last-name',
		'order'          	=> 'ASC',
		'post_type'        	=> 'affiliate',
		'post_status'      	=> 'publish',
		'meta_query' => array(
			'key'			=> 'category',
			'value' 		=> 'full' ,
		)
	);
	if 	( !$affiliates_array = get_posts( $affiliate_args ) ) return $all_affiliate_info;

	// get them all
	foreach( $affiliates_array as $this_affiliate ) {
	
		//check if getting all (-1) or a few
		if ( ( $affiliate_name === -1 ) || (in_array( $this_affiliate->post_name , $affiliate_name ) ) ) {		
		
			//idies_debug( $this_affiliate );
			
			$this_affiliate_meta = get_post_meta( $this_affiliate->ID , 'affiliate-details' , true);
			
			$affiliate_info['post_title'] = $this_affiliate->post_name;
			$affiliate_info['ID'] = $this_affiliate->ID;
			$affiliate_info['display_name'] = empty( $this_affiliate->post_title ) ? '' : $this_affiliate->post_title;
			$affiliate_info['last_name'] = empty( $this_affiliate_meta[0]['last-name'] ) ? '' : $this_affiliate_meta[0]['last-name'];
			$affiliate_info['email'] = empty( $this_affiliate_meta[0]['email-address'] ) ? '' : $this_affiliate_meta[0]['email-address'];
			$affiliate_info['url'] = empty( $this_affiliate_meta[0]['url'] ) ? '' : $this_affiliate_meta[0]['url'] ;
			$affiliate_info['phone'] = empty( $this_affiliate_meta[0]['phone-number'] ) ? '' : $this_affiliate_meta[0]['phone-number'];
			$affiliate_info['address'] = empty( $this_affiliate_meta[0]['campus-address'] ) ? '' : $this_affiliate_meta[0]['campus-address'] ;
			$affiliate_info['execcomm'] = empty( $this_affiliate_meta[0]['executive-committee'] ) ? false : true ;
			$affiliate_info['staff'] = empty( $this_affiliate_meta[0]['staff'] ) ? false : true ;
			$affiliate_info['idies_title'] = empty( $this_affiliate_meta[0]['idies-title'] ) ? '' : $this_affiliate_meta[0]['idies-title'] ;
			
			$get_depts = array();
			$get_schools = array();

			foreach ( get_cfc_meta( 'dept-center-affiliations' ,  $affiliate_info['ID'] ) as $key => $value) {
			
				// get dept info from cfc data
				$this_dept = get_cfc_field( 'dept-center-affiliations' , 'department-or-center' , $affiliate_info['ID'] , $key );
				$this_sch = get_cfc_field( 'department-details' , 'schooldivision' , $this_dept->ID );
				
				// save dept, but skip if school and dept are same . i.e. Sheridan Libraries
				if( !( strcmp( $this_dept->post_title , $this_sch->post_title ) === 0 ) ) {
				
					//key is class name, value array holds ID and display name
					$get_depts[ 'dept-' . $this_dept->ID ] = array( 'ID' => $this_dept->ID ,
																	'display_name' => $this_dept->post_title );
				}
				
				// save school, but skip if already saved (i.e. more than one dept in same school)
				if ( !in_array( 'sch' . $this_sch->ID , $get_schools ) ) {
					//key is class name, value array holds ID and display name
					$get_schools[ 'sch-' . $this_sch->ID ] = array( 'ID' => $this_sch->ID ,
																	'display_name' => $this_sch->post_title );
				}
			}
			$affiliate_info['depts'] = $get_depts;
			$affiliate_info['schools'] = $get_schools;
			
			$all_affiliate_info[$this_affiliate->post_name] = $affiliate_info;
			$affiliate_info = array();
		}
	}

	//idies_debug( $all_affiliate_info );

	//default is order by last_name
	switch ( $orderby ) {
		case 'dept':
			uasort( $all_affiliate_info , 'idies_sort_by_dept' );
		break;
		case 'school' :
			uasort( $all_affiliate_info , 'idies_sort_by_school' );
		break;
		case 'title' :
			uasort( $all_affiliate_info , 'idies_sort_by_title' );
		break;
		case 'last' :
		default:
			uasort( $all_affiliate_info , 'idies_sort_by_last' );
	}
	return $all_affiliate_info ;

}

/*
 *
 * Get Departments from Affiliates (not all departments, only ones with affiliates)
 * 
 */
function idies_get_departments( $all_affiliates ) {

	$all_department_info = array();

	foreach( $all_affiliates as $this_affiliate ) {
		foreach( $this_affiliate['depts'] as $this_dept_key=>$this_dept ){
	
			if ( !in_array( $this_dept_key , $all_department_info ) ) {
				$all_department_info[ $this_dept_key ] = $this_dept;
			}
		}
	}
	
	//idies_debug( $all_department_info );
	uasort( $all_department_info , 'idies_sort_by_display_name' );
	return $all_department_info ;
}

/*
 *
 * Get Schools from Affiliates (not all schools, just ones with affiliates)
 * 
 */
function idies_get_schools( $all_affiliates ) {

	$all_school_info = array();

	foreach( $all_affiliates as $this_affiliate ) {
		foreach( $this_affiliate['schools'] as $this_school_key=>$this_school ){
	
			if ( !in_array( $this_school_key , $all_school_info ) ) {
				$all_school_info[ $this_school_key ] = $this_school;
			}
		}
	}
	
	//idies_debug( $all_school_info );
	uasort( $all_school_info , 'idies_sort_by_display_name' );
	return $all_school_info ;
}

// Works with uasort to custom sort the Affiliates associative array.
// Sorts by the last_name field.  
function idies_sort_by_last( $a , $b ) {

	// If last names are the same, sorts by display_name (essentially first name).
	if ( strcmp( $a['last_name'], $b['last_name'] ) === 0 ) {
		if ( strcmp( $a['display_name'], $b['display_name'] ) === 0 ) {
			return 0;
		} else {
			return ( strcmp( $a['display_name'] , $b['display_name'] ) < 0 ) ? -1 : 1;
		}
    }
    return ( strcmp( $a['last_name'] , $b['last_name'] ) < 0 ) ? -1 : 1;
}

// Works with uasort to custom sort the Affiliates associative array.
// Sorts by school.  
function idies_sort_by_school( $a , $b ) {

	//if neither has a school, sort by last name.
	//if only one is empty, put it last
	if ( !( count( $a['schools'] ) + count( $b['schools'] )  ) ) {
		return idies_sort_by_last( $a , $b );
	} elseif ( !(count( $a['schools'] ) ) ) {
		return 1;
	} elseif ( !(count( $b['schools'] ) ) ) {
		return 1;
	}

	$afirst = current( $a[ 'schools' ] );
	$bfirst = current( $b[ 'schools' ] );
	
	//if neither has a school, or both in same school, sort by last name.
	if ( strcmp( $afirst['display_name'], $bfirst['display_name'] ) === 0 ) {
		return idies_sort_by_last( $a , $b );
	}
	
	//sort by primary school
    return ( strcmp( $afirst['display_name'] , $bfirst['display_name'] ) < 0 ) ? -1 : 1;
}

// Works with uasort to custom sort the Affiliates associative array.
// Sorts by department.  
function idies_sort_by_dept( $a , $b ) {

	//if neither has a department, sort by last name.
	//if only one is empty, put it last
	if ( !( count( $a['depts'] ) + count( $b['depts'] )  ) ) {
		return idies_sort_by_last( $a , $b );
	} elseif ( !(count( $a['depts'] ) ) ) {
		return 1;
	} elseif ( !(count( $b['depts'] ) ) ) {
		return 1;
	}

	$afirst = current( $a[ 'depts' ] );
	$bfirst = current( $b[ 'depts' ] );
	
	//if both in same school, sort by last name.
	if ( strcmp( $afirst['display_name'], $bfirst['display_name'] ) === 0 ) {
		return idies_sort_by_last( $a , $b );
	}
	
	//sort by primary department
    return ( strcmp( $afirst['display_name'] , $bfirst['display_name'] ) < 0 ) ? -1 : 1;
}

// Works with uasort to custom sort the Affiliates associative array.
// Sorts by (IDIES) Title.  
function idies_sort_by_title( $a , $b ) {

	//if neither has a title, sort by last name.
	//if only one is empty, put it last.
	if ( !( count( $a['idies_title'] ) + count( $b['idies_title'] )  ) ) {
		return idies_sort_by_last( $a , $b );
	} elseif ( !(count( $a['idies_title'] ) ) ) {
		return 1;
	} elseif ( !(count( $b['idies_title'] ) ) ) {
		return 1;
	}

	//if both have same title, sort by last name.
	if ( strcmp( $a['idies_title'], $b['idies_title'] ) === 0 ) {
		return idies_sort_by_last( $a , $b );
	}
	
	//sort by primary department
    return ( strcmp( $a['idies_title'] , $b['idies_title'] ) < 0 ) ? -1 : 1;
}

// Works with uasort to custom sort the Departments associative array.
// Sorts by department display_name.  
// There should never be two departments with the same display name.
function idies_sort_by_display_name( $a , $b ) {

	//sort by display_name
    return ( strcmp( $a['display_name'] , $b['display_name'] ) < 0 ) ? -1 : 1;
}

// Filter the affiliates array to only include affiliates with $filter, or,
// not include affiliates with filter.  
function idies_filter_affil( $the_affiliates , $filter , $is = true ){
	$result = array();
	foreach( $the_affiliates as $this_affiliate ) {
		if ( empty( $this_affiliate[ $filter ] ) xor $is ) $result[] = $this_affiliate;	
	}
	return $result;
}

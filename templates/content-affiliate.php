<div class="well">
<article <?php post_class(); ?>>
  <header>
    <p class="entry-title h4"><?php echo get_post_format(); ?><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
  </header>
  <div class="entry-summary">
  <div class="row">
  <div class="col-xs-12">
<?php 
if (check_wck()) : 

	$all_divisions = array(); 
	$all_affiliations = array();
	
	foreach (  get_cfc_meta( 'dept-center-affiliations' ) as $key => $value ) {
		
		$the_affiliation = get_cfc_field( 'dept-center-affiliations','department-or-center', false, $key ) ;
		$the_affiliation_meta = get_post_meta( $the_affiliation->ID , 'department-details' , true );
		
		$affiliation_title = $the_affiliation->post_title;
		$division_title = get_the_title(  $the_affiliation_meta[0]['schooldivision'] );
		
		if ( !(in_array( $division_title , $all_divisions ) ) )  $all_divisions[] = $division_title;
		
		if ( !(in_array( $affiliation_title , $all_affiliations ) ) &&
			( strcmp( $affiliation_title , $division_title ) !== 0 ) )  $all_affiliations[] = $affiliation_title;
		} 
		
	if ( count( $all_affiliations ) ) echo "<div><em>" . implode(", ",$all_affiliations) . "</em></div>";
	if ( count( $all_divisions ) ) echo "<div><strong>" . implode(", ",$all_divisions) . "</strong></div>";
	
endif; //check_cfc_field ?>

  <p/></div>
  </div>
  </div>
</article>
  </div>

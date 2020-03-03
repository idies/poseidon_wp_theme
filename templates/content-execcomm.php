<?php 
//Shows the execcomm archive
global $post;
global $schools;
global $depts;

$max_depts=3;
$affil_depts='';
$dkey = 'department-or-center';
$skey = 'schooldivision';
for ( $i = 1 ; $i <= $max_depts ; $i++ ){
	if ( $this_dept = $post->$dkey ){

		$affil_depts[] = $depts[$this_dept]->post_title;
		$affil_schools[] = $schools[ $depts[ $this_dept ]->$skey ]->post_title;

	} else {
		break;
	}
	$dkey = 'department-or-center_' . $i;
}
$affil_schools = array_unique( $affil_schools );
$affil_depts = '<em>' . join( '</em><br><em>', $affil_depts ) .  '</em><br>';
$affil_schools = '<strong>' . join( '</strong><br><strong>', $affil_schools ) .  '</strong><br>';
$affil_title = $post->{'idies-title'};
?>
<div class="col-lg-4 col-sm-6 col-xs-12">
	<div class="well well-affiliate">
		<p class="bigger"><strong><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></strong></p>
		<p><?php echo $affil_title; ?></p>
		<p><?php echo $affil_depts; ?></p>
		<p><?php echo $affil_schools; ?></p>
	</div>
</div>

<?php while (have_posts()) : the_post(); ?>
<article <?php post_class(); ?>>
<header>
<h2><?php echo get_post_format(); ?><?php the_title(); ?></h2>
<?php if ( check_wck() ) {$idies_title = get_cfc_field( 'affiliate-details' , 'idies-title' ) ; } ?>
<?php if (!empty($idies_title) ) { ?><p class="lead"><?php echo $idies_title; ?>, IDIES</p><?php } ?>
</header>
<div class="entry-summary">
<div class="row">
<?php if ( has_post_thumbnail() ) : ?>
<div class="col-sm-3 col-xs-hidden pull-right"><?php the_post_thumbnail( 'thumbnail' ); ?></div>
<div class="col-sm-9 col-xs-12">
<?php else : ?>
<div class="col-xs-12">
<?php endif ; ?>
<?php if (check_wck()) : ?>
<?php 	
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
?>
<dl class='dl-horizontal'>
<?php if ( count( $all_affiliations ) ) echo "<dt>Department(s):</dt><dd>" . implode("<br>",$all_affiliations) . "</dd>";?>
<?php if ( count( $all_divisions ) ) echo "<dt>School or Division:</dt><dd>" . implode("<br>",$all_divisions) . "</dd>";?>
</dl>
<ul class="fa-ul">
<?php if ( get_cfc_field( 'affiliate-details' , 'campus-address' ) ) : ?>
<li><i class="fa-li fa fa-map-pin"></i><?php the_cfc_field( 'affiliate-details' , 'campus-address' ); ?></li>
<?php endif; ?>
<?php if ( get_cfc_field( 'affiliate-details' , 'phone-number' ) ) : ?>
<li><i class="fa-li fa fa-phone"></i><?php the_cfc_field( 'affiliate-details' , 'phone-number' ); ?></li>
<?php endif; ?>
<?php if ( get_cfc_field( 'affiliate-details' , 'email-address' ) ) : ?>
<li><i class="fa-li fa fa-envelope"></i><a href="mailto:<?php the_cfc_field( 'affiliate-details' , 'email-address' ); ?>" target="_blank">Email</a></li>
<?php endif; ?>
<?php if ( get_cfc_field( 'affiliate-details' , 'url' ) ) : ?>
<li><i class="fa-li fa fa-globe"></i><a href="<?php the_cfc_field( 'affiliate-details' , 'url' ); ?>" target="_blank">Website</a></li>
<?php endif; ?>
</ul>
<?php endif; //check_cfc_field ?>
</div>
<div class="col-xs-12">
<h3>Custom Searches</h3>
<dl class="dl dl-horizontal">
<dt><a href="<?php echo add_query_arg( 'q', urlencode( get_the_title() ), 'https://www.jhu.edu/search/?c=gsa'); ?>" target="_blank"><strong>Search JHU</strong></a></dt><dd>Search the Johns Hopkins University websites for <?php the_title(); ?>.</dd>
<dt><a href="<?php echo add_query_arg( 'q', urlencode( get_the_title() ), 'https://scholar.google.com/scholar?hl=en'); ?>" target="_blank"><strong>Search Google Scholar</strong></a></dt><dd>Search Google Scholar for <?php the_title(); ?>.</dd>
</dl>
<div class="clearfix"><div>
</div>
<div class="col-xs-12">
<?php the_content(); ?>
</div>
</div>
</article>
<?php endwhile; ?>
<ul class="breadcrumb">
	<li><a href="<?php echo home_url(); ?>">IDIES</a></li>
	<li><a href="<?php echo home_url();?>/affiliates/"> Faculty Members</a></li>
	<li><?php the_title(); ?></li>
</ul>

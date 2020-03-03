<?php 	get_template_part('templates/page', 'header'); ?>
<h2>Public Datasets</h2>

<p class="lead">An incubator for creating, curating, and publishing new data sets, IDIES research centers around the generation and analysis of very large scientific databases. Several of these public online databases have been developed, including:</p>
<?php 	
//SHOW PUBLIC DATASETS IN CAROUSEL 
$publicdatasets = get_cfc_meta( 'publicdatasets' );
?>
<div id="carousel-public" class="carousel slide" data-ride="carousel">
<!-- Wrapper for slides -->
<div class="carousel-inner" role="listbox">
<?php
$i=0; 
foreach( $publicdatasets as $key => $value ) : 

	//SHOW DATA 
	$this_pic = get_cfc_field( 'publicdatasets' , 'pds-picture' , false, $key); 
?>
<div class="item <?php if (!$i) echo 'active' ; ?>">
<?php echo the_attachment_link( $this_pic , true , false , false ); ?>
<div class="flex-caption">
<p><?php the_cfc_field( 'publicdatasets','pds-caption' , false, $key ); ?></p>
<p><a class="btn btn-primary external-link" href="<?php the_cfc_field( 'publicdatasets','pds-explore-url' , false, $key); ?>">Explore</a></p>
</div>
</div>
<?php 		$i++; ?>
<?php	endforeach; ?>
</div>

<!-- Menu -->
<ul class="carousel-indicators nav nav-pills nav-justified">
<?php 	$i=0; ?>
<?php 	foreach( $publicdatasets as $key => $value ) : ?>
<li data-target="#carousel-public" data-slide-to="<?php echo $i; ?>" class="<?php if (!$i) echo 'active' ; ?>"><a href="#"><?php the_cfc_field( 'publicdatasets','pds-title' , false, $key ); ?></a></li>
<?php 		$i++; ?>
<?php	endforeach; ?>
</ul>

</div>

<?php 	//SHOW OTHER DATASETS IN WELLS ?>
<h2>Other Datasets</h2>

<p class="lead">IDIES researchers are also involved in other data-intensive engineering and science projects, such as:</p>
<div class="wells-group">
<div class="row">
<?php 	$i=0; ?>
<?php	foreach( get_cfc_meta( 'otherdatasets' ) as $key => $value ) : 
			$i++; 
			//GET DATA 
			if (! $the_title = get_cfc_field( 'otherdatasets','ods-title', false, $key ) ) continue; 
			$the_description = get_cfc_field( 'otherdatasets','ods-description', false, $key );	
			$the_picture = get_cfc_field( 'otherdatasets','ods-picture', false, $key );	
				
			//SHOW DATA 
			if ( $i & 1 ): ?><div class="col-xs-12 col-m-12 col-md-6"><?php endif; ?>
<div class="col-xs-12 col-sm-6 col-md-6">
<div class="well well-sm">
<?php 		if ($the_picture) : ?><div class="center-block"><?php the_attachment_link( $the_picture , true, false, true ); ?></div><?php endif; ?>
<h2><?php echo $the_title; ?></h2>
<?php 		if ($the_description) : echo $the_description; endif; ?>
</div>
</div>
<?php 		if ( !($i & 1) ): ?></div><?php endif; ?>
<?php	endforeach; ?>
<?php 	if ( $i & 1 ): ?></div><?php endif; ?>
</div>
</div>
<?php 	//SHOW USUAL CONTENT LAST?>
<?php 	get_template_part('templates/content', 'page'); ?>

<?php 	get_template_part('templates/page', 'header'); ?>
<?php 	//SHOW USUAL CONTENT ?>
<?php 	get_template_part('templates/content', 'page'); ?>
<?php 	//SHOW RESEARCH PROJECTS IN COLLAPSABLE ACCORDIONS ?>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
<?php 	$i=0; ?>
<?php 	foreach( get_cfc_meta( 'researchprojects' ) as $key => $value ) : ?>
<?php 	//GET DATA ?>
<?php 		if (! $the_title = get_cfc_field( 'researchprojects','title', false, $key ) ) continue; ?>
<?php		$the_description = get_cfc_field( 'researchprojects','description', false, $key );	?>
<?php		$the_picture = get_cfc_field( 'researchprojects','picture', false, $key );	?>
<?php		$the_button_text = get_cfc_field( 'researchprojects','button-text', false, $key ); ?>
<?php		$the_button_url = get_cfc_field( 'researchprojects','button-url', false, $key ); ?>
<?php 	//SHOW DATA ?>
<div class="panel panel-default">
<div class="panel-heading" role="tab" id="heading<?php echo $i; ?>">
<h2 class="panel-title"><a <?php if ($i) echo "class='collapsed'"; ?> role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse<?php echo $i; ?>"><?php echo $the_title; ?></a></h2>
</div>
<div id="collapse<?php echo $i; ?>" class="panel-collapse collapse <?php if (!$i) echo "in"; ?>" role="tabpanel" aria-labelledby="heading<?php echo $i; ?>">
<div class="panel-body">
<?php if ($the_picture) : ?><div class="pull-right"><?php the_attachment_link( $the_picture['id'] ); ?></div><?php endif; ?>
<?php if ($the_description) : echo $the_description; endif; ?>
<?php if(($the_button_text) && ($the_button_url)) : ?> 
<p class="align-left"><a class="btn btn-primary" href="<?php echo $the_button_url; ?>"><?php echo $the_button_text; ?></a></p>
<?php endif; ?>
</div>
</div>
</div>
<?php 		$i++; ?>
<?php	endforeach; ?>
</div>
<?php
if ( !function_exists( 'get_cfc_meta' ) ) return;
$idies_faqs = get_cfc_meta( 'faqs-meta' ); 
if ( !count( $idies_faqs ) ) return;
?>
<div class="clearfix"></div>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
<?php
$faq_num = 1;
$faq_in = ' in ';
$faq_collapsed = '';
foreach( $idies_faqs as $key => $value ) : 

	$faq_question = the_cfc_field('faqs-meta', 'question', false, $key, false);
	$faq_answer = the_cfc_field('faqs-meta', 'answer', false, $key , false);
	$faq_link = the_cfc_field('faqs-meta', 'link', false, $key , false);
	$faq_slug = the_cfc_field('faqs-meta', 'slug', false, $key , false);
?>
<div class="panel panel-default">
	<div class="panel-heading" role="tab" id="heading<?php echo $faq_num; ?>">
		<h4 class="panel-title">
		<a data-toggle="collapse" class="<?php echo $faq_collapsed; ?>" data-parent="#accordion" href="#collapse<?php echo $faq_num; ?>" aria-expanded="true" aria-controls="collapse<?php echo $faq_num; ?>">
		<?php echo $faq_question; ?>
		</a>
		</h4>
	</div>
	<div id="collapse<?php echo $faq_num; ?>" class="panel-collapse collapse <?php echo $faq_in; ?>" role="tabpanel" aria-labelledby="heading<?php echo $faq_num; ?>">
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-6 col-md-9">
					<?php echo $faq_answer; ?>
				</div>
				<div class="col-xs-3 col-md-3">
<?php 
					if ( !empty( $faq_slug ) && !empty( $faq_link ) ) :
?>
					<a class="btn btn-primary alignright" href="<?php echo home_url() . $faq_slug; ?>"><?php echo $faq_link; ?></a>
<?php 
					endif;
?>
				</div>
			</div>
		</div>
	</div>
</div> 
<?php
	$faq_num++;
	$faq_in = '';
	$faq_collapsed = ' collapsed ';
endforeach; 
?>
</div> 
<div class="clearfix"></div>

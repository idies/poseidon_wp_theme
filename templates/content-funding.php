<?php 
global $orderby; 
global $divideby; 
?>
<article <?php post_class(); ?> id="article-<?php the_id(); ?>">
  <header>
    <p class="h4 entry-title"><a data-toggle="collapse" class="article-toggle collapsed" href="#collapse<?php the_id(); ?>"  aria-expanded="false" aria-controls="collapse<?php the_id(); ?>"><?php echo get_post_format(); ?><?php the_title(); ?></a></p>
  </header>
  <div class="collapse" id="collapse<?php the_id(); ?>">
  <div class="entry-summary panel panel-default panel-body">
	<dl class="dl-horizontal">
	<!--dt>Official Title: </dt><dd><?php the_cfc_field('funding-details','official-title');?></dd-->
	<dt>Agency: </dt><dd><?php the_cfc_field('funding-details','sponsor');?></dd>
	<dt>Funding Locator: </dt><dd><?php the_cfc_field('funding-details','reference-number');?></dd>
	<dt>Description: </dt><dd><?php the_content(); ?></dd>
	<dt>Deadline(s): </dt>
	<dd><?php 
//Show long desciption of deadline for this Funding Opp. 
if ( $deadlines = get_cfc_field( 'funding-details' , 'deadlines' ) ) :
	$this_deadline = get_page_by_title( $deadlines->post_title , 'OBJECT' , 'deadline' );
	echo apply_filters('the_content', $this_deadline->post_content);
endif;
?></dd>
	</dl>
	<p class="text-right"><a href="<?php the_cfc_field('funding-details','url');?>" class="btn btn-primary external-link">View Full Description</a></p>
  </div>
  </div>
</article>

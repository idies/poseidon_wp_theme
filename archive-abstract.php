<?php get_template_part('templates/page', 'header'); ?>

<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'roots'); ?>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>
<?php if ($wp_query->max_num_pages > 1) : ?>
  <nav class="post-nav">
    <ul class="pager">
      <li class="previous"><?php previous_posts_link(__('&larr; More Abstracts', 'roots')); ?></li>
      <li class="next"><?php next_posts_link(__('More Abstracts &rarr;', 'roots')); ?></li>
    </ul>
  </nav>
<?php endif; ?>
<p class="alignright"><span class='text-warning'><strong>*</strong></span><em> indicates the presenting author.</em></p>
<div class="clearfix"></div>
<?php $count=0; ?>
<?php while (have_posts()) : the_post(); ?>
  <?php //echo get_post_format(); ?>
	<?php if ( !($count & 1) ) : //even?>
	<div class="row">
	<?php endif; ?>
  <?php get_template_part('templates/content', 'abstract' ); ?>
	<?php if ( ($count & 1) ) : //odd?>
	</div>
	<?php endif; ?>
	<?php $count++; ?>
<?php endwhile; ?>
<?php if ( ($count & 1) ) : //odd?>
</div>
<?php endif; ?>
<?php if ($wp_query->max_num_pages > 1) : ?>
  <nav class="post-nav">
    <ul class="pager">
      <li class="previous"><?php previous_posts_link(__('&larr; More Abstracts', 'roots')); ?></li>
      <li class="next"><?php next_posts_link(__('More Abstracts &rarr;', 'roots')); ?></li>
    </ul>
  </nav>
<?php endif; ?>

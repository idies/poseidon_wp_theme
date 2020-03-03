<?php 
get_template_part('templates/page', 'header'); 
?>

<?php 
// Show how many articles
//$count_posts = wp_count_posts( get_post_type() );
//$published_posts = $count_posts->publish;
//echo "<h3>" . $published_posts . " Article";
//if ($published_posts-1) echo "s";
//echo "</h3>";
$count=0;
?><div class='row'><?php
while (have_posts()) : the_post(); 
	?><div class='col-md-12 col-md-6'><?php
	get_template_part( 'templates/content' , get_post_type(  ) ); 
	?></div><?php
	echo ($count) ? "<div class='clearfix'></div>" : "" ;
	$count = 1-$count;
endwhile; 
?></div><?php
?>

<?php if ($wp_query->max_num_pages > 1) : ?>
  <nav class="post-nav">
    <ul class="pager">
      <li class="previous"><?php next_posts_link(__('&larr; Older posts', 'roots')); ?></li>
      <li class="next"><?php previous_posts_link(__('Newer posts &rarr;', 'roots')); ?></li>
    </ul>
  </nav>
<?php endif; ?>

<?php 
// Show Knowledgebase Articles
?>
<article <?php post_class( "panel panel-primary " ); ?> id="article-<?php the_id(); ?>">
  <header class="panel-heading">
    <p class="h4 entry-title panel-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
  </header>
  <div class="entry-summary panel-body">
	<?php the_excerpt(); ?>
	<p class="text-right"><a href="<?php the_permalink(); ?>"><em>Read Article</em><a></p>
  </div>
</article>

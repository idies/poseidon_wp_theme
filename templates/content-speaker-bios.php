<?php 
// Display the CPT
while (have_posts()) : 
	the_post(); 

?>
<article <?php post_class(); ?>>
  <header>
    <h2 class="entry-title"><?php echo get_post_format(); ?><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
  </header>
</article>
<?php 
endwhile; 
?>

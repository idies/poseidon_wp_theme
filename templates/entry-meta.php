<time class="updated" datetime="<?php echo get_the_time('c'); ?>">Posted: <?php echo get_the_date(); ?></time>
<?php if ( "knowledgebase" === get_post_type() ) :?>
<p class="byline author vcard"><?php echo __('By', 'roots'); ?> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn"><?php echo get_the_author(); ?></a></p>
<?php endif;?>

<?php while (have_posts()) : the_post(); ?>
<?php 	get_template_part('templates/content', 'funding'); ?>
<?php endwhile; ?>
<p class="text-right"><a href="/grants-funding/funding-opportunities/" class="btn btn-warning">View All Funding Opportunities</a></p>

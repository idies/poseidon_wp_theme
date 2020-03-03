<?php while (have_posts()) : the_post(); ?>
<?php 	get_template_part('templates/content', 'jobs'); ?>
<?php endwhile; ?>
<p class="text-right"><a href="/news-events/jobs-opportunities/" class="btn btn-warning">View All Job Opportunities</a></p>

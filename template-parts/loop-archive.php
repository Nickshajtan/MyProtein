<?php 
while ( have_posts() ) :
	the_post();

	if (is_archive()) :
		echo '<big> Category title:'.single_cat_title('',false).'</big>';
	else:
		echo '<big> Blog posts page title:'.single_post_title('',false).'</big>';
	endif;

	get_template_part( 'partials/content', 'post_intro' );

endwhile;
echo hcc_pagination_bar($wp_query);
the_posts_pagination();
?>
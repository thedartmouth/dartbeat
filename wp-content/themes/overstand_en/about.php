<?php
/*
Template Name: About Page
*/
?><?php get_header() ?>

<?php include (TEMPLATEPATH . '/menubar.php'); ?>
	

		<div id="content">
				

<?php the_post() ?>
			<div id="post-<?php the_ID(); ?>" class="<?php sandbox_post_class() ?>">
			
				<div class="entry-content">
<?php the_content() ?>

				</div>
			</div><!-- .post -->



		</div><!-- #content -->
		<?php get_sidebar() ?>
	</div><!-- #container -->
<!--<?php include (TEMPLATEPATH . '/bottom.php'); ?>-->
<?php get_footer() ?>
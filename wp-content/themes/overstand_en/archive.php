<?php get_header() ?>

	<div id="container">
	
	<div class="left-col">
		<?php the_post() ?>

<?php if ( is_day() ) : ?>
			<h2 class="page-title"><?php printf(__('Archives:<br/> <span>%s</span>', 'sandbox'), get_the_time(get_settings('date_format'))) ?></h2>
<?php elseif ( is_month() ) : ?>
			<h2 class="page-title"><?php printf(__('Archives:<br/> <span>%s</span>', 'sandbox'), get_the_time('F Y')) ?></h2>
<?php elseif ( is_year() ) : ?>
			<h2 class="page-title"><?php printf(__('Archives:<br/> <span>%s</span>', 'sandbox'), get_the_time('Y')) ?></h2>
<?php elseif ( isset($_GET['paged']) && !empty($_GET['paged']) ) : ?>
			<h2 class="page-title"><?php _e('Archives:<br/>', 'sandbox') ?></h2>
<?php endif; ?>
			</div>
			
			
		<div id="content">


<?php rewind_posts() ?>

<?php while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID() ?>" class="<?php sandbox_post_class() ?>">
				<h3 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink tou %s', 'sandbox'), wp_specialchars(get_the_title(), 1)) ?>" rel="bookmark"><?php the_title() ?></a></h3>
				
				<div class="entry-content">
<?php the_excerpt(''.__('Read More <span class="meta-nav">&raquo;</span>', 'sandbox').'') ?>

				</div>
				<div class="entry-meta">
					<span class="author vcard"><?php printf(__('By %s', 'sandbox'), '<a class="url fn n" href="'.get_author_link(false, $authordata->ID, $authordata->user_nicename).'" title="' . sprintf(__('View all posts by %s ', 'sandbox'), $authordata->display_name) . '">'.get_the_author().'</a>') ?></span>
				<span class="meta-sep">|</span>
					<span><?php the_date('d M y'); ?></span>
					<span class="meta-sep">|</span>
					<span class="cat-links"><?php printf(__('Posted in %s', 'sandbox'), get_the_category_list(', ')) ?></span>
					<span class="meta-sep">|</span>
<?php edit_post_link(__('Edit', 'sandbox'), "\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t<span class=\"meta-sep\">|</span>\n"); ?>
					<span class="comments-link"><?php comments_popup_link(__('Comments (0)', 'sandbox'), __('Comments (1)', 'sandbox'), __('Comments (%)', 'sandbox')) ?></span>
				</div>
			</div><!-- .post -->

<?php endwhile ?>

		
	
		</div><!-- #content .hfeed -->
		
		<?php get_sidebar() ?>
				<div id="nav-above" class="navigation">
				<div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&laquo;</span> Older posts', 'sandbox')) ?></div>
				<div class="nav-next"><?php previous_posts_link(__('<span class="meta-nav">&raquo;</span> Newer posts', 'sandbox')) ?></div>
			</div>
		<?php get_footer() ?>
	</div><!-- #container -->
<?php include (TEMPLATEPATH . '/bottom.php'); ?>	

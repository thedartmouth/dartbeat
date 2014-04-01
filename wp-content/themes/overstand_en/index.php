<?php get_header() ?>
<div id="index">


	<div id="container">
	
	<div class="left-col">
	<?php the_post() ?>
	<h2>Fresh</h2>
	</div>
	
	
	
	<div id="content">


<?php rewind_posts() ?>

<?php while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID() ?>" class="<?php sandbox_post_class() ?>">
				<h3 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink to %s', 'sandbox'), wp_specialchars(get_the_title(), 1)) ?>" rel="bookmark"><?php the_title() ?></a></h3>
				
				<div class="entry-content">
<?php the_excerpt(''.__('Read more <span class="meta-nav">&raquo;</span>', 'sandbox').'') ?>

				</div>
				<div class="entry-meta">
					<span class="author vcard"><?php printf(__('By %s', 'sandbox'), '<a class="url fn n" href="'.get_author_link(false, $authordata->ID, $authordata->user_nicename).'" title="' . sprintf(__('View all posts by %s', 'sandbox'), $authordata->display_name) . '">'.get_the_author().'</a>') ?></span>
				<span class="meta-sep">|</span>
					<span><?php the_date('d M y'); ?></span>
					<span class="meta-sep">|</span>
					<span class="cat-links"><?php printf(__('Published in %s', 'sandbox'), get_the_category_list(', ')) ?></span>
					<span class="meta-sep">|</span>
<?php edit_post_link(__('Edit', 'sandbox'), "\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t<span class=\"meta-sep\">|</span>\n"); ?>
					<span class="comments-link"><?php comments_popup_link(__('Comments (0)', 'sandbox'), __('Comments (1)', 'sandbox'), __('Comments (%)', 'sandbox')) ?></span>
				</div>
			</div><!-- .post -->

<?php endwhile ?>

			<div id="nav-below" class="navigation">
				<div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&laquo;</span> Older posts', 'sandbox')) ?></div>
				<div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&raquo;</span>', 'sandbox')) ?></div>
			</div>
	
		</div><!-- #content .hfeed -->
		
					<?php get_sidebar() ?>
				<div id="nav-above" class="navigation">
				<div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&laquo;</span> Older posts', 'sandbox')) ?></div>
				<div class="nav-next"><?php previous_posts_link(__('<span class="meta-nav">&raquo;</span> Newer posts', 'sandbox')) ?></div>
			</div>
	</div><!-- #container -->
		<?php include (TEMPLATEPATH . '/bottom.php'); ?>	
</div><!-- #index -->
<?php get_footer() ?>
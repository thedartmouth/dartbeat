<?php get_header() ?>

	<div id="container">
	<div class="left-col">
				<?php rewind_posts(); ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<h2 class="entry-title"><?php the_category(); ?>
				<?php the_title(); ?></h2>
				<h2 class="author"> <?php the_author_description(); ?></h2>
				<h2 class="author">by <?php the_author(); ?>
				</br></br><?php the_date('d M Y'); ?></h2>
				
			<div id="heartbeat"></div>
	<h2 class="menu-title">sections</h2>
		<h2 class="menu-title2"><a href="<?php echo get_category_link(3); ?>">all</a></h2>
		<h2 class="menu-title2"><a href="<?php echo get_category_link(4); ?>">campus</a></h2>
		<h2 class="menu-title2"><a href="<?php echo get_category_link(6); ?>">arts</a></h2>
		<h2 class="menu-title2"><a href="<?php echo get_category_link(1012); ?>">culture</a></h2>
		<h2 class="menu-title2"><a href="<?php echo get_category_link(5); ?>">sports</a></h2>
		
		

	<h2 class="menu-title">links</h2>
		<h2 class="menu-title2"><a href="http://www.thedartmouth.com">the dartmouth</a></h2>
		<h2 class="menu-title2"><a href="http://www.dartmouth.edu/dining/">dds</a></h2>
		<h2 class="menu-title2"><a href="http://bwa.dartmouth.edu">blitz</a></h2>
		<h2 class="menu-title2"><a href="http://www.dartmouth.edu/bannerstudent">banner</a></h2>
		<h2 class="menu-title2"><a href="https://blackboard.dartmouth.edu/">blackboard</a></h2>

	<h2 class="menu-title">blogroll</h2>
		<h2 class="menu-title2"><a href="http://blogdailyherald.com/">brown</a></h2>
		<h2 class="menu-title2"><a href="http://cornellsun.com/blog/">cornell</a></h2>
		<h2 class="menu-title2"><a href="http://spectrum.columbiaspectator.com/">columbia</a></h2>
		<h2 class="menu-title2"><a href="http://www.thecrimson.com/section/flyby/">harvard</a></h2>
		<h2 class="menu-title2"><a href="http://blogs.dailyprincetonian.com/prox/">princeton</a></h2>
		<h2 class="menu-title2"><a href="http://underthebutton.com/">upenn</a></h2>
		<h2 class="menu-title2"><a href="http://www.yaledailynews.com/news/blogs/cross-campus/">yale</a></h2>

				
<?php edit_post_link(__('Edit', 'sandbox'), "\n\t\t\t\t\t<span class=\"edit-link\">", "</span>"); ?></div>

</div>
	

<div id="post-<?php the_ID(); ?>" class="<?php sandbox_post_class(); ?>">





			
								<div class="entry-content">

			
<?php the_content(''.__('Read more <span class="meta-nav">&raquo;</span>', 'sandbox').''); ?>
<br><br>
<?php if(function_exists('kc_add_social_share')) kc_add_social_share(); ?>
<br>
<?php link_pages("\t\t\t\t\t<div class='page-link'>".__('Pages: ', 'sandbox'), "</div>\n", 'number'); ?>
				

<?php if (function_exists('the_tags') ) : ?>
<?php the_tags(); ?>
<?php endif; ?>

</div>
<?php if (function_exists('rps_show')) echo rps_show(); ?> 
	

<!-- <div class="entry-meta">
<div id="comments-headline"><h2 class="comments-headline">WHAT TO DO NOW?</h2></div>
			<div class="entry-meta-content"><?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) : // Comments and trackbacks open ?>
					<?php printf(__('<a class="comment-link" href="#respond" title="Post a comment">Post a comment</a> or leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'sandbox'), get_trackback_url()) ?>
<?php elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) : // Only trackbacks open ?>
					<?php printf(__('Comments are closed, but you can leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'sandbox'), get_trackback_url()) ?>
<?php elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) : // Only comments open ?>
					<?php printf(__('Trackbacks are closed, but you can <a class="comment-link" href="#respond" title="Post a comment">post a comment</a>.', 'sandbox')) ?>
<?php elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) : // Comments and trackbacks closed ?>
					<?php _e('Both comments and trackbacks are currently closed.') ?>
<?php endif; ?></div>

</div>

		<div id="nav-below" class="navigation">
		<h3>Read</h3>
				<div class="nav-previous"><?php previous_post_link('<span class="meta-nav">&laquo;</span> %link') ?></div>
    <div class="nav-next"><?php next_post_link('<span class="meta-nav">&raquo;</span> %link') ?></div>
				<h3>Read in <?php
foreach((get_the_category()) as $cat) { 
echo $cat->cat_name . ' '; 
} ?></h3>
			<div class="nav-previous"><?php previous_post_link('&laquo; %link', '%title', TRUE); ?></div>
			<div class="nav-next"><?php next_post_link('&raquo; %link', '%title', TRUE); ?></div>

				<?php if ( function_exists('related_posts')) :?>
			<h3>Related Posts</h3>
			<ul>				
			<?php related_posts(); ?>
			</ul>
	
		<?php endif; ?>
				

			</div>-->

<?php comments_template(); ?>
<?php endwhile;?><?php endif; ?>		

								
				<?php the_post(); ?>

</div><!-- .post -->

				<!-- #content -->

		<?php get_sidebar() ?>

<?php get_footer() ?>
	</div><!-- #container -->

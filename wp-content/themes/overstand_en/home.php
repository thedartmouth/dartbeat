<?php get_header() ?>



<div id="container">

<?php include (TEMPLATEPATH . '/menubar.php'); ?>


<?php rewind_posts() ?>


<ul class="latest2">
<?php if (function_exists('rps_show')) echo rps_show(); ?> 

 <?php if (have_posts()) : ?>
   <?php while (have_posts()) : the_post(); ?>
	<li class="list-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?> </a></li>
	<div class="alignright"><?php comments_popup_link(); ?>   </br><?php the_time('d M g:i A  '); ?></div>
	<li class="list-author"><h2>by <?php the_author(); ?></h2>
	<li class="latest-excerpt2"><?php the_excerpt(); ?></li><br><br>
    <?php endwhile; ?>    
  
<div class="navigation">
	<div class="alignright"><?php previous_posts_link('Newer &raquo;') ?></div>
	<div class="alignleft"><?php next_posts_link(' &laquo; Older','') ?></div>
	<br><br>
</div>

</div>

  </div>
<?php else : ?>
  <h2 class="center">Not Found</h2>
 <p class="center"><?php _e("Sorry, but you are looking for something that isn't here."); ?></p>
  <?php endif; ?>


</ul>
	<?php get_sidebar() ?>

	</div><!-- #container -->
	



	<?php get_footer() ?>
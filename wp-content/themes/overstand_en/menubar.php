<div class="menubar">	
	<?php if( is_front_page()) : ?>
	<h2 class="menu-title"><a href="<?php echo get_page_link(11); ?>">about us</a></h2>
	<h2 class="menu-title"><a href="<?php echo get_page_link(761); ?>">contact us</a></h2>
	<?php endif;?>
	

	
	<h2 class="menu-title">sections</h2>
		<h2 class="menu-title2"><a href="<?php echo get_category_link(3); ?>">all</a></h2>
		<h2 class="menu-title2"><a href="<?php echo get_category_link(4); ?>">campus</a></h2>
		<h2 class="menu-title2"><a href="<?php echo get_category_link(6); ?>">arts</a></h2>
		<h2 class="menu-title2"><a href="<?php echo get_category_link(1012); ?>">culture</a></h2>
		<h2 class="menu-title2"><a href="<?php echo get_category_link(5); ?>">sports</a></h2>

	<h2 class="menu-title">links</h2>
		<h2 class="menu-title2"><a href="http://www.thedartmouth.com">the dartmouth</a></h2>
		<h2 class="menu-title2"><a href="http://www.thedartmouth.com/community">community</a></h2>
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

<?php if( is_front_page()) : ?>
	<div></br></br></br></br><?php echo do_shortcode("[forecast]"); ?></div>
	<?php endif;?>
			</div>

	
</div>
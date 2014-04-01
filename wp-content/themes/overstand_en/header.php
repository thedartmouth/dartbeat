<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php sandbox_blog_lang(); ?>>
<head profile="http://gmpg.org/xfn/11">
	<title><?php bloginfo('name'); if ( is_404() ) : _e(' &raquo; ', 'sandbox'); _e('Not Found', 'sandbox'); elseif ( is_home() ) : _e(' &raquo; ', 'sandbox'); bloginfo('description'); else : wp_title(); endif; ?></title>
	<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
	<meta name="description" content="<?php bloginfo('description') ?>" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?> <?php _e('Posts RSS feed', 'sandbox'); ?>" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?> <?php _e('Comments RSS feed', 'sandbox'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/swfobject.js"></script>
     <!--[if lt IE 7]>
        <link rel="stylesheet" href="http://www.fakeblog.de/wp-content/themes/overstand/iealternate.css" type="text/css" media="screen" />
	<![endif]-->
<?php wp_head() ?>


</head>

<body class="<?php sandbox_body_class() ?>">

<div id="wrapper" class="hfeed">
	<div id="search"><?php get_search_form(); ?></div>
	<div id="header" onclick="location.href='/';" style="cursor: pointer;">
	<!-- <?php include (TEMPLATEPATH . '/searchform.php'); ?> -->
	</div><!--  #header -->
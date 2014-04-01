<?php
/*
Plugin Name: Twitter search smooth scrolling
Plugin URI: http://www.semanticarchitecture.net/writing-a-wordpress-twitter-widget/
Description: This plug-in will show the most recent tweets that match the search term. It uses jQuery to create a smooth user experience animation
Version: 1.0
Author: Patrick Kalkman
Author URI: http://www.semanticarchitecture.net/
License: GPL2
*/

/*  Copyright 2012  Patrick Kalkman  (email : pkalkie@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define("WIDGET_NAME", "Smooth_Twitter_Widget");

error_reporting(E_ALL);

class Smooth_Twitter_Widget extends WP_Widget {
	
	function Smooth_Twitter_Widget() {
		parent::WP_Widget( /* Base ID */WIDGET_NAME, /* Name */WIDGET_NAME, array( 'description' => 'Widget to show recent tweets that match given search terms' ));	
	}

	/** @see WP_Widget::form */
	function form( $instance ) {
		$defaults = array(
			'title' => __('Semantic Tweets', WIDGET_NAME),
			'search_query' => __('SemanticWeb', WIDGET_NAME),
			'refresh_interval' => __('30000', WIDGET_NAME),
			'tweet_interval' => __('8000', WIDGET_NAME),
			'tweet_animation_duration' => __('2000', WIDGET_NAME));
    
    $instance = wp_parse_args((array)$instance, $defaults);

		$title = strip_tags($instance['title']);
		$search_query = strip_tags($instance['search_query']);
		$refresh_interval = strip_tags($instance['refresh_interval']);
		$tweet_interval = strip_tags($instance['tweet_interval']);
		$tweet_animation_duration = strip_tags($instance['tweet_animation_duration']);

		?>
		<p>
		  <?php _e('Title', WIDGET_NAME) ?>: 
		  <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
		</p>
		<p>
		  <?php _e('Search', WIDGET_NAME) ?>: 
		  <input class="widefat" name="<?php echo $this->get_field_name('search_query'); ?>" type="text" value="<?php echo esc_attr($search_query); ?>"/>
		</p>
		<p>
		  <?php _e('Refresh interval (ms)', WIDGET_NAME) ?>: 
		  <input class="widefat" name="<?php echo $this->get_field_name('refresh_interval'); ?>" type="text" value="<?php echo esc_attr($refresh_interval); ?>"/>
		</p>
		<p>
		  <?php _e('Tweet interval (ms)', WIDGET_NAME) ?>: 
		  <input class="widefat" name="<?php echo $this->get_field_name('tweet_interval'); ?>" type="text" value="<?php echo esc_attr($tweet_interval); ?>"/>
		</p>
		<p>
		  <?php _e('Tweet animation (ms)', WIDGET_NAME) ?>: 
		  <input class="widefat" name="<?php echo $this->get_field_name('tweet_animation_duration'); ?>" type="text" value="<?php echo esc_attr($tweet_animation_duration); ?>"/>
		</p>

		<?php 
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['search_query'] = strip_tags($new_instance['search_query']);
		$instance['refresh_interval'] = strip_tags($new_instance['refresh_interval']);
		$instance['tweet_interval'] = strip_tags($new_instance['tweet_interval']);
		$instance['tweet_animation_duration'] = strip_tags($new_instance['tweet_animation_duration']);
		return $instance;
	}

	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		$search_query = apply_filters('widget_title', $instance['search_query']);
		$refresh_interval = apply_filters('widget_title', $instance['refresh_interval']);
		$tweet_interval = apply_filters('widget_title', $instance['tweet_interval']);
		$tweet_animation_duration = apply_filters('widget_title', $instance['tweet_animation_duration']);

		echo $before_widget;
		echo $before_title . $title . $after_title; ?>

		<div class="twitter-search-widget">
		    <ul class="boxBody tweetContainer small"  
		        search-query="<?php echo $search_query; ?>"
		        refresh-interval="<?php echo $refresh_interval; ?>"
		        tweet-interval="<?php echo $tweet_interval; ?>"
		        tweet-animation-duration="<?php echo $tweet_animation_duration; ?>">
		    </ul>
		</div>

	<script type="text/javascript" >
	var $j = jQuery.noConflict();

	// Assign the twitter widget to all elements that have the class .twitter-search-widget
	$j(document).ready(
	    $j(function () {
	        var twitterControls = {};
	        $j(".twitter-search-widget").each(function () {
	            twitterControls[$j(this).id] = new SmoothTwitter.TwitterControl($j(this));
	        });
	    })
	);
	</script>

		<?php echo $after_widget;
	}
}

// register widget
add_action( 'widgets_init', create_function( '', 'register_widget("Smooth_Twitter_Widget");' ) );
add_action('init', 'initialize_script');

function initialize_script() {
  wp_register_script('twitter-search-widget', plugins_url('twitter-search-smooth-scrolling.js',__FILE__ ));
  wp_enqueue_script('twitter-search-widget', array('jquery'));
  wp_register_style('twitter-search-widget-style', plugins_url('twitter-search-smooth-scrolling.css',__FILE__ ));
  wp_enqueue_style('twitter-search-widget-style');
};

?>
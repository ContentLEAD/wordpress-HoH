<?php
/*
Plugin Name: Headlines widget
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A plugin that creates widget that displays headlines with images
Version: 1.0
Author: Ryan Conley

License: A "Slug" license name e.g. GPL2
*/



class hohlist extends WP_Widget {

	// constructor

		// constructor
    function hohlist() {
        parent::WP_Widget(false, $name = __('headlines on hompage with images', 'wp_widget_plugin') );
  
	}

	// widget form creation
// widget form creation
function form($instance) {

// Check values
if( $instance) {
     $title = esc_attr($instance['title']);
 
} else {
     $title = '';

}
?>

<p>
<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'wp_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>


<?php
}

	// widget update
// update widget
function update($new_instance, $old_instance) {
      $instance = $old_instance;
      // Fields
      $instance['title'] = strip_tags($new_instance['title']);

     return $instance;
}

function widget($args, $instance) {
   extract( $args );
   // these are the widget options
   $title = apply_filters('widget_title', $instance['title']);

   echo $before_widget;
   // Display the widget
   echo '<div class="widget-text wp_widget_plugin_box">';

   // Check if title is set
   if ( $title ) {
      echo $before_title . $title . $after_title;
   }

 echo '<ul>';
 $recent = new WP_Query("posts_per_page=3&order=DESC&orderby=post_date"); while($recent->have_posts()) : $recent->the_post();

                echo '<li style="display:inline-block;padding:15px">'; ?>
                <a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a> <br />
                <time datetime="<?php echo date(DATE_W3C); ?>" pubdate ><?php the_time('F jS, Y') ?></time>

                <?php

                         if ( has_post_thumbnail() && ! post_password_required() ) : ?>
                        <div class="entry-thumbnail">
                                <?php echo get_the_post_thumbnail(get_the_ID(), 'thumbnail'); ?>
                                        </div>
                        <?php endif;

                echo'</li>';
        endwhile;

 echo '</ul>';
    echo '</div>';
   echo $after_widget;
}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("hohlist");'));
?>
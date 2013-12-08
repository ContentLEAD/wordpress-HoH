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
     $byline= $instance['byline'];
     $thumbnails = $instance['thumbnails'];
     $date = $instance['date'];
     $excerpt = $instance['excerpt'];
     $count = esc_attr($instance['count']);
} else {
     $title = '';
     $count = '';
   
}

?>

<p>
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'wp_widget_plugin'); ?></label>
</p>
<p>
<input id="<?php echo $this->get_field_id('byline'); ?>" name="<?php echo $this->get_field_name('byline'); ?>" type="checkbox" <?php echo ($byline==true)?'checked': ''?> />
<label for="<?php echo $this->get_field_id('byline'); ?>"><?php _e('Byline', 'wp_widget_plugin'); ?></label>
</p>
<p>
<input  id="<?php echo $this->get_field_id('thumnails'); ?>" name="<?php echo $this->get_field_name('thumbnails'); ?>" type="checkbox" <?php echo ($thumbnails==true)?'checked': ''?> />
<label for="<?php echo $this->get_field_id('thumbnails'); ?>"><?php _e('thumbnails', 'wp_widget_plugin'); ?></label>
</p>
<p>
<input id="<?php echo $this->get_field_id('date'); ?>" name="<?php echo $this->get_field_name('date'); ?>" type="checkbox" <?php echo ($date==true)?'checked': ''?> />
<label for="<?php echo $this->get_field_id('date'); ?>"><?php _e('date', 'wp_widget_plugin'); ?></label>
</p>
<p>
<input id="<?php echo $this->get_field_id('excerpt'); ?>" name="<?php echo $this->get_field_name('excerpt'); ?>" type="checkbox" <?php echo ($excerpt==true)?'checked': ''?> />
<label for="<?php echo $this->get_field_id('excerpt'); ?>"><?php _e('excerpt', 'wp_widget_plugin'); ?></label>
</p>

<p>
<input width="3px" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text"  value="<?php echo $count; ?>" />
<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('count', 'wp_widget_plugin'); ?></label>
</p>



<?php
}

	// widget update
// update widget
function update($new_instance, $old_instance) {
      $instance = $old_instance;
      // Fields
      $instance['title'] = strip_tags($new_instance['title']);
      $instance['byline'] = $new_instance['byline'];
      $instance['thumbnails'] = $new_instance['thumbnails'];
      $instance['date'] = $new_instance['date'];
      $instance['excerpt'] = $new_instance['excerpt'];
      $instance['count'] = strip_tags($new_instance['count']);

     return $instance;
}

function widget($args, $instance) {
   extract( $args );
   // these are the widget options
   $title = apply_filters('widget_title', $instance['title']);
     $byline= $instance['byline'];
     $thumbnails = $instance['thumbnails'];
     $date = $instance['date'];
      $excerpt = $instance['excerpt'];
     $count = esc_attr($instance['count']);

   echo $before_widget;
   // Display the widget
   echo '<div class="widget-text wp_widget_plugin_box">';

   // Check if title is set
   if ( $title ) {
      echo $before_title . $title . $after_title;
   }

 echo '<ul>';
 $recent = new WP_Query("posts_per_page=$count&order=DESC&orderby=post_date"); while($recent->have_posts()) : $recent->the_post();

                echo '<li style="display:inline-block;padding:15px">'; ?>
                <a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a> <br />
                <?php if ($byline==true): ?>
                <?php echo "by ".get_the_author()."<br />";?> 
              <?php endif; ?>
                <?php if ($date==true): ?>
                <time datetime="<?php echo date(DATE_W3C); ?>" pubdate ><?php the_time('F jS, Y') ?></time>
                   <?php endif; ?>
                <?php if ($thumbnails==true):

                         if ( has_post_thumbnail() && ! post_password_required() ) : ?>
                        <div class="entry-thumbnail">
                                <a href="<?php echo get_permalink(); ?>"><?php echo get_the_post_thumbnail(get_the_ID(), 'thumbnail'); ?></a>
                                        </div>
                        <?php endif;
                        endif;

                        if($excerpt==true):?>
                          <div class="excerpt">
                          <?php

                          echo get_the_excerpt();

                          ?>

                          </div>
<?php
                          endif;

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
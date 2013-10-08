<ul>
<?php

require('_plugins/site-pages/blog/wp-blog-header.php');

 $recent = new WP_Query("posts_per_page=3&order=DESC&orderby=post_date"); while($recent->have_posts()) : $recent->the_post();

		echo '<li style="display:inline-block;padding:15px">'; ?>
		<a href="<?php echo get_permalink(); ?>"><?php the_title();  ?></a> <br />
		<time datetime="<?php echo date(DATE_W3C); ?>" pubdate ><?php the_time('F jS, Y') ?></time>

		<?php

			 if ( has_post_thumbnail() && ! post_password_required() ) : ?>
			<div class="entry-thumbnail">
				<?php echo get_the_post_thumbnail(get_the_ID(), 'latest-news-thumb'); ?>
					</div>
			<?php endif; 

		echo'</li>';
	endwhile;

/* Restore original Post Data */
wp_reset_postdata();

?>
</ul>

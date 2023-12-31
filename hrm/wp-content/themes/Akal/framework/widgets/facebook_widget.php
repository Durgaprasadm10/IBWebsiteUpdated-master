<?php 
/*---------------------------------------------------------------------------------*/
/* Facebook widget */
/*---------------------------------------------------------------------------------*/
class Facebook_Like_Widget extends WP_Widget {
	
	
	public function __construct() {
		parent::__construct(
			'facebook_like_widget', // Base ID
			__( 'Brad Facebook Like Box', 'brad-framework' ), // Name
			array( 'description' => __( 'Add Support For Facebook Like Box', 'brad-framework' ), ) // Args
		);
	}
	
	public function widget($args, $instance)
	{
		extract($args);

		$title = apply_filters('widget_title', $instance['title']);
		$page_url = esc_attr($instance['page_url']) ;
		$width = esc_attr($instance['width']);
		$color_scheme = esc_attr($instance['color_scheme']);
		$show_faces = $instance['show_faces'] == true ? 'true' : 'false';
		$show_stream = $instance['show_stream'] == true  ? 'true' : 'false';
		$show_header = $instance['show_header'] == true  ? 'true' : 'false';
		$height = '70';
		
		if($show_faces == 'true') {
			$height = '214';
		}
		
		if($show_stream == 'true') {
			$height = '540';
		}
		
	
		
		echo $before_widget;

		if($title) {
			echo $before_title.$title.$after_title;
		}
		
		if($page_url): ?>

<iframe src="http://www.facebook.com/plugins/likebox.php?href=<?php echo urlencode($page_url); ?>&amp;width=<?php echo $width; ?>&amp;colorscheme=<?php echo $color_scheme; ?>&amp;show_faces=<?php echo $show_faces; ?>&amp;stream=<?php echo $show_stream; ?>&amp;header=<?php echo $show_header; ?>" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:<?php echo $width; ?>px; height: <?php echo $height; ?>px; max-width:100%;" allowTransparency="true"></iframe>
<?php endif;
		
		echo $after_widget;
	}
	
	public function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = esc_attr($new_instance['title']);
		$instance['page_url'] = esc_url($new_instance['page_url']);
		$instance['width'] = esc_attr($new_instance['width']);
		$instance['color_scheme'] = esc_attr($new_instance['color_scheme']);
		$instance['show_faces'] = esc_attr($new_instance['show_faces']);
		$instance['show_stream'] = esc_attr($new_instance['show_stream']);
		$instance['show_header'] = esc_attr($new_instance['show_header']);
		
		return $instance;
	}

	public function form($instance)
	{
		$defaults = array('title' => 'Find us on Facebook', 'page_url' => '', 'width' => '283', 'color_scheme' => 'light', 'show_faces' => 'on', 'show_stream' => false, 'show_header' => false);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
  <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
</p>
<p>
  <label for="<?php echo $this->get_field_id('page_url'); ?>">Facebook Page URL:</label>
  <input class="widefat" type="text" id="<?php echo $this->get_field_id('page_url'); ?>" name="<?php echo $this->get_field_name('page_url'); ?>" value="<?php echo $instance['page_url']; ?>" />
</p>
<p>
  <label for="<?php echo $this->get_field_id('width'); ?>">Width:</label>
  <input class="widefat" type="text"  id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo $instance['width']; ?>" />
</p>
<p>
  <label for="<?php echo $this->get_field_id('color_scheme'); ?>">Color Scheme:</label>
  <select id="<?php echo $this->get_field_id('color_scheme'); ?>" name="<?php echo $this->get_field_name('color_scheme'); ?>" class="widefat" style="width:100%;">
    <option <?php if ('light' == $instance['color_scheme']) echo 'selected="selected"'; ?>>light</option>
    <option <?php if ('dark' == $instance['color_scheme']) echo 'selected="selected"'; ?>>dark</option>
  </select>
</p>
<p>
  <input class="checkbox" type="checkbox" <?php checked($instance['show_faces'], 'on'); ?> id="<?php echo $this->get_field_id('show_faces'); ?>" name="<?php echo $this->get_field_name('show_faces'); ?>" />
  <label for="<?php echo $this->get_field_id('show_faces'); ?>">Show faces</label>
</p>
<p>
  <input class="checkbox" type="checkbox" <?php checked($instance['show_stream'], 'on'); ?> id="<?php echo $this->get_field_id('show_stream'); ?>" name="<?php echo $this->get_field_name('show_stream'); ?>" />
  <label for="<?php echo $this->get_field_id('show_stream'); ?>">Show stream</label>
</p>
<p>
  <input class="checkbox" type="checkbox" <?php checked($instance['show_header'], 'on'); ?> id="<?php echo $this->get_field_id('show_header'); ?>" name="<?php echo $this->get_field_name('show_header'); ?>" />
  <label for="<?php echo $this->get_field_id('show_header'); ?>">Show facebook header</label>
</p>
<?php
	}
}
?>

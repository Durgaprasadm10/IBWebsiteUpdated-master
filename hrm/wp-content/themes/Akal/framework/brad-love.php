<?php
/*
Simple class to create love it icon */


class bradLove {
	
	 function __construct()   {	
        add_action('wp_enqueue_scripts', array(&$this, 'enqueue_scripts'));
        add_action('wp_ajax_brad-love', array(&$this, 'ajax'));
		add_action('wp_ajax_nopriv_brad-love', array(&$this, 'ajax'));
	}
	
	function enqueue_scripts() {
		
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'brad-love', get_template_directory_uri() . '/js/brad-love.js', 'jquery', '1.0', TRUE );

	}
	
	function ajax($post_id) {
		
		//update
		if( isset($_POST['loves_id']) ) {
			$post_id = str_replace('brad-love-', '', $_POST['loves_id']);
			echo $this->love_post($post_id, 'update');
		} 
		
		//get
		else {
			$post_id = str_replace('brad-love-', '', $_POST['loves_id']);
			echo $this->love_post($post_id, 'get');
		}
		
		exit;
	}
	
	
	function love_post($post_id, $action = 'get') 
	{
		if(!is_numeric($post_id)) return;
	
		switch($action) {
		
			case 'get':
				$love_count = get_post_meta($post_id, '_brad_love', true);
				if( !$love_count ){
					$love_count = 0;
					add_post_meta($post_id, '_brad_love', $love_count, true);
				}
				
				return '<span class="brad-love-count">'. $love_count .'</span>';
				break;
				
			case 'update':
				$love_count = get_post_meta($post_id, '_brad_love', true);
				if( isset($_COOKIE['brad_love_'. $post_id]) ) return $love_count;
				
				$love_count++;
				update_post_meta($post_id, '_brad_love', $love_count);
				setcookie('brad_love_'. $post_id, $post_id, time()*20, '/');
				
				return '<span class="brad-love-count">'. $love_count .'</span>';
				break;
		
		}
	}


	function add_love( $sl = false ) {
		global $post;

		$output = $this->love_post($post->ID);
  
  		$class = 'brad-love';
  		$title = __('Love this', 'brad');
		$text = '';
		if( $sl == true) { $text= __('Likes','brad') ; }
		
		if( isset($_COOKIE['brad_love_'. $post->ID]) ){
			$class = 'brad-love loved';
			$title = __('You already love this!', 'brad');
		}
		
		return '<a href="#" class="'. $class .'" id="brad-love-'. $post->ID .'" title="'. $title .'"> <i class="fa fa-heart-o"></i> '. $output .' ' . $text .'</a>';
	}
	
}


global $brad_love;
$brad_love = new bradLove();

// get the ball rollin' 
function brad_love($return = '') {
	
	global $brad_love;

	if($return == 'return') {
		return $brad_love->add_love(); 
	} else {
		echo $brad_love->add_love(); 
	}
	
}

?>

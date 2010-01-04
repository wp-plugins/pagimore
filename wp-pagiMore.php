<?php
/*
Plugin Name: pagiMore
Plugin URI: -
Description: Slider based pagination based on Lester Chan's ( http://lesterchan.net/wordpress/readme/wp-pagenavi.html ) paginav.
Version: 1.0
Author: Mr. Henry
Author URI: http://mrhenry.be
*/

### Initalize JavaScripts
if (function_exists('wp_enqueue_script')) {
	wp_enqueue_script('jquery-slider', plugins_url('wp-pagiMore/ui.slider.js'), array('jquery', 'jquery-ui-core'), '1.0');
	wp_enqueue_script('pagiMore', plugins_url('wp-pagiMore/jquery.pagiMore.js'), false, false);
}

### Function: Page Navigation Option Menu
add_action('admin_menu', 'pagiMore_menu');
function pagiMore_menu() {
	if (function_exists('add_options_page')) {
		add_options_page(__('pagiMore', 'wp-pagiMore'), __('pagiMore', 'wp-pagiMore'), 'manage_options', 'wp-pagiMore/pagiMore-options.php') ;
	}
}

### Function: Enqueue pagiMore Stylesheets
add_action('wp_print_styles', 'pagiMore_stylesheets');
function pagiMore_stylesheets() {
	wp_enqueue_style('wp-pagiMore', plugins_url('wp-pagiMore/pagiMore.css'), false, '1.0', 'all');
}

### Function: Page Navigation
function wp_pagiMore($before = '', $after = '') {
	global $wpdb, $wp_query;
	if (!is_single()) {
		$request = $wp_query->request;
		$posts_per_page = intval(get_query_var('posts_per_page'));
		$paged = intval(get_query_var('paged'));
		$pagiMore_options = get_option('pagiMore_options');
		$numposts = $wp_query->found_posts;
		$max_page = $wp_query->max_num_pages;
		if(empty($paged) || $paged == 0) {
			$paged = 1;
		}
		$start_page = 1;
		
		$publish_dates = $wpdb->get_results("SELECT ID, post_date FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_date DESC");
		$loopcounter = 1;
		$date_format = 'F, Y';
		$length = count($publish_dates);
		
		foreach ($publish_dates as $publish_dates) {
			
			if ($loopcounter % ($posts_per_page) == 0 || $loopcounter == $length){
				
				$date = substr($publish_dates->post_date, 0, 10);
				$date = strtotime($date);
				$dates[] = date($date_format, $date);
			}
			$loopcounter++;
		}
		
		$pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), $pagiMore_options['pages_text']);
		$pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);
		
		echo $before.'<div id="pagiMore"><div id="pagiMoreContent"><ul id="pagiMoreList">'."\n";
		
		for($i = $start_page; $i  <= $max_page; $i++) {
			if($i == $paged) {
				$current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagiMore_options['current_text']);
				echo '<li class="current pageItem"><span class="pagiMore-page">'.$current_page_text.'</span><span class="pagiMore-date">'.$dates[$i-1].'</span></li>';
				
			} else {
				$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagiMore_options['page_text']);
				echo '<li class="pageItem"><span class="pagiMore-page"><a href="'.clean_url(get_pagenum_link($i)).'" class="pagiMore-page" title="'.$page_text.'">'.$page_text.'</a></span><span class="pagiMore-date">'.$dates[$i-1].'</span></li>';
			}
		}
		echo '</ul></div><div id="pagiMoreSlider"></div></div>'.$after."\n";
	}
}

### Function: pagiMore options
add_action('activate_wp-pagiMore/wp-pagiMore.php', 'pagiMore_init');
function pagiMore_init() {
	$pagiMore_options = array();
	$pagiMore_options['current_text'] = '%PAGE_NUMBER%';
	$pagiMore_options['page_text'] = '%PAGE_NUMBER%';
	add_option('pagiMore_options', $pagiMore_options, 'pagiMore Options');
}
?>
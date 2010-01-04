=== pagiMore ===
Contributors: wearemrhenry
Tags: pagiMore, navigation, pagination, slider, jQuery
Requires at least: 2.8
Tested up to: 2.8
Stable tag: trunk

A pagination plugin based on Lester Chan's paginav. This plugin adds a slider to the pagination when the number of pages won't fit in the container. 

== Description ==

Adds pagination to your WordPress blog. If pagination don't fit into the container, a slider will be added. When hovering over the page numbers, the date from the first post on that page will be displayed.

Based on Lester Chan's ( http://lesterchan.net/wordpress/readme/wp-pagenavi.html ) paginav.

Tested and works in IE6, IE7, IE8, Safari+Chrome, FireFox, Opera (no dates there) & Camino.

== Installation ==

1. Put pagiMore in the wp-content/plugins folder.
2. Activate the plugin in the admin page.

== Usage ==

Put this code on the page where you want to use the pagination (for example in index.php in your theme):
<div id="yourPaginationDiv">
	<? if(function_exists('wp_pagiMore')) { wp_pagiMore(); } ?>
</div>

Put this in your JavaScript file (and don't forget to include it):

jQuery(document).ready(function(){
	jQuery('#yourPaginationDiv').pagiMore({
		animate: true, //true for fancy animation in the slider
		showDates: true //true displays the date from the first post on that page
	});
});

Make sure that 
<?php wp_head(); ?>
is in your header. Put your own JavaScript file after the wp_head function.

Make your own style by editing the stylesheet pagiMore.css included in the wp-pagiMore folder.

== Screenshots ==
slider.png
no-slider.png
settings.png
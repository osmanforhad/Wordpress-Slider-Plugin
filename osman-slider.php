<?php
/**
 * Plugin Name:       Slider Short code Plugin
 * Plugin URI:        https://osmanforhad.net/plugins/practice/
 * Description:       Wordpress Slider Plugin Example by Short code
 * and Display QR code under every WorPress Post
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.1
 * Author:            osman forhad
 * Author URI:        https://author.osmanforhad.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       tinyslider
 * Domain Path:       /languages/
 */

//Call back for loading text domain Languages
function wps_load_textdomain(){
	load_plugin_textdomain('tinyslider', false, dirname(__FILE__)."/languages");
}

//Load text domain
add_action('plugins_loaded', 'tinys_load_textdomain');

function tinys_init(){
	add_image_size('tiny-slider', 800, 600, true);
}
add_action('init', 'tinys_init');

//callback function for enqueue plugin assets
function tinys_assets(){
	wp_enqueue_style('tinyslider-css','//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.8.4/tiny-slider.css',null,'1.0');
	wp_enqueue_script('tinyslider-js','//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.8.4/min/tiny-slider.js',null,'1.0',true);

	wp_enqueue_scripts('tinyslider-main-js', plugin_dir_url(__FILE__)."/assets/js/main.js", array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'tinys_assets');

//call back function for tinys_shortcode_tslider
function tinys_shortcode_tslider($arguments, $content){
	$defaults = array(
		'width' => 800,
		'height' => 600,
		'id' => ''
	);
	$attributes = shortcode_atts($defaults, $arguments);
	$content = do_shortcode($content);

	$shortcode_output = <<<EOD
<div id=""{$attributes['id']} style="width:{$attributes['width']};height:{$attributes['height']}">
<div class="slider">
{$content}
</div>

</div>
EOD;

	return $shortcode_output;
}
//add short code
add_shortcode('tslider', 'tinys_shortcode_tslider');

//call back function for tinys_shortcode_tslide
function tinys_shortcode_tslide($arguments){
	$defaults = array(
		'caption' => '',
		'id' => '',
		'size' => 'tiny-slider'
	);
	$attributes = shortcode_atts($defaults, $arguments);

	$image_src = wp_get_attachment_image_src($attributes['id'], $attributes['size']);

	$shortcode_outptut = <<<EOD
<div class="slide">
<p><img src="{$image_src[0]}" alt="{$attributes['caption']}"> </p>
<p>{$attributes['caption']}</p>
</div>
EOD;

	return $shortcode_outptut;

}
//add short code
add_shortcode('tslider', 'tinys_shortcode_tslide');
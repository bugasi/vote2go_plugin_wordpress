<?php

/*
Plugin Name: Vote2Go Wordpress Plugin
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Integrate vote2go surveys into your Wordpress website.
Version: 0.3.6
Author: BuGaSi GmbH
Author URI: https://bugasi.de/
License: MIT
*/

// code for plugin update handling
require 'plugin-update-checker/plugin-update-checker.php';

$v2gUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://github.com/bugasi/vote2go_plugin_wordpress',
    __FILE__,
    'vote2go-wordpress'
);

$v2gUpdateChecker->setBranch('master');


// actual plugin code
add_shortcode('vote2go', "vote2go_shortcode_function");

function vote2go_shortcode_function($atts) {
    $a = shortcode_atts(array(
        'voteid' => 'derp',
        'frameheight' => '300px',
        'framewidth' => '500px',
	    'criteria' => '',
	    'align' => 'center'
    ), $atts);
    $criteria = null;
    if (strlen($a['criteria']) > 0) {
    	$criteria = [];
	    $entries = explode(';', $a['criteria']);
	    foreach ($entries as $entry) {
		    $keyVal = explode(':', $entry);
		    if (sizeof($keyVal) == 2) {
		    	$criteria[$keyVal[0]] = $keyVal[1];
		    }
	    }
    }

    wp_register_script('vote2go_js', plugin_dir_url(__FILE__).'/public/js/vote2go.js');
    wp_enqueue_script('vote2go_js');
	wp_register_style('vote2go_css', plugin_dir_url(__FILE__).'/public/css/vote2go.css');
	wp_enqueue_style('vote2go_css');

    return "<div class=\"vote2go_wrapper\" style=\"text-align: {$a['align']};\" data-v2g-vote-id=\"{$a['voteid']}\" data-v2g-frame-width=\"{$a['framewidth']}\" data-v2g-frame-height=\"{$a['frameheight']}\" " . getCriteriaAttribute($criteria) . "></div>";
}

function getCriteriaAttribute($criteria) {
	if ($criteria == null) {
		return "";
	}
	$asJson = json_encode($criteria);
	$asBase64 = base64_encode($asJson);
	return "data-v2g-criteria=\"${asBase64}\"";
}


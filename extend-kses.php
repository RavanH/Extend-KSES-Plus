<?php
/*
 * Plugin Name: Extend KSES +
 * Plugin URI: http://status301.net
 * Description: Extends kses.php by allowing additional html tags
 * Version: 3.5-alpha
 * Author: Ravanh, Tierra Innovation
 * Author URI: http://status301.net
 */

/*
 * This is a modified version (under the MIT License) of a plugin
 * originally developed by Tierra Innovation for WNET.org.
 * 
 * This plugin is currently available for use in all personal
 * or commercial projects under both MIT and GPL licenses. This
 * means that you can choose the license that best suits your
 * project, and use it accordingly.
 *
 * MIT License: http://www.tierra-innovation.com/license/MIT-LICENSE.txt
 * GPL2 License: http://www.tierra-innovation.com/license/GPL-LICENSE.txt
 */

// For more info see wp-includes/kses.php

// TODO: remove options page and move options to Settings > Writing
// set admin screen
function modify_extend_kses_plus_menu() {
	add_submenu_page(
		'tools.php',
		'Extend KSES', // page title
		'Extend KSES', // sub-menu title
		'manage_options', // access/capa
		'extend-kses.php', // file
		'admin_extend_kses_plus_options' // function
	);
}
add_action('admin_menu', 'modify_extend_kses_plus_menu');

// unset options upon deactivation
function unset_extend_kses_plus_options() {
	delete_option('allow_kses');
}
register_deactivation_hook(__FILE__,'unset_extend_kses_plus_options');

function admin_extend_kses_plus_options() {

	if (isset($_REQUEST['submit']))
		update_extend_kses_plus_options();

	print_extend_kses_plus_form();
}

function update_extend_kses_plus_options() {

	if (isset($_REQUEST['allow_kses']))
		update_option('allow_kses',$_REQUEST['allow_kses']);
	else
		update_option('allow_kses',[]);

	echo '
		<div id="message" class="updated fade">

			<p>'.__('Settings saved.').'</p>

		</div>
	';
}

function print_extend_kses_plus_form() {
	$default = array(
		'div' => 'yes',
		'embed' => 'yes',
		'iframe' => 'yes',
		'img' => 'yes',
		'map' => 'yes',
		'object' => 'yes',
		'pre' => 'yes'
	);
	$allow_kses = get_option('allow_kses', $default);

	$allow_kses_div_selected = isset( $allow_kses['div'] ) ? 'checked' : '';
	$allow_kses_embed_selected = isset( $allow_kses['embed'] ) ? 'checked' : '';
	$allow_kses_iframe_selected = isset( $allow_kses['iframe'] ) ? 'checked' : '';
	$allow_kses_img_selected = isset( $allow_kses['img'] ) ? 'checked' : '';
	$allow_kses_map_selected = isset( $allow_kses['map'] ) ? 'checked' : '';
	$allow_kses_object_selected = isset( $allow_kses['object'] ) ? 'checked' : '';
	$allow_kses_pre_selected = isset( $allow_kses['pre'] ) ? 'checked' : '';
	$allow_kses_script_selected = isset( $allow_kses['script'] ) ? 'checked' : '';

    if ( defined(WP_DEBUG) && true == WP_DEBUG ) {
        $allowed_tags = wp_kses_allowed_html( 'post' );
        var_dump( $allowed_tags );
    }

    // execute the form
	print "

	<div class='wrap'>

		<div id='icon-options-general' class='icon32'></div>

		<h2>Extend KSES</h2>

			<form method='post'>

				<ul>
					<li><label><input type='checkbox' name='allow_kses[div]' value='yes' $allow_kses_div_selected /> <strong>div</strong></label> (additional support for 'id')</li>
					<li><label><input type='checkbox' name='allow_kses[embed]' value='yes' $allow_kses_embed_selected /> <strong>embed</strong></label> (full support)</li>
					<li><label><input type='checkbox' name='allow_kses[iframe]' value='yes' $allow_kses_iframe_selected /> <strong>iframe</strong></label> (full support)</li>
					<li><label><input type='checkbox' name='allow_kses[img]' value='yes' $allow_kses_img_selected /> <strong>img</strong></label> (additional support for image maps)</li>
					<li><label><input type='checkbox' name='allow_kses[map]' value='yes' $allow_kses_map_selected /> <strong>map</strong></label> (full support)</li>
					<li><label><input type='checkbox' name='allow_kses[object]' value='yes' $allow_kses_object_selected /> <strong>object</strong></label> (full support incl. param tag)</li>
					<li><label><input type='checkbox' name='allow_kses[pre]' value='yes' $allow_kses_pre_selected /> <strong>pre</strong></label> (additional support for google syntax highlighter)</li>
					<li><label><input type='checkbox' name='allow_kses[script]' value='yes' $allow_kses_script_selected /> <strong>script</strong></label> (notes: 1. disable rich text editor to prevent it from cripling script code; 2. complex script code may still be cripled by other filters; 3. be careful, allowing unverified script is a security risk!)</li>
				</ul>

				<br />
				<input type='submit' name='submit' class='button-primary' value='".__('Save Changes')."' />

			</form>

		</div>

	";
}

function do_extend_kses_plus_magic() {
	global $allowedposttags, $allowedtags;
	$default = array(
		'div' => 'yes',
		'embed' => 'yes',
		'iframe' => 'yes',
		'img' => 'yes',
		'map' => 'yes',
		'object' => 'yes',
		'pre' => 'yes'
	);

	$allow_kses = get_option('allow_kses', $default);

	// do the magic
	if ( isset($allow_kses['div']) ) {

		$allowedposttags['div'] = array(
			'align' => [],
			'class' => [],
			'dir' => [],
			'id' => [],
			'lang' => [],
			'style' => [],
			'xml:lang' => [],
			'itemscope' => [],
			'itemtype' => [],
			'itemprop' => []
		);

		$allowedtags['div'] = array(
			'align' => [],
			'class' => [],
			'dir' => [],
			'id' => [],
			'lang' => [],
			'style' => [],
			'xml:lang' => [],
			'itemscope' => [],
			'itemtype' => [],
			'itemprop' => []
		);

	}

	if ( isset($allow_kses['embed']) ) {

		$allowedposttags['embed'] = array(
			'style' => [],
			'type' => [],
			'id' => [],
			'height' => [],
			'width' => [],
			'src' => [],
			'itemprop' => []
		);

		$allowedtags['embed'] = array(
			'style' => [],
			'type' => [],
			'id' => [],
			'height' => [],
			'width' => [],
			'src' => [],
			'itemprop' => []
		);

	}

	if ( isset($allow_kses['iframe']) ) {

		$allowedposttags['iframe'] = array(
			'width' => [],
			'height' => [],
			'frameborder' => [],
			'scrolling' => [],
			'marginheight' => [],
			'marginwidth' => [],
			'class' => [],
			'id' => [],
			'title' => [],
			'style' => [],
			'align' => [],
			'longdesc' => [],
			'src' => [],
			'itemscope' => [],
			'itemtype' => [],
			'itemprop' => []
		);

		$allowedtags['iframe'] = array(
			'width' => [],
			'height' => [],
			'frameborder' => [],
			'scrolling' => [],
			'marginheight' => [],
			'marginwidth' => [],
			'class' => [],
			'id' => [],
			'title' => [],
			'style' => [],
			'align' => [],
			'longdesc' => [],
			'src' => [],
			'itemscope' => [],
			'itemtype' => [],
			'itemprop' => []
		);

		add_filter('tiny_mce_before_init', create_function( '$a','$a["extended_valid_elements"] = "iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width|itemscope|itemtype|itemprop]"; return $a;') );

	}

	if ( isset($allow_kses['img']) ) {

		$allowedposttags['img'] = array(
			'alt' => [],
			'align' => [],
			'border' => [],
			'class' => [],
			'height' => [],
			'hspace' => [],
			'longdesc' => [],
			'vspace' => [],
			'src' => [],
			'style' => [],
			'width' => [],
			'title' => [],
			'usemap' => [],
			'itemprop' => []
		);

		$allowedtags['img'] = array(
			'alt' => [],
			'align' => [],
			'border' => [],
			'class' => [],
			'height' => [],
			'hspace' => [],
			'longdesc' => [],
			'vspace' => [],
			'src' => [],
			'style' => [],
			'width' => [],
			'title' => [],
			'usemap' => [],
			'itemprop' => []
		);

	}

	if ( isset($allow_kses['map']) ) {

		$allowedposttags['map'] = array(
			'name' => [],
			'area' => array(
				'attributes' => [],
				'shape' => [],
				'coords' => [],
				'href' => [],
				'target' => [],
				'alt' => [],
				'title' => [],
				'id' => []
			),
			'id' => [],
			'itemscope' => [],
			'itemtype' => [],
			'itemprop' => []
		);

		$allowedtags['map'] = array(
			'name' => [],
			'area' => array(
				'attributes' => [],
				'shape' => [],
				'coords' => [],
				'href' => [],
				'target' => [],
				'alt' => [],
				'title' => [],
				'id' => []
			),
			'id' => [],
			'itemscope' => [],
			'itemtype' => [],
			'itemprop' => []
		);

	}

	if ( isset($allow_kses['object']) ) {

		$allowedposttags['object'] = array(
			'style' => [],
			'height' => [],
			'width' => [],
			'name' => [],
			'type' => [],
            'form' => [],
            'data' => [],
			'id' => [],
			'height' => [],
			'width' => [],
			'usemap' => [],
			'itemprop' => []
		);

		$allowedtags['object'] = array(
			'style' => [],
			'height' => [],
			'width' => [],
			'name' => [],
			'type' => [],
            'form' => [],
            'data' => [],
			'id' => [],
			'height' => [],
			'width' => [],
			'usemap' => [],
			'itemprop' => []
		);

		$allowedposttags['param'] = array(
			'name' => [],
			'value' => []
		);

		$allowedtags['param'] = array(
			'name' => [],
			'value' => []
		);

	}

	if ( isset($allow_kses['pre']) ) {

		$allowedposttags['pre'] = array(
			'style' => [],
			'name' => [],
			'class' => [],
			'lang' => [],
			'width' => [],
			'itemprop' => []
		);

		$allowedtags['pre'] = array(
			'style' => [],
			'name' => [],
			'class' => [],
			'lang' => [],
			'width' => [],
			'itemprop' => []
		);

	}

	if ( isset($allow_kses['script']) ) {

		$allowedposttags['script'] = array(
			'type' => [],
			'async' => [],
			'charset' => [],
			'defer' => [],
			'src' => []
		);

		$allowedtags['script'] = array(
			'type' => [],
			'async' => [],
			'charset' => [],
			'defer' => [],
			'src' => []
		);

		$allowedposttags['noscript'] = [];

		$allowedtags['noscript'] = [];

		add_filter( 'content_save_pre', 'extend_kses_plus_filter_cdata', 9, 1 );

		add_filter('tiny_mce_before_init', create_function( '$a','$a["extended_valid_elements"] = "script[type|async|charset|defer|src]"; return $a;') );

		add_filter('tiny_mce_before_init', create_function( '$a','$a["extended_valid_elements"] = "noscript[]"; return $a;') );
	}
}
add_action('init','do_extend_kses_plus_magic');

function extend_kses_plus_filter_cdata( $content ) {
	$filtered = str_replace( '// <![CDATA[', '', $content );
	return str_replace( '// ]]>', '', $filtered );
}

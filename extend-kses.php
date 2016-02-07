<?php
/*
 * Plugin Name: Extend KSES +
 * Plugin URI: http://status301.net
 * Description: Extends kses.php by allowing additional html tags
 * Version: 3.4.1
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
		update_option('allow_kses',array());

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
		'param' => 'yes',
		'pre' => 'yes'
	);
	$allow_kses = get_option('allow_kses', $default);

	$allow_kses_div_selected = isset( $allow_kses['div'] ) ? 'checked' : '';
	$allow_kses_embed_selected = isset( $allow_kses['embed'] ) ? 'checked' : '';
	$allow_kses_iframe_selected = isset( $allow_kses['iframe'] ) ? 'checked' : '';
	$allow_kses_img_selected = isset( $allow_kses['img'] ) ? 'checked' : '';
	$allow_kses_map_selected = isset( $allow_kses['map'] ) ? 'checked' : '';
	$allow_kses_object_selected = isset( $allow_kses['object'] ) ? 'checked' : '';
	$allow_kses_param_selected = isset( $allow_kses['param'] ) ? 'checked' : '';
	$allow_kses_pre_selected = isset( $allow_kses['pre'] ) ? 'checked' : '';
	$allow_kses_script_selected = isset( $allow_kses['script'] ) ? 'checked' : '';

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
					<li><label><input type='checkbox' name='allow_kses[object]' value='yes' $allow_kses_object_selected /> <strong>object</strong></label> (full support)</li>
					<li><label><input type='checkbox' name='allow_kses[param]' value='yes' $allow_kses_param_selected /> <strong>param</strong></label> (full support)</li>
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
		'param' => 'yes',
		'pre' => 'yes'
	);

	$allow_kses = get_option('allow_kses', $default);

	// do the magic
	if ( isset($allow_kses['div']) ) {

		$allowedposttags['div'] = array(
			'align' => array (),
			'class' => array (),
			'dir' => array (),
			'id' => array (),
			'lang' => array(),
			'style' => array (),
			'xml:lang' => array()
		);

		$allowedtags['div'] = array(
			'align' => array (),
			'class' => array (),
			'dir' => array (),
			'id' => array (),
			'lang' => array(),
			'style' => array (),
			'xml:lang' => array()
		);

	}

	if ( isset($allow_kses['embed']) ) {

		$allowedposttags['embed'] = array(
			'style' => array(),
			'type' => array (),
			'id' => array (),
			'height' => array (),
			'width' => array (),
			'src' => array (),
			'object' => array(
				'height' => array (),
				'width' => array (),
				'param' => array (
					'name' => array (),
					'value' => array ()
				)
			)
		);

		$allowedtags['embed'] = array(
			'style' => array(),
			'type' => array (),
			'id' => array (),
			'height' => array (),
			'width' => array (),
			'src' => array (),
			'object' => array(
				'height' => array (),
				'width' => array (),
				'param' => array (
					'name' => array (),
					'value' => array ()
				)
			)
		);

	}

	if ( isset($allow_kses['iframe']) ) {

		$allowedposttags['iframe'] = array (
					'width' => array (),
					'height' => array (),
					'frameborder' => array (),
			'scrolling' => array (),
			'marginheight' => array (),
			'marginwidth' => array (),
			'class' => array (),
			'id' => array (),
			'title' => array (),
			'style' => array (),
			'align' => array (),
			'longdesc' => array (),
			'src' => array ()
		);

		$allowedtags['iframe'] = array (
					'width' => array (),
					'height' => array (),
					'frameborder' => array (),
			'scrolling' => array (),
			'marginheight' => array (),
			'marginwidth' => array (),
			'class' => array (),
			'id' => array (),
			'title' => array (),
			'style' => array (),
			'align' => array (),
			'longdesc' => array (),
			'src' => array ()
		);

		add_filter('tiny_mce_before_init', create_function( '$a','$a["extended_valid_elements"] = "iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width]"; return $a;') );

	}

	if ( isset($allow_kses['img']) ) {

		$allowedposttags['img'] = array (
			'alt' => array (),
			'align' => array (),
			'border' => array (),
			'class' => array (),
			'height' => array (),
			'hspace' => array (),
			'longdesc' => array (),
			'vspace' => array (),
			'src' => array (),
			'style' => array (),
			'width' => array (),
			'title' => array (),
			'usemap' => array ()
		);

		$allowedtags['img'] = array (
			'alt' => array (),
			'align' => array (),
			'border' => array (),
			'class' => array (),
			'height' => array (),
			'hspace' => array (),
			'longdesc' => array (),
			'vspace' => array (),
			'src' => array (),
			'style' => array (),
			'width' => array (),
			'title' => array (),
			'usemap' => array ()
		);

	}

	if ( isset($allow_kses['map']) ) {

		$allowedposttags['map'] = array (
			'name' => array (),
			'area' => array (
				'attributes' => array (),
				'shape' => array (),
				'coords' => array (),
				'href' => array (),
				'target' => array (),
				'alt' => array (),
				'title' => array (),
				'id' => array ()
			),
			'id' => array ()
		);

		$allowedtags['map'] = array (
			'name' => array (),
			'area' => array (
				'attributes' => array (),
				'shape' => array (),
				'coords' => array (),
				'href' => array (),
				'target' => array (),
				'alt' => array (),
				'title' => array (),
				'id' => array ()
			),
			'id' => array ()
		);

	}

	if ( isset($allow_kses['object']) ) {

		$allowedposttags['object'] = array(
				'style' => array (),
			'height' => array (),
			'width' => array (),
			'param' => array (
				'name' => array (),
				'value' => array ()
			),
			'embed' => array(
				'style' => array(),
				'type' => array (),
				'id' => array (),
				'height' => array (),
				'width' => array (),
				'src' => array (),
				'allowfullscreen' => array (),
				'allowscriptaccess' => array ()
			)
		);

		$allowedtags['object'] = array(
				'style' => array (),
			'height' => array (),
			'width' => array (),
			'param' => array (
				'name' => array (),
				'value' => array ()
			),
			'embed' => array(
				'style' => array(),
				'type' => array (),
				'id' => array (),
				'height' => array (),
				'width' => array (),
				'src' => array (),
				'allowfullscreen' => array (),
				'allowscriptaccess' => array ()
			)
		);

	}

	if ( isset($allow_kses['param']) ) {

		$allowedposttags['param'] = array (
			'name' => array (),
			'value' => array ()
		);

		$allowedtags['param'] = array (
			'name' => array (),
			'value' => array ()
		);

	}

	if ( isset($allow_kses['pre']) ) {

		$allowedposttags['pre'] = array (
			'style' => array (),
			'name' => array (),
			'class' => array (),
			'lang' => array (),
			'width' => array ()
		);

		$allowedtags['pre'] = array (
			'style' => array (),
			'name' => array (),
			'class' => array (),
			'lang' => array (),
			'width' => array ()
		);

	}

	if ( isset($allow_kses['script']) ) {

		$allowedposttags['script'] = array (
			'type' => array (),
			'async' => array (),
			'charset' => array (),
			'defer' => array (),
			'src' => array ()
		);

		$allowedtags['script'] = array (
			'type' => array (),
			'async' => array (),
			'charset' => array (),
			'defer' => array (),
			'src' => array ()
		);

		$allowedposttags['noscript'] = array ();

		$allowedtags['noscript'] = array ();

		add_filter( 'content_save_pre', 'extend_kses_plus_filter_cdata', 9, 1 );

		add_filter('tiny_mce_before_init', create_function( '$a','$a["extended_valid_elements"] = "script[type|async|charset|defer|src]"; return $a;') );

		add_filter('tiny_mce_before_init', create_function( '$a','$a["extended_valid_elements"] = "noscript[]"; return $a;') );
	}
}
add_action('init','do_extend_kses_plus_magic');

function extend_kses_plus_filter_cdata( $content ) {
	$content = str_replace( '// <![CDATA[', '', $content );
	$content = str_replace( '// ]]>', '', $content );
	return $content;
}

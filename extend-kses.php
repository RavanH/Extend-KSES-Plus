<?php
/*
 * Plugin Name: Extend KSES +
 * Plugin URI: http://status301.net
 * Description: Extends kses.php by allowing additional html tags
 * Version: 3.5
 * Text Domain: extend-kses
 * Author: RavanH, Tierra Innovation
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
 */

// For more info see wp-includes/kses.php

// unset options upon deactivation
function unset_extend_kses_plus_options() {
	delete_option('allow_kses');
}
register_deactivation_hook(__FILE__,'unset_extend_kses_plus_options');

function extend_kses_plus_sanitize_options($new) {
	return (array)$new;
}

function extend_kses_plus_default() {
    return array(
		'embed' => 'yes',
		'iframe' => 'yes',
		'object' => 'yes',
		'tinymce' => 'yes',
		'img' => 'yes',
		'pre' => 'yes'
	);
}
function extend_kses_plus_post_settings() {
	$allow_kses = get_option('allow_kses', extend_kses_plus_default());

	$allow_kses_embed_selected = isset( $allow_kses['embed'] ) ? 'checked' : '';
	$allow_kses_iframe_selected = isset( $allow_kses['iframe'] ) ? 'checked' : '';
	$allow_kses_object_selected = isset( $allow_kses['object'] ) ? 'checked' : '';
	$allow_kses_script_selected = isset( $allow_kses['script'] ) ? 'checked' : '';
	$allow_kses_microdata_selected = isset( $allow_kses['microdata'] ) ? 'checked' : '';
	$allow_kses_tinymce_selected = isset( $allow_kses['tinymce'] ) ? 'checked' : '';
        
        $title = translate('Content');
        $allow_kses_embed_label = __('Allow <code>embed</code> tag','extend-kses');
        $allow_kses_iframe_label = __('Allow <code>iframe</code> tag','extend-kses');
        $allow_kses_object_label = __('Allow <code>object</code> and <code>param</code> tags','extend-kses');
        $allow_kses_script_label = __('Allow <code>script</code> tag *','extend-kses');
        $allow_kses_notes = __('*) Warning: Be careful, allowing unverified script is a security risk! Also note that the rich text editor and other filters may still remove javascript; disable the rich text editor or use the <code>scr</code> attribute to link to an external source.','extend-kses');
        $allow_kses_microdata_label = __('Allow <a href="https://en.wikipedia.org/wiki/Microdata_(HTML)" target="_blank">Microdata</a> attributes <code>itemscope</code>, <code>itemtype</code>, <code>itemid</code>, <code>itemref</code> and <code>itemprop</code> on all elements','extend-kses');
        $allow_kses_tinymce_label = __('Prevent the <strong>Rich Text Editor</strong> stripping allowed tags and attributes','extend-kses');

        print "
                <fieldset>
                    <legend class='screen-reader-text'><span>$title</span></legend>
			<label><input type='checkbox' name='allow_kses[embed]' value='yes' $allow_kses_embed_selected /> $allow_kses_embed_label</label><br>
			<label><input type='checkbox' name='allow_kses[iframe]' value='yes' $allow_kses_iframe_selected /> $allow_kses_iframe_label</label><br>
			<label><input type='checkbox' name='allow_kses[object]' value='yes' $allow_kses_object_selected /> $allow_kses_object_label</label><br>
			<label><input type='checkbox' name='allow_kses[script]' value='yes' $allow_kses_script_selected /> $allow_kses_script_label</label><br>
			<label><input type='checkbox' name='allow_kses[microdata]' value='yes' $allow_kses_microdata_selected /> $allow_kses_microdata_label</label><br>
			<label><input type='checkbox' name='allow_kses[tinymce]' value='yes' $allow_kses_tinymce_selected /> $allow_kses_tinymce_label</label>
		</fieldset>
                <p class='description'>$allow_kses_notes</p>
	";
}

function extend_kses_plus_comment_settings() {
	$allow_kses = get_option('allow_kses', extend_kses_plus_default());

	$allow_kses_div_selected = isset( $allow_kses['div'] ) ? 'checked' : '';
	$allow_kses_img_selected = isset( $allow_kses['img'] ) ? 'checked' : '';
	$allow_kses_map_selected = isset( $allow_kses['map'] ) ? 'checked' : '';
	$allow_kses_pre_selected = isset( $allow_kses['pre'] ) ? 'checked' : '';

        $title = translate('Comments');
        $allow_kses_div_label = __('Allow <code>div</code> tag','extend-kses');
        $allow_kses_img_label = __('Allow <code>img</code> tag','extend-kses');
        $allow_kses_pre_label = __('Allow <code>pre</code> tag','extend-kses');
        $allow_kses_map_label = __('Allow <code>map</code> and <code>area</code> tags','extend-kses');

        print "
                <fieldset>
                    <legend class='screen-reader-text'><span>$title</span></legend>
			<label><input type='checkbox' name='allow_kses[div]' value='yes' $allow_kses_div_selected /> $allow_kses_div_label</label><br>
			<label><input type='checkbox' name='allow_kses[img]' value='yes' $allow_kses_img_selected /> $allow_kses_img_label</label><br>
			<label><input type='checkbox' name='allow_kses[pre]' value='yes' $allow_kses_pre_selected /> $allow_kses_pre_label</label><br>
			<label><input type='checkbox' name='allow_kses[map]' value='yes' $allow_kses_map_selected /> $allow_kses_map_label</label>
		</fieldset>
	";

    if ( defined('WP_DEBUG') && true == WP_DEBUG ) {
        $allowed_tags = wp_kses_allowed_html( 'post' );
        echo "<div style='height:200px;overflow:scroll'><pre>";
        var_dump( $allowed_tags );
        echo "</pre></div><code>";
        echo allowed_tags();
        echo "</code>";       
    }

}

function extend_kses_plus_do_magic() {
	global $allowedposttags, $allowedtags;

	$allow_kses = get_option('allow_kses', extend_kses_plus_default());

	// do the magic
	if ( isset($allow_kses['div']) ) {

		$allowedtags['div'] = array(
			'align' => true,
			'dir' => true,
			'lang' => true,
			'style' => true
		);

	}

	if ( isset($allow_kses['embed']) ) {

		$allowedposttags['embed'] = array(
			'style' => true,
			'type' => true,
			'id' => true,
                        'class' => true,
			'height' => true,
			'width' => true,
			'src' => true
		);

	}

	if ( isset($allow_kses['iframe']) ) {

		$allowedposttags['iframe'] = array(
			'id' => true,
			'class' => true,
			'title' => true,
			'style' => true,
			'width' => true,
			'height' => true,
			'frameborder' => true,
			'scrolling' => true,
			'marginheight' => true,
			'marginwidth' => true,
			'name' => true,
			'sandbox' => true,
			'align' => true,
			'longdesc' => true,
			'src' => true
		);

	}

	if ( isset($allow_kses['img']) ) {

		$allowedtags['img'] = array(
			'alt' => true,
			'align' => true,
			'border' => true,
			'class' => true,
			'height' => true,
			'hspace' => true,
			'longdesc' => true,
			'vspace' => true,
			'src' => true,
			'style' => true,
			'width' => true,
			'title' => true,
			'usemap' => true
		);

	}

	if ( isset($allow_kses['map']) ) {

		$allowedtags['map'] = array(
			'name' => true,
			'class' => true,
			'id' => true,
			'style' => true,
			'title' => true
		);
		$allowedtags['area'] = array(
                      'alt' => true,
                      'coords' => true,
                      'href' => true,
                      'nohref' => true,
                      'shape' => true,
                      'target' => true,
                      'class' => true,
                      'id' => true,
                      'style' => true,
                      'title' => true
                );

	}

	if ( isset($allow_kses['object']) ) {

		$allowedposttags['object'] = array(
			'style' => true,
			'height' => true,
			'width' => true,
			'name' => true,
			'type' => true,
                        'form' => true,
                        'data' => true,
			'id' => true,
			'height' => true,
			'width' => true,
			'usemap' => true,
                        'classid' => true,
                        'hspace' => true,
                        'vspace' => true
		);

		$allowedposttags['param'] = array(
			'name' => true,
			'value' => true
		);

	}

	if ( isset($allow_kses['pre']) ) {
            
            $pre = array(
			'id' => true,
			'name' => true,
			'class' => true,
			'style' => true,
			'width' => true
            );
            
            if (isset($allowedposttags['pre'])) {
                $allowedposttags['pre']['name'] = true;
            }

            $allowedtags['pre'] = $pre;

	}

	if ( isset($allow_kses['script']) ) {

		$allowedposttags['script'] = array(
			'type' => true,
			'async' => true,
			'charset' => true,
			'defer' => true,
			'src' => true
		);

		$allowedposttags['noscript'] = [];

		add_filter( 'content_save_pre', 'extend_kses_plus_filter_cdata', 9, 1 );
	}
        
	if ( isset($allow_kses['microdata']) ) {
            $allowedposttags = array_map( '_add_microdata_attributes', $allowedposttags );
        }
        
        if ( isset($allow_kses['tinymce']) ) {
            add_filter('tiny_mce_before_init', 'extend_kses_plus_tinymce_valid_elements');
       }

}
add_action('admin_init','extend_kses_plus_do_magic');

/**
 * Add to extended_valid_elements for TinyMCE
 *
 * @param $init assoc. array of TinyMCE options
 * @return $init the changed assoc. array
 */
function extend_kses_plus_tinymce_valid_elements( $init ) {
    // Build our string of extended elements
    $allowed_tags = wp_kses_allowed_html( 'post' );
    $elements = [];
    foreach ( $allowed_tags as $tag => $atts ) {
        if ( is_array($atts) && !empty($atts) ) {
            $attributes = [];
            foreach ( $atts as $att => $is_allowed ) {
                if ( $is_allowed && 'xml:lang' != $att ) {
                    $attributes[] =  $att;
                }
            }
            $atts_string = '[' . implode('|', $attributes) . ']';
        } else {
            $atts_string = '';
        }
        $elements[] = $tag . $atts_string;
    }
    $extend = implode(',',$elements);

    // Add to extended_valid_elements if it alreay exists
    if ( isset($init['extended_valid_elements']) && !empty($init['extended_valid_elements']) ) {
        $init['extended_valid_elements'] .= ',' . $extend;
    } else {
        $init['extended_valid_elements'] = $extend;
    }

    return $init;    
}

function extend_kses_plus_filter_cdata( $content ) {
    $filtered = str_replace( '// <![CDATA[', '', $content );
    return str_replace( '// ]]>', '', $filtered );
}

/**
 * Helper function to add microdata attributes to a tag in the allowed html list.
 *
 * @since 3.5.0
 * @access private
 *
 * @param array $value An array of attributes.
 * @return array The array of attributes with global attributes added.
 */
function _add_microdata_attributes( $value ) {
    $attributes = array(
            'itemscope' => true,
            'itemtype' => true,
            'itemid' => true,
            'itemref' => true,
            'itemprop' => true
    );

    if ( true === $value ) {
            $value = array();
    }

    if ( is_array( $value ) ) {
            return array_merge( $value, $attributes );
    }

    return $value;
}

// TEXT DOMAIN
function extend_kses_plus_plugins_loaded() {
    if ( is_admin() ) { // text domain needed on admin only
        load_plugin_textdomain('extend-kses', false, dirname(dirname(plugin_basename( __FILE__ ))) . '/languages' );
    }
}
add_action('plugins_loaded', 'extend_kses_plus_plugins_loaded');
        
// ACTION LINK
function extend_kses_plus_add_action_link( $links ) {
    $settings_link = '<a href="' . admin_url('options-writing.php') . '">' . translate('Settings') . '</a>';
    array_unshift( $links, $settings_link ); 
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__) , 'extend_kses_plus_add_action_link' );

// REGISTER SETTINGS, SETTINGS FIELDS...
function extend_kses_plus_admin() {
    register_setting('writing', 'allow_kses', 'extend_kses_plus_sanitize_options' );
    //add_settings_section('xml_sitemap_section', '<a name="xmlsf"></a>'.__('XML Sitemap','xml-sitemap-feed'), array($this,'xml_sitemap_settings'), 'reading');
    add_settings_field('extend_kses_post_content', translate('Content'), 'extend_kses_plus_post_settings', 'writing');
    add_settings_field('extend_kses_comments', translate('Comments'), 'extend_kses_plus_comment_settings', 'writing');
}
add_action('admin_init', 'extend_kses_plus_admin', 9);



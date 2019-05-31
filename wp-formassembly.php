<?php
/*
Plugin Name: EchoDelta WP-FormAssembly
Plugin URI: http://www.formassembly.com/plugins/wordpress/
Description: Embed a FormAssembly Web Form in a WordPress Post or Page. To use, add a [formassembly formid=NNNN] tag to your post. To create your web form, go to https://www.formassembly.com
Version: 3
Author: FormAssembly / Drew Buschhorn / jhned
Author URI: https://echodelta.co
*/

/*
Inspired by Include It
http://www.satollo.com/english/wordpress/include-it/
*/

/*
Basic Usage:

[formassembly formid=NNNN]
or
[formassembly workflowid=NNNN]

(where NNNN is the ID of a form or workflow created with FormAssembly)

Advanced Attributes:
	iframe="true"                 Render as iframe
	style="XXX: YYYY;"            Add CSS overrides to either Form or Iframe
	server="a URL"                Override the default server (https://app.formassembly.com) to retrieve the form from a different FormAssembly instance, e.g., "https://acme.tfaforms.net"

*/
function fa_add( $atts ) {

	$atts = shortcode_atts(
		array(
			'server' => 'https://app.formassembly.com',
		),
		$atts,
		'formassembly'
	);

	$new_content = '';
	$qs          = '';
	$action_url  = '';
	$fa_id       = '';

	if ( isset( $_SERVER['QUERY_STRING'] ) && ! empty( $_SERVER['QUERY_STRING'] ) ) {
		$qs = '?' . $_SERVER['QUERY_STRING'];
	};

	if ( isset( $atts['server'] ) ) {
		if ( parse_url( $atts['server'] ) === false ) {
			return '';
		}
		$host_url = $atts['server'];
	} else {
		$host_url = 'https://app.formassembly.com';
	}

	if ( isset( $atts['formid'] ) || isset( $atts['workflowid'] ) ) {

		if ( isset( $atts['formid'] ) ) {
			$action_url = 'forms/view';
			$fa_id      = $atts['formid'];
		} elseif ( isset( $atts['workflowid'] ) ) {
			$action_url = 'workflows/start';
			$fa_id      = $atts['workflowid'];
		}

		// IFRAME method
		if ( isset( $atts['iframe'] ) ) {
			if ( ! isset( $atts['style'] ) ) {
				$atts['style'] = 'width: 100%; min-height: 650px;';
			}
			$attributes  = implode( ' ', array( 'frameborder=0', 'style="' . $atts['style'] . '"' ) );
			$new_content = '<iframe ' . $attributes . ' src="' . $host_url . '/' . $action_url . '/' . $fa_id . $qs . '"></iframe>';
		} else {
			// REST API method.
			// Use cURL if available
			if ( extension_loaded( 'curl' ) ) {

				$ch = curl_init();
				curl_setopt( $ch, CURLOPT_HEADER, 0 );
				curl_setopt( $ch, CURLOPT_AUTOREFERER, 1 );
				curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

				if ( ! isset( $_GET['tfa_next'] ) ) {
					curl_setopt( $ch, CURLOPT_URL, $host_url . '/rest/' . $action_url . '/' . $fa_id . $qs );
				} else {
					curl_setopt( $ch, CURLOPT_URL, $host_url . '/rest' . $_GET['tfa_next'] );
				};
				$buffer = curl_exec( $ch );
			} elseif ( '1' === ini_get( 'allow_url_fopen' ) && function_exists( 'file_get_contents' ) ) {
				// Use file_get_contents (fopen) otherwise (Note: referrer not set)

				if ( ! isset( $_GET['tfa_next'] ) ) {
					$buffer = file_get_contents( $host_url . '/rest/' . $action_url . '/' . $fa_id . $qs );
				} else {
					$buffer = file_get_contents( $host_url . '/rest' . $_GET['tfa_next'] );
				}
			} else {
				// REST API call not supported, must use iframe instead.
				$buffer = '<strong style="color:red">Your server does not support this form publishing method. Try adding iframe="1" to your FormAssembly tag.</strong>';
			}

			// Add style options in to combat WordPress' default centering of forms.
			if ( ! isset( $atts['style'] ) ) {
				$style = '<style>.wForm form{text-align: left;}</style>';
			} else {
				$style = '<style>.wForm form{' . $atts['style'] . '}</style>';
			}

			$new_content = $style . $buffer;
		}
	}

	return $new_content;
}

add_shortcode( 'formassembly', 'fa_add' );

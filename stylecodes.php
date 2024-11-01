<?php
/*
Plugin Name: StyleCodes
Plugin URI: http://www.shazahm.net/?page_id=111
Description: Adds a library of CSS style shortcodes.
Version: 0.1
Author: Steven A. Zahm
Author URI: http://www.connections-pro.com

Copyright 2010  Steven A. Zahm  (email : shazahm1@hotmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!class_exists('styleCodesLoad'))
{
	class styleCodesLoad
	{
		
		public function __construct()
		{
			define('STYLECODES_VERSION', '0.1');
			define('STYLECODES_BASE_PATH', WP_PLUGIN_DIR . '/' . plugin_basename( dirname(__FILE__)));
			define('STYLECODES_BASE_URL', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__)));
			
			// Required for the [raw] shortcode
			remove_filter('the_content', 'wpautop');
			remove_filter('the_content', 'wptexturize');
			add_filter('the_content', array(&$this, 'raw'), 99);
			add_filter('widget_text', array(&$this, 'raw'), 99);
			
			// Register the shortcodes.
			add_action( 'plugins_loaded', array(&$this, 'registerShortcodes') );
			
			// Calls the methods to load the frontend JavaScripts and CSS.
			//add_action('wp_print_scripts', array(&$this, 'loadScripts') );
			add_action('wp_print_styles', array(&$this, 'loadStyles') );
		}
		
		/**
		 * Loads the Connections CSS on the WordPress frontend.
		 * 
		 * CSS Styles Author: Webtreats | http://tutorials.mysitemyway.com/adding-column-layout-shortcodes-to-a-wordpress-theme/
		 */
		public function loadStyles()
		{
			wp_register_style('stylecodes_css', STYLECODES_BASE_URL . '/stylecodes.css', array(), STYLECODES_VERSION);
			wp_enqueue_style( 'stylecodes_css' );
		}
		
		/**
		 * Disable Automatic Formatting on Posts
		 * Thanks to TheBinaryPenguin (http://wordpress.org/support/topic/plugin-remove-wpautop-wptexturize-with-a-shortcode)
		 * 
		 * @return string
		 */
		public function raw($content)
		{
			$new_content = '';

			/* Matches the contents and the open and closing tags */
			$pattern_full = '{(\[raw\].*?\[/raw\])}is';
		
			/* Matches just the contents */
			$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
		
			/* Divide content into pieces */
			$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
		
			/* Loop over pieces */
			foreach ($pieces as $piece) {
				/* Look for presence of the shortcode */
				if (preg_match($pattern_contents, $piece, $matches)) {
		
					/* Append to content (no formatting) */
					$new_content .= $matches[1];
				} else {
		
					/* Format and append to content */
					$new_content .= wptexturize(wpautop($piece));
				}
			}
		
			return $new_content;
		}
		
		public function registerShortcodes()
		{
			add_shortcode('sc_highlight', array(&$this, 'highlight'));
			
			add_shortcode('sc_one_half', array(&$this, 'oneHalf'));
			add_shortcode('sc_one_half_last', array(&$this, 'oneHalfLast'));
			
			add_shortcode('sc_one_third', array(&$this, 'oneThird'));
			add_shortcode('sc_one_third_last', array(&$this, 'oneThirdLast'));
			add_shortcode('sc_two_third', array(&$this, 'twoThird'));
			add_shortcode('sc_two_third_last', array(&$this, 'twoThirdLast'));
			
			add_shortcode('sc_one_fourth', array(&$this, 'oneFourth'));
			add_shortcode('sc_one_fourth_last', array(&$this, 'oneFourthLast'));
			add_shortcode('sc_three_fourth', array(&$this, 'threeFourth'));
			add_shortcode('sc_three_fourth_last', array(&$this, 'threeFourthLast'));
			
			add_shortcode('sc_one_fifth', array(&$this, 'oneFifth'));
			add_shortcode('sc_one_fifth_last', array(&$this, 'oneFifthLast'));
			add_shortcode('sc_two_fifth', array(&$this, 'twoFifth'));
			add_shortcode('sc_two_fifth_last', array(&$this, 'twoFifthLast'));
			add_shortcode('sc_three_fifth', array(&$this, 'threeFifth'));
			add_shortcode('sc_three_fifth_last', array(&$this, 'threeFifthLast'));
			add_shortcode('sc_four_fifth', array(&$this, 'fourFifth'));
			add_shortcode('sc_four_fifth_last', array(&$this, 'fourFifthLast'));
			
			add_shortcode('sc_one_sixth', array(&$this, 'oneSixth'));
			add_shortcode('sc_one_sixth_last', array(&$this, 'oneSixthLast'));
			add_shortcode('sc_five_sixth', array(&$this, 'fiveSixth'));
			add_shortcode('sc_five_sixth_last', array(&$this, 'fiveSixthLast'));
		}
		
		public function highlight($atts, $content = NULL)
		{
			extract(shortcode_atts(
						array(
							'text' => 'black',
							'color' => 'yellow',
							),
							$atts
						)
				   );
			
			$highlight = array(
							'yellow' => '',
							'orange' => '',
							'pink' => '',
							'green' => '',
							'blue' => '',
							'inverted' => ''
							);
			
			return "<span class=\"highlight-$color\" style=\"color: $text; background-color: $color;\">" . do_shortcode($content) . '</span>';
		}
		
		public function oneHalf( $atts, $content = null )
		{
		   return '<div class="one-half">' . do_shortcode($content) . '</div>';
		}
		
		public function oneHalfLast( $atts, $content = null )
		{
		   return '<div class="one-half last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
		}
		
		public function oneThird( $atts, $content = null )
		{
		   return '<div class="one-third">' . do_shortcode($content) . '</div>';
		}
		
		public function oneThirdLast( $atts, $content = null )
		{
		   return '<div class="one-third last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
		}
		
		public function twoThird( $atts, $content = null )
		{
		   return '<div class="two-third">' . do_shortcode($content) . '</div>';
		}
		
		public function twoThirdLast( $atts, $content = null )
		{
		   return '<div class="two-third last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
		}
		
		public function oneFourth( $atts, $content = null )
		{
		   return '<div class="one-fourth">' . do_shortcode($content) . '</div>';
		}
		
		public function oneFourthLast( $atts, $content = null )
		{
		   return '<div class="one-fourth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
		}
		
		public function threeFourth( $atts, $content = null )
		{
		   return '<div class="three-fourth">' . do_shortcode($content) . '</div>';
		}
		
		public function threeFourthLast( $atts, $content = null )
		{
		   return '<div class="three-fourth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
		}
		
		public function oneFifth( $atts, $content = null )
		{
		   return '<div class="one-fifth">' . do_shortcode($content) . '</div>';
		}
		
		public function oneFifthLast( $atts, $content = null )
		{
		   return '<div class="one-fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
		}
		
		public function twoFifth( $atts, $content = null )
		{
		   return '<div class="two-fifth">' . do_shortcode($content) . '</div>';
		}
		
		public function twoFifthLast( $atts, $content = null )
		{
		   return '<div class="two-fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
		}
		
		public function threeFifth( $atts, $content = null )
		{
		   return '<div class="three-fifth">' . do_shortcode($content) . '</div>';
		}
		
		public function threeFifthLast( $atts, $content = null )
		{
		   return '<div class="three-fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
		}
		
		public function fourFifth( $atts, $content = null )
		{
		   return '<div class="four-fifth">' . do_shortcode($content) . '</div>';
		}
		
		public function fourFifthLast( $atts, $content = null )
		{
		   return '<div class="four-fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
		}
		
		public function oneSixth( $atts, $content = null )
		{
		   return '<div class="one-sixth">' . do_shortcode($content) . '</div>';
		}
		
		public function oneSixthLast( $atts, $content = null )
		{
		   return '<div class="one-sixth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
		}
		
		public function fiveSixth( $atts, $content = null )
		{
		   return '<div class="five-sixth">' . do_shortcode($content) . '</div>';
		}
		
		function fiveSixthLast( $atts, $content = null )
		{
		   return '<div class="five-sixth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
		}
	}
	
	
	/*
	 * Initiate the plug-in.
	 */
	global $styleCodes;
	$styleCodes = new styleCodesLoad();
	
}
?>
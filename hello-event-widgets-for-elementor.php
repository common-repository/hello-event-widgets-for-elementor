<?php
/**
 *
 * @category          WordPress_Plugin
 * @author            Tekomatik
 * @license           GPL-2.0+
 * @link              https://www.tekomatik.com
 *
 * Plugin Name:       Hello Event Widgets For Elementor
 * Plugin URI:        https://www.tekomatik.com/plugins/hello-event
 * Description:       Elementor Widgets for the Hello Event plugin
 * Author:            Christer Fernstrom
 * Author URI:        https://www.tekomatik.com/about
 *
 * Requires Plugins:  elementor, hello-event
 *
 *
 * Version:           1.0.2
 *
 * Text Domain:       hello-event-widgets-for-elementor
 * Domain Path:       /languages
 *
 *
 * License:           GPL v2
 * License URI:       https://www.opensource.org/licenses/gpl-license.php
 * Elementor tested up to: 3.21.8
 *
 * This is an add-on for WordPress
 * https://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * **********************************************************************
 */


namespace Tekomatik\HelloEventW4E;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Hello_Event_Elementor_Widgets {
  
   public function __construct() {
     add_action( 'elementor/widgets/register', array($this, 'register_hello_event_widgets' ));
     add_action( 'admin_enqueue_scripts', array($this, 'enqueue_scripts'));
     add_action( 'wp_enqueue_scripts', array($this, 'enqueue_scripts'));
     add_action( 'elementor/elements/categories_registered', array($this, 'register_custom_elementor_category' ));
     // Prepare translations
     add_action( 'plugins_loaded', array($this, 'load_textdomain' ));
   }
   
   function enqueue_scripts() {
     wp_enqueue_style('hello_event_widgets', plugins_url('css/hello-widgets.css', __FILE__));
   }
  
   function load_textdomain(){
     load_plugin_textdomain('hello-event-widgets-for-elementor', false, basename( dirname( __FILE__ ) ) . '/languages');
   }
   
   // Register custom category
   function register_custom_elementor_category( $elements_manager ) {
     $elements_manager->add_category('hello-event',
       [
         'title' => __( 'Hello Event', 'hello-event-widgets-for-elementor' ),
         'icon' => 'fa fa-plug',
        ]
     );
   }
  
   // Load widget files and register the widgets
  function register_hello_event_widgets( $widgets_manager ) {
  	require_once( __DIR__ . '/widgets/hello-event-add-to-calendar.php' );
  	require_once( __DIR__ . '/widgets/hello-event-ticket.php' );
  	require_once( __DIR__ . '/widgets/hello-event-map.php' );
  	require_once( __DIR__ . '/widgets/hello-event-thumbnail.php' );
  	require_once( __DIR__ . '/widgets/hello-event-set-default.php' );
  	require_once( __DIR__ . '/widgets/hello-event-title.php' );
  	require_once( __DIR__ . '/widgets/hello-event-info.php' );

  	$widgets_manager->register( new Hello_Event_Add_To_Calendar() );
  	$widgets_manager->register( new Hello_Event_Ticket() );
  	$widgets_manager->register( new Hello_Event_Map() );
  	$widgets_manager->register( new Hello_Event_Thumbnail() );
  	$widgets_manager->register( new Hello_Event_Title() );
  	$widgets_manager->register( new Hello_Event_Set_Default() );
  	$widgets_manager->register( new Hello_Event_Info() );
  }

} // End class
global $hello_event_elementor_widgets;
$hello_event_elementor_widgets = new Hello_Event_Elementor_Widgets();


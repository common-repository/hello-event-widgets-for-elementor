<?php

namespace Tekomatik\HelloEventW4E;

class Hello_Event_Map extends \Elementor\Widget_Base {
  
  function debug_log ( $log )  {
    if ( is_array( $log ) || is_object( $log ) ) {
       error_log( print_r( $log, true ) );
    } else {
       error_log( $log );
    }
  }
  
  // ======================================= DATA =================================
	public function get_name() {
		return 'hello_map';
	}

	public function get_title() {
		return esc_html__( 'Hello Event Map', 'hello-event-widgets-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-map-pin';
	}

	public function get_categories() {
		return [ 'hello-event' ];
	}

	public function get_keywords() {
		return [ 'hello', 'event' ];
	}

  // ======================================= CONTROLS =================================
  protected function register_controls() {

    $this->start_controls_section(
      'content_section',
      [
        'label' => esc_html__( 'Content', 'hello-event-widgets-for-elementor' ),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ],
    );

  	$this->add_control(
  	'class',
  	[
  		'type' => \Elementor\Controls_Manager::TEXT,
  		'label' => esc_html__( 'Class', 'hello-event-widgets-for-elementor' ),
  		'placeholder' => esc_html__( 'Enter the CSS class', 'hello-event-widgets-for-elementor' ),
  	]
  );
  

  	$this->end_controls_section();  // End content section;
    

  	} // End Register Controls    
    // ======================================= RENDERING =================================
    
  	protected function render() {
      global $post;
      $post_id = $post->ID;
      $event_id = \get_post_meta($post_id, 'default_event', true);
  		$settings = $this->get_settings_for_display();
      $class = 'event-map ';
      $allowed_html = array(
        'div' => array(
          'class' => array(),
          'id' => array(),
        ),
        'b' => array(),
        'script' => array(),
      );
      
      if ($settings['class'] != "")
        $class .=  $settings['class'];
      if ( \Elementor\Plugin::$instance->editor->is_edit_mode()  ||  \is_preview() ) {
        $event_map = \do_shortcode('[hello-map id='.$event_id.']');
      }
      else {
          $event_map = \do_shortcode('[hello-map]');
      }
  		if ( empty( $event_map ) ) {
  			return;
  		}
  		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) { ?>
    		<div style="border:2px solid black; height:470px; background-color: #5f6f7f; color:white;"
          <?php echo 'class="'.esc_html($class).'"'; ?>
        >
          <?php echo wp_kses($event_map, $allowed_html); ?>
          The map will appear here on the frontend
        </div>
  		<?php
      }
      else { ?>
    		<div
          <?php echo 'class="'.esc_html($class).'"'; ?>
        >
    			<?php
          echo wp_kses($event_map, $allowed_html); ?>
          
        </div>
  		<?php
        
      }
  	}

  

} // End of class
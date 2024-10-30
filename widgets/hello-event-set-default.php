<?php

namespace Tekomatik\HelloEventW4E;

class Hello_Event_Set_Default extends \Elementor\Widget_Base {
  
  
  // ======================================= DATA =================================
	public function get_name() {
		return 'hello_event_set_default';
	}

	public function get_title() {
		return esc_html__( 'Hello Event Set Default', 'hello-event-widgets-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-settings';
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
			'event_ref',
			[
				'type' => \Elementor\Controls_Manager::TEXT,
				'label' => esc_html__( 'Event', 'hello-event-widgets-for-elementor' ),
				'description' => esc_html__( 'Enter the slug or the post id of an event to display during edit', 'hello-event-widgets-for-elementor' ),
			]
		);
    
  	$this->end_controls_section();  // End content section;
    
  	} // End Register Controls
    
    // ======================================= RENDERING =================================
    
  	protected function render() {
  		$settings = $this->get_settings_for_display();
      if ($settings['event_ref']) {
        if (is_numeric($settings['event_ref']))
          $event_id = $settings['event_ref'];
        else {
          $event = get_page_by_path($settings['event_ref'], OBJECT, \Tekomatik\HelloEvent\Hello_Event::EVENT_SLUG);
          $event_id = $event ? $event->ID : 0;
        }
        global $post;
        $post_id = $post->ID;
        \update_post_meta($post_id, 'default_event', $event_id);
      }
      return;
  	}

  
} // End class
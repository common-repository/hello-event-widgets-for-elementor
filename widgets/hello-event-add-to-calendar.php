<?php

namespace Tekomatik\HelloEventW4E;

class Hello_Event_Add_To_Calendar extends \Elementor\Widget_Base {
    
  function debug_log ( $log )  {
    if ( is_array( $log ) || is_object( $log ) ) {
       error_log( print_r( $log, true ) );
    } else {
       error_log( $log );
    }
  }
  
  // ======================================= DATA =================================
	public function get_name() {
		return 'hello_event_add_calendar';
	}

	public function get_title() {
		return esc_html__( 'Hello Event Add to Calendar', 'hello-event-widgets-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-calendar';
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
        'label' => esc_html__( 'Text', 'hello-event-widgets-for-elementor' ),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ],
    );

  
  	$this->add_control(
    	'text',
    	[
    		'type' => \Elementor\Controls_Manager::TEXT,
    		'label' => esc_html__( 'Text', 'hello-event-widgets-for-elementor' ),
        'default' => esc_html__('Add to calendar', 'hello-event-widgets-for-elementor'),
    	]
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
    
		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'hello-event-widgets-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'button-color',
			[
				'label' => esc_html__( 'Text color', 'hello-event-widgets-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#fff',
        'selectors' => [
          '{{WRAPPER}} .event-add-to-calendar input[type=submit]' => 'color: {{VALUE}}',
        ],
			]
		);
    
		$this->add_control(
			'button-background-color',
			[
				'label' => esc_html__( 'Button background color', 'hello-event-widgets-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#DA4453',
        'selectors' => [
          '{{WRAPPER}} .event-add-to-calendar.hello-button form input[type=submit]' => 'background-color: {{VALUE}}',
        ],
			]
		);
    
		$this->add_control(
			'button-background-color-hover',
			[
				'label' => esc_html__( 'Button background color on hover', 'hello-event-widgets-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#DF4958',
        'selectors' => [
          '{{WRAPPER}} .event-add-to-calendar.hello-button:hover form input[type=submit]:hover' => 'background-color: {{VALUE}}',
        ],
			]
		);
    
  	$this->add_group_control(
  			\Elementor\Group_Control_Typography::get_type(),
  			[
  				'name' => 'content_typography',
  				'selector' => '{{WRAPPER}} .event-add-to-calendar a',
  			]
  		);
    

		$this->end_controls_section();  // End style section
    

  	} // End Register Controls    
    // ======================================= RENDERING =================================
    
  	protected function render() {
      global $post;
      $post_id = $post->ID;
      $event_id = \get_post_meta($post_id, 'default_event', true);
  		$settings = $this->get_settings_for_display();
      $label = esc_html($settings['text']);

      $shortcode = 'hello-event-ics';
      if ( \Elementor\Plugin::$instance->editor->is_edit_mode()  ||  \is_preview() ) {
        $event_add_to_calendar = \do_shortcode('['.$shortcode.' id='.$event_id.' text="'.$label.'"]');
      }
      else {
        $event_add_to_calendar = \do_shortcode('['.$shortcode.' text="'.$label.'"]');
      }
      if ( empty( $event_add_to_calendar ) ) {
        return;
      }
      
    
      
     $class = 'event-add-to-calendar hello-button ';
      if ($settings['class'] != "")
        $class .=  $settings['class'];
  		?>
  		<div
        <?php echo 'class="'.esc_html($class).'"'; ?>
      >
  			<?php
        $allowed_html = array(
          'form' => array(
            'method' => 'post',
            'action' => '#',
          ),
          'input' => array(
            'type' => ['hidden', 'submit'],
            'name' => array(),
            'value' => array(),
          ),
        );
        echo wp_kses($event_add_to_calendar, $allowed_html);
        ?>
      </div>
  		<?php
  	}


} // End of class
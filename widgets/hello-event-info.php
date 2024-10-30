<?php

namespace Tekomatik\HelloEventW4E;

class Hello_Event_Info extends \Elementor\Widget_Base {
  
  function debug_log ( $log )  {
    if ( is_array( $log ) || is_object( $log ) ) {
       error_log( print_r( $log, true ) );
    } else {
       error_log( $log );
    }
  }
  
  // ======================================= DATA =================================
	public function get_name() {
		return 'hello_event_info';
	}

	public function get_title() {
		return esc_html__( 'Hello Event Info', 'hello-event-widgets-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-typography';
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
    	'information',
    	[
    		'type' => \Elementor\Controls_Manager::SELECT,
    		'label' => esc_html__( 'Information', 'hello-event-widgets-for-elementor' ),
    		'description' => esc_html__( 'Select the event information to retrieve', 'hello-event-widgets-for-elementor' ),
        'options' => [
          'start-date' =>             __("Start date", 'hello-event-widgets-for-elementor'),
          'start-time' =>             __("Start time", 'hello-event-widgets-for-elementor'),
          'start-date-and-time' =>    __("Start date and time", 'hello-event-widgets-for-elementor'),
          'end-date' =>               __("End date", 'hello-event-widgets-for-elementor'),
          'end-time' =>               __("End time", 'hello-event-widgets-for-elementor'),
          'end-date-and-time' =>      __("End date and time", 'hello-event-widgets-for-elementor'),
          'location' =>               __("Location", 'hello-event-widgets-for-elementor'),
          'excerpt' =>                __("Excerpt", 'hello-event-widgets-for-elementor'),
          'content' =>                __("Content", 'hello-event-widgets-for-elementor'),
        ],
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
			'color',
			[
				'label' => esc_html__( 'Color', 'hello-event-widgets-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#333',
        'selectors' => [
          '{{WRAPPER}} .event-info' => 'color: {{VALUE}}',
        ],
			]
		);
    
  	$this->add_group_control(
  		\Elementor\Group_Control_Typography::get_type(),
  		[
  			'name' => 'content_typography',
  			'selector' => '{{WRAPPER}} .event-info',
  		]
  	);

		$this->end_controls_section();  // End style section
    

  	} // End Register Controls
    // Help function
    function my_allowed_html() {

    	$allowed_tags = array(
    		'a' => array(
    			'class' => array(),
    			'href'  => array(),
    			'rel'   => array(),
    			'title' => array(),
    		),
    		'abbr' => array(
    			'title' => array(),
    		),
    		'b' => array(),
    		'blockquote' => array(
    			'cite'  => array(),
    		),
    		'cite' => array(
    			'title' => array(),
    		),
    		'code' => array(),
    		'del' => array(
    			'datetime' => array(),
    			'title' => array(),
    		),
    		'dd' => array(),
    		'div' => array(
    			'class' => array(),
    			'title' => array(),
    			'style' => array(),
    		),
    		'dl' => array(),
    		'dt' => array(),
    		'em' => array(),
    		'h1' => array(),
    		'h2' => array(),
    		'h3' => array(),
    		'h4' => array(),
    		'h5' => array(),
    		'h6' => array(),
    		'i' => array(),
    		'img' => array(
    			'alt'    => array(),
    			'class'  => array(),
    			'height' => array(),
    			'src'    => array(),
    			'width'  => array(),
    		),
    		'li' => array(
    			'class' => array(),
    		),
    		'ol' => array(
    			'class' => array(),
    		),
    		'p' => array(
    			'class' => array(),
    		),
    		'q' => array(
    			'cite' => array(),
    			'title' => array(),
    		),
    		'span' => array(
    			'class' => array(),
    			'title' => array(),
    			'style' => array(),
    		),
    		'strike' => array(),
    		'strong' => array(),
    		'ul' => array(
    			'class' => array(),
    		),
    	);
	
    	return $allowed_tags;
    }
    
    // ======================================= RENDERING =================================
    
  	protected function render() {
      global $post;
      $post_id = $post->ID;
      $event_id = \get_post_meta($post_id, 'default_event', true);
  		$settings = $this->get_settings_for_display();
      $shortcode = 'hello-' . $settings['information'];
      if ( \Elementor\Plugin::$instance->editor->is_edit_mode()  ||  \is_preview() ) {
        $event_info = \do_shortcode('['.$shortcode.' id='.$event_id.']');
      }
      else {
          $event_info = \do_shortcode('['.$shortcode.']');
      }
  		if ( empty( $event_info ) ) {
  			return;
  		}
      $class = 'event-info ';
      if ($settings['class'] != "")
        $class .=  $settings['class'];
  		?>
  		<div
        <?php echo 'class="'.esc_html($class).'"'; ?>
      >
      <?php
      $allowed_html = $this->my_allowed_html();
      echo wp_kses($event_info, $allowed_html); ?>
      </div>
  		<?php
  	}

  } // End of class
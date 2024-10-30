<?php

namespace Tekomatik\HelloEventW4E;

class Hello_Event_Title extends \Elementor\Widget_Base {
   
  function debug_log ( $log )  {
    if ( is_array( $log ) || is_object( $log ) ) {
       error_log( print_r( $log, true ) );
    } else {
       error_log( $log );
    }
  }
  
  // ======================================= DATA =================================
	public function get_name() {
		return 'hello_event_title';
	}

	public function get_title() {
		return esc_html__( 'Hello Event Title', 'hello-event-widgets-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-t-letter';
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
  		'tag',
  		[
    		'type' => \Elementor\Controls_Manager::SELECT,
  			'label' => esc_html__( 'HTML Tag', 'hello-event-widgets-for-elementor' ),
  			'description' => esc_html__( 'Enter the HTML tag', 'hello-event-widgets-for-elementor' ),
        'options' => [
          'H1' =>  'H1',
          'H2' =>  'H2',
          'H3' =>  'H3',
          'H4' =>  'H4',
          'H5' =>  'H5',
          'H6' =>  'H6',
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
				'default' => '#f00',
        'selectors' => [
          '{{WRAPPER}} .event-title' => 'color: {{VALUE}}',
        ],
			]
		);
    
  	$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .event-title',
			]
		);
    
		$this->end_controls_section();  // End style section
    
  	} // End Register Controls
    
    // ======================================= RENDERING =================================
    
  	protected function render() {
      // $post_id = $_GET['post']; // The page we're editing
      global $post;
      $post_id = $post->ID;
      $event_id = \get_post_meta($post_id, 'default_event', true);
  		$settings = $this->get_settings_for_display();
      if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
        $event_title = \do_shortcode('[hello-title id='.$event_id.']');
      }
      elseif ( \is_preview() ) {
        $event_title = \do_shortcode('[hello-title id='.$event_id.']');
      }
      else {
          $event_title = \do_shortcode('[hello-title]');
      }
  		if ( empty( $event_title ) ) {
  			return;
  		}
      $class = 'event-title ';
      if ($settings['class'] != "")
        $class .=  $settings['class'];
  		?>
  		<<?php echo esc_html($settings['tag']); ?>
        <?php echo 'class="'.esc_html($class).'"'; ?>
      >
  			<?php echo esc_html($event_title); ?>
      </<?php echo esc_html($settings['tag']); ?>>
  		<?php
  	}

  
} // End class
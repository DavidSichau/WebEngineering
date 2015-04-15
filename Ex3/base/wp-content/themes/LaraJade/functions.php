<?php 

	require_once('theme-options.php');
    add_theme_support('post-thumbnails');    

	$stylesheet_url = get_bloginfo('stylesheet_url');
	$stylesheet_dir = get_bloginfo('stylesheet_directory');
	$images_url = get_bloginfo('stylesheet_url').'/images/';

	function echoPicture($ssurl, $locurl) {
	 echo $ssurl.'/'.$locurl;
	}

	/* PORTFOLIO Settings */
	if( ! function_exists( 'create_portfolio_post_type' ) ):
  		function create_portfolio_post_type() {
		    $labels = array(
		       'name' => __( 'Portfolio' ),
				'singular_name' => __( 'Portfolio' ),
				'menu_name' => __( 'Portfolios' ),
				'add_new' => __( 'Add Portfolio' ),
				'all_items' => __( 'All Portfolios' ),
				'add_new_item' => __( 'Add Portfolio' ),
				'edit_item' => __( 'Edit Portfolio' ),
				'new_item' => __( 'New Portfolio' ),
				'view_item' => __( 'View Portfolio' ),
				'search_items' => __( 'Search Portfolios' ),
				'not_found' => __( 'No Portfolios found' ), 
				'not_found_in_trash' => __( 'No Portfolios found in trash' ), 
				'parent_item_colon' => __( 'Parent Portfolio' )
		    );

		    $args = array(
		    	'labels' => $labels,
				'public' => true, 
				'publicly_queryable' => true, 
				'show_in_nav_menus' => true, 
				'query_var' => true, 
				'rewrite' => true, 
				'capability_type' => 'post', 
				'hierarchical' => false, 
				'supports' => array(
					'title',
					'thumbnail', 
					//'editor', 
					//'author', 
					//'excerpt', 
					//'trackbacks', 
					//'custom-fields', 
					//'comments', 
					//'revisions', 
					//'page-attributes', 
					//'post-formats',
				), 
				'menu_position' => 5,
				'register_meta_box_cb' => 'add_portfolio_post_type_metabox'
		    );

		  	register_post_type( 'portfolio', $args );
		  	register_taxonomy( 'custom_category', 'portfolio',
		    	array(
		          'hierarchical' => true//,
		          //'label' => 'role'
		       	)
			); 
		}
		add_action( 'init', 'create_portfolio_post_type' );
	endif;

	function add_portfolio_post_type_metabox() {
  		add_meta_box( 'portfolio_metabox', 'Portfolio Data', 'portfolio_metabox', 'portfolio', 'normal' );
  	}

  	function portfolio_metabox() {
		global $post;
		$custom = get_post_custom($post->ID);
		$year = $custom['portfolio_year'][0]; 
		$description = $custom['portfolio_description'][0]; 
		$url = $custom['portfolio_url'][0];
		?>
		<div class="portfolio">
			<p> 
				<label>Year<br> 
				<input type="text" name="year" size="50" value ="<?php echo $year; ?>"> </label> 
			</p>
			<p> 
				<label>Description<br> 
				<input type="text" name="description" size="50" value ="<?php echo $description; ?>"> </label> 
			</p>
			<p> 
				<label>URL<br> 
				<input type="text" name="url" size="50" value="<?php echo $url; ?>"> </label>
			</p>
		</div>
	<?php }

	function portfolio_post_save_meta( $post_id, $post ) {
		// is the user allowed to edit the post or page?
		if( ! current_user_can( 'edit_post', $post->ID )){
	  		return $post->ID;
		}
		
		$portfolio_post_meta['portfolio_year'] = $_POST['year']; 
		$portfolio_post_meta['portfolio_description'] = $_POST['description']; 
		$portfolio_post_meta['portfolio_url'] = $_POST['url']; 

	  	// add values as custom fields
	  	foreach( $portfolio_post_meta as $key => $value ) {
	    	if( get_post_meta( $post->ID, $key, FALSE ) ) {
	      		// if the custom field already has a value
				update_post_meta($post->ID, $key, $value); 
			} else {
	      		// if the custom field doesn't have a value
	      		add_post_meta( $post->ID, $key, $value );
	    	}
		    if( !$value ) {
		      // delete if blank
		      delete_post_meta( $post->ID, $key );
			} 
		}
	}

	add_action( 'save_post', 'portfolio_post_save_meta', 1, 2 );
	/* END PORTFOLIO Setting */

	/* Post-to-Post */
	function my_connection_types() {
	    p2p_register_connection_type( array(
	        'name' => 'posts_to_pages',
	        'from' => 'post',
	        'to' => 'portfolio'
	    	) 
	    );
	}
	add_action( 'p2p_init', 'my_connection_types' );
	/* END Post-to-Post*/

	/* Theme customization */
	/* Colors */
	function laraJade_customizer( $wp_customize ) {
		// add new section
		$wp_customize->add_section( 'laraJade_theme_colors', array(
			'title' => __( 'Change Colors', 'laraJade' ),
			'priority' => 100,
			) 
		);

		/* BACKGROUND */
		// add color picker setting
		$wp_customize->add_setting( 'bg_color', array(
			'default' => '#414141'
			) 
		);

		// add color picker control
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bg_color', array(
				'label' => 'Background Color',
				'section' => 'laraJade_theme_colors',
				'settings' => 'bg_color',
				) 
			)
		);

		/* HEADLINE */
		// add color picker setting
		$wp_customize->add_setting( 'headline_color', array(
			'default' => '#1e73be'
			) 
		);

		// add color picker control
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'headline_color', array(
				'label' => 'Headline Color',
				'section' => 'laraJade_theme_colors',
				'settings' => 'headline_color',
				) 
			)
		);

		/* Article text */
		// add color picker setting
		$wp_customize->add_setting( 'article_color', array(
			'default' => '#474D51'
			) 
		);

		// add color picker control
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'article_color', array(
				'label' => 'Article Color',
				'section' => 'laraJade_theme_colors',
				'settings' => 'article_color',
				) 
			)
		);
	}
	add_action( 'customize_register', 'laraJade_customizer' );

	// bg fct
	function laraJade_customizer_head_styles() {
		$bg_color = get_theme_mod( 'bg_color' ); 
		
		if ( $bg_color != '#414141' ) :
		?>
			<style type="text/css">
				body {
					background-color: <?php echo $bg_color; ?>;
				}
				#header {
					background-color: <?php echo $bg_color; ?>;	
				}
			</style>
		<?php
		endif; ?>
		<style type="text/css">
				h2.headline {
					font-size: 2em;
				}
		</style>
		<?php
	}
	add_action( 'wp_head', 'laraJade_customizer_head_styles' );
	
	// headline fct
	function laraJade_headline_customizer_head_styles() {
		$headline_color = get_theme_mod( 'headline_color' ); 
		
		if ( $headline_color != '#1e73be' ) :
		?>
			<style type="text/css">
				h2.headline {
					color: <?php echo $headline_color; ?>;
				}
			</style>
		<?php
		endif;
	}
	add_action( 'wp_head', 'laraJade_headline_customizer_head_styles' );
	
	// article fct
	function laraJade_article_customizer_head_styles() {
		$article_color = get_theme_mod( 'article_color' ); 
		
		if ( $article_color != '#1e73be' ) :
		?>
			<style type="text/css">
				#blog p {
					color: <?php echo $article_color; ?>;
				}
			</style>
		<?php
		endif;
	}
	add_action( 'wp_head', 'laraJade_article_customizer_head_styles' );
	/* END Colors */

	/* Address details */
	function laraJade_address_customizer( $wp_customize ) {

		/**
		 * Adds textarea support to the theme customizer
		 */
		class Example_Customize_Textarea_Control extends WP_Customize_Control {
		    public $type = 'textarea';
		 
		    public function render_content() {
		        ?>
		            <label>
		                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		                <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
		            </label>
		        <?php
		    }
		}

		$defAddr = '
		<br>
		<br>
		New Chrichton Cottage
		<br>
		Arradoul, Buckie
		<br>
		AB43 5AP
		<br>
		Scotland UK
		<br>
		<br>
		+44 (0) 1234 567891
		';

		$wp_customize->add_section( 'address_section', array(
			'title' => __( 'Manage Address', 'laraJade' ),
			'priority' => 100,
			) 
		);

		$wp_customize->add_setting( 'address_textbox', array(
		        'default' => $defAddr,
		    )
		);

		/*
		$wp_customize->add_control('address_textbox', array(
			'label' => 'Address',
			'section' => 'address_section',
			'settings' => 'address_textbox',
			'type' => 'text',
			) 
		);
		*/

		$wp_customize->add_control(
		    new Example_Customize_Textarea_Control(
		        $wp_customize,
		        'textarea',
		        array(
		            'label' => 'Address',
		            'section' => 'address_section',
		            'settings' => 'address_textbox'
		        )
    		)
		);

	}
	add_action( 'customize_register', 'laraJade_address_customizer' );
	/* END Address details*/

	/* Header image details */
	/*
	function laraJade_headerImg_customizer( $wp_customize ) {
		$wp_customize->add_section( 'header_img_section', array(
			'title' => __( 'Header Image', 'laraJade' ),
			'priority' => 100,
			) 
		);

		$wp_customize->add_setting( 'img-upload' );
 
		$wp_customize->add_control(
		    new WP_Customize_Image_Control(
		        $wp_customize,
		        'img-upload',
		        array(
		            'label' => 'Select Image',
		            'section' => 'header_img_section',
		            'settings' => 'img-upload'
		        )
		    )
		);
	}
	add_action( 'customize_register', 'laraJade_headerImg_customizer' );
	*/
	// Register Theme Features
	function laraJade_theme_features()  {

		// Add theme support for Custom Header
		$header_args = array(
			'default-image'          => 'http://localhost/we2015/wp-content/themes/LaraJade/images/bg1.png',
			'width'                  => 0,
			'height'                 => 400,
			'flex-width'             => true,
			'flex-height'            => true,
			'uploads'                => true,
			'random-default'         => false,
			'header-text'            => false,
			'default-text-color'     => '',
			'wp-head-callback'       => '',
			'admin-head-callback'    => '',
			'admin-preview-callback' => '',
		);
		add_theme_support( 'custom-header', $header_args );
	}

	// Hook into the 'after_setup_theme' action
	add_action( 'after_setup_theme', 'laraJade_theme_features' );
	/* END Header image details*/

	/* END Theme customization */
?>
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
		          'hierarchical' => true,
		          'label' => 'role'
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
?>
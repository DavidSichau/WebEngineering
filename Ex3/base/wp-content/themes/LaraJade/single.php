<?php 
	global $stylesheet_dir, $stylesheet_url;
	get_header(); 
?>

	<div id="main" class="group">
		<main id="blog" class="left-col">

		<?php
			while ( have_posts() ) : the_post();

			if (get_post_type() == 'post') {
				the_title('<h1 style="color:blue;size=5em"><strong>','</strong></h1>');
				the_post_thumbnail( 'large', array( 'float' => 'left' ) );
				the_content();	
			} else if (get_post_type() == 'portfolio') {
				the_title('<h1 style="color:blue;size=5em"><strong>','</strong></h1>');
				the_post_thumbnail( 'large', array( 'float' => 'left' ) );
				echo '</br>';
				//the_content();
				$custom_fields = get_post_custom();
				foreach ( $custom_fields as $field_key => $field_values ) {
					if(!isset($field_values[0])) 
						continue; 
					if(in_array($field_key,array("_edit_lock","_edit_last")))
						continue; 
					// year
					if(strpos($field_key,"year") !== false) {
						echo '<strong>Year: </strong>';
						echo $field_values[0]; 
					// description
					} elseif(strpos($field_key,"description") !== false) {
						echo '<strong>Description: </br></strong>';
						echo $field_values[0]; 
					// URL
					} elseif(strpos($field_key,"url") !== false) {
						echo '<strong>URL: </strong>';
						echo '<a href="'.$field_values[0].'">';
						echo $field_values[0]; 
						echo '</a>';
					}
					echo '<br/>';
				}
				//var_dump(get_post_type());
			}

			// Previous/next post navigation.
			the_post_navigation( array(
				'next_text' =>
					'<span class="screen-reader-text">' . __( 'Next post:', 'LaraJade' ) . '</span> ' .
					'<span class="post-title">%title</span>',
				'prev_text' =>
					'<span class="screen-reader-text">' . __( 'Previous post:', 'LaraJade' ) . '</span> ' .
					'<span class="post-title">%title</span>',
			) );

			// End the loop.
			endwhile;
		?>

		</main>
	</div>

<?php get_footer(); ?>

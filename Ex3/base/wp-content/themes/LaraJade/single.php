<?php 
	global $stylesheet_dir, $stylesheet_url;
	get_header(); 
?>

	<div id="main" class="group">
		<main id="blog" class="left-col">

		<?php
			while ( have_posts() ) : the_post();

			the_title('<h1 style="color:blue;size=5em"><strong>','</strong></h1>');
			the_post_thumbnail( 'large', array( 'float' => 'left' ) );
			the_content();

			// Previous/next post navigation.
			the_post_navigation( array(
				'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'LaraJade' ) . '</span> ' .
					'<span class="screen-reader-text">' . __( 'Next post:', 'LaraJade' ) . '</span> ' .
					'<span class="post-title">%title</span>',
				'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'LaraJade' ) . '</span> ' .
					'<span class="screen-reader-text">' . __( 'Previous post:', 'LaraJade' ) . '</span> ' .
					'<span class="post-title">%title</span>',
			) );

			// End the loop.
			endwhile;
		?>

		</main>
	</div>

<?php get_footer(); ?>

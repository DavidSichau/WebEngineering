<?php 
    global $stylesheet_dir, $stylesheet_url;
    get_header();
?>
				<div class="container" style="background-image: url('<?php echoPicture($stylesheet_dir,'./images/bg2.png');?> ');background-size: 100%;background-repeat: no-repeat;background-color: #040205; " role="main">

					<ul class="list">
						<?php
							$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
							$args = array( 
								'posts_per_page' => 4, 
								'offset'=> 0,
								'paged' => $paged
								);

							$allPosts = new WP_Query($args);
							while ( $allPosts->have_posts() ):
								$allPosts->the_post();
						?>

                       	<li class="blog_list__item">
							<figure class="blog_list__item__inner">
								<figcaption>
									<?php the_post_thumbnail('thumbnail'); ?>
									<strong><?php the_title(); ?></strong>.
									<?php the_excerpt(); ?>
									<a href=<?php the_permalink(); ?>>Read more</a>
								</figcaption>
							</figure>
						</li>
						
						<?php 
							endwhile;
						?>
					</ul>
					
					<div style="margin: auto;">
					<?php 
						next_posts_link( 'Older Entries', $allPosts->max_num_pages );
						previous_posts_link( 'Newer Entries' );
					?>
					</div>
					<?php
						wp_reset_postdata(); 
					?>

				</div>
<?php 
    get_footer();
?>
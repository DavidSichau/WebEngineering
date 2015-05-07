<?php 
    get_header();
    global $stylesheet_dir;
?>
				<div class="container" style="background-image: url('./images/bg3.png');background-size: 100%;background-repeat: no-repeat;background-color: #040205; " role="main">

					<ul class="list">
						<?php
							$portfolioQuery = new WP_Query('post_type=portfolio');
							if ($portfolioQuery->have_posts()):
								while($portfolioQuery->have_posts()):
									$portfolioQuery->the_post();
						?>

						<li class="list__item">
							<figure class="list__item__inner">
								<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail('thumbnail'); ?>
								</a>
								<figcaption>
									<strong><?php the_title(); ?></strong>
									<br>
									<?php
										$year = get_post_meta(get_the_ID(),'portfolio_year',true);
										if ($year != '') {echo $year;}
									?>
								</figcaption>
							</figure>
						</li>

						<?php
								endwhile;
							endif;
						?>
					</ul>

				</div>

<?php 
    get_footer();
?>
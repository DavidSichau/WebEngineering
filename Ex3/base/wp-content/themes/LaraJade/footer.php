<?php global $stylesheet_dir;?>
<div id="footer" style="min-height:250px;">
                <?php wp_footer(); ?>
				<!-- <div class="flex-container"> -->
				<div class="flex-item" style="margin-right: 1.25rem;">
					<strong>ADDRESS</strong>
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
					<br>
					<br>
					<img width="35%" src="<?php echoPicture($stylesheet_dir,'images/qcode.png');?> " align="left">
				</div>
				<div class="flex-item" style="margin-right: 1.25rem;">
					<strong>About Me</strong>
					<br>
					<br>
					<?php 
						$maxWords = 25;
						$aboutMe = get_option('aboutMe_text');
						$textArr = explode(' ', $aboutMe);
						if (count($textArr) >= $maxWords) {
							$text = implode(' ', array_slice($textArr, 0, $maxWords));
							$text = $text.'...';
						} else {
							$text = implode(' ', array_slice($textArr, 0, $maxWords));
						}
						
						echo $text;
						
					?>
					<strong><a href="index.php" style="color:#fff;">More</a></strong>
					<br>
					<br>
					<strong>Follow me:</strong>
					<br>
					<br>
					<img src="<?php echoPicture($stylesheet_dir,'images/twitter.png');?>" width="15%">
					<img src="<?php echoPicture($stylesheet_dir,'images/linkedin.png');?>" width="15%">
					<img src="<?php echoPicture($stylesheet_dir,'images/pinterest.png');?>" width="15%">
					<img src="<?php echoPicture($stylesheet_dir,'images/facebook.png');?>" width="15%">
					<img src="<?php echoPicture($stylesheet_dir,'images/google_plus.png');?>" width="15%">
				</div>
				<div class="flex-item" style="margin-right: 1.25rem;">
					<strong>My last post</strong>
					<br>
					<br>
					<?php
						$args = array( 
							'posts_per_page' => 1, 
							'offset'=> 0,
							);

						$allPosts = new WP_Query($args);
						if ($allPosts->have_posts() ) {
							$allPosts->the_post();
							the_excerpt();
						}
					?>
					<a href=<?php the_permalink(); ?> style="color: white;"><strong>More</strong></a>
				</div>
				<div class="flex-item">
					<?php
						$latestPortfolio = new WP_Query('post_type=portfolio');
						if ($latestPortfolio->have_posts() ) {
							$latestPortfolio->the_post();
						}
					?>
					<strong>Last Project</strong>
					<br>
					</br>
					<?php the_title(); ?>
					<br>
					<br>
					<?php the_post_thumbnail('thumbnail'); ?>
				</div>

				<!-- </div> -->
			</div>
		</div>

	</body>
</html>
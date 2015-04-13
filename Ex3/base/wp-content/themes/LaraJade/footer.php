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
						if ( $allPosts->have_posts() ) {
							$allPosts->the_post();
							the_excerpt();
						}
					?>
					<a href=<?php the_permalink(); ?> style="color: white;"><strong>More</strong></a>
				</div>
				<div class="flex-item">
					<strong>Last Project</strong>
					<br>
					</br>
					Freelance WebSite
					<br>
					<br>
					<img width="80%" src="<?php echoPicture($stylesheet_dir,'images/portfolio/p1.jpg');?>" >
				</div>

				<!-- </div> -->
			</div>
		</div>

	</body>
</html>
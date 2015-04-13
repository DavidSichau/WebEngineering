<?php
	add_action('admin_menu', 'setup_theme_admin_menu');
	
	function setup_theme_admin_menu() { 
		add_menu_page(
			'Index Page Settings', 
			'Index Page Intro', 
			'manage_options', 
			'aboutMe_settings', 
			'aboutMe_settings_page'
		);
	}
?>

<?php
function aboutMe_settings_page() { ?>
	<style type="text/css">
	<?php include('settings.css'); ?>
	</style>
	<div class="wrap" >
		<?php screen_icon('themes'); ?> 
		<h2>Index Page Settings</h2>
		<form method="POST" action="">
			<input type="hidden" name="update_settings" value="Y" />
				<table class="form-table">
					<tr>
						<th>
							<label for="aboutMe">Introduction text</label>
						</th>
						<td>
							<textarea type="text" name="aboutMe" rows="15" cols="65">
								<?php
									// TODO: get just updated text instead last saved text 
									print get_option("aboutMe_text"); 
								?>
							</textarea>
						</td> 
					</tr>
				</table>
			<p>
				<input type="submit" value="Save settings" class="button-primary"/>
			</p> 
		</form>
	</div> 

	<?php
	if (isset($_POST["update_settings"])) {
		$aboutMe = esc_attr($_POST["aboutMe"]); 
		update_option("aboutMe_text", $aboutMe); 
	?>
	<div id="message" class="updated">Settings saved</div>
	<?php }
} ?>
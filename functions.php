<?php
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
add_shortcode('homepagebox', 'homepageboxfunc');

function theme_enqueue_styles() {

	$parent_style = 'unite-parent-style';

	wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
	wp_enqueue_style('child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array($parent_style),
		wp_get_theme()->get('Version')
	);
	wp_enqueue_script('jquery-cycle', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.cycle/3.0.3/jquery.cycle.all.js', array(), '1.0.0', true);
}

function homepageboxfunc($atts) {
	$boxes = shortcode_atts(array(
		'title' => '',
		'details' => '',
		'linktext' => '',
		'link' => '',
		'imagurl' => '',
	), $atts);
	ob_start();
	?>
	<div class="homepage_box_container">
		<div class="homeBox_title">
			<?php echo $boxes['title']; ?>
		</div>
		<div class="homepage_box_wrapper">
			<div class="homepage_box_left">
				<div class="homeBox_details">
					<?php echo $boxes['details']; ?>
				</div>
			</div>
			<div class="homeBox_right">
				<?php echo '<img class="alignnone" title="" src="' . $boxes['imagurl'] . '" alt="">'; ?>
			</div>
		</div>
		<div class="link_div">
			<?php
echo '<a href="' . $boxes['link'] . '">' . $boxes['linktext'] . '</a>';
	?>
		</div>
	</div>
	<?php
$all_film = ob_get_clean();
	return $all_film;
}
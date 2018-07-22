<?php
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
add_shortcode('homepagebox', 'homepageboxfunc');
add_shortcode('newsletterbox', 'testimonial_shortcode');

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

function testimonial_shortcode() {
	ob_start();
	?>
	<div class="testimonials_container">

		<div id="newsletter">

			<div class="title special_font">

				Newsletter Signup

			</div>

			<form action="" method="post" id="newsletter_form">

				<input type="hidden" name="wp3_newsletter_subscribe" value="true">

				<input name="wp3newsletter_email" onfocus="if(this.value=='Email Address')this.value='';" onblur="if(this.value=='')this.value='Email Address';" type="text" class="input" value="Email Address">

				<input name="submit" type="submit" class="button" value="Submit">

			</form>

		</div>

		<script type="text/javascript">



		</script>

		<div class="testimonial_home">

			<h3>

				<a href="http://JRRosenStudio.com/testimonials/">Testimonials</a>

			</h3>

			<script type="text/javascript">

				jQuery(function(){

					jQuery('.testimonial_home .text').cycle();

				});

			</script>

			<div class="text">
				<div>
					"On behalf of everyone at the Perkins School for the Blnid, thank you! Your parcipitation in the Thomas and Bessie Horticulture Center..."<br>
					<br>
					To read Sandy Sharpio's Testimonial, click below!
					<br>
					<em><strong><a href="http://JRRosenStudio.com/perkins-schoo/">Perkins School for the Blind</a></strong></em>
				</div>

				<div >

					"Thank you so much for rushing the envelopes for me, I greatly appreciate it! They came out beautiful, the bride will be thrilled!..."<br>
					<br>
					To read Michelle Choy's full testimonial, click below!
					<br>

					<em><strong><a href="http://JRRosenStudio.com/758-2/">Michelle Choy</a></strong></em>
				</div>

				<div>
					"Just a quick note to thank you for the beautiful work you did for our wedding. The programs, seating scroll, and table cards looked... "<br>
					<br>
					To read Amy Logan Maloney's full testimonial, click below!
					<br>
					<em><strong><a href="http://JRRosenStudio.com/amy-logan-maloney/">Amy Logan Maloney</a></strong></em>
				</div>
			</div>

		</div>

		<!--end testimonial-->

	</div>
	<?php
$newsletter_form = ob_get_clean();
	return $newsletter_form;
}
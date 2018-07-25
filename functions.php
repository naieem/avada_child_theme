<?php
add_action('wp_enqueue_scripts', 'theme_enqueue_styles'); // querying styles
add_shortcode('homepagebox', 'homepageboxfunc'); // homepage 3 boxes shortcode
add_shortcode('newsletterbox', 'testimonial_shortcode'); // testimonial homepage shortcode
add_shortcode('testimoniallist', 'testimonial_list'); // testimonial list shortcode
add_action('init', 'testimonial_post_type_init'); // adding testimonial post type
function theme_enqueue_styles() {

	$parent_style = 'unite-parent-style';

	wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
	wp_enqueue_style('child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array($parent_style),
		wp_get_theme()->get('Version')
	);
	wp_enqueue_script('jquery-cycle', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.cycle/3.0.3/jquery.cycle.all.js', array(), '1.0.0', true);

	// use from javascript file wil be like
	// site.ajax_url
	wp_localize_script('jquery', 'site', array(
		'ajax_url' => admin_url('admin-ajax.php'),
	));
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

function testimonial_shortcode($atts) {
	$testi = shortcode_atts(array(
		'shortcode' => '',
		'testimonialpagelink' => '',
	), $atts);
	$args = array(
		'offset' => 0,
		'category' => 0,
		'orderby' => 'post_date',
		'order' => 'DESC',
		'include' => '',
		'exclude' => '',
		'meta_key' => '',
		'meta_value' => '',
		'post_type' => 'testimonial',
		'post_status' => 'draft, publish, future, pending, private',
		'suppress_filters' => true,
	);
	$testimonials = wp_get_recent_posts($args, ARRAY_A);
	wp_reset_query();
	ob_start();
	?>
	<div class="testimonials_container">

		<div id="newsletter">

			<div class="title special_font">

				Newsletter Signup

			</div>
			<?php
echo do_shortcode("[" . $testi['shortcode'] . "]");
	?>
			<!-- <form id="newsletter_form">
				<input type="hidden" name="newsletter_subscribe" value="true">
				<input name="email" onfocus="if(this.value=='Email Address')this.value='';" onblur="if(this.value=='')this.value='Email Address';" type="text" class="input" value="Email Address">
				<input name="submit" type="submit" class="button" value="Submit">
			</form> -->
		</div>
		<script type="text/javascript">
			// jQuery(document).ready(function($) {
			// 	jQuery(document).on( 'submit', 'form#newsletter_form', function(event) {
			// 		event.preventDefault();
			// 		debugger;
			// 		var data = $(this).serialize();
			// 		jQuery.ajax({
			// 			url : site.ajax_url,
			// 			type : 'post',
			// 			data : data + "&action=send_mail",
			// 			success : function( response ) {
			// 				alert(response);
			// 			}
			// 		});
			// 	});
			// });

		</script>
		<div class="testimonial_home">
			<h3>
				<a href="<?php echo $testi['testimonialpagelink'] ?>">Testimonials</a>
			</h3>
			<script type="text/javascript">
				jQuery(function(){
					jQuery('.testimonial_home .text').cycle();
				});
			</script>

			<div class="text">
				<?php
foreach ($testimonials as $testimonial) {
		echo '<div>"';
		echo $testimonial["post_excerpt"];
		echo '"<br><br>';
		echo 'To read ' . $testimonial["post_title"] . '\'s Testimonial, click below!<br>';
		echo '<em><strong><a href="' . $testi['testimonialpagelink'] . '">' . $testimonial["post_title"] . '</a></strong></em>';
		echo '</div>';
	}
	?>
			</div>

		</div>

		<!--end testimonial-->

	</div>
	<?php
$newsletter_form = ob_get_clean();
	return $newsletter_form;
}

function testimonial_list() {
	$args = array(
		'offset' => 0,
		'category' => 0,
		'orderby' => 'post_date',
		'order' => 'DESC',
		'include' => '',
		'exclude' => '',
		'meta_key' => '',
		'meta_value' => '',
		'post_type' => 'testimonial',
		'post_status' => 'draft, publish, future, pending, private',
		'suppress_filters' => true,
	);

	$testimonials = wp_get_recent_posts($args, ARRAY_A);
	wp_reset_query();
	ob_start();
	foreach ($testimonials as $testimonial) {
		?>
		<div class="testimonial_page_container float-left">
			<div class="testimonial_wrapper float-left">
				<div class="testimonial_title float-left">
					<a href="<?php echo get_permalink($testimonial['ID']); ?>"><?php echo $testimonial["post_title"]; ?>'s Testimonial</a>
				</div>
				<div class="testimonial_desc float-left">
					<?php echo $testimonial["post_excerpt"]; ?>
				</div>
				<div class="testimonial_excerpt float-left">
					<?php echo 'To read ' . $testimonial["post_title"] . '\'s Testimonial, click below!<br>'; ?>
				</div>
				<div class="testimonial_footer float-left">
					<em><strong><?php echo $testimonial["post_title"]; ?></strong></em>|
					<span><?php echo get_the_date('F, Y', $testimonial['ID']); ?></span>|
					<a href="<?php echo get_permalink($testimonial['ID']); ?>">read full testimonial »</a>
				</div>
			</div>
		</div>
	<?php }?>
	<?php
$testimonial_list = ob_get_clean();
	return $testimonial_list;
}

/**
 * regiseting testimonial post type
 * @return testimonial post type
 */
function testimonial_post_type_init() {
	$labels = array(
		'name' => _x('Testimonials', 'post type general name', 'jrrosen-child'),
		'singular_name' => _x('Testimonials', 'post type singular name', 'jrrosen-child'),
		'menu_name' => _x('Testimonials', 'admin menu', 'jrrosen-child'),
		'name_admin_bar' => _x('Testimonials', 'add new on admin bar', 'jrrosen-child'),
		'add_new' => _x('Add New', 'book', 'jrrosen-child'),
		'add_new_item' => __('Add New Testimonials', 'jrrosen-child'),
		'new_item' => __('New Testimonials', 'jrrosen-child'),
		'edit_item' => __('Edit Testimonials', 'jrrosen-child'),
		'view_item' => __('View Testimonials', 'jrrosen-child'),
		'all_items' => __('All Testimonials', 'jrrosen-child'),
		'search_items' => __('Search Testimonials', 'jrrosen-child'),
		'parent_item_colon' => __('Parent Testimonials:', 'jrrosen-child'),
		'not_found' => __('No Testimonials found.', 'jrrosen-child'),
		'not_found_in_trash' => __('No Testimonials found in Trash.', 'jrrosen-child'),
	);

	$args = array(
		'labels' => $labels,
		'description' => __('Description.', 'jrrosen-child'),
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'testimonial'),
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title', 'author', 'excerpt', 'editor'),
	);

	register_post_type('testimonial', $args);
}

/**
 * Demo request endpoint handling from ajax call
 */
add_action("wp_ajax_send_mail", "send_mail");
add_action("wp_ajax_nopriv_send_mail", "send_mail");

function send_mail() {
	$name = $_POST['email'];
	echo $name;
	$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
	$msg = wordwrap($msg, 70);

// send email
	$mail = mail("naieemsupto@gmail.com", "My subject", $msg);
	echo $mail;
	die();
}
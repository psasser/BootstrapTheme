<?php
/**
 * Custom Child Theme Functions
 *
 * This file's parent directory can be moved to the wp-content/themes directory 
 * to allow this Child theme to be activated in the Appearance - Themes section of the WP-Admin.
 *
 * Included is a basic theme setup that will add support for custom header images and custom 
 * backgrounds. There are also a set of commented theme supports that can be uncommented if you need
 * them for backwards compatibility. If you are starting a new theme, these legacy functionality can be deleted.  
 *
 * More ideas can be found in the community documentation for Thematic
 * @link http://docs.thematictheme.com
 *
 * @package ThematicSampleChildTheme
 * @subpackage ThemeInit
 */


/* The Following add_theme_support functions 
 * will enable legacy Thematic Features
 * if uncommented.
 */
 
// add_theme_support( 'thematic_legacy_feedlinks' );
// add_theme_support( 'thematic_legacy_body_class' );
// add_theme_support( 'thematic_legacy_post_class' );
// add_theme_support( 'thematic_legacy_comment_form' );
// add_theme_support( 'thematic_legacy_comment_handling' );

/**
 * Define theme setup
 */
function childtheme_setup() {
	
	/*
	 * Add support for custom background
	 * 
	 * Allow users to specify a custom background image or color.
	 * Requires at least WordPress 3.4
	 * 
	 * @link http://codex.wordpress.org/Custom_Backgrounds Custom Backgrounds
	 */
	add_theme_support( 'custom-background' );
	
	
	/**
	 * Add support for custom headers
	 * 
	 * Customize to match your child theme layout and style.
	 * Requires at least WordPress 3.4
	 * 
	 * @link http://codex.wordpress.org/Custom_Headers Custom Headers
	 */
	add_theme_support( 'custom-header', array(
		// Header image default
		'default-image' => '',
		// Header text display default
		'header-text' => true,
		// Header text color default
		'default-text-color' => '000',
		// Header image width (in pixels)
		'width'	=> '940',
		// Header image height (in pixels)
		'height' => '235',
		// Header image random rotation default
		'random-default' => false,
		// Template header style callback
		'wp-head-callback' => 'childtheme_header_style',
		// Admin header style callback
		'admin-head-callback' => 'childtheme_admin_header_style'
		) 
	);
	
}
add_action('thematic_child_init', 'childtheme_setup');


/**
 * Custom Image Header Front-End Callback
 *
 * Defines the front-end style definitions for 
 * the custom image header.
 * This style declaration will be output in the <head> of the
 * document just before the closing </head> tag.
 * Inline Syles and !important declarations 
 * can be used to override these styles.
 *
 * @link http://codex.wordpress.org/Function_Reference/get_header_image get_header_image()
 * @link http://codex.wordpress.org/Function_Reference/get_header_textcolor get_header_textcolor()
 */
function childtheme_header_style() {
	?>	
	<style type="text/css">
	<?php
	/* Declares the header image from the settings
	 * saved in WP-Admin > Appearance > Header
	 * as the background-image for div#branding.
	 */
	if ( get_header_image() && HEADER_IMAGE != get_header_image() ) {
		?>
		#branding {
			background:url('<?php header_image(); ?>') no-repeat 0 100%;
			margin-bottom:28px;
    		padding:44px 0 <?php echo HEADER_IMAGE_HEIGHT; ?>px 0; /* Bottom padding is the same height as the image */
    		overflow: visible;
}
		}
		<?php if ( 'blank' != get_header_textcolor() ) { ?>
		#blog-title, #blog-title a {
			color:#000;
		}
		#blog-description {	
			padding-bottom: 22px;
		}
		<?php
		}
		
	}
	?>
	<?php
	/* This delcares text color for the Blog title and Description
	 * from the settings saved in WP-Admin > Appearance > Header\
	 * If not set the deafault color is set to #000 
	 */
	if ( get_header_textcolor() ) {
		?>
		#blog-title, #blog-title a, #blog-description {
			color:#<?php header_textcolor(); ?>;
		}
		<?php
	}
	/* Removes header text if the
	 * "Do not diplay header text…" setting is saved
	 * in WP-Admin > Appearance > Header
	 */
	if ( ! display_header_text() ) {
		?>
		#branding {
			background-position: center bottom;
			background-repeat: no-repeat;
			margin-top: 32px;
		}
		#blog-title, #blog-title a, #blog-description {
			display:none;
		}
		#branding { 
			height:<?php echo HEADER_IMAGE_HEIGHT; ?>px; 
			width:940px;
			padding:0; 
		}
		<?php
	}
	?>
	</style>
	<?php
}


/**
 * Custom Image Header Admin Callback
 *
 * Callback to defines the admin (back-end) style
 * definitions for the custom image header.
 * Customize the css to match your theme defaults.
 * The !important declarations override inline admin styles
 * to better represent a WYSIWYG of the front-end styling
 * that this child theme is currently designed to display.
 */
function childtheme_admin_header_style() {
	?>
	<style type="text/css">
	#headimg {
		background-position: left bottom; 
		background-repeat:no-repeat;
		border:0 !important;   
		height:auto !important;
		padding:0 0 <?php echo HEADER_IMAGE_HEIGHT + 22; /* change the added integer (22) to match your desired top padding */?>px 0;
		margin:0 0 28px 0;
	}
	
	#headimg h1 {
	    font-family:Arial,sans-serif;
	    font-size:34px;
	    font-weight:bold;
	    line-height:40px;
		margin:0;
	}
	#headimg a {
		color: #000;
		text-decoration: none;
	}
	#desc{
		font-family: Georgia;
    	font-size: 13px;
    	font-style: italic;
    }
	</style>
	<?php
}



//get rid of some of the widgets that we don't need
function remove_some_widgets(){

	unregister_sidebar( 'secondary-aside' );
	unregister_sidebar( '1st-subsidiary-aside' );
	unregister_sidebar( '2nd-subsidiary-aside' );
	unregister_sidebar( '3rd-subsidiary-aside' );
	unregister_sidebar( 'index-top' );
	unregister_sidebar( 'index-insert' );
	unregister_sidebar( 'index-bottom' );
	unregister_sidebar( 'single-top' );
	unregister_sidebar( 'single-insert' );
	unregister_sidebar( 'single-bottom' );
	unregister_sidebar( 'page-top' );
	unregister_sidebar( 'page-bottom' );
}
add_action( 'widgets_init', 'remove_some_widgets', 11 );
//end get rid of the widgets that we don't need



//get the theme ready for bootstrap
function bootstrapScripts() {
	wp_enqueue_style('bootstrapcssmin', get_bloginfo('stylesheet_directory') . '/bootstrap/css/bootstrap.min.css');
	wp_enqueue_style('bootstrapthememin', get_bloginfo('stylesheet_directory') . '/bootstrap/css/bootstrap-theme.min.css');
	
	wp_enqueue_script('bootstrapjsmain_footer', get_bloginfo('stylesheet_directory') . '/bootstrap/js/bootstrap.min.js', '', '', true);
}
add_action( 'wp_enqueue_scripts', 'bootstrapScripts' );

function metaViewport() {?>
	<meta name="viewport" content="width=device-width">
<?php }
add_action('wp_head','metaViewport');
//end get the theme ready for bootstrap



//Setting up ACF Options Page
function my_options_page_settings($options)
{
	$options['title'] = __('Theme Options');
	$options['pages'] = array(
		__('All Page Content'),
		__('Social Media')
	);
	
	return $options;
}
add_filter('acf/options_page/settings', 'my_options_page_settings');
//End Setting up ACF Options Page



//Wordpress Mainteanance
function my_embed_oembed_html($html, $url, $attr, $post_id) {
  return '<div class="video-container">' . $html . '</div>';
}
add_filter('embed_oembed_html', 'my_embed_oembed_html', 99, 4);

require_once('wp_bootstrap_navwalker.php');
//End Wordpress Maintenance



//Reuseable code pieces
function addSocialMedia($style)
{
	echo '<ul class="socialmedia">';
	if(get_field('twitter', 'option'))
	{
		if($style == 'rounded')
		{
			echo '<li><a href="'.get_field('twitter', 'option').'" class="socialtwitter symbol" title="&#xe486;" target="_blank"></a></li>';
		}
		else if($style == 'circle')
		{
			echo '<li><a href="'.get_field('twitter', 'option').'" class="socialtwitter symbol" title="&#xe286;" target="_blank"></a></li>';
		}
		else
		{
			echo '<li><a href="'.get_field('twitter', 'option').'" class="socialtwitter symbol" title="&#xe086;" target="_blank"></a></li>';	
		}
	}
	if(get_field('facebook', 'option'))
	{
		if($style == 'rounded')
		{
			echo '<li><a href="'.get_field('facebook', 'option').'" class="socialfacebook symbol" title="&#xe427;" target="_blank"></a></li>';
		}
		else if($style == 'circle')
		{
			echo '<li><a href="'.get_field('facebook', 'option').'" class="socialfacebook symbol" title="&#xe227;" target="_blank"></a></li>';
		}
		else
		{
			echo '<li><a href="'.get_field('facebook', 'option').'" class="socialfacebook symbol" title="&#xe027;" target="_blank"></a></li>';
		}
	}
	if(get_field('linkedin', 'option'))
	{
		if($style == 'rounded')
		{
			echo '<li><a href="'.get_field('linkedin', 'option').'" class="sociallinkedin symbol" title="&#xe452;" target="_blank"></a></li>';
		}
		else if($style == 'circle')
		{
			echo '<li><a href="'.get_field('linkedin', 'option').'" class="sociallinkedin symbol" title="&#xe252;" target="_blank"></a></li>';
		}
		else
		{
			echo '<li><a href="'.get_field('linkedin', 'option').'" class="sociallinkedin symbol" title="&#xe052;" target="_blank"></a></li>';
		}
	}
	if(get_field('pinterest', 'option'))
	{
		if($style == 'rounded')
		{
			echo '<li><a href="'.get_field('pinterest', 'option').'" class="socialpinterest symbol" title="&#xe464;" target="_blank"></a></li>';
		}
		else if($style == 'circle')
		{
			echo '<li><a href="'.get_field('pinterest', 'option').'" class="socialpinterest symbol" title="&#xe264;" target="_blank"></a></li>';
		}
		else
		{
			echo '<li><a href="'.get_field('pinterest', 'option').'" class="socialpinterest symbol" title="&#xe064;" target="_blank"></a></li>';
		}
	}
	if(get_field('rss_feed', 'option'))
	{
		if($style == 'rounded')
		{
			echo '<li><a href="'.get_field('rss_feed', 'option').'" class="socialrss symbol" title="&#xe471;" target="_blank"></a></li>';
		}
		else if($style == 'circle')
		{
			echo '<li><a href="'.get_field('rss_feed', 'option').'" class="socialrss symbol" title="&#xe271;" target="_blank"></a></li>';
		}
		else
		{
			echo '<li><a href="'.get_field('rss_feed', 'option').'" class="socialrss symbol" title="&#xe071;" target="_blank"></a></li>';
		}
	}
	if(get_field('youtube', 'option'))
	{
		if($style == 'rounded')
		{
			echo '<li><a href="'.get_field('youtube', 'option').'" class="socialyoutube symbol" title="&#xe499;" target="_blank"></a></li>';
		}
		else if($style == 'circle')
		{
			echo '<li><a href="'.get_field('youtube', 'option').'" class="socialyoutube symbol" title="&#xe299;" target="_blank"></a></li>';
		}
		else
		{
			echo '<li><a href="'.get_field('youtube', 'option').'" class="socialyoutube symbol" title="&#xe099;" target="_blank"></a></li>';
		}
	}
	if(get_field('google_plus', 'option'))
	{
		if($style == 'rounded')
		{
			echo '<li><a href="'.get_field('google_plus', 'option').'" class="socialgoogleplus symbol" title="&#xe439;" target="_blank"></a></li>';
		}
		else if($style == 'circle')
		{
			echo '<li><a href="'.get_field('google_plus', 'option').'" class="socialgoogleplus symbol" title="&#xe239;" target="_blank"></a></li>';
		}
		else
		{
			echo '<li><a href="'.get_field('google_plus', 'option').'" class="socialgoogleplus symbol" title="&#xe039;" target="_blank"></a></li>';
		}
	}
	if(get_field('vimeo', 'option'))
	{
		if($style == 'rounded')
		{
			echo '<li><a href="'.get_field('vimeo', 'option').'" class="socialvimeo symbol" title="&#xe489;" target="_blank"></a></li>';

		}
		else if($style == 'circle')
		{
			echo '<li><a href="'.get_field('vimeo', 'option').'" class="socialvimeo symbol" title="&#xe289;" target="_blank"></a></li>';
		}
		else
		{
			echo '<li><a href="'.get_field('vimeo', 'option').'" class="socialvimeo symbol" title="&#xe089;" target="_blank"></a></li>';
		}
	}
	if(get_field('email', 'option'))
	{
		if($style == 'rounded')
		{
			echo '<li><a href="mailto:'.get_field('email', 'option').'" class="email symbol" title="&#xe424;" target="_blank"></a></li>';
		}
		else if($style == 'circle')
		{
			echo '<li><a href="mailto:'.get_field('email', 'option').'" class="email symbol" title="&#xe224;" target="_blank"></a></li>';
		}
		else
		{
			echo '<li><a href="mailto:'.get_field('email', 'option').'" class="email symbol" title="&#xe024;" target="_blank"></a></li>';
		}
	}
	if(get_field('instagram', 'option'))
	{
		if($style == 'rounded')
		{
			echo '<li><a href="'.get_field('instagram', 'option').'" class="instagram symbol" title="&#xe500;" target="_blank"></a></li>';
		}
		else if($style == 'circle')
		{
			echo '<li><a href="'.get_field('instagram', 'option').'" class="instagram symbol" title="&#xe300;" target="_blank"></a></li>';
		}
		else
		{
			echo '<li><a href="'.get_field('instagram', 'option').'" class="instagram symbol" title="&#xe100;" target="_blank"></a></li>';
		}
	}
	echo '</ul>';
}

function isBlogView(){
	$args = array(
		'public'   => true,
		'_builtin' => false
	);

	$output = 'names';
	$operator = 'and';
	$post_types = get_post_types( $args, $output, $operator ); 

	foreach ( $post_types as $post_type ) 
	{
		if(is_singular($post_type) || is_post_type_archive($post_type))
		{
			return false;		
		}
	}
	
	$args = array(
		'public'   => true,
		'_builtin' => false
	);

	$output = 'names';
	$operator = 'and';
	$taxonomies = get_taxonomies( $args, $output, $operator ); 

	foreach ( $taxonomies as $taxonomy ) 
	{
		if(is_tax($taxonomy))
		{		
			return false;		
		}
	}
	
	
	if(is_archive() || is_home() || is_single())
	{
		return true;
	}
	else
	{
		return false;
	}
}
	
function isCPTView($cpttocheck)
{
	if(is_singular($cpttocheck) || is_post_type_archive($cpttocheck))
	{
		return true;
	}
	else
	{
		return false;
	}
}
//End resuseable code pieces





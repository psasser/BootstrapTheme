<?php
/**
 * Custom Child Theme Functions
 *
 * This file's parent directory can be moved to the wp-content/themes directory 
 * to allow this Child theme to be activated in the Appearance - Themes section of the WP-Admin.
 *
 * Included is a basic theme setup that will add the reponsive stylesheet that comes with Thematic. 
 *
 * More ideas can be found in the community documentation for Thematic
 * @link http://docs.thematictheme.com
 *
 * @package ThematicSampleChildTheme
 * @subpackage ThemeInit
 */


/*Stuff to Add to WP Config*/
/*
define('WP_HOME', 'http://' . $_SERVER['HTTP_HOST']);
define('WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST']);
*/
/*End Stuff to Add to WP Config*/

add_theme_support( 'thematic_html5' );

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
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
	acf_add_options_sub_page('All Page Content');
	acf_add_options_sub_page('Social Media');	
}
//End Setting up ACF Options Page



//Wordpress Mainteanance
function my_embed_oembed_html($html, $url, $attr, $post_id) {
	$newtext = '<div class="video-container">' . $html . '</div>'; //Make it responsive
	$newtext = str_replace( '?feature=oembed', '?feature=oembed&rel=0', $newtext ); //Remove suggested links
	return $newtext;
}
add_filter('embed_oembed_html', 'my_embed_oembed_html', 99, 4);

require_once('wp_bootstrap_navwalker.php');

function remove_sidebar()
{
	return false; 
}
//add_filter('thematic_sidebar', 'remove_sidebar');

function replace_last_nav_item($items, $args) {
	return substr_replace($items, '', strrpos($items, $args->after), strlen($args->after));
}
add_filter('wp_nav_menu','replace_last_nav_item',100,2);

function create_post_type() {
	register_post_type( 'portfolio',
		array(
			'labels' => array(
				'name' => __( 'Portfolio' ),
				'singular_name' => __( 'Portfolio' )
			),
		'public' => true,
		'has_archive' => true,
		'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes'),
		'menu_position' => 5,
		'hierarchical' => true,
		)
	);
	register_taxonomy(
		'portfolio-cat',
		'portfolio',
		array(
			'label' => __( 'Property Category' ),
			'hierarchical' => true
		)
	);
}
//add_action( 'init', 'create_post_type' );

function yearshortcode( $atts ) {
	return date('Y');
}
add_shortcode( 'year', 'yearshortcode' );

add_filter( 'auto_update_plugin', '__return_true' );
//End Wordpress Maintenance



//Reuseable code pieces
function addSocialMedia($style)
{
	echo '<ul class="socialmedia">';
	
	if( have_rows('social_media_repeater', 'option') ):

    	while ( have_rows('social_media_repeater', 'option') ) : the_row();
			if(get_sub_field('social_media_link'))
			{
				if(get_sub_field('social_media_type') == "Twitter")
				{
					if($style == 'rounded')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialtwitter symbol" title="&#xe486;" target="_blank"></a></li>';
					}
					else if($style == 'circle')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialtwitter symbol" title="&#xe286;" target="_blank"></a></li>';
					}
					else
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialtwitter symbol" title="&#xe086;" target="_blank"></a></li>';	
					}
				}
				if(get_sub_field('social_media_type') == "Facebook")
				{
					if($style == 'rounded')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialfacebook symbol" title="&#xe427;" target="_blank"></a></li>';
					}
					else if($style == 'circle')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialfacebook symbol" title="&#xe227;" target="_blank"></a></li>';
					}
					else
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialfacebook symbol" title="&#xe027;" target="_blank"></a></li>';
					}
				}
				if(get_sub_field('social_media_type') == "LinkedIn")
				{
					if($style == 'rounded')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="sociallinkedin symbol" title="&#xe452;" target="_blank"></a></li>';
					}
					else if($style == 'circle')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="sociallinkedin symbol" title="&#xe252;" target="_blank"></a></li>';
					}
					else
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="sociallinkedin symbol" title="&#xe052;" target="_blank"></a></li>';
					}
				}
				if(get_sub_field('social_media_type') == "Pinterest")
				{
					if($style == 'rounded')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialpinterest symbol" title="&#xe464;" target="_blank"></a></li>';
					}
					else if($style == 'circle')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialpinterest symbol" title="&#xe264;" target="_blank"></a></li>';
					}
					else
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialpinterest symbol" title="&#xe064;" target="_blank"></a></li>';
					}
				}
				if(get_sub_field('social_media_type') == "RSS Feed")
				{
					if($style == 'rounded')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialrss symbol" title="&#xe471;" target="_blank"></a></li>';
					}
					else if($style == 'circle')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialrss symbol" title="&#xe271;" target="_blank"></a></li>';
					}
					else
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialrss symbol" title="&#xe071;" target="_blank"></a></li>';
					}
				}
				if(get_sub_field('social_media_type') == "YouTube")
				{
					if($style == 'rounded')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialyoutube symbol" title="&#xe499;" target="_blank"></a></li>';
					}
					else if($style == 'circle')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialyoutube symbol" title="&#xe299;" target="_blank"></a></li>';
					}
					else
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialyoutube symbol" title="&#xe099;" target="_blank"></a></li>';
					}
				}
				if(get_sub_field('social_media_type') == "Google Plus")
				{
					if($style == 'rounded')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialgoogleplus symbol" title="&#xe439;" target="_blank"></a></li>';
					}
					else if($style == 'circle')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialgoogleplus symbol" title="&#xe239;" target="_blank"></a></li>';
					}
					else
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialgoogleplus symbol" title="&#xe039;" target="_blank"></a></li>';
					}
				}
				if(get_sub_field('social_media_type') == "Vimeo")
				{
					if($style == 'rounded')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialvimeo symbol" title="&#xe489;" target="_blank"></a></li>';
			
					}
					else if($style == 'circle')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialvimeo symbol" title="&#xe289;" target="_blank"></a></li>';
					}
					else
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="socialvimeo symbol" title="&#xe089;" target="_blank"></a></li>';
					}
				}
				if(get_sub_field('social_media_type') == "Email")
				{
					if($style == 'rounded')
					{
						echo '<li><a href="mailto:'.get_sub_field('social_media_link').'" class="email symbol" title="&#xe424;" target="_blank"></a></li>';
					}
					else if($style == 'circle')
					{
						echo '<li><a href="mailto:'.get_sub_field('social_media_link').'" class="email symbol" title="&#xe224;" target="_blank"></a></li>';
					}
					else
					{
						echo '<li><a href="mailto:'.get_sub_field('social_media_link').'" class="email symbol" title="&#xe024;" target="_blank"></a></li>';
					}
				}
				if(get_sub_field('social_media_type') == "Instagram")
				{
					if($style == 'rounded')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="instagram symbol" title="&#xe500;" target="_blank"></a></li>';
					}
					else if($style == 'circle')
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="instagram symbol" title="&#xe300;" target="_blank"></a></li>';
					}
					else
					{
						echo '<li><a href="'.get_sub_field('social_media_link').'" class="instagram symbol" title="&#xe100;" target="_blank"></a></li>';
					}
				}
			}
			
		endwhile;
	
	endif;
	
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


//Setting up Header
function remove_menu() {
	remove_action('thematic_header','thematic_brandingopen',1);
	remove_action('thematic_header','thematic_blogtitle',3);
	remove_action('thematic_header','thematic_blogdescription',5);
	remove_action('thematic_header','thematic_brandingclose',7);
	remove_action('thematic_header','thematic_access',9);
}
add_action('init', 'remove_menu');
//End Setting up Header


//Setting up Footer
function remove_footersiteoptions() {
	remove_action('thematic_footer','thematic_siteinfoopen',20);
	remove_action('thematic_footer','thematic_siteinfo',30);
	remove_action('thematic_footer','thematic_siteinfoclose',40);
}
add_action('init', 'remove_footersiteoptions');
//End Setting up Footer


//Setting up Template Options
function addingTemplateStuff()
{
	if( have_rows('template_creator') ):

		 // loop through the rows of data
		while ( have_rows('template_creator') ) : the_row();
	
			if( get_row_layout() == 'slideshow' ):
			
			elseif( get_row_layout() == 'call_to_action' ) :
			
			elseif( get_row_layout() == 'countdown_area' ): 
			
			elseif( get_row_layout() == 'glyphicon_teaser_area' ):
			 
			elseif( get_row_layout() == 'large_title_area_with_text_on_the_right' ): 
			
			elseif( get_row_layout() == 'number_counter_area' ): 
			
			elseif( get_row_layout() == 'collapsible_panel_section' ): 
			
			elseif( get_row_layout() == 'large_divider_image' ): 
			
			elseif( get_row_layout() == 'simple_text_section' ): 
			
			endif;
	
		endwhile;
	
	endif;	
}
//End Setting up Template Options

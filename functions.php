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

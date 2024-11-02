<?php
/*
Plugin Name: I Love Social Bookmarking
Plugin URI: http://www.webworldarticles.com/
Version: 0.3.1
Author: <a href="http://www.webworldarticles.com/">WebWorld Articles</a>
Description: I Love Social Bookmarking is a simple WordPress plugin that allows your readers to submit your content to social media services via a clutter-free drop-down list of attractive icons.
*/

/*
Copyright 2007-2008 http://www.webworldarticles.com/

I Love Social Bookmarking is free software: you can redistribute it and/or modify it
under the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this
program.  If not, see <http://www.gnu.org/licenses/>.
*/


// Some global variables
$ilsb_url = get_bloginfo('wpurl').'/wp-content/plugins/i-love-social-bookmarking/includes/';
$adminOptionsName = "ilsb_plugin_admin_options";
$ilsb_version = '0.3.2';


// Define all the default options, define all ssupported social media sites, and returns all as an array
function get_ilsb_admin_options()
{
	global $adminOptionsName;
	$ilsb_admin_options = array(
		'is_auto_show' => 'on',
		'wp_page_types' => array(
			'is_home' => array(
				'selected' => 'on',
				'anchor' => 'Homepage'),
			'is_single' => array(
				'selected' => 'on',
				'anchor' => 'Single blog post'),
			'is_page' => array(
				'selected' => 'on',
				'anchor' => 'Single page'),
			'is_category' => array(
				'selected' => 'off',
				'anchor' => 'Category archive'),
			'is_tag' => array(
				'selected' => 'off',
				'anchor' => 'Tag archive'),
			'is_date' => array(
				'selected' => 'off',
				'anchor' => 'Date archive'),
			'is_search' => array(
				'selected' => 'off',
				'anchor' => 'Search results')),
		'show_icons' => array(
			'show_subscribe' => array(
				'selected' => 'on',
				'url' => '%BLOG_RSS%',
				'title' => 'Subscribe to RSS',
				'anchor' => 'Subscribe'),
			'show_blinklist' => array(
				'selected' => 'off',
				'url' => 'http://www.blinklist.com/index.php?Action=Blink/addblink.php&amp;Url=%BLOG_URL%&amp;Title=%BLOG_TITLE%',
				'title' => 'Add to Blinklist',
				'anchor' => 'Blinklist'),
			'show_bloglines' => array(
				'selected' => 'off',
				'url' => 'http://www.bloglines.com/sub/%BLOG_URL%',
				'title' => 'Add to Bloglines',
				'anchor' => 'Bloglines'),
			'show_blogmarks' => array(
				'selected' => 'off',
				'url' => 'http://blogmarks.net/my/new.php?mini=1&amp;simple=1&amp;url=%BLOG_URL%&amp;title=%BLOG_TITLE%',
				'title' => 'Add to Blogmarks',
				'anchor' => 'Blogmarks'),
			'show_digg' => array(
				'selected' => 'on',
				'url' => 'http://digg.com/submit?phase=2&amp;url=%BLOG_URL%&amp;title=%BLOG_TITLE%',
				'title' => 'Add to Digg',
				'anchor' => 'Digg'),
			'show_delicious' => array(
				'selected' => 'on',
				'url' => 'http://del.icio.us/post?url=%BLOG_URL%&amp;title=%BLOG_TITLE%',
				'title' => 'Add to del.icio.us',
				'anchor' => 'del.icio.us'),
			'show_facebook' => array(
				'selected' => 'off',
				'url' => 'http://www.facebook.com/share.php?u=%BLOG_URL%',
				'title' => 'Share on Facebook',
				'anchor' => 'Facebook'),
			'show_furl' => array(
				'selected' => 'off',
				'url' => 'http://www.furl.net/storeIt.jsp?u=%BLOG_URL%&amp;t=%BLOG_TITLE%',
				'title' => 'Add to Furl',
				'anchor' => 'Furl'),
			'show_magnolia' => array(
				'selected' => 'off',
				'url' => 'http://ma.gnolia.com/bookmarklet/add?url=%BLOG_URL%&amp;title=%BLOG_TITLE%',
				'title' => 'Add to Magnolia',
				'anchor' => 'Ma.gnolia'),
			'show_newsvine' => array(
				'selected' => 'off',
				'url' => 'http://www.newsvine.com/_tools/seed&amp;save?u=%BLOG_URL%&amp;h=%BLOG_TITLE%',
				'title' => 'Add to NewsVine',
				'anchor' => 'NewsVine'),
			'show_reddit' => array(
				'selected' => 'off',
				'url' => 'http://reddit.com/submit?url=%BLOG_URL%&amp;title=%BLOG_TITLE%',
				'title' => 'Add to Reddit',
				'anchor' => 'Reddit'),
			'show_stumbleupon' => array(
				'selected' => 'on',
				'url' => 'http://www.stumbleupon.com/submit?url=%BLOG_URL%&amp;title=%BLOG_TITLE%',
				'title' => 'Add to StumbleUpon',
				'anchor' => 'StumbleUpon'),
			'show_technorati' => array(
				'selected' => 'off',
				'url' => 'http://technorati.com/faves?add=%BLOG_URL%',
				'title' => 'Add to Technorati',
				'anchor' => 'Technorati')),
		'the_title' => 'I Love Social Bookmarking',
		'the_list_style' => 'list',
		'the_list_width' => '',
		'the_list_bgcolor' => '#FFFFFF',
		'the_list_border_btm' => '#884098',
		'the_link_anchor' => 'on',
		'the_list_font' => 'ilsb-arial',
		'the_list_fontsize' => '',
		'the_link_target' => 'current',);

	$ilsb_options = get_option($adminOptionsName);
	if (!empty($ilsb_options))
	{
		foreach ($ilsb_options as $key => $option)
		$ilsb_admin_options[$key] = $option;
	}
	
	update_option($adminOptionsName, $ilsb_admin_options);
	return $ilsb_admin_options;
}


// Prints out the admin page
function print_ilsb_admin_options()
{
	include dirname(__FILE__).'/includes/admin.php';
}


// Initialize the admin panel
if (!function_exists('ilsb_admin_menu'))
{
	function ilsb_admin_menu()
	{
		if (function_exists('add_options_page'))
		{
			add_options_page('I Love Social Bookmarking', 'I Love Social Bookmarking', 9, basename(__FILE__), print_ilsb_admin_options);
		}
	}
}


// I Love Social Bookmarking main action
function pre_ilsb()
{
	$ilsb_options = get_ilsb_admin_options();
	$blog_rss = get_bloginfo('rss2_url');
	$blog_url = get_permalink();
	$blog_title = urlencode(get_the_title('','','false'));
	
	$ilsb = '';
	$ilsb .= '<div class="ilsb-parent '.$ilsb_options['the_list_font'].'"><a href="#" class="ilsb ilsb-share">'.$ilsb_options['the_title'].'</a><br />';
	$ilsb .= '<div class="ilsb-child">';
	foreach ($ilsb_options['show_icons'] as $site => $option)
	{
		if ($option['selected'] == 'on')
		{
			$find = array('%BLOG_RSS%', '%BLOG_URL%', '%BLOG_TITLE%');
			$replace = array($blog_rss, $blog_url, $blog_title);
			$url = str_replace($find, $replace, $option['url']);
			$class = strtolower($option['anchor']);
			$bad_char = array('.', ' ');
			$class = str_replace($bad_char, '', $class);
			$ilsb .= '<span><a rel="nofollow" href="'.$url.'" class="ilsb ilsb-'.$class.'" title="'.$option['title'].'"';
			if ($ilsb_options['the_link_target'] == 'new')
			{
				$ilsb .= ' onclick="window.open(this.href, \'_blank\', \'scrollbars=yes, menubar=no, border=0, height=600, width=800, resizable=yes, toolbar=no, location=no, status=no\'); return false;" ';
			}
			$ilsb .= '>';
			if ($ilsb_options['the_link_anchor'] == 'on') { $ilsb .= $option['anchor']; }
			$ilsb .= '</a></span>';
		}
	}
    $ilsb .= '</div></div>';
	return $ilsb;
}
function ilsb()
{	
	echo pre_ilsb();
}


// Add I Love Social Bookmarking header info
function add_ilsb_header($ilsb_options)
{
	global $ilsb_url;
	$ilsb_options = get_ilsb_admin_options();
	if (function_exists('wp_enqueue_script'))
	{
		wp_enqueue_script('i-love-social-bookmarking', $ilsb_url.'ilsb.js', array('jquery'), '0.3');
	}
	echo '<link rel="stylesheet" href="'.$ilsb_url.'style.css" type="text/css" media="screen" />';
	echo '<style type="text/css">';
	if ($ilsb_options['the_list_width'] != '') {echo 'div.ilsb-parent , div.ilsb-child {width:'.$ilsb_options['the_list_width'].'px;}';}
	if ($ilsb_options['the_list_bgcolor'] != '') {echo 'div.ilsb-parent , div.ilsb-child {background-color:'.$ilsb_options['the_list_bgcolor'].';}';}
	if ($ilsb_options['the_list_font_size'] != '') {echo 'div.ilsb-parent a {font-size:'.$ilsb_options['the_list_font_size'].'px;}';}
	if ($ilsb_options['the_list_border_btm'] != '') {echo 'div.ilsb-child {border-bottom:2px solid '.$ilsb_options['the_list_border_btm'].'}';}
	if ($ilsb_options['the_list_style'] == 'inline') {echo 'div.ilsb-child span {display:inline-block;float:left;}';}
	if ($ilsb_options['the_list_style'] == 'list') {echo 'div.ilsb-child span {display:block;}';}
    echo '</style>';
}


// Add actions and filters
add_action('activate_i-love-social-bookmarking/ilsb.php', 'get_ilsb_admin_options');
add_action('admin_menu', 'ilsb_admin_menu');
add_action('wp_head', 'add_ilsb_header', 1);
function ilsb_hook($content)
{
	$ilsb_options = get_ilsb_admin_options();
	$ilsb_options = $ilsb_options['wp_page_types'];
	if ((is_home() and ($ilsb_options['is_home']['selected']=='on')) or
		(is_single() and ($ilsb_options['is_single']['selected']=='on')) or
		(is_page() and ($ilsb_options['is_page']['selected']=='on')) or
		(is_category() and ($ilsb_options['is_category']['selected']=='on')) or
		(is_date() and ($ilsb_options['is_date']['selected']=='on')) or
		(is_search() and ($ilsb_options['is_search']['selected']=='on')))
	{
		$content .= pre_ilsb();
	}
	elseif (function_exists('is_tag'))
	{
		if (is_tag() and ($ilsb_options['is_tag']['selected']=='on'))
		{
			$content .= pre_ilsb();
		}
	}
	return $content;
}
$ilsb_options = get_ilsb_admin_options();
if ($ilsb_options['is_auto_show'] == 'on')
{
	add_filter('the_content', 'ilsb_hook');
	add_filter('the_excerpt', 'ilsb_hook');
}
?>

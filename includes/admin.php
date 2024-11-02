<?php
global $ilsb_url, $adminOptionsName, $ilsb_version;

if ($_REQUEST['restore'])
{
	get_ilsb_admin_options();
	delete_option($adminOptionsName, $ilsb_admin_options);
	echo '<div class="updated"><p><strong>Settings restored to defaults.</strong></p></div>';
}

$ilsb_options = get_ilsb_admin_options();

if ($_REQUEST['submit'])
{
	$error = false;
	if ($_REQUEST['auto_show'])
	{
		$ilsb_options['is_auto_show'] = $_REQUEST['auto_show'];
	}
	foreach ($ilsb_options['wp_page_types'] as $page => $option)
	{
		if ($_REQUEST['page_types'] && in_array($page, $_REQUEST['page_types']))
		{
			$ilsb_options['wp_page_types'][$page]['selected'] = 'on';
		}
		else
		{
			$ilsb_options['wp_page_types'][$page]['selected'] = 'off';
		}
	}
	foreach ($ilsb_options['show_icons'] as $site => $option)
	{
		if ($_REQUEST['icons'] && in_array($site, $_REQUEST['icons']))
		{
			$ilsb_options['show_icons'][$site]['selected'] = 'on';
		}
		else
		{
			$ilsb_options['show_icons'][$site]['selected'] = 'off';
		}
	}
	if (!$_REQUEST['title'])
	{
		$ilsb_options['the_title'] = '';
	}
	if ($_REQUEST['title'])
	{
		if (preg_match('/[a-zA-Z0-9]/', $_REQUEST['title']))
		{
			$ilsb_options['the_title'] = $_REQUEST['title'];
		}
		else
		{
			$error = true;
			$error_msg = $error_msg.'<li>'.$_REQUEST['title'].' contains invalid characters (use letters and numbers only)</li>';
		}
	}
	if ($_REQUEST['list_style'])
	{
		$ilsb_options['the_list_style'] = $_REQUEST['list_style'];
	}
	if (!$_REQUEST['list_width'])
	{
		$ilsb_options['the_list_width'] = '';
	}
	if ($_REQUEST['list_width'])
	{
		if (preg_match('/^\d{2,3}$/', $_REQUEST['list_width']))
		{
			$ilsb_options['the_list_width'] = $_REQUEST['list_width'];
		}
		else
		{
			$error = true;
			$error_msg = $error_msg.'<li>'.$_REQUEST['list_width'].' is not a valid width</li>';
		}
	}
	if (!$_REQUEST['list_bgcolor'])
	{
		$ilsb_options['the_list_bgcolor'] = '';
	}
	if ($_REQUEST['list_bgcolor'])
	{
		$colour = preg_replace('/#/', '', $_REQUEST['list_bgcolor']);
		$colour = strtolower($colour);
		if (preg_match('/^[a-f0-9]{6,6}$/', $colour))
		{
			$colour = strtoupper($colour);
			$colour = '#'.$colour;
			$ilsb_options['the_list_bgcolor'] = $colour;
		}
		else
		{
			$error = true;
			$colour = '#'.$colour;
			$error_msg = $error_msg.'<li>'.$colour.' is not a valid hexdecimal colour</li>';
		}
	}
	if (!$_REQUEST['list_border_btm'])
	{
		$ilsb_options['the_list_border_btm'] = '';
	}
	if ($_REQUEST['list_border_btm'])
	{
		$colour = preg_replace('/#/', '', $_REQUEST['list_border_btm']);
		$colour = strtolower($colour);
		if (preg_match('/^[a-f0-9]{6,6}$/', $colour))
		{
			$colour = strtoupper($colour);
			$colour = '#'.$colour;
			$ilsb_options['the_list_border_btm'] = $colour;
		}
		else
		{
			$error = true;
			$colour = '#'.$colour;
			$error_msg = $error_msg.'<li>'.$colour.' is not a valid hexdecimal colour</li>';
		}
	}
	if ($_REQUEST['link_anchor'])
	{
		$ilsb_options['the_link_anchor'] = $_REQUEST['link_anchor'];
	}
	if ($_REQUEST['list_font'])
	{
		$ilsb_options['the_list_font'] = $_REQUEST['list_font'];
	}
	if ($_REQUEST['style'])
	{
		$ilsb_options['the_style'] = $_REQUEST['style'];
	}
	if (!$_REQUEST['list_font_size'])
	{
		$ilsb_options['the_list_font_size'] = '';
	}
	if ($_REQUEST['list_font_size'])
	{
		if (preg_match('/^\d{1,2}$/', $_REQUEST['list_font_size']) && $_REQUEST['list_font_size'] < 31 && $_REQUEST['list_font_size'] > 7)
		{
			$ilsb_options['the_list_font_size'] = $_REQUEST['list_font_size'];
		}
		else
		{
			$error = true;
			$error_msg = $error_msg.'<li>'.$_REQUEST['list_font_size'].' is not a valid font size';
			if ($_REQUEST['list_font_size'] > 31) { $error_msg = $error_msg.' (too big - try a smaller font size)';}
			if ($_REQUEST['list_font_size'] < 7) { $error_msg = $error_msg.' (too small - try a bigger font size)';}
			$error_msg = $error_msg.'</li>';
		}
	}
	if ($_REQUEST['link_target'])
	{
		$ilsb_options['the_link_target'] = $_REQUEST['link_target'];
	}

	if ($error == false)
	{
		update_option($adminOptionsName, $ilsb_options);
		echo '<div class="updated"><p><strong>Settings Updated.</strong></p></div>';
	}
	elseif ($error == true)
	{
		 echo '<div class="error"><p><strong>Failed to update settings:</strong></p>';
		 echo '<ul>'.$error_msg.'</ul></div>';
	}
}
?>

<style type="text/css">
div.ilsb-info {width:200px; float:right; background:#EFE1F2; border:1px solid #884098; padding:6px; margin-left:10px;}
div.ilsb-info h4 {margin-top:0px;}
div.ilsb-info p {font-size:11px;}
.ilsb-icon {float:left; width:20px; height:20px; margin-right:10px;}
.ilsb-off {filter:alpha(opacity=30); opacity: 0.3; -moz-opacity:0.3;}
p {clear:left;}
label {float:left; width:130px;}
.ilsb-input {float:left; display:inline; margin-right:10px;}
.submit span {float:left; margin-top:6px;}
</style>
<link rel="stylesheet" href="<?php echo $ilsb_url; ?>style.css" type="text/css" media="screen" />
<div class="wrap">
	<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
	<h2>I Love Social Bookmarking</h2>
	<div class="ilsb-info">
		<img src="<?php echo $ilsb_url; ?>share.png" width="20" height="20" align="right" />
	    <h4>I Love Social Bookmarking</h4>
    	<p><strong>Version:</strong> <?php echo $ilsb_version; ?></p>
	    <p><strong>Author:</strong> Aaron Russell</p>
    	<p><strong>Website:</strong> <a href="http://www.milienzo.com/wordpress-plugins/i-love-social-bookmarking/">www.milienzo.com</a></p>
	    <p><strong>Contact:</strong> <a href="http://www.milienzo.com/contact/">Contact Aaron</a></p>
    	<p><em>I Love Social Bookmarking</em> is a simple WordPress plugin that allows your readers to submit your content to social media services via a clutter-free drop-down list of attractive icons.</p>
	    <p><em>ILSB</em> is released under the GNU General Public License. This means the software is free to use, redistribute and modify. Happy days!</p>
    	<p>If you like <em>ILSB</em> please write about it on your blog and send a link my way. :)</p>
	    <p>If you have any comments, questions or suggestions feel free to <a href="http://www.milienzo.com/contact/">contact me</a>.</p>
    	<p><strong>Icons by:</strong> <a href="http://www.fasticon.com">FastIcon.com</a></p>
    </div>
           
    <h3>Would you like automatic or manual display?</h3>
    <p><label>Display</label>
    <div class="ilsb-input"><input type="radio" name="auto_show" value="on" <?php if ($ilsb_options['is_auto_show'] == "on") { echo 'checked'; } ?> /></div>
    <label>Automatic</label>
    <div class="ilsb-input"><input type="radio" name="auto_show" value="off" <?php if ($ilsb_options['is_auto_show'] == "off") { echo 'checked'; } ?> /></div>
    Manual</p>
    <p>If manual use the following code within your templates:</p>
    <p align="center"><code>&lt;?php if (function_exists('ilsb')){ilsb();} ?&gt;</code></p>
    
    <h3>Select the pages on which you would like the list to display</h3>
    <p>These are active, only when the above option is selected to <em>automatic</em>.</p>
    <?php
	foreach ($ilsb_options['wp_page_types'] as $page => $option)
	{
		echo '<p><label>'.$option['anchor'].'</label>';
		echo '<div class="ilsb-input"><input type="checkbox" name="page_types[]" value="'.$page.'"';
		if ($option['selected'] == 'on') {echo ' checked';}
		echo ' /></div>&nbsp;</p>';
	}
	?>
	
    <h3>Select which icon/links you would like to display</h3>
	<?php
	foreach ($ilsb_options['show_icons'] as $site => $option)
	{
		$img = strtolower($option['anchor']);
		$bad_char = array('.', ' ');
		$img = str_replace($bad_char, '', $img);
		$img = $ilsb_url.$img.'.png';
		echo '<p><img class="ilsb-icon';
		if ($option['selected'] == "off") { echo ' ilsb-off'; }
		echo '" src="'.$img.'" /><label style="width:100px;">'.$option['anchor'].'</label>';
		echo '<div class="ilsb-input"><input type="checkbox" name="icons[]" value="'.$site.'"';
		if ($option['selected'] == "on") { echo ' checked'; }
		echo ' /></div>&nbsp;</p>';
	} ?>
    
    <h3>Style the appearance of the drop-down list</h3>
    <p><label>List title</label><div class="ilsb-input"><input type="text" name="title" maxlength="30" value="<?php echo $ilsb_options['the_title']; ?>" /></div>
    (leave empty to define no title)</p>
    <p><label>List style</label>
    <div class="ilsb-input"><input type="radio" name="list_style" value="list" <?php if ($ilsb_options['the_list_style'] == "list") { echo 'checked'; } ?> /></div>
    <label>Vertical</label>
    <div class="ilsb-input"><input type="radio" name="list_style" value="inline" <?php if ($ilsb_options['the_list_style'] == "inline") { echo 'checked'; } ?> /></div>
    Horizontal</p>
    <p><label>List width</label><div class="ilsb-input">
    <input type="text" name="list_width" onclick="this.value=''" maxlength="3" value="<?php echo $ilsb_options['the_list_width']; ?>" /></div>px (leave empty to define no width)</p>
    <p><label>BG colour</label><div class="ilsb-input">
    <input type="text" name="list_bgcolor" onclick="this.value=''" maxlength="7" value="<?php echo $ilsb_options['the_list_bgcolor']; ?>" /></div># (leave empty to define no colour)</p>
    <p><label>Border colour</label><div class="ilsb-input">
    <input type="text" name="list_border_btm" onclick="this.value=''" maxlength="7" value="<?php echo $ilsb_options['the_list_border_btm']; ?>" /></div># (leave empty to define no border)</p>
    <p><label>Link anchor</label>
    <div class="ilsb-input"><input type="radio" name="link_anchor" value="on" <?php if ($ilsb_options['the_link_anchor'] == "on") { echo 'checked'; } ?> /></div>
    <label>Display</label>
    <div class="ilsb-input"><input type="radio" name="link_anchor" value="off" <?php if ($ilsb_options['the_link_anchor'] == "off") { echo 'checked'; } ?> /></div>
    Hidden</p>
    <p><label>Font</label><div class="ilsb-input"><select name="list_font" class="<?php echo $ilsb_options['the_list_font']; ?>" onChange="this.className=this.value">
    <option value="ilsb-arial" style="font-family:Arial, Helvetica, sans-serif;" <?php if ($ilsb_options['the_list_font'] == "ilsb-arial") { echo 'selected'; } ?> >Arial</span></option>
    <option value="ilsb-century" style="font-family:'Century Gothic', 'Lucida Grande', 'Lucida Sans';" <?php if ($ilsb_options['the_list_font'] == "ilsb-century") { echo 'selected'; } ?> >Century Gothic</span></option>
    <option value="ilsb-couier" style="font-family:'Courier New', Courier, monospace;" <?php if ($ilsb_options['the_list_font'] == "ilsb-courier") { echo 'selected'; } ?> >Courier New</span></option>
    <option value="ilsb-georgia" style="font-family:Georgia, 'Times New Roman', Times, serif;" <?php if ($ilsb_options['the_list_font'] == "ilsb-georgia") { echo 'selected'; } ?> >Georgia</option>
    <option value="ilsb-lucida" style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif;" <?php if ($ilsb_options['the_list_font'] == "ilsb-lucida") { echo 'selected'; } ?> >Lucida Sans Unicode</option>
    <option value="ilsb-tahoma" style="font-family:Tahoma, Verdana, Helvetica, sans-serif;" <?php if ($ilsb_options['the_list_font'] == "ilsb-tahoma") { echo 'selected'; } ?> >Tahoma</option>
    <option value="ilsb-times" style="font-family:'Times New Roman', Times, serif;" <?php if ($ilsb_options['the_list_font'] == "ilsb-times") { echo 'selected'; } ?> >Times New Roman</option>
    <option value="ilsb-verdana" style="font-family:Verdana, Arial, Helvetica, sans-serif;" <?php if ($ilsb_options['the_list_font'] == "ilsb-verdana") { echo 'selected'; } ?> >Verdana</option>
    </select></div>&nbsp;</p>
    <p><label>Font size</label><div class="ilsb-input">
    <input type="text" name="list_font_size" onclick="this.value=''" maxlength="2" value="<?php echo $ilsb_options['the_list_font_size']; ?>" /></div>px (leave empty to let your style sheet define the size)</p>

    <h3>Select the window in which you would like the links to open</h3>
    <p><label>Link target</label>
    <div class="ilsb-input"><input type="radio" name="link_target" value="current" <?php if ($ilsb_options['the_link_target'] == "current") { echo 'checked'; } ?> /></div>
    <label>Current</label>
    <div class="ilsb-input"><input type="radio" name="link_target" value="new" <?php if ($ilsb_options['the_link_target'] == "new") { echo 'checked'; } ?> /></div>
    New</p>
    
    <hr style="clear:both; margin-top:26px;" />
    
    <div class="submit"><p><input type="submit" name="submit" id="submit" value="Update Settings" /></p>
    <p><span><em>If you encounter problems whilst upgrading from an earler version, try restoring the default settings.</em></span>
    <input type="submit" name="restore" id="restore" value="Reset Defaults" /></p>
    </div>
    </form>	
</div><?php

?>
<?php

//  Hooks/Filters
add_action('admin_init', 'zombie_init_fn' );
add_action('admin_menu', 'zombie_add_page_fn');

add_action('init', 'zombie_init');
function zombie_init() {
	wp_enqueue_script("prototype");
	wp_enqueue_script("slider",get_bloginfo('url')."/wp-includes/js/scriptaculous/slider.js",array('scriptaculous'));
	load_theme_textdomain( 'zombie', get_template_directory_uri() . '/languages' );

$zombie_defaults = array(

"zmb_side" => "Right",
"zmb_sidewidth" => "650",
"zmb_colpad" => "10",

"zmb_fontsize" => "15px",
"zmb_fontfamily" => "Verdana, Geneva, sans-serif (Default)",
"zmb_textalign" => "Default",
"zmb_parindent" => "0px",

"zmb_caption" => "Light Gray",
"zmb_title" => "Show",
"zmb_pagetitle" => "Show",
"zmb_categtitle" => "Show",
"zmb_hand" => "Show",
"zmb_top" => "Show",
"zmb_splash" => "Show",
"zmb_drips" => "Show",
"zmb_puddle" => "Show",
"zmb_info" => "Show",
"zmb_menu" => "Enable",
"zmb_tables" => "Disable",
"zmb_copyright" => "",

"zmb_postdate" => "Show",
"zmb_posttime" => "Hide",
"zmb_postauthor" => "Show",
"zmb_postcateg" => "Show",
"zmb_postbook" => "Show");
$options = get_option('za_options');
if(!$options)
update_option('za_options',$zombie_defaults);
}



// The settings
function zombie_init_fn(){
	wp_register_style( 'zombie',get_template_directory_uri() . '/zombie-admin.css' );

	register_setting('za_options', 'za_options', 'za_options_validate' );
	add_settings_section('layout_section', 'Layout Settings', 'section_layout_fn', __FILE__);
	add_settings_section('text_section', 'Text Settings', 'section_text_fn', __FILE__);
	add_settings_section('graphics_section', 'Graphics Settings', 'section_graphics_fn', __FILE__);
	add_settings_section('post_section', 'Post Information Settings', 'section_post_fn', __FILE__);

	add_settings_field('zmb_side', 'Sidemenu Position', 'setting_side_fn', __FILE__, 'layout_section');
	add_settings_field('zmb_sidewidth', 'Content / Sidemenu Width', 'setting_sidewidth_fn', __FILE__, 'layout_section');
	add_settings_field('zmb_colpad', 'Select Padding between Columns', 'setting_colpad_fn', __FILE__, 'layout_section');

	add_settings_field('zmb_fontsize', 'Select Font Size', 'setting_fontsize_fn', __FILE__, 'text_section');
	add_settings_field('zmb_fontfamily', 'Select Font Type', 'setting_fontfamily_fn', __FILE__, 'text_section');
	add_settings_field('zmb_textalign', 'Force Text Align', 'setting_textalign_fn', __FILE__, 'text_section');
	add_settings_field('zmb_parindent', 'Paragraph indent', 'setting_parindent_fn', __FILE__, 'text_section');

	add_settings_field('zmb_caption', 'Caption Border', 'setting_caption_fn', __FILE__, 'graphics_section');
	add_settings_field('zmb_title', 'Title and Description', 'setting_title_fn', __FILE__, 'graphics_section');
	add_settings_field('zmb_pagetitle', 'Page Titles', 'setting_pagetitle_fn', __FILE__, 'graphics_section');
	add_settings_field('zmb_categetitle', 'Category Page Titles', 'setting_categtitle_fn', __FILE__, 'graphics_section');
	add_settings_field('zmb_hand', 'Zombie Hand', 'setting_hand_fn', __FILE__, 'graphics_section');
	add_settings_field('zmb_top', 'Header Background', 'setting_top_fn', __FILE__, 'graphics_section');
	add_settings_field('zmb_splash', 'Blood Splash', 'setting_splash_fn', __FILE__, 'graphics_section');
	add_settings_field('zmb_drips', 'Blood Dripping', 'setting_drips_fn', __FILE__, 'graphics_section');
	add_settings_field('zmb_puddle', 'Bloody Footer', 'setting_puddle_fn', __FILE__, 'graphics_section');
	add_settings_field('zmb_info', ' The Bullets in the Footer', 'setting_info_fn', __FILE__, 'graphics_section');
	add_settings_field('zmb_menu', 'The Menu Animation', 'setting_menu_fn', __FILE__, 'graphics_section');
	add_settings_field('zmb_tables', 'Invisible Tables', 'setting_tables_fn', __FILE__, 'graphics_section');
	add_settings_field('zmb_copyright', 'Insert footer copyright', 'setting_copyright_fn', __FILE__, 'graphics_section');

	add_settings_field('zmb_postdate', 'Post Date', 'setting_postdate_fn', __FILE__, 'post_section');
	add_settings_field('zmb_posttime', 'Post Time', 'setting_posttime_fn', __FILE__, 'post_section');
	add_settings_field('zmb_postauthor', 'Post Author', 'setting_postauthor_fn', __FILE__, 'post_section');
	add_settings_field('zmb_postcateg', 'Post Category', 'setting_postcateg_fn', __FILE__, 'post_section');
	add_settings_field('zmb_postbook', 'Post Permalink', 'setting_postbook_fn', __FILE__, 'post_section');


}

// Adding the zombie subpage
function zombie_add_page_fn() {
$page = add_theme_page('Zombie Apocalypse Settings', 'Zombie Apocalypse Settings', 'edit_theme_options', 'zombie-page', 'zombie_page_fn');
	add_action( 'admin_print_styles-'.$page, 'zombie_admin_styles' );

}
function zombie_admin_styles() {

	wp_enqueue_style( 'zombie' );
}



// ************************************************************************************************************

// Callback functions

// General suboptions description

function  section_layout_fn() {
	echo "<p>Settings for adjusting your blog's layout .</p>";
}
function  section_text_fn() {
	echo '<p>All text realted customization options.</p>';
}

function  section_graphics_fn() {
	echo '<p>Settings for hiding or showinng different graphics.</p>';
}

function  section_post_fn() {
	echo '<p>Settings for hiding or showinng different post tags.</p>';
}

 //SELECT - Name: za_options[side]
function  setting_side_fn() {
$options = get_option('za_options');
	if (!isset($options['zmb_side'])) { $options['zmb_side'] ="Right";	}

$items = array("Left", "Right", "Disable");
echo "<select id='zmb_side' name='za_options[zmb_side]'>";
foreach($items as $item) {
	$selected = ($options['zmb_side']==$item) ? 'selected="selected"' : '';
	echo "<option value='$item' $selected>$item</option>";
}
echo "</select>";

echo "<div><small>Select the side on which to display the sidebar or disable it altogether and have only one column for a presentation-like design.
			Disabling the sidemenu also disables the Content/Sidemenu Width option.</small></div>";

}



 //SLIDER - Name: za_options[sidewidth]
function setting_sidewidth_fn()
   {
   $options = get_option('za_options');
	if (!isset($options['zmb_sidewidth'])) { $options['zmb_sidewidth'] =650;}

   ?>
   <div id="zoom_slider" class="slider">
   <div class="handle"></div>
   <div style="display:block;float:none;width:450px;">
   <p id="cont_value" style="width:<?php  echo ($options['zmb_sidewidth']/2 - 2);  ?>px;" class="numbers"><?php  echo $options['zmb_sidewidth'];  ?>px</p>
   <p id="side_value" style="width:<?php echo ((896 - $options['zmb_sidewidth'])/2); ?>px;" class="numbers"><?php echo (900-$options['zmb_sidewidth']);  ?>px</p>
   </div>
   </div>
   <?php echo  "<input   name='za_options[zmb_sidewidth]' id='zmb_sidewidth' type='hidden' value='".$options['zmb_sidewidth']."' />";?>

   <!-- JS libraries for the slider-->
	<script> if (document.getElementById('zmb_side').value=='Disable') document.getElementById('slider_div').className="hideSlider"; </script>
<!-- slider script-->
<script type="text/javascript">
  (function() {
    var zoom_slider = $('zoom_slider'),
        cont = $('cont_value');
		side = $('side_value');
		sw = $('zmb_sidewidth');

    new Control.Slider(zoom_slider.down('.handle'), zoom_slider, {
    range: $R(0, 900),
    sliderValue: cont.innerHTML,
   	values :[500,510,520,530,540,550,560,570,580,590,600,610,620,630,640,650,660,670,680,690,700,710,720,730,740,750],

    onSlide: function(value) {
		cont.innerHTML = value + " px";cont.style.width = (value/2 -2)+"px";
		side.innerHTML= (900 - value) + " px" ;side.style.width = (896-value)/2+"px";
		sw.value = value;cont.style.width = (value/2 -2);
      },
      onChange: function(value) {
		cont.innerHTML = value + " px";cont.style.width = (value/2 -2)+"px";
		side.innerHTML= (900 - value) + " px" ;side.style.width = (896-value)/2+"px";
		sw.value = value;cont.style.width = (value/2 -2);
      }
    });
  })();

</script>


   <?php
   echo "<div><small>Select the width of your content and sidemenu (Values range from 500px to 750px for the content, and from 150px to 400px for the sidemenu).</small></div>";

   }

 //SELECT - Name: za_options[colpad]
function  setting_colpad_fn() {
	$options = get_option('za_options');
	if (!isset($options['zmb_colpad'])) { $options['zmb_colpad'] ="10px";	}

	$items =array ("0", "10px" , "15px" , "20px" , "25px", "30px");
	echo "<select id='zmb_colpad' name='za_options[zmb_colpad]'>";
foreach($items as $item) {
	$selected = ($options['zmb_colpad']==$item) ? 'selected="selected"' : '';
	echo "<option value='$item' $selected>$item</option>";
}
	echo "</select>";

echo "<div><small>Select the padding between the content and the sidebar.</small></div>";

}

//SELECT - Name: za_options[fontsize]
function  setting_fontsize_fn() {
	$options = get_option('za_options');
	if (!isset($options['zmb_fontsize'])) { $options['zmb_fontsize'] ="15px";	}
	$items =array ("12px", "13px" , "14px" , "15px" , "16px", "17px", "18px");
	echo "<select id='zmb_fontsize' name='za_options[zmb_fontsize]'>";
foreach($items as $item) {
	$selected = ($options['zmb_fontsize']==$item) ? 'selected="selected"' : '';
	echo "<option value='$item' $selected>$item</option>";
}
	echo "</select>";

	echo "<div><small>Select the font size you'll use in your blog. Pages, posts and comments will be affected. Buttons, Headers and Side menus will remain the same.</small></div>";

}


//SELECT - Name: za_options[fontfamily]
function  setting_fontfamily_fn() {
	$options = get_option('za_options');
	if (!isset($options['zmb_fontfamily'])) { $options['zmb_fontfamily'] ="Verdana, Geneva, sans-serif (Default)";	}
	$items = array("Verdana, Geneva, sans-serif (Default)" ,"\"Segoe UI\", Arial, sans-serif","Calibri, Arian, sans-serif","\"Myriad Pro\",Myriad,Arial, sans-serif", "Georgia, \"Times New Roman\", Times, serif" , "Tahoma, Geneva, sans-serif" , "\"Trebuchet MS\", Arial, Helvetica, sans-serif" , "\"Courier New\", Courier, monospace" , "\"Comic Sans MS\", cursive");
	echo "<select id='zmb_fontfamily' name='za_options[zmb_fontfamily]'>";
foreach($items as $item) {
	$selected = ( $options['zmb_fontfamily']==$item) ? 'selected="selected"' : '';
	echo "<option style='font-family:$item;' value='$item' $selected>$item</option>";
}
	echo "</select>";

	echo "<div><small>Select the font family you'll use in your blog. All text will be affected (including header text, menu buttons, side menu text etc.).</small></div>";

}

//SELECT - Name: za_options[textalign]
function  setting_textalign_fn() {
	$options = get_option('za_options');
	if (!isset($options['zmb_textalign'])) { $options['zmb_textalign'] ="Default";	}
	$items = array ("Default" , "Left" , "Right" , "Justify" , "Center");
	echo "<select id='zmb_textalign' name='za_options[zmb_textalign]'>";
foreach($items as $item) {
	$selected = ($options['zmb_textalign']==$item) ? 'selected="selected"' : '';
	echo "<option value='$item' $selected>$item</option>";
}
	echo "</select>";

	echo "<div><small>This overwrites the text alignment in posts and pages. Leave 'Default' for normal settings (alignment will remain as declared in posts, comments etc.).</small></div>";

}

//SELECT - Name: za_options[parindent]
function  setting_parindent_fn() {
	$options = get_option('za_options');
	if (!isset($options['zmb_parindent'])) { $options['zmb_parindent'] ="10px";	}
	$items = array ("0px" , "5px" , "10px" , "15px" , "20px");
	echo "<select id='zmb_parindent' name='za_options[zmb_parindent]'>";
foreach($items as $item) {
	$selected = ($options['zmb_parindent']==$item) ? 'selected="selected"' : '';
	echo "<option value='$item' $selected>$item</option>";
}
	echo "</select>";

	echo "<div><small>Choose the indent for your paragraphs.</small></div>";

}

//SELECT - Name: za_options[caption]
function  setting_caption_fn() {
	$options = get_option('za_options');
	if (!isset($options['zmb_caption'])) { $options['zmb_caption'] ="Light Gray";	}
	$items = array ("Light Gray" , "Gray" , "Bloody" , "Light Bloody" , "Paper" , "Black");
	echo "<select id='zmb_caption' name='za_options[zmb_caption]'>";
foreach($items as $item) {
	$selected = ($options['zmb_caption']==$item) ? 'selected="selected"' : '';
	echo "<option value='$item' $selected>$item</option>";
}
	echo "</select>";

	echo "<div><small>This setting changes the look of your captions. All images that are not inserted through captions will not be affected.</small></div>";

}

//CHECKBOX - Name: za_options[title]
function setting_title_fn() {
	$options = get_option('za_options');
	if (!isset($options['zmb_title'])) { $options['zmb_title'] ="Show";	}
	$items = array ("Show" , "Hide");
	echo "<select id='zmb_title' name='za_options[zmb_title]'>";
foreach($items as $item) {
	$selected = ($options['zmb_title']==$item) ? 'selected="selected"' : '';
	echo "<option value='$item' $selected>$item</option>";
}
	echo "</select>";
	echo "<div><small>Hide or show your blog's Title and Description in the header (recommended if you have a custom header image with text).</small></div>";
}
//CHECKBOX - Name: za_options[pagetitle]
function setting_pagetitle_fn() {
	$options = get_option('za_options');
	if (!isset($options['zmb_pagetitle'])) { $options['zmb_pagetitle'] ="Show";	}
	$items = array ("Show" , "Hide");
	echo "<select id='zmb_pagetitle' name='za_options[zmb_pagetitle]'>";
foreach($items as $item) {
	$selected = ($options['zmb_pagetitle']==$item) ? 'selected="selected"' : '';
	echo "<option value='$item' $selected>$item</option>";
}
	echo "</select>";
	echo "<div><small>Hide or show Page titles on any <i>created</i> pages. </small></div>";
}

//CHECKBOX - Name: za_options[pagetitle]
function setting_categtitle_fn() {
	$options = get_option('za_options');
	if (!isset($options['zmb_categtitle'])) { $options['zmb_categtitle'] ="Show";	}
	$items = array ("Show" , "Hide");
	echo "<select id='zmb_categtitle' name='za_options[zmb_categtitle]'>";
foreach($items as $item) {
	$selected = ($options['zmb_categtitle']==$item) ? 'selected="selected"' : '';
	echo "<option value='$item' $selected>$item</option>";
}
	echo "</select>";
	echo "<div><small>Hide or show Page titles on <i>Category</i> Pages. </small></div>";
}

//CHECKBOX - Name: za_options[hand]
function setting_hand_fn() {
	$options = get_option('za_options');
	if (!isset($options['zmb_hand'])) { $options['zmb_hand'] ="Show";	}
	$items = array ("Show" , "Hide");
	echo "<select id='zmb_hand' name='za_options[zmb_hand]'>";
foreach($items as $item) {
	$selected = ($options['zmb_hand']==$item) ? 'selected="selected"' : '';
	echo "<option value='$item' $selected>$item</option>";
}
	echo "</select>";
	echo "<div><small>Hide or show the zombie hand image in the right corner of the header. You'll most likely want to do this when you upload your own header image that will cover most of the hand.</small></div>";
}

//CHECKBOX - Name: za_options[top]
function setting_top_fn() {
	$options = get_option('za_options');
	if (!isset($options['zmb_top'])) { $options['zmb_top'] ="Show";	}
	$items = array ("Show" , "Hide");
	echo "<select id='zmb_top' name='za_options[zmb_top]'>";
foreach($items as $item) {
	$selected = ($options['zmb_top']==$item) ? 'selected="selected"' : '';
	echo "<option value='$item' $selected>$item</option>";
}
	echo "</select>";
	echo "<div><small>Hide or show the grunge background in the header.</small></div>";
}

//CHECKBOX - Name: za_options[splash]
function setting_splash_fn() {
	$options = get_option('za_options');
	if (!isset($options['zmb_splash'])) { $options['zmb_splash'] ="Show";	}
	$items = array ("Show" , "Hide");
	echo "<select id='zmb_splash' name='za_options[zmb_splash]'>";
foreach($items as $item) {
	$selected = ($options['zmb_splash']==$item) ? 'selected="selected"' : '';
	echo "<option value='$item' $selected>$item</option>";
}
	echo "</select>";
	echo "<div><small>Hide or show the blood splash and claw marks in the background.</small></div>";

}

//CHECKBOX - Name: za_options[drips]
function setting_drips_fn() {
	$options = get_option('za_options');
	if (!isset($options['zmb_drips'])) { $options['zmb_drips'] ="Show";	}
	$items = array ("Show" , "Hide");
	echo "<select id='zmb_drips' name='za_options[zmb_drips]'>";
foreach($items as $item) {
	$selected = ($options['zmb_drips']==$item) ? 'selected="selected"' : '';
	echo "<option value='$item' $selected>$item</option>";
}
	echo "</select>";
	echo "<div><small>Hide or show the blood drippings in the sidebar's top corner.</small></div>";
}

//CHECKBOX - Name: za_options[puddle]
function setting_puddle_fn() {
	$options = get_option('za_options');
	if (!isset($options['zmb_puddle'])) { $options['zmb_puddle'] ="Show";	}
	$items = array ("Show" , "Hide");
	echo "<select id='zmb_puddle' name='za_options[zmb_puddle]'>";
foreach($items as $item) {
	$selected = ($options['zmb_puddle']==$item) ? 'selected="selected"' : '';
	echo "<option value='$item' $selected>$item</option>";
}
	echo "</select>";
	echo "<div><small>Hide or show the bloody hand and the blood puddle in the footer area.</small></div>";
}

//CHECKBOX - Name: za_options[info]
function setting_info_fn() {
	$options = get_option('za_options');
	if (!isset($options['zmb_info'])) { $options['zmb_info'] ="Show";	}
	$items = array ("Show" , "Hide");
	echo "<select id='zmb_info' name='za_options[zmb_info]'>";
foreach($items as $item) {
	$selected = ($options['zmb_info']==$item) ? 'selected="selected"' : '';
	echo "<option value='$item' $selected>$item</option>";
}
	echo "</select>";
	echo "<div><small>Hide or show the image with bulelts in the footer.</small></div>";
}

//CHECKBOX - Name: za_options[menu]
function setting_menu_fn() {
	$options = get_option('za_options');
	if (!isset($options['zmb_menu'])) { $options['zmb_menu'] ="Enable";	}
	$items = array ("Enable" , "Disable");
	echo "<select id='zmb_menu' name='za_options[zmb_menu]'>";
foreach($items as $item) {
	$selected = ($options['zmb_menu']==$item) ? 'selected="selected"' : '';
	echo "<option value='$item' $selected>$item</option>";
}
	echo "</select>";
	echo "<div><small>Disable or enable the drop down menu's animation effect.</small></div>";
}

//CHECKBOX - Name: za_options[tables]
function setting_tables_fn() {
	$options = get_option('za_options');
	if (!isset($options['zmb_tables'])) { $options['zmb_tables'] ="Enable";	}
	$items = array ("Enable" , "Disable");
	echo "<select id='zmb_tables' name='za_options[zmb_tables]'>";
foreach($items as $item) {
	$selected = ($options['zmb_tables']==$item) ? 'selected="selected"' : '';
	echo "<option value='$item' $selected>$item</option>";
}
	echo "</select>";
	echo "<div><small>Hide table borders and background color.</small></div>";
}

// TEXTBOX - Name: za_options[copyright]
function setting_copyright_fn() {
	$options = get_option('za_options');
	if (!isset($options['zmb_copyright'])) { $options['zmb_copyright'] ="";	}
	echo "<input id='zmb_copyright' name='za_options[zmb_copyright]' size='40' type='text' value='{$options['zmb_copyright']}' />";
	echo "<div><small>Insert custom text that will appear on the left side of the footer. Leave blank if that's not necessary.<br /> You can use HTML tags and any special characters like &copy .</small></div>";
}

//CHECKBOX - Name: za_options[postdate]
function setting_postdate_fn() {
	$options = get_option('za_options');
	if (!isset($options['zmb_postdate'])) { $options['zmb_postdate'] ="Show";	}
	$items = array ("Show" , "Hide");
	echo "<select id='zmb_postdate' name='za_options[zmb_postdate]'>";
foreach($items as $item) {
	$selected = ($options['zmb_postdate']==$item) ? 'selected="selected"' : '';
	echo "<option value='$item' $selected>$item</option>";
}
	echo "</select>";
	echo "<div><small>Hide or show the post date.</small></div>";
}

//CHECKBOX - Name: za_options[posttime]
function setting_posttime_fn() {
	$options = get_option('za_options');
	if (!isset($options['zmb_posttime'])) { $options['zmb_posttime'] ="Hide";	}
	$items = array ("Show" , "Hide");
	echo "<select id='zmb_posttime' name='za_options[zmb_posttime]'>";
foreach($items as $item) {
	$selected = ($options['zmb_posttime']==$item) ? 'selected="selected"' : '';
	echo "<option value='$item' $selected>$item</option>";
}
	echo "</select>";
	echo "<div><small>Show the post time with the date. Time will not be visible if the Post Date is hidden.</small></div>";
}

//CHECKBOX - Name: za_options[postauthor]
function setting_postauthor_fn() {
	$options = get_option('za_options');
	if (!isset($options['zmb_postauthor'])) { $options['zmb_postauthor'] ="Show";	}
	$items = array ("Show" , "Hide");
	echo "<select id='zmb_postauthor' name='za_options[zmb_postauthor]'>";
foreach($items as $item) {
	$selected = ($options['zmb_postauthor']==$item) ? 'selected="selected"' : '';
	echo "<option value='$item' $selected>$item</option>";
}
	echo "</select>";
	echo "<div><small>Hide or show the post author.</small></div>";
}

//CHECKBOX - Name: za_options[postcateg]
function setting_postcateg_fn() {
	$options = get_option('za_options');
	if (!isset($options['zmb_postcateg'])) { $options['zmb_postcateg'] ="Show";	}
	$items = array ("Show" , "Hide");
	echo "<select id='zmb_postcateg' name='za_options[zmb_postcateg]'>";
foreach($items as $item) {
	$selected = ($options['zmb_postcateg']==$item) ? 'selected="selected"' : '';
	echo "<option value='$item' $selected>$item</option>";
}
	echo "</select>";
	echo "<div><small>Hide the post category (and tags if available).</small></div>";
}

//CHECKBOX - Name: za_options[postbook]
function setting_postbook_fn() {
	$options = get_option('za_options');
	if (!isset($options['zmb_postbook'])) { $options['zmb_postbook'] ="Show";	}
	$items = array ("Show" , "Hide");
	echo "<select id='zmb_postbook' name='za_options[zmb_postbook]'>";
foreach($items as $item) {
	$selected = ($options['zmb_postbook']==$item) ? 'selected="selected"' : '';
	echo "<option value='$item' $selected>$item</option>";
}
	echo "</select>";
	echo "<div><small>Hide the 'Bookmark permalink'.</small></div>";
}



// FOR FURTHER
// DROP-DOWN-BOX - Name: za_options[dropdown1]
function  setting_dropdown_fn() {
	$options = get_option('za_options');
	$items = array("Red", "Green", "Blue", "Orange", "White", "Violet", "Yellow");
	echo "<select id='drop_down1' name='za_options[dropdown1]'>";
	foreach($items as $item) {
		$selected = ($options['dropdown1']==$item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";
}

// TEXTAREA - Name: za_options[text_area]
function setting_textarea_fn() {
	$options = get_option('za_options');
	echo "<textarea id='za_textarea_string' name='za_options[text_area]' rows='7' cols='50' type='textarea'>{$options['text_area']}</textarea>";
}

// TEXTBOX - Name: za_options[text_string]
function setting_string_fn() {
	$options = get_option('za_options');
	echo "<input id='za_text_string' name='za_options[text_string]' size='40' type='text' value='{$options['text_string']}' />";
}

// PASSWORD-TEXTBOX - Name: za_options[pass_string]
function setting_pass_fn() {
	$options = get_option('za_options');
	echo "<input id='za_text_pass' name='za_options[pass_string]' size='40' type='password' value='{$options['pass_string']}' />";
}

// CHECKBOX - Name: za_options[chkbox1]
function setting_chk1_fn() {
	$options = get_option('za_options'); $checked ="";
	if(isset($options['chkbox1'])&& $options['chkbox1']) { $checked = ' checked="checked" '; }
	echo "<input ".$checked." id='za_chk1' name='za_options[chkbox1]' type='checkbox' />";
}

// CHECKBOX - Name: za_options[chkbox2]
function setting_chk2_fn() {
	$options = get_option('za_options');$checked ="";
	if(isset($options['chkbox2'])&&$options['chkbox2']) { $checked = ' checked="checked" '; }
	echo "<input ".$checked." id='za_chk2' name='za_options[chkbox2]' type='checkbox' />";
}

// RADIO-BUTTON - Name: za_options[option_set1]
function setting_radio_fn() {
	$options = get_option('za_options');
	$items = array("Square", "Triangle", "Circle");
	foreach($items as $item) {
		$checked = ($options['option_set1']==$item) ? ' checked="checked" ' : '';
		echo "<label><input ".$checked." value='$item' name='za_options[option_set1]' type='radio' /> $item</label><br />";
	}
}


// Display the admin options page
function zombie_page_fn() {

 if (!current_user_can('edit_theme_options'))  {
    wp_die( __('Sorry, but you do not have sufficient permissions to access this page.') );
  }?>

	<div class="wrap">
		<div class="icon32" id="icon-options-general"><br></div>
		<h2>Zombie Apocalypse Options</h2>
	<p style="display:inline;float:left;">	Customize your Zombie Apocalypse Theme to suit your needs. Visit the theme's <a href="http://www.flashrats.com">home page</a> for more info and comments or</p>
	<div style="display:inline;float:left;margin-top:7px;">
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
	<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
	<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
	</form>
	</div>
		<form action="options.php" method="post">
		<?php settings_fields('za_options'); ?>
		<?php do_settings_sections(__FILE__); ?>
		<p class="submit">
			<input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
		</p>
		</form>

	</div>
<?php
}


// Validate user data
function za_options_validate($input) {
	// Sanitize the texbox input
	$input['zmb_copyright'] =  wp_kses_data($input['zmb_copyright']);
	return $input; // return validated input

}
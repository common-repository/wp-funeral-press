<?php
class wpfh_settings{
	
	
	
	function submenu($settings_submenu_items){
	global $wpfh_install;
	
		$settings_submenu_items .= '
					<li><a href="admin.php?page=wpfh-settings-email" >'.__("Email Text","sp-wpfh").'</a> 	</li>
					<li><a href="admin.php?page=wpfh-custom-css">'.__("Custom CSS","sp-wpfh").'</a> 	</li>
					
					
				 ';
		
		return $settings_submenu_items;	
	}
		
	function menu(){
		
		global $wpfh_install;

		return $wpfh_install->topMenu(__("Settings","sp-wpfh"),$submenu);
	}
	
	function css(){
		global $wpdb;
		
			echo $this->menu();
		
		if(file_exists(''.get_template_directory().'/obits.css')){
		echo  '<p style="color:red;padding:10px;background-color:EFEFEF;border:1px dotted red;margin:10px">
		'.__("You are currently using custom css! If you wish to reset back to default css please delete the obits.css in your template directory","sp-wpfh").'
		</p>';	
		}
		
		 echo '<p style="color:red;padding:10px;background-color:EFEFEF;border:1px dotted red;margin:10px">'.__("If you would like to create custom css, copy the css code below. Open your template folder and create a file called obits.css. Paste the css in the file and upload. The plugin will detect the custom css file exists and will use that file instead.","sp-wpfh").'</p>';
		
		echo '
	
		
		
		<strong>'.__("Create this custom css file","sp-wpfh").': '.get_template_directory_uri().'/obits.css</strong><br><textarea style="width:100%;height:600px">';
	include ''.ABSPATH.'wp-content/plugins/wp-funeral-press/css/style.css';
		echo '</textarea>';
	}
	
		function email(){
				global $wpdb;
				echo $this->menu();
			
				if($_POST['save-emails'] != ""){
	update_option('wpfh_email_admin', $_POST['wpfh_email_admin']);	
	
	update_option('wpfh_email_user', $_POST['wpfh_email_user']);
	update_option('wpfh_email_user_approved', $_POST['wpfh_email_user_approved']);
	
	update_option('wpfh_email_admin_cc', $_POST['wpfh_email_admin_cc']);
	update_option('wpfh_email_user_approve_cc', $_POST['wpfh_email_user_approve_cc']);
	update_option('wpfh_email_user_cc', $_POST['wpfh_email_user_cc']);
	
	
	update_option('wpfh_email_admin_subject', $_POST['wpfh_email_admin_subject']);
	update_option('wpfh_email_user_subject', $_POST['wpfh_email_user_subject']);
	update_option('wpfh_email_user_approved_subject', $_POST['wpfh_email_user_approved_subject']);
	//end checkboxes
	
	echo '<div class="wpfh_message">'.__("Saved Your Settings","sp-wpfh").'!</div>';
	}
	
	
	
	echo ' <form method="post" action="admin.php?page=wpfh-settings-email" enctype="multipart/form-data">
	
	  <script>
  jQuery(function() {
    jQuery( "#wpfh_emails_accordion" ).accordion({
      collapsible: true,
	  heightStyle: "content",
	  active : "none"
    }).show();;
  });
  </script>
	<div id="wpfh_emails_accordion"  style="display: none;">
	
	
	<h3>'.__("Admin posting email","sp-wpfh").'</h3>
	<div>
	<table class="wp-list-table widefat fixed posts" cellspacing="0">

<tr>
<td width="300"><strong>'.__("Subject","sp-wpfh").'</strong></td><td> <input type="text" name="wpfh_email_admin_subject"" value="'.stripslashes(get_option('wpfh_email_admin_subject')).'" style="width:400px"></td>
</tr>
 <tr>
	 <td><strong>Send a CC(comma seperated)</strong></td>
	 <td><input type="text" name="wpfh_email_admin_cc"" value="'.stripslashes(get_option('wpfh_email_admin_cc')).'" style="width:400px"></td>
	 </tr>
    <tr>
    <td width="300"><strong>'.__("Admin posting email","sp-wpfh").'</strong><br><em>'.__("This is the admin email when a new posting has been entered.","sp-wpfh").'</em><br />
<br />
[obit] = '.__("Obit Name","sp-wpfh").'<br>
[link] = '.__("Obit Page","sp-wpfh").'<br>
[user] = '.__("Users Name","sp-wpfh").'<br>
[approve_link] = '.__("Approval Page","sp-wpfh").'</td>
    <td>';
	 the_editor(stripslashes(get_option('wpfh_email_admin')), "wpfh_email_admin", "", true);
	 echo '</td>
  </tr>
  
  </table>
  </div>
  
  <h3>'.__("User posting email","sp-wpfh").'</h3>
  <div>
  <table class="wp-list-table widefat fixed posts" cellspacing="0">
<tr>
<td width="300"><strong>'.__("Subject","sp-wpfh").'</strong></td>
<td><input type="text" name="wpfh_email_user_subject"" value="'.stripslashes(get_option('wpfh_email_user_subject')).'"  style="width:400px"></td>
</tr>
 <tr>
	 <td><strong>Send a CC(comma seperated)</strong></td>
	 <td><input type="text" name="wpfh_email_user_cc"" value="'.stripslashes(get_option('wpfh_email_user_cc')).'" style="width:400px"></td>
 </tr>
  
  <tr>
    <td width="300"><strong>'.__("User posting email","sp-wpfh").'</strong><br><em>'.__("This is the email which is sent to the user after they enter a posting","sp-wpfh").'.</em><br />
<br />
[obit] = '.__("Obit Name","sp-wpfh").'<br>
[link] = '.__("Obit Page","sp-wpfh").'<br>
[user] = '.__("Users Name","sp-wpfh").'<br>
<br>

</td>
    <td>';
	 the_editor(stripslashes(get_option('wpfh_email_user')), "wpfh_email_user", "", true);
	 echo '
	</td>
  </tr>
  
  </table>
  </div>
  
  <h3>'.__("User approved email","sp-wpfh").'</h3>
  <div>
  <table class="wp-list-table widefat fixed posts" cellspacing="0">
  <tr>
<td width="300"><strong>'.__("Subject","sp-wpfh").'</strong></td>
<td><input type="text" name="wpfh_email_user_approved_subject"" value="'.stripslashes(get_option('wpfh_email_user_approved_subject')).'"  style="width:400px"></td>
</tr>
 <tr>
	 <td><strong>Send a CC(comma seperated)</strong></td>
	 <td><input type="text" name="wpfh_email_user_approve_cc"" value="'.stripslashes(get_option('wpfh_email_user_approve_cc')).'" style="width:400px"></td>
 </tr>
  
  
 <tr>
    <td width="300"><strong>'.__("User approved email","sp-wpfh").'</strong><br><em>'.__("This is the email that is sent to the user after their posting has been approved","sp-wpfh").'.</em><br />
<br />
[obit] = '.__("Obit Name","sp-wpfh").'<br>
[link] = '.__("Obit Page","sp-wpfh").'<br>
[user] = '.__("Users Name","sp-wpfh").'<br>
<br></td>
    <td>';
	 the_editor(stripslashes(get_option('wpfh_email_user_approved')), "wpfh_email_user_approved", "", true);
	 echo '</td>
  </tr>
   </table>
  </div>
  
 
  ';
  
 do_action('wpfh_admin_email_editor');
   
  echo '</div>
  <input type="submit" value="Save" name="save-emails"/>
  </form>';	
	
				
			
		}
	
function view(){
	
	global $wpdb;
	echo $this->menu();
	
	
	if($_POST['save-settings'] != ""){
	do_action('wpfh_save_settings');
	update_option('wpfh_display_page', $_POST['wpfh_display_page']);
	update_option('wpfh_order_flowers', $_POST['wpfh_order_flowers']);
	update_option('wpfh_obit_name', $_POST['wpfh_obit_name']);
	update_option('wpfh_obit_name_plural', $_POST['wpfh_obit_name_plural']);
	update_option('wpfh_obit_display_num', $_POST['wpfh_obit_display_num']);
	update_option('wpfh_obit_style', $_POST['wpfh_obit_style']);
	update_option('wpfh_obit_style', $_POST['wpfh_obit_style']);
	update_option('wpfh_recaptcha_public_key', $_POST['wpfh_recaptcha_public_key']);
	update_option('wpfh_recaptcha_private_key', $_POST['wpfh_recaptcha_private_key']);
	update_option('wpfh_gb_no_posts', $_POST['wpfh_gb_no_posts']);
	update_option('wpfh_email_admin_override', $_POST['wpfh_email_admin_override']);
	update_option('wpfh_order_obits', $_POST['wpfh_order_obits']);
	update_option('wpfh_search_date_by', $_POST['wpfh_search_date_by']);
	
	
	
	
	update_option('wpfh_obit_w', $_POST['wpfh_obit_w']); update_option('wpfh_obit_h', $_POST['wpfh_obit_h']);
	update_option('wpfh_obits_w', $_POST['wpfh_obits_w']); update_option('wpfh_obits_h', $_POST['wpfh_obits_h']);
	update_option('wpfh_obitsh_w', $_POST['wpfh_obitsh_w']); update_option('wpfh_obitsh_h', $_POST['wpfh_obitsh_h']);
	update_option('wpfh_obitw_w', $_POST['wpfh_obitw_w']); update_option('wpfh_obitw_h', $_POST['wpfh_obitw_h']);
	
	update_option('wpfh_church_name', $_POST['wpfh_church_name']);
	
	update_option('wpfp_jqueryui_theme',$_POST['wpfp_jqueryui_theme']);	
	update_option('wpfh_fh_name', $_POST['wpfh_fh_name']);
	update_option('wpfh_cem_name', $_POST['wpfh_cem_name']);
	update_option('wpfh_gb_name', $_POST['wpfh_gb_name']);
	update_option('wpfh_gb_name_plural', $_POST['wpfh_gb_name_plural']);
	
		
		if($_FILES['wpfh_obit_default_pic']['name'] != ""){			
     	$wpfh_obit_default_pic = wp_upload_bits($_FILES['wpfh_obit_default_pic']["name"], null, file_get_contents($_FILES['wpfh_obit_default_pic']["tmp_name"]));		
		 update_option('wpfh_obit_default_pic',$wpfh_obit_default_pic['url']);
		}
	

	//checkboxes
	if($_POST['wpfh_enable_search'] == "1"){update_option('wpfh_enable_search','1' ); }else{update_option('wpfh_enable_search','0' );	}	
	if($_POST['wpfh_disable_guestbook'] == "1"){update_option('wpfh_disable_guestbook','1' ); }else{update_option('wpfh_disable_guestbook','0' );	}
	if($_POST['wpfh_disable_fb'] == "1"){update_option('wpfh_disable_fb','1' ); }else{update_option('wpfh_disable_fb','0' );	}	
	if($_POST['wpfh_disable_print'] == "1"){update_option('wpfh_disable_print','1' ); }else{update_option('wpfh_disable_print','0' );	}			
	if($_POST['wpfh_allow_guests'] == "1"){update_option('wpfh_allow_guests','1' ); }else{update_option('wpfh_allow_guests','0' );	}		
	if($_POST['users_can_register'] == "1"){update_option('users_can_register','1' ); }else{update_option('users_can_register','0' );	}	
	if($_POST['wpfh_recaptcha'] == "1"){update_option('wpfh_recaptcha','1' ); }else{update_option('wpfh_recaptcha','0' );	}	
	if($_POST['wpfh_disable_fb'] == "1"){update_option('wpfh_disable_fb','1' ); }else{update_option('wpfh_disable_fb','0' );	}		
	if($_POST['wpfh_disable_breadcrumbs'] == "1"){update_option('wpfh_disable_breadcrumbs','1' ); }else{update_option('wpfh_disable_breadcrumbs','0' );	}			
	if($_POST['wpfh_guestbook_post_count'] == "1"){update_option('wpfh_guestbook_post_count','1' ); }else{update_option('wpfh_guestbook_post_count','0' );	}	
	if($_POST['wpfh_auto_approve_guestbook'] == "1"){update_option('wpfh_auto_approve_guestbook','1' ); }else{update_option('wpfh_auto_approve_guestbook','0' );	}	
	
	//end checkboxes
	
	echo '<div class="wpfh_message">Saved Your Settings!</div>';
	}
	
	//get checkbox
	if(get_option('wpfh_enable_search') == 1){ $wpfh_enable_search = ' checked="checked" ';	}else{ $wpfh_enable_search = '  '; }
	if(get_option('wpfh_disable_guestbook') == 1){ $wpfh_disable_guestbook = ' checked="checked" ';	}else{ $wpfh_disable_guestbook = '  '; }
	if(get_option('wpfh_disable_fb') == 1){ $wpfh_disable_fb = ' checked="checked" ';	}else{ $wpfh_disable_fb = '  '; }
	if(get_option('wpfh_disable_print') == 1){ $wpfh_disable_print = ' checked="checked" ';	}else{ $wpfh_disable_print = '  '; }
	if(get_option('wpfh_allow_guests') == 1){ $wpfh_allow_guests = ' checked="checked" ';	}else{ $wpfh_allow_guests = '  '; }
	if(get_option('users_can_register') == 1){ $users_can_register = ' checked="checked" ';	}else{ $users_can_register = '  '; }
	if(get_option('wpfh_recaptcha') == 1){ $wpfh_recaptcha = ' checked="checked" ';	}else{ $wpfh_recaptcha = '  '; }
	if(get_option('wpfh_disable_fb') == 1){ $wpfh_disable_fb = ' checked="checked" ';	}else{ $wpfh_disable_fb = '  '; }
	if(get_option('wpfh_disable_breadcrumbs') == 1){ $wpfh_disable_breadcrumbs = ' checked="checked" ';	}else{ $wpfh_disable_breadcrumbs = '  '; }
	if(get_option('wpfh_guestbook_post_count') == 1){ $wpfh_guestbook_post_count = ' checked="checked" ';	}else{ $wpfh_guestbook_post_count = '  '; }
	if(get_option('wpfh_auto_approve_guestbook') == 1){ $wpfh_auto_approve_guestbook = ' checked="checked" ';	}else{ $wpfh_auto_approve_guestbook = '  '; }
	
	
	echo ' <form method="post" action="admin.php?page=wpfh-settings" enctype="multipart/form-data">
	<table class="wp-list-table widefat fixed posts" cellspacing="0">
 
	 	 <tr>
	 <td><strong>Override Admin Email</strong><br><em>If you need to set an alternative email to use for the administrator email then use this. Otherwise it defaults to your wordpress settings.          </td>
	 <td><input type="text" name="wpfh_email_admin_override"" value="'.stripslashes(get_option('wpfh_email_admin_override')).'" style="width:400px"></td>
	 </tr>
	  <tr>
    <td width="300"><strong>'.__("Obit Display type","sp-wpfh").'</strong><br><em>'.__("There are 3 different styles to display your obits. Thumbnail mode, block mode and list mode. Check out each style and choose the best one for your website","sp-wpfh").'.</em></td>
    <td><select name="wpfh_obit_style">
		<option value="'.get_option('wpfh_obit_style').'" selected="selected">'.get_option('wpfh_obit_style').'</option>
		<option value="thumbnails">'.__("Thumbnails","sp-wpfh").'</option>
		<option value="block">'.__("Block","sp-wpfh").'</option>
		<option value="list">'.__("List","sp-wpfh").'</option>
		</select> </td>
  </tr>
   <tr>
    <td width="300"><strong>Obit List thumbnail</strong><br><em>Width and height for the main obit list thumbnails</em></td>
    <td>Width <input type="text" name="wpfh_obits_w"  value="'.get_option('wpfh_obits_w').'"  size=80"  style="width:50px">   Height <input type="text" name="wpfh_obits_h"  value="'.get_option('wpfh_obits_h').'"  size=80"  style="width:50px"> </td>
  </tr>
     <tr>
    <td width="300"><strong>Main Obit Image</strong><br><em>Main Image on the obit.</em></td>
    <td>Width <input type="text" name="wpfh_obit_w"  value="'.get_option('wpfh_obit_w').'"  size=80"  style="width:50px">   Height <input type="text" name="wpfh_obit_h"  value="'.get_option('wpfh_obit_h').'"  size=80"  style="width:50px"> </td>
  </tr>
   <tr>
    <td width="300"><strong>Widget Image thumbnail</strong><br><em>Width and height for the widgets</em></td>
    <td>Width <input type="text" name="wpfh_obitw_w"  value="'.get_option('wpfh_obitw_w').'"  size=80"  style="width:50px">   Height <input type="text" name="wpfh_obitw_h"  value="'.get_option('wpfh_obitw_h').'"  size=80"  style="width:50px"> </td>
  </tr>
  <tr>
    <td width="300"><strong>Shortcode Image thumbnail</strong><br><em>Width and height for the shortcodes</em></td>
    <td>Width <input type="text" name="wpfh_obitsh_w"  value="'.get_option('wpfh_obitsh_w').'"  size=80"  style="width:50px">   Height <input type="text" name="wpfh_obitsh_h"  value="'.get_option('wpfh_obitsh_h').'"  size=80"  style="width:50px"> </td>
  </tr>
     <tr>
    <td width="300"><strong>Disable facebook share?</strong><br><em>Check this to disable the facebook share button</em></td>
    <td><input type="checkbox" name="wpfh_disable_fb"   value="1" '. $wpfh_disable_fb.'>  </td>
  </tr>
      <tr>
    <td width="300"><strong>Disable obit print button?</strong><br><em>Check this to disable the obit print button</em></td>
    <td><input type="checkbox" name="wpfh_disable_print"   value="1" '. $wpfh_disable_print.'>  </td>
  </tr>
     <tr>
    <td width="300"><strong>Disable breadcrumbs?</strong><br><em>Check this to disable breadcrumbs</em></td>
    <td><input type="checkbox" name="wpfh_disable_breadcrumbs"   value="1" '. $wpfh_disable_breadcrumbs.'>  </td>
  </tr>
   <tr>
    <td width="300"><strong>Disable Guestbook?</strong><br><em>Check this box to disable the guestbook</em></td>
    <td><input type="checkbox" name="wpfh_disable_guestbook"   value="1" '. $wpfh_disable_guestbook.'>  </td>
  </tr>
    <tr>
    <td width="300"><strong>Auto approve guestbook posts?</strong><br><em>Checking this will bypass the guestbook approval system</em></td>
    <td><input type="checkbox" name="wpfh_auto_approve_guestbook"   value="1" '. $wpfh_auto_approve_guestbook.'>  </td>
  </tr>
     <tr>
    <td width="300"><strong>Allow Guests to post without registration</strong><br><em>Check this to allow non registered users to post to the guestbook</em></td>
    <td><input type="checkbox" name="wpfh_allow_guests"   value="1" '. $wpfh_allow_guests.'>  </td>
  </tr>
   <tr>
    <td width="300"><strong>Show post count on guestbook tab?</strong><br><em>This will show the post count on guestbook tab</em></td>
    <td><input type="checkbox" name="wpfh_guestbook_post_count"   value="1" '. $wpfh_guestbook_post_count.'>  </td>
  </tr>
    <tr>
    <td width="300"><strong>Enable Registration?</strong><br><em>Check this to enable wordpress registration, this is a default wordpress setting. We just make it easier for you to change it here.</em></td>
    <td><input type="checkbox" name="users_can_register"   value="1" '. $users_can_register.'>  </td>
  </tr>
    <tr>
    <td width="300"><strong>Enable reCaptcha?</strong><br><em>Check this to enable captcha code for guest users. Put in your public and private key, <a href="https://www.google.com/recaptcha" target="_blank">You can get one here</a></em></td>
    <td><input type="checkbox" name="wpfh_recaptcha"   value="1" '. $wpfh_recaptcha.'><br>Public Key: <input style="width:400px" type="text" name="wpfh_recaptcha_public_key" value="'.get_option('wpfh_recaptcha_public_key').'"><br>Private Key: <input type="text" name="wpfh_recaptcha_private_key" value="'.get_option('wpfh_recaptcha_private_key').'" style="width:400px"> </td>
  </tr>
    <tr>
    <td width="300"><strong>'.__("Enable Search?","sp-wpfh").'</strong><br><em>'.__("Should we add a search form to the top of the obits page?","sp-wpfh").'</em></td>
    <td><input type="checkbox" name="wpfh_enable_search"   value="1" '. $wpfh_enable_search.'>  </td>
  </tr>

    <tr>
    <td width="300"><strong>'.__("How many Obituaries to display","sp-wpfh").'</strong><br><em>'.__("How many obits should we display on each page?","sp-wpfh").'</em></td>
    <td><input type="text" name="wpfh_obit_display_num"  value="'.get_option('wpfh_obit_display_num').'"  size=80"> </td>
  </tr>
  <td width="300"><strong>'.__("Search by","sp-wpfh").'</strong><br><em>'.__("Would you like to have the users search by burial or death date?","sp-wpfh").'</em></td>
    <td> <select name="wpfh_search_date_by">
		<option value="'.get_option('wpfh_search_date_by').'">'.get_option('wpfh_search_date_by').'</option>
		<option value="death_date">Death Date</option>
		<option value="burial_date">Burial Date</option>
		</select></td>
  </tr>
     <tr>
    <td width="300"><strong>'.__("Order Obits by","sp-wpfh").'</strong><br><em>'.__("How do you want to order the obits? Default is the burial date","sp-wpfh").'</em></td>
    <td> <select name="wpfh_order_obits">
		<option value="'.get_option('wpfh_order_obits').'">'.get_option('wpfh_order_obits').'</option>
		<option value="death_date">Death Date</option>
		<option value="burial_date">Burial Date</option>
		<option value="birth_date">Birth Date</option>
		<option value="last_name">Last Name</option>
		<option value="first_name">First Name</option>
		</select></td>
  </tr>
    <tr>
    <td width="300"><strong>'.__("Word for Obituaries","sp-wpfh").'</strong><br><em>'.__("What should we call Obituaries?","sp-wpfh").'</em></td>
    <td>Singular <input type="text" name="wpfh_obit_name"  value="'.get_option('wpfh_obit_name').'"  size=80"  style="width:100px"> Plural <input type="text" name="wpfh_obit_name_plural"  value="'.get_option('wpfh_obit_name_plural').'"   style="width:100px"></td>
  </tr>
     <tr>
    <td width="300"><strong>'.__("Word for Churches","sp-wpfh").'</strong><br><em>'.__("What word should we use in place of Church","sp-wpfh").'</em></td>
    <td><input type="text" name="wpfh_church_name"  value="'.get_option('wpfh_church_name').'"  size=80"  style="width:100px"> </td>
  </tr>
       <tr>
    <td width="300"><strong>'.__("Word for Funeral Home","sp-wpfh").'</strong><br><em>'.__("What word should we use in place of funeral home","sp-wpfh").'</em></td>
    <td><input type="text" name="wpfh_fh_name"  value="'.get_option('wpfh_fh_name').'"  size=80"  style="width:100px"></td>
  </tr>
    <tr>
    <td width="300"><strong>'.__("Word for Funeral Cemetery","sp-wpfh").'</strong><br><em>'.__("What word should we use in place of cemetery","sp-wpfh").'</em></td>
    <td><input type="text" name="wpfh_cem_name"  value="'.get_option('wpfh_cem_name').'"  size=80"  style="width:100px"></td>
  </tr>
   <tr>
    <td width="300"><strong>'.__("Word for Guestbooks","sp-wpfh").'</strong><br><em>'.__("What word should we use in place of guestbook","sp-wpfh").'</em></td>
    <td>Singular <input type="text" name="wpfh_gb_name"  value="'.get_option('wpfh_gb_name').'"  size=80"  style="width:100px"> Plural <input type="text" name="wpfh_gb_name_plural"  value="'.get_option('wpfh_gb_name_plural').'"  size=80"  style="width:100px"></td>
  </tr>
    <tr>
    <td width="300"><strong>'.__("No guestbook comments text","sp-wpfh").'</strong><br><em>'.__("The text to display if no guestbook posts exist.","sp-wpfh").'</em></td>
    <td><input type="text" name="wpfh_gb_no_posts"  value="'.get_option('wpfh_gb_no_posts').'"  size=80"  ></td>
  </tr>
   <tr>
    <td width="300"><strong>'.__("Order Flowers link","sp-wpfh").'</strong><br><em>'.__("There are many different flower affiliate programs available online. If you would like your users to order flowers put the full url for your flowers affiliate program. If you leave it blank the order flowers link will not show.","sp-wpfh").'</em></td>
    <td><input type="text" name="wpfh_order_flowers"  value="'.get_option('wpfh_order_flowers').'"  size=80"> </td>
  </tr>
  
   <tr>
    <td width="300"><strong>'.__("No pic image","sp-wpfh").'</strong><br><em>'.__("Upload a default picture we should use incase the deceased does not have a picture.","sp-wpfh").'</em></td>
    <td><input type="file" name="wpfh_obit_default_pic"  ><div>';
	
	if(get_option('wpfh_obit_default_pic') != ''){
		echo '<img src="../wp-content/plugins/wp-funeral-press/thumbs.php?src='.get_option('wpfh_obit_default_pic').'&w=150&h=150">';
	}else{
	echo '<span style="color:red">'.__("No default pictured loaded, please upload one.","sp-wpfh").'</div>';
	}
	echo '</div> </td>
  </tr>
  		 <tr>
    <td ><strong>Jquery UI Theme</strong><br><em>You can change the theme here or remove the theme if you use your own custom theme. The default theme is smoothness. <a href="http://jqueryui.com/themeroller/" target="_blank">Click here to view all themes</a>.</em></td>
    <td><select name="wpfp_jqueryui_theme">
			<option value="'.get_option('wpfp_jqueryui_theme').'" selected="selected">'.get_option('wpfp_jqueryui_theme').'</option>
			<option value="base">base</option>
			<option value="black-tie">black-tie</option>
			<option value="blitzer">blitzer</option>
			<option value="cupertino">cupertino</option>
			<option value="dark-hive">dark-hive</option>
			<option value="dot-luv">dot-luv</option>
			<option value="eggplant">eggplant</option>
			<option value="excite-bike">excite-bike</option>
			<option value="flick">flick</option>
			<option value="hot-sneaks">hot-sneaks</option>
			<option value="humanity">humanity</option>
			<option value="le-frog">le-frog</option>
			<option value="mint-choc">mint-choc</option>
			<option value="overcast">overcast</option>
			<option value="pepper-grinder">pepper-grinder</option>
			<option value="redmond">redmond</option>
			<option value="smoothness">smoothness</option>
			<option value="south-street">south-street</option>
			<option value="start">start</option>
			<option value="sunny">sunny</option>
			<option value="swanky-purse">swanky-purse</option>
			<option value="trontastic">trontastic</option>
			<option value="ui-darkness">ui-darkness</option>
			<option value="ui-lightness">ui-lightness</option>
			<option value="vader">vader</option>
			<option value="none">Remove Theme (use your own )</option>

		 </select></td>
  </tr>
		
';
	
	
	
	do_action('wpfh_cem_settings');
	
echo '
  <tr><td></td><td><input type="submit" value="Save" name="save-settings"/></td></tr>
</table>
	
';

	
		
echo '


</form>';	
	
	
}
	
}

?>
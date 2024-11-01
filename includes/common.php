<?php


function wpfh_order_obits(){
	
	if(get_option('wpfh_order_obits') == ''){
	
	$order = 'burial_date';	
		
	}else{
	$order = get_option('wpfh_order_obits');	
	}
		return $order;	
}

function wpfp_show_post($id){
global $wpdb;	
	
	
}


if(!function_exists('set_html_content_type')){
function set_html_content_type() {

	return 'text/html';
}
}
function wpfh_user($id,$value= NULL){
	global $wpdb;
	
	
	$user =  get_userdata( $id);
	
	
	if($value != NULL){
		return $user->$value;
	}else{
		return $user;
	}
	
}
function wpfh_obit($id, $value = NULL){
	global $wpdb;
	
		$r = $wpdb->get_results("SELECT * FROM  ".$wpdb->prefix ."wpfh_obits WHERE id = '".$id."'", ARRAY_A);
			
	
	if($value != NULL){
		return $r[0][$value];
	}else{
		return $r;
	}
}
function wpfh_set_meta_status($id,$status){
	global $wpdb,$current_user;
	
	$update['status'] = $status;
	$where['id'] = $id;
	
	$wpdb->update("".$wpdb->prefix ."wpfh_obits_meta", $update,$where);
}
function wpfh_set_meta($vars){
	
	global $wpdb,$current_user;
	
	
	if($vars['multiple'] == 1){
	$insert['uid'] = $vars['uid'];
	$insert['oid'] = $vars['oid'];
	$insert['status'] = $vars['status'];
	$insert['meta_name'] = $vars['meta_name'];
	$insert['meta_value'] = serialize($vars['meta_value']);
	$wpdb->insert("".$wpdb->prefix ."wpfh_obits_meta", $insert);
	$insert_id =  $wpdb->insert_id;
	}else{
	$r = $wpdb->get_results("SELECT * FROM  ".$wpdb->prefix ."wpfh_obits_meta  where meta_name = '".$wpdb->escape($vars['meta_name'])."' and oid = '".$vars['oid']."'", ARRAY_A);		
	
	if(count($r)== 0){
	$insert['uid'] = $vars['uid'];
	$insert['oid'] = $vars['oid'];
	$insert['status'] = $vars['status'];
	$insert['meta_name'] = $vars['meta_name'];
	$insert['meta_value'] = serialize($vars['meta_value']);
	$wpdb->insert("".$wpdb->prefix ."wpfh_obits_meta", $insert);
	$insert_id =  $wpdb->insert_id;
	}else{
	$insert['uid'] = $vars['uid'];
	$insert['oid'] = $vars['oid'];
	$insert['status'] = $vars['status'];
	$insert['meta_name'] = $vars['meta_name'];
	$insert['meta_value'] = serialize($vars['meta_value']);
	$where['id'] = $r[0]['id'];
	$wpdb->update("".$wpdb->prefix ."wpfh_obits_meta", $insert,$where);	
	$insert_id =  $r[0]['id'];
	}
	
	
	}
	
	return $insert_id;
	
	
	
}
function wpfh_delete_meta($id){
	global $wpdb;
	$wpdb->query("DELETE FROM ".$wpdb->prefix . "wpfh_obits_meta where  id = '".$wpdb->escape($id)."'	");	
}
function wpfh_get_meta($vars){
	global $wpdb,$current_user;
	
	
	if(is_numeric($vars)){ 
	$r = $wpdb->get_results("SELECT * FROM  ".$wpdb->prefix ."wpfh_obits_meta where  id = '".$wpdb->escape($vars)."'", ARRAY_A);
	
	return $r;
	}else{
		
		if($vars['status'] != ''){
		$status = '  AND status = '.$vars['status'].' ';	
		}
	if($vars['oid'] == ''){
		
	$r = $wpdb->get_results("SELECT * FROM  ".$wpdb->prefix ."wpfh_obits_meta where  meta_name = '".$wpdb->escape($vars['meta_name'])."' ".$status."", ARRAY_A);	
	
		return $r;
		
	}else{
		
		
		$r = $wpdb->get_results("SELECT * FROM  ".$wpdb->prefix ."wpfh_obits_meta  where meta_name = '".$wpdb->escape($vars['meta_name'])."' and oid = '".$vars['oid']."' ".$status."", ARRAY_A);		
		
		if($r >1 ){
		return $r;	
		}else{
		
			if(is_array(@unserialize($r[0]['meta_value']))){
			return 	unserialize($r[0]['meta_value']);
			}else{
				
			return stripslashes($r[0]['meta_value']);
			}
			
		}
	}
	
}
}

function wpfh_editor($content,$id,$settings){
	

ob_start();


wp_editor($content,$id,$settings);


$editor_contents = ob_get_clean();


return $editor_contents;
	
}
function wpfh_gb_word($plural = 0){
	
	global $wpdb;
	
	
	$h = __("Guestbook","sp-wpfh");	
	
	
		if(get_option('wpfh_gb_name') != ''){
			
				if($plural == 1){
			$h =get_option('wpfh_gb_name_plural');
				}else{
				$h =get_option('wpfh_gb_name');	
				}
			
				
		}
		
		return $h;
}
function wpfh_cem_word(){
	
	global $wpdb;
	
	
	$h = __("Cemetery","sp-wpfh");	
	
		
		if(get_option('wpfh_cem_name') != ''){
			$h =get_option('wpfh_cem_name');	
		}
		
		return $h;
}


function wpfh_fh_word(){
	
	global $wpdb;
	
	
	$h = __("Funeral Home","sp-wpfh");
	
		
		if(get_option('wpfh_fh_name') != ''){
			$h =get_option('wpfh_fh_name');	
		}
		
		return $h;
}

function wpfh_church_word(){
	
	global $wpdb;
	
	
	if(get_option('wpfh_church_name') != ''){
			$h =get_option('wpfh_church_name');	
		}else{
			$h =  __("Church","sp-wpfh");	
		}
		return $h;
}

function wpfh_check_theme_my_login(){
	
	global $wpdb;

	 $r = $wpdb->get_results("SELECT * FROM  " . $wpdb->prefix . "posts where post_content LIKE   '%[theme-my-login]%' and post_type = 'page'", ARRAY_A);
	 if($r[0]['ID'] == ""){
		return false;
		}else{
		return $r[0]['ID'];	
		}
	 
}

function wpfh_obit_page_id(){
	global $wpdb;

	 $r = $wpdb->get_results("SELECT * FROM  " . $wpdb->prefix . "posts where post_content LIKE   '%[funeralpress]%' and post_type = 'page'", ARRAY_A);
							
		if($r[0]['ID'] == ""){
		return false;
		}else{
		return $r[0]['ID'];	
		}
}

function wpfh_obit_page_url($and){
	global $wpdb;
	
		$url = get_permalink( wpfh_obit_page_id() );	
		
		
if ( get_option('permalink_structure') != '' ) { 


return ''.$url.'?'.$and.''	;


}else{
	
		return ''.$url.'&'.$and.''	;
	
	
}
	
	
}
function wpfh_obit_page($obitid = NULL, $f = NULL, $atts = NULL){
	global $wpdb;
	
	
	if ( get_option('permalink_structure') != '' ) { 
	
		$url = apply_filters('wpfh_link_url',$url,$obitid,$f);
		
		if($url != ''){
			if($atts != NULL){
			$atts = '?'.$atts.'';	
			$url .=''.$atts.'';
			}
						
			
		return $url;	
		}
	}
					
	$url = get_permalink( wpfh_obit_page_id() );		

			if($obitid != ""){
					$and .='id='.$obitid.'';
			} 
			if($f != NULL){
				   $and .='&f='.$f.'';
			}
		
		

	if($atts != NULL){
$atts = '&'.$atts.'';	
}	
	
if ( get_option('permalink_structure') != '' ) { 


return ''.$url.'?'.$and.''.$atts.''	;


}else{
	
		return ''.$url.'&'.$and.''.$atts.''	;
	
	
}
		
		
		


	
	
}
	
	

function wpfh_notice($message){
	
return $message;	
}

function get_real_image_path ($url) {
	
	global $blog_id;
	$theImageSrc = $url;
	if (isset($blog_id) && $blog_id > 0) {
		$imageParts = explode('/files/', $theImageSrc);
		if (isset($imageParts[1])) {
			$theImageSrc = '/blogs.dir/' . $blog_id . '/files/' . $imageParts[1];
		}
	}
	return $theImageSrc;
}
function wpfh_admin_email(){
		if(get_option('wpfh_email_admin_override') != ''){
			return get_option('wpfh_email_admin_override');
		}else{
			return get_option('admin_email');
		}
}

function wpfh_email($to,$subject,$content,$headers,$attach = NULL ){
	global $wpdb;
	
	
			
	
		if(get_option('wpfh_email_admin_override') != ''){
			
			  $headers .= 'From: '.get_option('wpfh_email_admin_override').' <'.get_option('wpfh_email_admin_override').'>' . "\r\n";
		}else{
			 $headers .= 'From: '.get_option('admin_email').' <'.get_option('admin_email').'>' . "\r\n";
		}
	 
  //add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
   wp_mail( $to, 
   			$subject, 
			$content, 
			$headers);
			
				
	
	
	
}


function wpfh_login(){
	global $wpdb;
	
		  if ( !is_user_logged_in() ) { 
 					
					
	
	
								wpfh_redirect(wp_login_url($_SERVER['REQUEST_URI'] ));
						 }else{
							 
							 	
					return true; 
					 }
	
}

function wpfh_short_link($url){
		
		global $wpdb;
		
						
		
		$longUrl = $url;
		//$apiKey = $this->apikey;
		
		 
		$postData = array('longUrl' => $longUrl, 'key' => '');
		$jsonData = json_encode($postData);
		 
		$curlObj = curl_init();
		 
		curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url');
		curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curlObj, CURLOPT_HEADER, 0);
		curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
		curl_setopt($curlObj, CURLOPT_POST, 1);
		curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);
		 
		$response = curl_exec($curlObj);
		 
		
		$json = json_decode($response);
		 print_r($json);
		curl_close($curlObj);
		 
		return $json->id;
				
		
	}

function wpfh_share_fb($url,$picture,$name,$text,$r){
	
$picture = get_real_image_path ( $picture );
	
	$name = 'View '.$name.'\'s '.get_option('wpfh_obit_name').'';

	//$url = 'https://www.facebook.com/dialog/feed?app_id=14563499550189&display=popup&caption='.urlencode($name).'&picture='.urlencode($picture).'&link='.urlencode($url).'&summary='.$text.'&redirect_uri=https://developers.facebook.com/tools/explorer';

//$url = 'https://www.facebook.com/dialog/feed?app_id=145634995501895&display=popup&caption='.urlencode($url).'&picture='.urlencode($picture).'&name='.urlencode($name).'&link='.$url.'&description='.$text.'&redirect_uri='.$url.'';
 
 $url ='http://www.facebook.com/sharer.php?u='.$url.'';
  
if(get_option('wpfh_disable_fb') != 1){
	$html .='<a href="'.$url.'" class="share_fb wpfh_popup wpfh-fb">'.__("Share","sp-wpfh").'</a>';
	return $html;
}
	
}
function wpfh_redirect($url){
	
	
	echo '<script type="text/javascript">
<!--
window.location = "'.$url.'"
//-->
</script>';exit;
}
function wpfh_current_url() {
	$pageURL = 'http';
	if( isset($_SERVER["HTTPS"]) ) {
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}
?>
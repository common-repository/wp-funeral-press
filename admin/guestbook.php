<?php
 class  wpfh_obits_guestbook{
	
		function menu(){
		
		global $wpfh_install;
		
		$submenu = '<a href="admin.php?page=wpfh-guestbook" class="button">'.__("View Guestbook Postings","sp-wpfh").'</a> 
				     ';
		return $wpfh_install->topMenu(__("Guestbook","sp-wpfh"),$submenu);
	}
	
	 function youtube($url){
		
	
    $id=0;
    // we get the unique video id from the url by matching the pattern
    preg_match("/v=([^&]+)/i", $url, $matches);
    if(isset($matches[1])) $id = $matches[1];
    if(!$id) {
        $matches = explode('/', $url);
        $id = $matches[count($matches)-1];
    }
    // this is your template for generating embed codes
    $code = '<div id="img_wrapper"><object width="640" height="458"><param name="movie" value="http://www.youtube.com/v/{id}&hl=en_US&fs=1&"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/{id}&hl=en_US&fs=1&" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="425" height="344"></embed></object></div>';

    // we replace each {id} with the actual ID of the video to get embed code for this particular video
    $code = str_replace('{id}', $id, $code);

    return $code;
	}
	
	 function postedOn($id,$type){
		  
		 	global $wpdb;
		 
		 	$r = $wpdb->get_results("SELECT * FROM  ".$wpdb->prefix ."wpfh_obits  where id = ".$wpdb->escape($id)."", ARRAY_A);	
			
			
			return stripslashes($r[0][$type]);
	 }
	  function postedBy($id,$type){
		 
		 	global $wpdb;
			
			 $user_data = get_userdata($id);
			 
			 
			 return $user_data->$type;
		 
	 }
	 

	function add(){
		global $wpdb;
		
	
		if($_POST['save-guestbook'] != ""){
		if($_POST['message']  != ''){
		$insert['content'] = sanitize_text_field($_POST['message']);
		}
		$insert['approved'] = $_POST['approved'];
			
		if($_POST['id'] == ""){
			$wpdb->insert("".$wpdb->prefix ."wpfh_posts", $insert);
		}else{			
			$where['id'] = $_POST['id'];
			
					
			$wpdb->update("".$wpdb->prefix ."wpfh_posts", $insert,$where);
		}
		wpfh_redirect('admin.php?page=wpfh-guestbook');	
		}
		
		if($_GET['id'] != ""){
			
			$r = $wpdb->get_results("SELECT * FROM  ".$wpdb->prefix ."wpfh_posts where id = ".$wpdb->escape($_GET['id'])."", ARRAY_A);
		$extra = '<input name="id" type="hidden" value="'.$r[0]['id'].'"/>';	
		if($r[0]['approved'] == 1){
			
			$ap = 'Yes';
				
			}else{
			$ap = 'No';	
			}
		$approved = '<option value="'.$r[0]['approved'].'" selected="selected">'.$ap.'</option>';
		}
		
		
		
			if($r[0]['uid'] == 0){
			$name = '<a href="mailto:'.$r[0]['email'].'">'.$r[0]['name'].'</a> <em>(Guest)</em>';	
		}else{
		$name = '<a href="mailto:'.$this->postedBy($r[0]['uid'],'user_email').'">'.$this->postedBy($r[0]['uid'],'display_name').'</a>';	
		}
			
		
		
		echo '<form method="post" action="admin.php?page=wpfh-guestbook&function=add" enctype="multipart/form-data">
'.	$extra.'
 <table class="wp-list-table widefat fixed posts" cellspacing="0">

  <tr>
    <td width="148"><label for="first_name">'.__("Posted by","sp-wpfh").'</label></td>
    <td>'.	$name .'</td>
  </tr>
  <tr>
    <td><label for="middle">'.__("Posting On","sp-wpfh").'</label></td>
    <td>'.$this->postedOn($r[0]['oid'],'first_name').' '.$this->postedOn($r[0]['oid'],'last_name').'</td>
  </tr>
  <tr>
    <td><label for="last_name">'.__("Message","sp-wpfh").'</label></td>
    <td>';
	
		if($r[0]['type'] == 'guestbook'){
						echo '<textarea name="message"  style="width:100%;height:200px">'.stripslashes($r[0]['content']).'</textarea>';
												}
												if($r[0]['type'] == 'photo'){
												unset($photo);
												$photo = unserialize(stripslashes($r[0]['content']));	
											echo '<img src="'.$photo['url'].'" /><p>'.$photo['desc'].'</p>
											
											
											';
											
												}
													if($r[0]['type'] == 'youtube'){
														unset($youtube);
												$youtube = unserialize(stripslashes($r[0]['content']));	
												
													echo $this->youtube($youtube['url']);
													echo'<p>'.$youtube['desc'].'</p>';
												
													
												
													}
													
													
													do_action('wpfh_admin_post_view',$r);

	
	
	
	echo '</td>
  </tr>
    
    <tr>
    <td><label for="burial_date">'.__("Approved","sp-wpfh").'</label></td>
    <td><select name="approved">
	'.$approved.'
	<option value="1">'.__("Yes","sp-wpfh").'</option>
	<option value="0">'.__("No","sp-wpfh").'</option>
	</select></td>
  </tr>
  <tr><td></td><td><input type="submit" value="Save" name="save-guestbook"/></td></tr>
</table>';
		
		
		
	}
	function view($id= NULL){
		
		
		global $wpdb;
		
		echo $this->menu();
		
			if($_GET['function'] == 'delete'){
		$wpdb->query("DELETE FROM  ".$wpdb->prefix ."wpfh_posts WHERE id = ".$wpdb->escape($_GET['id'])."	");
			wpfh_redirect('admin.php?page=wpfh-guestbook');				
	}
	
	
		if($_GET['function'] == 'approve'){				
			$update['approved'] = $_GET['approve'];
			$where['id'] = $_GET['id'];
			$wpdb->update("".$wpdb->prefix ."wpfh_posts", $update,$where);
			
						if(get_option('wpfh_email_user_approved') != ""){
						$r_approve = $wpdb->get_results("SELECT * FROM  ".$wpdb->prefix ."wpfh_posts  where id = ".$wpdb->escape($where['id'] )."", ARRAY_A);		
						if($r_approve[0]['name'] != ''){
						$name_to = $r_approve[0]['name'];	
						}else{
						$name_to = ''.$this->postedBy($r_approve[0]['uid'],'display_name').'';
						}
						$email_content = str_replace("[obit]",''.$this->postedOn($r_approve[0]['oid'] ,'first_name').' '.$this->postedOn($r_approve[0]['oid'],'last_name').'',stripslashes(get_option('wpfh_email_user_approved')));
						$email_content = str_replace("[link]",''. wpfh_obit_page($r_approve[0]['oid'],'guestbook').'', $email_content);
						$email_content = str_replace("[user]",''.$name_to.'',$email_content);
						
						if(stripslashes(get_option('wpfh_email_user_approve_cc')) != ''){
						$headers .=  'Cc: '.get_option('wpfh_email_user_approve_cc').'' . "\r\n";
						}
						
						if($r_approve[0]['email'] != ''){
						$send_to = $r_approve[0]['email'];	
						}else{
						$send_to = $this->postedBy($r_approve[0]['uid'],'user_email');	
						}
						 add_filter( 'wp_mail_content_type', 'set_html_content_type' );
						wpfh_email($send_to,stripslashes(get_option('wpfh_email_user_approved_subject')),$email_content,$headers );
						 remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
					
						unset($email_content);
				}
			
					if($_GET['approve'] == 1){
						
						do_action('wpfh_obit_approved',$where['id']);	
					}
			
			wpfh_redirect('admin.php?page=wpfh-guestbook');		
			}
		
	if($_GET['id'] != "" or $_GET['function'] == 'add'){
	
	
	 $this->add();
			}else{
			
	
		
		
		
	
	
		
		
		
		if($id != ""){
		$search = ' AND oid = '.$id.'';	
		}
		
		
			
			$search = apply_filters("wpfh_admin_search_guestbook_query", $search);
		
			$query = "SELECT * FROM  " . $wpdb->prefix . "wpfh_posts WHERE id != '' ".$search." order by date desc";
		
			$pagination = new Pagination();
			if (isset($_GET['pagenum'])){   $page = (int) $_GET['pagenum'];}else{ $page = 1; }
			$pagination->setLink("admin.php?page=wpfh-guestbook&pagenum=%s");
			$pagination->setPage($page);
			$pagination->setSize(get_option('wpfh_obit_display_num'));
			$pagination->setTotalRecords(count($wpdb->get_results($query, ARRAY_A)));
		    $r = $wpdb->get_results("".$query." ".$pagination->getLimitSql()."", ARRAY_A);
		
		
		
			 
									 echo '
								 <table class="wp-list-table widefat fixed posts" cellspacing="0">
	<thead>
	<tr>
<th width="150">'.__("Date","sp-wpfh").'</th>
<th width="120">'.__("Posted On","sp-wpfh").'</th>
<th width="100">'.__("Poster Name","sp-wpfh").'</th>
<th width="100">'.__("Type","sp-wpfh").'</th>
<th>'.__("Message Preview","sp-wpfh").'</th>
<th>'.__("Action","sp-wpfh").'</th>
</tr>
	</thead>';
				
				if(count($r) == 0){
					echo '	<tr>
					<td colspan="4">
					<div class="error">  '.__("No Posts Found","sp-wpfh").'</div>
					</td></tr>';
				}else{
				
				for($i=0; $i<count(	$r); $i++){
				
				if($r[$i]['approved'] == 1){
		$approve = '<a href="admin.php?page=wpfh-guestbook&function=approve&id='.$r[$i]['id'].'&approve=0"  class="button"  style="margin-right:15px" >'.__("Unapprove","sp-wpfh").'</a>';
		
		$style= ' ';
			
		}else{
			$style= ' style="background-color:#ffd1d1 !important" ';
		$approve = '<a href="admin.php?page=wpfh-guestbook&function=approve&id='.$r[$i]['id'].'&approve=1"  class="button"  style="margin-right:15px" >'.__("Approve","sp-wpfh").'</a>';		
		}
		
			if($r[$i]['uid'] == 0){
			$name = '<a href="mailto:'.$r[$i]['email'].'">'.$r[$i]['name'].'</a>  <em>(Guest)</em>';	
		}else{
		$name = '<a href="mailto:'.$this->postedBy($r[$i]['uid'],'user_email').'">'.$this->postedBy($r[$i]['uid'],'display_name').'</a>';	
		}
			
		
				echo '	<tr>
<td '.$style.'>'. date_i18n(get_option('date_format') , $r[$i]['date']).'</td>				
<td '.$style.'><a href="admin.php?page=wpfh&function=edit&id='.$r[$i]['oid'].'">'.$this->postedOn($r[$i]['oid'],'first_name').' '.$this->postedOn($r[$i]['oid'],'last_name').'</a>	
<td '.$style.'>'.$name .'</td>
<td '.$style.'>'.$r[$i]['type'].'</td>
<td '.$style.'>

';

				if($r[$i]['type'] == 'guestbook'){
						echo '' . substr(stripslashes(strip_tags($r[$i]['content'])), 0, 150) . '...';
												}
												if($r[$i]['type'] == 'photo'){
												unset($photo);
												$photo = unserialize(stripslashes($r[$i]['content']));	
											echo '<a href="'.$photo['url'].'" target="_blank">'.__("View Photo","sp-wpfh").'</a><br>'.$photo['desc'].'';
											
												}
													if($r[$i]['type'] == 'youtube'){
														unset($youtube);
												$youtube = unserialize(stripslashes($r[$i]['content']));	
													echo '<a href="'.$youtube['url'].'" target="_blank">'.__("View Video","sp-wpfh").'</a><br>'.$youtube['desc'].'';	
												
													}


											do_action('wpfh_admin_list_view',$r,$i);


echo '
</td>
<td '.$style.'>
 <a href="admin.php?page=wpfh-guestbook&function=delete&id='.$r[$i]['id'].'" style="margin-right:15px" class="button">'.__("Delete","sp-wpfh").'</a>  
<a href="admin.php?page=wpfh-guestbook&function=edit&id='.$r[$i]['id'].'"  class="button"  style="margin-right:15px">'.__("View","sp-wpfh").'</a>
'.$approve.'
</td>
</tr>';	
					
				}
				}
				echo '</table>';
				echo $pagination->create_links();
			}

	}
	 
	 
	 
	 
 }

?>
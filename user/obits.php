<?php

class wpfh_user_obits
{
	
	
	function go_meta(){
			global $wpdb;
			if ( get_option('permalink_structure') != '' && class_exists('wpfh_premium') ) { 
			
		$_GET['id'] = get_query_var('id');
		$_GET['f'] = get_query_var('f');
			}
			if($_GET['id'] !=''){
		 
			$r = $wpdb->get_results("SELECT * FROM  ".$wpdb->prefix ."wpfh_obits  where id = ".$wpdb->escape($_GET['id'])."", ARRAY_A);	
					
				if( $r[0]['photo']  == ""){ $r[0]['photo'] =get_option('wpfh_obit_default_pic');}

			 
			 
			  $name       = ''.__("Remembering","sp-wpfh").' ' . stripslashes($r[0]['first_name']) . ' ' . stripslashes($r[0]['middle']) . ' ' . stripslashes($r[0]['last_name']) . ' ' . $maiden . '';
			  $description = substr(stripslashes(strip_tags($r[0]['obituary'])),0,200);
			  $obit_page = wpfh_obit_page($_GET['id']);
			  $image = '' . content_url() . '/plugins/wp-funeral-press/thumbs.php?src=' .get_real_image_path ( $r[0]['photo'] ). '&w=400&h=500';
	
	
	echo '


<!-- for Twitter -->          
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="'.$name.'" />
<meta name="twitter:description" content="'.$description.'" />
<meta name="twitter:image" content="'.	$image.'" />
	
	<meta property="og:title" content="'.$name.'"/>
<meta property="og:type" content="article"/>
<meta property="og:url" content="'. $obit_page.'"/>
<meta property="og:image" content="'.	$image.'" />
<meta property="og:description"
      content="'.$description.'"/>';	
			}
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
    function obitName()
    {
        global $wpdb;
        
        
        $r = $wpdb->get_results("SELECT * FROM  " . $wpdb->prefix . "wpfh_obits where id = " . $wpdb->escape($_GET['id']) . "", ARRAY_A);
        if ($r[0]['maiden'] != "") {
            $maiden = ' (' . stripslashes($r[0]['maiden']) . ') ';
        } else {
            $maiden = '';
        }
        $title = '' . stripslashes($r[0]['first_name']) . ' ' . stripslashes($r[0]['middle']) . ' ' . stripslashes($r[0]['last_name']) . ' ' . $maiden . ' | ';
        return $title;
        
    }
    
    function search(){
		 global $wpdb, $post;
		$search = apply_filters('wpfh_search_above',$search);
		$search .='<div id="wpfh_search">
			<form action="'.get_permalink( get_option('wpfh_display_page') ).'" method="get">
				<h3>'.__("Search","sp-wpfh").' '.get_option('wpfh_obit_name_plural').'</h3>
				';
				$search = apply_filters('wpfh_search_before',$search);
				$search .='<label>'.__("First Name","sp-wpfh").'</label><input type="text" name="first_name" value="'.sanitize_text_field($_REQUEST['first_name']).'">   
						  <label>'.__("Last Name","sp-wpfh").'</label> <input type="text" name="last_name" value="'.sanitize_text_field($_REQUEST['last_name']).'"> 
						   ';
						  if(get_option('wpfh_search_date_by') == '' or get_option('wpfh_search_date_by') == 'death_date'){						  
						  $search .='<label>'.__("Death Date","sp-wpfh").'</label> <input type="text" name="date" class="datepicker" value="'.sanitize_text_field($_REQUEST['date']).'">'; 
						  }else{
							$search .='<label>'.__("Burial Date","sp-wpfh").'</label> <input type="text" name="burial_date" class="datepicker" value="'.sanitize_text_field($_REQUEST['burial_date']).'">';  
						  }
				$search = apply_filters('wpfh_search_mid',$search);
				$search .='<div style="text-align:right;padding-top:6px;"><input type="submit" name="search-obits" value="Search!"></div>
					';
					
					$search = apply_filters('wpfh_search_after',$search);
				$search .='</form></div>';
				
				$search = apply_filters('wpfh_search_below',$search);
				
				return $search;
	}
    
    function view()
    {
        global $wpdb, $post,$current_user;
        
        	
	
        if ($_GET['id'] != "") {
			   
			
            $r  = $wpdb->get_results("SELECT * FROM  " . $wpdb->prefix . "wpfh_obits where id = " . $wpdb->escape($_GET['id']) . "", ARRAY_A);
       
			if($r[0]['approved'] != 1){
				
				
			}else{
		
		    $name       = '' . stripslashes($r[0]['first_name']) . ' ' . stripslashes($r[0]['middle']) . ' ' . stripslashes($r[0]['last_name']) . ' ' . $maiden . '';
            $r[0]['fullname'] = $name;
            add_filter('wp_title', array(
                $this,
                'obitName'
            ));
            if ($r[0]['maiden'] != "") {
                $maiden = ' (' . stripslashes($r[0]['maiden']) . ') ';
            } else {
                $maiden = '';
            }
            
            if ($r[0]['vet'] == 1) {
                $class = 'wpfh_obit_vet';
                $vet   = '<div class="wpfh_veteran">U.S. Veteran</div>';
            } else {
                $vet   = '';
                $class = '';
            }
			
			
			
			if($r[0]['birth_date'] != "0000-00-00"  ){
			$birth_date = '' . date_i18n(get_option('date_format') ,strtotime($r[0]['birth_date'])). ' - ';
			}else{
			$birth_date = '';	
			}
			if($r[0]['death_date'] != "0000-00-00"  ){
			$death_date = '' . date_i18n(get_option('date_format') ,strtotime($r[0]['death_date'])) . '';
			}else{
			$death_date = '';	
			}
			if($r[0]['burial_date'] != "0000-00-00"   ){
			$burial_date = '' . date_i18n(get_option('date_format') ,strtotime($r[0]['burial_date'])) . '';
			}else{
			$burial_date = '';	
			}
			
		 $restructure_top_obit  = apply_filters('wpfp_frontend_top_obit', $restructure_top_obit,$r,$name,$birth_date,$death_date,$vet,$burial_date);
		 
		 
		 if($restructure_top_obit != ''){
			 
		$html =  $restructure_top_obit;	 
		 }else{
		 	if( $r[0]['photo']  == ""){ $r[0]['photo'] =get_option('wpfh_obit_default_pic');}
           
		   
		   	$wpfh_obit_subnav_items = apply_filters('wpfh_obit_subnav_items', $wpfh_obit_subnav_items,$r);				
					if(!is_array($wpfh_obit_subnav_items)){
					$wpfh_obit_subnav_items_show = $wpfh_obit_subnav_items;	
					}
		   if(get_option('wpfh_disable_print') != 1){
			   
			$print_button = '<a href="#" class="wpfh-printer">'.__("Print","sp-wpfh").'</a>';   
		   }
		   
		   		if( $r[0]['photo']  == ""){ $r[0]['photo'] =get_option('wpfh_obit_default_pic');}
				
				
		   
		    $html .= '<div id="wpfh_main_obit">
									
									<div class="wpfh_main_obit_info '.$class.'">
										<div id="wpfh_main_obit_left">	';
										
										$html .='<div style="float:left;width:'.get_option('wpfh_obit_w').'px;margin-right:10px;"><img src="' . content_url() . '/plugins/wp-funeral-press/thumbs.php?src=' .get_real_image_path ( $r[0]['photo'] ). '&w='.get_option('wpfh_obit_w').'&h='.get_option('wpfh_obit_h').'" ></div>';
										$html = apply_filters('wpfp_main_before_name',$html,$r);									
										$html .='<h2><a href="'.wpfh_obit_page($_GET['id']).'">' . $name . '</a></h2>
										';
										$html = apply_filters('wpfp_main_after_name',$html,$r);
										 $html .= '<p class="wpfh_obit_date">'.	$birth_date .'' . $death_date . '</p>' . $vet . '</div>';
										 $html = apply_filters('wpfp_main_after_death_date',$html,$r); 
										  
										$html .='<div id="wpfh_main_obit_right">';
										  if (get_option('wpfh_site_type') == 'funeral') {
										$html .='<p><strong>'.__("Service Date","sp-wpfh").':</strong> ' .$burial_date . '</p>';
										  }else{
											$html .='<p><strong>'.__("Burial Date","sp-wpfh").'</strong> ' .$burial_date . '</p>';  
										  }
										 $html = apply_filters('wpfp_main_after_service_date',$html,$r); 
										if($r[0]['obit_notes'] != ''){
										$html.='<p>' . stripslashes($r[0]['obit_notes']) . '</p>';
										}
										 $html = apply_filters('wpfp_main_after_notes',$html,$r); 
										$wpfh_obit_top_right .= apply_filters('wpfh_obit_top_right',$wpfh_obit_top_right,$r);
										if(!is_array($wpfh_obit_top_right)){
										$html .= $wpfh_obit_top_right;	
										}
										$html .='
										
										</div>
										<div style="clear:both"></div>
									</div>';
									
										$wpfh_obit_above_tabs .= apply_filters('wpfh_obit_above_tabs',$wpfh_obit_above_tabs,$r);
										if(!is_array($wpfh_obit_above_tabs)){
										$html .= $wpfh_obit_above_tabs;	
										}
									
									$html .='
									<div id="wpfh-obit-subnav" class="noPrint">
		' . wpfh_share_fb(wpfh_obit_page($_GET['id']), get_real_image_path ( $r[0]['photo'] ) , $name,stripslashes(strip_tags($r[0]['obituary'])),$r ) . '
									'.$print_button.'
									
									'.$wpfh_obit_subnav_items_show.'
									<div style="clear:both"></div>
									</div>';
									
									
		 }
					$above_breadcrumbs  = apply_filters('wpfp_frontend_obit_above_breadcrumbs',$r);				
					if(!is_array($above_breadcrumbs)){
					 $html .=$above_breadcrumbs;	
					}
								if(get_option('wpfh_disable_breadcrumbs') != 1){	
									
									$html .='<p class="noPrint"><a href="'.get_permalink( get_option('wpfh_display_page') ).'?f=obits">'.get_option('wpfh_obit_name_plural').'</a> &raquo; ' . $name . '</p>';
								}
					$below_breadcrumbs  = apply_filters('wpfp_frontend_obit_below_breadcrumbs',$r);				
					
						if(!is_array($below_breadcrumbs)){
					 $html .=$below_breadcrumbs;	
						}
            $html .= $this->tabs($r);
            
            
             $below_tabs  = apply_filters('wpfp_frontend_obit_below_tabs',$r);				
					
					if(!is_array($below_tabs)){
					 $html .=$below_tabs;
					}
            
            //show obit
            if ($_GET['f'] == 'obit' or $_GET['f'] == '') {
				
		
			$obit = apply_filters('the_content',stripslashes($r[0]['obituary'])); 
            
			
				$main_obit_filter  = apply_filters('wpfp_frontend_obit_main_obit',$r);				
					if(!is_array($main_obit_filter)){
					 $html .=$main_obit_filter;	
					}else{
			
			
			    $html .= '										
						' . $obit . '
						';
					}
						
						
            }
    
            if ($_GET['f'] == 'guestbook') {
				
                $html .= $this->posting('guestbook', $r);
            }
            if ($_GET['f'] == 'service' && class_exists('wpfh_cem_user')) {
				 global $wpfh_cem_user;
                 $html .= $wpfh_cem_user->obit_service($r[0]['placeofservice'],$r[0]['service_time']);
            }
             if ($_GET['f'] == 'location' && class_exists('wpfh_cem_user')) {
				 global $wpfh_cem_user;
                 $html .= $wpfh_cem_user->obit_location($r[0]['funeralhome'],$r[0]['visitation_time']);
            }
            
			
			$html = apply_filters('wpfp_frontend_top_obit_content',$html,$r);
            $html .= '
						
						</div>';
            
			}
		
           
        } else {
			
			
			
			
			if($_REQUEST['search-obits'] != ""){
					
					if($_REQUEST['first_name'] != ""){
						$search .=' AND first_name like "%'. $wpdb->escape($_REQUEST['first_name']).'%" ';	
					}
					if($_REQUEST['last_name'] != ""){
						$search .=' AND last_name like "%'. $wpdb->escape($_REQUEST['last_name']).'%" ';	
					}
					if($_REQUEST['date'] != ""){
					$picked_date = strtotime( $wpdb->escape($_REQUEST['date']));
					
				
						
						
						$search .=' AND YEAR(death_date) = YEAR("'. $wpdb->escape($_REQUEST['date']).'") AND MONTH(death_date) = MONTH("'. $wpdb->escape($_REQUEST['date']).'")  ';	
					}
					if($_REQUEST['burial_date'] != ""){
					$picked_date = strtotime( $wpdb->escape($_REQUEST['burial_date']));
					
				
						
						
						$search .=' AND YEAR(burial_date) = YEAR("'. $wpdb->escape($_REQUEST['burial_date']).'") AND MONTH(burial_date) = MONTH("'. $wpdb->escape($_REQUEST['burial_date']).'")  ';	
					}	
			}
			
			
				
			
				
				$search = apply_filters("wpfh_obit_list_query",$search);
			
			
			
			
			$query = "SELECT * FROM  " . $wpdb->prefix . "wpfh_obits WHERE id != '' ".$search."  AND  approved = 1 ORDER  by ".wpfh_order_obits()." desc";
				#echo $query;		
		
			$pagination = new Pagination();
			if (isset($_GET['pagenum'])){   $page = (int) $_GET['pagenum'];}else{ $page = 1; }
			
			if($_REQUEST['search-obits'] != ''){ $search_string .='&search-obits='.$_REQUEST['search-obits'].'';}
			if($_REQUEST['first_name'] != ''){ $search_string .='&first_name='.$_REQUEST['first_name'].'';}
			if($_REQUEST['last_name'] != ''){ $search_string .='&last_name='.$_REQUEST['last_name'].'';}
			if($_REQUEST['date'] != ''){ $search_string .='&date='.$_REQUEST['date'].'';}
			
			$pagination->setLink("".wpfh_obit_page_url('f=obits').$search_string."&pagenum=%s");
			$pagination->setPage($page);
			$pagination->setSize(get_option('wpfh_obit_display_num'));
			$pagination->setTotalRecords(count($wpdb->get_results($query, ARRAY_A)));
	
	
			
			
            $r = $wpdb->get_results("".$query." ".$pagination->getLimitSql()."", ARRAY_A);
            
		
		
			
            $html .= '<div id="wpfh_obits">';
			
				if(get_option('wpfh_enable_search') == 1){
			$html .= $this->search();	
			}
			
			
			if(count($r) == 0){
				$html .= '<div class="wpfh_error">'.sprintf(__("No %s Found","sp-wpfh"),get_option('wpfh_obit_name_plural')).'</div>';
			}else{
			
          
		  $custom_obit_list = apply_filters('wpfp_custom_obit_list', $r);
		  	if( !is_array($custom_obit_list)){
				$html .=  $custom_obit_list;
				
			
			}else{
	
			$above_list .= apply_filters('wpfh_above_obit_list', $above_list,$r,$pagination);
				if( !is_array($above_list)){
				$html .=  $above_list;
				}
							
		    for ($i = 0; $i < count($r); $i++) {
			
				if( $r[$i]['photo']  == ""){ $r[$i]['photo'] =get_option('wpfh_obit_default_pic');}
				
                if ($r[$i]['vet'] == 1) {
                    $class = ' wpfh_obit_vet';
                    $vet   = '<br><div style="text-align:center;font-weight:bold">'.__("Veteran","sp-wpfh").'</div>';
                } else {
                    $vet   = '';
                    $class = '';
                }
                
                if ($r[$i]['maiden'] != "") {
                    $maiden = ' (' . stripslashes($r[$i]['maiden']) . ') ';
                } else {
                    $maiden = '';
                }
              
			
			   if($r[$i]['birth_date'] != '0000-00-00'){
			$birth_date = '' . date_i18n(get_option('date_format') ,strtotime($r[$i]['birth_date'])). ' - ';
			}else{
				$birth_date = '';	
			}
			   if($r[$i]['death_date'] != '0000-00-00'){
			$death_date = '' . date_i18n(get_option('date_format') ,strtotime($r[$i]['death_date'])) . '';
			}else{
				$death_date = '';	
			} 
			
			   if($r[$i]['burial_date'] != '0000-00-00'){
			$burial_date = '' . date_i18n(get_option('date_format') ,strtotime($r[$i]['burial_date'])) . '';
			}else{
				$burial_date = '';	
			} 
			
			
			
		
			
			
			  if(get_option('wpfh_obit_style') == 'block'){
			  //block mode
			    $html .= '<div class="wpfh_obit' . $class . '">							
										<div class="wpfh_obit_image">
										<a href="'.wpfh_obit_page($r[$i]['id']).'"><img src=" ' . content_url() . '/plugins/wp-funeral-press/thumbs.php?src=' .get_real_image_path ( $r[$i]['photo'] ). '&w='.get_option('wpfh_obits_w').'&h='.get_option('wpfh_obits_h').'"></a>' . $vet . '
										</div>
										<div class="wpfh_obit_obit">
										<p class="wpfh_obit_title"><a href="'.wpfh_obit_page($r[$i]['id']).'">' . stripslashes($r[$i]['first_name']) . ' ' . stripslashes($r[$i]['middle']) . ' ' . stripslashes($r[$i]['last_name']) . ' ' . $maiden . '</a></p>
										<p class="wpfh_obit_date">' . $burial_date . '</p>
										' . substr(stripslashes(strip_tags($r[$i]['obituary'])), 0, 250) . '...
										
										</div>
										<div style="clear:both"></div>
										<div class="wpfh_obit_button">
										<a href="'.wpfh_obit_page($r[$i]['id']).'">'.__("View More","sp-wpfh").'</a>
										</div>
									</div>';
									
									
			//end block mode
			
			  }elseif(get_option('wpfh_obit_style') == 'list'){
			//list mode
			  $html .= '<div class="wpfh_obit_list' . $class . '">			
			  				<div class="wpfh_obit_list_name">
							<a href="'.wpfh_obit_page($r[$i]['id']).'">' . stripslashes($r[$i]['first_name']) . ' ' . stripslashes($r[$i]['middle']) . ' ' . stripslashes($r[$i]['last_name']) . ' ' . $maiden . '</a>
							</div>
							
							<div class="wpfh_obit_list_dates">
						<a href="'.wpfh_obit_page($r[$i]['id']).'">' . $burial_date . '</a>
							</div>
			  			
				 <div style="clear:both"></div>
			</div>';
			
			///end list mode	
			 }elseif(get_option('wpfh_obit_style') == 'thumbnails'){
			///thumbnail mode
			
			  $html .= '<div class="wpfh_obit_thumbnail' . $class . '">			
			  				<div class="wpfh_obit_thumbnail_name">
							<a href="'.wpfh_obit_page($r[$i]['id']).'">' . stripslashes($r[$i]['first_name']) . ' ' . stripslashes($r[$i]['middle']) . ' ' . stripslashes($r[$i]['last_name']) . ' ' . $maiden . '</a>
							</div>
							<div class="wpfh_obit_thumbnail_image">
								<a href="'.wpfh_obit_page($r[$i]['id']).'"><img src=" ' . content_url() . '/plugins/wp-funeral-press/thumbs.php?src=' .get_real_image_path ( $r[$i]['photo'] ). '&w='.get_option('wpfh_obits_w').'&h='.get_option('wpfh_obits_h').'"></a>
							</div>
							<div class="wpfh_obit_thumbnail_dates">
						<a href="'.wpfh_obit_page($r[$i]['id']).'">' . $burial_date . '</a>
							</div>
			  			
				 <div style="clear:both"></div>
			</div>';
			
			
			// end thumnail mode	 
			 }
			
								
            }
			}
			}
		
			$html .= $pagination->create_links();
            $html .= '</div>';
            
        }
	
        return $html;
        
    }
    
    function posting($type, $obit)
    {
        global $wpdb, $current_user;
        $f = $_GET['f'];
        $r = $wpdb->get_results("SELECT * FROM  " . $wpdb->prefix . "wpfh_posts where oid =  " . $wpdb->escape($_GET['id']) . "   and approved = 1 order by date desc", ARRAY_A);
        
      
        if ($_GET['n'] == 'add') {
            //add post	
            
			
			if(get_option('wpfh_allow_guests')!= 1){
		
            //check to see if logged in
            wpfh_login();	
				
			}
			
		
            //continue
            
            
            
            switch ($f) {
                
                case "guestbook":
                    
                    if ($_POST['save-post'] != "") {
						
						
					if(get_option('wpfh_recaptcha') == 1 && get_option('wpfh_recaptcha_private_key') != ''){	
				
						 $privatekey = get_option('wpfh_recaptcha_private_key');
 				 $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

			  if (!$resp->is_valid && $current_user->ID == '') {
				// What happens when the CAPTCHA was entered incorrectly
				$error = '<div class="wpfh_error">'.__('Please type the correct security code.',"sp-wpfh").'</div>';
			  }

					}
						
					
						if(	$error == '' && get_option('wpfh_disable_guestbook') != 1){
						
						$mode = $_POST['mode'];
                        
						switch($mode){
							case"guestbook":
							$insert['type'] = 'guestbook';
							$insert['content']   = sanitize_text_field( $_POST['message']);
							break;
							
							case "photo":
							$insert['type'] = 'photo';
							
								if($_FILES['photo']['name'] != ""){			
								$photo = wp_upload_bits($_FILES['photo']["name"], null, file_get_contents($_FILES['photo']["tmp_name"]));		
								$photo['desc'] = sanitize_text_field($_POST['photo-message']);								
								$insert['content'] = 	serialize($photo);	
								}	
								
							break;
							
							case"youtube":
							$insert['type'] = 'youtube';
								$youtube['url'] = sanitize_text_field($_POST['youtube']);
								$youtube['desc'] = sanitize_text_field($_POST['youtube-message']);
							$insert['content']   = serialize($youtube);
							break;
						}
						
						if($_POST['guest-name'] != ''){
							$insert['name'] = sanitize_text_field($_POST['guest-name']);
							$insert['email'] = sanitize_email($_POST['guest-email']);
							$insert['uid'] = 0;
						}else{
                        $insert['uid']       = $current_user->ID;
						}
						
						
						
                        $insert['oid']       = intval( $_GET['id']);
                       
                        $insert['date']      = time();
						
						if(get_option('wpfh_auto_approve_guestbook') == 1){
						$insert['approved']  = 1;	
						}else{
						$insert['approved']  = 0;	
						}
                        
                        $insert['anonymous'] =  intval($_POST['anonymous']);
                        
						$insert = apply_filters('wpfh_tabs_save',$insert);
						
                        $wpdb->insert("" . $wpdb->prefix . "wpfh_posts", $insert);
						
						$insert_id = $wpdb->insert_id;
						
						do_action("wpfh_user_posting_add",$insert_id);
					
						 
						if($insert['name'] != ''){
						$name_to = $insert['name'];	
						
						}else{
						$name_to = ''.$this->postedBy($insert['uid'],'display_name').'';
						}
						if($insert['email'] != ''){
						$email_to = $insert['email'];	
						
						}else{
						$name_to = ''.$current_user->user_email.'';
						}
						
						
						if(get_option('wpfh_email_user') != ""){
						$email_content = str_replace("[obit]",''.$this->postedOn($insert['oid'] ,'first_name').' '.$this->postedOn($insert['oid'],'last_name').'',stripslashes(get_option('wpfh_email_user')));
						$email_content = str_replace("[link]",''. wpfh_obit_page($insert['oid'],'guestbook').'', $email_content);
						$email_content = str_replace("[user]",''.$name_to.'',$email_content);
						if(stripslashes(get_option('wpfh_email_user_cc')) != ''){
						$headers .=  'Cc: '.get_option('wpfh_email_user_cc').'' . "\r\n";
						}
						
						wpfh_email(	$email_to ,stripslashes(get_option('wpfh_email_user_subject')),$email_content,$headers );
						unset($email_content);
						}
						
						if(get_option('wpfh_email_admin') != ""){
						$email_content = str_replace("[obit]",''.$this->postedOn($insert['oid'] ,'first_name').' '.$this->postedOn($insert['oid'],'last_name').'',stripslashes(get_option('wpfh_email_admin')));
						$email_content = str_replace("[link]",''. wpfh_obit_page($insert['oid'],'guestbook').'', $email_content);
						$email_content = str_replace("[user]",''.$name_to.'',$email_content);
						$email_content = str_replace("[approve_link]",''.get_settings('siteurl').'/wp-admin/admin.php?page=wpfh-guestbook',$email_content);
						
						if(stripslashes(get_option('wpfh_email_admin_cc')) != ''){
						$headers .=  'Cc: '.get_option('wpfh_email_admin_cc').'' . "\r\n";
						}
					
						wpfh_email(wpfh_admin_email(),stripslashes(get_option('wpfh_email_admin_subject')),$email_content ,$headers);
						unset($email_content);
						}
						
						
						
						
                      wpfh_redirect(''.wpfh_obit_page($_GET['id'],'guestbook','n=add&thankyou=1').'');
						
						}else{
						$html .= $error;	
						}
                    }
					
					
                    if ($_GET['thankyou'] == 1) {
                      
					  	if(get_option('wpfh_auto_approve_guestbook') == 1){
						   $html .= '<div class="wpfh_modal">
								<a href="'.wpfh_obit_page($_GET['id'],'guestbook').'">'.sprintf(__("Thank you for adding your message, your message show up right away on  %s's ".wpfh_gb_word()." page. Click here to return to the previous page.","sp-wpfh"),$obit[0]['first_name'] ).'</a>
								</div>';
						}else{
						   $html .= '<div class="wpfh_modal">
								<a href="'.wpfh_obit_page($_GET['id'],'guestbook').'">'.sprintf(__("Thank you for adding your message, your message is now awaiting approval. Once approved you will receive an email and the message will appear on %s's ".wpfh_gb_word()." page. Click here to return to the previous page.","sp-wpfh"),$obit[0]['first_name'] ).'</a>
								</div>';	
						}
                        
					  
					 
                        
                    } else {
						
				if(!is_user_logged_in()  && get_option('users_can_register') == 1){
					
					$html .='<p><strong>'.__('You are currently posting as a guest, if you would like to register',"sp-wpfh").' <a href="'.wp_login_url( $_SERVER['REQUEST_URI']  ).'">'.__('Click here',"sp-wpfh").'</a></strong></p>';
					
				  }
					
					
							if(get_option('wpfh_allow_guests')!= 1 ){
		
            //check to see if logged in
            wpfh_login();	
				
		}
                        $html .= '<div class="wpfh_modal"><form action="" method="post"  enctype="multipart/form-data" class="wpfh_upload_form">';
						
						
								if(!is_user_logged_in()){
				
				
			
			$html .= '<div id="wpfh_guest_info">
			
				<p><label >'.__("Name","sp-wpfh").':</label> <input type="text" name="guest-name" id="guest_name" class="required" value="'.$_POST['guest-name'].'"></p>
			    <p><label >'.__("Email","sp-wpfh").':</label> <input type="text" name="guest-email" id="guest_email"  class="required" value="'.$_POST['guest-email'].'"></p>
			
			</div>';
			}
	
							
							
							$html .='<div id="wpfh_message_icons">
	<a href="javascript:wpfh_message_button(\'wpfh_message_button\');" class="wpfh_message_button selected"><img src=" ' . content_url() . '/plugins/wp-funeral-press/images/comment.png"> '.__("Message","sp-wpfh").'</a>  
	';
	if(class_exists('wpfh_cem_user')){	
	$html .='<a href="javascript:wpfh_message_button(\'wpfh_photo_button\');" class="wpfh_photo_button"><img src=" ' . content_url() . '/plugins/wp-funeral-press/images/picture.png"> '.__("Photo","sp-wpfh").'</a>  
	<a href="javascript:wpfh_message_button(\'wpfh_youtube_button\');" class="wpfh_youtube_button"><img src=" ' . content_url() . '/plugins/wp-funeral-press/images/youtube.png"> '.__("Youtube","sp-wpfh").'</a>';
	
	
							$extra_tabs = '';
							$exra_tabs .= apply_filters('wpfh_posting_tabs',$extra_tabs);
							$html .= $exra_tabs;
	}
		
	
		
		
		
			
				
				
	$html .='
	<div style="clear:both"></div></div>
							
							<input type="hidden" name="mode"  id="wpfh_mode" value="guestbook">
							<div class="wpfh_message_form_fields wpfh_message_button_form">
							<p><strong>'.sprintf(__("Leave a message or tribute.","sp-wpfh"),$obit[0]['first_name']).'</strong></p>
							<div class="wpfh_message_form_holder">
							<textarea name="message" style="width:98%;height:170px" id="wpfh_message_textarea">'.$_POST['message'].'</textarea>
							</div>
							</div>
							 
							<div class="wpfh_message_form_fields wpfh_photo_button_form" style="display:none">
							<p><strong>'.__("Upload your photo","sp-wpfh").'</strong></p>
							<div  class="wpfh_message_form_holder">
							
							'.__("Photo","sp-wpfh").': <input type="file" name="photo" id="wpfh_message_file"><br>
							<br />
'.__("Write something about this photo","sp-wpfh").'
							<textarea style="width:100%;height:70px" name="photo-message">'.$_POST['photo-message'].'</textarea>
							</div>
							</div>
							
							<div class="wpfh_message_form_fields wpfh_youtube_button_form"  style="display:none">
							<p><strong>'.__("Put the full youtube link below","sp-wpfh").'</strong></p>
							<div class="wpfh_message_form_holder">
							
							'.__("Youtube Link","sp-wpfh").': <em>example: http://www.youtube.com/watch?v=cEhzmhx9jt8</em><input type="text" name="youtube" style="width:95%" id="wpfh_message_youtube" value="'.$_POST['youtube'].'">			<br />
'.__("Write something about this video","sp-wpfh").'
							<textarea style="width:100%;height:70px" name="youtube-message">'.$_POST['youtube-message'].'</textarea>

							</div>
							</div>';
							
							$extra_tabs_content = '';
							$extra_tabs_content .= apply_filters('wpfh_posting_content_tab',$extra_tabs_content);
							$html .= $extra_tabs_content;
							
							$html.='
							
							<p style="font-size:16px"><input type="checkbox" name="anonymous" value="1"> '.__("Check to hide your name","sp-wpfh").'</p>';
						
							$buttons .='';
							$buttons .= apply_filters('wpfh_guestbook_posting_fields', $buttons);
							if($buttons != ''){
							$html .= $buttons;
							}
							
					if(get_option('wpfh_recaptcha') == 1 && get_option('wpfh_recaptcha_public_key') != '' && !is_user_logged_in()){
				  $publickey = get_option('wpfh_recaptcha_public_key'); 
				 $captcha =  '<p>'.recaptcha_get_html($publickey).'</p>';
				 
				}else{
				 $captcha  = '';	
				}
							$html .='	
							<div style="text-align:right">'. $captcha .'<input type="submit" name="save-post" value="'.__("Add Message","sp-wpfh").'" style="font-size:1.0em"></div>
							
							
							</form></div>';
                    }
                    
                    break;
                    
            }
            
            
            
            
            
            
            
            
        } else {
            //list postings	
            
            if (count($r) == 0) {
                //no posts exist
				if( $obit[0]['photo']  == ""){ $obit[0]['photo'] =get_option('wpfh_obit_default_pic');}	
                $html .= '<div class="wpfh_modal">
								<a href="'.wpfh_obit_page($_GET['id'],'guestbook','n=add').'">';
								if(get_option('wpfh_gb_no_posts') == ''){
								$html .=''.sprintf(__("%s Does not have any %s posts. Be the first to add one by clicking here.","sp-wpfh"),$obit[0]['first_name'],$type).'';
								}else{
								$html .= get_option('wpfh_gb_no_posts');	
								}
								
					
								$html .='</a></div>';
                
            } else {
                //display postings		
                
                
                switch ($f) {
                    
                    case "guestbook":
                        $html .='<div style="margin:5px;font-size:1.3em;">
						<a href="'.wpfh_obit_page($_GET['id'],'guestbook','n=add').'">
						<img src="' . content_url() . '/plugins/wp-funeral-press/images/add.png"> '.__("Add A Message","sp-wpfh"). '
						</a></div>';
                        for ($i = 0; $i < count($r); $i++) {
                            $user_data = get_userdata($r[$i]['uid']);
                           
						    if ($r[$i]['uid'] == 0) {
                                $posting_name = ''.$r[$i]['name'].'';
                            } else {
                                $posting_name = '' . $user_data->user_nicename . '';
                            }
							
							
							
							
							
							 if ($r[$i]['anonymous'] == 1) {
							 $posting_name = ''.__("Anonymous","sp-wpfh").''; 
							 }
                            $html .= '<div class="wpfh_posting">
												<div class="wpfh_posting_left">
												<p><strong>'.__("Posted by","sp-wpfh").':</strong> <br />
' . $posting_name . '</p>
												<p><em><strong>'.__("Posted on","sp-wpfh").':</strong><br />
 ' . date_i18n(get_option('date_format') , $r[$i]['date']). '</em></p>
												</div>
												<div class="wpfh_posting_right">';
												
											
											
												if($r[$i]['type'] == 'guestbook'){
												$html .='' . stripslashes($r[$i]['content']) . '';	
												}
												
												
												if($r[$i]['type'] == 'photo'){
												unset($photo);
												$photo = unserialize(stripslashes($r[$i]['content']));	
											
												$html .='<img src="'.$photo['url'].'" /><p>'.$photo['desc'].'</p>';	
												}
												
												
												
												if($r[$i]['type'] == 'youtube'){
														unset($youtube);
												$youtube = unserialize(stripslashes($r[$i]['content']));	
														
														$html .= $this->youtube($youtube['url']);
														$html .='<p>'.$youtube['desc'].'</p>';
												}
												
												
												$custom_tab_type = '';
												$custom_tab_type .= apply_filters('wpfh_custom_tab_guestbook_view',$custom_tab_type,$r,$i);
												$html .=$custom_tab_type;
												
												$html .='</div>
												<div style="clear:both"></div>
									
											</div>';
                            unset($user_data);
                        }
                        
                        break;
                        
                       
  
                        
                }
            }
            
            
        }
        
        
        
        return $html;
        
    }
    function tabs($r)
    {
		global $wpdb;
        $id = $_GET['id'];
        $f  = $_GET['f'];
        if ($f == 'obit' or $f == "") {
            $obitselected = ' id="current" ';
        }
        if ($f == 'guestbook') {
            $guestbookselected = ' id="current" ';
        }
        if ($f == 'photoalbum') {
            $photoalbumselected = ' id="current" ';
        }
        if ($f == 'tributes') {
            $tributeselected = ' id="current" ';
        }
        $html .= '<div id="wpfh-header" class="noPrint">
  <ul>
    <li ' . $obitselected . '><a href="'.wpfh_obit_page( $id).'">'.get_option('wpfh_obit_name').'</a></li>';
	if(get_option('wpfh_disable_guestbook') != 1){
		
		if(get_option('wpfh_guestbook_post_count') == 1){
	
		 $r_count = $wpdb->get_results("SELECT * FROM  " . $wpdb->prefix . "wpfh_posts where oid =  " . $wpdb->escape($_GET['id']) . "   and approved = 1 order by date desc", ARRAY_A);	
			if(count($r_count) == 0  ){
			 $r_count_text = ''.wpfh_gb_word().'';	
			}else{
			 $r_count_text = ''.wpfh_gb_word(1).' ('.count($r_count).') ';	
			}
			
		}else{
			$r_count_text = ''.wpfh_gb_word().'';
		}
   $html .=' <li ' . $guestbookselected . '><a href="'.wpfh_obit_page($_GET['id'],'guestbook').'">'.$r_count_text .'</a></li>';
	}
 
 if(class_exists('wpfh_cem_user')){	
	
	global $wpfh_cem_user;	
	$html .= $wpfh_cem_user->user_menu();
	 
 }
 if(get_option('wpfh_order_flowers') != ""){
	 $html .=' <li ><a href="'.get_option('wpfh_order_flowers').'" target="_blank">'.__("Order Flowers","sp-wpfh").'</a></li>';
	 
 }
 $additional_menu_items = apply_filters('wpfp_frontend_obit_menu', $additional_menu_items);

  $html .=''. $additional_menu_items.'';
 
  $html .='</ul>
  <div  class="wpfh-clear"></div>
  
</div>';
        if(current_user_can('manage_options')){
	 $html .=' <div style="padding:5px;text-align:right"><a class="button" href="'.admin_url( 'admin.php?page=wpfh&function=edit&id='.$_GET['id'].'' ).'" >'.__("Admin Edit Obit","sp-wpfh").'</a></div>';
	 
 }   
        return $html;
        
    }
    
    function id(){
	    global $post;
echo $post->ID;	
	}
    function inject()
    {
        global $wpdb;
        global $post;

        
        $post_data = get_post($post->ID, ARRAY_A);
        
        
        if ($post_data['ID'] == get_option('wpfh_display_page')) {
            return $this->view();
        } else {
			$content = $post->post_content;
			
			$content = str_replace(']]>', ']]&gt;', $content);
			
            return wpautop($content);
        }
    }
    
   function remove_title(){
	 global $wpdb;
	     $post_data = get_post($post->ID, ARRAY_A);
	   if ($post_data['ID'] == get_option('wpfh_display_page')) {
          	return ' ';   
        } else {
            return $post_data['the_title'];
        }
	 

   }
   

}


$wpfh_user_obits = new wpfh_user_obits;

echo $wpfh_user_obits->id();
if ($_GET['id'] != "") {
    add_filter('wp_title', array(
        $wpfh_user_obits,
        'obitName'
    ));
}


add_shortcode( 'funeralpress',  array($wpfh_user_obits, 'view') );	
add_action( 'wp_head',  array($wpfh_user_obits, 'go_meta') );	
?>
<?php 

$wpfh_tools = new wpfh_tools;


add_action('wpfh_settings_submenu', array($wpfh_tools ,'top_menu'));
add_action('wpfh_tools', array($wpfh_tools ,'change_url_tool'));


    add_action('admin_menu', array(
        $wpfh_tools,
        'menu'
    ));
class wpfh_tools{
	
	
	
	
	function __construct(){
		
	
	}
	
	function menu(){
		    add_submenu_page('wpfu', 'Tools', 'Tools', 'wpfh_manage_settings', 'wpfh-tools', array(
            $this,
            'view'
        ));
	}
	
	function top_menu($settings_submenu_items){
		$settings_submenu_items .='<li><a href="admin.php?page=wpfh-tools">'.__("Tools","sp-wpfh").'</a></li>';
		
		return $settings_submenu_items;
	}
	
	function view(){
		global $wpdb;
		global $wpdb, $current_user;
        echo wpfh_install::topMenu('', $submenu);
		
		do_action('wpfh_tools');
	}
	
	function change_url_tool(){
		
		global $wpdb;
		
		
		if($_POST['change_url'] != ''){
		
		echo '<div style="width:400px;background-color:#FFF;padding:10px;margin:10px;height:200px;overflow-y: scroll;overflow-x: hidden;">';
		if($_POST['old_url'] != '' && $_POST['new_url'] != ''){
			
		echo 1;
				
				/*
				$postings = $wpdb->get_results("SELECT * FROM  " . $wpdb->prefix . "wpfh_posts", ARRAY_A);
		
					for($i=0; $i<count(	$postings ); $i++){
					
						$content = unserialize(stripslashes($postings[$i]['content']));	
					
					
						if (strpos( $content['url'],$_POST['old_url']) !== false) {
				
						$content['url'] = str_replace($_POST['old_url'], $_POST['new_url'], $content['url']);
						$update['content'] =  serialize($content);
						
						
						$where['id'] = $postings[$i]['id'];						
						echo 'Updated Post: '.$postings[$i]['id'].'<br>';
						$wpdb->update("".$wpdb->prefix ."wpfh_posts", $update,$where);
						unset($update);unset($content);unset($where);
						}
				}
				*/
				$obits = $wpdb->get_results("SELECT * FROM  " . $wpdb->prefix . "wpfh_obits where photo like '%".$wpdb->escape($_POST['old_url'])."%'", ARRAY_A);
				echo "SELECT * FROM  " . $wpdb->prefix . "wpfh_obits where photo like '%".$wpdb->escape($_POST['old_url'])."%'";
				echo count($obits).' Obits synced';
				for($i=0; $i<count(	$obits); $i++){
					if (strpos($obits[$i]['photo'],$_POST['old_url']) !== false) {
					$update['photo'] = str_replace($_POST['old_url'], $_POST['new_url'], $obits[$i]['photo']);	
					$where['id'] = $obits[$i]['id'];
					
					echo 'Updated Obit: '.$obits[$i]['first_name'].' '.$obits[$i]['last_name'].'<br>';
					$wpdb->update("".$wpdb->prefix ."wpfh_obits", $update,$where);
					unset($update);unset($content);unset($where);
					}
				}
				echo '<div style="color:green">Finished!</div>';
		}
		echo '</div>';	
		}
	echo '<h2>URL Tool</h2>
		<p>This tool will allow you to update guestbook URLs and obit photo urls to your new url. Only use this tool if you have migrated your platform to a new url. This is a traditional search and replace so please use exactly what you want to replace. Please note the example below. This will replace both obit photos and guestbook photos!</p>
		<form action="admin.php?page=wpfh-tools" method="post">
		 <table class="wp-list-table widefat fixed posts" cellspacing="0">
		 <tr>
		 <td width="100">Old URL:</td>
		 <td>   <input type="text" name="old_url" value="'.$_POST['old_url'].'"> <em>Example: beta.myfuneralsite.com</em></td>
		</tr>
		<tr>
		 <td width="100">New URL:</td>
		 <td>   <input type="text" name="new_url" value="'.$_POST['new_url'].'"> <em>Example: www.myfuneralsite.com</em></td>
		</tr>
			<tr>
		 <td width="100"></td>
		 <td>   <input type="submit" name="change_url" value="Change URLs!"></td>
		</tr>
		</form>';
		
		
	}
}

?>
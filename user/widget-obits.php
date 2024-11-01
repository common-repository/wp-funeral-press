<?php
add_action('widgets_init',
     create_function('', 'return register_widget("wpfh_widget_obits");')
);
class wpfh_widget_obits extends WP_Widget{
	

	function __construct() {
		parent::__construct(
			'wpfh_obit_widget', // Base ID
			__('FuneralPress Latest Obits', 'sp-wpfh'), // Name
			array( 'description' => __( 'Displays the latest obits.', 'sp-wpfh' ), ) // Args
		);
	}

	
	public function widget( $args, $instance ) {
		global $wpdb;
		$data =  $instance ;
		echo $args['before_widget'];
		if ( ! empty($data['wpfh_search_title']) ){
		echo $args['before_title'] . $data['wpfh_search_title']. $args['after_title'];
		}
		
		
		
		$atts['style'] = $data['option2'];
		$atts['howmany'] = $data['option3'];
		
		
		if($data['option1'] != ""){
			
		echo '<h1 class="widget-title">	'.$data['option1'].'</h1><div class="'. $data['option5'].'">';
		}
		if($atts['howmany'] != ""){
			$limit = $atts['howmany'];
			}else{
			$limit = get_option('wpfh_obit_display_num');
			}
			
			
			$query = "SELECT * FROM  " . $wpdb->prefix . "wpfh_obits WHERE id != '' ".$search."  AND  approved = 1 ORDER  by ".wpfh_order_obits()." desc limit ".$limit."";
			$r = $wpdb->get_results($query, ARRAY_A);
           
		     $custom_obit_widget_list = apply_filters('wpfp_custom_obit_widget_list', $r);
		  	if( !is_array($custom_obit_widget_list)){
				$html .= $custom_obit_widget_list;
			}else{
		   
		   
		    
		         for ($i = 0; $i < count($r); $i++) {
					 
					 	if( $r[$i]['photo']  == ""){ $r[$i]['photo'] =get_option('wpfh_obit_default_pic');}
				
                if ($r[$i]['vet'] == 1) {
                    $class = ' wpfh_obit_vet';
                    $vet   = '<br><div style="text-align:center;font-weight:bold">Veteran</div>';
                } else {
                    $vet   = '';
                    $class = '';
                }
                
                if ($r[$i]['maiden'] != "") {
                    $maiden = ' (' . stripslashes($r[$i]['maiden']) . ') ';
                } else {
                    $maiden = '';
                }
              
			
				
			if($r[$i]['birth_date'] != "0000-00-00"  ){
			$birth_date = '' .  date_i18n(get_option('date_format') ,strtotime( $r[$i]['birth_date'])) . ' - ';
			}else{
			$birth_date = '';	
			}
			if($r[$i]['death_date'] != "0000-00-00"  ){
			$death_date = '' .  date_i18n(get_option('date_format') ,strtotime( $r[$i]['death_date'])) . ' - ';
			}else{
			$death_date = '';	
			}
			if($r[$i]['burial_date'] != "0000-00-00"  ){
			$burial_date = '' .  date_i18n(get_option('date_format') ,strtotime( $r[$i]['burial_date'])) . '';
			}else{
			$burial_date = '';	
			}
			
			
			
			  if(  $atts['style'] == 'block' or   $atts['style'] == ''){
			  //block mode
			    $html .= '<div class="wpfh_obit' . $class . '">							
										<div class="wpfh_obit_image">
										<a href="'.wpfh_obit_page($r[$i]['id']).'"><img src=" ' . content_url() . '/plugins/wp-funeral-press/thumbs.php?src=' .get_real_image_path ( $r[$i]['photo'] ). '&w='.get_option('wpfh_obitw_w').'&h='.get_option('wpfh_obitw_h').'"></a>' . $vet . '
										</div>
										<div class="wpfh_obit_obit">
										<p class="wpfh_obit_title"><a href="'.wpfh_obit_page($r[$i]['id']).'">' . stripslashes($r[$i]['first_name']) . ' ' . stripslashes($r[$i]['middle']) . ' ' . stripslashes($r[$i]['last_name']) . ' ' . $maiden . '</a></p>
										<p class="wpfh_obit_date">'.$burial_date   . '</p>
										' . substr(stripslashes(strip_tags($r[$i]['obituary'])), 0, 250) . '...
										<div class="wpfh_obit_button">
										<a href="'.wpfh_obit_page().'">'.__("View More","sp-wpfh").'</a>
										</div>
										</div>
										<div style="clear:both"></div>
									</div>';
									
									
			//end block mode
			
			  }elseif(  $atts['style'] == 'list'){
			//list mode
			  $html .= '<div class="wpfh_obit_list' . $class . '">			
			  				<div class="wpfh_obit_list_name">
							<strong><a href="'.wpfh_obit_page($r[$i]['id']).'">' . stripslashes($r[$i]['first_name']) . ' ' . stripslashes($r[$i]['middle']) . ' ' . stripslashes($r[$i]['last_name']) . ' ' . $maiden . '</a></strong>
							</div>
							
							<div class="wpfh_obit_list_dates">
						<a href="'.wpfh_obit_page($r[$i]['id']).'">'.$burial_date   . '</a>
							</div>
			  			
				 <div style="clear:both"></div>
			</div>';
			
			///end list mode	
			 }elseif(  $atts['style'] == 'thumbnails'){
			///thumbnail mode
			
			  $html .= '<div class="wpfh_obit_thumbnail' . $class . '">			
			  				<div class="wpfh_obit_thumbnail_name">
							<strong><a href="'.wpfh_obit_page($r[$i]['id']).'">' . stripslashes($r[$i]['first_name']) . ' ' . stripslashes($r[$i]['middle']) . ' ' . stripslashes($r[$i]['last_name']) . ' ' . $maiden . '</a></strong>
							</div>
							<div class="wpfh_obit_thumbnail_image">
								<a href="'.wpfh_obit_page($r[$i]['id']).'"><img src=" ' . content_url() . '/plugins/wp-funeral-press/thumbs.php?src=' .get_real_image_path ( $r[$i]['photo'] ). '&w='.get_option('wpfh_obitw_w').'&h='.get_option('wpfh_obitw_h').'"></a>
							</div>
							<div class="wpfh_obit_thumbnail_dates">
						<a href="'.wpfh_obit_page($r[$i]['id']).'">' .$burial_date   . '</a>
							</div>
			  			
				 <div style="clear:both"></div>
			</div>';
			
			
			// end thumnail mode	 
			 }elseif(  $atts['style'] == 'none'){
			///thumbnail mode
				if($r[$i]['vet'] == 1){
				$vetclass= 'class="wpfh_vet_list" ';	
				}else{
				$vetclass= ' ';	
				}
			  $html .= '<ul '.$vetclass.'>			
			  			';
						if($data['option4'] ==1){
						
						$html .='	<li><a href="'.wpfh_obit_page($r[$i]['id']).'"><img src=" ' . content_url() . '/plugins/wp-funeral-press/thumbs.php?src=' .get_real_image_path ( $r[$i]['photo'] ). '&w='.get_option('wpfh_obitw_w').'&h='.get_option('wpfh_obitw_h').'"></a>
							</li>';
						}
						$html .='
							<li><span><a href="'.wpfh_obit_page($r[$i]['id']).'">' . stripslashes($r[$i]['first_name']) . ' ' . stripslashes($r[$i]['middle']) . ' ' . stripslashes($r[$i]['last_name']) . ' ' . $maiden . '</a></span><a href="'.wpfh_obit_page($r[$i]['id']).'">' .$burial_date   . '</a></li>
						
			  			<li style="clear:both"></li>
			
			</ul>';
			
			
			// end thumnail mode	 
			 }
			
			 }
			
								
            }
			
         
		$html .='<div style="clear:both"></div><div style="text-align:right"><a href="'.wpfh_obit_page().'">'.__("View More","sp-wpfh").'</a></div></div>';
		echo  $html;
	
	
	
	
	
	
	
		echo $args['after_widget'];
	}


	public function form( $instance ) {
		$data =  $instance;
	
		
		if($data['option4'] == 1){ $checked1 = 'checked="checked"'; }
		
		
		  echo '<label>'.__("Title","sp-wpfh").'</label>
		   <input id="'.$this->get_field_id( 'option1' ).'" name="'.$this->get_field_name( 'option1' ).'"  type="text" value="'.esc_attr($data['option1']).'" /></p>
		  		<p><label>'.__("Text before the form","sp-wpfh").'</label>';
				
				echo ' <select id="'.$this->get_field_id( 'option2' ).'" name="'.$this->get_field_name( 'option2' ).'" >';
				 if($data['option2'] != ""){
				  echo '<option value="'.$data['option2'].'" selected="selected">'.$data['option2'].'</option>';
				  }
				  echo '<option value="list">'.__("List","sp-wpfh").'</option><option value="thumbnails">'.__("Thumbnails","sp-wpfh").'</option><option value="block">'.__("Blocks","sp-wpfh").'</option><option value="none">'.__("Non Formated Ordered List","sp-wpfh").'</option></select></p>';
				  
				echo '<p><label>'.__("How many to display?","sp-wpfh").' </label>
					<input id="'.$this->get_field_id( 'option3' ).'" name="'.$this->get_field_name( 'option3' ).'"  type="text" value="'.esc_attr($data['option3']).'" /></p>
					
					<p><label>'.__("Show thumbnail?","sp-wpfh").'</label>
				<input id="'.$this->get_field_id( 'option4' ).'" name="'.$this->get_field_name( 'option4' ).'"  type="checkbox" value="1" '.$checked1.'  /></p>
				<p><label>'.__("Special Class","sp-wpfh").' </label>
					<input id="'.$this->get_field_id( 'option5' ).'" name="'.$this->get_field_name( 'option5' ).'"  type="text" value="'.esc_attr($data['option5']).'" /></p>
		  		';
	
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		//print_r($new_instance);
		//print_r($old_instance);
		$instance['option1'] = ( ! empty( $new_instance['option1'] ) ) ? strip_tags( $new_instance['option1'] ) : '';
		$instance['option2'] = ( ! empty( $new_instance['option2'] ) ) ? strip_tags( $new_instance['option2'] ) : '';
		$instance['option3'] = ( ! empty( $new_instance['option3'] ) ) ? strip_tags( $new_instance['option3'] ) : '';
		$instance['option4'] = ( ! empty( $new_instance['option4'] ) ) ? strip_tags( $new_instance['option4'] ) : '';
		$instance['option5'] = ( ! empty( $new_instance['option5'] ) ) ? strip_tags( $new_instance['option5'] ) : '';
		//print_r($instance);exit;

		return $instance;
	}

}
?>
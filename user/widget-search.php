<?php
add_action('widgets_init',
     create_function('', 'return register_widget("wpfh_widget_search");')
);
class wpfh_widget_search extends WP_Widget{
	

	function __construct() {
		parent::__construct(
			'wpfh_search_widget', // Base ID
			__('FuneralPress Search Widget', 'sp-wpfh'), // Name
			array( 'description' => __( 'Displays a search widget', 'sp-wpfh' ), ) // Args
		);
	}

	
	public function widget( $args, $instance ) {
		
		$data =  $instance ;
		echo $args['before_widget'];
		if ( ! empty($data['wpfh_search_title']) )
		echo $args['before_title'] . $data['wpfh_search_title']. $args['after_title'];
	
	
	 $custom_search_widget = apply_filters('wpfp_search_widget',$data);
  if( !is_array($custom_search_widget))
  {
   $html .= $custom_search_widget;
   return $html;
  }
 
  
  else
  {
  
   if($data['wpfh_search_text'] != ""){echo '<p>'.$data['wpfh_search_text'].'</p>';}
     
   echo'<div id="wpfh_search_widget"><form action="'.wpfh_obit_page().'" method="post">';
    
    if($data['wpfh_search_fn'] == 1){
    echo '<label>'.__("First Name","sp-wpfh").':</label> <input type="text" name="first_name">'; 
    }
    if($data['wpfh_search_ln'] == 1){
    echo '<label>'.__("Last Name","sp-wpfh").':</label> <input type="text" name="last_name">'; 
    }
    if($data['wpfh_search_bd'] == 1){
    echo '<label>'.__("Death Date","sp-wpfh").':</label> <input type="text" name="date" class="datepicker">'; 
    }
      
	     echo '<div style="text-align:left;padding-top:6px;clear:both"><input type="submit" name="search-obits" value="'.__("Search","sp-wpfh").'"></div>
     
    </form></div>';
  }
	
	
	
	
	
		echo $args['after_widget'];
	}


	public function form( $instance ) {
		$data =  $instance;
	
		
		 if($data['wpfh_search_fn'] == 1){ $checked1 = 'checked="checked"'; }
		  if($data['wpfh_search_ln'] == 1){ $checked2 = 'checked="checked"'; }
		   if($data['wpfh_search_bd'] == 1){ $checked3 = 'checked="checked"'; }
		 
		  echo '<label>'.__("Title","sp-wpfh").'</label>
		   <input id="'.$this->get_field_id( 'wpfh_search_title' ).'" name="'.$this->get_field_name( 'wpfh_search_title' ).'"  type="text" value="'.esc_attr($data['wpfh_search_title']).'" /></p>
		  		<p><label>'.__("Text before the form","sp-wpfh").'</label>
				<input id="'.$this->get_field_id( 'wpfh_search_text' ).'" name="'.$this->get_field_name( 'wpfh_search_text' ).'"  type="text" value="'.esc_attr($data['wpfh_search_text']).'" /></p>
				<p><label>'.__("Enable First Name Field?","sp-wpfh").'</label>
				<input id="'.$this->get_field_id( 'wpfh_search_fn' ).'" name="'.$this->get_field_name( 'wpfh_search_fn' ).'"  type="checkbox" value="1" '.$checked1.'  /></p>
				<p><label>'.__("Enable Last Name Field?","sp-wpfh").'</label>
				<input id="'.$this->get_field_id( 'wpfh_search_ln' ).'" name="'.$this->get_field_name( 'wpfh_search_ln' ).'"  type="checkbox" value="1"'.$checked2.' /></p>
				<p><label>'.__("Enable Burial Date Field?","sp-wpfh").'</label>
				<input id="'.$this->get_field_id( 'wpfh_search_bd' ).'" name="'.$this->get_field_name( 'wpfh_search_bd' ).'"  type="checkbox" value="1"  '.$checked3.'/></p>
		  		';
	
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		//print_r($new_instance);
		//print_r($old_instance);
		$instance['wpfh_search_title'] = ( ! empty( $new_instance['wpfh_search_title'] ) ) ? strip_tags( $new_instance['wpfh_search_title'] ) : '';
		$instance['wpfh_search_text'] = ( ! empty( $new_instance['wpfh_search_text'] ) ) ? strip_tags( $new_instance['wpfh_search_text'] ) : '';
		$instance['wpfh_search_fn'] = ( ! empty( $new_instance['wpfh_search_fn'] ) ) ? strip_tags( $new_instance['wpfh_search_fn'] ) : '';
		$instance['wpfh_search_ln'] = ( ! empty( $new_instance['wpfh_search_ln'] ) ) ? strip_tags( $new_instance['wpfh_search_ln'] ) : '';
		$instance['wpfh_search_bd'] = ( ! empty( $new_instance['wpfh_search_bd'] ) ) ? strip_tags( $new_instance['wpfh_search_bd'] ) : '';
		
		//print_r($instance);exit;

		return $instance;
	}

}
?>
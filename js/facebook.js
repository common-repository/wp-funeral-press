


function wpfh_sharer(title,url,caption,image){
		FB.ui({
		  method: 'feed',
		  link: url,
		  name: title,
		  caption: caption,
		  picture: image,
		}, function(response){});	
}




		
		jQuery(document).ready(function($){
					
					
					
		});
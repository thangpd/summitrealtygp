/* //jQuery(document).ready(function(){
	
	console.log('dropdown js file loaded');
	
	jQuery('#ct-currency-switch').empty(); 

	var data = {
		'action': 'get_curriencies',
		
	};


	jQuery.post('/wp-admin/admin-ajax.php', data, function(response) {
		console.log("kapil");
		let parse_data=	JSON.parse(response);

		 jQuery.each(parse_data, function( index, value ) {
				//console.log(value);
			jQuery('#ct-currency-switch').append('<option data-rate="'+value[1]+'"  value="'+value[0]+'">'+value[0]+'</option>'); 
		});
	});
	
//});


 */
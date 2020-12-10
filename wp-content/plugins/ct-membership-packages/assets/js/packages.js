/* jQuery(document).on("click",'.payment_method',function(){
		
			var Button = $('.payment_method').val();
			console.log(Button);
			if(Button == 'stripe'){
				alert('stripe');
				$(".stripe-form").show('slow');
			}else{
				$(".stripe-form").hide('slow');
			}
			
			if(Button == 'paypal'){
				alert('paypal');
				console.log(Button+'aaa')
				 $(".paypal-recurring").show('slow');
			}else{
				console.log(Button+'bbb	')
				$(".paypal-recurring").hide('slow');
			}
			
		
	}); */
/* 	jQuery(document).ready(function($){
		
		 $('.payment_method').click(function() {
			var id = $(this).val();
			if(id == 'stripe'){
				$('.paymentform').attr('id','payment-form');
			}
			else{
				$('.paymentform').attr('id','');
			}
			
			console.log(id);
			
		}) 
	});
 
	function openCity(evt, cityName) {	
		//console.log(evt);		
		var i, tabcontent, tablinks;
		tabcontent = document.getElementsByClassName("tabcontent");
		for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
		}
		tablinks = document.getElementsByClassName("tablinks");
		for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" active", "");
		}
		document.getElementById(cityName).style.display = "block";
		evt.currentTarget.className += " active";
	}
*/
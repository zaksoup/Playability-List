$(document).ready(function() {

	$('.signup_link').click(function(){
	
		$('#signup').slideDown(function(){
		
			$('.close').fadeIn();
		
		});
	
	});
	
	$('.close').click(function(){
	
		hideForm();
	
	});

	var queryhash = window.location.hash
		switch (queryhash) {
			case "#signup":
				document.title = "Sign Up for Playability";
				$('#signup').slideDown(function(){
				
					$('.close').fadeIn();
				
				});
				break;
			default:
				break;
		};
		
		
		$(".signup .submit").click(function(){
			
			if($('.signup input.password').val() == $('.signup input.confirm').val()){
		
				$.post("../authentication.php", {user: $('.signup input.username').val(), pass: $('.signup input.password').val(), email: $('.signup input.email').val(), code: $('.signup input.code').val(), action: 'add'}, function(data) {
				    	    if(data == "success"){
				    	    
				    	    	alert(data);
				    	    	hideForm();
				    	    	
				    	    }else{
				    	    	alert(data);
				    	    };
				    	    //alert(data);
					  });
			}else{
				alert('password fail');
			};		 // alert('test');
		});
		
		$(".signin .submit").click(function(){
		
			submitAuth();
		
		});
		
		$('.signin input.password').keypress(function(e){
		      if(e.which == 13){
		      	e.preventDefault();
		       submitAuth();
		       return false;
		       }
		      });
		
		$('.logout').click(function(){
		
			$.post("../logout.php", {action: "logout"}, function(data){
			
				if(data == "success"){
				
					alert("logged out");
					
				}else{
				
					alert(data);
				};
			
			});
		
		});

});

function hideForm() {

	$('.close').fadeOut(function(){
	
		$('#signup').slideUp();
	
	});

}

function submitAuth(){

	$.post("../authentication.php", {user: $('.signin input.username').val(), pass: $('.signin input.password').val(), action: 'auth'}, function(data) {
	    	    if(data == "success"){
	    	    
	    	    	//alert(data);
	    	    	//hideAuthForm();
	    	    	window.location = "../index.php";
	    	    	
	    	    	
	    	    }else{
	    	    	alert(data);
	    	    };
	    	    //alert(data);
	});

}
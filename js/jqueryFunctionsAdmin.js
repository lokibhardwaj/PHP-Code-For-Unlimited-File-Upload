/**
 * Reviews JS for functions
 */
 
  
  jQuery(document).ready(function($) {
  
       //Tabs in admin   
      $('#tab-container').easytabs(); 
   
	 			  
		  //Design Colors				 
			//mainColor
			$(".mainColor").asColorPicker({
				mode: 'complex'
			  });
			  
			  //lightColor
			 $(".lightColor").asColorPicker({
				mode: 'complex'
			  });
			  
			 //bg_gradient_color1
			 $(".bg_gradient_color1,.bg_gradient_color2").asColorPicker({
				mode: 'complex'
			  });
			  
	 //##################################### Color update save in config file #################################
	 //##################################### Color update save in config file #################################

			jQuery("#design_colors_form").validate({
		       rules: {           
               
               },                
               messages: {  				    
               },
			   submitHandler: function (form) { 
			    $("#ad_loader").show();
				var str = $("#design_colors_form" ).serialize();				
				  $.ajax({
					type: "POST",
					url: "ajax_savecolor_deleteicon.php",
					data: str,
					cache: false,
					success: function(result){
						$("#ad_loader").hide();
						if(result){
							
					       $("#color_done").html('<span class="sucess_message">Configuration has been updated successfully!</span>').show().fadeOut( 5000 );
						   //window.location.replace(result+'admin.php#tabs1-design');
						   window.location.reload();
						}
					}
				 });	
				return false;
			  }
	       });
		   
		   
	 //##################################### Typekit fonts update save in config file #################################
	 //##################################### Typekit fonts update save in config file #################################
	 
	  /******************* Enable disable Typekit code**************/	  
	    $('#ad_typekit_chk').on('click', function () {
			$("#ad_loader").show();
		    if($(this).prop('checked') == true){
			  $('#typekite_feilds :input').removeAttr("disabled"); 
			  $('#typekit_action').removeAttr("disabled"); 
			   $("#typekite_feilds").removeClass("typekite_disabled");
			 var ad_typekit_chkVal = 1;
			 }else{
				
				  $('#typekite_feilds :input').attr("disabled", "disabled");
				  $('#typekit_action').attr("disabled", "disabled");
				  
				  $("#typekite_feilds").addClass("typekite_disabled");
			     var ad_typekit_chkVal = 0;	  
			   	}
				//Update into Config file
				var str = "ad_typekit_chk="+ad_typekit_chkVal;
				 	$.ajax({
						type: "POST",
						url: "ajax_savecolor_deleteicon.php",
						data: str,
						cache: false,
						success: function(result){
							$("#ad_loader").hide();
							//alert($(".site_url").val());
							//location.reload();
							//window.location.href($(".site_url").val());
							//window.location.replace($(".site_url").val()+'admin.php#tabs1-typekit');
							 //window.location = result+'/admin.php#tabs1-typekit';
							  window.location.reload();
							
						}
					});	
					
				
				
				
				
			  });
	  

			
			jQuery("#typekit_form").validate({
		       rules: {           
               
               },                
               messages: {  				    
               },
			   submitHandler: function (form) { 
			    $("#ad_loader").show();
				var str = $('#typekiteCode').val().replace('<script','sf_@_#');
				str = str.replace('</script>','ss_@_#');
				str = str.replace('<script>','st_@_#');
				str = str.replace('</script>','ss_@_#');
				$('#typekiteCode').val(str);
				var str = $("#typekit_form" ).serialize();
				
				  $.ajax({
					type: "POST",
					url: "ajax_savecolor_deleteicon.php",
					data: str,
					context: document.body,
					cache: false,
					success: function(result){
						
						$("#ad_loader").hide();
						if(result){							
					       $("#typekit_done").html('<span class="sucess_message">Configuration has been updated successfully!</span>').show().fadeOut( 5000 );
						     //window.location.reload();
							// window.location.reload(true);							
							window.location.href = $(".site_url").val()+'admin.php?action=tabs1-typekit';
							//$("#kit-type").click(); 
						}
					}
				 });	
				return false;
			  }
	       });
		   	 
			   
	 //##################################### Sharing update save in config file #################################
	 //##################################### Sharing fonts update save in config file #################################
	 
	  /******************* Enable disable Sharing code**************/	  
	    $('#ad_shr_chk').on('click', function () {
			$("#ad_loader").show();
		    if($(this).prop('checked') == true){
			  $('#ad_shar_detail :input').removeAttr("disabled"); 
			  //$('#typekit_action').removeAttr("disabled"); 
			   $("#ad_shar_detail").removeClass("sharing_disabled");
			 var ad_shr_chkVal = 1;
			 }else{
				
				  $('#ad_shar_detail :input').attr("disabled", "disabled");
				  //$('#typekit_action').attr("disabled", "disabled");
				  
				  $("#ad_shar_detail").addClass("sharing_disabled");
			     var ad_shr_chkVal = 0;	  
			   	}
				//Update into sharing in Config file
				var str = "ad_shr_chkVal="+ad_shr_chkVal;
				 	$.ajax({
						type: "POST",
						url: "ajax_savecolor_deleteicon.php",
						data: str,
						cache: false,
						success: function(result){
							$("#ad_loader").hide();
						}
					});
			  });
	  

			jQuery("#ad_sharing_form").validate({
		       rules: {           
               
               },                
               messages: {  				    
               },
			   submitHandler: function (form) { 
			    $("#ad_loader").show();
				var str = $("#ad_sharing_form" ).serialize();
				
				  $.ajax({
					type: "POST",
					url: "ajax_savecolor_deleteicon.php",
					data: str,
					cache: false,
					success: function(result){
						$("#ad_loader").hide();						
						if(result =="sharing_done"){							
					       $("#sharing_done").html('<span class="sucess_message">Configuration has been updated successfully!</span>').show().fadeOut( 5000 );
						}
					}
				 });	
				return false;
			  }
	       });
		 


	//##################################### Files limit save in config file #################################
	 //##################################### Files limi update save in config file #################################
	 
	  /******************* file limit code**************/	  
	     	jQuery("#ad_settings_form").validate({
		       rules: {           
				file_limit: {
					  required: true,
					  number: true,
					  max: 2000,
					  min: 1
					}
               },                
               messages: { 
					 file_limit: {
						required: "Please enter a number" ,
						number: "Enter only number",						
						
					},
               },
			   submitHandler: function (form) { 
			    $("#ad_loader").show();
				var str = $("#ad_settings_form" ).serialize();
				
				  $.ajax({
					type: "POST",
					url: "ajax_savecolor_deleteicon.php",
					data: str,
					cache: false,
					success: function(result){
						$("#ad_loader").hide();							
						if(result =="setting_done"){							
					       $("#setting_done").html('<span class="sucess_message">Configuration has been updated successfully!</span>').show().fadeOut( 5000 );
						}
					}
				 });	
				return false;
			  }
	       });
		   
		   
		   
		/***********************************************************
		 *** Change in config file zip, plain and both download
		***********************************************************/
		
	   	
		$(document).on("click", ".adminDownloadMode", function(event) {    
			$("#ad_loader").show();
			var str = "adminDownloadMode= "+$(this).val();
			 $.ajax({
				type: "POST",
				url: "ajax_zipPlain.php",
				data: str,
				cache: false,
				success: function(result){
				$("#ad_loader").hide();	
                  if(result == "allow_downloadMode_done"){					
				   $("#adminDownloadMode_done").html('<span class="sucess_message">Configuration has been updated successfully!</span>').show().fadeOut( 5000 );	
				  }				  
				}				
			});	
	   });
	   
	   
	   
	   /***********************************************************
		 *** Change in config re zipped option
		***********************************************************/
		
	   	
		$(document).on("click", ".re_zipped_ctrl", function(event) {    
			$("#ad_loader").show();
			//var str = "re_zipped_ctrl= "+$(this).val();			
			if($("#re_zipped_chk").prop('checked') == true){			 
				var re_zipped_chk = 1;
			 }else{
				 var re_zipped_chk = 0;	  
			 }
			 
			var str ="re_zipped_ctrl= "+re_zipped_chk;
			 
			 $.ajax({
				type: "POST",
				url: "ajax_re_zipped.php",
				data: str,
				cache: false,
				success: function(result){
				$("#ad_loader").hide();	
                  if(result == "rezipped_done"){					
				   $("#admin_rezipped_done").html('<span class="sucess_message">Configuration has been updated successfully!</span>').show().fadeOut( 5000 );	
				  }else{
					$("#admin_rezipped_done").html('<span class="error_message">Something wrong.</span>').show().fadeOut( 5000 );	  
				  }				  
				}				
			});	
	   });
	   
	   
	     /***********************************************************
		 *** Change in config show doanload option
		***********************************************************/
		
	   	
		$(document).on("click", ".download_link_ctrl", function(event) {    
			$("#ad_loader").show();
			var str = "download_link_ctrl= "+$(this).val();
			 $.ajax({
				type: "POST",
				url: "ajax_re_zipped.php",
				data: str,
				cache: false,
				success: function(result){
				$("#ad_loader").hide();	
                  if(result == "download_link_done"){					
				   $("#download_link_done").html('<span class="sucess_message">Configuration has been updated successfully!</span>').show().fadeOut( 5000 );	
				  }else{
					$("#download_link_done").html('<span class="error_message">Something wrong.</span>').show().fadeOut( 5000 );	  
				  }				  
				}				
			});	
	   });
		   
		   
		   
      /******************* SMTP Settings **************/	  
	     	jQuery("#ad_smtp_settings_form").validate({
		       rules: {           
					smtp_host: {
					  required: true,
					
					},
					
					smtp_port: {
					  required: true,
					  number: true,
					  max: 65535,
					  min: 1
					},
               },                
               messages: { 
					 smtp_host: {
						required: "SMTP Host is needed" ,
					},
					smtp_port: {
						required: "Please enter a port number" ,
						number: "Enter only number",						
					},
               },
			   submitHandler: function (form) { 
			    $("#ad_loader").show();
				var str = $("#ad_smtp_settings_form" ).serialize();
				
				  $.ajax({
					type: "POST",
					url: "ajax_smtp.php",
					data: str,
					cache: false,
					success: function(result){
						$("#ad_loader").hide();							
						if(result =="setting_done"){							
					       $("#smtp_setting_done").html('<span class="sucess_message">Configuration has been updated successfully!</span>').show().fadeOut( 5000 );
						}
					},

				 }).fail(function() {
							$("#smtp_setting_done").html('<span class="sucess_message">Configuration has not been updated successfully!</span>').show().fadeOut( 5000 );
						
				 }).always(function(){
				 	$("#ad_loader").hide();	
				 });	
				return false;
			  }
	       });
		   


     //##################################### Enable https update save in config file #################################
	 //##################################### Enable https update save in config file #################################
	 
	  /******************* Enable disable Enable https**************/	  
	    $('#ad_http_chk-').on('click', function () {	
			
			$("#ad_loader").show();
		    if($(this).prop('checked') == true){			 
			 var ad_http_chkVal = 1;
			 }else{
				 var ad_http_chkVal = 0;	  
			 }
			//Update into Config file
			var str = "ad_http_chkVal="+ad_http_chkVal;
			 $.ajax({
				type: "POST",
				url: "ajax_savecolor_deleteicon.php",
				data: str,
				cache: false,
				success: function(result){
				  $("#ad_loader").hide();							
					if(result){							
					  $("#http_setting_done").html('<span class="sucess_message">Configuration has been updated successfully!</span>').show().fadeOut( 5000 );
					  //location.reload();
					   window.location.replace(result+'/admin.php#tabs1-settings');
					}
				}
				
			});	
	   });
	   
	   
	   

     //##################################### Enable WWW update save in config file #################################
	 //##################################### Enable WWW update save in config file #################################
	 
	  /******************* Enable disable Enable WWW**************/	  
	    $('#ad_domain_chk-').on('click', function () {	
			
			$("#ad_loader").show();
		    if($(this).prop('checked') == true){			 
			 var ad_domain_chkVal = 1;
			 }else{
				 var ad_domain_chkVal = 0;	  
			 }
			//Update into Config file
			var str = "ad_domain_chkVal="+ad_domain_chkVal;
			 $.ajax({
				type: "POST",
				url: "ajax_savecolor_deleteicon.php",
				data: str,
				cache: false,
				success: function(result){
				  $("#ad_loader").hide();							
					if(result){							
					  $("#domain_setting_done").html('<span class="sucess_message">Configuration has been updated successfully!</span>').show().fadeOut( 5000 );
					  //location.reload();
					   //window.location.replace(result+'/admin.php#tabs1-settings');
					}
				}
				
			});	
	   });
	   
	   
	   
     //##################################### Enable https Or WWW update save in config file #################################
	 //##################################### Enable https Or WWW update save in config file #################################
	 
	  /******************* Enable disable Enable https**************/	  
	    $('.ssl_verify').on('click', function () {	
			
			$("#ad_loader").show();
			//https
		    if($("#ad_http_chk").prop('checked') == true){			 
			 var ad_http_chkVal = 1;
			 }else{
				 var ad_http_chkVal = 0;	  
			 }
			 
			 //WWW
			 if($("#ad_domain_chk").prop('checked') == true){			 
			 var ad_domain_chk = 1;
			 }else{
				 var ad_domain_chk = 0;	  
			 }
			 
			//Update into Config file
			var str = "ad_http_chkVal="+ad_http_chkVal+"&ad_domain_chkval="+ad_domain_chk;
			//alert(str);
			 $.ajax({
				type: "POST",
				url: "ajax_savecolor_deleteicon.php",
				data: str,
				cache: false,
				success: function(result){
				  $("#ad_loader").hide();							
					if(result){	
					
					  $("#domain_setting_done").html('<span class="sucess_message">Configuration has been updated successfully!</span>').show().fadeOut( 5000 );
					  //location.reload();
					   window.location.replace(result+'admin.php#tabs1-settings');
					   
					   
					   
					}
				}
				
			});	
	   });
	   
	   
	   
	   
	 //##################################### Security password update save in config file #################################
	 //##################################### Security password update save in config file #################################
	 
	  /******************* Enable disable Security code**************/	  
	    $('#ad_security_chk').on('click', function () {
			$("#ad_loader").show();
		    if($(this).prop('checked') == true){
			  $('#sec_user').removeAttr("disabled"); 
			  $('#sec_pwd').removeAttr("disabled"); 
			  $('#security_action').removeAttr("disabled");			  
			  $("#ad_security_detail").removeClass("security_disabled");
			 var ad_security_chkVal = 1;
			 }else{
				
				 $('#sec_user').attr("disabled", "disabled");
				 $('#sec_pwd').attr("disabled", "disabled");				 
				 $('#security_action').attr("disabled", "disabled");				 
				 
				  $("#ad_security_detail").addClass("security_disabled");
			     var ad_security_chkVal = 0;	  
			   	}
				//Update into security enable in Config file
				var str = "ad_security_chkVal="+ad_security_chkVal;				
				 	$.ajax({
						type: "POST",
						url: "ajax_savecolor_deleteicon.php",
						data: str,
						cache: false,
						success: function(result){
							$("#ad_loader").hide();

						}
					});
			  });
	  
	     //Submit form
			jQuery("#ad_security_form").validate({
		          errorPlacement: function (error, element) {
					error.insertAfter(element);
					if (element.hasClass('e_txt')) {
						//element.next().removeClass('loginValid').addClass('loginError');
						element.removeClass('loginValid').addClass('loginError');
					}
				},
				success: function (label) {
					if (label.prev().hasClass('e_txt')) {
						//label.text("ok Done!");
					}
				},
				highlight: function (element, errorClass, validClass) {
					if ($(element).hasClass('e_txt')) {
						//$(element).next().removeClass('loginValid').addClass('loginError');
						$(element).removeClass('loginValid').addClass('loginError');
					} else {
						$(element).addClass(errorClass).removeClass(validClass);
					}
				},
				unhighlight: function (element, errorClass, validClass) {
					if ($(element).hasClass('e_txt')) {
						//$(element).next().removeClass('loginError').addClass('loginValid');
						$(element).removeClass('loginError').addClass('loginValid');
					} else {
						$(element).removeClass(errorClass).addClass(validClass);
					}
				},
				 
				   rules: {  
                  sec_user: {
					required: true,					
					},
					sec_pwd: {
					required: true,					
					},
                  },
                
                messages: {  
				    
                    sec_user: {
						required: "Please enter username" ,						
					},	
                    sec_pwd: {
						required: "Please enter password" ,						
					},					
					
                  },
				 
			   submitHandler: function (form) { 
			    $("#ad_loader").show();
				var str = $("#ad_security_form" ).serialize();
				  $.ajax({
					type: "POST",
					url: "ajax_savecolor_deleteicon.php",
					data: str,
					dataType: "json",
					cache: false,
					success: function(result){
						
						$("#ad_loader").hide();						
						if(result){	
							//alert(result['sec_user'] + '-'+ result['sec_pwd'] );
							$("#sec_user").val(result['sec_user']);
							//$("#sec_pwd").val(result['sec_pwd']);
							
					       $("#security_done").html('<span class="sucess_message">Configuration has been updated successfully!</span>').show().fadeOut( 5000 );
						    
							 window.location.reload(true);		
						}
					}
				 });	
				return false;
			  }
	       });
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
  
			

	//##################################### Logo upload	##########################################		
	//##################################### Logo upload	##########################################		
		
			 $('.change_logo').on('click', function () {
				 $("#photoimg").click();
			  });
				 
				$('#photoimg').on('change', function(){ 
				   $("#preview_error").html('');
				   $("#ad_loader").show();
				   //$("#preview").html('<img src="loader.gif" alt="Uploading...."/>');
				   $("#imageform").ajaxForm({
					  beforeSubmit : function(arr, $form, options){
						},
					    success : function(data){
						 $("#ad_loader").hide();
						 var cl = $(data).attr("class");
						 if($(data).attr("class") == "img_error"){
							 $("#preview_error").html(data);  
							}else{
								$("#preview").html(data);
								  window.location.reload();
							}	
												 
					   }
				   }).submit();
				});
             			

			
				
		    //Logo Retina upload			
			 $('.change_logo_retina').on('click', function () {
				 $("#photoimg_retina").click();
			  });
				 
				$('#photoimg_retina').on('change', function(){ 
				   $("#preview_retina_error").html('');
				   $("#ad_loader").show();
				   $("#logo_retinaform").ajaxForm({
				           
						beforeSubmit : function(arr, $form, options){
						},
					    success : function(data){
						 $("#ad_loader").hide();
						 var cl = $(data).attr("class");
						 if($(data).attr("class") == "img_error"){
							 $("#preview_retina_error").html(data);  
							}else{
								$("#preview_retina").html(data);
								window.location.reload();
							}	
												 
					   }   
						   
				   }).submit();
				});	
				
          //change favicon
		   $('.change_favicon').on('click', function () {
				 $("#photoimg_favicon").click();
			  });
				 
				$('#photoimg_favicon').on('change', function(){ 
				  $("#ad_loader").show();
				   $("#preview_favicon_error").html('');
				 
				   $("#favicon_form").ajaxForm({
				    beforeSubmit : function(arr, $form, options){
						},
					    success : function(data){
							$("#ad_loader").hide();
						 var cl = $(data).attr("class");
						 if($(data).attr("class") == "img_error"){
							 $("#preview_favicon_error").html(data);  
							}else{
								$("#preview_favicon").html(data);
								window.location.reload();
							}	
												 
					   }
				   }).submit();
				});
				
				
		   //Change touchIcon		  
		   $('.change_touchicon').on('click', function () {
				 $("#photoimg_touchicon").click();
			  });
				 
				$('#photoimg_touchicon').on('change', function(){ 
				   $("#preview_touchicon_error").html('');
				    $("#ad_loader").show();
				   $("#touchicon_form").ajaxForm({
				     beforeSubmit : function(arr, $form, options){
						},
					    success : function(data){
						$("#ad_loader").hide();
						 var cl = $(data).attr("class");
						 if($(data).attr("class") == "img_error"){
							 $("#preview_touchicon_error").html(data);  
							}else{
								$("#preview_touchicon").html(data);
								window.location.reload();
							}	
												 
					   }
				   }).submit();
				});
		  
		   //Delete logo,logo Retina, Favicon Touchicon
		     $('.delete_icon').on('click', function () {
				var ids =  $(this).attr("id");
				if (confirm("Are you sure for delete?")) {
                    $("#ad_loader").show();
					var str = "ids="+ids;
				 	$.ajax({
						type: "POST",
						url: "ajax_savecolor_deleteicon.php",
						data: str,
						cache: false,
						success: function(result){
							$("#ad_loader").hide();
							if(result=="delete_logo"){ $("#preview").html("");}
							else if(result=="delete_retina"){ $("#preview_retina").html("");}
							else if(result=="delete_favicon"){ $("#preview_favicon").html("");}
							else if(result=="delete_touchicon"){ $("#preview_touchicon").html("");}
							
							window.location.reload();
						}
					});	
						return false;
				  
				 }
				return false;		
			  });
	  //############ Logo upload and delete section end #########################################   
	  //############ Logo upload and delete section end #########################################   
		
		
    });//Main close

	
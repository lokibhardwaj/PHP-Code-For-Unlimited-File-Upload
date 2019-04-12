/**
 * Reviews JS for functions
 */
 
  
  jQuery(document).ready(function($) {
	  
	  
	  
	  var isOpera1 = !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
		// Opera 8.0+ (UA detection to detect Blink/v8-powered Opera)
		var isFirefox1 = typeof InstallTrigger !== 'undefined';   // Firefox 1.0+
		var isSafari1 = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
			// At least Safari 3+: "[object HTMLElementConstructor]"
		var isChrome1 = !!window.chrome && !isOpera1;              // Chrome 1+
		var isIE1 = /*@cc_on!@*/false || !!document.documentMode;   // At least IE6
	    
		var OSName="Unknown OS";
		if (navigator.appVersion.indexOf("Win")!=-1) OSName="Windows";
		else if (navigator.appVersion.indexOf("Mac")!=-1) OSName="MacOS";
		else if (navigator.appVersion.indexOf("X11")!=-1) OSName="UNIX";
		else if (navigator.appVersion.indexOf("Linux")!=-1) OSName="Linux";
			
			
		if(isOpera1 ==true){			
			$('.file_select_before').removeAttr("multiple");
			$('.file_select').removeAttr("multiple");
		}
		else if(isSafari1 ==true && OSName=="Windows" ){
		
			$('.file_select_before').removeAttr("multiple");
			$('.file_select').removeAttr("multiple");
			
			$('#copyButton1').addClass("safariCl"); //Remove clipBoard icon
			$('#copyButton').addClass("safariCl"); //Remove clipBoard icon
		}
		
		else if(isSafari1 ==true && OSName=="MacOS" ){
		
			$('#copyButton1').addClass("safariCl"); //Remove clipBoard icon
			$('#copyButton').addClass("safariCl"); //Remove clipBoard icon
			
		}
		
		
		
		//Change in config file zip and plain download
		
	   	
		$(document).on("click", ".downloadMode", function(event) {    
			
			var str = "downloadMode= "+$(this).val();
			 $.ajax({
				type: "POST",
				url: "ajax_zipPlain.php",
				data: str,
				cache: false,
				success: function(result){										
					if(result == "plainFiles"){
						$(".frm_direct_download, .clip-board-container").hide();
					}else{
						$(".frm_direct_download, .clip-board-container").show();
					}
				}				
			});	
	   });
		
		
		
		// Click on Add files icon, 
		$('a#addFile').on('click', function () { 
			 var n = $('.file_select').length + 1;
				/*if( 5 < n ) {
					alert('Stop it!');
					return false;
				}*/
				var box_html = $('<input type="file" id="file_select'+n+'" class="file_select"  size="30" />');
				box_html.hide();
				$('input.file_select:last').after(box_html);
				box_html.fadeIn('slow');
				
				
				 $("#file_select"+n).click();
				return false;
		  });
		  
		  // Create input file on mouser over
		  $('#upload').on('mouseover', function () { 
		     var catVals = [];
			 var n = $('.file_select').length + 1;
				/*if( 5 < n ) {
					alert('Stop it!');
					return false;
				}*/
				 $('.file_select').each(function() {
				   if($(this).val() ==""){
					 catVals.push($(this).attr('id')); 
					}
			      });				
				if(catVals.length ==0){
					
					if((isSafari1==true && OSName=='Windows') || isOpera1==true && OSName=='Windows')
					{
					 var box_html = $('<input type="file" id="file_select_'+n+'" class="file_select"    /> <input type="hidden" id="txt_file_select_'+n+'" class="file_select_count" value="" /> ');
		            }
					else
					{
					  var box_html = $('<input type="file" id="file_select_'+n+'" class="file_select"   multiple="multiple" /> <input type="hidden" id="txt_file_select_'+n+'" class="file_select_count" value="" /> ');	 
					}
				    box_html.hide();
				    $('input.file_select_count:last').after(box_html);
				    box_html.fadeIn('slow');
				
				}
		     });
		  
		  
		   //Show selected files in list
		    $("body").on( 'change', '.file_select', function() {
					//Get Id
                  				
				 var id = $(this).attr("id");	
				 var file_data = $("#"+id).prop("files")[0].length;
				 //alert(file_data);
				 
				 
				 var x = document.getElementById(id);
					var txt = "";
					var txt_upload = "";
					
					var total_Upload_Size = Number($("#total_Upload_Size").val());
					var all_selected_files = Number($("#all_txt_file_select").val());
					
					if ('files' in x) {
						if (x.files.length == 0) {
							txt = "";
							txt_upload = "";
						} else {
							for (var i = 0; i < x.files.length; i++) {
								var file = x.files[i];
								
								var gen_id = file.name;
								//var gen_id1 =  gen_id.split(".");
								//var gen_id1 =  gen_id.replace(/./g, '@');
								//var gen_ids = gen_id1+file.size;
								//var rand = Math.floor(1000 + Math.random() * 9000);
								
								
								var myStr = file.name;
									myStr=myStr.toLowerCase();
									//myStr=myStr.replace(/(\s+$)/,"");
									myStr=myStr.replace(/(^\s+|[^a-zA-Z0-9 ]+|\s+$)/g,"");
									myStr=myStr.replace(/\s+/g, "");
									
							    var gen_ids = myStr+Number(file.size);
															
								//txt += "><strong>" + (i+1) + ". file</strong><br>";
							    txt += "<div class='fileList'>";
								txt_upload += "<div id='"+gen_ids+"' class='current_upload'> ";
								txt_upload += "<div class='current_p_bar'> <span id='' class='current_p_bar'></span></div> ";
								
								if ('name' in file) {
									txt += "<span class='f_name'> " + file.name + "</span>";
									txt_upload += "<div id='' class='current_file_name'>" + file.name + "</div>";
								}
								if ('size' in file) {
									txt += "<span class='f_size'>" +  bytesToSize(file.size) + " </span>";
									txt_upload += "<div id='' class='current_file_size'>" +  bytesToSize(file.size) + "</div>";
									
								}
								txt += "</div>";
								
								txt_upload += "</div>";
								
								total_Upload_Size +=(file.size);
								
							}
							
							var xlength = x.files.length;
								all_selected_files +=(xlength);
						}
					}
					
				$('.fileList:last').after(txt);
				$('.current_upload:last').after(txt_upload);
				
				
				
				$("#total_Upload_Size").val(total_Upload_Size);
				$("#all_txt_file_select").val(all_selected_files); //Selected files length count
				
				//Ready to upload files and totall size
				$("#total_to_upload_left").html(all_selected_files+' Files');
				$("#total_to_upload_size").html(bytesToSize(total_Upload_Size));
				
				 if($("#all_txt_file_select").val() >5){			 
					  $("#total_to_upload").show(); //before upload
					  $("#file_list").hide(); //before upload	
			      }
				
				//Check file limit for upload 
				if($("#files_limit").val() < all_selected_files){
					
					$("#files_limit_error").html("Please upload files less than or equal to "+$("#files_limit").val()+".");
					$("#send").hide();
				}
				
				$(this).hide();
				
	       });
		   
		   //Count Size In KB Mb
		   	function bytesToSize(bytes) {				
			     if(bytes >=1073741824) 
					{
						bytes1 = bytes/1073741824;
						bytes1 = bytes1.toFixed(2) + ' GB' ;
					}
					if(bytes >=1048576) 
					{
						bytes1 = bytes/1048576;
						bytes1 = bytes1.toFixed(2) + ' MB' ;
					}
					
					else if(bytes >=1024){
						bytes1 = bytes/1024;
						bytes1 = bytes1.toFixed(2) + ' KB' ;
					}
					else if(bytes >=1){
						bytes1 = bytes + ' byte';
					}
					else if(bytes ==1){
						bytes1 = bytes + ' byte';
						
					}
					return  bytes1;
			}
		
		//Submit On click Send Button
		 $("body").on( 'click', '#send', function() {
				
			var total_Upload_Size =0;
			var total_files=0;
			var catVals = [];
			 $('.file_select').each(function() {
				 
				 if($(this).attr('id') =="file_select"){
					
				 }else{
					 if($(this).val() !=""){
					 catVals.push($(this).attr('id')); 
					 
					 var fId = $(this).attr('id');
					 //alert(fId)
					 var filesLen = $("#"+fId)[0].files.length;
					  $("#txt_"+fId).val(filesLen);
					  //alert(filesLen);
					  total_files += Number(filesLen);
					 }else{
						 
					 }
				 }
				 
			   //total_Upload_Size += Number(this.files[0].size);
			 });
             $("#all_select_fiels").val(catVals);	//,$("#all_select_fiels").val()		
             //$("#total_Upload_Size").val(total_Upload_Size);	//Calculate Upload File Size
			 
			 var fileCount = document.getElementById('file_select').files.length-1;			
			 $("#txt_file_select").val(fileCount);
			 
			 var all_selected_files = fileCount+total_files;
			 //$("#all_txt_file_select").val(all_selected_files);
			 
			 // Decide Expand div show or not
			 if($("#all_txt_file_select").val() >5){
				 
				 $("#expander_files").show(); //on upload
				 $(".expand_wrappper").hide(); //on upload

			   }
			 
			 
			 
			upload($("#web_root").val(),$("#jirafeau_get_max_upload_size_bytes").val(),$("#total_Upload_Size").val());
			
		 });
		 
		 //Enable disable password field
		  $('#pwdChk').on('click', function () {
			  if($(this).prop('checked') == true){
				  
					$("#input_key").removeAttr("disabled"); 
				}else{
					$("#input_key").val("");
				  $("#input_key").attr("disabled", "disabled"); 
				}
	      });
		  
		  
		  
		  /******************************* Expand div up down on uploading screen********************/
			$('#expander_files').click(function () {
				
				if ($('.expand_wrappper').is(":hidden")) {						
					if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Mac') != -1) {
						$('.expand_wrappper').slideDown(1500);
						//document.getElementById('file_list').style.overflow = "visible";      
					}else{
						$('.expand_wrappper').slideDown(1500);
					}
					$(this).addClass("up_icon");
					$(this).removeClass("down_icon");	
														
				} else {
					if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Mac') != -1) {
						$('.expand_wrappper').slideUp(1500);						
					}else{
						$('.expand_wrappper').slideUp(1500);
					}
					
					$(this).addClass("down_icon");
					$(this).removeClass("up_icon");	
					
				}
             });
			 
			 //On upload page
			 $('#expander_total_upload').click(function () {
				if ($('#file_list').is(":hidden")) {
					if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Mac') != -1) {
						$('#file_list').slideDown(1500);
						//document.getElementById('file_list').style.overflow = "visible";      
					}else{
						$('#file_list').slideDown(1500);
					}
					$(this).addClass("up_icon");
					$(this).removeClass("down_icon");	
																						
				} else {
					if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Mac') != -1) {
						$('#file_list').slideUp(1500);    
					}else{
						$('#file_list').slideUp(1500);
					}
					$(this).addClass("down_icon");
					$(this).removeClass("up_icon");	
					
					
				}
             });
		  
		  
		  
		  //Password protected form submit and force single file download. 
		  
		    $( ".dn-icon-pwd" ).click(function() {				 
			   /*
			    var siteName = $("#site-name").val();			   
				var actionNew =  siteName+'?h='+$( this ).attr('id')+'&d=1';				   
			     $( "#submit_post" ).attr('action',actionNew);			   
			     $( "#submit_post" ).submit();
				 */
				  
				  if($("#pwd-keys").val() ==""){
					  $("#pwd-keys-error").html("Password required.").show();
				  }else{
					 $("#pwd-keys-error").html("").hide();
					 $("#single_download_pwd").val($( this ).attr('id')); 
					 $( "#single_download_form_pwd" ).submit();
				  }
			 
			});
			
			// Transfer typed password for single download
			
			$( "#pwd-keys" ).keyup(function() {
				 if($(this).val().length >0){
                   $("#pwd-keys-error").html("").hide();
				 }else{
					 $("#pwd-keys-error").html("Password required.").show();
				 }
				$("#pwd-keys-copy").val($( this ).val()); 
            });
		  
		  //Without password protected force  single file download.
		  $( ".dn-icon" ).click(function() {
			 
			  $("#single_download").val($( this ).attr('id')); 
			  $( "#single_download_form" ).submit();
			  
			});
			
		  //Preview Image show on click
		  $("body").on( 'click', '.pre_link', function() { 
			 var getId =  $( this ).attr('id');
			  $( "."+getId ).submit();							  
			});
			
			
			//Share form submit and send mail  to friends				
           $("body").on( 'click', '.share-link', function() {			  
			  $( "#share_form" ).submit();			  
			});
			
			
			
			
			//Deletes Files
			 $("body").on( 'click', '.del_files', function() {	
				 var siteUrl = $("#web_root").val();
				 var str = $('#file-code').val();
						$.ajax({
						type: "POST",
						url: siteUrl+'f.php',
						data: str,
						cache: false,
						success: function(result){								
						   //$("#del_message").html(result).show();
						   
						   if(result !=""){ 
								var seconds = 2;
								$("#upload_finished").hide();
								$("#upload_finished").html("");
								$("#upload_finished").css("height","0px");
								$("#upload_finished").css("min-height","0px");
								$("#upload_finished").css("width","0px");
								$("#del_done").show();								
								
								$("#dvCountDown_done_del").show();
								$("#lblCount").html(seconds);
								
								setInterval(function () {
								  $("#upload_finished").hide();
									seconds--;
									$("#lblCount").html(seconds);
									
									if (seconds == 0) {
										
										window.location = siteUrl;
									}
								}, 1000);

							 }						   
						   }
						});			
				
	            });
				
				
			//Redirect (if not redirect in 5 sec upload done) 
			 $("body").on( 'click', '.if_not_redirect', function() {
				 $("#upload_done").hide();
				 $("#upload_finished").show();			
					
             });	
			
			
			
			//Uploading cancel
			$("body").on( 'click', '.upload_cancel_btn', function() {
			  var siteUrl = $("#web_root").val();		
				$("#uploading").hide();
				$("#total_to_upload").hide();
				$("#file-list-container").hide();
				$("#options").hide();
				$("#bgImg").hide();
				$("#cancel_container").show();
				setInterval(function () {					
				  window.location = siteUrl;					
				}, 2000);
		    });
			
			
			
   //######################################### Send your flies form validate ###############################
   //######################################### Send your flies form validate ###############################
   
     //Add more email text box
	    var max_fields      = 10; //maximum input boxes allowed
		var wrapper         = jQuery(".email_wrapper"); //Fields wrapper
		var add_button      = jQuery(".add_field_button"); //Add button ID
    
		var x = 1; //initlal text box count
		jQuery(add_button).click(function(e){ //on add input button click
			e.preventDefault();
			if(x < max_fields){ //max input box allowed
				x++; //text box increment
				jQuery(wrapper).append('<div class="send_txt fr_'+x+'"><input class="e_txt" type="text" name="friend_Emails['+x+']" placeholder="Friends email" /><a href="#" class="remove_field">Remove</a></div>'); //add input box
			}
			
			$('.e_txt').each(function () {
				$(this).rules("add", {
					required: true,
					email: true,
				});
			});
			
			
		});
		
		jQuery(wrapper).on("click",".remove_field", function(e){ //user click on remove text
			e.preventDefault(); $(this).parent('div').remove(); x--;
		})
    //End Add more email textbox
	
	
   
   
			jQuery("#snd_linkForm").validate({
				 errorPlacement: function (error, element) {
					error.insertAfter(element);
					if (element.hasClass('e_txt')) {
						element.next().removeClass('emailValid').addClass('emailError');
					}
				},
				success: function (label) {
					if (label.prev().hasClass('e_txt')) {
						//label.text("ok Done!");
					}
				},
				highlight: function (element, errorClass, validClass) {
					if ($(element).hasClass('e_txt')) {
						$(element).next().removeClass('emailValid').addClass('emailError');
					} else {
						$(element).addClass(errorClass).removeClass(validClass);
					}
				},
				unhighlight: function (element, errorClass, validClass) {
					if ($(element).hasClass('e_txt')) {
						$(element).next().removeClass('emailError').addClass('emailValid');
					} else {
						$(element).removeClass(errorClass).addClass(validClass);
					}
				},	
				
				
		       rules: {               
                snd_msg:"required",                
                your_Email:"required",                
                           
                
                  "friend_Emails[0]": {
					required: true,
					email: true,
					
					},
					your_Email: {
					required: true,
					email: true,
					},
                  },
                
                messages: {  
				    snd_msg: "Please enter message" ,
                    friend_Emails: {
						required: "Please enter a valid email" ,
						email: "Please enter a valid email",
					},	
                    your_Email: {
						required: "Please enter a valid email" ,
						email: "Please enter a valid email",
					},					
					
                  },
				  
				  
				   submitHandler: function (form) { 
						var str = $("#snd_linkForm" ).serialize();
							$.ajax({
							type: "POST",
							url: "ajax_sendlinks.php",
							data: str,
							cache: false,
							success: function(result){
								if(result ==1){
									$("#sendLinks_wrapper").hide();
									$("#mail_sent").show();
								}else{
									$("#mail_result").html("Something wrong").show().fadeOut( 10000 );;
								}
								
							}
							});	
						return false;
					}
	       });
		   
		   
		   
	//######################################### Login check validate and submit ###############################
   //#########################################  Login check validate and submit ###############################
			jQuery("#login-form").validate({
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
                  user: {
					required: true,					
					},
					password: {
					required: true,					
					},
                  },
                
                messages: {  
				    
                    user: {
						required: "Please enter username" ,						
					},	
                    password: {
						required: "Please enter password" ,						
					},					
					
                  },
				  
				  
				   submitHandler: function (form) { 
						var str = $("#login-form" ).serialize();
							$.ajax({
							type: "POST",
							url: "ajax_login.php",
							data: str,
							cache: false,
							success: function(result){								
								if(result ==1){
									$("#upload-login").hide();
									$(".footer").hide();
									//$("#upload").show();								
									window.location.replace($("#web_root").val());								
									
								}else{
									$("#upload-login-error").show();
									$("#upload-login").hide();
								}
								
							}
							});
						return false;
					}
	       });
		   
		   
		   
		   
		   
		   
		   
		   
		
		
		//Drag drop effect on second screen
		    var
			  $body1 = $('body'),
			  $dropzones1 = $('.bgImg-first,.add_file_wrapper');
			 

			$body1
			  .on('dragbetterenter', function() {
				$body1.addClass('_drag');
			  })
			  .on('dragbetterleave', function() {
				$body1.removeClass('_drag');
			  })

			$dropzones1
			  .on('dragbetterenter', function() {
				$dropzones1.addClass('_hover1');
			  })
			  .on('dragbetterleave', function() {
				$dropzones1.removeClass('_hover1');
			  })
			  
			  
			  
			  
			  
			  
			  
			  
		/**###############################*********************************** Copy link to Clipboard*****/
           /*$("a#copy-dynamic").zclip({
			   path:"ZeroClipboard.swf",
			   copy:function(){return $("input#dynamic").val();},			    
               afterCopy: function()
               {
                   console.log($('#fe_text').val() + " was copied to clipboard");
               }
           });*/
		   
		   //Clip board list show hide on download page
			$( ".fileList" ).hover(
			  function() {
				//$( this ).append( $( "<span> ***</span>" ) );
			  }, function() {
				//$( this ).find( "span:last" ).remove();
			  }
			);
			$( ".fileList" ).css('cursor','pointer');
			$('.fileList').hover(function () {
              $(this).find('.clipBoardUrl_list').toggle();
            });
			
			//Copy to clip board on Complete Upload
			
			//var clipboard = new Clipboard('#copyButton');
			var clipboard = new Clipboard('#copyButton', {
						text: function(trigger) {
							return trigger.getAttribute('aria-label');
						}
					});
			 clipboard.on('success', function(e) {
				console.info('Action:', e.action);
				console.info('Text:', e.text);
				console.info('Trigger:', e.trigger);				
				$( ".text-copied-upload" ).show().fadeOut(4000);				
				
				$("#copyTarget").focus(function() {
					
						var $this = $(this);
						$this.select();

						// Work around Chrome's little problem
						$this.mouseup(function() {
							// Prevent further mouseup intervention
							$this.unbind("mouseup");
							return false;
						});
					});				
					
					
				e.clearSelection();
			});

			clipboard.on('error', function(e) {
				console.error('Action:', e.action);
				console.error('Trigger:', e.trigger);
				
			});
			
			
			//Copy to clip board on Download page
			
		   //var clipboard = new Clipboard('.copyButton1');
		   var clipboard = new Clipboard('.copyButton1', {
				text: function(trigger) {					
					return trigger.getAttribute('aria-label');					
				}
			});
			clipboard.on('success', function(e) {
				console.info('Action:', e.action);
				console.info('Text:', e.text);
				console.info('Trigger:', e.trigger);				
				$( e.trigger ).next().show().fadeOut(4000);
				
				$(".clip-board-txt-dn-page").focus(function() {
						var $this = $(this);
						$this.select();

						// Work around Chrome's little problem
						$this.mouseup(function() {
							// Prevent further mouseup intervention
							$this.unbind("mouseup");
							return false;
						});
					});

				e.clearSelection();
			});

			clipboard.on('error', function(e) {
				console.error('Action:', e.action);
				console.error('Trigger:', e.trigger);
			});
				
        
            //FOCUS on Copy link Area		
			//$(".clip-board-txt-dn-page").focus(function() {
			$("body").on( 'focus', '.clip-board-txt-dn-page', function() {	
						var $this = $(this);
						$this.select();

						// Work around Chrome's little problem
						$this.mouseup(function() {
							// Prevent further mouseup intervention
							$this.unbind("mouseup");
							return false;
						});
					});
			  
			 //$("#copyTarget").focus(function() {
			 $("body").on( 'focus', '#copyTarget', function() {
				
						var $this = $(this);
						$this.select();

						// Work around Chrome's little problem
						$this.mouseup(function() {
							// Prevent further mouseup intervention
							$this.unbind("mouseup");
							return false;
						});
					});
			  
			  
			  
				  
				
		
    });//Main close
	
	

	//Function call from function.js.php
	// Showing Upload progress bar
	function uploaded_progress_circle(percentage){
		
		var percentageVal = parseInt(percentage, 10);
			  var val = parseInt(percentageVal);
			  var $circle = $('#svg #bar');
			  
			  if (isNaN(val)) {
			   val = 99; 
			  }
			  else{
				var r = $circle.attr('r');
				var c = Math.PI*(r*2);
			   
				if (val < 0) { val = 0;}
				if (val > 100) { val = 100;}
				
				var pct = ((100-val)/100)*c;
				
				$circle.css({ strokeDashoffset: pct});
				
				$('#cont').attr('data-pct',val);
			  }
			
	}
	
	
	
	function removeFromList(fname,fsize){
		var myStr = fname;
			myStr=myStr.toLowerCase();
			//myStr=myStr.replace(/(\s+$)/,"");
			myStr=myStr.replace(/(^\s+|[^a-zA-Z0-9 ]+|\s+$)/g,"");
			myStr=myStr.replace(/\s+/g, "");
			
		var gen_ids = myStr+Number(fsize);
		return gen_ids;
	}
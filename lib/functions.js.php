<?php
/*
 *  Jirafeau, your web file repository
 *  Copyright (C) 2017  s42transfer <admin@s42.io>
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, either version 3 of the
 *  License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

define ('JIRAFEAU_ROOT', dirname (__FILE__) . '/../');
require (JIRAFEAU_ROOT . 'lib/config.original.php');
require (JIRAFEAU_ROOT . 'lib/settings.php');
require (JIRAFEAU_ROOT . 'lib/functions.php');
require (JIRAFEAU_ROOT . 'lib/lang.php');
?>




function translate (expr)
{
    var lang_array = <?php echo json_lang_generator () ?>;
    if (lang_array.hasOwnProperty(expr))
        return lang_array[expr];
    return expr;
} 


function upload_done(){
	    document.getElementById('uploading').style.display = 'none';
		document.getElementById('upload').style.display = 'none';
		document.getElementById('upload_done').style.display = '';
		document.title = 's42.transfer - 100%';
		
		
		  var seconds = 4;
			var dvCountDown = document.getElementById("dvCountDown_done");
			var lblCount = document.getElementById("lblCount_done");
			dvCountDown.style.display = "block";
			lblCount.innerHTML = seconds;
			setInterval(function () {
				seconds--;
				lblCount.innerHTML = seconds;
				if (seconds == 0) {
					dvCountDown.style.display = "none";
					document.getElementById('upload_done').style.display = 'none';
					
					document.getElementById('upload_finished').style.display = 'block';
				}
			}, 1000);
}

function show_link_new (url, reference, date)
{
	
	 upload_done();
	
	
	
		//alert('reference:-'+ reference);
		// Upload finished
		document.getElementById('uploading').style.display = 'none';
		document.getElementById('upload').style.display = 'none';
		document.getElementById('upload_finished').style.display = 'none';
		document.title = 's42.transfer - 100%';

		// Download page   
		if (!!document.getElementById('upload_finished_download_page'))
		{
			document.getElementById('upload_link').innerHTML = reference;
		   
		}
		
		
		// Validity date
		if (date)
		{
			document.getElementById('date').innerHTML = date;
			document.getElementById('validity').style.display = '';
		}
		else{
		   document.getElementById('date').innerHTML = date;
		   document.getElementById('validity').style.visibility = "hidden";	
		}
			
	
	

}

function show_link (url, reference, delete_code, crypt_key, date)
{
    // Upload finished
    document.getElementById('uploading').style.display = 'none';
    document.getElementById('upload').style.display = 'none';
    document.getElementById('upload_finished').style.display = '';
    document.title = 's42.transfer - 100%';

    // Download page
    var download_link = url + 'f.php?h=' + reference;
    var download_link_href = url + 'f.php?h=' + reference;
    if (crypt_key.length > 0)
    {
        download_link += '&amp;k=' + crypt_key;
        download_link_href += '&k=' + crypt_key;
    }
    if (!!document.getElementById('upload_finished_download_page'))
    {
        document.getElementById('upload_link').innerHTML = download_link;
        document.getElementById('upload_link').href = download_link_href;
    }

    // Email link
    var filename = document.getElementById('file_select').files[0].name;
    var b = encodeURIComponent("Download file \"" + filename + "\":") + "%0D";
    b += encodeURIComponent(download_link_href) + "%0D";
    if (date)
        b += "%0D" + encodeURIComponent("This file will be available until " + date) + "%0D";
    document.getElementById('upload_link_email').href = "mailto:?body=" + b + "&subject=" + encodeURIComponent(filename);

    // Delete link
    var delete_link = url + 'f.php?h=' + reference + '&amp;d=' + delete_code;
    var delete_link_href = url + 'f.php?h=' + reference + '&d=' + delete_code;
    document.getElementById('delete_link').innerHTML = delete_link;
    document.getElementById('delete_link').href = delete_link_href;

    // Validity date
    if (date)
    {
        document.getElementById('date').innerHTML = date;
        document.getElementById('validity').style.display = '';
    }
    else
        document.getElementById('validity').style.display = 'none';

    // Preview link (if allowed)
    if (!!document.getElementById('preview_link'))
    {
        document.getElementById('upload_finished_preview').style.display = 'none';
        var preview_link = url + 'f.php?h=' + reference + '&amp;p=1';
        var preview_link_href = url + 'f.php?h=' + reference + '&p=1';
        if (crypt_key.length > 0)
        {
            preview_link += '&amp;k=' + crypt_key;
            preview_link_href += '&k=' + crypt_key;
        }

        // Test if content can be previewed
         type = document.getElementById('file_select').files[0].type;
         if (type.indexOf("image") > -1 ||
             type.indexOf("audio") > -1 ||
             type.indexOf("text") > -1 ||
             type.indexOf("video") > -1)
         {
            document.getElementById('preview_link').innerHTML = preview_link;
            document.getElementById('preview_link').href = preview_link_href;
            document.getElementById('upload_finished_preview').style.display = '';
         }
    }

    // Direct download link
    var direct_download_link = url + 'f.php?h=' + reference + '&amp;d=1';
    var direct_download_link_href = url + 'f.php?h=' + reference + '&d=1';
    if (crypt_key.length > 0)
    {
        direct_download_link += '&amp;k=' + crypt_key;
        direct_download_link_href += '&k=' + crypt_key;
    }
    document.getElementById('direct_link').innerHTML = direct_download_link;
    document.getElementById('direct_link').href = direct_download_link_href;


    // Hide preview and direct download link if password is set
    if (document.getElementById('input_key').value.length > 0)
    {
        if (!!document.getElementById('preview_link'))
            document.getElementById('upload_finished_preview').style.display = 'none';
        document.getElementById('upload_direct_download').style.display = 'none';
    }
}

function show_upload_progression (percentage, speed, time_left)
{	
	//Upload list or files pending	
	document.getElementById('current_p_status').style.width = percentage;
	document.getElementById('current_file_name').innerHTML = async_global_file.name;	
	var cSize = bytesToSize(async_global_file.size);	
	document.getElementById('current_file_size').innerHTML = cSize;	
    document.getElementById('uploaded_percentage').innerHTML = percentage;
}

function show_upload_progression_tot (percentage, speed, time_left)
{
	uploaded_progress_circle(percentage); //Show Progress bar  using jquery
	 document.getElementById('uploaded_percentage_tot').innerHTML = percentage;
	 
	 if(async_global_transfered_tot ==0){
		 document.getElementById('up_left_size').innerHTML = "0 byte";
	 }else{
		 document.getElementById('up_left_size').innerHTML = bytesToSize(async_global_transfered_tot);
	 }
	 
	 document.getElementById('up_tot_size').innerHTML = bytesToSize(async_global_total_fileSize);
      document.getElementById('uploaded_speed').innerHTML = speed;
	  document.getElementById('uploaded_time').innerHTML = time_left;
      document.title = 's42.transfer - ' + percentage;
}
function hide_upload_progression ()
{
    document.getElementById('uploaded_percentage').style.display = 'none';
    document.getElementById('uploaded_speed').style.display = 'none';
    document.getElementById('uploaded_time').style.display = 'none';
    document.title = 's42.transfer';
}

function upload_progress (e)
{
    if (e == undefined || e == null || !e.lengthComputable)
        return;

    // Init time estimation if needed
    if (upload_time_estimation_total_size == 0)
        upload_time_estimation_total_size = e.total;

    // Compute percentage
    var p = Math.round (e.loaded * 100 / e.total);
    var p_str = ' ';
    if (p != 100)
        p_str = p.toString() + '%';
    // Update estimation speed
    // Get speed string
    var speed_str = ""; upload_time_estimation_speed_string(); //Closed for total
    speed_str = "";//upload_speed_refresh_limiter(speed_str);
    // Get time string
	
    var time_str =""; //chrono_update(upload_time_estimation_time()); //Closed for total

    show_upload_progression (p_str, speed_str, time_str);
}

function control_selected_file_size(max_size, error_str)
{
	
    f_size = document.getElementById('file_select').files[0].size;
	
    if (max_size > 0 && f_size > max_size * 1024 * 1024)
    {
        pop_failure(error_str);
        document.getElementById('send').style.display = 'none';
    }
    else
    {
		
        document.getElementById('options').style.display = '';
        document.getElementById('send').style.display = '';
        document.getElementById('error_pop').style.display = 'none';
        document.getElementById('file_select').style.left = 'inherit';
        document.getElementById('file_select').style.height = 'inherit';
        document.getElementById('file_select').style.opacity = '0.1';
		
        document.getElementById('add_file_wrapper').style.display = '';
        document.getElementById('text-box').style.display = 'none';
		document.getElementById("file_select").className = "file_select file_select_after";
		document.getElementById('bgImg').style.backgroundImage = 'none';
		
		document.getElementById('file-list-container').style.display = 'block';
		
		document.getElementById("bgImg").className = "";
		
		
		
		

		
    }
}

// Byte covert into KB,MB,GB 
function bytesToSize(bytes) {
   if(bytes >=1073741824) 
	{
	  bytes1 = bytes/1073741824;
	  bytes1 = bytes1.toFixed(2) + ' GB' ;
	}
    else if(bytes >=1048576) 
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
};

function pop_failure (e)
{
    var text = "An error occured";
    if (typeof e !== 'undefined')
        text = e;
    text = "<p>" + text + "</p>";
    document.getElementById('error_pop').innerHTML = e;

    document.getElementById('uploading').style.display = 'none';
    document.getElementById('error_pop').style.display = 'none';
    document.getElementById('upload').style.display = '';
    document.getElementById('send').style.display = '';
}

function add_time_string_to_date(d, time)
{
    if(typeof(d) != 'object' || !(d instanceof Date))
    {
        return false;
    }
    
    if (time == 'minute')
    {
        d.setSeconds (d.getSeconds() + 60);
        return true;
    }
    if (time == 'hour')
    {
        d.setSeconds (d.getSeconds() + 3600);
        return true;
    }
    if (time == 'day')
    {
        d.setSeconds (d.getSeconds() + 86400);
        return true;
    }
    if (time == 'week')
    {
        d.setSeconds (d.getSeconds() + 604800);
        return true;
    }
    if (time == 'month')
    {
        d.setSeconds (d.getSeconds() + 2419200);
        return true;
    }
    if (time == 'year')
    {
        d.setSeconds (d.getSeconds() + 29030400);
        return true;
    }
    return false;
}

function classic_upload (url, file, time, password, one_time, upload_password)
{
	async_global_url  = url; //Assign Global url
	async_global_time = time; //Assign time
	async_global_file =file; 
	
    // Delay time estimation init as we can't have file size				
	if(total_fileSize_global ==0){
	   total_fileSize_global= 1;
       async_global_total_fileSize = document.getElementById('total_Upload_Size').value;	  
	   upload_time_estimation_init_tot(async_global_total_fileSize);	

		//Show upload file from waiting list
	    var totalFilelen1 = document.getElementById('all_txt_file_select').value;		
	    document.getElementById('left_files').innerHTML = totalFilelen1 + " Files remaining" ;
	}
	
	//Hide upload file from waiting list
	var find_ids = removeFromList(async_global_file.name,async_global_file.size);
	$('#'+find_ids).slideUp(1000);

    var req = new XMLHttpRequest ();
    req.upload.addEventListener ("progress", upload_progress, false);
	req.upload.addEventListener ("progress", async_upload_progress_tot, false);
    req.addEventListener ("error", pop_failure, false);
    req.addEventListener ("abort", pop_failure, false);
    req.onreadystatechange = function ()
    {
        if (req.readyState == 4 && req.status == 200)
        {
            var res = req.responseText;
            if (res == "Error")
            {
                pop_failure ();
                return;
            }
			res = res.split ("\n");			
			async_global_link_list.push(res[0]);
			async_global_link_del_list.push(res[1]);
			             
			 //ADD trasfer files size
			 async_global_transfered_tot +=parseInt(async_global_file.size);

			//Set fileCount_global			
			fileCount_global = fileCount_global+1;
			
			 var fileCount = document.getElementById(current_global_file).files.length;	
			 var all_select_fiels = document.getElementById('all_select_fiels').value;

			//Show File uploaded file	or remaining files	
			var totalFilelen = document.getElementById('all_txt_file_select').value;			
			var left_files = totalFilelen - remain_global_file;			
			document.getElementById('left_files').innerHTML =left_files + " Files remaining" ;			
			document.getElementById('done_files').innerHTML =remain_global_file +" Files uploaded!";			
			remain_global_file  = remain_global_file+1;

				if(fileCount ==fileCount_global){				
					all_select_fiels_1 = all_select_fiels.split (",");					
					current_global_file = all_select_fiels_1[0];				
					fileCount_global = 0;
					
					var str = all_select_fiels;
					var arr = str.split(",");
					var fst = arr.splice(0,1).join("");
					var rest = arr.join(",");
					
					document.getElementById('all_select_fiels').value=rest;
					
					
				}else{
					
				}
			
			if(all_select_fiels !="" || fileCount_global>0){				
				classic_upload (async_global_url,
					document.getElementById(current_global_file).files[fileCount_global],
					document.getElementById('select_time').value,
					document.getElementById('input_key').value,
					document.getElementById('one_time_download').checked,
					document.getElementById('upload_password').value
					);
				
				
				
				 var e = e ? e:window.event;
				 return false;
				upload_progress (e);
				
				
						
				
			}else{	
				hide_upload_progression ();
				classic_upload_end() //End classic upload and show download link
				return;
				
			}
			
			
			
			
			
			
        }
    }
    req.open ("POST", url + 'script.php' , true);

    var form = new FormData();
    form.append ("file", file);
    form.append ("file_lenght", fileCount_global);
    if (time)
        form.append ("time", time);
    if (password)
        form.append ("key", password);
    if (one_time)
        form.append ("one_time_download", '1');
    if (upload_password.length > 0)
        form.append ("upload_password", upload_password);

    req.send (form);
}

function check_html5_file_api ()
{
    return window.File && window.FileReader && window.FileList && window.Blob;
}

var async_global_transfered = 0;
var async_global_transfered_tot = 0;
var async_global_url = '';
var async_global_file;
var async_global_ref = '';
var async_global_max_size = 0;
var async_global_time;
var async_global_transfering = 0;
var async_global_transfering_tot = 0;
var async_global_ref_list = new Array; //Store reference in array

var async_global_link_list = new Array; //Store classic link  in array
var async_global_link_del_list = new Array; //Store classic delete link in array

var async_global_total_fileSize =0; //Store all upload file size

var fileCount_global = 0;
var current_global_file="file_select";
var remain_global_file = 1;

var oneTimeRunEnd = 0; //For prevent end function run to mutipal ti
var total_fileSize_global  = 0;

function async_upload_start (url, max_size, file, time, password, one_time, upload_password)
{
    async_global_transfered = 0;
    async_global_url = url;
    async_global_file = file;
    async_global_max_size = max_size;
    async_global_time = time;
	
	//Hide upload file from waiting list
	var find_ids = removeFromList(async_global_file.name,async_global_file.size);
	$('#'+find_ids).slideUp(1000);
    
	var req = new XMLHttpRequest ();
    req.addEventListener ("error", pop_failure, false);
    req.addEventListener ("abort", pop_failure, false);
    req.onreadystatechange = function ()
    {
        if (req.readyState == 4 && req.status == 200)
        {
            var res = req.responseText;
            if (res == "Error")
            {
                pop_failure ();
                return;
            }
            res = res.split ("\n");			
            async_global_ref = res[0];
			
			async_global_ref_list.push(res[0]);
            var code = res[1];
            async_upload_push (code);
        }
    }
    req.open ("POST", async_global_url + 'script.php?init_async' , true);

    var form = new FormData();
    form.append ("filename", async_global_file.name);
    form.append ("type", async_global_file.type);
    if (time)
        form.append ("time", time);
    if (password)
        form.append ("key", password);
    if (one_time)
        form.append ("one_time_download", '1');
    if (upload_password.length > 0)
        form.append ("upload_password", upload_password);

    // Start time estimation				
	if(total_fileSize_global ==0){
	  total_fileSize_global= 1;
        async_global_total_fileSize = document.getElementById('total_Upload_Size').value;	  
		upload_time_estimation_init_tot(async_global_total_fileSize);	

		//Show upload file from waiting list
	    var totalFilelen1 = document.getElementById('all_txt_file_select').value;		
	    document.getElementById('left_files').innerHTML = totalFilelen1 + " Files remaining" ;
	}

    req.send (form);
}

function async_upload_progress (e)
{
    if (e == undefined || e == null || !e.lengthComputable && async_global_file.size != 0)
        return;

    // Compute percentage
	
    var p = Math.round ((e.loaded + async_global_transfered) * 100 / (async_global_file.size));
    var p_str = ' ';
    if (p != 100)
        p_str = p.toString() + '%';
    // Update estimation speed
    
    // Get speed string
    var speed_str = "";//upload_time_estimation_speed_string();
    speed_str = "";//upload_speed_refresh_limiter(speed_str);
    // Get time string
    var time_str =""; //chrono_update(upload_time_estimation_time());

    show_upload_progression (p_str, speed_str, time_str);
}
function async_upload_progress_tot (e) 
{
    if (e == undefined || e == null || !e.lengthComputable && async_global_total_fileSize != 0)
        return;
    
	// Compute percentage	
    var p = Math.round ((e.loaded + async_global_transfered_tot) * 100 / (async_global_total_fileSize));
    var p_str = ' ';
    if (p != 100)
        p_str = p.toString() + '%';
    // Update estimation speed
    upload_time_estimation_add_tot(e.loaded + async_global_transfered_tot);
    // Get speed string
    var speed_str = upload_time_estimation_speed_string();
    speed_str = upload_speed_refresh_limiter(speed_str);
    // Get time string
    var time_str = chrono_update(upload_time_estimation_time());
    show_upload_progression_tot (p_str, speed_str, time_str);
}

function async_upload_push (code)
{
    if (async_global_transfered == async_global_file.size)
    {  
		async_global_transfered = 0;
		code="";		
		
		
		//Set fileCount_global			
		fileCount_global = fileCount_global+1;		
		 var fileCount = document.getElementById(current_global_file).files.length;	
		 var all_select_fiels = document.getElementById('all_select_fiels').value;
 
		//Show File uploaded file	or remaining files	
		var totalFilelen = document.getElementById('all_txt_file_select').value;			
		var left_files = totalFilelen - remain_global_file;			
		document.getElementById('left_files').innerHTML =left_files + " Files remaining" ;			
		document.getElementById('done_files').innerHTML =remain_global_file +" Files uploaded!";			
		remain_global_file  = remain_global_file+1;		  
		if(fileCount ==fileCount_global){
			//alert("Euqal");
			all_select_fiels_1 = all_select_fiels.split (",");				
			current_global_file = all_select_fiels_1[0];				
			fileCount_global = 0;
			
			var str = all_select_fiels;
			var arr = str.split(",");
			var fst = arr.splice(0,1).join("");
			var rest = arr.join(",");				
			document.getElementById('all_select_fiels').value=rest;	
		}else{
			
		}
		
		if(all_select_fiels !="" || fileCount_global>0){		
			async_upload_start (document.getElementById('web_root').value,  document.getElementById('jirafeau_get_max_upload_size_bytes').value,
 		    document.getElementById(current_global_file).files[fileCount_global],
            document.getElementById('select_time').value,
            document.getElementById('input_key').value,
            document.getElementById('one_time_download').checked,
            document.getElementById('upload_password').value
            );
			 var e = e ? e:window.event;
             return false;
			async_upload_progress(e);		
		}else{	
		
			hide_upload_progression ();
			async_upload_end (code);
			return;
			
		}	
    }
    var req = new XMLHttpRequest ();
    req.upload.addEventListener ("progress", async_upload_progress, false);
    req.upload.addEventListener ("progress", async_upload_progress_tot, false);
    req.addEventListener ("error", pop_failure, false);
    req.addEventListener ("abort", pop_failure, false);
    req.onreadystatechange = function ()
    {
        if (req.readyState == 4 && req.status == 200)
        {
            var res = req.responseText;
            if (res == "Error")
            {
                pop_failure ();
                return;
            }
            res = res.split ("\n");
            var code = res[0]
			
			 var t = async_global_transfering-async_global_transfered;
			 async_global_transfered_tot += t;
			 //alert(async_global_transfered_tot);
			 
			 
            async_global_transfered = async_global_transfering;
			
			
            
			
            async_upload_push (code);
        }
    }
    req.open ("POST", async_global_url + 'script.php?push_async' , true);

    var chunk_size = parseInt (async_global_max_size * 0.10);
    var start = async_global_transfered;
    var end = start + chunk_size;
    if (end >= async_global_file.size)
        end = async_global_file.size;
    var blob = async_global_file.slice (start, end);
    async_global_transfering = end;

    var form = new FormData();
    form.append ("ref", async_global_ref);
    form.append ("data", blob);
    form.append ("code", code);
    req.send (form);
}

function async_upload_end (code)
{
    var req = new XMLHttpRequest ();
    req.addEventListener ("error", pop_failure, false);
    req.addEventListener ("abort", pop_failure, false);
    req.onreadystatechange = function ()
    {
        if (req.readyState == 4 && req.status == 200)
        {
            var res = req.responseText;
            if (res == "Error")
            {
                pop_failure ();
                return;
            }			
            if (async_global_time != 'none')
            {
                var d = new Date();
                if(!add_time_string_to_date(d, async_global_time))
                    return;
                show_link_new (async_global_url, res, d.toString());
            }
            else
                show_link_new (async_global_url, res);
        }
    }
    req.open ("POST", async_global_url + 'script.php?end_async' , true);
	
    var form = new FormData();
    form.append ("ref", async_global_ref);
	form.append ("ref_list", async_global_ref_list);
    form.append ("code", code);
    req.send (form);
}


function classic_upload_end ()
{
    var req = new XMLHttpRequest ();
    req.addEventListener ("error", pop_failure, false);
    req.addEventListener ("abort", pop_failure, false);
    req.onreadystatechange = function ()
    {
        if (req.readyState == 4 && req.status == 200)
        {
            var res = req.responseText;
            if (res == "Error")
            {
                pop_failure ();
                return;
            }
            if (async_global_time != 'none')
            {
                var d = new Date();
                if(!add_time_string_to_date(d, async_global_time))
                    return;
                show_link_new (async_global_url, res, d.toString());
            }
            else
                show_link_new (async_global_url, res);
        }
    }
    req.open ("POST", async_global_url + 'script.php?end_classic' , true);

	//alert("async_global_url:-"+async_global_url);
    var form = new FormData();
    
	form.append ("link_list", async_global_link_list);
	form.append ("link_del_list", async_global_link_del_list);
    req.send (form);
}







function upload (url, max_size,total_fileSize)
{
	var isOpera = !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
    // Opera 8.0+ (UA detection to detect Blink/v8-powered Opera)
	
	var isFirefox = typeof InstallTrigger !== 'undefined';   // Firefox 1.0+
	var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
	
		// At least Safari 3+: "[object HTMLElementConstructor]"
	var isChrome = !!window.chrome && !isOpera;              // Chrome 1+
	var isIE = /*@cc_on!@*/false || !!document.documentMode;   // At least IE6

	if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Mac') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {
		isSafari="mac";       
    }
	
	if( isChrome==true || isFirefox==true || isOpera==true || isSafari=='mac')
	{
			if (check_html5_file_api ())
			{
				async_upload_start (url,
					max_size,
					document.getElementById('file_select').files[0],
					document.getElementById('select_time').value,
					document.getElementById('input_key').value,
					document.getElementById('one_time_download').checked,
					document.getElementById('upload_password').value
					
					);
			}
	}
	else if(isSafari ==true) {
		classic_upload (url,
            document.getElementById('file_select').files[0],
            document.getElementById('select_time').value,
            document.getElementById('input_key').value,
            document.getElementById('one_time_download').checked,
            document.getElementById('upload_password').value
            );
	}
    else
    {
		
        classic_upload (url,
            document.getElementById('file_select').files[0],
            document.getElementById('select_time').value,
            document.getElementById('input_key').value,
            document.getElementById('one_time_download').checked,
            document.getElementById('upload_password').value
            );
    }
	
}

var upload_time_estimation_total_size = 42;
var upload_time_estimation_transfered_size = 42;
var upload_time_estimation_transfered_date = 42;
var upload_time_estimation_moving_average_speed = 42;

function upload_time_estimation_init(total_size)
{
    upload_time_estimation_total_size = total_size;
    upload_time_estimation_transfered_size = 0;
    upload_time_estimation_moving_average_speed = 0;
    var d = new Date();
    upload_time_estimation_transfered_date = d.getTime();
}

function upload_time_estimation_init_tot(total_size)
{
    upload_time_estimation_total_size = total_size;
    upload_time_estimation_transfered_size = 0;
    upload_time_estimation_moving_average_speed = 0;
    var d = new Date();
    upload_time_estimation_transfered_date = d.getTime();
}



function upload_time_estimation_add(total_transfered_size)
{
    // Let's compute the current speed
    var d = new Date();
    var speed = upload_time_estimation_moving_average_speed;
    if (d.getTime() - upload_time_estimation_transfered_date != 0)
        speed = (total_transfered_size - upload_time_estimation_transfered_size)
                / (d.getTime() - upload_time_estimation_transfered_date);
				
    // Let's compute moving average speed on 30 values
    var m = (upload_time_estimation_moving_average_speed * 29 + speed) / 30;
	
    // Update global values
    upload_time_estimation_transfered_size = total_transfered_size;
    upload_time_estimation_transfered_date = d.getTime();
    upload_time_estimation_moving_average_speed = m;
}

function upload_time_estimation_add_tot(total_transfered_size)
{
    // Let's compute the current speed
    var d = new Date();
    var speed = upload_time_estimation_moving_average_speed;
    if (d.getTime() - upload_time_estimation_transfered_date != 0)
        speed = (total_transfered_size - upload_time_estimation_transfered_size) / (d.getTime() - upload_time_estimation_transfered_date);
    // Let's compute moving average speed on 30 values
    var m = (upload_time_estimation_moving_average_speed * 29 + speed) / 30;
    // Update global values
    upload_time_estimation_transfered_size = total_transfered_size;
    upload_time_estimation_transfered_date = d.getTime();
    upload_time_estimation_moving_average_speed = m;
}

function upload_time_estimation_speed_string()
{
    // speed ms -> s
	if (navigator.userAgent.indexOf('Safari') != -1) {
		var s = upload_time_estimation_moving_average_speed * 90;       
    }else{
		var s = upload_time_estimation_moving_average_speed * 1000;
	}
    
    var res = 0;
    var scale = '';
    if (s <= 1000)
    {
        /*res = s.toString();
        scale = "o/s";*/
		res = Math.floor(s/10) / 10;
        scale = "BYTE/s";
    }
    else if (s < 1000000)
    {
        res = Math.floor(s/100) / 10;
        scale = "KB/s";
    }
    else
    {
        res = Math.floor(s/100000) / 10;
        scale = "MB/s";
    }
    if (res == 0)
        return '';
    return res.toString() + ' ' + scale;
}

function milliseconds_to_time_string (milliseconds)
{
    function numberEnding (number) {
        return (number > 1) ? 's' : '';
    }
	if (navigator.userAgent.indexOf('Safari') != -1) {
		var temp = Math.floor(milliseconds / 10);       
    }else{
		var temp = Math.floor(milliseconds / 1000);
	}
    
    var years = Math.floor(temp / 31536000);
    if (years) {
        return years + ' ' + translate ('year') + numberEnding(years);
    }
    var days = Math.floor((temp %= 31536000) / 86400);
    if (days) {
        return days + ' ' + translate ('day') + numberEnding(days);
    }
    var hours = Math.floor((temp %= 86400) / 3600);
    if (hours) {
        return hours + ' ' + translate ('hour') + numberEnding(hours);
    }
    var minutes = Math.floor((temp %= 3600) / 60);
    if (minutes) {
        return minutes + ' ' + translate ('minute') + numberEnding(minutes);
    }
    var seconds = temp % 60;
    if (seconds) {
        return seconds + ' ' + translate ('second') + numberEnding(seconds);
    }
    return translate ('less than a second');
}

function upload_time_estimation_time()
{
    // Estimate remaining time
    if (upload_time_estimation_moving_average_speed == 0)
        return 0;
    return (upload_time_estimation_total_size - upload_time_estimation_transfered_size)
            / upload_time_estimation_moving_average_speed;
}

var chrono_last_update = 0;
var chrono_time_ms = 0;
var chrono_time_ms_last_update = 0;
function chrono_update(time_ms)
{
    var d = new Date();
    var chrono = 0;
    // Don't update too often
    if (d.getTime() - chrono_last_update < 1000 &&
        chrono_time_ms_last_update > 0)
        chrono = chrono_time_ms;
    else
    {
        chrono_last_update = d.getTime();
        chrono_time_ms = time_ms;
        chrono = time_ms;
        chrono_time_ms_last_update = d.getTime();
    }

    // Adjust chrono for smooth estimation
    chrono = chrono - (d.getTime() - chrono_time_ms_last_update);

    // Let's update chronometer
    var time_str = '';
    if (chrono > 0)
        time_str = milliseconds_to_time_string (chrono);
    return time_str;
}

var upload_speed_refresh_limiter_last_update = 0;
var upload_speed_refresh_limiter_last_value = '';
function upload_speed_refresh_limiter(speed_str)
{
    var d = new Date();
    if (d.getTime() - upload_speed_refresh_limiter_last_update > 1500)
    {
        upload_speed_refresh_limiter_last_value = speed_str;
        upload_speed_refresh_limiter_last_update = d.getTime();
    }
    return upload_speed_refresh_limiter_last_value;
}



function uploaded_file_remove(current,all_select_fiels){
	
}

function validate_installation_email(){
	if(document.getElementById('input_sender_email').value==''){
		document.getElementById('input_sender_email').placeholder='Please Fill your email address!';
		document.getElementById('input_sender_email').style.border='1px solid red';
		return false;
	}
}





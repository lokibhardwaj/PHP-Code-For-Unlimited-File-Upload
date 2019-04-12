<?php
/*
 *  s42transfer, your web file repository
 *  Copyright (C) 2013
 *  s42transfer <admin@s42.io>
 *  s42transfer <admin@s42.io>
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

/*
 * This stylesheet is the default stylesheet for s42transfer.
 * The content is dynamically generated for easier handling.
 */

 // Check to provide default settings for installation screens
  If(!isset($cfg)){
	global $cfg;
	$cfg['main_color']="#134953";
	$cfg['main_color_light']="#01cefe";

	$cfg['bg_gradient_color1']="#04cdf7"; 
	$cfg['bg_gradient_color2']="#66b754";
	$cfg['logo']="Logo_Normal.png";
	$cfg['logo_retina']="Logo_Retina.png";
	$cfg['logo_resolation']="Logo_Retina.png";
	
	$cfg['typekit_normal']="Arial";
	$cfg['typekit_bold']="Arial";
	$cfg['typekit_optional']="Arial";
	$typekit_normal = $cfg['typekit_normal'];
	$typekit_bold = $cfg['typekit_bold'];
	$typekit_optional = $cfg['typekit_optional'];
	$cfg['web_root']="";
}


header('Content-type: text/css');
include("../../lib/config.local.php");
if($cfg['typekit_fontreplacement']==1){
	$typekit_normal = $cfg['typekit_normal'];
	$typekit_bold = $cfg['typekit_bold'];
	$typekit_optional = $cfg['typekit_optional'];	
}else{
	$cfg['typekit_normal']="Arial";
	$cfg['typekit_bold']="Arial";
	$cfg['typekit_optional']="Arial";
	$typekit_normal = $cfg['typekit_normal'];
	$typekit_bold = $cfg['typekit_bold'];
	$typekit_optional = $cfg['typekit_optional'];
}
?>

/* ==========================================================================
   Summary

   1 = Basic Style
   2 = Copyright
   3 = Options
   4 = Upload
   5 = Terms of service
   6 = Install
   7 = Admin
   8 = Download page
   
   ========================================================================== */

/* ==========================================================================
   1 = Basic Style
   ========================================================================== */

body {
  background: rgba(0, 0, 0, 0) linear-gradient(145deg, <?php echo $cfg['bg_gradient_color1'];?>, <?php echo $cfg['bg_gradient_color2'];?> 96%) repeat scroll 0 0;
  background: rgba(0, 0, 0, 0)-webkit-linear-gradient(145deg, <?php echo $cfg['bg_gradient_color1'];?>, <?php echo $cfg['bg_gradient_color2'];?> 96%) repeat scroll 0 0;
  font-family: "<?php echo $typekit_normal;?>",sans-serif;
  font-size: 17px;
  line-height: 1.5;
  margin: 0;
  color: <?php echo $cfg['main_color'];?>;
  background-attachment: fixed;
}
h1 a {
  display: block;
  background-size: 100% 100%;
  text-indent: -9999px;
  width: 194px;
  height: 0px;
  margin: 0em auto;
  position: relative;
  left: 0.4em;
}
h2 {
  text-align: center;
  color: #795548;
}
/*
#upload, #install {
  padding-top: 1em;
}  */
#install {
  background: #d6d6d6 none repeat scroll 0 0;
}
#install table tr td {
  width: 100%;
}
fieldset {
  border: medium none;
  margin: 0 auto;
  min-height: 30em;
  padding: 0;
  position: relative;
  width: 25em;
}
#text-box {
  float: left;
  width: 100%;
}
.security-box {
  float: left;
  margin: 0 !important;
 
  width: 100%;
}
.set-top{
	padding-top:40px;
}
span.upload {
  color: #ffffff;
  float: left;
  font-size: 32px;
  text-align: center;
  width: 100%;
  position: relative;
  top: 210px;
}
span.upload-sec {
  color: #ffffff;
  float: left;
  font-size: 16px;
  text-align: center;
  width: 100%;
  
 
}




span.drag {
  color: <?php echo $cfg['main_color_light'];?>;
  font-family: <?php echo $typekit_normal;?>;
  float: left;
  text-align: center;
  width: 100%;
  position: relative;
  top: 210px;
 }
 #file_list .fileList:first-child {
  border-bottom: medium none;
  padding: 0;
}
.fileList {
  background: #ffffff none repeat scroll 0 0;
  border-bottom: 1px solid <?php echo $cfg['main_color_light'];?>;
  box-sizing: border-box;
  color: <?php echo $cfg['main_color'];?>;
  float: left;
  padding: 1.7% 0;
  position: relative;
  width: 100%;
}
.f_size {
  float: right;
  padding-right: 2%;
  width:20%;
  text-align:right;
  color: <?php echo $cfg['main_color_light'];?>;
}
.f_name {
    float: left;
    padding-left: 2%;
    width: 68%;
    word-break: break-all;
}
#add_file_wrapper::before {
  background: rgba(0, 0, 0, 0) url("<?php echo $cfg['web_root'];?>media/latest/add_small.svg") no-repeat scroll 95.5% center / auto 100%;
  color: <?php echo $cfg['main_color'];?>;
  content: "Add more files";
  position: absolute;
  width: 100%;
}
#add_file_wrapper:hover::before {
  background: rgba(0, 0, 0, 0) url("<?php echo $cfg['web_root'];?>media/latest/add_small_hover.svg") no-repeat scroll 95.5% center / auto 100%;
}
.dwn-file-list .fileList::before  {
  background: none;
}
.file_list_wrapper .fileList:first-child {
  border-top: 1px solid <?php echo $cfg['main_color_light'];?>;
}
.dwn-file-list .fileList {
  border-bottom: 1px solid #c3c3c3; 
  float: left;
  padding: 1.7% 0;
  width: 100%;
}
.dwn-file-list .fileList::before {
  background: rgba(0, 0, 0, 0) url("<?php echo $cfg['web_root'];?>media/latest/add_small.svg") no-repeat scroll 95.5% center / auto 100%;
  content: '';
}
#add_file_wrapper, .dwn-file-list .fileList {
  border-bottom-width: 1px;
  border-bottom-style: solid;
  border-color: <?php echo $cfg['main_color_light'];?>;
  float: left;
  padding: 1.7% 0;
  width: 100%;
}
#add_file_wrapper {
  border-bottom: 1px solid <?php echo $cfg['main_color_light'];?>;
  float: left;
  padding: 1.7% 2%;
  width: 96%;
}
#add_file_wrapper input[type="file"] {
  cursor: pointer;
  opacity: 0;
  width: 100%;
} 
.download-icon {
  float: right;
  margin-right: 2%;
  width: 5%;
}
.download-icon a.dn-icon {
  background: rgba(0, 0, 0, 0) url("<?php echo $cfg['web_root'];?>media/latest/download.svg") no-repeat scroll center center / auto 100%;
  float: left;
  height: 25px;
  position: relative;
  width: 100%;
}
.download-icon a.dn-icon:hover{
  background: rgba(0, 0, 0, 0) url("<?php echo $cfg['web_root'];?>media/latest/download_activ.svg") no-repeat scroll center center / auto 100%;
}


.download-icon a.dn-icon-pwd {
  background: rgba(0, 0, 0, 0) url("<?php echo $cfg['web_root'];?>media/latest/download.svg") no-repeat scroll center center / auto 100%;
  float: left;
  height: 25px;
  position: relative;
  width: 100%;
}
.download-icon a.dn-icon-pwd:hover{
  background: rgba(0, 0, 0, 0) url("<?php echo $cfg['web_root'];?>media/latest/download_activ.svg") no-repeat scroll center center / auto 100%;
}


.pwd-protection {
  color: <?php echo $cfg['main_color'];?>;
  float: left;
  font-size: 17px;
  margin: 2%;
  width: 96%;
}
.pwd-protection > input {
  float: left;
  position: relative;
  width: 96%;
}

.descrip_title{
	 color: #d0021b;
	  float: left;
}
.descrip {
    float: left;
    font-size: 13px;
    padding-left: 5px;
    padding-top: 3px;
    width: 80%;
}
.descrip_1{
    font-size: 13px;
	 float: left;
	
}


legend {
  padding: 0.5em 1em; 
  background: #efebe9;
  color: #663D1C;
  font-size: 1.2em;
  display: none;
  min-width: 8em;
  text-align: center;
}

table a {
  color: #000;
}

table a:hover,
table a:focus {
  text-decoration: none;
}
.upload-sec select,
input[type="text"],
input[type="password"] {
  
 
  border-left:none;
  border-right:none;
  padding: 6px 2% !important;
  font-size: 16px !important;
  width:96%;
  background:none;
  
}
fieldset.logins-wrapper{
	width:23.5em;
}
.upload-sec-block input[type="text"]{
	color:#fff;
}
.e_txt.pwdtxt{
color:#fff !important;	
}

.sec-pwd {
  border-top:0px solid #01cefe;
  border-bottom: 1px solid #01cefe;
}
.e_txt.sec-pwd.loginError {
  border-top: medium none;
}
.sec-user{
	border-bottom: 1px solid #01cefe;
	border-top: 1px solid #01cefe;
}

.upload-sec-block ::-webkit-input-placeholder { /* Chrome */
   color: #fff;
}
.upload-sec-block :-ms-input-placeholder { /* IE 10+ */
   color: #fff;
}
.upload-sec-block ::-moz-placeholder { /* Firefox 19+ */
  color: #fff;
  opacity: 1;
}
.upload-sec-block :-moz-placeholder { /* Firefox 4 - 18 */
  color: #fff;
  opacity: 1;
}

.upload-sec input::-moz-placeholder, .upload-sec textarea::-moz-placeholder{
	color: #fff;
	
}


select,
input[type="text"],
input[type="password"] {
  border: 1;
  padding: 5px 5px;
  font-size: 1em;
  border:1px solid <?php echo $cfg['main_color'];?>;
  color:<?php echo $cfg['main_color'];?>;
}





.inner {
  margin-top: 3em;
}

#upload fieldset {
  background: <?php echo $cfg['main_color'];?> url("<?php echo $cfg['web_root'];?>media/latest/upload-plus.svg") no-repeat scroll center 35%;
  -webkit-transition: all 0.5s ease;
     -moz-transition: all 0.5s ease;
      -ms-transition: all 0.5s ease;
       -o-transition: all 0.5s ease;
          transition: all 0.5s ease;
}

.upload-click {
  margin-top: 54%;
}
.upload-txt {
  color: #ffffff;
  float: left;
  font-size: 32px;
  text-align: center;
  width: 100%;
}
.click-or-drag {
  color: #01cefe;
  font-size: 17px;
  text-align: center;
  width: 100%;
  float: left;
}

 
/* Drag drop effect*/
.add_file_wrapper._hover1 {
  background-color: #134953;
}

body._drag .bgImg-first::before {
  background: #ffffff url("<?php echo $cfg['web_root'];?>media/latest/upload-plus-hover.svg") no-repeat scroll center 34.3% !important;
  border: 10px solid #134953;
  box-sizing: border-box;
  color: <?php echo $cfg['main_color'];?>;
  content: "Drop it!";
  display: block;
  font-size: 32px;
  left: 0;
  min-height: 100%;
  padding: 217px 0 0;
  position: absolute;
  text-align: center;
  transition: all 0.5s ease 0s;
  width: 100%;
  z-index: 1;
}
#upload > form {
  text-align: center;
}

#file_select {
  background: #ffffff none repeat scroll 0 0;
  color: #134953;
  cursor: pointer;
  font-size: 17px;
  height: 96%;
  left: 0;
  opacity: 0;
  padding: 10px;
  position: absolute;
  top: 0;
  width: 95.2%;
  z-index: 11;
}
#current_upload {
  background: #134953 none repeat scroll 0 0;
  padding: 0;
} 
.cancel_txt_below > a {
  color: <?php echo $cfg['main_color_light'];?>;
  text-decoration: none;
}
.current_upload {
  background: #ffffff none repeat scroll 0 0;
  border-bottom: 1px solid <?php echo $cfg['main_color_light'];?>;
  float: left;
  padding: 1.8% 0;
  position: relative;
  width: 100%;
  display:block;
}
.current_upload:first-child{
	border-bottom: none;
}
#uploading {
  background: <?php echo $cfg['main_color'];?>  none repeat scroll 0 0;
  border: medium none;
  margin: 0 auto;
  padding: 0 !important;
  position: relative;
  width: 25em;
  min-height: 30em;
}
#uploaded_speed {
  color: <?php echo $cfg['main_color_light'];?>;
  position: absolute;
  text-align: center;
  top: 90px;
  width: 100%;
    -ms-transform: rotate(90deg); /* IE 9 */
    -webkit-transform: rotate(90deg); /* Chrome, Safari, Opera */
    transform: rotate(90deg);
  margin-left: -38px;
}
#svg circle {
  stroke-dashoffset: 0;
  transition: stroke-dashoffset 1s linear;
  stroke: #fff;
  stroke-width: 0.3em;
}
#svg #bar {
  stroke: <?php echo $cfg['main_color_light'];?>;
}
#cont {
  display: block;
  height: 200px;
  width: 200px;
  margin: 0em auto;
  border-radius: 100%;
  position: relative;
  top: 30px;
    -ms-transform: rotate(-90deg); /* IE 9 */
    -webkit-transform: rotate(-90deg); /* Chrome, Safari, Opera */
    transform: rotate(-90deg);
}
#cont:after {
  position: absolute;
  display: block;
  height: 160px;
  width: 160px;
  left: 50%;
  top: 50%;
  content: attr(data-pct)"%";
  margin-top: -80px;
  margin-left: -80px;
  border-radius: 100%;
  line-height: 160px;
  font-size: 2em;
  /*text-shadow: 0 0 0.5em black;*/
    -ms-transform: rotate(90deg); /* IE 9 */
    -webkit-transform: rotate(90deg); /* Chrome, Safari, Opera */
    transform: rotate(90deg); 
}
.uploading {
  font-size: 32px;
  margin-top: 11%;
}
.timing-container {
  height: 117px;
  margin-bottom: 9px;
  text-align: center;
  width: 100%;
}
#current_p_bar > span {
    background: <?php echo $cfg['main_color_light'];?> none repeat scroll 0 0;
    float: left;
	height: 5px;
}
#current_p_bar {
  background: #ffffff none repeat scroll 0 0;
  float: left;
  height: 5px;
  width: 100%;
}
#current_p_status {
  max-width: 100%;
}
#left_files {
  float: left;
  font-family: <?php echo $typekit_optional;?>;
  width: 30%;
  margin-right: 0;
  padding-left: 9px;
  text-align: left;
  
}

#done_files {
  float: right;
  font-family: <?php echo $typekit_optional;?>;
  padding-right: 2%;
}
#current_upload .current_file_name, #current_upload .current_file_size {
  padding: 1.5% 2% 1.5% 2%;
  color: <?php echo $cfg['main_color_light'];?>;
}
.current_file_name {
  color: <?php echo $cfg['main_color'];?>; 
  float: left; 
  padding-left: 2%;
  width: 68%;
  text-align:left; 
  word-break: break-all;
}
.current_file_size {
  color: <?php echo $cfg['main_color_light'];?>;
  float: right;
  padding-right: 2%;
  text-align: right;
  width: 19%;
}
#current_file_size.current_file_size {
  color: #ffffff!important;
}
.uplaoding-ht {
  float: left;
  min-height: 1em;
  width: 100%;
}
.files_remaing {
  border-bottom: 0px solid #808080;
  float: left;
  font-size: 13px;
  padding: 1.6% 0;
  width: 100%;
}
.current_upload_wrapper {
  background: <?php echo $cfg['main_color'];?>  none repeat scroll 0 0;
  float: left;
  margin-bottom: 0.8em;
  margin-top: 0;
  position: relative;
  width: 100%;
}
.upload_cancel {
  float: left;
  margin: 2.5% 2.36% 2.5% 1.8%;
  position: relative;
  width: 96%;
} 
.upload_cancel > a {
  background:<?php echo $cfg['main_color'];?>;
  border: 1px solid <?php echo $cfg['main_color_light'];?>;
  color: #ffffff;
  float: left;
  padding: 1.5% 0;
  width: 100%;
}
.upload_cancel > a:hover {
  background: #ffffff none repeat scroll 0 0;
  color: <?php echo $cfg['main_color_light'];?>;
  border: 1px solid <?php echo $cfg['main_color_light'];?>;
  cursor: pointer;
}
#uploaded_time {
  color: <?php echo $cfg['main_color_light'];?>;
  text-align: center;
}

/* ==========================================================================
   2 = Copyright
   ========================================================================== */
.footer {
  margin: 1% auto;
  width: 25em;
  margin-bottom: 7.3%;
  clear: both;
}
.footer-logo {
  background: rgba(0, 0, 0, 0) url("<?php echo $cfg['logo']; ?>") no-repeat scroll 0 0!important;
  float: left;
  height: 90px;
  width: 190px;
}
.footer-logout a{
	font-weight:bold;
}




@media  only screen and (-webkit-min-device-pixel-ratio: 1.5),
        only screen and (   min-moz-device-pixel-ratio: 1.5),
        only screen and (     -o-min-device-pixel-ratio: 3/2),
        only screen and (        min-device-pixel-ratio: 1.5),
        only screen and (min-resolution: 192dpi) {
    .footer-logo {
    	background-image: url("<?php echo $cfg['logo_resolation']; ?>") !important;
   	    width: 190px;
        height: 90px;
        background-size: 100% !important;
	}
}


.donation-btn {
  float: left;
}
#copyright {
  color: <?php echo $cfg['main_color'];?>;
  font-family: <?php echo $typekit_optional;?>;
  float: right;
  font-size: 11px;
  margin: -10px auto 0;
  padding-left: 0;
  text-align: right;
  width: 18em;
}
#copyright > p {
  margin: 0;
}
#copyright a {
  color: <?php echo $cfg['main_color'];?>;
  text-decoration: none;
}
abbr {
  text-decoration: none;
}
#copyright a:hover,
#copyright a:focus {
  text-decoration: underline;
}

/* ==========================================================================
   3 = Options
   ========================================================================== */
/* Chrome n Safari Specific CSS */
@media screen and (-webkit-min-device-pixel-ratio:0) {
#file-list-container {
  min-height: 19.42em!important;
}
.search-container {
  height: 38px!important;	
}
label.emailError{
	font-size: 11px!important;
}
.ad_gen_right select {
  -webkit-appearance: none;
  background: #f3f3f3 url("<?php echo $cfg['web_root'];?>media/latest/select-arrow.svg") no-repeat scroll 90% center;
  margin-left: 0.6em!important;
  margin-top: 0.15em!important;
  padding: 0.6em!important;
}
.ad_gen_right input#name{
	height: 38px!important;
}
.ad_type_txt > label, span.ad_txt{
	padding: 0!important;
}
.total_to_uploads{
	padding: 10px 2.12%!important;
}
.ad_gen_bottom_right select{
  background: rgba(0, 0, 0, 0) url("<?php echo $cfg['web_root'];?>media/latest/select-arrow.svg") no-repeat scroll 94% center ;	
}
.ad_type_txt > label{
  padding: 10px 0!important;
}
span.ad_txt {
margin-top: 13px!important;
}
#add_file_wrapper::before {
  background: rgba(0, 0, 0, 0) url("<?php echo $cfg['web_root'];?>media/latest/add_small.svg") no-repeat scroll right center ;
  background-repeat: no-repeat;
  height: 25px;
  width: 96%;
}
#add_file_wrapper:hover::before {
  background: rgba(0, 0, 0, 0) url("<?php echo $cfg['web_root'];?>media/latest/add_small_hover.svg") no-repeat scroll right center ;
  background-repeat: no-repeat;
  height: 25px;
  width: 96%;
}
.expand_icons_total.down_icon, .expand_icons_total.up_icon, .expand_icon.down_icon, .expand_icon.up_icon{
  background-image:  url("<?php echo $cfg['web_root'];?>media/latest/expand-arrow.svg");
  background-size: 25px;
  height: 25px;
  background-position: center;
  background-repeat: no-repeat;
  margin-top: 4%;
}
#total_to_upload_left {
  width: 33.5%;
}
#expander_total_upload {
  width: 33%;
}
.expand_icons_total.up_icon, .expand_icon.up_icon {
  -webkit-transform: scaleY(-1);
}
.ad_gen_left select{
	line-height: 20px;
}
div.ad_sttng input{
	font-size: 17px;
	color:  <?php echo $cfg['main_color'];?>;
	border: 1px solid <?php echo $cfg['main_color'];?>;
}
input.ad_type_bold, input.ad_type_normal, input.ad_type_optional{
	height: 22px;
}
.ad_stng > input{
	margin-right:0!important;
	height: 30px;
}
span.ad_txt{
	margin-top: 5px!important;
}
.logout input{
	height: 44px!important;
}
p.ad_tpye_content textarea{
	height: 50px;
}
.ad_gen_left select{
  height:38px;
  margin-top:1px;
  -webkit-appearance: none;
  -webkit-border-radius: 0px;
}
div.ad_gen_bottom_right{
	width: 10%;
	-webkit-border-radius: 0px;
}
.ad_gen_bottom_right select {
  -webkit-appearance: none;
  height: 33px;
}
.ad_file_act_del input {
  background: #134953 url("<?php echo $cfg['web_root'];?>media/latest/delete.svg");
  height: 40px;
  width: 40px;
  background-repeat: no-repeat;
  background-position: center;
}
.ad_file_act_sh input {
  background: #04cdf7 url("<?php echo $cfg['web_root'];?>media/latest/delete_link_activ.svg") ;
  height: 40px;
  width: 40px;
  background-repeat: no-repeat;
}
.submit_send, .dn_submit {
  margin: 6.2% 2% 1.9% 1.95%!important;
}

#sendLinks_wrapper form .submit_send {
  float: left;
  margin: 81% 0 0!important;
  width: 100%;
}
#sendLinks_wrapper form#snd_linkForm .submit_send {
  margin-top: 2.4%!important;
  margin-bottom: 2%!important;
}
send_txt input{
	width:56%;
}
.expand_wrappper{
	width: 100%;
}
.done_image {
  background: <?php echo $cfg['main_color'];?>  url("<?php echo $cfg['web_root'];?>media/latest/done.svg") no-repeat scroll center 35%;
  background-size: 44%;
}
.done_del_image {
  background: #134953 url("<?php echo $cfg['web_root'];?>media/latest/done_del.svg") no-repeat scroll center 35%;
  background-size: 44%;
}
}
/* Chrome - Safari Specific CSS  ENDS*/

.file_list_wrapper {
  width: 100%;
}
.expand_wrappper{
	width: 100%;
}

.ad_sttng > input {
  margin-left: 2%;
  height: 2.1em;
  width: 16.2em;
  font-size: 17px;
  float: right;
  color:  <?php echo $cfg['main_color'];?>;
  border: 1px solid <?php echo $cfg['main_color'];?>;
}
#file-list-container {
  background: #ffffff none repeat scroll 0 0;
  display: none;
  float: left;
  min-height: 18.81em;
  position: relative;
  width: 100%;
}

.ad_gen_bottom_right select {
  background-color: #f2f2f2 ;
  line-height: 25px;
}
#options {
  background: #ffffff none repeat scroll 0 0;
  float: left;
  position: relative;
  width: 100%;
}
#options table {
  float: left;
  margin: 0 2%;
  width: 96%;
  position: relative;
}
#options input#send {
  background: <?php echo $cfg['main_color'];?>;
  border: 1px solid rgba(0, 0, 0, 0);
  color: <?php echo $cfg['main_color_light'];?>;
  float: left;
  font-size: 17px;
  font-weight: bold;
  font-family: <?php echo $typekit_bold;?>;
  left: 0;
  margin: 0.62em 2%;
  padding: 2%;
  position: relative;
  width: 96%;
}
#options input#send:hover {
  background: #ffffff none repeat scroll 0 0;
  border: 1px solid <?php echo $cfg['main_color_light'];?>;
  cursor: pointer;
}
#options p {
  float: left;
  margin: 0;
  width: 100%;
}
#options tr {
  color: <?php echo $cfg['main_color'];?>;
}
#option_table tr:nth-child(2n), #option_table tr:nth-child(3n) {
  float: left;
  width: 48.5%;
}
#option_table tr td {
  float: left;
  margin-bottom: 0.5em;
  position: relative;
  width: 100%;
}
#option_table tr td input {
  float: left;
  margin-left: 0;
}

#option_table tr td input[type="checkbox"], .ad_shr_chk input[type="checkbox"] {
  display: none;
}
#one_time_download, #pwdChk, .ad_shr_chk, #ad_typekit_chk, #ad_http_chk, #ad_domain_chk, #remember-me  {
  opacity: 0;
  filter: alpha(opacity=0);
  display: none;
}
#one_time_download + label, #pwdChk + label, .ad_shr_chk + label, #ad_typekit_chk + label, #ad_http_chk + label, #ad_domain_chk + label, #remember-me + label{
    position: relative;
}
#one_time_download + label::before, #pwdChk + label::before, .ad_shr_chk + label::before, #ad_typekit_chk + label::before, #ad_http_chk + label::before, #ad_domain_chk + label::before {
  border: 1px solid <?php echo $cfg['main_color'];?>;
  content: "";
  display: inline-block;
  float: left;
  font-size: 14px;
  height: 14px;
  line-height: 14.5px;
  margin: 4px 8px 0 0;
  text-align: center;
  visibility: visible;
  width: 14px;
}

#one_time_download:checked + label:before, #pwdChk:checked + label:before, .ad_shr_chk:checked + label:before, #ad_typekit_chk:checked + label:before, #ad_http_chk:checked + label:before, #ad_domain_chk:checked + label:before  {
    content: '✔';
	float:left;
	width: 14px;
	height: 14px;
}

#remember-me + label::before{

  border: 1px solid #fff;
  content: "";
  display: inline-block;
  float: left;
  font-size: 14px;
  height: 14px;
  line-height: 14.5px;
  margin: 4px 8px 0 0;
  text-align: center;
  visibility: visible;
  width: 14px;

}
#remember-me:checked + label:before{
	content: '✔';
	float:left;
	width: 14px;
	height: 14px;
	color:#fff;
	
}
.remember-me-block{
color: #fff;
    padding-left: 2%;
    padding-top: 1%;
    width: 95%;
}

#option_table tr td input#input_key {
  background: #ffffff none repeat scroll 0 0;
  border: 1px solid <?php echo $cfg['main_color'];?>;
  padding: 3%;
  margin-top: 3%;
  width: 93%;
  color:<?php echo $cfg['main_color'];?>;
}
#option_table tr td select#select_time {
  -webkit-appearance: none;	
  -moz-appearance: none;
  background-attachment: scroll;
  background-clip: border-box;
  background-image: url("<?php echo $cfg['web_root'];?>media/latest/select-arrow.svg");
  background-origin: padding-box;
  background-position: 95% center;
  background-repeat: no-repeat;
  background-size: 9% auto;
  border: 1px solid <?php echo $cfg['main_color'];?>;
  color: <?php echo $cfg['main_color'];?>;
  float: left;
  margin-top: 3%;
  padding: 2.5%;
  width: 100%;
}
#max_file_size {
  display: none;
}
#option_table tr:nth-child(3n){
	margin-left: 3%;
}
#option_table tr:first-child {
  float: left;
  width: 100%;
  position: relative;
}
#options input[type="submit"] {
  position: relative;
  left: 11.2em;
}

/* ==========================================================================
   4 = Upload
   ========================================================================== */

#upload_finished,
#uploading,
.message,
.info {
  text-align: center;
  color: #fff;
  padding-left: 3em;
}
#uploading .upload_bar {
  margin: 0;
}
#upload_finished > p:nth-child(1) {
  color: #0D9CB2;
  font-weight: bold;
  font-family: <?php echo $typekit_bold;?>;
}
#upload_finished a {
  text-decoration: none;
}
#uploading a {
  font-weight: bold;
  text-decoration: none;
  font-family: <?php echo $typekit_bold;?>;
}
#uploaded_percentage {
  font-size: 2em;
  font-weight: bold;
  font-family: <?php echo $typekit_bold;?>;
}
.error_conttent, .error_content, .upload_cncl, #mail_sent_page {
  position: relative;
  top: 233px;
}
.cancel_txt, .sent_txt {
  float: left;
  width: 100%;
}
.cancel_txt_below, .sent_txt_below {
  float: left;
  text-align: center;
  width: 100%;
}
p.access_error, p.wrong-password, .done_txt, #dvCountDown_done, .dvCountDown_done, .cancel_txt, .sent_txt {
  color: #ffffff;
  font-size: 32px;
  line-height: 1.2em;
  margin: 0;
  padding: 0;
  text-align: center;
}
.done_txt, #dvCountDown_done, .dvCountDown_done{
  line-height: 1.5em;
}
.del_set{
	 float: left;
     width: 100%;
}
.file_not_found .error_conttent .access_error {
  float: left;
  padding: 0 2%;
  width: 96%;
}
.file_not_found{
  background: #134953; 
}
.access_denied {
  background: <?php echo $cfg['main_color'];?>  url("<?php echo $cfg['web_root'];?>media/latest/denied.svg") no-repeat scroll center 35%;
}
a.if_not_redirect {
  color: <?php echo $cfg['main_color_light'];?>;
}
a.if_not_redirect_after_delete{
	 color: <?php echo $cfg['main_color_light'];?>;
}
p.wrong-password, #dvCountDown_done, .link-expire, .link-expire2, .cancel_txt_below, .sent_txt_below, .dvCountDown_done{
  font-size: 17px; 
  color: <?php echo $cfg['main_color_light'];?>;
  
}
.link-expire, .link-expire2{
  margin: 0;
  text-align: center;
}
span.done_txt {
  float: left; 
  margin-top: 10%;
  width: 100%;
  position: relative;
}
#dvCountDown_done > span {
  margin-right: 4px;
}

.dvCountDown_done > span {
  margin-right: 4px;
}

#upload_done_download_page {
  position: relative;
  top: 6px;
}
.upload_done_download_page {
  position: relative;
  top: 6px;
}
.cancel_container, #mail_sent {
  background: <?php echo $cfg['main_color'];?>  url("<?php echo $cfg['web_root'];?>media/latest/error.svg") no-repeat scroll center 35%;
  height: 30em;
  margin: 0 auto;
  width: 25em;
}
#mail_sent {
  background: <?php echo $cfg['main_color'];?>  url("<?php echo $cfg['web_root'];?>media/latest/email.svg") no-repeat scroll center 35%;
}
#upload_done, .link-expired, #del_done{
  background: <?php echo $cfg['main_color'];?> ;
  border: medium none;
  margin: 0 auto;
  min-height: 30em;
  padding: 0;
  position: relative;
  width: 25em;
}
.done_image {
  background: <?php echo $cfg['main_color'];?>  url("<?php echo $cfg['web_root'];?>media/latest/done.svg") no-repeat scroll center 35% / 44% auto;
  float: left;
  height: 186px;
  position: relative;
  top: 30px;
  width: 100%;
}
.done_del_image {
	background-color: <?php echo $cfg['main_color'];?>  ;
  background:url("<?php echo $cfg['web_root'];?>media/latest/done_del.svg") no-repeat scroll center 100% / 15% auto;
  float: left;
  height: 186px;
  position: relative;
  top: 30px;
  width: 100%;
}
#upload_image_email {
  padding-left: 20px;
  margin-left: 10px;
  background: url(<?php echo $cfg['web_root'];?>media/latest/email.png) no-repeat;
}
#content {
  padding-top: 1em;
}
.delete_links > span {
  margin-bottom: 2.45%;
}
#dvCountDown, .delete_links > span {
  color: <?php echo $cfg['main_color'];?>;
  width: 100%;
  float: left;
  text-align: left;
}
.if_not_redirect_af_del{
	border:none !important;
	color: <?php echo $cfg['main_color'];?> !important;
	background:none !important;
	float:none !important;
}
.if_not_redirect_af_del:hover{
	border:none !important;
	color: <?php echo $cfg['main_color'];?> !important;
	background:none !important;
	
}
#upload_finished, #sendLinks_wrapper {
  background: #ffffff ;
  border: medium none;
  margin: 0 auto;
  min-height: 30em;
  padding: 0;
  position: relative;
  width: 25em;
}
#upload_finished_download_page > p.upload-complete, #sendLinks_wrapper .send-links, .download-img, p.download-title {
  color: <?php echo $cfg['main_color_light'];?>;
  float: left;
  font-size: 32px;
  font-weight: normal !important;
  margin: 4% 0;
  text-align: center;
  width: 100%;
}
.link-expired {
  background: #134953 url("<?php echo $cfg['web_root'];?>media/latest/expired.svg") no-repeat scroll center 35%;
}
.file_not_found {
  background: <?php echo $cfg['main_color'];?>  url("<?php echo $cfg['web_root'];?>media/latest/expired.svg") no-repeat scroll center 35%;
}
.dwn-file-list .f_size {
  padding-right: 2%;
}
.dn_txt, .terms-And-Conditin {
  color: <?php echo $cfg['main_color'];?>;
  float: left;
  font-size: 13px;
  margin: 0 2%;
  width: 96%;
}
.terms-And-Conditin a{
  color: <?php echo $cfg['main_color'];?>;
}
.dwn-file-list .file_list_wrapper {
  float: left;
  margin-bottom: 0.3em;
  min-height: 18.6em;
  width: 100%;
}
p#upload_link {
  background: #ffffff none repeat scroll 0 0;
  float: left;
  margin-top: 0;
  margin-bottom: 3%;
  width: 100%;
}
.download_links {
  width: 100%;
  float: left;
}
.download_links span, .send_txt {
  float: left;
  text-align: left;
  width: 100%;
  border-top: 1px solid <?php echo $cfg['main_color_light'];?>;
}
#sendLinks_wrapper form {
  background: #ffffff none repeat scroll 0 0;
  float: left;
  margin-bottom: 3%;
  position: relative;
  width: 100%;
}
.download_link:last-child {
  border-bottom: 1px solid <?php echo $cfg['main_color_light'];?>;
}
form .send_txt.login_txt {
  border-top: 1px solid <?php echo $cfg['main_color_light'];?>;
  border-bottom: 1px solid <?php echo $cfg['main_color_light'];?>;
}
form input#admin_password {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0 !important;
  margin: 0 2%;
  width: 93%;
}
.download_links span a, .send_txt input, .send_txt textarea, #admin_password{
  background:rgba(0, 0, 0, 0) url("<?php echo $cfg['web_root'];?>media/latest/share.svg") no-repeat scroll 98.8% center;
  color: <?php echo $cfg['main_color'];?>;
  float: left;
  padding: 1.5% 2%;
  width: 96%;
}
.download_links span .download_btn{
   background:rgba(0, 0, 0, 0) url("<?php echo $cfg['web_root'];?>media/latest/share.svg") no-repeat scroll 98.8% center;
  color: <?php echo $cfg['main_color'];?>;
  float: left;
  padding: 1.5%;
  width: 100%;
  border:none;
  font-size:17px;
  cursor:pointer;
  text-align:left;
	
}
.download_links span .download_btn:hover{
  background: rgba(0, 0, 0, 0) url("http://www.web-hike.com/Jirafeau-master/media/latest/share_active.svg") no-repeat scroll 98.8% center;
}


.download_links span a:hover{
  background: rgba(0, 0, 0, 0) url("<?php echo $cfg['web_root'];?>media/latest/share_active.svg") no-repeat scroll 98.8% center;
}
.send_txt input::-moz-placeholder, .send_area textarea::-moz-placeholder{
	color: <?php echo $cfg['main_color'];?>;
	opacity:1; 
}
#sendLinks_wrapper form .submit_send {
  float: left;
  margin: 79% 0 0;
  width: 100%;
}
#sendLinks_wrapper form#snd_linkForm .submit_send {
  margin-top: 0.5%;
  margin-bottom: 2%;
}
#sendLinks_wrapper form#snd_linkForm .submit_send input {
  width: 96%;
  margin: 0 2%;	
}
.send_txt input, .send_txt.send_area textarea {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  width: 52%;
}
.send_txt.send_area textarea {
	width: 96%;
}
label.emailError {
  color: #d0021b;
  font-family: <?php echo $typekit_optional;?>;
  font-size: 11px;
  padding: 2% 2%;
  float: left;
  width: auto;
}
.send_area label.error {
  color: #d0021b;
  font-family: <?php echo $typekit_optional;?>;
  float: right;
  font-size: 11px;
  margin-bottom: 1%;
  margin-right: 2%;
}
#snd_linkForm #mail_result {
  color: #d0021b;
  width: 98%;
  float: left;
  margin-left: 2%;
}
label.emailValid {
  background: rgba(0, 0, 0, 0) url("<?php echo $cfg['web_root'];?>media/latest/emailvalid.svg") no-repeat scroll right center / auto 65%;
  float: right;
  margin-right: 2%;
  padding: 17px;
}
.send_txt a.remove_field{
  background: rgba(0, 0, 0, 0) url("<?php echo $cfg['web_root'];?>media/latest/close_1.svg") no-repeat scroll right center / auto 65%;
  float: right;
  margin-right: 2%;
  height: 30px;
  padding: 2px 0;
  width: 28px;
  font-size: 0;
}
.send_txt textarea {
  font-family: arial;
  font-size: 17px;
  height: 13.26em;
  resize: none;
}
.download_links span.prr_img, .download_links span.img_preview {
  border: none;
  width: auto;
  float:left;
}
.download_links span.img_preview {
  margin-left: 10px;
  word-break: break-all;
  width: 70%;
  text-decoration:underline;
}
.submit_send, .dn_submit { 
  float: left;
  margin: 5.1% 2% 1.9% 1.95%;
  width: 96%;
}
.submit_send{
  margin: 0 2% 1.9% 1.95%;
}
.dn_submit input#submit_download {
  color: #ffffff !important;
  font-size: 17px;
}
.dn_submit input#submit_download:hover {
  background: #ffffff none repeat scroll 0 0;
  border: 1px solid <?php echo $cfg['main_color_light'];?>;
  color: <?php echo $cfg['main_color_light'];?>!important;
  cursor: pointer;
}
.submit_send input#send_btn, .dn_submit input#submit_download, .add_field_button {
  background: <?php echo $cfg['main_color'];?> none repeat scroll 0 0;
  border: 1px solid transparent;
  color: <?php echo $cfg['main_color_light'];?>;
  float: left;
  font-weight: bold;
  font-family: <?php echo $typekit_bold;?>;
  margin: 0;
  padding: 1.5% 0;
  width: 100%;
}
 .add_field_button {
  background: <?php echo $cfg['main_color'];?> none repeat scroll 0 0;
  border: 1px solid transparent;
  color: <?php echo $cfg['main_color_light'];?>;
  float: left;
  font-weight: bold;
  font-family: <?php echo $typekit_bold;?>;
  margin: 0 2% 2%;
  padding: 1% 0;
  width: 95.5%;      
  text-align: center;  
  text-decoration: none;
}
.submit_send input#send_btn:hover, .add_field_button:hover {
  background: #ffffff none repeat scroll 0 0;
  border: 1px solid <?php echo $cfg['main_color_light'];?>;
  cursor: pointer;
}
.send_txt-total {
  border-bottom: 1px solid <?php echo $cfg['main_color_light'];?>;
  color: <?php echo $cfg['main_color'];?>;
  float: left;
  font-size: 13px;
  text-align: right;
  width: 100%;
}
.txt-total {
  float: left;
  font-weight: bold;
  font-family: <?php echo $typekit_bold;?>;
  margin: 0 2%;
  width: 96%;
}
.send_txt.f_list {
  border: medium none;
  color: <?php echo $cfg['main_color'];?>;
  font-family: <?php echo $typekit_optional;?>;
  float: left;
  font-size: 13px;
  margin: 3% 2%;
  width: 96%;
}
.snd_fileSize {
  color: <?php echo $cfg['main_color_light'];?>;
  font-family: <?php echo $typekit_optional;?>;
  float: right;
  width:18%;
  text-align: right;
}
.snd_fileName {
  float: left;
  width: 82%;
  word-break: break-all;
}
.send-links-ht {
  float: left;
  min-height: 18.4em;
  width: 100%;
}
.send_links {
  float: left;
  margin: 5% 0 0;
  padding: 0 2%;
  width: 96%;
}
.send_links > a, .submit_send > input {
  background: <?php echo $cfg['main_color'];?> none repeat scroll 0 0;
  color: <?php echo $cfg['main_color_light'];?>;
  float: left;
  font-weight: bold;
  font-family: <?php echo $typekit_bold;?>;
  padding: 1.5% 0;
  width: 99.5%;
  border: 1px solid transparent;
}
.submit_send > input{
	background: <?php echo $cfg['main_color'];?>;
	color: <?php echo $cfg['main_color_light'];?>;
}
form .submit_send > input {
  float: left;
  font-size: 17px;
  margin: 0 2%;
  width: 96%;
  border: 1px solid transparent;
}
form .submit_send > input:hover{
  background:  #ffffff none repeat scroll 0 0;
  border: 1px solid <?php echo $cfg['main_color_light'];?>;
  cursor: pointer;
  color: <?php echo $cfg['main_color_light'];?>;
  
}

form .submit_login > input {
  float: left;
  font-size: 17px;
  margin: 0 2%;
  width: 96%;
  border: 1px solid #fff;
  background:  #ffffff none repeat scroll 0 0;
  padding:2%;
}

form .submit_login > input:hover{
  
  background:  #ffffff none repeat scroll 0 0;
  border: 1px solid <?php echo $cfg['main_color_light'];?>;
  cursor: pointer;
  color: <?php echo $cfg['main_color_light'];?>;
   padding:2%;
   float: left;
  font-size: 17px;
  margin: 0 2%;
  width: 96%;
  
}
.sec-fields label{
	display:none !important;
}

.submit_login {
  float: left;
  padding-top: 31px;
  width: 100%;
}
.upload-sec-block .error {
  display: none !important;
}
.e_txt.loginError {
  border: 1px solid #d0021b;
  border-left: 0px solid #d0021b;
  border-right: 0px solid #d0021b;
 
}



form #admin_password {
  border: none;
}

.send_links > a:hover {
  background: #ffffff none repeat scroll 0 0;
  border: 1px solid <?php echo $cfg['main_color_light'];?>;
}
#validity {
  color: <?php echo $cfg['main_color'];?>;
  float: left;
  font-size: 13px;
  margin: 2% 2% 0;
  text-align: left;
  width: 96%;
}
 #validity p{
   margin: 0;
}
.delete_links {
  float: left;
  margin: 2.45% 2% 2%;
  width: 96%;
}
.delete_links a {
  border: 1px solid <?php echo $cfg['main_color_light'];?>;
  color: <?php echo $cfg['main_color_light'];?>;
  float: left;
  font-weight: bold;
  font-family: <?php echo $typekit_bold;?>;
  padding: 1.5% 0;
  width: 99.5%;
}
.delete_links a:hover {
  background: <?php echo $cfg['main_color'];?> none repeat scroll 0 0;
  border: 1px solid rgba(0, 0, 0, 0);
  color: <?php echo $cfg['main_color_light'];?>;
}
#content form fieldset { 
  background: #ffffff;
}



/*********************************  Circle bouncing effect************************************/

svg {
  animation: scaleup .5s 0s 1 ease-in-out forwards;

  circle {
    stroke: @primary;
    fill: none;
    &:last-of-type {
      opacity: 0;
      stroke: #ddd;
      //animation-fill-mode: forwards;
      transition: stroke-dashoffset .5s ease-out;
    }
  }
  
  .complete & {
    animation-name: scaledown;
  }
}
@keyframes rotatefull {
  0% {
    transform: translate3d(-50%, 0, 0) rotate(0);
  }
  20% {
    transform: translate3d(-50%, 0, 0) rotate(72deg);
  }
  40% {
    transform: translate3d(-50%, 0, 0) rotate(144deg);
  }
  60% {
    transform: translate3d(-50%, 0, 0) rotate(216deg);
  }
  80% {
    transform: translate3d(-50%, 0, 0) rotate(288deg);
  }
  99%, 100% {
    transform: translate3d(-50%, 0, 0) rotate(360deg);
  }
}

@keyframes scaleup {
  0% {
    transform: scale(.1);
    opacity: 0;
  }
  20% {
    opacity: 1;
  }
  72% {
    transform: scale(1.1);
  }
  84% {
    transform: scale(.95);
  }
  98% {
    transform: scale(1);
  }
  99% {
    transform: scale(1);
  }
  100% {
    transform: scale(1);
  }  
}

@keyframes scaledown {
  0% {
    transform: scale(1);
    opacity: 1;
  }
  15% {
    transform: scale(1.2);
  }
  60% {
    opacity: 1;
  }
  99%, 100% {
    transform: scale(.1);
    opacity: 0;
  }
  
}


/********************************* END   Circle bouncing effect************************************/











/* ==========================================================================
   5 = Terms of service
   ========================================================================== */
.terms-containers {
  background: #ffffff none repeat scroll 0 0;
  height: 73.5em;
  margin: 0 auto;
  overflow: auto;
  position: relative;
  width: 25em;
}
.terms-containers h1 {
  color: <?php echo $cfg['main_color'];?>;
  float: left;
  font-size: 17px;
  margin: 2% 0 2% 2%;
  padding-bottom: 0;
  padding-right: 0;
  padding-top: 0;
  width: 98%;
}
textarea[readonly="readonly"] {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: 0 none;
  color: <?php echo $cfg['main_color'];?>;
  display: block;
  float: left;
  font-family: Arial,sans-serif;
  font-size: 13px;
  line-height: 1.5em;
  margin: 0 0 0 2%;
  padding: 0;
  position: relative;
  resize: none;
  width: 98%;
}
textarea[readonly="readonly"] + p,
textarea[readonly="readonly"] + p + p {
  text-align: center;
  color: #795548;
}

textarea[readonly="readonly"] + p a,
textarea[readonly="readonly"] + p + p a {
  font-weight: bold;
  text-decoration: none;
  color: #795548;
}

textarea[readonly="readonly"] + p a:hover,
textarea[readonly="readonly"] + p + p a:hover,
textarea[readonly="readonly"] + p a:focus,
textarea[readonly="readonly"] + p + p a:focus {
  text-decoration: underline;
}

/* ==========================================================================
   6 = Install
   ========================================================================== */
#install fieldset {
  margin-top: 7%;
}
.b-install {
  background: #D6D6D6;
}
.footer-install {
  margin: 0 auto 6em;
  width: 56em;
}
.footer-install #copyright a {
  color: #000000;
}
.footer-install #copyright{
	margin: 0;
}
.footer-install .footer-logo {
  color: #000000;
  font-size: 11px;
  margin: 13px 0 0;
}
#install table tr td.info.set-website-url, #install table tr td.info.set-website-url-admin {
  padding-bottom: 0;
  padding-top: 0;
}
.info.set-website-url-admin {
  width: 98%!important;
}
.info.set-website-url > a, .info.set-website-url-admin > a {
  color: #01cefe;
  font-size: 32px;
  text-decoration: none;
}
.info.set-website-url-admin span {
  color: <?php echo $cfg['main_color'];?>;
}
/*==install tabs==*/
.step-active, .step-disabled {
  background: #9b9b9b none repeat scroll 0 0;
  color: #ffffff;
  float: left;
  height: 28px;
  margin-left: 0.5%;
  padding: 6px 0;
  text-align: center;
  width: 11%;
}
.step-active {
  background: #ffffff none repeat scroll 0 0 !important;
  color: #4a4a4a !important;
}
#install table tr:first-child {
  background: #d6d6d6 none repeat scroll 0 0;
  border: 0 none;
  margin: 0;
  padding: 0;
}
#install table tr:first-child td span:first-child {
  margin-left: 0;
}
#install table tr:first-child td {
  position: relative;
  padding: 0;
  width: 100%;
  border: none;
}

/*==install tabs ends==*/

#install fieldset, #install + fieldset {
  background: #ffffff none repeat scroll 0 0;
  max-width: 56em;
  min-height: 30em;
  width: auto;
}

#install table,
#install + fieldset table {
  width: 100%;
  border-collapse: collapse;
}

#install td,
#install + fieldset td {
  padding: 0.5em 0.5em;
  border-bottom: 0;
}
#install table tr td.step-heading {
  color: #9b9b9b;
  font-size: 32px;
  text-align: center;
}
#install table tr td.label label {
  color: #000000;
  font-weight: bold;
}
#install table tr td.field input#admin_password {
  border: 1px solid #000000;
  color: #000000;
  margin: 0;
  padding: 8px 5px;
  width: 42%;
}
.field > input#admin_password::-moz-placeholder, input#input_sender_email::-moz-placeholder, input#input_sender_name::-moz-placeholder {
  opacity: 1;
  color: #000000;
}
#install table tr td.info.pass, #install table tr td.info.choose-lang {
  padding-top: 0;
  width: 65%;
}
#install fieldset > form {
  margin-top: 2em;
  text-align: center;
}

#install form {
  display: table;
  width: 100%;
}

#install table tr td.steps {
  color: #9b9b9b;
  float: left;
  font-size: 32px;
  margin-top: 0.5em;
  padding: 0;
  text-align: center;
}
#install table tr td.info {
  color: #4a4a4a;
  float: left;
  text-align: left;
  width: 65%;
}
tr.dat-dir {
  float: left;
  margin-top: 2.5%;
}
.url-btn {
  float: left;
  margin-top: 1.9%;
  width: 100%;
}
tr.url-btn > td {
  float: left;
  width: 98.3% !important;
}
#install table tr td.field {
  float: left;
  margin-top: 2%;
  width: 98%;
}
#install table tr td.info.base {
  width: 70%;
  padding-top: 0px;
}
input.navright {
  float: right !important;
  text-align: center!important;
}
.navright.url-nxt {
  text-align: center;
}
#install table tr td.field select {
  -moz-appearance: none;
  -webkit-appearance: none;
  background: rgba(0, 0, 0, 0) url("<?php echo $cfg['web_root'];?>media/latest/language-arrow.svg") no-repeat scroll 97% center / auto 30%;
  border: 1px solid #000000 !important;
  cursor: pointer;
  margin-top: 1%;
  padding: 8px 5px;
  width: 44%;
}
#admin_password {
  border: 1px solid #134953;
  padding: 9px 5px;
  width: 47%;
}
#install input[type="submit"] {
  background: #000000 none repeat scroll 0 0;
  border: medium none;
  color: #ffffff;
  float: left;
  font-family: <?php echo $typekit_bold;?>;
  font-size: 17px;
  font-weight: bold;
  margin: 0;
  min-width: 9em;
  padding: 10px 0;
  cursor: pointer;
  border: 1px solid transparent;  
  text-align: center;
}
#install input[type="submit"]:hover{
  background: #ffffff none repeat scroll 0 0;
  border: 1px solid #000000;
  color: #000000;
}
#install table tr.nav td.adm-pas.next {
  float: left;
  margin-top: 3.9%;
  width: 98.3%;
}
td.here-enter {
  color: #4a4a56;
  padding-top: 0!important;
}
#install table tr.nav td.adm-pas.next .next-right {
  float: right;
}
.field.email-pad {
  padding-bottom: 0 !important;
  padding-top: 0 !important;
}
.ad_sttng label.error {
  color: #d0021b;
  float: right;
  margin: 1% 0;
  text-align: right;
  width: 100%;
}
#install table tr td.label { 
  padding-bottom: 0;
  float:left;
}
#install table tr td.info.padd-top {
  padding-top: 0;
}
.f-right, input.navright {
  float: right;
}
#install table tr.nav {
  float: left;
  margin-top: 19.5%;
  width: 100%;
}
#install + fieldset table {
  font-size: 0.9em;
}
#install input.navleft {
  background: #D6D6D6;
}
#install table tr.url-padd {
  float: left;
  margin-bottom: 1.3%;
  width: 100%;
}
#install table tr td.field input#input_web_root, #install table tr td.field input#input_var_root, #install table tr td.email input#input_email, #install table tr td.sender-name input#input_sender_name, .field input#input_sender_email, .field > input#input_sender_name {
  background: #f2f2f2 none repeat scroll 0 0;
  border: medium none;
  padding: 9px 5px;
  width: 71%;
}
#install table tr.email-btns td {
  float: left;
  width: 98.2% !important;
}
#install table tr td input.navright.skip {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: 1px solid #000000;
  color: #000000;
  margin-right: 0.7em;
}
#install table tr td input.navright.skip:hover{
  background: #000000;
  color: #ffffff;
}
.email-btns {
  float: left;
  margin-top: 21.4%;
  width: 100%;
}
.install-cmplt {
  font-weight: bold;
  font-family: <?php echo $typekit_bold;?>;
  padding-bottom: 0 !important;
}
.set-website{
  padding-top:0!important;
  }
#install + fieldset td:first-child input[type="submit"] {
  background: none;
  padding: 0;
  color: #000;
  font-weight: bold;
  font-family: <?php echo $typekit_bold;?>;
  border-bottom: 0;
}

#install + fieldset td:first-child input[type="submit"]:hover,
#install + fieldset td:first-child input[type="submit"]:focus {
  text-decoration: underline;
}


/* ==========================================================================
   7 = Admin
   ========================================================================== */

#admin fieldset,
#admin + fieldset {
  width: auto;
  max-width: 50em;
  border: 7px dashed #bcaaa4;
}

#admin table,
#admin + fieldset table {
  width: 100%;
  border-collapse: collapse;
  border-bottom: 2px solid #FFF;
}

#admin td,
#admin + fieldset td {
  padding: 0.5em 1em;
  border: 2px solid #FFF;
  border-bottom: 0;
}

#admin td:empty {
  width: 13.1em;
}

#admin table form:nth-child(odd),
#admin + fieldset tr:nth-child(odd) {
  background: #bcaaa4;
}

#admin fieldset > form {
  margin-top: 2em;
  text-align: center;
}

#admin form {
  display: table;
  width: 100%;
}

#admin td:last-child { text-align: left; }

#admin .info { width: 19em; }

#admin input[type="submit"] {
  min-width: 10.5em;
}

#admin + fieldset table {
  font-size: 0.9em;
}

#admin + fieldset td:first-child input[type="submit"] {
  background: none;
  padding: 0;
  color: #000;
  font-weight: bold;
  font-family: <?php echo $typekit_bold;?>;
  border-bottom: 0;
}
#ad_list_wrapper .ad_single_cover .ad_file_name input[type="submit"]{
  background: none;
  border: none;
}
.ad_type_txt label {
  padding-left: 2% !important;
}
#admin + fieldset td:first-child input[type="submit"]:hover,
#admin + fieldset td:first-child input[type="submit"]:focus {
  text-decoration: underline;
}
.footer.admin {
  margin: 0 auto 6%;
  padding-top: 2%;
  width: 96%;
}

/* ==========================================================================
   8 = Download page
   ========================================================================== */

#self_destruct {
  font-weight: bold;
  color: red;
  font-family: <?php echo $typekit_bold;?>;
  background-image: url('<?php echo $cfg['web_root'];?>media/latest/pixel_bomb.png');
  background-size: 40px 40px;
  background-repeat: no-repeat;
  padding-left: 40px;
  padding-top: 10px;
  padding-bottom: 10px;
}

/* ==========================================================================
   Admin- Installation
   ========================================================================== */
   
   
   /* ==========================================================================
   Admin- CSS
   ========================================================================== */
#tab-container {
  float: left;
  margin: 0 2%;
  width: 96%;
}
.etabs {
  float: left;
  margin: 0;
  padding: 0;
  width: 80%;
}
.tab {
  background: <?php echo $cfg['main_color'];?> none repeat scroll 0 0;
  display: inline-block;
}
.tab a.active {
  color: <?php echo $cfg['main_color'];?>;
}
.logout {
  float: left;
  position: relative;
  width: 20%;
}
.logout input {
  background: <?php echo $cfg['main_color_light'];?> none repeat scroll 0 0;
  border: medium none;
  color: <?php echo $cfg['main_color'];?> !important;
  float: right;
  padding: 0!important;
  width: 68%;
  height: 44px;
}
.logout input:hover {
  background: <?php echo $cfg['main_color'];?> none repeat scroll 0 0;
  color: <?php echo $cfg['main_color_light'];?>!important;
  cursor: pointer;
}
.tab a, .logout input {
  color: <?php echo $cfg['main_color_light'];?>;
  font-family: <?php echo $typekit_normal;?>;
  display: block;
  font-size: 17px;
  line-height: 2em;
  outline: medium none;
  padding: 0.3em 3.5em;
  text-decoration: none;
}
.tab.active {
  background: #ffffff none repeat scroll 0 0;
  border: medium none;
  position: relative;
}
.tab-container .panel-container { background: #fff; border: solid #666 1px; padding: 10px; -moz-border-radius: 0 4px 4px 4px; -webkit-border-radius: 0 4px 4px 4px; }
.panel-container { margin-bottom: 10px; }
.tab_content {
  background-color: #ffffff;
  float: left;
  width: 100%;
}
#tabs1-gen h2 {
  color: <?php echo $cfg['main_color_light'];?>;
  float: left;
  font-size: 32px;
  font-family: <?php echo $typekit_normal;?>;
  font-weight: normal;
  margin-bottom: 0;
  margin-top: 0;
  margin: 0.3em 0; 
  text-align: center;
  width: 100%;
}
.edit_label, .search_label {
  float: left;
  font-weight: bold;
  width: 100%;
  font-family: <?php echo $typekit_bold;?>;
}
.ad_gen_left select, .ad_gen_right input#name {
  -moz-appearance: none;
  background: rgba(0, 0, 0, 0) url("<?php echo $cfg['web_root'];?>media/latest/select-arrow.svg") no-repeat scroll 97% center / auto 50%;
  border: 1px solid <?php echo $cfg['main_color'];?> ;
  color: <?php echo $cfg['main_color'];?>;
  float: left;
  font-weight: normal;
  padding-left: 5px;
  width: 85%;
}
.ad_gen_right input#name {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  cursor: default;
  margin-left: 0;
  width: 76%;
  border: none;
}
.search-container {
  float: left;
  width: 83%;
  height: 40px;
  border: 1px solid <?php echo $cfg['main_color'];?>;
}
.ad_gen_right select {
  -moz-appearance: none;
  background: #f3f3f3 url("<?php echo $cfg['web_root'];?>media/latest/select-arrow.svg") no-repeat scroll 90% center / auto 36%;
  border: medium none;
  color: <?php echo $cfg['main_color'];?>;
  font-family: <?php echo $typekit_optional;?>;
  float: left;
  font-size: 13px;
  position: relative;
  width: 22%;
  padding: 0.58em;
  margin-left: 0.5em;
  margin-top: 0.24em;
}
.ad_gen_right select option {
  -moz-appearance: none;
  border-right: 2px solid #808080;
  outline: medium none;
}
.ad_gen_wp {
  float: left;
  margin: 0 1%;
  width: 98%;
}
.ad_gen_left input {
  padding: 1.4% 4%!important;
}
.ad_gen_left input, .ad_gen_right input {
  background: <?php echo $cfg['main_color'];?> none repeat scroll 0 0;
  border: medium none;
  box-sizing: border-box;
  color: <?php echo $cfg['main_color_light'];?>;
   border: 1px solid rgba(0, 0, 0, 0);
  float: left;
  font-size: 17px;
  font-weight: bold;
  font-family: <?php echo $typekit_bold;?>;
  margin-left: 1%;
  padding: 1.4% 2%;
  position: relative;
  cursor: pointer;
}

.ad_gen_left input:hover, .ad_gen_right input:hover{
  background: #ffffff none repeat scroll 0 0;
  border: 1px solid <?php echo $cfg['main_color_light'];?>;	
}

.ad_single_cover:first-child {
  height: auto;
}
.ad_list_wrapper {
  border: medium none !important;
  color: <?php echo $cfg['main_color'];?>;
  float: left;
  margin: 1.5em 0 2em;
  width: 100%;
}
.ad_single_cover {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0 !important;
  float: left;
  font-size: 13px;
  height: 49px;
  margin: 0 !important;
  width: 100%;
}
.ad_single_cover div {
  border-bottom: 1px solid <?php echo $cfg['main_color_light'];?>;
  box-sizing: border-box;
  float: left;
  font-family: <?php echo $typekit_optional;?>;
}
.ad_single_cover:first-child .ad_file_once, .ad_single_cover .ad_file_once {
  box-sizing: border-box;
  float: left;
  width: 4%;
}
.ad_file_name, .ad_file_type, .ad_file_size, .ad_file_exp, .ad_file_once, .ad_file_date, .ad_file_ip, .ad_file_action {
  background: #ebfbff none repeat scroll 0 0;
  margin: 0 0.3em;
  padding: 15px 0 15px 0.3%;
  width: 9%;
}
.ad_single_cover:first-child .ad_file_type{
  height: auto;
}
.ad_file_type {
  display: block;
  height: 49px;
  padding: 7px 0 0 5px;
  word-wrap: break-word;
}
.ad_single_cover:first-child .ad_file_size, .ad_file_size {
  border-bottom-width: 0 !important;
  box-shadow: 0 -2px 0 0 <?php echo $cfg['main_color'];?> inset;
  width: 5%;
}
.ad_file_size {
  border-bottom-width: 0 !important;
  box-shadow: 0 -2px 0 0 <?php echo $cfg['main_color_light'];?> inset;
}
.ad_single_cover:first-child .ad_file_name{
   height: auto;
}
.ad_file_name {
  background: #ebfbff url("<?php echo $cfg['web_root'];?>media/latest/link.svg") no-repeat scroll 98% center / auto 72%;
  height: 49px;
  margin-left: 0;
  padding: 0;
  width: 42.6%;
  padding: 1%;
   color: <?php echo $cfg['main_color'];?>;
  
   
}
.ad_link{
	 font-weight: bold;
	 font-size: 17px;
}
.ad_gen_left select {
  padding: 1.5% 2%;
}
.ad_file_exp, .ad_file_date {
  padding: 7px 0 0.35% 5px;
  box-sizing: border-box;
}
.ad_file_act_sh input, .ad_file_act_del input {
  border: medium none;
  box-sizing: border-box;
  cursor: pointer;
  float: left;
  font-size: 0;
  height: 40px;
  width: 45px;
}
.ad_single_cover:first-child div {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border-color: <?php echo $cfg['main_color'];?>;
  box-sizing: border-box;
  padding: 0 0 3px 0.3%;
  width: 9%;
}
.asColorPicker-clear::after {
  content: "" !important;
}
.ad_gen_left{
    float: left;
    width: 46%;
}
.ad_gen_right {
  float: left;
  margin-left: 8%;
  width: 46%;
}
.ad_file_name input.style_none {
  font-size: 17px;
  height: 49px;
  width: 100%;
  padding-left: 2%;
  cursor: pointer;
}
.ad_single_cover:first-child .ad_file_name {
  box-sizing: border-box;
  float: left;
  padding-left: 1%;
  width: 42.6%;
}
.ad_file_name.ad_link {
  padding: 0px;
  display: block !important; /* Overwrite for ad-blocker */
}
.style_none {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: <?php echo $cfg['main_color'];?>;
  float: left;
  font-size: 13px;
  font-weight: bold;
  font-family: <?php echo $typekit_bold;?>;
  height: auto;
  text-align: left;
  width: 100%;
  padding:0;
}
#total_to_upload_size{
	color: <?php echo $cfg['main_color_light'];?>;
}
.ad_file_action, .ad_single_cover:first-child .ad_file_action {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none !important;
  margin-right: 0;
  padding: 4px 0 0;
  width: auto;
}
.style_none.size_bn_desc {
  font-family: <?php echo $typekit_optional;?>;
  background: rgba(0, 0, 0, 0) url("<?php echo $cfg['web_root'];?>media/latest/select-arrow.svg") no-repeat scroll 94% center / auto 53%;
}
.style_none.size_bn_asc {
  font-family: <?php echo $typekit_bold;?>;
  background: rgba(0, 0, 0, 0) url("<?php echo $cfg['web_root'];?>media/latest/select-arrow-flip.svg") no-repeat scroll 94% center / auto 53%;
}
.ad_file_act_sh, .ad_file_act_del {
  border-bottom: medium none !important;
  float: left;
  padding-top: 0 !important;
  width: 45%;
}
.ad_file_act_del {
  margin-left: 6%;
}
.ad_file_act_sh > form, .ad_file_act_del > form {
  box-sizing: border-box;
  width: 100%;
}
.ad_file_act_sh{
  padding-left:0px;
  
}
.ad_file_act_sh input {
  background: <?php echo $cfg['main_color_light'];?> url("<?php echo $cfg['web_root'];?>media/latest/delete_link_activ.svg") no-repeat scroll center center / auto 90%;
}
.ad_file_act_del input {
  background: <?php echo $cfg['main_color'];?> url("<?php echo $cfg['web_root'];?>media/latest/delete.svg") no-repeat scroll center center / auto 60%;
}
/******************* Pagination**************/
 div.pagination span.disabled {
  padding: 2px 5px 2px 5px;
  margin: 2px;
  border: 1px solid #EEE;
  color: #DDD;
 }
.pagination {
  float: left;
  margin-bottom: 1.2%;
  margin-left: 1%;
  margin-right: 1%;
  width: 80%;
}
div.pagination span.current {
  border-top: 1px solid <?php echo $cfg['main_color'];?>!important;
}
div.pagination span.current, .pagination a {
  background: #f2f2f2 none repeat scroll 0 0;
  border-top: 1px solid rgba(0, 0, 0, 0);
  box-sizing: border-box;
  font-family: <?php echo $typekit_optional;?>;
  color: <?php echo $cfg['main_color'];?> !important;
  float: left;
  font-size: 13px;
  margin: 0 3px;
  padding: 4px 0;
  text-align: center;
  text-decoration: none;
  width: 2.7%;
}
.pagination a:hover, div.pagination span.current:hover {
  background: <?php echo $cfg['main_color'];?> none repeat scroll 0 0;
  color: #f2f2f2!important;
}
.pagination a.active {
  border-top: 1px solid #134953;
}
/*******************End  Pagination**************/
.ad_gen_bottom_right {
  float: right;
  margin-bottom: 1.15%;
  margin-right: 0.5%;
  width: 10%;
}
.ad_gen_bottom_right select {
  -moz-appearance: none;
  background: #f2f2f2 url("<?php echo $cfg['web_root'];?>media/latest/select-arrow.svg") no-repeat scroll 94% center / auto 50%;
  border: medium none;
  color: <?php echo $cfg['main_color'];?>;
  font-family: <?php echo $typekit_optional;?>;
  cursor: pointer;
  float: right;
  font-size: 13px;
  margin-top: -1px;
  padding-right: 19%;
}
.color_wrapper {
  float: left;
  width: 100%;
  border-bottom: 1px solid <?php echo $cfg['main_color_light'];?>;
}
.inner_wrapper_full{
	width:100%;
	float:left;
}
.color_wrapper > h1, .inner_wrapper_full > h1, .logo_container > h1, #tabs1-typekit > h2, #tabs1-shar > h2, h1.main_middle_headings, #tabs1-settings > h2 {
  color: <?php echo $cfg['main_color_light'];?>;
  font-family: <?php echo $typekit_normal;?>;
  font-size: 32px;
  font-weight: normal;
  text-align: center;
  
  margin: 0.3em 0;
}
.background-color > h2, .main-color > h2 {
  margin-top: 0;
}
.logo_heading, .fav_heading {
  border-bottom: 1px solid <?php echo $cfg['main_color_light'];?>;
  float: left;
  width: 100%;
}
#preview, .logo_upload {
  float: left;
  height: 90px;
  margin-left: 2%;
  margin-top: 4%;
  width: 190px !important;
}
#preview{ 
  padding: 10px;
}
.color_done, #sharing_done, #typekit_done {
  color: #008000;
  float: left;
  margin: 1% 0 0;
  text-align: center;
  width: 100%;
}
#preview {
  background: #d6d6d6 none repeat scroll 0 0;
  text-align: center;
}
.logo_retina_upload {
  float: left;
  margin-left: 2%;
  margin-top: 4%;
  width: 23%;
}
#imageform > input, #logo_retinaform > input, #favicon_form > input, #touchicon_form > input {
  display: none;
}
.change_logo, .delete_logo, .change_logo_retina, .delete_retina, .change_favicon, .change_touchicon {
  width: 100%;
  float: left;
  font-size: 17px;
  font-weight: bold;
  font-family: <?php echo $typekit_bold;?>;
  cursor: pointer;
}
.change_logo:hover, .delete_logo:hover, .change_logo_retina:hover, .delete_retina:hover, .change_favicon:hover, .change_touchicon:hover, .change_favicon:hover, #delete_logo:hover, .delete_icon:hover {
  color: #01cefe;
}
.delete_logo, .delete_retina, .delete_favicon{
	font-size: 13px;
	font-weight: normal;
}
.img_error {
  color: #d00235;
}
.favicon_upload {
  float: left;
  margin-left: 2%;
  margin-top: 4%;
  width: 44% !important;
}
.change_favicon, #delete_logo, .delete_icon{
  width: 100%;
  float:left;
  cursor: pointer;
}
#delete_logo, .delete_icon{
  font-family: <?php echo $typekit_normal;?>;
  font-size: 17px;
}
#sharing_done .sucess_message {
  float: right;
}
 #delete_retina{
  margin-left: 2%; 
 }
.main-color, .background-color {
  float: left;
  width: 45%;
}
.background-color{
	float:right;
}
#preview_retina {
  background: #d6d6d6 none repeat scroll 0 0;
  height: 180px;
  padding: 10px;
  width: 380px;
}
#preview_touchicon {
  background: #d6d6d6 none repeat scroll 0 0;
  height: 144px;
  padding: 10px;
  width: 144px;
}	
#preview_retina, #preview_touchicon {
  float: left;
  margin-left: 1%;
  margin-top: 4%;
  text-align: center;
}
.touchicon_upload {
  float: left;
  margin-left: 2%;
  margin-top: 4%;
  width: 54%;
}
#preview_retina img.preview_retina {
  max-width: 100%;
  height: auto;
}
.change_logo_retina, .delete_retina {
  width: 98%;
  margin-left: 2%;
}
.logo_heading > p, .fav_heading > p {
  float: right;
  font-family: <?php echo $typekit_optional;?>;
  font-size: 13px;
  margin-right: 2%;
}
.color_wrapper.logo_container {
  padding-bottom: 1.5%;
}
.logo_heading > h1, .fav_heading > h1 {
  float: left;
  width: 44%;
}
#preview_favicon {
  background: #d6d6d6 none repeat scroll 0 0;
  float: left;
  height: 64px;
  margin-left: 2%;
  margin-top: 4%;
  padding: 10px;
  text-align: center;
  width: 64px;
}
.preview_favicon {
  
  max-width: 100%;
}
.logo_heading > p {
  float: right !important;
  font-size: 13px;
  margin-right: 2%;
  text-align: right;
  width: 36% !important;
}
.color_wrapper.fav_container {
  margin-bottom: 3%;
}
.color_wrapper:last-child {
  border: none;
}
.main-color > div {
  float: left;
  width: 100%;
}
#preview img {
  max-width: 100%;
  height: auto;
}
.main-color > h2, .background-color h2, .logo_heading > h1, .fav_heading > h1 {
  color: <?php echo $cfg['main_color'];?>;
  font-size: 17px;
  font-family: <?php echo $typekit_bold;?>;
  margin-left: 2%;
  text-align: left;
}
.ad_loader {
  background: rgb(249, 249, 249) url("<?php echo $cfg['web_root'];?>media/latest/page-loader.gif") no-repeat scroll 50% 50%;
  height: 100%;
  left: 0;
  opacity: 0.3;
  position: fixed;
  top: 0;
  width: 100%;
  z-index: 9999;
}
.m_color_row {
  border-bottom: 1px solid <?php echo $cfg['main_color_light'];?>;
  float: left;
  width: 100%;
}
.m_color_row:nth-child(2n) {
  border-top: 1px solid <?php echo $cfg['main_color_light'];?>;
}
.m_color_row:nth-child(3n) {
  border-bottom: none;
}
span.m_color {
  font-family: <?php echo $typekit_normal;?>;
  float: left;
  padding-left: 2%;
  position: relative;
  top: 10px;
  width: 15%;
  font-size: 17px;
}
.asColorPicker-wrap {
  background: rgba(0, 0, 0, 0) url("<?php echo $cfg['web_root'];?>media/latest/color_picker_activ.svg") no-repeat scroll 62.5% center / auto 72%;
  float: right;
  width: 80%;
}
.asColorPicker-wrap input {
  background: #f2f2f2 none repeat scroll 0 0;
  border: medium none;
  float: right;
  height: 33px;
  padding-right: 2%;
  text-align: right;
  width: 18%;
  color: <?php echo $cfg['main_color'];?>;
  font-family: <?php echo $typekit_normal;?>;
}
.asColorPicker-trigger {
  float: right;
  height: 27px !important;
  margin-right: 1.5%;
  margin-top: 7px;
  width: 12% !important;
}
.design_setting_btn, .setting_btn {
  float: left;
  margin: 1em 0 0;
  text-align: center;
  width: 100%;
}
.setting_btn{
  margin-bottom: 1em;
}
.design_setting_btn > input, .setting_btn input, .settings_btn > input {
  background: <?php echo $cfg['main_color'];?> none repeat scroll 0 0;
  border: 1px solid rgba(0, 0, 0, 0);
  color: <?php echo $cfg['main_color_light'];?>;
  font-size: 17px;
  padding: 0.5em 3em;
} 
.design_setting_btn > input:hover, .setting_btn > input:hover{
  background: #ffffff none repeat scroll 0 0;
  border: 1px solid <?php echo $cfg['main_color_light'];?>;	
}
.design_setting_btn > input:hover, .setting_btn input:hover{
  cursor: pointer;
}
.ad_typekit_left {
  float: left;
  width: 45%;
}
.ad_Typekit {
  width: 100%;
  float: left;
}
.typekite_feilds {
  float: left;
  width: 100%;
  border-bottom: 1px solid <?php echo $cfg['main_color_light'];?>;
}
.ad_shar_chk {
  float: left;
  padding-left: 1%;
  width: 99%;
}
p.ad_tpye_head {
  border-bottom: 1px solid <?php echo $cfg['main_color_light'];?>;
  float: left;
  font-size: 13px !important;
  margin-bottom: 0;
  padding-bottom: 10px;
  padding-left: 2%;
  width: 98%;
}
.ad_typekit_right p {
  border-bottom: 1px solid <?php echo $cfg['main_color_light'];?>;
  margin: 0;
  font-family: <?php echo $typekit_normal;?>;
}
.ad_typekit_right p.ad_tpye_head {
  font-family: <?php echo $typekit_bold;?>;
  font-size: 17px !important;
  font-weight: bold;
  padding-left: 2%;
  padding-top: 13px;
  width: 98%;
}
p.ad_type_txt:last-child {
  border: medium none;
}
.ad_type_txt {
  float: left;
  width: 100%;
}
input.ad_type_bold, input.ad_type_normal, input.ad_type_optional {
  border: medium none;
  color: <?php echo $cfg['main_color'];?>;
  float: right;
  font-size: 17px;
  padding: 0;
  width: 15%;
}
input.ad_type_normal, input.ad_type_bold, input.ad_type_optional {
  background: #f2f2f2 none repeat scroll 0 0;
  padding: 10px;
  font-family: <?php echo $typekit_normal;?>;
  text-align: right;
  width: 40%;
}
.ad_type_txt > label, span.ad_txt {
  padding: 0.53em 0;
  float: left;
}
.ad_typelit_msg {
  float: right;
  font-family: <?php echo $typekit_optional;?>;
  margin-top: 5px;
}
p.ad_tpye_content, .ad_type_lorem {
  float: left;
  font-size: 13px;
  margin: 0;
  padding-left: 2%;
  width: 98%;
}
.ad_type_lorem {
  font-family: <?php echo $typekit_optional;?>;
  margin-top: 2%;
}
.not_record {
  float: left;
  padding-top: 2%;
  text-align: center;
  width: 100%;
  color: #d0021b;
}
p.ad_tpye_content{
  width:100%;
  padding:0;
}
.ad_tpye_head > h1 {
  float: left;
  font-family: <?php echo $typekit_bold;?>;
  font-size: 17px;
  margin: 0;
  width: 30%;
}
.ad_shar_chk > label {
  font-size: 17px;
  font-weight: bold;
  font-family: <?php echo $typekit_bold;?>;
}
p.ad_tpye_content textarea {
  background: #f2f2f2 none repeat scroll 0 0;
  border: medium none;
  font-family: <?php echo $typekit_normal;?>;
  color: <?php echo $cfg['main_color'];?>;
  float: left;
  margin-top: 0;
  padding-left: 2%;
  padding-right: 0;
  padding-top: 1.1em;
  resize: none;
  font-size:17px;
  width: 98%;
}
.ad_typekit_right {
  float: right;
  width: 45%;
}
.ad_email_sharing {
  float: left;
  width: 100%;
}
.ad_shar_detail {
  float: left;
  width: 45%;
}
#ad_shar_detail > p, .ad_stng {
  border-bottom: 1px solid <?php echo $cfg['main_color_light'];?>;
  float: left;
  margin-bottom: 0;
  padding-left: 2%;
  width: 98%;
}
#ad_shar_detail > p {
  font-weight: bold;
  padding-bottom: 10px;
  font-family: <?php echo $typekit_bold;?>;
}


.ad_security_detail {
  float: left;
  width: 100%;
}
#ad_security_detail > p, .ad_stng {
  border-bottom: 1px solid <?php echo $cfg['main_color_light'];?>;
  float: left;
  margin-bottom: 0;
  padding-left: 2%;
  width: 98%;
}
#ad_security_detail > p {
  font-weight: bold;
  padding-bottom: 10px;
  font-family: <?php echo $typekit_bold;?>;
}





.ad_txt {
  float: left;
  padding: 10px 0;
}
.ad_stng > input {
  background: #f2f2f2 none repeat scroll 0 0;
  border: medium none;
  color: <?php echo $cfg['main_color'];?>;
  float: right;
  font-size: 17px;
  padding: 0.53em 2%;
  text-align: right;
  width:60%;
}
#ad_shar_detail .setting_btn {
  text-align: right;
}
.ad_security_detail .setting_btn {
  text-align: right;
}
#ad_settings_detail > p {
  font-weight: bold;
  padding-left: 2%;
  font-family: <?php echo $typekit_bold;?>;
  border-bottom: 1px solid <?php echo $cfg['main_color_light'];?>;
  padding-bottom: 10px;
  margin-bottom: 0px;
}

.http_check > p {
  font-weight: bold;
  padding-left: 2%;
  font-family: <?php echo $typekit_bold;?>;
  border-bottom: 1px solid <?php echo $cfg['main_color_light'];?>;
  padding-bottom: 10px;
  margin-bottom: 0px;
}
.ad_setting_fiels.http_check {
    float: left;
    width: 100%;
	
}
.ssl-top{
	padding-top:3.6%;
}
.ad_shar_chk_ssl {
  padding-top: 6px;
}
.ad_sttng, .settings_btn {
  float: left;
  margin-left: 2%;
  width: 96%;
}
.ad_sttng{
	width: 64%;
}
.settings_btn {
  margin-bottom: 1em;
  margin-top: 1em;
  width: 98%;
}
.settings_btn > input {
  float: right;	
  cursor: pointer;
  border: 1px solid transparent;
}
.settings_btn > input:hover {
  background: #ffffff;	
  border: 1px solid <?php echo $cfg['main_color_light'];?>;
}
.setting_done {
  color: #008000;
  float: right;
  margin-top: 1%;
  width: 96%;
}
.ad_setting_fiels > form #ad_settings_detail {
  width: 99%;
  float: left;
}
.ad_setting_fiels > form #ad_settings_detail .ad_sttng {
  border-bottom: 1px solid <?php echo $cfg['main_color_light'];?>;
  margin-left: 0;
  padding-left: 2%;
  width: 98%;
}
.ad_setting_fiels > form #ad_settings_detail .settings_btn #setting_done {
  float: right;
  margin-top: 2%;
}
.ad_setting_fiels > form #ad_settings_detail .settings_btn #setting_done{
	float: right;
	width: 100%;
}
#ad_settings_form #ad_settings_detail .ad_sttng > input {
  width: 60%;
  padding: 0 2%;
  font-family: <?php echo $typekit_normal;?>; 
  border: medium none;
  height: 39px;
  background: #f2f2f2;
}
#setting_done .sucess_message {
  float: right;
}
.ad_setting_fiels > form #ad_settings_detail .settings_btn #setting_done .sucess_message{
	float: right;
}
#ad_smtp_settings_form #ad_settings_detail .ad_sttng > input {
  width: 60%;
  padding: 0 2%;
  font-family: <?php echo $typekit_normal;?>; 
  border: medium none;
  height: 39px;
  background: #f2f2f2;
}
#copyright.admin-copy {
  margin-top: -5px; 
}
/*#asColorPicker-dropdown {
  max-width: 130px !important;
  min-width: 130px !important;
}
.asColorPicker-saturation {
  width: 107px !important; 
}*/
/* ==========================================================================
Admin- CSS ENDS
========================================================================== */
   
   
   
/* ==========================================================================
Expander- CSS
========================================================================== */
.total_to_uploads {
  background: <?php echo $cfg['main_color'];?> none repeat scroll 0 0;
  float: left;
  padding: 10px 2%;
  width: 96%;
  height: 44px;
}
.left_files_uploads {
  color: #ffffff;
  float: left;
  position: relative;
  width: 33.5%;
} 
.done_files {
  color: #ffffff;
  float: right;
  position: relative;
  width: auto;
}
.expand_icons_total.down_icon, .expand_icons_total.up_icon, .expand_icon.down_icon, .expand_icon.up_icon {
  background: rgba(0, 0, 0, 0) url("<?php echo $cfg['web_root'];?>media/latest/expand-arrow.svg") no-repeat scroll center center / auto 45%;
  cursor: pointer;
  float: left;
  font-size: 0;
  height: 28px;
  margin: 5% 0 0 0;
  position: relative;
  top: 8px;
  width: 33%;
}
.expand_icons_total.up_icon, .expand_icon.up_icon {
  transform: scaleY(-1);
}
.expand_icon.down_icon, .expand_icon.up_icon { 
  background: rgba(0, 0, 0, 0) url("<?php echo $cfg['web_root'];?>media/latest/expand-arrow.svg") no-repeat scroll center center / auto 45%;
  margin: 0 0 0 0;
  top: 2px;
  width: 33%;
}
#svg-count-done circle {
  stroke-dashoffset: 0;
  transition: stroke-dashoffset 1s linear;
  stroke-width: 0.3em;
}
#svg-count-done #bar-count-done{
  stroke: <?php echo $cfg['main_color_light'];?>;;
}
#cont-count-done {
  display: block;
  margin: 2em auto;
  border-radius: 100%;
  position: relative;
}
#svg-count-done{
  background-color: <?php echo $cfg['main_color'];?>;
  background:url("<?php echo $cfg['web_root'];?>media/latest/right122.png") no-repeat scroll center top transparent !important;
  margin-left: 26.5%;
  margin-top: 5.6%;
  background-position:52% 40% !important;
}
.count_done_txt {
  margin-top: -30px !important;
}



/************************************************ Clip Board Css*****************/
.download_links span a#copyButton{
  background:rgba(0, 0, 0, 0) url("<?php echo $cfg['web_root'];?>media/latest/clipboard.svg") no-repeat scroll 98.8% center;
  color: <?php echo $cfg['main_color'];?>;
  width:98%;
 }
 .download_links span a#copyButton:hover{
  background:rgba(0, 0, 0, 0) url("<?php echo $cfg['web_root'];?>media/latest/clipboard_active.svg") no-repeat scroll 98.8% center;
  color: <?php echo $cfg['main_color'];?>;
  width:98%;
 }
 .clipBoardUrl_list a.copyButton1{
	 background:rgba(0, 0, 0, 0) url("<?php echo $cfg['web_root'];?>media/latest/clipboard.svg") no-repeat scroll 49.8% center;
     color: <?php echo $cfg['main_color'];?>;
	  height: 25px;
      width: 100%; 
 }
 .clipBoardUrl_list a.copyButton1:hover{
	  background:rgba(0, 0, 0, 0) url("<?php echo $cfg['web_root'];?>media/latest/clipboard_active.svg") no-repeat scroll 49.8% center;
     color: <?php echo $cfg['main_color'];?>;
	 height: 25px;
      width: 100%;
 }
 
 
.clip-board-txt {
  background-color: #E7ECED!important;
  border: medium none !important;
  font-size: 17px!important;
  min-height: 40px!important;
  height: 57px!important;
  padding: 2% 1% 1% 3% !important;
  width: 96%!important;
   font-family: Arial,sans-serif;
    margin:0px!important;
}
.clip-board-txt-dn-page{
	 background-color: #E7ECED!important;
  border: medium none !important;
  font-size: 17px!important;
  min-height: 40px!important;
  padding: 0.2% 2% 0%!important;
  width: 77%!important;
   font-family: Arial,sans-serif;
    margin:0px!important;
}



.clipBoardUrl_list{
    padding: 4% 0 0;
    width: 100%;
	float:left;
	margin:2% 0;
	background-color: #E7ECED;
	display:none;
}
.text-copied {
    float: left;
    margin-left: 19%;
    width: 100%;
   color: <?php echo $cfg['main_color_light'];?>;
}
.text-copied-upload{
	  color: <?php echo $cfg['main_color_light'];?>;
	    float: right;
  margin-right: 10%;
}
.clip-icon {
  width: 16% !important;
}
.copyButton1.download-icon {
  margin-right: -35%;
}
.download_links span a#copyButton-safari, .clipBoardUrl_list a.safariCl{
  background: none!important;
  color: <?php echo $cfg['main_color'];?>;
  width: 98%;
  cursor: default;
}
/* ==========================================================================
Expander- CSS ENDS
========================================================================== */
 
/******************************************************************
********** ZIP download and plain download*******
******************************************************************/ 


.zipUnzipContainer > label {
  color: #134953;
}
.hide_this{
	display:none;
}
#pwd-keys-error{
	float:left;
	color:red;
}
.spacer_top_bottom{
	padding:10px; 0px;
	width:100%;
	float:left;
}
.zip_ctrl{
	margin:20px 0px 0px 0px; 
}
.downLoadOpt > p, .rezipped > p  {
  border-bottom: 0px solid #01cefe;
  font-family: Arial;
  font-weight: bold;
  margin-bottom: 0;
  padding-bottom: 10px;
  padding-left: 2%;
}
.downLoadOpt_inner, .re_zipped_inner{
	padding:9px 0px;
}
<?php
include("/home/httpd/vhosts/mysms.firstamsms.com/httpdocs/cms/config1.inc"); // stores important required info
include($displaytools); // required for output
include("/home/httpd/vhosts/mysms.firstamsms.com/httpdocs/cms/filter.inc"); // needed for content filtering
// #CMS_Start - DO NOT ALTER THIS LINE
$edit_ary = array (
	"chunk1" => array (
		"title"=>"Representative",
		"description"=>"Representative contact list.",		
		"display_type" => array (
			"name"=>"reps_rows",
			"entry_type"=>"edit_one",
			"change_id_label"=>"id",
			"display_label"=>"representative",
			"select_existing_default"=>"Select Representative...",
			"select_existing_query"=>"SELECT id,heading FROM representatives",
			"heading_color"=>"#000000",
			"display_sort_by_field"=>"heading"
			),
		"rep_query"=>"",
		"blanks"=>"1",		
		"table_name"=>"representatives"
		)
	);
// #CMS_End - DO NOT ALTER THIS LINE
// CMS Start & Add lines must immediately preceed and follow edit_ary
$custom_table_tag = "<TABLE width=\"575\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"content\">";
$custom_td_tag = "<TD width=\"408\" valign=\"top\">";
// Note inclusion of optional stylesheet code in header below
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html><!-- InstanceBegin template="/Templates/sub.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" --> 

<title>First American SMS</title>

<!-- InstanceEndEditable -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php include ('../includes/menu.php'); ?>
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->

function flvFPW1(){// v1.4
// Copyright 2003, Marja Ribbers-de Vroed, FlevOOware (www.flevooware.nl/dreamweaver/)
var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16,v17,v18;if (v4>1||v1[2].indexOf("%")>-1){v10=screen.width;for (v6=0;v6<v2.length;v6++){v18=v2[v6].split("=");if (v18[0]=="width"){v8=parseInt(v18[1]);if (v18[1].indexOf("%")>-1){v8=(v8/100)*v10;v2[v6]="width="+v8;}}if (v18[0]=="left"){v9=parseInt(v18[1]);v11=v6;}}if (v4==2){v7=(v10-v8)/2;v11=v2.length;}else if (v4==3){v7=v10-v8-v9;}v2[v11]="left="+v7;}if (v5>1||v1[2].indexOf("%")>-1){v14=screen.height;for (v6=0;v6<v2.length;v6++){v18=v2[v6].split("=");if (v18[0]=="height"){v12=parseInt(v18[1]);if (v18[1].indexOf("%")>-1){v12=(v12/100)*v14;v2[v6]="height="+v12;}}if (v18[0]=="top"){v13=parseInt(v18[1]);v15=v6;}}if (v5==2){v7=(v14-v12)/2;v15=v2.length;}else if (v5==3){v7=v14-v12-v13;}v2[v15]="top="+v7;}v16=v2.join(",");v17=window.open(v1[0],v1[1],v16);if (v3){v17.focus();}document.MM_returnValue=false;}
//-->
</script>
<script language="JavaScript" src="../mm_menu.js"></script>
<link href="../styles.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../images/bt_products_on.gif','../images/bt_aboutus_on.gif','../images/bt_demoroom_on.gif','../images/bt_events_on.gif','../images/bt_contact_on.gif','../images/bt_login_on.gif','../images/bt_features_on.gif','../images/bt_back_on.gif','../images/bt_benefits_on.gif','../images/bt_requestinfo_on.gif','../images/bt_management_on.gif','../images/bt_helpdesk_on.gif','../images/bt_trusthelpdesk_on.gif','../images/bt_1099helpdesk_on.gif','../images/bt_officedirectory_on.gif','../images/bt_productinquiry_on.gif')">
<script language="JavaScript1.2">mmLoadMenus();</script> 
<a name="top"></a>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="80" valign="middle" class="headerbg">
      <table width="780" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="347"><a href="/index.php"><img src="/images/firstamsms.gif" width="317" height="62" hspace="5" border="0"></a></td>
          <td width="433" align="right">
            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="420" height="80">
              <param name="movie" value="/swf/servingtheindustry.swf">
							<param name="wmode" value="transparent">
              <param name="quality" value="high">
              <embed src="/swf/servingtheindustry.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="420" height="80" wmode="transparent"></embed>
            </object>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td height="1" bgcolor="EBEAC1"><img src="../images/pixel.gif" width="1" height="1"></td>
  </tr>
  <tr> 
    <td height="23" valign="top" bgcolor="0F1477"><img src="../images/bt_spacer.gif" width="170" height="23"><img src="../images/bt_divide.gif" width="1" height="23"><a href="../products_services/index.php" onMouseOut="MM_swapImgRestore();MM_startTimeout();" onMouseOver="MM_swapImage('products','','../images/bt_products_on.gif',1);MM_showMenu(window.mm_menu_1213104953_0,0,23,null,'products')"><img src="../images/bt_products_off.gif" name="products" width="139" height="23" border="0"></a><img src="../images/bt_divide.gif" width="1" height="23"><a href="../company/index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('aboutus','','../images/bt_aboutus_on.gif',1)"><img src="../images/bt_aboutus_off.gif" name="aboutus" width="93" height="23" border="0"></a><img src="../images/bt_divide.gif" width="1" height="23"><a href="../demoroom/index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('demoroom','','../images/bt_demoroom_on.gif',1)"><img src="../images/bt_demoroom_off.gif" name="demoroom" width="111" height="23" border="0"></a><img src="../images/bt_divide.gif" width="1" height="23"><a href="../events/index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('events','','../images/bt_events_on.gif',1)"><img src="../images/bt_events_off.gif" name="events" width="86" height="23" border="0"></a><img src="../images/bt_divide.gif" width="1" height="23"><a href="index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('contact','','../images/bt_contact_on.gif',1)"><img src="../images/bt_contact_off.gif" name="contact" width="100" height="23" border="0"></a><img src="../images/bt_divide.gif" width="1" height="23"><a href="../index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('mysms','','../images/bt_login_on.gif',1)"><img src="../images/bt_login_off.gif" name="mysms" width="75" height="23" border="0"></a><img src="../images/bt_divide.gif" width="1" height="23"></td>
  </tr>
  <tr> 
    <td height="24" bgcolor="EBEAC1"><table width="780" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="694" height="24" class="verdana11"><!-- InstanceBeginEditable name="breadcrumbs" --><a href="/index.php">Home</a> 
            &gt; <a href="index.php">Contact Us</a><!-- InstanceEndEditable --></td>
          <td width="76" align="right">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="100%" valign="top"> <p>&nbsp;</p>
      <table width="780" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="170" valign="top"><img src="../images/toptab_yellow.gif" width="170" height="25"></td>
          <td width="34">&nbsp;</td>
          <td width="576">&nbsp;</td>
        </tr>
        <tr> 
          <td width="170" valign="top"><img src="../images/toptab_red.gif" width="170" height="36"></td>
          <td width="34"><img src="../images/hd_columnspacer.gif" width="34" height="36"></td>
          <td width="576"><!-- InstanceBeginEditable name="section_title" --><img src="../images/hd_contactus.gif" width="576" height="36"><!-- InstanceEndEditable --></td>
        </tr>
        <tr> 
          <td width="170" valign="top"><!-- InstanceBeginEditable name="leftphoto" --><img src="../images/leftpic_contact2.jpg" width="170" height="135"><!-- InstanceEndEditable --><br> 
            <!-- InstanceBeginEditable name="subnav_table" --> 

            <table width="170" border="0" cellpadding="5" cellspacing="0" bgcolor="#EBEAC1">

              <tr> 

                <td height="5"> <a href="management.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('management','','../images/bt_management_on.gif',1)"><img src="../images/bt_management_off.gif" name="management" width="99" height="18" hspace="5" vspace="10" border="0"></a><br> 

                  <a href="helpdesk_sms.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('helpdesk','','../images/bt_helpdesk_on.gif',1)"><img src="../images/bt_helpdesk_off.gif" name="helpdesk" width="112" height="18" hspace="5" border="0"></a><br> 

                  <a href="helpdesk_trustacct.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('trustacct','','../images/bt_trusthelpdesk_on.gif',1)"><img src="../images/bt_trusthelpdesk_off.gif" name="trustacct" width="145" height="18" hspace="5" vspace="10" border="0"></a><br> 

                  <a href="helpdesk_1099.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('1099','','../images/bt_1099helpdesk_on.gif',1)"><img src="../images/bt_1099helpdesk_off.gif" name="1099" width="145" height="18" hspace="5" border="0"></a><br> 

                  <a href="office_directory.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('directory','','../images/bt_officedirectory_on.gif',1)"><img src="../images/bt_officedirectory_off.gif" name="directory" width="115" height="18" hspace="5" vspace="10" border="0"></a><br> 

                  <a href="../forms/request_info.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('inquiry','','../images/bt_productinquiry_on.gif',1)"><img src="../images/bt_productinquiry_off.gif" name="inquiry" width="115" height="18" hspace="5" border="0"></a><br> 

                  <a href="javascript:history.back()" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('back','','../images/bt_back_on.gif',1)"><img src="../images/bt_back_off.gif" name="back" width="57" height="18" hspace="5" vspace="15" border="0"></a><br> 

                </td>

              </tr>

            </table>

            <!-- InstanceEndEditable --> <img src="../images/toptab_beigebase.gif" width="170" height="20"></td>
          <td width="34">&nbsp;</td>
          <!-- InstanceBeginEditable name="Content" --> 

          <td width="576" valign="top" class="content">

              

          <?php 
          if ($_REQUEST["state"]) {
            //check for regions
            $region_sql = "SELECT * FROM regions WHERE regions.state_id = '".$_REQUEST["state"]."' ORDER BY heading";
            $region_result = mysql_query($region_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
            if (mysql_num_rows($region_result)) { // check for any content
            	$getrep = false;
            	echo "<p><br>Please Select a Region or County</p>\n";
            	while ($this_region = mysql_fetch_assoc($region_result)) {
            		$county_sql = "SELECT * FROM counties WHERE counties.region_id = '".$this_region["id"]."' ORDER BY heading";
            		$county_result = mysql_query($county_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
            		if (mysql_numrows($county_result)) { //check for any content
            			echo "<p><strong>".$this_region["heading"]." </strong>(select a county below)<strong>:</strong></p>\n";
            			echo "<ul>\n";
            			while ($this_county = mysql_fetch_assoc($county_result)) {
            				echo "<li><a href=\"representative.php?county=".$this_county["id"]."\">".$this_county["heading"]."</a></li>\n";
            			}
            			echo "</ul>\n";
            		}
            		else { // no counties
            			echo "<p><strong><a href=\"representative.php?region=".$this_region["id"]."\">".$this_region["heading"]."</a></strong></p>";
            		}
            	}
            	echo "<p>&nbsp;</p>";
            }
            else { // no regions
            	$getrep = "state";
            }
          }
          elseif ($_REQUEST["region"]) {
          	$getrep = "region";
          }
          elseif ($_REQUEST["county"]) {
           	$getrep = "county";
          }	
          else {
          	$getrep = false;
          	$edit_ary['chunk1']['rep_query'] = "SELECT DISTINCT representatives.* FROM repdb,representatives WHERE repdb.rep_id = representatives.id ORDER BY repdb.id";         	
          	content_display("chunk1",$custom_table_tag, $custom_td_tag);
          }
          if ($getrep) {  
          	$edit_ary['chunk1']['rep_query'] = "SELECT DISTINCT representatives.* FROM repdb,representatives WHERE repdb.rep_id = representatives.id AND repdb.".$getrep."_id = '".$_REQUEST[$getrep]."' ORDER BY repdb.id";
          	content_display("chunk1",$custom_table_tag, $custom_td_tag);
          }       
         ?>

            <p> <br>

              <br>

            </p>

            <blockquote>&nbsp;</blockquote>

            <p>&nbsp; </p></td>

          <!-- InstanceEndEditable --></tr>
        <tr> 
          <td valign="top">&nbsp;</td>
          <td width="34">&nbsp;</td>
          <!-- InstanceBeginEditable name="endlinks" -->

          <td width="576" align="center" class="content">&nbsp;</td>

          <!-- InstanceEndEditable --></tr>
      </table>
      <br>
    </td>
  </tr>
  <tr> 
    <td height="24" bgcolor="EBEAC1"><table width="780" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="170">&nbsp;</td>
          <td width="24" align="center" class="verdana11">&nbsp;</td>
          <td width="586" align="center" class="verdana11"><p><a href="/index.php"><br>
              Home</a> &nbsp;| &nbsp;<a href="../products_services/index.php">Products 
              &amp; Services</a> &nbsp;| &nbsp;<a href="../company/index.php">About 
              Us</a> &nbsp;| &nbsp;<a href="../demoroom/index.php">Demo Room</a> 
              &nbsp;| &nbsp;<a href="../events/index.php">Events</a> &nbsp;| &nbsp;<a href="index.php">Contact 
              Us</a> &nbsp;| &nbsp;<a href="../index.php">Login</a> <br>
              <br>
              &copy; <?php echo date("Y") ?> First American SMS&nbsp;&nbsp;&nbsp;(800) 767-7832<br>
              <a href="http://www.firstamprs.com/content/privacy-information" class="text1" onClick="flvFPW1(this.href,'legal','width=980,height=600,scrollbars=yes',1);return document.MM_returnValue">Privacy Policies & Legal Notice</a></p>
          </td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td width="24" align="center" class="verdana11">&nbsp;</td>
          <td width="586" align="center" class="verdana11">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
<!-- InstanceEnd --></html>


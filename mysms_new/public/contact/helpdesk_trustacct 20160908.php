<?php
/*
include("/home/httpd/vhosts/mysms.firstamsms.com/httpdocs/cms/config1.inc"); // stores important required info
include($displaytools); // required for output
include("/home/httpd/vhosts/mysms.firstamsms.com/httpdocs/cms/filter.inc"); // needed for content filtering
// #CMS_Start - DO NOT ALTER THIS LINE
$edit_ary = array (
	"chunk1" => array (
		"title"=>"Trust Accounting Help Desk Information",
		"description"=>"Help desk phone numbers and hours.",		
		"display_type"=>"phone_hours",		
		"blanks"=>"0",		
		"table_name"=>"helpdesk_trustacct",		
		)
	);
// #CMS_End - DO NOT ALTER THIS LINE
// CMS Start & Add lines must immediately preceed and follow edit_ary
$custom_table_tag = "<TABLE border=\"0\" cellspacing=\"0\">";
$custom_td_tag = "<TD valign=\"top\" class=\"verdana11\">";
$edit_ary["chunk2"] = array (
		"title"=>"Trust Accounting Help Desk Contacts",
		"description"=>"Help desk contact list.",		
		"display_type" => array (
			"name"=>"data_list",
			"entry_type"=>"edit_one",
			"change_id_label"=>"id",
			"display_label"=>"contact",
			"select_existing_query"=>"SELECT id,heading FROM helpdesk_trustacct_contacts",
			"heading_color"=>"#000000",
			"display_sort_by_field"=>"",
			),		
		"blanks"=>"1",		
		"table_name"=>"helpdesk_trustacct_contacts",		
		);
// Note inclusion of optional stylesheet code in header below
*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><!-- InstanceBegin template="/Templates/sub.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" --> 

<title>First American SMS</title>

<!-- InstanceEndEditable -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php include ('../../includes/menu.php'); ?>
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
<script language="JavaScript" src="/mm_menu.js"></script>
<link href="../styles.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../images/bt_products_on.gif','../../images/bt_aboutus_on.gif','../../images/bt_demoroom_on.gif','../../images/bt_events_on.gif','../../images/bt_contact_on.gif','../../images/bt_login_on.gif','../../images/bt_features_on.gif','../../images/bt_back_on.gif','../../images/bt_benefits_on.gif','../../images/bt_requestinfo_on.gif','../../images/bt_management_on.gif','../../images/bt_helpdesk_on.gif','../../images/bt_trusthelpdesk_on.gif','../../images/bt_1099helpdesk_on.gif','../../images/bt_officedirectory_on.gif','../../images/bt_productinquiry_on.gif')">
<script language="JavaScript1.2">mmLoadMenus();</script> 
<a name="top"></a>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="80" valign="middle" class="headerbg">
      <table width="780" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="347"><a href="http://www.firstamsms.com/"><img src="/images/firstamsms.gif" width="317" height="62" hspace="5" border="0"></a></td>
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
    <td height="1" bgcolor="EBEAC1"><img src="../../images/pixel.gif" width="1" height="1"></td>
  </tr>
  <tr> 
    <td height="23" valign="top" bgcolor="0F1477">&nbsp;</td>
  </tr>
  <tr> 
    <td height="24" bgcolor="EBEAC1"><table width="780" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="694" height="24" class="verdana11"><!-- InstanceBeginEditable name="breadcrumbs" --><a href="http://www.firstamsms.com/">Home</a> 

            &gt; Contact Us<!-- InstanceEndEditable --></td>
          <td width="76" align="right">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="100%" valign="top"> <p>&nbsp;</p>
      <table width="780" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="170" valign="top"><img src="../../images/toptab_yellow.gif" width="170" height="25"></td>
          <td width="34">&nbsp;</td>
          <td width="576">&nbsp;</td>
        </tr>
        <tr> 
          <td width="170" valign="top"><img src="../../images/toptab_red.gif" width="170" height="36"></td>
          <td width="34"><img src="../../images/hd_columnspacer.gif" width="34" height="36"></td>
          <td width="576"><!-- InstanceBeginEditable name="section_title" --><img src="../../images/hd_trustacchelpdesk.gif" width="576" height="36"><!-- InstanceEndEditable --></td>
        </tr>
        <tr> 
          <td width="170" valign="top"><!-- InstanceBeginEditable name="leftphoto" --><img src="../../images/leftpic_contact2.jpg" width="170" height="135"><!-- InstanceEndEditable --><br> 
            <!-- InstanceBeginEditable name="subnav_table" --> 

            <table width="170" border="0" cellpadding="5" cellspacing="0" bgcolor="#EBEAC1">

              <tr> 

                <td height="5"> 
                  <a href="helpdesk_sms.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('helpdesk','','../../images/bt_helpdesk_on.gif',1)"><img src="../../images/bt_helpdesk_off.gif" name="helpdesk" width="112" height="18" hspace="5" vspace="10" border="0"></a><br> 

                  <a href="helpdesk_trustacct.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('trustacct','','../../images/bt_trusthelpdesk_on.gif',1)"><img src="../../images/bt_trusthelpdesk_off.gif" name="trustacct" width="145" height="18" hspace="5" vspace="10" border="0"></a><br> 

                  <a href="helpdesk_1099.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('1099','','../../images/bt_1099helpdesk_on.gif',1)"><img src="../../images/bt_1099helpdesk_off.gif" name="1099" width="145" height="18" hspace="5" vspace="10" border="0"></a><br> 

                  <a href="http://mysms.firstamsms.com" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('back','','../../images/bt_back_on.gif',1)"><img src="../../images/bt_back_off.gif" name="back" width="57" height="18" hspace="5" vspace="10" border="0"></a><br> 

                </td>

              </tr>

            </table>

            <!-- InstanceEndEditable --> <img src="../../images/toptab_beigebase.gif" width="170" height="20"></td>
          <td width="34">&nbsp;</td>
          <!-- InstanceBeginEditable name="Content" --> 

          <td width="576" valign="top" class="content">
            <blockquote>
         	<!-- DYNAMIC BEGIN -->
			<br>
			<p><?php //content_display("chunk1","","<BR>"); ?></p>

              <p><?php //content_display("chunk2"); ?></p>
			<!-- DYNAMIC END -->
			<!-- STATIC BEGIN -->
			<br> 
			<p> 
      <b>Phone:</b> (800) 767-7833
<BR> 
 
      <b>Fax:</b> (888) 378-8615
<BR> 
 
<BR>      <b>Hours:</b><BR> 9:00 a.m. - 8:00 p.m. (Eastern)
<BR> 
 
      6:00 a.m. - 5:00 p.m. (Pacific)
<BR> 
</p> 
 
              <p> 
      <p> 
      <B><font color="#000000">Colleen Bomgaars, Help Desk Manager</font></B><BR> 
      <a href="mailto:cbomgaars@firstam.com">cbomgaars@firstam.com</a><BR> 
      (800) 767-7833 Ext. 1607<BR> 
      <BR> 
      <B><font color="#000000">Mickey Jones, Director - Customer Service</font></B><BR> 
      <a href="mailto:mijones@firstam.com">mijones@firstam.com</a><BR> 
      (800) 767-7832 Ext. 1606<BR> 
      <BR> 
      <B><font color="#000000">Patrick Schultz, Vice President, SMS</font></B><BR> 
      <a href="mailto:pschultz@firstam.com">pschultz@firstam.com</a><BR> 
      (800) 767-7832 Ext. 1675<BR> 
      <BR> 
      </p></p> 
 
			<!-- STATIC END --> 
            </blockquote>

            <p>&nbsp; </p>

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
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/public/includes/wide_footer.php'); ?>
          <td>&nbsp;</td>
          <td width="24" align="center" class="verdana11">&nbsp;</td>
          <td width="586" align="center" class="verdana11">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
<!-- InstanceEnd --></html>


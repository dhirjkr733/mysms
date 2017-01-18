<?php
$me = $_SERVER['PHP_SELF'];  
$Apathweb = explode("/", $me);  
$myFileName = array_pop($Apathweb);  
$pathweb = implode("/", $Apathweb);  
$myURL = "http://".$_SERVER['HTTP_HOST'].$pathweb."/".$myFileName;
$file = basename($PHP_SELF); 
$dir = explode("/",dirname($PHP_SELF)); //$dir[1] will be name of directory, if "" then u r in root
?>

<SCRIPT language=JavaScript src="/extranet/js/script.js" type=text/javascript></SCRIPT>
<script language="JavaScript">
<!--
function flvFPW1(){// v1.3
// Copyright 2002, Marja Ribbers-de Vroed, FlevOOware (www.flevooware.nl/dreamweaver/)
var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16,v17,v18;if (v4>1){v10=screen.width;for (v6=0;v6<v2.length;v6++){v18=v2[v6].split("=");if (v18[0]=="width"){v8=parseInt(v18[1]);}if (v18[0]=="left"){v9=parseInt(v18[1]);v11=v6;}}if (v4==2){v7=(v10-v8)/2;v11=v2.length;}else if (v4==3){v7=v10-v8-v9;}v2[v11]="left="+v7;}if (v5>1){v14=screen.height;for (v6=0;v6<v2.length;v6++){v18=v2[v6].split("=");if (v18[0]=="height"){v12=parseInt(v18[1]);}if (v18[0]=="top"){v13=parseInt(v18[1]);v15=v6;}}if (v5==2){v7=(v14-v12)/2;v15=v2.length;}else if (v5==3){v7=v14-v12-v13;}v2[v15]="top="+v7;}v16=v2.join(",");v17=window.open(v1[0],v1[1],v16);if (v3){v17.focus();}document.MM_returnValue=false;}
//-->
</script>
<a name="top"></a>
<table width="755" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" class="headerbg">
      <table width="755" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="317" bgcolor="#FFFFFF"><a href="/index.php"><img src="/images/firstamsms.gif" width="317" height="62" hspace="0" border="0" /></a></td>
          <td width="438" align="right">
            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="420" height="80">
              <param name="movie" value="/swf/servingtheindustry.swf" />
              <param name="wmode" value="transparent" />
              <param name="quality" value="high" />
              <embed src="/swf/servingtheindustry.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="420" height="80" wmode="transparent"></embed>
            </object>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td height="23" bgcolor="#0F1477"><img src="/images/topnav_empty.gif" width="755" height="23"></td>
  </tr>
</table>


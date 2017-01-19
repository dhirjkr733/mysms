<table width="170" border="0" cellpadding="0" cellspacing="0">
  <tr valign="top">
    <td width="25" height="20"><img src="/images/arrow1.gif" width="21" height="17"></td>
    <td><span class="headline">Support Connection</span></td>
  </tr>
  <tr valign="top">
    <td width="25" height="19">&nbsp;</td>
    <td class="text1">Access online support tools and find answers to common questions. </td>
  </tr>
  <tr valign="top">
    <td height="39">&nbsp;</td>
    <td class="text1"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" id="subnav">
        <tr valign="top">
          <td height="5" colspan="2"><img src="/images/spacer.gif" width="1" height="5"></td>
        </tr>
        <tr valign="top">
          <td width="10"><img src="/images/arrow2.gif" width="4" height="17"></td>
          <td><a href="mailto:software.support@firstam.com">Email the Help Desk </a></td>
        </tr>
        <tr valign="top">
          <td height="5" colspan="2"><img src="/images/spacer.gif" width="1" height="5"></td>
        </tr>
        <?php

/*
			<tr valign="top">
			  <td width="10"><img src="/images/arrow2.gif" width="4" height="17"></td>
			  <td width="140" class="nav1"><a href="/extranet/support/online_support.php" <?php if ($file=="online_support.php") echo "class=\"highlighted\""; ?>>Chat Support</a></td>
			</tr>

*/        
        ?>

        <!-- <tr valign="top">
          <td height="5" colspan="2"><img src="/images/spacer.gif" width="1" height="5"></td>
        </tr>
        <tr valign="top">
          <td><img src="/images/arrow2.gif" width="4" height="17"></td>
          <td><a href="https://eclassroom.firstam.net/main/User/GuestAttend.jhtml?s">Centra&reg; Login </a></td>
               </tr> -->
        <!--<tr valign="top">
          <td height="5" colspan="2"><img src="/images/spacer.gif" width="1" height="5"></td>
        </tr>
        
        <tr valign="top">
          <td><img src="/images/arrow2.gif" width="4" height="17"></td>
          <td><a href="http://mysms.firstamsms.com/centra_download.php">Download Centra&reg; Client Software </a></td>
        </tr>
        -->
        <!-- <tr valign="top">
                  <td height="5" colspan="2"><img src="/images/spacer.gif" width="1" height="5"></td>
                </tr> -->
        <tr valign="top">
          <td width="10" height="18"><img src="/images/arrow2.gif" width="4" height="17"></td>
          <td><a href="/extranet/support/faqs.php?product=<?php print $_SESSION['default_product']; ?>" <?php if ($file=="faqs.php") echo "class=\"highlighted\""; ?>>Product FAQ's </a></td>
        </tr>
        <tr valign="top">
          <td height="5" colspan="2"><img src="/images/spacer.gif" width="1" height="5"></td>
        </tr>
        <tr valign="top">
          <td width="10" height="18"><img src="/images/arrow2.gif" width="4" height="17"></td>
<!-- 
          <td><a href="http://design2.rightanswers.com:5080/firstam/ss/?mysmstoken=<?php echo generateRightAnswersToken(); ?>" onClick="popUP('http://design2.rightanswers.com:5080/firstam/ss/?mysmstoken=<?php echo generateRightAnswersToken(); ?>','RightAnswers',800,600,1,1);return false;"<?php if ($file=="faqs.php") echo " class=\"highlighted\""; ?>>Right Answers Right Now </a></td>
 -->
          <td><a href="http://mysms.firstamsms.com/decryptthis.php?mysmstoken=<?php echo generateRightAnswersToken(); ?>" onClick="popUP('http://mysms.firstamsms.com/decryptthis.php?mysmstoken=<?php echo generateRightAnswersToken(); ?>','RightAnswers',1344,700,1,1);return false;"<?php if ($file=="faqs.php") echo " class=\"highlighted\""; ?>>Right Answers Right Now </a></td>
        </tr>
        <!--
        <tr valign="top">
          <td height="5" colspan="2"><img src="/images/spacer.gif" width="1" height="5"></td>
        </tr>
        <tr valign="top">
          <td height="18"><img src="/images/arrow2.gif" width="4" height="17"></td>
          <td class="textbody"><a href="/coming_soon.php">Knowledgebase </a></td>
        </tr>
        -->
    </table></td>
  </tr>
</table>
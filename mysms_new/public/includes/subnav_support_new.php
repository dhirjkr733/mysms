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
		<td class="text1">
			<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" id="subnav">
				<tr valign="top">
					<td height="5" colspan="2"><img src="/images/spacer.gif" width="1" height="5"></td>
				</tr>
				<tr valign="top">
					<td width="10"><img src="/images/arrow2.gif" width="4" height="17"></td>
					<td width="140" class="nav1"><a href="mailto:software.support@smscorp.com">Email SMS Customer Support </a></td>
				</tr>
				<tr valign="top">
					<td height="5" colspan="2"><img src="/images/spacer.gif" width="1" height="5"></td>
				</tr>
				<tr valign="top">
					<td width="10"><img src="/images/arrow2.gif" width="4" height="17"></td>
					<td width="140" class="nav1"><a href="/public/support/online_support.php" <?php if ($file=="online_support.php") echo "class=\"highlighted\""; ?>>Chat Support</a></td>
				</tr>
				<tr valign="top">
					<td height="5" colspan="2"><img src="/images/spacer.gif" width="1" height="5"></td>
				</tr>
				<tr valign="top">
					<td width="10" height="18"><img src="/images/arrow2.gif" width="4" height="17"></td>
					<td width="140" class="nav1"><a href="/public/support/vendors.php" <?php if ($file=="vendors.php") echo "class=\"highlighted\""; ?>>Industry Links </a></td>
				</tr>
				<tr valign="top">
					<td height="5" colspan="2"><img src="/images/spacer.gif" width="1" height="5"></td>
				</tr>
				<tr valign="top">
					<td><img src="/images/arrow2.gif" width="4" height="17"></td>
					<td width="140" class="nav1"><a href="#" onclick="return false">Connect Your Representative</a></td>
				</tr>
				<tr valign="top">
					<td height="5" colspan="2"><img src="/images/spacer.gif" width="1" height="5"></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="2">
			<script type="text/javascript">
				function pullQueryString() {
					var error = window.location.search;
					if (error.substring(0, 1) == "?") {
						error = error.substring(1);
					}
					return error;
				}
			</script>
			
			<form name="logmeinsupport" action="https://secure.logmeinrescue.com/Customer/Code.aspx" method="post" id="logmeinsupport">
				<b><font color="red">
					<script type="text/javascript">
						var response = pullQueryString();
						response = response.substring(22);
		
						if(response.toLowerCase().indexOf("pincode_missing") > -1 ){
							document.write("Assisted service can be obtained by first contacting  support at 1 (800) 767-7831." + "<br />");
						}
						else if(response.toLowerCase().indexOf("pincode_invalid") > -1){
							document.write("The PIN code you have entered is invalid." + "<br />");
						}
						else if(response.toLowerCase().indexOf("pincode_expired") > -1){
							document.write("The PIN code you have entered is expired." + "<br />");
						}
						else if(response.toLowerCase().indexOf("pincode_error") > -1){
							document.write("The PIN code you have entered is invalid." + "<br />");
						}
						else if(response.toLowerCase().indexOf("pincode_alreadyused") > -1){
							document.write("The PIN code you have entered has already been used." + "<br />");
						}
						else{
							document.write(response) + "<br />";
						}
					</script>
				</font></b>
				<input type="hidden" name="tracking0" maxlength="64" /> <!-- optional -->
				<input type="hidden" name="language" maxlength="5" /> <!-- optional -->
				<input type="hidden" name="hostederrorhandling" value="1" />
				<input type="text" name="Code" /><br />
				<input type="image" src="/images/bt_connect.gif" alt="Connect" style="margin-top: 7px;"><br />
			</form>
			<span style="color:#0000FF;font-family:Tahoma;font-size:12px;font-weight:normal;font-style:italic">To initiate a remote session, enter the code provided by your support representative in the box above and click "Connect".</span>
		</td>
	</tr>
</table>

<?php /*


<!-- <tr valign="top">
          <td height="5" colspan="2"><img src="/images/spacer.gif" width="1" height="5"></td>
        </tr>
        <tr valign="top">
          <td><img src="/images/arrow2.gif" width="4" height="17"></td>
          <td><a href="https://eclassroom.firstam.net/main/User/GuestAttend.jhtml?s">Centra&reg; Login </a></td>
        </tr> 
        <tr valign="top">
          <td height="5" colspan="2"><img src="/images/spacer.gif" width="1" height="5"></td>
        </tr> -->
<!-- Commented out 060606 until there is a working link <tr valign="top">
  <td><img src="/images/arrow2.gif" width="4" height="17"></td>
  <td><a href="http://mysms.firstamsms.com/centra_download.php">Download Centra&reg; Client Software </a></td>
</tr> -->



        <tr valign="top">
          <td colspan="2">
          
          <script language="JavaScript">
<!--
function setJS() {
	document.QuestionEntry.JavaScript.value = "true";
}
//-->
</script>
<form action="https://broker.gotoassist.com/h/sms-phone" method=get name=QuestionEntry>
<input type="hidden" name=Portal value="sms-phone">
<input type=hidden name=Target value="ds/queryPost.flow">
<input type=hidden name=Template value="ds/phoneModeRedemption.tmpl">
<input type=hidden name=JavaScript value=false>
<input type=hidden name=Form value=pbQuestionEntry>
<input type=text name=Question style="font: normal 10 verdana,arial,helvetica;width:140px;margin-bottom:6px;"><br />
<input type="image" src="/images/bt_connect.gif" alt="Connect" onClick=setJS()>
<!--<input type=submit value="Connect" onClick=setJS()>-->
</form>
<script language="JavaScript">
<!--
document.QuestionEntry.Question.focus()
//-->
</script>
<span style="color:#0000FF;font-family:Tahoma;font-size:12px;font-weight:normal;font-style:italic">To initiate a remote session, enter the code provided by your support representative in the box above and click "Connect".</span>
	      
          </td>
        </tr>
 */ ?>
<script language="javascript">
function printThis() {
	myDetailWindow = window.open('', 'BackupAgreement', 'location=no,menubar=yes,resizable=yes,scrollbars=no,status=no,toolbar=no,fullscreen=no,width=400,height=300');
	myDetailWindow.document.writeln('<html>');
	myDetailWindow.document.writeln('<head>');
	myDetailWindow.document.writeln('<title>First American SMS</title>');
	myDetailWindow.document.writeln('<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">');
	myDetailWindow.document.writeln('<link href="/mysms.css" rel="stylesheet" type="text/css">');
	myDetailWindow.document.writeln('<style type="text/css">');
	myDetailWindow.document.writeln('</style>');
	myDetailWindow.document.writeln('</head>');
	myDetailWindow.document.writeln('<body leftmargin="5" topmargin="0" marginwidth="0" marginheight="0">');
	myDetailWindow.document.writeln('<p><b>System Backup Agreement:</b></p>');
	myDetailWindow.document.writeln('<p> <font color="#CC0000"><b>*IMPORTANT REQUIREMENT FOR COMPLETING YOUR UPGRADE* </b></font></p>');
	myDetailWindow.document.writeln('<p> In order to upgrade your <?php echo $product; ?> system, First American SMS requires that a complete backup of the data directory(ies) be executed prior to beginning the upgrade.  This requirement is made in order to prevent any data loss in the event of an unrecoverable error during the upgrade.&nbsp; </p>');
	myDetailWindow.document.writeln('<p> By Accepting this Backup Agreement I hereby acknowledge, as a representative of my company, that a complete backup of the above referenced data directory(ies) will be performed prior to starting the upgrade of our <?php echo $product; ?> system. Further, I acknowledge that severe and complete data loss may result if any user logs in and accesses the <?php echo $product; ?> system during the data conversion process of the upgrade. </p>');
	myDetailWindow.document.writeln('</body');
	myDetailWindow.document.writeln('</html');
	myDetailWindow.print();
}
</script>
<p><b>System Backup Agreement:</b></p>
<p> <font color="#CC0000"><b>*IMPORTANT REQUIREMENT FOR COMPLETING YOUR UPGRADE* </b></font></p>
<p> In order to upgrade your <?php echo $product; ?> system, First American SMS requires that a complete backup of the data directory(ies) be executed prior to beginning the upgrade.  This requirement is made in order to prevent any data loss in the event of an unrecoverable error during the upgrade.&nbsp; </p>
<p> By Accepting this Backup Agreement I hereby acknowledge, as a representative of my company, that a complete backup of the above referenced data directory(ies) will be performed prior to starting the upgrade of our <?php echo $product; ?> system. Further, I acknowledge that severe and complete data loss may result if any user logs in and accesses the <?php echo $product; ?> system during the data conversion process of the upgrade. </p>
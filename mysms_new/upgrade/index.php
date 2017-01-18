<?php
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
?>
<?php
	$companyName = 'First American SMS';
	$companyTitle = 'We are currently upgrading the website.';
	$companyLogo = '<img src="logos/logo.gif">';
	$companyNote = 'We apologize for the inconvenience.  Please check back shortly.';
	$companyPhone = 'software.support@firstam.com';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo $companyName . ' : ' . $companyTitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="author" content="<?php echo $companyName; ?>" />
<meta name="copyright" content="Copyright 2009 - <?php echo $companyName; ?>, all rights reserved" />
<meta name="robots" content="index, follow" />
<meta name="revisit-after" content="15 days" />

<style type="text/css" media="screen">

	* { margin:0; padding:0; }

	body { color:#888; font-family:Arial, Helvetica, sans-serif; font-size:.7em; text-align:center; background-color:#eee; }

	h1,h2,h3 { color:#666; line-height:1.8em; }
	h1 { font-size:1.8em; }
	h2 { font-size:1.5em; }
	h3 { font-size:1.3em; }
	p { margin-bottom:.7em; line-height:1.4em; }

	.clear { clear:both; position:relative; font-size:0px; height:0px; line-height:0px; visibility:hidden; }

	.container { margin:100px auto 20px; width:520px; border:1px solid #aaa; }

	.col1-set { clear:both; background:#fff; border:7px solid #ddd; padding:40px; }
	.col1-set img { padding-bottom:20px; }

</style>
</head>
<body>
	<div class="container">
		<div class="col1-set">
			<?php echo $companyLogo; ?><br />
			<h1><?php echo $companyTitle; ?></h1>
			<p><?php echo $companyNote; ?></p>
			<h2>Need Immediate Assistance?</h2>
			<h3><?php echo $companyPhone; ?></h3>
			<div class="clear"></div>
		</div>
	</div>
	<p>&copy; <?php echo date("Y") ?> - <?php echo $companyName; ?>, all rights reserved.</p>
</body>
</html>
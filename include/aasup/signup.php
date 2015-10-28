<?php
session_start();
?>
<html><head>
<title>signup</title>
</head><body onload=document.form.imagetext.focus()>

<?php
// check what the user has entered matches what is in the session
if(isset($_POST['imagetext'])&&strlen($_POST['imagetext'])==7&&isset($_SESSION['text'])&&
	strtolower($_POST['imagetext'])==$_SESSION['text'])
{
	echo '<b><font color=green>input text matches that on the image</font></b>';
}
// there was no match
elseif(isset($_POST['imagetext']))
{
	echo '<b><font color=red>input text doesn\'t match the text on the image</font></b>';
}
unset($_SESSION['text']);
?>

<form name=form method=post action=<?=$_SERVER['PHP_SELF']?>?<?=SID?>>
<table>
<tr><td colspan=2>copy the text you see in this image into the text box</td></tr>
<tr><td><img src=aasup.php?<?=SID?>></td><td><input type=text name=imagetext></td></tr>
<tr><td colspan=2><input type=submit value=submit></td></tr></table>
</form>
</body></html>
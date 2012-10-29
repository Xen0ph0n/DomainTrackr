
<html>
<head></head>
<title>DomainTrackr</title>
<body>


<?php
// dbconnection
mysql_connect("db438830780.db.1and1.com", "dbo438830780", "infected") or die(mysql_error());
mysql_select_db("db438830780") or die(mysql_error());

if (!isset($_POST['domain']) || (!isset($_POST['contact']))){
echo '<b>DomainTrackr by Xen0ph0n<br><br>Enter Domain To Track!<br><br></b>';
echo '<form name search method="post">';
echo 'Domain: <input type="text" name="domain" maxlength="100"><br>';
echo 'Notes on Domain: <input type="text" maxlength="250" name="notes"><br>';
echo '<br><font size="2" color="red">Email Required For Tracking And Notification</font><br>';
echo 'Email: <input type="text" name="contact" maxlength="100"><br>';
echo '<input type="submit" value="Add to DB and Track"></form>';
echo '<br><br><br>';
echo 'Just need a quick IP/DNS Lookup?<a href="lookup.php"><b> Here you go</b></a>';
}

if (isset($_POST['domain']) && (isset($_POST['contact']))){
$domain = $_POST['domain'];
$contact = $_POST['contact'];

//check validity of email
if(!filter_var($_POST['contact'], FILTER_VALIDATE_EMAIL)){
echo "Not A Valid Email Address, you really need a real one.";
echo '<br><a href="index.php">Try Again</a>';
}

//do work if email checks out
else{
$oldip = gethostbyname($domain);
$newip = $oldip;
$notes = $_POST['notes'];
$datetime = date('Y-m-d H:i:s');
echo 'Current Resolution of <b>'.$domain.'</b> is:<br>';
echo '<b>'. $oldip. '</b><br><br>';
echo 'Domain Added to Account:<br>';
echo '<b>'. $contact. '</b><br><br>';
echo '<b><a href="trackr.php?email='.$contact.'">Click Here To Track All Your Domains</a></b>';
mysql_query("INSERT INTO domaintrackr (domain, newip, oldip, changedate, contact, notes) VALUES('$domain', '$newip', '$oldip', '$datetime' , '$contact', '$notes') ") or die(mysql_error());
}
}


echo '<br><br><br><br><font size="2">DomainTrackr by Xen0ph0n.<br> <a href="http://www.github.com/Xen0ph0n/DomainTrackr"> View Source / Fork It </a>';
?>

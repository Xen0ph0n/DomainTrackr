<html>
<head>
<title>DomainTrackr</title>
<style type="text/css">
<!--
A:link {text-decoration: none}
A:visited {text-decoration: none}
A:active {text-decoration: none}
A:hover {text-decoration: underline}
-->
</style>
</head>

<body>


<?php

// DomainTrackr by Chris Clark
// chris@xenosec.org / #xenosec / xen0ph0n @ github.com
// Copyright and Licenced GPL v3


// dbconnection
mysql_connect("DBSERVER", "USERNAME", "PASSWORD") or die(mysql_error());
mysql_select_db("DATABASE") or die(mysql_error());

if (!isset($_POST['domain']) || (!isset($_POST['contact']))){
echo '<b>DomainTrackr<br><br>Enter Domain To Track!<br><br></b>';
echo '<form name search method="post">';
echo 'Domain: <input type="text" name="domain" maxlength="100"><br>';
echo 'Notes on Domain: <input type="text" maxlength="250" name="notes"><br>';
echo '<br><font size="2" color="red">Email Required For Tracking And Notification<br>Track up to Thirty (30) Domains Per Account.</font><br>';
echo 'Email: <input type="text" name="contact" maxlength="100"><br><br>';
echo '<input type="submit" value="Add to DB and Track"></form>';
echo '<br><br>';
echo '<a href="trackr.php"> Track Your Existing Domains <br><br></a>';
echo 'Just need a quick IP/DNS Lookup?<a href="lookup.php"> Here you go</a>';
}

if (isset($_POST['domain']) && (isset($_POST['contact']))){
$domain = $_POST['domain'];
$contact = $_POST['contact'];
$multipcheck = gethostbynamel($domain);

//check validity of email
if(!filter_var($_POST['contact'], FILTER_VALIDATE_EMAIL)){
echo '<b>DomainTrackr<br></b><br>';
echo "<b><font color='red'>". $contact . "</font> Is Not A Valid Email Address </b><br> You really need a real one for tracking and alerts!";
echo '<br><br><a href="index.php">Try Again Please</a>';
}

//check if domain has multiple dns records, like akamai hosted sites etc

elseif(count($multipcheck) >= 2){
echo '<b>'. $domain.' </b>Uses Anycast DNS (such as Google.com) it is<b> 99.9% not Malcious </b><br><br>';
echo 'Current Resolution of <b>'.$domain.'</b> is:<br><br>';
	foreach($multipcheck as $ip){
	echo $ip . '<br>';
	}
echo '<br><b>'. $domain .'</b> has<b> NOT </b> been added to your DomanTrackr Account<br><br><b><a href="index.php">Enter a New Domain</a></b><br></b>';

}
//make sure user has less than 25 domains in domain tracker

elseif(mysql_num_rows(mysql_query("SELECT * FROM domaintrackr WHERE contact = '$contact'")) >= 30){
echo '<b>'. $contact.' </b>has reached limit for trackable domains (30) </b><br><br>';
echo '<br><b>'. $domain .'</b> has<b> NOT </b> been added to your DomanTrackr Account<br><br><b><a href="trackr.php?email='.$contact.'">View and Delete Existing Domains</a></b><br></b>';
echo '<br><b><a href="mailto:chris@xenosec.org">Tell Me Why You Need More!</a></b>';
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
echo '<b><a href="trackr.php?email='.$contact.'">Track All Your Domains</a></b>';
mysql_query("INSERT INTO domaintrackr (domain, newip, oldip, changedate, contact, notes) VALUES('$domain', '$newip', '$oldip', '$datetime' , '$contact', '$notes') ") or die(mysql_error());
echo '<br><br><br><a href="index.php">Add More Domains!</a>';
}
}


echo '<br><br><br><br><font size="2">DomainTrackr by Xen0ph0n.<br> <a href="http://www.github.com/Xen0ph0n/DomainTrackr"> View Source / Fork It </a>';
?>

<?php header('Refresh: 1800'); ?>
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


//delete domains from tracking
if (isset($_POST['delete'])){
$deleteid = $_POST['delete'];
echo "<b>DomainTrackr</b><br><br>";
mysql_query("DELETE FROM domaintrackr WHERE ID='$deleteid'") or die(mysql_error());
echo "<b>Domain Successfully Removed From DomainTrackr</b><br>";
echo '<br><a href="'.$_SERVER['HTTP_REFERER'].'">Continue Tracking Your Domains</a></br>';
echo '<br><br><a href="index.php">Enter New Domains to Track</a>';
}


// Enter your contact email to track your domains..requires open browser window refresh every 30mins
elseif (!isset($_GET['email'])){
echo "<b>DomainTrackr</b><br><br>";
echo "Please Enter Your Email Address To Track Your Domains: "; 
echo '<form name search method="get">';
echo 'Email Address: <input type="text" maxlength="100" name="email">';
echo '<input type="submit" value="Track"></form>';
echo '<br><br><a href="index.php">Enter New Domains to Track</a>';
}


else {
$contact = $_GET['email'];

//check validity of email
if(!filter_var($contact, FILTER_VALIDATE_EMAIL)){
echo "Not A Valid Email Address";
}

else{
$domains = mysql_query("SELECT * FROM domaintrackr WHERE contact='$contact'");

//if no hits tell user to enter right email or add domains
if(mysql_num_rows($domains)==0){
echo 'Domaintrackr has no domains for this Email Address<br>';
echo '<a href="index.php">Add SOME!!</a><br>';
echo '<a href="trackr.php">Or Enter Correct Email</a>';
}

//Track Domains
else{
echo "<b> DomainTrackr<br><br>Displaying All Domains for " . $contact . " <br></b><i><font size='2' color='darkblue'> Keep this page open in your browser, it will refresh every 30 minutes and email you any changes <br> (This Stops Me From Getting Launched From My WebHost!) </font><br><br></i><a href='index.php'>Track Additional Domains</a><br><br>";

$allchangeddomains = array();
while($row = mysql_fetch_array($domains)){
	echo "Domain:<b> ". $row['domain'] ."</b>";
	echo "<font size='2'> <i>Notes: " . $row['notes']. "</font></i><br>";
	$currentip = gethostbyname($row['domain']);
	//get new resolutions and send email if ips are different
	if($row['newip'] == $currentip){
		echo " Current Resolution <b> ". $currentip. "</b> Last Change: <b>" . $row['changedate']. "</b>";
		}
	else{
		$changedate = date('Y-m-d H:i:s');
		$lastip = $row['newip']; 
		$oid = $row['ID'];
		mysql_query("UPDATE domaintrackr SET changedate='$changedate', oldip='$lastip', newip='$currentip' WHERE id='$oid'") or die(mysql_error());
	        echo "<font color='red'> NEW IP: <b> ". $currentip. "</b></font> Previous IP:<b> ". $lastip. "</b> Last Change: <b>" . $changedate. "</font></b>"; 
		$changeddomain = "Domain: " .$row['domain'] . " Previous IP: " . $lastip . " NEW IP " . $currentip . " Notes on Domain: ". $row['notes']. "\n";
		$allchangeddomains[$oid] = $changeddomain;
		} 
		
	echo ' <form action="trackr.php" method="post"><button type="submit" name="delete" value="'. $row['ID'].'" >Stop Tracking '.$row['domain'].'</button> </form>';	
		
	
	}


if($allchangeddomains != null){
$arraystring = implode('', $allchangeddomains);
$datetime = new DateTime();
$subject = "Malicious Domain IP Resolution Change!!";
$body = "As of ". $datetime->format('Y-m-d H:i:s') . " the following Domains you are tracking resolve to new IPs: \n \n" . $arraystring . "\n \n Provided by DomainTrackr by Xen0ph0n";
$headers = 'From: DomainTrackr <trackr@xenosec.org>' . "\r\n" . 'Reply-To: trackr@xenosec.org' . "\r\n" . 'X-Mailer: DomainTrackr';

 if (mail($contact, $subject, $body, $headers)) {
   echo("<br><b>Alert Message Successfully Sent!</b>");
  } else {
   echo("<br><b>Alert Message Delivery Failed...</b>");
  }
}
}}}

	
echo '<br><br><br><br><font size="2">DomainTrackr by Xen0ph0n.<br> <a href="http://www.github.com/Xen0ph0n/DomainTrackr"> View Source / Fork It </a>';

?>
</body>
</html>

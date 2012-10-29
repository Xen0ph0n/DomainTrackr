<html>
<title>DomainTrackr</title>
<body>
<?php
// dbconnection
mysql_connect("db438830780.db.1and1.com", "dbo438830780", "infected") or die(mysql_error());
mysql_select_db("db438830780") or die(mysql_error());

// Enter your contact email to track your domains..requires open browser window refresh every 30mins
if (!isset($_GET['email'])){
echo "Please Enter Your Email Address To Track Your Domains: "; 
echo '<form name search method="get">';
echo 'Email Address: <input type="text" name="email">';
echo '<input type="submit" value="Track"></form>';
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
while($row = mysql_fetch_array($domains)){
	echo "Domain: ". $row['domain'] ." Previous IP: ". $row['oldip']. " New IP: ". $row['newip'] . " Date of Change: ". $row['changedate'];
	echo "<br><br>";
	}
}}}
echo '<br><br><br><br><font size="2">DomainTrackr by Xen0ph0n.<br> <a href="http://www.github.com/Xen0ph0n/DomainTrackr"> View Source / Fork It </a>';

?>
</body>
</html>

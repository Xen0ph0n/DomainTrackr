
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
// Usage:
// Upload to your site of choice, free hosing provider etc. 
// Use as an API to scrape/check lots of stuffs..
// www.domain.com/domaintrackr/?full=yes&domain=DOMAIN.NAME (full DNS results)
// "                        ""/?domain=DOMAIN.NAME (quick lookup of IPs it resolves too)
//
// "                        ""/?full=yes&ip=xxx.xxx.xxx.xxx (Full reverse results)
// "                        ""/?IP=xxx.xxx.xxx.xxx (quick lookup of DNS name)



echo '<b>Enter Your Search<br><br></b>';
echo '<form name search method="get">';
echo 'Full DNS Results (Slower):<input type="checkbox" value="yes" name="full" ><br>';
echo '<br>Search for one or the other:<br>';
echo 'Domain: <input type="text" name="domain"><br>';
echo 'IP: <input type="text" name="ip"><br>';
echo '<input type="submit" value="Lookup"></form>';



if (isset($_GET['domain']) && $_GET['ip'] == null){
$domain = $_GET['domain'];
$quickresult = gethostbynamel($domain);

echo '<b>Quick Results:</b><br><br>';
foreach($quickresult as $ip){
	echo $ip . '<br>';
	}

if (isset($_GET['full']) && isset($_GET['domain'])){
$dnsresult = dns_get_record($domain, DNS_ALL);
echo '<br><b>Full DNS Results:</b><br>';
foreach($dnsresult as $key => $val){
	if(is_array($val)){
		 echo ' <br>';
		foreach($dnsresult[$key] as $subkey => $subval){
			if(is_array($subval)){
				foreach($dnsresult[$key][$subkey] as $subsubkey => $subsubval){
				echo $subsubkey . ' : ' . $subsubval.'<br>';
				}
				}
			else{
			echo $subkey. ' : '. $subval.'<br>';
			}
			}
		}
	else{
	echo $key. ' : '. $val.'<br>';
	}
}
}
}


elseif (isset($_GET['ip'])){
$ip = $_GET['ip'];
$domain = gethostbyaddr($ip);

echo '<b>Quick Results:</b><br><br>';
echo $domain .'<br>';
        }


if (isset($_GET['full']) && $_GET['ip'] != null){
$result = dns_get_record($ip.'.IN-ADDR.ARPA', DNS_ANY);

echo '<br/><b>Full DNS Results:</b><br>';

foreach($result as $key => $val){
	if(is_array($val)){
		echo ' <br>';
		foreach($result[$key] as $subkey => $subval){
			if(is_array($subval)){
				echo $subkey. ': <br>';
				foreach($result[$key][$subkey] as $subsubkey => $subsubval){
				echo $subsubkey . ' : ' . $subsubval.'<br>';
				}
				}
			else{
			echo $subkey. ' : '. $subval.'<br>';
			}
			}
		}
	else{
	echo $key. ' : '. $val.'<br>';
	}
}
}
echo '<br><br><br><br><font size="2">DomainTrackr by Xen0ph0n.<br> <a href="http://www.github.com/Xen0ph0n/DomainTrackr"> View Source / Fork It </a>';

?>

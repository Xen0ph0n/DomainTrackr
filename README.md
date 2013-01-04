// DomainTrackr by Chris Clark <br>
// chris@xenosec.org / xen0ph0n @ github.com <br>
// Copyright and Licenced GPL v3 <br><br>

DomainTrackr is a PHP & MySQL tool which allows researchers to eaisly track <br>
the resolution of malicious domains, and be pro-activly alerted to changes.<br>
Install Requires a MySQL database with the following structure:
<br><br>
ID    int(10) 	  	  	No  	  	auto_increment 	Primary 	Unique <br>
domain  	varchar(100) 	utf8_bin 		Index  	Fulltext<br>
oldip  	varchar(15) 	utf8_bin 	 	Index <br>
newip  	varchar(15) 	utf8_bin  	Index <br>
changedate  	datetime 	 	<br>
notes  	varchar(250) 	utf8_bin 	 	Fulltext<br>
contact  	varchar(100) 	utf8_bin 	 <br>
<br><br>
Then just put the relevant DB info in the //dbconnection sections at the top of index & trackr <br>
Also change the send from email address at the bottom of trackr to something relevant to your domain. <br>

Version .01a<br>
Next Features to be Added: Pretty Webfront, Optional Email updates, pivotable ip's and domains to OSI tools <br><br>


Usage:<br>
1. Enter Domain, Relevant Notes, and Email Address on the index page<br>
2. Chose to either enter additional domains, or go to Trackr<br>
3. You can delete domains from Trackr you no longer wish to track (30 Domains Per Account)<br>
4. Leave a browser window open to Trackr, it will refresh every 30 minutes<br>
all domains ever entered by a user will be tracked (email address is account)<br>
if any IP Resolution changes are detected an alert email will be sent to the<br>
account email containing details. <br>
<br><br>

Live Example:<br>
http://www.dtrackr.com/ <-- Enter Domains<br>
http://www.dtrackr.com/trackr.php <-- Track Your Domains<br>
https://www.xenosec.org/trackr/trackr.php?email=chris@xenosec.org <-- Example with domains added (google to show deltas)<br>
<br>
NOTE: Currently DomainTrackr does not support sites which resolve to multiple 
IP Addresses. This functionality isn't needed in tracking malicious C2 domains
and malicious infrastructure. (IE Google.com, Yahoo.com etc).<br><br><br>


Additionally included is a super lightweight PHP DNS and Reverse lookup page:<br><br>
http://www.dtrackr.com/lookup.php <-- Full DNS Lookup Page<br>
Upload to your site of choice, free hosing provider etc. just needs PHP<br>
Use as an API to scrape/check lots of stuffs.. <br>
lookup.php?full=yes&domain=DOMAIN.NAME (full DNS results) <br>
" ""/?domain=DOMAIN.NAME (quick lookup of IPs it resolves too) <br>
IP reverse lookup: (sucks , and will only give one random result if multiple domains hosted) <br>
" ""/?full=yes&ip=xxx.xxx.xxx.xxx (Full reverse results) <br>
" ""/?IP=xxx.xxx.xxx.xxx (quick lookup of DNS name) <br>
<br><br>
Example of Alert Email:
<br><br>
As of 2012-10-29 03:06:13 the following Domains you are tracking resolve to new IPs: 
 <br><br>
Domain: google.com Previous IP: 74.125.225.41 NEW IP 74.125.225.34 Notes on Domain: Please buy me!!<br>
Domain: google.com Previous IP: 74.125.225.2 NEW IP 74.125.225.135 Notes on Domain: Steal all your info here<br>
Domain: yahoo.com Previous IP: 98.139.183.24 NEW IP 98.138.253.109 Notes on Domain: People Still Visit This sitE?<br>
<br><br>
Provided by DomainTrackr by Xen0ph0n
<br>
<br>
<br>


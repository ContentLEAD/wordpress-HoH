<?php
//example calling of the classes.
require_once 'headlinesXML.php';
require_once 'headlinesImages.php';

$headlines = new HeadlinesImages('user','pw','db','localhost');
$HOH =  $headlines->getHeadlines("Title of News Section","http://www.linktoblogpage.com");
$style = $headlines->getStyles();
echo "<head>" . $style . "</head><body>";
echo $HOH;
echo "<br/>";
$headlines2 = new HeadlinesXMLRPC('wp_user','wp_pw','p/xmlrpc.php',3);//number of posts
$HOH2 =  $headlines2->getHeadlines("Title of News","http://www.linktoblogpage.com");
echo $HOH2;
echo "<br/>";

$style2 = $headlines2->getStyles();



 "</body>"; 

?>
<?php
/**
 * Hinzufügen von Büchern zur Datenbank
 *
 * Diese Datei ist ein Eingabeformular um Bücher zur Datenbank hinzuzufügen und
 * zur Hilfe, werden Daten per ISBN von Amazon zu holen
 *
 * PHP Version nur mit Version 5 getestet
 *
 * Lizens: Diese Datei wurde unter der GNU Public License lizensiert, diese
 * liegt in der Datei COPYING im Hauptverzeichnis wenn sie die Datei nicht
 * mit erhalten haben, ist sie unter http://www.gnu.org/copyleft/gpl.html
 * zu finden.
 *
 * @package    myBooks
 * @author     Fabian Mruck <norge@berlios.de>
 * @copyright  2006 Fabian Mruck
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    SVN: $Id:s$
 */
require_once('/include/isbn.php');
require_once('/include/main.php');

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>myBooks</title>
</head>
<body onload="document.isbn.isbn.focus();">
<form name="isbn" method="get" action="">
<input type="text" name="isbn" />
<input type="submit" />
</form>';


$ISBN_ein = $_GET['isbn'];
if (!$ISBN_ein){
    $ISBN_ein = "9783897212138";
}
$ISBN = isbn_clear($ISBN_ein);

$url  = "http://webservices.amazon.de/onca/xml";
$url .= "?Service=AWSECommerceService";
$url .= "&SubscriptionId=17155194708692CTJJ82";
$url .= "&Operation=ItemLookup";
$url .= "&ItemId=".$ISBN;
$url .= "&MerchantId=All";
$url .= "&ResponseGroup=Medium,ItemAttributes,EditorialReview,Reviews";


$xml = simplexml_load_file($file);

$xml1 = simplexml2array($xml);

echo '<a href="'.$xml1[Items][Item][DetailPageURL].'">Buch bei Amazon kaufen</a><br />';
if ($xml1[Items][Item][LargeImage][URL]){
    if (!file_exists("/kunden/115002_90607/buch/jpg/large/$ISBN.jpg")) {
    copy($xml1[Items][Item][LargeImage][URL], "/kunden/115002_90607/buch/jpg/large/$ISBN.jpg");
    }
    echo '<img src="http://book.fabi.ws/jpg/large/'.$ISBN.'.jpg" alt="'.$ISBN.'" />';
}
if ($xml1[Items][Item][MediumImage][URL]){
    if (!file_exists("/kunden/115002_90607/buch/jpg/medium/$ISBN.jpg")) {
    copy($xml1[Items][Item][MediumImage][URL], "/kunden/115002_90607/buch/jpg/medium/$ISBN.jpg");
    }
    echo '<img src="http://book.fabi.ws/jpg/medium/'.$ISBN.'.jpg" alt="'.$ISBN.'" />';
}
if ($xml1[Items][Item][SmallImage][URL]){
    if (!file_exists("/kunden/115002_90607/buch/jpg/small/$ISBN.jpg")) {
    copy($xml1[Items][Item][SmallImage][URL], "/kunden/115002_90607/buch/jpg/small/$ISBN.jpg");
    }
    echo '<img src="http://book.fabi.ws/jpg/small/'.$ISBN.'.jpg" alt="'.$ISBN.'" /><br />';
}
if (count($xml1[Items][Item][EditorialReviews][EditorialReview]) > 0) {


    if (!$xml1[Items][Item][EditorialReviews][EditorialReview][Source]){
        foreach ($xml1[Items][Item][EditorialReviews][EditorialReview] as $Review){
            echo $Review[Source]."<br />";
            echo $Review[Content]."<br />";
        }
    }else{
        echo $xml1[Items][Item][EditorialReviews][EditorialReview][Source]."<br />";
        echo $xml1[Items][Item][EditorialReviews][EditorialReview][Content]."<br />";
    }
}
$data = $xml1[Items][Item][ItemAttributes];
echo  "<br /><br />";
foreach ($data as $key => $value) {
   echo $key.":  ".$value."<br />";

}


echo "
</body>
</html>";

?>
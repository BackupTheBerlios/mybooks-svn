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
 * @version    SVN: $Id:$
 */
require_once('includes/isbn.php');
require_once('includes/main.php');

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
    $GLOBALS[ERROR] = "Bitte geben Sie eine ISBN ein!";
}

$ISBN = isbn_clear($ISBN_ein);

if (substr($ISBN, 0, 1)) {

}
switch (substr($ISBN, 0, 1)) {
    case 3:
        $ISBN_lang = "de";;

        break;
    case 0:
        $ISBN_lang = "com";;
        break;
    case 1:
        $ISBN_lang = "com";;
        break;
    default:
        break;
}
$ISBN_lang = "de";

$url  = "http://webservices.amazon.";
$url .= $ISBN_lang;
$url .= "/onca/xml";
$url .= "?Service=AWSECommerceService";
$url .= "&SubscriptionId=";
$url .= AMAZONID;
$url .= "&Operation=ItemLookup";
$url .= "&ItemId=";
$url .= $ISBN;
$url .= "&MerchantId=All";
$url .= "&ResponseGroup=Medium,ItemAttributes,EditorialReview,Reviews";


$xml = simplexml_load_file($url);

$xml1 = simplexml2array($xml);


/*
echo '<a href="'.$xml1[Items][Item][DetailPageURL].'">Buch bei Amazon kaufen</a><br />';
if ($xml1[Items][Item][LargeImage][URL]){
    if (!file_exists("/kunden/115002_90607/buch/mybooks/images/large/$ISBN.jpg")) {
        copy($xml1[Items][Item][LargeImage][URL], "/kunden/115002_90607/buch/mybooks/images/large/$ISBN.jpg");
    }
    echo '<img src="http://book.fabi.ws/mybooks/images/large/'.$ISBN.'.jpg" alt="'.$ISBN.'" />';
}
if ($xml1[Items][Item][MediumImage][URL]){
    if (!file_exists("/kunden/115002_90607/buch/mybooks/images/medium/$ISBN.jpg")) {
        copy($xml1[Items][Item][MediumImage][URL], "/kunden/115002_90607/buch/mybooks/images/medium/$ISBN.jpg");
    }
    echo '<img src="http://book.fabi.ws/mybooks/images/medium/'.$ISBN.'.jpg" alt="'.$ISBN.'" />';
}
if ($xml1[Items][Item][SmallImage][URL]){
    if (!file_exists("/kunden/115002_90607/buch/mybooks/images/small/$ISBN.jpg")) {
        copy($xml1[Items][Item][SmallImage][URL], "/kunden/115002_90607/buch/mybooks/images/small/$ISBN.jpg");
    }
    echo '<img src="http://book.fabi.ws/mybooks/images/small/'.$ISBN.'.jpg" alt="'.$ISBN.'" /><br />';
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

}*/






echo "
</body>
</html>";

?>
<?php
/**
 * ISBN Funktionen
 *
 * In dieser Datei werden Funktionen zur Umwandlung der ISBN, und zum pr�fen
 * derselben bereitgestellt
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
 * @todo Fehlermeldungen einbauen und Pr�fziffern pr�fen
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    SVN: $Id:$
 */

/**
 * Diese Funktion wandelt eine ISBN13 in eine ISBN um
 *
 * @param string $isbn13 ISBN13
 * @return string ISBN
 */
function c_isbn($isbn13)
{

    //�berpr�fung ob 978 als Start fehlt?
    if (substr($isbn13, 0, 3) !== "978") {
        //FHELT!!! Ausgeben einer Fehlermeldung
        return null;
        die();
    }
    //Die ISBN ohne Pr�fziffer aus der ISBN 13 extrahieren
    $isbn_o_pz = substr($isbn13, 3, 9);
    //Anf�gen der Pr�fziffer mitels der Funktion isbn_pz
    $isbn = $isbn_o_pz.isbn_pz($isbn_o_pz);
    //Zur�ckgeben der vollst�ndigen ISBN
    return $isbn;
}

/**
 * Diese Funktion wandelt eine ISBN13 in eine ISBN um
 *
 * @param string $isbn ISBN
 * @return string ISBN13
 */
function c_isbn13($isbn)
{
    //Die ISBN ohne Pr�fziffer extrahieren
    $isbn_o_pz = substr($isbn, 0, 9);
    //Zur Erzeugung der ISBN13 voranstellen vun 978
    $isbn13 = "978".$isbn_o_pz;
    //Anf�gen der EAN-Pr�fziffer mittels der Funktion ean_pz
    $isbn13 = $isbn13.ean_pz($isbn13);
    //Zur�ckgeben der vollst�ndigen ISBN13
    return $isbn13;

}

/**
 * Erstellt die Pr�fziffer einer ISBN
 *
 * @param string $isbn_o_pz
 * @return string
 */
function isbn_pz($isbn_o_pz)
{
    //Erzeugen der Pr�fziffersumme
    $pzs  =   substr($isbn_o_pz, 0, 1);
    $pzs += 2*substr($isbn_o_pz, 1, 1);
    $pzs += 3*substr($isbn_o_pz, 2, 1);
    $pzs += 4*substr($isbn_o_pz, 3, 1);
    $pzs += 5*substr($isbn_o_pz, 4, 1);
    $pzs += 6*substr($isbn_o_pz, 5, 1);
    $pzs += 7*substr($isbn_o_pz, 6, 1);
    $pzs += 8*substr($isbn_o_pz, 7, 1);
    $pzs += 9*substr($isbn_o_pz, 8, 1);
    //Teilen der Summe durch 11 und ausgeben des Restes
    $pz = fmod($pzs, 11);
    //�berpr�fen ob die Pr�fziffer 10 ist
    if ($pz == 10) {
        //Wenn ja erstzen mit X
        $pz = "X";
    }
    //Zur�ckgeben der Pr�fziffer
    return $pz;
}

/**
 * Erstellt die Pr�fziffer einer EAN
 *
 * @param string $ean
 * @return string
 */
function ean_pz($ean)
{
    //Erzeugen der Pr�fziffersumme
    $pzs = 3*substr($ean, 11, 1);
    $pzs += substr($ean, 10, 1);
    $pzs += 3*substr($ean, 9, 1);
    $pzs += substr($ean, 8, 1);
    $pzs += 3*substr($ean, 7, 1);
    $pzs += substr($ean, 6, 1);
    $pzs += 3*substr($ean, 5, 1);
    $pzs += substr($ean, 4, 1);
    $pzs += 3*substr($ean, 3, 1);
    $pzs += substr($ean, 2, 1);
    $pzs += 3*substr($ean, 1, 1);
    $pzs += substr($ean, 0, 1);
    //Teilen der Summe durch 10 und den Rest von 10 abziehen
    $pz = 10-fmod($pzs, 10);
    //Zur�ckgeben der Pr�fziffer
    return $pz;
}

/**
 * Bereinigt die ISBN und gibt sie als ISBN aus
 *
 * Entfernt Leerzeichen und Bindestriche aus der ISBN, pr�ft ob es eine ISBN
 * oder ISBN 13 ist und wandelt sie gegebenenfals in eine ISBN um
 *
 * @param string $isbn
 * @return string ISBN
 */
function isbn_clear($isbn)
{
    //Entfernen von Leerzeichen und Bindestrichen
    $isbn = ereg_replace("[[:space:]-]+", "", $isbn);
    //�berpr�fen der L�nge
    switch (strlen($isbn)) {
        //Wenn 10 dann ist es eine ISBN
        case 10:
            $isbn = $isbn;
            break;
        //Wenn 10 dann ist es eine ISBN13
        case 13:
            //ISBN13 nach ISBN umwandeln
            $isbn = c_isbn($isbn);
            break;
        default:
            //ERROR Fehlermeldung einf�gen
            break;

    }

    //ISBN zur�ck geben
    return $isbn;

}
?>
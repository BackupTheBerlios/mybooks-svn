<?php
/**
 * Grundfunktionen für myBooks
 *
 * In dieser Datei werden Funktionen gespeichert die für verscheidenste Seitenm benutzt werden
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
 * @version    SVN: $Id$
 */

function simplexml2array($xml)
{
    if (get_class($xml) == 'SimpleXMLElement') {
        $attributes = $xml->attributes();
        foreach($attributes as $k=>$v) {
            if ($v) $a[$k] = (string) $v;
        }
        $x = $xml;
        $xml = get_object_vars($xml);
    }
    if (is_array($xml)) {
        if (count($xml) == 0) return (string) $x; // for CDATA
        foreach($xml as $key=>$value) {
            $r[$key] = simplexml2array($value);
            // original line instead of the following if statement:
            //$r[$key] = simplexml2ISOarray($value);
            if ( !is_array( $r[$key] ) ) $r[$key] = utf8_decode( $r[$key] );
        }
        if (isset($a)) $r['@'] = $a;    // Attributes
        return $r;
    }
    return (string) $xml;
}
/**
 * Funktion um eine Verbindung zur MySQL-Datenbank herzustellen
 *
 */
function connect_mysql()
{
    //Verbindung zum Datenbankserver herstellen
    $conn = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD);
    //Datenbank auswaehlen
    mysql_select_db (MYSQL_DATABASE);
}
?>
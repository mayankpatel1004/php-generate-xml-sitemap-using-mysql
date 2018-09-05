<?php
require ("Connection.php");
//Create file
$file = fopen("http://192.168.56.101/IRMA_server/phpFiles/results.xml",w);
//Display Document in browser as plain text for readabiity purposes
header("Content-type: text/xml;charset=utf-8");
//Obtain the number of phases
$Query = "SELECT MAX(Phase_ID) AS NbPhase FROM Improvements";
$Result = mysql_query($Query);
$Row = mysql_fetch_object($Result);
$nbPhase = $Row->NbPhase;
print "<TrafficPhase>\n";
$i = 1;
while ($i <= $nbPhase)
{
print "<Phase>\n";
$k = 1;
$Query1 = "SELECT ImpName, Phase, Option_ID, COUNT(Option_ID) AS NbOption FROM Improvements WHERE Phase_ID = $i";
$Result1 = mysql_query($Query1);
$Row1 = mysql_fetch_object($Result1);
print "<PhaseName>".$Row1->Phase."</PhaseName>\n";
print "<Option_id>" .$k. "</Option_id>\n";
print "<name>".$Row1->ImpName."</name>\n";
print "<Option_Concept_ID>".$Row1->Option_ID."</Option_Concept_ID>\n";
$k = $k + 1;
$Query2 = "SELECT ImpName, Option_ID FROM Improvements WHERE Phase_ID = $i";
$Result2 = mysql_query($Query2);
$Row2 = mysql_fetch_object($Result2);
while($Row2 = mysql_fetch_object( $Result2))
{
print "<Option_id>" .$k. "</Option_id>\n";
print "<name>".$Row2->ImpName."</name>\n";
print "<Option_Concept_ID>".$Row2->Option_ID."</Option_Concept_ID>\n";
$k = $k + 1;
}
$i = $i + 1;
print "</Phase>\n";
}
print "</TrafficPhase>\n";
$xml->formatOutput = true;
echo $xml->saveXML();
fwrite($file, $xml->asXML());
fclose($file);
?>
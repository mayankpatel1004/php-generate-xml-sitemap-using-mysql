<?php require_once("connection.php");

function createRSSFile($post_title)
{
	$returnITEM = "<item>\n";
	
	$returnITEM = "<url>\n
  		<loc>$post_title</loc>\n
  		<changefreq>hourly</changefreq>\n
	</url>\n";
	
	$returnITEM .= "<title>".$post_title."</title>\n";
	$returnITEM .= "</item>\n";
	return $returnITEM;
}

$filename = "sitemap.xml";
$rootURL = "http:/localhost/misc/generate-sitemap/";
$latestBuild = date("r");

$createXML = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$createXML .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"
      xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
      xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n";
			
$content_search = "SELECT name FROM categories ORDER BY id DESC";
$content_results = mysql_query($content_search);

while ($articleInfo = mysql_fetch_assoc($content_results))
{
	$title = $articleInfo["name"];
	$createXML .= createRSSFile($title);
}
$createXML .= "\n</urlset>";
// Finish it up
$filehandle = fopen($filename,"w") or die("Can't open the file");
fwrite($filehandle,$createXML);
fclose($filehandle);

?>
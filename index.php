<?php

$rawData = array();


if (($handle = fopen("data/qc_4.csv", "r")) !== FALSE) {
	while (($data = fgetcsv($handle, 0, "\t", '"')) !== FALSE) {
		$rawData[] = $data;
	}
}

echo "Voici ce que j'ai lu: <br />\n";
echo "<table>";

## from http://www.developergeekresources.com/examples/php/php_mdimarr1a.php
echo "<table border='1'>";
foreach ($rawData as $rows => $row)
{
	echo "  <tr>\n";
	foreach ($row as $col => $cell)
	{
		echo "    <td>" . $cell . "</td>\n";
	}	
  echo "  </tr>\n";
}	
echo "</table>";

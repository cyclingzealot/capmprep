<?php

$rawData = array();


if (($handle = fopen("data/qc_4.csv", "r")) !== FALSE) {
	$line = 0;
	$headers = 0;
	while (($data = fgetcsv($handle, 0, "\t", '"')) !== FALSE) {
		if($line == 0)  $headers = $data;
		else {
			foreach($headers as $key => $headerName) {
				$value = $data[$key];
				if(strlen($value) > 0) {
					$rawData[$data[0]][$headerName] = $data[$key];
				}
			}
		}

		$line++;
	}
}



/**
echo "Voici ce que j'ai lu: <br />\n";

echo '<pre>';
var_export($rawData);
echo '</pre>';
*/



#### Choisir la type de question:

$qtType = rand(3, 3);
#1. Lequel des suivant est un T de P 
#2. Lequel des suivant n'est pas un T de P
#3. X se trouve dans le T de ...


### Choisir l'item concerné par la question

switch ($qtType) {
case 0: askTypeOfParent(); break;
case 3: askWhatIsMyParent($rawData); break;
case 1: askTypeOfNotParent(); break;
	
}



#3. Xi se trouve dans le Tp de ...
function askWhatIsMyParent($rawData) {
	// For this question, the item must have a parent 
	$itemSatisfactory = FALSE;
	$data = array();

	// Find a suitable item for the question.
	// The item must have a parent
	while(!$itemSatisfactory) {
		$idPicked = pickItem(__LINE__, count($rawData));

		if($idPicked === FALSE)  die("No suitable candidates left");

		$data = $rawData[$idPicked];

		if(empty($data))  die("No data found for item picked");

		if(!empty($data['Parent1']))  {$itemSatisfactory = TRUE;}
		#else {echo "Rejected " . $data['Label'] . "<br />";}
	}

	$parentKey = 'Parent1';

	//Check if parent2 exists.  If so, consider picking it
	if(!empty($data['Parent2']) && rand(1,2) == 2)  $parentKey = 'Parent2';


	// Get all the parent data
	$parentID = $data[$parentKey];
	$parentLabel = $rawData[$parentID]['Label'];
	$parentTypeID = $rawData[$parentID]['Type'];
	$parentTypeLabel = $rawData[$parentTypeID]['Label'];

	$itemLabel = $data['Label'];

	### Print the question
	echo "$itemLabel se trouve dans le " . strtolower($parentTypeLabel) . " de ...  $parentLabel";


}


function pickItem($requestID, $numItems) {
	if(!isset($requestID)) die("The request must be valid.  Got $requestID");
	// Track the requests to make sure we're not 
	// sending the same item per requests, and that 
	// we die if we can't find an appropriate item

	//$requestTracker is static so we remember all
	//the calls to this function after its exit
	static $requestTracker = array();

	//Is this the first time we get a call 
	//from line $requestID?
	if(!isset($requestTracker[$requestID])) {
		//If so, initialize the array	
		//with the ID of every question
		$requestTracker[$requestID] = range(0, $numItems-1);
	}


	// No candidates left?  Return FALSE
	if(count($requestTracker[$requestID]) == 0) {
		return FALSE;
	}


	//Pick a random item from the ones available
	$keyPicked  = array_rand($requestTracker[$requestID]);
	$idPicked   = $requestTracker[$requestID][$keyPicked];

	//Remove that item from a possible answer
	unset($requestTracker[$requestID][$keyPicked]);
	
	//Re-arrange the request tracking
	$requestTracker[$requestID] = array_values($requestTracker[$requestID]);

	return $idPicked;
}








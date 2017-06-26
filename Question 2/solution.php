<!DOCTYPE html>
<html>
<head>
<title>Fishing Trip Results</title>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<div class="col-md-offset-1 col-md-10">
<h1>Top 20 Fishing Trip Results</h1>
<table class="table">
<tr>
	<th>Types of fish caught</th><th>Times this result happened</th>
</tr>
<?php

$jsonData = json_decode(file_get_contents('https://liquid.fish/fishes.json'));
//print_r($jsonData);
$fishResults = array();
foreach ($jsonData as $fishingTrip){
	$tripFishTypes = array();
	foreach ($fishingTrip->fish_caught as $fishCaught){
		if(!in_array($fishCaught, $tripFishTypes)) $tripFishTypes[] = $fishCaught;
	}
	sort($tripFishTypes);
	$typesCount = count($tripFishTypes);
	if($typesCount <= 2) $tripResult = implode(' and ', $tripFishTypes);
	else {
		$tripFishTypes[$typesCount - 1] = 'and ' . $tripFishTypes[$typesCount - 1];
		$tripResult = implode(', ', $tripFishTypes);
	}
	if(!isset($fishResults[$tripResult])) $fishResults[$tripResult] = 0;
	$fishResults[$tripResult]++;
}
arsort($fishResults);
$resultKeys = array_keys($fishResults);
for ($i = 0; $i < 20; $i++){
	echo '<tr><td>'.ucfirst($resultKeys[$i]).'</td><td>'.$fishResults[$resultKeys[$i]].'</td></tr>';
}
?>
</table>
</div>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>

	<?php
		$key = "3551865-6e82c33b15bb737c30d00e864" ;
		$response = file_get_contents("https://pixabay.com/api/?key=" . $key . "&q=Guitarra&image_type=photo&per_page=20");
		$response = json_decode($response,true);
		$imagem = array();
		$cont = 0;
	foreach ($response["hits"] as &$value)
	{
		$cont++;
		echo "<img src =\"" . $value["webformatURL"] . "\" >";
		if ($value["imageWidth"] / $value["imageHeight"] = 1.6) {
			@copy($value["webformatURL"],"./Img" .$cont . ".jpg");
			echo "passei por aqui";
		}
		
	}
	
 ?>
</body>
</html>


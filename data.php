<?php
	include("JSON.php");
	// Future-friendly json_encode
	if( !function_exists('json_encode2') ) 
	{
		function json_encode2($data) 
		{
			$json = new Services_JSON();
			return( $json->encode($data) );
		}
	}

	// Future-friendly json_decode
	if( !function_exists('json_decode2') ) 
	{
		function json_decode2($data) 
		{
			$json = new Services_JSON();
			return( $json->decode($data) );
		}
	}	

	
	//var_dump($_POST);
	$idValue = $_POST["data"];
	$data = json_decode2($_POST["data"]);
	
	print("<p>");
	echo $idValue . "\n";// . $data.;
	print("<p>");
	foreach($data->captcha as $value)
	{
		print($value->image);
		print("<br>");
		foreach($value->data as $xy)
		{
			print("&nbsp;&nbsp;&nbsp;&nbsp;");
			print("x=" . $xy->x . ",&nbsp;y=" . $xy->y);
			print("<br>");
		}
		
		print("<p>");
	}
?>
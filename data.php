<?php
	//var_dump($_POST);
	$idValue = $_POST["data"];
	$data = json_decode($_POST["data"]);
	
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
	
	function json_decode($json)
	{
		$comment = false;
		$out = '$x=';
	 
		for ($i=0; $i<strlen($json); $i++)
		{
			if (!$comment)
			{
				if (($json[$i] == '{') || ($json[$i] == '['))       $out .= ' array(';
				else if (($json[$i] == '}') || ($json[$i] == ']'))   $out .= ')';
				else if ($json[$i] == ':')    $out .= '=>';
				else                         $out .= $json[$i];         
			}
			else $out .= $json[$i];
			if ($json[$i] == '"' && $json[($i-1)]!="\\")    $comment = !$comment;
		}
		eval($out . ';');
		return $x;
	}
?>
<!DOCTYPE HTML>
<html>

<META http-equiv="Content-Script-Type" content="text/javascript">
<script type="text/javascript" src="http://www.json.org/json2.js">
</script>

<body>
<h3>symCaptcha: security through symmetry.</h3>
Click on the center of each pictured symmetrical object:
	<p>

	<?php
	// Grab list of images in imgs directory, show two at random
	// TODO: Change to one known image, one unknown image
	$imgdir = 'imgs/';
	$imagelist = scandir($imgdir);
	
	$num = array_rand($imagelist);
	do 
	{
		$num2 = array_rand($imagelist);
	} while ($num2 == $num); //prevent identical images
	
	$image1 = $imgdir . $imagelist[$num];
	$image2 = $imgdir . $imagelist[$num2];
	?>
	
	
	<!-- Preload images for canvas -->
	<img height="0" width="0" src="<?php echo $image1 ?>" />
	<img height="0" width="0" src="<?php echo $image2 ?>" />

	<canvas id="canvas1" width="800" height="300" style="border:1px solid #c3c3c3;">
	Your browser does not support the canvas element.
	</canvas>

	<script type="text/javascript">
		var img1xy = new Array();
		var img2xy = new Array();
	
		function CircleOnClick(event){
			// Get mouse clicks
			var mouseX, mouseY;
			if(event.offsetX) {
				mouseX = event.offsetX;
				mouseY = event.offsetY;
			}
			else if(event.layerX) {
				mouseX = event.layerX;
				mouseY = event.layerY;
			}
			
			var canvas = document.getElementById("canvas1");
			var context = canvas.getContext("2d");
			var centerX = mouseX - 15 //canvas.width / 2;
			var centerY = mouseY - 95 //canvas.height / 2;
			var radius = 10;
			
			var xy = new Object();
			xy.y = centerY;
			
			// Write (x,y) position of click to array
			if(centerX <= 400){
				xy.x = centerX;
				img1xy.push(xy);
				//img1x.push(centerX);
				//img1y.push(centerY);
			}
			else {
				xy.x = centerX-400;
				img2xy.push(xy);
				//img2x.push(centerX-400);
				//img2y.push(centerY);
			}
			
			// Draw a red circle
			context.beginPath();
			context.arc(centerX, centerY, radius, 0, 2 * Math.PI, false);
			context.lineWidth = 5;
			context.strokeStyle = "red";
			context.stroke();
						
		}

		
		// Draw images on canvas, watch for mouse clicks
		window.onload = function(){
			var canvas=document.getElementById("canvas1");
			var ctx=canvas.getContext("2d");
			
			var img1=new Image();
			var img2=new Image();
			img1.src="<?php echo $image1 ?>";
			img2.src="<?php echo $image2 ?>";

			ctx.drawImage(img1,0,0);
			ctx.drawImage(img2,400,0);
			
			canvas.addEventListener("click", CircleOnClick, false);
		
		}
		
		
	</script>
	
	
	</p>
	<p>
	<?php
	// Display the currently shown file names. For debugging purposes.
	print("Left image:  $image1");
	print("<p>");
	print("Right image:  $image2");
	?>
	</p>
	
	<script type="text/javascript">
	// TODO: package the coordinate data, send to data.php to interact with database
		function SendData(xy1, xy2){
			//var msg1 = "Left image: (" + xy1[0].x + "," + xy1[0].y + ")";
			//var msg2 = "\nRight image: (" + xy2[0].x + "," + xy2[0].y + ")";
			//alert(msg1 + msg2);
						
			var dataToDB = 
			{	"captcha":
				[
					{ "image":"<?php echo $image1 ?>", "data": xy1 }
					,{ "image":"<?php echo $image2 ?>", "data": xy2 }
				]
			};
			var jsonStr = JSON.stringify(dataToDB);
			//alert(jsonStr);
			
			document.getElementById('xyData').setAttribute("value", jsonStr);
			document.getElementById('frmSubmit').submit();
		}
		
	</script>
	<p>
	<button type="button" onclick="SendData(img1xy,img2xy)">Submit</button>
	<button type="button" onclick="window.location.reload()">Reset</button>
	</p>
	<form id="frmSubmit" method="POST" action="data.php">
		<input id="xyData" type="hidden" name="data" value="" />
	</form>
</body>

</html>
<?php

//initialise stuff 
	$cardID = 0;
	$start_point = "";
	$latitude = 0.0;
	$longitude = 0.0;
	$main_text = "";
	$distance = 0.0;
	$time_hours= 00;
	$time_minutes = 00;
	$date = date('Y-m-d');
	$date = 0000-00-00;
	$ave_velocity = 0.0;
	$main_text = "";
	$specsID= 0;
	$boginess=0;
	$rain=0;
	$sun=0;
	$wind=0;
	$cloud=0;
	$snow=0;
	$image = Null;
		

if (isset($_POST['card'])){

	
	//connect Db
	$db = mysqli_connect('localhost', 'root', '', 'adventures');
	
	//Check connection 
	if (!$db) {
	  die("Connection failed: " . mysqli_connect_error());
	}
	// Get cardID
	$cardID = $_POST['cardID'];

	//Get post ID from card ID
	
	$postquery = "SELECT `postID` FROM `cards` WHERE `cardID` = $cardID ";
	$presult = mysqli_query($db, $postquery);
	while($row = mysqli_fetch_array($presult)) {$postID = $row['postID'];}

	
	// Get all card data from db
	$dataquery = "SELECT * FROM `posts` WHERE `postID` = $postID ";
	$dresult = mysqli_query($db, $dataquery);
	$dataArray = mysqli_fetch_all($dresult, MYSQLI_ASSOC);

	$start_point = $dataArray[0]['start_point'];
	$latitude = $dataArray[0]['latitude'];
	$longitude = $dataArray[0]['longitude'];
	$date = $dataArray[0]['date'];
	$main_text = $dataArray[0]['main_text'];
	$specsID = $dataArray[0]['specsID'];
	
	//Query for specs data
	
	$specsquery = "SELECT * FROM `specs` WHERE `specsID` = $specsID ";
	$sresult = mysqli_query($db, $specsquery);
	$specsArray = mysqli_fetch_all($sresult, MYSQLI_ASSOC);

	$distance = $specsArray[0]['distance'];
    $time_hours = $specsArray[0]['time_hours'];
	$time_minutes = $specsArray[0]['time_minutes'];
	$ave_velocity = $specsArray[0]['ave_velocity'];
	$boginess = $specsArray[0]['boginess'];
	$rain = $specsArray[0]['rain'];
	$sun = $specsArray[0]['sun'];
	$wind = $specsArray[0]['wind'];
	$cloud = $specsArray[0]['cloud'];
	$snow = $specsArray[0]['snow']; 
	
	$latitude = number_format($latitude, 6, '.','');
	$longitude = number_format($longitude, 6, '.','');
	$distance = number_format($distance, 2,'.','');
	$ave_velocity= number_format($ave_velocity,2,'.','');

		
	
	if (mysqli_query($db, $dataquery)):?>
	  
	<html>
	
	<head>
	  <title>Post</title>
	</head>


	<body>
    
    <?php include('errors.php'); ?>
    <div class ="topnav">
		<div class="header">
			<textarea readonly><?php echo "$start_point";?> </textarea>
			<textarea readonly><?php echo "$latitude";?> </textarea>
			<textarea readonly><?php echo "$longitude";?></textarea>
			<textarea readonly><?php echo "$date";?></textarea>
		</div>
	</div>
    <div class="info_box">
	    <div class="header">
		    Tell me about it...
		</div>
		<div class="input-group"> 
			<textarea name ="main_text" cols = "75" maxlength="1200" readonly><?php echo $main_text?></textarea>
	    </div>
    </div>
	<?php if ($image != Null):?>
		<div class="image_upload">
			<div class ="header">
			 Here is your uploaded picture
			</div>
			<br>
			<?php //Display uploaded image or placeholder?>
		</div>
	<?php endif;?>
    <div class="specs-container">
		<div class= "weather_container">
			<div class="header">What was the weather like?</div>
			<div>
			  <input type="checkbox" id="rain" name="weather[]" value="rain" disabled> <?php // Tick correct boxes. 1 in db means ticked?>
			  <label for="sun">Rain</label>
			</div>
			<div>
			  <input type="checkbox" id="sun" name="weather[]" value="sun" disabled>
			  <label for="sun">Sun</label>
			</div>
			<div>
			  <input type="checkbox" id="wind" name="weather[]" value="wind" disabled>
			  <label for="wind">Wind</label>
			</div>
			<div>
			  <input type="checkbox" id="cloud" name="weather[]" value="cloud" disabled>
			  <label for="cloud">Cloud</label>
			</div>
			<div>
			  <input type="checkbox" id="snow" name="weather[]" value="snow" disabled>
			  <label for="snow">Snow</label>
			</div>
	
		
		<div class = "specifications_container">
		<div class ="input-group">
			<label>Time - Hours: </label><textarea readonly><?php echo $time_hours; ?></textarea>
			<br>
			<label>Time - Minutes: </label><textarea readonly><?php echo $time_minutes;?></textarea>
			<br>
			<label>Distance: </label><textarea readonly><?php echo $distance;?></textarea>
			<br>
			<label>Average velocity over route: </label><textarea readonly> <?php echo $ave_velocity;?></textarea>
			<br>
			<label>Boginess: </label><textarea readonly><?php echo $boginess;?></textarea>
		</div>	
		</div>
	</div>
	</div>

	</body>
	</html>
	<?php else: 
	  echo "Error: " . $dataquery . "<br>" . mysqli_error($db);
	 endif;
	mysqli_close($db);
	
}

?>
<style>
    .info_box{
		width:100%;
		margin: 50px auto 0px;
		color: Black;
		
	}
	
	.header {
	    width: 85%;
	    margin: 50px auto 50px;
	    color: Black;
	    background: PowderBlue;
	    text-align: center;
	    border: 1px solid SlateBlue;
	    padding: 20px;
	}
	
	.image_upload{
		text-align: center;
		overflow: hidden;
		width; 30%:
		margin: 50px auto 0px;
	    color: Black;
		background:#e9e9e9;
	}
	
	.image_upload button(
		width: 98%;
		margin: 50px auto 0px;
	    color: Black;
		background; Green;
	)
	
	.specs-container {
	    overflow: hidden;
	    background-color: #e9e9e9;
	}
	
	.specifications_container{
		background-color;#e9e9e9;
	}
	
	.specifications-container input[type=time] {
		padding: 6px;
		margin-top: 8px;
		font-size: 17px;
		border: none;
		width: 150px; 
	}
	.specifications_container input[type=number_format] {
		padding: 6px;
		margin-top: 8px;
		font-size: 17px;
		border: 1px solid gray ;
		width: 150px; 
	}	
	.specifications_container input[type=integer] {
		padding: 6px;
		margin-top: 8px;
		font-size: 17px;
		border: 1px solid gray ;
		width: 150px; 
	}	
	.weather_container{
		text-align: center;
		overflow: hidden;
	    background-color: #e9e9e9;
	}
	
	.weather-boxes{
		padding:2px;
		background-color; #e9e9e9;
	}
	
	/* Add responsiveness - On small screens, display the navbar vertically instead of horizontally */
	@media screen and (max-width: 600px) {
	  .specs-container {
		float: none;
	  }
	  .specs-container a, .specs-container input[type=text], .specs-container button {
		float: none;
		display: block;
		text-align: left;
		width: 100%;
		margin: 0;
		padding: 14px;
	  }
	  .specs-container input[type=text] {
		border: 1px solid #ccc;
	  }
	  
	  
	}
	
	form, .content {
	    width: 85%;
	    margin: 0px auto;
	    padding: 10px;
	    border: 1px solid SlateBlue;
	    background: white;
	    border-radius: 10px 10px 10px 10px;
	}
	.input-group {
	    margin: 10px 0px 10px 0px;
	}
	.input-group input {
	    height: 30px;
	    width: 70%;
	    padding: 5px 10px;
	    font-size: 16px;
	    border-radius: 5px;
	    border: 1px solid gray;
		

	textarea {
		display: block;
		margin-left: auto;
		margin-right: auto;
	}
</style>

<html>
<head>
  <title>Post</title>
</head>


<body>
    <form name="postformB" method="post" action="postserver.php" enctype="multipart/form-data">
    <?php include('errors.php'); ?>
    <div class ="topnav">
		<div class="header">
			<input type="text" name="start_point" placeholder="Start point name" >
			<input type="number_format" name="latitude" placeholder="Latitude DD.DDDDDD">
			<input type="number_format" name="longitude" placeholder="Longitude DD.DDDDDD">
			<input type="date" name="date">
		</div>
	</div>
    <div class="info_box">
	    <div class="header">
		    Tell me about it...
		</div>
		<div class= "weather_container" style="background-color:white;"> 
			<textarea name ="main_text" cols = "70" maxlength="1200">...</textarea>
	    </div>
    </div>
    <div class="image_upload">
		<div class ="header">
			Upload image
		</div>
		<br>
		<input type="file" name="image">
	</div>
    <div class="specs-container">
		<div class= "weather_container">
			<div class="header">What was the weather like?</div>
			<div>
			  <input type="checkbox" id="rain" name="weather[]" value="rain">
			  <label for="sun">Rain</label>
			</div>
			<div>
			  <input type="checkbox" id="sun" name="weather[]" value="sun">
			  <label for="sun">Sun</label>
			</div>
			<div>
			  <input type="checkbox" id="wind" name="weather[]" value="wind">
			  <label for="wind">Wind</label>
			</div>
			<div>
			  <input type="checkbox" id="cloud" name="weather[]" value="cloud">
			  <label for="cloud">Cloud</label>
			</div>
			<div>
			  <input type="checkbox" id="snow" name="weather[]" value="snow">
			  <label for="snow">Snow</label>
			</div>
	
		
		<div class = "specifications_container">
		<div class ="input-group">
			<label>Time - Hours: </label><input type="number_format" name="hours_taken" placeholder= "00">
			<br>
			<label>Time - Minutes: </label><input type= "number_format" name="minutes_taken" placeholder="00">
			<br>
			<label>Distance: </label><input type="number_format" id ='distance' name="distance" placeholder="00.00km">
			<br>
			<label>Boginess: </label><input type="integer" id = 'boginess' name = "boginess" placeholder=0>
		</div>	
		</div>
	</div>
	</div>
	<button type="submit" class="btn" name="submit">Submit</button>


  </form>
</body>
</html>

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
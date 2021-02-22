<?php
include('server.php');
include('map_point.php');
?>


<html>
<title>The Adventures of You</title>
<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link rel="stylesheet" href="style2.css">
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css' rel='stylesheet' />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<div class="topnav">
		<div class="login-container"> 
		
		<?php  if (isset($_SESSION['username'])) : ?>
			<a href= "second attempt at a homepage.php" style="float:left">Welcome <?php echo $_SESSION['username']; ?> </a>
			<a href="post_form_redo.php" type="new_post"  >Record a new memory</a>
			<a href="index.php?logout='1'" style="color: SlateBlue;">Log out</a>			
		<?php endif; ?>
		</div>
	</div>



	
<div class="header">
  <h2>The Adventures of You</h2>
</div>
<br>
<div class="row">
  <div class="leftcolumn">
  	
	
    <div class="card" style='width: 100%;height:650px; '>
      <h2> Past adventures </h2>
		<div class="card" style='width: 100%; height: 90%; padding:0;'>
	  <div id='map' style='width: 100%; height: 100%;padding-top:0;'></div>
		  
		<script>

		// from each feature, get element and assign data vars properly
		mapboxgl.accessToken = 'pk.eyJ1IjoibWFkZHkwMiIsImEiOiJjazltNW0xcTYwMWJiM2ZwOWcwOHJtMjNzIn0.z2kfgTAxa9FSa4lmZSce4w';

		var map = new mapboxgl.Map({
		  container: 'map',
		  style: 'mapbox://styles/mapbox/outdoors-v11',
		  center: [-4.5914, 54.3509],
		  zoom: 4
		});
		
		map.on('load',function(){
		// get geojson file
		var geojson = <?php echo json_encode($geojson, JSON_NUMERIC_CHECK);?>;
		
		for(var i=0; i < geojson.features.length; i++){
		  // make a marker for each feature and add to the map
		  new mapboxgl.Marker()
		  .setLngLat(geojson.features[i].geometry.coordinates)
		  .setPopup(new mapboxgl.Popup({ closeButton: false, offset: 25 }) // add popups
			.setHTML('<p>' + geojson.features[i].properties.title + '</p>'))
		  .addTo(map);
		};
		map.resize();
		});
		
		</script>

	</div>
	</div>
	<br>

	
  </div>
    <div class="rightcolumn">
		<div class="card">
		  <h2>Write Ups</h2>
			<div class="preview">
				<div class="row row-cols-3 row-cols-md-2">
				
				<?php
				include ('server.php');
				$cardsSelect = "SELECT * FROM `cards` WHERE `accountID`= (SELECT `accountID` FROM `accounts` WHERE `username`= '".$_SESSION['username']."') ";
				$result = mysqli_query($db, $cardsSelect);
				$cardsArray = mysqli_fetch_all($result, MYSQLI_ASSOC);?>

				<?php for($i = 0; $i<count($cardsArray);$i++):?>
					<div class="card" style="width:100%;">
					  <div class="card-header">
						<?php echo $cardsArray[$i]['date']; ?>
					  </div>
					  <div class="card-body">
						<h5 class="card-title">Start: <?php echo $cardsArray[$i]['start'];?></h5>
						<p class="card-text">  <?php echo $cardsArray[$i]['textPreview'];?></p>
						<?php $cardID = $cardsArray[$i]['cardID'];?>
						<form name="cardform" method="post" action="oldpostserver.php" enctype="multipart/form-data">
							<input type="hidden" name = "cardID" value = <?php echo "$cardID"; ?> >
							<button type="submit" class="btn btn-primary" name="card">See full</button>
						</form>
					
					  </div>
					</div>

				<?php endfor; ?> 
					
					
					<div class="card">
					  <div class="card-header">
						Date
					  </div>
					  <div class="card-body">
						<h5 class="card-title">Route Start Point</h5>
						<p class="card-text">Write up text that has been written for a write up by a person that writes things up.</p>
						<a href="4" class="btn btn-primary">See full</a>
					  </div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	<div class = "rightcolumn">
		<div class = "card">
		<h2>Some of your pictures</h2>
		
		<div class = "images">
			<?php
			// Get an array of all image IDs
			$imageIDSelect = "SELECT `imageID`,`latitude`,`longitude` FROM `posts` WHERE `accountID`= (SELECT `accountID` FROM `accounts` WHERE `username`= '".$_SESSION['username']."') ";
			$result = mysqli_query($db, $imageIDSelect);
			$result = mysqli_fetch_all($result,MYSQLI_ASSOC);

			// Currently all images are default holders
			for($i=0;$i<count($result);$i++):
				$imageID= $result[$i]['imageID'];
				//print $imageID;
				$imageLat = $result[$i]['latitude'];
				$imageLong = $result[$i]['longitude'];
				$imageDataSelect = "SELECT imageData FROM images WHERE imageID = $imageID";
				$images = mysqli_query($db, $imageDataSelect);
				$images = mysqli_fetch_all($images, MYSQLI_ASSOC);
				?>
				<div class = "card">
				<div class = "image-container">
					<div class = "card-header">
					<?php echo "Latitude:  ".$imageLat."   Longitude:  ".$imageLong;?>
					</div>
					<br><div class="card-body">
					<img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($images[$i]['imageData']); ?>" width= 100%  class="center">
					<br></div>
				</div>
				</div>
			<?php endfor;?>
		</div>
		
		</div>
	</div>
</html>



<?php
include ('server.php');

function IsChecked($chkname,$value)
    {
        if(!empty($_POST[$chkname]))
        {
            foreach($_POST[$chkname] as $chkval)
            {
                if($chkval == $value)
                {
                    return true;
                }
            }
        }
        return false;
    }
$username = $_SESSION['username'];

// initialising variables
$accountID=0;

//post main stuff 
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
$start = "";
$textPreview = "";


// post check boxes
$rain = 0;
$sun = 0;
$wind = 0;
$cloud = 0;
$snow = 0;
$boginess = 0;
//format variables for database input


$ave_velocity= number_format($ave_velocity,2,'.','');

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'adventures');


if (isset($_POST['submit'])) {
		
	
	// receive all input values from the form
	$start_point = mysqli_real_escape_string($db, $_POST['start_point']);
	$latitude = mysqli_real_escape_string($db, $_POST['latitude']);
	$longitude = mysqli_real_escape_string($db, $_POST['longitude']);
	$main_text = mysqli_real_escape_string($db, $_POST['main_text']);
	$time_hours = mysqli_real_escape_string($db,$_POST['hours_taken']);
	$time_minutes = mysqli_real_escape_string($db,$_POST['minutes_taken']);
	$distance = mysqli_real_escape_string($db,$_POST['distance']);
	$boginess = mysqli_real_escape_string($db, $_POST['boginess']);
	$date =  mysqli_real_escape_string($db, $_POST['date']);
	$rain = IsChecked('weather','rain') ? 1 : 0;
	$sun = IsChecked('weather','sun') ? 1 : 0;
	$wind = IsChecked('weather','wind') ? 1 : 0;
	$cloud = IsChecked('weather','cloud') ? 1 : 0;
	$snow = IsChecked('weather','snow') ? 1 : 0;
	
	
	// Validate all input boxes
	
	

	if (empty($start_point)) { array_push($errors, "Start point is required"); }
	if (strlen($start_point)>32) {$start_point = mb_substr($start_point,0,32);}
	if (empty($latitude)) { array_push($errors, "Latitude is required"); }
	$latitude = number_format($latitude, 6, '.','');
	if (empty($longitude)) { array_push($errors, "Longitude is required"); }
	$longitude = number_format($longitude, 6, '.','');
	if (empty($date)) { array_push($errors, "Date is required"); }
	if (empty($main_text)) { array_push($errors, "Main report is required"); }
	if (strlen($main_text)>1200) {$start_point = mb_substr($start_point,0,1200);}
	if (empty($distance)) { array_push($errors, "Distance duration is required"); }
	$distance = number_format($distance,2,'.','');
	if (empty($time_hours)) { array_push($errors, "Time duration is required"); }	
	$time_hours = floor($time_hours);
	if (empty($time_minutes)) { array_push($errors, "Time duration is required"); }		
	$time_minutes = floor($time_minutes);
	if (empty($boginess)){array_push($errors, "A value for boginess is required");}
	$boginess = floor($boginess);
	

	

	// Check connection
	if (!$db) {
	  die("Connection failed: " . mysqli_connect_error());
	}
	
	// get accountID
	$accountquery = "SELECT `accountID` FROM `accounts` WHERE `username`='$username'";
	$aresult = mysqli_query($db,$accountquery);
	while($row = mysqli_fetch_array($aresult)) {$accountID =  $row['accountID']; }

	
	
	
	// image upload
	if (count($_FILES) > 0) {
		if (is_uploaded_file($_FILES['image']['tmp_name'])) {
			//require_once "db.php";
			$imgData = addslashes(file_get_contents($_FILES['image']['tmp_name']));
			$imageProperties = getimageSize($_FILES['image']['tmp_name']);
			$sql = "INSERT INTO images(imageType ,imageData, uploaded)
			VALUES('{$imageProperties['mime']}', '{$imgData}',NOW())";
			$current_id = mysqli_query($db, $sql) or die("<b>Error:</b> Problem on Image Insert<br/>" . mysqli_error($db));
		}
	}
	if(empty($_FILES["image"]["tmp_name"])) {
		$imageProperties= NULL;
		$imgData = NULL;
		$sql = "INSERT INTO images(imageType ,imageData, uploaded) VALUES ('$imageProperties', '$imgData',NOW())";
		$current_id = mysqli_query($db, $sql) or die("<b>Error:</b> Problem on Image Insert<br/>" . mysqli_error($db));	
	}
	
	// get image ID 
	$imageID = mysqli_insert_id($db);
	
	
	// Calculation of ave velocity.
	$time_minutes = round($time_minutes/60,3);
	$time=($time_hours)+($time_minutes);
	$ave_velocity=$time/$distance;
	$ave_velocity = round($ave_velocity,2);
	
	
	// format data correctly //
	//distance expects 5 digits to 2 dp 
	$distance = number_format($distance, 2,'.','');
	
	//time_hours expects an integer
	$time_hours = floor($time_hours);
	
	//time_minutes expects 5 digits to 3dp
	$time_minutes = number_format($time_minutes,3,'.','');
	
	//ave_velocity expects 4 digits to 2dp
	$ave_velocity= number_format($ave_velocity,2,'.','');
	
	// Specifications upload
	$specs_query = "INSERT INTO specs(distance,time_hours,time_minutes,ave_velocity,rain,sun,wind,cloud,snow,boginess) 
	VALUES($distance,$time_hours,$time_minutes,$ave_velocity,$rain,$sun,$wind,$snow,$cloud,$boginess)";
	
	
	$results = mysqli_query($db, $specs_query);
	$specsID = mysqli_insert_id($db);


	
	
	$posts_query = "INSERT INTO `posts` (accountID,start_point,latitude,longitude,main_text,imageID,specsID,date)
	VALUES($accountID,'$start_point',$latitude,$longitude,'$main_text',$imageID,$specsID,$date)"; 
	$presults = mysqli_query($db, $posts_query);

	$postID = mysqli_insert_id($db);
	
	//need to determine if texts are long enough for card querying 
	$endsp = 0;
	$endtp = 0;
	$endsp =  (strlen($start_point)< 32 ? 31 : strlen($start_point)-1);
	$endtp =  (strlen($main_text)< 255 ? 254 : strlen($main_text)-1);


	$start = substr($start_point,0,$endsp);
	$textPreview = substr($main_text,0,$endtp);
	
	
	$cards_query = "INSERT INTO cards(postID,accountID,imageID,start,date,textPreview)
	VALUES($postID,$accountID,$imageID,'$start',$date,'$textPreview')";


	
	
	
	if (mysqli_query($db, $cards_query)) {
	  header('Location: second attempt at a homepage.php');
	} else {
	  echo "Error: " . $cards_query . "<br>" . mysqli_error($db);
	}
	

	
	mysqli_close($db);

 

}
?>


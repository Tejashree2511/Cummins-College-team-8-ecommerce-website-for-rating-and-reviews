

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecomerce";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

if(isset($_POST['update'])){



// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$rating_value = $_POST['rating_value'];
$userName = $_POST['userName'];
$userMessage = $_POST['userMessage'];
$now = time();
// $review_id=$POST['review_id'];

$sql="UPDATE `rating` SET `name`='".$userName"',`rating`='".$userMessage"',`message`='".$userMessage"',`datetime`='".$userMessage"' WHERE 'review_id'=$review_id";




// $sql = "INSERT INTO rating (name, rating, message, datetime)
// VALUES ('$userName', '$rating_value', '$userMessage', '$now')";

// $sql= "update rating set rating=$rating_value, message=$userMessage,datetime=$now where review_id=$id";



if (mysqli_query($conn, $sql)) {
  echo " Review updated Successfully";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);

}



if(isset($_POST['action'])){
  $avgRatings = 0;
  $avgUserRatings = 0;
  $totalReviews = 0;
  $totalRatings5 = 0;
  $totalRatings4 = 0;
  $totalRatings3 = 0;
  $totalRatings2 = 0;
  $totalRatings1 = 0;
  $ratingsList = array();
  $totalRatings_avg = 0;



  $sql = "SELECT * FROM rating ORDER BY review_id DESC";
  $result = mysqli_query($conn, $sql);

  while($row = mysqli_fetch_assoc($result)) {
    $ratingsList[] = array(
      'review_id' => $row['review_id'],
      'name' => $row['name'],
      'rating' => $row['rating'],
      'message' => $row['message'],
      'datetime' => date('l jS \of F Y h:i:s A',$row['datetime'])
    );
    if($row['rating'] == '5'){
      $totalRatings5++;
    }
    if($row['rating'] == '4'){
      $totalRatings4++;
    }
    if($row['rating'] == '3'){
      $totalRatings3++;
    }
    if($row['rating'] == '2'){
      $totalRatings2++;
    }
    if($row['rating'] == '1'){
      $totalRatings1++;
    }
    $totalReviews++;
    $totalRatings_avg = $totalRatings_avg + intval($row['rating']);
  }
  $avgUserRatings = $totalRatings_avg / $totalReviews;

  $output = array(
    'avgUserRatings' => number_format($avgUserRatings, 1),
    'totalReviews' => $totalReviews,
    'totalRatings5' => $totalRatings5,
    'totalRatings4' => $totalRatings4,
    'totalRatings3' => $totalRatings3,
    'totalRatings2' => $totalRatings2,
    'totalRatings1' => $totalRatings1,
    'ratingsList' => $ratingsList
  );

  echo json_encode($output);






}



?>

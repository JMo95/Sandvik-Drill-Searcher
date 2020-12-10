<?php
$host = "localhost"; 
$user = "*******"; 
$password = "*******"; 
$dbname = "drills"; 
$id = '';

$con = mysqli_connect($host, $user, $password,$dbname);

$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));


if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}


switch ($method) {
    case 'GET':
      $id = $_GET['id'];
      $sql = "select * from Drill_Table".($id?" where drill_id=$id":''); 
      break;
    case 'POST':
      //First we want to write the start of the sql request.
      if($_POST[0] == 0)
      {
      $sql = "insert into Drill_Table (";
      //Now we need to add all of the lables. $_Post[0] equals how many labels there are.
      $Parser = 2;
      while ($Parser < $_POST[1] + 2)
      {
          $sql = $sql."`$_POST[$Parser]`, ";
          $Parser = $Parser + 1;
      }
      //At the end of that our $sql string should be
      // "insert into Drill_Table(Label_one, Label_two, Label_three, " with that extra space and comma.
      //We'll remove the space and comma using substr.
      $sql = substr($sql, 0, -2);
      //Note to self, if this doens't work replace with two substr(-1)s.
      //Now we add the closing parenthenses and all of the data up to the values.
      $sql = $sql.") values ('0',";
      //Conveniently, the values map directly from the lables, so we just need to skip the first label
      //of drill_id since we always set that to zero and parse frmo there.
      $Parser = 3;
      while ($Parser < $_POST[1] + 2)
      {
          $CurrentLabel = preg_replace("/\s+/", "",$_POST[$Parser]);
          $sql = $sql." '$_POST[$CurrentLabel]',";
          $Parser = $Parser + 1;
      }
      //At the end of this we will have one extra comma that we need to remove, then we just need to add a
      //parenthense to close it out and we're done with the sql string.
      $sql = substr($sql, 0, -1);
      $sql = $sql.")";
      print($_POST[preg_replace("/\s+/", "",$_POST[$Parser])]);
      //$sql = "DROP TABLE LUL";
      }
      else if ($_POST[0] == 1)
      {
          //This ain't no post request at all! It adds a column! Jebaited.
          //In reality: I tried to make a custod method in axios and it wouldn't let me so I'm instead overloading
          //the Post method to accomodate for all additions I desire.
          $sql = "ALTER TABLE Drill_Table ADD COLUMN `$_POST[1]` VARCHAR(45)";
      }
      else if ($_POST[0] == 2)
      {
          //Used to drop columns from Drill_Table.
          $sql = "ALTER TABLE Drill_Table DROP `$_POST[1]`";
      }
      else if ($_POST[0] == 3)
      {
          //Used to drop elements from Drill_Table.
          //NOTE: auto-increment is not reset when deleting, this may cause a problem in the future though that number current is BIGINT in the 
          //database thus it can increment to 18,466,744,073,709,551,615 records so if you store and remove the records that many times you will
          //eventualy overload the auto_increment. Not quite sure what will happen but I also think that even in the entire existence of this
          //company you won't have to remove and add that many drill elements. For reference if one element was added by one person every single
          //second it would still take 585576613195 years to add enough elements to overload auto_increment.
          $sql = "DELETE FROM Drill_Table WHERE drill_id = $_POST[1]";
      }
      else if ($_POST[0] == 4)
      {
          //Used to add new tables (called only when other functions are called) for when you add a new column so that you can modify how that
          //column will have its search parameters inputted.
          $sql = "CREATE TABLE `$_POST[1]` (Dex INT PRIMARY KEY AUTO_INCREMENT)";
      }
      else if ($_POST[0] == 5)
      {
          //Used to drop tables when you drop their respective column.
          $sql = "DROP TABLE `$_POST[1]`";
      }
      else if ($_POST[0] == 6)
      {
          //Used to add an auto-increment element to each of the new tables for accessing each index later on in the search system, called before $_POST[0] being 6.
          $sql = "ALTER TABLE `$_POST[1]` ADD COLUMN Input_Type VARCHAR(45) AFTER Dex";
      }
      else if ($_POST[0] == 7)
      {
          print($_POST[1]);
          //Used to add the number 0 to our new table created from $_POST[0] being 4 (so when we insert a
          //column) so that the input defaults to text.
          $sql = "INSERT INTO `$_POST[1]` (Input_Type) VALUE(0)";
      }
      break;
}

// run SQL statement
$result = mysqli_query($con,$sql);

// die if SQL statement failed
if (!$result) {
  http_response_code(404);
  die(mysqli_error($con));
}

if ($method == 'GET') {
    if (!$id) echo '[';
    for ($i=0 ; $i<mysqli_num_rows($result) ; $i++) {
      echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
    }
    if (!$id) echo ']';
  } elseif ($method == 'POST') {
    echo json_encode($result);
  } else {
    echo mysqli_affected_rows($con);
  }

$con->close();
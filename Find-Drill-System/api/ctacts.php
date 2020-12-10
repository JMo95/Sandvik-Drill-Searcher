<?php
$host = "localhost"; 
$user = "******"; 
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
      $sql = "select * from login_table".($id?" where dex=$id":'');
      break;
    case 'POST':
      //If $_POST[0] == 0 we're creating a new account.
      $sql = "select * from login_table";
      if($_POST[0] == 0)
      {
          $sql = "insert into login_table (username, password) values ('$_POST[1]', '$_POST[2]')";
      }
      //If $_POST[0] == 1 then we're deleting the account we just "made" when testing login.
      if($_POST[0] == 1)
      {
          $sql = "delete from login_table where username='$_POST[1]' and password='$_POST[2]'";
      }
      break;
}

// run SQL statement
$result = mysqli_query($con,$sql);

function toNumber($input)
{
    if ($input)
        return ord(strtolower($input)) - 96;
    else
        return 0;
}

function Encrypt($StringtoEncrypt)
{
    $list=array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j');
    $listtwo = array('k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't');
    $listthree = array('u', 'v', 'w', 'x', 'y', 'z');
    $Parser = 0;
    $CompleteString = "";
    while ($Parser < strlen($StringtoEncrypt))
    {
        $NewString = "";
        //First get the current letter.
        $CurrentLetter = $StringtoEncrypt[$Parser];
        //Check if it's a letter:
        if (ctype_alpha($CurrentLetter))
        {
            //Convert it to lower case, then convert it to a number 1-27.
            $NumVal = toNumber($CurrentLetter);
            //Multiply the numerical value by 12.
            $NumVal = $NumVal * 12;
            $NewString = strval($NumVal);
            //If it was uppercase, then add the letter u to indicate that.             ";
            if(ctype_upper($CurrentLetter))
            { 
                $NewString = 'u' . $NewString; 
            }
            //Add a number to indicate the length of the letter (so how much we have to read to decrypt it) to the front.
            $NewString = strval(strlen($NewString)) . $NewString;
        }
        //Otherwise check if it's a number.
        else if (ctype_digit($CurrentLetter))
        {
            //As we're only taking numbers 0-9 since it's one digit, just take it to its ascii equivalent and then add an n to indicate it was a letter.
            $WhichList = rand(0, 2);
            $LetVal = 'G';
            if($WhichList == 0)
            { $LetVal = $list[$CurrentLetter]; }
            else if($WhichList == 1)
            { $LetVal = $listtwo[$CurrentLetter]; }
            else if($WhichList == 2)
            { $LetVal = $listthree[$CurrentLetter]; }
            $LetVal = $list[$CurrentLetter];
            $NewString = 'n' . $LetVal;
            $NewString = strval(strlen($NewString)) . $NewString;
        }
        //Otherwise call it a special character and don't convert it.
        else
        {
            $NewString = 's' . $CurrentLetter;
            $NewString = strval(strlen($NewString)) . $NewString;
        }
        $CompleteString = $CompleteString . $NewString;
        $Parser += 1;
        
    }
    return $CompleteString;
}

// die if SQL statement failed
if (!$result) {
  http_response_code(404);
  die(mysqli_error($con));
}

if (($method == 'GET') && ($_GET['inputone'] == 'ax5')&&($_GET['inputtwo'] == 'by715')) {
    if (!$id) echo '[';
    $Inp = "";
    for ($i=0 ; $i<mysqli_num_rows($result) ; $i++) {
      $Current = json_decode(json_encode(mysqli_fetch_object($result)), true);
      $user = $Current['username'];
      $pass = $Current['password'];
      $userE = Encrypt($user);
      $passE = Encrypt($pass);
      $Inp = $Inp . $userE;
      $Inp = $Inp . ',';
      $Inp = $Inp . $passE;
      $Inp = $Inp .',';
    }
    $Inp = substr($Inp, 0, -1);
    echo $Inp;
    if (!$id) echo ']';
    echo " ";
  } elseif ($method == 'POST') {
    echo json_encode($result);
  } else {
    echo mysqli_affected_rows($con);
  }

$con->close();
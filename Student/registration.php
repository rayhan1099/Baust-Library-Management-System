<?php
  include "connection.php";
  include "navbar.php";
?>
<!DOCTYPE html>
<html>
<head>

  <title>Student Registration</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 

  <style type="text/css">
    section
    {
      margin-top: -20px;
    }
  </style> 
</head>
<body>
    <?php
      $error=0;
    $firstErr = $lastErr = $contactErr = $emailErr = $password =NULL;
    $first = $last = $contact = $email =$passwordErr = NULL;
    $flag = true;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["first"])) {
            $firstErr = "Name is required";
            $error++;
        } else {
            $first = test_input($_POST["first"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/", $first)) {
                $firstErr = "Only letters and white space allowed";
                $error++;
            }
        }
        if (empty($_POST["last"])) {
            $lastErr = "Name is required";
            $error++;
        } else {
            $last = test_input($_POST["last"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/", $last)) {
                $lastErr = "Only letters and white space allowed";
                $error++;
            }
        }
        if (empty($_POST["contact"])) {
            $contactErr = "contact is required";
            $error++;
            $flag = false;
        } else {
            $contact = test_input($_POST["contact"]);
            if (!preg_match('/^[0-9]{11}+$/', $contact)) {
                $contactErr = "Enter 11 digit number";
                $error++;
            }
        }
        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
            $error++;
        } else {
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
                $error++;
            }
        }
        if (!empty($_POST["password"]) && ($_POST["password"])) {
            $password = test_input($_POST["password"]);
        
            if (strlen($_POST["password"]) <= '6') {
                $passwordErr = "Your Password Must Contain At Least 6 Characters!";
                $error++;
            } elseif (!preg_match("#[0-9]+#", $password)) {
                $passwordErr = "Your Password Must Contain At Least 1 Number!";
                $error++;
            } elseif (!preg_match("#[A-Z]+#", $password)) {
                $passwordErr = "Your Password Must Contain At Least 1 Capital Letter!";
                $error++;
            } elseif (!preg_match("#[a-z]+#", $password)) {
                $passwordErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
                $error++;
            }
        } else {
            $passwordErr = "Please enter password   ";
            $error++;
        }
    
    }
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>
  
   
<section>
  <div class="reg_img">

    <div class="box2">
        <h1 style="text-align: center; font-size: 35px;font-family: Lucida Console;"> &nbsp Library Management System</h1>
        <h1 style="text-align: center; font-size: 25px;">User Registration Form</h1>

        <form action=" <?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        
        <div class="login">
                    <input type="text" name="first" class="form-control" placeholder="Enter_First_Name" required="<?= $first; ?>">
                    <span class="error"> <?= $firstErr; ?></span></br>
                   <input type="text" name="last" class="form-control" placeholder="Enter__Last_Name" required="<?= $last; ?>">
                    <span class="error"> <?= $lastErr; ?></span></br>
                   <input type="text" autocomplete="off" name="email" class="form-control" placeholder="Enter_Valid_Email" required="<?= $email; ?>">
                    <span class="error"> <?= $emailErr; ?></span></br>
                   <input type="text" name="username" class="form-control" placeholder="Enter_User_Name" required="">
                    </br>
                    <input type="text" name="roll" class="form-control" placeholder="Enter_Roll_No" required="">
                    </br>
                   <input type="text" name="contact" class="form-control" placeholder="Enter_Contact_Number" required="<?= $contact; ?>">
                    <span class="error"> <?= $contactErr; ?></span></br>
                  <input type="password" name="password" class="form-control" placeholder="Enter_Password" required="<?= $password; ?>">
                    <span class="error"> <?= $passwordErr; ?></span></br>
        
                <input class="btn btn-default" type="submit" name="submit" value="Sign Up" style="color: black; width: 70px; height: 30px">

               
            </div>
            </div>
            </div>
    </form>
    
    <?php

if(isset($_POST['submit']))
{
  $count = 0;
  $sql="SELECT username from `student`";
  $res=mysqli_query($db,$sql);

  while($row=mysqli_fetch_assoc($res))
  {
    if($row['username']==$_POST['username'])
    {
      $count=$count+1;
    }
  }
  if($count==0 and $error == 0)
  {
    mysqli_query($db,"INSERT INTO `STUDENT` VALUES('$_POST[first]', '$_POST[last]', '$_POST[username]', '$_POST[password]', '$_POST[roll]', '$_POST[email]', '$_POST[contact]', 'p.jpg');");
  ?>
     <script type="text/javascript">
                window.location="../login.php"
              </script>
  <?php
  }
  if($count!=0)
  {

    ?>
      <script type="text/javascript">
        alert("The username already exist.");
      </script>
    <?php

  }

}

?>

</body>
</html>
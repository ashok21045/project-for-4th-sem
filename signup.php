
<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
include 'partials/_test.php';

$username = $_POST["username"];
$password =  $_POST["password"];
$cpassword   =  $_POST["cpassword"];
$exist = false;
// if (($password==$cpassword) && $exist==false) {
    $sql = "INSERT INTO `user` (`username`, `password`, `cpassword`) VALUES ('$username', '$password', '$cpassword')";
    $result= mysqli_query($conn, $sql);
    if($result){
        echo "donee!";

    }
    else{
        echo "not injected";
    }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BrainSpark | SignUp</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Poppins", sans-serif;
            background-color: #0f172a;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .signup-container {
            background: #1e293b;
            padding: 30px;
            border-radius: 12px;
            width: 320px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.4);
        }

        .brand {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .logo {
            height: 60px;
            width: 60px;
            margin-right: 10px;
        }

        .logo-title {
            font-size: 2rem;
            color: #38bdf8;
        }

        .signup-container h2 {
            margin: 10px 0;
            color: #38bdf8;
        }

        .signup-form {
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        .signup-form label {
            font-size: 0.9rem;
            margin-bottom: 5px;
            color: #c5c5c5;
        }

        .signup-form input {
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 6px;
            outline: none;
        }

        .signup-form input:focus {
            border: 2px solid #38bdf8;
        }

        .signup-btn {
            background-color: #38bdf8;
            color: white;
            border: none;
            padding: 12px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 7px;
            cursor: pointer;
            transition: 0.2s;
        }

        .signup-btn:hover {
            background-color: #0ea5e9;
        }

       


        /* bootstrap css */
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

       
    </style>
</head>

<body>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Holy guacamole!</strong> You should check in on some of those fields below.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
    <div class="signup-container">
        <div class="brand">
            <img src="logo.png" alt="BrainSpark Logo" class="logo">
            <h2 class="logo-title">BrainSpark</h2>
        </div>

        <form class="signup-form" action= "signup.php" method= "POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter password" required>
            <label for="cpassword">Conform Password</label>
            <input type="password" id="cpassword" name="cpassword" placeholder="Re-Enter password" required>

            <button type="submit" class="signup-btn">Sign Up</button>
        </form>

        
    </div>


      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
 
</body>

</html>
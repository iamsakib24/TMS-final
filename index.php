<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['login'])) 
{
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "SELECT ID FROM tbladmin WHERE UserName=:username and Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();

    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if($query->rowCount() > 0)
    {
        foreach ($results as $result) {
            $_SESSION['trmsaid'] = $result->ID;
        }
        $_SESSION['login'] = $_POST['username'];
        echo "<script>document.location ='dashboard.php';</script>";
    }
    else {
        echo "<script>alert('Invalid Details');</script>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
<title>Login Page</title>

<link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">

<style>
body{
    height:100vh;
    margin:0;
    display:flex;
    align-items:center;
    justify-content:center;
    background:url('images/M.png');
    background-size:cover;
}

/* MAIN WRAPPER */
.login-wrapper{
    width:900px;
    display:flex;
    gap:25px;   /* 👈 LEFT RIGHT GAP */
}

/* LEFT BOX */
.left-box{
    width:50%;
    background:rgba(0,0,0,0.65);
    color:white;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    padding:40px;
    border-radius:12px;
    text-align:center;
}

/* RIGHT BOX */
.right-box{
    width:50%;
    background:white;
    padding:40px;
    border-radius:12px;
    box-shadow:0 0 15px rgba(0,0,0,0.2);
}
</style>

</head>

<body>


<div class="login-wrapper">




   <div class="left-box">
    <h3 class="text-center">Teacher Login</h3>
    <hr>
    
    <a href="login.php" class="btn btn-success btn-block" style="padding: 12px; font-size: 16px;">
        Login here
    </a>

    <br>

    <a href="register.php" class="btn btn-primary btn-block" style="padding: 12px; font-size: 16px;">
        Register here
    </a>
</div>

  


    <div class="right-box">
        <h3 class="text-center">Admin Login</h3>
        <hr>

        <form method="post">

            <div class="form-group">
                <label>User Name</label>
                <input type="text" class="form-control" name="username" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <div class="form-group d-flex justify-content-between">
                
                <a href="forgot-password.php">Forgot Password?</a>
            </div>

            <button type="submit" class="btn btn-success btn-block" name="login">
                Sign In
            </button>

        </form>
    </div>

</div>

</body>
</html>

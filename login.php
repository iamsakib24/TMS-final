<?php
session_start();
include('includes/dbconnection.php');

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    // আপনার ডাটাবেজ কলাম অনুযায়ী Email এর E বড় হাতের এবং password ছোট হাতের
    $sql = "SELECT * FROM tblteacher WHERE Email=:email AND password=:password LIMIT 1";
    $query = $dbh->prepare($sql);

    $query->bindParam(':email',$email);
    $query->bindParam(':password',$password);

    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    if($result)
    {
        // ডাটাবেজের কলামের নাম অনুযায়ী ID (বড় হাতের) ব্যবহার করুন
        $_SESSION['trmsaid'] = $result->ID;
        $_SESSION['email'] = $result->Email;

        session_regenerate_id(true);

        header("Location: teacher-dashboard.php");
        exit();
    }
    else {
        echo "<script>alert('Invalid login');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Teacher Login</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:linear-gradient(135deg,#667eea,#764ba2);
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
}

.login-box{
    width:380px;
    background:white;
    padding:30px;
    border-radius:12px;
    box-shadow:0 0 25px rgba(0,0,0,0.3);
}

h2{
    text-align:center;
    margin-bottom:20px;
    color:#333;
}

input{
    width:100%;
    padding:10px;
    margin:10px 0;
    border:1px solid #ccc;
    border-radius:8px;
    outline:none;
}

button{
    width:100%;
    padding:10px;
    background:#4e54c8;
    color:white;
    border:none;
    border-radius:8px;
    font-size:16px;
    cursor:pointer;
}

button:hover{
    background:#3b40a4;
}

a{
    display:block;
    text-align:center;
    margin-top:10px;
    text-decoration:none;
    color:#4e54c8;
}
</style>

</head>
<body>

<div class="login-box">
    <h2>Teacher Login</h2>
    <form method="post">
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <button type="submit" name="login">Login</button>
    </form>
    <a href="register.php">Create New Account</a>
</div>

</body>
</html>
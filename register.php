<?php
session_start();
include('includes/dbconnection.php');

if(isset($_POST['register']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $qualification = $_POST['qualification'];
    $address = $_POST['address'];
    $subject = $_POST['subject'];
    $joiningdate = $_POST['joiningdate'];
    $password = md5($_POST['password']);

    // image upload
    $picture = $_FILES["picture"]["name"];
    $temp = $_FILES["picture"]["tmp_name"];
    move_uploaded_file($temp,"images/".$picture);

    $sql = "INSERT INTO tblteacher
    (name,picture,email,mobilenumber,qualifications,address,teachersub,joiningdate,password)
    VALUES
    (:name,:picture,:email,:mobile,:qualification,:address,:subject,:joiningdate,:password)";

    $query = $dbh->prepare($sql);

    $query->bindParam(':name',$name);
    $query->bindParam(':picture',$picture);
    $query->bindParam(':email',$email);
    $query->bindParam(':mobile',$mobile);
    $query->bindParam(':qualification',$qualification);
    $query->bindParam(':address',$address);
    $query->bindParam(':subject',$subject);
    $query->bindParam(':joiningdate',$joiningdate);
    $query->bindParam(':password',$password);

    $query->execute();

    echo "<script>alert('Registration Successful');</script>";
    echo "<script>window.location='login.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Teacher Registration</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:linear-gradient(135deg,#4e54c8,#8f94fb);
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
}

.container{
    width:400px;
    background:white;
    padding:30px;
    border-radius:12px;
    box-shadow:0 0 20px rgba(0,0,0,0.3);
}

h2{
    text-align:center;
    margin-bottom:20px;
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
    cursor:pointer;
    font-size:16px;
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

<div class="container">

    <h2>Teacher Registration</h2>

   <form method="post" enctype="multipart/form-data">

    <input type="text" name="name" placeholder="Name" required>

    <input type="email" name="email" placeholder="Email" required>

    <input type="text" name="mobile" placeholder="Mobile" required>

    <input type="text" name="qualification" placeholder="Qualification" required>

    <input type="text" name="address" placeholder="Address" required>

    <input type="text" name="subject" placeholder="Subject" required>

    <input type="date" name="joiningdate" required>

    <input type="file" name="picture" required>

    <input type="password" name="password" placeholder="Password" required>

    <button type="submit" name="register">Register</button>

</form>

    <a href="index.php">Already have an account? Login</a>

</div>

</body>
</html>
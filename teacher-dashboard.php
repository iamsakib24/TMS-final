<?php
session_start();
include('includes/dbconnection.php');

if(empty($_SESSION['trmsaid'])) { 
    header('location:login.php');
    exit;
}

$tid = $_SESSION['trmsaid']; 

// সঠিক SQL কোয়েরি: teacher_id এবং salary কলামের নাম ঠিক করা হয়েছে
$sql = "SELECT T.*, S.salary 
        FROM tblteacher T 
        LEFT JOIN tblsalary S ON T.ID = S.teacher_id 
        WHERE T.ID = :tid";

$query = $dbh->prepare($sql);
$query->bindParam(':tid', $tid, PDO::PARAM_INT);
$query->execute();
$row = $query->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Teacher Dashboard</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f7f6; margin: 0; padding: 20px; }
        .dashboard-container { max-width: 600px; background: white; margin: 0 auto; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .profile-header { text-align: center; margin-bottom: 30px; }
        .profile-img { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid #4e54c8; margin-bottom: 10px; }
        .info-group { margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .label { font-weight: bold; color: #4e54c8; display: block; font-size: 0.9em; }
        .value { color: #333; font-size: 1.1em; }
        .actions { text-align: center; margin-top: 20px; }
        .btn-logout { background: #ff4d4d; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; display: inline-block; }
    </style>
</head>
<body>

<div class="dashboard-container">
    <div class="profile-header">
        <img src="images/<?php echo htmlentities($row->Picture); ?>" alt="Profile" class="profile-img">
        <h2>Welcome, <?php echo htmlentities($row->Name); ?></h2>
    </div>

    <div class="info-group">
        <span class="label">Email Address</span>
        <span class="value"><?php echo htmlentities($row->Email); ?></span>
    </div>
    
    <div class="info-group">
        <span class="label">Monthly Salary</span>
        <span class="value" style="color: green; font-weight: bold;">
            <?php 
            if($row->salary) {
                echo htmlentities($row->salary) . " BDT"; 
            } else {
                echo "Not Assigned";
            }
            ?>
        </span>
    </div>

    <div class="info-group">
        <span class="label">Mobile Number</span>
        <span class="value"><?php echo htmlentities($row->MobileNumber); ?></span>
    </div>
    <div class="info-group">
        <span class="label">Qualification</span>
        <span class="value"><?php echo htmlentities($row->Qualifications); ?></span>
    </div>
    <div class="info-group">
        <span class="label">Subject Specialization</span>
        <span class="value"><?php echo htmlentities($row->TeacherSub); ?></span>
    </div>

     <div class="info-group">
        <span class="label">Joining Date</span>
        <span class="value"><?php echo htmlentities($row->JoiningDate); ?></span>
    </div>
    <div class="info-group">
        <span class="label">Address</span>
        <span class="value"><?php echo htmlentities($row->Address); ?></span>
    </div>

   



    <div class="actions">
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
</div>

</body>
</html>
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['trmsaid']==0)) {
  header('location:logout.php');
} else {



if(isset($_POST['submit']))
{
    $teacher_id = $_POST['teacher_id'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    // Duplicate check
    $check = "SELECT * FROM tblattendance WHERE teacher_id=:tid AND date=:date";
    $q = $dbh->prepare($check);
    $q->bindParam(':tid',$teacher_id,PDO::PARAM_STR);
    $q->bindParam(':date',$date,PDO::PARAM_STR);
    $q->execute();

    if($q->rowCount()>0){
        echo "<script>alert('Attendance already added');</script>";
    } else {

        $sql="INSERT INTO tblattendance(teacher_id,date,status)
              VALUES(:tid,:date,:status)";
        $query=$dbh->prepare($sql);
        $query->bindParam(':tid',$teacher_id,PDO::PARAM_STR);
        $query->bindParam(':date',$date,PDO::PARAM_STR);
        $query->bindParam(':status',$status,PDO::PARAM_STR);
        $query->execute();

        echo "<script>alert('Attendance Saved Successfully');</script>";
    }
}
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <title>TRMS Attendance Management</title>

    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<?php include_once('includes/sidebar.php');?>

<div id="right-panel" class="right-panel">

<?php include_once('includes/header.php');?>

<div class="breadcrumbs">
    <div class="col-sm-4">
        <h1>Teacher Attendance</h1>
    </div>
</div>

<div class="content mt-3">
<div class="animated fadeIn">
<div class="row">
<div class="col-lg-12">

<div class="card">
<div class="card-header">
    <strong>Teacher Attendance Management</strong>
</div>

<!-- ✅ Attendance Form -->
<form method="post">
<div class="card-body">

    <div class="form-group">
        <label>Select Teacher</label>
        <select name="teacher_id" class="form-control" required>
            <option value="">Select Teacher</option>
            <?php
            $sql="SELECT * FROM tblteacher";
            $query=$dbh->prepare($sql);
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            foreach($results as $row){
            ?>
            <option value="<?php echo $row->ID;?>">
                <?php echo $row->Name;?>
            </option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group">
        <label>Date</label>
        <input type="date" name="date" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control" required>
            <option value="Present">Present</option>
            <option value="Absent">Absent</option>
        </select>
    </div>

</div>

<p style="text-align:center;">
    <button type="submit" name="submit" class="btn btn-success">
        Save Attendance
    </button>
</p>
</form>

</div>
</div>
</div>
</div>
</div>
</div>

</div>

<script src="vendors/jquery/dist/jquery.min.js"></script>
<script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>

</body>
</html>
<?php } ?>

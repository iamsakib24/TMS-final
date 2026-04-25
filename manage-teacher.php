<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['trmsaid']==0)) {
  header('location:logout.php');
} else {
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>TRMS||||Manage Teacher</title>

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
        <h1>Manage Teachers</h1>
    </div>
</div>

<div class="content mt-3">
<div class="animated fadeIn">
<div class="row">
<div class="col-lg-12">
<div class="card">
<div class="card-header">
    <strong class="card-title">Manage Teachers (With Salary)</strong>
</div>

<div class="card-body">
<table class="table table-bordered">
<thead>
<tr>
  <th>S.NO</th>
  <th>Teacher Name</th>
  <th>Subject</th>
  <th>Salary</th>
  <th>Month</th>
  <th>Year</th>
  <th>Registration Date</th>       
  <th>Action</th>
</tr>
</thead>

<?php
// ✅ UPDATED QUERY (JOIN)
$sql="SELECT tblteacher.*, tblsalary.salary, tblsalary.month, tblsalary.year 
      FROM tblteacher 
      LEFT JOIN tblsalary 
      ON tblteacher.ID = tblsalary.teacher_id";

$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;

if($query->rowCount() > 0)
{
foreach($results as $row)
{   
?>
<tr>
  <td><?php echo htmlentities($cnt);?></td>
  <td><?php echo htmlentities($row->Name);?></td>
  <td><?php echo htmlentities($row->TeacherSub);?></td>

  <!-- ✅ Salary Show -->
  <td><?php echo $row->salary ? $row->salary : 'Not Added'; ?></td>
  <td><?php echo $row->month ? $row->month : '-'; ?></td>
  <td><?php echo $row->year ? $row->year : '-'; ?></td>

  <td><?php echo htmlentities($row->RegDate);?></td>

  <td>
    <a href="edit-teacher-detail.php?editid=<?php echo htmlentities($row->ID);?>">
        Edit
    </a>
  </td>
</tr>

<?php 
$cnt++;
}} 
?>

</table>
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

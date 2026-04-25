<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');


if(isset($_POST['submit']))
{
    $teacher_id = $_POST['teacher_id'];
    $salary = $_POST['salary'];
    $month = $_POST['month'];
    $year = $_POST['year'];

    // Duplicate check 
    $checksql = "SELECT * FROM tblsalary 
                 WHERE teacher_id=:tid AND month=:month AND year=:year";
    $checkquery = $dbh->prepare($checksql);
    $checkquery->bindParam(':tid',$teacher_id,PDO::PARAM_STR);
    $checkquery->bindParam(':month',$month,PDO::PARAM_STR);
    $checkquery->bindParam(':year',$year,PDO::PARAM_STR);
    $checkquery->execute();

    if($checkquery->rowCount() > 0){
        echo "<script>alert('Salary already added for this month');</script>";
    } else {

        $sql = "INSERT INTO tblsalary(teacher_id, salary, month, year)
                VALUES(:teacher_id, :salary, :month, :year)";
        
        $query = $dbh->prepare($sql);
        $query->bindParam(':teacher_id',$teacher_id,PDO::PARAM_STR);
        $query->bindParam(':salary',$salary,PDO::PARAM_STR);
        $query->bindParam(':month',$month,PDO::PARAM_STR);
        $query->bindParam(':year',$year,PDO::PARAM_STR);

        $query->execute();

        echo "<script>alert('Salary Added Successfully');</script>";
    }
}
?><!doctype html>
<html lang="en">
<head>
    <title>Teacher Salary Management</title>

    <link rel="stylesheet" href="css/bootstrap.css">
    <style>
        table {
            border-collapse: collapse;
        }
        td {
            border: 2px solid orange;
        }
        th {
            color:#000;
            border: 2px solid orange;
            font-weight:bold;
            font-size:18px;
        }
    </style>
</head>

<body>

<?php include_once('includes/header.php');?>

<div class="container mt-5">
    <h2 class="text-center">Teacher Salary Management</h2>

    <table class="table table-responsive">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Name</th>
                <th>Subject</th>
                <th>Salary</th>
                <th>Month</th>
                <th>Year</th>
                <th>Action</th>
            </tr>
        </thead>

        <?php
        $sql = "SELECT * FROM tblteacher";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        $cnt = 1;
        foreach($results as $row)
        {
        ?>
        <form method="post">
        <tr>
            <td><?php echo $cnt;?></td>
            <td><?php echo $row->Name;?></td>
            <td><?php echo $row->TeacherSub;?></td>

            <td>
                <input type="text" name="salary" class="form-control" required>
            </td>

            <td>
                <input type="text" name="month" class="form-control" placeholder="April" required>
            </td>

            <td>
                <input type="text" name="year" class="form-control" placeholder="2026" required>
            </td>

            <td>
                <input type="hidden" name="teacher_id" value="<?php echo $row->ID;?>">
                <button type="submit" name="submit" class="btn btn-success">Save</button>
            </td>
        </tr>
        </form>

        <?php 
        $cnt++;
        }
        ?>
    </table>
</div>



</body>
</html>

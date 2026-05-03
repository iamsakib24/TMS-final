<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['trmsaid'] == 0)) {
    header('location:logout.php');
} else {
    // Salary Save Logic
    if(isset($_POST['submit'])) {
        $teacher_id = $_POST['teacher_id'];
        $salary = $_POST['salary'];
        $month = $_POST['month'];
        $year = $_POST['year'];

        $checksql = "SELECT * FROM tblsalary WHERE teacher_id=:tid AND month=:month AND year=:year";
        $checkquery = $dbh->prepare($checksql);
        $checkquery->bindParam(':tid',$teacher_id,PDO::PARAM_STR);
        $checkquery->bindParam(':month',$month,PDO::PARAM_STR);
        $checkquery->bindParam(':year',$year,PDO::PARAM_STR);
        $checkquery->execute();

        if($checkquery->rowCount() > 0){
            echo "<script>alert('Salary already added for this month');</script>";
        } else {
            $sql = "INSERT INTO tblsalary(teacher_id, salary, month, year) VALUES(:teacher_id, :salary, :month, :year)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':teacher_id',$teacher_id,PDO::PARAM_STR);
            $query->bindParam(':salary',$salary,PDO::PARAM_STR);
            $query->bindParam(':month',$month,PDO::PARAM_STR);
            $query->bindParam(':year',$year,PDO::PARAM_STR);
            $query->execute();
            echo "<script>alert('Salary Added Successfully');</script>";
        }
    }
?>
<!doctype html>
<html lang="en">
<head>
    <title>Teacher Salary | TRMS</title>
    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <style>
        body { 
            background: #f4f7f6; 
            font-family: 'Segoe UI', sans-serif; 
            margin: 0;
        }
        
       
        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .salary-card {
            background: #fff;
            width: 100%;
            max-width: 1000px;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.06);
            border: 1px solid #e0e0e0;
        }

        .salary-card h2 {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #5c6bc0;
        }

      
        .table { margin-bottom: 0; }
        .table thead th {
            background-color: #f8f9fa;
            border-top: none;
            color: #555;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
        }

        .form-control {
            height: 38px;
            font-size: 14px;
            border-radius: 4px;
        }

        .btn-pay {
            background-color: #5c6bc0;
            color: white;
            border: none;
            padding: 6px 20px;
            font-weight: 600;
            border-radius: 4px;
            width: 100%;
        }

        .btn-pay:hover { background-color: #4a59a7; color: #fff; }

    
        .user-area, .header-left { display: none !important; }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="salary-card">
        <h2>Salary Disbursement Panel</h2>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="5%">SL</th>
                        <th width="30%">Teacher Name</th>
                        <th width="20%">Amount</th>
                        <th width="20%">Month/Year</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM tblteacher";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    $cnt = 1;
                    foreach($results as $row) {
                    ?>
                    <form method="post">
                        <tr>
                            <td><?php echo $cnt;?></td>
                            <td>
                                <strong><?php echo $row->Name;?></strong><br>
                                <small class="text-muted"><?php echo $row->TeacherSub;?></small>
                            </td>
                            <td>
                                <input type="number" name="salary" class="form-control" placeholder="Salary" required>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <select name="month" class="form-control mr-1" required>
                                        <?php
                                        $months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                                        foreach($months as $m) {
                                            echo "<option value='$m'".($m == date('M') ? ' selected' : '').">$m</option>";
                                        }
                                        ?>
                                    </select>
                                    <input type="text" name="year" class="form-control" value="<?php echo date('Y'); ?>" style="width: 70px;" required>
                                </div>
                            </td>
                            <td>
                                <input type="hidden" name="teacher_id" value="<?php echo $row->ID;?>">
                                <button type="submit" name="submit" class="btn btn-pay">PAY</button>
                            </td>
                        </tr>
                    </form>
                    <?php $cnt++; } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
<?php } ?>

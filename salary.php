<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Salary Save Logic
if(isset($_POST['submit']))
{
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
    <title>Teacher Salary Management | TRMS</title>
    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    
    <style>
        body { 
            background: #f4f7f6; 
            font-family: 'Poppins', sans-serif; 
            margin: 0;
            padding: 0;
        }
        
        /* Container fix to center the content */
        .main-content {
            padding: 20px;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .card { 
            border: none; 
            border-radius: 15px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.1); 
            background: #fff;
            width: 100%;
            max-width: 1200px; /* Table er size control korbe */
            overflow: hidden;
        }

        .card-header { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            padding: 25px; 
            text-align: center;
            border: none;
        }
        .card-header h2 { 
            font-size: 22px; 
            font-weight: 700; 
            color: #fff; 
            margin: 0;
            text-transform: uppercase;
        }
        
        .table thead th {
            background-color: #5c6bc0;
            color: #ffffff;
            font-weight: 600;
            border: none;
            padding: 15px;
            text-align: center;
        }
        
        .table tbody td {
            vertical-align: middle;
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        .form-control {
            border-radius: 8px;
            padding: 8px;
            border: 1px solid #ddd;
        }

        .btn-save {
            background: #00b09b;
            background: linear-gradient(to right, #00b09b, #96c93d);
            border: none;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            color: #fff;
            transition: 0.3s;
        }
        .btn-save:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .teacher-name { font-weight: 700; color: #333; }
        .subject-badge { 
            background: #ffeaa7; 
            color: #d63031; 
            padding: 2px 10px; 
            border-radius: 10px; 
            font-size: 11px; 
            font-weight: bold;
        }

        /* Hiding potential unwanted icons from header.php */
        .user-area img, .user-avatar { display: none !important; }
    </style>
</head>

<body>


<?php include_once('includes/header.php');?>

<div class="main-content">
    <div class="card">
        <div class="card-header">
            <h2>Salary Disbursement Panel</h2>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th style="text-align: left;">Teacher Details</th>
                            <th>Monthly Salary</th>
                            <th>Month</th>
                            <th>Year</th>
                            <th>Action</th>
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
                            <td style="text-align: left;">
                                <div class="teacher-name"><?php echo $row->Name;?></div>
                                <span class="subject-badge"><?php echo $row->TeacherSub;?></span>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="number" name="salary" class="form-control" placeholder="Amount" required>
                                </div>
                            </td>
                            <td>
                                <select name="month" class="form-control" required>
                                    <?php
                                    $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                                    foreach($months as $m) {
                                        echo "<option value='$m'".($m == date('F') ? ' selected' : '').">$m</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="year" class="form-control" value="<?php echo date('Y'); ?>" required>
                            </td>
                            <td>
                                <input type="hidden" name="teacher_id" value="<?php echo $row->ID;?>">
                                <button type="submit" name="submit" class="btn btn-save">PAY</button>
                            </td>
                        </tr>
                        </form>
                        <?php $cnt++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="vendors/jquery/dist/jquery.min.js"></script>
<script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>

</body>
</html>

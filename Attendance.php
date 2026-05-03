<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['trmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $teacher_id = $_POST['teacher_id'];
        $date = $_POST['date'];
        $status = $_POST['status'];

        $check = "SELECT * FROM tblattendance WHERE teacher_id=:tid AND date=:date";
        $q = $dbh->prepare($check);
        $q->bindParam(':tid', $teacher_id, PDO::PARAM_STR);
        $q->bindParam(':date', $date, PDO::PARAM_STR);
        $q->execute();

        if ($q->rowCount() > 0) {
            echo "<script>alert('Attention: Attendance already added.');</script>";
        } else {
            $sql = "INSERT INTO tblattendance(teacher_id,date,status) VALUES(:tid,:date,:status)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':tid', $teacher_id, PDO::PARAM_STR);
            $query->bindParam(':date', $date, PDO::PARAM_STR);
            $query->bindParam(':status', $status, PDO::PARAM_STR);
            $query->execute();
            echo "<script>alert('Success: Attendance Saved');</script>";
        }
    }
?>
<!doctype html>
<html lang="en">
<head>
    <title>Teacher Attendance | TRMS</title>
    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    
    <style>
        body { 
            background-color: #f4f7f6; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

       
        .wrapper {
            display: flex;
            justify-content: center; 
            align-items: center;     
            min-height: 100vh; 
            padding: 20px;
        }

        .attendance-card {
            background: #ffffff;
            width: 100%;
            max-width: 750px; 
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            border: 1px solid #e0e0e0;
        }

        .attendance-card h2 {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 25px;
            text-align: center;
            border-bottom: 2px solid #5c6bc0;
            padding-bottom: 15px;
        }

        .form-label {
            font-weight: 600;
            color: #444;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            height: 45px;
            border-radius: 6px;
            border: 1px solid #ced4da;
        }

        .btn-save {
            background-color: #5c6bc0;
            color: white;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 6px;
            border: none;
            width: 100%; 
            margin-top: 10px;
        }

        .btn-save:hover { 
            background-color: #4a59a7; 
            cursor: pointer;
        }

        .btn-reset {
            background: transparent;
            border: 1px solid #ccc;
            color: #777;
            width: 100%;
            margin-top: 10px;
            padding: 10px;
            border-radius: 6px;
        }

     
        #right-panel {
            margin-left: 0 !important;
        }
    </style>
</head>

<body>

<div id="right-panel" class="right-panel">
    

    <div class="wrapper">
        <div class="attendance-card">
            <h2>Teacher Attendance System</h2>

            <form method="post">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label class="form-label">Select Faculty Member</label>
                            <select name="teacher_id" class="form-control" required>
                                <option value="">-- Choose Teacher --</option>
                                <?php
                                $sql = "SELECT * FROM tblteacher";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                foreach ($results as $row) {
                                    echo "<option value='".$row->ID."'>".$row->Name."</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label class="form-label">Date</label>
                            <input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label class="form-label">Attendance Status</label>
                            <select name="status" class="form-control" required>
                                <option value="Present">Present</option>
                                <option value="Absent">Absent</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-8">
                        <button type="submit" name="submit" class="btn btn-save">Save Attendance</button>
                    </div>
                    <div class="col-md-4">
                        <button type="reset" class="btn btn-reset">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
<?php } ?>

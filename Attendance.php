<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['trmsaid'] == 0)) {
    header('location:logout.php');
} else {
    // Attendance Save Logic
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
            echo "<script>alert('Attention: Attendance already added for this teacher on this date.');</script>";
        } else {
            $sql = "INSERT INTO tblattendance(teacher_id,date,status) VALUES(:tid,:date,:status)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':tid', $teacher_id, PDO::PARAM_STR);
            $query->bindParam(':date', $date, PDO::PARAM_STR);
            $query->bindParam(':status', $status, PDO::PARAM_STR);
            $query->execute();

            echo "<script>alert('Success: Attendance Saved Successfully');</script>";
        }
    }
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>Teacher Attendance Dashboard | TRMS</title>
    
    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    
    <style>
        /* Base Styling */
        body { background-color: #f0f3f6; font-family: 'Poppins', sans-serif; color: #333; }
        .content-wrapper { padding: 40px 20px; }
        
        /* Colorful Gradient Header */
        .page-header-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 25px;
            border-radius: 15px;
            color: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .page-header-box h1 { font-size: 26px; font-weight: 700; margin: 0; color: white; }
        .page-header-box p { margin: 5px 0 0; opacity: 0.8; font-size: 14px; }
        
        /* Modern Card Styling */
        .card-attendance {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            background: #ffffff;
            transition: transform 0.3s ease;
        }
        .card-attendance:hover { transform: translateY(-5px); }
        .card-header-custom {
            background-color: #ffffff;
            border-bottom: 1px solid #f0f0f0;
            padding: 25px;
            border-radius: 15px 15px 0 0 !important;
        }
        .card-header-custom strong { font-size: 18px; color: #4a5568; font-weight: 600; }
        
        /* Form Elements Styling */
        .form-label-custom { font-weight: 600; color: #666; margin-bottom: 10px; font-size: 14px; }
        .form-control-custom {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            transition: all 0.3s;
            font-size: 15px;
        }
        .form-control-custom:focus {
            border-color: #a78bfa;
            box-shadow: 0 0 0 3px rgba(167, 139, 250, 0.2);
            color: #333;
        }
        
        /* Status Select Color-coding */
        .select-status { font-weight: 600; color: white !important; }
        .status-present { background-color: #10b981 !important; } /* Green */
        .status-absent { background-color: #ef4444 !important; } /* Red */
        
        /* Action Buttons */
        .btn-action {
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s;
            border: none;
        }
        .btn-submit {
            background: linear-gradient(135deg, #a78bfa 0%, #7c3aed 100%);
            color: white;
            box-shadow: 0 4px 10px rgba(124, 58, 237, 0.3);
        }
        .btn-submit:hover {
            box-shadow: 0 6px 15px rgba(124, 58, 237, 0.4);
            transform: scale(1.02);
            color: white;
        }
        .btn-reset { background-color: #f3f4f6; color: #4b5563; }
        .btn-reset:hover { background-color: #e5e7eb; color: #1f2937; }
        
    </style>
</head>

<body>

<?php include_once('includes/sidebar.php');?>

<div id="right-panel" class="right-panel">
    <?php include_once('includes/header.php');?>

    <div class="content-wrapper">
        <div class="animated fadeIn">
            
            <!-- Dynamic Colorful Page Header -->
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="page-header-box">
                        <div>
                            <h1>Mark Attendance</h1>
                            <p>Daily record management for all faculty members</p>
                        </div>
                        <div class="header-date" style="font-weight: 600; font-size: 16px;">
                            <i class="fa fa-calendar"></i> <?php echo date('l, F j, Y'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card card-attendance">
                        <div class="card-header-custom">
                            <strong>Daily Attendance Entry Form</strong>
                        </div>

                        <form method="post">
                            <div class="card-body padding-40" style="padding: 40px;">
                                
                                <div class="row">
                                    <!-- Select Teacher -->
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label-custom">Select Faculty Member</label>
                                        <select name="teacher_id" class="form-control form-control-custom" required>
                                            <option value="" style="color: #888;">Choose a teacher...</option>
                                            <?php
                                            $sql = "SELECT * FROM tblteacher";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            foreach ($results as $row) { ?>
                                                <option value="<?php echo $row->ID; ?>">
                                                    <?php echo $row->Name; ?> (<?php echo $row->TeacherSub; ?>)
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <!-- Date -->
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label-custom">Attendance Date</label>
                                        <input type="date" name="date" class="form-control form-control-custom" value="<?php echo date('Y-m-d'); ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Status -->
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label-custom">Attendance Status</label>
                                        <select name="status" id="statusSelect" class="form-control form-control-custom select-status status-present" required onchange="updateStatusColor()">
                                            <option value="Present" class="status-present">Present</option>
                                            <option value="Absent" class="status-absent">Absent</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            
                            <div class="card-footer" style="background-color: #fafafa; text-align: right; padding: 25px 40px; border-radius: 0 0 15px 15px; border-top: 1px solid #f0f0f0;">
                                <button type="reset" class="btn-action btn-reset mr-2">
                                    Reset Form
                                </button>
                                <button type="submit" name="submit" class="btn-action btn-submit">
                                    Save Attendance Entry
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="vendors/jquery/dist/jquery.min.js"></script>
<script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<script>
    function updateStatusColor() {
        var select = document.getElementById("statusSelect");
        select.classList.remove("status-present", "status-absent");
        
        if (select.value === "Present") {
            select.classList.add("status-present");
        } else if (select.value === "Absent") {
            select.classList.add("status-absent");
        }
    }
    
    // Set initial color
    updateStatusColor();
</script>

</body>
</html>
<?php } ?>

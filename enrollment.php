<?php
    session_start();
    require_once 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Online Enrollment Registration (S.Y. 2020-2021 2nd Semester)</title>

        <?php
            $stud_num = $_SESSION['stud_num'];
            $password = $_SESSION['password'];
            $school_year = "4th Year 1st Semester";

            // search if account exists in database and get the number of subjects enrolled
            $sql = "SELECT * FROM profile_t P JOIN student_t S ON P.stud_num = S.stud_num WHERE P.stud_num = '$stud_num' AND P.password = '$password'";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $fname = $row['fname'];
                $section = $row['section'];
                $department = $row['department'];
                $isEnrolled = $row['isEnrolled'];
                $no_of_enrolled = $row['no_of_subjs'];
            }else {
                echo "<script>alert('Account does not exists. Try again.');</script>";
            }

            // get the subject codes of enrolled subjects into an array (if already enrolled)
            $arr_enrolled_subjects = array();
            if($isEnrolled == 'Yes'){
                $sql = "SELECT sub_code FROM grade_t WHERE stud_num = '$stud_num'";
                $result = $conn->query($sql);
                for($i = 0; $row = $result->fetch_assoc(); $i++){
                    $arr_enrolled_subjects[$i] = $row['sub_code'];
                }
            }

            // get the total number of subjects
            $sql = "SELECT COUNT(*) AS 'count' FROM schedule_t WHERE section = '$section' AND department = '$department'";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $no_of_subjs = $row['count'];
            }else{
                echo "<script>alert('Schedule Table is empty.');</script>";
            }

            // get the records from schedule into an array
            $sql = "SELECT * FROM schedule_t WHERE section = '$section' AND department = '$department'";
            $result = $conn->query($sql);
            if($result->num_rows >0){
                for($i = 0; $rows = $result->fetch_assoc(); $i++){
                    $course_array[$i][0] = $rows['sub_code'];
                    $course_array[$i][1] = $rows['sub_desc'];
                    $course_array[$i][2] = $rows['units'];
                    $course_array[$i][3] = $rows['sched'];
                    $course_array[$i][4] = $rows['admin_id'];
                }
            }
        ?>

        <!-- JavaScript -->
        <script>
            function hide_content_empty(){
                document.getElementById('div_content_empty').style.display = "none";
            }
            function hide_content_not_empty(){
                document.getElementById('div_content_not_empty').style.display = "none";
            }
            function goto_schedule(){
                location = "http://localhost/webdev1/schedule.php";
            }
        </script>

        <!-- CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
            .font-Poppins{
                font-family: 'Poppins',sans-serif;
            }
            .checkbox_courses{
                background: white;
                padding: 40px;
                border: 2px solid #eee;
                margin: 80px;
            }
        </style>
    </head>
    
    <body style="background-image: url('./images/pup_campus.jpg'); background-size: cover; height: 100%; background-attachment: fixed; background-position: center;">
        <!-- Navigation Bar -->
        <nav class="navbar bg-danger bg-gradient navbar-dark navbar-expand-lg">
            <div class="container font-Poppins">
                <a href="home.php" class="navbar-brand fs-3">
                    <img src="./images/pup_logo.png" alt="" width=45 height="auto" class="d-inline-block align-text-middle"> Polytechnic University of the PUP
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto mb-0 mb-lg-0 fw-bold fs-6">
                        <li class="nav-item" >
                            <a class="nav-link" href="home.php" style="text-transform: capitalize;"><?php echo $fname;?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"  href="grades.php">Grades</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="enrollment.php">Enrollment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="schedule.php">Schedule</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php" onclick="return confirm('You are being logged out.');">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Form -->
        <div class="container w-100 p-3">
            <div class="checkbox_courses font-Poppins" style="border-radius: 10px;	box-shadow: 0 10px 15px rgba(0,0,0,1);">
                <form method="POST">
                    <div id="div_headings">
                        <div class="text-center" id="div_headings" style="background-color: maroon;">
                            <span class="fw-bold fs-2 text-light align-middle"><?php $remaining = $no_of_subjs-$no_of_enrolled; if($remaining == 0) echo "No more remaining courses available."; else echo "$remaining remaining courses available";?></span>
                        </div>
                        <div class='d-flex justify-content-center' style='background-color: maroon;'>
                            <span class='fs-6 text-light align-middle'>(S.Y. 2020-2021 Second Semester)</span>
                        </div>
                    </div>

                    <!-- display when all subjects are enrolled -->
                    <div id="div_content_empty" style="border: 2px solid dimgrey; border-collapse: collapse; padding: 70px;">
                        <p class="fs-5 fw-normal text-center">All subjects have been successfully enrolled. Head over to <a href="schedule.php" class="text-decoration-none fw-normal">Schedule Tab</a> to find the subjects that you have enrolled.</p>
                    </div>

                    <!-- display unenrolled subjects -->
                    <div id="div_content_not_empty">
                        <div id="div_courses" style="border: 2px solid dimgrey;"><br>
                            <?php
                                for($i = 0; $i < count($course_array); $i++){
                                    if($isEnrolled == 'Yes'){
                                        if(check_if_enrolled($arr_enrolled_subjects, $course_array[$i][0])){
                                            continue;
                                        }
                                    }
                                    echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
                                    echo "<input type='checkbox' name=enroll[] id=enroll[$i] value=$i><label for=enroll[$i]>&nbsp[". $course_array[$i][0]."] ". $course_array[$i][1]."</label><br><br>";
                                }

                                function check_if_enrolled($arr, $temp){
                                    for($i = 0; $i < count($arr); $i++){
                                        if($arr[$i] == $temp){
                                            return True;
                                        }
                                    }
                                    return False;
                                }
                            ?>
                        </div>
                        <div class="text-center" id="div_btn_enroll">
                            <br><br><input class='btn btn-success' type='submit' name='btnSubmit' id='btn_enroll' value='Enroll'>
                        </div>
                    </div>
                    <?php
                        if(isset($_POST['btnSubmit'])){
                            // get the chosen subjects and insert it to grade table
                            if(!empty($_POST['enroll'])){
                                $enrolled_subs = $_POST['enroll'];
                                foreach($enrolled_subs as $enrolled){
                                    $sub_code = $course_array[$enrolled][0];
                                    $sql = "SELECT admin_id FROM schedule_t WHERE sub_code='$sub_code' AND section = '$section' AND department = '$department'";
                                    $result = $conn->query($sql);
                                    if($result->num_rows > 0){
                                        $row = $result->fetch_assoc();
                                        $admin_id = $row['admin_id'];
                                    }else{
                                        echo "<script>alert('Error: Subject code Invalid.');</script>";
                                    }

                                    $sql = "INSERT INTO grade_t(stud_num, sub_code, admin_id) VALUES ('$stud_num', '$sub_code', '$admin_id')";
                                    if(!$conn->query($sql)){
                                        echo "<script>alert('Error inserting subjects.');</script>";
                                    }
                                    $no_of_enrolled++;
                                }

                                // update student enrollment status and no of enrolled subjects
                                $sql = "UPDATE student_t SET isEnrolled = 'Yes', no_of_subjs = '$no_of_enrolled' WHERE stud_num = '$stud_num'";
                                if(!$conn->query($sql)){
                                    echo "<script>alert('Error updating Student Table.');</script>";
                                }
                                unset($_POST['btnSubmit']);
                                echo "<script>goto_schedule();</script>";
                            }else{
                                echo "<script>alert('Please specify the subjects that you would like to enroll');</script>";
                            }
                        }
                    ?>
                </form>
                <?php

                    // hide divs depending on value of no_of_enrolled
                    if($no_of_enrolled == 7){
                        echo "<script>hide_content_not_empty()</script>";
                    }else{
                        echo "<script>hide_content_empty()</script>";
                    }

                ?>
            </div>
        </div>

        <!-- Footer -->
        <br><br>
        <footer class="bg-dark bg-gradient">
            <div class="container">
                <br>                    
                    <nav class="text-light text-center">
                        Authors: 
                        <a style="text-decoration: none; color: lightslategray;" href="https://www.facebook.com/jshcrzt">Cruzat, Joshua</a> | 
                        <a style="text-decoration: none; color: lightslategray;" href="https://www.facebook.com/jers.zamora.9">Destacamento, Jerson</a> | 
                        <a style="text-decoration: none; color: lightslategray;" href="https://www.facebook.com/leeurengi">Legaspi, Rocella Mae</a> | 
                        <a style="text-decoration: none; color: lightslategray;" href="https://www.facebook.com/ZetsuoLockhart">Pandungan, Jericho</a>
                    </nav>
                <p class="m-0 text-light text-center">
                    <br><br>&copy2021 PUP-CCIS<br>All Rights Reserved.<br>
                </p>
            </div>
        </footer>

        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    </body>
</html>
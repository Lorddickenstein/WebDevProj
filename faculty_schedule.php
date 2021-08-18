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

        <!-- PHP -->
        <?php
            $admin_id = $_SESSION['admin_id'];
            $password = $_SESSION['password'];

            // search if account exists in database and get the number of subjects enrolled
            $sql = "SELECT * FROM admin_t WHERE admin_id = '$admin_id' AND password = '$password'";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $fname = $row['fname'];
            }else {
                echo "<script>alert('Account does not exists. Try again.');</script>";
            }
            
            // get the number of sections enrolled to this admin
            $sql = "SELECT count(*) AS count FROM schedule_t WHERE section IN (SELECT DISTINCT section FROM grade_t G JOIN student_t S ON G.stud_num = S.stud_num WHERE admin_id = '$admin_id') AND admin_id='$admin_id'";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $no_of_enrolled = $row['count'];
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
        </script>
    
        <!-- CSS -->
        <link href="./css/schedule.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    </head>
    <body>
        <!-- Navigation Bar -->
        <nav class="navbar bg-danger bg-gradient navbar-dark navbar-expand-lg">
            <div class="container">
                <a href="home.php" class="navbar-brand fs-3" >
                    <img src="./images/pup_logo.png" alt="" width=45 height="auto" class="d-inline-block align-text-middle"> Polytechnic University of the PUP
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto mb-0 mb-lg-0 fw-bold fs-6">
                        <li class="nav-item" >
                            <a class="nav-link" href="faculty_home.php" style="text-transform: capitalize;"><?php echo $fname;?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="faculty_studentlist.php">Student List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="faculty_grade.php">Grades</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="faculty_schedule.php">Schedule</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php" onclick="return confirm('You are being logged out.');">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Form -->
        <form method="POST">
            <div class="container w-100 p-3">
                <div class="checkbox_courses font-Poppins" id="div_outer_border">
                    <div id="div_headings">
                        <div class="d-flex justify-content-center">
                            <span class='fs-2 fw-bold text-light align-middle'><?php if($no_of_enrolled > 0) echo "You have $no_of_enrolled sections enrolled to your subjects.";else echo "There are no sections enrolled to your subjects."?></span>
                        </div>
                        <div class='d-flex justify-content-center' style='background-color: maroon;'>
                            <span class='fs-6 text-light align-middle'>(S.Y. 2020-2021 Second Semester)</span>
                        </div>
                    </div>
                    <div id="div_content_empty">
                        <p class="fs-5 fw-normal text-center">You're schedule for this sem S.Y. 2020-2021 will appear here.</p>
                    </div>
                    <div id="div_content_not_empty">
                        <table style='border-collapse: collapse;' class='text-center w-100'>
                            <tr class='text-center'>
                                <th style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>Subject Code</th>
                                <th style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>Description</th>
                                <th style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>Schedule</th>
                                <th style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>Section</th>
                            </tr>
                            <?php 
                                $sql = "SELECT sub_code, sub_desc, sched, section, department FROM schedule_t WHERE section IN (SELECT DISTINCT section FROM grade_t G JOIN student_t S ON G.stud_num = S.stud_num WHERE admin_id = '$admin_id') AND admin_id='$admin_id'";
                                $result = $conn->query($sql);
                                if($result->num_rows > 0){
                                    while($rows = $result->fetch_assoc()){
                                        echo "<tr>";
                                        echo "<td style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>". $rows['sub_code']. "</td>";
                                        echo "<td style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>". $rows['sub_desc']. "</td>";
                                        echo "<td style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>". $rows['sched']. "</td>";
                                        echo "<td style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>". $rows['department']. "<br>". $rows['section']. "</td>";
                                        echo "</tr>";
                                    }
                                }else{
                                    echo "<td style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>No Record</td>";
                                }

                            ?>
                        </table><br>
                        <?php 
                            // hide divs depending on value of no_of_enrolled
                            if($no_of_enrolled > 0){
                                echo "<script>hide_content_empty()</script>";
                            }else{
                                echo "<script>hide_content_not_empty()</script>";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </form>
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
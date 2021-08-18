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
        ?>

        <!-- JavaScript -->
        <script type="text/javascript">
            function hide_content_empty(){
                document.getElementById('div_content_empty').style.display = "none";
            }
            function hide_content_not_empty(){
                document.getElementById('div_content_not_empty').style.display = "none";
            }
        </script>
        
        <!-- CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
            body{
                background-image: url('./images/pup_campus.jpg');
                background-size: cover;
                height: 100%; 
                background-attachment: fixed;
                background-position: center;
            }
            .font-Poppins{
                font-family: 'Poppins',sans-serif;
            }
            .checkbox_courses{
                background: white;
                padding: 40px;
                border: 2px solid #eee;
                margin: 80px;
            }
            #div_outer_border{
                background-color: white;
                margin: 80px;
                padding: 40px;
                border: 2px solid #eee;
                border-radius: 10px;
                box-shadow: 0 10px 15px rgba(0,0,0,1);
            }
            #div_content_empty{
                border: 2px solid dimgrey;
                border-collapse: collapse;
                padding: 70px;
            }
        </style>
    </head>
    <body>
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
                            <a class="nav-link active"  href="grades.php">Grades</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="enrollment.php">Enrollment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="schedule.php">Schedule</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <!-- Form -->
        <form action="faculty_grade.php" method="post">
            <div class="container w-100 p-3">
                <div class="checkbox_courses font-Poppins" id="div_outer_border">
                    <div id="div_headings" style='background-color: maroon;'>
                        <div class="d-flex justify-content-center">
                            <span class='fs-2 fw-bold text-light align-middle'><?php if($no_of_enrolled > 0) echo "Grades";else echo "You have not enrolled a subject."?></span>
                        </div>
                        <div class='d-flex justify-content-center'>
                            <span class='fs-6 text-light align-middle'>(S.Y. 2020-2021 Second Semester)</span>
                        </div>
                    </div>
                    <div id="div_content_empty">
                        <p class="fs-5 fw-normal text-center">Grades will displayed here once you have enrolled atleast one subject. Click <a href="enrollment.php" class="text-decoration-none fw-normal">here</a> now to enroll!</p>
                    </div>
                    <div id="div_content_not_empty" class="d-grid gap-2">
                        <table style='border-collapse: collapse;' class='text-center w-100'>
                            <tr class='text-center'>
                                <th style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>Subject Code</th>
                                <th style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>Description</th>
                                <th style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>Instructor</th>
                                <th style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>Final Grade</th>
                                <th style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>Status</th>
                            </tr>
                            <?php
                                $sql = "SELECT DISTINCT G.sub_code, S.sub_desc, A.fname, A.mname, A.lname, G.final_grade, G.status FROM grade_t G JOIN admin_t A ON G.admin_id = A.admin_id JOIN schedule_t S ON G.sub_code = S.sub_code WHERE G.stud_num = '$stud_num' AND S.section = '$section'";
                                $result = $conn->query($sql);
                                if($result->num_rows > 0){
                                    while($rows = $result->fetch_assoc()){
                                        echo "<tr>";
                                        echo "<td style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>". $rows['sub_code']. "</td>";
                                        echo "<td style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>". $rows['sub_desc']. "</td>";
                                        $admin_fname = $rows['fname']; $admin_mname = $rows['mname']; $admin_lname = $rows['lname'];
                                        $admin_full_name = $admin_fname. " ". $admin_mname[0]. ". ". $admin_lname;
                                        echo "<td style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>". $admin_full_name. "</td>";
                                        echo "<td style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>". $rows['final_grade']. "</td>";
                                        echo "<td style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>". $rows['status']. "</td>";
                                        echo "</tr>";
                                    }
                                    $result->free_result();
                                }
                            ?>
                        </table>
                    </div>
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
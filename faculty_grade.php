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
                $result->free_result();
            }else {
                echo "<script>alert('Account does not exists. Try again.');</script>";
            }
            
            // get the number of sections enrolled to this admin
            $sql = "SELECT count(*) AS count FROM schedule_t WHERE section IN (SELECT DISTINCT section FROM grade_t G JOIN student_t S ON G.stud_num = S.stud_num WHERE admin_id = '$admin_id') AND admin_id='$admin_id'";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $no_of_enrolled = $row['count'];
                $result->free_result();
            }

            // get the department enrolled to this admin in an array
            $sql = "SELECT DISTINCT department FROM grade_t G JOIN student_t S ON G.stud_num = S.stud_num WHERE admin_id = '$admin_id'";
            $result = $conn->query($sql);
            $arr_department = array();
            if($result->num_rows > 0){
                for($i = 0; $row = $result->fetch_assoc(); $i++){
                    $arr_department[$i] = $row['department'];
                }
                $result->free_result();
            }

            if(isset($_POST['btnSearch_category'])){
                $section = $_POST['section'];
                $department = $_POST['department'];
                $sql = "SELECT * FROM grade_t G JOIN profile_t P ON G.stud_num = P.stud_num JOIN student_t S ON G.stud_num = S.stud_num WHERE G.admin_id = '$admin_id' AND S.section = '$section' AND S.department = '$department' ORDER BY P.lname, P.fname, P.mname";
                $res = $conn->query($sql);
            }else if(isset($_POST['btnSearch'])){
                $search = $_POST['search'];
                $sql = "SELECT * FROM grade_t G JOIN profile_t P ON G.stud_num = P.stud_num JOIN student_t S ON G.stud_num = S.stud_num WHERE G.admin_id = '$admin_id' AND CONCAT(P.fname, P.mname, P.lname, G.stud_num, S.department, S.section) LIKE '%$search%' ORDER BY P.lname, P.fname, P.mname";
                $res = $conn->query($sql);
            }else{
                $sql = "SELECT * FROM grade_t G JOIN profile_t P ON G.stud_num = P.stud_num JOIN student_t S ON G.stud_num = S.stud_num WHERE G.admin_id = '$admin_id' ORDER BY P.lname, P.fname, P.mname";
                $res = $conn->query($sql);
            }
            
        ?>

        <script src="jquery.tabledit.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script>
            function edit_grade(id){
                document.getElementById(id).disabled = false;
                var edit = id + "_edit";
                var save = id + "_save";
                document.getElementById(edit).style.display = "none";
                document.getElementById(save).style.display = "block";
            }
            function reload_page(){
                location = location;
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
                            <a class="nav-link active" href="faculty_grade.php">Grades</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="faculty_schedule.php">Schedule</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php" onclick="return confirm('You are being logged out.');">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Form -->
        <form action="faculty_grade.php" method="post">
            <div class="container w-100 p-3">
                <div class="checkbox_courses font-Poppins" id="div_outer_border">
                    <div id="div_headings">
                        <div class="d-flex justify-content-center">
                            <span class='fs-2 fw-bold text-light align-middle'><?php if($no_of_enrolled > 0) echo "Grades";else echo "There are no sections enrolled to your subjects."?></span>
                        </div>
                        <div class='d-flex justify-content-center' style='background-color: maroon;'>
                            <span class='fs-6 text-light align-middle'>(S.Y. 2020-2021 Second Semester)</span>
                        </div>
                        <div class="container">
                            <div class="fs-6 me-3 text-light w-100">
                                <div class="row">
                                    <div class="row">
                                        <div class="col-3">
                                            <label class="ms-3 form-label">Search by Category</label>
                                        </div>
                                        <div class="col-9">
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 mt-3 ms-3 me-3">
                                            <label class="form-label">Department&nbsp</label>
                                            <select name="department" class="form-select form-select-sm t-5" aria-label=".form-select-lg example" id="department">
                                                <?php 
                                                    for($i = 0; $i < count($arr_department); $i++)
                                                        echo "<option value='$arr_department[$i]'>$arr_department[$i]</option>";
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 mt-3 ms-3 me-3">
                                            <label class="form-label">Section&nbsp</label>
                                            <select name="section" class="form-select form-select-sm t-5" aria-label=".form-select-lg example" id="section">
                                                <option value="3-1">3-1</option>
                                                <option value="3-2">3-2</option>
                                                <option value="3-3">3-3</option>
                                                <option value="3-4">3-4</option>
                                                <option value="3-1N">3-1N</option>
                                                <option value="3P">3P</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label></label>
                                        <div class="mb-3 mt-3 ms-3 me-3">
                                            <input type="submit" class="btn btn-success" value="Search" id="btnSearch_category" name="btnSearch_category">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="row">
                                        <div class="col-4">
                                            <label class="form-label">Search Individual Student</label><br>
                                        </div>
                                        <div class="col-8">
                                            <hr/>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 mt-3 ms-3 me-3">
                                            <div class="input-group">
                                                <input type="text" name="search" id="search" class="form-control form-control-sm" placeholder="Enter Keyword">
                                                <input type="submit" class="btn btn-success" value="Search" id="btnSearch" name="btnSearch">
                                                <input type="submit" class="btn btn-success" value="Refresh" id="btnRefresh" name="btnRefresh">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="div_content_not_empty" class="d-grid gap-2">
                        <table style='border-collapse: collapse;' class='text-center w-100'>
                            <tr class='text-center'>
                                <th style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>Student Number</th>
                                <th style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>Full Name</th>
                                <th style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>Section</th>
                                <th style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>Final Grade</th>
                                <th style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>Status</th>
                            </tr>
                            <?php
                                $arr = array();
                                $i = 0;
                                while($row = $res->fetch_assoc()){
                                    echo "<tr>";
                                    echo "<td style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>". $row['stud_num']."</td>";
                                    $full_name = $row['fname']. " ". $row['mname']. " ". $row['lname'];
                                    echo "<td style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>". $full_name. "</td>";
                                    echo "<td style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>". $row['department']. "<br>". $row['section']."</td>";
                                    $grade = $row['final_grade'];
                                    $btn_edit = "$i". "_edit";
                                    $btn_save = "$i". "_save";
                                    echo "<td style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'><div class='row'><div class='col-8'><input type='text' class='form-control form-control-sm mb-2 text-center w-100' name='$i' id='$i' value='$grade' disabled></div><div class='col-4'><input type='submit' class='btn btn-primary rounded-pill btn-sm w-100' style='display: none;' id='$btn_save' name='$btn_save' value='Save'><button type='button' class='btn btn-primary rounded-pill btn-sm w-100' onclick='javascript:edit_grade($i)' id='$btn_edit'>Edit</button></div></div></td>";
                                    echo "<td style='border: 2px solid dimgrey; border-collapse: collapse; padding: 15px;'>". $row['status']."</td>";
                                    echo "</tr>";
                                    if(isset($_POST[$btn_save])){
                                        $final_grade = $_POST[$i];
                                        $stud_num = $row['stud_num'];
                                        if($final_grade == 0){
                                            $status = "";
                                        }else{
                                            if($final_grade > 3.0){
                                                $status = "F";
                                            }else{
                                                $status = "P";
                                            }
                                        }
                                        $sql = "UPDATE grade_t SET final_grade = $final_grade, status = '$status' WHERE stud_num = '$stud_num' AND admin_id = '$admin_id'";
                                        if($result = $conn->query($sql)){
                                            echo "<script>alert('Updated Student Table Successfully.'); reload_page();</script>";
                                            $result->free_result();
                                        }
                                    }
                                    $i++;
                                }
                            ?>
                        </table>
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
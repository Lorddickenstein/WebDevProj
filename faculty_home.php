<?php
	session_start();
	require_once 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Polytechnic University of the PUP</title>

        <!-- PHP -->
        <?php
            $admin_id = $_SESSION['admin_id'];
            $password = $_SESSION['password'];

            // retrieve record of admin
            $sql = "SELECT * FROM admin_t WHERE admin_id = '$admin_id' AND password = '$password'";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $fname = $row['fname'];
                $mname = $row['mname'];
                $lname = $row['lname'];
                $address = $row['address'];
                $age = $row['age'];
                $sex = $row['sex'];
                $email = $row['email'];
                $birthday = $row['birthday'];
                $full_name = $fname. " ". $mname[0]. ". ". $lname;
            }else {
                echo "<script>alert('Account does not exists. Try again.');</script>";
            }

            if(isset($_POST['btnSave'])){
                // insert update sql statement here
                $fname = $_POST['fname'];
                $mname = $_POST['mname'];
                $lname = $_POST['lname'];
                $address = $_POST['address'];
                $age = $_POST['age'];
                $sex = ucfirst($_POST['sex']);
                $email = $_POST['email'];
                $birthday = $_POST['birthday'];

                $sql = "UPDATE admin_t SET fname = '$fname', mname = '$mname', lname = '$lname', address = '$address', age = '$age', sex = '$sex', email = '$email', birthday = '$birthday', password = '$password' WHERE admin_id = '$admin_id'";
                if($result = $conn->query($sql)){
                   echo "<script>alert('Updated Admin Table Successfully.');</script>";
                   echo "<script>reload_page()</script>";
                }
            }
		?>

        <!-- JavaScript -->
        <script>
            function hide_view_btn(){
                document.getElementById('div_view_mode').style.display = "none";
                document.getElementById("fname").disabled = false;
                document.getElementById("mname").disabled = false;
                document.getElementById("lname").disabled = false;
                document.getElementById("address").disabled = false;
                document.getElementById("email").disabled = false;
                document.getElementById("sex").disabled = false;
                document.getElementById("birthday").disabled = false;
                document.getElementById("age").disabled = false;
                show_edit_btn();
            }
            function show_edit_btn(){
                document.getElementById('div_edit_mode').style.display = "block";
            }
            function reload_page(){
                location = location;
            }
        </script>

        <!-- CSS -->
        <link href="./css/home.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    </head>
    
    <body>
        <!-- Navigation Bar -->
        <nav class="navbar bg-danger bg-gradient navbar-dark navbar-expand-lg">
            <div class="container">
                <a href="faculty_profile.php" class="navbar-brand fs-3" >
                    <img src="./images/pup_logo.png" alt="" width=45 height="auto" class="d-inline-block align-text-middle"> Polytechnic University of the PUP
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto mb-0 mb-lg-0 fw-bold fs-6">
                        <li class="nav-item" >
                            <a class="nav-link active" href="faculty_home.php" style="text-transform: capitalize;"><?php echo $fname;?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="faculty_studentlist.php">Student List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="faculty_grade.php">Grades</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="faculty_schedule.php">Schedule</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <br><br>
        <div class='div_greetings'>
            <h1><span class="align-middle">Faculty Profile</span></h1>
        </div>
        <br>
        <div class='div_full text-dark'>
        <table id="table_prof">
            <tr>
                <td id='td_image' class="td_border">
                    <img src='./images/user.png' id='image_user'>
                </td>
                <td id='col_info' class="td_border"><br>
                    <div class="container-fluid">
                        <form method="POST">
                            <div class="row mb-2">
                                <div class="col-8">
                                    <div class="row">
                                        <label for="admin_num" class="col-4 col-form-label">Admin Number: </label>
                                        <input type="text" class="form-control form-control-sm w-50 col-8" name="admin_num" id="admin_num" value="<?php echo $admin_id; ?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <label for="fname" class="form-label">First Name: </label>
                                    <input type="text" class="form-control form-control-sm" name="fname" id="fname" value="<?php echo $fname; ?>" required disabled>
                                </div>
                                <div class="col-4">
                                    <label for="mname" class="form-label">Middle Name: </label>
                                    <input type="text" class="form-control form-control-sm" name="mname" id="mname" value="<?php echo $mname; ?>" required disabled>
                                </div>
                                <div class="col-4">
                                    <label for="lname" class="form-label">Last Name: </label>
                                    <input type="text" class="form-control form-control-sm" name="lname" id="lname" value="<?php echo $lname; ?>" required disabled>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <label for="address" class="form-label">Address: </label>
                                    <input type="text" class="form-control form-control-sm" name="address" id="address" value="<?php echo $address; ?>" required disabled>
                                </div>
                                <div class="col-6">
                                    <label for="birthday" class="form-label">Birthday: </label>
                                    <input type="date" class="form-control form-control-sm w-50" min="01-01-1900" max="<?php echo date("m-d-Y"); ?>" name="birthday" id="birthday" value="<?php echo $birthday; ?>" required disabled>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <label for="age" class="col-4 col-form-label">Age: </label>
                                    <input type="number" class="col-8 form-control form-control-sm w-25" name="age" id="age" value="<?php echo $age; ?>" required disabled>
                                </div>
                                <div class="col-4">
                                    <label for="sex" class="col-4 col-form-label">Sex: </label>
                                    <input type="text" class="col-8 form-control form-control-sm w-50" name="sex" id="sex" value="<?php echo $sex; ?>" maxlength="1" size="1" required disabled>
                            </div>
                                <div class="col-4">
                                    <label for="email" class="col-3 col-form-label">Email: </label>
                                    <input type="email" class="col-9 form-control form-control-sm" name="email" id="email" value="<?php echo $email; ?>" required disabled>
                                </div>
                            </div><br>
                            <div class="row mb-2">
                                <div class="row text-end">
                                    <div class="col" id="div_view_mode">
                                        <button type="button" class="btn btn-danger rounded-pill btn-sm" onclick="javascript:hide_view_btn()">Edit Profile</button>
                                    </div>
                                    <div class="col" id="div_edit_mode" style="display: none;">
                                        <button type="button" class="btn btn-danger rounded-pill btn-sm" onclick="javascript:reload_page()">Cancel</button>
                                        <input type="submit" class="btn btn-danger rounded-pill btn-sm" name="btnSave" id="btnSave" value="Save Changes">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </td>
            </tr>
        </table>
        <table class="content">
            <tr>
                <td id='td_feed'>
                    <br><br><br><br><br><br>
                    <h2>This is your news Feed</h2>
                    <p>Content is here</p>
                    <br><br><br><br><br><br>
                </td>
            </tr>
        </table>
        </div>

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
	
			
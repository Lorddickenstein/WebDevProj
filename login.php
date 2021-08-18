<?php 
    session_start();
    require_once 'connection.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Login to PUP</title>

        <!-- PHP -->
        <?php
            $user_type = $_SESSION['user_type'];
            $isExist = 'Yes';

            if(isset($_POST['btnLogin'])){
                if($user_type == 'student'){
                    $stud_num = $_POST['id_num'];
                    $password = $_POST['password'];
                    $sql = "SELECT stud_num, password FROM profile_t WHERE stud_num = '$stud_num' AND password = '$password'";
                    $result = $conn->query($sql);

                    if($result->num_rows > 0){
                        $row = $result->fetch_assoc();
                        $_SESSION['stud_num'] = $row['stud_num'];
                        $_SESSION['password'] = $row['password'];
                        header("location:home.php");
                    }else {
                        $isExist = 'No';
                    }
                }else{
                    $admin_id = $_POST['id_num'];
                    $password = $_POST['password'];
                    $sql = "SELECT admin_id, password FROM admin_t WHERE admin_id = '$admin_id' AND password = '$password'";
                    $result = $conn->query($sql);
                    
                    if($result->num_rows > 0){
                        $row = $result->fetch_assoc();
                        $_SESSION['admin_id'] = $row['admin_id'];
                        $_SESSION['password'] = $row['password'];
                        header("location:faculty_home.php");
                    }else{
                        $isExist = 'No';
                    }
                }
            }
            if($isExist == 'No'){
                echo "<script>alert('Account does not Exist!')</script>";
            }
        ?>

        <!-- CSS -->
        <link href="./css/login.css" rel="stylesheet" type="text/css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    </head>

    <body>
        <!-- Navigation Bar -->
        <nav class="navbar bg-danger bg-gradient navbar-dark navbar-expand-lg">
            <div class="container font-Poppins">
                <a href="login.php" class="navbar-brand fs-3" >
                    <img src="./images/pup_logo.png" alt="" width=45 height="auto" class="d-inline-block align-text-middle"> Polytechnic University of the PUP
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto mb-0 mb-lg-0 fw-bold fs-6">
                        <?php 
                            if($user_type == 'student'){
                                echo "<li class='nav-item'><a class='nav-link' href='signup.php'>Sign Up</a></li>";
                            }
                        ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="login.php">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav><br><br>

        <!-- Form -->     
        <div class="container">
            <div class="row">
                <div class="col-4"></div>
                <div class="col-4 font-Poppins fw-bold">
                    <Form method="POST">
                        <div class="mb-3 mt-3 ms-3 me-3">
                            <label for="id_num" class="form-label"><?php if($user_type == 'student') echo "Student Number: "; else echo "Admin Number: " ?></label>
                            <input type="text" class="form-control form-control-sm" id="id_num" name="id_num" maxlength="15" size="15" placeholder="<?php if($user_type=='student') echo "Enter Student Number"; else echo "Enter Admin Number"; ?>" maxlength="15" size="15" required>
                        </div>
                        <div class="mb-3 mt-3 ms-3 me-3">
                            <label for="password" class="form-label">Password here pls</label>
                            <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Enter Password" maxlength="50" size="50" required>
                        </div>
                        <div class="d-grid mb-3 mt-3 ms-3 me-3">
                            <input type="submit" class="btn btn-primary fw-bold" name="btnLogin" value="Log In">
                        </div>
                        <div class="ms-3 me-3 text-center">
                            <a href="#" class="text-decoration-none fw-normal">Forgot Password?</a>
                            <hr/>
                        </div>
                        <div class='mb-3 mt-6 ms-3 me-3 text-center'>
                        <?php
                            if($user_type == "student"){
                                echo "<a href='signup.php' class='btn btn-success btn-lg fw-bold'>Create an Account</a>";
                            }else{
                                echo "<a href='index.php' class='btn btn-success btn-lg fw-bold'>Not an Admin?</a>";
                            }
                        ?>
                        </div>
                    </Form>
                </div>
                <div class="col-4"></div>
            </div>
            
        </div>

        <!-- Footer -->
        <br><br>
        <footer class="bg-dark bg-gradient">
            <div class="container">
                <br>                    
                    <nav class="text-light text-center font-Poppins">
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

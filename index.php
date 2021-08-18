<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Polytechnic University of the PUP</title>

        <!-- PHP -->
        <?php 
            if(isset($_POST['btnStudent'])){
                $_SESSION['user_type'] = "student";
                header("location:login.php");
            }
            if(isset($_POST['btnAdmin'])){
                $_SESSION['user_type'] = "admin";
                header("location:login.php");
            }
        ?>

        <!-- CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
            form{
                border: 3px solid #f1f1f1;
                background-color: white;
                border-radius: 5px;
            }
            .font-Poppins{
                font-family: 'Poppins', sans-serif
            }
        </style>
    </head>

    <body style="background-image: url('./images/pup_campus.jpg'); text-align : center; background-size: 100%; background-attachment: fixed; background-position: center;"><br><br>
        <!-- Form -->
        <div class="container">
            <div class="row mt-5 mb-5">
                <div class="col-3"></div>
                <div class="col-6 font-Poppins">
                    <Form method="POST">
                        <div class="text-center mt-3 mb-3">
                            <div class="mb-3">
                                <img src="./images/pup_logo.png" alt="" width=100 height="auto">
                            </div>
                            <div>
                                <p class="fs-1">Welcome to the <b>Polytechnic University<br>of the PUP!</b></p>
                                <p>Enter what type of user you are.</p>
                            </div>
                        </div>
                        <div class="text-center ms-5 me-5">
                            <div class="d-grid mb-3 mt-3 ms-3 me-3 fw-bold">
                                <input type="submit" class="btn btn-primary fw-bold" name="btnStudent" value="Student">
                            </div>
                            <div class="d-grid mb-3 mt-3 ms-3 me-3 fw-bold">
                                <input type="submit" class="btn btn-danger btn-block fw-bold" name="btnAdmin" value="Admin">
                            </div>
                        </div>
                        <div class="text-center ms-3 me-3">
                            <div class="mt-5">
                                <p class="ms-3 me-3">By using this service, you understood and agree to the PUP Online Services <a href="https://www.pup.edu.ph/terms/" class="text-decoration-none fw-normal">Terms of Use</a> and <a href="https://www.pup.edu.ph/privacy/" class="text-decoration-none fw-normal">Privacy Statement</a>.</p>
                            </div>
                        </div><br><br>
                    </Form>
                </div>
                <div class="col-3"></div>
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
<?php 
    session_start();
    require_once 'connection.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Create an Account</title>
        
        <!-- CSS -->
        <link rel="stylesheet" type='text/css' href="./css/index.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

        <!-- JavaScript -->
        <script>
          function check_pass(){
            var pass = document.getElementById('pass').value;
            var conf = document.getElementById('confirmpass').value;

            if(pass !== conf){
              alert('Passwords do not match.');
              return false;
            }
            return true;
          }

          function change_display(mode){
            document.getElementById('gender').style.display=mode;
            document.getElementById('gender').value="";
            document.getElementById('gender').focus();
            document.getElementById('gender').select();
          }
        </script>
        <?php
          if(isset($_POST['btnSubmit'])){
            $fname = $_POST['fname'];
            $mname = $_POST['mname'];
            $lname = $_POST['lname'];
            $address = $_POST['address'];
            $age = $_POST['age'];
            $sex = $_POST['sex'];
            if($sex == 'Others'){
              $sex = $_POST['gender'];
            }
            $email = $_POST['email'];
            $birth = $_POST['birth'];
            $section = $_POST['section'];
            $department = $_POST['department'];
            $stud_num = $_POST['stud_num'];
            $password = $_POST['password'];
            $sql = "SELECT stud_num, password FROM profile_t WHERE stud_num = '$stud_num' AND password = '$password'";
            $result = $conn->query($sql);
            if(!($result->num_rows > 0)){
              $_SESSION['stud_num'] = $_POST['stud_num'];
              $_SESSION['password'] = $_POST['password'];
              $sql = "INSERT INTO profile_t(stud_num, fname, mname, lname, address, age, sex, email, birthday, password) VALUES('$stud_num', '$fname', '$mname', '$lname', '$address', $age, '$sex', '$email', '$birth', '$password')";
              
              if($conn->query($sql) == TRUE){
                $sql = "INSERT INTO student_t(stud_num, section, department) VALUES ('$stud_num', '$section', '$department')";
                echo $sql;
                if($conn->query($sql)){
                  header("location:home.php");
                }
              }
              else{
                echo "<script>alert('Error Registering.')</script>";
              }
            }else{
              echo "<script>alert('Account already exist!')</script>";
            }
          }
        ?>

    </head>

    <body>
        <!-- Navigation Bar -->
        <nav class="navbar bg-danger bg-gradient navbar-dark navbar-expand-lg">
            <div class="container">
                <a href="signup.php" class="navbar-brand fs-3" >
                    <img src="./images/pup_logo.png" alt="" width=45 height="auto" class="d-inline-block align-text-middle"> Polytechnic University of the PUP
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto mb-0 mb-lg-0 fw-bold fs-6">
                        <li class="nav-item">
                            <a class="nav-link active" href="signup.php">Sign Up</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav><br><br>

        <!-- Form -->
        <form method='POST' onsubmit='return check_pass()'>
          <h1 class='create'>Create an Account<hr/></h1>
          <p><span class='error'>*required field</span></p>
          <div>
              <label for='fname'>First Name: </label><span class='error'> *</span>
              <input type=text id='fname' name='fname' placeholder='Enter First Name' maxlength="50" size="50" required><br>
          </div><br>
          <div>
            <label for='mname'>Middle Name: </label><span class='error'> *</span>
            <input type=text id='mname' name='mname' placeholder='Enter Middle Name' maxlength="50" size="50" required><br>
          </div><br>
          <div>
            <label for='lname'>Last Name: </label><span class='error'> *</span>
            <input type=text id='lname' name='lname' placeholder='Enter Last Name' maxlength="50" size="50" required><br>
          </div><br>
            <div>
              <label for='address'>Address: </label><span class='error'> *</span>
              <input type='text' id='address' name='address' placeholder='Enter Address' maxlength="120" size="120" required>
            </div><br>
            <div>
              <label for='age'>Age: </label>
              <input type='number' id='age' name='age' min=0 max=200 required>
            </div><br>
            <div>
              <label>Sex:</label><br><br>
              <input type='radio' id='male' name='sex' value='Male' onclick="javascript:change_display('none')" maxlength="15" size="15">
              <label for='male' class='sex'>Male</label><br><br>
              <input type='radio' id='female' name='sex' value='Female' maxlength="15" size="15" onclick="javascript:change_display('none')">
              <label for='female' class='sex'>Female</label><br><br>
              <input type='radio' id='others' name='sex' value='Others' maxlength="15" size="15" onclick="javascript:change_display('block')">
              <label for='others' class='sex'>Others</label>
              <input type='text' style='display: none' id='gender' name='gender' maxlength="15" size="15" placeholder='Please specify...'>
            </div><br>
            <div>
              <label for='email'>Email: </label>
              <input type='email' id='email' name='email' placeholder='@example.com' maxlength="120" size="120">
              </div><br>
            <div>
              <label for='birth'>Birthday: </label>
              <input type="date" id="birth" name="birth" min="1900-01-01" max="<?php echo date("Y-m-d"); ?>">
            </div><br>
            <div>
              <label for='stud_num'>Student Number: </label><span class='error'> *</span>
              <input type='text' id='stud_num' name='stud_num' placeholder='Enter Student Number' maxlength="15" size="15" required>
            </div><br>
            <div>
              <label for='section'>Program and Section: </label><span class='error'> *</span>
              <div class="row gx-1 justify-content-evenly">
                  <div class="col-md-6">
                      <div class="h-100 d-inline-flex flex-column justify-content-center">
                          <select name="section" class="form-select form-select-lg w-25 t-5" aria-label=".form-select-lg example" id="section" required>
                              <option value="3-1">3-1</option>
                              <option value="3-2">3-2</option>
                              <option value="3-3">3-3</option>
                              <option value="3-4">3-4</option>
                              <option value="3-1N">3-1N</option>
                              <option value="3P">3P</option>
                          </select>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="h-100 d-inline-flex flex-column justify-content-start">
                          <select name="department" class="form-select form-select-lg w-25 t-5" aria-label=".form-select-lg example" id="department" required>
                              <option value="BSCS">BSCS</option>
                              <option value="BSIT">BSIT</option>
                          </select>
                      </div>
                  </div>
              </div>
            </div><br>
            <div>
              <label for='passwor'>Password: </label><span class='error'> *</span>
              <input type='password' id='pass' name='password' placeholder='Enter Password' maxlength="50" size="50" required>
            </div><br>
            <div>
              <label for='confirmpass'>Confirm Password: </label><span class='error'> *</span>
              <input type='password' id='confirmpass' name='confirmpass' placeholder='Repeat Password' maxlength="50" size="50" required>
            </div><br>
              <input type='reset' name='btnReset' value='Reset'>
              <input type='submit' name='btnSubmit' value='Submit'>
              <br><br>
          </form>

        

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
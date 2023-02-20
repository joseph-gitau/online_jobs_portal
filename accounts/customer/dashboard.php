<?php
$path_old =  dirname(__FILE__);
$path2 = str_replace("\\", "/", $path_old);
$path3 = str_replace($_SERVER['DOCUMENT_ROOT'], "", $path2);
// remove accounts/customer from path
$path = str_replace("accounts/customer", "", $path3);
echo $path;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicon -->
    <link rel="shortcut icon" href="<?php echo $path; ?>/resources\images\default_profile.jpg" type="image/x-icon">
    <!-- js -->
    <script src="<?php echo $path; ?>/js/index.js"></script>
    <!-- font awesome -->
    <link rel="stylesheet" href="<?php echo $path; ?>/resources\libraries\fontawesome-free-5.15.4-web\css\all.min.css" />

    <!-- choosen -->
    <link rel="stylesheet" href="<?php echo $path; ?>/resources\libraries\chosen_v1.8.7_2\docsupport\style.css">
    <link rel="stylesheet" href="<?php echo $path; ?>/resources\libraries\chosen_v1.8.7_2\chosen.css">
    <!-- css -->
    <link rel="stylesheet" href="<?php echo $path; ?>/css/style.css?v=<?php echo rand(); ?>">
    <!-- jquery -->
    <script src="<?php echo $path; ?>/js/jquery.js"></script>
    <script src="<?php echo $path; ?>/resources\libraries\chosen_v1.8.7_2\chosen.jquery.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.chosen-select').chosen();
        });
    </script>

    <title>Online jobs portal</title>
</head>

<body>
    <div class="container">
        <header>
            <nav>
                <!-- logo -->
                <div class="logo">
                    <a href="index.php">Online jobs portal</a>
                </div>
                <!-- search -->
                <div class="search">
                    <form action="search.php" method="GET">
                        <input type="text" name="search" placeholder="Search a job or a talent">
                        <button type="submit">Search</button>
                    </form>
                </div>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="jobseeker/login.php">Job seekers</a></li>
                    <li><a href="employer/login.php">Employers</a></li>
                    <li><a href="auth/register.php">Register</a></li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </nav>
        </header>
        <!-- nw -->
        <div class="main">
            <div class="main-left">
                <span class="gradient-text">Find your dream job</span>
                <p class="slack">Search for jobs, post your resume, find career advice and research local employers.</p>
                <a class="btn" href="register.php">Register</a>
                <!-- quick search for job-seekers and employers -->

                <!-- find talent/job -->
                <div class="filter-search">
                    <form action="search.php" method="GET">
                        <!-- talent/job select -->
                        <select name="type" id="type" class="chosen-select">
                            <option value="" selected disabled>Select a talent/job</option>
                            <option value="talent">Find talent</option>
                            <option value="job">Find job</option>
                        </select>
                        <!-- location selector-->
                        <select name="location" id="location" class="chosen-select">
                            <option value="" selected disabled>Select location</option>
                            <option value="nairobi">Nairobi</option>
                            <option value="mombasa">Mombasa</option>
                            <option value="kisumu">Kisumu</option>
                            <option value="eldoret">Eldoret</option>
                            <option value="nakuru">Nakuru</option>
                            <option value="kakamega">Kakamega</option>
                        </select>
                        <!-- search button -->
                        <button type="submit">Search</button>
                    </form>
                    <!-- <select data-placeholder="Choose a Country..." class="chosen-select" multiple tabindex="4">
                            <option value=""></option>
                            <option value="101">India</option>
                            <option value="102">Singapore</option>
                            <option value="103">Srilanka</option>
                        </select> -->
                </div>
                <!-- employers section -->
                <div class="employers">
                    <span class="gradient-text">Featured employers</span>
                    <div class="employers-list">
                        <div class="employer">
                            <img src="resources/images/employer1.png" alt="employer_img">
                            <h3>Company name</h3>
                            <p>Company description <i class="fas fa-users"></i></p>
                        </div>
                        <div class="employer">
                            <img src="resources/images/employer2.png" alt="employer_img">
                            <h3>Company name</h3>
                            <p>Company description</p>
                        </div>
                        <div class="employer">
                            <img src="resources/images/employer3.png" alt="employer_img">
                            <h3>Company name</h3>
                            <p>Company description</p>
                        </div>
                        <div class="employer">
                            <img src="resources/images/employer4.png" alt="employer_img">
                            <h3>Company name</h3>
                            <p>Company description</p>
                        </div>
                        <div class="employer">
                            <img src="resources/images/employer5.png" alt="employer_img">
                            <h3>Company name</h3>
                            <p>Company description</p>
                        </div>
                        <div class="employer">
                            <img src="resources/images/employer6.png" alt="employer_img">
                            <h3>Company name</h3>
                            <p>Company description</p>
                        </div>
                    </div>
                </div>
                <!-- nw -->
            </div>
        </div>
    </div>
</body>

</html>
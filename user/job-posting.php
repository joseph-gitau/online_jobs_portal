<?php
// if session is not started, start it

if (!isset($_SESSION)) {
    session_start();
}
// if $_SESSION['id'] and $_SESSION['username] is not set then redirect to login page with the page as referer page
if (!isset($_SESSION['user_id']) && !isset($_SESSION['username'])) {
    $_SESSION['referer_page'] = $_SERVER['REQUEST_URI'];
    header("Location: ../auth/login.php");
} else {
    $user_type = $_SESSION['user_type'];
    $user_id = $_SESSION['user_id'];
    /* echo $user_type;
    echo $user_id; */
}

?>
<!DOCTYPE html>
<html>

<head>
    <?php
    // include header_links.php
    include '../partials/header_links.php';
    ?>
    <title>online jobs portal - Profile</title>

</head>

<body>
    <header>
        <?php
        // include header.php
        include '../partials/header.php';
        ?>
    </header>
    <div class="container" id="container">
        <!-- list all job-postings -->
        <div class="jobs">
            <div class="header">
                <h2>Job postings</h2>
            </div>
            <!-- add new job btn -->
            <div class="add-new">
                <a href="#job-post" rel="modal:open" class="btn">Add new job</a>
            </div>
            <?php
            include '../dbh.php';
            $sql = "SELECT * FROM job_post WHERE u_id = $user_id and jp_status = 'active'";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            if ($resultCheck > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $attachment = $row['jp_image'];
                    echo '
                    <div class="card">
                        <div class="card-header">
                            <h3>' . $row['jp_title'] . '</h3>
                            <p class="txt-desc">' . $row['jp_description'] . '</p>
                        </div>
                        <div class="card-body">
                            <div class="card-body-left">
                                <p>' . $row['jp_type'] . '</p>
                                <p>' . $row['jp_category'] . '</p>
                                <p>' . $row['jp_location'] . '</p>
                                <p>' . $row['jp_salary'] . '</p>
                            </div>
                        </div>
                        <div class="attachments">
                            <h3>Attachments</h3>';
                    if ($attachment != '') {
                        echo '
                        <ul>
                            <li><a href="../resources/jobps/' . $attachment . '" target="_blank">' . $attachment . '</a></li>
                        </ul>
                        ';
                    } else {
                        echo '
                        <p>No attachments</p>
                        
                        ';
                    }

                    echo '</div> 
                        <div class="card-footer">
                            <a href="#" class="btn"><i class="fas fa-edit"></i> Edit</a>
                            <a href="#" class="delete-posting btn btn-danger" id="' . $row['jp_id'] . '"><i class="fas fa-trash"></i> Delete</a>
                        </div>
                    </div>
                    ';
                }
            }
            ?>
            <!-- job card -->
            <!-- <div class="card">
                <div class="card-header">
                    <h3>Laravel developer needed</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Et, accusantium!</p>
                </div>
                <div class="card-body">
                    <div class="card-body-left">
                        <p>Remote</p>
                        <p>PHP</p>
                        <p>Nairobi, kenya</p>
                        <p>Ksh 1,000</p>
                    </div>

                </div>
                <div class="attachments">
                    <h3>Attachments</h3>
                    <ul>
                        <li><a href="#">job-description.pdf</a></li>
                        <li><a href="#">job-description.pdf</a></li>
                        <li><a href="#">job-description.pdf</a></li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="#" class="btn"><i class="fas fa-edit"></i> Edit</a>
                    <a href="#" class="btn"><i class="fas fa-trash"></i> Delete</a>
                </div>
            </div> -->
        </div>
        <!-- nw -->
        <div class="modal" id="job-post">
            <form action="../reg_exe.php" method="POST" enctype="multipart/form-data">
                <h2>Add a new job listing</h2>
                <!-- job title -->
                <div class="form-control">
                    <label for="job-title">Job title</label>
                    <input type="text" name="job-title" id="job-title" placeholder="Job title">
                </div>
                <!-- job description -->
                <div class="form-control">
                    <label for="job-description">Job description</label>
                    <textarea name="job-description" id="job-description" cols="30" rows="10" placeholder="Job description"></textarea>
                </div>
                <!-- job type -->
                <div class="form-control">
                    <label for="job-type">Job type</label>
                    <select name="job-type" id="job-type" class="chosen-select">
                        <option value="full-time">Full time</option>
                        <option value="part-time">Part time</option>
                        <option value="remote">Remote</option>
                    </select>
                </div>
                <!-- job category -->
                <div class="form-control">
                    <label for="job-category">Job category</label>
                    <select name="job-category" id="job-category" class="chosen-select">
                        <option value="php">PHP</option>
                        <option value="javascript">Javascript</option>
                        <option value="python">Python</option>
                        <option value="java">Java</option>
                        <option value="c#">C#</option>
                        <option value="c++">C++</option>
                        <option value="c">C</option>
                        <option value="ruby">Ruby</option>
                        <option value="go">Go</option>
                        <option value="swift">Swift</option>
                        <option value="kotlin">Kotlin</option>
                        <option value="scala">Scala</option>
                        <option value="rust">Rust</option>
                        <option value="dart">Dart</option>
                        <option value="perl">Perl</option>
                        <option value="haskell">Haskell</option>
                        <option value="lua">Lua</option>
                        <option value="erlang">Erlang</option>
                        <option value="clojure">Clojure</option>
                        <option value="elixir">Elixir</option>
                        <option value="f#">F#</option>
                        <option value="r">R</option>
                        <option value="objective-c">Objective-C</option>
                        <option value="assembly">Assembly</option>
                        <option value="cobol">Cobol</option>
                        <option value="fortran">Fortran</option>
                        <option value="pascal">Pascal</option>
                        <option value="prolog">Prolog</option>
                        <option value="lisp">Lisp</option>
                        <option value="visual-basic">Visual Basic</option>
                        <option value="matlab">Matlab</option>
                        <option value="delphi">Delphi</option>
                        <option value="apl">APL</option>
                        <option value="scratch">Scratch</option>
                        <option value="html">HTML</option>
                        <option value="css">CSS</option>
                        <option value="sql">SQL</option>
                        <option value="no-sql">No-SQL</option>
                        <option value="bash">Bash</option>
                        <option value="powershell">Powershell</option>
                    </select>
                </div>
                <!-- job location -->
                <div class="form-control">
                    <label for="job-location">Job location</label>
                    <input type="text" name="job-location" id="job-location" placeholder="Job location">
                </div>
                <!-- job salary -->
                <div class="form-control">
                    <label for="job-salary">Job salary</label>
                    <input type="text" name="job-salary" id="job-salary" placeholder="Job salary">
                </div>
                <!-- any attachments -->
                <div class="form-control">
                    <label for="job-attachment">Any attachments</label>
                    <input type="file" name="job-attachment" id="job-attachment">
                </div>

                <div class="form-control">
                    <input type="submit" value="Add job" class="btn" id="add-jobps">
                </div>
            </form>

        </div>
        <!-- nw -->
        <!-- edit post modal -->

    </div>
    <!-- nw -->
    <!-- Modal HTML embedded directly into document -->
    <div id="ex1" class="modal">
        <p>Thanks for clicking. That felt good.</p>
        <a href="#" rel="modal:close">Close</a>
    </div>

    <?php
    // include footer_scripts.php
    include '../partials/footer_scripts.php';
    ?>
</body>

</html>
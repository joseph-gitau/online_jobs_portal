<?php
$path_old =  dirname(__FILE__);
$path2 = str_replace("\\", "/", $path_old);
$path3 = str_replace($_SERVER['DOCUMENT_ROOT'], "", $path2);
// replace partials with empty string
$path = str_replace("partials", "", $path3);
// echo $path;
?>

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- favicon -->
<link rel="shortcut icon" href="../resources/images/default_profile.jpg" type="image/x-icon">

<!-- choosen -->
<link rel="stylesheet" href="../resources\libraries\chosen_v1.8.7_2\docsupport\style.css">
<link rel="stylesheet" href="../resources\libraries\chosen_v1.8.7_2\chosen.css">
<!-- jquery -->
<script src="../js/jquery.js"></script>
<script src="../resources\libraries\chosen_v1.8.7_2\chosen.jquery.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css?v<?php echo rand(); ?>">
<!-- sweetalert -->
<script src="../js/sweetalert.min.js"></script>
<!-- waitme -->
<link rel="stylesheet" href="../Resources/libraries/Animations-waitMe/waitMe.css">
<!-- jquery.modal.min.js -->
<script src="../js/jquery.modal.min.js"></script>
<!-- jquery.modal.min.css -->
<link rel="stylesheet" href="../css/jquery.modal.min.css" />
<!-- font awesome -->
<link rel="stylesheet" href="../Resources\fontawesome-free-5.15.4-web\css\all.min.css" />
<script type="text/javascript">
    $(document).ready(function() {
        $('.chosen-select').chosen();
    });
</script>
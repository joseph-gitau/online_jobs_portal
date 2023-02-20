$(document).ready(function () {

    var current_effect = 'roundBounce';
    $('#register_user').click(function () {
        console.log("register_user");
        event.preventDefault();
        run_waitMe(current_effect);

        // make ajax call to register user
        var form = $('#register_form');
        $.ajax({
            url: '../reg_exe.php',
            type: 'POST',
            data: {
                register_user: true,
                name: $('#name').val(),
                username: $('#username').val(),
                email: $('#email').val(),
                password_1: $('#password_1').val(),
                password_2: $('#password_2').val(),
                phone: $('#phone').val(),
                role: $('#role').val()
            },
            success: function (data) {
                $('#container').waitMe('hide');
                if (data == "success") {
                    // swal success
                    swal({
                        title: "Success",
                        text: "You have been registered successfully",
                        icon: "success",
                        button: "OK",
                    }).then(function () {
                        window.location = "../user/dashboard.php";
                    });
                    // reset form
                    form[0].reset();
                } else {
                    console.log(data);
                    // swal error
                    swal("Error", data, "error", {
                        button: "OK",
                    });
                }

            }

        });
    });
    function run_waitMe(effect) {
        $('#container').waitMe({

            //none, rotateplane, stretch, orbit, roundBounce, win8, 
            //win8_linear, ios, facebook, rotation, timer, pulse, 
            //progressBar, bouncePulse or img
            effect: 'roundBounce',

            //place text under the effect (string).
            text: 'please wait...',

            //background for container (string).
            bg: 'rgba(255,255,255,0.7)',

            //color for background animation and text (string).
            color: '#000',

            //max size
            maxSize: '',

            //wait time im ms to close
            waitTime: -1,

            //url to image
            source: '',

            //or 'horizontal'
            textPos: 'vertical',

            //font size
            fontSize: '',

            // callback
            onClose: function () { }

        });
    }
});

function run_waitMe(effect) {
    $('#container').waitMe({

        //none, rotateplane, stretch, orbit, roundBounce, win8, 
        //win8_linear, ios, facebook, rotation, timer, pulse, 
        //progressBar, bouncePulse or img
        effect: 'roundBounce',

        //place text under the effect (string).
        text: 'please wait...',

        //background for container (string).
        bg: 'rgba(255,255,255,0.7)',

        //color for background animation and text (string).
        color: '#000',

        //max size
        maxSize: '',

        //wait time im ms to close
        waitTime: -1,

        //url to image
        source: '',

        //or 'horizontal'
        textPos: 'vertical',

        //font size
        fontSize: '',

        // callback
        onClose: function () { }

    });
}
// edit_profile_pic preview
function showPreview(event) {
    if (event.target.files.length > 0) {
        var src = URL.createObjectURL(event.target.files[0]);
        var preview = document.getElementById("profile_pic_preview");
        preview.src = src;
        preview.style.display = "block";
    }
}
// update_details
$("#update_details").click(function () {
    event.preventDefault();
    run_waitMe();
    var file = $('#image')[0].files[0];
    if (file == undefined) {
        file = "";
    }
    $.ajax({
        url: '../reg_exe.php',
        type: 'POST',
        data: {
            update_details: true,
            name: $('#name').val(),
            username: $('#username').val(),
            email: $('#email').val(),
            phone: $('#phone').val(),
            county: $('#county').val(),
            address: $('#address').val(),
            gender: $('#gender').val(),
            m_status: $('#marital_status').val(),
            dob: $('#dob').val(),
            // image: $('#image').val(),
            file: file,
            password: $('#password').val()
        },
        success: function (data) {
            $('#container').waitMe('hide');
            if (data == "success") {
                // swal success
                swal({
                    title: "Success",
                    text: "Details updated successfully",
                    icon: "success",
                    button: "OK",
                }).then(function () {
                    // reload page
                    location.reload();
                });
            } else {
                console.log(data);
                // swal error
                swal("Error", data, "error", {
                    button: "OK",
                });
            }

        }

    });
});
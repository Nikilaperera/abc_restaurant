<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CodeIgniter Form with Bootstrap and AJAX</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5 col-md-8 col-md-offset-2">
    <h4 style="text-align: center">--Myabc_restaurant CREATE AN ACCOUNT--</h4><br><br><br>
    <form id="searchForm">
        <div class="form-group row">
            <div class="col-md-3" style="display:inline-block">
                <label for="name">MEMBER ID / NIC:</label>
            </div>
            <div class="col-md-7" style="display:inline-block">
                <input type="text" class="form-control" id="identity" name="identity" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-primary" onclick="searchInfo()">Submit</button>
            </div>
        </div>

    </form>

    <div id="responseMessage" class="mt-3"></div>
    <form id="submitForm" style="display: none">
        <div class="form-group">
            <div class="col-md-6 row">
<!--                <label for="name">NIC:</label>-->
                <input type="hidden" id="member_id" name="member_id">
                <input type="text" class="form-control" id="nic" name="nic" required hidden>
            </div>
            <div class="col-md-6 row">
                <label for="name">EMAIL:</label>
                <input type="text" class="form-control" id="email" name="email" required>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary" onclick="submitForm()" id="createBtn">Create an Account</button>
                </div>
                <div class="col-md-6">
                    <button type="button" class="btn btn-danger" onclick="resetPassword()" id="resetBtn">Reset Password</button>
                </div>
            </div>
        </div>
    </form>
    <div id="responseMessageSuccess" class="mt-3"></div>
</div>

<!-- Include jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function searchInfo() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('auth/MemberToRegister/search_student_info'); ?>",
            data: $('#searchForm').serialize(),
            dataType: "json",
            success: function(response) {

                if(response.status == true){
                    $("#submitForm").show();

                    $('#responseMessage').html('' +
                        '<div class="alert alert-success">' +
                        '<li>Title : ' + response.data.title + '</li>' +
                        '<li>Name : ' + response.data.full_name + '</li>' +
                        '<li>NIC : ' + response.data.nic + '</li>' +
                        '<li>Email : ' + response.data.email + '</li>' +
                        '<li>Mobile : ' + response.data.mobile + '</li>' +
                        '</div>');

                    $("#member_id").val(response.data.member_id);
                    $("#nic").val(response.data.nic);
                    $("#email").val(response.data.email);
                    $("#mobile").val(response.data.mobile);

                }
                else{
                    $("#submitForm").hide();

                    $('#responseMessage').html('' +
                        '<div class="alert alert-danger">' +
                        '<li>' + response.data + '</li>' +
                        '</div>');
                }

            },
            error: function(response) {
                $('#responseMessage').html('<div class="alert alert-danger">Error !</div>');
            }
        });
    }

    function submitForm() {
        $("#createBtn").prop("disabled", true);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('auth/MemberToRegister/create_student_account'); ?>",
            data: $('#submitForm').serialize(),
            dataType: "json",
            success: function(response) {

                if(response.status == false){

                    $('#responseMessageSuccess').html('' +
                        '<div class="alert alert-danger">' +
                        '<li>' + response.message + '</li>' +
                        '</div>');
                }
                else{

                    $('#responseMessageSuccess').html('' +
                        '<div class="alert alert-success">' +
                        '<li>' + response + '</li>' +
                        '</div>');
                    setTimeout(function(){
                        window.location.reload();
                    }, 3000);
                }

            },
            error: function(response) {
                $('#responseMessageSuccess').html('<div class="alert alert-danger">Error !</div>');
            }
        });
    }

    function resetPassword() {
        $("#resetBtn").prop("disabled", true);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('auth/MemberToRegister/reset_student_account'); ?>",
            data: $('#submitForm').serialize(),
            dataType: "json",
            success: function(response) {

                if(response.status == false){

                    $('#responseMessageSuccess').html('' +
                        '<div class="alert alert-danger">' +
                        '<li>' + response.message + '</li>' +
                        '</div>');
                }
                else{

                    $('#responseMessageSuccess').html('' +
                        '<div class="alert alert-success">' +
                        '<li>' + response + '</li>' +
                        '</div>');
                    setTimeout(function(){
                        window.location.reload();
                    }, 3000);
                }

            },
            error: function(response) {
                $('#responseMessageSuccess').html('<div class="alert alert-danger">Error !</div>');
            }
        });
    }
</script>

</body>
</html>

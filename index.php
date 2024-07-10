<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <title>PHP AJAX CRUD</title>
</head>
<body>
   <div class="container">

        <div class="d-flex justify-content-end mt-5">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary mt-4 mb-2" data-toggle="modal" data-target="#myModal">
                Add User
            </button>
        </div>
        <div id="records_contant"></div>

        <!-- Success and Error message divs -->
        <div id="success-message" class="alert alert-success d-none"></div>
        <div id="error-message" class="alert alert-danger d-none"></div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Enter your details here:</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>First Name:</label>
                            <input type="text" id="firstname" class="form-control" placeholder="Enter your first name here">
                        </div>
                        <div class="form-group">
                            <label>Last Name:</label>
                            <input type="text" id="lastname" class="form-control" placeholder="Enter your last name here">
                        </div>
                        <div class="form-group">
                            <label>Email Id:</label>
                            <input type="email" id="email" class="form-control" placeholder="Enter your email id here">
                        </div>
                        <div class="form-group">
                            <label>Contact Number:</label>
                            <input type="number" id="mobile" class="form-control" placeholder="Enter your contact number here">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="addRecord()">Save</button>
                    </div>
                </div>
            </div>
        </div>


<!-- Update Modal -->
<div class="modal fade" id="update_user_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Enter your details here:</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>First Name:</label>
                            <input type="text" id="update_firstname" class="form-control" placeholder="Enter your first name here">
                        </div>
                        <div class="form-group">
                            <label>Last Name:</label>
                            <input type="text" id="update_lastname" class="form-control" placeholder="Enter your last name here">
                        </div>
                        <div class="form-group">
                            <label>Email Id:</label>
                            <input type="email" id="update_email" class="form-control" placeholder="Enter your email id here">
                        </div>
                        <div class="form-group">
                            <label>Contact Number:</label>
                            <input type="number" id="update_mobile" class="form-control" placeholder="Enter your contact number here">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="updateuserdetail()">Save</button>
                        <input type ="hidden" name ="" id ="hidden_user_id">
                    </div>
                </div>
            </div>
        </div>
        
   </div>

    <!-- jQuery library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery from here -->
    <script type="text/javascript">
        // to load a table at very first at the time of refresh 
        $(document).ready(function(){
            readRecords();
        });

        // function to get the data and show on a table
        function readRecords(){
            var readrecord = "readrecord";
            $.ajax({
                url : "backend1.php",
                type :"post",
                data:{ readrecord:readrecord},
                success:function(data,status){
                    $('#records_contant').html(data);
                }
            });
        }

        // function to add or insert the data in a database table
        function addRecord(){
            var firstname = $('#firstname').val();
            var lastname = $('#lastname').val();
            var email = $('#email').val();
            var mobile = $('#mobile').val();

            // Clear previous error and success messages
            $('#error-message').text('').addClass('d-none');
            $('#success-message').text('').addClass('d-none');

            // Validate fields
            if (firstname === "" || lastname === "" || email === "" || mobile === "") {
                $('#error-message').text('All fields are required').removeClass('d-none');
                return;
            }

            // AJAX from here
            $.ajax({
                url: "backend1.php",
                type: 'POST',
                data: {
                    firstname: firstname,
                    lastname: lastname,
                    email: email,
                    mobile: mobile
                },
                success: function(data, status){
                    console.log("Data: " + data + "\nStatus: " + status);
                    if (data.trim() === "Record added successfully") {
                        $('#success-message').text('Record added successfully').removeClass('d-none');
                        // Clear form fields
                        $('#firstname').val('');
                        $('#lastname').val('');
                        $('#email').val('');
                        $('#mobile').val('');
                        // Close modal
                        $('#myModal').modal('hide');
                    } else {
                        $('#error-message').text(data).removeClass('d-none');
                    }
                    // Refresh or update records (if you have a function to do this)
                    readRecords();
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + error);
                    $('#error-message').text('An error occurred while adding the record').removeClass('d-none');
                }
            });
        }
        //function to delete data from table 
        function DeleteUser(deleteid){
            var conf = confirm("Are you sure want to delete the data?");
            if(conf == true){
                $.ajax({
                    url : "backend1.php",
                    type : "post",
                    data :{ deleteid : deleteid},
                    success:function(data ,status){
                        readRecords();
                    }
                });
            }
        }
        //function to update or edit data 
        function GetUserDetails(id){
            $('#hidden_user_id').val(id);
            $.post("backend1.php",{
                    id : id
            }, function(data,status){
                var user = JSON.parse(data);
                $('#update_firstname').val(user.firstname);
                $('#update_lastname').val(user.lastname);
                $('#update_email').val(user.email);
                $('#update_mobile').val(user.mobile);
            }

            );
        $('#update_user_modal').modal("show");
        }
        //to update the data and insert it into database 
        function updateuserdetail(){
            var firstnameupd = $('#update_firstname').val();
            var lastnameupd = $('#update_lastname').val();
            var emailupd = $('#update_email').val();
            var mobileupd = $('#update_mobile').val();
            var hidden_user_idupd = $('#hidden_user_id').val();

            $.post("backend1.php",{
                hidden_user_idupd : hidden_user_idupd,
                firstnameupd : firstnameupd,
                lastnameupd : lastnameupd,
                emailupd : emailupd,
                mobileupd : mobileupd
            },
            function(data,status){
                $('#update_user_modal').modal("hide");
                readRecords();
            }
            )
        }
    </script>
</body>
</html>

<?php ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <div class="container">
        <h1>User Dashboard</h1>
        <hr>
        <div class="row">
            <div class="col-md-5">
                <h2>Add User</h2>
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob">
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">Choose Picture</label>
                        <input type="file" class="form-control" id="file" name="file">
                    </div>
                    <button type="submit" id="submitbtn" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="col-md-7">
                <h2>User Details</h2>
                <div class="table-responsive-lg">
                    <table class="table table-primary">
                        <thead>
                            <tr>
                                <th scope="col">Profile Image</th>
                                <th scope="col">Name of the User</th>
                                <th scope="col">Email Address</th>
                                <th scope="col">Date of Birth</th>
                                <th scope="col" class="text-center" colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody id="userTableBody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function() {
        // AJAX request to get user details
        $.ajax({
            url: 'getUserDetails.php',
            type: 'POST',
            success: function(response) {
                var data = JSON.parse(response);
                var userTableBody = $('#userTableBody');
                userTableBody.empty();
                data.forEach(function(user) {
                    var row = '<tr>' +
                        '<td><img src="' + user.file + '" alt="Profile Image" width="50"></td>' +
                        '<td>' + user.name + '</td>' +
                        '<td>' + user.email + '</td>' +
                        '<td>' + user.dob + '</td>' +
                        '<td><button class="btn btn-primary btn-edit" data-user-id="' + user.user_id + '">Edit</button></td>' +
                        '<td><button class="btn btn-danger" onclick="deleteUser(' + user.user_id + ')">Delete</button></td>' +

                        '</tr>';
                    userTableBody.append(row);
                });
            },
            error: function(xhr, status, error) {
                console.log(error); // Handle errors
            }
        });

        function openEditModal(userId) {
            var modal = $('#editModal');
            var editName = modal.find('#editName');
            var editEmail = modal.find('#editEmail');
            var editDob = modal.find('#editDob');
            var editId = modal.find('#editId');
            var editCurrentImage = modal.find('#editCurrentImage')
            $.ajax({
                url: 'getUserUpdate.php',
                type: 'POST',
                data: { userId: userId },
                success: function(response) {
                    var user = JSON.parse(response);
                    editName.val(user.name);
                    editEmail.val(user.email);
                    editDob.val(user.dob);
                    editId.val(user.user_id)

                },
                error: function(xhr, status, error) {
                    console.log(error); 
                }
            });

            modal.modal('show');
        }

        $('body').on('click', '.btn-edit', function() {
            var userId = $(this).data('user-id');
            openEditModal(userId);
        });
    });
</script>

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Update User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                    <div class="mb-3">
                            <label for="editName" class="form-label">User ID</label>
                            <input type="text" class="form-control" id="editId" name="editId" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="editName" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="editName" name="editName">
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="editEmail" name="editEmail">
                        </div>
                        <div class="mb-3">
                            <label for="editDob" class="form-label">Date of Birth:</label>
                            <input type="date" class="form-control" id="editDob" name="editDob">
                        </div>
                     
                      

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="editUser" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function deleteUser(userId) {
            $.ajax({
                url: "deleteUser.php",
                type: "POST",
                data: {userId:userId},
                success: function(response) {
                    alert(response)
                    location.reload()
                }
            });
        }
    </script>

<script>
    $(document).ready(function() {
        $('#editUser').click(function(event) {
            event.preventDefault();

            // var formData = new FormData();
            var userId= $('#editId').val();
            var name= $('#editName').val();
            var email= $('#editEmail').val();
            var dob= $('#editDob').val();
         

            $.ajax({
                url: 'updateUser.php',
                type: 'POST',
                data: {userId:userId,name:name,email:email,dob:dob},
                success: function(response) {
                    alert(response);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });
    });
</script>

    <script>
        $(document).ready(function() {
            $('#submitbtn').click(function(event) {
                event.preventDefault();

                var formData = new FormData();
                formData.append('name', $('#name').val());
                formData.append('email', $('#email').val());
                formData.append('dob', $('#dob').val());
                formData.append('file', $('#file')[0].files[0]);

                $.ajax({
                    url: 'submit.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alert(response);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>

</body>

</html>
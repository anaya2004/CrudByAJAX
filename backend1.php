<?php 
$conn = mysqli_connect('localhost', 'root', '', 'ajax_db');

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

extract($_POST);

// To select data from database 
if(isset($_POST['readrecord'])){
    $data = '<table class="table table-bordered table-striped">
                    <tr>
                            <th>SNo.</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email Address</th>
                            <th>Contact Number</th>
                            <th>Edit Action</th>
                            <th>Delete Action</th>
                    </tr>';

    $displayquery = "SELECT * FROM `ajax_crud`";
    $result = mysqli_query($conn , $displayquery);
    if(mysqli_num_rows($result) > 0){
        $number = 1;
        while($row = mysqli_fetch_array($result)){
            $data .= '<tr>
                <td>'.$number.'</td>
                <td>'.$row['firstname'].'</td>
                <td>'.$row['lastname'].'</td>
                <td>'.$row['email'].'</td>
                <td>'.$row['mobile'].'</td>
                <td>
                    <button onclick="GetUserDetails('.$row['id'].')" class="btn btn-warning">Edit</button>
                </td>
                <td>
                    <button onclick="DeleteUser('.$row['id'].')" class="btn btn-danger">Delete</button>
                </td>
            </tr>';
            $number++;
        }
    }
    $data .= '</table>';
    echo $data;
    exit(); // Ensure no further code is executed
}

// To insert data in database 
if (!isset($_POST['readrecord']) && isset($firstname) && isset($lastname) && isset($email) && isset($mobile)) {
    // Check if any field is empty
    if (empty($firstname) || empty($lastname) || empty($email) || empty($mobile)) {
        echo "All fields are required";
        exit(); // Ensure no further code is executed
    }

    // Sanitize inputs
    $firstname = mysqli_real_escape_string($conn, $firstname);
    $lastname = mysqli_real_escape_string($conn, $lastname);
    $email = mysqli_real_escape_string($conn, $email);
    $mobile = mysqli_real_escape_string($conn, $mobile);

    $query = "INSERT INTO `ajax_crud`(`firstname`, `lastname`, `email`, `mobile`) 
              VALUES ('$firstname','$lastname','$email','$mobile')";

    if (mysqli_query($conn, $query)) {
        echo "Record added successfully";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
//to delete the data from database
if(isset($_POST['deleteid'])){
    $userid =$_POST['deleteid'];
    $deletequery = "DELETE FROM `ajax_crud` WHERE id ='$userid' ";
    mysqli_query($conn ,$deletequery);
}

//get userid for update 
if(isset($_POST['id']) && isset($_POST['id']) != ""){
    $user_id = $_POST['id'];
    $query = "SELECT * FROM ajax_crud WHERE id = '$user_id'";
    if(!$result = mysqli_query($conn , $query)){
        exit(mysqli_error());
    }

    $response = array();

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $response = $row;
        }
    }else{
        $response['status'] = 200;
        $response['message'] == "Data not found!";
    }
//to convert array object into json format 
    echo json_encode($response);

}//end of outer if 
// else {
//     $response['status'] = 200;
//     $response['message'] == "Invalid request!";
// }


//to update the data 
if(isset($_POST['hidden_user_idupd'])){
    $hidden_user_idupd = $_POST['hidden_user_idupd'];
    $firstnameupd = $_POST['firstnameupd'];
    $lastnameupd = $_POST['lastnameupd'];
    $emailupd = $_POST['emailupd'];
    $mobileupd = $_POST['mobileupd'];

    $query = "UPDATE `ajax_crud` SET `firstname`='$firstnameupd',`lastname`='$lastnameupd',`email`='$emailupd',`mobile`='$mobileupd' WHERE  id = '$hidden_user_idupd'";
    mysqli_query($conn, $query);
    // if (mysqli_query($conn, $query)) {
    //     echo "Record updated successfully";
    // } else {
    //     echo "Error: " . $query . "<br>" . mysqli_error($conn);
    // }
}
mysqli_close($conn);
?>

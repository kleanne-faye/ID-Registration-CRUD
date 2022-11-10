<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
// database connection
include('config.php');

$added = false;


//Add  new student code 

if(isset($_POST['submit'])){
	$u_card = $_POST['card_no'];
	$u_f_name = $_POST['user_first_name'];
	$u_l_name = $_POST['user_last_name'];
	$u_father = $_POST['user_father'];
	$u_aadhar = $_POST['user_aadhar'];
	$u_birthday = $_POST['user_dob'];
	$u_gender = $_POST['user_gender'];
	$u_email = $_POST['user_email'];
	$u_phone = $_POST['user_phone'];
	$u_state = $_POST['state'];
	$u_dist = $_POST['dist'];
	$u_village = $_POST['village'];
	#$u_police = $_POST['police_station'];
	$u_pincode = $_POST['pincode'];
	$u_mother = $_POST['user_mother'];
	$u_family = $_POST['family'];
	$u_staff_id = $_POST['staff_id'];
	$u_guardian = $_POST['user_guardian'];
	$u_gur_mob= $_POST['gur_mob'];
	


	//image upload

	$msg = "";
	$image = $_FILES['image']['name'];
	$target = "upload_images/".basename($image);

	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
  		$msg = "Image uploaded successfully";
  	}else{
  		$msg = "Failed to upload image";
  	}
#u_police,,'$u_police'u_aadhar,'$u_aadhar',
  	$insert_data = "INSERT INTO student_data(u_card, u_f_name, u_l_name, u_father, u_birthday, u_gender, u_email, u_phone, u_state, u_dist, u_village,  u_pincode, u_mother, u_family, staff_id,image,uploaded) VALUES ('$u_card','$u_f_name','$u_l_name','$u_father','$u_birthday','$u_gender','$u_email','$u_phone','$u_state','$u_dist','$u_village','$u_pincode','$u_mother','$u_family','$u_staff_id','$image',NOW())";
  	$run_data = mysqli_query($con,$insert_data);

  	if($run_data){
		  $added = true;
  	}else{
  		echo "Data not insert";
  	}

}

?>







<!DOCTYPE html>
<html>
<head>
	<title>Student Registration</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

	<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #a3c585;">
	<div class="container">
<a href="#" target="_blank"><img src="images/uc_logo.png" class="img-fluid" style="width: 450px; height: 100px; overflow: hidden; margin-top: -6px;"></a><br><hr>

<!-- adding alert notification  -->
<?php
	if($added){
		echo "
			<div class='btn-success' style='padding: 15px; text-align:center;'>
				Your Student Data has been Successfully Added.
			</div><br>
		";
	}

?>





	<a href="logout.php" class="btn btn-success" style="background-color: #4b6043; border-color: #658354;"><i class="fa fa-lock"></i> Logout</a>
	<button class="btn btn-success" style="background-color: #4b6043; border-color: #658354;" type="button" data-toggle="modal" data-target="#myModal">
  <i class="fa fa-plus"></i> Add New Student
  </button>
  <!--<a href="export.php" class="btn btn-success pull-right" style="background-color: #4b6043; border-color: #658354;"><i class="fa fa-download"></i> Export Data</a>-->
  <hr>
		<table class="table table-bordered table-striped table-hover" id="myTable">
		<thead>
			<tr>
			   <th class="text-center" scope="col">No.</th>
				<th class="text-center" scope="col">Name</th>
				<th class="text-center" scope="col">Student ID</th>
				<th class="text-center" scope="col">Phone</th>
				<th class="text-center" scope="col">College Department</th>
				<th class="text-center" scope="col">View</th>
				<th class="text-center" scope="col">Edit</th>
				<th class="text-center" scope="col">Delete</th>
			</tr>
		</thead>
			<?php

        	$get_data = "SELECT * FROM student_data order by 1 desc";
        	$run_data = mysqli_query($con,$get_data);
			$i = 0;
        	while($row = mysqli_fetch_array($run_data))
        	{
				$sl = ++$i;
				$id = $row['id'];
				$u_card = $row['u_card'];
				$u_f_name = $row['u_f_name'];
				$u_l_name = $row['u_l_name'];
				$u_phone = $row['u_phone'];
				$u_family = $row['u_family'];
				$u_staff_id = $row['staff_id'];

        		$image = $row['image'];

        		echo "

				<tr>
				<td class='text-center'>$sl</td>
				<td class='text-left'>$u_f_name  $u_l_name</td>
				<td class='text-left'>$u_card</td>
				<td class='text-left'>$u_phone</td>
				<td class='text-center'>$u_staff_id</td>
			
				<td class='text-center'>
					<span>
					<a href='#' class='btn btn-success mr-3 profile' data-toggle='modal' data-target='#view$id' title='Profile'><i class='fa fa-address-card-o' aria-hidden='true'></i></a>
					</span>
					
				</td>
				<td class='text-center'>
					<span>
					<a href='#' class='btn btn-warning mr-3 edituser' data-toggle='modal' data-target='#edit$id' title='Edit'><i class='fa fa-pencil-square-o fa-lg'></i></a>

					     
					    
					</span>
					
				</td>
				<td class='text-center'>
					<span>
					
						<a href='#' class='btn btn-danger deleteuser' title='Delete'>
						     <i class='fa fa-trash-o fa-lg' data-toggle='modal' data-target='#$id' style='' aria-hidden='true'></i>
						</a>
					</span>
					
				</td>
			</tr>


        		";
        	}

        	?>

			
			
		</table>
		<form method="post" action="export.php">
     <input type="submit" name="export" class="btn btn-success" value="Export Data" />
    </form>
	</div>


	<!---Add in modal---->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 700px; height: 1000px;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background-color: #254117;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
		<center><img src="images/uc_logo.png" width="300px" height="80px" alt=""></center>
    
      </div>
      <div class="modal-body">
        <form method="POST" enctype="multipart/form-data">
			
			<!-- This is test for New Card Activate Form  -->
			<!-- This is Address with email id  -->
<div class="form-row">
<div class="form-group col-md-6">
<label for="inputEmail4">Student ID</label>
<input type="phone" class="form-control" name="card_no" placeholder="Enter Student ID (with dash)" maxlength="11" required>
</div>
<div class="form-group col-md-6">
<label for="inputPassword4">Mobile No.</label>
<input type="tel" class="form-control" name="user_phone" placeholder="Enter Mobile Number (+63***)" maxlength="13" required>
</div>
</div>


<div class="form-row">
<div class="form-group col-md-4">
<label for="lastname">Last Name</label>
<input type="text" class="form-control" name="user_last_name" placeholder="Enter Last Name" required="">
</div>
<div class="form-group col-md-4">
<label for="firstname">First Name</label>
<input type="text" class="form-control" name="user_first_name" placeholder="Enter First Name" required="">
</div>
<div class="form-group col-md-3">
<label for="lastname">Middle Name</label>
<input type="text" class="form-control" name="user_middle_name" placeholder="Enter Middle Name" required="">
</div>
</div>
</div>



<div class="form-row">
<div class="form-group col-md-6">
<label for="fathername">Father's Name</label>
<input type="text" class="form-control" name="user_father" placeholder="Enter Complete Name" required="">
</div>
<div class="form-group col-md-6">
<label for="fathername">Occupation</label>
<input type="text" class="form-control" name="occupation_father" placeholder="Enter Occupation">
</div>
<div class="form-group col-md-6">
<label for="mothername">Mother's Name</label>
<input type="text" class="form-control" name="user_mother" placeholder="Enter Complete Name" required="">
</div>
<div class="form-group col-md-6">
<label for="fathername">Occupation</label>
<input type="text" class="form-control" name="occupation_mother" placeholder="Enter Occupation">
</div>
<div class="form-group col-md-6">
<label for="fathername">Guardian</label>
<input type="text" class="form-control" name="user_guardian" placeholder="Enter Guardian's Name" required="">
</div>
<div class="form-group col-md-6">
<label for="inputPassword4">Mobile No. of Guardian</label>
<input type="phone" class="form-control" name="gur_mob" placeholder="Enter Mobile Number (+63***)" maxlength="13" required>
</div>
</div>


<div class="form-row">
<div class="form-group col-md-6">
<label for="email">Email Address</label>
<input type="email" class="form-control" name="user_email" placeholder="Enter Email Address" required="">
</div>
<div class="form-group col-md-6">
<label for="aadharno">Telephone No. (if there is)</label>
<input type="number" class="form-control" name="user_aadhar" maxlength="12" placeholder="Enter Telephone No.">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6">
<label for="inputState">Gender</label>
<select id="inputState" name="user_gender" class="form-control">
  <option selected>Choose...</option>
  <option>Male</option>
  <option>Female</option>
  <option>Other</option>
</select>
</div>
<div class="form-group col-md-6">
<label for="inputPassword4">Date of Birth</label>
<input type="date" class="form-control" name="user_dob" placeholder="Date of Birth">
</div>
</div>


<div class="form-group">
<label for="family">&nbsp; &nbsp;Family Member's</label>
    <textarea class="form-control" name="family" rows="3"></textarea>
</div>



<div class="form-group">
<label for="inputAddress">&nbsp; &nbsp;Address</label>
<input type="text" class="form-control" name="village" placeholder="Enter your complete address">
</div>
<!--<div class="form-group">
<label for="inputAddress2">Police Station</label>
<input type="text" class="form-control" name="police_station" placeholder="Enter police station">
</div>-->
<div class="form-row">
<div class="form-group col-md-4">
<label for="inputState">Province</label>
<select name="state" class="form-control">
  <option selected>Choose...</option>
  <option value="Abra">Abra</option>
									<option value="Apayao">Apayao</option>
									<option value="Benguet">Benguet</option>
									<option value="Ifugao">Ifugao</option>
									<option value="Kalinga">Kalinga</option>
									<option value="Mountain Province">Mountain Province</option>
									
</select>
</div>
<div class="form-group col-md-4">
<label for="inputCity">Municipality</label>
<input type="text" class="form-control" name="dist">
</div>
<div class="form-group col-md-2">
<label for="inputZip">Zip Code</label>
<input type="number" class="form-control" name="pincode">
</div>
</div>


<div class="form-group">
<label for="inputAddress">&nbsp; &nbsp;Preferred Course</label>
<select name="staff_id" class="form-control">
  <option selected>Select Course</option>
                        <option value="BSIT">Bachelor of Science in Information Technology</option>
                        <option value="BSCS">Bachelor of Science in Computer Science</option>
                        <option value="BSDA">Bachelor of Science in Data Analytics</option>
                        <option value="BSCoE">Bachelor of Science in Computer Engineering</option>
                        <option value="BSCE">Bachelor of Science in Civil Engineering</option>
                        <option value="BSA">Bachelor of Science in Architecture</option>
                        <option value="BSAc">Bachelor of Science in Accountancy</option>
                        <option value="BSN">Bachelor of Science in Nursing</option>
									
</select>
</div>
			


        	<div class="form-group">
        		<label>&nbsp; &nbsp; Image</label>
        		<input type="file" name="image" class="form-control" >
        	</div>

        	
        	 &nbsp; &nbsp;<input type="submit" name="submit" class="btn btn-info btn-large" style="background-color: #658354; border-color: #658354;" value="Submit">
        	
        	<div class="modal-footer">
        <button type="button" class="btn btn-default"style="background-color: #658354; border-color: #658354; color: white;" data-dismiss="modal">Close&nbsp; &nbsp;</button>
      </div>
        </form>
      </div>
      
    </div>

  </div>
</div>


<!------DELETE modal---->




<!-- Modal -->
<?php

$get_data = "SELECT * FROM student_data";
$run_data = mysqli_query($con,$get_data);

while($row = mysqli_fetch_array($run_data))
{
	$id = $row['id'];
	echo "

<div id='$id' class='modal fade' role='dialog'>
  <div class='modal-dialog'>

    <!-- Modal content-->
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal'>&times;</button>
        <h4 class='modal-title text-center'>Are you sure to delete data???</h4>
      </div>
      <div class='modal-body'>
        <a href='delete.php?id=$id' class='btn btn-danger' style='margin-left:250px'>Delete</a>
      </div>
      
    </div>

  </div>
</div>


	";
	
}


?>


<!-- View modal  -->
<?php 

// <!-- profile modal start -->
$get_data = "SELECT * FROM student_data";
$run_data = mysqli_query($con,$get_data);

while($row = mysqli_fetch_array($run_data))
{
	$id = $row['id'];
	$card = $row['u_card'];
	$name = $row['u_f_name'];
	$name2 = $row['u_l_name'];
	$u_father = $row['u_father'];
	$mother = $row['u_mother'];
	$gender = $row['u_gender'];
	$email = $row['u_email'];
	$Bday = $row['u_birthday'];
	$family = $row['u_family'];
	$phone = $row['u_phone'];
	$address = $row['u_state'];
	$village = $row['u_village'];
	#$police = $row['u_police'];
	$dist = $row['u_dist'];
	$pincode = $row['u_pincode'];
	$state = $row['u_state'];
	$time = $row['uploaded'];
	
	$image = $row['image'];
	echo "

		<div class='modal fade' id='view$id' tabindex='-1' role='dialog' aria-labelledby='userViewModalLabel' aria-hidden='true'>
		<div class='modal-dialog'>
			<div class='modal-content'>
			<div class='modal-header'>
				<h4 class='modal-title' id='exampleModalLabel'>Profile <i class='fa fa-user-circle-o' aria-hidden='true'></i></h4>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
				</button>
			</div>
			<div class='modal-body'>
			<div class='container' id='profile'> 
				<div class='row'>
					<div class='col-sm-4 col-md-2'>
						<img src='upload_images/$image' alt='' style='width: 150px; height: 150px;' ><br>
		
						<i class='fa fa-id-card' aria-hidden='true'></i> $card<br>
						<i class='fa fa-phone' aria-hidden='true'></i> $phone  <br>
						Issue Date : $time
					</div>
					<div class='col-sm-3 col-md-6'>
						<h3 class='text-primary'>$name $name2</h3>
						<p class='text-secondary'>
						<strong>Father :</strong> $u_father <br>
						<strong>Mother :</strong>$mother <br>

						<i class='fa fa-venus-mars' aria-hidden='true'></i> $gender
						<br />
						<i class='fa fa-envelope-o' aria-hidden='true'></i> $email
						<br />
						<div class='card' style='width: 18rem;'>
						<i class='fa fa-users' aria-hidden='true'></i> Familiy :
								<div class='card-body'>
								<p> $family </p>
								</div>
						</div>
						
						<i class='fa fa-home' aria-hidden='true'> Address : </i> $village, <br> $dist, $state - $pincode
						<br />
						</p>
						<!-- Split button -->
					</div>
				</div>

			</div>   
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
			</div>
			</form>
			</div>
		</div>
		</div> 


    ";
}


// <!-- profile modal end -->


?>





<!----edit Data--->

<?php

$get_data = "SELECT * FROM student_data";
$run_data = mysqli_query($con,$get_data);

while($row = mysqli_fetch_array($run_data))
{
	$id = $row['id'];
	$card = $row['u_card'];
	$name = $row['u_f_name'];
	$name2 = $row['u_l_name'];
	$u_father = $row['u_father'];
	$mother = $row['u_mother'];
	$gender = $row['u_gender'];
	$email = $row['u_email'];
	$aadhar = $row['u_aadhar'];
	$Bday = $row['u_birthday'];
	$family = $row['u_family'];
	$phone = $row['u_phone'];
	$address = $row['u_state'];
	$village = $row['u_village'];
	$police = $row['u_police'];
	$dist = $row['u_dist'];
	$pincode = $row['u_pincode'];
	$state = $row['u_state'];
	$staffCard = $row['staff_id'];
	$time = $row['uploaded'];
	$image = $row['image'];
	echo "

<div id='edit$id' class='modal fade' role='dialog'>
  <div class='modal-dialog'>

    <!-- Modal content-->
    <div class='modal-content'>
      <div class='modal-header'>
             <button type='button' class='close' data-dismiss='modal'>&times;</button>
             <h4 class='modal-title text-center'>Edit your Data</h4> 
      </div>

      <div class='modal-body'>
        <form action='edit.php?id=$id' method='post' enctype='multipart/form-data'>

		<div class='form-row'>
		<div class='form-group col-md-6'>
		<label for='inputEmail4'>Student ID</label>
		<input type='phone' class='form-control' name='card_no' placeholder='Enter Student ID (with dash)' maxlength='11' value='$card' required>
		</div>
		<div class='form-group col-md-6'>
		<label for='inputPassword4'>Mobile No.</label>
		<input type='tel' class='form-control' name='user_phone' placeholder='Enter Mobile Number (+63***)' maxlength='13' value='$phone' required>
		</div>
		</div>
		
		
		<div class='form-row'>
		<div class='form-group col-md-6'>
		<label for='firstname'>First Name</label>
		<input type='text' class='form-control' name='user_first_name' placeholder='Enter First Name' value='$name'>
		</div>
		<div class='form-group col-md-6'>
		<label for='lastname'>Last Name</label>
		<input type='text' class='form-control' name='user_last_name' placeholder='Enter Last Name' value='$name2'>
		</div>
		</div>
		
		
		<div class='form-row'>
		<div class='form-group col-md-6'>
		<label for='fathername'>Father's Name</label>
		<input type='text' class='form-control' name='user_father' placeholder='Enter First Name' value='$u_father'>
		</div>
		<div class='form-group col-md-6'>
		<label for='mothername'>Mother's Name</label>
		<input type='text' class='form-control' name='user_mother' placeholder='Enter Last Name' value='$mother'>
		</div>
		</div>
		
		
		<div class='form-row'>
		<div class='form-group col-md-6'>
		<label for='email'>Email Address</label>
		<input type='email' class='form-control' name='user_email' placeholder='Enter Email Address' value='$email'>
		</div>
		<div class='form-group col-md-6'>
		<label for='aadharno'>Telephone No.</label>
		<input type='phone' class='form-control' name='user_aadhar' maxlength='12' value='$aadhar'>
		</div>
		</div>
		
		<div class='form-row'>
		<div class='form-group col-md-6'>
		<label for='inputState'>Gender</label>
		<select id='inputState' name='user_gender' class='form-control' value='$gender'>
		  <option selected>$gender</option>
		  <option>Male</option>
		  <option>Female</option>
		  <option>Other</option>
		</select>
		</div>
		<div class='form-group col-md-6'>
		<label for='inputPassword4'>Date of Birth</label>
		<input type='date' class='form-control' name='user_dob' placeholder='Date of Birth' value='$Bday'>
		</div>
		</div>
		
		
		
		<div class='form-group'>
		<label for='inputAddress'>Address</label>
		<input type='text' class='form-control' name='village' placeholder='Enter your complete address' value='$village'>
		</div>
		
		<div class='form-group col-md-4'>
		<label for='inputState'>Province</label>
		<select name='state' class='form-control'>
		<option selected>Choose...</option>
  		<option value='Abra'>Abra</option>
									<option value='Apayao'>Apayao</option>
									<option value='Benguet'>Benguet</option>
									<option value='Ifugao'>Ifugao</option>
									<option value='Kalinga'>Kalinga</option>
									<option value='Mountain Province'>Mountain Province</option>
									
		</select>
		</div>
		<div class='form-group col-md-4'>
		<label for='inputCity'>Municipality</label>
		<input type='text' class='form-control' name='dist'>
		</div>
		<div class='form-group col-md-4'>
		<label for='inputZip'>Zip</label>
		<input type='number' class='form-control' name='pincode' value='$pincode'>
		</div>
		</div>
		<div class='form-group'>
		<label for='inputAddress'>&nbsp; &nbsp;Preferred Course</label>
		<select name='staff_id' class='form-control'>
  		<option selected>Select Course</option>
                        <option value='BSIT'>Bachelor of Science in Information Technology</option>
                        <option value='BSCS'>Bachelor of Science in Computer Science</option>
                        <option value='BSDA'>Bachelor of Science in Data Analytics</option>
                        <option value='BSCoE'>Bachelor of Science in Computer Engineering</option>
                        <option value='BSCE'>Bachelor of Science in Civil Engineering</option>
                        <option value='BSA'>Bachelor of Science in Architecture</option>
                        <option value='BSAc'>Bachelor of Science in Accountancy</option>
                        <option value='BSN'>Bachelor of Science in Nursing</option>
									
</select>
</div>
        	

        	<div class='form-group'>
        		<label>Image</label>
        		<input type='file' name='image' class='form-control'>
        		
        	</div>

        	
        	
			 <div class='modal-footer'>
			 <input type='submit' name='submit' class='btn btn-info btn-large' style='background-color: #658354; border-color: #658354; value='Submit'>
			 <button type='button' class='btn btn-default' style='background-color: #658354; border-color: #658354; color: white; data-dismiss='modal'>Close&nbsp; &nbsp;</button>
		 </div>


        </form>
      </div>

    </div>

  </div>
</div>


	";
}


?>

<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();

    });
  </script>

</body>
</html>

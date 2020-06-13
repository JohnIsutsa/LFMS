<?php include 'includes/connection.php'?>
<?php include 'includes/adminheader.php'?>

<?php 
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {

header("location: index.php");
}
?>

<div id="wrapper">

       <?php include 'includes/adminnav.php'?>
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            UPLOAD MATTER
                        </h1>

<?php
if (isset($_POST['upload'])) {
require "../gump.class.php";
$gump = new GUMP();
$_POST = $gump->sanitize($_POST); 

$gump->validation_rules(array(
    'title'    => 'required|max_len,60|min_len,3',
    'description'   => 'required|max_len,300|min_len,3',

));
$gump->filter_rules(array(
    'title' => 'trim|sanitize_string',
    'description' => 'trim|sanitize_string',
    ));
$validated_data = $gump->run($_POST);


if($validated_data === false) {
    ?>
    <center><font color="red" > <?php echo $gump->get_readable_errors(true); ?> </font></center>
    <?php 
    $file_title = $_POST['title'];
    $file_description = $_POST['description'];
}
else {
    $file_title = $validated_data['title'];
    $file_description = $validated_data['description'];
if (isset($_SESSION['id'])) {
        $file_uploader = $_SESSION['username'];
        $uploader_id = $_SESSION['id']; //uploader ID 
        $uploader_role = $_SESSION['role']; //uploader role
        
    }
    if ($uploader_role == 'client') {

            $sessId = $_SESSION['id']; 
            $dbquery = "SELECT lawyer_id FROM clients WHERE client_id = '$sessId'"; 
            $dbresult = mysqli_query($conn, $dbquery) or die(mysqli_error($conn)); 

            while($rows = $dbresult->fetch_assoc()) 
                {
                    $lawyer_id = $rows['lawyer_id'];
                            
                }

        $query = "INSERT INTO matters(matter_name, description, client_id, lawyer_id, created_by) VALUES ('$file_title', '$file_description', '$uploader_id', '$lawyer_id', '$file_uploader')";
        $result = mysqli_query($conn, $query) or die (mysqli_error($conn)); 

        if (mysqli_affected_rows($conn) > 0) { 
            echo "<script>alert('SUCCESSFULLY UPLOADED MATTER');
      window.location.href= 'index.php';</script>";
        } else {
            "<script> alert('Error while uploading..try again');</script>";
        }
    } else 
    if($uploader_role == 'lawyer'){
         $client = $_POST['client'];
         $query = "INSERT INTO matters(matter_name, description, client_id, lawyer_id, created_by) VALUES ('$file_title','$file_description', '$client', '$uploader_id', '$file_uploader')";
         $result = mysqli_query($conn, $query) or die (mysqli_error($conn)); 

         if (mysqli_affected_rows($conn) > 0) { 
           
             echo "<script>alert('SUCCESSFULLY UPLOADED MATTER');
      window.location.href= 'index.php';</script>";
        } else {
            "<script> alert('Error while uploading..try again');</script>";
        }

    }
}
}
?>


     <form role="form" action="" method="POST" enctype="multipart/form-data">


	<div class="form-group">
		<label for="post_title">Matter Name</label>
		<input type="text" name="title" class="form-control" placeholder="Eg: Makutano petition"  value = "<?php if(isset($_POST['upload'])) {
            echo $file_title; } ?>" required="">
	</div>

	<div class="form-group">
		<label for="post_tags">Matter Description</label>
		<input type="text" name="description" class="form-control" placeholder="Eg: This matter pertains to the petition involving the following...." value="<?php if(isset($_POST['upload'])) {
            echo $file_description;  } ?>" required="" >
	</div>

    <?php if ($_SESSION['role']=='lawyer') {
        $sessId = $_SESSION['id']; 
        $query = "SELECT client_id, client_name FROM clients WHERE lawyer_id = '$sessId'";
        $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
        ?>
        <div class="form-group">
            <label for="post_tags">Client</label>
            <select class="select-sytle gender" name="client">
                        <?php
                        while($rows = $result->fetch_assoc()) 
                        {
                            $id = $rows['client_id'];
                            $name = $rows['client_name'];
                            echo "<option value='$id'>$id - $name</option>";
                        }

                        ?>
                    </select>

                </br>
        </div>

   <?php } ?>


   <!-- <?php 
        /*if ($_SESSION['role'] == 'client') {
            $sessId = $_SESSION['id']; 
            $query = "SELECT lawyer_id FROM clients WHERE client_id = '$sessId'"; 
            $result = mysqli_query($conn, $query) or die(mysqli_error($conn)); 

            $lawyer_id = $result; 
        }*/
     ?>-->
    

	 
<button type="submit" name="upload" class="btn btn-primary" value="Upload Note">Add Matter</button>
<br>
<br>
</form>
</div>
</div>
</div>
</div>
</div>


<script src="js/jquery.js"></script>

    
    <script src="js/bootstrap.min.js"></script>

</body>

</html>



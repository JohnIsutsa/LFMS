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
                            UPLOAD MATTER FILE
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

    $file = $_FILES['file']['name'];
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    $validExt = array ('pdf', 'txt', 'doc', 'docx', 'ppt' , 'zip');
    if (empty($file)) {
echo "<script>alert('Attach a file');</script>";
    }
    else if ($_FILES['file']['size'] <= 0 || $_FILES['file']['size'] > 30720000 )
    {
echo "<script>alert('file size is not proper');</script>";
    }
    else if (!in_array($ext, $validExt)){
        echo "<script>alert('Not a valid file');</script>";

    }
    else {
        $folder  = 'allfiles/';
        $fileext = strtolower(pathinfo($file, PATHINFO_EXTENSION) );
        $matterfile = rand(1000 , 1000000) .'.'.$fileext;
        if(move_uploaded_file($_FILES['file']['tmp_name'], $folder.$matterfile)) {


        	if ($uploader_role == 'lawyer') {
        		$matter = $_POST['matter']; 
        		$matter_explode = explode('|', $matter); 
        		$matter_ref = $matter_explode[0]; 
        		$client = $matter_explode[1]; 

        		$query = "INSERT INTO matter_files(file_name, description, ref_no, file_type, file, file_uploader, client_id, lawyer_id) VALUES ('$file_title' , '$file_description', '$matter_ref', '$fileext', '$matterfile', '$file_uploader', '$client', '$uploader_id')";
            	$result = mysqli_query($conn , $query) or die(mysqli_error($conn));
            		if (mysqli_affected_rows($conn) > 0) {
                		echo "<script> alert('file uploaded successfully.It will be published after admin approves it');
                			window.location.href='index.php';</script>";
            		}
            		else {
                			"<script> alert('Error while uploading..try again');</script>";
            		}	
        	} elseif ($uploader_role == 'client') {
        		$matter = $_POST['matter']; 
        		$matter_explode = explode('|', $matter); 
        		$matter_ref = $matter_explode[0]; 
        		$lawyer = $matter_explode[1];

        		$query = "INSERT INTO matter_files(file_name, description, ref_no, file_type, file, file_uploader, client_id, lawyer_id) VALUES ('$file_title' , '$file_description', '$matter_ref', '$fileext', '$matterfile', '$file_uploader', '$uploader_id', '$lawyer')";
            	$result = mysqli_query($conn , $query) or die(mysqli_error($conn));
            		if (mysqli_affected_rows($conn) > 0) {
                		echo "<script> alert('file uploaded successfully.It will be published after admin approves it');
                			window.location.href='index.php';</script>";
            		}
           			else {
               		 		"<script> alert('Error while uploading..try again');</script>";
            		}
        	}
            
        }
    }
}
}
?>

     <form role="form" action="" method="POST" enctype="multipart/form-data">


     <?php if ($_SESSION['role']=='lawyer') {
        $sessId = $_SESSION['id']; 
        $query = "SELECT ref_no, matter_name, client_id FROM matters WHERE lawyer_id = '$sessId'";
        $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
        ?>
        <div class="form-group">
            <label for="post_tags">Select Matter</label>
            <select class="select-sytle gender" name="matter">
                        <?php
                        while($rows = $result->fetch_assoc()) 
                        {
                            $ref = $rows['ref_no'];
                            $name = $rows['matter_name'];
                            $client_id = $rows['client_id'];
                            echo "<option value='$ref|$client_id'>$ref - $name - $client_id</option>";
                        }

                        ?>
                    </select>


                </br>
        </div>

   <?php } ?>

   <?php if ($_SESSION['role']=='client') {
        $sessId = $_SESSION['id']; 
        $query = "SELECT ref_no, matter_name, lawyer_id FROM matters WHERE client_id = '$sessId'";
        $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
        ?>
        <div class="form-group">
            <label for="post_tags">Select Matter</label>
            <select class="select-sytle gender" name="matter">
                        <?php
                        while($rows = $result->fetch_assoc()) 
                        {
                            $ref = $rows['ref_no'];
                            $name = $rows['matter_name'];
                            $lawyer_id = $rows['lawyer_id']; 
                            echo "<option value='$ref|$lawyer_id'>$ref - $name - $lawyer_id</option>";
                        }

                        ?>
                    </select>

                </br>
        </div>

   <?php } ?>



	<div class="form-group">
		<label for="post_title">File Name</label>
		<input type="text" name="title" class="form-control" placeholder="Eg: Makutano petition files..."  value = "<?php if(isset($_POST['upload'])) {
            echo $file_title; } ?>" required="">
	</div>

	<div class="form-group">
		<label for="post_tags">File Description</label>
		<input type="text" name="description" class="form-control" placeholder="Eg: This is a file regarding the matter pertaining to the petition involving the following...." value="<?php if(isset($_POST['upload'])) {
            echo $file_description;  } ?>" required="" >
	</div>

	 <div class="form-group">
        <label for="post_image">Select File</label><font color="brown"> (allowed file type: 'pdf','doc', 'ppt', 'docx','txt','zip' | allowed maximum size: 30 mb ) </font>
		<input type="file" name="file"> 
     </div>

<button type="submit" name="upload" class="btn btn-primary" value="Upload Note">Upload File</button>
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



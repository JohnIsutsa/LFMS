<?php include ('includes/connection.php'); ?>
<?php include ('includes/adminheader.php'); ?>

<div id="wrapper">
       
       <?php include 'includes/adminnav.php';?>
        <div id="page-wrapper">

            <div class="container-fluid">

                
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome 
                            <small><?php echo $_SESSION['name']; ?></small>
                        </h1>


<?php if ($_SESSION['role']=='admin') { ?>


	<!--code for admin dashboard goes here-->
	
<?php } else { 

		//code for lawyer and client dashboard goes here

		if ($_SESSION['role'] == 'client') {
			$client_id = $_SESSION['id']; 
			$username = $_SESSION['username']; 

			$query = "SELECT * FROM matters WHERE client_id = '$client_id'"; 
			$result = mysqli_query($conn, $query) or die (mysqli_error($conn)); 
		?>
			<div class="container" style="width: 1000px;">  
                <!--<h3 align="center">Make accordion by using Bootstrap Collapse and Panels with PHP Script</h3><br />  
                <br />  -->
                <div class="panel-group" id="posts">  
                <?php  
                while($row = mysqli_fetch_array($result))  
                {  
                	$ref_no = $row["ref_no"]; 
                ?>  

                     <div class="panel panel-default">  
                          <div class="panel-heading">  
                               <h4 class="panel-title">  
                                    <a href="#<?php echo $row["ref_no"]; ?>" data-toggle="collapse" data-parent="#posts"><?php echo $row["matter_name"]; ?></a>  
                               </h4>  
                          </div>  
                          <div id="<?php  echo $row["ref_no"]; ?>" class="panel-collapse collapse">  
                               <div class="panel-body">    

                               <!--Entered table code starting here-->

                        <div class="row">
						<div class="col-lg-12">
			        	<div class="table-responsive">

						<form action="" method="post">
			            <table class="table table-bordered table-striped table-hover">


			            <thead>
			                    <tr>
			                        <th>Name</th>
			                        <th>Description</th>
			                        <th>Type </th>
			                        <th>Uploaded on</th>
			                      	<!--<th>Status</th>-->
			                        <th>View</th>
			                        <!--<th>Delete</th>-->
			                        
			                    </tr>
			             </thead>
			             <tbody>

			                 <?php
			                 $currentuser = $_SESSION['username'];

						$query = "SELECT * FROM matter_files WHERE ref_no ='$ref_no' ORDER BY uploaded_on DESC";
						$run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
						if (mysqli_num_rows($run_query) > 0) {
							while ($row = mysqli_fetch_array($run_query)) {
								    $file_id = $row['file_id'];
								    $file_name = $row['file_name'];
								    $file_description = $row['description'];
								    $file_type = $row['file_type'];
								    $file_date = $row['uploaded_on'];
								    //$file_status = $row['status'];
								    $file = $row['file'];

								    echo "<tr>";
								    echo "<td>$file_name</td>";
								    echo "<td>$file_description</td>";
								    echo "<td>$file_type</td>";
								    echo "<td>$file_date</td>";
								    //echo "<td>$file_status</td>";
								    echo "<td><a href='allfiles/$file' target='_blank' style='color:green'>View </a></td>";
								    /*echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete this post?')\" href='?del=$file_id'><i class='fa fa-times' style='color: red;'></i>delete</a></td>";*/

								    echo "</tr>";

							}
						}
						else {

							echo "<div >
								<div style='bold'> No files uploaded yet!</div> <br>

								<button><a href='uploadmatterfile.php'>Upload</a></button> <br> <br>
							</div>";

							 /*echo "<script>alert('Not files yet! Start uploading now');
							    window.location.href= 'uploadmatterfile.php';</script>";*/
						}
						?>


			            </tbody>
			            </table>
						</form>
						</div>
						</div>
						</div>

                               </div>  
                          </div> 
                     </div>  
                <?php  
                }  
                ?>  
                </div>  
           </div>  




	<?php	} elseif ($_SESSION['role'] == 'lawyer') {

			$lawyer_id = $_SESSION['id'];
			$username = $_SESSION['username']; 

			$query = "SELECT * FROM matters WHERE lawyer_id = '$lawyer_id' ORDER BY client_id"; 
			$result = mysqli_query($conn, $query) or die (mysqli_error($conn));

			?>


			<div class="container" style="width:1000px;">  
                
                <div class="panel-group" id="posts">  
                <?php  
                while($row = mysqli_fetch_array($result))  
                {  
                	$ref_no = $row["ref_no"];
                	/*$clientid = $row["client_id"]; 
                	$query2 = "SELECT client_name FROM clients WHERE client_id = $clientid"; 
                	$result2 = mysqli_query($conn, $query2) or die(mysqli_error($conn));*/
                ?>  
                     <div class="panel panel-default">  
                          <div class="panel-heading">  
                               <h4 class="panel-title">  
                                    <a href="#<?php echo $row["ref_no"]; ?>" data-toggle="collapse" data-parent="#posts"><?php echo $row["matter_name"]; ?></a>  
                               </h4>  
                          </div>  
                         <div id="<?php  echo $row["ref_no"]; ?>" class="panel-collapse collapse">  
                               <div class="panel-body">    

                               <!--Entered table code starting here-->

                        <div class="row">
						<div class="col-lg-12">
			        	<div class="table-responsive">

						<form action="" method="post">
			            <table class="table table-bordered table-striped table-hover">


			            <thead>
			                    <tr>
			                        <th scope="col">Name</th>
			                        <th scope="col">Description</th>
			                        <th scope="col">Type </th>
			                        <th scope="col">Uploaded on</th>
			                      	<!--<th>Status</th>-->
			                        <th scope="col">View</th>
			                        <!--<th>Delete</th>-->
			                        
			                    </tr>
			             </thead>
			             <tbody>

			                 <?php
			                 $currentuser = $_SESSION['username'];

						$query = "SELECT * FROM matter_files WHERE ref_no ='$ref_no' ORDER BY uploaded_on DESC";
						$run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
						if (mysqli_num_rows($run_query) > 0) {
							while ($row = mysqli_fetch_array($run_query)) {
								    $file_id = $row['file_id'];
								    $file_name = $row['file_name'];
								    $file_description = $row['description'];
								    $file_type = $row['file_type'];
								    $file_date = $row['uploaded_on'];
								    //$file_status = $row['status'];
								    $file = $row['file'];

								    echo "<tr>";
								    echo "<td>$file_name</td>";
								    echo "<td>$file_description</td>";
								    echo "<td>$file_type</td>";
								    echo "<td>$file_date</td>";
								    //echo "<td>$file_status</td>";
								    echo "<td><a href='allfiles/$file' target='_blank' style='color:green'>View </a></td>";
								    /*echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete this post?')\" href='?del=$file_id'><i class='fa fa-times' style='color: red;'></i>delete</a></td>";*/

								    echo "</tr>";

							}
						}
						else {

							echo "<div >
								<div style='bold'> No files uploaded yet!</div> <br>

								<button><a href='uploadmatterfile.php'>Upload</a></button> <br> <br>
							</div>";

							 /*echo "<script>alert('Not files yet! Start uploading now');
							    window.location.href= 'uploadmatterfile.php';</script>";*/
						}
						?>


			            </tbody>
			            </table>
						</form>
						</div>
						</div>
						</div>

                               </div>  
                          </div> 
                     </div>  
                <?php  
                }  
                ?>  
                </div>  
           </div>  


		<?php } 
			
			}
		?>

	</div>
	</div>
</div>
</div>
</div>






	<script src="js/jquery.js"></script>

	
    <script src="js/bootstrap.min.js"></script>
 </body>
</html>
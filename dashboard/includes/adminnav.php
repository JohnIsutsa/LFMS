  
 <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">LAW FIRM MANAGEMENT SYSTEM</a>
            </div>
            
            <ul class="nav navbar-right top-nav">
                <?php if($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'client') { ?> <li><a href="./uploadmatterfile.php">UPLOAD</a></li> <?php } ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['name']; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <?php if ($_SESSION['role'] == "client") { ?>
                            <li>
                                <a href="./clientviewprofile.php?name=<?php echo $_SESSION['username']; ?>"><i class="fa fa-fw fa-user"></i> Account</a>
                            </li>    
                        <?php } elseif ($_SESSION['role'] == "lawyer") { ?>
                             <li>
                                <a href="./lawyerviewprofile.php?name=<?php echo $_SESSION['username']; ?>"><i class="fa fa-fw fa-user"></i> Account</a>
                            </li>    
                        <?php } ?>
                        <!--
                            ****TODO: REMEMBER TO ADD ADMIN ALLOWANCE HERE***
                        -->
                        <!--<li>
                            <a href="./userprofile.php?section=<?php //echo $_SESSION['username']; ?>"><i class="fa fa-fw fa-user"></i> Account</a>
                        </li>-->
                        <li class="divider"></li>
                        <li>
                            <a href="../logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>

<div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="index.php" class="active"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                <?php if($_SESSION['role'] == 'admin') {
                    ?>
                   <li>
                         <a href="javascript:;" data-toggle="collapse" data-target="#user"><i class="fa fa-fw fa-users"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="user" class="collapse">
                            <li>
                                <a href="./users.php">View All Users</a>
                            </li>
                            
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="collapse" data-target="#posts"><i class="fa fa-fw fa-file-text"></i> My Account <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="posts" class="collapse">
                            <li>
                                <a href="./viewprofile.php?name=<?php echo $_SESSION['username']; ?>"> View Profile</a>
                            </li>
                            <li>
                                <a href="./userprofile.php?section=<?php echo $_SESSION['username']; ?>">Edit Profile</a>
                            </li>
                        </ul>
                        </li>
                            
                    <?php } else { ?>

                    <?php if ($_SESSION['role'] == "lawyer") { ?>
                        <li>
                         <a href="javascript:;" data-toggle="collapse" data-target="#user"><i class="fa fa-fw fa-users"></i> My Files <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="user" class="collapse">
                            <li>
                                <a href="./files.php">View All Files</a>
                            </li>
                            <li>
                                <a href="./uploadmatterfile.php">Upload Matter File</a>
                            </li>
                            
                        </ul>
                    </li>
                    <?php } elseif ($_SESSION['role']=="client") { ?>
                        <li>
                         <a href="javascript:;" data-toggle="collapse" data-target="#user"><i class="fa fa-fw fa-users"></i> My Files <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="user" class="collapse">
                            <li>
                                <a href="./files.php">View All Files</a>
                            </li>
                            <li>
                                <a href="./uploadmatterfile.php">Upload File</a>
                            </li>
                            
                        </ul>
                    </li>
                    <?php } ?>

                    <!--<li>
                         <a href="javascript:;" data-toggle="collapse" data-target="#user"><i class="fa fa-fw fa-users"></i> My Files <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="user" class="collapse">
                            <li>
                                <a href="./notes.php">View All Files</a>
                            </li>
                            <li>
                                <a href="./uploadnote.php">Upload File</a>
                            </li>
                            
                        </ul>
                    </li>-->
                    <li>
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="collapse" data-target="#posts"><i class="fa fa-fw fa-file-text"></i> My Account <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="posts" class="collapse">

                            <?php if ($_SESSION['role'] == 'client') { ?>

                            <li>
                                <a href="./clientviewprofile.php?name=<?php echo $_SESSION['username']; ?>"> View Profile</a>
                            </li>
                            <li>
                                <a href="./clientuserprofile.php?section=<?php echo $_SESSION['username']; ?>">Edit Profile</a>
                            </li>
                                
                            <?php } else if ($_SESSION['role'] == 'lawyer') { ?>
                            <li>
                                <a href="./lawyerviewprofile.php?name=<?php echo $_SESSION['username']; ?>"> View Profile</a>
                            </li>
                            <li>
                                <a href="./lawyeruserprofile.php?section=<?php echo $_SESSION['username']; ?>">Edit Profile</a>
                            </li>


                            <?php }  ?>
                            
                        </ul>
                    </li>
                    <?php if ($_SESSION['role'] == 'lawyer') { ?>

                        <!--/* CODE TO TAKE YOU TO CLIENT SIGN UP PAGE */-->
                         <li>
                            <a href="../clientsignup.php" class="active"><i class="fa fa-fw fa-dashboard"></i>Add Client</a>
                        </li>
                        
                    <?php } ?>

<?php } ?>
                </ul>
            </div>
        </nav>
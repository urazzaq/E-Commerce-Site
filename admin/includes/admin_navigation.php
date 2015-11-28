<?php
include_once '../helpers/helpers.php';
?>
<nav id="navigation" class="navbar navbar-default navbar-fixed-top">
    <div class="container" id = "top" >

        <ul class="nav navbar-nav">
            <!--Menu Items-->
            <li><a href="../admin/admin_index.php" >Administrator Area</a></li>   
            <li><a href ="../index.php" ><span class="glyphicon glyphicon-home">--Home</span></a></li>
            <li class="dropdown"><a href="./users.php" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-wrench"></span>
                    --Admin Options 
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="change_password.php">Change Password</a></li>
                    </ul>
                </a></li>
            <li><a href ="<?php echo ((logged_in()) ? './user_logout.php' : './user_login.php'); ?>"><span class="glyphicon glyphicon-log-in"></span><?php echo ((logged_in()) ? '--Logout' : '--Login'); ?></a></li>
            <li><a href ="./admin_brand.php">Edit Brands</a></li>
            <li><a href ="./admin_categories.php">Edit Categories</a></li>
            <li><a href ="./admin_products.php">Edit Products</a></li>
            <li class="dropdown">


                <!--                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $parent['catagory']; ?><span class = "caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        Dropdown Items
                           
                                            <li>
                                                <a href="#"> <?php echo $child['catagory']; ?></a>
                                            </li>
                                      
                                    </ul>
                                </li>-->
        </ul>

    </div>
</nav>
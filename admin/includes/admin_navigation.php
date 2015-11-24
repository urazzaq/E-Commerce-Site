
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container" id = "top" >
        <a href="../admin/admin_index.php" class="navbar-brand">Administrator Area</a>
        <ul class="nav navbar-nav">
                <!--Menu Items-->
                <li><a href ="../index.php"><span class="glyphicon glyphicon-home"></span>Home</a></li><li><a href ="./admin_brand.php">Edit Brands</a></li><li><a href ="./admin_categories.php">Edit Categories</li><li><a href ="./admin_products.php">Edit Products</a></li>
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
<!-- Top Nav Bar -->

<?php
require_once 'conn.php';
$sql = "SELECT * FROM catagories WHERE parent = 0 ";
$parentQuery = $conn->query($sql);
if (!$parentQuery) {
    echo "invalid Query " . mysql_error();
}
?>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container" id = "top" >
        <a href="index.php" class="navbar-brand">Umer's E-Commerce World</a>
        <ul class="nav navbar-nav">
            <?php
            //query dynamic menu items
            while ($parent = mysqli_fetch_assoc($parentQuery)) :
                $parent_id = $parent['id'];
                $sql2 = "SELECT * FROM catagories WHERE parent = '$parent_id' ";
                $cquery = $conn->query($sql2);
                ?>
                <!--Menu Items-->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $parent['catagory']; ?><span class = "caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <!--Dropdown Items-->
                        <?php while ($child = mysqli_fetch_assoc($cquery)) : ?>
                            <li>
                                <a href="#"> <?php echo $child['catagory']; ?></a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </li>
            <?php endwhile; ?>
        </ul>

    </div>
</nav>

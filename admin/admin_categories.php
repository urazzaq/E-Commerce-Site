<?php
require_once "../core/conn.php";
include_once "includes/admin_head.php";
include_once "includes/admin_navigation.php";
include_once '../helpers/helpers.php';

    $sql = "SELECT * FROM categories WHERE parent = 0";
    $result = $conn->query($sql);
?>

<h2 class = 'text-center' >Categories</h2><hr>
<div class = 'row'>
    <div class='col-md-6'>
        <table class='table table-bordered'>
            <thead>
            <th>Category</th><th>Parent</th><th></th>
            </thead>
            <tbody>
                <?php while($parent = mysqli_fetch_assoc($result)):?>
                <tr>
                    <td>Shirts</td>
                    <td>Men</td>
                    <td>
                        <a href='admin_categories.php?edit=1' class='btn btm-xs btn-default'>
                            <span class='glyphicon glyphicon-pencil'></span>
                        </a>
                         <a href='admin_categories.php?delete=1' class='btn btm-xs btn-default'>
                            <span class='glyphicon glyphicon-remove'></span>
                        </a>
                    </td>
                </tr>
                <?php endwhile;?>
            </tbody>
        </table>
        
    </div>
      <div class='col-md-6'>
        
    </div>
</div>


<?php include_once 'includes/admin_footer.php'; ?>
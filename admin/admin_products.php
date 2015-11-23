<?php

require_once "../core/conn.php";
include_once "includes/admin_head.php";
include_once "includes/admin_navigation.php";
include_once '../helpers/helpers.php';
$sql = "SELECT * FROM products WHERE deleted = 0";
$presults = $conn->query($sql);

?>
<h2 class="text-center">Products</h2><hr>
<table class ="table table-bordered table-condensed table-striped">
    <thead><th></th><th>Product</th><th>Price</th><th>Category</th><th>Featured</th><th>Sold</th></thead>
<tbody>
    <?php while($product = mysqli_fetch_assoc($presults)):?>
    <tr>
        <td>
            <a href="admin_products.php?edit=<?php echo $product['id']?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
            <a href="admin_products.php?delete=<?php echo $product['id']?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></a>
        </td>
        <td><?php echo $product['title']?></td>
        <td><?php echo money($product['price'])?></td>
        <td></td> 
        <td>  
            <a href="admin_products.php?featured=<?php echo (($product['featured']==0)?'1':'0');?>&id=<?php echo $product['id'];?>" class="btn btn-xs btn-default" >
                <span class="glyphicon glyphicon-<?php echo (($product['featured']==1)?'minus':'plus' ); ?>" ></span></a>
                &nbsp <?php echo (($product['featured']==1)?'Featured Product':'');?>;
        </td>
        <td></td>
    </tr>
    <?php endwhile;?>
</tbody>
</table>

<?php include_once 'includes/admin_footer.php'; ?>


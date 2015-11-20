<?php
require_once "../core/conn.php";
include_once "includes/admin_head.php";
include_once "includes/admin_navigation.php";
//get brands from database
$sql = "SELECT * FROM brand ORDER BY brand";
$result = $conn->query($sql);
if (!$result) {
        echo "invalid query".mysql_error();
    }
    
?>
<h2 class = 'text-center' >Brands</h2><hr>
<!-- Brand Form -->
<div class = 'text-center'>
    <form class='form-inline' action='admin_brand.php' method='post'>
        <div class ='form-group'>
            <label for ='brand'>Add A Brand</label>
            <input type='text' name ='brand' id ='brand' class='form-control' value='<?php echo ((isset($_POST['brand']))?$_POST['brand']:'');?>'>
            <input type ='submit' name ='add_submit' value ='Add Brand' class ='btn btn-success'>
        </div>       
    </form>
</div><hr>
<table class="table table-bordered table-striped table-auto">
    <thead>
        <th> </th><th>Brand</th><th> </th>  
    </thead>
    <tbody>
        <?php while($brand  = mysqli_fetch_assoc($result)): ?>
        <tr>
        <td><a href ="admin_brands.php?edit=<?php echo $brand['id']; ?>" class = 'btn btn-xs btn-default'><span class ="glyphicon glyphicon-pencil"></span></a> </td>
        <td><?php echo $brand['brand']; ?></td>
        <td><a href ="admin_brands.php?delete=<?php echo $brand['id']; ?>" class = 'btn btn-xs btn-default'><span class ="glyphicon glyphicon-remove-sign"></span></a> </td>
        </tr>
        <?php endwhile; ?>
    </tbody>  
</table>

<?php include_once 'includes/admin_footer.php'; ?>
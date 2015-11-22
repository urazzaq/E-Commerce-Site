<?php
require_once "../core/conn.php";
include_once "includes/admin_head.php";
include_once "includes/admin_navigation.php";
include_once '../helpers/helpers.php';

//get brands from database
$sql = "SELECT * FROM brand ORDER BY brand";
$result = $conn->query($sql);
if (!$result) {
        echo "invalid query".mysql_error();
    }
    
//edit brand
if(isset($_GET['edit'])&& !empty($_GET['edit'])){
    $edit_id = (int)$_GET['edit'];
    $edit_id = sanitize($edit_id);
    $sql2 = "SELECT * FROM brand WHERE id = '$edit_id'";
    $edit_result = $conn->query($sql2);
    $eBrand = mysqli_fetch_assoc($edit_result);
  
}
    
    
//delete brand
if(isset($_GET['delete'])&& !empty($_GET['delete'])){
    $delete_id = (int)$_GET['delete'];
    $delete_id = sanitize($delete_id);
    $sql = "DELETE FROM brand WHERE id = '$delete_id'";
    $conn->query($sql);
     header('Location: admin_brand.php');
}

//if add form is submitted
$errors = array();
if(isset($_POST['add_submit'])){
    $brand = sanitize($_POST['brand']);
    //check if brand is blank
    if($brand ===''){
        $errors[].='You must enter a brand!';
    }
    // check if brand exists in database
    $sql = "SELECT * FROM brand WHERE brand = '$brand'";
    if(isset($_GET['edit'])){
        $sql = "SELECT * FROM brand WHERE brand = '$brand' AND id != '$edit_id'";
    }
    $result = $conn ->query($sql);
    $count = mysqli_num_rows($result);
    if($count > 0){
        $errors[].=$brand." already exists in database!";
    }
    // display errors
    if(!empty($errors)){
        echo display_errors($errors);
   
    }else{
    //Add brand to database 
    $sql = "INSERT INTO brand (brand) VALUES ('$brand')";
        if(isset($_GET['edit'])){
        $sql = "UPDATE brand SET brand = '$brand' WHERE id = '$edit_id'";
        }
   
    $conn ->query($sql);
    header('Location: admin_brand.php');//refresh page
    
    }    
}
?>

<h2 class = 'text-center' >Brands</h2><hr>
<!-- Brand Form -->
<div class = 'container text-center'>
    <form class='form-inline' action="admin_brand.php<?php echo ((isset($_GET['edit']))?'?edit='.$edit_id:'')?>" method='post'>
        <div class ='form-group'>
            <?php 
            $brand_value = ''; 
           if(isset($_GET['edit'])){
            //get current brand value from database   
            $brand_value = $eBrand['brand'];   
            }else{
            // set to new edited brand value    
                if(isset($_POST['brand'])){
                    $brand_value = sanitize($_POST['brand']);
                }
            }
            ?>
            
            <label for ='brand'><?php echo ((isset($_GET['edit']))?'Edit':'Add A')?> Brand</label>
            <input type='text' onmouseover="this.select()" name ='brand' id ='brand' class='form-control' value='<?php echo $brand_value?>'>
            
            <?php if(isset($_GET['edit'])):?>
            <a href="admin_brand.php" class ="btn btn-warning">Cancel</a>
            <?php endif;?>
            
            <input type ='submit' name ='add_submit' value ='<?php echo ((isset($_GET['edit']))?'Edit ':'Add ')?> Brand' class ='btn btn-success'>
        </div>       
    </form>
</div><hr>
<table class="table table-bordered table-striped table-auto table-condensed">
    <thead>
        <th></th><th>Brand</th><th></th>  
    </thead>
    <tbody>
        <?php while($brand  = mysqli_fetch_assoc($result)): ?>
        <tr>
        <td><a href ="admin_brand.php?edit=<?php echo $brand['id']; ?>" class = 'btn btn-xs btn-default'><span class ="glyphicon glyphicon-pencil"></span></a> </td>
        <td><?php echo $brand['brand']; ?></td>
        <td><a href ="admin_brand.php?delete=<?php echo $brand['id']; ?>" class = 'btn btn-xs btn-default'><span class ="glyphicon glyphicon-remove-sign"></span></a> </td>
        </tr>
        <?php endwhile; ?>
    </tbody>  
</table>

<?php include_once 'includes/admin_footer.php'; ?>
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
    $sql ="INSERT INTO brand (brand) VALUES ('$brand')";
    $conn ->query($sql);
    header('Location: admin_brand.php');//refresh page
    
    }    
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
<table class="table table-bordered table-striped table-auto table-condensed">
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
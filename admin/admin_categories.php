<?php
require_once "../core/conn.php";
include_once "includes/admin_head.php";
include_once "includes/admin_navigation.php";
include_once '../helpers/helpers.php';

    $sql = "SELECT * FROM categories WHERE parent = 0 ";
    $result = $conn->query($sql);
    $errors = array();
   
    //Process Form
    if(isset($_POST) && !empty($_POST)){
        $parent = sanitize($_POST['parent']);
        $category = sanitize($_POST['category']);
        $sqlform = "SELECT * FROM categories WHERE category = '$category' AND parent = '$parent'";
        $fresult = $conn->query($sqlform);
        $count = mysqli_num_rows($fresult);
        //if category is blank
        if($category  === ''){
            $errors[].= "The category cannot be left blank";
        }
        //if exists in the database
        if($count > 0){
            $errors[].= $category.' already exists';
        }
        //Display Errors or Update Database
        if(!empty($errors)){
          //display errors
            $display = display_errors($errors);?>
            <script>
                $('document').ready(function(){
                $('#errors').html('<?php echo $display;?>') 
                });
            </script>
            
        <?php } else {
            $updatesql = "INSERT INTO categories (category,parent) VALUES ('$category','$parent')";
            $conn->query($updatesql);
            header('Location: admin_categories.php');//refresh page
        }  
    }
    
?>

<h2 class = 'text-center' >Categories</h2><hr>
<div class = 'row'>    
    
    <!--Form -->
    <div class='col-md-12'>
          <form class ='form' action='admin_categories.php' method="post">
              <legend>Add a Category</legend>
              <div id ='errors'></div>
              <div class='form-group'>
              <label for="parent">Parent</label>
              <select class='form-control' name='parent' id='parent'>;
              <option value='0'>Parent</option>
                     <?php while($parent = mysqli_fetch_assoc($result)):?>
                        <option value='<?php echo $parent['id']?>'><?php echo $parent['category']?></option>
                     <?php endwhile;?>
              </select>  
              </div> 
              <div class='form-group'>
                <label for='category'>Category</label>
                <input type='text' class='form-control' id='category' name='category'>
              </div>
              <div class='form-group'>
                <input type='submit' value='Add Catagory' class='btn btn-success'>
              </div>
          </form>       
    </div>
    
    <!--Category table -->
    <div class='col-md-12'>
        <table class='table table-bordered '>
            <thead class='bg-success'>
            <th>Category</th><th>Parent</th><th></th>
            </thead>
            <tbody>
                <?php
                
                $sql = "SELECT * FROM categories WHERE parent = 0 ";
                $result = $conn->query($sql);
                while($parent = mysqli_fetch_assoc($result)):
                    $parent_id = (int)$parent['id'];
                    $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
                    $childResult = $conn->query($sql2);
                ?>
                <tr class='bg-primary'>
                    <td ><?php echo $parent['category'];?></td>
                    <td>Parent</td>
                    <td>
                        <a href='admin_categories.php?edit=<?php echo $parent['id'];?>' class='btn btm-xs btn-default'>
                            <span class='glyphicon glyphicon-pencil'></span>
                        </a>
                         <a href='admin_categories.php?delete=<?php echo $parent['id'];?>' class='btn btm-xs btn-default'>
                            <span class='glyphicon glyphicon-remove'></span>
                        </a>
                    </td>
                </tr>
                 <?php while($child = mysqli_fetch_assoc($childResult)):?>
                <tr class='bg-info'>
                    <td><?php echo $child['category'];?></td>
                    <td><?php echo $parent['category'];?></td>
                    <td>
                        <a href='admin_categories.php?edit=<?php echo $child['id'];?>' class='btn btm-xs btn-default'>
                            <span class='glyphicon glyphicon-pencil'></span>
                        </a>
                         <a href='admin_categories.php?delete=<?php echo $child['id'];?>' class='btn btm-xs btn-default'>
                            <span class='glyphicon glyphicon-remove'></span>
                        </a>
                    </td>
                </tr>
                    <?php endwhile;?>
                <?php endwhile;?>
            </tbody>
        </table>   
    </div>
 
</div>


<?php include_once 'includes/admin_footer.php'; ?>
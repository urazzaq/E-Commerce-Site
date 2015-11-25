<?php
require_once "../core/conn.php";
include_once "includes/admin_head.php";
include_once "includes/admin_navigation.php";
include_once '../helpers/helpers.php';  
$dbpath ='';   
$insertSql ='';
//add product
if (isset($_GET['add'])||isset($_GET['edit']) ) {
    $brandQuery = $conn->query('SELECT * FROM brand ORDER BY brand');
    $parentQuery = $conn->query('SELECT * FROM categories WHERE parent = 0 ORDER BY category');
    $title = ((isset($_POST['title'])&& $_POST['title'] != '')?sanitize($_POST['title']):'');
    $brand = ((isset($_POST['brand'])&& !empty($_POST['brand']))?sanitize($_POST['brand']):'');
    $parent = ((isset($_POST['parent'])&& !empty($_POST['parent']) )?sanitize($_POST['parent']):'');
    $category = ((isset($_POST['child'])&& !empty($_POST['child']))?sanitize($_POST['child']):'');
    $price = ((isset($_POST['price'])&& $_POST['price'] != '')?sanitize($_POST['price']):'');
    $list_price = ((isset($_POST['list_price'])&& $_POST['list_price'] != '')?sanitize($_POST['list_price']):'');
    $description = ((isset($_POST['description'])&& $_POST['description'] != '')?sanitize($_POST['description']):'');
    $sizes = ((isset($_POST['sizes '])&& $_POST['sizes '] != '')?sanitize($_POST['sizes ']):'');
    $sizes = rtrim($sizes,',');
    $saved_image = '';
  
   

// retreving input from databases to populate 
if(isset($_GET['edit'])){
    $edit_id = (int)$_GET['edit'];
    $productResults = $conn->query("SELECT * FROM products WHERE id ='$edit_id'");
    $product = mysqli_fetch_assoc($productResults);
    
//unset image if delete selected and update db
    if(isset($_GET['delete_image'])){
        $image_url =$_SERVER['DOCUMENT_ROOT'].$product['image'];
        unlink($image_url);
        $conn->query("UPDATE products SET image='' WHERE id='$edit_id'");
        header('Location: admin_products.php?edit='.$edit_id); //refresh page
    }
    
    $title = ((isset($_POST['title'])&& $_POST['title']!= "")?sanitize($_POST['title']):$product['title']);
    $brand = ((isset($_POST['brand'])&& $_POST['brand'] != "")?sanitize($_POST['brand']):$product['brand']);
    $category= ((isset($_POST['child'])&& $_POST['child'] != "")?sanitize($_POST['child']):$product['categories']);
    $pQuery = $conn->query("SELECT * FROM categories WHERE id ='$category'");
    $parentResult = mysqli_fetch_assoc($pQuery);
    $parent = ((isset($_POST['parent'])&& $_POST['parent']!= "")?sanitize($_POST['parent']):$parentResult['parent']);
    $price= ((isset($_POST['price'])&& $_POST['price']!= "")?sanitize($_POST['price']):$product['price']);
    $list_price= ((isset($_POST['list_price'])&& $_POST['list_price']!= "")?sanitize($_POST['list_price']):$product['list_price']);
    $description= ((isset($_POST['description'])&& $_POST['description']!= "")?sanitize($_POST['description']):$product['description']);
    $sizes = ((isset($_POST['sizes'])&& $_POST['sizes']!= "")?sanitize($_POST['sizes']):$product['sizes']);
    $sizes = rtrim($sizes,',');
    $saved_image = (($product['image'] != '')?$product['image']:'');
    $dbpath = $saved_image;
}    
    //build sizes array
        if (!empty($sizes)) {
            $sizeString = sanitize($sizes);
            $sizeString = rtrim($sizeString, ',');
            $sizesArray = explode(',', $sizeString);
            $sArray = array();
            $qArray = array();
            //separate size and quantity 
            foreach ($sizesArray as $ss) {
                $s = explode(':', $ss);
                $sArray[] = $s[0];
                $qArray[] = $s[1];
            }
        } else {
            $sizesArray = array();
        }

//build add product array 
    if ($_POST){
        $dbpath =''; 
        $errors = array();
        //form validation
        $required = array('title', 'brand', 'price', 'parent', 'child', 'sizes');
        foreach ($required as $field) {
            if ($_POST[$field] == '') {
                $errors[].= 'All Fields are Required';
                break;
            }
        }
        //validate photo
        if (!empty($_FILES)) {
            var_dump($_FILES);
            $photo = $_FILES['photo'];
            $name = $photo['name'];
            $nameArray = explode('.', $name);
            $fileName = $nameArray[0];
            $fileExt = $nameArray[1];
            $mime = explode('/',$photo['type']);
            $mimeType = $mime[0];
            $mimeExt = $mime[1];
            $tmpLoc = $photo['tmp_name'];
            $fileSize = $photo['size'];
            $allowed = array('png','jpg','jpeg','gif');
            $uploadName = md5(microtime()).'.'.$fileExt; echo $uploadName."<br>";
         
            $uploadPath = $_SERVER['DOCUMENT_ROOT']."/images/".$uploadName; echo $uploadPath."<br>";
            $dbpath = "/images/".$uploadName; echo $dbpath."<br>";
           
            if($mimeType!='image'){
                $errors[].='The File must be an Image';
            }
            if(!in_array($fileExt,$allowed)){
                $errors[].="The file extension must be a png, jpeg, jpg, gif.";
            }
            if($fileSize > 15000000){
                $errors[].="file size must be under 15MB";
            }
//            if($fileExt!=$mimeExt && ($mimeExt == 'jpeg' && $fileExt!= 'jpeg')){
//                 $errors[].="File Extension does not match the file";
//            }
        }
            if (!empty($errors)) {
                echo display_errors($errors);
            } else {
                //upload file and insert into database
                move_uploaded_file($tmpLoc, $uploadPath);
                $insertSql = "INSERT INTO products (`title`,`price`,`list_price`,`brand`,`categories`,`image`,`description`,`sizes`) VALUES ('$title','$price','$list_price','$brand','$category','$dbpath','$description','$sizes')";
                //edit image
                if(isset($_GET['edit'])){
                $insertSql = "UPDATE products SET title = '$title', price = '$price', list_price = '$list_price', brand = '$brand', categories = '$category', image = '$dbpath', description = '$description', sizes = '$sizes' WHERE id = '$edit_id' ";
                }
                $conn->query($insertSql);
                header('Location: admin_products.php'); //refresh page
               
         
            }    
    }
        ?>    
        <!--add product form-->
        <h2 class="text-center"><?php echo((isset($_GET['edit']))?'Edit':'Add');?> Product</h2><hr>
        <form action="admin_products.php?<?php echo((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?> " method="post" enctype="multipart/form-data">
            <div class="form-group col-md-3">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" id="title" value="<?php echo $title ?>">
            </div>
            <div class="form-group col-md-3">
                <label for="brand">Brand</label>
                <select class="form-control" id="brand" name="brand" >
                    <option value="" <?php echo(( $brand == "" ) ? ' selected' : ''); ?> ></option>
                    <?php while ($b = mysqli_fetch_assoc($brandQuery)): ?>
                        <option value="<?php echo $b['id']; ?>" <?php echo (($brand == $b['id'] ) ? ' selected' : ''); ?> ><?php echo $b['brand']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="parent">Parent Category</label>
                <select class="form-control" id="parent" name="parent" >
                    <option value="" <?php echo(($parent == "" ) ? ' selected' : ''); ?> ></option>
                    <?php while ($p = mysqli_fetch_assoc($parentQuery)): ?>
                        <option value="<?php echo $p['id']; ?>" <?php echo(( $parent== $p['id'] ) ? ' selected' : ''); ?> ><?php echo $p['category']; ?></option>
                    <?php endwhile; ?>    
                </select>
            </div>
            <div class='form-group col-md-3'>
                <label for="child">Child Category</label>
                <select class="form-control" id="child" name="child" ></select>
            </div>
            <div class="form-group col-md-3">
                <label for="price">Price</label>
                <input type='text' id="price" name="price" class='form-control' value="<?php echo $price ; ?>">
            </div>
            <div class="form-group col-md-3">
                <label for="price">List Price</label>
                <input type='text' id="list_price" name="list_price" class='form-control' value="<?php echo $list_price; ?>">
            </div>
            <div class="form-group col-md-3">
                <label>Sizes and Quantity</label>
                <button class='btn btn-default form-control' onclick="$('#sizesModal').modal('toggle');
                        return false">Sizes and Quantity</button>
            </div>
            <div class="form-group col-md-3">
                <label for="sizes">Sizes & Qty Preview</label>
                <input class="form-control" type="text" name="sizes" id="sizes" value="<?php echo $sizes; ?>" readonly>
            </div>
            <div class="form-group col-md-6">
               
                <?php if($saved_image!=''): ?>
                <div class="saved-image">
                    <img src="<?php echo $saved_image?>"alt="saved_image"/><br>
                    <a href="admin_products.php?delete_image=1&edit=<?php echo $edit_id?>" class="text-danger">Delete Image</a>
                </div>
                <?php else:?>
                <label for="photo">Product Photo</label>
                <input type="file" name="photo" id="photo" class='form-control' value="Add Product Photo" >
                <?php endif;?>
           
            </div>
            <div class="form-group col-md-6">
                <label for="description">Product Description</label>
                <textarea type="text" name="description" id="description" class="form-control" rows="6"><?php echo $description; ?></textarea>
            </div>
            
            <div class="form-group pull-right">
                <a href="admin_products.php" class="btn btn-default btn-danger">Cancel</a>
                <input type="submit" value="<?php echo((isset($_GET['edit']))?'Edit Product':'Add Product');?> " class="btn btn-success">
            </div><div class="clearfix"></div>
        </form>

        <!-- Modal -->
        <div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel">
            <div class="modal-dialog  modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="sizesModalLabel">Size & Quantitiy</h4>
                    </div>
                    <div class="modal-body">
                        <div class='container-fluid'>
                            <?php for ($i = 1; $i <= 6; $i++): ?>
                                <div class="form-group col-md-4">
                                    <label for="size<?php echo $i; ?>">Size:</label>
                                    <input type="text" name="size<?php echo $i; ?>" id="size<?php echo $i; ?>" value="<?php echo ((!empty($sArray[$i - 1])) ? $sArray[$i - 1] : ''); ?>" class='form-control'>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="qty<?php echo $i; ?>">Quantity:</label>
                                    <input  type="number" name="qty<?php echo $i; ?>" id="qty<?php echo $i; ?>" value="<?php echo ((!empty($qArray[$i - 1])) ? $qArray[$i - 1] : ''); ?>" min="0" class='form-control'>
                                </div>

                            <?php endfor; ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="updateSizes();
                                $('#sizesModal').modal('toggle');
                                return false">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }else {


        $sql = "SELECT * FROM products WHERE deleted = 0";
        $presults = $conn->query($sql);
        if (isset($_GET['featured'])) {
            $id = (int)$_GET['id'];
            $featured = (int)$_GET['featured'];
            $fsql = "UPDATE products SET featured = '$featured' WHERE id='$id'";
            $conn->query($fsql);
            header('Location: admin_products.php'); //refresh page
        }
        ?>
        <!--products table-->
        <h2 class="text-center">Products</h2>
        <a href="admin_products.php?add=1" class="btn btn-success pull-right" id="add-product-button">Add Product</a>
        <div class="clearfix"></div>
        <hr>
        <table style="width:70%" class="table table-auto table-bordered table-striped">
            <thead><th></th><th>Product</th><th>Price</th><th>Category</th><th>Featured</th><th>Sold</th></thead>
        <tbody>
            <?php
            while ($product = mysqli_fetch_assoc($presults)):
                $childID = $product['categories'];
                $catSql = "SELECT * FROM categories WHERE id ='$childID'";
                $result = $conn->query($catSql);
                $child = mysqli_fetch_assoc($result);
                $parentID = $child['parent'];
                $pSql = "SELECT * FROM categories WHERE id ='$parentID'";
                $presult = $conn->query($pSql);
                $parent = mysqli_fetch_assoc($presult);
                $category = $parent['category'] . '~' . $child['category'];
                ?>
                <tr>
                    <td>
                        <a href="admin_products.php?edit=<?php echo $product['id'] ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
                        <a href="admin_products.php?delete=<?php echo $product['id'] ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></a>
                    </td>
                    <td><?php echo $product['title'] ?></td>
                    <td><?php echo money($product['price']) ?></td>
                    <td>
            <?php echo $category ?>  
                    </td> 
                    <td>  
                        <a href="admin_products.php?featured=<?php echo (($product['featured'] == 0) ? '1' : '0'); ?>&id=<?php echo $product['id']; ?>" class="btn btn-xs btn-default" >
                            <span class="glyphicon glyphicon-<?php echo (($product['featured'] == 1) ? 'minus' : 'plus' ); ?>" ></span></a>
                        &nbsp <?php echo (($product['featured'] == 1) ? 'featured' : 'unfeatured'); ?>
                    </td>
                    <td>

                    </td>
                </tr>
        <?php endwhile; ?>
        </tbody>
        </table>

    <?php } include_once 'includes/admin_footer.php'; ?>
    <script>
    $('document').ready(function(){
      get_child_options('<?php echo $category?>');  
    });
    
    </script>

<!--Details Modal-->
<?php
require_once 'core/conn.php';
$id = $_POST['id'];// access post variable of id
$id = (int)$id;
$sql = "SELECT * FROM products WHERE id = '$id'";
$result = $conn->query($sql);
if (!$result) {
        echo "invalid query".mysql_error();
    }
$product = mysqli_fetch_assoc($result); // set product assoc arr of current Post value of corrosponding product to id
$brand_id = $product['brand'];
$sql = "SELECT brand FROM brand WHERE id = '$brand_id'";
$brand_query = $conn->query($sql);
if (!$brand_query) {
        echo "invalid query".mysql_error();
    }
$brand = mysqli_fetch_assoc($brand_query);
$sizestring = $product['sizes'];
$size_array = explode(',',$sizestring);
?>
<!--Start Buffer-->
<?php ob_start(); ?>
<div class = "modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
    <div class = "modal-dialog modal-lg">
        <div class = "modal-content">
                <div class = "modal-header">
                    <button class = "close" type = "button" onclick="closeModal()" aria-label="Close">
                        <span aria-hidden= "true">&times;</span>
                    </button>
                    <h4 class = "modal-title text-center"><?php echo $product['title']; ?></h4>
                </div>
                <div class = "modal-body">
                    <div class="container-fluid">
                        <div class = "row">
                            <div class= "col-sm-6">
                                <div class = "center-block">
                                    <img src = "<?php echo $product['image']; ?>" height = 500px width = 500px alt = "<?php echo $product['title']; ?>" class = "details img-responsive" />
                                </div>
                            </div>   
                            <div class= "col-sm-6">
                                <h4>Details<h4>                  
                                <p><?php echo $product['description']; ?></p>
                                <hr>
                                <p>Price: <?php echo $product['price']; ?></p>
                                <p>Brand: <?php echo $brand['brand']; ?></p>
                                <form action="add_cart.php" method ="post">
                                    <div class = "form-group">
                                        <div class = "col-xs-3">
                                            <label for="quantity">Quantity:</label>                                        
                                            <input type="text" class = "form-control" id="quantity" name="quantity">
                                        <div class ="form-group">
                                            <label for='size'>Size</label>
                                            <select name ="size" id ="size" class ="form-control">
                                                <option value = ""></option>
                                                <?php foreach($size_array as $string){
                                                    $string_array = explode(':',$string);
                                                    $size = $string_array[0];
                                                    $quantity = $string_array[1];
                                                    echo '<option value = "'.$size.'">'.$size.' ('.$quantity.' Available)</option>' ;    
                                                } ?>
                                               
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>	
                </div>
                <div class ="modal-footer">
                    <button class = "btn btn-default" onclick="closeModal()">Close</button>
                    <button class = "btn btn-warning" type="submit"><span class="glyphicon glyphicon-shopping-cart"></span>Add to Cart</button>
                </div>
        </div>	
    </div>
</div>
<!--Close modal function-->
<script>
    function closeModal(){
        jQuery('#details-modal').modal('hide');
        setTimeout(function(){
            jQuery('#details-modal').remove();
            jQuery('.modal-backdrop').remove();
        },500);
    }
    
</script>
    

<?php echo ob_get_clean(); ?>
<!--End Buffer-->

<?php
include_once "includes/head.php";
include_once "includes/navigation.php";
include_once "includes/header_partial.php";
include_once 'helpers/helpers.php';
include_once 'core/conn.php';

if(isset($_GET['cat'])){
    $cat_id = sanitize($_GET['cat']);
}else{
    $cat_id = '';
}
$sql = "SELECT * FROM products WHERE categories = '$cat_id' ";
$productQuery = $conn->query($sql);
$category = get_category($cat_id);

?>
<div class= "container-fluid">
    <?php include_once "includes/leftbar.php"; ?>
   
    <!--Main Content -->
    <div class="col-md-8">
        <div class="row">
            <h2 class ="text-center"><?= $category['parent'].' '.$category['child']?></h2>

            <?php while ($products = mysqli_fetch_assoc($productQuery)) : ?>
                <div class = "col-sm-3 text-center">
                    <h4><b><?php echo $products['title']; ?> </b><hr></h4> 
                    <img src="<?php echo $products['image']; ?>" alt ="<?php $products['title']; ?>" class = "img-size" />
                    <p class="list-price text-danger">List Price<s> <?php echo$products['list_price']; ?></s></p>
                    <p class="price">Our Price: $<?php echo$products['price']; ?></p>
                    <button type = "button"  class ="btn btn-sm btn-success" onclick="detailsModal(<?php echo $products['id']; ?>)">Details</button>
                </div>
          
            <?php endwhile; ?>  

        </div>
    </div>
    <?php include_once "includes/rightbar.php"; ?>
    <?php include_once "includes/footer.php"; ?>


</body>
</html>

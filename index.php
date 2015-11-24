
<?php
include_once "includes/head.php";
include_once "includes/navigation.php";
include_once "includes/header.php";
include_once 'core/conn.php';

$sql = "SELECT * FROM products WHERE featured = 1 ";
$featured = $conn->query($sql);
if (!$featured) {
    echo "invalid query";
}
?>
<div class= "container-fluid">
    <?php include_once "includes/leftbar.php"; ?>
    <?php include_once "indludes/detailsModal.php";?>
    <!--Main Content -->
    <div class="col-md-8">
        <div class="row">
            <h2 class ="text-center">Featured Products</h2>

            <?php while ($products = mysqli_fetch_assoc($featured)) : ?>
                <div class = "col-sm-3 text-center">
                    <h4><b><?php echo $products['title']; ?> </b></h4> 
                    <img src="<?php echo $products['image']; ?>" alt ="<?php $products['title']; ?>" class = "img-size" />
                    <p class="list-price text-danger">List Price<s> <?php echo$products['list_price']; ?></s></p>
                    <p class="price">Our Price: $<?php echo$products['price']; ?></p>
                    <button type = "button" class ="btn btn-sm btn-success" onclick="detailsModal(<?php echo $products['id']; ?>)">Details</button>
                </div>
            <?php endwhile; ?>

        </div>
    </div>
    
    <?php include_once "includes/rightbar.php"; ?>
    
   
    <?php include_once "includes/footer.php"; ?>

<script>alert('Not a real E-commerce site! for showcase purposed only WIP,View in IE11 instead Chrome may caused issues with form selection "being fixed"');</script>
</body>
</html>

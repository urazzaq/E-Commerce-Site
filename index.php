
<?php
include_once "head.php";
include_once "navigation.php";
include_once "Header.php";
include_once 'conn.php';

$sql = "SELECT * FROM products WHERE featured = 1 ";
$featured = $conn->query($sql);
if (!$featured) {
    echo "invalid query";
}
?>
<div class= "container-fluid">
    <?php include_once "leftbar.php"; ?>
    <?php include_once "DetailsModal.php";?>
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
    
    <?php include_once "rightbar.php"; ?>
    
    <script> alert("WIP!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!Warning , Internet explorer not recomended, may cause placement issues\n\
Disclaimer: This website is for academic and showcase pupososes only. we are not a real e-commerce site!");</script>

    <?php include_once "footer.php"; ?>


</body>
</html>

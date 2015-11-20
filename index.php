
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
    
    <script> alert("WIP!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!Warning , Internet explorer not recomended, may cause placement issues\n\
Disclaimer: This website is for academic and showcase pupososes only. we are not a real e-commerce site!");</script>

    <?php include_once "includes/footer.php"; ?>


</body>
</html>

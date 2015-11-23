<?php
    require_once '../core/conn.php';
    $pID = (int)$_POST['parentID'];
    $childQuery = $conn->query("SELECT * FROM categories WHERE parent ='$pID' ORDER BY category");
    ob_start();
?>
<option value=''></option>
<?php while($child = mysqli_fetch_assoc($childQuery)):?>
<option value="<?php echo $child['id']?>"><?php echo $child['category']?></option>
 <?php endwhile;?> 
<?php echo ob_get_clean();//pass back as data for ajax request ?>



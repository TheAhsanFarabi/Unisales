<?php include('header.php') ?>


<?php 
if($u['user_type']==1){
  $seller = $u['id'];
  $orders = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM orders JOIN users ON orders.buyer=users.id WHERE seller = $seller ORDER BY order_id DESC"), MYSQLI_ASSOC);

}

if($u['user_type']==2) {
  $buyer = $u['id'];
  $orders = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM orders JOIN users ON orders.buyer=users.id WHERE buyer = $buyer ORDER BY order_id DESC"), MYSQLI_ASSOC);
}
  
?>




<div class="container">
    <h1 class="display-1 mt-5 fw-bolder text-center">All Orders</h1>

    <?php foreach($orders as $o) {  ?>

    <?php 
$seller_info = ($conn->query("SELECT * FROM users WHERE id = ".$o['seller']))->fetch_assoc();
$buyer_info = ($conn->query("SELECT * FROM users WHERE id = ".$o['buyer']))->fetch_assoc();
?>


    <?php 
if($o['prop_id']){
$p_id = $o['prop_id'];
$sql = "SELECT * FROM props WHERE p_id=$p_id";
$result = $conn->query($sql);
$product = $result->fetch_assoc(); 
$title = $product['p_title'];
$price = $product['p_price'];
$img = 'data/props/'.$product['p_img'];
$type = 'PROP';
}
else {
  $g_id = $o['gig_id'];
$sql = "SELECT * FROM gigs WHERE g_id=$g_id";
$result = $conn->query($sql);
$product = $result->fetch_assoc(); 
$title = $product['g_title'];
$price = $product['g_price'];
$img = 'data/gigs/'.$product['g_img'];
$type = 'GIG';
}
?>
    <div class="alert alert-light border border-5" role="alert">



        <div class="row">
            <div class="col">
                <img src="<?= $img ?>" width="200px" class="img-thumbnail rounded-5 shadow" />
                <?php if($o['is_paid_full']==1) { ?>
                    <div class="alert alert-success rounded-5 w-50 p-2 mt-2 text-center" role="alert">Completed</div>
                <?php } elseif($o['is_paid_half']==1) { ?>
                    <div class="alert alert-warning rounded-5 w-50 p-2 mt-2 text-center" role="alert">In Progress</div>
                <?php } else { ?>
                    <div class="alert alert-danger rounded-5 w-50 p-2 mt-2 text-center" role="alert">Not Complete</div>
                <?php } ?>
                
                
                
        </div>
            <div class="col">
                <h3>Order ID: <?= $o['order_id'] ?></h3>
                <p>Product Title: <b><?= $title ?><?php echo " (". "$type" .")" ?></b></p>
                <p>Price: <b><?= $price ?> BDT</b></p>
                <p>Sending to: <b><?= $o['address'] ?></b></p>
                <p>Order Time: <b><?= date("F j, Y, g:i a", strtotime($o['time'])) ?></b></p>
                <a href="order_details.php?order_id=<?= $o['order_id'] ?>" class="btn btn-outline-dark rounded-pill">Check and Update Status</a>
            </div>

        </div>



    </div>


    <?php } ?>
</div>




<script>
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
</script>




<?php include('footer.php') ?>
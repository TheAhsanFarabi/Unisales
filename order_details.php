<?php include('header.php') ?>
<style>
.progress-bar-step1 {
    background-color: #3498db;
    /* Blue color */
}

.progress-bar-step2 {
    background-color: #e74c3c;
    /* Red color */

}

.progress-bar-step3 {
    background-color: #e67e22;
    /* Orange color */
}

.progress-bar-step4 {


    background-color: skyblue;
    /* sky_blue */
}

.progress-bar-step5 {


    background-color: #2ecc71;
    /* Green color */
}


.image-radio-list {
    list-style-type: none;
    padding: 0;
}

.image-radio-list label {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    cursor: pointer;
    border: 2px solid #B2BEB5;
    border-radius: 1rem;
    padding: 10px;
}

.image-radio-list input[type="radio"] {
    display: none;
}

.image-radio-list img {
    width: 50px;
    height: 50px;
    margin-right: 10px;
    border-radius: 50%;
}

.image-radio-list input[type="radio"]:checked+label {
    background-color: #f0f0f0;
    /* Highlight the selected option */
}
</style>

<?php 


$sql = "SELECT * FROM orders WHERE order_id=" . $_GET['order_id'];
$result = $conn->query($sql);
$order = $result->fetch_assoc(); 

$seller_info = ($conn->query("SELECT * FROM users WHERE id = ".$order['seller']))->fetch_assoc();
$buyer_info = ($conn->query("SELECT * FROM users WHERE id = ".$order['buyer']))->fetch_assoc();

if($order['prop_id']){
    $p_id = $order['prop_id'];
    $sql = "SELECT * FROM props WHERE p_id=$p_id";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc(); 
    $title = $product['p_title'];
    $price = $product['p_price'];
    $amount = $product['p_amount'];
    $img = 'data/props/'.$product['p_img'];
    $type = 'PROP';
    }
    else {
    $g_id = $order['gig_id'];
    $sql = "SELECT * FROM gigs WHERE g_id=$g_id";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc(); 
    $title = $product['g_title'];
    $price = $product['g_price'];
    $amount = $product['g_amount'];
    $img = 'data/gigs/'.$product['g_img'];
    $type = 'GIG';
}

// IS_PAID 50%
if(isset($_POST['paid_half_confirm'])){
    $order_id = $_POST['order_id'];
    $price = $_POST['price'];
    //$amount = $_POST['amount'];
    $seller = $_POST['seller'];
    $buyer = $_POST['buyer'];
    $transport = $_POST['transport'];
    $destination = $_POST['destination'];

    $transportation = ($conn->query("SELECT * FROM transportations WHERE truckName = '$transport' "))->fetch_assoc();
    if($transportation['orders']!=''){
        $updatedOrders = $transportation['orders'] . ',' . $order_id;
    }
    else $updatedOrders =  $order_id;

    if($transportation['capacity']>=$transportation['orders_size']+$amount){

        $conn->query("UPDATE transportations SET orders = '$updatedOrders', orders_size = orders_size + $amount WHERE truckName = '$transport' ");

        mysqli_query($conn, "UPDATE orders SET is_paid_half=1, transport='$transport' WHERE order_id=$order_id");
        mysqli_query($conn, "UPDATE users SET balance=balance+$price/2 WHERE id=$seller");
        mysqli_query($conn, "UPDATE users SET balance=balance-$price/2 WHERE id=$buyer");


        if($transportation['capacity']==$transportation['orders_size']+$amount) {
            mysqli_query($conn, "UPDATE transportations SET flag=1 WHERE truckName='$transport' ");
         }
        
        echo '<script>';
        echo 'setTimeout(function() { window.location.href = window.location.href; }, 500);'; // reload after 0.5 seconds
        echo '</script>';

    }
    else {
        echo "<h1>" . "Plz Choose another Transport. Space not availabe" . "</h1>";
    }


  }
  
  // ORDER_CONFIRM
  if(isset($_POST['order_confirm'])) {
    $order_id = $_POST['order_id'];
    mysqli_query($conn, "UPDATE orders SET order_confirm=1 WHERE order_id=$order_id");
      // Reload the page using JavaScript with a different approach
      echo '<script>';
      echo 'setTimeout(function() { window.location.href = window.location.href; }, 500);'; // reload after 0.5 seconds
      echo '</script>';
  
  }
  
  
  // IS_DELIVERY_STARTED
  // IS_DELIVERY_FINISHED
  
  
  // IS_PAID 100%
  if(isset($_POST['paid_full_confirm'])){
    $order_id = $_POST['order_id'];
    $price = $_POST['price'];
    $seller = $_POST['seller'];
    $buyer = $_POST['buyer'];
    // NEW UPDATE
    $result = $conn->query("SELECT transport FROM orders WHERE order_id=$order_id");
    $or = $result->fetch_assoc(); 
    $transport = $or['transport'];


    mysqli_query($conn, "UPDATE orders SET is_paid_full=1 WHERE order_id=$order_id");
    mysqli_query($conn, "UPDATE users SET balance=balance+$price/2 WHERE id=$seller");
    mysqli_query($conn, "UPDATE users SET balance=balance-$price/2 WHERE id=$buyer");

    // UPDATE
    mysqli_query($conn, "UPDATE transportations SET orders_size = orders_size - $amount  WHERE truckName = '$transport' ");
    

// FINAL CHECK BEFORE RESET
    $transportation = ($conn->query("SELECT orders_size FROM transportations WHERE truckName = '$transport' "))->fetch_assoc();
    
    if($transportation['orders_size']==0){

        mysqli_query($conn, "UPDATE transportations SET orders='', orders_size=0, flag=0 WHERE truckName = '$transport' ");

    }
    
      // Reload the page using JavaScript with a different approach
      echo '<script>';
      echo 'setTimeout(function() { window.location.href = window.location.href; }, 500);'; // reload after 0.5 seconds
      echo '</script>';
  }

?>

<div class="container my-5">
    <h1 class="text-center">Order Details</h1>

    <div class="alert alert-light border border-5 rounded-5" role="alert">
        <div class="row">
            <div class="col"><img src="<?= $img ?>" width="200px" class="img-thumbnail shadow rounded-5" /></div>
            <div class="col">
                <h3>Order ID: <?= $order['order_id'] ?></h3>
                <p>Product Title: <b><?= $title ?><?php echo " (". "$type" .")" ?></b></p>
                <p>Price: <b><?= $price ?> BDT</b></p>
                <p>Sending to: <b><?= $buyer_info['address'] ?></b></p>
                <p>Order Time: <b><?= date("F j, Y, g:i a", strtotime($order['time'])) ?></b></p>
            </div>

        </div>

    </div>

    <div class="container d-flex justify-content-center">
        <?php if($u['user_type']==2) { ?>

        <?php if($order['is_paid_half']==0 & $order['order_confirm']==0 & $order['is_delivery_started']==0 & $order['is_delivery_finished']==0 & $order['is_paid_full']==0) { ?>
        <button type="button" class="btn btn-lg btn-outline-primary rounded-pill mt-5 mx-auto" data-bs-toggle="modal"
            data-bs-target="#is_paid_half">
            Confirm Payment 50%
        </button>
        <?php } ?>
        <?php if($order['is_paid_half']==1 & $order['order_confirm']==1 & $order['is_delivery_started']==1 & $order['is_delivery_finished']==1 & $order['is_paid_full']==0) { ?>
        <button type="button" class="btn btn-lg btn-outline-success rounded-pill mt-5 mx-auto" data-bs-toggle="modal"
            data-bs-target="#is_paid_full">
            Confirm Payment 100%
        </button>
        <?php } ?>
        <?php } ?>
        <?php if($u['user_type']==1) { ?>
        <?php if($order['is_paid_half']==1 & $order['order_confirm']==0 & $order['is_delivery_started']==0 & $order['is_delivery_finished']==0 & $order['is_paid_full']==0) { ?>
        <button type="button" class="btn btn-lg btn-outline-danger rounded-pill mt-5 mx-auto" data-bs-toggle="modal"
            data-bs-target="#confirm_order">
            Confirm Order
        </button>
        <?php } ?>
        <?php } ?>

        <?php if($order['is_paid_full']==1) { ?>
        <p class="display-5 text-success"><b>Congratulations!</b> Your order is successfully done</p>
        <?php } ?>
    </div>

    <div class="container row d-flex align-items-center">
        <div class="col d-flex flex-column text-center text-muted"> <i class="fa-solid fa-location-dot fs-1"></i>
        <p>From</p>
            <h4><?= $seller_info['address'] ?></h4>
        </div>
        <div class="px-5 py-0 border border-3 col-7" style="height:5px"></div>
        <div class="col d-flex flex-column text-center text-muted"><i class="fa-solid fa-location-dot fs-1"></i>
        <p>To</p>
            <h4><?= $buyer_info['address'] ?></h4>
        </div>


    </div>

    <div class="container mt-5">
        <h2 class="text-center pb-3">Order Progress Bar</h2>
        <div class="progress">
            <div class="progress-bar<?= $order['order_id'] ?> progress-bar-step1" role="progressbar" style="width: 0%;"
                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="d-flex justify-content-between mt-2">
            <div class="my-5 mx-3  text-center">
                <i class="fa-solid fa-sack-dollar fs-3 text-primary" id="icon1"></i><br>
                <small class=" text-primary">50% paid</small>
            </div>
            <div class="my-5 mx-3  text-center">
                <i class="fa-solid fa-handshake fs-3 text-danger" id="icon1"></i><br>
                <small class=" text-danger">Order Confirm</small>
            </div>
            <div class="my-5 mx-3 text-center">
                <i class="fa-solid fa-truck-fast fs-3 text-warning" id="icon2"></i><br>
                <small class=" text-warning">Delivery Started</small>
            </div>
            <div class="my-5 mx-3 text-center">
                <i class="fa-solid fa-truck-fast fs-3 text-info" id="icon3"></i><br>
                <small class=" text-info">Delivery Finished</small>
            </div>
            <div class="my-5 mx-3 text-center">
                <i class="fa-solid fa-sack-dollar fs-3 text-success" id="icon4"></i><br>
                <small class=" text-success">100% paid</small>
            </div>

        </div>


        <script>
        // Replace these with your actual variable values
        var variableA<?= $order['order_id'] ?> = <?= $order['is_paid_half'] ?>; // BY COMPANY
        var variableB<?= $order['order_id'] ?> = <?= $order['order_confirm'] ?>; // BY FARMER
        var variableC<?= $order['order_id'] ?> = <?= $order['is_delivery_started'] ?>; // BY TRANSPORTATION
        var variableD<?= $order['order_id'] ?> = <?= $order['is_delivery_finished'] ?>; // BY TRANSPORTATION
        var variableE<?= $order['order_id'] ?> = <?= $order['is_paid_full'] ?>; // BY COMPANY

        // Calculate the percentage based on the variables
        var percentage = (variableA<?= $order['order_id'] ?> + variableB<?= $order['order_id'] ?> +
            variableC<?= $order['order_id'] ?> + variableD<?= $order['order_id'] ?> +
            variableE<?= $order['order_id'] ?>) * 20;

        // Set the width of the progress bar and apply the appropriate class
        var progressBar = document.querySelector('.progress-bar<?= $order['order_id'] ?>');
        progressBar.style.width = percentage + '%';

        // Apply the appropriate color class based on the percentage
        if (percentage <= 20) {
            progressBar.classList.add('progress-bar-step1');
        } else if (percentage <= 40) {
            progressBar.classList.add('progress-bar-step2');
        } else if (percentage <= 60) {
            progressBar.classList.add('progress-bar-step3');
        } else if (percentage <= 80) {
            progressBar.classList.add('progress-bar-step4');
        } else {
            progressBar.classList.add('progress-bar-step5');
        }

        progressBar.setAttribute('aria-valuenow', percentage);
        </script>


    </div>





    <style>
    .image-container {
        position: relative;
        overflow: hidden;
    }

    .image-container img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        /* Maintain aspect ratio and cover the container */
    }
    </style>
    <div class="row text-center">
        <div class="col-sm rounded-5 border border-3 container image-container mx-2 p-3">
            <h4>Seller Info</h4>
            <img src="data/profiles/<?= $seller_info['img'] ?>" class="img-fluid rounded-5" alt="Seller Image" /><br>
            <a href="profile.php?id=<?= $seller_info['id'] ?>" class="fs-4 fw-bolder"><?= $seller_info['name'] ?></a>
        </div>

        <div class="col-sm rounded-5 border border-3 container image-container mx-2 p-3">
            <h4>Buyer Info</h4>
            <img src="data/profiles/<?= $buyer_info['img'] ?>" class="img-fluid rounded-5" alt="Buyer Image" /><br>
            <a href="profile.php?id=<?= $buyer_info['id'] ?>" class="fs-4 fw-bolder"><?= $buyer_info['name'] ?></a>
        </div>
        <div class="col-sm rounded-5 border border-3 container image-container mx-2 p-3">
            <?php if(!$order['transport']){
                echo "No Transport Selected";

            }
            else{ ?>

            <h4>Selected Transport</h4>
            <img src="assets\images\<?= $order['transport'] ?>.png" class="img-fluid" alt="Transport Image" />
            <p class="fs-4 fw-bolder"><?= $order['transport'] ?></p>


            <?php } ?>

        </div>
    </div>


</div>



<!-- Modal is_paid_half -->
<div class="modal fade" id="is_paid_half" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Conform Payment 50%</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </button>
            </div>
            <div class="modal-body text-center">
                <i class="fa-solid fa-sack-dollar display-1"></i>
                <p>I accept the <a href="#">terms and condition</a> that I will pay 50% before the delivery starts
                </p>

                <form method="POST">

                    <?php 

$trucks = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM transportations"), MYSQLI_ASSOC);

 
 ?>

                    <div class="form-group">
                        <label for="transport">Choose A Transport</label>
                        <ul class="image-radio-list">
                            <?php foreach($trucks as $t) { ?>



                            <li>
                                <input type="radio" id="<?= $t['truckName']; ?>" name="transport"
                                    value="<?= $t['truckName']; ?>">
                                <label for="<?= $t['truckName']; ?>"><img
                                        src="assets/images/<?= $t['truckName']; ?>.png">
                                    <?= $t['truckName']; ?>
                                    <b class="mx-2">Cost:<?= $t['cost']; ?></b>
                                    <b class="mx-2">Capacity:<?= $t['capacity']; ?></b>
                                    <span
                                        class="text-primary"><?php if($t['flag']==0) echo "Available"; else echo "Not Avaiable"; ?></span></label>
                            </li>
                            <?php } ?>

                        </ul>
                    </div>
                    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                    <input type="hidden" name="price" value="<?= $price ?>">
                    <input type="hidden" name="seller" value="<?= $seller_info['id'] ?>">
                    <input type="hidden" name="destination" value="<?= $buyer_info['address'] ?>">
                    <input type="hidden" name="buyer" value="<?= $buyer_info['id'] ?>">
                    <p>Total Fee: <?= $price ?></p>
                    <p>Total Vat: <?= $price*0.1 ?></p>
                    <p>Current Payable Amount: <?= $price/2 ?></p>
                    <button type="submit" name="paid_half_confirm" class="btn btn-primary btn-lg">Pay and Confirm
                        50% payment</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Modal order_confirm-->
<div class="modal fade" id="confirm_order" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Conform Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </button>
            </div>
            <div class="modal-body text-center">
                <i class="fa-solid fa-handshake display-1"></i>
                <p>I accept the <a href="#">terms and condition</a> that my delivery will start soon and I am giving
                    the right products to Unisales Transportion </p>
                <form method="POST">
                    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                    <button type="submit" name="order_confirm" class="btn btn-primary btn-lg">Confirm
                        Order</button>
                </form>
            </div>
        </div>
    </div>
</div>






<!-- Modal is_paid_full-->
<div class="modal fade" id="is_paid_full" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Conform Payment 100%</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </button>
            </div>
            <div class="modal-body text-center">
                <i class="fa-solid fa-sack-dollar display-1"></i>
                <p>I accept the <a href="#">terms and condition</a> that I will pay the other 50% of the products
                </p>
                <form method="POST">
                    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                    <input type="hidden" name="price" value="<?= $price ?>">
                    <input type="hidden" name="seller" value="<?= $seller_info['id'] ?>">
                    <input type="hidden" name="buyer" value="<?= $buyer_info['id'] ?>">
                    <button type="submit" name="paid_full_confirm" class="btn btn-primary btn-lg">Pay and Confirm
                        100% Payment</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include('footer.php') ?>
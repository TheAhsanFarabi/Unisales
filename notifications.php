<div class="dropdown">
    <div class="pe-4 fs-5 text-light" id="dropdownNotification" data-bs-toggle="dropdown" aria-expanded="false"
        style="cursor: pointer;"><i class="fa-solid fa-bell"></i></div>
    <?php
if($u['user_type']==1){
    $seller = $u['id'];
    $orders_sell = mysqli_query($conn, "SELECT COUNT(*) AS row_count FROM orders WHERE seller = $seller AND is_paid_full=0")->fetch_assoc();
    $order_count = $orders_sell['row_count'];
    $notifications = $conn->query("SELECT p_title as title, p_id as id, name FROM requests 
    JOIN props ON props.p_id = requests.prop_id 
    JOIN users ON requests.user_id = users.id 
    WHERE p_creator = $seller");
  }
  
  if($u['user_type']==2) {
    $buyer = $u['id'];
    $orders_buy = mysqli_query($conn, "SELECT COUNT(*) AS row_count FROM orders WHERE buyer = $buyer AND is_paid_full=0")->fetch_assoc();
    $order_count = $orders_buy['row_count'];
    $notifications = $conn->query("SELECT g_title as title, g_id as id, name FROM requests 
    JOIN gigs ON gigs.g_id = requests.gig_id 
    JOIN users ON requests.user_id = users.id 
    WHERE g_creator = $buyer");
  }

  $type="Orders";
  //$notifications = 1;
?>

    <div class="dropdown-menu dropdown-menu-end text-small container p-3" aria-labelledby="dropdownNotification"
        style="width:300px;">

        <h5>All Notifications</h5>
        <div class="alert alert-info alert-dismissible fade show m-0 rounded-0" role="alert">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col">
                        <p>You have <b><?= $order_count ?></b> orders to check</p>
                        <a href="orders.php" class="btn btn-primary">Click here</a>
                    </div>

                </div>
            </div>
        </div>
        <hr class="text-muted">
        <?php if (!empty($notifications)) : ?>

        <?php foreach ($notifications as $n) : ?>
        <div class="alert alert-warning alert-dismissible fade show m-0 rounded-0" role="alert">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col">
                        <p>Your post <b><?= $n['title'] ?></b> got an request from <b><?= $n['name']?></b></p>
                        <?php if($u['user_type']==1) { ?>
                        <a href="single-prop.php?id=<?= $n['id'] ?>" class="btn btn-primary">View</a>
                        <?php } else { ?>
                            <a href="single-gig.php?id=<?= $n['id'] ?>" class="btn btn-primary">View</a>
                        <?php }  ?>
                    </div>

                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else : ?>
        <!-- Display an empty icon or message when there are no notifications -->
        <div class="alert alert-light alert-dismissible fade show m-0 rounded-0" role="alert">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col">No notifications</div>
                    <div class="col-auto">
                        <!-- You can use an empty icon or any other visual element here -->
                        <i class="far fa-bell"></i>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>




</div>
</div>
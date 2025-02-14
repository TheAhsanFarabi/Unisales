<?php include('header.php') ?>


<?php 

$f_wal = 'https://pngimg.com/d/farmer_PNG48.png';
$c_wal = 'https://cdn-icons-png.flaticon.com/512/2399/2399925.png';

?>

<div class="alert alert-warning alert-dismissible pt-5 mt-3" role="alert">
    <div class="container">

        <strong class="fs-3">TIPS OF THE DAY!</strong>
        <p class="fs-5">Get Organized. Making a plan for what you're going to do and when you're going to do it
            will
            make sure you're always ahead of the curve - literally.</p>
    </div>
    <button type="button" class="btn-close mt-5" data-bs-dismiss="alert" aria-label="Close"></button>

</div>


<div class="container mt-5 mb-3 p-4 border border-2 rounded-5"
    style="background-image: url(<?php if($u['user_type']==1) echo $f_wal; else echo $c_wal; ?>); background-repeat:no-repeat; background-position: right; background-size:25%;">
    <div class="d-flex justify-content-start align-items-center">
        <img src="data/profiles/<?= $u['img']?>" alt="Avator" width="70" height="70" class="rounded-circle" />
        <div class="col">
            <small class="fs-3 mx-2 fw-bolder" id="greeting">Welcome back,
                <?php if($u['user_type']==1) echo "Farmer"; else echo "Company"; ?></small>
            <b class="text-primary fs-3"><?php echo $u['name'] ?></b>
        </div>


    </div>

    <?php if($u['user_type']==1) { ?>
    <button class="btn btn-outline-dark fs-5 rounded-pill mt-3" data-bs-toggle="modal" data-bs-target="#propModal"><i
            class="fa-solid fa-plus me-2"></i>Create a Prop</button>
    <?php include('post/post_prop.php'); ?>
    <?php } else { ?>
    <button class="btn btn-outline-dark fs-5 rounded-pill mt-3" data-bs-toggle="modal" data-bs-target="#gigModal"><i
            class="fa-solid fa-plus me-2"></i>Create a Gig</button>

    <?php include('post/post_gig.php'); ?>
    <?php } ?>


</div>


<div class="container mb-4">




    <a href="discover.php?category='Vegetables' " class="text-decoration-none">
        <button type="button" class="btn btn-outline-dark p-2 m-2 rounded-pill" style="width:190px;">
            <i class="fa-solid fa-pepper-hot fs-1"></i> <br> Vegetables
        </button>
    </a>

    <a href="discover.php?category='Fruits' " class="text-decoration-none">
        <button type="button" class="btn btn-outline-dark p-2 m-2 rounded-pill" style="width:190px;">
            <i class="fa-solid fa-lemon fs-1"></i> <br> Fruits
        </button>
    </a>
    <a href="discover.php?category='Fish' " class="text-decoration-none">
        <button type="button" class="btn btn-outline-dark p-2 m-2 rounded-pill" style="width:190px;">
            <i class="fa-solid fa-fish fs-1"></i> <br>Fish
        </button>
    </a>
    <a href="discover.php?category='Meat' " class="text-decoration-none">
        <button type="button" class="btn btn-outline-dark p-2 m-2 rounded-pill" style="width:190px;">
            <i class="fa-solid fa-drumstick-bite fs-1"></i> <br>Meat
        </button>
    </a>
    <a href="discover.php?category='Dairy' " class="text-decoration-none">
        <button type="button" class="btn btn-outline-dark p-2 m-2 rounded-pill" style="width:190px;">
            <i class="fa-solid fa-cow fs-1"></i> <br>Dairy
        </button>
    </a>
    <a href="discover.php?category='Spice' " class="text-decoration-none">
        <button type="button" class="btn btn-outline-dark p-2 m-2 rounded-pill" style="width:190px;">
            <i class="fa-solid fa-mortar-pestle fs-1"></i> <br>Spice
        </button>
    </a>

</div>




<?php 
if($u['user_type']==1) include('gig.php');
else include('prop.php');
?>


<?php 

$query = "SELECT u.id, u.img, u.name
FROM users u
JOIN (
    SELECT seller, COUNT(*) AS order_count
    FROM orders
    GROUP BY seller
    HAVING COUNT(*) = (
        SELECT MAX(order_count)
        FROM (
            SELECT COUNT(*) AS order_count
            FROM orders
            GROUP BY seller
        ) AS max_orders
    )
) AS max_seller_orders ON u.id = max_seller_orders.seller";
$result = $conn->query($query);
?>
<div class="container">
    <h1 class="text-center my-5">Popular on Unisales</h1>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
    <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="col bg-light shadow-lg fs-5 rounded-5"><img src="#" width="100px"><br>
        <img class="mb-2 bd-placeholder-img profile-pic img-thumbnail rounded-circle" 
                        alt="profile_pic" data-bs-toggle="modal" data-bs-target="#profileModal"
                        <?php if($row['img']) { ?> src="data/profiles/<?= $row['img'] ?>" <?php } else { ?>
                        src="assets/images/empty.jpg" <?php } ?> />
            <h4><?= $row['name'] ?><h4>
        </div>
      <?php } ?>
    </div>
</div>

<?php include('footer.php') ?>
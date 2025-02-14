<?php include('header.php') ?>


<?php 
if($u['user_type']==2){
    $category = $_GET['category'];
    $query = "SELECT * FROM props JOIN users ON users.id = props.p_creator WHERE p_category =$category";
    $result = $conn->query($query);

    // Debugging output
    if (!$result) {
        die("Error in query: " . $conn->error);
    }
    echo "Number of rows: " . $result->num_rows;
?>

<div class="container">
    <h1 class="text-center mt-5 pt-5">All Props of <?= $category ?></h1>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" id="propsContainer">
        <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="col">
            <div class="card text-center mt-4 rounded-5">
                <div class="card-header">
                    <img src="data/profiles/<?= $row['img'] ?>" alt="Profile Picture" width="30" height="30"
                        class="rounded-circle">
                    <a href="profile.php?id=<?= $row['id'] ?>"><?php echo $row['name']; ?></a>
                </div>
                <img src="data/props/<?= $row['p_img'] ?>" class="bd-placeholder-img card-img-top"
                    alt="Image description" style="height:200px; object-fit: cover;">

                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['p_title'] ?></h5>
                    <p class="card-text"><?php echo $row['p_details'] ?></p>
                    <p class="text-muted">Amount: <?php echo $row['p_amount'] ?> KG</p>
                    <p class="text-muted">Price: <?php echo $row['p_price'] ?> BDT/KG</p>
                    <p class="text-danger">Total Request: <?php echo $row['p_requests'] ?></p>
                    <a href="single-prop.php?id=<?= $row['p_id'] ?>" class="btn btn-outline-dark rounded-pill">Apply</a>
                </div>
                <div class="card-footer text-muted">
                    <?php echo date("F j, Y, g:i a", strtotime($row['p_time'])); ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>


<?php

}
else {
    $category = $_GET['category'];
    $query = "SELECT * FROM gigs JOIN users ON users.id = gigs.g_creator WHERE g_category =$category ";
    $result = $conn->query($query); ?>


<div class="container">
<h1 class="text-center mt-5 pt-5">All Gigs of <?= $category ?></h1>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" id="gigsContainer">
        <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="col">
            <div class="card text-center mt-4 rounded-5">
                <div class="card-header">
                    <img src="data/profiles/<?= $row['img'] ?>" alt="Profile Picture" width="30" height="30"
                        class="rounded-circle">
                    <a href="profile.php?id=<?= $row['id'] ?>"><?php echo $row['name']; ?></a>
                </div>
                <img src="data/gigs/<?= $row['g_img'] ?>" class="bd-placeholder-img card-img-top"
                    alt="Image description" style="height:200px; object-fit: cover;">

                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['g_title'] ?></h5>
                    <p class="card-text"><?php echo $row['g_details'] ?></p>
                    <p class="text-muted">Amount: <?php echo $row['g_amount'] ?> KG</p>
                    <p class="text-muted">Price: <?php echo $row['g_price'] ?> BDT/KG</p>
                    <p class="text-danger">Total Request: <?php echo $row['g_requests'] ?></p>
                    <a href="single-gig.php?id=<?= $row['g_id'] ?>" class="btn btn-outline-dark rounded-pill">Apply</a>
                </div>
                <div class="card-footer text-muted">
                    <?php echo date("F j, Y, g:i a", strtotime($row['g_time'])); ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<?php

}




?>


<?php include("footer.php") ?>
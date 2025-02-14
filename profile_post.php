<?php
$owner = $user['id'];
if($user['user_type']==1) {
$props = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM props JOIN users ON users.id=props.p_creator WHERE id=$owner ORDER BY p_id DESC"), MYSQLI_ASSOC);
?>

<div class="album py-5 m-2 bg-body-tertiary">
    <h2 class="text-center">All Props</h2>
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 g-3">
            <?php foreach($props as $p) { ?>
            <div class="col">
                <div class="card text-center mt-4 rounded-5">
                    <div class="card-header">
                    <img src="data/profiles/<?= $p['img']?>" alt="Profile Picture" width="30" height="30"
                            class="rounded-circle">
                        <?php echo "By " . $p['name']; ?>
                    </div>
                    <img src="data/props/<?= $p['p_img'] ?>" class="bd-placeholder-img card-img-top" alt="Image description"
                        style="height:200px; object-fit: cover;">

                    <div class="card-body">
                        <h5 class="card-title"><?php echo $p['p_title']?></h5>
                        <p class="card-text"><?php echo $p['p_details']?></p>
                        <p class="text-primary">Total price: <?php echo $p['p_price']?> BDT</p>
                        <p class="text-primary">Total Request: <?php echo $p['p_requests']?></p>
                        <a href="single-prop.php?id=<?= $p['p_id'] ?>" class="btn btn-success">View</a>
                    </div>
                    <div class="card-footer text-muted">
                        <?php echo date("F j, Y, g:i a", strtotime($p['p_time'])); ?>

                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php } else {
$gigs = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM gigs JOIN users ON users.id=gigs.g_creator WHERE id=$owner ORDER BY g_id DESC"), MYSQLI_ASSOC);
?>

<div class="album py-5 bg-body-tertiary">
    <h2 class="text-center">All gigs</h2>
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 g-3">
            <?php foreach($gigs as $g) { ?>
            <div class="col">
                <div class="card text-center mt-4 rounded-5">
                    <div class="card-header">
                    <img src="data/profiles/<?= $g['img']?>" alt="Profile Picture" width="30" height="30"
                            class="rounded-circle">
                        <?php echo "By " . $g['name']; ?>
                    </div>
                    <img src="data/gigs/<?= $g['g_img'] ?>" class="bd-placeholder-img card-img-top" alt="Image description"
                        style="height:200px; object-fit: cover;">

                    <div class="card-body">
                        <h5 class="card-title"><?php echo $g['g_title']?></h5>
                        <p class="card-text"><?php echo $g['g_details']?></p>
                        <p class="text-primary">Total price: <?php echo $g['g_price']?> BDT</p>
                        <p class="text-primary">Total Request: <?php echo $g['g_requests']?></p>
                        <a href="single-gig.php?id=<?= $g['g_id'] ?>" class="btn btn-success">View</a>
                    </div>
                    <div class="card-footer text-muted">
                        <?php echo date("F j, Y, g:i a", strtotime($g['g_time'])); ?>

                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php } ?>


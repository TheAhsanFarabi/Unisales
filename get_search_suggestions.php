
<?php
include('connection.php');
session_start();

$user_id = $_SESSION['id'];
$sql_user = "SELECT user_type FROM users WHERE id = $user_id";
$result_user = $conn->query($sql_user);

if ($result_user && $result_user->num_rows > 0) {
    $u = $result_user->fetch_assoc();
}

// Get the search query from the AJAX request
$searchQuery = $_GET['q'];

// Fetch post titles from the database based on the search query
if($u['user_type']==1) {
$sql = "SELECT g_id as id, g_title as title, g_price as price, g_img as img FROM gigs WHERE g_title LIKE '%$searchQuery%'";
$result = $conn->query($sql);
} else {
$sql = "SELECT p_id as id, p_title as title, p_price as price, p_img as img FROM props WHERE p_title LIKE '%$searchQuery%'";
$result = $conn->query($sql);
}
// Display the posts as card views with images
if ($result && $result->num_rows > 0):
    while ($row = $result->fetch_assoc()):
?>
<div class="card mb-3 m-2">

    <div class="card-body">
        <?php if($u['user_type']==1) { ?>
        <img src="data/gigs/<?= $row['img'] ?>" class="card-img-top w-25" alt="Post Image">
        <a href="single-gig.php?id=<?= $row['id'] ?>" class="card-title"><?= $row['title'] ?></a>
        <?php } else { ?>
        <img src="data/props/<?= $row['img'] ?>" class="card-img-top w-25" alt="Post Image">
        <a href="single-prop.php?id=<?= $row['id'] ?>" class="card-title"><?= $row['title'] ?></a>
        <?php } ?>
        
        <p class="text-primary">Total price: <?php echo $row['price']?> BDT</p>
        <!-- You can include additional post information here -->
    </div>
</div>
<?php
    endwhile;
else:
?>
<div class="card suggestions-card">
    <div class="card-body p-2">
        <div class="suggestion card-text">No posts found</div>
    </div>
</div>
<?php endif; ?>
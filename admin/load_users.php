<?php
include('connection.php');

// Sanitize user input
function sanitizeInput($input) {
    global $conn;
    return $conn->real_escape_string($input);
}

$totalUsers = ($conn->query("SELECT COUNT(*) AS total FROM users"))->fetch_assoc();
$Farmers = ($conn->query("SELECT COUNT(*) AS total FROM users WHERE user_type = 1"))->fetch_assoc();
$Companies = ($conn->query("SELECT COUNT(*) AS total FROM users WHERE user_type = 2"))->fetch_assoc();

$percentageFarmers = ($Farmers['total'] / $totalUsers['total']) * 100;
$percentageCompanies = ($Companies['total'] / $totalUsers['total']) * 100;

$queryUsers = "SELECT id, name, email, user_type, is_verified, img FROM users";
$resultUsers = $conn->query($queryUsers);
$usersData = $resultUsers->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['verify'])) {
    $userId = sanitizeInput($_POST['id']);
    $conn->query("UPDATE users SET is_verified = 1 WHERE id = '$userId'");
    header("Location: admin.php");
}

if (isset($_POST['delete_user'])) {
    $userId = sanitizeInput($_POST['id']);
    $conn->query("DELETE FROM users WHERE id = '$userId'");
    header("Location: admin.php");
}

?>

<!-- Your HTML structure -->
<h1 class="mb-4 text-center">Users Report</h1>

<!-- PROGRESS BAR TEMPLATE -->
<!-- <div class="progress fs-2 rounded-pill" style="height: 60px;">
    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $percentageFarmers; ?>%;"
        aria-valuenow="<?php echo $percentageFarmers; ?>" aria-valuemin="0" aria-valuemax="100">
        <?php echo $percentageFarmers; ?>% Farmers</div>
    <div class="progress-bar" role="progressbar" style="width: <?php echo $percentageCompanies; ?>%;"
        aria-valuenow="<?php echo $percentageCompanies; ?>" aria-valuemin="0" aria-valuemax="100">
        <?php echo $percentageCompanies; ?>% Companies</div>
</div> -->

<div class="container row">
    <div class="col p-3 bg-light shadow-lg fs-5 rounded-5 m-2"><i class="fa-solid fa-star text-danger"></i>Total Farmers<br><b class="display-5 fw-bold"><?= $Farmers['total'] ?></b></div>
    <div class="col p-3 bg-light shadow-lg fs-5 rounded-5 m-2"><i class="fa-solid fa-star text-primary"></i>Total Company<br><b class="display-5 fw-bold"><?= $Companies['total'] ?></b></div>
  
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <h2>Active Farmers: <?php echo $Farmers['total']; ?></h2>
        <div id="farmers-list">
            <?php
            foreach ($usersData as $user) {
                if ($user['user_type'] == 1) {
                    includeUserCard($user);
                }
            }
            ?>
        </div>
    </div>
    <div class="col-md-6">
        <h2>Active Companies: <?php echo $Companies['total']; ?></h2>
        <div id="companies-list">
            <?php
            foreach ($usersData as $user) {
                if ($user['user_type'] == 2) {
                    includeUserCard($user);
                }
            }
            ?>
        </div>
    </div>
</div>

<?php
function includeUserCard($user)
{
    ?>
    <div class="user-card p-3 border border-2">

        <img src="data/profiles/<?php echo $user['img']; ?>" alt="<?php echo $user['name']; ?> Image"
            style="width: 50px; height: 50px;">
        <p><strong>Name:</strong> <?php echo $user['name']; ?></p>
        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        <p><strong>Verified:</strong> <?php echo $user['is_verified'] ? 'Yes' : 'No'; ?></p>

        <?php if ($user['is_verified'] == 0) { ?>
            <form method="POST">
                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                <button type="submit" class="btn btn-primary" name="verify">Verify User</button>
            </form>
        <?php } ?>

        <form method="POST">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">
            <button type="submit" class="btn btn-danger" name="delete_user">Delete User</button>
        </form>
        
    </div>
    <?php
}
?>

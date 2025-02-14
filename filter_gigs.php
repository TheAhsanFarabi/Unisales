
<?php
// Include your database connection code
include('connection.php');

if (isset($_POST['location']) && isset($_POST['price']) && isset($_POST['rank'])) {
    $selected_rank = $_POST['rank'];
    $selected_location = $_POST["location"];
    $selected_price = $_POST["price"];
    $selected_price_max = $selected_price+1;

    if ($selected_rank !== 'all') {
        $where_condition1 = "rating >= $selected_rank AND rating < " . ($selected_rank + 1);
    }
    $where_condition2 = ($selected_location !== 'all') ? "g_location = '$selected_location'" : "";

    $where_condition = "";

    if (!empty($where_condition1) && !empty($where_condition2)) {
        $where_condition = " WHERE $where_condition1 AND $where_condition2 AND g_price < $selected_price";
    } elseif (!empty($where_condition1)) {
        $where_condition = " WHERE $where_condition1 AND g_price < $selected_price";
    } elseif (!empty($where_condition2)) {
        $where_condition = " WHERE $where_condition2 AND g_price < $selected_price";
    } else {
        $where_condition = " WHERE g_price < $selected_price";
    }

    $query = "SELECT * FROM gigs JOIN users ON users.id=gigs.g_creator " . $where_condition;
    $result = $conn->query($query);

    // Output the gigs HTML
    while ($row = $result->fetch_assoc()) {
    if($row['g_flag']==1) $border = 'border border-5 border-success';
    elseif($row['g_requests']>0) $border = 'border border-5 border-warning';
    else $border='border border-5';
        // Output gig details as per your design
        echo '<div class="col">';
        echo '<div class="card text-center mt-4 rounded-5 '. $border .'">';
        echo '<div class="card-header">';
        echo '<img src="data/profiles/' . $row['img'] . '" alt="Profile Picture" width="30" height="30" class="rounded-circle">';
        echo '<a href="profile.php?id=' . $row['id'] . '">' . $row['name'] . '</a>';
        echo '</div>';
        echo '<img src="data/gigs/' . $row['g_img'] . '" class="bd-placeholder-img card-img-top" alt="Image description" style="height:200px; object-fit: cover;">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $row['g_title'] . '</h5>';
        echo '<p class="card-text">' . $row['g_details'] . '</p>';
        echo '<p class="text-muted">Amount: ' . $row['g_amount'] . ' KG</p>';
        echo '<p class="text-muted">Price: ' . $row['g_price'] . ' BDT/KG</p>';
        echo '<p class="text-danger">Total Request: ' . $row['g_requests'] . '</p>';
        echo '<a href="single-gig.php?id=' . $row['g_id'] . '" class="btn btn-outline-dark rounded-pill">Apply</a>';
        echo '</div>';
        echo '<div class="card-footer text-muted">';
        echo date("F j, Y, g:i a", strtotime($row['g_time']));
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}

// Close the database connection
$conn->close();
?>

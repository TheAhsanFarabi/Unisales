<?php include('header.php') ?>

<?php 

$current_user =  $u['id'];

$query1 = "SELECT p_title, name, p_price, time FROM orders
          JOIN props ON props.p_id = orders.prop_id 
          JOIN users ON orders.buyer = users.id 
          WHERE is_paid_full = 1 AND seller = $current_user OR buyer = $current_user";


$query2 = "SELECT g_title, name, g_price, time FROM orders
          JOIN gigs ON gigs.g_id = orders.gig_id 
          JOIN users ON orders.seller = users.id 
          WHERE is_paid_full = 1 AND seller = $current_user OR buyer = $current_user";

$result1 = $conn->query($query1);
$result2 = $conn->query($query2);

?>

<div class="container">
    <h1 class="mb-4 mt-5">Statistics of Props</h1>

    <?php 
    // Check if there are results
    if ($result1->num_rows > 0) {
    ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Buyer</th>
                    <th>Adjusted Price</th>
                    <th>VAT</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch and display each row as a table row
                while ($row = $result1->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?php echo $row['p_title']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['p_price'] - $row['p_price']*0.1; ?> TAKA</td>
                        <td><?php echo $row['p_price']*0.1; ?> TAKA</td>
                        <td><?php echo date("F j, Y, g:i a", strtotime($row['time'])); ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    <?php
    } else {
        echo "<p>No statistics found.</p>";
    }
    ?>


<h1 class="mb-4 mt-5">Statistics of Gigs</h1>

    <?php 
    // Check if there are results
    if ($result2->num_rows > 0) {
    ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Seller</th>
                    <th>Adjusted Price</th>
                    <th>VAT</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch and display each row as a table row
                while ($row = $result2->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?php echo $row['g_title']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['g_price'] - $row['g_price']*0.1; ?> TAKA</td>
                        <td><?php echo $row['g_price']*0.1; ?> TAKA</td>
                        <td><?php echo date("F j, Y, g:i a", strtotime($row['time'])); ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    <?php
    } else {
        echo "<p>No statistics found.</p>";
    }
    ?>
</div>


<?php include('footer.php') ?>

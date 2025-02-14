<?php 
include('connection.php');
$order = 0;
if(isset($_POST['searchOrder'])){

$order_id = $_POST['order_id'];

$sql = "SELECT * FROM orders WHERE order_id=$order_id";
$result = $conn->query($sql);
$order = $result->fetch_assoc(); 

}

$transportation = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM transportations"), MYSQLI_ASSOC);

if (isset($_POST['update'])) {
    $order_id = $_POST['order_id'];
    $status_type = $_POST['status_type'];

    // Validate status_type to prevent SQL injection
    if ($status_type === 'is_delivery_started' || $status_type === 'is_delivery_finished') {
        // Update the orders table based on the selected status_type
        $sql = "UPDATE orders SET $status_type = 1 WHERE order_id = $order_id";

        if ($conn->query($sql) === TRUE) {
            //echo "Order status updated successfully.";
            echo '<script>';
            echo 'var status_updated = true;';
            echo '</script>';
        } else {
            echo "Error updating order status: " . $conn->error;
        }
    } else {
        echo "Invalid status type.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRANSPORTATION DASHBOARD</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>

<body>





    <div class="container" id="content">

        <h1 class="display-1">TRANSPORTATION DASHBOARD</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>Truck Photo</th>
                    <th>Truck Name</th>
                    <th>Cost</th>
                    <th>Highest Capacity</th>
                    <th>Current Capacity</th>
                    <th>All Orders</th>
                 
                </tr>
            </thead>
            <tbody>

                <?php foreach($transportation as $t) { 

                       $orders = explode(",", $t['orders']);
                    
                    
                    
                ?>
                <tr>
                    <td><img src="assets/images/<?= $t['truckName']; ?>.png" width="60px"> </td>
                    <td><?php echo $t['truckName']; ?></td>
                    <td><?php echo $t['cost']; ?> BDT/KG</td>
                    <td><?php echo $t['capacity']; ?> KG</td>
                    <td><?php echo $t['orders_size']; ?> KG</td>
                <td class="d-flex flex-row justify-content-start">
                <?php 
                
                
                foreach($orders as $o){ ?>
                       

                        <form method="POST">
                            <input type="hidden" name="order_id" value="<?= $o ?>">
                            <button type="submit" name="search_order" class="btn btn-primary me-2"><?= $o ?></button>
                        </form>

                <?php } ?>
                <div class="p-5"></div>
                 
                </td>


                </tr>
                <?php } ?>
            </tbody>

        </table>


        <div id="orderDetails">

            <!-- ORDER DETAILS WILL BE HERE -->


        </div>




    </div>

    <script>
    $(document).ready(function() {
        $('form').submit(function(e) {
            e.preventDefault();

            var order_id = $(this).find('input[name="order_id"]').val();

            $.ajax({
                type: 'POST',
                url: 'get_order_details.php',
                data: {
                    order_id: order_id
                },
                dataType: 'json',
                success: function(data) {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        // Update the page with the received order details
                        var orderDetailsHTML = '<h1>Order Details</h1>' +
                            '<p><strong>Order ID:</strong> ' + data.order_id + '</p>' +
                            '<p><strong>Seller ID:</strong> ' + data.seller + '</p>' +
                            '<p><strong>Buyer ID:</strong> ' + data.buyer + '</p>' +
                            '<div class="container mt-5">' +
                            '<h2 class="text-center pb-3">Order Progress Bar</h2>' +
                            '<div class="progress">' +
                            '<div class="progress-bar progress-bar-secondary" role="progressbar" style="width: ' +
                            data.percentage + '%;" aria-valuenow="' + data.percentage +
                            '" aria-valuemin="0" aria-valuemax="100"></div>' +
                            '</div>' +
                            '<div class="d-flex justify-content-between mt-2">' +
                            '<div class="my-5 mx-3  text-center">' +
                            '<i class="fa-solid fa-sack-dollar fs-3 text-secondary" id="icon1"></i><br>' +
                            '<small class=" text-secondary">50% paid</small>' +
                            '</div>' +
                            '<div class="my-5 mx-3  text-center">' +
                            '<i class="fa-solid fa-handshake fs-3 text-secondary" id="icon1"></i><br>' +
                            '<small class=" text-secondary">Order Confirmed</small>' +
                            '</div>' +
                            '<div class="my-5 mx-3  text-center">' +
                            '<i class="fa-solid fa-truck-fast fs-3 text-secondary" id="icon1"></i><br>' +
                            '<small class=" text-secondary">Delivery Started</small>' +
                            '</div>' +
                            '<div class="my-5 mx-3  text-center">' +
                            '<i class="fa-solid fa-truck-fast fs-3 text-secondary" id="icon1"></i><br>' +
                            '<small class=" text-secondary">Delivery Finished</small>' +
                            '</div>' +
                            '<div class="my-5 mx-3  text-center">' +
                            '<i class="fa-solid fa-sack-dollar fs-3 text-secondary" id="icon1"></i><br>' +
                            '<small class=" text-secondary">100% paid</small>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="container mt-3">' +
                            '<h2 class="text-center pb-3">Order Actions</h2>' +
                            '<div class="d-flex flex-row justify-content-center">' +
                            '<form method="POST">' +
                            '<input type="hidden" name="order_id" value="' + data.order_id +
                            '">' +
                            '<input type="hidden" name="status_type" value="is_delivery_started">' +
                            '<button type="submit" name="update" class="btn btn-warning mx-2">Mark as Delivery Started</button>' +
                            '</form>' +
                            '<form method="POST">' +
                            '<input type="hidden" name="order_id" value="' + data.order_id +
                            '">' +
                            '<input type="hidden" name="status_type" value="is_delivery_finished">' +
                            '<button type="submit" name="update" class="btn btn-info mx-2">Mark as Delivery Finished</button>' +
                            '</form>' +
                            '</div>' +
                            '</div>';

                        $('#orderDetails').html(orderDetailsHTML);
                    }
                },
                error: function() {
                    alert('Error fetching order details');
                }
            });
        });
    });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        // Check the orderProcessed flag and show the toast if true
        if (typeof status_updated !== 'undefined' && status_updated) {
            var toast = new bootstrap.Toast(document.getElementById('successToast'));
            toast.show();
        }
    });
    </script>

    <!-- ... Your PHP and HTML code ... -->

    <!-- Add this Bootstrap Toast element somewhere in your HTML -->
    <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true"
        style="position: absolute; top: 100px; right: 0;">
        <div class="toast-header bg-secondary">
            <strong class="me-auto text-light">Order Status</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Status Updated Successfully
        </div>
    </div>


    <footer class="container pt-4 mb-0 w-100">
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="assets/js/app.js"></script>
    </footer>
</body>

</html>
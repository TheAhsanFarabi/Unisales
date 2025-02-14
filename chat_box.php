<?php 

$messages = $conn->query("SELECT DISTINCT user2 FROM chats WHERE user1=".$u['id']);



?>


<div class="dropdown">
    <div class="px-3 fs-5 text-light" id="dropdownChat" data-bs-toggle="dropdown" aria-expanded="false"
        style="cursor: pointer;"><i class="fa-solid fa-message"></i></div>


    <div class="dropdown-menu dropdown-menu-end text-small container p-3" aria-labelledby="dropdownChat"
        style="width:300px;">

        <h5>All Messages</h5>

        <?php if (!empty($messages)) : ?>

        <?php foreach ($messages as $m) : 

    
            
            
        ?>

        <div class="alert alert-warning alert-dismissible fade show m-0 rounded-0" role="alert">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col">
                        
                        <?php 
                        $uu = $conn->query("SELECT * FROM users WHERE id=".$m['user2']);
                        $user2_info = $uu->fetch_assoc(); 
                        
                        ?>
                        <img src="data/profiles/<?=$user2_info['img']?>" class="rounded-circle" width="100px">
                        <p>You have conversation with <b><?= $user2_info['name'] ?></b></p>
                        <a href="chat.php?id=<?= $user2_info['id']?>" class="btn btn-primary">View</a>
                    </div>

                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else : ?>
        <!-- Display an empty icon or message when there are no messages -->
        <div class="alert alert-light alert-dismissible fade show m-0 rounded-0" role="alert">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col">No messages</div>
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
<?php
include("header.php");

$user1_id = $_SESSION['id'];
$user2_id = $_GET['id'];

$all_chats = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM chats JOIN users ON users.id=chats.user1 WHERE (user1=$user1_id AND user2=$user2_id) OR (user1=$user2_id AND user2=$user1_id) ORDER BY c_time"), MYSQLI_ASSOC);

foreach ($all_chats as $chat) {
    if ($chat['message_type'] == 'text') {
        if ($chat['id'] == $user1_id) {
            echo '<div class="d-flex justify-content-end">
                    <div class="mw-100 px-5 border border-1 mb-2 text-white shadow-lg rounded-pill '.($chat['user_type']==1 ? "bg-success" : "bg-primary").'">
                        <div class="d-flex justify-content-end align-items-center">
                            <p class="fs-5 ps-1 mt-3">'.$chat['chat_message'].'</p>
                            <i class="fa-solid fa-user fs-3 ps-1"></i>
                        </div>
                    </div>
                </div>';
        } else {
            echo '<div class="d-flex justify-content-start">
                    <div class="mw-100 px-5 border border-1 mb-2 shadow-lg rounded-pill">
                        <div class="d-flex justify-content-start align-items-center">
                            <i class="fa-solid fa-user fs-3 pe-4 ps-1"></i>
                            <p class="fs-5 ps-1 mt-3">'.$chat['chat_message'].'</p>
                        </div>
                    </div>
                </div>';
        }
    } elseif ($chat['message_type'] == 'photo') {
        if ($chat['id'] == $user1_id) {
            echo '<div class="d-flex justify-content-end mt-5">
                    <div class="mw-100 border border-3'.($chat['user_type']==1 ? "border-success" : "border-primary").'">
                        <div class="d-flex justify-content-end align-items-center">
                            <img src="'.$chat['chat_message'].'" alt="Chat Photo" class="img-fluid">
                            <i class="fa-solid fa-user fs-3 ps-1"></i>
                        </div>
                    </div>
                </div>';
        } else {
            echo '<div class="d-flex justify-content-start mt-5">
                    <div class="mw-100 border border-3">
                        <div class="d-flex justify-content-start align-items-center">
                            <i class="fa-solid fa-user fs-3 pe-4 ps-1"></i>
                            <img src="'.$chat['chat_message'].'" alt="Chat Photo" class="img-fluid">
                        </div>
                    </div>
                </div>';
        }
    }
}
?>

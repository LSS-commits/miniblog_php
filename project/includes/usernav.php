<?php
// TODO: check if user is logged in/out, display nav links accordingly
?>

<div>
    
    <details>
        <!-- clickable user icon  -->
        <summary class="usernavIcon border">&#128590;</summary>
        <ul>
            <!-- if user is logged out, link to login page -->
            <li><a href="/project/login.php">Log in</a></li>

            <!-- if user is logged in, logout link + user dashboard  -->
            <li><a href="">My dashboard</a></li>
            <li><a href="">Log out</a></li>
        </ul>
    </details>
</div>
<nav class="flex" id="navbar">
    <div class="first flex">
        <div class="logo center">
            <img src="<?php echo IMAGES.'logo.png';?>" alt="">
        </div>
        <span class="bars" onclick="toggle('#menu','active')"><img src="<?php echo IMAGES.'icons/bars-solid.svg' ?>" alt="" width="20"></span>
    </div>    
    <ul id="menu" class="menu flex-y ls-none">
        <li><a href="<?php echo URL?>" class="flex-center">indice</a></li>
        <li><a href="<?php echo URL?>product" class="flex-center">productos</a></li>
        <?php 
        
            if(isset($_SESSION['USER'])){
            $user=unserialize($_SESSION['USER']);
            // print_r($user);
            ?>
            <li><a href="<?php echo URL?>user/profile" class="flex-center"><?php echo $user->getName_user()?></a></li>
            <li><a href="<?php echo URL?>user/logout" class="flex-center">Cerrar Sesión</a></li>
            <?php
        }else{?>
            <li><a href="<?php echo URL?>user/static/login" class="flex-center">Login</a></li>
            <li><a href="<?php echo URL?>user/static/signup" class="flex-center">Registrase</a></li>
        <?php }?>
    </ul>
</nav>
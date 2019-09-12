<nav class="flex" id="navbar">
    <div class="first flex">
        <div class="logo center">
            <img src="<?php echo ROUTEIMG.'logo.png';?>" alt="">
        </div>
        <span class="bars" onclick="toggle('#menu','active')"><img src="<?php echo ROUTEIMG.'icons/bars-solid.svg' ?>" alt="" width="20"></span>
    </div>    
    <ul id="menu" class="menu flex-y ls-none">
        <li><a href="index.php?c=index&a=static&p=index" class="flex-center">indice</a></li>
        <li><a href="index.php?c=product" class="flex-center">productos</a></li>
        <li><a href="index.php?c=index&a=static&p=contact" class="flex-center">contacto</a></li>
        <?php 
        
            if(isset($_SESSION['USER'])){
            $user=$_SESSION['USER'];
            // print_r($user);
            ?>
            <li><a href="index.php?c=user&a=profile" class="flex-center"><?php echo $user->getName_user()?></a></li>
            <li><a href="index.php?c=user&a=logout" class="flex-center">Cerrar Sesión</a></li>
            <?php
        }else{?>
            <li><a href="index.php?c=index&a=static&p=login" class="flex-center">Login</a></li>
            <li><a href="index.php?c=user&a=viewSignup&p=signup" class="flex-center">Registrase</a></li>
        <?php }?>
    </ul>
</nav>
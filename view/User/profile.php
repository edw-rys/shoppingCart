<header>
    <?php include_once NAVIGATION?>
</header>
<main class="my-profile flex flex-center <?php echo $myGender->name_gender?>" >
    <div class="container-profile grid">
        <section class="my-data">
            <h1 class="txt-center">Mi perfil</h1>
            <div class="_head picture flex-center">
                <span><?php echo $user->getName_user()." ".$user->getLast_name();?></span>
            </div>
            <div class="info flex flex-y picture">
                <span class="flex space-btw"> 
                    <span><b>Nombre de usuario: </b></span><span><?php echo $user->getUsername()?></span>
                </span>
                <span class="flex space-btw">
                    <span><b>Año de nacimiento: </b></span><span><?php echo $user->getBirthdate()?></span>
                </span>
                <span class="flex space-btw">
                    <span><b>Edad: </b></span><span><?php echo date("Y") - date("Y",strtotime($user->getBirthdate()));?></span>
                </span>
                <span>
                    <span><b>Correo electrónico: </b></span><span><?php echo $user->getMail()?></span>
                </span>
                <span class="flex space-btw">
                    <span><b>País: </b></span><span><?php echo $myCountry->name_cy?></span>
                </span>
                <span class="flex space-btw">
                    <span><b>Género: </b></span><span><?php echo $myGender->name_gender?></span>
                </span>
            
            </div>
            <div class="edit picture flex-center">
                <b><a href="index.php?c=user&a=editprofile">Editar datos</a></b>
            </div>
        
        </section>
        <div class="muro">
            <?php
            if($user->getId_typeuser()==CLIENT){
                include_once "view/components/muroCliente.php";
            }else if($user->getId_typeuser()==ADMIN){
                include_once "view/components/muroAdmin.php";
            }
            ?>
        </div>
    </div>
</main>
<div class="m-20"></div>
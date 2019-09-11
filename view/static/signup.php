<header>
    <?php include_once NAVIGATION?>
</header>

<main class="flex-center main-login">
    <div class="container_login">
        <h1 class="txt-center">Resgitrese</h1>
        <form action="index.php?c=user&a=save" method="post" class="" id="form-signup" onsubmit="return validateNewUser()">
            <div class="m-20"></div>
            <label class="grid grid-c-2" style="margin:10px 0">
                <span>Nombre: </span>
                <input class="input-txt" type="text" name="name">
            </label>
            <label class="grid grid-c-2" style="margin:10px 0">
                <span>Apellido: </span>
                <input class="input-txt" type="text" name="lastname">
            </label>
            <label class="grid grid-c-2" style="margin:10px 0">
                <span>Año de nacimiento: </span>
                <input class="input-txt" type="date" name="birthday">
            </label>
            <label class="grid grid-c-2" style="margin:10px 0">
                <span>correo: </span>
                <input class="input-txt" type="mail" name="email">
            </label>
            <label class="grid grid-c-2" style="margin:10px 0">
                <span>Usuario: </span>
                <input class="input-txt" type="text" name="username">
            </label>
            <label class="grid grid-c-2" style="margin:10px 0">
                <span>Contraseña: </span>
                <input class="input-txt" type="password" name="password">
            </label>
            <label class="grid grid-c-2" style="margin:10px 0">
                <span>País: </span>
                <select name="county" id="">
                    <option value="0">seleccione</option>
                    <?php 
        
                    if(isset($continents)){
                        print_r($continents);
                        foreach($continents as $cont){
                            ?>
                            <optgroup label="<?php echo $cont[0]->name_ct?>">
                            <?php foreach($cont[1] as $country ){
                            ?>
                                <option value="<?php echo $country->id_country?>"><?php echo $country->name_cy?></option>
                            <?php }?>
                            </optgroup>
                            <?php
                        }
                    }
                    ?>
                </select>
            </label>
            <p class="txt-center">Género</p>
            <div class="gender-container flex flex-center" style="grid-column: span 2">
                
                <div class="container-gender-input male relative  txt-white">
                    <label class="gender-label relative">
                        <input type="radio" name="gender" value="1">
                        <div class="capa">
                            <img src="<?php echo ROUTEIMG."icons/male.svg"?>" alt="">
                            <span class="flex-center">MASCULINO</span>
                        </div>
                        
                    </label>
                </div>
                <div class="container-gender-input female  txt-white">
                    <label class="gender-label relative">
                        <input type="radio" name="gender" value="2">
                        <div class="capa">
                            <img src="<?php echo ROUTEIMG."icons/female.svg"?>" alt="">
                            <span class="flex-center">FEMENINO</span>
                        </div>
                        
                    </label>
                </div>
            </div>
            <label class="flex-center flex-y">
                <input type="submit" value="Iniciar" class="button-send ">
            </label>
        </form>
    </div>
</main>
<div class="m-40"></div>
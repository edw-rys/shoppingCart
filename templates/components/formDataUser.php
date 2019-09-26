<!-- <main class="flex-center main-login"> -->
    <div class="container_login">
        <h1 class="txt-center"><?php echo $tittle?></h1>
        <div class="m-20"></div>
        <form action="<?php echo URL?>user/save" method="post" class="" id="form-signup" onsubmit=" validateNewUser()">
            <?php if(isset($user)) {?>
            <input type="hidden" name="idUser" value="<?php echo $user->getId_user();?>">
            <?php }?>
            <label class="grid grid-c-2" style="margin:10px 0">
                <span>Nombre: </span>
                <input class="input-txt" type="text" name="name" value="<?php echo isset($user)?$user->getName_user():""?>">
            </label>
            <label class="grid grid-c-2" style="margin:10px 0">
                <span>Apellido: </span>
                <input class="input-txt" type="text" name="lastname" value="<?php echo isset($user)?$user->getLast_name():""?>">
            </label>
            <label class="grid grid-c-2" style="margin:10px 0">
                <span>Año de nacimiento: </span>
                <input class="input-txt" type="date" name="birthday" value="<?php echo isset($user)?$user->getBirthdate():""?>">
            </label>
            <label class="grid grid-c-2" style="margin:10px 0">
                <span>correo: </span>
                <input class="input-txt" type="mail" name="email" value="<?php echo isset($user)?$user->getMail():""?>">
            </label>
            <label class="grid grid-c-2" style="margin:10px 0">
                <span>Usuario: </span>
                <input class="input-txt" type="text" name="username" value="<?php echo isset($user)?$user->getUsername():""?>">
            </label>
            <label class="grid grid-c-2" style="margin:10px 0">
                <span>Contraseña: </span>
                <input class="input-txt" type="password" name="password">
            </label>
            <pre>
            </pre>
            <label class="grid grid-c-2" style="margin:10px 0">
                <span>País: </span>
                <select name="county" id="">
                    <option value="0">seleccione</option>
                    <?php 
        
                    if(isset($obj)){
                        
                        $continents=$obj->continents;
                        foreach($continents as $cont){
                            ?>
                            <optgroup label="<?php echo $cont[0]->name_ct?>">
                            <?php foreach($cont[1] as $country ){
                            ?>
                                <option value="<?php echo $country->id_country?>" <?php if(isset($user))if($country->id_country==$user->getId_country()) echo "selected"?>
                                ><?php echo $country->name_cy?></option>
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
                        <input type="radio" name="gender" value="1" <?php if(isset($user))if(1==$user->getId_gender()) echo "checked"?>>
                        <div class="capa">
                            <img src="<?php echo IMAGES."icons/male.svg"?>" alt="">
                            <span class="flex-center">MASCULINO</span>
                        </div>
                        
                    </label>
                </div>
                <div class="container-gender-input female  txt-white">
                    <label class="gender-label relative">
                        <input type="radio" name="gender" value="2" <?php if(isset($user))if(2==$user->getId_gender()) echo "checked"?>>
                        <div class="capa">
                            <img src="<?php echo IMAGES."icons/female.svg"?>" alt="">
                            <span class="flex-center">FEMENINO</span>
                        </div>
                        
                    </label>
                </div>
            </div>
            <label class="flex-center flex-y">
                <input type="submit" value="<?php echo $valueButton?>" class="button-send" name="t">
            </label>
        </form>
    </div>
<!-- </main> -->
<!-- <div class="m-40"></div> -->
<section>
<h2 class="tittle txt-center"><?php echo (isset($tittle))?$tittle:"Registro"?></h2>
<form action="<?php echo URL?>/product/add" method="post" enctype="multipart/form-data" id="form-product">
    <?php if(isset($product)){?>
        <span><input type="hidden" name="idp" value="<?php echo $product->getId();?>"></span>
    <?php }?>
    <span class="flex space-around relative"  style="margin:10px 0; overflow:hidden">
        <span>Imágen: </span>
        <label class="image-select relative gradient-00B4DB ">
            <span class="icon"><i class="icon-image"></i></span>
            <input class="file-img" class="input-txt" type="file" name="img_p" onchange="preview(this, '.image-upload')">
        </label>
        <span class="image-select icon gradient-00B4DB txt-white">
            <a href="#!" class="flex-center txt-dc-none" onclick="toggle('.image-upload','hidden')">
                <span>ver foto</span>
                <span style="padding:5px"><i class="icon-view"></i></span>
            </a>
        </span>
    </span>
    <div class="image-upload hidden flex-center"></div>
    <label class="grid grid-c-2" style="margin:10px 0">
        <span>Nombre: </span>
        <input class="input-txt" type="text" name="name_p" value="<?php echo isset($product)?$product->getName():""?>">
    </label>
    <label class="grid grid-c-2" style="margin:10px 0">
        <span>Descripción: </span>
        <input class="input-txt" type="text" name="description_p" value="<?php echo isset($product)?$product->getName():""?>">
    </label>
    <label class="grid grid-c-2" style="margin:10px 0">
        <span>Cantidad: </span>
        <input class="input-txt" type="number" name="quantity_p" value="<?php echo isset($product)?$product->getName():0?>" min="0">
    </label>
    <label class="grid grid-c-2" style="margin:10px 0">
        <span>Precio: </span>
        <input class="input-txt" type="text" name="price" value="<?php echo isset($product)?$product->getName():""?>">
    </label>
    <label class="grid grid-c-2" style="margin:10px 0">
        <span>Descuento: </span>
        <input class="input-txt" type="number" name="discount" value="<?php echo isset($product)?$product->getName():""?>" placeholder="digite número entre 0 y 100">
    </label>
    <label class="grid grid-c-2" style="margin:10px 0">
        <span>Categoría: </span>
        <select name="ctg_p" id="">
            <option value="0">seleccione</option>
            <?php 
            if(isset($all_category)){
                foreach($all_category as $ctg){
            ?>
                <option value="<?php echo $ctg->id_ctg?>"><?php echo $ctg->name_ctg?></option>
            <?php
                }
            }
            ?>
        </select>
    </label>
    <label class="flex-center flex-y">
        <input type="submit" value="<?php echo isset($action)?$action:"Guardar"?>" class="button-send gradient-00B4DB" name="t">
    </label>
</form>

</section>
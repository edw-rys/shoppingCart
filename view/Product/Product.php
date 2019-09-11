<header>
    <?php include_once NAVIGATION?>
</header>

<main>
    <article class="type-products">
        <h1 class="tittle txt-center">Productos</h1>
        <?php
            if(isset($listCtgProd) && !empty($listCtgProd)){
                foreach($listCtgProd as $ctg){
                    ?>
                    <section class="container-product">
                    <h2 class="tittle txt-center"><?php echo( $ctg->getName())?></h2>
                    <div id="productos">
                    <?php 
                    if(isset($listProducts) && !empty($listProducts)){
                        foreach($listProducts as $prod){
                            if( $prod->getCategory()->getId() == $ctg->getId()){
                        ?>
                        <div class="producto relative">
                            <?php if( $prod->getDiscount()!=0){
                            ?>
                            <div class="discount">
                                <span><?php echo $prod->getDiscount();?>% de descuento</span>
                            </div>
                            <?php
                            }?>
                            <img src="<?php echo $prod->getUrl_img()?>" alt="<?php echo $prod->getName()?>">
                            <div class="buy flex space-btw">
                                <?php 
                                    if( $prod->getDiscount()!=0) 
                                        echo "<span class='not-price txt-through '>$ ".$prod->getPrice()."</span>" 
                                ?>
                                <span class="price">$ <?php echo $prod->getPrice()*((100-$prod->getDiscount())/100) ?></span>
                                <a class="btn-add-car flex-center" href="#!">
                                    <span style="margin-right:5px">Add car</span> 
                                    <img src="<?php echo ROUTEIMG."icons/shopping-cart-solid.svg"?>" alt="">
                                </a>
                            </div>
                            <div class="description flex space-btw flex-x flex-center">
                                <span><?php echo $prod->getName()?></span>
                                <a href="#!" class="btn-like flex-center <?php echo $prod->isI_like()?'like':'no-like'?>"><img src="<?php echo ROUTEIMG.'icons/heart-regular.svg'?>" alt=""></a>
                            </div>
                        </div>
                    <?php 
                            }
                        }
                    } ?>
                    </div>
                </section>
                    <?php
                }
            }
        ?>
    </article>
</main>

<div class="m-20"></div>

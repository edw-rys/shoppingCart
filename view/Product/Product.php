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
                                include "view/components/productDesign.php";
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

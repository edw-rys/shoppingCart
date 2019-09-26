<header>
    <?php include_once NAVIGATION?>
</header>

<main>
    <article class="type-products">
        <h1 class="tittle txt-center">Productos</h1>
        <?php
            echo count($data);
            if(count($data)>1 ){
                $listCtgProd = $data['catgories'];
                $listProducts = $data['products'];


                if(!empty($listCtgProd)){
                    foreach($listCtgProd as $ctg){
                        ?>
                        <section class="container-product">
                        <h2 class="tittle txt-center"><?php echo( $ctg->getName())?></h2>
                        <?php 
                        if(!empty($listProducts)){
                            echo '<div class="productos">';
                            foreach($listProducts as $prod){
                                if( $prod->getCategory()->getId() == $ctg->getId()){
                                    include COMPONENTS."productDesign.php";
                                }
                            }
                            echo '</div>';
                        } ?>
                        
                    </section>
                        <?php
                    }
                }
            }
        ?>
    </article>
</main>

<div class="m-20"></div>

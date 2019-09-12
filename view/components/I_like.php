<section class="container">
    <h2>Deseos</h2>
    <div class="all-items grid-center">
        <?php if(isset($itemsLike)){
            foreach($itemsLike  as   $prod){
                include "view/components/productDesign.php";
            }
        }
        ?>
    </div>
</section>
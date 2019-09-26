<section class="container">
    <h2>Deseos</h2>
    <div class="all-items grid-center">
        <?php if(isset($data['itemsLike'])){
            $itemsLike=$data['itemsLike'];
            foreach($itemsLike  as   $prod){
                include COMPONENTS."productDesign.php";
            }
        }
        ?>
    </div>
</section>
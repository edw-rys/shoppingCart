<section class="container">
    <h2>Lista de compras hechas</h2>
    <div class="all-items-butout" style="">
        <table class="wid-100p table-style">
            <thead>
                <th>Número</th>
                <th>Id</th>
                <th>Nombre</th>
                <th>Precio de compra</th>
                <th>Fecha de la compra</th>
            </thead>
            <tbody>
                
                <?php 
                if(isset($itemsBuyout)){
                    $i=1;
                    foreach($itemsBuyout  as   $prod){
                        ?>
                        <tr>
                            <td><?php echo $i++;?></td>
                            <td><?php echo $prod->id_product;?></td>
                            <td><?php echo $prod->name_prod;?></td>
                            <td><?php echo $prod->price_sale;?></td>
                            <td><?php echo $prod->date_sale;?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
        
    </div>
</section>
<div class="m-40"></div>
<div class="shopping">
<section class="container">
    <h2 class="tittle txt-center">Lista de compras hechas</h2>
    <div class="all-items-butout" style="">
        <table class="wid-100p table-style">
            <thead>
                <th>Número</th>
                <th>Id producto</th>
                <th>Nombre</th>
                <th>Precio de compra</th>
                <th>Fecha de la compra</th>
                <th>Usuario</th>
                <th>Nombre y apellido</th>
                <th>Edad</th>
            </thead>
            <tbody>
                
                <?php 
                if(isset($items_Sale)){
                    $i=1;
                    foreach($items_Sale  as   $prod){
                        ?>
                        <tr>
                            <td><?php echo $i++;?></td>
                            <td><?php echo $prod->id_product;?></td>
                            <td><?php echo $prod->name_prod;?></td>
                            <td><?php echo $prod->price_sale;?></td>
                            <td><?php echo $prod->date_sale;?></td>
                            <td><?php echo $prod->username;?></td>
                            <td><?php echo $prod->name_ln;?></td>
                            <td><?php echo $prod->edad;?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
        
    </div>
</section>
</div>
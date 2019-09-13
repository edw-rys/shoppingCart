    <!-- <div class="items-panel fixed-center"> -->
        <div class="_body">
            <div class="tbl-header">
                <table class="wid-100p">
                    <thead>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Descuento</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Quitar</th>
                    </thead>
                </table>
            </div>
            <div class="table-content">
                <table id="table-items-shop" class="wid-100p">
                    <tbody>
                        <?php if(isset($products)){
                            $subtotal=0;
                            foreach($products as $product){
                                $precioTotal=(((100-$product['product']->discount)/100)*$product['product']->price*$product['cant']);
                                $subtotal+=$precioTotal;
                                ?>
                                <tr>
                                    <td><?php echo $product["product"]->name_prod?></td>
                                    <td>$ <?php echo $product["product"]->price?></td>
                                    <td><?php echo $product["product"]->discount?> %</td>
                                    <td>
                                        <input type="number" name="" id="" value="<?php echo $product['cant']?>" onchange="changeValue(<?php echo $product['product']->id_prod .','.$product['product']->discount.','.$product['product']->price.','.$product['product']->quantity ?>,this)" min=1 max=<?php echo $product["product"]->quantity?>>
                                    </td>
                                    <td>$ <?php echo $precioTotal?></td>
                                    <td><button class='btn-remove-item' onclick="removeItem(this.parentNode.parentNode,<?php echo $product['product']->id_prod?>)">x</button></td>
                                </tr>
                                <?php
                            }
                        }?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="_footer" id="footer-modal">
            <p class="flex space-around">
                <span>Subtotal</span><span>$ <?php echo $subtotal?></span>
                <span>Iva 12%</span><span>$ <?php echo $subtotal*0.12?></span>
                <span>Total</span><span>$ <?php echo $subtotal*1.12?></span>
            </p>
        </div>
        <div class="m-20"></div>
        <div class="send flex flex-center">
            <a href="index.php?c=cart&a=buy" class="button-send">Comprar</a>
        </div>
    <!-- </div> -->
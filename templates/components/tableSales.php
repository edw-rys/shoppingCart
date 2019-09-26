<section class="container">
    <h2 class="tittle txt-center">Lista de ventas</h2>
    <div class="filter flex flex-center">
        <input type="text" placeholder="">
        <select name="" id="">
            <option value="1">Fecha</option>
            <option value="2">Usuario</option>
        </select>
    </div>
    <div class="all-items-butout" style="">
        <table class="wid-100p table-style">
            <thead>
                <th>Número Factura</th>
                <th>Fecha venta</th>
                <th>Id producto</th>

                <th>Nombre del producto</th>
                <th>Descripción</th>
                <th>Precio de compra</th>
                <th>Cantidad compra</th>
                <th>Categoría</th>

                <th>Username</th>
                <th>Nombre y apellido</th>
                <th>Género</th>
                <th>Edad</th>
                <th>Correo</th>
                <th>País</th>
                <th>País</th>
            </thead>
            <tbody>
                
                <?php 
                if(isset($data["bills"])){
                    $bills=$data["bills"];
                    $i=1;
                    foreach($bills  as   $item){
                        foreach($item->getSales() as $data){
                        ?>
                        <tr>
                            <td><?php echo $item->getId_bill();?></td>
                            <td><?php echo $item->getDate_sale();?></td>
                            <td><?php echo $data->id_prod;?></td>
                            <td><?php echo $data->name_prod;?></td>
                            <td><?php echo $data->description;?></td>
                            <td><?php echo $data->price_sale;?></td>
                            <td><?php echo $data->quantity_sale;?></td>
                            <td><?php echo $data->name_ctg;?></td>
                            <td><?php echo $data->username;?></td>
                            <td><?php echo $data->name_user." ".$data->last_name;?></td>
                            <td><?php echo $data->name_gender;?></td>
                            <td><?php echo date("Y")- date("Y", strtotime($data->birthdate));?></td>
                            <td><?php echo $data->mail;?></td>
                            <td><?php echo $data->name_cy;?></td>
                            <td><?php echo $data->name_ct;?></td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td><?php echo $item->getPrice();?></td>
                        </tr>
                        <?php
                        }
                    }
                }
                ?>
            </tbody>
        </table>
        
    </div>
</section>

<div id="window-modal-items" class="hidden">
    <div class="items-panel fixed-center">
        <div class="_head flex space-btw">
            <p class="flex-center">Items seleccionados</p>
            <a href="#!" onclick="toggle('#window-modal-items','hidden')">
                <img class="icon" src="<?php echo ROUTEIMG."icons/close.svg"?>" alt="close" width="30" height="30">
            </a>
        </div>
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
                    </tbody>
                </table>
            </div>
        </div>
        <div class="_footer" id="footer-modal">
        </div>
        <div class="m-20"></div>
        <div class="send flex flex-center">
            <a href="index.php?c=cart&a=buy" class="button-send">Comprar</a>
        </div>
    </div>
</div>
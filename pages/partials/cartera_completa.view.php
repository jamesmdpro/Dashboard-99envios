<div class="cartera-completa">
    <h2>Cartera Completa</h2>
        <table id="cartera-completa--table">
        <thead>
        <tr>
            <th>Numero de guia</th>
            <th>Valor Comercial</th>
            <th>Valor flete</th>
            <th>Valor consignado</th>
            <th>Estado</th>
        </tr>
        <?php foreach ($card10 as $envio): ?>
            <tr>
                <td><?php echo $envio->numero_de_guia ?></td>
                <td class="valor-comercial">$ <?php echo number_format($envio->valor_comercial, ) ?></td>
                <td class="valor-comercial">$ <?php echo number_format($envio->valor_flete, ) ?></td>
                <td class="valor-comercial">$ <?php echo number_format($envio->valor_consignado, ) ?></td>
                <td><?php echo $envio->estado_del_envio ?></td>
                
            </tr>
        <?php endforeach; ?>            
                
        </thead>
        <!-- Add tbody here | JS insertion -->
    </table>
    <a href="#">Ver más</a>
    </div>
</main>
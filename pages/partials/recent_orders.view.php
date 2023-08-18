<div class="recent-orders">
    <h2>Ordenes Recientes</h2>
    <table id="recent-orders--table">
        <thead>
        <tr>
            <th>Numero de guia</th>
            <th>Fecha de envio</th>
            <th>Valor comercial</th>
            <th>Ciudad</th>
            <th>Producto</th>
        </tr>
        <?php foreach ($card9 as $envio): ?>
            <tr>
                <td><?php echo $envio->numero_de_guia ?></td>
                <td><?php echo $envio->fecha_envio ?></td>
                <td class="valor-comercial">$ <?php echo number_format($envio->valor_comercial, ) ?></td>
                <td><?php echo $envio->ciudad_destino ?></td>
                <td><?php echo $envio->Producto ?></td>
            </tr>
        <?php endforeach; ?>            
                
        </thead>
        <!-- Add tbody here | JS insertion -->
    </table>
    <a href="#">Ver más</a>
    </div>

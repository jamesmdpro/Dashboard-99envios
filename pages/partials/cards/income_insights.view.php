<div class="income">
    <span class="material-icons-sharp"> stacked_line_chart </span>
    <div class="middle">
    <div class="left">
        <h3>Estado Envios </h3>
        <div class = table>
        <table>
            <?php
                $estado_labels = ['Entregado', 'En movimiento', 'Cancelado'];
                
                foreach ($estado_labels as $label) {
                    $estado = null;
                    foreach ($card5 as $item) {
                        if ($item->estado_transformado === $label) {
                            $estado = $item;
                            break;
                        }
                    }
                    $total_envios = $estado ? $estado->total_envios : 0;
                    echo '<tr>';
                    echo '<td>' . $label . '</td>';
                    echo '<td>' . $total_envios . '</td>';
                    echo '</tr>';

                  
                }
                
                ?>
        </table>
        </div>
    </div>
    </div>
    <small class="text-muted"> Ver más </small>
</div>



<!--  
    <div class="income">
    <span class="material-icons-sharp"> stacked_line_chart </span>
    <div class="middle">
    <div class="left">
        <h3>Estado Envios </h3>
        <h3><?php// echo $card5[0]->estado_transformado?></h3>
        <h3><?php //echo $card5[1]->estado_transformado?></h3>  
    </div>
    <div class="progress">
        <svg>
        <rect x="50" y="250" width="50" height="50"></rect>
        </svg>
        <div class="number2">

        <p><?php //echo $card5[0]->total_envios?></p>
        <br>
        <p><?php //echo $card5[1]->total_envios?></p>
        </div>
    </div>
    </div>
    <small class="text-muted"> Ver más </small>
</div>

            <tr>
                <td><?php/// echo $card5[0]->estado_transformado ?></td>
                <td><?php //echo $card5[0]->total_envios ?></td>
            </tr>
            <tr>
                <td><?php //echo $card5[1]->estado_transformado ?></td>
                <td><?php //echo $card5[1]->total_envios ?></td>
            </tr>
            <tr>
                <td><?php //echo $card5[1]->estado_transformado ?></td>
                <td><?php //echo $card5[1]->total_envios ?></td>
            </tr>





-->



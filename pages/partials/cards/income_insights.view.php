<div class="income">
    <span class="material-icons-sharp"> stacked_line_chart </span>
    <div class="middle">
    <div class="left">
<<<<<<< HEAD
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
=======
        <h3>Transportadora </h3>
        <h1><?php echo $card5[0]->transportadora ?></h1>
        <h1><?php echo $card5[0]->total_envios ?><style>h1 {
                                        font-weight: 500;
                                        font-size: 1.2rem;
                                    }
                            </style>
                                </h1>
    </div>
    <div class="progress">
        <svg>
        <circle cx="38" cy="38" r="36"></circle>
        </svg>
        <div class="number">
        <p>44%</p>
>>>>>>> c2bb1c885d1679b4002e9c09fc825c73dd844896
        </div>
    </div>
    </div>
    <small class="text-muted"> Ver más </small>
<<<<<<< HEAD
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


=======
</div>
>>>>>>> c2bb1c885d1679b4002e9c09fc825c73dd844896

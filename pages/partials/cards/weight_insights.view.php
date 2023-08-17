<div class="weigth">
    <span class="material-icons-sharp"> scale</span>
    <div class="middle">
    <div class="left">
        <h3>Destinos más usados</h3>
        <div class = table>
        <table>
            <tr>
                <td><?php echo $card6[0]->ciudad_destino ?></td>
                <td><?php echo $card6[0]->total_envios ?></td>
            </tr>
            <tr>
                <td><?php echo $card6[1]->ciudad_destino ?></td>
                <td><?php echo $card6[1]->total_envios ?></td>
            </tr>
          
        </table>
        </div>
    </div>
    </div>
    <small class="text-muted"> Ver más </small>
</div>
<style>
    
    table {
        border-collapse: collapse;
        width: 120%;
    }

    th {
        padding: 0px;
        font-weight: bold;
        font-size: 0.87rem;
    }
    td {
        padding:16px;
        margin-block-start:0px;
        text-align: left;
        font-weight: bold;
        font-size: 0.87rem;
    }


</style>

<!--
    <div class="weigth">
    <span class="material-icons-sharp"> scale</span>
    <div class="middle">
    <div class="left">
        <h3>Destinos más usados</h3>
        <h3><?php //echo $card6[0]->ciudad_destino ?></h3>
        <h3><?php //echo $card6[1]->ciudad_destino ?></h3>
    </div>
    <div class="progress">
        <svg>
        <rect x="50" y="250" width="50" height="50"></rect>
        </svg>
        <div class="number">

        <p><?php //echo $card6[0]->total_envios ?></p>
        <br>
        <p><?php //echo $card6[1]->total_envios ?></p>
        </div>
    </div>
    </div>
    <small class="text-muted"> Ver más </small>
</div>
-->
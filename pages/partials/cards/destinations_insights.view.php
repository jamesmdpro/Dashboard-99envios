<div class="destinos">
    <span class="material-icons-sharp">emoji_objects</span>
    <div class="middle">
    <div class="left">
        <h3>Destinos más usados</h3>


        <h3><?php echo $card8[0]->ciudad_destino ?></h3>
        <h3><?php echo $card8[1]->ciudad_destino ?></h3>
    </div>
    <div class="progress2">
        <svg>
        <rect x="50" y="250" width="50" height="50"></rect>
        </svg>
        <div class="number2">

        <p><?php echo $card8[0]->total_envios ?></p>
        <br>
        <p><?php echo $card8[1]->total_envios ?></p>
        </div>
    </div>
    </div>
    <small class="text-muted"> Ver más </small>
</div>
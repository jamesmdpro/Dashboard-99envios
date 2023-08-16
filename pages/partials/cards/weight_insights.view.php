<div class="weigth">
    <span class="material-icons-sharp"> scale</span>
    <div class="middle">
    <div class="left">
        <h3>Estado de envio</h3>
        <h3><?php echo $card6 ?></h3>
        <h1><?php foreach ($card6 as $card) {
            echo $card->total_envios. "<br>";
            }?>
        </h1>       
    </div>
    <div class="progress">
        <svg>
        <circle cx="38" cy="38" r="36"></circle>
        </svg>
        <div class="number">
        <p>75%</p>
        </div>
    </div>
    </div>
    <small class="text-muted"> Ver más </small>
</div>
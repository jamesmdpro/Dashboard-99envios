<div class="otro">
    <span class="material-icons-sharp">receipt_long</span>
    <div class="middle">
    <div class="left">
        <h2>Estados de pago</h2>
        <h3><?php echo $card7[0]->estado_de_pago ?></h3>
        <h3><?php foreach ($card7 as $card) {
            echo $card->estado_de_pago. "<br>";
            }?><blockquote><?php echo $card7[0]->total_envios ?></blockquote>
        </h3>        
    </div>
    <div class="progress">
        <svg>
        <rect x="120" y="200" width="50" height="100"></rect>
        </svg>
        <div class="number">
        <p><?php echo $card7[0]->total_envios ?></p>       
        </div>
    </div>
    </div>
    <small class="text-muted"> Ver más </small>
</div>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet" />
  <link rel="stylesheet" href="pages/styles99.css" />

  <link rel="icon" href="favicon.png" type="pages/images/logo_2.png">

</head>

<body>
  <div class="container">
    <aside>
      <div class="top">
        <div class="logo">
          <img src="pages/images/logo.png" alt="Logo"class="custom-logo" />
          <h2>ENV<span class="danger">IOS</span></h2>
        </div>
        <div class="close" id="close-btn">
          <span class="material-icons-sharp"> close </span>
        </div>
      </div>
      <!-- SIDEBAR -->
      <div class="sidebar">
        <?php view('partials/sidebar.view.php'); ?>
      </div>
    </aside>

    <main>
      <h1>Dashboard</h1>

      <div class="date">
        <form id="consultaForm" method="POST">
          <label for="fecha">Selecciona una fecha:</label>
          <input type="date" id="fecha" name="fecha">
          <button type="button" onclick="modificarConsulta()">Modificar Consulta</button>
        </form>
      </div>


      <?php view('partials/insights.view.php', [
        'card1'=>$card1,
        'card2'=>$card2,
        'card3'=>$card3,
        'card4'=>$card4,
        'card5'=>$card5,
        'card6'=>$card6,
        'card7'=>$card7,
        'card8'=>$card8,

        
       

      ]); ?>

      
      <!--  HABILITAR  EN LA SIGUIENTE FASE   ESPACIO DE LA GRAFICA  -->

      <?php /* view('partials/grafica/container_grafica_card1.view.php', [ ]); */?>

      
      <!--  HABILITAR  EN LA SIGUIENTE FASE PEDIDOS POR ORDEN DE COMPRA POR DIA  -->
           
      <?php view('partials/recent_orders.view.php', [
        'card9'=>$card9,
      ]);?>

      <?php view('partials/cartera_completa.view.php', [
              'card10'=>$card10,
            ]);?>

      

      <!--   IMPLEMENTAR ALGO DE UTILIDAD  -->
      <?php view('partials/rigth.view.php', [
        

      ]); ?>
      
      
      

    </main>

    <!-- Scripts y enlaces JavaScript -->
    <script src="json_data/recent-order-data.js"></script>
    <script src="json_data/update-data.js"></script>
    <script src="json_data/sales-analytics-data.js"></script>
    <script src="pages\index.js"></script>
    
  </div>
</body>

</html>
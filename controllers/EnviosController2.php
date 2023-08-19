<?php

namespace Controllers;


use Models\Envios;
use Models\Cartera;
use Carbon\Carbon;



class EnviosController2 extends Controller
{
    public function index() {
        $total_envios_365 =$this->obtenerCodigoSucursal(27986);

        $total_enviado = $this->obtenerValorComercial(27986);
        $total_pagado =$this->obtenerFlete(27986);
        $total_fletes =$this->obtenerConsignado(27986);
        $estados_envios_cartera  = $this->obtenerEstadoEnvio(27986);
        $destinos_mas_usados = $this->obtenerCiudadEnvios(27986);
        $estado_de_pago_envios = $this->obtenerEstadoPago(27986);
        $transportadora_mas_usada = $this->obtenerTransportadora(27986);

        $destinos_mas_usados = $this->obtenerCiudadEnvios(27986);

        /* TABLAS ORDENES Y CARTERA   */     
        $ordenes_recientes = $this->obtenerOrdenesRecientes(27986);
        $cartera_recientes = $this->obtenerCarteraCompleta(27986);



        /* Grafica  
        $envios_semana_a_semana = $this->obtenerCiudadEnvios($usuario);
        $total_semana_grafica = $this->graficaTotalEnviosSemana($usuario);
*/

        return view('index.view.php',  [
            'card1'=>$total_envios_365, //ok
            'card2'=>$total_enviado,//ok
            'card3'=>$total_pagado,//ok
            'card4'=>$total_fletes,//ok
            'card5'=>$estados_envios_cartera,//ok
            'card6'=>$destinos_mas_usados, // destinos mas ususados
            'card7'=>$transportadora_mas_usada, // transportadora mas usada

            'card8'=>$destinos_mas_usados,

            /* TABLAS ORDENES Y CARTERA   */ 
            'card9'=>$ordenes_recientes,  
            'card10'=>$cartera_recientes, 


            /* Grafica  
            'grafica'=>$envios_semana_a_semana,
            'grafica_total'=>$total_semana_grafica
            */


        ]);
    }
    /*-------- CARD 1       --------- */
    public function obtenerCodigoSucursal($codigo_sucursal) {

        $total_envios_365 = Envios::where('codigo_sucursal', $codigo_sucursal)
            ->count();
    
        return $total_envios_365;
    }
    
    /*-------- CARD 2       --------- */
    public function obtenerValorComercial($codigo_sucursal){

        $total_enviado = Envios::where('codigo_sucursal', $codigo_sucursal)
            ->sum('valor_comercial');

        return $total_enviado = number_format($total_enviado, 0, ',', '.');

    }
    /*-------- CARD 3       --------- */
    public function obtenerFlete($codigo_sucursal){

        $total_pagado = Cartera::where('codigo_sucursal', $codigo_sucursal)
            ->sum('Valor_consignado');

        return $total_pagado = number_format($total_pagado, 0, ',', '.');
    
    }
    /*-------- CARD 4       --------- */
    public function obtenerConsignado($codigo_sucursal) {

        $total_fletes = Envios::where('codigo_sucursal', $codigo_sucursal)
             ->sum('Valor_flete');

        return $total_fletes = number_format($total_fletes, 0, ',', '.');
    }

    /*-------- CARD 5    --------- 
        SELECT
            CASE
                WHEN estado_del_envio = 'Entregada', THEN 'Entregado'
                WHEN estado_del_envio = 'Cancelado', THEN 'Cancelado'
                ELSE 'En moviento'
            END AS estado_transformado,
            COUNT(*) AS total_envios
        FROM cateracompleta
        WHERE codigo_sucursal = $usuario
        GROUP BY estado_transformado
        ORDER BY total_envios DESC;    



        SELECT `estado_del_envio`, COUNT(*) as `total_envios`
        FROM `cateracompleta`
        WHERE `codigo_sucursal` = $usuario
        GROUP BY `estado_del_envio`
        ORDER BY `total_envios` DESC;       
    }

    */
    public function obtenerEstadoEnvio($codigo_sucursal) {

        $estados_envios_cartera = Cartera::selectRaw("
            CASE
                WHEN estado_del_envio = 'Entregada' THEN 'Entregado'
                WHEN estado_del_envio = 'Cancelado' THEN 'Cancelado'
                ELSE 'En movimiento'
            END AS estado_transformado,
            COUNT(*) AS total_envios
            ")
        ->where('codigo_sucursal', $codigo_sucursal)
        ->groupBy('estado_transformado')
        ->orderByDesc('total_envios')
        ->get();

        return $estados_envios_cartera;
}

    /*-------- CARD 6       --------- */
    public function obtenerCiudadEnvios($codigo_sucursal){

        $destinos_mas_usados = Envios::select('ciudad_destino', Envios::raw('COUNT(*) as total_envios'))
            ->where('codigo_sucursal', $codigo_sucursal)
            ->groupBy('ciudad_destino')
            ->orderByDesc('total_envios')
            ->take(2)
            ->get();
        
        return $destinos_mas_usados;

    }


     /*-------- CARD 7    --------- */
    public function obtenerEstadoPago($codigo_sucursal){

        $estado_de_pago_envios = Envios::select('estado_de_pago', Envios::raw('COUNT(*) as total_envios'))
            ->where('codigo_sucursal', $codigo_sucursal)
            ->groupBy('estado_de_pago')
            ->orderByDesc('total_envios')
            ->take(3)
            ->get();
        
        return $estado_de_pago_envios;


   
    }
    /*---- TRANSPORTADORA    CARD 8--*/

    public function obtenerTransportadora($codigo_sucursal){

        $transportadora_mas_usada = Envios::select('transportadora', Envios::raw('COUNT(*) as total_envios'))
            ->where('codigo_sucursal', $codigo_sucursal)
            ->where('fecha_envio', '>=', Envios::raw("DATE_FORMAT(NOW(), '%Y-%m-05')"))
            ->where('fecha_envio', '<', Envios::raw("DATE_ADD(DATE_FORMAT(fecha_envio, '%Y-%m-05'), INTERVAL 1 MONTH)"))
            ->groupBy('transportadora')
            ->orderByDesc('total_envios')
            
            ->get();
    
        return $transportadora_mas_usada;

    }    

    /*-------- GRAFICA       --------- */
    
    public function obtenerEnviosSemanaActual($codigo_sucursal){
        $grafica_envios_por_dia = Envios::table('envioscompleto')
            ->where('codigo_sucursal', $codigo_sucursal)    
            ->select('fecha_envio', Envios::raw('COUNT(*) AS cantidad_envios'))
            ->whereRaw('YEARWEEK(fecha_envio, 1) = YEARWEEK(CURDATE(), 1)')
            ->groupBy('fecha_envio')
            ->orderBy('fecha_envio')
            ->get();
        
            return $grafica_envios_por_dia;
    }



    /*-------- ORDENES RECIENTES  CARD 9    --------- 
  
*/
    public function obtenerOrdenesRecientes($codigo_sucursal){

        $ordenes_recientes = Envios::select('numero_de_guia', 'fecha_envio', 'ciudad_destino', 'valor_comercial', 'Producto')
        ->selectRaw("ROW_NUMBER() OVER (PARTITION BY codigo_sucursal ORDER BY fecha_envio DESC) AS row_num")
        ->orderBy('codigo_sucursal')
        ->orderBy('fecha_envio', 'desc')
        ->limit(15)
        ->get();
    
            return $ordenes_recientes;
}
/*-------- CARTERA COMPLETA  CARD 10    --------- 
  
*/
    public function obtenerCarteraCompleta($codigo_sucursal){

        $cartera_recientes = Cartera::select('numero_de_guia', 'valor_comercial', 'valor_flete', 'valor_consignado', 'estado_del_envio')
        ->selectRaw("ROW_NUMBER() OVER (PARTITION BY codigo_sucursal ORDER BY fecha_de_consignacion DESC) AS row_num")
        ->orderBy('codigo_sucursal')
        ->orderBy('fecha_de_consignacion', 'desc')
        ->limit(15)
        ->get();

            return $cartera_recientes;
    }

}// FIN DE LA CLASS ENVIOSCONTROLLER2

/*  CARD9 TRASFORMADAS  SQL Y ORM

      SELECT
            numero_de_guia AS Numero_de_guia,
            fecha_envio AS Fecha_de_envio,
            valor_comercial AS payment,
            CASE
                WHEN estado_del_envio = 'Delivered' THEN 'Entregado'
                WHEN estado_del_envio = 'Declined' THEN 'Cancelado'
                ELSE 'En movimiento'
            END AS estado_transformado,
            CASE
                WHEN estado_del_envio = 'Delivered' THEN 'primary'
                WHEN estado_del_envio = 'Declined' THEN 'danger'
                ELSE 'warning'
            END AS statusColor
        FROM envioscompleto
        WHERE codigo_sucursal = $usuario;




    public function obtenerOrdenesRecientes($codigo_sucursal){

        $ordenes_recientes = Envios::selectRaw([
            'numero_de_guia as Numero_de_guia',
            'fecha_envio as Fecha_de_envio',
            'valor_comercial as payment',
            Envios::raw("CASE WHEN estado_del_envio = 'Delivered' THEN 'Entregado'
                          WHEN estado_del_envio = 'Declined' THEN 'Cancelado'
                          ELSE 'En movimiento'
                     END AS estado_transformado"),
            Envios::raw("CASE WHEN estado_del_envio = 'Delivered' THEN 'primary'
                          WHEN estado_del_envio = 'Declined' THEN 'danger'
                          ELSE 'warning'
                     END AS statusColor"),
        ])
        ->where('codigo_sucursal', $codigo_sucursal)
        ->take(1)
        ->get();
    
        return $ordenes_recientes;


    }
        // Convertir los datos a formato JSON
    //$jsonData = json_encode($ordenes_recientes, JSON_PRETTY_PRINT);
    
    // Definir la ruta del archivo JSON
    //$rutaArchivoJson = base_path('app/99envios/json_data/recent-order-data.js');
    
    // Escribir los datos en el archivo JSON
    //file_put_contents($rutaArchivoJson, 'const RECENT_ORDER_DATA = ' . $jsonData . ';');
    */





    /*-------- TOTAL  ENVIOS SEMANA GRAFICA2     --------- */

 
    /*
    public function obtenerCiudadEnvios($codigo_sucursal){

        $destinos_mas_usados = Envios::select('ciudad_destino', Envios::raw('COUNT(*) as total_envios'))
            ->where('codigo_sucursal', $codigo_sucursal)
            ->where('fecha_envio', '>=', Envios::raw("DATE_FORMAT(NOW(), '%Y-%m-05')"))
            ->where('fecha_envio', '<', Envios::raw("DATE_ADD(DATE_FORMAT(fecha_envio, '%Y-%m-05'), INTERVAL 1 MONTH)"))
            ->groupBy('ciudad_destino')
            ->orderByDesc('total_envios')
            ->take(2)
            ->get();
        
        return $destinos_mas_usados;

    }


     /*
    public function consultar($codigo_sucursal)
    {      
        CARD 1
        $total_envios_365 = Envios::where('codigo_sucursal', $codigo_sucursal)
            ->where('fecha_envio', '>=', date('Y') . '-01-01')
            ->count();
        CARD 4

        $total_fletes = Envios::where('codigo_sucursal', $codigo_sucursal)

            ->where('fecha_envio', '>=', date('Y-m-05'))
            ->where('fecha_envio', '<', date('Y-m-05', strtotime('+1 month')))
            ->count();

        CARD 5
        $transportadora_mas_usada = Envios::select('transportadora')
            ->where('codigo_sucursal', $codigo_sucursal)
            ->groupBy('transportadora')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(1)
            ->value('transportadora');
            
        $total_envios_transportadora = Envios::where('codigo_sucursal', $codigo_sucursal)
            ->where('fecha_envio', '>=', date('Y-m-05'))
            ->where('fecha_envio', '<', date('Y-m-05', strtotime('+1 month')))
            ->groupBy('transportadora')
            ->count();
         CARD 3   

        $total_pagado = Envios::where('codigo_sucursal', $codigo_sucursal)


            ->where('fecha_envio', '>=', date('Y-m-05'))
            ->where('fecha_envio', '<', date('Y-m-05', strtotime('+1 month')))
            ->sum('Valor_flete');
        CARD2

        $total_fletes = Envios::where('codigo_sucursal', $codigo_sucursal)

            ->where('fecha_envio', '>=', date('Y-m-05'))
            ->where('fecha_envio', '<', date('Y-m-05', strtotime('+1 month')))
            ->sum('valor_consignado');

            
        $envios_por_mes = Envios::selectRaw('COUNT(*) AS total_envios, MONTH(fecha_envio) AS mes')
            ->where('codigo_sucursal', $codigo_sucursal)
            ->groupBy('mes')
            ->get();
       
        $destinos_mas_usados = Envios::select('ciudad_destino', \DB::raw('COUNT(*) AS total_envios'))
            ->where('codigo_sucursal', $codigo_sucursal)
            ->where('fecha_envio', '>=', date('Y-m-05'))
            ->where('fecha_envio', '<', date('Y-m-05', strtotime('+1 month')))
            ->groupBy('ciudad_destino')
            ->orderByRaw('COUNT(*) DESC')
            ->get();
        

        $destinos_mas_usados = Envios::select('ciudad_destino', Leaf\DB::raw('COUNT(*) AS total_envios'))
            ->where('codigo_sucursal', $codigo_sucursal)
            ->where('fecha_envio', '>=', date('Y-m-05'))
            ->where('fecha_envio', '<', date('Y-m-05', strtotime('+1 month')))
            ->groupBy('ciudad_destino')
            ->orderByRaw('COUNT(*) DESC')
            ->get();



        $estados_envio = Envios::select('estado_del_envio', leaf\DB::raw('COUNT(*) AS total_envios'))
            ->where('codigo_sucursal', $codigo_sucursal)
            ->groupBy('estado_del_envio')
            ->get();

        $estados_pago = Envios::select('estado_de_pago', leaf\DB::raw('COUNT(*) AS total_envios'))
            ->where('codigo_sucursal', $codigo_sucursal)
            ->where('fecha_envio', '>=', date('Y-m-05'))
            ->where('fecha_envio', '<', date('Y-m-05', strtotime('+1 month')))
            ->groupBy('estado_de_pago')
            ->get();


        $data = [
            'total_envios_365' => $total_envios_365,
            

            'total$total_fletes' => $total_fletes,
            'Total$total_fletes' => $total_fletes,
            
            'transportadora_mas_envios' => $transportadora_mas_usada,
            'total_envios_transportadora' => $total_envios_transportadora,
            'total_pagado' => $total_pagado,

            

            
            'estados_pago' => $estados_pago,
            'estados_envio' => $estados_envio,
            'destino_mas_usado' => $destinos_mas_usados,
            'envios_por_mes_x_mes' => $envios_por_mes,
            
        ];

        return view('/index.view.php',[ $data ]);
        
        
        return response()->json([$data]);
        return view('index.view.php');
        echo view('index', [
            'data' => $data,
        ]);
        
    }
    /*
    public function otro_index()
    {
        response()->json(Test::all());
    }

    /*
    -------- CARD 4       ---------  CONSULTA ENVIOS MES A A MES CON CORTE DE 5 AL 5 DE CADA MES 
    public function obtenerConsignado($codigo_sucursal) {

        $year = date('Y'); // Año actual
        $month = date('m'); // Mes actual
        $total_fletes = 0;

        for ($m = $month; $m <= 12; $m++) {
            $start_date = ($m == $month) ? date("$year-$month-05") : date("$year-$m-05");
            $nextMonth = ($m == 12) ? 1 : $m + 1;
            $end_date = ($m == $month) ? date("$year-$nextMonth-05") : date("$year-$nextMonth-05", strtotime("+1 month"));

            $total_envios = Envios::where('codigo_sucursal', $codigo_sucursal)
                ->where('fecha_envio', '>=', $start_date)
                ->where('fecha_envio', '<', $end_date)
                ->count();

                $total_fletes += $total_envios;

        }
        echo "Total acumulado: $total_fletes";

        return $total_fletes;
    }






    */


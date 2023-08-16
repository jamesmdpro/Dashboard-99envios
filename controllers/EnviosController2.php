<?php

namespace Controllers;


use Models\Envios;
use Models\Cartera;
use Carbon\Carbon;


class EnviosController2 extends Controller
{
    public function index() {
        $total_envios_365 =$this->obtenerCodigoSucursal(27986);
        $total_consignado = $this->obtenerValorComercial(27986);
        $total_fletes =$this->obtenerFlete(27986);
        $total_envios_5_a_5 =$this->obtenerCodigoSucursal2(27986);
        $transportadora_mas_usadas = $this->obtenerTransportadora(27986);
        $Estados_envios_cartera = $this->obtenerEstadoEnvio(27986);
        $estado_de_pago_envios = $this->obtenerEstadoPago(27986);
        $destinos_mas_usados = $this->obtenerCiudadEnvios(27986);



        /* Grafica  
        $envios_semana_a_semana = $this->obtenerCiudadEnvios(27986);
        $total_semana_grafica = $this->graficaTotalEnviosSemana(27986);
*/

        return view('index.view.php',  [
            'card1'=>$total_envios_365,
            'card2'=>$total_consignado,
            'card3'=>$total_fletes,
            'card4'=>$total_envios_5_a_5,
            'card5'=>$transportadora_mas_usadas,
            'card6'=>$Estados_envios_cartera,
            'card7'=>$estado_de_pago_envios,
            'card8'=>$destinos_mas_usados,



            /* Grafica  
            'grafica'=>$envios_semana_a_semana,
            'grafica_total'=>$total_semana_grafica
            */
        ]);
    }
    /*-------- CARD 1       --------- */
    public function obtenerCodigoSucursal($codigo_sucursal) {

        $total_envios_365 = Envios::where('codigo_sucursal', $codigo_sucursal)
            ->where('fecha_envio', '>=', "2023-01-01")
            ->where('fecha_envio', '<=', "2023-12-31")
            ->count();

        return $total_envios_365;
    }
    /*-------- CARD 2       --------- */
    public function obtenerValorComercial($codigo_sucursal){

        $total_consignado = Envios::where('codigo_sucursal', $codigo_sucursal)
            ->where('fecha_envio', '>=', date('Y-m-05'))
            ->where('fecha_envio', '<', date('Y-m-05', strtotime('+1 month')))
            ->sum('valor_comercial');

            return $total_consignado = number_format($total_consignado, 0, ',', '.');
    }
    /*-------- CARD 3       --------- */
    public function obtenerFlete($codigo_sucursal){

        $total_fletes = Envios::where('codigo_sucursal', $codigo_sucursal)
            ->where('fecha_envio', '>=', date('Y-m-05'))
            ->where('fecha_envio', '<', date('Y-m-05', strtotime('+1 month')))
            ->sum('Valor_flete');

            return $total_fletes = number_format($total_fletes, 0, ',', '.');
    
    }
    /*-------- CARD 4       --------- */
    public function obtenerCodigoSucursal2($codigo_sucursal) {

        $year = date('Y'); // Año actual
        $month = date('m'); // Mes actual
        $total_envios_5_a_5 = 0;

        for ($m = $month; $m <= 12; $m++) {
            $start_date = ($m == $month) ? date("$year-$month-05") : date("$year-$m-05");
            $nextMonth = ($m == 12) ? 1 : $m + 1;
            $end_date = ($m == $month) ? date("$year-$nextMonth-05") : date("$year-$nextMonth-05", strtotime("+1 month"));

            $total_envios = Envios::where('codigo_sucursal', $codigo_sucursal)
                ->where('fecha_envio', '>=', $start_date)
                ->where('fecha_envio', '<', $end_date)
                ->count();

                $total_envios_5_a_5 += $total_envios;

        }
        echo "Total acumulado: $total_envios_5_a_5";

        return $total_envios_5_a_5;
    }
    /*-------- CARD 5       --------- */
    public function obtenerTransportadora($codigo_sucursal){

        $transportadora_mas_usadas = Envios::select('transportadora', Envios::raw('COUNT(*) as total_envios'))
            ->where('codigo_sucursal', $codigo_sucursal)
            ->where('fecha_envio', '>=', Envios::raw("DATE_FORMAT(NOW(), '%Y-%m-05')"))
            ->where('fecha_envio', '<', Envios::raw("DATE_ADD(DATE_FORMAT(fecha_envio, '%Y-%m-05'), INTERVAL 1 MONTH)"))
            ->groupBy('transportadora')
            ->orderByDesc('total_envios')
            
            ->get();
    
        return $transportadora_mas_usadas;

}
    /*-------- CARD 6    --------- */
    public function obtenerEstadoEnvio($codigo_sucursal){

        $Estados_envios_cartera = Cartera::select('estado_del_envio', Cartera::raw('COUNT(*) as total_envios'))
            ->where('codigo_sucursal', $codigo_sucursal)
            ->where('fecha_de_consignacion', '>=', Cartera::raw("DATE_FORMAT(NOW(), '%Y-%m-05')"))
            ->where('fecha_de_consignacion', '<', Cartera::raw("DATE_ADD(DATE_FORMAT(fecha_de_consignacion, '%Y-%m-05'), INTERVAL 1 MONTH)"))
            ->groupBy('estado_del_envio')
            ->orderByDesc('total_envios')
           
            ->get();

        return $Estados_envios_cartera; 


    }
     /*-------- CARD 7    --------- */
    public function obtenerEstadoPago($codigo_sucursal){

        $estado_de_pago_envios = Envios::select('estado_de_pago', Envios::raw('COUNT(*) as total_envios'))
            ->where('codigo_sucursal', $codigo_sucursal)
            ->where('fecha_envio', '>=', Envios::raw("DATE_FORMAT(NOW(), '%Y-%m-05')"))
            ->where('fecha_envio', '<', Envios::raw("DATE_ADD(DATE_FORMAT(fecha_envio, '%Y-%m-05'), INTERVAL 1 MONTH)"))
            ->groupBy('estado_de_pago')
            ->orderByDesc('total_envios')
            ->take(3)
            ->get();
        
        return $estado_de_pago_envios;

    }
    /*-------- CARD 8       --------- */
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
        $total_envios_5_a_5 = Envios::where('codigo_sucursal', $codigo_sucursal)
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
        $total_fletes = Envios::where('codigo_sucursal', $codigo_sucursal)
            ->where('fecha_envio', '>=', date('Y-m-05'))
            ->where('fecha_envio', '<', date('Y-m-05', strtotime('+1 month')))
            ->sum('Valor_flete');
        CARD2
        $total_consignado = Envios::where('codigo_sucursal', $codigo_sucursal)
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
            
            'total_consignado' => $total_consignado,
            'total_envios_5_a_5' => $total_envios_5_a_5,
            
            'transportadora_mas_envios' => $transportadora_mas_usada,
            'total_envios_transportadora' => $total_envios_transportadora,
            'total_fletes' => $total_fletes,
            

            
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
    */
} 
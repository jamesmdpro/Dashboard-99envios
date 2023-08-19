<?php

namespace Controllers;

use Models\User as User;
use Models\UsuariosOld as UsuariosOld;




class ModificarConsulta extends Controller
{
    public function showConsultDate(){
    
        $fecha = request()->postData('fecha');

        $total_envios_365 =$this->obtenerCodigoSucursal(27986 , $fecha);
        $total_enviado = $this->obtenerValorComercial(27986, $fecha);
        $total_pagado =$this->obtenerFlete(27986, $fecha);
        $total_fletes =$this->obtenerConsignado(27986, $fecha);
        $estados_envios_cartera  = $this->obtenerEstadoEnvio(27986, $fecha);
        $destinos_mas_usados = $this->obtenerCiudadEnvios(27986, $fecha);
        $estado_de_pago_envios = $this->obtenerEstadoPago(27986, $fecha);
        $transportadora_mas_usada = $this->obtenerTransportadora(27986, $fecha);

        $destinos_mas_usados = $this->obtenerCiudadEnvios(27986, $fecha);

        /* TABLAS ORDENES Y CARTERA   */     
        $ordenes_recientes = $this->obtenerOrdenesRecientes(27986);
        $cartera_recientes = $this->obtenerCarteraCompleta(27986);


        return view('index.view.php',[
            'card1'=>$total_envios_365, 
            'card2'=>$total_enviado,
            'card3'=>$total_pagado,
            'card4'=>$total_fletes,
            'card5'=>$estados_envios_cartera,
            'card6'=>$destinos_mas_usados, 
            'card7'=>$transportadora_mas_usada, 

            'card8'=>$destinos_mas_usados,

            /* TABLAS ORDENES Y CARTERA   */ 
            'card9'=>$ordenes_recientes,  
            'card10'=>$cartera_recientes, 
        ]);
    }

    /*-------- CARD 1       --------- */
    public function obtenerCodigoSucursal($codigo_sucursal, $fecha) {

        $total_envios_365 = Envios::where('codigo_sucursal', $codigo_sucursal)
            ->whereDate('fecha_envio', $fecha)
            ->count();
            
    
        return $total_envios_365;
    }
    /*-------- CARD 2       --------- */
    public function obtenerValorComercial($codigo_sucursal, $fecha){

        $total_enviado = Envios::where('codigo_sucursal', $codigo_sucursal)
            ->whereDate('fecha_envio', $fecha)
            ->sum('valor_comercial');

        return $total_enviado = number_format($total_enviado, 0, ',', '.');

    }
    /*-------- CARD 3       --------- */
    public function obtenerFlete($codigo_sucursal, $fecha){

        $total_pagado = Cartera::where('codigo_sucursal', $codigo_sucursal)
            ->whereDate('fecha_pago', $fecha)
            ->sum('Valor_consignado');

        return $total_pagado = number_format($total_pagado, 0, ',', '.');
    
    }
    /*-------- CARD 4       --------- */
    public function obtenerConsignado($codigo_sucursal, $fecha) {

        $total_fletes = Envios::where('codigo_sucursal', $codigo_sucursal)
            ->whereDate('fecha_pago', $fecha) 
            ->sum('Valor_flete');

        return $total_fletes = number_format($total_fletes, 0, ',', '.');
    }

    /*-------- CARD 5       --------- */
    public function obtenerEstadoEnvio($codigo_sucursal, $fecha) {

        $estados_envios_cartera = Cartera::selectRaw("
            CASE
                WHEN estado_del_envio = 'Entregada' THEN 'Entregado'
                WHEN estado_del_envio = 'Cancelado' THEN 'Cancelado'
                ELSE 'En movimiento'
            END AS estado_transformado,
            COUNT(*) AS total_envios
            ")
        ->where('codigo_sucursal', $codigo_sucursal)
        ->whereDate('fecha_pago', $fecha)
        ->groupBy('estado_transformado')
        ->orderByDesc('total_envios')
        ->get();

        return $estados_envios_cartera;
}
    /*-------- CARD 6       --------- */
    public function obtenerCiudadEnvios($codigo_sucursal, $fecha){

        $destinos_mas_usados = Envios::select('ciudad_destino', Envios::raw('COUNT(*) as total_envios'))
            ->where('codigo_sucursal', $codigo_sucursal)
            ->whereDate('fecha_pago', $fecha)
            ->groupBy('ciudad_destino')
            ->orderByDesc('total_envios')
            ->take(2)
            ->get();
        
        return $destinos_mas_usados;

    }
    /*-------- CARD 7    --------- */
    public function obtenerEstadoPago($codigo_sucursal, $fecha){

        $estado_de_pago_envios = Envios::select('estado_de_pago', Envios::raw('COUNT(*) as total_envios'))
            ->where('codigo_sucursal', $codigo_sucursal)
            ->whereDate('fecha_pago', $fecha)
            ->groupBy('estado_de_pago')
            ->orderByDesc('total_envios')
            ->take(3)
            ->get();
        
        return $estado_de_pago_envios;

    }

    /*---- TRANSPORTADORA    CARD 8--*/

    public function obtenerTransportadora($codigo_sucursal, $fecha){

        $transportadora_mas_usada = Envios::select('transportadora', Envios::raw('COUNT(*) as total_envios'))
            ->where('codigo_sucursal', $codigo_sucursal)
            ->whereDate('fecha_pago', $fecha)
            ->where('fecha_envio', '>=', Envios::raw("DATE_FORMAT(NOW(), '%Y-%m-05')"))
            ->where('fecha_envio', '<', Envios::raw("DATE_ADD(DATE_FORMAT(fecha_envio, '%Y-%m-05'), INTERVAL 1 MONTH)"))
            ->groupBy('transportadora')
            ->orderByDesc('total_envios')
            
            ->get();
    
        return $transportadora_mas_usada;

    }    

    
} 
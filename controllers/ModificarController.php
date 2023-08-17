<?php

namespace Controllers;

use Models\User as User;
use Models\UsuariosOld as UsuariosOld;




class ModificarConsulta extends Controller
{
    public function showConsultaForm()
    {
        return view('consulta/consulta_form.view.php');
    }

    public function modificarConsulta()
    {
        $fechaSeleccionada = request()->postData('fecha');

        // Realizar la modificación de la consulta utilizando la fecha
        // Puedes implementar la lógica para interactuar con la base de datos o cualquier otro recurso

        $resultadoConsulta = "Consulta modificada con fecha: " . $fechaSeleccionada;

        // Devolver el resultado de la consulta modificado
        return view('consulta/consulta_result.view.php', ['resultado' => $resultadoConsulta]);
    }
}
<?php

namespace Controllers;

use Models\User as User;
use Models\UsuariosOld;



class UserController extends Controller
{
   
    public function showRegistrationForm()
    {
        return view('login2/login_register.view.php');
    }

    public function register(){
        
        $nombre_completo = request()->postData('nombre_completo');
        $correo = request()->postData('correo');
        $usuario = request()->postData('usuario');
        $contrasena = request()->postData('contrasena');
        
        $salt = bin2hex(random_bytes(16));

        // Cifrar la contraseña con bcrypt y la sal
        $hashedPassword = password_hash($contrasena, PASSWORD_BCRYPT);

       
        $newUser = new User;
        $newUser -> nombre_completo = $nombre_completo;
        $newUser -> correo = $correo;
        $newUser -> usuario = $usuario;
        $newUser -> contrasena = $hashedPassword;
        $newUser -> salt = $salt;
        $newUser -> save();

        // Guardar el usuario y verificar si se ejecutó correctamente
        $saveResult = $newUser->save();

        if ($saveResult) {
            response()->page(viewsPath('index.view.html', false));
        } else {
            return view('login2/login_register.view.php');
            // Hacer algo aquí en caso de error
    
        }
    }
    public function login() {

        $user_email = request()->get('correo');  // Ajusta 'correo' a 'email' según tu formulario
        $password  = request()->get('contrasena'); // Ajusta 'contrasena' a 'password' según tu formulario
    
        // Llamamos al objeto $auth y utilizamos el método login() para intentar iniciar sesión
        $user = $auth->login([
            'correo' => $user_email,
            'contrasena' =>  $password ,
        ]);
    
        if (!$user) {
            // La autenticación falló, redirigir al formulario de inicio de sesión con mensaje de error
            return view('login2/login_register.view.php');
        } else {
            // La autenticación fue exitosa, redirigir al usuario a la página principal
            response()->page(viewsPath('index.view.html', false));
        }
    }

}

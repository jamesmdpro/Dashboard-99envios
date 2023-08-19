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

        $user_email = request()->postData('user_email');
        $password = request()->postData('user_pass');
        $codigo_sucursal = request()->postData('usuario'); // CODIGO DE SUCURSAL
    
        $user = User::where('correo', $user_email)->first(['contrasena']);
        
        if ($user && password_verify($password , $user->contrasena)) {              
        
            // Autenticación exitosa
          // auth::$session->set('loggedIn', true);
    
            response()->page(viewsPath('index.view.html', false));

        } else {
            // Autenticación fallida
            return view('login2/login_register.view.php');
        }
        
    }               

}

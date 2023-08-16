<?php

namespace Controllers;

use Models\User as User;
use Models\UsuariosOld as UsuariosOld;




class LoginController extends Controller
{
    public function showRegistrationForm2()
    {
        return view('login2/login_register.view.php');
    } 
    // Inicio de sesión
    public function login() {
        $user_email = request()->postData('user_email');
        $password = request()->postData('user_pass');
    
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
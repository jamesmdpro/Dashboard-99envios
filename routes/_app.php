<?php
use Controllers\UserController;

app()->get('/', function () {
    response()->page(viewsPath('login2/login_register.view.php', false)); //'index.view.php'
});
/*
app()->get('/home', 'TestsController@index');

app()->get('/test', 'TestsController@test');
*/

/* VISTA DE LA PAGINA   index 1 VIEW , index 2 PAGE*/
app()->get("/home", 'EnviosController2@index' );

/*    LOGIN REGISTRO USUARIOS */

//Registro nuevo usuarios 

app()->get('/registro',  'UserController@showRegistrationForm');
app()->post('/registro', 'UserController@register');
//app()->post('/registro', 'LoginController@login'); comflicto de de acciones

//Login usuarios 
app()->get('/login',  'LoginController@showRegistrationForm2');
app()->post('/login', 'LoginController@login');





app()->post('/new', function () {
  response()->page(viewsPath('login2/login_register.php', false));
  
});

app()->get('/home1', function () {
  response()->page(viewsPath('index.php', false));
});

/* CONSULATAR 20 REGISTROS JSON */
app()->get("/test1", 'EnviosController@consultarDB' );

/* CONSULATAR 20 REGISTROS WEB */
app()->get("/test2", 'EnviosController@consultarDB' );
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login register 99envios</title>
    <link rel="stylesheet" href="pages/login2/estilos.css">

    <link rel="icon" href="favicon.png" type="images/logo_2.png">
    

</head>
<body>

    <main>
        
        <div class="contenedor__todo">

            <div class="caja__trasera">
                <div class="caja_trasera-login">
                    <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesión para entrar en la página</p>
                    <button id="btn__iniciar-sesion">Iniciar Sesión</button>
                </div>
                <div class="caja_trasera-register">
                    <h3>¿Aún no tienes una cuenta?</h3>
                    <p>Regístrate para que puedas iniciar sesión</p>
                    <button id="btn__registrarse" type="button">Regístrarse</button>
                </div>
            </div>
            <!--  Formulario de login y registro-->
            <div class="contenedor__login-register">
                <form method="POST" class="formulario__login">
                    <h2>Iniciar Sesión</h2>
                    <input type="text" placeholder="Correo Electronico" name="user_email">
                    <input type="number" placeholder="Codigo Sucursal"  name="usuario"><!-- CODIGO SUCURSAL --> 
                    <input type="password" placeholder="Contraseña"     name="user_pass">    
                    <button>Entrar</button>
                </form>
                <!--  Registro-->
                <form  method="POST" class="formulario__register">
                    <h2>Regístrarse</h2>
                    <input type="text" placeholder="Nombre Completo"    name="nombre_completo">
                    <input type="text" placeholder="Correo Electronico" name="correo">
                    <input type="text" placeholder="Codigo sucursal"    name="usuario"> <!-- CODIGO SUCURSAL -->
                    <input type="password" placeholder="Contraseña"     name="contrasena">
                    <button >Regístrarse</button>
                </form>

                
            </div>

        </div>

    </main>
    <script src="pages/login2/script.js"></script>
    
</body>
</html>
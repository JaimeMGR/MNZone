<?php
function formulario_para_iniciar_sesion($pagina_actual, $error)
{

    echo "<div class='login-container'>
                            <form class='login-form' action='iniciar_sesion.php' method='POST'>
                                <label for='username'>Usuario:</label>
                                <input type='text' id='username' name='username'  placeholder='Introduce tu usuario'>
                                <label for='password'>Contraseña:</label>
                                <input type='password' id='password' name='password'  placeholder='Introduce tu contraseña'>
                                <input type='hidden' id='origen' name='origen' value='$pagina_actual'>
                                <a href='registro.php'>¿No tienes cuenta?</a>";
                                if ($error == 1) {
                                    echo "<p class='error' style='background:white; color:red'>Usuario o contraseña erróneos</p>
                                    <button type='submit'>Iniciar sesión</button>";
                                }else{
                                echo "<button type='submit'>Iniciar sesión</button>";
                                }
                                
                            echo"</form>
                            </div>";
}

function formulario_para_iniciar_sesion2($pagina_actual)
{
    if ($error = 1) {
        echo "<div class='login-container'>
                            <form class='login-form' action='iniciar_sesion.php' method='POST'>
                                <label for='username'>Usuario:</label>
                                <input type='text' id='username' name='username'  placeholder='Introduce tu usuario'>
                                <label for='password'>Contraseña:</label>
                                <input type='password' id='password' name='password'  placeholder='Introduce tu contraseña'>
                                <input type='hidden' id='origen' name='origen' value='$pagina_actual'>
                                <p class='error'>Usuario/Contrasña incorrecto</p>
                                <a href='registro.php'>¿No tienes cuenta?</a>
                                <button type='submit'>Iniciar sesión</button>
                            </form>
                            </div>";
    } else {
        echo "<div class='login-container'>
                            <form class='login-form' action='iniciar_sesion.php' method='POST'>
                                <label for='username'>Usuario:</label>
                                <input type='text' id='username' name='username'  placeholder='Introduce tu usuario'>
                                <label for='password'>Contraseña:</label>
                                <input type='password' id='password' name='password'  placeholder='Introduce tu contraseña'>
                                <input type='hidden' id='origen' name='origen' value='$pagina_actual'>
                                <a href='registro.php'>¿No tienes cuenta?</a>
                                <button type='submit'>Iniciar sesión</button>
                            </form>
                            </div>";
    }
}

function formulario_sesion_iniciada($nombre_usuario)
{
    return "<div class='login-container'>
                            <form class='login-form' action='cerrar_sesion.php' method='POST'>
                                 <label  for=>Usuario logueado: $nombre_usuario</label>
                                <button type='submit'>Cerrar sesión</button>
                            </form>
                          </div>";
}
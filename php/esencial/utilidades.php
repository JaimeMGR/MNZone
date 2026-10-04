<?php
function formulario_para_iniciar_sesion($pagina_actual, $error)
{

    echo "<div class='login-container'>
                            <form class='login-form' action='../../iniciar_sesion.php' method='POST'>
                                <label for='username'>Usuario:</label>
                                <input type='text' id='username' name='username'  placeholder='Introduce tu usuario'>
                                <label for='password'>Contraseña:</label>
                                <input type='password' id='password' name='password'  placeholder='Introduce tu contraseña'>
                                <input type='hidden' id='origen' name='origen' value='$pagina_actual'>
                                <a href='registro.php'>¿No tienes cuenta?</a>";
    if ($error == 1) {
        echo "<p class='error' style='background:white; color:red'>Usuario o contraseña erróneos</p>
              <button style='border-radius:5%'type='submit'>Iniciar sesión</button>";
    } else if ($error == 2) {
        echo "<p class='error' style='background:white; color:red'>Falta usuario o contraseña</p>
            <button style='border-radius:5%' type='submit'>Iniciar sesión</button>";
    } else {
        echo "<button type='submit'>Iniciar sesión</button>";
    }

    echo "</form>
                            </div>";
}

function formulario_para_iniciar_sesion2($pagina_actual, $error)
{
    if ($error = 1) {
        echo "<div class='login-container'>
                            <form class='login-form' action='../../iniciar_sesion.php' method='POST'>
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
    } else if ($error = 2) {
        echo "<div class='login-container'>
                            <form class='login-form' action='../../iniciar_sesion.php' method='POST'>
                                <label for='username'>Usuario:</label>
                                <input type='text' id='username' name='username'  placeholder='Introduce tu usuario'>
                                <label for='password'>Contraseña:</label>
                                <input type='password' id='password' name='password'  placeholder='Introduce tu contraseña'>
                                <input type='hidden' id='origen' name='origen' value='$pagina_actual'>
                                <p class='error'>Falta usuario o contraseña</p>
                                <a href='registro.php'>¿No tienes cuenta?</a>
                                <button type='submit'>Iniciar sesión</button>
                            </form>
                            </div>";
    } else {
        echo "<div class='login-container'>
                            <form class='login-form' action='../../iniciar_sesion.php' method='POST'>
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
    return "<div class='login-container login-container--logged'>
                            <form class='login-form login-form--logged' action='../../cerrar_sesion.php' method='POST'>
                                <div class='logged-user'>
                                  <span class='logged-user__label'>Usuario</span>
                                  <strong class='logged-user__name'>" . htmlspecialchars($nombre_usuario, ENT_QUOTES, 'UTF-8') . "</strong>
                                </div>
                                <button type='submit' class='logged-user__logout'>Cerrar sesión</button>
                            </form>
                          </div>";
}

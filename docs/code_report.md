# Reporte de codigo
Este documento es un sumario de todos los errores y malas practicas
encontradas en la base de codigo **system**. Ademas en este documento
se incluiran recomendaciones y notas sobre las pruebas agregadas.

<br>

version: **v0.2**

<br>

## Resultados
- `30/06/2024 - 11:00` Se realizaron las pruebas de penetracion con nikto:
    - **Componentes:** Todo el sistema
    - **Resultados:** El sistema es vulnerable a ataques de secuestro
    de session y cross-site-scripting (XSS)

- `30/06/2024 - 11:00` Se realizaron las pruebas de injeccion SQL con SQLMAP:
    - **Componentes:** Todo el sistema
    - **Resultados:** SQLMAP no encontro vulnerabilidades 

- `30/06/2024 - 12:00` Se realizaron las pruebas automaticas de integracion:
    - **Componentes:** Agregar-Eliminar-Editar un producto, login.
    - **Resultados:** `Tests: 10, Assertions: 6, Errors: 5, Failures: 7`. La mayoria de
    pruebas pruebas fallaron resultado de erroes de diseño de formularios
    en el html.

<br>
<br>

## Diseño
1. Codigo desorganizado.
2. HTML y PHP mas mesclado de lo necesario.
3. Durante las pruebas de integracion se detecto un
   mal uso de formularios y botones dentro del HTML en multiples paginas.

### Sumario
1. **Desorganización del Código:**
    - **Problema:** El código actual está desorganizado, lo cual dificulta su
    mantenimiento y comprensión. 

    - **Recomendación:** Se recomienda refactorizar y
    estructurar el código de manera más ordenada y modular.

2. **Mezcla Excesiva de HTML y PHP:**
    - **Problema:** Existe una integración excesiva de código HTML y
    PHP, lo cual dificulta la separación de la lógica de presentación
    y la lógica de negocio.

    - **Recomendación:** Se sugiere utilizar un patrón de diseño
    MVC (Modelo-Vista-Controlador) u otras prácticas que promuevan una
    separación clara de responsabilidades.

3. **Mal Uso de Formularios y Botones:**
    - **Problema:** Se observa un uso ineficiente de formularios y botones en múltiples
    páginas, lo que puede afectar la usabilidad y la experiencia
    del usuario.

    - **Recomendación:** Se aconseja revisar y mejorar la implementación
    de formularios y botones para asegurar una navegación coherente
    y eficiente.

<br>
<br>

## Codigo
1. Mal uso de  `start_session()` este esta siendo utilizado dentro del
constructor de la clase `Login` sin embargo no se esta chequeando si
una session ya existe lo que a la larga provocara errores. Ademas se
detecto el uso de `start_session()` al inicio del codigo de cada pagina
lo cual es malo ya que `start_session()` se deberia llamar solo una vez
al comenzar una session no multiples veces.
```php
    // Uso Actual
    public function __construct() {
        session_start();
        // ...
    }

    // Uso Correcto
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // ...
    }
```

2. Algunas clases como `Login` no tienen las dependencias dentro del
mismo archivo. Actualmente las dependencias de la clase `Login` estan
siendo importadas dentro de `login.php` esto funciona pero a medida de
que la base de codigo cresca probablemente sera un desastre, por lo que
se recomienda usar `composer` y `namespaces` o directamente `require`
o `require_once`.

3. El codigo actualmente esta muy desorganizado lo que dificulta la
implementacion de pruebas, sobre todo pruebas de integracion.

<br>
<br>

## Seguridad

### SQL INJECTION
Se testeo con `sqlmap` y no se encontraron vulnerabilidades.

### Nikto
Se testeo la pagina con [Nikto](https://github.com/sullo/nikto) y se detectaron 3 problemas de seguridad.
```
+ /: Retrieved x-powered-by header: PHP/5.6.25.
+ /: The anti-clickjacking X-Frame-Options header is not present. See: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Frame-Options
+ /: The X-Content-Type-Options header is not set. This could allow the user agent to render the content of the site in a different fashion to the MIME type. See: https://www.netsparker.com/web-vulnerability-scanner/vulnerabilities/missing-content-type-header/
+ Root page / redirects to: stock.php
+ /login.php: Cookie PHPSESSID created without the httponly flag. See: https://developer.mozilla.org/en-US/docs/Web/HTTP/Cookies
+ /login.php: Admin login page/section found.
```

### Otros
1. El sistema es vulnerable a ataques de secuestro de session. Esto devido
a que despues de reautenticar al usario el id de session no se regenera.

### Sumario
1. PHP Version Disclosure:
    - **Error:** `Retrieved x-powered-by header: PHP/5.6.25.`
    - **Recomendación:** Ocultar la versión de PHP en las cabeceras HTTP.

    - **Solución:**
    ```php
    // Añadir en el archivo php.ini
    expose_php = Off

    // O en el archivo `.htaccess`
    Header unset X-Powered-By
    ```

2. Falta de Cabecera X-Frame-Options:
    - **Error:** `The anti-clickjacking X-Frame-Options header is not present.`
    - **Recomendación:** Agregar la cabecera `X-Frame-Options`.

    - **Solución:**
    ```php
    // php
    header('X-Frame-Options: SAMEORIGIN');

    // O en el archivo `.htaccess`
    Header always append X-Frame-Options SAMEORIGIN
    ```

3. Falta de Cabecera X-Content-Type-Options:
    - **Error:** `The X-Content-Type-Options header is not set.`
    - **Recomendación:** Agregar la cabecera `X-Content-Type-Options`.

    - **Solución:**
    ```php
    // php
    header('X-Content-Type-Options: nosniff');

    // O en el archivo `.htaccess`
    Header set X-Content-Type-Options nosniff
    ```

4. Redirección de Página Raíz:
    - **Error:** `Root page / redirects to: stock.php`
    - **Recomendación:** Validar que la redirección es necesaria y segura.

5. Cookie PHPSESSID sin Flag HttpOnly:
    - **Error:** `Cookie PHPSESSID created without the httponly flag.`
    - **Recomendación:** Establecer la flag `HttpOnly` en las cookies.

    - **Solución:**
    ```php
    session_set_cookie_params(['httponly' => true]);
    session_start();
    ```

6. Pagina de Inicio de Sesión de Administrador:
    - **Error:** `Admin login page/section found.`
    - **Recomendación:** Proteger la página de inicio de sesión de administrador.

    - **Solución:**
        - Implementar autenticación multifactor (MFA).
        - Usar mecanismos de bloqueo después de varios intentos fallidos.
        - Asegurarse de que las contraseñas se almacenan de manera segura.

7. Mitigación de Ataques de Secuestro de Sesiones:
    - **Recomendación:** Se debería usar `session_regenerate_id(true)`
    para mitigar ataques de fijación de sesiones creando un nuevo
    identificador de sesión después de la autenticación del usuario.

    - **Solución:**
    ```php
    // Después de autenticar al usuario
    session_regenerate_id(true);
    ```

<br>
<br>

## Pruebas Manuales
Esto es un registro de todas las pruebas manuales que se han ido realizando en el sistema.

- `29/06/2024 - 17:00` se realizo una prueba en la pagina '/producto?id=' y se detecto un problema.
    - Problema: Al editar un producto y presionar guardar los cambios, ocurre una redireccion
    a la pagina principal esto sin importar si la edicion fue exitosa o no.

    - Pasos a seguir para reproducir:
        1. Logear y presionar cualquier producto en el inventario
        2. Presionar el boton de editar
        3. Editar cualquier campo (con valores incorrectos o correctos)
        4. Presionar el boton para guardar cambios

<br>
<br>

## Pruebas Automaticas
Esto es un registro de todas las pruebas automaticas que se han ido integrando al sistema.

- `25/06/2024 - 03:00` se agrego composer y [Codeception](https://codeception.com/) para escribir las pruebas.
- `27/05/2024 - 11:00` se realizaron pruebas de penetracion con [SQLmap](https://sqlmap.org/)
- `27/05/2024 - 12:00` se realizaron pruebas de penetracion con [Nikto](https://github.com/sullo/nikto)

- `27/06/2024 - 21:00` se agregaron pruebas para los siguientes componentes:
    - login: tanto uni test como integration test
    - agregar un producto: solo integration test
    - eliminar un producto: solo integration test

- `28/06/2024 - 17:00` se agregaron pruebas para los siguientes componentes:
    - agregar un producto: se agregaron mas test cases
    - editar un producto: se agregaron pruebas de integracion

<br>
<br>

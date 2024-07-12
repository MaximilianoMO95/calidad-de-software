## 1. Descripción del Caso Transversal: Sistema de Inventario de Productos

**1. Introducción**

El sistema de inventario de productos de la empresa **System** está diseñado para gestionar productos, usuarios, y las operaciones relacionadas con el inventario. La funcionalidad clave incluye la capacidad para agregar, modificar, eliminar y buscar productos, así como gestionar el stock y el historial de productos. Este caso transversal se enfoca en evaluar el sistema desde una perspectiva integral, cubriendo aspectos de funcionalidad, seguridad, rendimiento, y diseño.

**2. Requisitos del Sistema**

- **Gestión de Productos:**
  - **Agregar Productos:** Permitir la adición de nuevos productos con detalles como nombre, código, categoría, y precio.
  - **Modificar Productos:** Facilitar la edición de detalles de productos existentes.
  - **Eliminar Productos:** Permitir la eliminación de productos del inventario.
  - **Buscar Productos:** Habilitar la búsqueda de productos por nombre o código.

- **Gestión de Usuarios:**
  - **Autenticación:** Los usuarios deben autenticarse correctamente para acceder a ciertas funcionalidades.
  - **Roles y Permisos:** Diferentes tipos de usuarios (administradores, administrativos, clientes) deben tener permisos adecuados según su rol.

- **Seguridad:**
  - **Protección contra ataques comunes:** El sistema debe estar protegido contra ataques de SQL Injection, Cross-Site Scripting (XSS), y secuestro de sesión.

- **Rendimiento:**
  - **Capacidad de Manejo de Carga:** El sistema debe ser capaz de manejar múltiples usuarios simultáneamente sin degradación significativa del rendimiento.

- **Diseño y Usabilidad:**
  - **Interfaz de Usuario:** La interfaz debe ser clara y libre de errores ortográficos, proporcionando una experiencia de usuario intuitiva.

**3. Problemas Identificados en el Sistema**

**A. Resultados del Reporte de Código**

1. **Errores y Advertencias:**
   - Se encontraron 2,913 errores y 255 advertencias en el código según las pruebas con `phpcs`, indicando que el código no sigue los estándares de PHP.

2. **Vulnerabilidades de Seguridad:**
   - **Nikto:** Se detectaron vulnerabilidades de secuestro de sesión y XSS. Ejemplos incluyen la falta de cabeceras de seguridad (`X-Frame-Options`, `X-Content-Type-Options`) y cookies sin el flag `HttpOnly`.
   - **SQL Injection:** No se encontraron vulnerabilidades según las pruebas con `SQLMAP`.

3. **Pruebas Automáticas de Integración:**
   - La mayoría de las pruebas fallaron debido a errores en el diseño de formularios y la mezcla de HTML con PHP, afectando la funcionalidad de agregar, eliminar y editar productos.

4. **Problemas de Usabilidad:**
   - **Edición de Productos:** La página redirige incorrectamente a `stock.php` después de intentar editar un producto, sin importar si la operación fue exitosa o no.
   - **Ortografía:** Se encontraron múltiples errores ortográficos en varias páginas del sistema.

5. **Problemas de Seguridad con Contraseñas:**
   - **Almacenamiento de Contraseñas:** Las contraseñas de los usuarios se almacenan en texto plano en lugar de ser encriptadas, lo que compromete la seguridad del sistema.

**4. Recomendaciones y Acciones Correctivas**

**A. Código y Diseño:**
- **Refactorización del Código:** Reorganizar y modularizar el código para mejorar la mantenibilidad y seguir los estándares de codificación.
- **Separación de HTML y PHP:** Implementar el patrón de diseño MVC para separar la lógica de presentación de la lógica de negocio.

**B. Seguridad:**
- **Cabeceras de Seguridad:** Agregar las cabeceras `X-Frame-Options` y `X-Content-Type-Options`, y configurar el flag `HttpOnly` en las cookies.
- **Encriptación de Contraseñas:** Utilizar hashing para almacenar contraseñas de manera segura.

**C. Usabilidad y Rendimiento:**
- **Corrección de Errores de Usabilidad:** Revisar y corregir la lógica de redirección en la edición de productos y solucionar errores ortográficos en las páginas.
- **Mejora de Rendimiento:** Evaluar y optimizar el sistema para manejar múltiples usuarios simultáneamente.

**D. Pruebas:**
- **Pruebas de Integración:** Corregir los errores de diseño en formularios y pruebas para asegurar que todas las funcionalidades trabajen como se espera.
- **Pruebas Manuales y Automáticas:** Continuar realizando pruebas exhaustivas para identificar y corregir problemas adicionales.

<br>
<br>

---

## 2. Etapa de Planificación

### 1. **Carta Gantt**

| Actividad                           | Duración  | Inicio       | Fin          |
|-------------------------------------|-----------|--------------|--------------|
| Preparación del Entorno de Pruebas  | 2 días    | 01/08/2024   | 02/08/2024   |
| Configuración de Herramientas       | 1 día     | 03/08/2024   | 03/08/2024   |
| Pruebas de Integración y Unitarias  | 3 días    | 04/08/2024   | 06/08/2024   |
| Pruebas de Rendimiento              | 2 días    | 07/08/2024   | 08/08/2024   |
| Pruebas de Seguridad                | 2 días    | 09/08/2024   | 10/08/2024   |
| Chequeo de Estándares PHP           | 1 día     | 11/08/2024   | 11/08/2024   |
| Análisis de Resultados y Reporte    | 3 días    | 12/08/2024   | 14/08/2024   |

### 2. **Estrategia de Pruebas**

- **Pruebas Unitarias y de Integración:** Se utilizará Codeception para realizar pruebas unitarias y de integración, garantizando que las unidades individuales del código funcionen correctamente y que las integraciones entre componentes sean válidas.
  
- **Pruebas de Rendimiento:** JMeter será utilizado para medir el rendimiento del sistema bajo condiciones de carga, asegurando que la aplicación pueda manejar el tráfico esperado sin degradar su rendimiento.
  
- **Pruebas de Seguridad:** SQLMAP se empleará para realizar pruebas de inyección SQL, Nikto para evaluaciones generales de seguridad, y se utilizarán prácticas estándar para identificar vulnerabilidades y brechas de seguridad en el sistema.
  
- **Chequeo de Estándares PHP:** PHPCS se utilizará para verificar que el código fuente cumpla con los estándares de codificación de PHP definidos, garantizando que el código sea legible y mantenible.

### 3. **Criterios de Prueba**

- **Inicio de Pruebas:** Las pruebas comenzarán una vez que el entorno de pruebas esté completamente configurado y las herramientas estén instaladas y configuradas.
  
- **Aceptación de Pruebas:** Las pruebas serán aceptadas si los resultados cumplen con los criterios de éxito definidos en cada caso de prueba, y no se identifican defectos críticos.
  
- **Rechazo de Pruebas:** Las pruebas serán rechazadas si se encuentran defectos críticos o errores que impidan el funcionamiento correcto del sistema según las especificaciones.
  
- **Suspensión de Pruebas:** Las pruebas se suspenderán si se encuentran problemas graves que impidan la continuación de las pruebas, tales como fallos en el entorno de pruebas o fallos críticos en el sistema.

### 4. **Entorno de Ejecución de las Pruebas**

- **Lenguaje y Tecnologías:** PHP y tecnologías relacionadas.
- **Herramientas de Pruebas:**
  - **Codeception:** Para pruebas unitarias e integración.
  - **JMeter:** Para pruebas de rendimiento.
  - **PHPCS:** Para chequeo de estándares PHP.
  - **SQLMAP:** Para pruebas de seguridad de inyección SQL.
  - **Nikto:** Para pruebas de seguridad generales.
- **Recursos Necesarios:** Servidores de prueba, bases de datos, herramientas de prueba instaladas y configuradas, y acceso a los entornos de desarrollo y producción.

### 5. **Riesgos Asociados al Proceso de Pruebas**

- **Riesgos Potenciales:**
  - **Fallos en el Entorno de Pruebas:** Problemas con la configuración del entorno o la falta de recursos adecuados.
  - **Defectos Críticos:** Encontrar errores graves que bloqueen el progreso de las pruebas.
  - **Incompatibilidad de Herramientas:** Problemas con la integración o configuración de herramientas de prueba.

### 6. **Plan de Respuesta a los Riesgos**

- **Preparación del Entorno de Pruebas:** Asegurar una configuración correcta del entorno y recursos de prueba antes de iniciar las pruebas. Tener un plan de contingencia para la configuración fallida.
  
- **Manejo de Defectos Críticos:** Establecer un proceso claro para la identificación, documentación y resolución de defectos críticos. Reuniones regulares para revisar el progreso y ajustar las pruebas si es necesario.
  
- **Compatibilidad de Herramientas:** Verificar la compatibilidad y realizar pruebas previas para asegurar que las herramientas funcionen correctamente en el entorno de prueba. Tener un equipo de soporte disponible para resolver problemas técnicos.

---

<br>
<br>

---

## 3. Etapa de Diseño

### 1. **Casos de Prueba**

#### **1.1. Agregar un Nuevo Producto**

**Caso de Prueba 1.1.1: Agregar un producto con datos válidos**

- **Precondiciones:** El usuario está autenticado y tiene permisos adecuados.
- **Entradas:**
  - Categoría: "Herramientas"
  - Código: "M01"
  - Nombre: "Martillo"
  - Precio: 500
- **Pasos:**
  1. Navegar a la página de agregar producto.
  2. Introducir los datos válidos en los campos correspondientes.
  3. Hacer clic en "Guardar".
- **Resultados Esperados:**
  - El producto se agrega exitosamente.
  - Aparece un mensaje de confirmación: "Producto agregado exitosamente."
  - El producto "Martillo" es visible en la lista de inventario.

**Caso de Prueba 1.1.2: Agregar un producto sin categoría**

- **Precondiciones:** El usuario está autenticado y tiene permisos adecuados.
- **Entradas:**
  - Categoría: ""
  - Código: "D01"
  - Nombre: "Destornillador"
  - Precio: 100
- **Pasos:**
  1. Navegar a la página de agregar producto.
  2. Introducir los datos sin categoría.
  3. Hacer clic en "Guardar".
- **Resultados Esperados:**
  - Aparece un mensaje de error: "La categoría es obligatoria."
  - El producto no se agrega a la lista.

**Caso de Prueba 1.1.3: Agregar un producto con código duplicado**

- **Precondiciones:** El usuario está autenticado, y el producto con código "M01" ya existe.
- **Entradas:**
  - Categoría: "Herramientas"
  - Código: "M01"
  - Nombre: "Martillo Pequeño"
  - Precio: 200
- **Pasos:**
  1. Navegar a la página de agregar producto.
  2. Introducir los datos con código duplicado.
  3. Hacer clic en "Guardar".
- **Resultados Esperados:**
  - Aparece un mensaje de error: "El código ya existe."
  - El producto no se agrega.

**Caso de Prueba 1.1.4: Agregar un producto con precio no numérico**

- **Precondiciones:** El usuario está autenticado y tiene permisos adecuados.
- **Entradas:**
  - Categoría: "Herramientas"
  - Código: "S01"
  - Nombre: "Sierra"
  - Precio: "abc"
- **Pasos:**
  1. Navegar a la página de agregar producto.
  2. Introducir los datos con un precio no numérico.
  3. Hacer clic en "Guardar".
- **Resultados Esperados:**
  - Aparece un mensaje de error: "El precio debe ser un número entero."
  - El producto no se agrega.

#### **1.2. Modificar un Producto Existente**

**Caso de Prueba 1.2.1: Modificar el nombre de un producto**

- **Precondiciones:** El usuario está autenticado, y el producto "Martillo" existe.
- **Entradas:**
  - Nombre nuevo: "Martillo de Garra"
- **Pasos:**
  1. Navegar a la página de edición del producto "Martillo".
  2. Cambiar el nombre a "Martillo de Garra".
  3. Hacer clic en "Guardar".
- **Resultados Esperados:**
  - El nombre del producto se actualiza a "Martillo de Garra".
  - Aparece un mensaje de confirmación: "Producto actualizado exitosamente."

**Caso de Prueba 1.2.2: Modificar el código a uno que ya existe**

- **Precondiciones:** El usuario está autenticado, y los productos "Martillo" (código: M01) y "Destornillador" (código: D01) existen.
- **Entradas:**
  - Código nuevo: "D01"
- **Pasos:**
  1. Navegar a la página de edición del producto "Martillo".
  2. Cambiar el código a "D01".
  3. Hacer clic en "Guardar".
- **Resultados Esperados:**
  - Aparece un mensaje de error: "El código ya existe."
  - El código del producto no se modifica.

#### **1.3. Eliminar un Producto**

**Caso de Prueba 1.3.1: Eliminar un producto existente**

- **Precondiciones:** El usuario está autenticado, y el producto "Martillo" existe.
- **Entradas:** Ninguna.
- **Pasos:**
  1. Navegar a la lista de productos.
  2. Seleccionar el producto "Martillo".
  3. Hacer clic en "Eliminar".
  4. Confirmar la eliminación.
- **Resultados Esperados:**
  - El producto "Martillo" se elimina de la lista.
  - Aparece un mensaje de confirmación: "Producto eliminado exitosamente."

#### **1.4. Buscar un Producto**

**Caso de Prueba 1.4.1: Buscar un producto por nombre**

- **Precondiciones:** El usuario está autenticado y el producto "Martillo" existe.
- **Entradas:**
  - Nombre de producto: "Martillo"
- **Pasos:**
  1. Navegar a la página de búsqueda de productos.
  2. Introducir el nombre "Martillo".
  3. Hacer clic en "Buscar".
- **Resultados Esperados:**
  - El producto "Martillo" aparece en los resultados de búsqueda.

#### **1.5. Gestión de Stock**

**Caso de Prueba 1.5.1: Agregar stock a un producto**

- **Precondiciones:** El usuario está autenticado y el producto "Martillo" existe.
- **Entradas:**
  - Cantidad de stock a agregar: 10
- **Pasos:**
  1. Navegar a la página de gestión de stock del producto "Martillo".
  2. Introducir la cantidad de stock a agregar.
  3. Hacer clic en "Agregar stock".
- **Resultados Esperados:**
  - El stock del producto "Martillo" se incrementa en 10 unidades.
  - Aparece un mensaje de confirmación: "Stock agregado exitosamente."

**Caso de Prueba 1.5.2: Eliminar stock de un producto**

- **Precondiciones:** El usuario está autenticado y el producto "Martillo" existe con un stock de al menos 10 unidades.
- **Entradas:**
  - Cantidad de stock a eliminar: 5
- **Pasos:**
  1. Navegar a la página de gestión de stock del producto "Martillo".
  2. Introducir la cantidad de stock a eliminar.
  3. Hacer clic en "Eliminar stock".
- **Resultados Esperados:**
  - El stock del producto "Martillo" se reduce en 5 unidades.
  - Aparece un mensaje de confirmación: "Stock eliminado exitosamente."

#### **1.6. Generación de Historial de Inventario**

**Caso de Prueba 1.6.1: Generar historial de un producto**

- **Precondiciones:** El usuario está autenticado y el producto "Martillo" existe.
- **Entradas:** Ninguna.
- **Pasos:**
  1. Navegar a la página de historial del producto "Martillo".
  2. Hacer clic en "Generar historial".
- **Resultados Esperados:**
  - Se muestra el historial completo de inventario del producto "Martillo".

#### **1.7. Validaciones de Categorías, Códigos y Nombres**

**Caso de Prueba 1.7.1: Validar que la categoría es obligatoria**

- **Precondiciones:** El usuario está autenticado.
- **Entradas:**
  - Categoría: ""
  - Código: "S01"
  - Nombre: "Sierra"
  - Precio: 300
- **Pasos:**
  1. Navegar a la página de agregar producto.
  2. Introducir los datos sin categoría.
  3. Hacer clic en "Guardar".
- **Resultados Esperados:**
  - Aparece un mensaje de error: "La categoría es obligatoria."
  - El producto no se agrega.

**Caso de Prueba 1.7.2: Validar formato de código**

- **Precondiciones:** El usuario está autenticado.
- **Entradas:**
  - Categoría: "Accesorios"
  - Código: "123"
  - Nombre: "Cámara"
  - Precio: 400
- **Pasos:**
  1. Navegar a la página de agregar producto.
  2. Introducir un código que no sigue el formato especificado.
  3. Hacer clic en "Guardar".
- **Resultados Esperados:**
  - Aparece un mensaje de error: "El código debe comenzar con la inicial del producto seguida de un número correlativo."
  - El producto no se agrega.

**Caso de Prueba**

 **1.7.3: Validar formato de precio**

- **Precondiciones:** El usuario está autenticado.
- **Entradas:**
  - Categoría: "Electrónica"
  - Código: "E01"
  - Nombre: "Auricular"
  - Precio: "cuatrocientos"
- **Pasos:**
  1. Navegar a la página de agregar producto.
  2. Introducir un precio en formato no numérico.
  3. Hacer clic en "Guardar".
- **Resultados Esperados:**
  - Aparece un mensaje de error: "El precio debe ser un número."
  - El producto no se agrega.

---

<br>
<br>

## 4. Etapa de Ejecución

En esta etapa, se han llevado a cabo diversas pruebas según el plan
descrito anteriormente. A continuación se documenta el
estado de las pruebas, los hallazgos identificados, su origen y posibles
soluciones:

### Pruebas Realizadas y Hallazgos

1. **Pruebas con PHPCS (20/06/2024 - 10:00)**
   - **Componentes:** Todo el sistema.
   - **Resultados:** Se encontraron **2.913** errores y **255** advertencias, indicando que el código no sigue los estándares de PHP.
   - **Evidencias:** Resumen en `docs/phpcs`.
   - **Posibles Soluciones:** Refactorizar el código para cumplir con los estándares de PHP. Implementar un proceso de revisión de código para mantener la calidad.

2. **Pruebas de Penetración con Nikto (30/06/2024 - 11:00)**
   - **Componentes:** Todo el sistema.
   - **Resultados:** El sistema es vulnerable a ataques de secuestro de sesión y XSS.
   - **Evidencias:**
     ```
     + /: Retrieved x-powered-by header: PHP/5.6.25.
     + /: The anti-clickjacking X-Frame-Options header is not present.
     + /: The X-Content-Type-Options header is not set.
     + Root page / redirects to: stock.php
     + /login.php: Cookie PHPSESSID created without the httponly flag.
     + /login.php: Admin login page/section found.
     ```
   - **Posibles Soluciones:** Implementar las cabeceras de seguridad recomendadas, ocultar la versión de PHP y proteger el área de administración.

3. **Pruebas de Inyección SQL con SQLMAP (30/06/2024 - 11:00)**
   - **Componentes:** Todo el sistema.
   - **Resultados:** SQLMAP no encontró vulnerabilidades.
   - **Evidencias:** Log en `docs/sqlmap`.
   - **Posibles Soluciones:** Continuar con el monitoreo regular de vulnerabilidades y actualizar las prácticas de seguridad conforme sea necesario.

4. **Pruebas Automáticas de Integración (30/06/2024 - 12:00)**
   - **Componentes:** Agregar-Eliminar-Editar un producto, login.
   - **Resultados:** `Tests: 10, Assertions: 6, Errors: 5, Failures: 7`. La mayoría de las pruebas fallaron debido a errores de diseño de formularios en el HTML.
   - **Evidencias:**
     ```
     Codeception Results
     Successful: 3. Failed: 10.
     ```
   - **Posibles Soluciones:** Revisar y corregir los errores de diseño de formularios. Mejorar la validación de formularios y pruebas.

5. **Prueba Manual de Edición de Producto (29/06/2024 - 17:00)**
   - **Componentes:** Editar un producto.
   - **Resultados:** La página siempre redirige a `stock.php` incluso cuando un campo es inválido.
   - **Evidencias:** 
     ```php
     // producto.php
     // 199 ...
     // 200 $( "#editar_producto" ).submit(function( event ) {
       // Redirige siempre a stock.php
     })
     ```
   - **Posibles Soluciones:** Ajustar la lógica de redirección para manejar adecuadamente los errores de validación.

6. **Prueba Manual de Ortografía (02/07/2024 - 17:00)**
   - **Componentes:** Páginas PHP.
   - **Resultados:** Se encontraron múltiples errores de ortografía.
   - **Evidencias:** 
     ```php
     // paginas con errores de ortografía
     // navbar.php
     // ajax/buscar_categorias.php
     // usuarios.php
     ```
   - **Posibles Soluciones:** Corregir los errores de ortografía en el contenido del sistema para mejorar la presentación y profesionalismo.

7. **Prueba Manual de Creación de Usuario (02/07/2024 - 17:30)**
   - **Componentes:** Página de usuarios.
   - **Resultados:** La contraseña se almacena en texto plano, lo que provoca errores de autenticación.
   - **Evidencias:** 
     ```php
     // usuarios.php
     // ajax/nuevo_usuario.php
     // Contraseña no está siendo encriptada.
     // login.php
     // El hash de la contraseña no coincide debido a la falta de encriptación.
     ```
   - **Posibles Soluciones:** Implementar un sistema de encriptación para contraseñas al crear nuevos usuarios. Asegurar que todas las contraseñas se almacenan de forma segura.

### Herramienta de Seguimiento de Defectos
Se utilizo [git-bug](https://github.com/MichaelMure/git-bug) para realizar un seguimiento de defectos, esto 
dado a que es facil de instalar y se integra muy bien con la command-line y git. (cuenta tanto con webui como termui)

<br>
<br>

---

# 5. Informe: Resultados de las Pruebas y Recomendaciones

## 1. Introducción

Este reporte resume el estado final de las pruebas realizadas en el sistema **System**, las observaciones obtenidas, y las acciones correctivas necesarias. Se ha utilizado la herramienta de seguimiento de defectos `git-bug` para registrar y gestionar los problemas detectados durante las pruebas.

## 2. Estado Final de las Pruebas

### 2.1. Pruebas de Código y Estilo

- **Herramienta Utilizada:** `phpcs`
- **Resultado:** Se encontraron 2.913 errores y 255 advertencias en el código, indicando una falta general de adherencia a los estándares de codificación PHP.
- **Evidencia:** Sumario de errores y advertencias disponible en `docs/phpcs`.

### 2.2. Pruebas de Seguridad

- **Herramienta Utilizada:** `Nikto`
- **Resultado:** Se identificaron vulnerabilidades relacionadas con el secuestro de sesión y XSS. La versión de PHP y la falta de ciertas cabeceras de seguridad también fueron problemas encontrados.
- **Evidencia:** Reporte Nikto con detalles de vulnerabilidades.

- **Herramienta Utilizada:** `SQLMAP`
- **Resultado:** No se encontraron vulnerabilidades de inyección SQL.
- **Evidencia:** Log de SQLMAP disponible en `docs/sqlmap`.

### 2.3. Pruebas Automáticas de Integración

- **Herramienta Utilizada:** `Codeception`
- **Resultado:** De 10 pruebas, 6 afirmaciones fueron exitosas, pero se reportaron 5 errores y 7 fallos debido a problemas de diseño de formularios en HTML.
- **Evidencia:** Resultados detallados en el reporte de Codeception.

### 2.4. Pruebas Manuales

- **Problema Detectado:** Redirección incorrecta en la página de edición de productos y almacenamiento de contraseñas en texto plano.
- **Evidencia:** Observaciones y detalles en la sección de pruebas manuales.

### 2.5. Pruebas de Ortografía

- **Resultado:** Se identificaron múltiples errores de ortografía en diversas páginas del sistema.
- **Evidencia:** Detalles disponibles en la sección de pruebas manuales.

## 3. Análisis de Resultados

### 3.1. Aspectos Positivos

- **Pruebas de Inyección SQL:** No se encontraron vulnerabilidades, lo que indica un manejo adecuado de las consultas a la base de datos.
- **Integración Continua:** Se ha implementado un marco de pruebas robusto con Codeception, aunque con algunos problemas en los casos de prueba.
- **Seguridad en Autenticación:** Aunque se detectaron problemas, el sistema ya implementa ciertas medidas de seguridad.

### 3.2. Áreas de Mejora

- **Desorganización del Código:** La estructura del código es desorganizada, lo que dificulta su mantenimiento y escalabilidad.
- **Mezcla HTML y PHP:** La integración de HTML y PHP es excesiva, lo que complica la separación de responsabilidades y afecta la mantenibilidad.
- **Problemas de Seguridad:** La falta de cabeceras de seguridad y la exposición de la versión de PHP son riesgos importantes.
- **Errores de Diseño de Formularios:** Los formularios y botones en el sistema presentan errores que afectan la funcionalidad y la experiencia del usuario.
- **Ortografía y Redirección:** Los errores ortográficos y los problemas de redirección afectan la calidad y usabilidad del sistema.

## 4. Propuestas de Mejora y Acciones Correctivas

### 4.1. Refactorización del Código

- **Acción Correctiva:** Refactorizar el código para mejorar la organización y modularidad. Implementar un patrón de diseño MVC para separar la lógica de negocio y presentación.
- **Prioridad:** Alta.

### 4.2. Mejora en Seguridad

- **Acción Correctiva:** Implementar las recomendaciones de seguridad identificadas en el reporte de Nikto, incluyendo la adición de cabeceras de seguridad y la ocultación de la versión de PHP.
- **Prioridad:** Alta.

### 4.3. Corrección de Errores de Diseño

- **Acción Correctiva:** Revisar y corregir el uso de formularios y botones, y asegurar que los códigos de respuesta HTTP sean adecuados. Implementar validaciones y manejo adecuado de errores.
- **Prioridad:** Media.

### 4.4. Corrección de Errores de Ortografía

- **Acción Correctiva:** Realizar una revisión exhaustiva de ortografía en todas las páginas del sistema y corregir los errores encontrados.
- **Prioridad:** Baja.

### 4.5. Mejoras Continuas

- **Acción Correctiva:** Implementar un proceso de revisión de código regular y establecer una política de pruebas más rigurosa para prevenir futuros problemas. Capacitar al equipo en mejores prácticas de codificación y seguridad.
- **Prioridad:** Media.

## 5. Medidas de Retroalimentación

- **Acción Correctiva:** Establecer un canal de retroalimentación para el equipo de desarrollo y pruebas. Programar reuniones periódicas para revisar el progreso de las acciones correctivas y adaptar las estrategias según sea necesario.
- **Prioridad:** Media.

## 6. Conclusiones

El sistema **System** presenta áreas significativas de mejora en términos de organización del código, seguridad y diseño de formularios. Las pruebas realizadas han sido exhaustivas, pero se han identificado varias áreas críticas que requieren atención inmediata para garantizar la calidad y seguridad del sistema. Las acciones correctivas y mejoras propuestas deben ser implementadas con prioridad para abordar las deficiencias y mejorar la funcionalidad y seguridad del sistema.

---

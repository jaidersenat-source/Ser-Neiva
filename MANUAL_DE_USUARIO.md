# 📘 Manual de Usuario — SER (Sistema Estratégico Religioso de Neiva)

**Versión:** 1.0  
**Fecha:** Marzo 2026  
**Plataforma:** Sistema de gestión y visualización georreferenciada para las entidades religiosas de Neiva, Huila.

---

## Tabla de Contenido

1. [Acceso al Sistema](#1-acceso-al-sistema)
2. [Dashboard (Panel Principal)](#2-dashboard-panel-principal)
3. [Módulo de Iglesias](#3-módulo-de-iglesias)
4. [Importación Masiva de Iglesias](#4-importación-masiva-de-iglesias)
5. [Exportación de Iglesias (PDF y Excel)](#5-exportación-de-iglesias-pdf-y-excel)
6. [Módulo de Fundaciones](#6-módulo-de-fundaciones)
7. [Módulo de Eventos](#7-módulo-de-eventos)
8. [Módulo de Escenarios Deportivos](#8-módulo-de-escenarios-deportivos)
9. [Módulo de Campañas de Correo](#9-módulo-de-campañas-de-correo)
10. [Mapa Público (Georreferenciación)](#10-mapa-público-georreferenciación)
11. [Perfil de Usuario](#11-perfil-de-usuario)

---

## 1. Acceso al Sistema

### 1.1 Iniciar Sesión

1. Abra su navegador y vaya a la dirección del sistema.
2. En la pantalla de inicio de sesión, ingrese su **correo electrónico** y **contraseña**.
3. Haga clic en **"Iniciar Sesión"**.
4. Si olvidó su contraseña, haga clic en **"¿Olvidaste tu contraseña?"** y siga las instrucciones que recibirá por correo.

### 1.2 Registro de Cuenta

1. En la pantalla de inicio, haga clic en **"Registrarse"**.
2. Complete los campos: nombre, correo electrónico y contraseña.
3. Se le enviará un correo de verificación. Haga clic en el enlace del correo para activar su cuenta.

### 1.3 Roles de Usuario

- **Administrador:** Acceso total a todas las funciones del sistema.
- **Editor Huila:** Puede crear, editar y eliminar iglesias fuera del municipio de Neiva.
- **Usuario verificado:** Puede visualizar toda la información del sistema.

---

## 2. Dashboard (Panel Principal)

Al iniciar sesión, será dirigido al **Dashboard** o panel principal. Aquí encontrará un resumen ejecutivo del sistema.

### ¿Qué encontrará?

- **Banner de bienvenida:** Muestra su nombre, la fecha actual y un acceso rápido para registrar una nueva iglesia.
- **Tarjetas de estadísticas:**
  - Total de iglesias registradas
  - Iglesias activas
  - Iglesias inactivas
  - Número de denominaciones distintas
- **Panel de Feligreses/Asistentes:**
  - Total estimado de feligreses
  - Promedio por iglesia
  - Clasificación por tamaño (pequeña, mediana, grande)
  - Top 5 iglesias por número de asistentes
- **Registros recientes:** Las últimas 5 iglesias registradas con enlace directo.
- **Gráfico por denominación:** Distribución visual de las 6 denominaciones más frecuentes.
- **Mini-calendario:** Muestra los cumpleaños de pastores/líderes y los próximos eventos registrados.

### Navegación lateral

El menú lateral (sidebar) le permite acceder a cada módulo:

| Sección | Opciones |
|---------|----------|
| Principal | Dashboard |
| Gestión | Iglesias, Fundaciones, Eventos, Escenarios Deportivos |
| Comunicaciones | Campañas de Correo |
| Accesos | Mapa Público |

---

## 3. Módulo de Iglesias

Este es el módulo principal del sistema. Permite gestionar toda la información de las entidades religiosas registradas.

**Ruta:** Menú lateral → **Iglesias**

### 3.1 Ver Listado de Iglesias

Al acceder al módulo verá:
- Una barra superior con estadísticas: total de iglesias e iglesias activas.
- Un **filtro por municipio** (cuadro desplegable) para filtrar la tabla.
- Una tabla paginada (15 registros por página) con columnas: Nombre, Denominación, Dirección, Municipio, Estado y Acciones.

**Acciones en la tabla:**
- **Ver** (icono ojo): Abre el detalle completo de la iglesia.
- **Editar** (icono lápiz): Abre el formulario de edición.
- **Eliminar** (icono papelera): Elimina la iglesia (requiere confirmación).

### 3.2 Crear una Nueva Iglesia

1. En el listado, haga clic en **"Registrar Iglesia"** (botón en la esquina superior derecha).
2. Complete el formulario que se divide en las siguientes secciones:

#### Sección 1 — Información de la Iglesia
- **Nombre oficial** (obligatorio): Nombre completo de la entidad.
- **Denominación** (obligatorio): Seleccione de la lista (Cristiano, Católico, Pentecostal, Adventista, etc.).
- **Carácter confesional:** Tipo de confesión religiosa.
- **Estado** (obligatorio): Activo, Inactivo o Suspendido.
- **Fecha de fundación:** Fecha en que se fundó la iglesia.
- **Ubicación específica:** Información adicional (ej: "Comuna 5").
- **Miembros aproximados:** Número estimado de asistentes.

#### Sección 2 — Ubicación
- **Dirección** (obligatorio): Dirección completa.
- **Barrio, Municipio, Comuna, Ciudad, Departamento, País.**
- **Latitud y Longitud** (obligatorios): Coordenadas para la ubicación en el mapa. Se pueden obtener desde Google Maps haciendo clic derecho en la ubicación.

#### Sección 3 — Contacto
- Teléfono fijo, celular, correo electrónico, sitio web o redes sociales.

#### Sección 4 — Pastor Principal
- Nombre completo, tipo y número de documento, fecha de nacimiento, tipo de periodo de liderazgo, teléfono y correo del pastor.

#### Sección 5 — Líder de Mujeres
- Nombre, teléfono y correo de la líder del ministerio de mujeres.

#### Sección 6 — Datos Jurídicos
- Tipo de registro legal, número de personería jurídica, entidad que otorga, resolución, expediente, tipo de personería y observaciones.

#### Sección 7 — Programas y Ministerios
- Ministerios que ofrece la iglesia (selección múltiple).

#### Sección 8 — Horarios
- Horarios entre semana y fines de semana.

#### Foto
- Puede subir una foto representativa de la iglesia.

#### Ayudas/Servicios
- Seleccione las ayudas que ofrece la iglesia (asistencia alimentaria, atención espiritual, etc.).

3. Haga clic en **"Guardar"** para registrar la iglesia.

### 3.3 Ver Detalle de una Iglesia

1. En el listado, haga clic en **"Ver"** (icono ojo).
2. Verá toda la información organizada por secciones, incluyendo:
   - Foto de la iglesia
   - Datos generales, ubicación, contacto
   - Información del pastor y líder de mujeres
   - Datos jurídicos
   - Ayudas que ofrece la iglesia

### 3.4 Editar una Iglesia

1. En el listado, haga clic en el **icono de lápiz** o desde el detalle haga clic en **"Editar"**.
2. Modifique los campos necesarios.
3. Haga clic en **"Actualizar"**.

### 3.5 Eliminar una Iglesia

1. En el listado, haga clic en el **icono de papelera**.
2. Confirme la eliminación en el diálogo que aparece.
3. La iglesia y su foto serán eliminadas permanentemente.

> **Nota:** Solo los administradores pueden eliminar iglesias de Neiva. Los editores Huila solo pueden eliminar iglesias de otros municipios.

---

## 4. Importación Masiva de Iglesias

Permite cargar múltiples iglesias desde un archivo Excel (.xlsx).

**Ruta:** Menú lateral → **Iglesias** → Sub-menú **Importar**

### Pasos:

1. Haga clic en **"Importar"** en el sub-menú de Iglesias.
2. **Descargue la plantilla:** Haga clic en **"Descargar Plantilla"** para obtener el archivo Excel con el formato correcto.
3. **Complete la plantilla:**
   - Los datos se llenan a partir de la **fila 5** (la fila 4 contiene los encabezados).
   - Los campos obligatorios son: nombre oficial, denominación, dirección, latitud, longitud.
   - Respéte los formatos de fechas y coordenadas.
4. **Suba el archivo:** Seleccione el archivo Excel completado (máximo 20 MB).
5. Haga clic en **"Importar"**.
6. El sistema procesará el archivo y mostrará:
   - Número de registros creados exitosamente.
   - Registros omitidos (duplicados).
   - Errores encontrados con detalle por fila.

---

## 5. Exportación de Iglesias (PDF y Excel)

Permite descargar el listado de iglesias en formato PDF o Excel.

**Ruta:** Desde el listado de Iglesias, busque los botones **"Exportar PDF"** y **"Exportar Excel"**.

### Filtros disponibles para exportación:

Puede filtrar antes de exportar usando los parámetros:
- **Estado:** Activo / Inactivo
- **Denominación:** Filtrar por tipo de iglesia
- **Comuna:** Filtrar por comuna
- **Ayuda:** Filtrar iglesias que ofrecen un tipo específico de ayuda

### PDF
- Se genera un documento en formato paisaje (A4) con diseño institucional.
- Nombre del archivo: `SIRN_Iglesias_[fecha]_[hora].pdf`

### Excel
- Se genera un archivo .xlsx con 49 columnas y encabezados formateados.
- Nombre del archivo: `SIRN_Iglesias_[fecha]_[hora].xlsx`

---

## 6. Módulo de Fundaciones

Gestiona las fundaciones sin ánimo de lucro relacionadas con el sector religioso y social de Neiva.

**Ruta:** Menú lateral → **Fundaciones**

### 6.1 Ver Listado

- Tabla paginada (15 registros) con el total de fundaciones.
- Columnas: Nombre, NIT, Representante, Teléfono, Email, Dirección.

### 6.2 Crear una Fundación

1. Haga clic en **"Nueva Fundación"**.
2. Complete el formulario:
   - **Nombre** (obligatorio)
   - **NIT** de la fundación
   - **Representante legal**
   - **Documento** del representante
   - **Teléfono**
   - **Correo electrónico**
   - **Dirección**
   - **Latitud y Longitud** (para ubicación en el mapa)
3. Haga clic en **"Guardar"**.

### 6.3 Editar una Fundación

1. En el listado, haga clic en **"Editar"**.
2. Modifique los campos necesarios.
3. Guarde los cambios.

### 6.4 Eliminar una Fundación

1. Haga clic en el botón **"Eliminar"** y confirme la acción.

---

## 7. Módulo de Eventos

Permite gestionar eventos religiosos asociados a las iglesias registradas.

**Ruta:** Menú lateral → **Eventos**

### 7.1 Ver Listado de Eventos

- Tabla paginada (20 registros) mostrando: Título, Iglesia, Tipo, Fecha Inicio, Fecha Fin, Dirección.
- Cada evento está vinculado a una iglesia.

### 7.2 Vista de Calendario

1. En el sub-menú de Eventos, haga clic en **"Calendario"**.
2. Verá un calendario interactivo donde los eventos se muestran según sus fechas.
3. Puede navegar por meses y hacer clic en un evento para ver su detalle.

### 7.3 Crear un Evento

1. Haga clic en **"Nuevo Evento"**.
2. Complete el formulario:
   - **Iglesia** (obligatorio): Seleccione la iglesia organizadora.
   - **Título** (obligatorio): Nombre del evento.
   - **Descripción:** Detalle del evento.
   - **Fecha de inicio** (obligatorio) y **Fecha de fin.**
   - **Dirección del evento** (obligatorio).
   - **Latitud y Longitud** (obligatorios): Ubicación georreferenciada.
   - **Tipo de evento** (obligatorio): Retiro, Conferencia, Culto, Campamento u Otro.
   - **Estado** (obligatorio).
3. Haga clic en **"Guardar"**.

### 7.4 Ver Detalle de un Evento

- Haga clic en el evento para ver toda la información, incluyendo la iglesia asociada y la ubicación en el mapa.

### 7.5 Editar / Eliminar

- Use los botones correspondientes para editar o eliminar un evento.

---

## 8. Módulo de Escenarios Deportivos

Gestiona los escenarios deportivos que pueden estar disponibles para uso de las iglesias.

**Ruta:** Menú lateral → **Escenarios Deportivos**

### 8.1 Ver Listado

- Tabla paginada (15 registros) con: Nombre, Dirección, Contacto, Disponibilidad.

### 8.2 Crear un Escenario

1. Haga clic en **"Nuevo Escenario"**.
2. Complete:
   - **Nombre** (obligatorio)
   - **Dirección** (obligatoria)
   - **Latitud y Longitud** (obligatorios)
   - **Contacto**
   - **¿Disponible para iglesias?** (Sí / No)
3. Guarde.

### 8.3 Editar / Eliminar

- Use los botones de la tabla para editar o eliminar un escenario.

---

## 9. Módulo de Campañas de Correo

Permite enviar correos electrónicos masivos a las iglesias registradas en el sistema. Los correos incluyen contenido personalizado, imágenes incrustadas y el nombre del pastor/representante de cada iglesia.

**Ruta:** Menú lateral → **Campañas de Correo**

### 9.1 Ver Listado de Campañas

Verá una tabla con todas las campañas creadas:
- **#**: Número identificador
- **Asunto**: Tema del correo
- **Filtro**: A quién va dirigida (Todas, Ciudad específica, o Selección manual)
- **Destinatarios**: Cantidad de iglesias que recibirán el correo
- **Estado**: Borrador (pendiente) o Enviada
- **Fecha**: Fecha de creación

Haga clic en **"Ver"** para abrir la vista previa de cada campaña.

### 9.2 Crear una Nueva Campaña

1. Haga clic en **"Nueva Campaña"**.
2. El formulario tiene tres secciones:

#### Sección 1 — Contenido del Correo
- **Asunto** (obligatorio): El tema del correo.
- **Mensaje**: Editor de texto enriquecido (WYSIWYG) con herramientas de formato:
  - **Negrita** (B), **Cursiva** (I), **Subrayado** (U)
  - Listas ordenadas y no ordenadas
  - Insertar enlaces
  - Insertar imágenes desde URL
  - Cambiar tamaño de fuente
  - El editor sincroniza automáticamente con el campo oculto del formulario.

#### Sección 2 — Imágenes Adjuntas
- Puede adjuntar hasta **5 imágenes** que se enviarán incrustadas en el correo.
- Arrastre y suelte las imágenes o haga clic para seleccionarlas.
- Se mostrará una vista previa de cada imagen seleccionada.
- Formatos aceptados: JPG, PNG, GIF, WebP (máximo 5 MB cada una).

#### Sección 3 — Selección de Destinatarios
Elija a quién enviar el correo:
- **Todas las iglesias**: Se envía a todas las iglesias que tengan correo electrónico registrado.
- **Por ciudad/municipio**: Seleccione una ciudad para enviar solo a las iglesias de esa ubicación.
- **Selección manual**: Marque individualmente las iglesias destinatarias.

3. Haga clic en **"Crear Campaña"**.

### 9.3 Vista Previa de una Campaña

Antes de enviar, puede revisar exactamente cómo se verá el correo:

- **Columna izquierda**: Vista previa simulada del correo (header, cuerpo, imágenes, footer).
- **Columna derecha**: Información de la campaña:
  - Detalles (asunto, filtro, imágenes, fechas)
  - Lista completa de destinatarios con su correo
  - Una marca verde (✓) aparece junto a los destinatarios que ya recibieron el correo.

### 9.4 Enviar una Campaña

1. Desde la vista previa, haga clic en **"Enviar Campaña Ahora"** o en **"Enviar Campaña"** (botón del héader).
2. Aparecerá un **modal de confirmación** preguntando si desea enviar a los X destinatarios.
3. Haga clic en **"Sí, enviar ahora"** para confirmar, o **"Cancelar"** para volver.
4. El envío se procesa **en segundo plano** (cola). No necesita esperar en la página.
5. Los correos se envían uno por uno con una pausa entre cada envío.
6. Al terminar, la campaña cambia a estado **"Enviada"**.

> **Importante:** Una vez enviada, la campaña no se puede volver a enviar ni editar.

### 9.5 Eliminar una Campaña

- Solo se pueden eliminar campañas en estado **Borrador**.
- Desde la vista previa, haga clic en **"Eliminar Campaña"** y confirme en el modal.
- Se eliminará la campaña, sus imágenes y la lista de destinatarios.

### 9.6 ¿Cómo se personaliza el correo?

Cada iglesia recibe un correo personalizado con:
- **Saludo**: "Hola [Nombre del pastor/representante]"
- El sistema busca el nombre en este orden de prioridad:
  1. Nombre completo del pastor
  2. Pastor/Sacerdote (campo legado)
  3. Nombre oficial de la iglesia
  4. Nombre corto de la iglesia

### 9.7 ¿Qué correo se usa para enviar?

El sistema busca el correo de la iglesia en este orden:
1. Correo del pastor (`pastor_email`)
2. Correo institucional (`correo_institucional`)
3. Correo general (`email`)

---

## 10. Mapa Público (Georreferenciación)

El mapa público es una herramienta de visualización interactiva que muestra la ubicación de todas las entidades registradas en el sistema. **No requiere iniciar sesión.**

**Ruta:** Menú lateral → **Mapa Público** (se abre en nueva pestaña) o directamente en la URL `/mapa`.

### 10.1 Modos de Visualización

En la parte superior del mapa hay un selector con 4 opciones:

| Modo | ¿Qué muestra? |
|------|---------------|
| **Iglesias** | Todas las iglesias activas con marcadores en el mapa |
| **Eventos** | Eventos activos con sus ubicaciones |
| **Escenarios** | Escenarios deportivos registrados |
| **Fundaciones** | Fundaciones registradas con coordenadas |

Haga clic en cada opción para cambiar entre los modos.

### 10.2 Panel Lateral (Sidebar)

A la izquierda del mapa (o como drawer en móvil) encontrará:

- **Estadísticas:** Total de iglesias, denominaciones, elementos visibles.
- **Buscador:** Escriba para buscar por nombre en tiempo real.
- **Filtros por denominación:** Botones tipo chip para filtrar por tipo de iglesia.
- **Filtro por municipio:** Selector desplegable de municipios.
- **Lista de resultados:** Resultados que coinciden con los filtros aplicados. Haga clic en uno para centrar el mapa en esa ubicación.
- **Contador de resultados:** Muestra cuántos elementos son visibles en el mapa.

### 10.3 Interacción con el Mapa

- **Zoom:** Use la rueda del ratón o los botones +/- del mapa.
- **Mover:** Haga clic y arrastre para desplazarse.
- **Marcadores:** Haga clic en un marcador para ver un popup con información básica de la entidad.
- **Botón recentrar:** Devuelve la vista al centro de Neiva.

### 10.4 Responsivo

- En **escritorio:** El panel lateral está fijo a la izquierda.
- En **móvil/tablet:** El panel lateral se abre como un drawer deslizable desde la izquierda.

---

## 11. Perfil de Usuario

Permite gestionar su información personal.

**Ruta:** Haga clic en su nombre en el menú lateral → **Perfil**

### 11.1 Editar Datos Personales

1. Acceda a su perfil.
2. Puede modificar su **nombre** y **correo electrónico**.
3. Si cambia su correo, deberá verificarlo nuevamente.
4. Haga clic en **"Guardar"**.

### 11.2 Cambiar Contraseña

1. En la sección de contraseña, ingrese su contraseña actual.
2. Ingrese la nueva contraseña y confírmela.
3. Guarde los cambios.

### 11.3 Eliminar Cuenta

1. En la sección de eliminación, ingrese su contraseña.
2. Confirme la eliminación.
3. Su cuenta será eliminada permanentemente.

> **Advertencia:** Esta acción es irreversible.

---

## Preguntas Frecuentes

### ¿Cómo obtengo las coordenadas (latitud y longitud) de una ubicación?

1. Abra [Google Maps](https://maps.google.com).
2. Busque la dirección o ubíquela manualmente en el mapa.
3. Haga **clic derecho** sobre el punto exacto.
4. En el menú que aparece, verá las coordenadas (ej: `2.9344, -75.2891`).
5. Haga clic en las coordenadas para copiarlas.
6. Pegue la latitud y la longitud en los campos correspondientes del formulario.

### ¿Qué formato de Excel necesito para importar iglesias?

Descargue la plantilla oficial desde el módulo de importación. Los datos se llenan desde la fila 5 (la fila 4 son los encabezados). El archivo debe ser formato `.xlsx`.

### ¿Puedo enviar una campaña más de una vez?

No. Una vez que la campaña se marca como "Enviada", no se puede reenviar. Puede crear una nueva campaña con el mismo contenido.

### ¿Los correos se envían inmediatamente?

Los correos se procesan en segundo plano (cola). Se envían uno por uno con una pausa de medio segundo entre cada envío para respetar los límites del servidor de correo. No necesita esperar en la página.

### ¿Quién puede ver el mapa público?

Cualquier persona con acceso a la URL del mapa puede verlo. No requiere cuenta ni autenticación.

---

*Manual elaborado para el Sistema Estratégico Religioso de Neiva (SER) — Municipio de Neiva, Huila, Colombia.*

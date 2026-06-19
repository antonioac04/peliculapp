# PeliculApp

Práctica de Puesta en Producción Segura desarrollada con Laravel y JWT.

## Tecnologías utilizadas

- Laravel
- PHP 8.4
- JWT Authentication
- SQLite
- GitHub Actions
- Docker

## Gestión de autenticación con JWT

Para esta práctica se ha implementado autenticación mediante JWT (JSON Web Token) con el objetivo de proteger las rutas de la API y permitir el acceso únicamente a usuarios autenticados.

El tiempo de expiración del token se ha configurado en 60 minutos, por lo que cada token generado tiene una validez de una hora.

### Obtención del token

Para obtener un token es necesario iniciar sesión con un usuario registrado.

```bash
curl -X POST http://127.0.0.1:8000/api/auth/login \
-H "Content-Type: application/json" \
-H "Accept: application/json" \
-d '{"email":"antonio@test.com","password":"12345678"}'
```

Si las credenciales son correctas, la aplicación devuelve una respuesta similar a la siguiente:

```json
{
    "access_token": "TOKEN_JWT",
    "token_type": "bearer",
    "expires_in": 3600
}
```

### Uso del token en rutas protegidas

Una vez obtenido el token, este debe enviarse en la cabecera Authorization utilizando el esquema Bearer.

Ejemplo de consulta al listado de directores:

```bash
curl http://127.0.0.1:8000/api/directors \
-H "Authorization: Bearer TOKEN_JWT" \
-H "Accept: application/json"
```

Durante las pruebas realizadas se comprobó que las rutas protegidas responden con un error de autenticación cuando no se envía un token válido.

### Refresco del token

Para generar un nuevo token antes de que expire el actual se utiliza el endpoint de refresco:

```bash
curl -X POST http://127.0.0.1:8000/api/auth/refresh \
-H "Authorization: Bearer TOKEN_JWT" \
-H "Accept: application/json"
```

La respuesta devuelve un nuevo token válido que sustituye al anterior.

### Cierre de sesión

Para invalidar el token y finalizar la sesión del usuario se utiliza el endpoint de logout:

```bash
curl -X POST http://127.0.0.1:8000/api/auth/logout \
-H "Authorization: Bearer TOKEN_JWT" \
-H "Accept: application/json"
```

Después de realizar el logout, el token deja de ser válido. Esta situación se verificó realizando nuevas peticiones a rutas protegidas, obteniendo una respuesta de acceso no autorizado.

### Pruebas realizadas

Durante el desarrollo de la práctica se verificó correctamente el funcionamiento de los siguientes procesos:

- Generación de token mediante login.
- Acceso a rutas protegidas utilizando JWT.
- Denegación de acceso sin token o con token inválido.
- Refresco del token mediante el endpoint correspondiente.
- Invalidación del token después del logout.
- Protección de las rutas de directores mediante el middleware `auth:api`.

Todas las pruebas realizadas obtuvieron los resultados esperados.

## Dev Container

Se ha añadido un entorno de desarrollo reproducible mediante Dev Containers.

El archivo de configuración se encuentra en:

```text
.devcontainer/devcontainer.json

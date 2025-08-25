## Cashflow MVP (PHP 8 + MySQL + Docker)

Aplicación mínima para digitalizar el flujo de caja con 3 cuentas bancarias, priorización de pagos y reportes por proyecto.

### Requisitos
- Docker Desktop, Docker Compose v2
- MySQL Workbench (opcional)

### Variables de entorno
Copia `.env.example` a `.env` y ajusta si es necesario. Si no ves `.env.example`, crea un archivo `.env` con el contenido del bloque de ejemplo más abajo.

### Levantamiento
1) Construir e iniciar:
```
docker compose up -d --build
```
2) Instalar dependencias dentro del contenedor (si fuese necesario):
```
docker compose exec app composer install --no-interaction
```
3) La app quedará en `http://localhost:8080`.
4) MySQL expuesto en el puerto `3307` (configurable vía `EXTERNAL_MYSQL_PORT`).
5) Conectar MySQL Workbench: Host `127.0.0.1`, Port `3307`, User `cashflow`, Pass `cashflow`, DB `cashflow`.
6) API de ejemplo:
```
curl http://localhost:8080/api/movements
curl http://localhost:8080/api/reports/project-balance
```

### Estructura de carpetas
```
├─ .docker/
│  ├─ entrypoint.sh
│  └─ vhost.conf
├─ docker/
│  └─ mysql/
│     └─ init/
│        ├─ schema.sql
│        └─ seed.sql
├─ app/
│  ├─ Core/ (Router, Controller, Database, etc.)
│  ├─ Controllers/
│  ├─ Models/
│  ├─ Services/
│  └─ Views/
├─ public/
│  ├─ .htaccess
│  └─ index.php
├─ routes.php
├─ composer.json
├─ Dockerfile
├─ docker-compose.yml
└─ README.md
```

### Modelo de datos (resumen)
- projects, cost_centers, bank_accounts, cash_movements, adjustments, audit_logs, users

### Priorización (heurística MVP)
- Ordena egresos pendientes por: fecha de vencimiento ASC, `priority_score` DESC, monto ASC.

### Notas
- Puedes administrar datos con MySQL Workbench o desde la interfaz web.

### Ejemplo de `.env`
```
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8080
MYSQL_HOST=db
MYSQL_DATABASE=cashflow
MYSQL_USER=cashflow
MYSQL_PASSWORD=cashflow
MYSQL_PORT=3306
EXTERNAL_MYSQL_PORT=3307
```

### Checklist de verificación manual (10)
1. La web carga en `http://localhost:8080`.
2. Se listan saldos por cuenta.
3. `GET /api/movements` retorna JSON.
4. `GET /api/reports/project-balance` retorna JSON.
5. `POST /api/movements` crea un movimiento.
6. Vista de proyectos lista 2 proyectos iniciales.
7. Vista de priorización ordena por fecha/score.
8. MySQL Workbench conecta al puerto expuesto.
9. Seed crea 3 cuentas bancarias.

### Casos de prueba (5)
1. Crear ingreso de 1,000,000 en cuenta 1 y verificar incremento de saldo en inicio.
2. Crear egreso con `due_date` hoy y `priority_score=100`, verificar aparece primero en priorización.
3. Importar `FLUJO...xlsx` y confirmar que importe > 0 en reporte del importador.
4. Consultar saldo por proyecto después de varios movimientos asociados.
5. Crear ajuste sobre un movimiento y verificar integridad referencial.



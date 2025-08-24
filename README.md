# todo_api-backend – API dokumentáció

Ez a dokumentáció a mellékelt Postman Collection alapján készült. Minden végpontnál szerepel a HTTP metódus, az útvonal, a szükséges headerek, példa kérés (body), valamint egy minta cURL parancs.

**Alap URL:** `http://localhost:8000`

## Hitelesítés
A védett végpontok Bearer Token alapú hitelesítést várnak az `Authorization: Bearer <token>` headerrel.

## Végpontok

### POST `/api/login`
_Gyűjteményben megnevezés: **login**_

**Headerek:**
- `Accept: application/json`
- `Content-Type: application/json`

**Példa kérés törzs (JSON):**
```json
{"email":"mozso@example.com","password":"Jelszo_2025"}
```
**cURL példa:**
```bash
curl -X POST "http://localhost:8000/api/login" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d "{\"email\":\"mozso@example.com\",\"password\":\"Jelszo_2025\"}"
```
**Példa válasz (Response):**
```json
{
    "access_token": "4|zJKkj2LUAYnZcnEOY9ZrQp9pAUxSxmK7GEUEp85K98edc960",
    "token_type": "Bearer"
}
```
---

### POST `/api/logout`
_Gyűjteményben megnevezés: **logout**_

**Headerek:**
- `Accept: application/json`
- `Content-Type: application/json`
- `Authorization: Bearer 4|zJKkj2LUAYnZcnEOY9ZrQp9pAUxSxmK7GEUEp85K98edc960`

**cURL példa:**
```bash
curl -X POST "http://localhost:8000/api/logout" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer 4|zJKkj2LUAYnZcnEOY9ZrQp9pAUxSxmK7GEUEp85K98edc960"
```
**Példa válasz (Response):**
```json
{
    "message": "Sikeres kijelentkezés"
}
```
---

### GET `/api/ping`
_Gyűjteményben megnevezés: **ping**_

**cURL példa:**
```bash
curl -X GET "http://localhost:8000/api/ping"
```
**Példa válasz (Response):**
```json
{
  "message": "API működik"
}
```
---

### POST `/api/register`
_Gyűjteményben megnevezés: **register**_

**Headerek:**
- `Content-Type: application/json`
- `Accept: application/json`

**Példa kérés törzs (JSON):**
```json
{"name":"mozso","email":"mozso@example.com","password":"Jelszo_2025", "password_confirmation": "Jelszo_2025"}
```
**cURL példa:**
```bash
curl -X POST "http://localhost:8000/api/register" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d "{\"name\":\"mozso\",\"email\":\"mozso@example.com\",\"password\":\"Jelszo_2025\", \"password_confirmation\": \"Jelszo_2025\"}"
```
**Példa válasz (Response):**
```json
{
    "user": {
        "name": "mozso",
        "email": "mozso@example.com",
        "updated_at": "2025-08-23T20:53:02.000000Z",
        "created_at": "2025-08-23T20:53:02.000000Z",
        "id": 3
    },
    "message": "Sikeres regisztráció"
}
```
---

### GET `/api/todos`

**Headerek:**
- `Accept: application/json`
- `Content-Type: application/json`
- `Authorization: Bearer 4|zJKkj2LUAYnZcnEOY9ZrQp9pAUxSxmK7GEUEp85K98edc960`

**cURL példa:**
```bash
curl -X GET "http://localhost:8000/api/todos" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer 4|zJKkj2LUAYnZcnEOY9ZrQp9pAUxSxmK7GEUEp85K98edc960"
```
**Példa válasz (Response):**
```json
[
    {
        "id": 6,
        "user_id": 3,
        "title": "cica",
        "description": "Enni adni neki",
        "completed": true,
        "created_at": "2025-08-23T21:02:26.000000Z",
        "updated_at": "2025-08-23T21:03:55.000000Z"
    },
    {
        "id": 7,
        "user_id": 3,
        "title": "kanári",
        "description": "Inni adni neki",
        "completed": false,
        "created_at": "2025-08-23T21:07:22.000000Z",
        "updated_at": "2025-08-23T21:07:22.000000Z"
    }
]
```
---

### POST `/api/todos`

**Headerek:**
- `Accept: application/json`
- `Content-Type: application/json`
- `Authorization: Bearer 4|zJKkj2LUAYnZcnEOY9ZrQp9pAUxSxmK7GEUEp85K98edc960`

**Példa kérés törzs (JSON):**
```json
{"title":"cica","description":"Enni adni neki"}
```
**cURL példa:**
```bash
curl -X POST "http://localhost:8000/api/todos" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer 4|zJKkj2LUAYnZcnEOY9ZrQp9pAUxSxmK7GEUEp85K98edc960" \
  -d "{\"title\":\"cica\",\"description\":\"Enni adni neki\"}"
```
**Példa válasz (Response):**
```json
{
    "title": "cica",
    "description": "Enni adni neki",
    "user_id": 3,
    "updated_at": "2025-08-23T21:02:26.000000Z",
    "created_at": "2025-08-23T21:02:26.000000Z",
    "id": 6
}
```
---

### DELETE `/api/todos/{id}`

**Headerek:**
- `Accept: application/json`
- `Content-Type: application/json`
- `Authorization: Bearer 4|zJKkj2LUAYnZcnEOY9ZrQp9pAUxSxmK7GEUEp85K98edc960`

**cURL példa:**
```bash
curl -X DELETE "http://localhost:8000/api/todos/7" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer 4|zJKkj2LUAYnZcnEOY9ZrQp9pAUxSxmK7GEUEp85K98edc960"
```
**Példa válasz (Response):**
```json
{
    "message": "A(z) 7 azonosítójú rekord törölve."
}
```
---

### GET `/api/todos/{id}`

**Headerek:**
- `Accept: application/json`
- `Content-Type: application/json`
- `Authorization: Bearer 4|zJKkj2LUAYnZcnEOY9ZrQp9pAUxSxmK7GEUEp85K98edc960`

**cURL példa:**
```bash
curl -X GET "http://localhost:8000/api/todos/6" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer 4|zJKkj2LUAYnZcnEOY9ZrQp9pAUxSxmK7GEUEp85K98edc960"
```
**Példa válasz (Response):**
```json
{
    "id": 6,
    "user_id": 3,
    "title": "cica",
    "description": "Enni adni neki",
    "completed": true,
    "created_at": "2025-08-23T21:02:26.000000Z",
    "updated_at": "2025-08-23T21:03:55.000000Z"
}
```
---

### PUT `/api/todos/{id}`

**Headerek:**
- `Accept: application/json`
- `Content-Type: application/json`
- `Authorization: Bearer 4|zJKkj2LUAYnZcnEOY9ZrQp9pAUxSxmK7GEUEp85K98edc960`

**Példa kérés törzs (JSON):**
```json
{"completed":true}
```
**cURL példa:**
```bash
curl -X PUT "http://localhost:8000/api/todos/6" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer 4|zJKkj2LUAYnZcnEOY9ZrQp9pAUxSxmK7GEUEp85K98edc960" \
  -d "{\"completed\":true}"
```
**Példa válasz (Response):**
```json
{
    "id": 6,
    "user_id": 3,
    "title": "cica",
    "description": "Enni adni neki",
    "completed": true,
    "created_at": "2025-08-23T21:02:26.000000Z",
    "updated_at": "2025-08-23T21:03:55.000000Z"
}
```
---

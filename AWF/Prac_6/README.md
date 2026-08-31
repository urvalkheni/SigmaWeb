# Practical 6 — Task Management Application

A full-stack Task Management Application built with **React**, **Node.js**, **Express.js**, **MongoDB**, and **Mongoose**, with **CORS** configured for frontend-backend communication.

---

## Project Description

This project integrates a React frontend with a Node.js/Express backend and a MongoDB database to create a complete full-stack Task Management Application. Users can **create**, **read**, **update**, and **delete** tasks through a clean user interface. Tasks are stored persistently in MongoDB, so data survives browser refreshes.

---

## Technologies

- **React** 18+ (frontend UI)
- **Node.js** 18+ (runtime)
- **Express.js** (backend server / REST API)
- **MongoDB** (database)
- **Mongoose** (ODM / database modeling)
- **CORS** (cross-origin request handling)
- **Fetch API** (frontend HTTP requests)
- **Vite** (frontend build tool / dev server)
- **dotenv** (environment variables)
- **nodemon** (backend auto-restart in development)

---

## Architecture

```text
React Frontend (localhost:5173)
        |
        |  HTTP requests using Fetch API
        v
Express.js Backend (localhost:5000)
        |
        |  Mongoose
        v
MongoDB
```

The frontend communicates with the backend over HTTP using a central API service. The backend exposes REST endpoints, uses Mongoose to interact with MongoDB, and returns JSON responses.

---

## Folder Structure

```text
Prac_6/
│
├── backend/
│   ├── config/
│   │   └── db.js                 # MongoDB connection
│   ├── controllers/
│   │   └── taskController.js     # CRUD logic
│   ├── middleware/
│   │   └── errorMiddleware.js    # 404 + error handler
│   ├── models/
│   │   └── Task.js               # Task Mongoose model
│   ├── routes/
│   │   └── taskRoutes.js         # API routes
│   ├── .env                      # environment variables (not committed)
│   ├── .gitignore
│   ├── package.json
│   └── server.js                 # Express server entry point
│
├── frontend/
│   ├── src/
│   │   ├── components/
│   │   │   ├── TaskForm.jsx      # Create/Edit form
│   │   │   ├── TaskItem.jsx      # Single task + actions
│   │   │   ├── TaskList.jsx      # Task list container
│   │   │   └── Toast.jsx         # Toast notifications
│   │   ├── services/
│   │   │   └── api.js            # Central API service (Fetch)
│   │   ├── App.jsx               # Main app (state management)
│   │   ├── App.css
│   │   ├── index.css
│   │   └── main.jsx
│   ├── .env                      # VITE_API_URL
│   ├── .gitignore
│   ├── index.html
│   ├── package.json
│   └── vite.config.js
│
├── PROJECT.md                    # Practical specification
└── README.md
```

---

## Requirements

- **Node.js** 18+
- **MongoDB** (local) or **MongoDB Atlas** (cloud)
- **npm** (Node package manager)

---

## Installation

### Backend

```bash
cd backend
npm install
```

### Frontend

```bash
cd frontend
npm install
```

---

## Environment Variables

### Backend — `backend/.env`

```env
PORT=5000
MONGO_URI=your_mongodb_connection_string
```

- `PORT` — port the Express server runs on (default `5000`).
- `MONGO_URI` — connection string for MongoDB (local or Atlas).

A `.env.example` file is provided as a template. The real `.env` file is excluded from Git via `.gitignore`.

### Frontend — `frontend/.env`

```env
VITE_API_URL=http://localhost:5000
```

- `VITE_API_URL` — base URL of the backend API. Defaults to `http://localhost:5000` if not set.

> **Security note:** Never commit real connection strings or secrets. `.env` files are ignored.

---

## Running

Start MongoDB first (local `mongod` or a running Atlas database).

### Backend

```bash
cd backend
npm run dev
```

The backend runs at **http://localhost:5000**.

### Frontend

In a separate terminal:

```bash
cd frontend
npm run dev
```

The frontend runs at **http://localhost:5173**.

---

## API Documentation

Base URL: `http://localhost:5000`

| Method | Endpoint     | Purpose            | Success Code |
| ------ | ------------ | ------------------ | ------------ |
| GET    | `/health`    | Health check       | 200          |
| GET    | `/tasks`     | Get all tasks      | 200          |
| GET    | `/tasks/:id` | Get one task       | 200          |
| POST   | `/tasks`     | Create a task      | 201          |
| PUT    | `/tasks/:id` | Update a task      | 200          |
| DELETE | `/tasks/:id` | Delete a task      | 200          |

### Example — Create Task

```http
POST /tasks
Content-Type: application/json
```

```json
{
  "title": "Complete Practical 6",
  "description": "Build React Node MongoDB integration",
  "completed": false
}
```

### Task fields

| Field       | Type      | Required | Notes                        |
| ----------- | --------- | -------- | ---------------------------- |
| `title`     | string    | yes      | max 200 characters           |
| `description` | string  | no       | default empty string         |
| `completed` | boolean   | no       | default `false`              |
| `createdAt` | date      | auto     | added via timestamps         |
| `updatedAt` | date      | auto     | added via timestamps         |

### Error status codes

| Status | Meaning                |
| ------ | ---------------------- |
| 400    | Invalid input / ID     |
| 404    | Resource not found     |
| 500    | Server error           |

---

## Testing

### Backend (Postman or cURL)

1. Start the backend and confirm `GET /health` returns `{"success": true, "message": "Task API is running"}`.
2. `GET /tasks` — returns the task list (empty initially).
3. `POST /tasks` — create a task; expect `201`.
4. `GET /tasks/:id` — fetch a single task by its `_id`.
5. `PUT /tasks/:id` — update a task; expect `200`.
6. `DELETE /tasks/:id` — delete a task; expect `200`.
7. Test error cases: invalid `:id` → `400`, missing task → `404`, missing title → `400`.

### Browser / Frontend

1. Load the app at `http://localhost:5173`.
2. **Create** a task — it appears in the list with a success toast.
3. **Refresh** the browser — the task still exists (persistence from MongoDB).
4. **Edit** a task — update title/description/completed; confirm UI reflects the change.
5. **Delete** a task — a confirmation dialog appears; confirm and the task disappears.
6. Stop the backend to verify **error handling** and **toast** notifications on failure.

---

## Features

- Full CRUD (Create, Read, Update, Delete)
- Persistent MongoDB storage
- Centralized API service
- Loading states for all operations
- Error handling on every API call
- Delete confirmation dialog
- Toast notifications (success / error)
- Responsive layout
- State synchronization with the database

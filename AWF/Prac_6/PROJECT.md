# Practical 6 — Full Stack Integration

## React + Node.js + Express + MongoDB Task Management Application

**Course Outcome:** CO1, CO2
**Program Outcome:** PO3, PO5
**Practical:** 6

---

## 1. Project Overview

This practical integrates a React frontend with a Node.js, Express.js, and MongoDB backend to create a complete full-stack Task Management Application.

The frontend provides a user interface for managing tasks, while the backend provides REST API endpoints for performing CRUD operations. MongoDB is used as the persistent database.

The complete application follows this architecture:

```text
React Frontend
localhost:5173
      |
      | HTTP Requests using fetch
      v
Express.js Backend
localhost:5000
      |
      | Mongoose
      v
MongoDB
```

The application supports:

* Creating tasks
* Viewing tasks
* Updating tasks
* Deleting tasks
* Persistent storage in MongoDB
* Loading states
* Error handling
* Confirmation before deletion
* Toast notifications

---

# 2. Objective

The objective of this practical is to:

1. Connect a React frontend to a Node/Express backend.
2. Connect the Express backend to MongoDB using Mongoose.
3. Replace external/GitHub task data with data from the application's own backend.
4. Implement complete CRUD functionality.
5. Synchronize React state with backend data.
6. Configure CORS for frontend-backend communication.
7. Handle loading and error states for API operations.
8. Confirm that data persists after refreshing the browser.

---

# 3. Technologies Used

## Frontend

* React 18+
* JavaScript
* HTML
* CSS
* Fetch API
* React Router (if required)

## Backend

* Node.js v18+
* Express.js
* Mongoose
* MongoDB
* CORS
* dotenv

## Development and Testing

* npm
* Postman
* Browser DevTools
* Git/GitHub

---

# 4. Application Architecture

```text
                    TASK MANAGEMENT APPLICATION
                              |
                ┌─────────────┴─────────────┐
                |                           |
                v                           v
        React Frontend                Express Backend
        localhost:5173                localhost:5000
                |                           |
                | fetch()                  |
                └─────────────►─────────────┘
                                            |
                                            v
                                        Mongoose
                                            |
                                            v
                                        MongoDB
```

---

# 5. Request Flow

For example, when creating a task:

```text
User fills Task Form
        |
        v
React Component
        |
        | POST /tasks
        v
Express Route
        |
        v
Task Controller
        |
        v
Mongoose
        |
        v
MongoDB
        |
        v
Successful Response
        |
        v
React updates state
        |
        v
New task appears in UI
```

---

# 6. Project Structure

A recommended monorepo structure is:

```text
task-management/
│
├── backend/
│   ├── config/
│   │   └── db.js
│   │
│   ├── controllers/
│   │   └── taskController.js
│   │
│   ├── models/
│   │   └── Task.js
│   │
│   ├── routes/
│   │   └── taskRoutes.js
│   │
│   ├── .env
│   ├── .gitignore
│   ├── package.json
│   └── server.js
│
├── frontend/
│   ├── src/
│   │   ├── components/
│   │   │   ├── TaskForm.jsx
│   │   │   ├── TaskList.jsx
│   │   │   └── TaskItem.jsx
│   │   │
│   │   ├── services/
│   │   │   └── api.js
│   │   │
│   │   ├── App.jsx
│   │   └── main.jsx
│   │
│   ├── package.json
│   └── ...
│
├── PROJECT.md
└── README.md
```

---

# 7. Backend Setup

Create the backend:

```bash
mkdir backend
cd backend
npm init -y
```

Install dependencies:

```bash
npm install express mongoose cors dotenv
```

For development:

```bash
npm install --save-dev nodemon
```

---

# 8. Environment Variables

Create:

```text
backend/.env
```

Example:

```env
PORT=5000
MONGO_URI=your_mongodb_connection_string
```

The `.env` file must not be committed to GitHub.

Add:

```gitignore
node_modules/
.env
```

to `.gitignore`.

---

# 9. MongoDB Task Model

The Task model represents the task stored in MongoDB.

Example:

```javascript
const mongoose = require("mongoose");

const taskSchema = new mongoose.Schema(
  {
    title: {
      type: String,
      required: true,
      trim: true
    },

    description: {
      type: String,
      default: ""
    },

    completed: {
      type: Boolean,
      default: false
    }
  },
  {
    timestamps: true
  }
);

module.exports = mongoose.model("Task", taskSchema);
```

---

# 10. REST API

The backend provides the following endpoints:

| Method | Endpoint     | Purpose       |
| ------ | ------------ | ------------- |
| GET    | `/tasks`     | Get all tasks |
| GET    | `/tasks/:id` | Get one task  |
| POST   | `/tasks`     | Create task   |
| PUT    | `/tasks/:id` | Update task   |
| DELETE | `/tasks/:id` | Delete task   |

---

# 11. Create Task

### Request

```http
POST /tasks
```

Example body:

```json
{
  "title": "Complete Practical 6",
  "description": "Integrate React with Node and MongoDB"
}
```

### Expected Result

```http
201 Created
```

The task should be saved permanently in MongoDB.

---

# 12. Read Tasks

### Request

```http
GET /tasks
```

The backend retrieves tasks from MongoDB.

React calls this endpoint when the application loads.

```text
Application starts
       |
       v
GET /tasks
       |
       v
MongoDB
       |
       v
Tasks returned
       |
       v
React state
       |
       v
Task list rendered
```

---

# 13. Update Task

### Request

```http
PUT /tasks/:id
```

Example body:

```json
{
  "title": "Complete Practical 6",
  "description": "Full stack integration completed",
  "completed": true
}
```

The MongoDB document must be updated.

React should then update its state or re-fetch the task list.

---

# 14. Delete Task

### Request

```http
DELETE /tasks/:id
```

After successful deletion:

1. MongoDB record is deleted.
2. React state is updated.
3. The task disappears from the UI without a full page reload.

A confirmation dialog should be shown before deletion:

```text
Are you sure you want to delete this task?
       |
       ├── Cancel
       |
       └── Confirm
```

---

# 15. CORS Configuration

Because the frontend and backend run on different ports, CORS must be enabled.

Install:

```bash
npm install cors
```

Configure Express:

```javascript
const cors = require("cors");

app.use(cors());
```

This allows:

```text
React
localhost:5173
       |
       | HTTP
       v
Express
localhost:5000
```

---

# 16. Frontend API Service

Create a central API file:

```text
frontend/src/services/api.js
```

Example:

```javascript
const BASE_URL = "http://localhost:5000";

export const getTasks = async () => {
  const response = await fetch(`${BASE_URL}/tasks`);

  if (!response.ok) {
    throw new Error("Failed to fetch tasks");
  }

  return response.json();
};

export const createTask = async (task) => {
  const response = await fetch(`${BASE_URL}/tasks`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(task)
  });

  if (!response.ok) {
    throw new Error("Failed to create task");
  }

  return response.json();
};
```

Similar functions should be created for update and delete operations.

---

# 17. React State Management

The frontend should maintain task state.

Example:

```javascript
const [tasks, setTasks] = useState([]);
const [loading, setLoading] = useState(false);
const [error, setError] = useState("");
```

When tasks are loaded:

```text
Backend
   |
   v
GET /tasks
   |
   v
setTasks(data)
   |
   v
React renders task list
```

---

# 18. Loading States

Loading states should be handled for API operations.

Example:

```text
Loading tasks...
```

or:

```text
Creating task...
```

or:

```text
Updating...
```

The UI should clearly indicate when an operation is in progress.

---

# 19. Error Handling

Every API operation should handle errors.

Example:

```javascript
try {
  await createTask(task);
} catch (error) {
  setError(error.message);
}
```

The application should not silently ignore failed requests.

Example:

```text
Failed to create task.
Please try again.
```

---

# 20. Toast Notifications

The application should display notifications after operations.

Examples:

```text
✓ Task created successfully
✓ Task updated successfully
✓ Task deleted successfully
✗ Failed to create task
```

The toast can be implemented using a custom React component or an appropriate notification library.

---

# 21. Complete CRUD Flow

The complete application flow is:

```text
CREATE
User Form
   ↓
POST /tasks
   ↓
MongoDB
   ↓
Update React State
   ↓
Task appears

READ
Application loads
   ↓
GET /tasks
   ↓
MongoDB
   ↓
React State
   ↓
Task List

UPDATE
Edit Task
   ↓
PUT /tasks/:id
   ↓
MongoDB
   ↓
Update React State
   ↓
Updated Task

DELETE
Delete Button
   ↓
Confirmation
   ↓
DELETE /tasks/:id
   ↓
MongoDB
   ↓
Remove from React State
```

---

# 22. Testing Checklist

## Create

* [ ] Open application
* [ ] Enter task title
* [ ] Submit task
* [ ] Task appears in UI
* [ ] Task exists in MongoDB

## Read

* [ ] Refresh browser
* [ ] Previously created task remains
* [ ] Task is loaded from backend

## Update

* [ ] Edit task
* [ ] Submit update
* [ ] UI reflects change
* [ ] MongoDB reflects change

## Delete

* [ ] Click delete
* [ ] Confirmation dialog appears
* [ ] Confirm deletion
* [ ] Task disappears
* [ ] MongoDB record is deleted

## Error Handling

* [ ] Backend stopped
* [ ] Frontend shows error
* [ ] Failed POST handled
* [ ] Failed PUT handled
* [ ] Failed DELETE handled

---

# 23. Postman Testing

Before testing from React, verify the backend using Postman.

### GET

```http
GET http://localhost:5000/tasks
```

### POST

```http
POST http://localhost:5000/tasks
```

Body:

```json
{
  "title": "Test Task",
  "description": "Created using Postman"
}
```

### PUT

```http
PUT http://localhost:5000/tasks/TASK_ID
```

### DELETE

```http
DELETE http://localhost:5000/tasks/TASK_ID
```

---

# 24. Running the Application

## Start MongoDB

Make sure MongoDB is running or the configured MongoDB Atlas database is accessible.

## Start Backend

```bash
cd backend
npm run dev
```

Backend:

```text
http://localhost:5000
```

## Start Frontend

Open another terminal:

```bash
cd frontend
npm install
npm run dev
```

Frontend:

```text
http://localhost:5173
```

---

# 25. GitHub Deliverables

The repository should contain:

* React frontend
* Node/Express backend
* MongoDB integration
* CRUD APIs
* Frontend API service
* CORS configuration
* Loading states
* Error handling
* Delete confirmation
* Toast notifications
* README with setup instructions
* `.env` excluded using `.gitignore`

At least one commit should specifically represent the full-stack integration.

Example:

```bash
git add .
git commit -m "feat: integrate React frontend with backend CRUD APIs"
```

---

# 26. Viva Questions

### Why is CORS required?

Because the React frontend and Express backend run on different origins/ports during local development. CORS allows the browser to permit these cross-origin requests.

### Why do we need an API service file?

It centralizes backend communication and prevents API URLs and fetch logic from being duplicated throughout React components.

### Why update React state after POST/PUT/DELETE?

Because the UI needs to reflect the latest server state. Otherwise, the database may be updated while the screen still shows stale data.

### Why is error handling required for POST/PUT/DELETE?

Write operations can fail due to network errors, validation errors, server errors, or database failures. The user must receive feedback instead of the application silently assuming success.

### How do you verify MongoDB persistence?

Create a task, refresh the browser, and verify that the task is loaded again from the backend/database.

---

# 27. Learning Outcome

After completing this practical, the student will be able to:

* Build a complete React + Node.js + MongoDB application.
* Create and consume REST APIs.
* Connect React to an Express backend.
* Configure CORS.
* Perform CRUD operations.
* Synchronize frontend state with backend state.
* Handle loading and error states.
* Persist application data in MongoDB.

---

# 28. Conclusion

Practical 6 converts separate frontend and backend applications into a complete full-stack Task Management Application.

The final architecture is:

```text
        React
         |
         | fetch()
         v
      Express
         |
         | Mongoose
         v
      MongoDB
```

Users can create, read, update, and delete tasks through the React interface, while MongoDB provides persistent storage.

This project forms the foundation for Practical 7, where authentication, JWT authorization, password hashing, and middleware-based security will be added.

---

# 29. Implementation

The specification above has been implemented in this directory.

## Structure

```text
backend/
├── config/db.js
├── controllers/taskController.js
├── middleware/errorMiddleware.js
├── models/Task.js
├── routes/taskRoutes.js
├── .env
├── .gitignore
├── package.json
└── server.js

frontend/
├── src/
│   ├── components/
│   │   ├── TaskForm.jsx
│   │   ├── TaskItem.jsx
│   │   ├── TaskList.jsx
│   │   └── Toast.jsx
│   ├── services/api.js
│   ├── App.jsx
│   ├── App.css
│   ├── index.css
│   └── main.jsx
├── .env
├── .gitignore
├── index.html
├── package.json
└── vite.config.js
```

## What Is Implemented

* Express server with `cors()`, `express.json()`, routing, and error handling.
* Mongoose connection in `backend/config/db.js`.
* `Task` model with `title`, `description`, `completed`, and timestamps.
* Full CRUD controllers and routes (`GET`, `GET/:id`, `POST`, `PUT/:id`, `DELETE/:id`).
* Central frontend API service (`frontend/src/services/api.js`).
* React components for the form, list, single item, and toasts.
* Loading states, error handling, delete confirmation, and toast notifications.
* Responsive styling.
* `/health` endpoint.

The application is ready to be extended for Practical 7 (JWT authentication and middleware-based security).

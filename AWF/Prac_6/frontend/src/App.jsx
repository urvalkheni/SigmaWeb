import { useState, useEffect, useCallback } from "react";
import { getTasks, createTask, updateTask, deleteTask } from "./services/api";
import TaskForm from "./components/TaskForm";
import TaskList from "./components/TaskList";
import Toast from "./components/Toast";
import "./App.css";

function App() {
  const [tasks, setTasks] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");
  const [toast, setToast] = useState(null);
  const [editingTask, setEditingTask] = useState(null);

  const showToast = useCallback((message, type = "success") => {
    setToast({ message, type });
  }, []);

  useEffect(() => {
    if (!toast) return;
    const timer = setTimeout(() => setToast(null), 3000);
    return () => clearTimeout(timer);
  }, [toast]);

  const loadTasks = useCallback(async () => {
    setLoading(true);
    setError("");
    try {
      const data = await getTasks();
      setTasks(data.data);
    } catch (err) {
      setError("Failed to load tasks. Please try again.");
    } finally {
      setLoading(false);
    }
  }, []);

  useEffect(() => {
    loadTasks();
  }, [loadTasks]);

  const handleCreate = async (taskData) => {
    try {
      await createTask(taskData);
      await loadTasks();
      showToast("Task created successfully");
      return true;
    } catch (err) {
      showToast("Failed to create task", "error");
      setError("Failed to create task. Please try again.");
      return false;
    }
  };

  const handleUpdate = async (id, taskData) => {
    try {
      await updateTask(id, taskData);
      await loadTasks();
      setEditingTask(null);
      showToast("Task updated successfully");
      return true;
    } catch (err) {
      showToast("Failed to update task", "error");
      setError("Failed to update task. Please try again.");
      return false;
    }
  };

  const handleDelete = async (id) => {
    try {
      await deleteTask(id);
      setTasks((prev) => prev.filter((task) => task._id !== id));
      showToast("Task deleted successfully");
      return true;
    } catch (err) {
      showToast("Failed to delete task", "error");
      setError("Failed to delete task. Please try again.");
      return false;
    }
  };

  const handleEditStart = (task) => {
    setEditingTask(task);
  };

  const handleCancelEdit = () => {
    setEditingTask(null);
  };

  return (
    <div className="app">
      <header className="app-header">
        <h1>Task Management</h1>
        <p className="subtitle">React + Express + MongoDB</p>
      </header>

      <main className="app-main">
        <TaskForm
          onSave={handleCreate}
          editingTask={editingTask}
          onUpdate={handleUpdate}
          onCancelEdit={handleCancelEdit}
        />

        {error && <div className="error-banner">{error}</div>}

        <TaskList
          tasks={tasks}
          loading={loading}
          onEditStart={handleEditStart}
          onDelete={handleDelete}
        />
      </main>

      {toast && <Toast message={toast.message} type={toast.type} />}
    </div>
  );
}

export default App;

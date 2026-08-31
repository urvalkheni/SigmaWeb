import { useState, useEffect } from "react";

function TaskForm({ onSave, editingTask, onUpdate, onCancelEdit }) {
  const [title, setTitle] = useState("");
  const [description, setDescription] = useState("");
  const [completed, setCompleted] = useState(false);
  const [submitting, setSubmitting] = useState(false);
  const [error, setError] = useState("");

  const isEditing = Boolean(editingTask);

  useEffect(() => {
    if (editingTask) {
      setTitle(editingTask.title);
      setDescription(editingTask.description || "");
      setCompleted(editingTask.completed || false);
      setError("");
    } else {
      setTitle("");
      setDescription("");
      setCompleted(false);
      setError("");
    }
  }, [editingTask]);

  const validate = () => {
    if (!title || title.trim().length === 0) {
      setError("Title is required");
      return false;
    }
    if (title.trim().length > 200) {
      setError("Title cannot exceed 200 characters");
      return false;
    }
    return true;
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError("");

    if (!validate()) return;

    const taskData = {
      title: title.trim(),
      description: description.trim(),
      completed
    };

    setSubmitting(true);
    const ok = isEditing
      ? await onUpdate(editingTask._id, taskData)
      : await onSave(taskData);

    setSubmitting(false);

    if (ok || isEditing) {
      setTitle("");
      setDescription("");
      setCompleted(false);
    }
  };

  return (
    <form className="task-form card" onSubmit={handleSubmit}>
      <h2>{isEditing ? "Edit Task" : "Create Task"}</h2>

      <div className="form-group">
        <label htmlFor="title">Title</label>
        <input
          id="title"
          type="text"
          value={title}
          onChange={(e) => setTitle(e.target.value)}
          placeholder="Enter task title"
          disabled={submitting}
        />
      </div>

      <div className="form-group">
        <label htmlFor="description">Description</label>
        <textarea
          id="description"
          value={description}
          onChange={(e) => setDescription(e.target.value)}
          placeholder="Enter task description (optional)"
          rows="3"
          disabled={submitting}
        />
      </div>

      {isEditing && (
        <div className="form-group checkbox-group">
          <label className="checkbox-label">
            <input
              type="checkbox"
              checked={completed}
              onChange={(e) => setCompleted(e.target.checked)}
              disabled={submitting}
            />
            Completed
          </label>
        </div>
      )}

      {error && <div className="form-error">{error}</div>}

      <div className="form-actions">
        <button type="submit" className="btn btn-primary" disabled={submitting}>
          {submitting
            ? isEditing
              ? "Updating..."
              : "Creating..."
            : isEditing
            ? "Update Task"
            : "Create Task"}
        </button>

        {isEditing && (
          <button
            type="button"
            className="btn btn-secondary"
            onClick={onCancelEdit}
            disabled={submitting}
          >
            Cancel
          </button>
        )}
      </div>
    </form>
  );
}

export default TaskForm;

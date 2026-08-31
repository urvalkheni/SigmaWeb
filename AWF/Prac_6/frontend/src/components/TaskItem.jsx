import { useState } from "react";

function TaskItem({ task, onEditStart, onDelete }) {
  const [confirming, setConfirming] = useState(false);
  const [deleting, setDeleting] = useState(false);

  const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString(undefined, {
      year: "numeric",
      month: "short",
      day: "numeric"
    });
  };

  const handleEdit = () => {
    onEditStart(task);
  };

  const handleDeleteClick = () => {
    setConfirming(true);
  };

  const handleCancelDelete = () => {
    setConfirming(false);
  };

  const handleConfirmDelete = async () => {
    setDeleting(true);
    const ok = await onDelete(task._id);
    setDeleting(false);
    if (ok) setConfirming(false);
  };

  return (
    <li className={`task-item ${task.completed ? "completed" : ""}`}>
      <div className="task-content">
        <h3>{task.title}</h3>
        {task.description && <p className="task-description">{task.description}</p>}
        <div className="task-meta">
          <span className={`status-badge ${task.completed ? "done" : "pending"}`}>
            {task.completed ? "Completed" : "Incomplete"}
          </span>
          <span className="task-date">
            Created: {task.createdAt ? formatDate(task.createdAt) : "—"}
          </span>
        </div>
      </div>

      <div className="task-actions">
        {confirming ? (
          <div className="confirm-dialog">
            <span>Are you sure you want to delete this task?</span>
            <button
              className="btn btn-danger"
              onClick={handleConfirmDelete}
              disabled={deleting}
            >
              {deleting ? "Deleting..." : "Delete"}
            </button>
            <button
              className="btn btn-secondary"
              onClick={handleCancelDelete}
              disabled={deleting}
            >
              Cancel
            </button>
          </div>
        ) : (
          <>
            <button className="btn btn-secondary" onClick={handleEdit}>
              Edit
            </button>
            <button className="btn btn-danger" onClick={handleDeleteClick}>
              Delete
            </button>
          </>
        )}
      </div>
    </li>
  );
}

export default TaskItem;

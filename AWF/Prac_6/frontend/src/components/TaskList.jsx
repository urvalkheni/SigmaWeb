import TaskItem from "./TaskItem";

function TaskList({ tasks, loading, onEditStart, onDelete }) {
  if (loading) {
    return <div className="task-list empty-state">Loading tasks...</div>;
  }

  if (tasks.length === 0) {
    return (
      <div className="task-list empty-state">
        <p>No tasks found. Create your first task.</p>
      </div>
    );
  }

  return (
    <div className="task-list card">
      <h2>Tasks</h2>
      <ul className="task-items">
        {tasks.map((task) => (
          <TaskItem
            key={task._id}
            task={task}
            onEditStart={onEditStart}
            onDelete={onDelete}
          />
        ))}
      </ul>
    </div>
  );
}

export default TaskList;

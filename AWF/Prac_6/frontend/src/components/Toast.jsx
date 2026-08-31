function Toast({ message, type = "success" }) {
  const icon = type === "success" ? "✓" : "✗";
  return (
    <div className={`toast toast-${type}`} role="status">
      <span className="toast-icon">{icon}</span>
      <span className="toast-message">{message}</span>
    </div>
  );
}

export default Toast;

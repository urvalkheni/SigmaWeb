const mongoose = require("mongoose");
const Task = require("../models/Task");

async function getTasks(req, res) {
  try {
    const tasks = await Task.find().sort({ createdAt: -1 });
    res.status(200).json({ success: true, count: tasks.length, data: tasks });
  } catch (error) {
    res.status(500).json({ success: false, message: "Failed to load tasks" });
  }
}

async function getTask(req, res) {
  const { id } = req.params;

  if (!mongoose.Types.ObjectId.isValid(id)) {
    return res.status(400).json({ success: false, message: "Invalid task ID" });
  }

  try {
    const task = await Task.findById(id);

    if (!task) {
      return res.status(404).json({ success: false, message: "Task not found" });
    }

    res.status(200).json({ success: true, data: task });
  } catch (error) {
    res.status(500).json({ success: false, message: "Failed to load task" });
  }
}

async function createTask(req, res) {
  const { title, description, completed } = req.body;

  if (!title || title.trim().length === 0) {
    return res.status(400).json({ success: false, message: "Title is required" });
  }

  if (title.trim().length > 200) {
    return res.status(400).json({ success: false, message: "Title cannot exceed 200 characters" });
  }

  try {
    const task = await Task.create({
      title: title.trim(),
      description: description ? description.trim() : "",
      completed: completed === true
    });

    res.status(201).json({ success: true, message: "Task created successfully", data: task });
  } catch (error) {
    res.status(500).json({ success: false, message: "Failed to create task" });
  }
}

async function updateTask(req, res) {
  const { id } = req.params;

  if (!mongoose.Types.ObjectId.isValid(id)) {
    return res.status(400).json({ success: false, message: "Invalid task ID" });
  }

  const { title, description, completed } = req.body;

  if (title !== undefined && title.trim().length === 0) {
    return res.status(400).json({ success: false, message: "Title cannot be empty" });
  }

  if (title !== undefined && title.trim().length > 200) {
    return res.status(400).json({ success: false, message: "Title cannot exceed 200 characters" });
  }

  const updates = {};
  if (title !== undefined) updates.title = title.trim();
  if (description !== undefined) updates.description = description.trim();
  if (completed !== undefined) updates.completed = completed === true;

  try {
    const task = await Task.findByIdAndUpdate(id, updates, { new: true, runValidators: true });

    if (!task) {
      return res.status(404).json({ success: false, message: "Task not found" });
    }

    res.status(200).json({ success: true, message: "Task updated successfully", data: task });
  } catch (error) {
    res.status(500).json({ success: false, message: "Failed to update task" });
  }
}

async function deleteTask(req, res) {
  const { id } = req.params;

  if (!mongoose.Types.ObjectId.isValid(id)) {
    return res.status(400).json({ success: false, message: "Invalid task ID" });
  }

  try {
    const task = await Task.findByIdAndDelete(id);

    if (!task) {
      return res.status(404).json({ success: false, message: "Task not found" });
    }

    res.status(200).json({ success: true, message: "Task deleted successfully" });
  } catch (error) {
    res.status(500).json({ success: false, message: "Failed to delete task" });
  }
}

module.exports = {
  getTasks,
  getTask,
  createTask,
  updateTask,
  deleteTask
};

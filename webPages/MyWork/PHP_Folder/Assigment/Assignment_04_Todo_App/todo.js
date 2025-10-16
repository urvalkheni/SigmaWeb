// Assignment 4: Dynamic Todo App with LocalStorage
// Student: Kheni Urval | ID: 24CE055 | Course: WDF: ITUE203

// Todo application state
let todos = [];
let currentFilter = 'all';
let nextId = 1;

// DOM Elements
const todoInput = document.getElementById('todo-input');
const addBtn = document.getElementById('add-btn');
const todoList = document.getElementById('todo-list');
const emptyState = document.getElementById('empty-state');
const filterButtons = document.querySelectorAll('.filter-btn');
const clearCompletedBtn = document.getElementById('clear-completed');
const clearAllBtn = document.getElementById('clear-all-btn');
const exportBtn = document.getElementById('export-btn');
const totalCount = document.getElementById('total-count');
const activeCount = document.getElementById('active-count');
const completedCount = document.getElementById('completed-count');

// Initialize app
document.addEventListener('DOMContentLoaded', () => {
    loadTodos();
    renderTodos();
    updateStats();
    
    console.log('Todo App initialized by Kheni Urval (24CE055)');
});

// Event Listeners
addBtn.addEventListener('click', addTodo);
todoInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') addTodo();
});

filterButtons.forEach(btn => {
    btn.addEventListener('click', (e) => {
        setFilter(e.target.dataset.filter);
    });
});

clearCompletedBtn.addEventListener('click', clearCompleted);
clearAllBtn.addEventListener('click', clearAll);
exportBtn.addEventListener('click', exportTodos);

// Add new todo
function addTodo() {
    const text = todoInput.value.trim();
    
    if (text === '') {
        alert('Please enter a task!');
        return;
    }
    
    if (text.length > 100) {
        alert('Task is too long! Maximum 100 characters.');
        return;
    }
    
    const newTodo = {
        id: nextId++,
        text: text,
        completed: false,
        createdAt: new Date().toISOString(),
        completedAt: null
    };
    
    todos.push(newTodo);
    todoInput.value = '';
    
    saveTodos();
    renderTodos();
    updateStats();
    
    console.log(`Task added by student 24CE055: "${text}"`);
}

// Toggle todo completion
function toggleTodo(id) {
    const todo = todos.find(t => t.id === id);
    if (todo) {
        todo.completed = !todo.completed;
        todo.completedAt = todo.completed ? new Date().toISOString() : null;
        
        saveTodos();
        renderTodos();
        updateStats();
        
        console.log(`Task ${todo.completed ? 'completed' : 'uncompleted'}: "${todo.text}"`);
    }
}

// Delete todo
function deleteTodo(id) {
    const todoIndex = todos.findIndex(t => t.id === id);
    if (todoIndex > -1) {
        const deletedTodo = todos[todoIndex];
        todos.splice(todoIndex, 1);
        
        saveTodos();
        renderTodos();
        updateStats();
        
        console.log(`Task deleted: "${deletedTodo.text}"`);
    }
}

// Edit todo
function editTodo(id) {
    const todo = todos.find(t => t.id === id);
    if (todo) {
        const newText = prompt('Edit task:', todo.text);
        
        if (newText !== null && newText.trim() !== '') {
            if (newText.trim().length > 100) {
                alert('Task is too long! Maximum 100 characters.');
                return;
            }
            
            todo.text = newText.trim();
            
            saveTodos();
            renderTodos();
            
            console.log(`Task edited: "${todo.text}"`);
        }
    }
}

// Set filter
function setFilter(filter) {
    currentFilter = filter;
    
    // Update active filter button
    filterButtons.forEach(btn => {
        btn.classList.remove('active');
        if (btn.dataset.filter === filter) {
            btn.classList.add('active');
        }
    });
    
    renderTodos();
}

// Clear completed todos
function clearCompleted() {
    const completedCount = todos.filter(t => t.completed).length;
    
    if (completedCount === 0) {
        alert('No completed tasks to clear!');
        return;
    }
    
    if (confirm(`Delete ${completedCount} completed task(s)?`)) {
        todos = todos.filter(t => !t.completed);
        
        saveTodos();
        renderTodos();
        updateStats();
        
        console.log(`${completedCount} completed tasks cleared`);
    }
}

// Clear all todos
function clearAll() {
    if (todos.length === 0) {
        alert('No tasks to clear!');
        return;
    }
    
    if (confirm(`Delete all ${todos.length} task(s)?`)) {
        todos = [];
        nextId = 1;
        
        saveTodos();
        renderTodos();
        updateStats();
        
        console.log('All tasks cleared by student 24CE055');
    }
}

// Export todos
function exportTodos() {
    if (todos.length === 0) {
        alert('No tasks to export!');
        return;
    }
    
    const exportData = {
        exportedBy: 'Kheni Urval (24CE055)',
        exportDate: new Date().toISOString(),
        totalTasks: todos.length,
        tasks: todos.map(todo => ({
            text: todo.text,
            completed: todo.completed,
            createdAt: todo.createdAt,
            completedAt: todo.completedAt
        }))
    };
    
    const dataStr = JSON.stringify(exportData, null, 2);
    const dataBlob = new Blob([dataStr], { type: 'application/json' });
    
    const link = document.createElement('a');
    link.href = URL.createObjectURL(dataBlob);
    link.download = `todos_24CE055_${new Date().toISOString().split('T')[0]}.json`;
    link.click();
    
    console.log('Tasks exported by student 24CE055');
}

// Render todos
function renderTodos() {
    const filteredTodos = getFilteredTodos();
    
    if (filteredTodos.length === 0) {
        todoList.style.display = 'none';
        emptyState.style.display = 'block';
        
        // Update empty state message based on filter
        const emptyIcon = emptyState.querySelector('.empty-icon');
        const emptyTitle = emptyState.querySelector('h3');
        const emptyDesc = emptyState.querySelector('p');
        
        switch (currentFilter) {
            case 'active':
                emptyIcon.textContent = '✅';
                emptyTitle.textContent = 'No active tasks!';
                emptyDesc.textContent = 'All tasks are completed or add a new one.';
                break;
            case 'completed':
                emptyIcon.textContent = '🎯';
                emptyTitle.textContent = 'No completed tasks!';
                emptyDesc.textContent = 'Complete some tasks to see them here.';
                break;
            default:
                emptyIcon.textContent = '📝';
                emptyTitle.textContent = 'No tasks yet!';
                emptyDesc.textContent = 'Add your first task above to get started.';
        }
    } else {
        todoList.style.display = 'block';
        emptyState.style.display = 'none';
        
        todoList.innerHTML = filteredTodos.map(todo => createTodoHTML(todo)).join('');
        
        // Add event listeners to newly created elements
        attachTodoEventListeners();
    }
}

// Get filtered todos based on current filter
function getFilteredTodos() {
    switch (currentFilter) {
        case 'active':
            return todos.filter(t => !t.completed);
        case 'completed':
            return todos.filter(t => t.completed);
        default:
            return todos;
    }
}

// Create HTML for a single todo
function createTodoHTML(todo) {
    const createdDate = new Date(todo.createdAt).toLocaleDateString();
    const completedDate = todo.completedAt ? new Date(todo.completedAt).toLocaleDateString() : null;
    
    return `
        <div class="todo-item ${todo.completed ? 'completed' : ''}" data-id="${todo.id}">
            <div class="todo-content">
                <input type="checkbox" class="todo-checkbox" ${todo.completed ? 'checked' : ''}>
                <span class="todo-text">${escapeHtml(todo.text)}</span>
                <div class="todo-meta">
                    <small>Created: ${createdDate}</small>
                    ${completedDate ? `<small>Completed: ${completedDate}</small>` : ''}
                </div>
            </div>
            <div class="todo-actions">
                <button class="todo-action-btn edit-btn" title="Edit task">✏️</button>
                <button class="todo-action-btn delete-btn" title="Delete task">🗑️</button>
            </div>
        </div>
    `;
}

// Attach event listeners to todo items
function attachTodoEventListeners() {
    // Checkbox listeners
    document.querySelectorAll('.todo-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', (e) => {
            const todoId = parseInt(e.target.closest('.todo-item').dataset.id);
            toggleTodo(todoId);
        });
    });
    
    // Edit button listeners
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const todoId = parseInt(e.target.closest('.todo-item').dataset.id);
            editTodo(todoId);
        });
    });
    
    // Delete button listeners
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const todoId = parseInt(e.target.closest('.todo-item').dataset.id);
            
            if (confirm('Delete this task?')) {
                deleteTodo(todoId);
            }
        });
    });
}

// Update statistics
function updateStats() {
    const total = todos.length;
    const active = todos.filter(t => !t.completed).length;
    const completed = todos.filter(t => t.completed).length;
    
    totalCount.textContent = `${total} total`;
    activeCount.textContent = `${active} active`;
    completedCount.textContent = `${completed} completed`;
    
    // Update clear completed button state
    clearCompletedBtn.disabled = completed === 0;
    clearAllBtn.disabled = total === 0;
}

// Local Storage functions
function saveTodos() {
    const dataToSave = {
        todos: todos,
        nextId: nextId,
        savedBy: 'Kheni Urval (24CE055)',
        lastSaved: new Date().toISOString()
    };
    
    localStorage.setItem('todoApp_24CE055', JSON.stringify(dataToSave));
}

function loadTodos() {
    const saved = localStorage.getItem('todoApp_24CE055');
    
    if (saved) {
        try {
            const data = JSON.parse(saved);
            todos = data.todos || [];
            nextId = data.nextId || 1;
            
            console.log('Todos loaded from localStorage');
        } catch (error) {
            console.error('Error loading todos:', error);
            todos = [];
            nextId = 1;
        }
    }
}

// Utility function to escape HTML
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Auto-save functionality
setInterval(() => {
    if (todos.length > 0) {
        saveTodos();
    }
}, 30000); // Auto-save every 30 seconds

// Handle page unload
window.addEventListener('beforeunload', () => {
    saveTodos();
    console.log('Todos saved before page unload');
});

console.log('Todo App loaded successfully - Created by Kheni Urval (24CE055)');

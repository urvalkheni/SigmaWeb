/**
 * Events Renderer - JSON Data Display System
 * Student: Kheni Urval (24CE055)
 * Assignment 07: JSON Events Renderer
 * Course: WDF: ITUE203
 * Medium-Level Implementation
 */

class EventsRenderer {
    constructor() {
        this.events = [];
        this.currentFilter = 'all';
        this.currentSort = 'date';
        this.init();
    }

    /**
     * Initialize the events renderer
     */
    async init() {
        try {
            await this.loadEvents();
            this.setupEventListeners();
            this.renderEvents();
            console.log('Events Renderer initialized by Kheni Urval (24CE055)');
        } catch (error) {
            console.error('Failed to initialize events renderer:', error);
            this.showError('Failed to load events data');
        }
    }

    /**
     * Load events from JSON file
     */
    async loadEvents() {
        try {
            const response = await fetch('events.json');
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            this.events = await response.json();
            console.log(`Loaded ${this.events.length} events successfully`);
        } catch (error) {
            console.error('Error loading events:', error);
            // Fallback to sample data for demonstration
            this.events = this.getSampleEvents();
        }
    }

    /**
     * Get sample events data as fallback
     */
    getSampleEvents() {
        return [
            {
                id: 1,
                title: "Web Development Workshop",
                description: "Learn modern web development techniques",
                date: "2025-01-15",
                time: "09:00",
                location: "Computer Lab A",
                category: "workshop",
                organizer: "Kheni Urval (24CE055)",
                attendees: 25
            }
        ];
    }

    /**
     * Setup event listeners for UI interactions
     */
    setupEventListeners() {
        // Filter buttons
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                this.setFilter(e.target.dataset.filter);
            });
        });

        // Sort dropdown
        const sortSelect = document.getElementById('sortSelect');
        if (sortSelect) {
            sortSelect.addEventListener('change', (e) => {
                this.setSortOrder(e.target.value);
            });
        }

        // Search input
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                this.searchEvents(e.target.value);
            });
        }

        // Refresh button
        const refreshBtn = document.getElementById('refreshBtn');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', () => {
                this.refreshEvents();
            });
        }
    }

    /**
     * Set current filter
     */
    setFilter(filter) {
        this.currentFilter = filter;
        
        // Update active filter button
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        document.querySelector(`[data-filter="${filter}"]`).classList.add('active');
        
        this.renderEvents();
        console.log(`Filter set to: ${filter}`);
    }

    /**
     * Set sort order
     */
    setSortOrder(sortBy) {
        this.currentSort = sortBy;
        this.renderEvents();
        console.log(`Sort order set to: ${sortBy}`);
    }

    /**
     * Search events by title or description
     */
    searchEvents(query) {
        const filtered = this.getFilteredEvents().filter(event => {
            const searchText = query.toLowerCase();
            return event.title.toLowerCase().includes(searchText) ||
                   event.description.toLowerCase().includes(searchText) ||
                   event.organizer.toLowerCase().includes(searchText);
        });
        
        this.displayEvents(filtered);
        this.updateEventCount(filtered.length);
    }

    /**
     * Get filtered events based on current filter
     */
    getFilteredEvents() {
        if (this.currentFilter === 'all') {
            return this.events;
        }
        return this.events.filter(event => event.category === this.currentFilter);
    }

    /**
     * Get sorted events
     */
    getSortedEvents(events) {
        const sortedEvents = [...events];
        
        switch (this.currentSort) {
            case 'date':
                return sortedEvents.sort((a, b) => new Date(a.date) - new Date(b.date));
            case 'title':
                return sortedEvents.sort((a, b) => a.title.localeCompare(b.title));
            case 'category':
                return sortedEvents.sort((a, b) => a.category.localeCompare(b.category));
            case 'attendees':
                return sortedEvents.sort((a, b) => b.attendees - a.attendees);
            default:
                return sortedEvents;
        }
    }

    /**
     * Render events to the page
     */
    renderEvents() {
        const filtered = this.getFilteredEvents();
        const sorted = this.getSortedEvents(filtered);
        this.displayEvents(sorted);
        this.updateEventCount(sorted.length);
        this.renderEventsByMonth(sorted);
    }

    /**
     * Display events in the main container
     */
    displayEvents(events) {
        const container = document.getElementById('eventsContainer');
        if (!container) return;

        if (events.length === 0) {
            container.innerHTML = `
                <div class="no-events">
                    <h3>No Events Found</h3>
                    <p>No events match your current filter criteria.</p>
                </div>
            `;
            return;
        }

        container.innerHTML = events.map(event => this.createEventCard(event)).join('');
        
        // Add click listeners to event cards
        container.querySelectorAll('.event-card').forEach(card => {
            card.addEventListener('click', (e) => {
                const eventId = parseInt(e.currentTarget.dataset.eventId);
                this.showEventDetails(eventId);
            });
        });
    }

    /**
     * Create HTML for an event card
     */
    createEventCard(event) {
        const eventDate = new Date(event.date);
        const formattedDate = this.formatDate(eventDate);
        const dayOfWeek = eventDate.toLocaleDateString('en-US', { weekday: 'long' });
        
        return `
            <div class="event-card ${event.category}" data-event-id="${event.id}">
                <div class="event-date">
                    <span class="day">${eventDate.getDate()}</span>
                    <span class="month">${eventDate.toLocaleDateString('en-US', { month: 'short' })}</span>
                    <span class="weekday">${dayOfWeek}</span>
                </div>
                <div class="event-content">
                    <div class="event-header">
                        <h3 class="event-title">${event.title}</h3>
                        <span class="event-category ${event.category}">${this.capitalizeFirst(event.category)}</span>
                    </div>
                    <p class="event-description">${event.description}</p>
                    <div class="event-details">
                        <div class="event-info">
                            <span class="info-item">
                                <i class="icon">🕒</i>
                                ${event.time}
                            </span>
                            <span class="info-item">
                                <i class="icon">📍</i>
                                ${event.location}
                            </span>
                            <span class="info-item">
                                <i class="icon">👥</i>
                                ${event.attendees} attendees
                            </span>
                        </div>
                        <div class="event-organizer">
                            Organized by: ${event.organizer}
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    /**
     * Render events grouped by month
     */
    renderEventsByMonth(events) {
        const monthContainer = document.getElementById('monthlyView');
        if (!monthContainer) return;

        const eventsByMonth = this.groupEventsByMonth(events);
        
        monthContainer.innerHTML = Object.keys(eventsByMonth)
            .sort()
            .map(month => {
                const monthEvents = eventsByMonth[month];
                return `
                    <div class="month-group">
                        <h3 class="month-title">${this.formatMonthYear(month)}</h3>
                        <div class="month-events">
                            ${monthEvents.map(event => `
                                <div class="month-event ${event.category}">
                                    <span class="event-date">${this.formatDate(new Date(event.date))}</span>
                                    <span class="event-title">${event.title}</span>
                                    <span class="event-category">${this.capitalizeFirst(event.category)}</span>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
            }).join('');
    }

    /**
     * Group events by month
     */
    groupEventsByMonth(events) {
        return events.reduce((groups, event) => {
            const date = new Date(event.date);
            const monthKey = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`;
            
            if (!groups[monthKey]) {
                groups[monthKey] = [];
            }
            groups[monthKey].push(event);
            
            return groups;
        }, {});
    }

    /**
     * Show detailed view of an event
     */
    showEventDetails(eventId) {
        const event = this.events.find(e => e.id === eventId);
        if (!event) return;

        const modal = document.getElementById('eventModal');
        const modalContent = document.getElementById('modalContent');
        
        if (!modal || !modalContent) return;

        modalContent.innerHTML = `
            <div class="modal-header">
                <h2>${event.title}</h2>
                <span class="close-modal">&times;</span>
            </div>
            <div class="modal-body">
                <div class="event-detail-info">
                    <p><strong>Date:</strong> ${this.formatDate(new Date(event.date))}</p>
                    <p><strong>Time:</strong> ${event.time}</p>
                    <p><strong>Location:</strong> ${event.location}</p>
                    <p><strong>Category:</strong> ${this.capitalizeFirst(event.category)}</p>
                    <p><strong>Organizer:</strong> ${event.organizer}</p>
                    <p><strong>Expected Attendees:</strong> ${event.attendees}</p>
                </div>
                <div class="event-description-full">
                    <h4>Description</h4>
                    <p>${event.description}</p>
                </div>
            </div>
        `;

        modal.style.display = 'block';

        // Close modal listeners
        const closeBtn = modal.querySelector('.close-modal');
        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    }

    /**
     * Update event count display
     */
    updateEventCount(count) {
        const countElement = document.getElementById('eventCount');
        if (countElement) {
            countElement.textContent = `${count} event${count !== 1 ? 's' : ''} found`;
        }
    }

    /**
     * Refresh events data
     */
    async refreshEvents() {
        const refreshBtn = document.getElementById('refreshBtn');
        if (refreshBtn) {
            refreshBtn.disabled = true;
            refreshBtn.textContent = 'Refreshing...';
        }

        try {
            await this.loadEvents();
            this.renderEvents();
            console.log('Events refreshed successfully');
        } catch (error) {
            console.error('Failed to refresh events:', error);
            this.showError('Failed to refresh events');
        } finally {
            if (refreshBtn) {
                refreshBtn.disabled = false;
                refreshBtn.textContent = 'Refresh';
            }
        }
    }

    /**
     * Show error message
     */
    showError(message) {
        const container = document.getElementById('eventsContainer');
        if (container) {
            container.innerHTML = `
                <div class="error-message">
                    <h3>Error</h3>
                    <p>${message}</p>
                    <button onclick="location.reload()" class="retry-btn">Retry</button>
                </div>
            `;
        }
    }

    /**
     * Format date for display
     */
    formatDate(date) {
        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

    /**
     * Format month and year for grouping
     */
    formatMonthYear(monthKey) {
        const [year, month] = monthKey.split('-');
        const date = new Date(year, month - 1);
        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long'
        });
    }

    /**
     * Capitalize first letter
     */
    capitalizeFirst(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    /**
     * Get unique categories from events
     */
    getCategories() {
        const categories = [...new Set(this.events.map(event => event.category))];
        return categories.sort();
    }

    /**
     * Export events data
     */
    exportEvents() {
        const dataStr = JSON.stringify(this.events, null, 2);
        const dataBlob = new Blob([dataStr], { type: 'application/json' });
        const url = URL.createObjectURL(dataBlob);
        
        const link = document.createElement('a');
        link.href = url;
        link.download = 'events_export.json';
        link.click();
        
        URL.revokeObjectURL(url);
        console.log('Events exported successfully');
    }
}

// Initialize the events renderer when the page loads
document.addEventListener('DOMContentLoaded', () => {
    console.log('Initializing Events Renderer by Kheni Urval (24CE055)');
    window.eventsRenderer = new EventsRenderer();
});

// Export for Node.js if needed
if (typeof module !== 'undefined' && module.exports) {
    module.exports = EventsRenderer;
}

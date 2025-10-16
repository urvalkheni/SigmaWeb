// Assignment 5: Data Dashboard with Array Methods
// Student: Kheni Urval | ID: 24CE055 | Course: WDF: ITUE203

// Sample sales dataset
const salesData = [
    { id: 1, salesperson: 'John Smith', region: 'North', product: 'Laptop', amount: 1200, date: '2025-01-15' },
    { id: 2, salesperson: 'Sarah Johnson', region: 'South', product: 'Phone', amount: 800, date: '2025-01-16' },
    { id: 3, salesperson: 'Mike Wilson', region: 'East', product: 'Tablet', amount: 600, date: '2025-01-17' },
    { id: 4, salesperson: 'Emily Davis', region: 'West', product: 'Laptop', amount: 1500, date: '2025-01-18' },
    { id: 5, salesperson: 'John Smith', region: 'North', product: 'Phone', amount: 700, date: '2025-01-19' },
    { id: 6, salesperson: 'Sarah Johnson', region: 'South', product: 'Tablet', amount: 550, date: '2025-01-20' },
    { id: 7, salesperson: 'Mike Wilson', region: 'East', product: 'Laptop', amount: 1300, date: '2025-01-21' },
    { id: 8, salesperson: 'Emily Davis', region: 'West', product: 'Phone', amount: 900, date: '2025-01-22' },
    { id: 9, salesperson: 'David Brown', region: 'North', product: 'Tablet', amount: 650, date: '2025-01-23' },
    { id: 10, salesperson: 'Lisa Garcia', region: 'South', product: 'Laptop', amount: 1400, date: '2025-01-24' }
];

let currentData = [...salesData];

// DOM Elements
const totalRevenueEl = document.getElementById('total-revenue');
const avgSaleEl = document.getElementById('avg-sale');
const totalOrdersEl = document.getElementById('total-orders');
const topSalespersonEl = document.getElementById('top-salesperson');
const tableBody = document.getElementById('table-body');

// Initialize dashboard
document.addEventListener('DOMContentLoaded', () => {
    console.log('Dashboard initialized by Kheni Urval (24CE055)');
    calculateKPIs();
    renderTable();
});

// Calculate Key Performance Indicators using array methods
function calculateKPIs() {
    // Total Revenue using reduce
    const totalRevenue = currentData.reduce((sum, sale) => sum + sale.amount, 0);
    
    // Average Sale using reduce and length
    const avgSale = currentData.length > 0 ? totalRevenue / currentData.length : 0;
    
    // Total Orders (simply the length)
    const totalOrders = currentData.length;
    
    // Top Salesperson by total revenue using reduce and grouping
    const salesByPerson = currentData.reduce((acc, sale) => {
        if (!acc[sale.salesperson]) {
            acc[sale.salesperson] = 0;
        }
        acc[sale.salesperson] += sale.amount;
        return acc;
    }, {});
    
    const topSalesperson = Object.keys(salesByPerson).reduce((top, person) => {
        return salesByPerson[person] > salesByPerson[top] ? person : top;
    }, Object.keys(salesByPerson)[0] || 'None');
    
    // Update DOM
    totalRevenueEl.textContent = `$${totalRevenue.toLocaleString()}`;
    avgSaleEl.textContent = `$${Math.round(avgSale).toLocaleString()}`;
    totalOrdersEl.textContent = totalOrders.toLocaleString();
    topSalespersonEl.textContent = topSalesperson || 'None';
    
    console.log(`KPIs calculated by student 24CE055: Revenue: $${totalRevenue}, Average: $${avgSale.toFixed(2)}`);
}

// Render data table using map
function renderTable() {
    // Use map to create HTML for each row
    const tableHTML = currentData.map(sale => `
        <tr>
            <td>${sale.salesperson}</td>
            <td>${sale.region}</td>
            <td>${sale.product}</td>
            <td>$${sale.amount.toLocaleString()}</td>
            <td>${formatDate(sale.date)}</td>
        </tr>
    `).join('');
    
    tableBody.innerHTML = tableHTML;
}

// Format date for display
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

// Refresh data (reset to original)
function refreshData() {
    currentData = [...salesData];
    calculateKPIs();
    renderTable();
    console.log('Data refreshed by Kheni Urval (24CE055)');
}

// Sort by revenue using sort
function sortByRevenue() {
    currentData = currentData.sort((a, b) => b.amount - a.amount);
    renderTable();
    console.log('Data sorted by revenue (highest first)');
}

// Filter top performers (sales > $1000) using filter
function filterTopPerformers() {
    currentData = salesData.filter(sale => sale.amount > 1000);
    calculateKPIs();
    renderTable();
    console.log(`Filtered to ${currentData.length} top performers (>$1000)`);
}

// Additional utility functions using array methods

// Get sales by region using filter and reduce
function getSalesByRegion() {
    const regions = ['North', 'South', 'East', 'West'];
    
    return regions.map(region => {
        const regionSales = salesData.filter(sale => sale.region === region);
        const totalRevenue = regionSales.reduce((sum, sale) => sum + sale.amount, 0);
        
        return {
            region,
            totalSales: regionSales.length,
            totalRevenue,
            avgSale: regionSales.length > 0 ? totalRevenue / regionSales.length : 0
        };
    });
}

// Get product performance using groupBy-like functionality
function getProductPerformance() {
    const products = ['Laptop', 'Phone', 'Tablet'];
    
    return products.map(product => {
        const productSales = salesData.filter(sale => sale.product === product);
        const totalRevenue = productSales.reduce((sum, sale) => sum + sale.amount, 0);
        const avgPrice = productSales.length > 0 ? totalRevenue / productSales.length : 0;
        
        return {
            product,
            unitsSold: productSales.length,
            totalRevenue,
            avgPrice
        };
    }).sort((a, b) => b.totalRevenue - a.totalRevenue); // Sort by revenue
}

// Get monthly trends (if we had more data)
function getMonthlyTrends() {
    const monthlyData = salesData.reduce((acc, sale) => {
        const month = sale.date.substring(0, 7); // YYYY-MM
        
        if (!acc[month]) {
            acc[month] = {
                sales: 0,
                revenue: 0
            };
        }
        
        acc[month].sales++;
        acc[month].revenue += sale.amount;
        
        return acc;
    }, {});
    
    // Convert to array and sort by month
    return Object.entries(monthlyData)
        .map(([month, data]) => ({
            month,
            sales: data.sales,
            revenue: data.revenue,
            avgSale: data.revenue / data.sales
        }))
        .sort((a, b) => a.month.localeCompare(b.month));
}

// Advanced filtering function
function getTopNSalesperson(n = 3) {
    // Group by salesperson and calculate totals
    const salespersonStats = salesData.reduce((acc, sale) => {
        if (!acc[sale.salesperson]) {
            acc[sale.salesperson] = {
                name: sale.salesperson,
                totalSales: 0,
                totalRevenue: 0,
                transactions: []
            };
        }
        
        acc[sale.salesperson].totalSales++;
        acc[sale.salesperson].totalRevenue += sale.amount;
        acc[sale.salesperson].transactions.push(sale);
        
        return acc;
    }, {});
    
    // Convert to array, sort by revenue, and take top N
    return Object.values(salespersonStats)
        .map(person => ({
            ...person,
            avgSale: person.totalRevenue / person.totalSales
        }))
        .sort((a, b) => b.totalRevenue - a.totalRevenue)
        .slice(0, n);
}

// Console utilities for testing
console.log('=== Dashboard Analytics by Kheni Urval (24CE055) ===');
console.log('Sales by Region:', getSalesByRegion());
console.log('Product Performance:', getProductPerformance());
console.log('Monthly Trends:', getMonthlyTrends());
console.log('Top 3 Salespeople:', getTopNSalesperson(3));

// Export data function (bonus)
function exportData() {
    const dataToExport = {
        generatedBy: 'Kheni Urval (24CE055)',
        timestamp: new Date().toISOString(),
        summary: {
            totalRevenue: currentData.reduce((sum, sale) => sum + sale.amount, 0),
            totalOrders: currentData.length,
            avgSale: currentData.reduce((sum, sale) => sum + sale.amount, 0) / currentData.length
        },
        data: currentData
    };
    
    const blob = new Blob([JSON.stringify(dataToExport, null, 2)], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `sales_dashboard_24CE055_${new Date().toISOString().split('T')[0]}.json`;
    a.click();
    
    console.log('Data exported by student 24CE055');
}

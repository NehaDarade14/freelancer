
<div class="container gantt-container">
    <div class="gantt-header">
        <h2 class="gantt-title">Project Timeline</h2>
        <div class="gantt-controls">
            <button class="btn btn-sm btn-outline-secondary" onclick="gantt.changeViewMode('Day')">Day</button>
            <button class="btn btn-sm btn-outline-secondary" onclick="gantt.changeViewMode('Week')">Week</button>
            <button class="btn btn-sm btn-primary" onclick="gantt.changeViewMode('Month')">Month</button>
        </div>
    </div>
    <div id="gantt-chart"></div>
</div>

<link href="https://cdn.jsdelivr.net/npm/frappe-gantt@0.6.1/dist/frappe-gantt.min.css" rel="stylesheet">

<script>
// First load CSS, then JS, then initialize
function loadGantt() {
    return new Promise((resolve) => {
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/frappe-gantt@0.6.1/dist/frappe-gantt.min.js';
        script.onload = () => resolve();
        document.head.appendChild(script);
    });
}

async function initGantt() {
    try {
        await loadGantt();
        
        if (typeof Gantt === 'undefined') {
            throw new Error('Gantt library not loaded');
        }

        const tasks = {!! json_encode($projects) !!};
        const gantt = new Gantt("#gantt-chart", tasks, {
            view_mode: 'Month',
            date_format: 'YYYY-MM-DD',
            custom_popup_html: function(task) {
                return `
                    <div class="gantt-popup">
                        <h5>${task.name}</h5>
                        <p>Start: ${task.start}</p>
                        <p>End: ${task.end}</p>
                        <p>Progress: ${Math.round(task.progress * 100)}%</p>
                    </div>
                `;
            }
        });
    } catch (error) {
        console.error('Gantt initialization failed:', error);
        // Fallback UI or error message
        document.getElementById('gantt-chart').innerHTML = 
            '<div class="alert alert-danger">Failed to load Gantt chart. Please refresh the page.</div>';
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', initGantt);
</script>

<style>
.gantt-container {
    margin: 20px 0;
    padding: 15px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

#gantt-chart {
    width: 100%;
    min-height: 500px;
    overflow-x: auto;
}

.gantt-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.gantt-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
}

.gantt-controls {
    display: flex;
    gap: 10px;
}

.gantt-popup {
    padding: 15px;
    background: white;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    min-width: 250px;
}

.gantt-popup h5 {
    margin-top: 0;
    color: #2d3748;
}

@media (max-width: 768px) {
    .gantt-container {
        padding: 10px;
    }
    
    #gantt-chart {
        min-height: 400px;
    }
    
    .gantt-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}

.alert {
    padding: 15px;
    margin: 20px 0;
    border: 1px solid transparent;
    border-radius: 4px;
}
.alert-danger {
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
}
</style>

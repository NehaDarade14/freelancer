
<div class="container">
    <div class="kanban-board">
        @foreach($projects as $status => $statusProjects)
        <div class="kanban-column">
            <h3>{{ ucfirst($status) }}</h3>
            <div class="kanban-items" data-status="{{ $status }}">
                @foreach($statusProjects as $project)
                <div class="kanban-item" data-project-id="{{ $project->id }}">
                    <h4>{{ $project->title }}</h4>
                    <p>Due: {{ $project->deadline->format('M d, Y') }}</p>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ $project->progress }}%"></div>
                    </div>
                    <div class="team-members">
                        @if($project->team)
                            @foreach($project->team->members as $member)
                            <span class="badge bg-primary">{{ $member->name }}</span>
                            @endforeach
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
.kanban-board {
    display: flex;
    gap: 15px;
    padding: 20px;
}
.kanban-column {
    flex: 1;
    background: #f8f9fa;
    border-radius: 5px;
    padding: 15px;
}

.kanban-item {
    background: white;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 3px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    cursor: move;
}
</style>

<script>
function initKanban() {
    const kanbanItems = document.querySelectorAll('.kanban-item');
    const kanbanColumns = document.querySelectorAll('.kanban-items');

    kanbanItems.forEach(item => {
        item.draggable = true;
        
        item.addEventListener('dragstart', () => {
            item.classList.add('dragging');
        });

        item.addEventListener('dragend', () => {
            item.classList.remove('dragging');
        });
    });

    kanbanColumns.forEach(column => {
        column.addEventListener('dragover', e => {
            e.preventDefault();
            const draggingItem = document.querySelector('.dragging');
            if (draggingItem) {
                column.appendChild(draggingItem);
                
                // Update project status via AJAX
                const projectId = draggingItem.dataset.projectId;
                const newStatus = column.dataset.status;
                
                fetch(`/projects/trackingkanban/${projectId}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ status: newStatus })
                });
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', initKanban);
</script>
<?= $this->extend('layouts/internal') ?>

<?= $this->section('styles') ?>
<style>
    .kanban-board {
        display: flex;
        overflow-x: auto;
        padding-bottom: 20px;
        gap: 15px;
    }
    .kanban-column {
        flex: 0 0 300px;
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
    }
    .kanban-column-header {
        font-weight: bold;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #dee2e6;
    }
    .kanban-card {
        background-color: white;
        border-radius: 6px;
        padding: 15px;
        margin-bottom: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        cursor: move;
    }
    .kanban-card:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    .kanban-card .lead-value {
        font-size: 1.2em;
        font-weight: bold;
        color: #28a745;
    }
    .kanban-card .lead-info {
        font-size: 0.9em;
        color: #6c757d;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><?= esc($pipeline['name']) ?></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?= base_url('user/pipelines') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>
    </div>

    <?php if ($pipeline['description']): ?>
        <div class="mb-4 p-3 bg-light rounded">
            <h5>Descrição:</h5>
            <p class="mb-0"><?= esc($pipeline['description']) ?></p>
        </div>
    <?php endif; ?>

    <div class="kanban-board">
        <?php foreach ($leadsByStage as $stageData): ?>
            <div class="kanban-column" data-stage-id="<?= $stageData['stage']['id'] ?>">
                <div class="kanban-column-header">
                    <?= esc($stageData['stage']['name']) ?>
                    <span class="badge bg-secondary float-end"><?= count($stageData['leads']) ?></span>
                </div>
                <?php foreach ($stageData['leads'] as $lead): ?>
                    <div class="kanban-card" data-lead-id="<?= $lead['id'] ?>">
                        <h6 class="mb-1"><?= esc($lead['name']) ?></h6>
                        <?php if ($lead['company']): ?>
                            <div class="lead-info mb-1">
                                <i class="bi bi-building"></i> <?= esc($lead['company']) ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($lead['value'] > 0): ?>
                            <div class="lead-value mb-2">
                                R$ <?= number_format($lead['value'], 2, ',', '.') ?>
                            </div>
                        <?php endif; ?>
                        <div class="lead-info">
                            <i class="bi bi-clock"></i> <?= date('d/m/Y', strtotime($lead['created_at'])) ?>
                        </div>
                        <div class="mt-2">
                            <a href="<?= base_url('user/leads/edit/' . $lead['id']) ?>" 
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($stageData['leads'])): ?>
                    <p class="text-muted text-center">Nenhum lead neste estágio</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const columns = document.querySelectorAll('.kanban-column');
    
    columns.forEach(column => {
        new Sortable(column, {
            group: 'shared',
            animation: 150,
            ghostClass: 'blue-background-class',
            dragClass: 'dragging',
            onEnd: function(evt) {
                const leadId = evt.item.dataset.leadId;
                const newStageId = evt.to.dataset.stageId;
                
                // Fazer requisição AJAX para atualizar o estágio do lead
                fetch('/api/leads/' + leadId + '/move', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        stage_id: newStageId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Atualizar contadores
                        updateColumnCounts();
                    } else {
                        // Reverter se falhar
                        evt.from.insertBefore(evt.item, evt.from.children[evt.oldIndex]);
                        alert('Erro ao mover lead: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    evt.from.insertBefore(evt.item, evt.from.children[evt.oldIndex]);
                    alert('Erro ao mover lead');
                });
            }
        });
    });
});

function updateColumnCounts() {
    document.querySelectorAll('.kanban-column').forEach(column => {
        const count = column.querySelectorAll('.kanban-card').length;
        const badge = column.querySelector('.badge');
        if (badge) {
            badge.textContent = count;
        }
    });
}
</script>
<?= $this->endSection() ?>
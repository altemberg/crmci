<?= $this->extend('layouts/internal') ?>

<?= $this->section('page_content') ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Meus Pipelines</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if (!empty($pipelines)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Total de Leads</th>
                                <th>Criado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pipelines as $pipeline): ?>
                                <tr>
                                    <td><?= esc($pipeline['name']) ?></td>
                                    <td><?= esc($pipeline['description']) ?></td>
                                    <td>
                                        <?php
                                        $leadCount = model('LeadModel')
                                            ->where('pipeline_id', $pipeline['id'])
                                            ->where('user_id', session()->get('user')['id'])
                                            ->countAllResults();
                                        echo $leadCount;
                                        ?>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($pipeline['created_at'])) ?></td>
                                    <td>
                                        <a href="<?= base_url('user/pipelines/view/' . $pipeline['id']) ?>" 
                                           class="btn btn-sm btn-primary" title="Visualizar">
                                            <i class="bi bi-eye"></i> Visualizar
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center text-muted">Nenhum pipeline atribuído a você.</p>
            <?php endif; ?>
        </div>
    </div>
<?= $this->endSection() ?>
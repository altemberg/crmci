<?= $this->extend('layouts/internal') ?>

<?= $this->section('page_content') ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Meus Leads</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= base_url('user/leads/create') ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Novo Lead
                </a>
                <a href="<?= base_url('user/leads/export') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-download"></i> Exportar CSV
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if (!empty($leads)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Empresa</th>
                                <th>Valor</th>
                                <th>Pipeline</th>
                                <th>Estágio</th>
                                <th>Criado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($leads as $lead): ?>
                                <tr>
                                    <td><?= esc($lead['name']) ?></td>
                                    <td><?= esc($lead['email']) ?></td>
                                    <td><?= esc($lead['phone']) ?></td>
                                    <td><?= esc($lead['company']) ?></td>
                                    <td>R$ <?= number_format($lead['value'], 2, ',', '.') ?></td>
                                    <td><?= esc($lead['pipeline_name']) ?></td>
                                    <td><?= esc($lead['stage_name']) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($lead['created_at'])) ?></td>
                                    <td>
                                        <a href="<?= base_url('user/leads/edit/' . $lead['id']) ?>" 
                                           class="btn btn-sm btn-primary" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="<?= base_url('user/leads/delete/' . $lead['id']) ?>" 
                                           class="btn btn-sm btn-danger" 
                                           onclick="return confirm('Tem certeza que deseja excluir este lead?')"
                                           title="Excluir">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center text-muted">Nenhum lead cadastrado.</p>
            <?php endif; ?>
        </div>
    </div>
<?= $this->endSection() ?>
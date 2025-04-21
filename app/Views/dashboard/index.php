<?= $this->extend('layouts/internal') ?>

<?= $this->section('page_content') ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
    </div>

    <!-- Cards de Resumo -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total de Leads</h5>
                    <h2 class="card-text"><?= $total_leads ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total de Pipelines</h5>
                    <h2 class="card-text"><?= $total_pipelines ?></h2>
                </div>
            </div>
        </div>
        <?php if (session()->get('user')['role'] === 'admin'): ?>
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Total de Usuários</h5>
                    <h2 class="card-text"><?= $total_users ?></h2>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Leads Recentes -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Leads Recentes</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($recent_leads)): ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Valor</th>
                                <th>Criado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_leads as $lead): ?>
                                <tr>
                                    <td><?= esc($lead['name']) ?></td>
                                    <td><?= esc($lead['email']) ?></td>
                                    <td><?= esc($lead['phone']) ?></td>
                                    <td>R$ <?= number_format($lead['value'], 2, ',', '.') ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($lead['created_at'])) ?></td>
                                    <td>
                                        <a href="<?= base_url('user/leads/edit/' . $lead['id']) ?>" 
                                           class="btn btn-sm btn-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-muted">Nenhum lead cadastrado ainda.</p>
            <?php endif; ?>
        </div>
    </div>
<?= $this->endSection() ?>
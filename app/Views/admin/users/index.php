<?= $this->extend('layouts/internal') ?>

<?= $this->section('page_content') ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Gerenciar Usuários</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Novo Usuário
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if (!empty($users)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Tipo</th>
                                <th>Status</th>
                                <th>Criado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $user['id'] ?></td>
                                    <td><?= esc($user['name']) ?></td>
                                    <td><?= esc($user['email']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : 'info' ?>">
                                            <?= ucfirst($user['role']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $user['active'] ? 'success' : 'secondary' ?>">
                                            <?= $user['active'] ? 'Ativo' : 'Inativo' ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/users/edit/' . $user['id']) ?>" 
                                           class="btn btn-sm btn-primary" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <?php if ($user['id'] != 1): ?>
                                            <a href="<?= base_url('admin/users/delete/' . $user['id']) ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('Tem certeza que deseja excluir este usuário?')"
                                               title="Excluir">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-secondary" disabled title="Admin Principal">
                                                <i class="bi bi-lock"></i>
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center text-muted">Nenhum usuário cadastrado.</p>
            <?php endif; ?>
        </div>
    </div>
<?= $this->endSection() ?>
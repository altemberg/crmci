<?= $this->extend('layouts/internal') ?>

<?= $this->section('page_content') ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Gerenciar Pipelines</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?= base_url('admin/pipelines/create') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Novo Pipeline
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if (!empty($pipelines)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Usuário Atribuído</th>
                                <th>Estágios</th>
                                <th>Criado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pipelines as $pipeline): ?>
                                <tr>
                                    <td><?= $pipeline['id'] ?></td>
                                    <td><?= esc($pipeline['name']) ?></td>
                                    <td><?= esc($pipeline['description']) ?></td>
                                    <td>
                                        <?php if ($pipeline['user_id']): ?>
                                            <?php
                                            $user = model('UserModel')->find($pipeline['user_id']);
                                            echo $user ? esc($user['name']) : 'Usuário não encontrado';
                                            ?>
                                        <?php else: ?>
                                            <span class="text-muted">Nenhum</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($pipeline['stages']): ?>
                                            <small><?= esc($pipeline['stages']) ?></small>
                                        <?php else: ?>
                                            <span class="text-muted">Nenhum estágio</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($pipeline['created_at'])) ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/pipelines/edit/' . $pipeline['id']) ?>" 
                                           class="btn btn-sm btn-primary" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="<?= base_url('admin/pipelines/assign/' . $pipeline['id']) ?>" 
                                           class="btn btn-sm btn-info" title="Atribuir">
                                            <i class="bi bi-person-plus"></i>
                                        </a>
                                        <a href="<?= base_url('admin/pipelines/delete/' . $pipeline['id']) ?>" 
                                           class="btn btn-sm btn-danger" 
                                           onclick="return confirm('Tem certeza que deseja excluir este pipeline?')"
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
                <p class="text-center text-muted">Nenhum pipeline cadastrado.</p>
            <?php endif; ?>
        </div>
    </div>
<?= $this->endSection() ?>
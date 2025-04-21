<?= $this->extend('layouts/internal') ?>

<?= $this->section('page_content') ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Atribuir Pipeline</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?= base_url('admin/pipelines') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <h5 class="card-title mb-4">Pipeline: <?= esc($pipeline['name']) ?></h5>
            
            <?= form_open('admin/pipelines/assign/' . $pipeline['id']) ?>
                <div class="mb-3">
                    <label for="user_id" class="form-label">Selecione o Usuário</label>
                    <select class="form-select" id="user_id" name="user_id" required>
                        <option value="">Selecione um usuário</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user['id'] ?>" <?= ($pipeline['user_id'] == $user['id']) ? 'selected' : '' ?>>
                                <?= esc($user['name']) ?> (<?= $user['role'] ?>)
                                <?php if ($pipeline['user_id'] == $user['id']): ?>
                                    - Atribuído Atualmente
                                <?php endif; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Atribuir Pipeline</button>
            <?= form_close() ?>
        </div>
    </div>
<?= $this->endSection() ?>
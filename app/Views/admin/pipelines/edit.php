<?= $this->extend('layouts/internal') ?>

<?= $this->section('page_content') ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Editar Pipeline</h1>
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

            <?= form_open('admin/pipelines/edit/' . $pipeline['id']) ?>
                <div class="mb-3">
                    <label for="name" class="form-label">Nome do Pipeline</label>
                    <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('name')) ? 'is-invalid' : '' ?>" 
                           id="name" name="name" value="<?= old('name', $pipeline['name']) ?>" required>
                    <?php if (isset($validation) && $validation->hasError('name')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('name') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Descrição</label>
                    <textarea class="form-control <?= (isset($validation) && $validation->hasError('description')) ? 'is-invalid' : '' ?>" 
                              id="description" name="description" rows="3"><?= old('description', $pipeline['description']) ?></textarea>
                    <?php if (isset($validation) && $validation->hasError('description')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('description') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="user_id" class="form-label">Atribuir a Usuário (opcional)</label>
                    <select class="form-select <?= (isset($validation) && $validation->hasError('user_id')) ? 'is-invalid' : '' ?>" 
                            id="user_id" name="user_id">
                        <option value="">Selecione um usuário (opcional)</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user['id'] ?>" <?= (old('user_id', $pipeline['user_id']) == $user['id']) ? 'selected' : '' ?>>
                                <?= esc($user['name']) ?> (<?= $user['role'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($validation) && $validation->hasError('user_id')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('user_id') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary">Atualizar Pipeline</button>
            <?= form_close() ?>
        </div>
    </div>
<?= $this->endSection() ?>
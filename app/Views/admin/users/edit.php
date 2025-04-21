<?= $this->extend('layouts/internal') ?>

<?= $this->section('page_content') ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Editar Usuário</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">
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

            <?= form_open('admin/users/edit/' . $user['id']) ?>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('name')) ? 'is-invalid' : '' ?>" 
                               id="name" name="name" value="<?= old('name', $user['name']) ?>" required>
                        <?php if (isset($validation) && $validation->hasError('name')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('name') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control <?= (isset($validation) && $validation->hasError('email')) ? 'is-invalid' : '' ?>" 
                               id="email" name="email" value="<?= old('email', $user['email']) ?>" required>
                        <?php if (isset($validation) && $validation->hasError('email')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('email') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Nova Senha (deixe em branco para manter a atual)</label>
                        <input type="password" class="form-control <?= (isset($validation) && $validation->hasError('password')) ? 'is-invalid' : '' ?>" 
                               id="password" name="password">
                        <?php if (isset($validation) && $validation->hasError('password')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('password') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="role" class="form-label">Tipo de Usuário</label>
                        <select class="form-select <?= (isset($validation) && $validation->hasError('role')) ? 'is-invalid' : '' ?>" 
                                id="role" name="role" required <?= $user['id'] == 1 ? 'disabled' : '' ?>>
                            <option value="user" <?= (old('role', $user['role']) === 'user') ? 'selected' : '' ?>>Usuário</option>
                            <option value="admin" <?= (old('role', $user['role']) === 'admin') ? 'selected' : '' ?>>Administrador</option>
                        </select>
                        <?php if ($user['id'] == 1): ?>
                            <input type="hidden" name="role" value="admin">
                            <small class="text-muted">O usuário principal não pode mudar de tipo.</small>
                        <?php endif; ?>
                        <?php if (isset($validation) && $validation->hasError('role')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('role') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Atualizar Usuário</button>
            <?= form_close() ?>
        </div>
    </div>
<?= $this->endSection() ?>
<?= $this->extend('layouts/internal') ?>

<?= $this->section('page_content') ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Editar Lead</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?= base_url('user/leads') ?>" class="btn btn-secondary">
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

            <?= form_open('user/leads/edit/' . $lead['id']) ?>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('name')) ? 'is-invalid' : '' ?>" 
                               id="name" name="name" value="<?= old('name', $lead['name']) ?>" required>
                        <?php if (isset($validation) && $validation->hasError('name')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('name') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control <?= (isset($validation) && $validation->hasError('email')) ? 'is-invalid' : '' ?>" 
                               id="email" name="email" value="<?= old('email', $lead['email']) ?>">
                        <?php if (isset($validation) && $validation->hasError('email')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('email') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Telefone</label>
                        <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('phone')) ? 'is-invalid' : '' ?>" 
                               id="phone" name="phone" value="<?= old('phone', $lead['phone']) ?>">
                        <?php if (isset($validation) && $validation->hasError('phone')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('phone') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="company" class="form-label">Empresa</label>
                        <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('company')) ? 'is-invalid' : '' ?>" 
                               id="company" name="company" value="<?= old('company', $lead['company']) ?>">
                        <?php if (isset($validation) && $validation->hasError('company')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('company') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="value" class="form-label">Valor</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('value')) ? 'is-invalid' : '' ?>" 
                                   id="value" name="value" value="<?= old('value', $lead['value']) ?>">
                        </div>
                        <?php if (isset($validation) && $validation->hasError('value')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('value') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="pipeline_id" class="form-label">Pipeline</label>
                        <select class="form-select <?= (isset($validation) && $validation->hasError('pipeline_id')) ? 'is-invalid' : '' ?>" 
                                id="pipeline_id" name="pipeline_id" required>
                            <option value="">Selecione um pipeline</option>
                            <?php foreach ($pipelines as $pipeline): ?>
                                <option value="<?= $pipeline['id'] ?>" <?= (old('pipeline_id', $lead['pipeline_id']) == $pipeline['id']) ? 'selected' : '' ?>>
                                    <?= esc($pipeline['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($validation) && $validation->hasError('pipeline_id')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('pipeline_id') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="stage_id" class="form-label">Estágio</label>
                        <select class="form-select <?= (isset($validation) && $validation->hasError('stage_id')) ? 'is-invalid' : '' ?>" 
                                id="stage_id" name="stage_id" required>
                            <option value="">Selecione um estágio</option>
                            <?php foreach ($stages as $stage): ?>
                                <option value="<?= $stage['id'] ?>" <?= (old('stage_id', $lead['stage_id']) == $stage['id']) ? 'selected' : '' ?>>
                                    <?= esc($stage['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($validation) && $validation->hasError('stage_id')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('stage_id') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">Notas</label>
                    <textarea class="form-control <?= (isset($validation) && $validation->hasError('notes')) ? 'is-invalid' : '' ?>" 
                              id="notes" name="notes" rows="3"><?= old('notes', $lead['notes']) ?></textarea>
                    <?php if (isset($validation) && $validation->hasError('notes')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('notes') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary">Atualizar Lead</button>
            <?= form_close() ?>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Atualizar estágios quando pipeline mudar
document.getElementById('pipeline_id').addEventListener('change', function() {
    const pipelineId = this.value;
    const stageSelect = document.getElementById('stage_id');
    
    if (pipelineId) {
        fetch(`/api/pipelines/${pipelineId}/stages`)
            .then(response => response.json())
            .then(stages => {
                stageSelect.innerHTML = '<option value="">Selecione um estágio</option>';
                stages.forEach(stage => {
                    const option = document.createElement('option');
                    option.value = stage.id;
                    option.textContent = stage.name;
                    stageSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Erro ao carregar estágios:', error));
    } else {
        stageSelect.innerHTML = '<option value="">Selecione um estágio</option>';
    }
});
</script>
<?= $this->endSection() ?>
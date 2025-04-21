<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>
    <?php $session = session(); ?>
    <?php $currentUser = $session->get('user'); ?>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url('dashboard') ?>">CRM System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> <?= esc($currentUser['name']) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= base_url('profile') ?>">Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= base_url('logout') ?>">Sair</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?= current_url() == base_url('dashboard') ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    
                    <?php if ($currentUser['role'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(current_url(), '/admin/users') !== false ? 'active' : '' ?>" href="<?= base_url('admin/users') ?>">
                            <i class="bi bi-people"></i> Usuários
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(current_url(), '/admin/pipelines') !== false ? 'active' : '' ?>" href="<?= base_url('admin/pipelines') ?>">
                            <i class="bi bi-diagram-3"></i> Pipelines
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(current_url(), '/admin/leads') !== false ? 'active' : '' ?>" href="<?= base_url('admin/leads') ?>">
                            <i class="bi bi-person-lines-fill"></i> Todos os Leads
                        </a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(current_url(), '/user/pipelines') !== false ? 'active' : '' ?>" href="<?= base_url('user/pipelines') ?>">
                            <i class="bi bi-diagram-3"></i> Meus Pipelines
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(current_url(), '/user/leads') !== false ? 'active' : '' ?>" href="<?= base_url('user/leads') ?>">
                            <i class="bi bi-person-lines-fill"></i> Meus Leads
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?= $this->renderSection('page_content') ?>
            </main>
        </div>
    </div>

    <footer class="footer mt-auto py-3 bg-light">
        <div class="container text-center">
            <span class="text-muted">CRM System &copy; <?= date('Y') ?> - Todos os direitos reservados</span>
        </div>
    </footer>
<?= $this->endSection() ?>
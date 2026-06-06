<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Dashboard'); ?> | AppointmentScheduler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 255px;
            --primary: #0ea5e9;
            --primary-dark: #0284c7;
            --sidebar-bg: #0f172a;
            --sidebar-text: #94a3b8;
            --sidebar-active: #0ea5e9;
        }
        body { font-family: 'Nunito', sans-serif; background: #f1f5f9; }

        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            z-index: 1000;
            transition: all .3s;
        }
        #sidebar .sidebar-brand {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        #sidebar .sidebar-brand h4 { color: #fff; font-weight: 800; margin: 0; font-size: 1.1rem; }
        #sidebar .sidebar-brand small { color: var(--sidebar-text); font-size: .72rem; }
        #sidebar .nav-link {
            color: var(--sidebar-text);
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-radius: 8px;
            margin: 2px 10px;
            font-size: .88rem;
            transition: all .2s;
        }
        #sidebar .nav-link:hover, #sidebar .nav-link.active {
            background: var(--sidebar-active);
            color: #fff;
        }
        #sidebar .nav-link i { font-size: 1.1rem; width: 20px; }
        #sidebar .sidebar-section {
            font-size: .68rem;
            font-weight: 700;
            color: rgba(255,255,255,.3);
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 15px 20px 5px;
        }
        #sidebar .user-info {
            position: absolute;
            bottom: 0; width: 100%;
            padding: 15px 20px;
            border-top: 1px solid rgba(255,255,255,.08);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        #sidebar .user-info img { width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 2px solid var(--primary); }
        #sidebar .user-info .user-name { color: #fff; font-size: .83rem; font-weight: 600; }
        #sidebar .user-info .user-role { color: var(--sidebar-text); font-size: .7rem; }

        #main-content { margin-left: var(--sidebar-width); min-height: 100vh; }
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky; top: 0;
            z-index: 900;
            box-shadow: 0 1px 3px rgba(0,0,0,.05);
        }
        .topbar .page-title { font-weight: 700; font-size: 1.1rem; color: #1e293b; margin: 0; }
        .content-wrapper { padding: 25px; }

        .card { border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.06); }
        .card-header { background: transparent; border-bottom: 1px solid #f1f5f9; font-weight: 700; padding: 15px 20px; }

        .stat-card { border-radius: 12px; padding: 20px; color: #fff; }
        .stat-card .stat-icon { font-size: 2.5rem; opacity: .8; }
        .stat-card .stat-number { font-size: 2rem; font-weight: 800; }
        .stat-card .stat-label { font-size: .85rem; opacity: .9; }

        .table thead th { background: #f8fafc; font-weight: 700; font-size: .8rem; text-transform: uppercase; letter-spacing: .5px; color: #64748b; border: none; }
        .table td { vertical-align: middle; font-size: .88rem; }
        .table tbody tr:hover { background: #f8fafc; }

        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }

        .toast-container { position: fixed; top: 20px; right: 20px; z-index: 9999; }
        .avatar-sm { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; }
        .badge { font-size: .75rem; padding: 5px 10px; }

        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #main-content { margin-left: 0; }
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

<nav id="sidebar">
    <div class="sidebar-brand">
        <h4><i class="bi bi-calendar-check-fill me-2" style="color:#38bdf8"></i>AppointEase</h4>
    </div>
    <div class="mt-3">
        <div class="sidebar-section">Main</div>
        <a href="<?php echo e(route('dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <div class="sidebar-section">Manage</div>
        <a href="<?php echo e(route('appointments.index')); ?>" class="nav-link <?php echo e(request()->routeIs('appointments.*') ? 'active' : ''); ?>">
            <i class="bi bi-calendar-plus"></i> My Appointments
        </a>
        <?php if(auth()->user()->role === 'admin'): ?>
        <a href="<?php echo e(route('users.index')); ?>" class="nav-link <?php echo e(request()->routeIs('users.*') ? 'active' : ''); ?>">
            <i class="bi bi-people"></i> Users Management
        </a>
        <?php endif; ?>
        <div class="sidebar-section">Account</div>
        <a href="<?php echo e(route('profile')); ?>" class="nav-link <?php echo e(request()->routeIs('profile') ? 'active' : ''); ?>">
            <i class="bi bi-person-circle"></i> My Profile
        </a>
        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start" style="color:#fca5a5;">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>

    <div class="user-info">
        <?php
            $avatarUrl = auth()->user()->avatar && auth()->user()->avatar !== 'default.png'
                ? asset('uploads/avatars/' . auth()->user()->avatar)
                : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=0ea5e9&color=fff';
        ?>
        <img src="<?php echo e($avatarUrl); ?>" alt="Avatar">
        <div>
            <div class="user-name"><?php echo e(Str::limit(auth()->user()->name, 18)); ?></div>
            <div class="user-role"><?php echo e(ucfirst(auth()->user()->role)); ?></div>
        </div>
    </div>
</nav>

<div id="main-content">
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm d-md-none" id="sidebarToggle"><i class="bi bi-list fs-5"></i></button>
            <h5 class="page-title"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h5>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="text-muted small d-none d-sm-inline"><?php echo e(now()->format('l, F j, Y')); ?></span>
            <a href="<?php echo e(route('profile')); ?>" class="d-flex align-items-center gap-2 text-decoration-none">
                <img src="<?php echo e($avatarUrl); ?>" class="avatar-sm" alt="Avatar">
                <span class="small fw-600 text-dark d-none d-sm-inline"><?php echo e(auth()->user()->name); ?></span>
            </a>
        </div>
    </div>

    <div class="toast-container">
        <?php if(session('toast_success')): ?>
        <div class="toast align-items-center text-bg-success border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body"><i class="bi bi-check-circle-fill me-2"></i><?php echo e(session('toast_success')); ?></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        <?php endif; ?>
        <?php if(session('toast_error')): ?>
        <div class="toast align-items-center text-bg-danger border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body"><i class="bi bi-x-circle-fill me-2"></i><?php echo e(session('toast_error')); ?></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="content-wrapper">
        <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-1">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('.toast').forEach(t => {
        setTimeout(() => bootstrap.Toast.getOrCreateInstance(t).hide(), 4000);
    });
    document.getElementById('sidebarToggle')?.addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('show');
    });
</script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\appointment-scheduler\resources\views/layouts/app.blade.php ENDPATH**/ ?>
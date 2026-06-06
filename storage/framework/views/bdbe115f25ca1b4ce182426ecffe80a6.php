<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-header">
    <div class="mb-2"><i class="bi bi-calendar-check-fill fs-1 text-white"></i></div>
    <h2>Welcome Back!</h2>
    <p>Sign in to your account</p>
</div>
<div class="auth-body">
    <?php if($errors->any()): ?>
    <div class="alert alert-danger py-2">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div><i class="bi bi-exclamation-circle me-1"></i><?php echo e($error); ?></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
    <form method="POST" action="<?php echo e(route('login')); ?>">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    placeholder="aljef@example.com" value="<?php echo e(old('email')); ?>" required autofocus>
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Your password" required>
            </div>
        </div>
        <div class="mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label small" for="remember">Remember me</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100 py-2">
            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
        </button>
    </form>
    <div class="text-center mt-3">
        <small class="text-muted">Don't have an account? <a href="<?php echo e(route('register')); ?>" class="fw-600 text-decoration-none">Register here</a></small>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\appointment-scheduler\resources\views/auth/login.blade.php ENDPATH**/ ?>
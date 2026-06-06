<?php $__env->startSection('title', 'My Profile'); ?>
<?php $__env->startSection('page-title', 'My Profile'); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card text-center">
            <div class="card-body py-4">
                <?php
                    $avatarUrl = $user->avatar && $user->avatar !== 'default.png'
                        ? asset('uploads/avatars/' . $user->avatar)
                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0ea5e9&color=fff&size=120';
                ?>
                <div class="position-relative d-inline-block mb-3">
                    <img id="avatarPreview" src="<?php echo e($avatarUrl); ?>" alt="Avatar"
                        style="width:110px;height:110px;border-radius:50%;object-fit:cover;border:4px solid #0ea5e9">
                    <label for="avatarInput" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                        style="width:30px;height:30px;cursor:pointer;">
                        <i class="bi bi-camera-fill" style="font-size:.8rem"></i>
                    </label>
                </div>
                <h5 class="mb-1 fw-700"><?php echo e($user->name); ?></h5>
                <p class="text-muted mb-2"><?php echo e($user->email); ?></p>
                <span class="badge bg-<?php echo e($user->role === 'admin' ? 'danger' : 'primary'); ?> mb-3"><?php echo e(ucfirst($user->role)); ?></span>
                <div class="border-top pt-3 text-start">
                    <div class="small text-muted mb-1"><i class="bi bi-calendar3 me-2"></i>Joined <?php echo e($user->created_at->format('F d, Y')); ?></div>
                    <?php if($user->phone): ?><div class="small text-muted mb-1"><i class="bi bi-telephone me-2"></i><?php echo e($user->phone); ?></div><?php endif; ?>
                    <?php if($user->gender): ?><div class="small text-muted mb-1"><i class="bi bi-gender-ambiguous me-2"></i><?php echo e($user->gender); ?></div><?php endif; ?>
                    <?php if($user->address): ?><div class="small text-muted"><i class="bi bi-geo-alt me-2"></i><?php echo e($user->address); ?></div><?php endif; ?>
                </div>
            </div>
        </div>
        <form method="POST" action="<?php echo e(route('profile.avatar')); ?>" enctype="multipart/form-data" id="avatarForm">
            <?php echo csrf_field(); ?>
            <input type="file" id="avatarInput" name="avatar" accept="image/*" class="d-none">
        </form>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><i class="bi bi-person-fill me-2 text-primary"></i>Edit Profile Information</div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('profile.update')); ?>">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-600">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('name', $user->name)); ?>" required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('email', $user->email)); ?>" required>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo e(old('phone', $user->phone)); ?>" placeholder="09xx-xxx-xxxx">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">-- Select --</option>
                                <?php $__currentLoopData = ['Male','Female','Other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($g); ?>" <?php echo e(old('gender', $user->gender) === $g ? 'selected' : ''); ?>><?php echo e($g); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Address</label>
                            <textarea name="address" class="form-control" rows="2"><?php echo e(old('address', $user->address)); ?></textarea>
                        </div>
                    </div>
                    <hr class="my-4">
                    <h6 class="fw-700 mb-3"><i class="bi bi-lock-fill me-2 text-primary"></i>Change Password <span class="text-muted fw-400 small">(leave blank to keep)</span></h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-600">Current Password</label>
                            <input type="password" name="current_password" class="form-control <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Current password">
                            <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-600">New Password</label>
                            <input type="password" name="password" class="form-control" placeholder="New password">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-600">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-2"></i>Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.getElementById('avatarInput').addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = e => { document.getElementById('avatarPreview').src = e.target.result; };
            reader.readAsDataURL(this.files[0]);
            document.getElementById('avatarForm').submit();
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\appointment-scheduler\resources\views/profile/index.blade.php ENDPATH**/ ?>
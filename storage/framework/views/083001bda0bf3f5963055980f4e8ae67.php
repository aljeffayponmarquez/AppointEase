<?php $__env->startSection('title', 'Users Management'); ?>
<?php $__env->startSection('page-title', 'Users Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-people-fill me-2 text-primary"></i>All Users</span>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="bi bi-plus-lg me-1"></i>Add User
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created Date</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($user->name)); ?>&background=0ea5e9&color=fff&size=32"
                                    class="avatar-sm" alt="Avatar">
                                <span class="fw-600"><?php echo e($user->name); ?></span>
                            </div>
                        </td>
                        <td class="text-muted"><?php echo e($user->email); ?></td>
                        <td><span class="badge bg-<?php echo e($user->role === 'admin' ? 'danger' : 'primary'); ?>"><?php echo e(ucfirst($user->role)); ?></span></td>
                        <td class="text-muted small"><?php echo e($user->created_at->format('M d, Y')); ?></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-warning me-1 btn-edit"
                                data-id="<?php echo e($user->id); ?>" data-name="<?php echo e($user->name); ?>"
                                data-email="<?php echo e($user->email); ?>" data-role="<?php echo e($user->role); ?>"
                                data-bs-toggle="modal" data-bs-target="#editUserModal">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger btn-delete"
                                data-id="<?php echo e($user->id); ?>" data-name="<?php echo e($user->name); ?>"
                                data-bs-toggle="modal" data-bs-target="#deleteUserModal">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" class="text-center text-muted py-5"><i class="bi bi-people fs-2 d-block mb-2"></i>No users found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($users->hasPages()): ?><div class="p-3"><?php echo e($users->links()); ?></div><?php endif; ?>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="<?php echo e(route('users.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-person-plus-fill me-2"></i>Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-600">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Min 8 characters" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Role <span class="text-danger">*</span></label>
                        <select name="role" class="form-select" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Save User</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" id="editUserForm">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil-fill me-2"></i>Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-600">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="edit_email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">New Password <span class="text-muted small">(leave blank to keep)</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Min 8 characters">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600">Role <span class="text-danger">*</span></label>
                        <select name="role" id="edit_role" class="form-select" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning"><i class="bi bi-save me-1"></i>Update User</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <form method="POST" id="deleteUserForm">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger"><i class="bi bi-trash-fill me-2"></i>Delete User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="bi bi-exclamation-triangle-fill text-warning fs-1"></i>
                    <p class="mt-2">Delete <strong id="delete_name"></strong>?</p>
                    <p class="text-muted small">This action cannot be undone.</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash me-1"></i>Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('edit_name').value  = this.dataset.name;
            document.getElementById('edit_email').value = this.dataset.email;
            document.getElementById('edit_role').value  = this.dataset.role;
            document.getElementById('editUserForm').action = `/users/${this.dataset.id}`;
        });
    });
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('delete_name').textContent = this.dataset.name;
            document.getElementById('deleteUserForm').action = `/users/${this.dataset.id}`;
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\appointment-scheduler\resources\views/users/index.blade.php ENDPATH**/ ?>
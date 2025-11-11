<?php require_once __DIR__ . '/../config/security.php'; ?>
<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php require_once __DIR__ . '/../config/csrf.php'; ?>
<?php require_login(['SuperAdmin', 'Admin']); ?>
<?php include __DIR__ . '/includes/admin-header.php'; ?>
<?php
$message = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $token = $_POST['csrf_token'] ?? '';
  if (!csrf_validate($token)) {
    $error = 'Invalid request.';
  } else {
    $action = $_POST['action'] ?? '';
    $current = current_user();
    try {
      $pdo = db();
    } catch (Throwable $e) {
      $pdo = null;
      $error = 'Database connection error.';
    }

    if ($pdo && $action === 'create_user') {
      $name = trim($_POST['name'] ?? '');
      $email = trim($_POST['email'] ?? '');
      $role = $_POST['role'] ?? 'Editor';
      $status = $_POST['status'] ?? 'active';
      $password = $_POST['password'] ?? '';
      $confirm = $_POST['confirm_password'] ?? '';
      if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please provide a valid name and email.';
      } elseif (!in_array($role, ['SuperAdmin', 'Admin', 'Editor'], true)) {
        $error = 'Invalid role.';
      } elseif ($role === 'SuperAdmin' && ($current['role'] ?? '') !== 'SuperAdmin') {
        $error = 'Only SuperAdmin can assign SuperAdmin role.';
      } elseif (!in_array($status, ['active', 'inactive'], true)) {
        $error = 'Invalid status.';
      } elseif ($password === '' || $password !== $confirm || strlen($password) < 8) {
        $error = 'Password must be at least 8 characters and match confirmation.';
      } else {
        try {
          $existsStmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
          $existsStmt->execute([$email]);
          if ((int)$existsStmt->fetchColumn() > 0) {
            $error = 'A user with that email already exists.';
          } else {
            $hash = password_hash_secure($password);
            $stmt = $pdo->prepare('INSERT INTO users (name, email, password_hash, role, status) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$name, $email, $hash, $role, $status]);
            audit_log($current['id'] ?? null, 'user_created');
            $message = 'User created successfully.';
          }
        } catch (Throwable $e) {
          $error = 'Could not create user.';
        }
      }
    }

    if ($pdo && $action === 'update_user') {
      $user_id = (int)($_POST['user_id'] ?? 0);
      $name = trim($_POST['name'] ?? '');
      $email = trim($_POST['email'] ?? '');
      $role = $_POST['role'] ?? 'Editor';
      $status = $_POST['status'] ?? 'active';
      $new_password = $_POST['password'] ?? '';
      $confirm = $_POST['confirm_password'] ?? '';

      if ($user_id <= 0) {
        $error = 'Invalid user.';
      } elseif ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please provide a valid name and email.';
      } elseif (!in_array($role, ['SuperAdmin', 'Admin', 'Editor'], true)) {
        $error = 'Invalid role.';
      } elseif ($role === 'SuperAdmin' && ($current['role'] ?? '') !== 'SuperAdmin') {
        $error = 'Only SuperAdmin can assign SuperAdmin role.';
      } elseif (!in_array($status, ['active', 'inactive'], true)) {
        $error = 'Invalid status.';
      } else {
        try {
          // Ensure email unique except for this user
          $existsStmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ? AND id <> ?');
          $existsStmt->execute([$email, $user_id]);
          if ((int)$existsStmt->fetchColumn() > 0) {
            $error = 'A user with that email already exists.';
          } else {
            // Update basic fields
            $stmt = $pdo->prepare('UPDATE users SET name = ?, email = ?, role = ?, status = ? WHERE id = ?');
            $stmt->execute([$name, $email, $role, $status, $user_id]);
            audit_log($current['id'] ?? null, 'user_updated');

            // Optional password update
            if ($new_password !== '') {
              if ($new_password !== $confirm || strlen($new_password) < 8) {
                $error = 'New password must be at least 8 characters and match confirmation.';
              } else {
                $hash = password_hash_secure($new_password);
                $pstmt = $pdo->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
                $pstmt->execute([$hash, $user_id]);
                audit_log($current['id'] ?? null, 'user_password_reset');
                if (!$message) {
                  $message = 'User updated. Password changed.';
                }
              }
            }

            if (!$error && !$message) {
              $message = 'User updated successfully.';
            }
          }
        } catch (Throwable $e) {
          $error = 'Could not update user.';
        }
      }
    }
  }
}

// Fetch users for listing and single user for edit
try {
  $pdo = isset($pdo) && $pdo ? $pdo : db();
  $users = $pdo->query('SELECT id, name, email, role, status FROM users ORDER BY role, name')->fetchAll();
  $editUser = null;
  $editId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
  if ($editId > 0) {
    $stmt = $pdo->prepare('SELECT id, name, email, role, status FROM users WHERE id = ?');
    $stmt->execute([$editId]);
    $editUser = $stmt->fetch();
  }
} catch (Throwable $e) {
  $users = [];
  $editUser = null;
}
?>

<div class="min-h-screen bg-gray-50/30">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">User Management</h1>
          <p class="mt-2 text-sm text-gray-600">Manage user accounts and permissions</p>
        </div>
        <a href="<?php echo url('admin/dashboard'); ?>"
          class="mt-4 sm:mt-0 inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-all duration-200">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M19 12H5M12 19l-7-7 7-7" class="icon-stroke" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          Back to Dashboard
        </a>
      </div>
    </div>

    <!-- Alert Messages -->
    <?php if ($message): ?>
      <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 flex items-center gap-3">
        <div class="w-3 h-3 rounded-full bg-green-500 animate-pulse"></div>
        <div class="text-green-700 font-medium"><?php echo esc_html($message); ?></div>
      </div>
    <?php endif; ?>
    <?php if ($error): ?>
      <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 flex items-center gap-3">
        <div class="w-3 h-3 rounded-full bg-red-500 animate-pulse"></div>
        <div class="text-red-700 font-medium"><?php echo esc_html($error); ?></div>
      </div>
    <?php endif; ?>

    <div class="grid lg:grid-cols-2 gap-8">
      <!-- User Form Section -->
      <div class="space-y-6">
        <!-- User Form Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
          <div class="px-6 py-4 border-b border-gray-200" style="background: <?php echo RCN_GRADIENT; ?>;">
            <h2 class="text-xl font-semibold text-white">
              <?php echo $editUser ? 'Edit User' : 'Add New User'; ?>
            </h2>
          </div>

          <form method="post" class="p-6 space-y-6">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="action"
              value="<?php echo $editUser ? 'update_user' : 'create_user'; ?>">
            <?php if ($editUser): ?>
              <input type="hidden" name="user_id" value="<?php echo (int)$editUser['id']; ?>">
            <?php endif; ?>

            <!-- Name & Email -->
            <div class="grid md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                <input name="name" type="text"
                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                  value="<?php echo $editUser ? esc_attr($editUser['name']) : ''; ?>"
                  placeholder="Enter full name" required>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input name="email" type="email"
                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                  value="<?php echo $editUser ? esc_attr($editUser['email']) : ''; ?>"
                  placeholder="user@example.com" required>
              </div>
            </div>

            <!-- Role & Status -->
            <div class="grid md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                <select name="role"
                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                  <option value="Editor"
                    <?php echo ($editUser['role'] ?? '') === 'Editor' ? 'selected' : ''; ?>>Editor
                  </option>
                  <option value="Admin"
                    <?php echo ($editUser['role'] ?? '') === 'Admin' ? 'selected' : ''; ?>>Admin
                  </option>
                  <?php if ((current_user()['role'] ?? '') === 'SuperAdmin'): ?>
                    <option value="SuperAdmin"
                      <?php echo ($editUser['role'] ?? '') === 'SuperAdmin' ? 'selected' : ''; ?>>
                      SuperAdmin</option>
                  <?php endif; ?>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status"
                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                  <option value="active"
                    <?php echo ($editUser['status'] ?? '') === 'active' ? 'selected' : ''; ?>>Active
                  </option>
                  <option value="inactive"
                    <?php echo ($editUser['status'] ?? '') === 'inactive' ? 'selected' : ''; ?>>
                    Inactive</option>
                </select>
              </div>
            </div>

            <!-- Password Fields -->
            <div class="grid md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  <?php echo $editUser ? 'New Password (optional)' : 'Initial Password'; ?>
                </label>
                <input name="password" type="password"
                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                  placeholder="<?php echo $editUser ? 'Leave blank to keep current' : 'Minimum 8 characters'; ?>"
                  <?php echo $editUser ? '' : 'required'; ?>>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  <?php echo $editUser ? 'Confirm New Password' : 'Confirm Password'; ?>
                </label>
                <input name="confirm_password" type="password"
                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                  placeholder="<?php echo $editUser ? 'Leave blank to keep current' : 'Confirm your password'; ?>"
                  <?php echo $editUser ? '' : 'required'; ?>>
              </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center gap-4 pt-6 border-t border-gray-200">
              <button type="submit"
                class="inline-flex items-center gap-2 px-8 py-3 rounded-xl text-white font-medium shadow-sm hover:shadow-md transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed"
                style="background: <?php echo RCN_GRADIENT; ?>;" id="submitBtn">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M5 13l4 4L19 7" class="icon-stroke" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <?php echo $editUser ? 'Update User' : 'Create User'; ?>
              </button>
              <?php if ($editUser): ?>
                <a href="<?php echo url('admin/users'); ?>"
                  class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-colors duration-200">
                  Cancel
                </a>
              <?php endif; ?>
            </div>
          </form>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-2 gap-4">
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 text-center">
            <div class="text-2xl font-bold text-gray-900"><?php echo count($users); ?></div>
            <div class="text-sm text-gray-500">Total Users</div>
          </div>
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 text-center">
            <div class="text-2xl font-bold text-gray-900">
              <?php echo count(array_filter($users, fn($u) => $u['status'] === 'active')); ?>
            </div>
            <div class="text-sm text-gray-500">Active Users</div>
          </div>
        </div>
      </div>

      <!-- Users List Section -->
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
          <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-900">All Users</h2>
            <span class="text-sm text-gray-500"><?php echo count($users); ?> users</span>
          </div>
        </div>

        <div class="p-6">
          <?php if (empty($users)): ?>
            <!-- Empty State -->
            <div class="text-center py-12">
              <svg class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                  d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
              </svg>
              <h3 class="text-lg font-medium text-gray-900 mb-2">No users found</h3>
              <p class="text-gray-500 mb-6">Get started by creating your first user account.</p>
            </div>
          <?php else: ?>
            <!-- Users Table -->
            <div class="overflow-hidden">
              <table class="w-full">
                <thead>
                  <tr class="text-left border-b border-gray-200">
                    <th class="pb-3 text-sm font-medium text-gray-500">User</th>
                    <th class="pb-3 text-sm font-medium text-gray-500">Role</th>
                    <th class="pb-3 text-sm font-medium text-gray-500">Status</th>
                    <th class="pb-3 text-sm font-medium text-gray-500 text-right">Actions</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                  <?php foreach ($users as $user): ?>
                    <tr
                      class="hover:bg-gray-50 transition-colors duration-150 <?php echo $editUser && $editUser['id'] === $user['id'] ? 'bg-blue-50' : ''; ?>">
                      <td class="py-4">
                        <div class="flex items-center gap-3">
                          <div
                            class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm">
                            <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                          </div>
                          <div>
                            <div class="font-medium text-gray-900">
                              <?php echo esc_html($user['name']); ?></div>
                            <div class="text-sm text-gray-500">
                              <?php echo esc_html($user['email']); ?></div>
                          </div>
                        </div>
                      </td>
                      <td class="py-4">
                        <span
                          class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                          <?php echo $user['role'] === 'SuperAdmin' ? 'bg-purple-100 text-purple-800' : ($user['role'] === 'Admin' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800'); ?>">
                          <?php echo esc_html($user['role']); ?>
                        </span>
                      </td>
                      <td class="py-4">
                        <span
                          class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                          <?php echo $user['status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                          <span
                            class="w-1.5 h-1.5 rounded-full mr-1.5 <?php echo $user['status'] === 'active' ? 'bg-green-400' : 'bg-red-400'; ?>"></span>
                          <?php echo ucfirst($user['status']); ?>
                        </span>
                      </td>
                      <td class="py-4 text-right">
                        <a href="<?php echo url('admin/users') . '?edit=' . (int)$user['id']; ?>"
                          class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-sm font-medium text-blue-600 hover:bg-blue-50 transition-colors duration-200">
                          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                              class="icon-stroke" stroke="currentColor" stroke-width="2"
                              stroke-linecap="round" stroke-linejoin="round" />
                          </svg>
                          Edit
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Form submission handling
  document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitBtn = document.getElementById('submitBtn');

    if (form && submitBtn) {
      form.addEventListener('submit', function() {
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-60', 'cursor-not-allowed');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML =
          '<svg class="h-5 w-5 animate-spin" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Saving...';
      });
    }
  });
</script>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
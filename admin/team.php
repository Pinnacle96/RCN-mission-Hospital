<?php
// Admin: Manage Leadership and Our Team members
require_once __DIR__ . '/includes/admin-header.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/csrf.php';

// Initialize session and database connection
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$pdo = db();

// Ensure uploads dir for team avatars exists
$team_upload_dir = __DIR__ . '/../uploads/team';
if (!is_dir($team_upload_dir)) {
  @mkdir($team_upload_dir, 0775, true);
}

function ensure_team_tables(PDO $pdo) {
  $pdo->exec("CREATE TABLE IF NOT EXISTS team_groups (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(64) UNIQUE NOT NULL,
    name VARCHAR(128) NOT NULL,
    description TEXT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    active TINYINT(1) NOT NULL DEFAULT 1
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

  $pdo->exec("CREATE TABLE IF NOT EXISTS team_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    group_id INT NOT NULL,
    name VARCHAR(128) NOT NULL,
    role_title VARCHAR(128) NULL,
    avatar_initials VARCHAR(4) NULL,
    avatar_image VARCHAR(255) NULL,
    bio TEXT NULL,
    twitter_url VARCHAR(255) NULL,
    facebook_url VARCHAR(255) NULL,
    linkedin_url VARCHAR(255) NULL,
    sort_order INT NOT NULL DEFAULT 0,
    active TINYINT(1) NOT NULL DEFAULT 1,
    CONSTRAINT fk_team_group FOREIGN KEY (group_id) REFERENCES team_groups(id) ON DELETE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

  // Seed default groups if missing
  $stmt = $pdo->prepare('SELECT COUNT(*) FROM team_groups WHERE slug IN ("leadership","medical")');
  try { $stmt->execute(); $count = (int) $stmt->fetchColumn(); } catch (Throwable $e) { $count = 0; }
  if ($count < 2) {
    $defaults = [
      ['slug' => 'leadership', 'name' => 'Leadership', 'sort_order' => 1],
      ['slug' => 'medical', 'name' => 'Medical Team', 'sort_order' => 2],
    ];
    foreach ($defaults as $g) {
      $ins = $pdo->prepare('INSERT IGNORE INTO team_groups (slug, name, sort_order, active) VALUES (?,?,?,1)');
      $ins->execute([$g['slug'], $g['name'], $g['sort_order']]);
    }
  }
}

function get_groups(PDO $pdo) {
  ensure_team_tables($pdo);
  $stmt = $pdo->query('SELECT * FROM team_groups ORDER BY sort_order, id');
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_members_by_group(PDO $pdo, int $group_id) {
  $stmt = $pdo->prepare('SELECT * FROM team_members WHERE group_id = ? ORDER BY sort_order, id');
  $stmt->execute([$group_id]);
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function normalize_slug($s) {
  $s = strtolower(trim($s));
  $s = preg_replace('/[^a-z0-9]+/', '-', $s);
  return trim($s, '-');
}

function handle_avatar_upload($current_avatar = null) {
  global $team_upload_dir;
  
  if (empty($_FILES['avatar']['name'])) {
    return $current_avatar;
  }

  $err = (int)($_FILES['avatar']['error'] ?? UPLOAD_ERR_NO_FILE);
  if ($err !== UPLOAD_ERR_OK) {
    throw new Exception('Avatar upload failed with error code: ' . $err);
  }

  // Validate file size
  $max_size = defined('MAX_UPLOAD_BYTES') ? MAX_UPLOAD_BYTES : 5 * 1024 * 1024; // 5MB default
  if ($_FILES['avatar']['size'] > $max_size) {
    throw new Exception('Avatar file exceeds size limit of ' . round($max_size / 1024 / 1024, 1) . 'MB');
  }

  // Validate file type
  $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
  $finfo = finfo_open(FILEINFO_MIME_TYPE);
  $mime_type = finfo_file($finfo, $_FILES['avatar']['tmp_name']);
  finfo_close($finfo);

  if (!in_array($mime_type, $allowed_types)) {
    throw new Exception('Invalid file type. Please upload JPEG, PNG, GIF, or WebP images only.');
  }

  // Generate safe filename
  $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
  $ext = preg_replace('/[^a-z0-9]/', '', $ext);
  $allowed_ext = ['jpg','jpeg','png','gif','webp'];
  if (!in_array($ext, $allowed_ext, true)) {
    $ext = 'jpg';
  }
  
  $safe_filename = 'team_' . time() . '_' . mt_rand(1000,9999) . '.' . $ext;
  $destination = $team_upload_dir . '/' . $safe_filename;

  // Move uploaded file
  if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $destination)) {
    throw new Exception('Failed to save uploaded avatar image.');
  }

  return 'uploads/team/' . $safe_filename;
}

$errors = [];
$notices = [];

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!csrf_validate($_POST['csrf_token'] ?? '')) {
    $errors[] = 'Invalid CSRF token. Please refresh and try again.';
  } else {
    $action = $_POST['action'] ?? '';
    try {
      ensure_team_tables($pdo);
      
      if ($action === 'group_create') {
        $name = trim($_POST['name'] ?? '');
        $slug = normalize_slug($_POST['slug'] ?? $name);
        $active = isset($_POST['active']) ? 1 : 0;
        if ($name === '' || $slug === '') { 
          throw new Exception('Group name and slug are required.'); 
        }
        $stmt = $pdo->prepare('INSERT INTO team_groups (slug, name, active) VALUES (?,?,?)');
        $stmt->execute([$slug, $name, $active]);
        $notices[] = 'Group created successfully.';
        
      } elseif ($action === 'group_update') {
        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $active = isset($_POST['active']) ? 1 : 0;
        $sort = (int)($_POST['sort_order'] ?? 0);
        if ($id <= 0 || $name === '') { 
          throw new Exception('Valid group and name required.'); 
        }
        $stmt = $pdo->prepare('UPDATE team_groups SET name=?, active=?, sort_order=? WHERE id=?');
        $stmt->execute([$name, $active, $sort, $id]);
        $notices[] = 'Group updated successfully.';
        
      } elseif ($action === 'member_create') {
        $group_id = (int)($_POST['group_id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $role = trim($_POST['role_title'] ?? '');
        $initials = trim($_POST['avatar_initials'] ?? '');
        $bio = trim($_POST['bio'] ?? '');
        $tw = trim($_POST['twitter_url'] ?? '');
        $fb = trim($_POST['facebook_url'] ?? '');
        $ln = trim($_POST['linkedin_url'] ?? '');
        $sort = (int)($_POST['sort_order'] ?? 0);
        
        if ($group_id <= 0 || $name === '') { 
          throw new Exception('Group and name are required.'); 
        }
        
        $avatar_image = handle_avatar_upload();
        
        $stmt = $pdo->prepare('INSERT INTO team_members (group_id, name, role_title, avatar_initials, avatar_image, bio, twitter_url, facebook_url, linkedin_url, sort_order, active) VALUES (?,?,?,?,?,?,?,?,?,?,1)');
        $stmt->execute([$group_id, $name, $role ?: null, $initials ?: null, $avatar_image, $bio ?: null, $tw ?: null, $fb ?: null, $ln ?: null, $sort]);
        $notices[] = 'Member added successfully.';
        
      } elseif ($action === 'member_update') {
        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $role = trim($_POST['role_title'] ?? '');
        $initials = trim($_POST['avatar_initials'] ?? '');
        $bio = trim($_POST['bio'] ?? '');
        $tw = trim($_POST['twitter_url'] ?? '');
        $fb = trim($_POST['facebook_url'] ?? '');
        $ln = trim($_POST['linkedin_url'] ?? '');
        $sort = (int)($_POST['sort_order'] ?? 0);
        $active = isset($_POST['active']) ? 1 : 0;
        
        if ($id <= 0 || $name === '') { 
          throw new Exception('Valid member and name required.'); 
        }
        
        $member = $pdo->prepare('SELECT * FROM team_members WHERE id=?');
        $member->execute([$id]);
        $current = $member->fetch(PDO::FETCH_ASSOC);
        if (!$current) throw new Exception('Member not found.');
        
        $avatar_image = handle_avatar_upload($current['avatar_image']);
        
        $stmt = $pdo->prepare('UPDATE team_members SET name=?, role_title=?, avatar_initials=?, avatar_image=?, bio=?, twitter_url=?, facebook_url=?, linkedin_url=?, sort_order=?, active=? WHERE id=?');
        $stmt->execute([$name, $role ?: null, $initials ?: null, $avatar_image, $bio ?: null, $tw ?: null, $fb ?: null, $ln ?: null, $sort, $active, $id]);
        $notices[] = 'Member updated successfully.';
        
      } elseif ($action === 'member_delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) throw new Exception('Valid member required.');
        
        // Get member to delete avatar file
        $member = $pdo->prepare('SELECT avatar_image FROM team_members WHERE id=?');
        $member->execute([$id]);
        $current = $member->fetch(PDO::FETCH_ASSOC);
        
        $stmt = $pdo->prepare('DELETE FROM team_members WHERE id=?');
        $stmt->execute([$id]);
        
        // Delete avatar file if exists
        if ($current && !empty($current['avatar_image']) && file_exists(__DIR__ . '/../' . $current['avatar_image'])) {
          @unlink(__DIR__ . '/../' . $current['avatar_image']);
        }
        
        $notices[] = 'Member deleted successfully.';
        
      } elseif ($action === 'member_reorder') {
        $orders = $_POST['sort_orders'] ?? [];
        foreach ($orders as $mid => $ord) {
          $stmt = $pdo->prepare('UPDATE team_members SET sort_order=? WHERE id=?');
          $stmt->execute([(int)$ord, (int)$mid]);
        }
        $notices[] = 'Member order updated successfully.';
      }
    } catch (Throwable $e) {
      $errors[] = $e->getMessage();
    }
  }
}

$groups = get_groups($pdo);
?>
<!-- Just the page-specific styles -->
<style>
  .avatar-preview {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #e5e7eb;
  }
  .drag-over {
    border-color: #3b82f6;
    background-color: #eff6ff;
  }
  .fade-in {
    animation: fadeIn 0.3s ease-in;
  }
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>

<!-- Main Content Area -->
<div class="max-w-7xl mx-auto">
  <!-- Page Header -->
  <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8">
    <div>
      <h1 class="text-3xl font-bold text-gray-900">Team Management</h1>
      <p class="text-gray-600 mt-2">Manage your team members and groups</p>
    </div>
    <a href="<?php echo url('about'); ?>" target="_blank" class="mt-4 lg:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
      <i class="fas fa-eye mr-2"></i>
      View About Page
    </a>
  </div>

  <!-- Notifications -->
  <?php if (!empty($errors)): ?>
    <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700 fade-in">
      <div class="flex items-center">
        <i class="fas fa-exclamation-circle mr-3"></i>
        <div>
          <strong class="font-semibold">Please fix the following errors:</strong>
          <ul class="mt-1 list-disc list-inside">
            <?php foreach ($errors as $err): ?>
              <li><?php echo htmlspecialchars($err); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  <?php endif; ?>
  
  <?php if (!empty($notices)): ?>
    <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700 fade-in">
      <div class="flex items-center">
        <i class="fas fa-check-circle mr-3"></i>
        <div>
          <strong class="font-semibold">Success!</strong>
          <ul class="mt-1">
            <?php foreach ($notices as $note): ?>
              <li><?php echo htmlspecialchars($note); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <!-- Groups Section -->
  <section class="mb-12">
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-xl font-semibold text-gray-900">Team Groups</h2>
      <span class="text-sm text-gray-500">Manage team categories</span>
    </div>

    <div class="grid lg:grid-cols-2 gap-8">
      <!-- Create Group Form -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Create New Group</h3>
        <form method="post" class="space-y-4">
          <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
          <input type="hidden" name="action" value="group_create">
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Group Name</label>
            <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., Leadership Team" required>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
            <input type="text" name="slug" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., leadership" required>
            <p class="text-xs text-gray-500 mt-1">Used for internal reference</p>
          </div>
          
          <div class="flex items-center">
            <input type="checkbox" name="active" id="active-group" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" checked>
            <label for="active-group" class="ml-2 text-sm text-gray-700">Active group</label>
          </div>
          
          <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
            <i class="fas fa-plus mr-2"></i>Create Group
          </button>
        </form>
      </div>

      <!-- Existing Groups -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Existing Groups</h3>
        <div class="space-y-4">
          <?php foreach ($groups as $g): ?>
            <form method="post" class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
              <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
              <input type="hidden" name="action" value="group_update">
              <input type="hidden" name="id" value="<?php echo (int)$g['id']; ?>">
              
              <div class="flex-1 min-w-0">
                <input type="text" name="name" value="<?php echo htmlspecialchars($g['name']); ?>" class="w-full px-3 py-1 border border-gray-300 rounded focus:ring-1 focus:ring-blue-500" required>
              </div>
              
              <input type="number" name="sort_order" value="<?php echo (int)$g['sort_order']; ?>" class="w-16 px-2 py-1 border border-gray-300 rounded text-center" title="Sort order">
              
              <label class="flex items-center">
                <input type="checkbox" name="active" <?php echo ((int)$g['active']===1?'checked':''); ?> class="h-4 w-4 text-blue-600">
              </label>
              
              <button type="submit" class="px-3 py-1 rounded bg-blue-600 text-white hover:bg-blue-700 transition-colors" title="Save">
                Save
              </button>
            </form>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>

  <!-- Members Section -->
  <section>
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-xl font-semibold text-gray-900">Team Members</h2>
      <span class="text-sm text-gray-500">Manage individual team members</span>
    </div>

    <?php foreach ($groups as $g): 
      $members = get_members_by_group($pdo, (int)$g['id']);
    ?>
      <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <!-- Group Header -->
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-lg font-semibold text-gray-900">
            <?php echo htmlspecialchars($g['name']); ?>
            <span class="text-sm font-normal text-gray-500 ml-2">(<?php echo count($members); ?> members)</span>
          </h3>
        </div>

        <!-- Members Table -->
        <?php if (!empty($members)): ?>
          <div class="overflow-x-auto mb-6">
            <table class="w-full text-sm">
              <thead class="bg-gray-50">
                <tr>
                  <th class="text-left p-3 font-medium text-gray-700">Member</th>
                  <th class="text-left p-3 font-medium text-gray-700">Role</th>
                  <th class="p-3 font-medium text-gray-700">Sort</th>
                  <th class="p-3 font-medium text-gray-700">Status</th>
                  <th class="p-3 font-medium text-gray-700">Actions</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <?php foreach ($members as $m): ?>
                  <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-3">
                      <div class="flex items-center gap-3">
                        <?php if (!empty($m['avatar_image'])): ?>
                          <img src="<?php echo url($m['avatar_image']); ?>" alt="<?php echo htmlspecialchars($m['name']); ?>" class="avatar-preview">
                        <?php else: ?>
                          <div class="avatar-preview bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-semibold text-lg">
                            <?php echo htmlspecialchars($m['avatar_initials'] ?: substr($m['name'], 0, 2)); ?>
                          </div>
                        <?php endif; ?>
                        <div>
                          <div class="font-medium text-gray-900"><?php echo htmlspecialchars($m['name']); ?></div>
                          <?php if (!empty($m['role_title'])): ?>
                            <div class="text-sm text-gray-500"><?php echo htmlspecialchars($m['role_title']); ?></div>
                          <?php endif; ?>
                        </div>
                      </div>
                    </td>
                    <td class="p-3 text-gray-600"><?php echo htmlspecialchars($m['role_title'] ?? '-'); ?></td>
                    <td class="p-3">
                      <input type="number" name="sort_orders[<?php echo (int)$m['id']; ?>]" 
                             value="<?php echo (int)$m['sort_order']; ?>" 
                             form="reorder-<?php echo (int)$g['id']; ?>"
                             class="w-16 px-2 py-1 border border-gray-300 rounded text-center">
                    </td>
                    <td class="p-3">
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo ((int)$m['active']===1 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'); ?>">
                        <?php echo ((int)$m['active']===1 ? 'Active' : 'Inactive'); ?>
                      </span>
                    </td>
                    <td class="p-3">
                      <div class="flex items-center gap-2">
                        <!-- Edit Button -->
                        <button type="button" 
                                onclick="openEditModal(<?php echo htmlspecialchars(json_encode($m)); ?>)" 
                                class="inline-flex items-center gap-2 px-3 py-1 rounded bg-blue-600 text-white hover:bg-blue-700 transition-colors"
                                title="Edit">
                          Edit
                        </button>
                        
                        <!-- Delete Form -->
                        <form method="post" class="inline" onsubmit="return confirm('Are you sure you want to delete this member?');">
                          <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                          <input type="hidden" name="action" value="member_delete">
                          <input type="hidden" name="id" value="<?php echo (int)$m['id']; ?>">
                          <button type="submit" class="inline-flex items-center gap-2 px-3 py-1 rounded bg-red-600 text-white hover:bg-red-700 transition-colors" title="Delete">
                            Delete
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

          <!-- Save Order Form -->
          <form id="reorder-<?php echo (int)$g['id']; ?>" method="post" class="text-right">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="action" value="member_reorder">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
              <i class="fas fa-sort mr-2"></i>Save Order
            </button>
          </form>
        <?php else: ?>
          <div class="text-center py-8 text-gray-500">
            <i class="fas fa-users text-4xl mb-4 text-gray-300"></i>
            <p>No members in this group yet.</p>
          </div>
        <?php endif; ?>

        <!-- Add Member Form -->
        <div class="mt-8 pt-6 border-t border-gray-200">
          <h4 class="text-lg font-semibold text-gray-900 mb-4">Add New Member</h4>
          <form method="post" enctype="multipart/form-data" class="grid md:grid-cols-2 gap-4">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="action" value="member_create">
            <input type="hidden" name="group_id" value="<?php echo (int)$g['id']; ?>">
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
              <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="John Doe" required>
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Role Title</label>
              <input type="text" name="role_title" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Medical Director">
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Avatar Initials</label>
              <input type="text" name="avatar_initials" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="JD" maxlength="2">
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Avatar Image</label>
              <input type="file" name="avatar" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
              <textarea name="bio" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Brief description..."></textarea>
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Twitter URL</label>
              <input type="url" name="twitter_url" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="https://twitter.com/username">
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Facebook URL</label>
              <input type="url" name="facebook_url" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="https://facebook.com/username">
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">LinkedIn URL</label>
              <input type="url" name="linkedin_url" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="https://linkedin.com/in/username">
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
              <input type="number" name="sort_order" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="0">
            </div>
            
            <div class="md:col-span-2 flex justify-end">
              <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                <i class="fas fa-user-plus mr-2"></i>Add Member
              </button>
            </div>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  </section>
</div>

<!-- Edit Member Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
  <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
    <div class="p-6">
      <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-semibold text-gray-900">Edit Team Member</h3>
        <button type="button" onclick="closeEditModal()" class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
          <i class="fas fa-times text-xl"></i>
        </button>
      </div>
      
      <form id="editMemberForm" method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
        <input type="hidden" name="action" value="member_update">
        <input type="hidden" name="id" id="edit_member_id">
        
        <div class="grid md:grid-cols-2 gap-4 mb-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
            <input type="text" name="name" id="edit_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Role Title</label>
            <input type="text" name="role_title" id="edit_role_title" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Avatar Initials</label>
            <input type="text" name="avatar_initials" id="edit_avatar_initials" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" maxlength="2">
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
            <input type="number" name="sort_order" id="edit_sort_order" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
          </div>
        </div>
        
        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700 mb-2">Current Avatar</label>
          <div id="currentAvatar" class="flex items-center gap-4 mb-4">
            <!-- Current avatar will be shown here -->
          </div>
          
          <label class="block text-sm font-medium text-gray-700 mb-2">Upload New Avatar</label>
          <input type="file" name="avatar" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
          <p class="text-xs text-gray-500 mt-1">Max file size: 5MB. Allowed formats: JPG, PNG, GIF, WebP</p>
        </div>
        
        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
          <textarea name="bio" id="edit_bio" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
        </div>
        
        <div class="grid md:grid-cols-3 gap-4 mb-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Twitter URL</label>
            <input type="url" name="twitter_url" id="edit_twitter_url" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Facebook URL</label>
            <input type="url" name="facebook_url" id="edit_facebook_url" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">LinkedIn URL</label>
            <input type="url" name="linkedin_url" id="edit_linkedin_url" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
          </div>
        </div>
        
        <div class="flex items-center justify-between">
          <label class="flex items-center">
            <input type="checkbox" name="active" id="edit_active" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
            <span class="ml-2 text-sm text-gray-700">Active member</span>
          </label>
          
          <div class="flex gap-3">
            <button type="button" onclick="closeEditModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
              Cancel
            </button>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
              Save Changes
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // Edit Modal Functions
  function openEditModal(member) {
    document.getElementById('edit_member_id').value = member.id;
    document.getElementById('edit_name').value = member.name;
    document.getElementById('edit_role_title').value = member.role_title || '';
    document.getElementById('edit_avatar_initials').value = member.avatar_initials || '';
    document.getElementById('edit_bio').value = member.bio || '';
    document.getElementById('edit_twitter_url').value = member.twitter_url || '';
    document.getElementById('edit_facebook_url').value = member.facebook_url || '';
    document.getElementById('edit_linkedin_url').value = member.linkedin_url || '';
    document.getElementById('edit_sort_order').value = member.sort_order;
    document.getElementById('edit_active').checked = member.active === 1;
    
    // Show current avatar
    const avatarContainer = document.getElementById('currentAvatar');
    if (member.avatar_image) {
      avatarContainer.innerHTML = `
        <img src="<?php echo url(''); ?>${member.avatar_image}" alt="${member.name}" class="avatar-preview">
        <span class="text-sm text-gray-600">Current avatar</span>
      `;
    } else {
      avatarContainer.innerHTML = `
        <div class="avatar-preview bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-semibold text-lg">
          ${member.avatar_initials || member.name.substring(0, 2)}
        </div>
        <span class="text-sm text-gray-600">No avatar uploaded</span>
      `;
    }
    
    document.getElementById('editModal').classList.remove('hidden');
  }
  
  function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
  }
  
  // Close modal on outside click
  document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) {
      closeEditModal();
    }
  });
</script>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>

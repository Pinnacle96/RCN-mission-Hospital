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
        if ($name === '' || $slug === '') { throw new Exception('Group name/slug is required.'); }
        $stmt = $pdo->prepare('INSERT INTO team_groups (slug, name, active) VALUES (?,?,?)');
        $stmt->execute([$slug, $name, $active]);
        $notices[] = 'Group created successfully.';
      } elseif ($action === 'group_update') {
        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $active = isset($_POST['active']) ? 1 : 0;
        $sort = (int)($_POST['sort_order'] ?? 0);
        if ($id <= 0 || $name === '') { throw new Exception('Valid group and name required.'); }
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
        if ($group_id <= 0 || $name === '') { throw new Exception('Group and name are required.'); }
        $avatar_image = null;
        if (isset($_FILES['avatar']) && is_uploaded_file($_FILES['avatar']['tmp_name'])) {
          $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
          $safe = 'team_' . time() . '_' . mt_rand(1000,9999) . '.' . preg_replace('/[^a-zA-Z0-9]+/', '', $ext);
          $dest = $team_upload_dir . '/' . $safe;
          if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $dest)) {
            throw new Exception('Failed to upload avatar image.');
          }
          $avatar_image = 'uploads/team/' . $safe;
        }
        $stmt = $pdo->prepare('INSERT INTO team_members (group_id, name, role_title, avatar_initials, avatar_image, bio, twitter_url, facebook_url, linkedin_url, sort_order, active) VALUES (?,?,?,?,?,?,?,?,?,?,1)');
        $stmt->execute([$group_id, $name, $role, $initials ?: null, $avatar_image, $bio ?: null, $tw ?: null, $fb ?: null, $ln ?: null, $sort]);
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
        if ($id <= 0 || $name === '') { throw new Exception('Valid member and name required.'); }
        $member = $pdo->prepare('SELECT * FROM team_members WHERE id=?');
        $member->execute([$id]);
        $current = $member->fetch(PDO::FETCH_ASSOC);
        if (!$current) throw new Exception('Member not found.');
        $avatar_image = $current['avatar_image'];
        if (isset($_FILES['avatar']) && is_uploaded_file($_FILES['avatar']['tmp_name'])) {
          $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
          $safe = 'team_' . time() . '_' . mt_rand(1000,9999) . '.' . preg_replace('/[^a-zA-Z0-9]+/', '', $ext);
          $dest = $team_upload_dir . '/' . $safe;
          if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $dest)) {
            throw new Exception('Failed to upload avatar image.');
          }
          $avatar_image = 'uploads/team/' . $safe;
        }
        $stmt = $pdo->prepare('UPDATE team_members SET name=?, role_title=?, avatar_initials=?, avatar_image=?, bio=?, twitter_url=?, facebook_url=?, linkedin_url=?, sort_order=?, active=? WHERE id=?');
        $stmt->execute([$name, $role ?: null, $initials ?: null, $avatar_image, $bio ?: null, $tw ?: null, $fb ?: null, $ln ?: null, $sort, $active, $id]);
        $notices[] = 'Member updated successfully.';
      } elseif ($action === 'member_delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) throw new Exception('Valid member required.');
        $stmt = $pdo->prepare('DELETE FROM team_members WHERE id=?');
        $stmt->execute([$id]);
        $notices[] = 'Member deleted.';
      } elseif ($action === 'member_reorder') {
        $orders = $_POST['sort_orders'] ?? [];
        foreach ($orders as $mid => $ord) {
          $stmt = $pdo->prepare('UPDATE team_members SET sort_order=? WHERE id=?');
          $stmt->execute([(int)$ord, (int)$mid]);
        }
        $notices[] = 'Order updated.';
      }
    } catch (Throwable $e) {
      $errors[] = $e->getMessage();
    }
  }
}

$groups = get_groups($pdo);

?>
<main class="container mx-auto px-4 py-6">
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Manage Teams</h1>
    <a href="<?php echo url('about'); ?>" target="_blank" class="btn-primary">View About Page</a>
  </div>

  <?php if (!empty($errors)): ?>
    <div class="mb-4 p-4 rounded bg-red-50 border border-red-200 text-red-700">
      <?php foreach ($errors as $err): ?><div><?php echo htmlspecialchars($err); ?></div><?php endforeach; ?>
    </div>
  <?php endif; ?>
  <?php if (!empty($notices)): ?>
    <div class="mb-4 p-4 rounded bg-green-50 border border-green-200 text-green-700">
      <?php foreach ($notices as $note): ?><div><?php echo htmlspecialchars($note); ?></div><?php endforeach; ?>
    </div>
  <?php endif; ?>

  <section class="mb-8">
    <h2 class="font-semibold text-lg mb-3">Groups</h2>
    <div class="grid md:grid-cols-2 gap-6">
      <div class="rounded-xl border border-gray-200 p-4 bg-white">
        <form method="post" class="space-y-3">
          <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
          <input type="hidden" name="action" value="group_create">
          <div>
            <label class="block text-sm font-medium mb-1">Name</label>
            <input name="name" class="w-full border rounded p-2" placeholder="e.g., Leadership">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Slug</label>
            <input name="slug" class="w-full border rounded p-2" placeholder="e.g., leadership">
          </div>
          <label class="inline-flex items-center gap-2"><input type="checkbox" name="active" checked> Active</label>
          <button class="btn-primary" type="submit">Add Group</button>
        </form>
      </div>
      <div class="rounded-xl border border-gray-200 p-4 bg-white">
        <?php foreach ($groups as $g): ?>
          <form method="post" class="flex items-center gap-3 mb-3">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="action" value="group_update">
            <input type="hidden" name="id" value="<?php echo (int)$g['id']; ?>">
            <input name="name" class="flex-1 border rounded p-2" value="<?php echo htmlspecialchars($g['name']); ?>">
            <input name="sort_order" class="w-20 border rounded p-2" type="number" value="<?php echo (int)$g['sort_order']; ?>" title="Sort order">
            <label class="inline-flex items-center gap-2"><input type="checkbox" name="active" <?php echo ((int)$g['active']===1?'checked':''); ?>> Active</label>
            <button class="btn-primary" type="submit">Save</button>
          </form>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section>
    <h2 class="font-semibold text-lg mb-3">Members</h2>
    <?php foreach ($groups as $g): $members = get_members_by_group($pdo, (int)$g['id']); ?>
      <div class="rounded-xl border border-gray-200 p-4 bg-white mb-6">
        <div class="flex items-center justify-between mb-3">
          <h3 class="font-semibold text-md"><?php echo htmlspecialchars($g['name']); ?></h3>
          <form method="post">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="action" value="member_reorder">
            <div class="overflow-x-auto">
              <table class="min-w-full text-sm">
                <thead><tr><th class="text-left p-2">Name</th><th class="text-left p-2">Role</th><th class="p-2">Sort</th><th class="p-2">Active</th><th class="p-2">Actions</th></tr></thead>
                <tbody>
                  <?php foreach ($members as $m): ?>
                    <tr class="border-t">
                      <td class="p-2"><?php echo htmlspecialchars($m['name']); ?></td>
                      <td class="p-2"><?php echo htmlspecialchars($m['role_title'] ?? ''); ?></td>
                      <td class="p-2"><input class="w-20 border rounded p-1" type="number" name="sort_orders[<?php echo (int)$m['id']; ?>]" value="<?php echo (int)$m['sort_order']; ?>"></td>
                      <td class="p-2"><?php echo ((int)$m['active']===1?'Yes':'No'); ?></td>
                      <td class="p-2">
                        <details>
                          <summary class="cursor-pointer text-blue-600">Edit</summary>
                          <form method="post" enctype="multipart/form-data" class="mt-2 space-y-2">
                            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" name="action" value="member_update">
                            <input type="hidden" name="id" value="<?php echo (int)$m['id']; ?>">
                            <div class="grid md:grid-cols-2 gap-2">
                              <input class="border rounded p-2" name="name" value="<?php echo htmlspecialchars($m['name']); ?>" placeholder="Name">
                              <input class="border rounded p-2" name="role_title" value="<?php echo htmlspecialchars($m['role_title'] ?? ''); ?>" placeholder="Role Title">
                              <input class="border rounded p-2" name="avatar_initials" value="<?php echo htmlspecialchars($m['avatar_initials'] ?? ''); ?>" placeholder="Initials (e.g., CO)">
                              <input class="border rounded p-2" name="twitter_url" value="<?php echo htmlspecialchars($m['twitter_url'] ?? ''); ?>" placeholder="Twitter URL">
                              <input class="border rounded p-2" name="facebook_url" value="<?php echo htmlspecialchars($m['facebook_url'] ?? ''); ?>" placeholder="Facebook URL">
                              <input class="border rounded p-2" name="linkedin_url" value="<?php echo htmlspecialchars($m['linkedin_url'] ?? ''); ?>" placeholder="LinkedIn URL">
                            </div>
                            <textarea class="border rounded p-2 w-full" name="bio" placeholder="Bio (optional)"><?php echo htmlspecialchars($m['bio'] ?? ''); ?></textarea>
                            <div class="flex items-center gap-2">
                              <input class="w-20 border rounded p-2" type="number" name="sort_order" value="<?php echo (int)$m['sort_order']; ?>" placeholder="Sort">
                              <label class="inline-flex items-center gap-2"><input type="checkbox" name="active" <?php echo ((int)$m['active']===1?'checked':''); ?>> Active</label>
                              <input type="file" name="avatar" accept="image/*">
                              <button class="btn-primary" type="submit">Save</button>
                            </div>
                          </form>
                          <form method="post" class="mt-2">
                            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" name="action" value="member_delete">
                            <input type="hidden" name="id" value="<?php echo (int)$m['id']; ?>">
                            <button type="submit" class="px-3 py-1 rounded bg-red-600 text-white">Delete</button>
                          </form>
                        </details>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <div class="text-right mt-2">
              <button class="btn-primary" type="submit">Save Order</button>
            </div>
          </form>
        </div>

        <div class="mt-3">
          <h4 class="font-medium mb-2">Add Member</h4>
          <form method="post" enctype="multipart/form-data" class="grid md:grid-cols-2 gap-3">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="action" value="member_create">
            <input type="hidden" name="group_id" value="<?php echo (int)$g['id']; ?>">
            <input class="border rounded p-2" name="name" placeholder="Full Name">
            <input class="border rounded p-2" name="role_title" placeholder="Role Title">
            <input class="border rounded p-2" name="avatar_initials" placeholder="Initials (e.g., CO)">
            <input class="border rounded p-2" name="twitter_url" placeholder="Twitter URL">
            <input class="border rounded p-2" name="facebook_url" placeholder="Facebook URL">
            <input class="border rounded p-2" name="linkedin_url" placeholder="LinkedIn URL">
            <textarea class="md:col-span-2 border rounded p-2" name="bio" placeholder="Bio (optional)"></textarea>
            <div class="md:col-span-2 flex items-center gap-3">
              <input type="file" name="avatar" accept="image/*">
              <input class="w-24 border rounded p-2" type="number" name="sort_order" placeholder="Sort">
              <button class="btn-primary" type="submit">Add Member</button>
            </div>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  </section>
</main>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
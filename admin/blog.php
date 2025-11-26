<?php require_once __DIR__ . '/../config/security.php'; ?>
<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php require_once __DIR__ . '/../config/csrf.php'; ?>
<?php require_login(['SuperAdmin', 'Admin', 'Editor']); ?>
<?php
function slugify(string $text): string
{
  $text = strtolower(trim($text));
  $text = preg_replace('~[^a-z0-9]+~', '-', $text);
  return trim($text, '-');
}

$action = $_GET['action'] ?? 'list';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!csrf_validate($_POST['csrf_token'] ?? '')) {
    http_response_code(400);
    echo 'Invalid CSRF token';
    exit;
  }
  if ($action === 'create') {
    $title = trim($_POST['title'] ?? '');
    $slug = slugify($title);
    $excerpt = trim($_POST['excerpt'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $author = current_user()['name'] ?? 'Admin';
    $imageName = null;
    if (!empty($_FILES['image']['name'])) {
      $f = $_FILES['image'];
      if ($f['size'] > MAX_UPLOAD_BYTES) {
        $err = 'File too large';
      } else {
        $mime = mime_content_type($f['tmp_name']);
        if (!in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true)) {
          $err = 'Invalid image type';
        } else {
          $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
          $imageName = uniqid('img_', true) . '.' . strtolower($ext);
          move_uploaded_file($f['tmp_name'], UPLOAD_DIR . $imageName);
        }
      }
    }
    try {
      $stmt = db()->prepare('INSERT INTO blog_posts (title, slug, excerpt, content, image, author, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())');
      $stmt->execute([$title, $slug, $excerpt, $content, $imageName, $author]);
      header('Location: ' . url('admin/blog.php') . '?created=1');
      exit;
    } catch (Throwable $e) {
      error_log('Blog create failed: ' . $e->getMessage());
      header('Location: ' . url('admin/blog.php') . '?error=1');
      exit;
    }
  }
  if ($action === 'update') {
    $id = (int)($_POST['id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $slug = slugify($title);
    $excerpt = trim($_POST['excerpt'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $imageName = $_POST['current_image'] ?? null;
    if (!empty($_FILES['image']['name'])) {
      $f = $_FILES['image'];
      if ($f['size'] <= MAX_UPLOAD_BYTES) {
        $mime = mime_content_type($f['tmp_name']);
        if (in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true)) {
          $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
          $imageName = uniqid('img_', true) . '.' . strtolower($ext);
          move_uploaded_file($f['tmp_name'], UPLOAD_DIR . $imageName);
        }
      }
    }
    try {
      $stmt = db()->prepare('UPDATE blog_posts SET title=?, slug=?, excerpt=?, content=?, image=? WHERE id=?');
      $stmt->execute([$title, $slug, $excerpt, $content, $imageName, $id]);
      header('Location: ' . url('admin/blog.php') . '?updated=1');
      exit;
    } catch (Throwable $e) {
      error_log('Blog update failed: ' . $e->getMessage());
      header('Location: ' . url('admin/blog.php') . '?error=1');
      exit;
    }
  }
  if ($action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    try {
      $stmt = db()->prepare('DELETE FROM blog_posts WHERE id=?');
      $stmt->execute([$id]);
      header('Location: ' . url('admin/blog.php') . '?deleted=1');
      exit;
    } catch (Throwable $e) {
      error_log('Blog delete failed: ' . $e->getMessage());
      header('Location: ' . url('admin/blog.php') . '?error=1');
      exit;
    }
  }
}
?>
<?php include __DIR__ . '/includes/admin-header.php'; ?>
<?php
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 6;
?>

<div class="min-h-screen bg-gray-50/30">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Blog Management</h1>
          <p class="mt-2 text-sm text-gray-600">Create and manage your blog posts</p>
        </div>
        <?php if ($action === 'list'): ?>
          <a href="<?php echo url('admin/blog.php'); ?>?action=create"
            class="mt-4 sm:mt-0 inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white font-medium shadow-sm hover:shadow-md transition-all duration-200"
            style="background: <?php echo RCN_GRADIENT; ?>;">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 5V19M5 12H19" class="icon-stroke" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" />
            </svg>
            New Post
          </a>
        <?php else: ?>
          <a href="<?php echo url('admin/blog.php'); ?>"
            class="mt-4 sm:mt-0 inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-all duration-200">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M19 12H5M12 19l-7-7 7-7" class="icon-stroke" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Back to Posts
          </a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Alert Messages -->
    <?php if ($action === 'list'): ?>
      <?php if (!empty($_GET['created'])): ?>
        <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 flex items-center gap-3">
          <div class="w-3 h-3 rounded-full bg-green-500 animate-pulse"></div>
          <div class="text-green-700 font-medium">Post created successfully</div>
        </div>
      <?php elseif (!empty($_GET['updated'])): ?>
        <div class="mb-6 p-4 rounded-xl bg-blue-50 border border-blue-200 flex items-center gap-3">
          <div class="w-3 h-3 rounded-full bg-blue-500 animate-pulse"></div>
          <div class="text-blue-700 font-medium">Post updated successfully</div>
        </div>
      <?php elseif (!empty($_GET['deleted'])): ?>
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 flex items-center gap-3">
          <div class="w-3 h-3 rounded-full bg-red-500 animate-pulse"></div>
          <div class="text-red-700 font-medium">Post deleted successfully</div>
        </div>
      <?php elseif (!empty($_GET['error'])): ?>
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 flex items-center gap-3">
          <div class="w-3 h-3 rounded-full bg-red-500 animate-pulse"></div>
          <div class="text-red-700 font-medium">An error occurred. Please try again.</div>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <?php if ($action === 'list'): ?>
      <!-- Blog Posts List -->
      <?php
      try {
        $count = (int)db()->query('SELECT COUNT(*) FROM blog_posts')->fetchColumn();
        $pages = max(1, (int)ceil($count / $perPage));
        if ($page > $pages) $page = $pages;
        $offset = ($page - 1) * $perPage;
        $posts = db()->query('SELECT * FROM blog_posts ORDER BY created_at DESC LIMIT ' . (int)$perPage . ' OFFSET ' . (int)$offset)->fetchAll();
      } catch (Throwable $e) {
        $posts = [];
        $pages = 1;
      }
      ?>

      <?php if (empty($posts)): ?>
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
          <svg class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
          </svg>
          <h3 class="text-lg font-medium text-gray-900 mb-2">No blog posts yet</h3>
          <p class="text-gray-500 mb-6">Get started by creating your first blog post.</p>
          <a href="<?php echo url('admin/blog.php'); ?>?action=create"
            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white font-medium shadow-sm hover:shadow-md transition-all duration-200"
            style="background: <?php echo RCN_GRADIENT; ?>;">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 5V19M5 12H19" class="icon-stroke" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" />
            </svg>
            Create First Post
          </a>
        </div>
      <?php else: ?>
        <!-- Posts Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php foreach ($posts as $post): ?>
            <div
              class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300 group">
              <?php if (!empty($post['image'])): ?>
                <div class="h-48 bg-gray-200 overflow-hidden">
                  <img src="<?php echo url('uploads/' . $post['image']); ?>"
                    alt="<?php echo esc_attr($post['title']); ?>"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
              <?php else: ?>
                <div class="h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                  <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
              <?php endif; ?>

              <div class="p-6">
                <h3
                  class="font-semibold text-gray-900 text-lg mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors">
                  <?php echo esc_html($post['title']); ?></h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?php echo esc_html($post['excerpt']); ?></p>

                <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                  <span><?php echo date('M j, Y', strtotime($post['created_at'])); ?></span>
                  <span>by <?php echo esc_html($post['author']); ?></span>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                  <a href="<?php echo url('admin/blog.php'); ?>?action=edit&id=<?php echo (int)$post['id']; ?>"
                    class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-colors duration-200">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                        class="icon-stroke" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    </svg>
                    Edit
                  </a>
                  <form method="post" action="<?php echo url('admin/blog.php'); ?>?action=delete"
                    onsubmit="return confirm('Are you sure you want to delete this post? This action cannot be undone.')"
                    class="flex-1">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" value="<?php echo (int)$post['id']; ?>">
                    <button type="submit"
                      class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-red-300 text-red-700 font-medium hover:bg-red-50 transition-colors duration-200">
                      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                          class="icon-stroke" stroke="currentColor" stroke-width="2"
                          stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                      Delete
                    </button>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <?php if (($pages ?? 1) > 1): ?>
          <div class="mt-8 flex items-center justify-center gap-2">
            <?php if ($page > 1): ?>
              <a href="<?php echo url('admin/blog.php'); ?>?page=<?php echo (int)($page - 1); ?>" class="px-3 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">Prev</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $pages; $i++): ?>
              <a href="<?php echo url('admin/blog.php'); ?>?page=<?php echo (int)$i; ?>" class="px-3 py-2 rounded-lg <?php echo $i === $page ? 'bg-gray-900 text-white' : 'border border-gray-300 text-gray-700 hover:bg-gray-50'; ?>"><?php echo (int)$i; ?></a>
            <?php endfor; ?>
            <?php if ($page < $pages): ?>
              <a href="<?php echo url('admin/blog.php'); ?>?page=<?php echo (int)($page + 1); ?>" class="px-3 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">Next</a>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      <?php endif; ?>

    <?php elseif ($action === 'create' || $action === 'edit'): ?>
      <!-- Blog Post Form -->
      <?php
      $post = ['id' => 0, 'title' => '', 'excerpt' => '', 'content' => '', 'image' => null];
      if ($action === 'edit') {
        $id = (int)($_GET['id'] ?? 0);
        $stmt = db()->prepare('SELECT * FROM blog_posts WHERE id=?');
        $stmt->execute([$id]);
        $post = $stmt->fetch() ?: $post;
      }
      ?>

      <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
          <!-- Form Header -->
          <div class="px-6 py-4 border-b border-gray-200" style="background: <?php echo RCN_GRADIENT; ?>;">
            <h2 class="text-xl font-semibold text-white">
              <?php echo $action === 'create' ? 'Create New Post' : 'Edit Post'; ?>
            </h2>
          </div>

          <!-- Form Content -->
          <form id="blogForm" method="post" enctype="multipart/form-data"
            action="<?php echo url('admin/blog.php'); ?>?action=<?php echo $action === 'create' ? 'create' : 'update'; ?>"
            class="p-6 space-y-6">
            <?php echo csrf_field(); ?>
            <?php if ($action === 'edit'): ?>
              <input type="hidden" name="id" value="<?php echo (int)$post['id']; ?>">
            <?php endif; ?>

            <!-- Title -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
              <input name="title"
                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                value="<?php echo esc_attr($post['title'] ?? ''); ?>" placeholder="Enter post title..."
                required>
            </div>

            <!-- Excerpt -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Excerpt</label>
              <textarea name="excerpt"
                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                rows="3" placeholder="Brief description of your post..."
                required><?php echo esc_html($post['excerpt'] ?? ''); ?></textarea>
            </div>

            <!-- Content -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
              <textarea name="content"
                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                rows="8" placeholder="Write your post content here..."
                required><?php echo $post['content'] ?? ''; ?></textarea>
            </div>

            <!-- Image Upload -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Featured Image</label>
              <div class="space-y-4">
                <?php if (!empty($post['image'])): ?>
                  <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                    <img src="<?php echo url('uploads/' . $post['image']); ?>" alt="Current image"
                      class="h-16 w-16 object-cover rounded-lg">
                    <div class="flex-1">
                      <p class="text-sm font-medium text-gray-900">Current Image</p>
                      <p class="text-sm text-gray-500"><?php echo esc_html($post['image']); ?></p>
                    </div>
                    <input type="hidden" name="current_image"
                      value="<?php echo esc_attr($post['image']); ?>">
                  </div>
                <?php endif; ?>

                <div
                  class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-gray-400 transition-colors duration-200">
                  <input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="hidden"
                    id="imageInput">
                  <label for="imageInput" class="cursor-pointer">
                    <svg class="h-12 w-12 mx-auto text-gray-400 mb-3" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-sm text-gray-600 mb-1">Click to upload an image</p>
                    <p class="text-xs text-gray-500">JPEG, PNG, WebP (Max <?php echo (int)(MAX_UPLOAD_BYTES / (1024 * 1024)); ?>MB)</p>
                  </label>
                </div>
                <div id="imagePreview" class="hidden">
                  <img id="previewImage" class="h-32 w-full object-cover rounded-xl">
                </div>
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
                <?php echo $action === 'create' ? 'Create Post' : 'Update Post'; ?>
              </button>
              <a href="<?php echo url('admin/blog.php'); ?>"
                class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-colors duration-200">
                Cancel
              </a>
            </div>
          </form>
        </div>
      </div>

      <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
      <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
      <script>
        // Image preview functionality
        document.getElementById('imageInput').addEventListener('change', function(e) {
          const file = e.target.files[0];
          const preview = document.getElementById('imagePreview');
          const previewImage = document.getElementById('previewImage');

          if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
              previewImage.src = e.target.result;
              preview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
          } else {
            preview.classList.add('hidden');
          }
        });

        (function(){
          var textarea = document.querySelector('textarea[name=content]');
          var container = document.createElement('div');
          container.id = 'quillEditor';
          container.style.height = '400px';
          container.className = 'bg-white';
          textarea.parentNode.insertBefore(container, textarea.nextSibling);
          textarea.style.display = 'none';
          var quill = new Quill('#quillEditor', {
            theme: 'snow',
            modules: {
              toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                ['link', 'image'],
                ['clean']
              ]
            }
          });
          quill.root.innerHTML = textarea.value || '';
          var form = document.getElementById('blogForm');
          var sync = function(){ textarea.value = quill.root.innerHTML; };
          quill.on('text-change', sync);
          if (form) { form.addEventListener('submit', function(){ sync(); }); }
        })();

        // Form submission handling
        (function() {
          var form = document.getElementById('blogForm');
          if (!form) return;

          var submitBtn = document.getElementById('submitBtn');

          form.addEventListener('submit', function() {

            if (submitBtn) {
              submitBtn.disabled = true;
              submitBtn.classList.add('opacity-60', 'cursor-not-allowed');
              var originalText = submitBtn.innerHTML;
              submitBtn.innerHTML =
                '<svg class="h-5 w-5 animate-spin" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Saving...';
            }
          });
        })();
      </script>
    <?php endif; ?>
  </div>
</div>

<style>
  .line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
</style>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>

<?php require_once __DIR__ . '/config/security.php'; ?>
<?php require_once __DIR__ . '/config/db.php'; ?>
<?php require_once __DIR__ . '/includes/constants.php'; ?>
<?php
$page_title = 'Gallery • ' . APP_NAME;
$page_description = 'Photos from our missions, outreaches, and programs.';
$hero_enable = false; // Use a custom hero consistent with Get Involved
// Category helpers (local to public page)
function ensure_public_categories(): void {
  try { db()->query('SELECT id, name FROM gallery_categories LIMIT 1'); }
  catch (Throwable $e) {
    try { db()->exec('CREATE TABLE IF NOT EXISTS gallery_categories (id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, name VARCHAR(64) NOT NULL UNIQUE, created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'); } catch (Throwable $e2) {}
  }
}
function get_public_categories(): array {
  ensure_public_categories();
  try {
    $rows = db()->query('SELECT name FROM gallery_categories ORDER BY name ASC')->fetchAll();
    $list = array_map(fn($r) => $r['name'], $rows ?: []);
    if (!$list) {
      $defaults = ['Outreach','Trips','Hospital','Volunteers','Facilities','Sponsors','Community'];
      $stmt = db()->prepare('INSERT IGNORE INTO gallery_categories (name) VALUES (?)');
      foreach ($defaults as $d) { $stmt->execute([$d]); }
      $list = $defaults;
    }
    return $list;
  } catch (Throwable $e) { return []; }
}
?>
<?php include __DIR__ . '/includes/header.php'; ?>

<!-- Modern Hero (consistent with Get Involved) -->
<section class="relative bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-900 text-white overflow-hidden">
  <div class="absolute inset-0 opacity-20">
    <div class="absolute inset-0"
      style="background-image: url('<?php echo url('assets/images/hero3.jpg'); ?>'); background-size: cover; background-position: center;"></div>
  </div>
  <div class="absolute top-0 left-0 right-0 bottom-0 opacity-10">
    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
      <defs>
        <pattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse">
          <path d="M 60 0 L 0 0 0 60" fill="none" stroke="white" stroke-width="1.5" />
        </pattern>
      </defs>
      <rect width="100%" height="100%" fill="url(#grid)" />
    </svg>
  </div>
  <div class="relative max-w-7xl mx-auto px-4 py-20">
    <div class="max-w-3xl">
      <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm mb-6">
        <span class="w-2 h-2 rounded-full bg-orange-400 mr-2 animate-pulse"></span>
        Moments from the Mission Field
      </div>
      <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight" style="font-family: Poppins, sans-serif;">
        Gallery
      </h1>
      <p class="text-lg text-white/90 mb-8 leading-relaxed">Photos from outreaches, trips, and community care efforts.</p>
      <div class="flex flex-wrap gap-4">
        <a href="#photos" class="inline-flex items-center px-6 py-3 rounded-lg font-medium text-white transition-all duration-300 transform hover:scale-105 shadow-lg" style="background: <?php echo RCN_GRADIENT; ?>;">
          View Photos
        </a>
        <a href="<?php echo url('get-involved'); ?>" class="inline-flex items-center px-6 py-3 rounded-lg font-medium border-2 border-white/30 text-white hover:bg-white/10 transition-all duration-300 backdrop-blur-sm">
          Get Involved
        </a>
      </div>
    </div>
  </div>
</section>

<section id="photos" class="max-w-7xl mx-auto px-4 py-16">
  <?php
  // Category filters
  $categories = get_public_categories();
  $active = trim($_GET['category'] ?? '');
  if ($active !== '' && !in_array($active, $categories, true)) { $active = ''; }
  try {
    if ($active !== '') {
      $stmt = db()->prepare('SELECT id, image, caption, category, uploaded_at FROM gallery WHERE category = ? ORDER BY uploaded_at DESC, id DESC');
      $stmt->execute([$active]);
      $items = $stmt->fetchAll();
    } else {
      $stmt = db()->query('SELECT id, image, caption, category, uploaded_at FROM gallery ORDER BY uploaded_at DESC, id DESC');
      $items = $stmt->fetchAll();
    }
  } catch (Throwable $e) { $items = []; }
  ?>

  <!-- Visible category filters -->
  <div class="mb-8 flex flex-wrap gap-3 items-center">
    <a href="<?php echo url('gallery'); ?>#photos" class="px-4 py-2 rounded-full border <?php echo $active === '' ? 'bg-gray-900 text-white border-gray-900' : 'text-gray-700 hover:bg-gray-50'; ?>">All</a>
    <?php foreach ($categories as $c): ?>
      <a href="<?php echo url('gallery'); ?>?category=<?php echo urlencode($c); ?>#photos" class="px-4 py-2 rounded-full border <?php echo $active === $c ? 'bg-gray-900 text-white border-gray-900' : 'text-gray-700 hover:bg-gray-50'; ?>"><?php echo esc_html($c); ?></a>
    <?php endforeach; ?>
  </div>

  <?php if (!empty($items)): ?>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php foreach ($items as $g): ?>
        <?php $src = url('uploads/gallery/' . esc_attr($g['image'])); ?>
        <article class="bg-white rounded-2xl shadow border border-gray-100 overflow-hidden hover:shadow-md transition group">
          <button type="button" class="w-full text-left" onclick="openGallery(<?php echo (int)$g['id']; ?>, '<?php echo esc_attr($src); ?>', '<?php echo esc_attr($g['caption'] ?? ''); ?>')">
            <div class="relative overflow-hidden">
              <img src="<?php echo $src; ?>" alt="<?php echo esc_attr($g['caption'] ?? ''); ?>" loading="lazy"
                class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-700">
              <div class="absolute inset-0 bg-black/10 group-hover:bg-black/5 transition-colors duration-300"></div>
            </div>
          </button>
          <div class="p-4">
            <?php if (!empty($g['caption'])): ?>
              <div class="text-gray-800 font-medium"><?php echo esc_html($g['caption']); ?></div>
            <?php else: ?>
              <div class="text-sm text-gray-500">&nbsp;</div>
            <?php endif; ?>
            <div class="text-xs text-gray-500 mt-1">Uploaded: <?php echo esc_html(date('M j, Y', strtotime($g['uploaded_at']))); ?></div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="bg-white rounded-2xl shadow p-10 text-center">
      <svg class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
      </svg>
      <h3 class="text-lg font-medium text-gray-900 mb-2">No photos found</h3>
      <p class="text-gray-500">Try another category or check back soon.</p>
    </div>
  <?php endif; ?>
</section>

<script>
  // Build an index of items for keyboard navigation
  const GALLERY_ITEMS = [
    <?php foreach ($items as $g): ?>
      { id: <?php echo (int)$g['id']; ?>, src: '<?php echo url('uploads/gallery/' . esc_attr($g['image'])); ?>', caption: '<?php echo esc_attr($g['caption'] ?? ''); ?>' },
    <?php endforeach; ?>
  ];
  const findIndexById = (id) => GALLERY_ITEMS.findIndex(x => x.id === id);
  let CURRENT_INDEX = -1;

  function openGallery(id, src, caption) {
    CURRENT_INDEX = findIndexById(id);
    if (window.Swal) {
      Swal.fire({
        title: caption || 'Photo',
        html: `<img src="${src}" alt="${caption || ''}" style="max-width:100%; border-radius: 0.75rem;"/>`,
        width: 900,
        confirmButtonText: 'Close',
        confirmButtonColor: '#f97316',
        didOpen: () => {
          const handler = (e) => {
            if (e.key === 'Escape') { Swal.close(); }
            if (e.key === 'ArrowLeft') { navigate(-1); }
            if (e.key === 'ArrowRight') { navigate(1); }
          };
          document.addEventListener('keydown', handler);
          Swal.getPopup().addEventListener('mouseleave', () => document.removeEventListener('keydown', handler));
        }
      });
      return;
    }
    const overlay = document.createElement('div');
    overlay.style.position = 'fixed';
    overlay.style.inset = '0';
    overlay.style.background = 'rgba(0,0,0,0.6)';
    overlay.style.zIndex = '9999';
    overlay.innerHTML = `
      <div class="flex items-center justify-center w-full h-full">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 w-full max-w-5xl mx-4">
          <div class="px-5 py-4 border-b"><div class="font-semibold text-gray-900">${caption || 'Photo'}</div></div>
          <div class="px-5 py-4">
            <img id="galleryImg" src="${src}" alt="${caption || ''}" class="w-full h-auto rounded-lg"/>
          </div>
          <div class="px-5 py-4 flex justify-between">
            <div class="flex items-center gap-2">
              <button id="galleryPrev" class="px-3 py-2 rounded-lg border text-gray-700 hover:bg-gray-50">Prev</button>
              <button id="galleryNext" class="px-3 py-2 rounded-lg border text-gray-700 hover:bg-gray-50">Next</button>
            </div>
            <button id="galleryClose" class="px-4 py-2 rounded-lg text-white" style="background: <?php echo RCN_GRADIENT; ?>;">Close</button>
          </div>
        </div>
      </div>`;
    document.body.appendChild(overlay);
    overlay.querySelector('#galleryClose').addEventListener('click', () => overlay.remove());
    overlay.querySelector('#galleryPrev').addEventListener('click', () => navigate(-1, overlay));
    overlay.querySelector('#galleryNext').addEventListener('click', () => navigate(1, overlay));
    const keyHandler = (e) => {
      if (e.key === 'Escape') overlay.remove();
      if (e.key === 'ArrowLeft') navigate(-1, overlay);
      if (e.key === 'ArrowRight') navigate(1, overlay);
    };
    document.addEventListener('keydown', keyHandler);
    overlay.addEventListener('mouseleave', () => document.removeEventListener('keydown', keyHandler));
  }

  function navigate(delta, overlay) {
    if (CURRENT_INDEX < 0) return;
    CURRENT_INDEX = (CURRENT_INDEX + delta + GALLERY_ITEMS.length) % GALLERY_ITEMS.length;
    const item = GALLERY_ITEMS[CURRENT_INDEX];
    if (overlay) {
      const img = overlay.querySelector('#galleryImg');
      const title = overlay.querySelector('.font-semibold');
      if (img) img.src = item.src;
      if (title) title.textContent = item.caption || 'Photo';
    } else if (window.Swal) {
      Swal.close();
      setTimeout(() => openGallery(item.id, item.src, item.caption), 50);
    }
  }
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
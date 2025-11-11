<?php /* Page content ends here */ ?>
      </main>
    </div>
  </div>
  <script>
    (function(){
      var btn = document.getElementById('sidebarToggle');
      var sidebar = document.getElementById('adminSidebar');
      var overlay = document.getElementById('mobileOverlay');
      var body = document.body;

      function openSidebar() {
        // Show sidebar by removing the offscreen transform
        sidebar.classList.remove('-translate-x-full');
        // Show overlay on mobile
        if (overlay) overlay.classList.remove('hidden');
        // Prevent background scroll when sidebar is open
        body.classList.add('overflow-hidden');
        if (btn) btn.setAttribute('aria-expanded', 'true');
      }

      function closeSidebar() {
        // Hide sidebar by adding the offscreen transform
        sidebar.classList.add('-translate-x-full');
        // Hide overlay
        if (overlay) overlay.classList.add('hidden');
        // Restore background scroll
        body.classList.remove('overflow-hidden');
        if (btn) btn.setAttribute('aria-expanded', 'false');
      }

      function toggleSidebar() {
        if (sidebar.classList.contains('-translate-x-full')) {
          openSidebar();
        } else {
          closeSidebar();
        }
      }

      if (btn && sidebar) {
        btn.addEventListener('click', function(e){
          e.preventDefault();
          toggleSidebar();
        });
      }

      if (overlay) {
        overlay.addEventListener('click', function(){
          closeSidebar();
        });
      }

      document.addEventListener('keyup', function(e){
        if (e.key === 'Escape') {
          closeSidebar();
        }
      });

      // Ensure sidebar closes when switching to desktop view
      var mq = window.matchMedia('(min-width: 768px)');
      function onWidthChange(e) {
        if (e.matches) {
          closeSidebar();
        }
      }
      if (mq.addEventListener) {
        mq.addEventListener('change', onWidthChange);
      } else if (mq.addListener) {
        mq.addListener(onWidthChange);
      }
    })();
  </script>
</body>
</html>
# RCN Mission Hospital Website

Comprehensive documentation for setup, configuration, usage, payments integration, and project handover.

Designed and Developed by Pinnacle Tech Hub • +2347032078859 • techspiresolutionsltd@gmail.com

## Overview

RCN Mission Hospital is a PHP-based website with an admin dashboard for managing content (blog, outreach reports, resources, sponsors, future programs, trips) and donations (PayPal IPN, optional Paystack). The project is designed to run on Windows (WAMP) or the built-in PHP server and uses a simple MySQL schema.

## Key Features

- Admin dashboard with role-based access (`SuperAdmin`, `Admin`, `Editor`).
- Content management: blog posts, outreach reports, resources, sponsors, future programs, trips.
- Donations tracking via PayPal IPN (one-time and subscriptions).
- Optional Paystack integration endpoints scaffolded.
- Secure forms with CSRF protection and session security.
- File uploads for resources (documents, PDFs) and images for sponsors/trips/outreach.
- Outreach report single page supports embedded video/audio/PDF via `file_link`.

## Tech Stack

- PHP 8.x (compatible with PHP 7.4+), no framework.
- MySQL/MariaDB.
- Composer for vendor libraries (PHPMailer).
- Tailwind-like utility classes (compiled CSS in `assets/css/custom.css`).

## Project Structure

```
rcnmissionhospital/
├── admin/                  # Admin dashboard pages
├── api/                    # Payment endpoints (PayPal IPN, Paystack init)
├── assets/                 # CSS, JS, images
├── blog/                   # Public blog listing & single
├── config/                 # DB, CSRF, security helpers
├── includes/               # Site-wide header/footer, constants
├── outreach-report/        # Public outreach listing & single
├── trips/                  # Public trips listing & single
├── uploads/                # Uploaded files/images
├── database.sql            # Database schema and sample data
└── vendor/                 # Composer dependencies (PHPMailer, etc.)
```

## Prerequisites

- PHP installed (Windows: WAMP/XAMPP or PHP binaries).
- MySQL/MariaDB server.
- Composer (recommended) for vendor autoload.

## Local Setup

1. Clone/copy the project into your web root (e.g., `c:\wamp64\www\rcnmissionhospital`).
2. Create a database (e.g., `rcn_mission_hospital`).
3. Import `database.sql` into MySQL.
4. Configure database credentials in `includes/constants.php`:
   - `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`.
5. Ensure uploads directory exists and is writable:
   - Default: `includes/constants.php` sets `UPLOAD_DIR` to `../uploads/` and auto-creates subfolders as needed.
6. Start a local server:
   - Built-in PHP: `php -S 127.0.0.1:8000 -t .` (run in project root)
   - Or configure Apache/Nginx to serve the project directory.

### Dynamic Base Path

`includes/constants.php` determines `BASE_PATH` automatically based on where the project is deployed within the web root. This allows running from a subdirectory without modifying links.

## Configuration

Edit `includes/constants.php`:

- App/Core:
  - `APP_NAME`, `BASE_PATH` (computed), `SESSION_TIMEOUT`, `LOGIN_MAX_ATTEMPTS`, `LOGIN_LOCK_WINDOW`.
- Database:
  - `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`.
- Uploads:
  - `UPLOAD_DIR`: absolute path to `uploads/`.
  - `MAX_UPLOAD_BYTES`: default `2MB`. Increase if needed.
- SMTP / Email:
  - `SMTP_HOST`, `SMTP_PORT`, `SMTP_USER`, `SMTP_PASS`.
  - `CONTACT_RECIPIENT`: optional override for contact form destination.
  - `SMTP_AUTH`: whether SMTP authentication is required (default `true`).
  - `SMTP_SECURE`: encryption mode: `tls` (default), `ssl`, or `none`.
- Payments (PayPal):
  - `PAYPAL_BUSINESS_EMAIL` (classic Webscr forms).
  - `PAYPAL_RETURN_URL`, `PAYPAL_CANCEL_URL`.
  - `PAYPAL_HOSTED_BUTTON_ID` (optional, for hosted donate buttons).
  - `PAYPAL_USE_SANDBOX` (set `true` for testing, `false` for live).
- Payments (Paystack):
  - `PAYSTACK_PUBLIC_KEY`, `PAYSTACK_SECRET_KEY`.
  - `PAYSTACK_PLAN_CODE_NGN_MONTHLY` (optional for recurring NGN plan).
  - `PAYSTACK_CALLBACK_URL`.

## Database

Schema is defined in `database.sql`. Core tables:

- `users`: Admin accounts (`role` and `status`).
- `blog_posts`: Title, slug, excerpt, content, image, author, `created_at`.
- `outreach_reports`: Title, description, `file_link`, image, date.
- `resources`: Title, description, `file_link`, `file`, date.
- `sponsors`: Name, message, image.
- `trips`: Title, location, dates, description, image, cost, deadlines, spots.
- `donations`: Gateway, type, amount, currency, email, status, transaction/external IDs, payload.
- `subscriptions`: Gateway, external_id, plan_code, amount, currency, email, status, timestamps, payload.

Apply migrations by importing `database.sql`. If you already created tables, use `ALTER TABLE` to add new columns (e.g., `ALTER TABLE resources ADD COLUMN file VARCHAR(255) DEFAULT NULL;`).

## Authentication & Roles

- Login and session security via `config/security.php`.
- CSRF protection via `config/csrf.php`.
- Roles:
  - `SuperAdmin`: Full access.
  - `Admin`: Full content access, payments dashboard.
  - `Editor`: Content creation/editing.
- Sample users are included in `database.sql`. Update passwords in production.

## Admin Dashboard

Entry: `admin/login.php` → `admin/dashboard.php`.

Pages:
- `admin/blog.php`: Manage blog posts.
- `admin/outreach.php`: Manage outreach reports.
- `admin/resources.php`: Manage downloadable resources and attachments.
- `admin/sponsors.php`: Manage sponsor messages and images.
- `admin/future-programs.php`: Manage planned programs.
- `admin/trips.php`: Manage trips.
- `admin/donations.php`: View donations (IPN-tracked).
- `admin/subscriptions.php`: View subscriptions status (recurring via PayPal).

### Resources – Links & Uploads

- Create/Edit allows:
  - `file_link`: external URL (YouTube, Drive, etc.).
  - `file`: uploaded document (pdf/doc/docx/xls/xlsx/ppt/pptx/txt/zip/rar). Size enforced by `MAX_UPLOAD_BYTES`.
- Admin cards show “File” (uploaded) and “External” (link) when present.
- Public `resources.php` shows “Download File” and/or “External Link”.

### Outreach Reports – Embedded Media

- `outreach-report/view.php` embeds `file_link` inline:
  - YouTube/Vimeo: responsive iframe.
  - Video files: HTML5 `<video>`.
  - Audio files: HTML5 `<audio>`.
  - PDFs: inline `<iframe>` viewer.
  - Other URLs: “Open Attachment” button.

## Payments Integration

### PayPal IPN

- IPN listener: `api/paypal/ipn.php`.
- Validates IPN with PayPal (sandbox/live controlled by `PAYPAL_USE_SANDBOX`).
- Stores one-time donations and subscription events into `donations`/`subscriptions` tables.
- Supported events: `txn_type=web_accept` (one-time), `subscr_signup`, `subscr_payment`, `subscr_cancel`.

Forms:
- `partners.php` includes PayPal donate and subscription forms with `notify_url` pointing to `api/paypal/ipn.php`.
- Configure `PAYPAL_BUSINESS_EMAIL`, `RETURN/CANCEL` URLs, and set sandbox toggle.

IPN Setup:
1. Log in to PayPal Business (or Sandbox).
2. Ensure IPN is enabled and the site can receive HTTP POSTs.
3. Use `notify_url` in the forms; ensure your domain is accessible (HTTPS in production).
4. Verify donations appear in `admin/donations.php` and subscriptions in `admin/subscriptions.php`.

### Paystack (Optional)

- Endpoints scaffolded: `api/paystack/init_once.php`, `api/paystack/init_recurring.php`.
- Set keys in `includes/constants.php` and complete the flow per Paystack docs.

## Uploads & Media

- Upload directory: `uploads/` (images, resources).
- Server auto-creates `uploads/resources/` when uploading a resource file.
- Allowed resource file types (default): pdf, doc/docx, xls/xlsx, ppt/pptx, txt, zip/rar.
- To allow audio/video uploads for resources, expand allowed extensions in `admin/resources.php`.

## Security

- CSRF tokens on POST actions.
- Session timeout and login attempt limits in `includes/constants.php`.
- Sanitization helpers used for output (`esc_html`, `esc_attr`).
- Validate uploads by size/type and use sanitized, unique filenames.

## Deployment

- Use HTTPS for production, especially for payment flows and IPN.
- Apache:
  - Place project under the document root or a subdirectory.
  - `.htaccess` included; configure virtual host as needed.
- Nginx:
  - Configure a server block pointing to the project root.
  - Route PHP via `php-fpm`.
- Environment:
  - Update `includes/constants.php` for production DB and payment keys.
  - Ensure file permissions for `uploads/`.

## Testing & Verification

- Content pages: create sample blog, outreach, resources entries and verify public pages.
- Uploads: test uploading a PDF and an external link on resources; verify both appear.
- Outreach report: set `file_link` to a YouTube URL and confirm embedded video.
- PayPal:
  - Set `PAYPAL_USE_SANDBOX=true`.
  - Make a test one-time donation and subscription; confirm IPN entries in admin pages.

## Troubleshooting

- IPN not recording:
  - Check server accessibility (public URL, HTTPS).
  - Verify `notify_url` points to `api/paypal/ipn.php`.
  - Inspect web server logs; ensure firewall permits PayPal POSTs.
  - Confirm `PAYPAL_USE_SANDBOX` setting matches environment.
- Upload fails:
  - Increase `MAX_UPLOAD_BYTES`.
  - Verify file type is allowed.
  - Ensure `uploads/` is writable by the web server.
- BASE_PATH links broken:
  - Confirm project location under document root; `BASE_PATH` auto-detects subdirectory paths.

## Email Queue Cron

- Script: `cron/send_queued_emails.php`.
- Schedule: run every 5 minutes (Windows Task Scheduler or cron).
- Types: `newsletter`, `newsletter_test`, `contact` with per-type limits and optional throttling.
- Backoff: progressive delays based on `attempts` and `last_attempt_at` to reduce retries.
- Pause: global pause via `QUEUE_PAUSE_SENDING` constant.
- SMTP/PHPMailer:
  - Uses `SMTP_HOST`, `SMTP_PORT`, `SMTP_USER`, `SMTP_PASS`.
  - Respects `SMTP_AUTH` and `SMTP_SECURE` (tls/ssl/none).
  - Charset set to `UTF-8` for non-ASCII content.
  - Clears recipients and reply-tos between sends to avoid cross-message leakage.
  - Generates a readable `AltBody` from HTML content for plain-text clients.
- Implementation note (MySQL): the per-type batch query validates and embeds `LIMIT` as an integer literal to work with real prepared statements (`ATTR_EMULATE_PREPARES=false`).

### Cron Setup by Environment

- Windows (local/server):
  - Open Task Scheduler and create a task to run every 5 minutes.
  - Program/script: path to `php.exe` (e.g., `C:\wamp64\bin\php\php8.x\php.exe`).
  - Arguments: `c:\wamp64\www\rcnmissionhospital\cron\send_queued_emails.php`.
  - Start in: `c:\wamp64\www\rcnmissionhospital`.
  - Run whether user is logged on or not; set highest privileges if needed.

- Shared Hosting (cPanel):
  - Cron command example:
    ```
    /usr/local/bin/php /home/<cpanel_user>/public_html/rcnmissionhospital/cron/send_queued_emails.php > /home/<cpanel_user>/logs/cron.log 2>&1
    ```
  - Schedule: Every 5 minutes.
  - Adjust paths (`<cpanel_user>`, subfolder) to your account.

- Linux VPS (Ubuntu/Debian):
  - Edit crontab: `crontab -e`
  - Add:
    ```
    */5 * * * * /usr/bin/php /var/www/rcnmissionhospital/cron/send_queued_emails.php > /var/log/rcnmissionhospital/cron.log 2>&1
    ```
  - Ensure `/var/log/rcnmissionhospital/` exists and is writable.

- Cloud/VM platforms (AWS/GCP/Azure/DigitalOcean):
  - Use the VM’s cron as above.
  - On managed platforms, consult their scheduler docs and point to the PHP CLI with your app path.

Notes:
- Match `SMTP_SECURE` to your provider: `tls` (587) or `ssl` (465), or `none` if unencrypted.
- Ensure `includes/constants.php` has correct SMTP and DB values in production.
- Logs for cron runs write to `logs/cron_job.log` by default; you can also redirect the CLI output as shown above.

## Logging

- Logger: `includes/logger.php` writes JSON lines to `logs/app.log` and per-category files.
- Rotation: controlled by `LOG_MAX_BYTES` (default 2MB) and `LOG_MAX_FILES` (default 5).
- Primary categories and files:
  - `cron_job` → `logs/cron_job.log` (email queue runs, sends, failures, backoff, fatal errors).
  - `paypal_ipn` → `logs/paypal_ipn.log` (IPN validation, donations, subscriptions, unhandled events, errors).
  - `paystack_payment` → `logs/paystack_payment.log` (one-time and recurring init, errors, success payloads).
  - `newsletter` → `logs/newsletter.log` (admin delete actions, public confirm/unsubscribe success/errors).
  - `admin_settings` → `logs/admin_settings.log` (settings save actions and summarized configuration state).
  - `contact` → `logs/contact.log` (contact form submissions and related actions).
- Inspecting logs on Windows:
  - Open `logs/` files directly with a text editor; entries are JSON objects with `time`, `level`, `category`, `message`, and `context`.

## Recent Enhancements (Operational)

- Structured logging added across critical flows (PayPal IPN, Paystack init endpoints, newsletter admin/public endpoints, admin settings, and the email queue cron).
- Email queue improvements:
  - UTF‑8 charset for PHPMailer.
  - Clears `Reply-To` between sends; sets sender reply-to for `contact` emails when provided.
  - Plain‑text `AltBody` generated from HTML for better readability.
  - Safe `LIMIT` handling compatible with MySQL prepared statements.
- Cron logging category aligned to `cron_job` for clarity and consistent file naming.
- New SMTP configuration constants:
  - `SMTP_AUTH` to toggle SMTP authentication.
  - `SMTP_SECURE` to select encryption (`tls`, `ssl`, or `none`).

## Handover Checklist

- [ ] Database imported and credentials configured.
- [ ] Admin user created with secure password (update sample hashes).
- [ ] `includes/constants.php` updated for production (DB, SMTP, payments).
- [ ] `PAYPAL_BUSINESS_EMAIL`, return/cancel URLs, and sandbox toggle set.
- [ ] `uploads/` writable and backups configured.
- [ ] IPN tested (one-time and recurring) and entries visible in admin.
- [ ] Public pages verified (blog, outreach, resources, trips).
- [ ] Security reviewed (HTTPS, CSRF, sessions, auth roles).

## Maintenance

- Regularly back up database and `uploads/`.
- Monitor `admin/donations.php` and `admin/subscriptions.php` for payment events.
- Keep Composer dependencies up to date (`composer install` if vendor changes).
- Log and review site activities via `audit_logs` (extend as needed).

## Live Deployment

### Shared Hosting (cPanel)

- Upload files:
  - Use cPanel File Manager or FTP to upload all project files into `public_html/` (root) or a subfolder (e.g., `public_html/rcnmissionhospital/`).
  - If deploying in a subfolder, `BASE_PATH` auto-detects and links will work without changes.
- Database:
  - Create a MySQL database and user in cPanel, grant all privileges.
  - Import `database.sql` using phpMyAdmin.
  - Update DB credentials in `includes/constants.php` (`DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`).
- PHP version:
  - Set PHP 8.x via cPanel “Select PHP Version”.
- HTTPS:
  - Enable AutoSSL/Let’s Encrypt in cPanel. Ensure your site loads on `https://`.
- File permissions:
  - Typical: directories `755`, files `644`.
  - Ensure `uploads/` is writable by the web server. If you see upload errors, temporarily set to `775` or `777` (not recommended for long-term).
- PayPal IPN:
  - Update forms to use a full `notify_url` pointing to `https://yourdomain.com/api/paypal/ipn.php`.
  - Set `PAYPAL_USE_SANDBOX=false` for live mode.
- Verify:
  - Test content pages, resource uploads, and outreach report media embedding.
  - Make a small live test donation and confirm it appears in `admin/donations.php`.

### VPS/Dedicated – Apache (Ubuntu/Debian)

1. Copy files to server: `/var/www/rcnmissionhospital`.
2. Create virtual host `/etc/apache2/sites-available/rcnmissionhospital.conf`:
   ```
   <VirtualHost *:80>
     ServerName yourdomain.com
     DocumentRoot /var/www/rcnmissionhospital
     <Directory /var/www/rcnmissionhospital>
       AllowOverride All
       Require all granted
     </Directory>
     ErrorLog ${APACHE_LOG_DIR}/rcnmissionhospital_error.log
     CustomLog ${APACHE_LOG_DIR}/rcnmissionhospital_access.log combined
   </VirtualHost>
   ```
3. Enable site and modules:
   - `a2ensite rcnmissionhospital`
   - `a2enmod rewrite`
   - `systemctl reload apache2`
4. Install PHP 8.x (`apt install php php-mysql php-xml php-gd`).
5. Configure MySQL and import `database.sql`.
6. Set ownership and permissions:
   - `chown -R www-data:www-data /var/www/rcnmissionhospital`
   - `find /var/www/rcnmissionhospital -type d -exec chmod 755 {} \;`
   - `find /var/www/rcnmissionhospital -type f -exec chmod 644 {} \;`
7. HTTPS with Let’s Encrypt:
   - `apt install certbot python3-certbot-apache`
   - `certbot --apache -d yourdomain.com`
8. Update `includes/constants.php` with production DB and payment settings.

### VPS/Dedicated – Nginx (Ubuntu/Debian)

1. Copy files to server: `/var/www/rcnmissionhospital`.
2. Create server block `/etc/nginx/sites-available/rcnmissionhospital`:
   ```
   server {
     listen 80;
     server_name yourdomain.com;
     root /var/www/rcnmissionhospital;
     index index.php index.html;

     location / {
       try_files $uri $uri/ /index.php?$query_string;
     }

     location ~ \.php$ {
       include snippets/fastcgi-php.conf;
       fastcgi_pass unix:/run/php/php8.2-fpm.sock; # adjust for your PHP-FPM
     }

     location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg)$ {
       expires 30d;
       access_log off;
     }
   }
   ```
3. Enable and reload:
   - `ln -s /etc/nginx/sites-available/rcnmissionhospital /etc/nginx/sites-enabled/`
   - `nginx -t && systemctl reload nginx`
4. Install PHP-FPM (`apt install php-fpm php-mysql`).
5. Configure MySQL and import `database.sql`.
6. Set ownership and permissions (e.g., `www-data`).
7. HTTPS:
   - `apt install certbot python3-certbot-nginx`
   - `certbot --nginx -d yourdomain.com`
8. Update `includes/constants.php` with production DB and payment settings.

### Windows Server – IIS

- Install PHP and configure FastCGI.
- Add a new IIS site:
  - Physical path: `C:\inetpub\rcnmissionhospital` (copy project files here).
  - Binding: `yourdomain.com`, port 80/443.
- Handler Mappings: ensure `.php` is handled by FastCGI.
- Default Document: add `index.php`.
- URL Rewrite: configure rules if needed to route to `index.php`.
- Permissions: grant write access to `uploads/` for `IIS_IUSRS`.
- HTTPS: install certificate and bind to the site.
- Update `includes/constants.php` with production DB and payment settings.

### Production Configuration Notes

- `BASE_PATH` auto-detects subdirectory deployments (e.g., `https://yourdomain.com/rcnmissionhospital/`). Test links; if you use a reverse proxy or unusual setup, consider hardcoding `BASE_PATH`.
- Set `PAYPAL_USE_SANDBOX=false` and ensure `notify_url` uses your full HTTPS domain.
- Ensure `uploads/` exists and is writable. The app auto-creates `uploads/resources/` when needed.

### Production Checklist

- Domain points to server and site loads on HTTPS.
- Database imported; credentials set in `includes/constants.php`.
- PHP version 8.x configured (Apache/Nginx/IIS).
- File permissions correct; `uploads/` writable.
- PayPal forms updated with full `notify_url`; sandbox disabled for live.
- Test donation processed; entry visible in `admin/donations.php`.
- Outreach media embeds render on `outreach-report/view.php`.
- Backups configured for DB and `uploads/`.

### Troubleshooting (Production)

- 500 errors:
  - Check web server error logs.
  - On Nginx, `.htaccess` is ignored; ensure routing is in the server block.
- Upload failures:
  - Verify permissions and `MAX_UPLOAD_BYTES`.
  - Confirm allowed file extensions in `admin/resources.php` if expanding types.
- IPN not recording:
  - Use HTTPS; ensure firewall allows PayPal POSTs.
  - Verify `notify_url` and check access logs for IPN hits.

## Contact & Credits

For support and further development:

Designed and Developed by Pinnacle Tech Hub

- Phone: +2347032078859
- Email: techspiresolutionsltd@gmail.com


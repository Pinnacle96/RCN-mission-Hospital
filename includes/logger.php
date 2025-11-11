<?php
// Simple file logger for app and cron flows

function logger_dir(): string {
  $dir = __DIR__ . '/../logs';
  if (!is_dir($dir)) {
    @mkdir($dir, 0775, true);
  }
  return $dir;
}

function rotate_if_needed(string $path): void {
  $maxBytes = defined('LOG_MAX_BYTES') ? (int)LOG_MAX_BYTES : (2 * 1024 * 1024);
  $maxFiles = defined('LOG_MAX_FILES') ? (int)LOG_MAX_FILES : 5;
  if ($maxBytes <= 0 || $maxFiles <= 0) return;
  clearstatcache(true, $path);
  if (file_exists($path) && filesize($path) !== false && filesize($path) >= $maxBytes) {
    // Rotate: file -> file.1, file.1 -> file.2, ..., up to maxFiles
    for ($i = $maxFiles; $i >= 2; $i--) {
      $src = $path . '.' . ($i - 1);
      $dst = $path . '.' . $i;
      if (file_exists($src)) {
        @rename($src, $dst);
      }
    }
    @rename($path, $path . '.1');
    // Create a fresh file
    @touch($path);
  }
}

function log_write(string $category, string $level, string $message, array $context = []): void {
  $dir = logger_dir();
  $time = date('Y-m-d H:i:s');
  $line = json_encode([
    'time' => $time,
    'level' => strtoupper($level),
    'category' => $category,
    'message' => $message,
    'context' => $context,
  ], JSON_UNESCAPED_SLASHES);
  if ($line === false) {
    $line = $time . " [" . strtoupper($level) . "] " . $category . ": " . $message;
  }
  $appLog = $dir . '/app.log';
  $catLog = $dir . '/' . preg_replace('/[^a-z0-9_-]+/i', '_', $category) . '.log';
  rotate_if_needed($appLog);
  rotate_if_needed($catLog);
  @file_put_contents($appLog, $line . PHP_EOL, FILE_APPEND);
  @file_put_contents($catLog, $line . PHP_EOL, FILE_APPEND);
}

function log_info(string $category, string $message, array $context = []): void {
  log_write($category, 'info', $message, $context);
}

function log_error(string $category, string $message, array $context = []): void {
  log_write($category, 'error', $message, $context);
}

?>
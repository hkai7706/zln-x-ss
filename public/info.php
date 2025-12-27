<?php
phpinfo();
echo "\n\nPublic Path: " . __DIR__;
echo "\n\nCSS exists: " . (file_exists(__DIR__ . '/css/main.css') ? 'YES' : 'NO');
if (is_dir(__DIR__ . '/css')) {
    echo "\n\nFiles in CSS folder: " . print_r(scandir(__DIR__ . '/css'), true);
}
?>
<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $status = Password::sendResetLink(['email' => 'sasangkalambang96@gmail.com']);
    echo "Status: " . ($status === Password::RESET_LINK_SENT ? "LINK SENT" : $status) . "\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

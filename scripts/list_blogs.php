<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Blog;

$blogs = Blog::orderByDesc('id')->take(10)->get(['id','titulo','slug','publicado','published_at','user_id']);
$result = [];
foreach ($blogs as $b) {
    $result[] = [
        'id' => $b->id,
        'titulo' => $b->titulo,
        'slug' => $b->slug,
        'publicado' => (bool)$b->publicado,
        'published_at' => $b->published_at ? $b->published_at->toDateTimeString() : null,
        'user_id' => $b->user_id,
    ];
}
echo json_encode($result, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) . PHP_EOL;

<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Blog;

$blog = Blog::find(1);
if (!$blog) {
    echo "Blog id=1 not found\n";
    exit(1);
}

echo "id: {$blog->id}\n";
echo "titulo: {$blog->titulo}\n";
echo "youtube_url: " . ($blog->youtube_url ?? 'NULL') . "\n";
echo "youtubeId(): " . ($blog->youtubeId() ?? 'NULL') . "\n";
echo "youtubeEmbedUrl(): " . ($blog->youtubeEmbedUrl() ?? 'NULL') . "\n";

<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Topic;
use App\Models\Template;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Support\MessageBag;

Auth::loginUsingId(1);

$topic = Topic::where('slug', 'rtxpost-transplant-aki-rejection')->first();
if (!$topic) { echo "Topic not found
"; exit; }

$errors = new ViewErrorBag;
$errors->put('default', new MessageBag);

try {
    echo view('admin.topics.edit', [
        'topic' => $topic->load(['template', 'category']),
        'templates' => Template::query()->orderBy('name')->get(),
        'categories' => Category::query()->orderBy('name')->get(),
        'errors' => $errors,
    ])->render();
} catch (Throwable $e) {
    echo $e, "
";
}

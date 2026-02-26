<?php

namespace App\Http\Controllers\Traits;
use App\Models\Tag;

trait HasTags
{
    protected function syncTags($model, ?string $tagsString): void
    {
        if (!$tagsString) {
            $model->tags()->detach();
            return;
        }

        $tagNames = collect(explode(' ', $tagsString))
            ->map(fn($tag) => strtolower(trim(str_replace('#', '', $tag))))
            ->filter()
            ->unique();

            $tagIds = $tagNames->map(fn($name) => 
            Tag::firstOrCreate(['nombre' => $name])->id
        );

        $model->tags()->sync($tagIds);
    }
}
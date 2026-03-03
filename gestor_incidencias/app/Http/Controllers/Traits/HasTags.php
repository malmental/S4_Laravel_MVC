<?php

namespace App\Http\Controllers\Traits;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

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
            ->unique()
            ->values();

        if ($tagNames->isEmpty()) {
            $model->tags()->detach();
            return;
        }

        $tagIds = DB::table('tags')
            ->whereIn('nombre', $tagNames)
            ->pluck('id')
            ->toArray();

        $nuevosTags = $tagNames->filter(fn($name) => !in_array($name, DB::table('tags')->whereIn('nombre', $tagNames)->pluck('nombre')->toArray()));

        foreach ($nuevosTags as $name) {
            $tagIds[] = Tag::create(['nombre' => $name])->id;
        }

        $model->tags()->sync($tagIds);
    }
}
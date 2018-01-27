<?php

namespace App\Helpers\WebApps\ELearning;

class ArticlesHelper
{
    public static function index($page, $op, $data, $section = null)
    {
        if ($op === 'create') {
            return static::store($page, $data);
        } elseif ($op === 'get') {
            return static::show($section);
        } elseif ($op === 'update') {
            return static::update($section, $data);
        } elseif ($op === 'delete') {
            return static::destroy($section);
        } elseif ($op === 'get-site') {
            return static::show($section);
        }
    }

    public static function show($section)
    {
        return $section->load('contents', 'extras');
    }

    public static function store($page, $data)
    {
        $section = $page->sections()->create(['title' => $data['title'], 'type' => $data['type']]);
        $section->contents()->create(['type' => 'paragraph', 'content' => $data['paragraph']]);
        if ($data['img']) {
            $section->contents()->create(['type' => 'img', 'content' => $data['img']]);
        }
        foreach ($data['tags'] as $tag) {
            $section->extras()->create(['type' => 'tag', 'content' => $tag]);
        }
        return $section;
    }

    public static function update($section, $data)
    {
        $section->update(['title' => $data['title'], 'type' => $data['type']]);
        $section->contents()->where('type', 'paragraph')->update(['content' => $data['paragraph']]);
        $section->contents()->where('type', 'img')->delete();
        if ($data['img']) {
            $section->contents()->create(['type' => 'img', 'content' => $data['img']]);
        }
        $section->extras()->where('type', 'tag')->delete();
        foreach ($data['tags'] as $tag) {
            $section->extras()->create(['type' => 'tag', 'content' => $tag]);
        }
        return $section;
    }

    public static function destroy($section)
    {
        $section->contents()->delete();
        $section->extras()->delete();
        $section->delete();
        return $section;
    }
}

<?php


namespace App\Helpers\Blogs\Template1;

class ConstantHelper
{
    public static function which($op, $data, $constant)
    {
        if ($op === 'update') {
            return static::update($data, $constant);
        } elseif ($op === 'get') {
            return static::show($constant);
        }
    }

    public static function update($data, $constant)
    {
        $constant->contents()->update(['active' => false]);
        foreach ($data['footer'] as $type) {
            if ($type === 'paragraph') {
                $constant->contents()->updateOrCreate(['type' => 'paragraph'], ['content' => $data['paragraph'], 'active' => true]);
            } elseif ($type === 'links') {
                $constant->contents()->updateOrCreate(['type' => 'links'], ['active' => true]);
            }
        }
        $content = $constant->contents()->where('type', 'links')->first();
        if ($content) {
            $content->extras()->delete();
            foreach ($data['links'] as $key => $link) {
                if ($link) {
                    $content->extras()->updateOrCreate(['type' => $key], ['content' => $link]);
                }
            }
        }

        return $constant;
    }

    public static function show($constant)
    {
        return $constant->load('contents.extras', 'site.extras');
    }
}

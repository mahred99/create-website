<?php

namespace App\Helpers\WebApps\ELearning;

class ExtraHelper
{
    public static function which($page, $op, $data, $component = null)
    {
        if ($page->slug === 'courses') {
            switch ($op) {
                case 'create-sections':
                    return self::createFile($component, $data);
                    break;
                case 'create-contents':
                    return self::createComment($component, $data);
                    break;
                case 'get':
                    return self::showExtra($component);
                    break;
                case 'update':
                    return self::updateFile($component, $data);
                    break;
                case 'delete':
                    return self::destroyExtra($component);
                    break;
            }
        }
    }

    public static function createFile($section, $data)
    {
        return $section->extras()->create([
            'type' => 'file',
            'title' => $data['title'],
            'content' => $data['file']
        ]);
    }

    public static function createComment($content, $data)
    {
        return $content->extras()->create([
            'type' => 'comment',
            'title' => $data['user'],
            'content' => $data['comment']
        ]);
    }

    public static function showExtra($extra)
    {
        return $extra->load('extraable.extras');
    }

    public static function destroyExtra($extra)
    {
        return $extra->delete();
    }

    public static function updateFile($extra)
    {
        return $extra->update([
            'title' => request('title'),
            'content' => request('file')
        ]);
    }
}

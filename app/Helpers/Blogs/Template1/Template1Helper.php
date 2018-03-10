<?php

namespace App\Helpers\Blogs\Template1;

class Template1Helper
{
    public static function scaffold($site)
    {
        $home = $site->addPage(['title' => 'Home Page', 'homePage' => true, 'slug' => '']);
        $post = $site->addPage(['title' => 'Post', 'slug' => 'post']);
        return $site;
    }

    public static function doThis($site, $page, $op, $data, $component)
    {
        if ($op === 'scaffold') {
            return static::scaffold($site);
        } elseif ($op === 'site') {
            $template1 = new Template1SiteHelper($site);
            return $template1->site($page, $data);
        } elseif ($op === 'dashboard') {
            $template1 = new Template1SiteHelper($site);
            return $template1->dashboard($page, $data, $component);
        } elseif ($op === 'dashboard-load-action') {
            $template1 = new Template1SiteHelper($site);
            return $template1->loadAction($data, $component);
        } elseif ($op === 'getSection') {
            return SectionHelper::which('get', $data, $component);
        } elseif ($op === 'updateSection') {
            return SectionHelper::which('update', $data, $component);
        } elseif ($op === 'get-content') {
            return ContentHelper::which('get', $component);
        } elseif ($op === 'delete-content') {
            return ContentHelper::which('delete', $component);
        } elseif ($op === 'create-section-site') {
            return SectionHelper::which('create-site', $data, $component, $page);
        } elseif ($op === 'api-info') {
            $template1 = new Template1SiteHelper($site);
            return $template1->apiInfo($data);
        } elseif ($op === 'site-update') {
            $template1 = new Template1SiteHelper($site);
            return $template1->update($data);
        }
    }
}

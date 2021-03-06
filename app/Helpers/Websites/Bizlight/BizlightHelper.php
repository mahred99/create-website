<?php

namespace App\Helpers\Websites\Bizlight;

use App\Site;

/**
 * Helper Class For Bizlight template
 * to perform the general Functions
 */
class BizlightHelper
{
    /**
     * Scaffold the template for the site
     * @param  App\Site  $site
     * @return App\Site
     */
    public static function scaffold($site)
    {
        $home = $site->addPage(['title' => 'Home Page', 'homePage' => true, 'slug' => '']);
        $home->sections()->create(['title' => 'show-case', 'order' => 1]);
        $home->sections()->create(['title' => 'accordion', 'order' => 2]);
        $home->sections()->create(['title' => 'horizontal-list', 'order' => 3]);
        $home->sections()->create(['title' => 'paragraph-image', 'order' => 4]);

        $about = $site->addPage(['title' => 'About', 'homePage' => false, 'slug' => 'about']);

        $services = $site->addPage(['title' => 'Services', 'homePage' => false, 'slug' => 'services']);

        $top_nav = $site->constants()->create(['type' => 'top-nav']);

        $contact = $site->addPage(['title' => 'Contact', 'homePage' => false, 'slug' => 'contact']);
        return $site;
    }

    /**
     * Find the proper helper class for the operation
     * @param  App\Site $site       The site that the request belongs to
     * @param  App\Page $page       The page that the request belongs to
     * @param  String $op           What Operation is requested
     * @param  Array $data          Request Data
     * @param  [type] $component    Any Other Models that the request might need
     * @return Array                Data that the Operation needs
     */
    public static function doThis($site, $page, $op, $data, $component)
    {
        if ($op === 'scaffold') {
            return static::scaffold($site);
        } elseif ($op === 'updateSection') {
            return SectionHelper::which($page, 'update', $data, $component);
        } elseif ($op === 'site') {
            $site = new BizlightSiteHelper($site->id);
            return $site->site($page);
        } elseif ($op === 'dashboard') {
            $site = new BizlightSiteHelper($site->id);
            return $site->dashboard($page, $data);
        } elseif ($op === 'getSection') {
            return SectionHelper::which($page, 'get', null, $component);
        } elseif ($op === 'createSection') {
            return SectionHelper::which($page, 'create', $data);
        } elseif ($op === 'deleteSection') {
            return SectionHelper::which($page, 'delete', $data, $component);
        } elseif ($op === 'constant-update') {
            return ConstantHelper::which('update', $data, $component);
        } elseif ($op === 'constant-get') {
            return ConstantHelper::which('get', $data, $component);
        } elseif ($op === 'get-page-auth') {
            return PageHelper::which('get', $page);
        } elseif ($op === 'delete-content') {
            return ContentHelper::whcih($component, $op, $data);
        } elseif ($op === 'update-page') {
            return PageHelper::which('update', $page, $data);
        } elseif ($op === 'api-info') {
            $site = new BizlightSiteHelper($site->id);
            return $site->apiInfo($data);
        } elseif ($op === 'site-update') {
            $site = new BizlightSiteHelper($site->id);
            return $site->update($data);
        }
    }
}

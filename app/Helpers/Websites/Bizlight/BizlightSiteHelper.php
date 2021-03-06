<?php

namespace App\Helpers\Websites\Bizlight;

use App\Page;
use App\Site;

/**
 * Helper Class For Bizlight template
 * to perform Function For View it's views files
 */
class BizlightSiteHelper
{
    /**
     * The site that the request belongs to
     * @var  App\Site $site
     */
    private $site;

    /**
     * For instantiate App\Site $site
     * @param Integer $id   Site ID
     */
    public function __construct($id)
    {
        $this->site = Site::findOrFail($id);
    }

    /**
     * Find The proper helper function to retrive the data
     * by pages's slug
     * @param  String $slug     Page's slug
     * @return Array            Contins view's location and data needed
     */
    public function site($slug)
    {
        if ($slug === 'index') {
            $location = $this->site->theme->location . '.site.' . $slug;
            $data = $this->homePage();
            return compact('location', 'data');
        } elseif ($slug === 'about') {
            $location = $this->site->theme->location . '.site.' . $slug;
            $data = $this->about();
            return compact('location', 'data');
        } elseif ($slug === 'services') {
            $location = $this->site->theme->location . '.site.' . $slug;
            $data = $this->services();
            return compact('location', 'data');
        } elseif ($slug === 'contact') {
            $location = $this->site->theme->location . '.site.' . $slug;
            $data = $this->contact();
            return compact('location', 'data');
        }
    }

    /**
     * Dashboard related views
     * @param  App\Page $page      The page that the request belongs to
     * @param  Array $data         Request Data
     * @return Array               Contins view's location and data needed
     */
    public function dashboard($page, $data)
    {
        if (is_int($page)) {
            $page = Page::findOrFail($page);
            $page->load('sections.contents');
            $location = $this->site->theme->location . '.dashboard.' . $data . '.show';
            $site = $this->site;
            $data = collect([$page]);
            return compact('location', 'data');
        } elseif (is_string($page)) {
            $pages = ['navigation', 'media', 'settings', 'analytics'];
            abort_if(! in_array($page, $pages), 404);
            $data = ['site' => $this->site];
            $location = $this->site->theme->location . '.dashboard.' . $page;
            return compact('location', 'data');
        }
    }

    /**
     * Bizlight Template Navigation Bar
     * @return Array    Data needed for the Navigation Bar
     */
    public function nav()
    {
        $site = $this->site;
        $nav = $site->constants()->where('type', 'top-nav')->with('contents')->first();
        $links = $nav->contents()->where('type', 'link')->get();
        $logo = $site->extras()->where('type', 'logo')->first();
        return compact('links', 'logo');
    }

    /**
     * Bizlight Home Page
     * @return Array  Data needed for the Home Page
     */
    public function homePage()
    {
        $site = $this->site;
        $nav = $this->nav();
        $page = $site->pages()->where('homePage', true)->first();
        $page->logs()->create(['type' => 'page-log', 'action' => 'load']);
        $showCase = $page->sections()->where('title', 'show-case')->with('contents')->first();
        $accordion = $page->sections()->where('title', 'accordion')->with('contents')->first();
        $horizontalList = $page->sections()->where('title', 'horizontal-list')->with('contents')->first();
        $paragraphImage = $page->sections()->where('title', 'paragraph-image')->with('contents')->first();
        return compact('site', 'nav', 'showCase', 'accordion', 'horizontalList', 'paragraphImage');
    }

    /**
     * Bizlight About Page
     * @return Array  Data needed for the About Page
     */
    public function about()
    {
        $site = $this->site;
        $nav = $this->nav();
        $page = $site->pages()->where('slug', 'about')->first();
        $page->logs()->create(['type' => 'page-log', 'action' => 'load']);
        $section = $page->sections()->where('title', 'about')->with('contents')->first();
        return compact('site', 'nav', 'section');
    }

    /**
     * Bizlight Services Page
     * @return Array  Data needed for the Services Page
     */
    public function services()
    {
        $site = $this->site;
        $nav = $this->nav();
        $page = $site->pages()->where('slug', 'services')->first();
        $page->logs()->create(['type' => 'page-log', 'action' => 'load']);
        $section = $page->sections()->where('title', 'services')->with('contents')->first();
        return compact('site', 'nav', 'section');
    }

    /**
     * Bizlight Contact Page
     * @return Array  Data needed for the Contact Page
     */
    public function contact()
    {
        $site = $this->site;
        $nav = $this->nav();
        $page = $site->pages()->where('slug', 'contact')->first();
        // $page->logs()->create(['type' => 'page-log', 'action' => 'load']);
        return compact('site', 'nav', 'page');
    }

    public function apiInfo($type)
    {
        if ($type === 'site-info') {
            return $this->site->load('extras');
        } elseif ($type === 'page-analytics') {
            return $this->pageAnalytics();
        }
    }

    public function pageAnalytics()
    {
        $page = $this->site->pages()->where('homePage', true)->first();
        $years = $page->logs->groupBy(
            function ($item, $key) {
                return \Carbon\Carbon::parse($item['created_at'])->year;
            }
        )->toArray();
        $months = $page->logs->groupBy(
            function ($item, $key) {
                $month = \Carbon\Carbon::parse($item['created_at'])->month;
                return date("F", mktime(0, 0, 0, $month, 1));
            }
        )->toArray();
        return ['months' => $months, 'years' => $years];
    }

    public function update($data)
    {
        if ($data['name']) {
            $this->site->update(['name' => $data['name']]);
        }
        if ($data['logo']) {
            $this->site->extras()->updateOrCreate(['type' => 'logo'], ['content' => $data['logo']]);
        }
        return $this->site;
    }
}

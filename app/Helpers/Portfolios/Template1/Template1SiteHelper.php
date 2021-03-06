<?php

namespace App\Helpers\Portfolios\Template1;

class Template1SiteHelper
{
    public function __construct($site)
    {
        $this->site = $site;
    }

    public function site($slug, $id)
    {
        abort_if($slug != 'index' || $id, 404);
        $page = $this->site->pages()->where('homePage', true)->first();
        $page->logs()->create(['type' => 'page-log', 'action' => 'load']);
        $page->load(['sections' => function ($query) {
            $query->orderBy('order', 'asc');
        }, 'sections.extras', 'sections.contents']);
        $sections =  $page->sections->whereNotIn('title', ['Left Show Case'])->whereIn('active', [1]);
        $location = $this->site->theme->location . '.site.index';
        $data = ['site' => $this->site, 'slug' => $slug, 'page' => $page, 'sections' => $sections];
        return compact('location', 'data');
    }

    public function dashboard($type, $data, $component)
    {
        $pages = ['media', 'settings', 'analytics'];
        abort_if(! in_array($type, $pages), 404);
        $location = $this->site->theme->location . '.dashboard.' . $type;
        $page = $this->site->pages()->where('homePage', true)->first();
        $page->load(['sections' => function ($query) {
            $query->orderBy('order', 'asc');
        }, 'sections.contents']);
        $data = ['site' => $this->site, 'page' => $page];
        return compact('location', 'data');
    }

    public function loadAction($data, $component)
    {
        if ($data['action'] === 'update') {
            if ($data['type'] === 'sections') {
                return $this->loadUpdateSection($component);
            }
        }
        abort(404);
    }

    public function loadUpdateSection($id)
    {
        $page = $this->site->pages()->where('homePage', true)->with('sections.contents')->first();
        $section = $page->sections()->find($id);
        $location = $this->site->theme->location . '.dashboard.sections.update';
        $data = ['page' => $page, 'site' => $this->site, 'section' => $section];
        return compact('location', 'data');
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
        return $this->site;
    }
}

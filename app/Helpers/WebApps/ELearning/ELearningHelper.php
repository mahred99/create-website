<?php

namespace App\Helpers\WebApps\ELearning;

use App\Site;

class ELearningHelper
{
    public static function scaffold($site)
    {
        $home = $site->addPage(['title' => 'Home Page', 'homePage' => true, 'slug' => '']);
        $home->sections()->create(['title' => 'showcase']);
        $home->sections()->create(['title' => 'articles']);
        $home->sections()->create(['title' => 'courses']);

        $profile = $site->addPage(['title' => 'Profile', 'homePage' => false, 'slug' => 'profile']);
        $signup = $site->addPage(['title' => 'Register', 'homePage' => false, 'slug' => 'register']);
        $signin = $site->addPage(['title' => 'Login', 'homePage' => false, 'slug' => 'login']);
        $contact = $site->addPage(['title' => 'Contact', 'homePage' => false, 'slug' => 'contact']);
        $articles = $site->addPage(['title' => 'Articles', 'homePage' => false, 'slug' => 'articles']);
        $article = $site->addPage(['title' => 'Article', 'homePage' => false, 'slug' => 'article']);
        $courses = $site->addPage(['title' => 'Courses', 'homePage' => false, 'slug' => 'courses']);
        $course = $site->addPage(['title' => 'Course', 'homePage' => false, 'slug' => 'course']);
        $lesson = $site->addPage(['title' => 'Lesson', 'homePage' => false, 'slug' => 'lesson']);
        $forum = $site->addPage(['title' => 'forum', 'homePage' => false, 'slug' => 'forum']);
        $footer = $site->constants()->create(['type' => 'footer']);
        return $site;
    }

    public static function doThis($site, $page, $op, $data, $component)
    {
        if ($op === 'scaffold') {
            return static::scaffold($site);
        } elseif ($op === 'site') {
            $eLearning = new ELearningSiteHelper($site->id);
            return $eLearning->site($page, $data);
        } elseif ($op === 'dashboard') {
            $eLearning = new ELearningSiteHelper($site->id);
            return $eLearning->dashboard($page, $data, $component);
        } elseif ($op === 'api-info') {
            $eLearning = new ELearningSiteHelper($site->id);
            return $eLearning->apiInfo($data);
        } elseif ($op === 'create-section-auth') {
            return SectionHelper::which($page, 'create', $data);
        } elseif ($op === 'getSection') {
            return SectionHelper::which($page, 'get', $data, $component);
        } elseif ($op === 'updateSection') {
            return SectionHelper::which($page, 'update', $data, $component);
        } elseif ($op === 'deleteSection') {
            return SectionHelper::which($page, 'delete', $data, $component);
        } elseif ($op === 'dashboard-load-page') {
            $eLearning = new ELearningSiteHelper($site->id);
            return $eLearning->loadPage($data, $component);
        } elseif ($op === 'dashboard-load-action') {
            $eLearning = new ELearningSiteHelper($site->id);
            return $eLearning->loadAction($data, $component);
        } elseif ($op === 'createContent') {
            return ContentHelper::which($page, 'create', $data, $component);
        } elseif ($op === 'getContent') {
            return ContentHelper::which($page, 'get', $data, $component);
        } elseif ($op === 'updateContent') {
            return ContentHelper::which($page, 'update', $data, $component);
        } elseif ($op === 'deleteContent') {
            return ContentHelper::which($page, 'delete', $data, $component);
        } elseif ($op === 'get-page-auth') {
            return PageHelper::which($page, 'get-auth');
        } elseif ($op === 'updatePage') {
            return PageHelper::which($page, 'update', $data);
        } elseif ($op === 'get-page') {
            return PageHelper::which($page, 'get');
        } elseif ($op === 'get-section-site') {
            return SectionHelper::which($page, 'get-site', $data, $component);
        } elseif ($op === 'get-content-site') {
            return ContentHelper::which($page, 'get-site', $data, $component);
        } elseif ($op === 'createSection') {
            return SectionHelper::which($page, 'create', $data);
        } elseif ($op === 'constant-update') {
            return ConstantHelper::which('update', $data, $component);
        } elseif ($op === 'constant-get') {
            return ConstantHelper::which('get', $data, $component);
        } elseif ($op === 'site-update') {
            $eLearning = new ELearningSiteHelper($site->id);
            return $eLearning->update($data);
        } elseif ($op === 'user-info') {
            $eLearning = new ELearningSiteHelper($site->id);
            return $eLearning->userInfo($component);
        } elseif ($op === 'user-update') {
            $eLearning = new ELearningSiteHelper($site->id);
            return $eLearning->userUpdate($data, $component);
        } elseif ($op === 'create-extra-sections') {
            return ExtraHelper::which($page, 'create-sections', $data, $component);
        } elseif ($op === 'create-extra-contents') {
            return ExtraHelper::which($page, 'create-contents', $data, $component);
        } elseif ($op === 'get-extra') {
            return ExtraHelper::which($page, 'get', $data, $component);
        } elseif ($op === 'update-extra') {
            return ExtraHelper::which($page, 'update', $data, $component);
        } elseif ($op === 'delete-extra') {
            return ExtraHelper::which($page, 'delete', $data, $component);
        }
    }
}

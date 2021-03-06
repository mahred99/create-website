require('../../../bootstrap');
require('../../../vue-froala-wysiwyg');

const Vue = require('vue');
import VueFroala from 'vue-froala-wysiwyg';
import store from './store';
import Buefy from 'buefy';

// chartjs package
require('chart.js');
// vue-charts package
require('hchs-vue-charts');
Vue.use(VueCharts);

Vue.use(Buefy);
Vue.use(VueFroala);

Vue.store = store;
// Site Components
Vue.component('app', require('./components/site/auth/App.vue'));
Vue.component('nav-bar', require('./components/site/nav/NavBar.vue'));
Vue.component('side-nav', require('./components/site/nav/SideNav.vue'));
Vue.component('site-register', require('./components/site/auth/Register.vue'));
Vue.component('site-login', require('./components/site/auth/Login.vue'));
Vue.component('site-courses', require('./components/site/pages/Courses.vue'));
Vue.component('site-course', require('./components/site/pages/Course.vue'));
Vue.component('site-lesson', require('./components/site/pages/Lesson.vue'));
Vue.component('site-articles', require('./components/site/pages/Articles.vue'));
Vue.component('site-article', require('./components/site/pages/Article.vue'));
Vue.component('site-contact', require('./components/site/pages/Contact.vue'));
Vue.component('site-home', require('./components/site/pages/Home.vue'));
Vue.component('site-footer', require('./components/site/pages/Footer.vue'));
Vue.component('comment-section', require('./components/site/sections/CommentSection.vue'));

// Dashboard Components
Vue.component('media', require('./components/dashboard/Media.vue'));
Vue.component('users', require('./components/dashboard/Users.vue'));
Vue.component('courses', require('./components/dashboard/Courses.vue'));
Vue.component('courses-crud', require('./components/dashboard/Courses-CRUD.vue'));
Vue.component('lessons', require('./components/dashboard/Lessons.vue'));
Vue.component('lessons-cu', require('./components/dashboard/Lessons-CU.vue'));
Vue.component('files', require('./components/dashboard/Files.vue'));
Vue.component('files-cu', require('./components/dashboard/Files-CU.vue'));
Vue.component('articles', require('./components/dashboard/Articles.vue'));
Vue.component('articles-cu', require('./components/dashboard/Articles-CU.vue'));
Vue.component('home-page', require('./components/dashboard/homePage.vue'));
Vue.component('contact', require('./components/dashboard/Contact.vue'));
Vue.component('footer-settings', require('./components/dashboard/Footer.vue'));
Vue.component('settings', require('./components/dashboard/Settings.vue'));
Vue.component('profile', require('./components/dashboard/Profile.vue'));
Vue.component('analytics', require('./components/dashboard/AnalyticsPage.vue'));


const app = new Vue({
    el: '#app',
    store
});



window.Vue = Vue;



require('../../../sidebar');

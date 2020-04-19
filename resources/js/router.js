import Vue from 'vue'
import VueRouter from 'vue-router'
import DashboardPage from "./pages/DashboardPage";

Vue.use(VueRouter);

const routes = [
  /*{ path: '/', component: DashboardPage },*/
  { path: '/', component: DashboardPage },
  { path: '/movies', component: () => import('./pages/MoviesPage') },
  { path: '/series', component: () => import('./pages/SeriesPage') },
  { path: '/categories', component: () => import('./pages/movies/CategoriesPage') },
  { path: '/categories/:id/movies', component: () => import('./pages/movies/MoviesPage'), name: 'categories.movies' },
  { path: '/categories-series', component: () => import('./pages/series/CategoriesSeriesPage'), name: 'categories-series' },
  { path: '/categories-series/:id/series', component: () => import('./pages/series/SeriesPage'), name: 'categories.series' },
  { path: '/series/:id/seasons', component: () => import('./pages/series/SeasonsPage'), name: 'series.seasons' },
  { path: '/series/:serie_id/seasons/:id/chapters', component: () => import('./pages/series/ChaptersPage'), name: 'seasons.chapters' },
];

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
export default new VueRouter({
  routes // short for `routes: routes`
});

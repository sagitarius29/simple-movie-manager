import Vue from 'vue'
import VueRouter from 'vue-router'
import DashboardPage from "./pages/DashboardPage";
import CategoriesPage from "./pages/CategoriesPage";
import MoviesPage from "./pages/MoviesPage";
import CategoriesSeriesPage from "./pages/series/CategoriesSeriesPage";
import SeriesPage from "./pages/series/SeriesPage";
import SeasonsPage from "./pages/series/SeasonsPage";
import ChaptersPage from "./pages/series/ChaptersPage";

Vue.use(VueRouter);

const routes = [
  /*{ path: '/', component: DashboardPage },*/
  { path: '/', component: CategoriesPage },
  { path: '/categories', component: CategoriesPage },
  { path: '/categories/:id/movies', component: MoviesPage, name: 'categories.movies' },
  { path: '/categories-series', component: CategoriesSeriesPage, name: 'categories-series' },
  { path: '/categories-series/:id/series', component: SeriesPage, name: 'categories.series' },
  { path: '/categories-series/:cat_id/series/:id/seasons', component: SeasonsPage, name: 'series.seasons' },
  { path: '/series/:serie_id/seasons/:id/chapters', component: ChaptersPage, name: 'seasons.chapters' },
];

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
export default new VueRouter({
  routes // short for `routes: routes`
});

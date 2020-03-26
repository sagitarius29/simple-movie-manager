import Vue from 'vue'
import VueRouter from 'vue-router'
import DashboardPage from "./pages/DashboardPage";
import CategoriesPage from "./pages/CategoriesPage";
import MoviesPage from "./pages/MoviesPage";

Vue.use(VueRouter);

const routes = [
  /*{ path: '/', component: DashboardPage },*/
  { path: '/', component: CategoriesPage },
  { path: '/categories/:id', component: MoviesPage }
];

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
export default new VueRouter({
  routes // short for `routes: routes`
});

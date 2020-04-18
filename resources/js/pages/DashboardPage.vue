<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Principal</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <router-link to="/categories" class="btn btn-light btn-options">
                                    <i class="fas fa-list"></i><br>Categorías Películas
                                </router-link>
                            </div>
                            <div class="col-md-3">
                                <router-link to="/categories" class="btn btn-light btn-options">
                                    <i class="fas fa-list"></i><br>Categorías Películas
                                </router-link>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-light btn-options">
                                    <i class="fas fa-film"></i><br>Películas
                                </button>
                            </div>
                            <div class="col-md-3">
                                <router-link to="/categories" class="btn btn-light btn-options">
                                    <i class="fas fa-list"></i><br>Categorías
                                </router-link>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: "DashboardPage",
  }
</script>

<style scoped>
    .btn-options {
        width: 100%;
    }
</style>

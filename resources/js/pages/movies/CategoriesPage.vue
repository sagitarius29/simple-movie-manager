<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <list-page-component header-title="Lista de Categorias Películas"
                                     endpoint="categories"
                                     element-name="Categoría"
                                     :element-default="documentDefault"
                                     :table-fields="tableFields"
                                     ref="listPage">
                    <template v-slot:storeupdate="{document, errors}">
                        <form-dynamic-component endpoint="categories/form-schema" :document="document" :errors="errors"/>
                    </template>
                    <template v-slot:actionicon="{rowData}">
                        <router-link :to="{name: 'categories.movies', params: {id: rowData.id}}" class="btn btn-outline-primary" title="Lista de Películas"><i class="fas fa-film"/></router-link>
                    </template>
                </list-page-component>
            </div>
        </div>
    </div>
</template>

<script>
  import ListPageComponent from "../../components/ListPageComponent";
  import FormDynamicComponent from "../../components/FormDynamicComponent";
  export default {
    name: "CategoriesPage",
    components: {FormDynamicComponent, ListPageComponent},
    data() {
      return {
        documentDefault: {
          name: null,
          order: null
        },
        tableFields: [
          {
            title: 'Orden',
            name: 'order',
          },
          {
            title: 'Nombre',
            name: 'name',
          },
          {
            title: 'Acciones',
            name: '__slot:actions',
          }
        ]
      }
    }
  }
</script>

<style scoped>

</style>

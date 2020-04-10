<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <list-page-component header-title="Lista de Categorias de Series"
                                     endpoint="categories-series"
                                     element-name="Categoría"
                                     :element-default="documentDefault"
                                     :table-fields="tableFields"
                                     ref="listPage">
                    <template v-slot:storeupdate="{document, errors}">
                        <form-dynamic-component endpoint="categories-series/form-schema" :document="document" :errors="errors"/>
                    </template>
                    <template v-slot:actionicon="{rowData}">
                        <router-link :to="{name: 'categories.series', params: {id: rowData.id}}" class="btn btn-outline-primary" title="Lista de Series"><i class="fas fa-film"/></router-link>
                    </template>
                </list-page-component>
            </div>
        </div>
    </div>
</template>

<script>
  import FormDynamicComponent from "../../components/FormDynamicComponent";
  import ListPageComponent from "../../components/ListPageComponent";

  export default {
    name: "CategoriesSeriesPage",
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

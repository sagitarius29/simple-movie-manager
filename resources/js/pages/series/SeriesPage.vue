<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <list-page-component :header-title="'Lista de Series: ' + categoryName"
                                     :endpoint="'categories-series/'+$route.params.id+'/series'"
                                     element-name="Serie"
                                     :element-default="documentDefault"
                                     :table-fields="tableFields"
                                     ref="listPage">
                    <template v-slot:storeupdate="{document, errors}">
                        <form-dynamic-component :endpoint="'categories-series/'+$route.params.id+'/series/form-schema'" :document="document" :errors="errors"/>
                    </template>

                    <template v-slot:actionicon="{rowData}">
                        <router-link :to="{name: 'series.seasons', params: {id: rowData.id, cat_id: $route.params.id}}" class="btn btn-outline-primary" title="Lista de Temporadas"><i class="fas fa-film"/></router-link>
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
    name: "SeriesPage",
    components: {FormDynamicComponent, ListPageComponent},
    data() {
      return {
        categoryName: null,
        documentDefault: {
          name: null,
          url: null,
          cover: null
        },
        tableFields: [
          {
            title: 'Cover',
            name: 'cover',
            callback(value) {
              return '<img src="'+value+'" style="max-width: 150px;">';
            }
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
    },
    mounted() {
      this.loadCategory();
    },
    methods: {
      loadCategory() {
        axios.get('/categories-series/'+this.$route.params.id).then(({data}) => {
          this.categoryName = data.name;
        });
      }
    }
  }
</script>

<style scoped>

</style>

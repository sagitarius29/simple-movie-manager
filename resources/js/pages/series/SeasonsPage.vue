<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <list-page-component :header-title="'Lista de Temporadas: ' + serieName"
                                     :endpoint="'series/'+$route.params.id+'/seasons'"
                                     element-name="Temporada"
                                     :element-default="documentDefault"
                                     :table-fields="tableFields"
                                     ref="listPage">
                    <template v-slot:storeupdate="{document, errors}">
                        <form-dynamic-component :endpoint="'series/'+$route.params.id+'/seasons/form-schema'" :document="document" :errors="errors"/>
                    </template>

                    <template v-slot:actionicon="{rowData}">
                        <router-link :to="{name: 'seasons.chapters', params: {id: rowData.id, serie_id: $route.params.id}}" class="btn btn-outline-primary" title="Lista de Capítulos"><i class="fas fa-film"/></router-link>
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
    name: "SeasonsPage",
    components: {FormDynamicComponent, ListPageComponent},
    data() {
      return {
        serieName: null,
        documentDefault: {
          name: null,
          url: null,
          cover: null
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
    },
    mounted() {
      this.loadCategory();
    },
    methods: {
      loadCategory() {
        axios.get('/categories-series/'+this.$route.params.cat_id+'/series/'+this.$route.params.id).then(({data}) => {
          this.serieName = data.name;
        });
      }
    }
  }
</script>

<style scoped>

</style>

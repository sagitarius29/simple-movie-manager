<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <list-page-component :header-title="'Lista de Películas: ' + categoryName"
                                     :endpoint="'categories/'+$route.params.id+'/movies'"
                                     element-name="Película"
                                     :element-default="documentDefault"
                                     :table-fields="tableFields"
                                     ref="listPage">
                    <template v-slot:storeupdate="{document, errors}">
                        <form-dynamic-component endpoint="movies/form-schema" :document="document" :errors="errors"/>
                    </template>
                </list-page-component>
            </div>
        </div>
    </div>
</template>

<script>
  import FormDynamicComponent from "../components/FormDynamicComponent";
  import ListPageComponent from "../components/ListPageComponent";

  export default {
    name: "MoviesPage",
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
            title: 'Video Url',
            name: 'url',
            callback(value) {
              if(value == null) {
                return '-';
              }
              return '<a href="'+value+'" target="_blank">Ir a Video</a>';
            }
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
        axios.get('/categories/'+this.$route.params.id).then(({data}) => {
          this.categoryName = data.name;
        });
      }
    }
  }
</script>

<style scoped>

</style>

<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <list-page-component :header-title="'Lista de Capítulos: ' + seasonName"
                                     :endpoint="'seasons/'+$route.params.id+'/chapters'"
                                     element-name="Capítulo"
                                     :element-default="documentDefault"
                                     :table-fields="tableFields"
                                     ref="listPage">
                    <template v-slot:storeupdate="{document, errors}">
                        <form-dynamic-component :endpoint="'seasons/'+$route.params.id+'/chapters/form-schema'" :document="document" :errors="errors"/>
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
    name: "ChaptersPage",
    components: {FormDynamicComponent, ListPageComponent},
    data() {
      return {
        seasonName: null,
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
        axios.get('/series/'+this.$route.params.serie_id+'/seasons/'+this.$route.params.id).then(({data}) => {
          this.seasonName = data.name;
        });
      }
    }
  }
</script>

<style scoped>

</style>

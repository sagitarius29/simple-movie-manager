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
                        <div class="form-group">
                            <label>Película existente (Opcional)</label>
                            <dynamic-select v-model="document.id" :config="{endpoint: 'movies', nameField: 'name', valueField: 'id'}" @onSelected="selectMovie(document, $event)"/>
                        </div>
                        <div class="form-group">
                            <label>Cover URL</label>
                            <input v-model="document.cover" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Cover Imagen</label>
                            <image-upload-input v-model="document.cover" :private="0"/>
                        </div>
                        <div class="form-group">
                            <label>Nombre</label>
                            <input v-model="document.name" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Video URL</label>
                            <input v-model="document.url" type="text" class="form-control">
                        </div>
                    </template>
                </list-page-component>
            </div>
        </div>
    </div>
</template>

<script>
  import FormDynamicComponent from "../components/FormDynamicComponent";
  import ListPageComponent from "../components/ListPageComponent";
  import DynamicSelect from "../components/inputs/DynamicSelect";
  import ImageUploadInput from "../components/inputs/ImageUploadInput";

  export default {
    name: "MoviesPage",
    components: {ImageUploadInput, DynamicSelect, FormDynamicComponent, ListPageComponent},
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

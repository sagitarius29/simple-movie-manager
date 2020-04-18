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
                        <div class="form-group">
                            <label>Serie existente (Opcional)</label>
                            <dynamic-select v-model="document.id" :config="{endpoint: 'series', nameField: 'name', valueField: 'id'}" @onSelected="selectSerie(document, $event)"/>
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
  import DynamicSelect from "../../components/inputs/DynamicSelect";
  import ImageUploadInput from "../../components/inputs/ImageUploadInput";

  export default {
    name: "SeriesPage",
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
      },
      selectSerie(document, serie) {
        document.cover = serie.cover;
        document.name = serie.name;
      }
    }
  }
</script>

<style scoped>

</style>

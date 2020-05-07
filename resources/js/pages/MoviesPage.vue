<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <list-page-component header-title="Lista de Películas en General"
                                     endpoint="movies"
                                     element-name="Película"
                                     :element-default="documentDefault"
                                     :table-fields="tableFields"
                                     :more-params="moreParams"
                                     ref="listPage">

                    <template v-slot:storeupdate="{document, errors}">
                        <div class="form-group">
                            <label>Categorías</label>
                            <dynamic-select v-model="document.categories" :config="{endpoint: 'categories', nameField: 'name', valueField: 'id', multiple:true}" :load-resource-on-select="false"/>
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

                    <template v-slot:actionicon="{rowData}">
                        <a :href="rowData.player" target="_blank" class="btn btn-outline-primary" title="Reproductor"><i class="fa fa-play-circle"/></a>
                    </template>
                </list-page-component>
            </div>
        </div>
    </div>
</template>

<script>
  import ListPageComponent from "../components/ListPageComponent";
  import DynamicSelect from "../components/inputs/DynamicSelect";
  import ImageUploadInput from "../components/inputs/ImageUploadInput";
  export default {
    name: "MoviesPage",
    components: {ImageUploadInput, DynamicSelect, ListPageComponent},
    data() {
      return {
        documentDefault: {
          name: null,
          url: null,
          cover: null,
          categories: []
        },
        moreParams: {
          filterCols: '',
          withRelation: 'categories'
        },
        tableFields: [
          {
            title: 'Cover',
            name: 'cover',
            callback(value) {
              return '<img src="'+value+'" style="max-width: 120px;">';
            }
          },
          {
            title: 'Nombre',
            name: 'name',
          },
          {
            title: 'Categoría',
            name: 'categories',
            callback(categories) {
              return _.map(categories, (category) => {
                return category.name;
              }).join(', ');
            }
          },
          {
            title: 'Acciones',
            name: '__slot:actions',
          }
        ]
      }
    },
    methods: {
      hasVideoPlayer(url) {
        let regex = new RegExp('\.mp4$', 'i');
        return regex.test(url);
      }
    }
  }
</script>

<style scoped>

</style>

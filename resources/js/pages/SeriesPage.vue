<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <list-page-component header-title="Lista de Series"
                                     :endpoint="'series'"
                                     element-name="Serie"
                                     :element-default="documentDefault"
                                     :table-fields="tableFields"
                                     :more-params="moreParams"
                                     ref="listPage">

                    <template v-slot:storeupdate="{document, errors}">
                        <div class="form-group">
                            <label>Categorías</label>
                            <dynamic-select v-model="document.categories" :config="{endpoint: 'categories-series', nameField: 'name', valueField: 'id', multiple:true}" :load-resource-on-select="false"/>
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
  import ListPageComponent from "../components/ListPageComponent";
  import DynamicSelect from "../components/inputs/DynamicSelect";
  import ImageUploadInput from "../components/inputs/ImageUploadInput";
  export default {
    name: "SeriesPage",
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
    }
  }
</script>

<style scoped>

</style>

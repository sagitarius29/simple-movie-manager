<template>
    <div>
        <v-select :value="selected"
                  @input="setSelected"
                  :multiple="config.multiple"
                  :options="options"
                  @search="onSearch"
                  :label="config.nameField"
                  :placeholder="placeholder"
                  :filterable="false">
            <template v-slot:option="option">
                <slot :option="option" name="option">
                    {{ option[config.nameField] }}
                </slot>
            </template>
            <div slot="no-options">No se han encontrado resultados.</div>
        </v-select>
    </div>
</template>

<script>
  import vSelect from 'vue-select'
  export default {
    name: "DynamicSelect",
    components: {vSelect},
    props: {
      value: {
        default: null
      },
      loadResourceOnSelect: {
        default: true
      },
      placeholder: {
        default: ''
      },
      config: {
        default() {
          return {
            endpoint: null,
            valueField: 'value',
            nameField: 'name',
            multiple: false,
            loadIfSelect: true
          }
        }
      },
    },
    data() {
      return {
        selected: '',
        selectedObject: null,
        options: []
      }
    },
    mounted() {
      if(this.value !== null && this.selected === '') {
        this.getDocumentInfo(this.value);
      }
      this.loadOptions();
    },
    watch: {
      value(val) {
        if(val === null) {
          this.selected = '';
        } else {
          this.getDocumentInfo(val);
        }
      }
    },
    methods: {
      onSearch(search, loading) {
        loading(true);
        this.search(loading, search, this);
      },
      search: _.debounce((loading, search, vm) => {
        api.get(
          vm.config.endpoint + '?search=' + search,
          {
            noloading: true
          }
        ).then(({data}) => {
          vm.options = data.data;
          loading(false);
        });
      }, 350),
      loadOptions() {
        api.get(this.config.endpoint).then((r) => {
          this.options = r.data.data;
        });
      },
      setSelected(object) {
        if( object !== null) {
          let val = object[this.config.valueField];
          this.selected = object[this.config.nameField];
          this.selectedObject = object;

          this.$emit('input', val);
          this.$emit('onSelected', object);
        } else {
          this.$emit('onReset', this.selectedObject);
          this.$emit('input', '');
          this.selected = '';
          this.selectedObject = null;
        }
      },
      getDocumentInfo(id) {
        if(id === '' || id === null) {
          return false
        }

        if(this.config.loadIfSelect !== undefined && !this.config.loadIfSelect) {
          return false;
        }
        api.get(this.config.endpoint + '/' + id).then((r) => {
          this.selected = r.data[this.config.nameField];
        });
      }
    }
  }
</script>

<style scoped>

</style>

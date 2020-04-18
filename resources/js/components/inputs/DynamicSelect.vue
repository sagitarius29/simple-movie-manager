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
          return {}
        }
      },
    },
    data() {
      return {
        defaultConfig: {
          endpoint: null,
          valueField: 'value',
          nameField: 'name',
          multiple: false,
          loadIfSelect: true
        },
        selected: '',
        selectedObject: null,
        options: []
      }
    },
    mounted() {
      this.defaultConfig = _.defaults(this.config, this.defaultConfig);
      if (this.defaultConfig.multiple) {
        this.defaultConfig.loadIfSelect = false;
      }

      if (this.value !== null && this.selected === '') {
        this.getDocumentInfo(this.value);
      }
      this.loadOptions();
    },
    watch: {
      value(val) {
        if (val === null) {
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
        axios.get(
          vm.defaultConfig.endpoint + '?search=' + search,
          {
            noloading: true
          }
        ).then(({data}) => {
          vm.options = data.data;
          loading(false);
        });
      }, 350),
      loadOptions() {
        axios.get(this.defaultConfig.endpoint).then((r) => {
          this.options = r.data.data;
        });
      },
      setSelected(object) {
        console.log('select ', object);
        if (object !== null) {
          let val;
          if (!this.defaultConfig.multiple) {
            val = object[this.defaultConfig.valueField];
            this.selected = object[this.defaultConfig.nameField];
            this.selectedObject = object;
          } else {
            val = object;
            this.selected = object;
            this.selectedObject = object;
          }

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
        if (id === '' || id === null) {
          return false
        }

        if (this.defaultConfig.loadIfSelect !== undefined && !this.defaultConfig.loadIfSelect) {
          return false;
        }
        axios.get(this.defaultConfig.endpoint + '/' + id).then((r) => {
          this.selected = r.data[this.defaultConfig.nameField];
        });
      }
    }
  }
</script>

<style scoped>

</style>

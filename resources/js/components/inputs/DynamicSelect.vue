<template>
    <div>
        <v-select :value="selected"
                  @input="setSelected"
                  :multiple="config.multiple"
                  :options="options"
                  @search="onSearch"
                  :label="defaultConfig.nameField"
                  :placeholder="placeholder"
                  :filterable="false">
            <template v-slot:option="option">
                <slot :option="option" name="option">
                    {{ option[defaultConfig.nameField] }}
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
        selected: null,
        selectedObject: null,
        options: []
      }
    },
    beforeMount() {
      //Loading Config
      this.defaultConfig = _.defaults(this.config, this.defaultConfig);
      if (this.defaultConfig.multiple) {
        this.defaultConfig.loadIfSelect = false;
      }
    },
    mounted() {
      this.loadOptions();
      this.getDocumentInfo(this.value);
    },
    watch: {
      value(val) {
        this.getDocumentInfo(val);
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
        if(this.defaultConfig.multiple) {
          this.$emit('input', object);
          this.$emit('onSelected', object);
        } else {
          this.$emit('input', object[this.defaultConfig.valueField]);
          this.$emit('onSelected', object);
        }
      },
      getDocumentInfo(value) {
        if (!value) {
          return false
        }

        if(this.defaultConfig.multiple) {
          this.selected = value;
          return true;
        }

        if (this.defaultConfig.loadIfSelect !== undefined && !this.defaultConfig.loadIfSelect) {
          return false;
        }

        axios.get(this.defaultConfig.endpoint + '/' + value).then((r) => {
          this.selected = r.data[this.defaultConfig.nameField];
        });
      }
    }
  }
</script>

<style scoped>

</style>

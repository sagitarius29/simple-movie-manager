<template>
  <b-card :header="headerTitle">
    <b-row>
      <b-col cols="12">
        <div class="form-group form-inline pull-right">
          <input type="search" class="form-control" v-model="search" placeholder="Buscar"/>
          &nbsp;<button v-if="permissions.create" @click="actionsExe('store')" class="btn btn-primary">Nuevo</button>
          <slot name="buttons"/>
        </div>
        <div class="clearfix"></div>
        <div>
          <ul class="nav nav-tabs">
            <slot name="nav-tabs">
              <li class="nav-item">
                <a class="nav-link active" href="#">Todos</a>
              </li>
            </slot>
          </ul>
          <div class="tab-content p-4">
            <data-table-component :api="apiRoot + endpoint" :fields="tableFieldsComputed" :key="keyList" ref="dataTable">
              <template v-slot:actionicon="{rowData}">
                <slot name="actionicon" v-bind:rowData="rowData"/>
              </template>
            </data-table-component>
          </div>
        </div>
      </b-col>
    </b-row>
    <div>
      <data-crud-component :element-name="elementName"
                           :default="elementDefault"
                           :endpoint="endpoint"
                           ref="crudModal"
                           :modal-lg="modalLg"
                           :primary-key="primaryKey"
                           @save="onSave">

        <template v-slot:storeupdate="{document, errors}">
          <slot v-bind:document="document" v-bind:errors="errors" name="storeupdate">
          </slot>
        </template>

        <template v-slot:show="{document}">
          <slot v-bind:document="document" name="show">
          </slot>
        </template>
      </data-crud-component>
    </div>
  </b-card>
</template>

<script>
  import DataTableComponent from "./DataTableComponent";
  import DataCrudComponent from "./DataCrudComponent";
  const _ = require('lodash');

  export default {
    name: "ListPageComponent",
    components: {DataCrudComponent, DataTableComponent},
    props: {
      headerTitle: {
        default: ''
      },
      tableFields: {
        default() {
          return [];
        }
      },
      customTable: {
        default: null
      },
      endpoint: {
        default: null
      },
      elementName: {
        required: true
      },
      elementDefault: {
        required: true
      },
      modalLg: {
        default: false
      },
      primaryKey: {
        default: 'id'
      },
      permissions: {
        default() {
          return {
            create: true
          }
        }
      },
      groups: [
        { title: 'Todos', moreParams: { filterCols: '' } },
        { title: 'Ejecutivos', moreParams: 'email,juan@test.com,text' },
      ],
    },
    data() {
      return {
        apiRoot: '/',
        search: '',
        paginate: ['filteredItems'],
        items: [],
        loadedTableFields: [],
        keyList: 0
      }
    },
    computed: {
      tableFieldsComputed() {
        if(this.customTable != null) {
          return this.loadedTableFields;
        }
        return this.tableFields;
      }
    },
    watch: {
      search(value) {
        this.onSearch(value, this);
      }
    },
    methods: {
      onSearch: _.debounce((search, vm) => {
        vm.$refs.dataTable.search(search);
      }, 350),
      onSave(document) {
        this.$refs.dataTable.refresh();
        this.$emit('onSave', document);
      },
      onErrorInput(errors) {
        console.log(errors);
      },
      actionsExe(action, data) {
        if(action === 'show' && this.$parent.onActionShow !== undefined) {
          this.$parent.onActionShow(data);
        } else if(action === 'update' && this.$parent.onActionUpdate !== undefined) {
          this.$parent.onActionUpdate(data);
        } else if(action === 'store' && this.$parent.onActionStore !== undefined) {
          this.$parent.onActionStore(data);
        } else {
          this.$refs.crudModal.actions(action, data);
        }
      },
      reloadTable() {
        this.loadTableFields().then(() => {
          this.keyList += 1;
        });
      },
      callbackTags(value) {
        let render = '';
        _.forEach(value, tag => render += '<span class="badge badge-secondary">'+tag+'</span>')
        return render;
      }
    }
  }
</script>

<style scoped>

</style>

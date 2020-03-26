<template>
  <div>
    <section class="table-responsive" v-if="fields.length > 0">
      <vuetable ref="vuetable"
                :api-url="api"
                :fields="fields"
                data-path="data"
                pagination-path=""
                class="table header-border table-striped"
                ascending-icon="fa fa-sort-amount-asc"
                descending-icon="fa fa-sort-amount-desc"
                :per-page="perPage"
                loading-class="loading-div"
                @vuetable:pagination-data="onPaginationData"
                :append-params="moreParams"
                :http-options="httpOptions"
                @vuetable:loading="$store.commit('loading')"
                @vuetable:loaded="$store.commit('endLoading')"
      >

        <template slot="actions" slot-scope="{rowData}">
          <div v-if="typeof rowData.acl != 'undefined'" class="text-center" >
            <div class="btn-group btn-group-sm">
              <slot name="actionicon" v-bind:rowData="rowData"/>
              <button v-if="rowData.acl.show" @click="$parent.actionsExe('show', rowData)" class="btn btn-outline-primary" title="Ver"><i class="fa fa-eye"/></button>
              <button v-if="rowData.acl.update" @click="$parent.actionsExe('update', rowData)" class="btn btn-outline-primary" title="Editar"><i class="fa fa-edit"/></button>
              <button v-if="rowData.acl.delete" @click="$parent.actionsExe('delete', rowData)" class="btn btn-outline-primary" title="Eliminar"><i class="fa fa-trash"/></button>
            </div>
          </div>
        </template>

        <template v-for="slotName in moreSlots" :slot="slotName" slot-scope="{rowData}">
          <slot :name="slotName" v-bind:rowData="rowData"/>
        </template>

      </vuetable>
    </section>
    <vuetable-pagination ref="pagination" :css="defaultCss" @vuetable-pagination:change-page="onChangePage"/>
  </div>
</template>

<script>
  import Vuetable from 'vuetable-2';
  import VuetablePagination from 'vuetable-2/src/components/VuetablePagination';
  import store from "../store";

  export default {
    name: "DataTableComponent",
    components: {
      Vuetable, VuetablePagination
    },
    props: {
      api: {
        required: true
      },
      fields: {
        required:true
      },
      perPage: {
        type: Number,
        default: 15
      },
      moreSlots: {
        default() {
          return []
        }
      },
      moreParams: {
        default() {
          return {
            filterCols: ''
          }
        }
      }
    },
    data: function() {
      return {
        paginationComponent: 'vuetable-pagination',
        paginationInfoTemplate: 'Mostrando {from} a {to} de {total} elementos',
        httpOptions: {
          headers: {
            Authorization: 'Bearer ' + store.getters['user/getToken']
          }
        },
        defaultCss: {
          wrapperClass: 'mt-2 mb-2 sg-paginator text-right',
          activeClass: 'active',
          disabledClass: 'disabled',
          pageClass: 'btn btn-light ml-1',
          linkClass: 'btn btn-light',
          paginationClass: '',
          paginationInfoClass: '',
          dropdownClass: '',
          icons: {
            first: 'fa fa-angle-double-left',
            prev: 'fa fa-angle-left',
            next: 'fa fa-angle-right',
            last: 'fa fa-angle-double-right',
          }
        },
        flags: {
          inProccess: false
        },
      };
    },
    methods: {
      onPaginationData(paginationData) {
        this.$refs.pagination.setPaginationData(paginationData);
      },
      onChangePage(page) {
        this.$refs.vuetable.changePage(page);
      },
      refresh() {
        this.$refs.vuetable.reload();
      },
      filterCols(data) {
        this.moreParams.filterCols = data;

        this.$refs.vuetable.refresh();
      },
      search(value) {
        this.moreParams.search = value;
        this.$refs.vuetable.refresh();
      },
    }
  }
</script>

<style scoped>

</style>

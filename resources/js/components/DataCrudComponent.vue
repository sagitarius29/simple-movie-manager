<template>
  <div class="modal fade" :id="'modal'+_uid" tabindex="-10" role="dialog" aria-hidden="true">
    <div :class="modalLg ? 'modal-dialog modal-lg' : 'modal-dialog'" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ title }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" v-if="document != null">
          <slot v-if="type !== 'show'" v-bind:document="document" v-bind:errors="errors" name="storeupdate">Here content Store Update</slot>
          <slot v-else v-bind:document="document" name="show">Here content show</slot>
        </div>
        <div class="modal-footer">
          <div class="text-left" style="flex: auto;">
            <button v-if="type === 'update'" type="button" class="btn btn-danger" @click="deleteElement(document)">Eliminar</button>
          </div>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button v-if="type !== 'show'" @click="saveDocument()" type="button" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

  export default {
    name: "DataCrudComponent",
    props: {
      elementName: {
        default: 'Elemento'
      },
      default: {
        required: true
      },
      endpoint: {
        required: true
      },
      modalLg: {
        default: false
      },
      primaryKey: {
        default: 'id'
      },
    },
    data() {
      return {
        type: 'store',
        comp_id: null,
        document: null,
        uid: 0,
        errors: {}
      }
    },
    computed: {
      title() {
        if(this.type === 'show') {
          return 'Detalles de ' + this.elementName;
        }
        if(this.type === 'update') {
          return 'Modificar ' + this.elementName;
        }
        return 'Crear ' + this.elementName;
      }
    },
    mounted() {
      this.comp_id = this._uid;
    },
    methods: {
      showModal() {
        this.errors = {};
        $('#modal'+this._uid).modal('show');
      },
      hideModal() {
        $('#modal'+this._uid).modal('hide');
      },
      actions(event, element) {
        this.reset();
        this.type = event;
        if(event === 'show') {
          this.document = _.merge(this.document, element);
          this.showModal();
        } else if(event === 'update') {
          this.document = _.merge(this.document, element);
          this.showModal();
        } else if(event === 'delete') {
          this.deleteElement(element);
        } else {
          this.showModal();
        }
      },
      reset() {
        this.document = JSON.parse(JSON.stringify(this.default));
      },
      deleteElement(element) {
        sgConfirm('Atención', '¿Está seguro de eliminar este elemento?', 'Si, Eliminar', () => {
          axios.delete(this.endpoint + '/' + element.id).then((r) => {
            Toast.fire('Felicitaciones', 'Se ha eliminado correctamente.', 'success');
            this.$emit('save', 'success');
            this.hideModal();
          });
        });
      },
      saveDocument() {
        let method = 'post';

        let url = this.endpoint;

        if(this.type === 'update') {
          url = url + '/' + this.document[this.primaryKey];
          method = 'patch';
        }

        axios[method](url, this.document).then((r) => {
          Toast.fire('Felicitaciones', 'Se ha guardado correctamente.', 'success');
          this.$emit('save', 'success');
          this.hideModal();
        }, (r) => {
          if(r.data.errors !== undefined) {
            this.errors = r.data.errors;
          }
          console.log('hay un error', r.data);
        });
      }
    }
  }
</script>

<style scoped>

</style>

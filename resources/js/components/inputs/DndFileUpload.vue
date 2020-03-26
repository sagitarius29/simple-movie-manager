<template>
  <div>
    <b-progress class="my-2" :value="uploaded" :max="100" show-progress :animated="uploading"></b-progress>
    <div class="inputDnD">
      <input type="file" class="form-control-file text-primary font-weight-bold" ref="inputFile" @change="readUrl($event)" :data-title="dataTitle" :accept="accept">
    </div>
  </div>
</template>

<script>
  export default {
    name: "DndFileUpload",
    props: {
      endpoint: {
        default: null
      },
      placeholder: {
        default: 'Arrastrar y Soltar Archivo'
      },
      accept: {
        default: '*/*'
      }
    },
    data() {
      return {
        fileName: null,
        uploading: false,
        uploaded: 0,
        error: false
      }
    },
    computed: {
      dataTitle() {
        let uploadCorrect = ' (Subiendo)';

        if(this.uploaded === 100 && this.error === false) {
          uploadCorrect = ' (Carga Correcta)'
        } else if(this.error === true) {
          uploadCorrect = ' (Error durante la carga)'
        }

        if(this.fileName != null) {
          return this.fileName + uploadCorrect;
        }
        return this.placeholder;
      }
    },
    methods: {
      readUrl(ev) {
        let input = ev.target;
        if (input.files && input.files[0]) {
          this.fileName = input.files[0].name;

          this.uploadFile(input.files[0]);
        }
      },
      uploadFile(file) {
        if(this.endpoint == null) {
          console.error('Component Endpoint not defined, please assign a endpoint URL.');
          return false;
        }

        let data = new FormData();
        data.append('file', file);

        this.uploading = true;
        this.error = false;

        api.post(this.endpoint, data, {
          onUploadProgress: this.onProgress,
          noloading: true,
        }).then(({data}) => {
          this.$emit('onUploadSuccess', data);
        }, () => {
          this.$emit('onUploadFail');
          this.error = true;
        }).finally(() => {
          this.uploading = false;
        });
      },
      onProgress(progressEvent) {
        this.uploaded = (progressEvent.loaded / progressEvent.total) * 100;
      },
      deleteFile: function(file) {
        let index = this.files.indexOf(file);
        Swal.fire({
          title: 'Esta seguro de eliminar este Documento?',
          text: "No puede dar marcha atrás si procede!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, Eliminar Ahora!'
        }).then((result) => {
          if (result.value) {

            if(this.id != null) {
              axios.delete(this.apiRoot+'/attachment/'+file.id+'/delete').then(() => {
                this.files.splice(index, 1);
                Toast.fire({
                  type: 'success',
                  title: 'Archivo eliminado correctamente.'
                });
              });
            } else {
              this.files.splice(index, 1);
              this.$emit('input', this.files);
              Toast.fire({
                type: 'success',
                title: 'Archivo eliminado correctamente.'
              });
            }

          }
        });
      },
    }
  }
</script>

<style scoped>
  .inputDnD {
    position: relative;
  }

  .inputDnD .form-control-file {
    width: 100%;
    height: 100%;
    min-height: 6em;
    outline: none;
    visibility: hidden;
    cursor: pointer;
    background-color: #c61c23;

  }
  .inputDnD .form-control-file:before {
    content: attr(data-title);
    position: absolute;
    top: 0.5em;
    left: 0;
    width: 100%;
    min-height: 6em;
    line-height: 2em;
    padding-top: 1.5em;
    opacity: 1;
    visibility: visible;
    text-align: center;
    border: 0.25em dashed currentColor;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    overflow: hidden;
  }
  .inputDnD .form-control-file:hover:before {
    border-style: solid;
    box-shadow: inset 0 0 0 0.25em currentColor;
  }
</style>

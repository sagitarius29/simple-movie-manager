<template>
    <div>
        <label :for="'file_'+_uid" class="foto-upload d-flex">
            <div v-if="noimage && !flags.upload" class="no-image align-self-center text-center"><i
                    class="fas fa-cloud-upload-alt"></i><br>Click para subir imagen.
            </div>
            <div v-else-if="flags.upload" class="no-image align-self-center text-center">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                         :aria-valuenow="uploaded" aria-valuemin="0" aria-valuemax="100"
                         :style="'width: '+uploaded+'%'">Subiendo
                    </div>
                </div>
            </div>
            <div class="w-100 text-center" v-else>
                <img class="mw-100 mh-100" :src="value" title="Click para cambiar">
            </div>
        </label>
        <input :id="'file_'+_uid" type="file" class="d-none" @change="uploadFile($event)" accept="image/jpeg,image/png">
    </div>
</template>

<script>
  export default {
    name: "ImageUploadInput",
    props: {
      value: {
        required: true
      },
      private: {
        default: 1
      }
    },
    data() {
      return {
        flags: {
          upload: false
        },
        uploaded: 0
      };
    },
    computed: {
      noimage() {
        return this.value == null;
      }
    },
    methods: {
      uploadFile(ev) {
        let input = ev.target;

        if (input.files.length === 0) {
          Toast.fire('Error', 'No ha seleccionado una imagen.', 'error');
          return false;
        }

        let data = new FormData;
        data.append('imagen', input.files[0]);

        data.append('private', this.private);

        this.flags.upload = true;

        axios.post('/upload/image', data, {
          onUploadProgress: this.onProgress,
          noloading: true
        }).then((r) => {
          this.$emit('input', r.data.url);
        }).finally(() => {
          this.flags.upload = false;
          this.uploaded = 0;
          input.value = '';
        });
      },
      onProgress(progressEvent) {
        this.uploaded = (progressEvent.loaded / progressEvent.total) * 100;
      }
    }
  }
</script>

<style lang="css" scoped>
    .foto-upload {
        border: dashed 3px #ccc;
        padding: 2px;
        height: 190px;
        cursor: pointer;
    }

    .foto-upload:hover {
        border-color: #007bfc;
    }

    .foto-upload .no-image {
        width: 100%;
    }
</style>

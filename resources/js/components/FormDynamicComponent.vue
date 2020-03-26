<template>
  <b-tabs>
    <b-tab v-for="form in forms" :key="form.title" :hidden="hiddenTab">
      <template v-slot:title>
        <div @click="toggleTab()">
          {{ form.title }}
          <span v-if="toggle">
          <i v-if="show" class="fa fa-angle-left"/> <i v-else class="fa fa-angle-down"/>
        </span>
        </div>
      </template>

      <form-component v-if="form.prefix === null" :schema="form.inputs" :errors="errors" :document="document"/>
      <form-component v-else :schema="form.inputs" :errors="errors" :document="document[form.prefix]"
                      :prefix-error="form.prefix + '.'"/>

      <slot></slot>
    </b-tab>
  </b-tabs>
</template>

<script>
  import FormComponent from "./FormComponent";

  export default {
    name: "FormDynamicComponent",
    components: {FormComponent},
    props: {
      endpoint: {
        required: true,
        default: null
      },
      document: {
        required: true,
        default() {
          return null;
        }
      },
      errors: {
        default() {
          return []
        }
      },
      toggle: {
        default: false
      },
    },
    data() {
      return {
        forms: [],
        show: false
      }
    },
    computed: {
      hiddenTab() {
        if(this.toggle === true) {
          return !this.show;
        }
        return false;
      }
    },
    mounted() {
      this.getFormData();
    },
    methods: {
      getFormData() {
        axios.get(this.endpoint).then(({data}) => {
          this.forms = data;
        });
      },
      toggleTab() {
        this.show = !this.show;
      }
    }
  }
</script>

<style scoped>

</style>

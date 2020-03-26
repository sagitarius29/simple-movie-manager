<template>
  <select :value="value" @input="$emit('input', $event.target.value)" class="form-control">
    <option :value="null">--Seleccione--</option>
    <option :value="option[config.valueField]" v-for="option in options"> {{ option[config.nameField] }}</option>
  </select>
</template>

<script>
  export default {
    name: "StaticSelect",
    props: {
      value: {
        default: null
      },
      config: {
        default() {
          return {
            endpoint: null,
            valueField: 'value',
            nameField: 'name'
          }
        }
      },
    },
    data() {
      return {
        options: []
      }
    },
    mounted() {
      this.loadOptions();
    },
    methods: {
      loadOptions() {
        if(this.config.endpoint === null) {
          return false;
        }
        api.get(this.config.endpoint).then(({data}) => {
          this.options = data;
        });
      },
    }
  }
</script>

<style scoped>

</style>

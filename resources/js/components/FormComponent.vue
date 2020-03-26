<template>
  <div class="row">
    <div :class="input.class || 'col-lg-12'" v-for="input in schema">
      <div class="form-group">
        <label>{{ input.title }}</label>
        <input v-if="isHtmlTag(input.type)" :type="input.type" v-model="document[input.bind]" :class="'form-control' + isInvalidClass(input.bind)" />
        <select v-model="document[input.bind]" v-else-if="input.type === 'select'" :class="'form-control' + isInvalidClass(input.bind)" >
          <option :value="null">-- Seleccione --</option>
          <option :value="option.value" v-for="option in input.options">{{ option.name }}</option>
        </select>
        <select v-else-if="input.type === 'boolean'" v-model="document[input.bind]" :class="'form-control' + isInvalidClass(input.bind)">
          <option :value="null">-- Seleccione --</option>
          <option value="1">SI</option>
          <option value="0">NO</option>
        </select>
        <textarea v-else-if="input.type === 'textarea'" v-model="document[input.bind]" :class="'form-control' + isInvalidClass(input.bind)" rows="5"></textarea>
        <tag-input v-else-if="input.type === 'tags'" :tags="document[input.bind]" :config="input.config" @tags-changed="newTags => document[input.bind] = newTags"/>
        <small v-if="input.info !== undefined" class="form-text text-muted">
          {{ input.info }}
        </small>
        <div class="invalid-feedback" v-if="isInvalid(input.bind)">
          {{ errors[prefixError + input.bind][0] }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import TagInput from "./inputs/TagsInput";
  export default {
    name: "FormComponent",
    components: {TagInput},
    props: {
      schema: {
        default() {
          return {};
        }
      },
      errors: {
        default() {
          return [];
        }
      },
      document: {
        required: true
      },
      prefixError: {
        default: ''
      }
    },
    methods: {
      isHtmlTag(tag) {
        return tag === 'text'
          || tag === 'password'
          || tag === 'email'
          || tag === 'number';
      },
      isInvalid(bind) {
        console.log('is invalid', this.prefixError + bind);
        return this.errors[this.prefixError + bind] !== undefined;
      },
      isInvalidClass(bind) {
        if(this.isInvalid(bind)) {
          return ' is-invalid';
        }
        return '';
      }
    }
  }
</script>

<style scoped>

</style>

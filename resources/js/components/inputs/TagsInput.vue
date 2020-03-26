<template>
  <div>
    <vue-tags-input
      v-model="tag"
      :tags="tagsInternal"
      @tags-changed="tagChanged"
      :autocomplete-items="items"
    />
  </div>
</template>

<script>
  import VueTagsInput from '@johmun/vue-tags-input';
  export default {
    name: "TagsInput",
    props: {
      value: {
        default: ''
      },
      tags: {
        default() {
          return []
        }
      },
      config: {
        default() {
          return {
            endpoint: '',
            valueField: 'name',
          }
        }
      }
    },
    components: {
      VueTagsInput
    },
    data() {
      return {
        tag: '',
        tagsInternal: [],
        items: []
      }
    },
    mounted() {
      if(this.tags.length > 0) {
        this.tagsMapping(this.tags);
      }
    },
    watch: {
      tags: 'tagsMapping',
      tag(value) {
        this.onSearch(value);
      }
    },
    methods: {
      tagChanged(newTags) {
        this.tagsInternal = newTags;
        this.$emit('tags-changed', _.map(newTags, (item) => item.text));
      },
      tagsMapping(value) {
        this.tagsInternal = _.map(value, (item) => {
          return {
            text: item
          }
        });
      },
      onSearch(search) {
        this.search(search, this);
      },
      search: _.debounce((search, vm) => {
        api.get(
                vm.config.endpoint + '?search=' + search,
                {
                  noloading: true
                }
        ).then(({data}) => {
          vm.items = _.map(data.data, (item) => {
            return {
              text: item.name.es
            }
          });
        });
      }, 350),
    }
  }
</script>

<style scoped>

</style>

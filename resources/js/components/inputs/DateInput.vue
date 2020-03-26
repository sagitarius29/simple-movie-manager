<template>
  <input v-model="date" @change="onChangeDate($event)" :id="'sg_input_daterange' + _uid" :name="'sg_input_daterange' + _uid" class="form-control" type="text" autocomplete="off">
</template>

<script>
  require('daterangepicker/daterangepicker');

  let element = null;
  export default {
    name: "DateInput",
    props: {
      value: {
        default: ''
      },
      type: {
        default: 'date'
      },
      minDate: {
        default: null
      },
      maxDate: {
        default: null
      }
    },
    data() {
      return {
        date: ''
      }
    },
    watch: {
      value(val) {
        this.setInput(val);
      }
    },
    mounted() {
      this.start();
    },
    methods: {
      start() {
        let config = {
          autoUpdateInput: false,
          locale: {
            format: 'MM/DD/YYYY',
            cancelLabel: 'Clear'
          }
        };

        let element = $('#sg_input_daterange' + this._uid);

        if(this.maxDate !== null) {
          if(this.maxDate === 'today') {
            config.maxDate = moment();
          } else {
            config.maxDate = this.maxDate;
          }
        }

        if(this.minDate !== null) {
          if(this.minDate === 'today') {
            config.minDate = moment();
          } else {
            config.minDate = this.minDate;
          }
        }

        console.log('Type Calendar: ', this.type);

        if(this.type === 'daterange') {
          //element.daterangepicker(config);
        } else if(this.type === 'datetime') {
          config.singleDatePicker = true;
          config.showDropdowns = true;
          config.timePicker = true;
          //config.locale.format = 'MM/DD/YYYY H:mm:ss';
          //element.daterangepicker(config);
        } else {
          config.singleDatePicker = true;
          config.showDropdowns = true;
        }
        element.daterangepicker(config);

        if(this.value !== '') {
          this.setInput(this.value)
        }

        element.on('apply.daterangepicker', (ev, picker) => {
          let val = '';
          if(this.type === 'daterange') {
            val = picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY');
          } else if(this.type === 'datetime') {
            val = picker.startDate.format('YYYY-MM-DD H:mm:ss');
          } else {
            val = picker.startDate.format('YYYY-MM-DD');
          }
          console.log('Input daterange event: ', val);
          this.$emit('input', val);
        });
      },
      setInput(value) {
        console.log('setInput excecute', value);
        if(this.type === 'daterange') {
          this.date = value;
        } else if(value != null && this.type === 'datetime') {
          this.date = moment(value).format('DD/MM/YYYY H:mm:ss');
        } else if(value != null) {
          this.date = moment(value).format('DD/MM/YYYY');
        } else {
          this.date = value;
        }
      },
      onChangeDate(ev) {
        let date = moment(ev.target.value, 'DD/MM/YYYY');
        if(!date.isValid()) {
          Toast.fire('Error', 'La fecha ingresada no es válida', 'error');
          this.date = null;
          return false;
        }

        this.date = date.format('DD/MM/YYYY');

        //this.$emit('input', date.format('YYYY-MM-DD'));
      }
    }
  }
</script>

<style scoped>

</style>

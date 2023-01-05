<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/ro';
import moment from 'moment';

export default {
  components: { DatePicker },
  props: [
    'dataVeche',
    'numeCampDb',
    'tip',
    'valueType',
    'format',
    'latime',
    'notBeforeDate',
    'notAfterDate',
    'doarZiua',
    'minuteStep',
    'hours',
    'disabled'],
  computed: {
    latimePrelucrata() {
      if (this.tip === "time") {
        return { width: '80px' };
      }
      if (this.tip === "date") {
        return { width: '150px' };
      }
      if (this.tip === "datetime") {
        return { width: '180px' };
      }
      // return { width: '150px' };
    }
  },
  name: 'ControlOpen',
  data() {
    return {
      time: null,
      dataNoua: '',
      // latimePrelucrata: latime.replace('"','')
    }
  },
    methods: {
      notDates(date) {
        // selectare data doar din interval
        if ((typeof this.notBeforeDate !== 'undefined') && (typeof this.notAfterDate !== 'undefined')){
          const notBefore = new Date(this.notBeforeDate);
          notBefore.setHours(0, 0, 0, 0);

          const notAfter = new Date(this.notAfterDate);
          notAfter.setHours(0, 0, 0, 0);

          return ((date.getTime() < notBefore.getTime()) || (date.getTime() > notAfter.getTime()));
        }
        // selectare date doar de la un moment dat
        if (typeof this.notBeforeDate !== 'undefined'){
          const notBefore = new Date(this.notBeforeDate);
          notBefore.setHours(0, 0, 0, 0);



          // selectare doar o zi din saptamana
        //   if (typeof this.doarZiua !== 'undefined'){
        //     const dateDay = date.getDay()
        //     return ((date.getTime() < notBefore.getTime())
        //       || (dateDay !== this.doarZiua));
        //   }

          // selectare doar sambata pana pe 09.01.2023, iar dupa selectare doar vinerea
            const dateDay = date.getDay()
            const dataLaCareSeSchimbaZiuaDinSaptamana = new Date("2023-01-09");
            return (
                (date.getTime() < notBefore.getTime())
                || ((date.getTime() < dataLaCareSeSchimbaZiuaDinSaptamana.getTime()) && (dateDay !== 6))
                || ((date.getTime() > dataLaCareSeSchimbaZiuaDinSaptamana.getTime()) && (dateDay !== 5))
                );



          return (date.getTime() < notBefore.getTime());
        }
        // selectare date doar pana la un moment dat
        if (typeof this.notAfterDate !== 'undefined'){
          const notAfter = new Date(this.notAfterDate);
          notAfter.setHours(0, 0, 0, 0);

          return (date.getTime() > notAfter.getTime());
        }
      },
      dataintoarcere: function () {
        this.$emit('dataintoarcere', this.time);
      }
    },
    created() {
        if (this.dataVeche == "") {
        }
        else {
          this.time = this.dataVeche
        }
        this.dataintoarcere('dataIntoarcereTrimisa');
    },
    updated() {
        this.dataintoarcere('dataIntoarcereTrimisa');
    }


}
</script>

<template>
  <div>
    <input type="text" :name=numeCampDb v-model="time" v-show="false">
    <date-picker
      v-model="time"
      :type=tip
      :value-type=valueType
      :format=format
      :minute-step=minuteStep
      :hour-options="hours"
      :editable="false"
      :style=latime
      :disabled-date="notDates"
      :disabled=disabled
    >
    </date-picker>
  </div>
</template>

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
    'hours'],
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
          if (typeof this.doarZiua !== 'undefined'){
            const dateDay = date.getDay()
            return ((date.getTime() < notBefore.getTime())
              || (dateDay !== this.doarZiua));
          }

          return (date.getTime() < notBefore.getTime());
        }
        // selectare date doar pana la un moment dat
        if (typeof this.notAfterDate !== 'undefined'){
          const notAfter = new Date(this.notAfterDate);
          notAfter.setHours(0, 0, 0, 0);

          return (date.getTime() > notAfter.getTime());
        }
      },
    },
    created() {
        if (this.dataVeche == "") {
        }
        else {
          this.time = this.dataVeche
        }
    },
    updated() {
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
    >      
    </date-picker>
  </div>
</template>
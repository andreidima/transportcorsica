/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('vue2-datepicker', require('./components/DatePicker.vue').default);
Vue.component('vue2-datepicker-plecare', require('./components/DatePickerPlecare.vue').default);
Vue.component('vue2-datepicker-intoarcere', require('./components/DatePickerIntoarcere.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// Vue.component('button-counter', {
//     template: '<label v-on:click="increment">{{ counter }}</label>',
//     data: function () {
//         return {
//             counter: 0
//         }
//     },
//     methods: {
//         increment: function () {
//             this.counter++
//             this.$emit('increment')
//         }
//     },
// })
// Vue.component('data-plecare', {
//     template: '<label v-on:click="dataplecare">asd</label>',
//     data: function () {
//         return {
//             // counter: 0
//         }
//     },
//     methods: {
//         dataplecare: function () {
//             // this.counter++
//             this.$emit('dataplecare')
//         }
//     },
// })

if (document.querySelector('#app1')) {
    const app1 = new Vue({
        el: '#app1',
    });
}

if (document.querySelector('#adauga-rezervare')) {
    const app1 = new Vue({
        el: '#adauga-rezervare',
        data: {
            adulti_nume: ((typeof adultiNumeVechi !== 'undefined') ? adultiNumeVechi : ''),
            adulti_data_nastere: ((typeof adultiDataNastereVechi !== 'undefined') ? adultiDataNastereVechi : ''),
            adulti_localitate_nastere: ((typeof adultiLocalitateNastereVechi !== 'undefined') ? adultiLocalitateNastereVechi : ''),
            adulti_sex: ((typeof adultiSexVechi !== 'undefined') ? adultiSexVechi : ''),
            copii_nume: ((typeof copiiNumeVechi !== 'undefined') ? copiiNumeVechi : ''),
            copii_data_nastere: ((typeof copiiDataNastereVechi !== 'undefined') ? copiiDataNastereVechi : ''),
            copii_localitate_nastere: ((typeof copiiLocalitateNastereVechi !== 'undefined') ? copiiLocalitateNastereVechi : ''),
            copii_sex: ((typeof copiiSexVechi !== 'undefined') ? copiiSexVechi : ''),
            // buletin: buletinVechi,
            // localitate_domiciliu: localitateDomiciliuVechi,

            tipuri_sex: [
                { nume: 'M' },
                { nume: 'F' }
            ],

            tip_calatorie: ((typeof tipCalatorieVeche !== 'undefined') ? tipCalatorieVeche : ''),
            traseu: ((typeof traseuVechi !== 'undefined') ? traseuVechi : ''),
            active: "active",
            tara_plecare: '',
            // judet_plecare: judetPlecareVechi,
            // judete_plecare: null,
            oras_plecare: ((typeof orasPlecareVechi !== 'undefined') ? orasPlecareVechi : ''),
            orase_plecare: '',
            // judet_sosire: judetSosireVechi,
            // judete_sosire: null,
            oras_sosire: ((typeof orasSosireVechi !== 'undefined') ? orasSosireVechi : ''),
            orase_sosire: '',

            // sex: '',

            nr_adulti: ((typeof nrAdultiVechi !== 'undefined') ? nrAdultiVechi : ''),
            nr_copii: ((typeof nrCopiiVechi !== 'undefined') ? nrCopiiVechi : ''),

            colete_kg: ((typeof coleteKgVechi !== 'undefined') ? coleteKgVechi : ''),
            colete_volum: ((typeof coleteVolumVechi !== 'undefined') ? coleteVolumVechi : ''),

            // pret_adult: ((typeof pretAdult !== 'undefined') ? pretAdult : ''),
            // pret_copil: ((typeof pretCopil !== 'undefined') ? pretCopil : ''),
            // pret_adult_tur_retur: ((typeof pretAdultTurRetur !== 'undefined') ? pretAdultTurRetur : ''),
            // pret_copil_tur_retur: ((typeof pretCopilTurRetur !== 'undefined') ? pretCopilTurRetur : ''),
            // pret_colete_kg: ((typeof pretColeteKg !== 'undefined') ? pretColeteKg : ''),
            // pret_colete_volum: ((typeof pretColeteKg !== 'undefined') ? (pretColeteKg * 166) : ''),
            pret_adult: '',
            pret_copil: '',
            pret_adult_tur_retur: '',
            pret_copil_tur_retur: '',
            pret_colete_kg: '',

            preturi_modificate_la_data_string_de_afisat: '',
            pret_adult_retur: '',
            pret_copil_retur: '',

            pret_colete_volum: '',
            pret_animal_mic: 0,
            pret_animal_mare: 0,
            pret_adult_cu_reducere_10_procente: 0,
            pret_copil_cu_reducere_10_procente: 0,

            pret_total_tur: '',
            pret_total_retur: '',

            tur_retur: ((typeof turReturVechi !== 'undefined') ? turReturVechi : ''),
            tur_retur_test: '',

            data1: '',
            data2: '',
            diferenta_date: '',

            data_plecare_veche: ((typeof dataPlecareVeche !== 'undefined') ? dataPlecareVeche : ''),
            data_intoarcere_veche: ((typeof dataIntoarcereVeche !== 'undefined') ? dataIntoarcereVeche : ''),

            // Autocomplete
            cumparator: ((typeof cumparatorVechi !== 'undefined') ? cumparatorVechi : ''),
            nr_reg_com: ((typeof nr_reg_comVechi !== 'undefined') ? nr_reg_comVechi : ''),
            cif: ((typeof cifVechi !== 'undefined') ? cifVechi : ''),
            sediul: ((typeof sediulVechi !== 'undefined') ? sediulVechi : ''),
            cumparatori: '',

        },
        watch: {
            traseu: function () {
                this.data_plecare_veche = '';
                this.data_intoarcere_veche = '';
            },
            data1: function () {
                this.getTarife();
                this.getPretTotal();
            },
            data2: function () {
                this.getTarife();
                this.getPretTotal();
            },
            tur_retur: function () {
                if (this.tur_retur == false) {
                    this.data2 = '';
                    this.diferenta_date = '';
                }
                this.getPretTotal()
            },
            colete_kg: function () {
                this.getPretTotal()
            },
            colete_volum: function () {
                this.getPretTotal()
            },
            pret_adult: function () {
                this.getPretTotal()
            },
            pret_copil: function () {
                this.getPretTotal()
            },
            pret_adult_tur_retur: function () {
                this.getPretTotal()
            },
            pret_copil_tur_retur: function () {
                this.getPretTotal()
            },
            pret_colete_kg: function () {
                this.getPretTotal()
            }
        },

        created: function () {
            this.setTaraPlecare()
            // this.getJudetePlecareInitial()
            // this.getOrasePlecareInitial()
            this.getOrasePlecare()
            // this.getJudeteSosireInitial()
            // this.getOraseSosireInitial()
            this.getOraseSosire()
            // this.setPreturi()
            this.getPretTotal()
        },
        methods: {
            setTaraPlecare() {
                if (this.traseu == 'Romania-Corsica') {
                    this.tara_plecare = 'Romania';
                // } else if (this.traseu == 'Corsica-Romania') {
                } else{
                    this.tara_plecare = 'Corsica';
                }
            },
            getJudetePlecareInitial: function () {
                axios.get('/orase_rezervari', {
                    params: {
                        request: 'judete_plecare',
                        tara: this.tara_plecare,
                    }
                })
                    .then(function (response) {
                        app1.judete_plecare = response.data.raspuns;
                    });

                // if (this.traseu == 'Corsica-Romania') {
                //     app1.judet_plecare = "Corsica";
                //     app1.getOrasePlecare();
                // }
            },
            getJudetePlecare: function () {
                axios.get('/orase_rezervari', {
                    params: {
                        request: 'judete_plecare',
                        tara: this.tara_plecare,
                    }
                })
                    .then(function (response) {
                        app1.orase_plecare = '';
                        app1.judet_plecare = 0;
                        app1.oras_plecare = 0;

                        app1.judete_plecare = response.data.raspuns;
                    });

                // if (this.traseu === 'Corsica-Romania') {
                //     app1.judet_plecare = "Corsica";
                //     app1.getOrasePlecare();
                // }
            },
            getOrasePlecare: function () {
                axios.get('/orase_rezervari', {
                    params: {
                        request: 'orase_plecare',
                        // judet: this.judet_plecare,
                        tara: this.tara_plecare
                    }
                })
                    .then(function (response) {
                        // app1.orase_plecare = '';
                        // app1.oras_plecare = 0;

                        app1.orase_plecare = response.data.raspuns;
                    });
            },
            getJudeteSosireInitial: function () {
                axios.get('/orase_rezervari', {
                    params: {
                        request: 'judete_sosire',
                        tara: this.tara_plecare,
                    }
                })
                    .then(function (response) {
                        app1.judete_sosire = response.data.raspuns;
                    });

                // if (this.traseu == 'Romania-Corsica') {
                //     app1.judet_sosire = "Corsica";
                //     app1.getOraseSosire();
                // }
            },
            getJudeteSosire: function () {
                axios.get('/orase_rezervari', {
                    params: {
                        request: 'judete_sosire',
                        tara: this.tara_plecare,
                    }
                })
                    .then(function (response) {
                        app1.orase_sosire = '';
                        app1.judet_sosire = 0;
                        app1.oras_sosire = 0;

                        app1.judete_sosire = response.data.raspuns;
                    });

                // if (this.traseu === 'Romania-Corsica') {
                //     app1.judet_sosire = "Corsica";
                //     app1.getOraseSosire();
                // }
            },
            getOraseSosireInitial: function () {
                axios.get('/orase_rezervari', {
                    params: {
                        request: 'orase_sosire',
                        traseu: this.traseu,
                    }
                })
                    .then(function (response) {
                        app1.orase_sosire = response.data.raspuns;
                    });
            },
            getOraseSosire: function () {
                axios.get('/orase_rezervari', {
                    params: {
                        request: 'orase_sosire',
                        // judet: this.judet_sosire,
                        tara: this.tara_plecare
                    }
                })
                    .then(function (response) {
                        app1.orase_sosire = '';
                        // app1.oras_plecare = 0;

                        app1.orase_sosire = response.data.raspuns;
                    });
            },
            // setPreturi() {
            //     if (this.tur_retur == false) {
            //         this.pret_adult = 120;
            //     } else if (this.tur_retur == true) {
            //         this.pret_adult = 200;
            //     }
            // },
            getTarife() {
                // console.log('asd');
                if (this.data1 && this.data2) {
                    dt1 = new Date(this.data1)
                    dt2 = new Date(this.data2)
                    this.diferenta_date = Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate())) / (1000 * 60 * 60 * 24))
                }

                axios.get('/orase_rezervari', {
                    params: {
                        request: 'tarife',
                        data_plecare: this.data1,
                        data_intoarcere: this.data2,
                        diferenta_date: this.diferenta_date,
                    }
                })
                    .then(function (response) {
                        app1.pret_adult= response.data.pret_adult;
                        app1.pret_copil= response.data.pret_copil;
                        app1.pret_adult_tur_retur= response.data.pret_adult_tur_retur;
                        app1.pret_copil_tur_retur= response.data.pret_copil_tur_retur;
                        app1.pret_colete_kg= response.data.pret_colete_kg;

                        app1.preturi_modificate_la_data_string_de_afisat = response.data.preturi_modificate_la_data_string_de_afisat;
                        app1.pret_adult_retur = response.data.pret_adult_retur;
                        app1.pret_copil_retur = response.data.pret_copil_retur;
                    });

            },
            getPretTotal() {
                this.pret_total_tur = 0;
                this.pret_total_retur = 0;

                if (this.data1 && this.data2) {
                    dt1 = new Date(this.data1)
                    dt2 = new Date(this.data2)
                    this.diferenta_date = Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate())) / (1000 * 60 * 60 * 24))
                }

                if (this.tip_calatorie == "Calatori") {
                    if (this.isNumeric(this.diferenta_date) && (this.diferenta_date < 15)) {
                        if (this.hasOnlyDigits(this.nr_adulti) && (this.nr_adulti > 0)) {
                            this.pret_total_tur = this.pret_total_tur + this.pret_adult_tur_retur * this.nr_adulti
                        }
                        if (this.hasOnlyDigits(this.nr_copii) && (this.nr_copii > 0)) {
                            this.pret_total_tur = this.pret_total_tur + this.pret_copil_tur_retur * this.nr_copii
                        }
                    } else {
                        if (this.hasOnlyDigits(this.nr_adulti) && (this.nr_adulti > 0)) {
                            this.pret_total_tur = this.pret_total_tur + this.pret_adult * this.nr_adulti
                        }
                        if (this.hasOnlyDigits(this.nr_copii) && (this.nr_copii > 0)) {
                            this.pret_total_tur = this.pret_total_tur + this.pret_copil * this.nr_copii
                        }
                        if (this.tur_retur == true){
                            this.pret_total_retur = this.pret_total_tur
                        }
                    }
                } else if(this.tip_calatorie == "Colete") {
                    if ((this.colete_kg && !isNaN(this.colete_kg)) && (this.colete_volum && !isNaN(this.colete_volum))) {
                        if (this.colete_kg > this.colete_volum * 166) {
                            this.pret_total_tur = Math.round(this.colete_kg * this.pret_colete_kg);
                        } else {
                            this.pret_total_tur = Math.round(this.colete_volum * this.pret_colete_volum);
                        }
                    } else if (this.colete_kg && !isNaN(this.colete_kg)){
                        this.pret_total_tur = Math.round(this.colete_kg * this.pret_colete_kg);
                    } else if (this.colete_volum && !isNaN(this.colete_volum)) {
                        this.pret_total_tur = Math.round(this.colete_volum * this.pret_colete_volum);
                    }

                    if (this.tur_retur == true) {
                        this.pret_total_retur = this.pret_total_tur
                    }
                }
            },
            stergeAdult: function (adult) {
                // this.nume.splice(adult,1);
                this.$delete(this.adulti_nume, adult);
                // this.$delete(this.buletin, adult);
                this.$delete(this.adulti_data_nastere, adult);
                this.$delete(this.adulti_localitate_nastere, adult);
                // this.$delete(this.localitate_domiciliu, adult);
                this.$delete(this.adulti_sex, adult);

                this.nr_adulti--;

                this.getPretTotal();
            },
            stergeCopil: function (copil) {
                // this.nume.splice(copil,1);
                this.$delete(this.copii_nume, copil);
                // this.$delete(this.buletin, copil);
                this.$delete(this.copii_data_nastere, copil);
                this.$delete(this.copii_localitate_nastere, copil);
                // this.$delete(this.localitate_domiciliu, copil);
                this.$delete(this.copii_sex, copil);

                this.nr_copii--;

                this.getPretTotal();
            },
            dataPlecareTrimisa(data_plecare) {
                if (this.traseu == "Romania-Corsica") {
                    this.data1 = data_plecare;
                }
                else if (this.traseu == "Corsica-Romania") {
                    this.data2 = data_plecare;
                }
                // this.data_plecare = data_plecare;
                // this.getPretTotal();
            },
            dataIntoarcereTrimisa(data_intoarcere) {
                if (this.traseu == "Romania-Corsica") {
                    this.data2 = data_intoarcere;
                }
                else if (this.traseu == "Corsica-Romania") {
                    this.data1 = data_intoarcere;
                }
                // this.data_intoarcere = data_intoarcere;
                // this.getPretTotal();
            },


            // // new Date("dateString") is browser-dependent and discouraged, so we'll write
            // // a simple parse function for U.S. date format (which does no error checking)
            // parseDate(str) {
            //     var mdy = str.split('/');
            //     return new Date(mdy[2], mdy[0] - 1, mdy[1]);
            // },
            // datediff(first, second) {
            // // Take the difference between the dates and divide by milliseconds per day.
            // // Round to nearest whole number to deal with DST.
            // return Math.round((second - first) / (1000 * 60 * 60 * 24));
            // }

            isNumeric(value) {
                return /^-?\d+$/.test(value);
            },
            // allow positive whole numbers
            hasOnlyDigits(value) {
                return /^\d+$/.test(value);
            },
            autoComplete: function () {
                app1.cumparatori = '';
                if (app1.cumparator.length > 2) {
                    axios.get('/vuejs/autocomplete/search', {
                        params: {
                            cumparator: app1.cumparator
                        }
                    })
                        .then(function (response) {
                        app1.cumparatori = response.data;
                    });
                }
            },
            inverseaza_orasele: function () {
                if (this.traseu == 'Romania-Corsica') {
                    (this.traseu = 'Corsica-Romania')
                } else {
                    (this.traseu = 'Romania-Corsica')
                }
                this.setTaraPlecare()
                this.getOrasePlecare()
                this.getOraseSosire()

                salvareoras = this.oras_plecare;
                this.oras_plecare = this.oras_sosire;
                this.oras_sosire = salvareoras;
            },
        }
    });
}

if (document.querySelector('#text-sms')) {
    const app = new Vue({
        el: '#text-sms',
        data: {
            text_sms: '',
            nr_caractere: 0
        },
        computed: {
            caractere() {
                var char = this.text_sms.length;
                return char;
            }
        }
    });
}

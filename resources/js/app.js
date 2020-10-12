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

if (document.querySelector('#app1')) {
    const app1 = new Vue({
        el: '#app1',
    });
}

if (document.querySelector('#adauga-rezervare')) {
    const app1 = new Vue({
        el: '#adauga-rezervare',
        data: {
            // nume: [[]],
            // buletin: [[]],
            nume: numeVechi,
            buletin: buletinVechi,
            data_nastere: dataNastereVechi,
            localitate_nastere: localitateNastereVechi,
            localitate_domiciliu: localitateDomiciliuVechi,
            tip_calatorie: tipCalatorieVeche,
            traseu: traseuVechi,
            active: "active",
            tara_plecare: '',
            // judet_plecare: judetPlecareVechi,
            // judete_plecare: null,
            oras_plecare: orasPlecareVechi,
            orase_plecare: '',
            // judet_sosire: judetSosireVechi,
            // judete_sosire: null,
            oras_sosire: orasSosireVechi,
            orase_sosire: '',


            nr_adulti: nrAdultiVechi,

            pret_adult: 0,
            pret_copil: 0,
            pret_animal_mic: 0,
            pret_animal_mare: 0,
            pret_adult_cu_reducere_10_procente: 0,
            pret_copil_cu_reducere_10_procente: 0,

            pret_total: '',

            tur_retur: turReturVechi,

        },

        created: function () {
            this.setTaraPlecare()
            // this.getJudetePlecareInitial()
            // this.getOrasePlecareInitial()
            this.getOrasePlecare()
            // this.getJudeteSosireInitial()
            // this.getOraseSosireInitial()
            this.getOraseSosire()
            this.setPreturi()
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
            setPreturi() {
                if (this.tur_retur == false) {
                    this.pret_adult = 120;
                } else if (this.tur_retur == true) {
                    this.pret_adult = 200;
                }
            },
            getPretTotal() {
                this.pret_total = 0;
                if (!isNaN(this.nr_adulti) && (this.nr_adulti > 0)) {
                    this.pret_total = this.pret_total + this.pret_adult * this.nr_adulti
                }
                // if (!isNaN(this.nr_copii) && (this.nr_copii > 0)) {
                //     this.pret_total = this.pret_total + this.pret_copil * this.nr_copii
                // }
            },
            stergePasager: function (index) {
                // this.nume.splice(index,1);
                this.$delete(this.nume, index);
                this.$delete(this.buletin, index);
                this.$delete(this.data_nastere, index);
                this.$delete(this.localitate_nastere, index);
                this.$delete(this.localitate_domiciliu, index);
                this.nr_adulti--;
            }
        }
    });
}

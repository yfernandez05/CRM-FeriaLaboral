<template>
    <form-empleo cardTitle="Editar empleo" :empleo="empleo" @saveData="saveData">
    </form-empleo>
</template>


<script>
    import FormEmpleo from './_FormEmpleo';
    import moment,{ now } from 'moment';

    export default {
        data() {
            return {
                empleo: {}
            }
        },
        created() {
            this.empleo.id = this.$route.params.id;

            if (isNaN(this.empleo.id)) {
                this.backToList();
            }

            this.obtenerEmpleo(this.empleo.id);
        },
        methods: {
            obtenerEmpleo(id) {
                showPreloader();

                let vm = this;
                axios.get(`${appApiUrl}/empleo/${id}`)
                    .then(function (response) {
                        hidePreloader();
                        //console.log(response);
                        if (response.data == null || response.data == '') {
                            warningMessage(`No se encontró ningún empleo con el código ${id}`, appName);
                            this.backToList();
                        }
                        vm.empleo = response.data;
                        /* vm.empleo.carreras.map(carrera => carrera.idcarrera); */

                        if(!vm.empleo.isactive){
                            warningMessage(appCannotDeleteMessage, appName);
                            vm.backToList();
                        }
                    })
                    .catch(function (error) {
                        hidePreloader();
                        errorMessage(appErrorMessage, appName);
                        vm.backToList();
                        console.log(error);
                    })
            },
            saveData(event) {
                showPreloader();
                //console.log('save data', event);

                let vm = this;
                axios.put(`${appApiUrl}/empleo/${this.empleo.id}`, event)
                    .then(function (response) {
                        hidePreloader();
                        //console.log(response);
                        let result = response.data;

                        if (result.status) {
                            successMessage(result.message, appName);

                            vm.$router.push({
                                name: 'spa.empleo'
                            });
                        } else
                            errorMessage(result.message, appName);
                    })
                    .catch(function (error) {
                        hidePreloader();
                        errorMessage(appErrorMessage, appName);
                        console.log(error);
                    })
            },
            backToList(){
                this.$router.push({
                    name: 'spa.empleo'
                });
            },
            formatDate (value, fmt = 'D MMM YYYY') {
                return (value == null)
                    ? ''
                    : moment(value, 'YYYY-MM-DD HH:mm:ss').format(fmt)
            },
        },
        components: {
            FormEmpleo
        }
    }

</script>

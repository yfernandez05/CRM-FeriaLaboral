<template>
    <form-carrera cardTitle="Editar carrera" :carrera="carrera" @saveData="saveData">
    </form-carrera>
</template>


<script>
    import FormCarrera from './_FormCarrera';
    import moment,{ now } from 'moment';

    export default {
        data() {
            return {
                carrera: {}
            }
        },
        created() {
            this.carrera.idcarrera = this.$route.params.id;

            if (isNaN(this.carrera.idcarrera)) {
                this.backToList();
            }

            this.obtenerCarrera(this.carrera.idcarrera);
        },
        methods: {
            obtenerCarrera(id) {
                showPreloader();

                let vm = this;
                axios.get(`${appApiUrl}/carrera/${id}`)
                    .then(function (response) {
                        hidePreloader();
                        //console.log(response);
                        if (response.data == null || response.data == '') {
                            warningMessage(`No se encontró ningúna carrera con el código ${id}`, appName);
                            this.backToList();
                        }
                        vm.carrera = response.data;

                        if(!vm.carrera.isactive){
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
                axios.put(`${appApiUrl}/carrera/${this.carrera.idcarrera}`, event)
                    .then(function (response) {
                        hidePreloader();
                        //console.log(response);
                        let result = response.data;

                        if (result.status) {
                            successMessage(result.message, appName);

                            vm.$router.push({
                                name: 'spa.carrera'
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
                    name: 'spa.carrera'
                });
            },
            formatDate (value, fmt = 'D MMM YYYY') {
                return (value == null)
                    ? ''
                    : moment(value, 'YYYY-MM-DD HH:mm:ss').format(fmt)
            },
        },
        components: {
            FormCarrera
        }
    }

</script>

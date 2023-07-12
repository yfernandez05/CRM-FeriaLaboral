<template>
    <form-empresa cardTitle="Editar empresa" :empresa="empresa" @saveData="saveData">
    </form-empresa>
</template>


<script>
    import FormEmpresa from './_FormEmpresa';
    import moment,{ now } from 'moment';

    export default {
        data() {
            return {
                empresa: {}
            }
        },
        created() {
            this.empresa.idempresa = this.$route.params.id;

            if (isNaN(this.empresa.idempresa)) {
                this.backToList();
            }

            this.obtenerEmpresa(this.empresa.idempresa);
        },
        methods: {
            obtenerEmpresa(id) {
                showPreloader();

                let vm = this;
                axios.get(`${appApiUrl}/empresa/${id}`)
                    .then(function (response) {
                        hidePreloader();
                        //console.log(response);
                        if (response.data == null || response.data == '') {
                            warningMessage(`No se encontró ningúna empresa con el código ${id}`, appName);
                            this.backToList();
                        }
                        vm.empresa = response.data;

                        if(!vm.empresa.isactive){
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
                axios.put(`${appApiUrl}/empresa/${this.empresa.idempresa}`, event)
                    .then(function (response) {
                        hidePreloader();
                        //console.log(response);
                        let result = response.data;

                        if (result.status) {
                            successMessage(result.message, appName);

                            vm.$router.push({
                                name: 'spa.empresa'
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
                    name: 'spa.empresa'
                });
            },
            formatDate (value, fmt = 'D MMM YYYY') {
                return (value == null)
                    ? ''
                    : moment(value, 'YYYY-MM-DD HH:mm:ss').format(fmt)
            },
        },
        components: {
            FormEmpresa
        }
    }

</script>

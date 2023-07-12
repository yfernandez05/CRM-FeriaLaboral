<template>
    <form-experiencia cardTitle="Editar experiencia" :experiencia="experiencia" @saveData="saveData"/>
</template>


<script>
    import FormExperiencia from './_FormExperiencia.vue';
    import moment,{ now } from 'moment';

    export default {
        data() {
            return {
                experiencia: {}
            }
        },
        created() {
            this.experiencia.id = this.$route.params.id;

            if (isNaN(this.experiencia.id)) {
                this.backToList();
            }

            this.obtenerExperiencia(this.experiencia.id);
        },
        methods: {
            obtenerExperiencia(id) {
                showPreloader();

                let vm = this;
                axios.get(`${appApiUrl}/experiencia/${id}`)
                    .then(function (response) {
                        hidePreloader();
                        //console.log(response);
                        if (response.data == null || response.data == '') {
                            warningMessage(`No se encontró ningúna experiencia con el código ${id}`, appName);
                            this.backToList();
                        }
                        vm.experiencia = response.data;

                        if(!vm.experiencia.isactive){
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
                axios.put(`${appApiUrl}/experiencia/${this.experiencia.id}`, event)
                    .then(function (response) {
                        hidePreloader();
                        //console.log(response);
                        let result = response.data;

                        if (result.status) {
                            successMessage(result.message, appName);

                            vm.$router.push({
                                name: 'spa.experiencia'
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
                    name: 'spa.experiencia'
                });
            },
        },
        components: {
            FormExperiencia
        }
    }

</script>

<template>
    <form-tipoEvento  cardTitle="Editar Tipo de Atencion" :tipoevento="tipoevento" @saveData="saveData">
    </form-tipoEvento>
</template>

<script>

  import FormTipoEvento from './_FormTipoEvento';

export default {
     data() {
            return {
                tipoevento: {}
            }
        },
        created() {
            this.tipoevento.idtipoevento = this.$route.params.id;

            if (isNaN(this.tipoevento.idtipoevento)) {
                this.$router.push({
                    name: 'spa.tipoEvento'
                });
            }

            this.obtenerTipoEvento(this.tipoevento.idtipoevento);
        },
        methods: {
            obtenerTipoEvento(id) {
                showPreloader();

                let vm = this;
                axios.get(`${appApiUrl}/tipoEvento/${id}`)
                    .then(function (response) {
                        hidePreloader();
                        if (response.data == null || response.data == '') {
                            warningMessage(`No se encontró ningúna Tipo de Evento con el código ${id}`, appName);

                            vm.$router.push({
                                name: 'spa.tipoEvento'
                            });
                        }
                        vm.tipoevento = response.data;
                    })
                    .catch(function (error) {
                        hidePreloader();
                        errorMessage(appErrorMessage, appName);

                        vm.$router.push({
                            name: 'spa.tipoEvento'
                        });
                        console.log(error);
                    })
            },
            saveData(event) {
                showPreloader();
               
                let vm = this;
                axios.put(`${appApiUrl}/tipoEvento/${this.tipoevento.idtipoevento}`, event)
                    .then(function (response) {
                        hidePreloader();
         
                        let result = response.data;

                        if (result.status) {
                            successMessage(result.message, appName);

                            vm.$router.push({
                                name: 'spa.tipoEvento'
                            });
                        } else
                            errorMessage(result.message, appName);
                    })
                    .catch(function (error) {
                        hidePreloader();
                        errorMessage(appErrorMessage, appName);
                        console.log(error);
                    })
            }
        },
        
        mounted() {

        },
        components: {
            FormTipoEvento
        }
}
</script>

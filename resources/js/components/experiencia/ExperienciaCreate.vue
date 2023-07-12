<template>
    <form-experiencia cardTitle="Registrar experiencia" @saveData="saveData">
    </form-experiencia>
</template>

<script>
    import FormExperiencia from './_FormExperiencia.vue';

    export default {
        methods: {
            saveData(event) {
                showPreloader();
                //console.log('save data', event);
                let vm = this;
                axios.post(`${appApiUrl}/experiencia`, event)
                    .then(function (response) {
                        hidePreloader();
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
            }
        },
        components: {
            FormExperiencia
        }
    }

</script>

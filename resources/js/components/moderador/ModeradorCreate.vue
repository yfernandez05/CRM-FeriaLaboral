<template>
    <form-moderador cardTitle="Registrar Moderador" @saveData="saveData">
    </form-moderador>
</template>

<script>
import FormModerador from './_FormModerador';

export default {
    methods: {
        saveData(event) {
            showPreloader();
            console.log('save data', event);
            let vm = this;
            axios.post(`${appApiUrl}/moderador`, event)
                .then(function (response) {
                    hidePreloader();
                    let result = response.data;

                    if (result.status) {
                        successMessage(result.message, appName);

                        vm.$router.push({
                            name: 'spa.moderador'
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

    components:{
        FormModerador
    }
}
</script>
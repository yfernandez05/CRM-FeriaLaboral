<template>
    <form-invitacion cardTitle="Crear Invitación" @saveData="saveData"></form-invitacion>
</template>
<script>
//importamos componentes
import FormInvitacion from './_FormInvitacion';
export default {
    methods: {
        saveData(event) {
            //showPreloader();
            //console.log('save data', event);
            let vm = this;
            axios.post(`${appApiUrl}/invitacion`, event)
            .then(function (response) {
                hidePreloader();
                let result = response.data;

                if (result.status) {
                    successMessage(result.message, appName);

                    vm.$router.push({
                        name: 'spa.invitacion'
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

    components:{FormInvitacion}
}
</script>
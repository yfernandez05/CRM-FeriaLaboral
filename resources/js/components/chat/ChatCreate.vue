<template>
    <form-chat cardTitle="Registrar Sala" @saveData="saveData">
    </form-chat>
</template>

<script>
import FormChat from './_FormChat';
import {socket} from './../../connectionsocket';

export default {
    methods: {
        saveData(event) {
            showPreloader();
            console.log('save data', event);
            let vm = this;
            axios.post(`${appApiUrl}/sala`, event)
                .then(function (response) {
                    hidePreloader();
                    let result = response.data;

                    if (result.status) {
                        successMessage(result.message, appName);

                        vm.$router.push({
                            name: 'spa.chat'
                        });
                        //emitimos estado sala al servicio
                        socket.emit('estado_salas_crm');
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
       FormChat 
    }
}
</script>
<template>
    <form-alerta cardTitle="Registrar Alerta" @saveData="saveData">
    </form-alerta>
</template>

<script>
//importamos componentes y librerias
import FormAlerta from './_FormAlerta';

export default {

    //metodos
    methods:{
        saveData(event) {
            showPreloader();
            //console.log('save data', event);
            let vm = this;
            axios.post(`${appApiUrl}/alerta`, event)
            .then(function (response) {
                hidePreloader();
                let result = response.data;

                if (result.status) {
                    successMessage(result.message, appName);
                    vm.$router.push({
                        name: 'spa.alerta'
                    });
                } else{
                    errorMessage(result.message, appName);
                }

            })
            .catch(function (error) {
                hidePreloader();
                errorMessage(appErrorMessage, appName);
                console.log(error);
            })
        },
    },

    //iniciamos componentes
    components:{
        FormAlerta
    },
}
</script>
<template>
    <form-chat cardTitle="Editar Sala" :sala="sala" @saveData="saveData">
    </form-chat>
</template>

<script>
import FormChat from './_FormChat';
import {socket} from './../../connectionsocket';

export default {
    data() {
        return {
            sala: {}
        }
    },
    created() {
        this.sala.chat_id = this.$route.params.id;

        if (isNaN(this.sala.chat_id)) {
            this.backToList();
        }

        this.obtenerCuenta(this.sala.chat_id);
    },
    methods: {
        obtenerCuenta(id) {
            showPreloader();

            let vm = this;
            axios.get(`${appApiUrl}/sala/${id}`)
                .then(function (response) {
                    hidePreloader();
                    //console.log(response);
                    if (response.data == null || response.data == '') {
                        warningMessage(`No se encontró ningúna sala con el código ${id}`, appName);
                        this.backToList();
                    }
                    vm.sala = response.data;                    

                    if(!vm.sala.isactive){
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
            axios.put(`${appApiUrl}/sala/${this.sala.chat_id}`, event)
                .then(function (response) {
                    hidePreloader();
                    //console.log(response);
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
        },
        backToList(){
            this.$router.push({
                name: 'spa.chat'
            });
        },

    },
    components: {
        FormChat
    }
}
</script>
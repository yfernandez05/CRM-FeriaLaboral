<template>
    <form-invitacion cardTitle="Editar Invitación" :invitacion="invitacion" @saveData="saveData"></form-invitacion>
</template>

<script>
//importamos componentes
import FormInvitacion from './_FormInvitacion';
import moment,{ now } from 'moment';

export default {
    data(){
        return{
            invitacion:{},
        }
    },

    //metodos
    methods:{
        obtenerInvitacion(id) {
            showPreloader();
            
            let vm = this;
            axios.get(`${appApiUrl}/invitacion/${id}`)
            .then(function (response) {
                hidePreloader();
                if (response.data == null || response.data == '') {
                    warningMessage(`No se encontró ningúna Invitacion con el código ${id}`, appName);

                    vm.$router.push({
                        name: 'spa.invitacion'
                    });
                }
                vm.invitacion = response.data;
                vm.invitacion.fecharegistro = vm.formatDate(vm.invitacion.fecharegistro, 'DD-MM-YYYY HH:mm:ss');
                console.log(vm.invitacion);
            })
            .catch(function (error) {
                hidePreloader();
                errorMessage(appErrorMessage, appName);

                vm.$router.push({
                    name: 'spa.invitacion'
                });
                console.log(error);
            })
        },

        saveData(event) {
            showPreloader();
            
            let vm = this;
            axios.put(`${appApiUrl}/invitacion/${this.invitacion.idinvitacion}`, event)
            .then(function (response) {
                hidePreloader();
    
                let result = response.data;

                if (result.status) {                    
                    successMessage(result.message, appName);

                    vm.$router.push({
                        name: 'spa.invitacion'
                    });
                }else{
                    errorMessage(result.message, appName);
                }
                   
            })
            .catch(function (error) {
                hidePreloader();
                errorMessage(appErrorMessage, appName);
                console.log(error);
            })
        },

        formatDate (value, fmt = 'D MMM YYYY') {
            return (value == null)
                ? ''
                : moment(value, 'YYYY-MM-DD HH:mm:ss').format(fmt)
        },
    },

    created(){
        this.invitacion.idinvitacion = this.$route.params.id;

        if (isNaN(this.invitacion.idinvitacion)) {
            this.$router.push({
                name: 'spa.invitacion'
            });
        }

        this.obtenerInvitacion(this.invitacion.idinvitacion);
    },



    components:{FormInvitacion}
}
</script>
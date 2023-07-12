<template>
    <form-alerta cardTitle="Editar Alerta" :alerta="alerta" @saveData="saveData">
    </form-alerta>
</template>

<script>
//importamos componentes librerias
import FormAlerta from './_FormAlerta';
import moment,{ now } from 'moment';

export default {
    data() {
        return {
            alerta: {}
        }
    },

    //iniciamos los metodos
    created() {
        this.alerta.idalerta = this.$route.params.id;

        if (isNaN(this.alerta.idalerta)) {
            this.backToList();
        }

        this.obtenerAlerta(this.alerta.idalerta);
    },

    //metodos
    methods:{
        obtenerAlerta(id) {
            showPreloader();

            let vm = this;
            axios.get(`${appApiUrl}/alerta/${id}`)
            .then(function (response) {
                hidePreloader();
                //console.log(response);
                if (response.data == null || response.data == '') {
                    warningMessage(`No se encontró ningúna alerta con el código ${id}`, appName);
                    this.backToList();
                }
                vm.alerta = response.data;
                vm.alerta.fechainicio = vm.formatDate(vm.alerta.fechainicio, 'DD-MM-YYYY HH:mm:ss');
                vm.alerta.fechafin = vm.formatDate(vm.alerta.fechafin, 'DD-MM-YYYY HH:mm:ss');

                if(!vm.alerta.isactive){
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
            let vm = this;
            axios.put(`${appApiUrl}/alerta/${this.alerta.idalerta}`, event)
            .then(function (response) {
                hidePreloader();
                //console.log(response);
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

        backToList(){
            this.$router.push({
                name: 'spa.alerta'
            });
        },

        formatDate (value, fmt = 'D MMM YYYY') {
            return (value == null)
                ? ''
                : moment(value, 'YYYY-MM-DD HH:mm:ss').format(fmt)
        },

    },

    //iniciamos componentes
    components:{
        FormAlerta,
    }
}
</script>
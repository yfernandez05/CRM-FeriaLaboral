<template>
    <form-moderador cardTitle="Editar Institución" :cliente="cliente" @saveData="saveData"></form-moderador>
</template>

<script>
//importamos componentes 
import FormModerador from './_FormModerador'; 

export default {
    data(){
        return{
            cliente:{},
        }
    },
    //metodos
    methods:{
        obtenerCliente(id) {
            showPreloader();
            
            let vm = this;
            axios.get(`${appApiUrl}/moderador/${id}`)
            .then(function (response) {
                hidePreloader();
                if (response.data == null || response.data == '') {
                    warningMessage(`No se encontró ningún Moderador con el código ${id}`, appName);

                    vm.$router.push({
                        name: 'spa.moderador'
                    });
                }
                vm.cliente = response.data;
            })
            .catch(function (error) {
                hidePreloader();
                errorMessage(appErrorMessage, appName);

                vm.$router.push({
                    name: 'spa.moderador'
                });
                console.log(error);
            })
        },

        saveData(event) {
            showPreloader();
            
            let vm = this;
            axios.put(`${appApiUrl}/moderador/${this.cliente.idcliente}`, event)
            .then(function (response) {
                hidePreloader();
    
                let result = response.data;

                if (result.status) {                    
                    successMessage(result.message, appName);

                    vm.$router.push({
                        name: 'spa.moderador'
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
        }
    },

    created(){
        this.cliente.idcliente = this.$route.params.id;

        if (isNaN(this.cliente.idcliente)) {
            this.$router.push({
                name: 'spa.moderador'
            });
        }

        this.obtenerCliente(this.cliente.idcliente);
    },

    components:{
        FormModerador,
    },
}
</script>
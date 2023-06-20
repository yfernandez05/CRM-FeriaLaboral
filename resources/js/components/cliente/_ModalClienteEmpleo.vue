<template>
    <modal :showModal="showModal" @closeModal="closeModal" modalSize="modal-lg" headerBgClass="bg-primary text-white">
        <template v-slot:modal-header-title>
            Postulante #{{cliente.idcliente}}
        </template>
        <template v-slot:modal-body-main>
            <div class="form-row">
                
                <div class="form-group form-group-sm col-12 col-sm-6 col-md-4 col-xl-3">
                    <label class="mb-0">Fecha Registro</label>
                    <span class="form-control form-control-sm d-block text-truncate text-muted"
                        v-text="cliente.fecha"></span>
                </div>
                <div class="form-group form-group-sm col-12 col-sm-6 col-md-4 col-xl-3">
                    <label class="mb-0">Nombres</label>
                    <span class="form-control form-control-sm d-block text-truncate text-muted"
                        v-text="cliente.nombres"></span>
                </div>
                <div class="form-group form-group-sm col-12 col-sm-6 col-md-4 col-xl-3">
                    <label class="mb-0">Apellidos</label>
                    <span class="form-control form-control-sm d-block text-truncate text-muted"
                        v-text="cliente.apellidos"></span>
                </div>
                <div class="form-group form-group-sm col-12 col-sm-6 col-md-4 col-xl-3">
                    <label class="mb-0">Email</label>
                    <span class="form-control form-control-sm d-block text-truncate text-muted"
                        v-text="cliente.email"></span>
                </div>
                <div class="form-group form-group-sm col-12 col-sm-6 col-md-4 col-xl-3">
                    <label class="mb-0">Telefono</label>
                    <span class="form-control form-control-sm d-block text-truncate text-muted"
                        v-text="cliente.telefono"></span>
                </div>
                <div class="form-group form-group-sm col-12 col-sm-6 col-md-4 col-xl-3">
                    <label class="mb-0">Dni</label>
                    <span class="form-control form-control-sm d-block text-truncate text-muted"
                        v-text="cliente.dni"></span>
                </div>
                <div class="form-group form-group-sm col-12 col-sm-6 col-md-4 col-xl-3">
                    <label class="mb-0">Dirección</label>
                    <span class="form-control form-control-sm d-block text-truncate text-muted"
                        v-text="cliente.direccion"></span>
                </div>
                <div class="form-group form-group-sm col-12 col-sm-6 col-md-4 col-xl-3">
                    <label class="mb-0">Labora en la Empresa </label>
                    <span class="form-control form-control-sm d-block text-truncate text-muted"
                        v-text="cliente.empresaactual"></span>
                </div>
                <div class="form-group form-group-sm col-12 col-sm-6 col-md-4 col-xl-3">
                    <label class="mb-0">Cargo Actual</label>
                    <span class="form-control form-control-sm d-block text-truncate text-muted"
                        v-text="cliente.cargoactual"></span>
                </div>
                <div class="form-group form-group-sm col-12">
                    <label class="mb-0">Más detalles</label>
                    <textarea class="form-control form-control-sm d-block  text-muted" rows="2" v-text="cliente.descripcion"></textarea>
                </div>
            </div>

            <div class="table-responsive">
                <table id="productos" class="table table-sm table-hover table-striped table-bordered mb-2">
                    <thead class="thead-dark">
                        <tr>
                            <th>Cod</th>
                            <th>F. Postulacion</th>
                            <th>Empleo</th>
                            <th>Empresa</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cl in cliente.empleos_postulados" :key="cl.idcliente_empleo">
                            <td v-text="cl.idcliente_empleo"></td>
                            <td v-text="cl.fecha"></td>
                            <td v-text="cl.titulo"></td>
                            <td v-text="cl.empresa.empresa"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </template>
    </modal>
</template>

<script>
import Modal from './../../utils/Modal';

export default {
    data(){
        return {
            showModal:false,
            cliente:{
                idcliente:'',
                campania:{},
                distrito:{}
            },
            clientesempleos:[],
        }
    },

    methods:{
        closeModal(event){
            this.showModal = false;
            this.cliente = {
                evento:{},
                campania:{},
                distrito:{}
            };
            this.clientesempleos = [];
        },
        showDetail(data){
            console.log(data);
            this.cliente = data;
            //this.obtenerEventos(this.cliente.idcliente);
            this.showModal = true;
        },
        obtenerEventos(id){
            showPreloader();

            let vm = this;
            axios.get(`${appApiUrl}/clienteevento/?idcliente=${id}`)
            .then(function (response) {
                hidePreloader();
                if (response.data == null || response.data == '' || response.data == []) {
                    warningMessage(`No se encontró ningúna atencion con el código ${vm.cliente.idcliente}`, appName);
                }
                vm.clientesempleos = response.data.data;
                vm.showModal = true;
                //console.log(vm.clientesempleos)
            })
            .catch(function (error) {
                hidePreloader();
                errorMessage(appErrorMessage, appName);
                //console.log(error);
            })
        }
    },

    components:{
        Modal
    }
}
</script>

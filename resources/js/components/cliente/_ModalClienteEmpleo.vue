<template>
    <modal :showModal="showModal" @closeModal="closeModal" modalSize="modal-lg" headerBgClass="bg-primary text-white">
        <template v-slot:modal-header-title>
            Postulante #{{cliente.idcliente}}
        </template>
        <template v-slot:modal-body-main>
            <div class="row">
                <div class="col-md-12 mt-1">
                    <ul id="tabs" class="nav nav-tabs">
                        <li class="nav-item"><a href="" data-target="#home1" data-toggle="tab" class="nav-link small text-uppercase active">Perfil Postulante</a></li>
                        <li class="nav-item"><a href="" data-target="#profile1" data-toggle="tab" class="nav-link small text-uppercase">Educación</a></li>
                        <li class="nav-item"><a href="" data-target="#messages1" data-toggle="tab" class="nav-link small text-uppercase">Experiencias</a></li>
                    </ul>
                    <br>
                    <div id="tabsContent" class="tab-content">
                        <div id="home1" class="tab-pane fade active show">
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
                                <!-- <div class="form-group form-group-sm col-12 col-sm-6 col-md-4 col-xl-3">
                                    <label class="mb-0">Labora en la Empresa </label>
                                    <span class="form-control form-control-sm d-block text-truncate text-muted"
                                        v-text="cliente.empresaactual"></span>
                                </div>
                                <div class="form-group form-group-sm col-12 col-sm-6 col-md-4 col-xl-3">
                                    <label class="mb-0">Cargo Actual</label>
                                    <span class="form-control form-control-sm d-block text-truncate text-muted"
                                        v-text="cliente.cargoactual"></span>
                                </div> -->
                                <div class="form-group form-group-sm col-12 col-sm-6 col-md-4 col-xl-3">
                                    <label class="mb-0">Currículum Vitae</label>
                                    <div class="d-flex align-items-center">
                                        <template v-if="hasFiles">
                                            <div class="btn-group" role="group">
                                                <a :href="cliente.files[0].url_patch" class="btn btn-primary" target="_blank" download>
                                                    <i class="far fa-file-pdf"> </i> Ver/Descargar
                                                </a>
                                                <!-- <a :href="cliente.files[0].url_patch" class="btn btn-success" download>
                                                <i class="fas fa-download"></i> Descargar
                                                </a> -->
                                            </div>
                                        </template>
                                        <template v-else>
                                            <div class="alert alert-info py-1" role="alert">
                                                Aún no ha subido un currículum vitae.
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                <div class="form-group form-group-sm col-12 col-sm-6 col-md-4 col-xl-3">
                                    <label class="mb-0">Exp. salarial minimo</label>
                                    <span class="form-control form-control-sm d-block text-truncate text-muted"
                                        v-text="cliente.minsalarial"></span>
                                </div> 
                                <div class="form-group form-group-sm col-12 col-sm-6 col-md-4 col-xl-3">
                                    <label class="mb-0">Exp. salarial maximo</label>
                                    <span class="form-control form-control-sm d-block text-truncate text-muted"
                                        v-text="cliente.maxsalarial"></span>
                                </div>
                                <div class="form-group form-group-sm col-12">
                                    <label class="mb-0">Más detalles</label> 
                                    <textarea rows="2" class="form-control form-control-sm d-block  text-muted" v-text="cliente.descripcion"></textarea>
                                </div>
                                
                            </div>
                        </div>
                        <div id="profile1" class="tab-pane fade ">
                            <div class="form-row">                
                                <div class="col-6 shadow-sm mb-2 p-3" v-for="est in cliente.estudios" :key="est.id">
                                    <h6 v-text="est.carrera" class="text-primary mb-0"></h6>
                                    <p class="mb-0">{{est.tipoestudio}} - {{est.estadoestudio}}</p>
                                    <p class="mb-0">{{est.fechainicioFormated}} / {{est.fechafinFormated}}</p>
                                </div>
                            </div>
                        </div>
                        <div id="messages1" class="tab-pane fade">
                            <div class="form-row my-2">                
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>          
            <div class="row">
                <div class="col-md-12 mt-2">
                    <h6 class="font-weight-bold">Empleos postulados:</h6>
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
    computed: {
        hasFiles() {
            return this.cliente.files.length > 0;
        }
    },

    components:{
        Modal
    }
}
</script>

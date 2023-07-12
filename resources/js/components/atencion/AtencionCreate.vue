<template>
    <main-content columnClass="col-12 col-xl-11">
        <template v-slot:card-header-title>
            Registrar Atencion
        </template>

        <template v-slot:card-body-main>
            <div class="form-row">
                
                <div class="form-group col-12" :class="{'has-danger':errorExists('comentario')}">
                    <label>Comentario<small class="text-danger">(*)</small></label>
                    <textarea class="form-control"  v-model="atencion.comentario" @:keyup.enter ="doSaveData" rows="3"></textarea>
                    <small class="form-control-feedback" v-if="errorExists('comentario')" v-text="showError('comentario').errorDetail"></small>
                </div>
                <div class="form-group col-12 col-sm-6 col-md-4" :class="{'has-danger':errorExists('idtipoatencion')}">
                    <label>Estado Atencion <small class="text-danger">(*)</small></label>
                    <select2 :options="tipoatenciones" v-model="atencion.idtipoatencion" :selectValue="atencion.idtipoatencion"
                        placeholder="Seleccione un estado" keyProperty="idtipoatencion" textProperty="tipoatencion">
                    </select2>
                    <small class="form-control-feedback" v-if="errorExists('idtipoatencion')"
                        v-text="showError('idtipoatencion').errorDetail"></small>
                </div>
                <div class="form-group col-12 col-sm-6 col-md-4" :class="{'has-danger':errorExists('fechaatencion')}">
                    <label>Fecha Atencion <small class="text-danger">(*)</small></label>
                    <v-date-picker v-model="atencion.fechaatencion"
                        format="DD-MM-YYYY"
                        value-type="format"
                        placeholder="Seccione"
                    >
                    </v-date-picker>
                    <small class="form-control-feedback" v-if="errorExists('fechaatencion')" v-text="showError('fechaatencion').errorDetail"></small>
                </div>
                <div class="form-group col-12 col-sm-6 col-md-4 d-flex no-block align-items-end justify-content-end">
                    <button type="button" class="btn btn-success waves-effect waves-light" @click="saveData">
                        <i class="fa fa-save"></i>
                        Guardar
                    </button>
                </div>
            </div>
            <hr class="mt-1 mb-2">
            <div class="form-row">
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
                    <label class="mb-0">Fecha Registro</label>
                    <span class="form-control form-control-sm d-block text-truncate text-muted"
                        v-text="cliente.fecha"></span>
                </div>
                <div class="form-group form-group-sm col-12 col-sm-6 col-md-4 col-xl-3">
                    <label class="mb-0">Carrera</label>
                    <span class="form-control form-control-sm d-block text-truncate text-muted"
                        v-text="cliente.carrera"></span>
                </div>
                <div class="form-group form-group-sm col-12 col-sm-6 col-md-4 col-xl-3">
                    <label class="mb-0">Colegio</label>
                    <span class="form-control form-control-sm d-block text-truncate text-muted"
                        v-text="cliente.colegio"></span>
                </div>
                <div class="form-group form-group-sm col-12 col-sm-6 col-md-4 col-xl-3">
                    <label class="mb-0">Año Egreso</label>
                    <span class="form-control form-control-sm d-block text-truncate text-muted"
                        v-text="cliente.anioegreso"></span>
                </div>
                <div class="form-group form-group-sm col-12 col-sm-6 col-md-4 col-xl-3">
                    <label class="mb-0">Campaña</label>
                    <span class="form-control form-control-sm d-block text-truncate text-muted"
                        v-text="cliente.campania.nombrecampania"></span>
                </div>
                <!-- <div class="form-group form-group-sm col-12 col-sm-6 col-md-4 col-xl-3">
                    <label class="mb-0">Evento</label>
                    <span class="form-control form-control-sm d-block text-truncate text-muted"
                        v-text="cliente.evento.nombreevento"></span>
                </div> -->
                <div class="form-group form-group-sm col-12 col-sm-6 col-md-4 col-xl-3">
                    <label class="mb-0">Distrito</label>
                    <span class="form-control form-control-sm d-block text-truncate text-muted"
                        v-text="cliente.distrito.nombreubigeo"></span>
                </div>
            </div>

            <div class="table-responsive">
                <table id="productos" class="table table-sm table-hover table-striped table-bordered mb-2">
                    <thead class="thead-dark">
                        <tr>
                            <th>Cod</th>
                            <th>F. Atencion</th>
                            <th>Est. Atencion</th>
                            <th>Comentario</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="aten in atenciones" :key="aten.idatencion">
                            <td v-text="aten.idatencion"></td>
                            <td v-text="aten.fecha"></td>
                            <td>
                                <span class="badge badge-pill" 
                                    :class="aten.tipoatencion.color"
                                     v-text="aten.tipoatencion.tipoatencion">
                                </span>
                            </td>
                            <td v-text="aten.comentario"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <hr class="mt-2">
        </template>
        <template v-slot:card-body-actions>
            <router-link :to="{name: 'spa.atencion'}" class="btn waves-effect waves-light btn-info mr-2">
                <i class="fas fa-reply"></i> <span class="button-text">Atrás</span>
            </router-link>

            <div></div>
        </template>
    </main-content>
</template>

<script>
    import MainContent from './../../utils/MainContent';
    import VDatePicker from 'vue2-datepicker';
    import moment,{ now } from 'moment';
    import 'vue2-datepicker/locale/es';
    import Select2 from './../../utils/Select2';

    export default {
        data(){
            return {
                errors:[],
                atencion:{
                    idtipoatencion:'',
                    fechaatencion: this.formatDate(new Date(),'DD-MM-YYYY'),
                    comentario: '',
                },
                tipoatenciones:[],
                cliente:{
                    campania:{  
                        evento:{nombreevento: '',}                      
                    },
                    distrito:{}
                },
                atenciones:[],
            }
        },
        created() {
            this.cliente.idcliente = this.$route.params.id;

            if (isNaN(this.cliente.idcliente)) {
                this.backToList();
            }

            this.obtenerCliente(this.cliente.idcliente);
            this.obtenerAtenciones(this.cliente.idcliente);
        },
        methods: {
            validateFields() {
                this.errors = [];

                if (!this.atencion.idtipoatencion) {
                    this.setError('idtipoatencion', 'El campo Tipo de Atencion es obligatorio');
                }

                if (!this.atencion.comentario) {
                    this.setError('comentario', 'El campo Comentario es obligatorio');
                }
               
                if (!this.atencion.fechaatencion) {
                    this.setError('fechaatencion', 'El campo Fecha Ingreso es obligatorio');
                }

                return this.errors;
            },
            setError(keyModel, errorDetail) {
                this.errors.push({
                    keyModel: keyModel,
                    errorDetail: errorDetail
                });
            },
            errorExists(keyModel){
                return this.errors.filter(err => err.keyModel === keyModel).length;
            },
            showError(keyModel){
                return this.errors.find(err => err.keyModel === keyModel);
            },
            formatDate (value, fmt = 'D MMM YYYY') {
                return (value == null)
                    ? ''
                    : moment(value, 'YYYY-MM-DD HH:mm:ss').format(fmt)
            },
            listartipoAtenciones() {
                let vm = this;
                axios.get(`${appApiUrl}/tipoAtencion/select`,{
                        params: { istosave:true}
                    })
                    .then(function (response) {
                        vm.tipoatenciones = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
            },
            saveData(){
                if (this.validateFields().length > 0) {
                    return;
                }

                let atencionData = {
                    comentario: this.atencion.comentario,
                    fechaatencion: this.atencion.fechaatencion,
                    idcliente: this.cliente.idcliente,
                    idtipoatencion: this.atencion.idtipoatencion,
                    
                };

                let vm = this;
                axios.post(`${appApiUrl}/atencion`, atencionData)
                    .then(function (response) {
                        hidePreloader();
                        let result = response.data;
                        if (result.status) {
                            successMessage(result.message, appName);
                            vm.obtenerAtenciones(vm.cliente.idcliente);
                        } else
                            errorMessage(result.message, appName);
                    })
                    .catch(function (error) {
                        hidePreloader();
                        errorMessage(appErrorMessage, appName);
                        console.log(error);
                    })
            },
            obtenerCliente(id) {
                showPreloader();

                let vm = this;
                axios.get(`${appApiUrl}/cliente/${id}/edit`)
                    .then(function (response) {
                        hidePreloader();
                        if (response.data == null || response.data == '') {
                            warningMessage(`No se encontró ningún cliente con el código ${id}`, appName);
                            vm.backToList();
                        }
                        vm.cliente = response.data;

                        if(!vm.cliente.isactive){
                            warningMessage('No se puede atender a un cliente elimnado', appName);
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
            backToList(){
                this.$router.push({
                    name: 'spa.atencion'
                });
            },
            obtenerAtenciones(id){
                showPreloader();

                let vm = this;
                axios.get(`${appApiUrl}/atencion/detail/${id}`)
                    .then(function (response) {
                        hidePreloader();
                        vm.atenciones = response.data;
                    })
                    .catch(function (error) {
                        hidePreloader();
                        errorMessage(appErrorMessage, appName);
                        console.log(error);
                    })
            }
        },
        mounted(){
            //this.atencion.fechaatencion = this.formatDate(new Date(),'DD-MM-YYYY');
            this.listartipoAtenciones();
        },
        components: {
            MainContent,
            VDatePicker,
            Select2
        }
    }

</script>

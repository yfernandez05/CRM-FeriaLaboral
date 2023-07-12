<template>
    <main-content columnClass="col-12 col-xl-10">
        <template v-slot:card-header-title>
            <span v-text="cardTitle"></span>
        </template>

        <template v-slot:card-body-main>
            <div class="form-row">
                <div class="form-group col-12 col-sm-6 col-md-4" :class="{'has-danger':errorExists('nombres')}">
                    <label>Nombres <small class="text-danger">(*)</small></label>
                    <input type="text" class="form-control" v-model="cliente.nombres" @:keyup.enter ="doSaveData" />
                    <small class="form-control-feedback" v-if="errorExists('nombres')" v-text="showError('nombres').errorDetail"></small>
                </div>
                <div class="form-group col-12 col-sm-6 col-md-4" :class="{'has-danger':errorExists('apellidos')}">
                    <label>Apellidos <small class="text-danger">(*)</small></label>
                    <input type="text" class="form-control" v-model="cliente.apellidos" @:keyup.enter ="doSaveData" />
                    <small class="form-control-feedback" v-if="errorExists('apellidos')" v-text="showError('apellidos').errorDetail"></small>
                </div>
                <div class="form-group col-12 col-sm-6 col-md-4" :class="{'has-danger':errorExists('email')}">
                    <label>Correo <small class="text-danger">(*)</small></label>
                    <input type="text" class="form-control" v-model="cliente.email" @:keyup.enter ="doSaveData" />
                    <small class="form-control-feedback" v-if="errorExists('email')" v-text="showError('email').errorDetail"></small>
                </div>                             
                <div class="form-group col-12 col-sm-6 col-md-4" :class="{'has-danger':errorExists('idcampania')}">
                    <label class="mb-1">Campaña <small class="text-danger">(*)</small></label>
                    <select2 :options="campania" v-model="cliente.idcampania"
                        :selectValue="cliente.idcampania" placeholder="Seleccione una campaña"
                        keyProperty="idcampania" textProperty="nombrecampania">
                    </select2>
                    <small class="form-control-feedback" v-if="errorExists('idcampania')" v-text="showError('idcampania').errorDetail"></small>
                </div>
            </div>
            <hr class="mt-2">

        </template>

        <template v-slot:card-body-actions>
            <router-link :to="{name: 'spa.moderador'}" class="btn waves-effect waves-light btn-info mr-2">
                <i class="fas fa-reply"></i> <span class="button-text">Atrás</span>
            </router-link>

            <div>
                <button type="button" class="btn btn-success waves-effect waves-light" @click="doSaveData">
                    <i class="fa fa-save"></i>
                    Guardar
                </button>
                <button type="reset" class="btn waves-effect waves-light btn-outline-secondary ml-2">
                    <i class="fa fa-window-close"></i> <span class="button-text">Cancelar</span>
                </button>
            </div>
        </template>

    </main-content>
</template>

<script>
import MainContent from './../../utils/MainContent';
import Select2 from './../../utils/Select2'; 
import 'vue2-datepicker/locale/es';

    export default {
        props: {
            cardTitle: {
                default: 'Moderador'
            },
            cliente: {
                type: Object,
                default() {
                    return {
                        nombres: '',
                        apellidos: '',
                        email: '',
                        idcampania: '',
                    }
                },
            },
            
        },
        data(){
            return {
                errors:[],
                campania:[],
            }
        },
        methods: {
            doSaveData() {

                if (this.validateFields().length > 0) {
                    return;
                }
                
                let clienteData = {
                    nombres: this.cliente.nombres,
                    apellidos: this.cliente.apellidos,
                    email: this.cliente.email,
                    idcampania: this.cliente.idcampania,
                    edad: 0,

                }

                //console.log(clienteData);
                this.$emit('saveData', clienteData);
            },

            listarCampania() {
                let vm = this;
                axios.get(`${appApiUrl}/campania/select`)
                .then(function (response) {
                    vm.campania = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                })
            },

            //limpiar el select:
            resetSelectUtmProcedencia(){                
                this.cliente.utm ='',
                this.cliente.campaign_medium ='',
                this.cliente.campaign_content ='',
                this.cliente.campaign_name ='',
                this.cliente.campaign_source ='',
                this.cliente.campaign_term ='';
                //console.log(this.utm);
            },

            validateFields() {
                this.errors = [];

                if (!this.cliente.nombres) {
                    this.setError('nombres', 'El campo nombres es obligatorio');
                }
                if (!this.cliente.apellidos) {
                    this.setError('apellidos', 'El campo apellidos es obligatorio');
                }               
                if (!this.cliente.email) {
                    this.setError('email', 'El campo Correo es obligatorio');
                }
                if (!this.cliente.idcampania) {
                    this.setError('idcampania', 'El Campaña correo es obligatorio');
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
           
        },
        created(){
            this.listarCampania();
            console.log(this.clienteId);
        },
        components: {
            MainContent,
            Select2,
        }
    }

</script>

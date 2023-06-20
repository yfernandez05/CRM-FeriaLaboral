<template>
    <main-content columnClass="col-12 col-xl-10">
        <!-- titulo -->
        <template v-slot:card-header-title>
            <span v-text="cardTitle"></span>
        </template>
        <!-- formulario create - edit -->
        <template v-slot:card-body-main>
            <div class="form-row">
                <div class="form-group col-12 col-sm-6 col-md-4 col-lg-6" :class="{'has-danger':errorExists('nombrealerta')}">
                    <label>Nombre Alerta <small class="text-danger">(*)</small></label>
                    <input type="text" class="form-control" v-model="alerta.nombrealerta" @:keyup.enter="doSaveData" />
                    <small class="form-control-feedback" v-if="errorExists('nombrealerta')" v-text="showError('nombrealerta').errorDetail"></small>
                </div>
                <div class="form-group col-12 col-sm-6 col-md-4 col-lg-6" :class="{'has-danger':errorExists('idcampania')}">
                    <label>Campaña <small class="text-danger">(*)</small></label>
                    <select2 :options="campanias" v-model="alerta.idcampania" :selectValue="alerta.idcampania"
                        placeholder="Seleccione una campaña" keyProperty="idcampania" textProperty="nombrecampania">
                    </select2>
                    <small class="form-control-feedback" v-if="errorExists('idcampania')"
                        v-text="showError('idcampania').errorDetail"></small>
                </div>

                <div class="form-group col-12 col-sm-6 col-md-4 col-lg-6" :class="{'has-danger':errorExists('fechainicio')}">
                    <label>Fecha Inicio <small class="text-danger">(*)</small></label>
                    <v-date-picker v-model="alerta.fechainicio"
                        type="datetime"
                        format="DD-MM-YYYY HH:mm:ss"
                        value-type="format"
                        placeholder="Seccione una fecha inicio">
                    </v-date-picker>
                    <small class="form-control-feedback" v-if="errorExists('fechainicio')" v-text="showError('fechainicio').errorDetail"></small>
                </div>
                <div class="form-group col-12 col-sm-6 col-md-4 col-lg-6" :class="{'has-danger':errorExists('fechafin')}">
                    <label>Fecha Fin <small class="text-danger">(*)</small></label>
                    <v-date-picker v-model="alerta.fechafin"
                        type="datetime"
                        format="DD-MM-YYYY HH:mm:ss"
                        value-type="format"
                        placeholder="Seccione una fecha fin">
                    </v-date-picker>
                    <small class="form-control-feedback" v-if="errorExists('fechafin')" v-text="showError('fechafin').errorDetail"></small>
                </div>
                <div class="form-group col-12" :class="{'has-danger':errorExists('descripcionalerta')}">
                    <label>Descripción</label>
                    <textarea class="form-control"  v-model="alerta.descripcionalerta" @:keyup.enter="doSaveData" rows="3"></textarea>
                    <small class="form-control-feedback" v-if="errorExists('descripcionalerta')" v-text="showError('descripcionalerta').errorDetail"></small>
                </div>
                <div class="form-group col-12" :class="{'has-danger':errorExists('urlalerta')}">
                    <label>Enlace URL</label>
                    <input type="text" class="form-control" v-model="alerta.urlalerta" @:keyup.enter="doSaveData" />
                    <small class="form-control-feedback" v-if="errorExists('urlalerta')" v-text="showError('urlalerta').errorDetail"></small>
                </div>
                <!-- <a  class="btn waves-effect waves-light btn-outline-primary ml-2" TARGET="_blank"
                    :href="alerta.urlalerta">
                    <i class="fas fa-external-link-alt"></i> <span class="button-text">Comrpobar enlace</span>
                </a>   -->             
            
            </div>
            <hr class="mt-2">
        </template>
        <!-- acciones footer -->
        <template v-slot:card-body-actions>
            <router-link :to="{name: 'spa.alerta'}" class="btn waves-effect waves-light btn-info mr-2">
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
//importamos componentes y librerias
import MainContent from './../../utils/MainContent';
import VueNumeric from 'vue-numeric';
import VDatePicker from 'vue2-datepicker';
import moment,{ now } from 'moment';
import 'vue2-datepicker/locale/es';
import Select2 from './../../utils/Select2';

export default {
    props:{
        cardTitle: {
            default: 'Alerta'
        },
        alerta:{
            type: Object,
            default() {
                return {
                    nombrealerta: '',
                    descripcionalerta: '',
                    urlalerta: '',
                    idcampania: 0,
                    fechainicio: '',
                    fechafin: '',
                }
            }
        }
    },

    data() {
        return{
            campanias: [],
            errors:[], 
        }
    },

    //metodos
    methods:{
        doSaveData() {

            if (this.validateFields().length > 0) {
                return;
            }

            let alertasData = {
                nombrealerta: this.alerta.nombrealerta,
                descripcionalerta: this.alerta.descripcionalerta,
                urlalerta: this.alerta.urlalerta,
                fechainicio: this.alerta.fechainicio,
                fechafin: this.alerta.fechafin,
                idcampania: this.alerta.idcampania
            }

            this.$emit('saveData', alertasData);
        },

        listarCampanias() {
            let vm = this;
            axios.get(`${appApiUrl}/campania/select`)
            .then(function (response) {
                vm.campanias = response.data;
            })
            .catch(function (error) {
                console.log(error);
            })
        },

        validateFields() {
            this.errors = [];

            if (!this.alerta.nombrealerta) {
                this.setError('nombrealerta', 'El campo Nombre Alerta es obligatorio');
            }
            /* if (!this.alerta.descripcionalerta) {
                this.setError('descripcionalerta', 'El campo Descripción es obligatorio');
            }
            if (!this.alerta.urlalerta) {
                this.setError('urlalerta', 'El campo URL es obligatorio');
            } */
            if (!this.alerta.idcampania) {
                this.setError('idcampania', 'El campo Campaña es obligatorio');
            }

            if (!this.alerta.fechainicio) {
                this.setError('fechainicio', 'El campo Fecha Inicio es obligatorio');
            }
            if (!this.alerta.fechafin) {
                this.setError('fechafin', 'El campo Fecha Fin es obligatorio');
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

    },

    //iniciamos metodos
    mounted(){
        this.alerta.fechainicio = this.formatDate(new Date(),'DD-MM-YYYY HH:mm:ss');
        this.listarCampanias();
    },

    //iniciamos componentes
    components:{
        MainContent,
        VueNumeric,
        VDatePicker,
        moment,
        Select2,
    },
}
</script>
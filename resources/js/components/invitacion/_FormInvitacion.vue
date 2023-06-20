<template>
    <!-- contendor principal -->
    <main-content>
        <!-- titulo -->
        <template v-slot:card-header-title>
            <span v-text="cardTitle"></span>
        </template>
        <!-- Fomrulario crear - actualizar -->
        <template v-slot:card-body-main>
            <div class="form-row">
                <div class="form-group col-12 col-sm-6 col-md-4 col-xl-3" :class="{'has-danger':errorExists('nombreinstitucion')}">
                    <label>Institucion <small class="text-danger">(*)</small></label>
                    <input type="text" class="form-control" v-model="invitacion.nombreinstitucion" @:keyup.enter ="doSaveData" />
                    <small class="form-control-feedback" v-if="errorExists('nombreinstitucion')" v-text="showError('nombreinstitucion').errorDetail"></small>
                </div>
                <div class="form-group col-12 col-sm-6 col-md-4 col-xl-3" :class="{'has-danger':errorExists('nombreencargado')}">
                    <label>Encargado <small class="text-danger">(*)</small></label>
                    <input type="text" class="form-control" v-model="invitacion.nombreencargado" @:keyup.enter ="doSaveData" />
                    <small class="form-control-feedback" v-if="errorExists('nombreencargado')" v-text="showError('nombreencargado').errorDetail"></small>
                </div>   
                <div class="form-group col-12 col-sm-6 col-md-4 col-xl-3" :class="{'has-danger':errorExists('fecharegistro')}">
                    <label>Fecha de Creación <small class="text-danger">(*)</small></label>
                    <v-date-picker v-model="invitacion.fecharegistro"
                        type="datetime"
                        format="DD-MM-YYYY HH:mm:ss"
                        value-type="format"
                        placeholder="Seccione una fecha">
                    </v-date-picker>
                    <small class="form-control-feedback" v-if="errorExists('fecharegistro')" v-text="showError('fecharegistro').errorDetail"></small>
                </div>                     
            </div>
            
            <hr class="mt-2">
        </template>
        <!-- Acciones footer -->
        <template v-slot:card-body-actions>
            <router-link :to="{name: 'spa.invitacion'}" class="btn waves-effect waves-light btn-info mr-2">
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
import VDatePicker from 'vue2-datepicker';
import moment,{ now } from 'moment';
import 'vue2-datepicker/locale/es';

export default {
    props: {
        cardTitle: {
            default: 'Invitación'
        },
        invitacion: {
            type: Object,
            default() {
                return {
                    nombreinstitucion: '',
                    nombreencargado: '',
                    fecharegistro:'',                   
                }
            }
        },
        
    },
    data(){
        return {
            errors:[],
        }
    },
    methods:{
         doSaveData() {
            if (this.validateFields().length > 0) {
                return;
            }

            let invitacionData = {
                nombreinstitucion: this.invitacion.nombreinstitucion,
                nombreencargado: this.invitacion.nombreencargado,          
                fecharegistro: this.invitacion.fecharegistro,          
            }

            this.$emit('saveData', invitacionData);
        },

        validateFields() {
            this.errors = [];

            if (!this.invitacion.nombreinstitucion) {
                this.setError('nombreinstitucion', 'El campo Institución es obligatorio');
            }
            if (!this.invitacion.nombreencargado) {
                this.setError('nombreencargado', 'El campo Encargado es obligatorio');
            }
            if (!this.invitacion.fecharegistro) {
                this.setError('fecharegistro', 'El campo Fecha es obligatorio');
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

    mounted(){
        this.invitacion.fecharegistro = this.formatDate(new Date(),'DD-MM-YYYY HH:mm:ss');
    },

    created(){

    },

    components:{
        MainContent,
        VDatePicker,
        moment
    }
}
</script>
<template>
    <main-content columnClass="col-12 col-xl-12">
        <template v-slot:card-header-title>
            <span v-text="cardTitle"></span>
        </template>

        <template v-slot:card-body-main>
            <div class="form-row">
                <div class="form-group col-12 col-sm-6 col-md-5" :class="{'has-danger':errorExists('titulo')}">
                    <label>Nombre Empleo <small class="text-danger">(*)</small></label>
                    <input type="text" class="form-control" v-model="empleo.titulo" @:keyup.enter ="doSaveData" />
                    <small class="form-control-feedback" v-if="errorExists('titulo')" v-text="showError('titulo').errorDetail"></small>
                </div>                
                
            </div>
            <div class="form-row">
                <div class="form-group col-12 col-sm-6 col-md-4" :class="{'has-danger':errorExists('requisitos')}">
                    <label>Requerimiento <small class="text-danger">(*)</small></label>
                    <div>
                        <vue-editor v-model="empleo.requisitos" :editorToolbar="customToolbarrequisitos"></vue-editor>
                    </div>
                    <small class="form-control-feedback" v-if="errorExists('requisitos')" v-text="showError('requisitos').errorDetail"></small>
                </div>

                <div class="form-group col-12 col-sm-6 col-md-8" :class="{'has-danger':errorExists('descripcion')}">
                    <label>Descripción <small class="text-danger">(*)</small></label>
                    <vue-editor v-model="empleo.descripcion" :editorToolbar="customToolbar"></vue-editor>
                    <small class="form-control-feedback" v-if="errorExists('descripcion')" v-text="showError('descripcion').errorDetail"></small>
                </div>
                
                
            </div>
            <hr class="mt-2">
        </template>

        <template v-slot:card-body-actions>
            <router-link :to="{name: 'spa.empleo'}" class="btn waves-effect waves-light btn-info mr-2">
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
import { VueEditor } from 'vue2-editor';
    import MainContent from './../../utils/MainContent';
    import VueNumeric from 'vue-numeric';
    import VDatePicker from 'vue2-datepicker';
    // import accounting from 'accounting';
    import moment,{ now } from 'moment';
    import 'vue2-datepicker/locale/es';

    export default {
        props: {
            cardTitle: {
                default: 'Empleo'
            },
            empleo: {
                type: Object,
                default() {
                    return {
                        titulo: '',
                        requisitos: '',
                        descripcion: '',
                    }
                }
            }
        },
        data(){
            return {
                errors:[],
                requisitos:'<ul><li>Requisito 1</ul></ol>',
                descripcion:'',
                customToolbar:[
                    [{ header: [false, 1, 2, 3, 4, 5, 6] }],                    
                    [{ color: [] }/* , { background: [] } */],
                    ["bold", "italic", "underline","strike"],
                    [
                        { list: "ordered" }, { list: "bullet" }
                    ],
                    ["link"],
                    [
                        { align: "" },
                        { align: "center" },
                        { align: "right" },
                        { align: "justify" }
                    ],
                    /* ["image", "code-block"] */
                ],        
                customToolbarrequisitos:[
                    [
                        { list: "bullet" }
                    ],
                    ['indent']
                ],        
            }
        },
        methods: {
            doSaveData() {

                if (this.validateFields().length > 0) {
                    return;
                }

                let rolData = {
                    titulo: this.empleo.titulo,
                    requisitos: this.empleo.requisitos,
                    descripcion: this.empleo.descripcion,
                }

                this.$emit('saveData', rolData);
            },

            validateFields() {
                this.errors = [];

                if (!this.empleo.titulo) {
                    this.setError('titulo', 'El nombre del empleo es obligatorio');
                }
                if (!this.empleo.requisitos) {
                    this.setError('requisitos', 'El campo requerimiento es obligatorio');
                }
                if (!this.empleo.descripcion) {
                    this.setError('descripcion', 'El campo descripción es obligatorio');
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
           
        },
        components: {
            MainContent,
            VueNumeric,
            VDatePicker,
            VueEditor
        }
    }

</script>

<style>
.ql-editor{
    max-height: 440px;
}
</style>
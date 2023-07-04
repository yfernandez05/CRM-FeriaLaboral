<template>
    <main-content columnClass="col-12 col-xl-12">
        <template v-slot:card-header-title>
            <span v-text="cardTitle"></span>
        </template>

        <template v-slot:card-body-main>
            <div class="form-row">
                <div class="form-group col-12 col-sm-6 col-md-4" :class="{'has-danger':errorExists('titulo')}">
                    <label>Cargo <small class="text-danger">(*)</small></label>
                    <input type="text" class="form-control" v-model="empleo.titulo" @:keyup.enter ="doSaveData" />
                    <small class="form-control-feedback" v-if="errorExists('titulo')" v-text="showError('titulo').errorDetail"></small>
                </div>
                <div class="form-group col-12 col-sm-6 col-md-4" :class="{'has-danger':errorExists('idexperiencia')}">
                    <label>Tiempo experiencia</label>
                    <select2 :options="experiencias" v-model="empleo.idexperiencia" :selectValue="empleo.idexperiencia"
                        placeholder="Seleccione un tiempo de experiencia" keyProperty="experiencias" textProperty="nombre">
                    </select2>
                    <small class="form-control-feedback" v-if="errorExists('idexperiencia')"
                        v-text="showError('idexperiencia').errorDetail"></small>
                </div>                
                <div class="form-group col-12 col-sm-6 col-md-2" :class="{'has-danger':errorExists('vacantes')}">
                    <label>Vacantes <small class="text-danger">(*)</small></label>
                    <vue-numeric class="form-control" ref="vacantes" 
                        @keypress.native.enter.prevent="doSaveData"
                        thousand-separator="" v-model="empleo.vacantes" v-bind:precision="0" >
                    </vue-numeric>
                    <small class="form-control-feedback" v-if="errorExists('vacantes')" v-text="showError('vacantes').errorDetail"></small>
                </div>
                <div class="form-group col-12 col-sm-6 col-md-2" :class="{'has-danger':errorExists('preciopromedio')}">
                    <label>Sueldo Promedio</label>
                    <vue-numeric class="form-control" thousand-separator="" v-model="empleo.preciopromedio"
                        currency="S/" v-bind:precision="2">
                    </vue-numeric>
                    <small class="form-control-feedback" v-if="errorExists('preciopromedio')" v-text="showError('preciopromedio').errorDetail"></small>
                </div>
                <div class="form-group col-12 col-sm-6 col-md-4" :class="{'has-danger': errorExists('carrera')}">
                    <label>Carreras <small class="text-danger">(*)</small></label>
                    <multiselect v-model="empleo.carreras"
                        :options="carreras"
                        :multiple="true"
                        track-by="idcarrera"
                        label="nombre"
                        :select-label="'Añadir'"
                        :selected-label="'Seleccionado'"
                        :deselect-label="'Eliminar'"
                        :clear-label="'Limpiar selección'"
                        :search-placeholder="'Buscar'"
                        class="custom-multiselect"
                        placeholder="Seleccione una o varias carreras">
                    </multiselect>
                    <small class="form-control-feedback" v-if="errorExists('carrera')" v-text="showError('carrera').errorDetail"></small>
                </div>
                <div class="form-group col-12 col-sm-6 col-md-4" :class="{'has-danger': errorExists('ciclo')}">
                    <label>Ciclo <small class="text-danger">(*)</small></label>
                    <multiselect v-model="empleo.ciclos"
                        :options="ciclos"
                        :multiple="true"
                        track-by="id"
                        label="nombre"
                        :select-label="'Añadir'"
                        :selected-label="'Seleccionado'"
                        :deselect-label="'Eliminar'"
                        :clear-label="'Limpiar selección'"
                        :search-placeholder="'Buscar'"
                        class="custom-multiselect"
                        placeholder="Seleccione un ciclo o varios">
                    </multiselect>
                    <small class="form-control-feedback" v-if="errorExists('ciclo')" v-text="showError('ciclo').errorDetail"></small>
                </div>
                
            </div>
            <div class="form-row mt-2">             
                <div class="form-group col-12" :class="{'has-danger':errorExists('descripcion')}">
                    <label>Descripción <small class="text-danger">(*)</small></label>
                    <vue-editor v-model="empleo.descripcion" :editorToolbar="customToolbar"></vue-editor>
                    <small class="form-control-feedback" v-if="errorExists('descripcion')" v-text="showError('descripcion').errorDetail"></small>
                </div>
                <div class="form-group col-12 col-sm-6 col-md-6" :class="{'has-danger':errorExists('requisitos')}">
                    <label>Requerimiento <small class="text-danger">(*)</small></label>
                    <div>
                        <vue-editor v-model="empleo.requisitos" :editorToolbar="customToolbarrequisitos"></vue-editor>
                    </div>
                    <small class="form-control-feedback" v-if="errorExists('requisitos')" v-text="showError('requisitos').errorDetail"></small>
                </div>

                <div class="form-group col-12 col-sm-6 col-md-6" :class="{'has-danger':errorExists('beneficios')}">
                    <label>Beneficios </label>
                    <div>
                        <vue-editor v-model="empleo.beneficios" :editorToolbar="customToolbarrequisitos"></vue-editor>
                    </div>
                    <small class="form-control-feedback" v-if="errorExists('beneficios')" v-text="showError('beneficios').errorDetail"></small>
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
    import Multiselect from 'vue-multiselect'
    import Select2 from './../../utils/Select2.vue'
    
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
                        idexperiencia: '',
                        carreras: [],
                        ciclos: [],
                        requisitos: '',
                        beneficios: '',
                        descripcion: '',
                        vacantes: '',
                        preciopromedio: '',
                    }
                }
            }
        },
        data(){
            return {
                errors:[],
                experiencias:[],
                carreras:[],
                ciclos:[],
                requisitos:'<ul><li>Requisito 1</ul></ol>',
                beneficios:'',
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

                let idcarreras = this.empleo.carreras.map(carrera => carrera.idcarrera);
                let idciclos = this.empleo.ciclos.map(ciclo => ciclo.id);
                
                let EmpleoData = {
                    titulo: this.empleo.titulo,
                    idexperiencia: this.empleo.idexperiencia,
                    idcarrera: idcarreras,
                    idciclo: idciclos,
                    requisitos: this.empleo.requisitos,
                    beneficios: this.empleo.beneficios,
                    descripcion: this.empleo.descripcion,
                    vacantes: this.empleo.vacantes,
                    preciopromedio: this.empleo.preciopromedio
                }
                //console.log(EmpleoData)
                this.$emit('saveData', EmpleoData);
            },

            validateFields() {
                this.errors = [];

                if (!this.empleo.titulo) {
                    this.setError('titulo', 'El campo cargo es obligatorio');
                }
                /* if (!this.empleo.idexperiencia) {
                    this.setError('idexperiencia', 'El campo experiencia es obligatorio');
                } */
                if (!this.empleo.carreras || this.empleo.carreras.length === 0) {
                    this.setError('carrera', 'El campo carrera es obligatorio');
                }
                if (!this.empleo.ciclos || this.empleo.ciclos.length === 0) {
                    this.setError('ciclo', 'El campo ciclo es obligatorio');
                }
                if (!this.empleo.requisitos) {
                    this.setError('requisitos', 'El campo requerimiento es obligatorio');
                }                
                if (!this.empleo.descripcion) {
                    this.setError('descripcion', 'El campo descripción es obligatorio');
                }
                if (!this.empleo.vacantes) {
                    this.setError('vacantes', 'El campo vacantes es obligatorio');
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
            listarExperiencias() {
                let vm = this;
                axios.get(`${appApiUrl}/experiencia/select`)
                    .then(function (response) {
                        vm.experiencias = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
            },
            listarCarreras() {
                let vm = this;
                axios.get(`${appApiUrl}/carrera/select`)
                    .then(function (response) {
                        vm.carreras = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
            },
            listarCiclos() {
                let vm = this;
                axios.get(`${appApiUrl}/ciclo/select`)
                    .then(function (response) {
                        vm.ciclos = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
            },
        },
        mounted(){
          this.listarExperiencias(); 
          this.listarCarreras(); 
          this.listarCiclos();
          //this.empleo.idcarrera = [5];
        },
        components: {
            MainContent,
            VueNumeric,
            VueEditor,            
            Multiselect,
            Select2
        }
    }

</script>

<style>
.ql-editor{
    max-height: 440px;
}
.custom-multiselect .multiselect__option , .multiselect, .multiselect__input, .multiselect__single{
  font-size: 0.98em;
}
</style>
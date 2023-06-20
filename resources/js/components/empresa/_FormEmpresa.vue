<template>
    <main-content columnClass="col-12 col-xl-10">
        <template v-slot:card-header-title>
            <span v-text="cardTitle"></span>
        </template>

        <template v-slot:card-body-main>
            <div class="form-row">
                <div class="form-group col-12 col-sm-6 col-md-4" :class="{'has-danger':errorExists('empresa')}">
                    <label>Empresa <small class="text-danger">(*)</small></label>
                    <input type="text" class="form-control" v-model="empresa.empresa" @:keyup.enter ="doSaveData" />
                    <small class="form-control-feedback" v-if="errorExists('empresa')" v-text="showError('empresa').errorDetail"></small>
                </div>
                <div class="form-group col-12 col-sm-6 col-md-4" :class="{'has-danger':errorExists('ruc')}">
                    <label>Ruc <small class="text-danger">(*)</small></label>
                    <vue-numeric class="form-control" ref="ruc" 
                        @keypress.native.enter.prevent="doSaveData"
                        thousand-separator="" v-model="empresa.ruc" v-bind:precision="0" >
                    </vue-numeric>
                    <small class="form-control-feedback" v-if="errorExists('ruc')" v-text="showError('ruc').errorDetail"></small>
                </div>
                <div class="form-group col-12 col-sm-6 col-md-4" :class="{'has-danger':errorExists('razonsocial')}">
                    <label>Razón Social <small class="text-danger">(*)</small></label>
                    <input type="text" class="form-control" v-model="empresa.razonsocial" @:keyup.enter ="doSaveData" />
                    <small class="form-control-feedback" v-if="errorExists('razonsocial')" v-text="showError('razonsocial').errorDetail"></small>
                </div>
            </div>
            <hr class="mt-2">
        </template>

        <template v-slot:card-body-actions>
            <router-link :to="{name: 'spa.empresa'}" class="btn waves-effect waves-light btn-info mr-2">
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
    import VueNumeric from 'vue-numeric';
    import VDatePicker from 'vue2-datepicker';
    // import accounting from 'accounting';
    import moment,{ now } from 'moment';
    import 'vue2-datepicker/locale/es';

    export default {
        props: {
            cardTitle: {
                default: 'Empresa'
            },
            empresa: {
                type: Object,
                default() {
                    return {
                        empresa: '',
                        ruc: '',
                        razonsocial: '',
                    }
                }
            }
        },
        data(){
            return {
                errors:[]
            }
        },
        methods: {
            doSaveData() {

                if (this.validateFields().length > 0) {
                    return;
                }

                let rolData = {
                    empresa: this.empresa.empresa,
                    ruc: this.empresa.ruc,
                    razonsocial: this.empresa.razonsocial,
                }

                this.$emit('saveData', rolData);
            },

            validateFields() {
                this.errors = [];

                if (!this.empresa.empresa) {
                    this.setError('empresa', 'El campo Empresa es obligatorio');
                }
                if (!this.empresa.ruc) {
                    this.setError('ruc', 'El campo Ruc es obligatorio');
                }
                if (!this.empresa.razonsocial) {
                    this.setError('razonsocial', 'El campo Razón Social es obligatorio');
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
            VDatePicker
        }
    }

</script>

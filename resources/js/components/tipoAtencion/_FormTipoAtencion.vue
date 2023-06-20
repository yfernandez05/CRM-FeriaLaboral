<template>
    <main-content columnClass="col-12 col-md-10 col-lg-8 col-xl-7">
        <template v-slot:card-header-title>
            <span v-text="cardTitle"></span>
        </template>

        <template v-slot:card-body-main>
            <div class="form-row">
                <div class="form-group col-12 col-sm-12" :class="{'has-danger':errorExists('tipoAtencion')}">
                    <label>Estado de Atencion <small class="text-danger">(*)</small></label>
                    <input type="text" class="form-control" v-model="tipoatencion.tipoatencion"/>
                    <small class="form-control-feedback" v-if="errorExists('tipoAtencion')" v-text="showError('tipoAtencion').errorDetail"></small>
                </div>
                <div class="form-group col-12 col-sm-12" >
                    <label>Color <small class="text-danger">(*)</small></label>
                    <input type="text" class="form-control" v-model="tipoatencion.color"/>
                </div>
            </div>
            <hr class="mt-2">
        </template>

        <template v-slot:card-body-actions>
            <router-link :to="{name: 'spa.tipoAtencion'}" class="btn waves-effect waves-light btn-info mr-2">
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

    export default {
        props: {
            cardTitle: {
                default: 'TipoAtencion'
            },
            tipoatencion: {
                type: Object,
                default: function () {
                    return {
                        tipoatencion: '',
                        color:''
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

                let TipoAtencionData = {
                    tipoatencion: this.tipoatencion.tipoatencion,
                    color: this.tipoatencion.color
                }

                this.$emit('saveData', TipoAtencionData);
            },

            validateFields() {
                this.errors = [];

                if (!this.tipoatencion.tipoatencion) {
                    this.setError('tipoAtencion', 'El campo Tipo de Dato es obligatorio');
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
        components: {
            MainContent
        }
    }

</script>

<template>
    <main-content columnClass="col-12 col-md-10 col-lg-8 col-xl-7">
        <template v-slot:card-header-title>
            <span v-text="cardTitle"></span>
        </template>

        <template v-slot:card-body-main>
            <div class="form-row">
                <div class="form-group col-12 col-sm-12" :class="{'has-danger':errorExists('tipoEvento')}">
                    <label>Tipo Evento <small class="text-danger">(*)</small></label>
                    <input type="text" class="form-control" v-model="tipoevento.tipoevento"/>
                    <small class="form-control-feedback" v-if="errorExists('tipoEvento')" v-text="showError('tipoEvento').errorDetail"></small>
                </div>
            </div>
            <hr class="mt-2">
            <div class="form-group col-12 col-sm-12" >
                <label><small>Opciones adicionales:</small></label><br>

                <label>Seleccione color de fondo: &nbsp;</label>
                <v-input-colorpicker v-model="tipoevento.backgroundColor"/> &nbsp; &nbsp;
                <!-- <input type="text" class="form-control" v-model="estadopago.backgroundColor"/> -->

                <label>Seleccione color de texto: &nbsp;</label>
                <v-input-colorpicker v-model="tipoevento.textColor"/>
                <!-- <input type="text" class="form-control" v-model="estadopago.textColor"/> -->
            </div>
            <div class="form-group col-12 col-sm-12" >
                <label><small>Vista previa:</small></label><br>
                <h4><span v-bind:style="{background: tipoevento.backgroundColor, color:tipoevento.textColor}" class="badge badge-pill badge-lg mb-3" v-text="tipoevento.tipoevento"></span></h4>
            </div>
        </template>

        <template v-slot:card-body-actions>
            <router-link :to="{name: 'spa.tipoEvento'}" class="btn waves-effect waves-light btn-info mr-2">
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
    import VInputColorpicker from 'vue-native-color-picker'

    export default {
        props: {
            cardTitle: {
                default: 'tipo Evento'
            },
            tipoevento: {
                type: Object,
                default: function () {
                    return {
                        tipoevento: '',
                        backgroundColor: '#d3d3d3',
                        textColor: '#000',
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

                let TipoEventoData = {
                    tipoevento: this.tipoevento.tipoevento,
                    backgroundColor: this.tipoevento.backgroundColor,
                    textColor: this.tipoevento.textColor,
                }

                this.$emit('saveData', TipoEventoData);
            },

            validateFields() {
                this.errors = [];

                if (!this.tipoevento.tipoevento) {
                    this.setError('tipoEvento', 'El campo Tipo de Evento es obligatorio');
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
            MainContent,
            VInputColorpicker
        }
    }

</script>

<style scoped>
input.icp__input {
    border: 2px solid #333a40 !important;
}
</style>

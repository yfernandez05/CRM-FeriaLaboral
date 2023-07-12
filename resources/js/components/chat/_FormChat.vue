<template>
    <main-content columnClass="col-12 col-xl-8">
        <template v-slot:card-header-title>
            <span v-text="cardTitle"></span>
        </template>

        <template v-slot:card-body-main>
            <div class="form-row">
                <div class="form-group col-12 col-sm-6 col-md-6" :class="{'has-danger':errorExists('nombresala')}">
                    <label>Nombre Sala <small class="text-danger">(*)</small></label>
                    <input type="text" class="form-control" v-model="sala.nombresala" @:keyup.enter ="doSaveData" />
                    <small class="form-control-feedback" v-if="errorExists('nombresala')" v-text="showError('nombresala').errorDetail"></small>
                </div>

                <div class="form-group col-12 col-sm-6 col-md-6" :class="{'has-danger':errorExists('descripcion')}">
                    <label>Descripción </label>
                    <input type="text" class="form-control" v-model="sala.descripcion" @:keyup.enter ="doSaveData" />
                    <small class="form-control-feedback" v-if="errorExists('descripcion')" v-text="showError('descripcion').errorDetail"></small>
                </div>
                <div class="form-group col-12 col-sm-6 col-md-6" :class="{'has-danger':errorExists('datofijado')}">
                    <label>Dato Fijado </label>
                    <textarea type="text" class="form-control" v-model="sala.datofijado" @:keyup.enter ="doSaveData" rows="3"></textarea>
                    <small class="form-control-feedback" v-if="errorExists('contrato')" v-text="showError('datofijado').errorDetail"></small>
                </div>
            </div>
            <hr class="mt-2">
        </template>

        <template v-slot:card-body-actions>
            <router-link :to="{name: 'spa.chat'}" class="btn waves-effect waves-light btn-info mr-2">
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
            default: 'Sala'
        },
        sala: {
            type: Object,
            default() {
                return {
                    nombresala: '',
                    descripcion: '',
                    datofijado: '',
                    idtiposala: 2,
                }
            }
        }
    },
    data(){
        return {
            errors:[]
        }
    },
    methods:{
        doSaveData() {

            if (this.validateFields().length > 0) {
                return;
            }

            let salaData = {
                nombresala: this.sala.nombresala,
                descripcion: this.sala.descripcion,
                datofijado: this.sala.datofijado,
                idtiposala: this.sala.idtiposala,
            }

            this.$emit('saveData', salaData);
        },

        validateFields() {
            this.errors = [];

            if (!this.sala.nombresala) {
                this.setError('nombresala', 'El campo Nombre Sala es obligatorio');
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

    },
    components:{
        MainContent
    }
}
</script>
<template>
    <main-content columnClass="col-12 col-md-10 col-lg-8 col-xl-7">
        <template v-slot:card-header-title>
            <span v-text="cardTitle"></span>
        </template>

        <template v-slot:card-body-main>
            <div class="form-row">
                <div class="form-group col-12 col-sm-6" :class="{'has-danger':errorExists('idrol')}">
                    <label>Rol <small class="text-danger">(*)</small></label>
                    <select2 :options="roles" v-model="user.idrol" :selectValue="user.idrol"
                        placeholder="Seleccione Un rol" keyProperty="idrol" textProperty="rol">
                    </select2>
                    <small class="form-control-feedback" v-if="errorExists('idrol')"
                        v-text="showError('idrol').errorDetail"></small>
                </div>
                <div class="form-group col-12 col-sm-6" :class="{'has-danger':errorExists('idcuenta')}">
                    <label>Cuenta <small class="text-danger">(*)</small></label>
                    <select2 :options="cuentas" v-model="user.idcuenta" :selectValue="user.idcuenta"
                        placeholder="Seleccione una cuenta" keyProperty="idcuenta" textProperty="empresa">
                    </select2>
                    <small class="form-control-feedback" v-if="errorExists('idcuenta')"
                        v-text="showError('idcuenta').errorDetail"></small>
                </div>
                <div class="form-group col-12 col-sm-6" :class="{'has-danger':errorExists('idempresa')}">
                    <label>Empresa <small class="text-danger">(*)</small></label>
                    <select2 :options="empresas" v-model="user.idempresa" :selectValue="user.idempresa"
                        placeholder="Seleccione una empresa" keyProperty="idempresa" textProperty="empresa">
                    </select2>
                    <small class="form-control-feedback" v-if="errorExists('idempresa')"
                        v-text="showError('idempresa').errorDetail"></small>
                </div>
                <div class="form-group col-12 col-sm-6" :class="{'has-danger':errorExists('name')}">
                    <label>Nombres <small class="text-danger">(*)</small></label>
                    <input type="text" class="form-control" v-model="user.name" />
                    <small class="form-control-feedback" v-if="errorExists('name')"
                        v-text="showError('name').errorDetail"></small>
                </div>
                <div class="form-group col-12 col-sm-6" :class="{'has-danger':errorExists('email')}">
                    <label>Email <small class="text-danger">(*)</small></label>
                    <input type="text" class="form-control" v-model="user.email" />
                    <small class="form-control-feedback" v-if="errorExists('email')"
                        v-text="showError('email').errorDetail"></small>
                </div>

                <div class="form-group col-12 col-sm-6" :class="{'has-danger':errorExists('password')}"
                    v-if="showPasswordField">
                    <label>Password <small class="text-danger">(*)</small></label>
                    <input type="text" class="form-control" v-model="user.password" />
                    <small class="form-control-feedback" v-if="errorExists('password')"
                        v-text="showError('password').errorDetail"></small>
                </div>
                <div class="form-group col-12 col-sm-6" :class="{'has-danger':errorExists('password_confirmation')}"
                    v-if="showPasswordField">
                    <label>Confirmar Password <small class="text-danger">(*)</small></label>
                    <input type="text" class="form-control" v-model="user.password_confirmation" />
                    <small class="form-control-feedback" v-if="errorExists('password_confirmation')"
                        v-text="showError('password_confirmation').errorDetail"></small>
                </div>
            </div>

            <hr class="mt-2">
        </template>

        <template v-slot:card-body-actions>
            <router-link :to="{name: 'spa.user'}" class="btn waves-effect waves-light btn-info mr-2">
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


    export default {
        props: {
            cardTitle: {
                default: 'user'
            },
            user: {
                type: Object,
                // a factory function
                default: function () {
                    return {
                        name: '',
                        email: '',
                        password: '',
                        password_confirmation: '',
                        api_token: '',

                    }
                }
            },
            showPasswordField: {
                type: Boolean,
                default: true
            }

        },
        data() {
            return {
                roles: [],
                cuentas: [],
                empresas: [],
                errors: [],

            }
        },
        methods: {
            listarRoles() {
                let vm = this;
                axios.get(`${appApiUrl}/rol/select`)
                    .then(function (response) {
                        vm.roles = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
            },
            listarCuentas() {
                let vm = this;
                axios.get(`${appApiUrl}/cuenta/select`)
                    .then(function (response) {
                        vm.cuentas = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
            },
            listarEmpresa() {
                let vm = this;
                axios.get(`${appApiUrl}/empresa/select`)
                    .then(function (response) {
                        vm.empresas = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
            },
            doSaveData() {

                if (this.validateFields().length > 0) {
                    return;
                }

                let userData = {
                    name: this.user.name,
                    email: this.user.email,
                    //password:this.user.password,
                    idrol: this.user.idrol,
                    idcuenta: this.user.idcuenta,
                    idempresa: this.user.idempresa,
                    api_token: this.user.api_token,
                };

                if (this.showPasswordField)
                    userData.password = this.user.password;

                this.$emit('saveData', userData);
            },
            validateFields() {
                this.errors = [];

                if (!this.user.idrol) {
                    this.setError('idrol', 'El campo Rol es obligatorio');
                }

                if (!this.user.idcuenta) {
                    this.setError('idcuenta', 'El campo Empresa es obligatorio');
                }

                if (!this.user.name) {
                    this.setError('name', 'El campo Nombre es obligatorio');
                }
                if (!this.user.email) {
                    this.setError('email', 'El campo Email es obligatorio');
                }


                if (this.showPasswordField) {

                    if (!this.user.password) {
                        this.setError('password', 'El campo password es obligatorio');
                    }

                    if (!this.user.password_confirmation) {
                        this.setError('password_confirmation', 'El campo confirmar password es obligatorio');
                    }

                    if (this.user.password != this.user.password_confirmation) {
                        this.setError('password_confirmation', 'Los passwords no coinciden');
                    }
                }


                return this.errors;
            },
            setError(keyModel, errorDetail) {
                this.errors.push({
                    keyModel: keyModel,
                    errorDetail: errorDetail
                });
            },
            errorExists(keyModel) {
                return this.errors.filter(err => err.keyModel === keyModel).length;
            },
            showError(keyModel) {
                return this.errors.find(err => err.keyModel === keyModel);
            },
        },
        mounted() {
            this.listarRoles();
            this.listarCuentas();
            this.listarEmpresa();
        },
        components: {
            MainContent,
            Select2,

        }
    }

</script>

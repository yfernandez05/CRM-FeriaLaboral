<template>
    <main-content>
        <template v-slot:card-header-title>
            Empresas
        </template>
        <template v-slot:card-header-actions>
            <button class="btn btn-sm btn-info waves-effect waves-light" @click="buscarEmpresa()">
                <i class="fas fa-search"></i>
                <span class="d-none d-sm-inline-block">
                    Buscar
                </span>
            </button>
            <button class="btn btn-sm btn-danger waves-effect waves-light">
                <i class="fas fa-times"></i>
                <span class="d-none d-sm-inline-block" @click="limpiarFiltroEmpresa()">
                    Limpiar
                </span>
            </button>
            <router-link :to="{name:'spa.empresa.registrar'}" class="btn btn-sm btn-success waves-effect waves-light">
                 <i class="fas fa-plus"></i>
                <span class="d-none d-sm-inline-block ">
                    Nuevo
                </span>
            </router-link>    
        </template>
        <template v-slot:card-body-main>
            <div class="form-row">
                <div class="form-group col-12 col-sm-6 col-md-4 ">
                    <label>Empresa</label>
                    <input type="text" class="form-control" v-model="empresa.empresa" @keyup.enter="buscarEmpresa()">
                </div>
                <div class="form-group col-12 col-sm-6 col-md-4 ">
                    <label>Ruc</label>
                    <input type="text" class="form-control" v-model="empresa.ruc" @keyup.enter="buscarEmpresa()">
                </div>
                <div class="form-group col-12 col-sm-6 col-md-4 ">
                    <label>Razón Social</label>
                    <input type="text" class="form-control" v-model="empresa.razonsocial" @keyup.enter="buscarEmpresa()">
                </div>
                <div class="form-group col-12 col-sm-6 col-md-4 ">
                    <label>&nbsp;</label>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="estado" 
                            v-model="empresa.estado" @change="buscarEmpresa()">
                        <label class="custom-control-label" for="estado">Incluir Eliminados</label>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="p-2">Acciones</th>
                            <th class="p-2">Cod</th>
                            <th class="p-2">Empresa</th>
                            <th class="p-2">Ruc</th>
                            <th class="p-2 text-nowrap">Razón Social</th>
                            <th class="p-2">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="emp in empresas" :key="emp.idempresa">
                            <td>
                                <row-actions :rowData="emp" @rowItemActions="rowItemActions">
                                </row-actions>
                            </td>
                            <td v-text="emp.idempresa"></td>
                            <td v-text="emp.empresa"></td>
                            <td v-text="emp.ruc"></td>
                            <td v-text="emp.razonsocial"></td>
                            <td >
                                <span class="badge badge-pill py-1 px-3" 
                                    :class="emp.isactive ? 'badge-success':'badge-danger'"
                                     v-text="emp.statename">
                                </span>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
            <pagination-links :pagination="pagination" @changePerPage="changePerPage">
            </pagination-links>

        </template>
    </main-content>
</template>


<script>
    import MainContent from './../../utils/MainContent';
    import PaginationLinks from './../../utils/PaginationLinks';
    import RowActions from './../../utils/RowActions';
    import VDatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/locale/es';
    import moment,{ now } from 'moment';

    export default {
        data() {
            return {
                empresas: [],
                pagination: {},
                filters: {},
                empresa: {
                    empresa: '',
                    ruc: '',
                    razonsocial: '',
                    estado: false
                }
            }
        },
        
        methods: {
            listarEmpresa() {
                showPreloader();

                let vm = this;
                axios.get(`${appApiUrl}/empresa`, {
                        params: this.filters
                    })
                    .then(function (response) {

                        hidePreloader();
                        vm.empresas = response.data.data;
                        vm.pagination = response.data;
                        delete vm.pagination.data;
                    })
                    .catch(function (error) {
                        hidePreloader();
                        console.log(error);
                    });
            },
            changePerPage(event) {
                this.filters.page = event.page;
                this.filters.perpage = event.perpage;
                this.listarEmpresa();
            },
            rowItemActions(event) {
                switch (event.action) {
                    case 'edit':
                        if(!event.data.isactive) {
                            warningMessage(appCannotDeleteMessage, appName);
                            break;
                        }

                        this.$router.push({ name: 'spa.empresa.editar', params: { id: event.data.idempresa } }) 
                    break;
                    case 'delete':
                        this.eliminarRol(event.data);
                    break;
                }
            },
            buscarEmpresa() {
                this.filters = {};
                this.filters.page = 1;

                if (this.empresa.empresa.length)
                    this.filters.empresa = this.empresa.empresa;
                
                if (this.empresa.ruc.length)
                    this.filters.ruc = `%${this.empresa.ruc}`;
                
                if (this.empresa.razonsocial.length)
                    this.filters.razonsocial = this.empresa.razonsocial;
                
                if (this.empresa.estado)
                    this.filters.estado = this.empresa.estado;

                this.listarEmpresa();  
            },
            eliminarRol(param){
                let vm = this;

                if(!param.isactive) {
                    warningMessage(appRecordIsDeletedMessage, appName);
                    return;
                }

                swalAlertConfirm(`¿Seguro que quiere eliminar la empresa <b>${param.empresa}</b>?`, appName)
                    .then(function(optionSelected){
                        if(optionSelected.value){
                            
                            showPreloader();
                            axios.delete(`${appApiUrl}/empresa/${param.idempresa}`)
                                .then(function (response) {         
                                    hidePreloader();
                                    let result = response.data;

                                    if (result.status) {
                                        successMessage(result.message, appName);
                                        vm.listarEmpresa();
                                    } else
                                        errorMessage(result.message, appName);
                                })
                                .catch(function (error) {
                                    hidePreloader();
                                    errorMessage(appErrorMessage, appName);
                                    console.log(error);
                                });
                        }
                    });
            },             
            limpiarFiltroEmpresa(){
                this.empresa.empresa = '';
                this.empresa.ruc = '';
                this.empresa.razonsocial = '';
            },
            formatDate (value, fmt = 'D MMM YYYY') {
                return (value == null)
                    ? ''
                    : moment(value, 'YYYY-MM-DD HH:mm:ss').format(fmt)
            },
            selectToday(emit){
                emit([ new Date(), new Date() ]);
            },
        },
        mounted() {
            this.listarEmpresa();
        },
        components: {
            MainContent,
            PaginationLinks,
            RowActions,
            VDatePicker,
        }
    }

</script>

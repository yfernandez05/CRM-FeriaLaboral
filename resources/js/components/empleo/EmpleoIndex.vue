<template>
    <main-content>
        <template v-slot:card-header-title>
            Empleo
        </template>
        <template v-slot:card-header-actions>
            <button class="btn btn-sm btn-info waves-effect waves-light" @click="buscarEmpleo()">
                <i class="fas fa-search"></i>
                <span class="d-none d-sm-inline-block">
                    Buscar
                </span>
            </button>
            <button class="btn btn-sm btn-danger waves-effect waves-light">
                <i class="fas fa-times"></i>
                <span class="d-none d-sm-inline-block" @click="limpiarFiltroEmpleo()">
                    Limpiar
                </span>
            </button>
            <router-link :to="{name:'spa.empleo.registrar'}" class="btn btn-sm btn-success waves-effect waves-light">
                 <i class="fas fa-plus"></i>
                <span class="d-none d-sm-inline-block ">
                    Nuevo
                </span>
            </router-link>    
        </template>
        <template v-slot:card-body-main>
            <div class="form-row">
                <div class="form-group col-12 col-sm-6 col-md-4 ">
                    <label>Empleo</label>
                    <input type="text" class="form-control" v-model="empleo.titulo" @keyup.enter="buscarEmpleo()">
                </div>
                <!-- <div class="form-group col-12 col-sm-6 col-md-4 ">
                    <label>Ruc</label>
                    <input type="text" class="form-control" v-model="empleo.descripcion" @keyup.enter="buscarEmpleo()">
                </div> -->
                <div class="form-group col-12 col-sm-6 col-md-4 ">
                    <label>&nbsp;</label>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="estado" 
                            v-model="empleo.estado" @change="buscarEmpleo()">
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
                            <th class="p-2">Empleo</th>
                            <th class="p-2 text-nowrap">Requisitos</th>
                            <th class="p-2">Descripción</th>                            
                            <th class="p-2">F. Publicación</th>
                            <th class="p-2">Empresa</th>
                            <!-- <th class="p-2">F. Cierre</th> -->
                            <th class="p-2">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr v-for="emp in empleos" :key="emp.id">
                            <td>
                                <row-actions :rowData="emp" @rowItemActions="rowItemActions">
                                </row-actions>
                            </td>
                            <td v-text="emp.id"></td>
                            <td v-text="emp.titulo"></td>
                            <td v-html="sanitizeHTML(emp.requisitos).slice(0, 25) + '...'"></td>
                            <td v-html="sanitizeHTML(emp.descripcion).slice(0, 25) + '...'"></td>
                            <td v-text="emp.fecha_publicacion"></td>
                            <td v-text="emp.empresa.empresa"></td>
                            <!-- <td v-text="emp.fecha_cierre"></td> -->
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
    import DOMPurify from 'dompurify';
    import MainContent from './../../utils/MainContent';
    import PaginationLinks from './../../utils/PaginationLinks';
    import RowActions from './../../utils/RowActions';
    import VDatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/locale/es';
    import moment,{ now } from 'moment';

    export default {
        data() {
            return {
                empleos: [],
                pagination: {},
                filters: {},
                empleo: {
                    titulo: '',
                    descripcion: '',
                    requisitos: '',
                    estado: false
                }
            }
        },
        
        methods: {
            listarEmpleo() {
                showPreloader();

                let vm = this;
                axios.get(`${appApiUrl}/empleo`, {
                        params: this.filters
                    })
                    .then(function (response) {

                        hidePreloader();
                        vm.empleos = response.data.data;
                        vm.pagination = response.data;
                        delete vm.pagination.data;
                    })
                    .catch(function (error) {
                        hidePreloader();
                        console.log(error);
                    });
            },
            sanitizeHTML(html) {
                return DOMPurify.sanitize(html);
            },
            changePerPage(event) {
                this.filters.page = event.page;
                this.filters.perpage = event.perpage;
                this.listarEmpleo();
            },
            rowItemActions(event) {
                switch (event.action) {
                    case 'edit':
                        if(!event.data.isactive) {
                            warningMessage(appCannotDeleteMessage, appName);
                            break;
                        }

                        this.$router.push({ name: 'spa.empleo.editar', params: { id: event.data.id } }) 
                    break;
                    case 'delete':
                        this.eliminarEmpleo(event.data);
                    break;
                }
            },
            buscarEmpleo() {
                this.filters = {};
                this.filters.page = 1;

                if (this.empleo.titulo.length)
                    this.filters.titulo = this.empleo.titulo;
                
                if (this.empleo.descripcion.length)
                    this.filters.descripcion = `%${this.empleo.descripcion}`;
                
                if (this.empleo.requisitos.length)
                    this.filters.requisitos = this.empleo.requisitos;
                
                if (this.empleo.estado)
                    this.filters.estado = this.empleo.estado;

                this.listarEmpleo();  
            },
            eliminarEmpleo(param){
                let vm = this;

                if(!param.isactive) {
                    warningMessage(appRecordIsDeletedMessage, appName);
                    return;
                }

                swalAlertConfirm(`¿Seguro que quiere eliminar la oferta laboral <b>${param.titulo}</b>?`, appName)
                    .then(function(optionSelected){
                        if(optionSelected.value){
                            
                            showPreloader();
                            axios.delete(`${appApiUrl}/empleo/${param.id}`)
                                .then(function (response) {         
                                    hidePreloader();
                                    let result = response.data;

                                    if (result.status) {
                                        successMessage(result.message, appName);
                                        vm.listarEmpleo();
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
            limpiarFiltroEmpleo(){
                this.empleo.titulo = '';
                this.empleo.descripcion = '';
                this.empleo.requisitos = '';
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
            this.listarEmpleo();
        },
        components: {
            MainContent,
            PaginationLinks,
            RowActions,
            VDatePicker,
        }
    }

</script>

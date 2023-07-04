<template>
    <main-content>
        <template v-slot:card-header-title>
            Empleo
        </template>
        <template v-slot:card-header-actions>
            <button class="btn btn-sm btn-green waves-effect waves-light" @click="descargarExcel()">
                <i class="fas fa-file-excel"></i>
                <span class="d-none d-sm-inline-block">
                    Descargar
                </span>
            </button>
            <i class="fas fa-grip-lines-vertical text-white px-3"></i>
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
                    <label>Cargo</label>
                    <input type="text" class="form-control" v-model="empleo.titulo" @keyup.enter="buscarEmpleo()">
                </div>
                <div class="form-group col-12 col-sm-6 col-md-4 col-xl-3 ">
                    <label>Fecha</label>
                    <v-date-picker v-model="empleo.fecha_publicacion" range lang="es" format="DD-MM-YYYY" confirm
                        :editable="false" placeholder="Seleccione un rango de fecha" @input="buscarEmpleo()">
                        <template v-slot:footer="{ emit }">
                            <button class="mx-btn" @click="selectToday(emit)">
                                Hoy
                            </button>
                        </template>
                    </v-date-picker>
                </div>                
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
                            <th class="p-2">Empresa</th>
                            <th class="p-2">Cargo</th>
                            <th class="p-2">Descripción</th>                            
                            <th class="p-2 text-nowrap">Requisitos</th>
                            <th class="p-2 text-nowrap">Beneficios</th>
                            <th class="p-2">Carreras</th>
                            <th class="p-2">Ciclos</th>
                            <th class="p-2">Experiencia</th>
                            <th class="p-2">Vacantes</th>
                            <th class="p-2">Sueldo Promedio</th>
                            <th class="p-2">F. Publicación</th>                            
                            <!-- <th class="p-2">F. Cierre</th> -->
                            <th class="p-2">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr v-for="emp in empleos" :key="emp.id">
                            <td>
                                <row-actions :rowData="emp" @rowItemActions="rowItemActions" :activeDelete="false">
                                    <button type="button" :title="emp.isactive ? 'Eliminar':'Restaurar'" @click="cambiarEstado(emp)"
                                            class="btn btn-sm  waves-effect waves-light border-0 mr-1"
                                            :class="emp.isactive ? 'btn-outline-danger':'btn-outline-success'">
                                        <i class="fas fa-lg" :class="emp.isactive ? 'fa-trash':'fa-check-circle'"></i>
                                    </button>
                                </row-actions>
                            </td>
                            <td v-text="emp.id"></td>
                            <td v-text="emp.empresa.empresa"></td>
                            <td v-text="emp.titulo"></td>
                            <td v-html="sanitizeHTML(emp.descripcion).slice(0, 35) + '...'"></td>
                            <td v-html="sanitizeHTML(emp.requisitos).slice(0, 35) + '...'"></td>
                            <td>
                                <template v-if="emp.beneficios !== null">
                                    <span v-html="sanitizeHTML(emp.beneficios).slice(0, 35) + '...'"></span>
                                </template>
                                <template v-else></template>
                            </td>
                            <td>                                    
                                <span class="badge badge-primary py-1 px-3 mb-1" v-for="carrera in emp.carreras" :key="carrera.idcarrera" v-text="carrera.nombre"></span>
                            </td>
                            <td>                                
                                <span class="badge badge-primary py-1 px-3 mb-1" v-for="ciclo in emp.ciclos" :key="ciclo.id" v-text="ciclo.nombre "></span>
                            </td>

                            <td v-text="emp.experiencia.nombre"></td>
                            <td v-text="emp.vacantes"></td>
                            <td>{{ emp.preciopromedio !== null && emp.preciopromedio !== 0 ? emp.preciopromedio : '' }}</td>
                            <td v-text="emp.fecharegistro"></td>                            
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
    import qs from 'qs';

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
                    fecha_publicacion: '',
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

                if (this.empleo.fecha_publicacion.length == 2) {
                    if (this.empleo.fecha_publicacion[0] != null)
                        this.filters.fechadesde = this.formatDate(this.empleo.fecha_publicacion[0], 'DD-MM-YYYY');

                    if (this.empleo.fecha_publicacion[1] != null)
                        this.filters.fechahasta = this.formatDate(this.empleo.fecha_publicacion[1], 'DD-MM-YYYY');
                }
                
                if (this.empleo.estado)
                    this.filters.estado = this.empleo.estado;

                this.listarEmpleo();  
            },
            cambiarEstado(param) {
                let vm = this;
                
                let optionMessage ='Eliminar';

                if(!param.isactive) optionMessage = 'Restaurar';


                swalAlertConfirm(`¿Seguro que quiere ${optionMessage} el Empleo <b>${param.titulo}</b>?`, appName)
                    .then(function (optionSelected) {

                        if (optionSelected.value) {

                            showPreloader();
                            axios.delete(`${appApiUrl}/empleo/${param.id}`)
                                .then(function (response) {
                                    hidePreloader();
                                    let result = response.data;

                                    if (result.status) {
                                        successMessage(result.message, appName);
                                        vm.listarEmpleo();
                                    }  else if (result.warning){
                                        warningMessage(result.message, appName);
                                        vm.listarEmpleo();
                                    } else{
                                        errorMessage(result.message, appName);
                                    }

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
                this.empleo.fecha_publicacion = '';
                this.buscarEmpleo();
            },
            formatDate (value, fmt = 'D MMM YYYY') {
                return (value == null)
                    ? ''
                    : moment(value, 'YYYY-MM-DD HH:mm:ss').format(fmt)
            },
            selectToday(emit){
                emit([ new Date(), new Date() ]);
            },

            descargarExcel() {
                this.buscarEmpleo();

                let urlexcel = `${appApiUrl}/empleo/exportarexcel?${qs.stringify(this.filters)}`;
                window.location = urlexcel;
            }
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

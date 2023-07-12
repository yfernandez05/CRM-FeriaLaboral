<template>
    <main-content>
        <template v-slot:card-header-title>
            Experiencia
        </template>
        <template v-slot:card-header-actions>
            <button class="btn btn-sm btn-info waves-effect waves-light" @click="buscarExperiencia()">
                <i class="fas fa-search"></i>
                <span class="d-none d-sm-inline-block">
                    Buscar
                </span>
            </button>
            <button class="btn btn-sm btn-danger waves-effect waves-light">
                <i class="fas fa-times"></i>
                <span class="d-none d-sm-inline-block" @click="limpiarFiltrosExperiencia()">
                    Limpiar
                </span>
            </button>
            <router-link :to="{name:'spa.experiencia.registrar'}" class="btn btn-sm btn-success waves-effect waves-light">
                 <i class="fas fa-plus"></i>
                <span class="d-none d-sm-inline-block ">
                    Nuevo
                </span>
            </router-link>    
        </template>
        <template v-slot:card-body-main>
            <div class="form-row">
                <div class="form-group col-12 col-sm-6 col-md-4 ">
                    <label>Experiencia</label>
                    <input type="text" class="form-control" v-model="experiencia.nombre" @keyup.enter="buscarExperiencia()">
                </div>
                
                <div class="form-group col-12 col-sm-6 col-md-4 ">
                    <label>&nbsp;</label>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="estado" 
                            v-model="experiencia.estado" @change="buscarExperiencia()">
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
                            <th class="p-2">Experiencia</th>
                            <th class="p-2">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="exp in experiencias" :key="exp.id">
                            <td>
                                <row-actions :rowData="exp" @rowItemActions="rowItemActions" :activeDelete="false">
                                    <button type="button" :title="exp.isactive ? 'Desactivar':'Activar'" @click="cambiarEstado(exp)"
                                            class="btn btn-sm  waves-effect waves-light border-0 mr-1"
                                            :class="exp.isactive ? 'btn-outline-danger':'btn-outline-success'">
                                        <i class="fas fa-lg" :class="exp.isactive ? 'fa-trash':'fa-check-circle'"></i>
                                    </button>
                                </row-actions>
                            </td>
                            <td v-text="exp.id"></td>
                            <td v-text="exp.nombre"></td>
                            <td >
                                <span class="badge badge-pill py-1 px-3" 
                                    :class="exp.isactive ? 'badge-success':'badge-danger'"
                                     v-text="exp.statename">
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

    export default {
        data() {
            return {
                experiencias: [],
                pagination: {},
                filters: {},
                experiencia: {
                    nombre: '',
                }
            }
        },
        
        methods: {
            listarExperiencia() {
                showPreloader();

                let vm = this;
                axios.get(`${appApiUrl}/experiencia`, {
                        params: this.filters
                    })
                    .then(function (response) {

                        hidePreloader();
                        vm.experiencias = response.data.data;
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
                this.listarExperiencia();
            },
            rowItemActions(event) {
                switch (event.action) {
                    case 'edit':
                        if(!event.data.isactive) {
                            warningMessage(appCannotDeleteMessage, appName);
                            break;
                        }

                        this.$router.push({ name: 'spa.experiencia.editar', params: { id: event.data.id } }) 
                    break;
                    case 'delete':
                        this.eliminarExperiencia(event.data);
                    break;
                }
            },
            buscarExperiencia() {
                this.filters = {};
                this.filters.page = 1;

                if (this.experiencia.nombre.length)
                    this.filters.nombre = this.experiencia.nombre;

                if (this.experiencia.estado)
                    this.filters.estado = this.experiencia.estado;

                this.listarExperiencia();  
            },
            cambiarEstado(param) {
                let vm = this;
                
                let optionMessage ='Eliminar';

                if(!param.isactive) optionMessage = 'Activar';


                swalAlertConfirm(`¿Seguro que quiere ${optionMessage} la experiencia <b>${param.nombre}</b>?`, appName)
                    .then(function (optionSelected) {

                        if (optionSelected.value) {

                            showPreloader();
                            axios.delete(`${appApiUrl}/experiencia/${param.id}`)
                                .then(function (response) {
                                    hidePreloader();
                                    let result = response.data;

                                    if (result.status) {
                                        successMessage(result.message, appName);
                                        vm.listarExperiencia();
                                    }  else if (result.warning){
                                        warningMessage(result.message, appName);
                                        vm.listarExperiencia();
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
            limpiarFiltrosExperiencia(){
                this.experiencia.nombre = '';
                this.buscarExperiencia();
            },
        },
        mounted() {
            this.listarExperiencia();
        },
        components: {
            MainContent,
            PaginationLinks,
            RowActions,
        }
    }

</script>

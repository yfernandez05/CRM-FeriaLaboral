<template>
    <main-content>
        <template v-slot:card-header-title>
            Ciclos
        </template>
        <template v-slot:card-header-actions>
            <button class="btn btn-sm btn-info waves-effect waves-light" @click="buscarCiclos()">
                <i class="fas fa-search"></i>
                <span class="d-none d-sm-inline-block">
                    Buscar
                </span>
            </button>
            <button class="btn btn-sm btn-danger waves-effect waves-light">
                <i class="fas fa-times"></i>
                <span class="d-none d-sm-inline-block" @click="limpiarFiltrosCiclos()">
                    Limpiar
                </span>
            </button>
            <router-link :to="{name:'spa.ciclo.registrar'}" class="btn btn-sm btn-success waves-effect waves-light">
                 <i class="fas fa-plus"></i>
                <span class="d-none d-sm-inline-block ">
                    Nuevo
                </span>
            </router-link>    
        </template>
        <template v-slot:card-body-main>
            <div class="form-row">
                <div class="form-group col-12 col-sm-6 col-md-4 ">
                    <label>Ciclo</label>
                    <input type="text" class="form-control" v-model="ciclo.nombre" @keyup.enter="buscarCiclos()">
                </div>
                
                <div class="form-group col-12 col-sm-6 col-md-4 ">
                    <label>&nbsp;</label>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="estado" 
                            v-model="ciclo.estado" @change="buscarCiclos()">
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
                            <th class="p-2">Ciclo</th>
                            <th class="p-2">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="ci in ciclos" :key="ci.id">
                            <td>
                                <row-actions :rowData="ci" @rowItemActions="rowItemActions" :activeDelete="false">
                                    <button type="button" :title="ci.isactive ? 'Desactivar':'Activar'" @click="cambiarEstado(ci)"
                                            class="btn btn-sm  waves-effect waves-light border-0 mr-1"
                                            :class="ci.isactive ? 'btn-outline-danger':'btn-outline-success'">
                                        <i class="fas fa-lg" :class="ci.isactive ? 'fa-trash':'fa-check-circle'"></i>
                                    </button>
                                </row-actions>
                            </td>
                            <td v-text="ci.id"></td>
                            <td v-text="ci.nombre"></td>
                            <td >
                                <span class="badge badge-pill py-1 px-3" 
                                    :class="ci.isactive ? 'badge-success':'badge-danger'"
                                     v-text="ci.statename">
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
                ciclos: [],
                pagination: {},
                filters: {},
                ciclo: {
                    nombre: '',
                }
            }
        },
        
        methods: {
            listarCiclos() {
                showPreloader();

                let vm = this;
                axios.get(`${appApiUrl}/ciclo`, {
                        params: this.filters
                    })
                    .then(function (response) {

                        hidePreloader();
                        vm.ciclos = response.data.data;
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
                this.listarCiclos();
            },
            rowItemActions(event) {
                console.log(event);
                switch (event.action) {
                    case 'edit':
                        if(!event.data.isactive) {
                            warningMessage(appCannotDeleteMessage, appName);
                            break;
                        }
                        this.$router.push({ name: 'spa.ciclo.editar', params: { id: event.data.id } }) 
                    break;
                    case 'delete':
                        this.eliminarCiclos(event.data);
                    break;
                }
            },
            buscarCiclos() {
                this.filters = {};
                this.filters.page = 1;

                if (this.ciclo.nombre.length)
                    this.filters.nombre = this.ciclo.nombre;

                if (this.ciclo.estado)
                    this.filters.estado = this.ciclo.estado;

                this.listarCiclos();  
            },
            cambiarEstado(param) {
                let vm = this;
                
                let optionMessage ='Eliminar';

                if(!param.isactive) optionMessage = 'Activar';


                swalAlertConfirm(`¿Seguro que quiere ${optionMessage} el ciclo <b>${param.nombre}</b>?`, appName)
                    .then(function (optionSelected) {

                        if (optionSelected.value) {

                            showPreloader();
                            axios.delete(`${appApiUrl}/ciclo/${param.id}`)
                                .then(function (response) {
                                    hidePreloader();
                                    let result = response.data;

                                    if (result.status) {
                                        successMessage(result.message, appName);
                                        vm.listarCiclos();
                                    }  else if (result.warning){
                                        warningMessage(result.message, appName);
                                        vm.listarCiclos();
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
            limpiarFiltrosCiclos(){
                this.ciclo.nombre = '';
                this.buscarCiclos();
            },
        },
        mounted() {
            this.listarCiclos();
        },
        components: {
            MainContent,
            PaginationLinks,
            RowActions,
        }
    }

</script>

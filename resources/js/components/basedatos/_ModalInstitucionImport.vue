<template>
    <modal :showModal="showModal" @closeModal="closeModal">
        <template v-slot:modal-header-title>
            Importar Instituciones desde Excel
        </template>
        <template v-slot:modal-body-main>
            <div class="form-row">
                <div class="form-group col-12">
                    <label class="mb-1">Asignar Asesor</label>
                    <select2 :options="users" v-model="user.iduser"
                        :selectValue="users.iduser" placeholder="Seleccione un Asesor"
                        keyProperty="id" textProperty="name" id="idcuenta">
                    </select2>
                </div>
                <div class="form-group col-12">
                    <label>Archivo Excel</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" ref="fileexcel" @change="handleFileUpload"
                                accept=".XLSX, .CSV" id="fileexcel">
                            <label class="custom-file-label" for="fileexcel" v-text="fileName">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-success" type="button"
                            @click="importarExcel()">
                                <i class="fa fa-save"></i>
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </modal>
</template>
<script>
    import Modal from './../../utils/Modal';
    import Select2 from './../../utils/Select2';

    export default {
        data() {
            return {
                showModal: false,
                fileName: '',
                user:{
                    iduser:0,
                },
                users:[],
            }
        },
        methods: {
            listarUser() {
                let vm = this;
                axios.get(`${appApiUrl}/user/userasesor`)
                    .then(function (response) {

                        hidePreloader();
                        vm.users = response.data;

                    })
                    .catch(function (error) {
                        hidePreloader();
                        console.log(error);
                    });
            },

            closeModal(event) {
                this.showModal = false;
                this.fileName = '';
            },
            openModal() {
                this.showModal = true;
                this.fileName = '';
            },
            handleFileUpload(event) {
                if (event.target.files[0]) {
                    this.fileName = event.target.files[0].name;
                }else
                    this.fileName = '';
            },
            importarExcel() {
                let vm = this;

                if (this.$refs.fileexcel.files[0]) {
                    if(!this.user.iduser){
                        warningMessage('Seleccione una Asesor', appName);
                    }else{
                        let formData = new FormData();
                        formData.append('file', this.$refs.fileexcel.files[0]);
                        formData.append('iduser', this.user.iduser);

                        axios.post(`${appApiUrl}/import/saveInstitucion`, formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                        .then(function (response) {
                            hidePreloader();
                            let result = response.data;

                            if (result.status) {
                                successMessage(result.message, appName);
                                vm.showModal = false;
                                vm.fileName = '';
                                vm.$parent.listarImportaciones(); 
                            } else
                                errorMessage(result.message, appName);
                        })
                        .catch(function (error) {
                            hidePreloader();
                            errorMessage(appErrorMessage, appName);
                            console.log(error);
                        })
                    }  
                                      
                } else
                    warningMessage('Seleccione un archivo Excel', appName);

            },
        },
        mounted() {
            this.listarUser();
        },
        components: {
            Modal,
            Select2
        }
    }

</script>

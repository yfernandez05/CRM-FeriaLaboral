<script>
//importamos libreria
import {Pie} from "vue-chartjs";


export default {
  extends: Pie,
    data(){
        return{
            pieNombre: [],
            pieDatos: [],
            bgColors: [
                'rgba(43, 181, 200, 0.8)',              
                'rgba(234, 236, 203, 0.8)',
                'rgba(227, 184, 185, 0.8)',
                'rgba(177, 196, 209, 0.8)',
                'rgba(177, 227, 181, 0.8)',
                'rgba(206, 232, 234, 0.8)',
                'rgba(206, 175, 131, 0.8)',
                'rgba(80, 223, 201, 0.8)',
                'rgba(172, 146, 204, 0.8)',
                'rgba(32, 219, 216, 0.8)',
                ],
            bgBorder: [
                'rgba(43, 181, 200, 1)',              
                'rgba(234, 236, 203, 1)',
                'rgba(227, 184, 185, 1)',
                'rgba(177, 196, 209, 1)',
                'rgba(177, 227, 181, 1)',
                'rgba(206, 232, 234, 1)',
                'rgba(206, 175, 131, 1)',
                'rgba(80, 223, 201, 1)',
                'rgba(172, 146, 204, 1)',
                'rgba(32, 219, 216, 1)',
            ]   
        }
    },

    mounted(){      
        this.cantidadclientesevento()      
    },

    //metodos
    methods:{
        cantidadclientesevento(){
            let vm = this;
            axios.get(`${appApiUrl}/reporte/cantidadclientesevento`)
            .then(function (response){
                let result = response.data; //
                result.forEach(element => {
                    vm.pieDatos.push(element.total);              
                    vm.pieNombre.push(element.nombreevento);   
                    vm.mostrar();             
                 });
            })
            .catch(function (error){
                console.log(error);
            })
        },

        mostrar(){
            this.renderChart({
                labels: this.pieNombre ,
                datasets:[
                    {
                        label: 'GRAFICOS',
                        backgroundColor: this.bgColors,
                        borderColor: this.bgBorder,
                        borderWidth: 2,
                        //data: [21,20,19,18,17,16,12,10,9,2,1]
                        data:  this.pieDatos,
                    }
                ],
            }, {responsive: true, maintainAspectRatio: false }) //para que sea responsivo
        },

    },

}
</script>

<style scoped>
 #pie-chart{
     height:300px !important; 
     display: block !important;
 }
</style>
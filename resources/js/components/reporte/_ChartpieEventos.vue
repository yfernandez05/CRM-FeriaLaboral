<script>
//importamos libreria
import {Pie} from "vue-chartjs";


export default {
  extends: Pie,

    props:{
        datos:[],
        titulo:[],
    },

    data(){
        return{
            pieNombre: [],
            pieDatos: [],
            bgColors: [
                'rgba(0, 183, 189, 0.90)',              
                'rgba(29, 66, 138, 0.90)',
                'rgba(255, 215, 86, 0.90)',
                'rgba(238, 75, 34, 0.90)',
                'rgba(0, 0, 0, 0.90)',
                'rgba(0, 177, 220, 0.90)',
                'rgba(255, 255, 255, 0.90)',
                'rgba(14, 39, 73, 0.90)',
                'rgba(58, 98, 174, 0.90)',
                'rgba(115, 166, 253, 0.90)',
                'rgba(192, 245, 249, 0.90)',
                'rgba(45, 41, 71, 0.90)',
                'rgba(43, 107, 200, 0.90)',
                'rgba(151, 62, 65, 0.90)',
                'rgba(255, 154, 66, 0.90)',
                'rgba(26, 124, 136, 0.90)',
                'rgba(98, 90, 155, 0.90)',
                'rgba(143, 136, 65, 0.90)',
                ],
            bgBorder: [
                'rgba(0, 183, 189, 1)',              
                'rgba(29, 66, 138, 1)',
                'rgba(255, 215, 86, 1)',
                'rgba(238, 75, 34, 1)',
                'rgba(0, 0, 0, 1)',
                'rgba(0, 177, 220, 1)',
                'rgba(221, 221, 221, 1)',
                'rgba(14, 39, 73, 1)',
                'rgba(58, 98, 174, 1)',
                'rgba(115, 166, 253, 1)',
                'rgba(192, 245, 249, 1)',
                'rgba(45, 41, 71, 1)',
                'rgba(43, 107, 200, 1)',
                'rgba(151, 62, 65, 1)',
                'rgba(255, 154, 66, 1)',
                'rgba(26, 124, 136, 1)',
                'rgba(98, 90, 155, 1)',
                'rgba(143, 136, 65, 1)',
            ]   
        }
    },

    mounted(){      
        //this.cantidadclientesevento()      
    },

    //metodos
    methods:{
        /* cantidadclientesevento(){
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
        }, */

        mostrar(){
            this.renderChart({
                labels: this.titulo ,
                datasets:[
                    {
                        label: 'GRAFICOS',
                        backgroundColor: this.bgColors,
                        borderColor: this.bgBorder,
                        borderWidth: 2,
                        //data: [21,20,19,18,17,16,12,10,9,2,1]
                        data:  this.datos,
                    }
                ],
            }, {responsive: true, maintainAspectRatio: false ,plugins: {
                    labels: {                    
                    fontColor: ["white","white","white","white","white","white","black","white","white","white","black","white","white"]
                    } 
                } }) //para que sea responsivo
        },

    },

}
</script>

<style scoped>
 #pie-chart{
     height:465px !important;
     display: block !important;
 }
</style>
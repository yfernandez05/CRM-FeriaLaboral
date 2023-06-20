<script>
//importamos librerias 
import {Pie} from "vue-chartjs";
import labels from "chartjs-plugin-labels"; //importamos lo labels para el chart

export default {
    extends: Pie,
    
    props:{
        datos:[],
        titulo:[],
    },

    data(){
        return{
            //pieNombre: [],
            //pieDatos: [],
            bgColors: [
                'rgba(0, 183, 189, 0.90)',              
                'rgba(29, 66, 138, 0.90)',
                'rgba(255, 215, 86, 0.90)',
                'rgba(238, 75, 34, 0.90)',
                'rgba(0, 0, 0, 0.90)',
                'rgba(0, 177, 220, 0.90)',
                'rgba(255, 255, 255, 0.90)',
                'rgba(80, 223, 201, 0.8)',
                'rgba(172, 146, 204, 0.8)',
                'rgba(32, 219, 216, 0.8)',
                'rgba(45, 41, 71, 0.90)',
                'rgba(43, 107, 200, 0.90)',
                'rgba(151, 62, 65, 0.90)',
                'rgba(255, 154, 66, 0.90)',
                'rgba(26, 124, 136, 0.90)',
                'rgba(98, 90, 155, 0.90)',
                'rgba(143, 136, 65, 0.90)',          
                ],
            bgBorder:[
                'rgba(0, 183, 189, 1)',              
                'rgba(29, 66, 138, 1)',
                'rgba(255, 215, 86, 1)',
                'rgba(238, 75, 34, 1)',
                'rgba(0, 0, 0, 1)',
                'rgba(0, 177, 220, 1)',
                'rgba(221, 221, 221, 1)',
                'rgba(80, 223, 201, 1)',
                'rgba(172, 146, 204, 1)',
                'rgba(32, 219, 216, 1)',   
                'rgba(45, 41, 71, 1)',
                'rgba(43, 107, 200, 1)',
                'rgba(151, 62, 65, 1)',
                'rgba(255, 154, 66, 1)',
                'rgba(26, 124, 136, 1)',
                'rgba(98, 90, 155, 1)',
                'rgba(143, 136, 65, 1)',        
            ],
            options: {
                responsive: true,
                maintainAspectRatio: false,  
                events: ["click", "mousemove"],
                plugins: {
                    labels: {
                    render: 'percentage' , //'label' 'percentage' precision: 2
                    fontColor: ["white","white","white","white","white","white","black"]
                    } 
                }       
            },
        }
    },

    mounted(){      
        this.colegios();
        
    },

    //metodos
    methods:{
        colegios(){
            let vm = this;
            /* axios.get(`${appApiUrl}/reporte/asistenciasevento`)
            .then(function (response){
                let result = response.data; //
                    result.forEach(element => {
                    vm.pieDatos.push(element.total);              
                    vm.pieNombre.push(element.asistencianame);   
                    vm.mostrar();             
                });
            })
            .catch(function (error){
                console.log(error);
            }) */
            
        },  

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
            ]},this.options)       //para que sea responsivo
        },

    }
}
</script>

<style scoped>
 #pie-chart{
     height:237px !important;
     display: block !important;
 }
</style>
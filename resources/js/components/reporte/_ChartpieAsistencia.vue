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
                ],
            bgBorder:[
                'rgba(0, 183, 189, 1)',              
                'rgba(29, 66, 138, 1)',             
            ],
            options: {
                responsive: true,
                maintainAspectRatio: false,  
                events: ["click", "mousemove"],
                plugins: {
                    labels: {
                    render: 'percentage' , //'label' 'percentage' precision: 2
                    fontColor: ["white", "white"]
                    } 
                }       
            },
        }
    },

    mounted(){      
        this.asistencia();
        
    },

    //metodos
    methods:{
        asistencia(){
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
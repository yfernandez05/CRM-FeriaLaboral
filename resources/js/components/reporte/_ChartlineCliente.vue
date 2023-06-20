<script>
//importamos librerias
import { Line } from 'vue-chartjs';

export default {
    extends: Line,

    props:{
       /* chartId:{ //para agregar un id espesifico a grafici
        type: String,
        default: "idGrafico",
      },  */ 
      datos:[],
      titulo:[],
    },

    data() {
        return {
            /* titulo: [],
            datos: [], */
            bgColors: [
                'rgba(45, 82, 199, 0.8)',              
                'rgba(243, 243, 243, 0.8)',
            ],
            bgBorder:[
                'rgba(45, 82, 199, 1)',              
                'rgba(243, 243, 243, 1)',
            ],
            options: {
                scales: {
                    yAxes: [{
                        type: 'linear',
                        ticks: {
                            min: 0,
                            //stepSize: 50
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Cantidad'
                        }
                    }],
                    xAxes: [{
                        scaleLabel: {
                        display: true,
                        labelString: 'Fechas'
                        }
                    }],
                },
                responsive: true,
                maintainAspectRatio: false,  
                events: ["click", "mousemove"],
                plugins: {
                    labels: {
                        render: 'value' , //'label' 'percentage' precision: 2
                        fontColor: ["white", "black"]
                    } 
                },      
            },
        }   
    },

    //metodos
    methods:{
        mostrar(){
            this.renderChart({
                labels: this.titulo ,
                datasets:[
                {
                    label: 'Registros',
                    backgroundColor: 'transparent',
                    borderColor: this.bgBorder,
                    borderWidth: 2,
                    lineTension: 0,
                    fill: true,
                    borderDash: [5, 5],
                    pointBorderColor: 'rgba(0, 183, 189, 1)',
                    pointBackgroundColor: 'rgba(0, 183, 189, 0.80)',
                    pointRadius: 5,
                    pointHoverRadius: 10,
                    pointHitRadius: 30,
                    pointBorderWidth: 2,
                    pointStyle: 'rectRounded',
                    spanGaps: true,
                    //data: [1,20,19,18,17,16,12,10,9,2,1]
                            data:  this.datos,
                }],
            },this.options)       //para que sea responsivo
        },
    },
}
</script>

<style scoped>
  #line-chart{
    height: 500px !important;
    width: 100% !important;
  }
</style>
<!--
<style>
.main-wrapper{
    width: 90%;
    margin-left: auto;
    margin-right: auto;
}
</style>
<template>
    <div class="main-wrapper">
        <div>
            <div v-if="chartData != null && chartData.length > 1">
                <GChart
                    type="ColumnChart"
                    :data="chartData"
                    :options="chartOptions"
                />
            </div>
            <div v-else="chartData.length === 0">
                empty
            </div>
        </div>
        <div>
            <div>
                <v-app>
                    <v-row>
                        <v-col
                            cols="12"
                            sm="6"
                            md="4"
                        >
                            <v-menu
                                v-model="menuFrom"
                                :close-on-content-click="false"
                                :nudge-right="40"
                                transition="scale-transition"
                                offset-y
                                min-width="auto"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        v-model="fromDate"
                                        label="From"
                                        prepend-icon="mdi-calendar"
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-date-picker
                                    v-model="fromDate"
                                    @input="menuFrom = false"
                                ></v-date-picker>
                            </v-menu>
                        </v-col>
                        <v-col
                            cols="12"
                            sm="6"
                            md="4"
                        >
                            <v-menu
                                v-model="menuTo"
                                :close-on-content-click="false"
                                :nudge-right="40"
                                transition="scale-transition"
                                offset-y
                                min-width="auto"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        v-model="toDate"
                                        label="To"
                                        prepend-icon="mdi-calendar"
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-date-picker
                                    v-model="toDate"
                                    @input="menuTo = false"
                                ></v-date-picker>
                            </v-menu>
                        </v-col>
                    </v-row>
                </v-app>
            </div>
        </div>

    </div>
</template>

<script>
import { GChart } from "vue-google-charts";
export default {
    name: "App",
    components: {
        GChart
    },
    data() {
        return {
            // Array will be automatically processed with visualization.arrayToDataTable function
            chartData: null,
            chartOptions: {
                chart: {
                    title: "Company Performance",
                }
            },
            activePickerFrom: null,
            activePickerTo: null,
            fromDate: null,
            menuFrom: false,
            toDate: null,
            menuTo: false,
        };
    },
    watch: {
        menuFrom (val) {
            val && setTimeout(() => (this.activePickerFrom = 'YEAR'))
        },
        menuTo (val) {
            val && setTimeout(() => (this.activePickerTo = 'YEAR'))
        },
    },
    methods:{
        async get(start, end){
            axios.get('/api/sales/dayTotals?start='+start+"&end="+end,
                    )
                .then(response => {
                    var sales = response.data.sales;
                    console.log(response.data);
                    this.chartData = [];
                    this.chartData.push(['Date', 'Sales']);
                    for(var i=0;i<sales.length;i++){
                        var tempArr = [sales[i].date, Number(sales[i].total)];
                        console.log(tempArr);
                        this.chartData.push(tempArr);
                    }
                })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                });
        },

        async getLastMonth(start, end){
            axios.get('/api/sales/lastMonthDayTotals',
            )
                .then(response => {
                    var sales = response.data.sales;
                    console.log(response.data);
                    this.chartData = [];
                    this.chartData.push(['Date', 'Sales']);
                    for(var i=0;i<sales.length;i++){
                        var tempArr = [sales[i].date, Number(sales[i].total)];
                        console.log(tempArr);
                        this.chartData.push(tempArr);
                    }
                })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                });
        },

        saveFrom (date) {
            this.$refs.menuFrom.save(date)
        },

        saveTo (date) {
            this.$refs.menuTo.save(date)
        },
    },
    created() {
        /*var now = new Date();
        var prevMonthLastDate = new Date(now.getFullYear(), now.getMonth(), 0);
        var prevMonthFirstDate = new Date(now.getFullYear() - (now.getMonth() > 0 ? 0 : 1), (now.getMonth() - 1 + 12) % 12, 1);

        var formatDateComponent = function(dateComponent) {
            return (dateComponent < 10 ? '0' : '') + dateComponent;
        };

        var formatDate = function(date) {
            return formatDateComponent(date.getMonth() + 1) + '/' + formatDateComponent(date.getDate()) + '/' + date.getFullYear();
        };

        this.get(formatDate(prevMonthFirstDate), formatDate(prevMonthLastDate));*/
        this.getLastMonth();
    }
};
</script>
-->

<template>
    <div id="container">
        <div id="sideMenu">
            <h1>Accent Group Sales</h1>

            <ul class="menu">
                <li>Dashboard</li>
            </ul>

            <ul class="menu">
                <li>DataGrid</li>
            </ul>

            <ul class="menu">
                <li>Account</li>
                <li v-if="user != null">{{user.name}}</li>
                <li><a href="/logout">Logout</a></li>
            </ul>
        </div>
        <div id="content">
            <div id="titleBar">
                <h2>Dashboard</h2>
                <span class="controls activeControl">Weekly</span>
                <span class="controls">Monthly</span>
            </div>

            <div v-if="salesData.labels.length == 0">
                <v-sheet
                         :color="`grey ${theme.isDark ? 'darken-2' : 'lighten-4'}`"
                         class="pa-3"
                >
                    <v-skeleton-loader
                        class="mx-auto"
                        max-width="300"
                        type="card"
                    ></v-skeleton-loader>
                </v-sheet>
            </div>
            <div class="mainChart">
                <canvas id="salesData" style="visibility: hidden;"></canvas>
                <h2>Total Sales</h2>
                <h3>${{totalSales}}</h3>

                <div class="clearFix"></div>
            </div>
        </div>
    </div>
</template>

<script>
import { GChart } from "vue-google-charts";
export default {
    name: "App",
    components: {
        GChart
    },
    data() {
        return {
            // Array will be automatically processed with visualization.arrayToDataTable function
            chartData: null,
            chartOptions: {
                chart: {
                    title: "Company Performance",
                }
            },
            activePickerFrom: null,
            activePickerTo: null,
            fromDate: null,
            menuFrom: false,
            toDate: null,
            menuTo: false,
            user: null,
            salesData : {
                labels: [/*"Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"*/],
                datasets: [
                    {
                        label: "Front",
                        fillColor: "rgba(195, 40, 96, 0.1)",
                        strokeColor: "rgba(195, 40, 96, 1)",
                        pointColor: "rgba(195, 40, 96, 1)",
                        pointStrokeColor: "rgba(195, 40, 96, 1)",
                        pointHighlightStroke: "rgba(225,225,225,0.9)",
                        data: [/*3400, 3000, 2500, 4500, 2500, 3400, 3000*/]
                    }
                ]
            },
            totalSales: 0
        };
    },
    inject: {
        theme: {
            default: { isDark: false },
        },
    },
    watch: {
        menuFrom (val) {
            val && setTimeout(() => (this.activePickerFrom = 'YEAR'))
        },
        menuTo (val) {
            val && setTimeout(() => (this.activePickerTo = 'YEAR'))
        },
    },
    methods:{
        async getUser(){
            axios.get('/api/user')
                 .then(response=>{
                     this.user = response.data.user;
                 }).catch(error => {
                    console.log(error)
                    this.user = null;
                });;
        },
        async get(start, end){
            axios.get('/api/sales/dayTotals?start='+start+"&end="+end,
            )
                .then(response => {
                    var sales = response.data.sales;
                    console.log(response.data);
                    this.chartData = [];
                    this.chartData.push(['Date', 'Sales']);
                    this.salesData.labels = [];
                    this.salesData.datasets[0].data = [];
                    for(var i=0;i<sales.length;i++){
                        this.salesData.labels.push(sales[i].date);
                        this.salesData.datasets[0].data.push(Number(sales[i].total));
                        /*var tempArr = [sales[i].date, Number(sales[i].total)];
                        console.log(tempArr);
                        this.chartData.push(tempArr);*/
                    }
                    console.log(this.salesData);
                })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                });
        },

        async getLastMonth(start, end){
            axios.get('/api/sales/lastMonthDayTotals',
            )
                .then(response => {
                    var sales = response.data.sales;
                    console.log(response.data);
                    this.salesData.labels = [];
                    this.salesData.datasets[0].data = [];
                    this.totalSales = 0;
                    for(var i=0;i<sales.length;i++){
                        this.salesData.labels.push(sales[i].date);
                        this.salesData.datasets[0].data.push(Number(sales[i].total));
                        this.totalSales += Number(sales[i].total);
                    }

                    document.getElementById('salesData').style.visibility = "visible";
                    console.log(this.salesData.datasets[0].data);
                    var ctx = document.getElementById("salesData").getContext("2d");
                    var ceilNum = this.ceilNumber(Math.max.apply(Math, this.salesData.datasets[0].data) / 10) ;
                    window.myLineChart = new Chart(ctx).Line(this.salesData, {
                        pointDotRadius : 6,
                        pointDotStrokeWidth : 2,
                        datasetStrokeWidth : 3,
                        scaleShowVerticalLines: false,
                        scaleGridLineWidth : 2,
                        scaleShowGridLines : true,
                        scaleGridLineColor : "rgba(225, 255, 255, 0.02)",
                        scaleOverride: true,
                        scaleSteps: 10,
                        scaleStepWidth: Math.ceil(ceilNum),
                        scaleStartValue: 0,

                        responsive: true

                    });
                })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                });
        },

        ceilNumber(number){
            let bite = 0;
            if(number < 10){
                return 10;
            }
            while( number >= 10 ){
                number /= 10;
                bite += 1;
            }
            return Math.ceil(number) * Math.pow(10,bite);
        },

        saveFrom (date) {
            this.$refs.menuFrom.save(date)
        },

        saveTo (date) {
            this.$refs.menuTo.save(date)
        },
    },
    created() {
        /*var now = new Date();
        var prevMonthLastDate = new Date(now.getFullYear(), now.getMonth(), 0);
        var prevMonthFirstDate = new Date(now.getFullYear() - (now.getMonth() > 0 ? 0 : 1), (now.getMonth() - 1 + 12) % 12, 1);

        var formatDateComponent = function(dateComponent) {
            return (dateComponent < 10 ? '0' : '') + dateComponent;
        };

        var formatDate = function(date) {
            return formatDateComponent(date.getMonth() + 1) + '/' + formatDateComponent(date.getDate()) + '/' + date.getFullYear();
        };

        this.get(formatDate(prevMonthFirstDate), formatDate(prevMonthLastDate));*/
        this.getLastMonth();
    }
};
</script>

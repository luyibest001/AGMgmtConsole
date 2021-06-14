<template>
    <div id="container">
        <div id="sideMenu">
            <h1>Accent Group Sales</h1>

            <ul class="menu">
                <li><button :class="currentTab === 'dashboard' ? 'menu-button activeButton' : 'menu-button'" @click="currentTab='dashboard'">Dashboard</button></li>
            </ul>

            <ul class="menu">
                <li><button :class="currentTab === 'datagrid' ? 'menu-button activeButton' : 'menu-button'" @click="currentTab='datagrid'">DataGrid</button></li>
            </ul>

            <ul class="menu">
                <li>Account</li>
                <li v-if="user != null">{{user.name}}</li>
                <li><a href="/logout">Logout</a></li>
            </ul>
        </div>
        <div class="content" v-if="currentTab === 'dashboard'">
            <div class="titleBar">
                <h2 style="float: unset!important; margin-bottom: 20px;">Dashboard</h2>
                <div class="row">
                    <div class="large-6 columns">
                        <label for="start">Start Date</label>
                        <input id="start" type="date" /><br />
                    </div>
                    <div class="large-6 columns">
                        <label for="end">End Date</label>
                        <input id="end" type="date" /><br />
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 columns">
                        <button class="button radius" type="button" id="filter" @click="onDateFilterClicked">Filter</button>
                    </div>
                </div>
            </div>

            <div v-if="salesData.labels.length === 0">
                <v-sheet
                         :color="`grey ${theme.isDark ? 'darken-2' : 'lighten-4'}`"
                         class="pa-3"
                >
                    <v-skeleton-loader
                        class="mx-auto"
                        max-width="600"
                        type="card"
                    ></v-skeleton-loader>
                </v-sheet>
            </div>
            <div class="dashboard-box" v-else>
                <p>${{totalSales}}</p>
                <hr style="margin: 0!important;">
                <h2>Total Sales</h2><br/>
            </div>
            <div class="mainChart">
                <canvas id="salesData"></canvas>

                <div class="clearFix"></div>
            </div>
            <v-app>
                <v-container v-if="this.dashboardSalesList == null">
                    <v-row>
                        <v-col
                            cols="12"
                            md="12"
                        >
                            <v-skeleton-loader
                                v-bind="attrs"
                                type="list-item-three-line"
                            ></v-skeleton-loader>
                            <v-skeleton-loader
                                v-bind="attrs"
                                type="list-item-three-line"
                            ></v-skeleton-loader>
                            <v-skeleton-loader
                                v-bind="attrs"
                                type="list-item-three-line"
                            ></v-skeleton-loader>
                        </v-col>
                    </v-row>
                </v-container>
                <v-data-table v-else
                              :headers="headers"
                              :items="dashboardSalesList"
                              :items-per-page="10"
                              class="elevation-1"
                ></v-data-table>
            </v-app>
        </div>

        <div class="content" v-else>
            <div style="margin-bottom: 30px;">
                <h2 style="float: unset!important; margin-bottom: 20px;">DataGrid</h2><br/>
                <div class="row">
                    <div class="large-4 columns">
                        <label for="start">Select Product</label>
                        <select v-model="selectedProduct" style="border: 1px solid #ccc!important; border-radius: 5px;">
                            <option selected value="">Select Product</option>
                            <option v-for="product in products" :value="product.id">{{product.name}}</option>
                        </select>
                    </div>
                    <div class="large-4 columns">
                        <label for="end">Select Customer</label>
                        <select v-model="selectedCustomer" style="border: 1px solid #ccc!important; border-radius: 5px;">
                            <option selected value="">Select Customer</option>
                            <option v-for="customer in customers" :value="customer.id">{{customer.full_name}}</option>
                        </select>
                    </div>
                    <div class="large-4 columns">
                        <label for="end">Employee</label>
                        <select v-model="selectedEmployee" style="border: 1px solid #ccc!important; border-radius: 5px;">
                            <option selected value="">Select Employee</option>
                            <option v-for="employee in employees" :value="employee.id">{{employee.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 columns">
                        <button class="button radius" id="filter2" @click="onDataGridFilterClicked">Filter</button>
<!--                        <button id="clearFilter2" class="button radius secondary">Clear Filter</button>-->
                    </div>
                </div>
            </div>
            <div class="text-center">
                <v-app>
                    <v-container v-if="this.salesList == null">
                        <v-row>
                            <v-col
                                cols="12"
                                md="12"
                            >
                                <v-skeleton-loader
                                    v-bind="attrs"
                                    type="list-item-three-line"
                                ></v-skeleton-loader>
                                <v-skeleton-loader
                                    v-bind="attrs"
                                    type="list-item-three-line"
                                ></v-skeleton-loader>
                                <v-skeleton-loader
                                    v-bind="attrs"
                                    type="list-item-three-line"
                                ></v-skeleton-loader>
                            </v-col>
                        </v-row>
                    </v-container>
                    <v-data-table v-else
                        :headers="headers"
                        :items="salesList"
                        :items-per-page="10"
                        class="elevation-1"
                    ></v-data-table>
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
            attrs: {
                class: 'mb-6',
                boilerplate: true,
                elevation: 2,
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
            totalSales: 0,
            currentTab: 'dashboard',
            headers: [
                {
                    text: 'Invoice ID',
                    align: 'start',
                    sortable: false,
                    value: 'invoice_id',
                },
                { text: 'Date', value: 'date' },
                { text: 'Product Name', value: 'product_name' },
                { text: 'Price($)', value: 'product_price' },
                { text: 'Employee', value: 'sales_person_name' },
                { text: 'Customer', value: 'customer_name' }
            ],
            salesList: null,
            dashboardSalesList: [],
            products: [],
            customers: [],
            employees: [],
            selectedCustomer: null,
            selectedProduct: null,
            selectedEmployee: null,
            isUpdating: false,
        };
    },
    inject: {
        theme: {
            default: { isDark: false },
        },
    },
    watch: {
        isUpdating (val) {
            if (val) {
                setTimeout(() => (this.isUpdating = false), 3000)
            }
        },
        menuFrom (val) {
            val && setTimeout(() => (this.activePickerFrom = 'YEAR'))
        },
        menuTo (val) {
            val && setTimeout(() => (this.activePickerTo = 'YEAR'))
        },
        currentTab (val){
            if(val === "dashboard"){
                this.clearSalesData();
                this.getSalesByDate();
            }else{
                this.getAllSales();
            }
        }
    },
    methods:{
        onDateFilterClicked(){
            var startDate = $('#start').val(),
                endDate = $('#end').val();
            $("canvas#salesData").remove();
            $("div.mainChart").append('<canvas id="salesData" class="animated fadeIn"></canvas>');
            this.clearSalesData();
            this.getSalesByDate(startDate, endDate);
        },

        onDataGridFilterClicked(){
            var url = "/api/sales?";
            this.salesList = null;
            if(this.selectedCustomer != null){
                url += 'customer='+this.selectedCustomer + "&";
            }

            if(this.selectedProduct != null){
                url += 'product='+this.selectedProduct + "&";
            }

            if(this.selectedEmployee != null){
                url += 'employee='+this.selectedEmployee;
            }

            url = url.replace(/&\s*$/, "");
            console.log(url);
            axios.get(url)
                .then(response=>{

                    var sales = response.data.sales;
                    console.log(sales);
                    this.salesList = [];
                    for(var i=0;i<sales.length;i++){
                        var sale = {
                            invoice_id: sales[i].invoiceId,
                            date: sales[i].date,
                            product_name: sales[i].product_name,
                            product_price: sales[i].price,
                            sales_person_name: sales[i].sales_person_name,
                            customer_name: sales[i].customer_name
                        };
                        this.salesList.push(sale);
                    }
                }).catch(error => {
                console.log(error)
            });
        },

        clearDateFilter(){
            e.preventDefault();
        },

        removeCustomer (item) {
            const index = this.customers.indexOf(item.name)
            if (index >= 0) this.customers.splice(index, 1)
        },
        removeProduct (item) {
            const index = this.products.indexOf(item.name)
            if (index >= 0) this.products.splice(index, 1)
        },
        removeEmployee (item) {
            const index = this.employees.indexOf(item.name)
            if (index >= 0) this.employees.splice(index, 1)
        },
        clearSalesData(){
            this.salesData.labels = [];
            this.salesData.datasets[0].data = [];
            this.totalSales = 0;
        },

        async getProducts(){
            axios.get('/api/products')
                .then(response=>{
                    console.log(response.data.products);
                    this.products = response.data.products;
                }).catch(error => {
                    console.log(error)
                });
        },

        async getEmployees(){
            axios.get('/api/employees')
                .then(response=>{
                    this.employees = response.data.employees;

                }).catch(error => {
                    console.log(error)
                });
        },

        async getCustomers(){
            axios.get('/api/customers')
                .then(response=>{
                    this.customers = response.data.customers;
                }).catch(error => {
                    console.log(error)
                });
        },
        getAllSales(){
          axios.get('/api/sales')
              .then(response=>{
                  var sales = response.data.sales;
                  this.salesList = [];
                  for(var i=0;i<sales.length;i++){
                    var sale = {
                        invoice_id: sales[i].invoiceId,
                        date: sales[i].date,
                        product_name: sales[i].product_name,
                        product_price: sales[i].price,
                        sales_person_name: sales[i].sales_person_name,
                        customer_name: sales[i].customer_name
                    };
                    this.salesList.push(sale);
                  }
              }).catch(error => {
                  console.log(error)
              });
        },

        async getUser(){
            axios.get('/api/user')
                 .then(response=>{
                     this.user = response.data.user;
                 }).catch(error => {
                    console.log(error)
                    this.user = null;
                });
        },
        async getSalesByDate(start, end){
            var url = "/api/sales/dayTotals?";
            if(start !== undefined){
                url += "start="+start+"&";
            }

            if(end !== undefined){
                url += "end="+end;
            }

            url = url.replace(/&\s*$/, "");

            axios.get(url,
            )
                .then(response => {
                    var salesTotal = response.data.salesTotal;
                    var sales = response.data.sales;
                    console.log(salesTotal);
                    this.drawDashboardTable(sales);
                    this.drawSalesChart(salesTotal);
                })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                });
        },

        drawDashboardTable (sales){
            this.dashboardSalesList = [];
            for(var i=0;i<sales.length;i++){
                var sale = {
                    invoice_id: sales[i].invoiceId,
                    date: sales[i].date,
                    product_name: sales[i].product_name,
                    product_price: sales[i].price,
                    sales_person_name: sales[i].sales_person_name,
                    customer_name: sales[i].customer_name
                };
                this.dashboardSalesList.push(sale);
            }
        },

        drawSalesChart (sales){
            this.clearSalesData();
            this.totalSales = 0;
            for(var i=0;i<sales.length;i++){
                this.salesData.labels.push(sales[i].date);
                this.salesData.datasets[0].data.push(Number(sales[i].total));
                this.totalSales += Number(sales[i].total);
            }
            this.totalSales = this.totalSales.toFixed(2);

            console.log(this.salesData.datasets[0].data);
            var ctx = document.getElementById("salesData").getContext("2d");

            var ceilNum = this.ceilNumber(Math.max.apply(Math, this.salesData.datasets[0].data) / 10) ;
            window.myLineChart = new Chart(ctx);
            window.myLineChart.Line(this.salesData, {
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
        this.getSalesByDate();
        this.getCustomers();
        this.getProducts();
        this.getEmployees();
    }
};
</script>

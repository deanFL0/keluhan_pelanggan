<template>
    <div class="dashboard-wrapper">
        <!-- Row 1: Charts -->
        <div class="chart-row">
            <div class="chart-box pie-chart">
                <canvas id="pieChart"></canvas>
            </div>
            <div class="chart-box bar-chart">
                <canvas id="barChart"></canvas>
            </div>
        </div>

        <!-- Row 2: Table -->
        <div class="table-wrapper">
            <div class="table-header">
                <h2 class="table-title">Top 10 Keluhan</h2>
            </div>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Umur Keluhan</th>
                    </tr>
                </thead>
                <tbody v-if="dashboardData && dashboardData.recent_keluhan">
                    <tr
                        v-for="keluhan in dashboardData.recent_keluhan"
                        :key="keluhan.id"
                    >
                        <td>{{ keluhan.nama }}</td>
                        <td>{{ keluhan.email }}</td>
                        <td>{{ keluhan.created_at }}</td>
                        <td>{{ keluhan.age }} hari</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import {
    renderBarChart,
    getDashboardData,
    renderPieChart,
} from "../services/Dashboard";

export default {
    name: "Dashboard",

    data() {
        return {
            dashboardData: null,
            pieChartInstance: null,
            barChartInstance: null,
        };
    },
    mounted() {
        this.fetchDashboardData();
    },
    methods: {
        async fetchDashboardData() {
            try {
                const response = await getDashboardData();
                this.dashboardData = response.data.data;
                console.log(this.dashboardData);
                renderPieChart("pieChart", this.dashboardData.pie_chart);
                renderBarChart("barChart", this.dashboardData.bar_chart);
            } catch (error) {
                console.error("Error fetching dashboard data:", error);
            }
        },
    },
};
</script>

<style>
html,
body {
    margin: 0;
    padding: 0;
    font-family: "Segoe UI", sans-serif;
    background-color: #f4f6f9;
    height: 100%;
    overflow: hidden;
}

#app {
    height: 100vh;
    overflow: hidden;
}

.dashboard-wrapper {
    display: flex;
    flex-direction: column;
    height: 100vh;
    box-sizing: border-box;
    padding: 20px;
    padding-top: 0px;
    gap: 20px;
}

.chart-row {
    display: flex;
    flex: 1;
    gap: 20px;
    max-height: 40%;
}

.chart-box {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    padding: 10px;
    flex-grow: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.pie-chart {
    flex: 1;
}

.bar-chart {
    flex: 2;
}

.table-wrapper {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    overflow-y: auto;
    flex: 1;
    min-height: 0;
}

.table-header {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 15px;
}

.table-title {
    font-size: 20px;
    font-weight: bold;
    color: #333;
}

.styled-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.styled-table th,
.styled-table td {
    padding: 12px 15px;
    text-align: left;
}

.styled-table thead {
    background-color: #007bff;
    color: #fff;
}

.styled-table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

.styled-table tbody tr:hover {
    background-color: #e0f0ff;
}
</style>

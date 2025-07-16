
import { Chart } from "chart.js/auto";

let pieChartInstance = null;
let barChartInstance = null;

export function getDashboardData() {
    return axios.get('/api/dashboard');
}

export function renderPieChart(canvasId, data) {
    const ctx = document.getElementById(canvasId);

    if (pieChartInstance) {
        pieChartInstance.destroy();
    }

    pieChartInstance = new Chart(ctx, {
        type: "pie",
        data: {
            labels: ["Received", "In Process", "Done"],
            datasets: [
                {
                    label: "Status Keluhan",
                    data: [data.received, data.in_process, data.done],
                    backgroundColor: [
                        "rgba(0, 50, 255, 0.8)",
                        "rgba(255, 104, 0, 0.8)",
                        "rgba(150, 148, 147, 0.8)",
                    ],
                    borderWidth: 1,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: "top",
                },
                title: {
                    display: true,
                    text: "Keluhan by Status",
                },
            },
        },
    });
}

export function renderBarChart(canvasId, data) {
    const ctx = document.getElementById(canvasId);
    
    if (barChartInstance) {
        barChartInstance.destroy();
    }

    barChartInstance = new Chart(ctx, {
        type: "bar",
        data: {
            labels: data.labels,
            datasets: [
                {
                    label: "Received",
                    data: data.datasets[0],
                    backgroundColor: "rgba(0, 50, 255, 0.8)",
                    borderWidth: 1,
                },
                {
                    label: "In Process",
                    data: data.datasets[1],
                    backgroundColor: "rgba(255, 104, 0, 0.8)",
                    borderWidth: 1,
                },
                {
                    label: "Done",
                    data: data.datasets[2],
                    backgroundColor: "rgba(150, 148, 147, 0.8)",
                    borderWidth: 1,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: "top",
                },
                title: {
                    display: true,
                    text: "Time Series by Status",
                },
            },
        },
    });
}
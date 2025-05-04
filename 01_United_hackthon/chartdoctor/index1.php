<!DOCTYPE html>
<html>
<head>
    <title>Doctor Dashboard</title>
    <scrip src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Doctor Dashboard</h2>

    <!-- Filter -->
    <label for="doctorFilter">Filter by Doctor:</label>
    <select id="doctorFilter">
        <option value="">All</option>
    </select>

    <canvas id="patientsChart" width="400" height="200"></canvas>
    <canvas id="genderChart" width="400" height="200"></canvas>
    <canvas id="returningChart" width="400" height="200"></canvas>
    <script>
let patientsChart, genderChart, returningChart;

// Redraw chart with new data
function drawChart(ctx, type, labels, data, bgColors) {
    return new Chart(ctx, {
        type: type,
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: bgColors
            }]
        }
    });
}

// Load dropdown options
fetch('patients_per_doctor.php')
.then(res => res.json())
.then(data => {
    const select = document.getElementById("doctorFilter");
    data.forEach(d => {
        const opt = document.createElement("option");
        opt.value = d.doctor;
        opt.textContent = d.doctor;
        select.appendChild(opt);
    });
});

// Chart Loaders
function loadCharts(doctor = '') {
    const suffix = doctor ? `?doctor=${encodeURIComponent(doctor)}` : '';

    // Load patients chart
    fetch('patients_per_doctor.php' + suffix)
    .then(res => res.json())
    .then(data => {
        if (patientsChart) patientsChart.destroy();
        const ctx = document.getElementById('patientsChart');
        patientsChart = drawChart(ctx, 'bar', data.map(d => d.doctor), data.map(d => d.total), ['#36a2eb']);
    });

    // Load gender chart
    fetch('gender_distribution.php' + suffix)
    .then(res => res.json())
    .then(data => {
        if (genderChart) genderChart.destroy();
        const ctx = document.getElementById('genderChart');
        genderChart = drawChart(ctx, 'pie', data.map(d => d.gender), data.map(d => d.total), ['#ff6384', '#36a2eb', '#ffcd56']);
    });

    // Load returning chart
    fetch('new_vs_returning.php' + suffix)
    .then(res => res.json())
    .then(data => {
        if (returningChart) returningChart.destroy();
        const ctx = document.getElementById('returningChart');
        returningChart = drawChart(ctx, 'doughnut', data.map(d => d.type), data.map(d => d.count), ['#4bc0c0', '#9966ff']);
    });
}

// Filter trigger
document.getElementById('doctorFilter').addEventListener('change', function() {
    loadCharts(this.value);
});

window.onload = () => loadCharts(); // initial load




</script>

</body>
</html>
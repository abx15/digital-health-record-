<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Health Dashboard</title>
  <link rel="icon" href="img/HealthSync.png" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    canvas { max-width: 600px; margin: 20px auto; display: block; }
    select { margin: 20px; padding: 5px; }
  </style>
</head>
<body>

  <h2 style="text-align:center;">Health Data Dashboard</h2>
  <select id="doctorFilter">
    <option value="All">All Doctors</option>
  </select>

  <canvas id="barVisits"></canvas>
  <canvas id="genderChart"></canvas>
  <canvas id="costChart"></canvas>
  <canvas id="testCountChart"></canvas>

  <script>
    let rawData = [];

    async function fetchData() {
      const res = await fetch('get_data.php');
      const data = await res.json();
      rawData = data;
      populateDoctorFilter(data);
      renderCharts("All");
    }

    function populateDoctorFilter(data) {
      const select = document.getElementById("doctorFilter");
      const doctors = [...new Set(data.map(d => d.consultant_doctor))];
      doctors.forEach(doc => {
        const opt = document.createElement("option");
        opt.value = doc;
        opt.textContent = doc;
        select.appendChild(opt);
      });

      select.addEventListener("change", () => renderCharts(select.value));
    }

    function renderCharts(doctor) {
      const data = doctor === "All" ? rawData : rawData.filter(d => d.consultant_doctor === doctor);

      // 1. Visits Chart
      const totalDaily = data.reduce((a, b) => a + Number(b.daily_visit), 0);
      const totalWeekly = data.reduce((a, b) => a + Number(b.weekly_visit), 0);
      const totalMonthly = data.reduce((a, b) => a + Number(b.monthly_visit), 0);

      new Chart(document.getElementById("barVisits"), {
        type: "bar",
        data: {
          labels: ["Daily", "Weekly", "Monthly"],
          datasets: [{
            label: "Total Visits",
            data: [totalDaily, totalWeekly, totalMonthly],
            backgroundColor: ["#4e73df", "#1cc88a", "#36b9cc"]
          }]
        }
      });

      // 2. Gender Chart
      const genderCount = { Male: 0, Female: 0 };
      data.forEach(d => {
        const g = d.gender.trim().toLowerCase();
        if (g === "male") genderCount.Male++;
        else if (g === "female") genderCount.Female++;
      });

      new Chart(document.getElementById("genderChart"), {
        type: "doughnut",
        data: {
          labels: ["Male", "Female"],
          datasets: [{
            data: [genderCount.Male, genderCount.Female],
            backgroundColor: ["#f6c23e", "#e74a3b"]
          }]
        }
      });

      // 3. Cost by Procedure
      const procedureCosts = {};
      data.forEach(d => {
        if (d.procedure) {
          procedureCosts[d.procedure] = (procedureCosts[d.procedure] || 0) + parseFloat(d.cost || 0);
        }
      });

      const pcLabels = Object.keys(procedureCosts);
      const pcValues = Object.values(procedureCosts);

      new Chart(document.getElementById("costChart"), {
        type: "bar",
        data: {
          labels: pcLabels,
          datasets: [{
            label: "Total Cost",
            data: pcValues,
            backgroundColor: "#858796"
          }]
        }
      });

      // 4. Test Count by Procedure
      const testCounts = {};
      data.forEach(d => {
        if (d.procedure) {
          testCounts[d.procedure] = (testCounts[d.procedure] || 0) + 1;
        }
      });

      new Chart(document.getElementById("testCountChart"), {
        type: "bar",
        data: {
          labels: Object.keys(testCounts),
          datasets: [{
            label: "Number of Tests",
            data: Object.values(testCounts),
            backgroundColor: "#36b9cc"
          }]
        }
      });
    }

    fetchData();
  </script>

</body>
</html>

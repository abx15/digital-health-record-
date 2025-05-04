let genderChart, outcomeChart, costChart;

function loadCharts() {
  const doctor = document.getElementById("doctorSelect").value;
  const url = `get_data.php?doctor=${doctor}`;

  fetch(url)
    .then(res => res.json())
    .then(data => {
      const genderCounts = countBy(data, 'gender');
      const outcomeCounts = countBy(data, 'outcome');
      const avgCostByDoctor = averageCost(data);

      drawChart('genderChart', 'pie', Object.keys(genderCounts), Object.values(genderCounts), 'Gender Distribution', genderChart, c => genderChart = c);
      drawChart('outcomeChart', 'doughnut', Object.keys(outcomeCounts), Object.values(outcomeCounts), 'Outcome', outcomeChart, c => outcomeChart = c);
      drawChart('costChart', 'bar', Object.keys(avgCostByDoctor), Object.values(avgCostByDoctor), 'Avg Earnings per Doctor Clinic', costChart, c => costChart = c, true);
    });
}

function drawChart(id, type, labels, data, label, prevChart, setChartFn, isCurrency = false) {
  if (prevChart) prevChart.destroy();
  const ctx = document.getElementById(id).getContext('2d');
  const newChart = new Chart(ctx, {
    type,
    data: {
      labels,
      datasets: [{
        label: label,
        data: data,
        backgroundColor: [
          '#4e79a7', '#f28e2b', '#e15759', '#76b7b2', '#59a14f', '#edc949'
        ]
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { position: 'top' },
        tooltip: {
          callbacks: {
            label: context => {
              const value = context.parsed.y !== undefined ? context.parsed.y : context.parsed;
              return isCurrency ? `₹${value}` : value;
            }
          }
        }
      },
      scales: {
        y: {
          ticks: {
            callback: function(value) {
              return isCurrency ? `₹${value}` : value;
            }
          }
        }
      }
    }
  });
  setChartFn(newChart);
}

function countBy(data, field) {
  return data.reduce((acc, row) => {
    const key = (row[field] || 'Unknown').trim();
    acc[key] = (acc[key] || 0) + 1;
    return acc;
  }, {});
}

function averageCost(data) {
  const costMap = {}, countMap = {};
  data.forEach(row => {
    const doctor = row.consultant_doctor || 'Unknown';
    costMap[doctor] = (costMap[doctor] || 0) + parseFloat(row.cost || 0);
    countMap[doctor] = (countMap[doctor] || 0) + 1;
  });
  const avgMap = {};
  for (let doc in costMap) {
    avgMap[doc] = (costMap[doc] / countMap[doc]).toFixed(2);
  }
  return avgMap;
}

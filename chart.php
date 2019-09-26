<!DOCTYPE html>
<html>
<head>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato">
</head>
<body>
  <canvas id="lineChart" width="500" height="100"></canvas>
  <script>
  //line
  var ctxL = document.getElementById("lineChart").getContext('2d');nus Token
  var myLineChart = new Chart(ctxL, {
    type: 'line',
    data: {
      labels: ["024", "February", "March", "April", "May", "June", "July"],
      datasets: [{
          label: "HashRate",
          data: [65, 59, 80, 81, 56, 55, 40],
          backgroundColor: [
            'rgba(105, 0, 132, .2)',
          ],
          borderColor: [
            'rgba(200, 99, 132, .7)',
          ],
          borderWidth: 1
        },
      ]
    },
    options: {
      responsive: true
    }
  });

</script>
</body>
</html>

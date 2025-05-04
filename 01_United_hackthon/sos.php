<!DOCTYPE html>
<html>
<head>
  <title>Emergency SOS</title>
</head>
<body>
  <h1>SOS Alert System</h1>
  <button onclick="sendSOS()">Send SOS</button>
  <p id="message"></p>

  <script>
    function sendSOS() {
      if (confirm("Are you sure you want to send SOS?")) {
        if (!navigator.geolocation) {
          document.getElementById("message").innerText = "❌ Geolocation not supported.";
          return;
        }

        navigator.geolocation.getCurrentPosition(
          function(position) {
            const data = {
              patient_id: 3, // Replace with dynamic ID
              timestamp: new Date().toISOString().slice(0, 19).replace('T', ' '),
              latitude: position.coords.latitude,
              longitude: position.coords.longitude
            };

            fetch("send_sos.php", {
              method: "POST",
              headers: { "Content-Type": "application/json" },
              body: JSON.stringify(data)
            })
            .then(res => res.text())
            .then(msg => document.getElementById("message").innerText = msg)
            .catch(err => {
              console.error(err);
              document.getElementById("message").innerText = "❌ Error sending SOS.";
            });
          },
          function(error) {
            document.getElementById("message").innerText = "❌ Location error: " + error.message;
          }
        );
      }
    }
  </script>
</body>
</html>
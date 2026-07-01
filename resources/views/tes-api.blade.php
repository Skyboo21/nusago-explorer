<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembuktian Tampilan Web API Praktikum</title>
    <style>
        body { font-family: sans-serif; padding: 20px; line-height: 1.6; }
        .container { max-width: 800px; margin: auto; }
        .box { background: #f4f4f4; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #ddd; }
        input { padding: 10px; width: 100%; box-sizing: border-box; margin-bottom: 10px; }
        button { padding: 10px 15px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
        pre { background: #222; color: #0f0; padding: 15px; border-radius: 5px; overflow-x: auto; max-height: 400px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Uji Coba Filter API PENGUNJUNG di Halaman Web</h2>
        <div class="box">
            <label><strong>Masukkan Bearer Token dari Postman:</strong></label>
            <input type="text" id="tokenInput" placeholder="Paste token (misal: 1|AbCdEfGh...) di sini">
            <button onclick="fetchData()">Panggil API Pengunjung (Filter Tanggal)</button>
        </div>

        <h3>Hasil Respons (Tampilan Web)</h3>
        <p>Mengambil data dari: <code>/api/pengunjung?start_date=2026-06-01&end_date=2026-06-30</code></p>
        <pre id="output">Hasil JSON akan muncul di sini...</pre>
    </div>

    <script>
        function fetchData() {
            const token = document.getElementById('tokenInput').value;
            const output = document.getElementById('output');
            
            if(!token) {
                alert("Harap masukkan token terlebih dahulu!");
                return;
            }

            output.innerHTML = "Memuat data...";

            fetch('/api/pengunjung?start_date=2026-06-01&end_date=2026-06-30', {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                output.innerHTML = JSON.stringify(data, null, 4);
            })
            .catch(error => {
                output.innerHTML = "Terjadi Error: " + error;
            });
        }
    </script>
</body>
</html>

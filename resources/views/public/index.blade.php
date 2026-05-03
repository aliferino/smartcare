<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Uji Coba AJAX Pertama Anda</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

    <h1>Belajar AJAX</h1>
    
    <button id="btnTembak">Ambil Data Sekarang!</button>

    <div id="loading" style="display:none;">Sabar, lagi minta data ke server...</div>

    <div id="kontainer-data">
        <h2 id="judul"></h2>
        <p id="isi"></p>
    </div>

    <script>
        $(document).ready(function() {
            $('#btnTembak').click(function() {
                // Tampilkan loading biar user nggak bingung
                $('#loading').show();
                
                $.ajax({
                    url: 'https://jsonplaceholder.typicode.com/posts/1',
                    method: 'GET',
                    success: function(data) {
                        $('#loading').hide();
                        // Masukkan data hasil tembakan ke HTML
                        $('#judul').text(data.title);
                        $('#isi').text(data.body);
                    },
                    error: function() {
                        alert('Servernya lagi pingsan!');
                    }
                });
            });
        });
    </script>

</body>
</html>
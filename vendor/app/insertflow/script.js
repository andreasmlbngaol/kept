var isincome = document.getElementById('input-isincome');
var category = document.getElementById('input-category');
var name = document.getElementById('input-name');


// tambahkan event ketika diubah
isincome.addEventListener('change', function() {
    // buat object ajax
    var ajax = new XMLHttpRequest();
    
    // cek kesiapan ajax
    ajax.onreadystatechange = function() {
        if(ajax.readyState == 4 && ajax.status == 200) {
            console.log('test');
        }

    }

    // eksekusi ajax
    ajax.open('GET', '../../ajax/insertflow.php', true);
    ajax.send
})
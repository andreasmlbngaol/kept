var page = document.getElementById('home-header');
var time = document.getElementById('time');

// tambahkan event ketika diubah
page.addEventListener('mouseover', function() {
    // buat object ajax
    var ajax = new XMLHttpRequest();
    
    // cek kesiapan ajax
    ajax.onreadystatechange = function() {
        if(ajax.readyState == 4 && ajax.status == 200) {
            time.innerHTML = ajax.responseText;
        }
    }

    // eksekusi ajax
    ajax.open('GET', 'src/ajax/time.php?', true);
    ajax.send();
})
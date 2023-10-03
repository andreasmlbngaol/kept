var isincome = document.getElementById('input-isincome');
var category = document.getElementById('input-class');

// tambahkan event ketika diubah
isincome.addEventListener('change', function() {
    // buat object ajax
    var ajax = new XMLHttpRequest();
    
    // cek kesiapan ajax
    ajax.onreadystatechange = function() {
        if(ajax.readyState == 4 && ajax.status == 200) {
            category.innerHTML = ajax.responseText;
        }

    }

    // eksekusi ajax
    ajax.open('GET', 'ajax/class.php?isincome=' + isincome.value, true);
    ajax.send();
})
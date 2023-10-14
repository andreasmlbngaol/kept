var newPlan = document.getElementById('new-plan');
var newPlanCustom = document.getElementById('new-plan-custom');

// tambahkan event ketika diubah
newPlan.addEventListener('change', function() {
    // buat object ajax
    var ajax = new XMLHttpRequest();
    
    // cek kesiapan ajax
    ajax.onreadystatechange = function() {
        if(ajax.readyState == 4 && ajax.status == 200) {
            newPlanCustom.innerHTML = ajax.responseText;
        }
    }

    // eksekusi ajax
    ajax.open('GET', 'ajax/plan.php?newPlan=' + newPlan.value, true);
    ajax.send();
})
var buttonName = document.getElementById('button-name');
var profileName = document.getElementById('profile-name');
buttonName.addEventListener('click', function() {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function() {
        if(ajax.readyState == 4 && ajax.status == 200) {
            profileName.innerHTML = ajax.responseText;
        }
    }
    ajax.open('GET', 'ajax/change.php?value=' + buttonName.value, true);
    ajax.send();
})

var buttonNickname = document.getElementById('button-nickname');
var profileNickname = document.getElementById('profile-nickname');
console.log(buttonNickname.value);
buttonNickname.addEventListener('click', function() {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function() {
        if(ajax.readyState == 4 && ajax.status == 200) {
            profileNickname.innerHTML = ajax.responseText;
            console.log('ajax/change.php?value=' + buttonNickname.value);
        }
    }
    ajax.open('GET', 'ajax/change.php?value=' + buttonNickname.value, true);
    ajax.send();
})

var buttonHpNum = document.getElementById('button-hpnum');
var profileHpNum = document.getElementById('profile-hpnum');
buttonHpNum.addEventListener('click', function() {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function() {
        if(ajax.readyState == 4 && ajax.status == 200) {
            profileHpNum.innerHTML = ajax.responseText;
        }
    }
    ajax.open('GET', 'ajax/change.php?value=' + buttonHpNum.value, true);
    ajax.send();
})

var buttonUsername = document.getElementById('button-username');
var profileUsername = document.getElementById('profile-username');
buttonUsername.addEventListener('click', function() {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function() {
        if(ajax.readyState == 4 && ajax.status == 200) {
            profileUsername.innerHTML = ajax.responseText;
        }
    }
    ajax.open('GET', 'ajax/change.php?value=' + buttonUsername.value, true);
    ajax.send();
})

var buttonBirthday = document.getElementById('button-birthday');
var profileBirthday = document.getElementById('profile-birthday');
buttonBirthday.addEventListener('click', function() {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function() {
        if(ajax.readyState == 4 && ajax.status == 200) {
            profileBirthday.innerHTML = ajax.responseText;
        }
    }
    ajax.open('GET', 'ajax/change.php?value=' + buttonBirthday.value, true);
    ajax.send();
})

var buttonEmail = document.getElementById('button-email');
var profileEmail = document.getElementById('profile-email');
buttonEmail.addEventListener('click', function() {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function() {
        if(ajax.readyState == 4 && ajax.status == 200) {
            profileEmail.innerHTML = ajax.responseText;
        }
    }
    ajax.open('GET', 'ajax/change.php?value=' + buttonEmail.value, true);
    ajax.send();
})

var inputName = document.getElementById('profile-name-input');
var profileName = document.getElementById('profile-name');
inputName.addEventListener('click', function() {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function() {
        if(ajax.readyState == 4 && ajax.status == 200) {
            profileName.innerHTML = ajax.responseText;
        }
    }
    ajax.open('GET', 'ajax/changename.php?name=' + inputName.value, true);
    ajax.send();
})

var inputUsername = document.getElementById('profile-username-input');
var profileUsername = document.getElementById('profile-username');
inputUsername.addEventListener('click', function() {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function() {
        if(ajax.readyState == 4 && ajax.status == 200) {
            profileUsername.innerHTML = ajax.responseText;
        }
    }
    ajax.open('GET', 'ajax/changeusername.php?username=' + inputUsername.value, true);
    ajax.send();
})

var inputBio = document.getElementById('profile-bio-input');
var profileBio = document.getElementById('profile-bio');
inputBio.addEventListener('click', function() {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function() {
        if(ajax.readyState == 4 && ajax.status == 200) {
            profileBio.innerHTML = ajax.responseText;
        }
    }
    ajax.open('GET', 'ajax/changebio.php?bio=' + inputBio.value, true);
    ajax.send();
})

var inputPicture = document.getElementById('profile-picture-input');
var profilePicture = document.getElementById('profile-picture');
inputPicture.addEventListener('click', function() {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function() {
        if(ajax.readyState == 4 && ajax.status == 200) {
            profilePicture.innerHTML = ajax.responseText;
        }
    }
    ajax.open('GET', 'ajax/changebio.php?picture=' + inputPicture.value, true);
    ajax.send();
})
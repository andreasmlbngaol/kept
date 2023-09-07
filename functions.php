<?php
date_default_timezone_set('Asia/Jakarta');
session_start();
$conn = NULL;
function connect($connect) {
    global $conn;
    $conn = mysqli_connect("sql209.infinityfree.com", "if0_34962067", "PMLbfabCfgyBhf", "if0_34962067_{$connect}");
}

connect("cashflowdatabase");

// function for making script
function script($script) {
    echo "
<script>
    $script;
</script>
    ";
}

function jumpTo($destination) {
    script('window.location.href = "'.$destination.'";');
}
// function for showing alert
function alert($alert) {
    echo "
<script>
    window.alert('$alert')
</script>
";}

// function for query
function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function showDate() {
    echo date('Y-m-d');
}

function showDateTime() {
    echo date('Y-m-d H:i:s');
}

function showTime() {
    echo date('H:i:s');
}
?>
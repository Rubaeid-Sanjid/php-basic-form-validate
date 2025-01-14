<?php
 function validateToken($token) {
    $validTokens = ["123", "456", "789"];
    return in_array($token, $validTokens);
}

function getAllTokens() {
    return ["123", "456", "789"];
}
?>
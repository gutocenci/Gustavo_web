<?php

// Create connection
$conn = new mysqli(db_host, db_user, db_password, db_database);
// Check connection
if ($conn->connect_error) {
    echo "Conexão falhou: " . $conn->connect_error;
}

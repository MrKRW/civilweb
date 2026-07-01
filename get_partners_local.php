<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=civilweb', 'root', '');
    $stmt = $pdo->query('SELECT * FROM partners');
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (Exception $e) {
    echo "civilweb failed: " . $e->getMessage() . "\n";
    try {
        $pdo = new PDO('mysql:host=127.0.0.1;dbname=civilanka', 'root', '');
        $stmt = $pdo->query('SELECT * FROM partners');
        print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e2) {
        echo "civilanka failed: " . $e2->getMessage() . "\n";
    }
}

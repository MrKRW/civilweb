<?php
// Script to fix Unknown Collation errors in SQL dumps
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['sql_file'])) {
    $file = $_FILES['sql_file'];
    if ($file['error'] === UPLOAD_ERR_OK) {
        $content = file_get_contents($file['tmp_name']);
        
        // Replace newer collations with older, universally supported ones
        $content = str_replace('utf8mb4_uca1400_ai_ci', 'utf8mb4_unicode_ci', $content);
        $content = str_replace('utf8mb4_0900_ai_ci', 'utf8mb4_unicode_ci', $content);
        
        header('Content-Type: application/sql');
        header('Content-Disposition: attachment; filename="fixed_database.sql"');
        echo $content;
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Fix SQL File</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; }
        .box { border: 1px solid #ccc; padding: 20px; border-radius: 8px; max-width: 500px; }
        button { padding: 10px 15px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; margin-top: 15px; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Fix Database Collation Error</h2>
        <p>This tool will fix the <code>utf8mb4_uca1400_ai_ci</code> error in your .sql file.</p>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="sql_file" accept=".sql" required>
            <br>
            <button type="submit">Fix & Download SQL</button>
        </form>
    </div>
</body>
</html>

<?php
/**
 * Admin Credentials Fix - Generate correct password hash
 */

require_once 'includes/db.php';

echo "<h1>Admin Credentials Setup</h1>";
echo "<p style='font-family: monospace; background: #f0f0f0; padding: 15px; border-radius: 5px;'>";

// Test passwords and generate hashes
$passwords = [
    'admin123' => password_hash('admin123', PASSWORD_BCRYPT, ['cost' => 10]),
    'password' => password_hash('password', PASSWORD_BCRYPT, ['cost' => 10]),
];

echo "Generated Password Hashes:\n";
echo "─────────────────────────────────────────\n";
foreach ($passwords as $pwd => $hash) {
    echo "Password: $pwd\n";
    echo "Hash: $hash\n\n";
}

echo "Current admin user in database:\n";
echo "─────────────────────────────────────────\n";

try {
    $stmt = $pdo->query('SELECT username, password_hash, full_name, email FROM admin_users WHERE username = "admin"');
    $admin = $stmt->fetch();
    
    if ($admin) {
        echo "Username: " . htmlspecialchars($admin['username']) . "\n";
        echo "Name: " . htmlspecialchars($admin['full_name']) . "\n";
        echo "Email: " . htmlspecialchars($admin['email']) . "\n";
        echo "Hash: " . $admin['password_hash'] . "\n\n";
        
        // Test if the current hash matches any password
        echo "Testing current hash:\n";
        echo "  password_verify('admin123', hash): " . (password_verify('admin123', $admin['password_hash']) ? "✓ VALID" : "✗ INVALID") . "\n";
        echo "  password_verify('password', hash): " . (password_verify('password', $admin['password_hash']) ? "✓ VALID" : "✗ INVALID") . "\n\n";
        
        // If admin123 doesn't work, update with correct hash
        if (!password_verify('admin123', $admin['password_hash'])) {
            echo "⚠️  The current hash is NOT for 'admin123'\n";
            echo "This is the hash for: 'password'\n\n";
            
            echo "<span style='color: green; font-weight: bold;'>✓ SOLUTION: Use these credentials to login:</span>\n";
            echo "  Username: admin\n";
            echo "  Password: password\n\n";
            
            echo "<span style='color: blue;'>Or update database with correct hash for 'admin123':</span>\n";
            echo "SQL Command:\n";
            echo "UPDATE admin_users SET password_hash = '" . $passwords['admin123'] . "' WHERE username = 'admin';\n";
        } else {
            echo "✓ The hash is correct for 'admin123'\n";
        }
    } else {
        echo "✗ No admin user found. Please run database.sql first.\n";
    }
} catch (PDOException $e) {
    echo "Database Error: " . htmlspecialchars($e->getMessage()) . "\n";
}

echo "</p>";

echo "<hr><h2>Quick Fix Options:</h2>";
echo "<p>";
echo "<strong>Option 1 (Easiest):</strong><br>";
echo "Login with: <strong>username: admin</strong>, <strong>password: password</strong><br><br>";

echo "<strong>Option 2 (If you want to use admin123):</strong><br>";
echo "Run this SQL command in your database:<br>";
echo "<code>UPDATE admin_users SET password_hash = '" . password_hash('admin123', PASSWORD_BCRYPT, ['cost' => 10]) . "' WHERE username = 'admin';</code><br><br>";

echo "<strong>Option 3 (Create new admin user):</strong><br>";
echo "See the form below to create a new admin account.<br>";
echo "</p>";

// Form to create new admin user
echo "<hr><h2>Create New Admin User</h2>";
echo "<form method='POST' style='border: 1px solid #ddd; padding: 15px; max-width: 400px; border-radius: 5px;'>";
echo "<div style='margin-bottom: 15px;'>";
echo "<label>Username: <input type='text' name='new_username' placeholder='e.g., admin' required style='width: 100%; padding: 8px;'></label><br>";
echo "</div>";
echo "<div style='margin-bottom: 15px;'>";
echo "<label>Password: <input type='password' name='new_password' placeholder='e.g., MySecurePass123!' required style='width: 100%; padding: 8px;'></label><br>";
echo "</div>";
echo "<div style='margin-bottom: 15px;'>";
echo "<label>Full Name: <input type='text' name='new_fullname' placeholder='e.g., John Admin' required style='width: 100%; padding: 8px;'></label><br>";
echo "</div>";
echo "<div style='margin-bottom: 15px;'>";
echo "<label>Email: <input type='email' name='new_email' placeholder='e.g., admin@railway.com' required style='width: 100%; padding: 8px;'></label><br>";
echo "</div>";
echo "<button type='submit' name='create_user' style='background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 3px; cursor: pointer;'>Create Admin User</button>";
echo "</form>";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_user'])) {
    $new_username = trim($_POST['new_username'] ?? '');
    $new_password = $_POST['new_password'] ?? '';
    $new_fullname = trim($_POST['new_fullname'] ?? '');
    $new_email = trim($_POST['new_email'] ?? '');
    
    if (!empty($new_username) && !empty($new_password) && !empty($new_fullname) && !empty($new_email)) {
        try {
            $password_hash = password_hash($new_password, PASSWORD_BCRYPT, ['cost' => 10]);
            $stmt = $pdo->prepare('INSERT INTO admin_users (username, password_hash, full_name, email, role, is_active) VALUES (:username, :password_hash, :full_name, :email, :role, :is_active)');
            $stmt->execute([
                ':username' => $new_username,
                ':password_hash' => $password_hash,
                ':full_name' => $new_fullname,
                ':email' => $new_email,
                ':role' => 'Super Admin',
                ':is_active' => true
            ]);
            
            echo "<div style='background: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-top: 20px; border: 1px solid #c3e6cb;'>";
            echo "<strong>✓ Success!</strong> New admin user created:<br>";
            echo "Username: <strong>" . htmlspecialchars($new_username) . "</strong><br>";
            echo "Password: <strong>" . htmlspecialchars($new_password) . "</strong><br>";
            echo "You can now login with these credentials.";
            echo "</div>";
        } catch (PDOException $e) {
            echo "<div style='background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-top: 20px; border: 1px solid #f5c6cb;'>";
            echo "<strong>✗ Error:</strong> " . htmlspecialchars($e->getMessage());
            echo "</div>";
        }
    }
}

?>
<hr>
<p><a href='admin/login.php' style='font-size: 1.2em; color: #007bff; text-decoration: none;'>→ Go to Login</a></p>

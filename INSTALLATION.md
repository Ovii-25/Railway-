# Sri Lanka Railways - Quick Setup Guide

## ⚡ Quick Start (5 Minutes)

### Step 1: Install XAMPP
1. Download XAMPP from https://www.apachefriends.org
2. Install XAMPP to `C:\xampp` (Windows) or `/opt/lampp` (Linux)
3. Start Apache and MySQL from XAMPP Control Panel

### Step 2: Setup Database
1. Open browser and go to: `http://localhost/phpmyadmin`
2. Click "Import" tab
3. Click "Choose File" and select: `sql/database.sql`
4. Click "Go" button at bottom
5. Wait for success message

### Step 3: Configure (If needed)
1. Open `includes/db.php`
2. Verify these settings:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'sri_lanka_railways');
   define('DB_USER', 'root');
   define('DB_PASS', '');  // Leave empty for XAMPP default
   ```

### Step 4: Copy Files
1. Copy the entire `Railway` folder
2. Paste into: `C:\xampp\htdocs\`
3. Final path should be: `C:\xampp\htdocs\Railway\`

### Step 5: Access Website
1. Open web browser
2. Go to: `http://localhost/Railway/`
3. Done! Website should load.

---

## 🔧 Detailed Configuration

### Database Configuration
File: `includes/db.php`

**Default Settings (XAMPP):**
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'sri_lanka_railways');
define('DB_USER', 'root');
define('DB_PASS', '');
```

**Production Settings:**
```php
define('DB_HOST', 'your-server-ip');
define('DB_NAME', 'sri_lanka_railways');
define('DB_USER', 'your-username');
define('DB_PASS', 'your-secure-password');
```

### Server Requirements
- PHP 8.0 or higher
- MySQL 8.0 or higher
- Apache 2.4 or higher
- PDO PHP Extension
- JSON PHP Extension

### PHP Extensions Required
- `pdo_mysql`
- `mysqli`
- `json`
- `mbstring`
- `openssl`

### File Permissions (Linux/Mac)
```bash
chmod -R 755 /opt/lampp/htdocs/Railway
chmod -R 777 /opt/lampp/htdocs/Railway/uploads  # If you add file uploads
```

---

## 📝 Default Login Credentials

### Admin Panel (Future Feature)
- Username: `admin`
- Password: `admin123`
- **⚠️ Change immediately in production!**

---

## 🧪 Testing the Installation

### Test Database Connection
1. Go to: `http://localhost/Railway/`
2. If homepage loads → Database connection is working
3. If error message → Check database credentials

### Test Train Schedule
1. Click "Schedules" in navigation
2. Select "Colombo Fort" as From Station
3. Select "Kandy" as To Station
4. Click "Search"
5. Should show available trains

### Test Booking System
1. Search for a train schedule
2. Click "Book" button
3. Select date and class
4. Enter passenger details
5. Confirm booking
6. Should get confirmation page with booking reference

### Test Contact Form
1. Click "Contact" in navigation
2. Fill all required fields
3. Submit form
4. Should see success message
5. Check database `contact_messages` table

---

## 🐛 Common Issues & Solutions

### Issue: "Database Connection Error"
**Solution:**
1. Start MySQL in XAMPP Control Panel
2. Check database name is `sri_lanka_railways`
3. Verify credentials in `includes/db.php`
4. Ensure database was imported successfully

### Issue: "Page Not Found" (404 Error)
**Solution:**
1. Check file path: `C:\xampp\htdocs\Railway\`
2. Access via: `http://localhost/Railway/` (not `http://localhost/`)
3. Ensure Apache is running

### Issue: "Parse Error" or PHP Errors
**Solution:**
1. Check PHP version: `php -v` (must be 8.0+)
2. Enable error display in development:
   - Edit `php.ini`
   - Set `display_errors = On`
   - Restart Apache

### Issue: Forms Not Submitting
**Solution:**
1. Check browser console for JavaScript errors
2. Verify form `action` attribute
3. Check PHP error logs: `C:\xampp\php\logs\php_error_log`
4. Ensure POST data is being received

### Issue: Styles Not Loading
**Solution:**
1. Check `assets/css/style.css` exists
2. Clear browser cache (Ctrl + Shift + Delete)
3. Check browser console for 404 errors
4. Verify Bootstrap CDN is accessible

---

## 🚀 Deployment to Production Server

### Pre-deployment Checklist
- [ ] Update database credentials
- [ ] Change default admin password
- [ ] Enable HTTPS/SSL
- [ ] Set up regular database backups
- [ ] Configure email settings (if using)
- [ ] Test all features thoroughly
- [ ] Enable error logging (not display)
- [ ] Set proper file permissions
- [ ] Configure firewall rules
- [ ] Set up monitoring

### Deployment Steps

#### 1. Prepare Server
```bash
# Update system
sudo apt update && sudo apt upgrade

# Install Apache
sudo apt install apache2

# Install PHP 8
sudo apt install php8.1 php8.1-mysql php8.1-cli php8.1-common

# Install MySQL
sudo apt install mysql-server
```

#### 2. Upload Files
```bash
# Upload via FTP/SFTP to:
/var/www/html/Railway/
```

#### 3. Configure Database
```bash
# Login to MySQL
mysql -u root -p

# Create database
CREATE DATABASE sri_lanka_railways;

# Import schema
mysql -u root -p sri_lanka_railways < database.sql
```

#### 4. Set Permissions
```bash
sudo chown -R www-data:www-data /var/www/html/Railway
sudo chmod -R 755 /var/www/html/Railway
```

#### 5. Configure Apache
```apache
<VirtualHost *:80>
    ServerName railway.gov.lk
    DocumentRoot /var/www/html/Railway
    
    <Directory /var/www/html/Railway>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/railway-error.log
    CustomLog ${APACHE_LOG_DIR}/railway-access.log combined
</VirtualHost>
```

#### 6. Enable SSL (Recommended)
```bash
# Install Certbot
sudo apt install certbot python3-certbot-apache

# Get certificate
sudo certbot --apache -d railway.gov.lk
```

---

## 🔐 Security Hardening

### 1. Database Security
```php
// Use environment variables (recommended)
define('DB_HOST', getenv('DB_HOST'));
define('DB_NAME', getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));
```

### 2. PHP Security Settings
```ini
; php.ini settings
expose_php = Off
display_errors = Off
log_errors = On
error_log = /var/log/php/error.log
```

### 3. .htaccess Configuration
```apache
# Prevent directory listing
Options -Indexes

# Protect sensitive files
<FilesMatch "(db\.php|config\.php|\.env)">
    Order allow,deny
    Deny from all
</FilesMatch>

# Force HTTPS
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

## 📊 Performance Optimization

### 1. Enable PHP OpCache
```ini
; php.ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=60
```

### 2. Enable Compression
```apache
# .htaccess
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript
</IfModule>
```

### 3. Browser Caching
```apache
# .htaccess
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>
```

---

## 📈 Monitoring & Maintenance

### Database Backup (Daily)
```bash
#!/bin/bash
# backup.sh
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u root -p sri_lanka_railways > backup_$DATE.sql
```

### Log Monitoring
```bash
# Check Apache logs
tail -f /var/log/apache2/error.log

# Check PHP logs
tail -f /var/log/php/error.log

# Check MySQL logs
tail -f /var/log/mysql/error.log
```

### Performance Monitoring
- Use tools like New Relic or Datadog
- Monitor server resources (CPU, RAM, Disk)
- Track page load times
- Monitor database query performance

---

## 📞 Support & Resources

### Getting Help
- Check error logs first
- Review README.md
- Search for similar issues online
- Contact: info@railway.gov.lk

### Useful Commands

**Restart Services:**
```bash
# XAMPP (Windows)
xampp-control.exe

# Linux
sudo systemctl restart apache2
sudo systemctl restart mysql
```

**Check PHP Version:**
```bash
php -v
```

**Check MySQL Status:**
```bash
# Linux
sudo systemctl status mysql

# Windows
# Check XAMPP Control Panel
```

**Clear Cache:**
```bash
# Browser: Ctrl + Shift + Delete
# PHP OpCache: restart Apache
```

---

## ✅ Post-Installation Checklist

- [ ] Database imported successfully
- [ ] Homepage loads without errors
- [ ] Train schedules search works
- [ ] Booking system completes successfully
- [ ] Live status displays correctly
- [ ] Station finder works
- [ ] Notices page loads
- [ ] Contact form submits
- [ ] All links working
- [ ] Responsive on mobile
- [ ] No console errors
- [ ] Images loading
- [ ] Forms validating correctly

---

**Installation Complete! 🎉**

Your Sri Lanka Railways website is now ready to use.

For questions or issues, refer to the main README.md file.

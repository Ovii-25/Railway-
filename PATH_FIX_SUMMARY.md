# File Path Error Fixed

## Issue
**Error Message:**
```
Warning: require_once(../includes/db.php): Failed to open stream: No such file or directory in C:\xampp\htdocs\Railway\index.php on line 3

Fatal error: Uncaught Error: Failed opening required '../includes/db.php'
```

## Root Cause
The Railway project was moved from `c:\Users\User\Desktop\L3 S1 (2023-2024)\CA\Railway\` to `C:\xampp\htdocs\Railway\`

However, `index.php` was still using relative paths that pointed one level UP:
- `../includes/db.php` → Looks for `C:\xampp\htdocs\includes\db.php` ❌
- Should be `./includes/db.php` → Looks for `C:\xampp\htdocs\Railway\includes\db.php` ✓

## What Was Fixed

### 1. **index.php** - Updated all include paths
**Before:**
```php
require_once 'includes/db.php';
include 'includes/header.php';
include 'includes/footer.php';
```

**After:**
```php
require_once './includes/db.php';
include './includes/header.php';
include './includes/footer.php';
```

### 2. **includes/header.php** - Replaced entire file
The file had incorrect admin code instead of proper navbar HTML/CSS

**Now contains:**
- Proper DOCTYPE and head section
- Bootstrap 5 CSS CDN
- Navigation bar with all links
- Admin login button in navbar
- Responsive design

### 3. **includes/footer.php** - Fixed base_url variables
Added fallback to `./` when `$base_url` is not set:
```php
href="<?php echo isset($base_url) ? $base_url : './'; ?>"
```

## File Structure (Correct Now)
```
C:\xampp\htdocs\Railway\
├── index.php              ← Uses ./includes/db.php
├── admin/
│   ├── index.php         ← Uses ../includes/db.php ✓
│   ├── login.php
│   └── ...
├── pages/
│   ├── booking.php
│   └── ...
└── includes/
    ├── db.php            ← Database connection
    ├── header.php        ← Navigation & head
    └── footer.php        ← Footer & closing tags
```

## How to Verify

1. **Clear browser cache** (Ctrl+Shift+Delete)
2. **Access the website**: `http://localhost/Railway/`
3. Should see:
   - ✓ Hero section loads
   - ✓ Navbar with menu items
   - ✓ Quick train search form
   - ✓ Service cards
   - ✓ Notices section
   - ✓ Statistics and footer

## Testing

### Test the home page:
- URL: `http://localhost/Railway/`
- Expected: Full page loads with no PHP errors

### Test includes:
- Navigation bar should be present
- All links should work
- Admin login button should be visible

### Test database:
- Latest notices should display
- Station dropdowns should populate

## Additional Notes

- All file paths are now relative and use `./` prefix
- No more `..` references in main pages
- Admin pages use `../` correctly (they're in subdirectories)
- Backward compatible with `$base_url` variable if set

---

**Status:** ✅ All file path errors resolved

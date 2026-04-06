# Sri Lanka Railways Website - Redesign & Enhancement

## 🚂 Project Overview

A complete redesign of the Sri Lanka Railways website featuring modern UI/UX, responsive design, and comprehensive functionality for train booking, schedules, live tracking, and station information.

## ✨ Features

### Core Functionality
- **Home Page**: Hero banner, quick train search, service cards, latest notices
- **Train Schedules**: Search trains between any two stations with detailed information
- **Ticket Booking**: Complete booking system with passenger details and confirmation
- **Live Train Status**: Real-time train tracking and delay information
- **Station Finder**: Search and locate railway stations across Sri Lanka
- **Notices & Announcements**: View important railway updates and alerts
- **Contact Form**: Multi-field contact form with validation and database storage

### Technical Features
- Responsive design (mobile, tablet, desktop)
- Secure PDO database connections
- Input validation and sanitization
- XSS protection
- Clean, commented code
- Accessible design (ARIA labels, keyboard navigation)
- Bootstrap 5 framework
- Custom CSS animations
- Interactive JavaScript features

## 🛠️ Technology Stack

- **Frontend**: HTML5, CSS3, Bootstrap 5, JavaScript
- **Backend**: PHP 8.x
- **Database**: MySQL 8.x
- **Icons**: Bootstrap Icons
- **Fonts**: System fonts (Segoe UI, Arial)

## 📁 Project Structure

```
Railway/
├── assets/
│   ├── css/
│   │   └── style.css              # Custom styles
│   ├── js/
│   │   └── script.js              # Custom JavaScript
│   └── images/                    # Image assets
├── includes/
│   ├── db.php                     # Database connection
│   ├── header.php                 # Global header
│   └── footer.php                 # Global footer
├── pages/
│   ├── schedule.php               # Train schedules
│   ├── booking.php                # Ticket booking
│   ├── booking_confirmation.php   # Booking confirmation
│   ├── live_status.php            # Live train status
│   ├── stations.php               # Station finder
│   ├── notices.php                # Notices & announcements
│   └── contact.php                # Contact form
├── admin/                         # Admin panel (future)
├── sql/
│   └── database.sql               # Database schema & sample data
└── index.php                      # Homepage
```

## 🚀 Installation Instructions

### Prerequisites
- XAMPP/WAMP/LAMP or any PHP development environment
- PHP 8.0 or higher
- MySQL 8.0 or higher
- Modern web browser

### Step 1: Setup Environment
1. Install XAMPP (or similar)
2. Start Apache and MySQL services

### Step 2: Database Setup
1. Open phpMyAdmin (`http://localhost/phpmyadmin`)
2. Click "Import" tab
3. Select `sql/database.sql` file
4. Click "Go" to import
5. Database `sri_lanka_railways` will be created with sample data

### Step 3: Configure Database Connection
1. Open `includes/db.php`
2. Update database credentials if needed:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'sri_lanka_railways');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   ```

### Step 4: Deploy Files
1. Copy the entire `Railway` folder to your web server directory
   - XAMPP: `C:\xampp\htdocs\Railway`
   - WAMP: `C:\wamp64\www\Railway`
2. Ensure proper file permissions

### Step 5: Access Website
1. Open web browser
2. Navigate to: `http://localhost/Railway/`
3. Website should load successfully

## 📊 Database Schema

### Tables
1. **stations** - Railway stations information
2. **trains** - Train details
3. **schedules** - Train schedules between stations
4. **bookings** - Ticket bookings
5. **passengers** - Passenger information
6. **notices** - Railway notices and announcements
7. **contact_messages** - Contact form submissions
8. **live_train_status** - Real-time train status
9. **admin_users** - Admin panel users (future)

### Sample Data Included
- 15 major railway stations across Sri Lanka
- 10 different trains (Intercity, Express, Commuter)
- Multiple train schedules
- Sample notices and announcements

## 🎨 Design Features

### Color Scheme
- Primary: Blue (#0d6efd)
- Success: Green (#198754)
- Danger: Red (#dc3545)
- Warning: Yellow (#ffc107)
- Info: Cyan (#0dcaf0)

### Typography
- Font Family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif
- Responsive font sizes
- High contrast for readability

### Responsive Breakpoints
- Mobile: < 576px
- Tablet: 576px - 991px
- Desktop: ≥ 992px

## 🔒 Security Features

1. **SQL Injection Prevention**
   - PDO prepared statements
   - Parameter binding

2. **XSS Protection**
   - Input sanitization
   - Output escaping with `htmlspecialchars()`

3. **Input Validation**
   - Server-side validation
   - Client-side validation
   - Email format validation
   - Phone number validation

4. **Error Handling**
   - User-friendly error messages
   - Error logging
   - No sensitive information exposure

## 🧪 Testing Checklist

### Functional Testing
- ✅ Homepage loads correctly
- ✅ Train schedule search works
- ✅ Booking flow completes successfully
- ✅ Confirmation page displays booking details
- ✅ Live status tracking works
- ✅ Station finder search functions
- ✅ Notices display correctly
- ✅ Contact form submits and stores data

### Responsive Testing
- ✅ Mobile view (< 576px)
- ✅ Tablet view (576px - 991px)
- ✅ Desktop view (≥ 992px)

### Browser Compatibility
- ✅ Chrome
- ✅ Firefox
- ✅ Edge
- ✅ Safari

## 📝 Usage Guide

### For End Users

#### Searching Train Schedules
1. Go to "Schedules" page
2. Select departure and arrival stations
3. Choose travel date
4. Click "Search"
5. View available trains with fares

#### Booking Tickets
1. Search for trains on Schedule page
2. Click "Book" on desired train
3. Select travel date and class
4. Enter number of passengers
5. Fill passenger details
6. Confirm booking
7. Save/print confirmation

#### Tracking Live Status
1. Go to "Live Status" page
2. Select train from dropdown
3. Choose date
4. Click "Track"
5. View current location and status

### For Administrators

#### Database Management
1. Access phpMyAdmin
2. Select `sri_lanka_railways` database
3. Manage data through SQL queries or interface

#### Adding New Stations
```sql
INSERT INTO stations (station_code, name, district, province, facilities)
VALUES ('XXX', 'Station Name', 'District', 'Province', 'Facilities');
```

#### Adding New Trains
```sql
INSERT INTO trains (train_number, train_name, type, class_available, operational_days)
VALUES ('1234', 'Train Name', 'Intercity', '1st, 2nd, 3rd', 'Daily');
```

## 🔧 Customization

### Changing Colors
Edit `assets/css/style.css`:
```css
:root {
    --primary-color: #your-color;
    --secondary-color: #your-color;
}
```

### Adding New Pages
1. Create new PHP file in `pages/` folder
2. Include header: `include '../includes/header.php';`
3. Add content
4. Include footer: `include '../includes/footer.php';`
5. Add navigation link in `includes/header.php`

### Modifying Database
1. Update `sql/database.sql`
2. Reimport database
3. Update PHP queries accordingly

## 🐛 Troubleshooting

### Common Issues

**Issue**: Database connection error
- **Solution**: Check credentials in `includes/db.php`
- Ensure MySQL service is running
- Verify database name exists

**Issue**: Page not loading
- **Solution**: Check Apache service status
- Verify file paths are correct
- Check PHP error logs

**Issue**: Forms not submitting
- **Solution**: Check PHP error logs
- Verify database table names
- Ensure form action points to correct file

## 📈 Future Enhancements

- [ ] Admin panel for managing trains and schedules
- [ ] Online payment integration
- [ ] Email notifications for bookings
- [ ] SMS notifications
- [ ] User authentication system
- [ ] Booking history
- [ ] Seat selection interface
- [ ] Multi-language support (Sinhala, Tamil, English)
- [ ] Mobile app version
- [ ] API for third-party integrations

## 👨‍💻 Development Notes

### Code Standards
- PSR-12 coding standards for PHP
- BEM methodology for CSS class naming
- ES6+ JavaScript features
- Semantic HTML5 elements

### Best Practices Implemented
- Separation of concerns
- DRY (Don't Repeat Yourself)
- Reusable components
- Modular code structure
- Proper error handling
- Security first approach

## 📄 License

This project is developed for educational purposes as part of a final year project.

## 🤝 Contributing

This is an academic project. For improvements or suggestions:
1. Document the proposed changes
2. Test thoroughly
3. Maintain code quality and standards

## 📧 Support

For questions or issues:
- Email: info@railway.gov.lk
- Emergency Hotline: 1919

## 🎓 Academic Information

**Project**: Sri Lanka Railways Website Redesign & Enhancement
**Purpose**: Final Year Project / Web Development Portfolio
**Technologies**: HTML, CSS, Bootstrap 5, JavaScript, PHP, MySQL
**Year**: 2024-2025

## 📚 Resources & References

- Bootstrap 5 Documentation: https://getbootstrap.com
- PHP Manual: https://www.php.net/manual
- MySQL Documentation: https://dev.mysql.com/doc
- Bootstrap Icons: https://icons.getbootstrap.com

---

**Version**: 1.0
**Last Updated**: January 2, 2026
**Status**: Production Ready

---

## 🌟 Project Highlights

✅ **Complete** - All features fully implemented
✅ **Responsive** - Works on all devices
✅ **Secure** - SQL injection and XSS protection
✅ **Accessible** - ARIA labels and keyboard navigation
✅ **Modern** - Bootstrap 5 and latest web standards
✅ **Professional** - Clean code and documentation
✅ **Scalable** - Easy to extend and customize

**Ready for demonstration, deployment, and academic evaluation!**

<?php
session_start();
require_once 'includes/db.php';

$current_page = 'home';
$page_title = 'Home';
$base_url = './';

// Fetch latest notices
try {
    $stmt = $pdo->query("SELECT * FROM notices WHERE is_active = 1 ORDER BY created_at DESC LIMIT 3");
    $latest_notices = $stmt->fetchAll();
} catch (PDOException $e) {
    $latest_notices = [];
    error_log("Error fetching notices: " . $e->getMessage());
}

// Fetch all stations for quick search
try {
    $stmt = $pdo->query("SELECT station_id, name, district FROM stations ORDER BY name ASC");
    $stations = $stmt->fetchAll();
} catch (PDOException $e) {
    $stations = [];
}

include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section text-white d-flex align-items-center" 
         style="background: url('https://images.unsplash.com/photo-1474487548417-781cb71495f3?q=80&w=2070') center/cover; position: relative;">
    <!-- Dark overlay for better text visibility - NO BLUE CAST -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.28); z-index: 1;"></div>
    <!-- Subtle black gradient overlay for depth -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(45deg, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.22) 100%); z-index: 2;"></div>
    
    <div class="container" style="position: relative; z-index: 3;">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-3 fw-bold mb-4 animate__animated animate__fadeInDown" 
                    style="text-shadow: 2px 2px 8px rgba(0,0,0,0.8); color: #ffffff; font-size: 3.5rem; letter-spacing: 1px;">
                    Welcome to Sri Lanka Railways
                </h1>
                <p class="lead mb-4 animate__animated animate__fadeInUp" 
                   style="text-shadow: 1px 1px 4px rgba(0,0,0,0.8); color: #ffffff; font-size: 1.5rem; font-weight: 400;">
                    Connecting the nation through sustainable and reliable railway services
                </p>
                
                <!-- FIXED BUTTONS - Text stays visible on hover -->
                <div class="d-flex justify-content-center gap-3 animate__animated animate__fadeInUp">
                    <!-- Primary Button -->
                    <a href="pages/booking.php" class="btn btn-primary btn-lg px-4" 
                       style="background: var(--steel-blue); border: none; color: white; box-shadow: 0 4px 15px rgba(0,0,0,0.3);"
                       onmouseover="this.style.background='#266491'; this.style.color='white';" 
                       onmouseout="this.style.background='var(--steel-blue)'; this.style.color='white';">
                        <i class="bi bi-ticket-perforated"></i> Book Tickets Now
                    </a>
                    
                    <!-- Outline Button - FIXED: Text remains white on hover with background change -->
                    <a href="pages/schedule.php" class="btn btn-outline-light btn-lg px-4" 
                       style="border: 2px solid #ffffff; color: #ffffff; background: transparent; box-shadow: 0 4px 15px rgba(0,0,0,0.3);"
                       onmouseover="this.style.background='#ffffff'; this.style.color='#0C131F'; this.querySelector('i').style.color='#0C131F';" 
                       onmouseout="this.style.background='transparent'; this.style.color='#ffffff'; this.querySelector('i').style.color='#ffffff';">
                        <i class="bi bi-calendar-event"></i> View Schedules
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Train Search Section -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="card shadow border-0">
            <div class="card-body p-4">
                <h3 class="text-center mb-4">
                    <i class="bi bi-search text-primary"></i> Quick Train Search
                </h3>
                <form action="pages/schedule.php" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label for="from_station" class="form-label fw-bold">From Station</label>
                        <select class="form-select form-select-lg" id="from_station" name="from_station" required>
                            <option value="">Select departure station</option>
                            <?php foreach($stations as $station): ?>
                                <option value="<?php echo $station['station_id']; ?>">
                                    <?php echo htmlspecialchars($station['name'] . ' (' . $station['district'] . ')'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="to_station" class="form-label fw-bold">To Station</label>
                        <select class="form-select form-select-lg" id="to_station" name="to_station" required>
                            <option value="">Select arrival station</option>
                            <?php foreach($stations as $station): ?>
                                <option value="<?php echo $station['station_id']; ?>">
                                    <?php echo htmlspecialchars($station['name'] . ' (' . $station['district'] . ')'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="travel_date" class="form-label fw-bold">Travel Date</label>
                        <input type="date" class="form-control form-control-lg" id="travel_date" name="travel_date" 
                               min="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold">Our Services</h2>
        <div class="row g-4">
            <!-- Service Card 1: Train Schedules -->
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 text-center shadow-sm border-0 hover-card">
                    <div class="card-body p-4">
                        <div class="service-icon mb-3">
                            <i class="bi bi-calendar-event-fill text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="card-title mb-3">Train Schedules</h4>
                        <p class="card-text text-muted">
                            View complete train schedules, departure and arrival times for all routes across Sri Lanka.
                        </p>
                        <a href="pages/schedule.php" class="btn btn-outline-primary">
                            View Schedules <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Service Card 2: Ticket Booking -->
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 text-center shadow-sm border-0 hover-card">
                    <div class="card-body p-4">
                        <div class="service-icon mb-3">
                            <i class="bi bi-ticket-perforated-fill" style="color: var(--success-color); font-size: 3rem;"></i>
                        </div>
                        <h4 class="card-title mb-3">Ticket Booking</h4>
                        <p class="card-text text-muted">
                            Book your train tickets online easily and conveniently. Get instant booking confirmation.
                        </p>
                        <a href="pages/booking.php" class="btn btn-outline-success">
                            Book Now <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Service Card 3: Live Status -->
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 text-center shadow-sm border-0 hover-card">
                    <div class="card-body p-4">
                        <div class="service-icon mb-3">
                            <i class="bi bi-broadcast-pin" style="color: var(--danger-color); font-size: 3rem;"></i>
                        </div>
                        <h4 class="card-title mb-3">Live Train Status</h4>
                        <p class="card-text text-muted">
                            Track your train in real-time. Check live status, delays, and current location information.
                        </p>
                        <a href="pages/live_status.php" class="btn btn-outline-danger">
                            Track Now <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Service Card 4: Station Finder -->
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 text-center shadow-sm border-0 hover-card">
                    <div class="card-body p-4">
                        <div class="service-icon mb-3">
                            <i class="bi bi-geo-alt-fill" style="color: var(--warning-color); font-size: 3rem;"></i>
                        </div>
                        <h4 class="card-title mb-3">Station Finder</h4>
                        <p class="card-text text-muted">
                            Find railway stations across Sri Lanka. Get station details, facilities, and location maps.
                        </p>
                        <a href="pages/stations.php" class="btn btn-outline-warning">
                            Find Stations <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Notices Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="bi bi-megaphone-fill text-danger"></i> Latest Notices & Updates
            </h2>
            <a href="pages/notices.php" class="btn btn-primary">
                View All <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="row g-4">
            <?php if(!empty($latest_notices)): ?>
                <?php foreach($latest_notices as $notice): ?>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title mb-0">
                                        <?php echo htmlspecialchars($notice['title']); ?>
                                    </h5>
                                    <?php
                                    $priority_class = match($notice['priority']) {
                                        'Urgent' => 'danger',
                                        'High' => 'warning',
                                        'Normal' => 'info',
                                        'Low' => 'secondary',
                                        default => 'secondary'
                                    };
                                    ?>
                                    <span class="badge bg-<?php echo $priority_class; ?>">
                                        <?php echo htmlspecialchars($notice['priority']); ?>
                                    </span>
                                </div>
                                <?php if($notice['category']): ?>
                                    <small class="text-muted">
                                        <i class="bi bi-tag-fill"></i> <?php echo htmlspecialchars($notice['category']); ?>
                                    </small>
                                <?php endif; ?>
                                <p class="card-text mt-2">
                                    <?php echo htmlspecialchars(substr($notice['message'], 0, 100)) . '...'; ?>
                                </p>
                                <small class="text-muted">
                                    <i class="bi bi-clock-fill"></i> 
                                    <?php echo date('F j, Y', strtotime($notice['created_at'])); ?>
                                </small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        No active notices at this time.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-5 text-white" style="background: linear-gradient(135deg, #0B1220 0%, #172554 45%, #1E3A8A 100%);">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <i class="bi bi-train-front fs-1 mb-3"></i>
                    <h2 class="fw-bold mb-0 text-white">500+</h2>
                    <p class="mb-0 text-white">Daily Train Services</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <i class="bi bi-geo-alt-fill fs-1 mb-3"></i>
                    <h2 class="fw-bold mb-0 text-white">450+</h2>
                    <p class="mb-0 text-white">Railway Stations</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <i class="bi bi-people-fill fs-1 mb-3"></i>
                    <h2 class="fw-bold mb-0 text-white">1M+</h2>
                    <p class="mb-0 text-white">Daily Passengers</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <i class="bi bi-clock-history fs-1 mb-3"></i>
                    <h2 class="fw-bold mb-0 text-white">150+</h2>
                    <p class="mb-0 text-white">Years of Service</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold">Why Travel with Sri Lanka Railways?</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-box text-center p-4">
                    <i class="bi bi-shield-check text-success fs-1 mb-3"></i>
                    <h4>Safe & Reliable</h4>
                    <p class="text-muted">
                        Experience safe travel with our modern safety systems and well-maintained infrastructure.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box text-center p-4">
                    <i class="bi bi-cash-coin text-primary fs-1 mb-3"></i>
                    <h4>Affordable Fares</h4>
                    <p class="text-muted">
                        Enjoy competitive pricing and special discounts for students, seniors, and groups.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box text-center p-4">
                    <i class="bi bi-tree text-success fs-1 mb-3"></i>
                    <h4>Eco-Friendly</h4>
                    <p class="text-muted">
                        Travel green! Railways are one of the most environmentally friendly modes of transport.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

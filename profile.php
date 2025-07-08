<?php
include 'admin/config/dbcon.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['auth_user']['id'])) {
    header('Location: login.php?error=Please login to view your profile');
    exit();
}

$user_id = $_SESSION['auth_user']['id'];

// Get user details
$stmt = $conn->prepare("SELECT first_name, last_name, email, profile_picture FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$profile_img = 'uploads/profile/' . ($user['profile_picture'] ?? '');
if (!isset($user['profile_picture']) || !$user['profile_picture'] || !file_exists($profile_img)) {
    $profile_img = 'assets/imgs/profile/default-avatar.png';
}

$user_first_name = trim($user['first_name'] ?? '');
$user_last_name = trim($user['last_name'] ?? '');
$user_email = trim($user['email'] ?? '');
$display_name = !empty($user_first_name) ? $user_first_name : 'User';

include 'includes/header.php';
?>

<style>
/* Sidebar styles */
#left-column .block-categories {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.06);
  padding: 1.5rem 1rem;
}
#left-column .block_title {
  font-size: 1.2em;
  font-weight: 600;
  margin-bottom: 1rem;
  color: #2563eb;
  letter-spacing: 0.5px;
}
#left-column .category-top-menu li {
  margin-bottom: 10px;
}
#left-column .category-top-menu a {
  display: flex;
  align-items: center;
  gap: 10px;
  color: #222;
  font-weight: 500;
  border-radius: 8px;
  padding: 8px 12px;
  transition: background 0.2s, color 0.2s;
  text-decoration: none;
}
#left-column .category-top-menu a.active, #left-column .category-top-menu a:hover {
  background: #f0f4ff;
  color: #2563eb;
}
#left-column .category-top-menu i {
  font-size: 1.2em;
}

/* User info card */
.user-info-card {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.06);
  padding: 2rem 1.5rem;
  display: flex;
  align-items: center;
  gap: 1.5rem;
  margin-bottom: 2rem;
}
.user-info-card .profile-pic {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  overflow: hidden;
  background: #f0f0f0;
  flex-shrink: 0;
  box-shadow: 0 1px 4px rgba(0,0,0,0.07);
}
.user-info-card .profile-pic img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 50%;
}
.user-info-card .user-details {
  flex: 1;
}
.user-info-card .user-details .name {
  font-size: 1.3em;
  font-weight: 600;
  margin-bottom: 0.2em;
}
.user-info-card .user-details .email {
  color: #666;
  font-size: 1em;
}

/* Account action links grid */
.links {
  margin-top: 1.5rem;
  display: flex;
  flex-wrap: wrap;
  gap: 1.5rem 0;
}
.links a {
  display: flex;
  align-items: center;
  justify-content: flex-start;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
  padding: 1.2rem 1rem;
  margin: 0 0.75rem 1.5rem 0;
  min-width: 220px;
  color: #222;
  font-weight: 500;
  text-decoration: none;
  transition: box-shadow 0.2s, color 0.2s, background 0.2s;
  position: relative;
}
.links a:hover {
  background: #f0f4ff;
  color: #2563eb;
  box-shadow: 0 4px 16px rgba(37,99,235,0.08);
}
.links .link-item {
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 1.1em;
}
.links .link-item i.material-icons {
  font-size: 2em;
  color: #2563eb;
  background: #e8f0fe;
  border-radius: 50%;
  padding: 0.3em;
  margin-right: 0.5em;
}

@media (max-width: 991px) {
  #columns_inner { flex-direction: column; }
  #left-column { margin-bottom: 2rem; }
  .links { flex-direction: column; gap: 1rem; }
  .links a { min-width: 0; width: 100%; }
  .user-info-card { flex-direction: column; align-items: flex-start; gap: 1rem; }
}
</style>

<nav data-depth="2" class="breadcrumb">
  <div class="container">
    <ol>
      <li><a href="index.php"><span>Home</span></a></li>
      <li><span>Your account</span></li>
    </ol>
  </div>
</nav>
<section id="wrapper">
  <div class="container">
    <div id="columns_inner" class="row">
      <!-- Sidebar -->
      <div id="left-column" class="col-xs-12 col-sm-4 col-md-3">
        <div class="block-categories block mb-4">
          <h4 class="block_title">Account</h4>
          <div class="block_content">
            <ul class="category-top-menu list-unstyled">
              <li><a href="#dashboard" class="profile-link active"><i class="material-icons">dashboard</i> Dashboard</a></li>
              <li><a href="#orders" class="profile-link"><i class="material-icons">shopping_bag</i> Orders</a></li>
              <li><a href="#track" class="profile-link"><i class="material-icons">local_shipping</i> Track Order</a></li>
              <li><a href="#account" class="profile-link"><i class="material-icons">person</i> Account Details</a></li>
            </ul>
          </div>
        </div>
      </div>
      <!-- Main Content -->
      <div id="content-wrapper" class="js-content-wrapper left-column col-xs-12 col-sm-8 col-md-9">
        <section id="main">
          <header class="page-header">
            <h1>Your account</h1>
          </header>
          <section id="content" class="page-content">
            <aside id="notifications"><div class="container"></div></aside>
            <div class="user-info-card mb-4">
              <div class="profile-pic">
                <img src="<?= htmlspecialchars($profile_img) ?>" alt="Profile Picture">
              </div>
              <div class="user-details">
                <div class="name"> <?= htmlspecialchars($user_first_name . ' ' . $user_last_name) ?> </div>
                <div class="email"> <i class="material-icons" style="font-size:1em;vertical-align:middle;">email</i> <?= htmlspecialchars($user_email) ?> </div>
              </div>
            </div>
            <div class="row links">
              <a class="col-lg-4 col-md-6 col-sm-6 col-xs-12" id="identity-link" href="#account">
                <span class="link-item">
                  <i class="material-icons">&#xE853;</i>
                  Information
                </span>
              </a>
              <a class="col-lg-4 col-md-6 col-sm-6 col-xs-12" id="history-link" href="#orders">
                <span class="link-item">
                  <i class="material-icons">&#xE916;</i>
                  Order history and details
                </span>
              </a>
              <a class="col-lg-4 col-md-6 col-sm-6 col-xs-12" id="track-link" href="#track">
                <span class="link-item">
                  <i class="material-icons">local_shipping</i>
                  Track Order
                </span>
              </a>
              <a class="col-lg-4 col-md-6 col-sm-6 col-xs-12" id="addresses-link" href="#addresses">
                <span class="link-item">
                  <i class="material-icons">&#xE56A;</i>
                  Addresses
                </span>
              </a>
              <a class="col-lg-4 col-md-6 col-sm-6 col-xs-12" id="mywishlist-link" href="#wishlist">
                <span class="link-item">
                  <i class="material-icons">&#xE87D;</i>
                  My Wishlist
                </span>
              </a>
            </div>
          </section>
          <footer class="page-footer mt-4">
            <div class="text-sm-center">
              <a href="logout.php">Sign out</a>
            </div>
          </footer>
        </section>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>

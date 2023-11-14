<link href="assets/img/Logo.png" rel="icon">

<?php
session_start();

include 'header.php'; ?>
<div style="margin-top: 80px;">
  <?php
  if (isset($_SESSION['message'])) {
  ?>

    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <strong>Holy!</strong> <?php echo $_SESSION['message']; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php
    unset($_SESSION['message']);
  }
  ?>
</div>

<main id="main">

  <!-- ======= Hero Section ======= -->
  <h2>Product display shop sell</h2>
  <h2>Product display shop sell</h2>
  <h2>Product display shop sell</h2>
  <h2>Product display shop sell</h2>
  <h2>Product display shop sell</h2>
  <h2>Product display shop sell</h2>
  <h2>Product display shop sell</h2>
  <h2>Product display shop sell</h2>
  <h2>Product display shop sell</h2>
  <h2>Product display shop sell</h2>
  <h2>Product display shop sell</h2>



</main><!-- End #main -->
<?php include 'includes/footer.php'; ?>
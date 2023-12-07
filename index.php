<link href="assets/img/Logo.png" rel="icon">

<?php

include 'header.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<?php
if (isset($_SESSION['message'])) {
    $icon = ($_SESSION['messageType'] == 'success') ? 'success' : 'error';
?>
    <script>
        Swal.fire({
            position: 'top-end',
            icon: '<?php echo $icon; ?>',
            title: '<?php echo $_SESSION['message']; ?>',
            showConfirmButton: false,
            timer: 2000,
            toast: true,
            width: 'auto',
            padding: '0.1em',
            background: 'white',
            customClass: {
                popup: 'small-swal'
            }
        });
    </script>
<?php
    unset($_SESSION['message']); // unset the session message after displaying
    unset($_SESSION['messageType']); // unset the session message type after displaying
}
?>

</div>


<
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
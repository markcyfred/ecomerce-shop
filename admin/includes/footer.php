<!-- ======= Footer ======= -->
<footer id="footer" class="footer">

  <div class="credits">
    &copy; Copyright <strong><span>Shop-Sales</span></strong>. All Rights Reserved
    Designed by <a href="https://mywebmark.tech/" target="_blank">MywebMark Technologies</a>
  </div>
</footer><!-- End Footer -->
<style>
  .credits {

    font-size: 15px !important;
  }
</style>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/chart.js/chart.umd.js"></script>
<script src="assets/vendor/echarts/echarts.min.js"></script>
<script src="assets/vendor/quill/quill.min.js"></script>
<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="assets/vendor/tinymce/tinymce.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>



<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

<!-- JavaScript -->
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




</body>

</html>
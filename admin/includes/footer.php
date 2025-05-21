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
<script src="assets/js/sweetalert.js"></script>
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
<style>
     .breadcrumb {
          display: flex;
          justify-content: space-between;
     }

     .drop-zone {
          border: 2px dashed #ccc;
          border-radius: 10px;
          padding: 20px;
          text-align: center;
          cursor: pointer;
          transition: all 0.3s ease-in-out;
          animation: pulse 1.5s infinite;
     }

     .drop-zone:hover {
          border-color: #007bff;
     }

     .drop-zone.dragover {
          background-color: #f0f8ff;
     }

     @keyframes pulse {
          0% {
               box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
          }
          50% {
               box-shadow: 0 0 20px rgba(0, 123, 255, 0.6);
          }
          100% {
               box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
          }
     }
</style>
<script>
  const dropZone = document.getElementById("dropZone");
  const fileInput = document.getElementById("brand_image");

  dropZone.addEventListener("dragover", (e) => {
    e.preventDefault();
    dropZone.classList.add("dragover");
  });

  dropZone.addEventListener("dragleave", () => {
    dropZone.classList.remove("dragover");
  });

  dropZone.addEventListener("drop", (e) => {
    e.preventDefault();
    dropZone.classList.remove("dragover");
    const file = e.dataTransfer.files[0];
    fileInput.files = e.dataTransfer.files;
    dropZone.textContent = file.name;
  });

  dropZone.addEventListener("click", () => {
    fileInput.click();
  });
</script>


</body>

</html>
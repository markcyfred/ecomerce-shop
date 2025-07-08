<?php
include('../middleware/adminMiddleware.php');
include('includes/header.php');
?>
<style>
     .breadcrumb {
          display: flex;
          justify-content: space-between;
     }
</style>
<main id="main" class="main">

     <div class="pagetitle">
          <h1>View Banners</h1>
          <nav>
               <ol class="breadcrumb">
                    <li class="breadcrumb-item">View Banners</li>
                    <a href="add-banner.php" title="Add new Banner">
                         <i class="ri-menu-add-line"></i> Add Banner
                    </a>

                    <li class="breadcrumb-item active">
                         <a href="index.php">
                              <i class="ri-arrow-go-back-fill"></i>
                              Home</a>
                    </li>
               </ol>
          </nav>
     </div><!-- End Page Title -->

     <section class="section">
          <div class="row">
               <div class="col-lg-12">

                    <div class="table-responsive">
                         <table class="table datatable">
                              <thead>
                                   <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Subtitle</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                   $banners = getAll("banners");

                                   if (mysqli_num_rows($banners) > 0) {
                                        foreach ($banners as $item) {
                                   ?>
                                             <tr>
                                                  <th><?= $item['id']; ?></th>
                                                  <td><?= htmlspecialchars($item['title']); ?></td>
                                                  <td><?= htmlspecialchars($item['subtitle']); ?></td>
                                                  <td>Kes<?= number_format($item['price'], 2); ?></td>
                                                  <td>
                                                       <img src="../uploads/banners/<?= $item['image']; ?>" alt="<?= $item['title']; ?>" style="width: 50px; height: 50px;">
                                                  </td>
                                                  <td><?= $item['status'] == 1 ? 'Active' : 'Inactive'; ?></td>
                                                  <td>
                                                       <a href="edit-banner.php?id=<?= $item['id']; ?>" class="text-primary me-2">
                                                            <i class="ri-edit-2-fill fs-4"></i>
                                                       </a>
                                                       <form action="code.php" method="POST" style="display: inline;">
                                                            <input type="hidden" name="banner_id" value="<?= $item['id']; ?>">
                                                            <button type="submit" name="delete_banner_btn" style="border: none; background: none; padding: 0; cursor: pointer;">
                                                                 <i class="bi bi-trash text-danger fs-4"></i>
                                                            </button>
                                                       </form>
                                                  </td>
                                             </tr>
                                   <?php
                                        }
                                   } else {
                                        echo "<tr><td colspan='7'>No banners found</td></tr>";
                                   }
                                   ?>
                              </tbody>
                         </table>
                    </div>

               </div>
          </div>
     </section>

</main><!-- End #main -->
<?php
include('includes/footer.php')
?>
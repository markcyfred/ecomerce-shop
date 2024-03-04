<?php
include 'header.php'; 
include ("functions/userfunctions.php");
?>
<link href="assets/img/Logo.png" rel="icon">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</div>

<style>
    .card {
        display: flex;
        flex-direction: column;
        height: 100%;
        border: 2px dotted green;
    }

    .card img {
        flex: 1;
        object-fit: cover;
        border-radius: 0%;
    }
    .card-title {
        text-align: center;
        font-size: 15px;
        font-weight: bold;
    }
    @media screen and (max-width: 768px)
     {
        .col-md-3 {
            flex: 0 0 50%;
            max-width: 50%;
        }
        
    }
</style>

<main id="main">
   <div id="bread" style="margin-top: 70px;margin-bottom:10px;" class="py-3 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-0"><a href="index.php">Home</a> <span class="mx-2 mb-0">/</span> <strong
                        class="text-black">Categories</strong></div>
            </div>
        </div>
    </div>
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">
    <div class="container">
        <div class="row">
            <?php
            $categories = getAllActive("categories");

            if (mysqli_num_rows($categories) > 0) {
                $counter = 0;
                foreach ($categories as $item) {
                    ?>
                    <div style="width: 140px;" class="col-md-3 mb-2">
                        <a href="products.php?category=<?= $item['slug']; ?>">
                            <div class="card">
                                <img src="uploads/<?= $item['image']; ?>" class="card-img-top" alt="image">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $item['name']; ?></h5>
                                    <!-- You can add more information here if needed -->
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php 
                    $counter++;
                    if ($counter % 8 == 0) {
                        echo '</div><div class="row">';
                    }
                }
            } else {
                echo "No data available";  // Added semicolon here
            }
            ?>
        </div>
    </div>
</section><!-- End Hero -->

    <!-- ======= Products Section ======= -->

</main><!-- End #main -->
<?php include 'includes/footer.php'; ?>

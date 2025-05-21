<?php
include('../middleware/adminMiddleware.php');
include('includes/header.php');

$maxTags = 10;

// Function to renumber tag descriptions sequentially (no gaps)
function renumberTagDescriptions($conn) {
    $result = mysqli_query($conn, "SELECT id FROM tags ORDER BY id ASC");
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $desc = "#{$count} eco";
        mysqli_query($conn, "UPDATE tags SET description = '{$desc}' WHERE id = {$id}");
        $count++;
    }
}

// Handle sync_tags action - auto insert new tags from products
if (isset($_POST['sync_tags'])) {
    // Step 1: Get existing tags from DB
    $existingTags = [];
    $existingResult = mysqli_query($conn, "SELECT tag_name FROM tags");
    while ($row = mysqli_fetch_assoc($existingResult)) {
        $existingTags[] = trim($row['tag_name']);
    }
    $totalExisting = count($existingTags);

    // Step 2: Fetch distinct featured tags from products, excluding already existing tags
    $featuredTags = [];
    $query = "SELECT DISTINCT featured FROM products WHERE featured IS NOT NULL AND featured != ''";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $tag = trim($row['featured']);
        if (!in_array($tag, $existingTags)) {
            $featuredTags[] = $tag;
        }
    }

    // Step 3: Calculate remaining slots
    $remainingSlots = $maxTags - $totalExisting;

    if ($remainingSlots <= 0) {
        // Max tags reached, no more can be added
        $_SESSION['message'] = "Maximum tags reached ($maxTags). Delete some before syncing new ones.";
        $_SESSION['messageType'] = "error";
    } elseif (count($featuredTags) <= $remainingSlots) {
        // Insert all new tags directly (no truncate)
        $inserted = 0;
        foreach ($featuredTags as $tag) {
            $safeTag = mysqli_real_escape_string($conn, $tag);
            $insertQuery = "INSERT INTO tags (tag_name) VALUES ('$safeTag')";
            if (mysqli_query($conn, $insertQuery)) {
                $inserted++;
            }
        }
        // Renumber descriptions after all inserts
        renumberTagDescriptions($conn);

        $_SESSION['message'] = "Synced $inserted new tag(s) successfully.";
        $_SESSION['messageType'] = "success";
    } else {
        // Too many new tags, ask user to select
        $_SESSION['select_tags'] = true;
        $_SESSION['new_tags'] = $featuredTags;
        $_SESSION['remaining_slots'] = $remainingSlots;

        $_SESSION['message'] = "Too many new tags. Select up to $remainingSlots tag(s) to sync.";
        $_SESSION['messageType'] = "warning";
    }
}

// Confirm user-selected tags (after form submission)
if (isset($_POST['confirm_sync']) && isset($_POST['tags'])) {
    $selectedTags = $_POST['tags'];
    $inserted = 0;

    foreach ($selectedTags as $tag) {
        $safeTag = mysqli_real_escape_string($conn, $tag);

        // Insert only if not exists
        $checkQuery = "SELECT id FROM tags WHERE tag_name = '$safeTag' LIMIT 1";
        $checkResult = mysqli_query($conn, $checkQuery);
        if (mysqli_num_rows($checkResult) === 0) {
            $insertQuery = "INSERT INTO tags (tag_name) VALUES ('$safeTag')";
            if (mysqli_query($conn, $insertQuery)) {
                $inserted++;
            }
        }
    }

    // Renumber descriptions after inserts
    renumberTagDescriptions($conn);

    // Clear selection session variables
    unset($_SESSION['select_tags'], $_SESSION['new_tags'], $_SESSION['remaining_slots']);

    $_SESSION['message'] = "$inserted selected tag(s) synced successfully.";
    $_SESSION['messageType'] = "success";
}

// Optional: Delete tag handler with renumbering
if (isset($_GET['delete_tag_id'])) {
    $deleteId = intval($_GET['delete_tag_id']);
    $deleteQuery = "DELETE FROM tags WHERE id = $deleteId";
    if (mysqli_query($conn, $deleteQuery)) {
        // Renumber after deletion
        renumberTagDescriptions($conn);
        $_SESSION['message'] = "Tag deleted and descriptions renumbered successfully.";
        $_SESSION['messageType'] = "success";
    } else {
        $_SESSION['message'] = "Failed to delete tag.";
        $_SESSION['messageType'] = "error";
    }
    // Redirect to prevent resubmission on refresh
    header("Location: tags.php");
    exit();
}

?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Sync Featured Tags</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Sync Tags</li>
            </ol>
        </nav>
    </div>

    <?php if (isset($_SESSION['manage_tags_link'])): ?>
        <div class="alert alert-warning mt-3">
            <a href="featured-tags-manage.php" class="btn btn-warning">Manage Tags</a>
        </div>
        <?php unset($_SESSION['manage_tags_link']); ?>
    <?php endif; ?>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sync Featured Tags</h5>
                        <p class="card-text">Sync unique product-featured tags to your tags database.</p>

                        <?php if (isset($_SESSION['select_tags']) && $_SESSION['select_tags'] === true): ?>
                            <form method="POST">
                                <p>Select up to <?php echo $_SESSION['remaining_slots']; ?> tags:</p>
                                <?php foreach ($_SESSION['new_tags'] as $tag): ?>
                                    <div>
                                        <input type="checkbox" name="tags[]" value="<?php echo htmlspecialchars($tag); ?>" />
                                        <label><?php echo htmlspecialchars($tag); ?></label>
                                    </div>
                                <?php endforeach; ?>
                                <button type="submit" name="confirm_sync" class="btn btn-primary mt-3">Sync Selected Tags</button>
                            </form>
                        <?php else: ?>
                            <form method="POST">
                                <button type="submit" name="sync_tags" class="btn btn-primary">Sync Tags</button>
                            </form>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </section> 
</main>

<!-- SweetAlert2 JS -->
<?php if (isset($_SESSION['message'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: '<?php 
                $icons = ['success' => 'success', 'error' => 'error', 'warning' => 'warning', 'info' => 'info'];
                echo $icons[$_SESSION['messageType']] ?? 'info'; 
            ?>',
            title: '<?php echo addslashes($_SESSION['message']); ?>',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true
        });
    });
</script>
<?php unset($_SESSION['message'], $_SESSION['messageType']); endif; ?>

<?php if (isset($_SESSION['select_tags']) && isset($_SESSION['remaining_slots'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const maxSelection = <?php echo (int)$_SESSION['remaining_slots']; ?>;
        const checkboxes = document.querySelectorAll('input[name="tags[]"]');

        checkboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                const checked = document.querySelectorAll('input[name="tags[]"]:checked').length;
                if (checked > maxSelection) {
                    cb.checked = false;
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'warning',
                        title: `You can select up to ${maxSelection} tags only.`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            });
        });
    });
</script>
<?php endif; ?>

<?php include('includes/footer.php'); ?>

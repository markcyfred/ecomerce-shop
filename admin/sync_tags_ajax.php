<?php
include('admin/config/dbcon.php'); // Include your database connection
include('../middleware/adminMiddleware.php');
header('Content-Type: application/json');

if (!isset($_POST['confirm_sync'])) {
    // Your existing sync_tags logic here but adjusted for AJAX:

    // Fetch existing tags
    $existingTags = [];
    $existingResult = mysqli_query($conn, "SELECT id, tag_name FROM tags");
    $existingTagMap = [];
    while ($row = mysqli_fetch_assoc($existingResult)) {
        $tagName = trim($row['tag_name']);
        $existingTags[] = $tagName;
        $existingTagMap[$tagName] = $row['id'];
    }
    sort($existingTags);

    // Fetch distinct featured tags from products
    $featuredTags = [];
    $query = "SELECT DISTINCT featured FROM products WHERE featured IS NOT NULL AND featured != ''";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $featuredTags[] = trim($row['featured']);
    }
    sort($featuredTags);

    // Determine tags to add and delete
    $tagsToAdd = array_diff($featuredTags, $existingTags);
    $tagsToDelete = array_diff($existingTags, $featuredTags);

    $totalExisting = count($existingTags);
    $totalNew = count($tagsToAdd);
    $maxTags = 10;

    // Delete tags not in featuredTags
    foreach ($tagsToDelete as $tag) {
        $safeTag = mysqli_real_escape_string($conn, $tag);
        mysqli_query($conn, "DELETE FROM tags WHERE tag_name = '$safeTag'");
    }

    $totalRemaining = $totalExisting - count($tagsToDelete);

    if ($totalRemaining >= $maxTags) {
        echo json_encode([
            'status' => 'error',
            'message' => "Cannot sync tags. You already have $totalRemaining tags (max $maxTags). Please delete some to continue."
        ]);
        exit;
    } elseif (($totalRemaining + count($tagsToAdd)) <= $maxTags) {
        $inserted = 0;
        foreach ($tagsToAdd as $tag) {
            $safeTag = mysqli_real_escape_string($conn, $tag);
            $insertQuery = "INSERT INTO tags (tag_name) VALUES ('$safeTag')";
            if (mysqli_query($conn, $insertQuery)) {
                $id = mysqli_insert_id($conn);
                $desc = "#{$id} eco";
                mysqli_query($conn, "UPDATE tags SET description = '$desc' WHERE id = $id");
                $inserted++;
            }
        }
        echo json_encode([
            'status' => 'success',
            'message' => "Synced: $inserted new tags added, " . count($tagsToDelete) . " deleted."
        ]);
        exit;
    } else {
        echo json_encode([
            'status' => 'warning',
            'message' => "Too many tags to sync. Please manually select tags in the admin panel."
        ]);
        exit;
    }
} else {
    echo json_encode([
        'status' => 'info',
        'message' => 'Confirm sync via form.'
    ]);
}

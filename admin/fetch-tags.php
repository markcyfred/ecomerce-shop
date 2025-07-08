<?php
require '../admin/config/dbcon.php';

$query = "SELECT * FROM tags 
          ORDER BY 
            CASE WHEN order_num IS NULL OR order_num = 0 THEN 1 ELSE 0 END,
            order_num ASC";

$tags = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($tags)) {
    ?>
    <li class="list-group-item d-flex justify-content-between align-items-center" data-id="<?= $row['id']; ?>">
        <?= htmlspecialchars($row['tag_name']); ?>
        <span class="badge bg-primary"><?= htmlspecialchars($row['description']); ?></span>
        <small class="text-muted ms-2">(Order: <?= htmlspecialchars($row['order_num']); ?>)</small>
    </li>
    <?php
}
?>

<?php

require '../admin/config/dbcon.php';

// Handle AJAX request to reorder tags (POST JSON)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
    header('Content-Type: application/json');

    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (!isset($data['ids']) || !is_array($data['ids'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid or missing "ids" array']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE tags SET order_num = ?, description = ? WHERE id = ?");
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to prepare SQL statement']);
        exit;
    }

    $conn->begin_transaction();

    try {
        foreach ($data['ids'] as $index => $id) {
            $order = $index + 1;
            $desc = "#{$order} eco";
            $stmt->bind_param("isi", $order, $desc, $id);
            if (!$stmt->execute()) {
                throw new Exception("Execution failed for ID $id");
            }
        }
        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'tags sequenced successfully']);
    } catch (Exception $e) {
        $conn->rollback();
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    $stmt->close();
    $conn->close();
    exit;
}

// Initial load: fetch tags ordered by order_num for display
$query = "SELECT * FROM tags ORDER BY order_num ASC";
$tags = mysqli_query($conn, $query);
include('../middleware/adminMiddleware.php');
include('includes/header.php');
?>

<!-- Include Sortable CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.css">

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- SortableJS CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Manage Tag Order</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Reorder Tags</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-8">
                <div class="card p-3">
                    <h5>Drag and drop tags to reorder them</h5>
                    <ul id="tagList" class="list-group sortable">
                        <?php while ($row = mysqli_fetch_assoc($tags)) : ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center" data-id="<?= $row['id']; ?>">
                                <?= htmlspecialchars($row['tag_name']); ?>
                                <span class="badge bg-primary"><?= htmlspecialchars($row['description']); ?></span>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                    <div class="mt-3">
                        <button class="btn btn-success" id="saveOrderBtn">Save Order</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    const tagList = document.getElementById('tagList');
    const sortable = new Sortable(tagList, {
        animation: 150,
    });

    document.getElementById('saveOrderBtn').addEventListener('click', function () {
        const ids = [...tagList.children].map(item => item.dataset.id);

        fetch(window.location.href, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ ids })
        })
        .then(async res => {
            const contentType = res.headers.get("content-type");
            if (contentType && contentType.includes("application/json")) {
                return res.json();
            } else {
                const text = await res.text();
                throw new Error("Unexpected response:\n" + text);
            }
        })
        .then(data => {
            if (data.success) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: data.message,
                    showConfirmButton: false,
                    timer: 2000
                });
                // Reload tag list without refreshing page
                reloadTags();
            } else {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: data.message,
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        })
        .catch(error => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Unexpected error',
                text: error.message,
                showConfirmButton: false,
                timer: 3000
            });
        });
    });

    // Function to reload the tag list via AJAX
    function reloadTags() {
        fetch('fetch-tags.php')
        .then(res => res.text())
        .then(html => {
            tagList.innerHTML = html;
        });
    }
</script>

<?php include('includes/footer.php'); ?>
  
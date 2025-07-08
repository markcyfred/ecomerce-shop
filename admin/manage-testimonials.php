<?php
include('../middleware/adminMiddleware.php');
include('includes/header.php');

// Database connection: assume $conn is already defined in a common include
// For example, if you have a db_connect.php, you could require it here.
// But since you mentioned “Database connection assumed as $conn,” 
// I’m leaving that part out so it continues to work with your existing setup.
?>

<style>
    /* Basic modal styles */
    #modalOverlay {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        justify-content: center;
        align-items: center;
    }

    #modalContent {
        background: white;
        padding: 20px;
        max-width: 600px;
        width: 90%;
        border-radius: 8px;
        position: relative;
    }

    #modalContent img {
        max-width: 100%;
        border-radius: 5px;
        margin-top: 10px;
    }

    #modalClose {
        position: absolute;
        top: 10px;
        right: 15px;
        cursor: pointer;
        font-size: 20px;
        font-weight: bold;
    }

    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin: 5px;
    }

    .btn-approve {
        background-color: #28a745;
        color: white;
    }

    .btn-decline {
        background-color: #dc3545;
        color: white;
    }
</style>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>View Feedbacks</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Feedbacks</li>
                <a href="add-feedback.php" title="Add Feedback">
                    <i class="ri-menu-add-line"></i> Add Feedback
                </a>
                <li class="breadcrumb-item active">
                    <a href="index.php">
                        <i class="ri-arrow-go-back-fill"></i> Home
                    </a>
                </li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">All Feedbacks</h5>
                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Title</th>
                                        <th>Feedback (truncated)</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // 1. Select from `feedback` (not `feedbacks`)
                                    $query = "SELECT * FROM feedback ORDER BY created_at DESC";
                                    $result = mysqli_query($conn, $query);

                                    if ($result && mysqli_num_rows($result) > 0):
                                        while ($item = mysqli_fetch_assoc($result)):
                                    ?>
                                            <tr>
                                                <td><?= $item['id']; ?></td>
                                                <td><?= htmlspecialchars($item['name']); ?></td>
                                                <td><?= htmlspecialchars($item['title']); ?></td>
                                                <td>
                                                    <?php
                                                    // Truncate to 40 characters in the table view
                                                    $short = substr($item['feedback'], 0, 40);
                                                    if (strlen($item['feedback']) > 40) {
                                                        $short .= '…';
                                                    }
                                                    echo htmlspecialchars($short);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($item['image'])): ?>
                                                        <!-- 2. Point to uploads/feedback/ rather than uploads/feedbacks/ -->
                                                        <img src="../uploads/feedback/<?= htmlspecialchars($item['image']); ?>"
                                                             width="80"
                                                             height="80"
                                                             style="border-radius: 5px; border: 1px solid #ccc;"
                                                             alt="Feedback Image">
                                                    <?php else: ?>
                                                        No Image
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    // 3. Status badges (0 = pending, 1 = approved, else assume “declined”)
                                                    if ($item['status'] == 1): ?>
                                                        <span class="badge bg-success">Approved</span>
                                                    <?php elseif ($item['status'] == 0): ?>
                                                        <span class="badge bg-warning">Waiting Approval</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Declined</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <!-- 4. The “View” button carries data‐attributes for the modal -->
                                                    <button class="btn btn-view"
                                                        data-id="<?= $item['id']; ?>"
                                                        data-name="<?= htmlspecialchars($item['name'], ENT_QUOTES); ?>"
                                                        data-title="<?= htmlspecialchars($item['title'], ENT_QUOTES); ?>"
                                                        data-feedback="<?= htmlspecialchars($item['feedback'], ENT_QUOTES); ?>"
                                                        data-image="<?= !empty($item['image']) 
                                                            ? '../uploads/feedback/' . htmlspecialchars($item['image'], ENT_QUOTES) 
                                                            : ''; ?>"
                                                        data-status="<?= $item['status']; ?>">
                                                        View
                                                    </button>
                                                </td>
                                            </tr>
                                    <?php
                                        endwhile;
                                    else:
                                        echo '<tr><td colspan="7">No feedbacks found</td></tr>';
                                    endif;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Modal Overlay + Content -->
<div id="modalOverlay">
    <div id="modalContent">
        <span id="modalClose">&times;</span>
        <h3 id="modalTitle"></h3>
        <p><strong>Name:</strong> <span id="modalName"></span></p>
        <p id="modalFeedback"></p>
        <img id="modalImage" src="" alt="Feedback Image" style="display: none;">

        <div style="margin-top: 15px;">
            <!-- Approve -->
            <form id="approveForm" action="code.php" method="POST" style="display:inline;">
                <input type="hidden" name="feedback_id" id="approveFeedbackId" value="">
                <button type="submit" name="approve_feedback_btn" class="btn btn-approve">
                    Approve
                </button>
            </form>

            <!-- Decline -->
            <form id="declineForm" action="code.php" method="POST" style="display:inline;">
                <input type="hidden" name="feedback_id" id="declineFeedbackId" value="">
                <button type="submit" name="decline_feedback_btn" class="btn btn-decline">
                    Decline
                </button>
            </form>

            <!-- Delete -->
            <form id="deleteForm" action="code.php" method="POST" style="display:inline; margin-left: 5px;">
                <input type="hidden" name="feedback_id" id="deleteFeedbackId" value="">
                <button type="submit"
                        name="delete_feedback_btn"
                        onclick="return confirm('Delete this feedback?')"
                        class="btn btn-decline">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Modal elements
    const modalOverlay   = document.getElementById('modalOverlay');
    const modalClose     = document.getElementById('modalClose');
    const modalTitle     = document.getElementById('modalTitle');
    const modalName      = document.getElementById('modalName');
    const modalFeedback  = document.getElementById('modalFeedback');
    const modalImage     = document.getElementById('modalImage');
    const approveFeedbackId = document.getElementById('approveFeedbackId');
    const declineFeedbackId = document.getElementById('declineFeedbackId');
    const deleteFeedbackId  = document.getElementById('deleteFeedbackId');

    // Show the modal with data from the clicked “View” button
    function showModal(data) {
        modalTitle.textContent = data.title || 'No Title';
        modalName.textContent  = data.name || 'Anonymous';
        modalFeedback.textContent = data.feedback || '';

        if (data.image) {
            modalImage.src = data.image;
            modalImage.style.display = 'block';
        } else {
            modalImage.style.display = 'none';
        }

        // Fill hidden inputs in the approve/decline/delete forms
        approveFeedbackId.value = data.id;
        declineFeedbackId.value = data.id;
        deleteFeedbackId.value  = data.id;

        modalOverlay.style.display = 'flex';
    }

    // Close modal on click “×” or on clicking outside the content
    modalClose.onclick = () => modalOverlay.style.display = 'none';
    modalOverlay.onclick = e => {
        if (e.target === modalOverlay) {
            modalOverlay.style.display = 'none';
        }
    };

    // Event delegation: listen for clicks on “View” buttons in the table body
    document.querySelector('table.datatable tbody')
        .addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('btn-view')) {
                const button = e.target;
                const data = {
                    id:       button.getAttribute('data-id'),
                    name:     button.getAttribute('data-name'),
                    title:    button.getAttribute('data-title'),
                    feedback: button.getAttribute('data-feedback'),
                    image:    button.getAttribute('data-image')
                };
                showModal(data);
            }
        });
</script>
<style>
     /* =========================
   Overlay and Modal Box
   ========================= */
#modalOverlay {
    display: none;
    position: fixed;
    z-index: 10000;
    inset: 0; /* shorthand for top:0; right:0; bottom:0; left:0; */
    background-color: rgba(0, 0, 0, 0.6);
    justify-content: center;
    align-items: center;
    animation: fadeIn 0.2s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to   { opacity: 1; }
}

#modalContent {
    background-color: #ffffff;
    border-radius: 0.5rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    max-width: 600px;
    width: 90%;
    max-height: 80vh; /* <-- add max height */
    overflow-y: auto;  /* <-- allow vertical scroll */
    padding: 1.5rem;
    position: relative;
    transform: translateY(-10px);
    animation: slideDown 0.2s ease-out forwards;
}


@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* =========================
   Close “×” Button
   ========================= */
#modalClose {
    position: absolute;
    top: 0.75rem;   /* 12px */
    right: 0.75rem; /* 12px */
    font-size: 1.25rem; /* 20px */
    font-weight: 700;
    color: #555;
    cursor: pointer;
    transition: color 0.2s ease;
}

#modalClose:hover {
    color: #000;
}

/* =========================
   Modal Content (Text + Image)
   ========================= */
#modalContent h3 {
    margin-bottom: 0.75rem; /* 12px */
    font-size: 1.5rem;      /* 24px */
    color: #333;
}

#modalContent p {
    margin: 0.5rem 0;
    line-height: 1.6;
    color: #444;
}

#modalContent img {
    display: block;
    max-width: 100%;
    margin: 1rem 0;
    border-radius: 0.25rem; /* 4px */
    border: 1px solid #ddd;
}

/* =========================
   Action Buttons (Approve, Decline, Delete)
   ========================= */
.btn {
    display: inline-block;
    padding: 0.5rem 1rem; /* 8px 16px */
    border: none;
    border-radius: 0.25rem; /* 4px */
    font-size: 0.875rem;    /* 14px */
    font-weight: 600;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    transition: background-color 0.2s ease, transform 0.1s ease;
    margin: 0.25rem; /* 4px */
}

/* Approve (green) */
.btn-approve {
    background-color: #28a745;
    color: #fff;
}

.btn-approve:hover {
    background-color: #218838;
    transform: translateY(-1px);
}

/* Decline/Delete (red) */
.btn-decline {
    background-color: #dc3545;
    color: #fff;
}

.btn-decline:hover {
    background-color: #c82333;
    transform: translateY(-1px);
}

/* Keep forms inline */
#approveForm,
#declineForm,
#deleteForm {
    display: inline-block;
}

/* =========================
   Utility / Responsive
   ========================= */
@media (max-width: 576px) {
    #modalContent {
        padding: 1rem; /* 16px */
    }
    #modalContent h3 {
        font-size: 1.25rem; /* 20px */
    }
    .btn {
        font-size: 0.75rem; /* 12px */
        padding: 0.4rem 0.8rem; /* 6.4px 12.8px */
    }
}

</style>

<?php include('includes/footer.php'); ?>

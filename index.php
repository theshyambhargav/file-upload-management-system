<?php
include "config/db.php";
include "includes/header.php";

$message = "";

if (isset($_GET['success'])) {
    $message = "<div class='alert alert-success alert-custom'>File uploaded successfully.</div>";
}

if (isset($_GET['deleted'])) {
    $message = "<div class='alert alert-danger alert-custom'>File deleted successfully.</div>";
}

$files = mysqli_query($conn, "SELECT * FROM files ORDER BY uploaded_at DESC");
?>

<h3 class="mb-4">Upload File</h3>

<?php echo $message; ?>

<div class="card shadow-sm mb-4">
    <div class="card-body">

        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <input type="file" name="file" class="form-control" required>
                <small class="text-muted">Allowed: PDF, JPG, PNG, DOC, DOCX (Max 5MB)</small>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>

    </div>
</div>

<h3 class="mb-3">Uploaded Files</h3>

<div class="card shadow-sm">
    <div class="card-body table-responsive">

        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Size</th>
                    <th>Type</th>
                    <th>Uploaded</th>
                    <th width="160">Action</th>
                </tr>
            </thead>

            <tbody>
            <?php while ($row = mysqli_fetch_assoc($files)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['original_name']); ?></td>
                    <td><?php echo round($row['file_size']/1024,2); ?> KB</td>
                    <td><?php echo $row['file_type']; ?></td>
                    <td><?php echo $row['uploaded_at']; ?></td>
                    <td>
                        <a href="uploads/<?php echo $row['stored_name']; ?>" 
                           class="btn btn-success btn-sm" download>
                           Download
                        </a>

                        <a href="delete.php?id=<?php echo $row['id']; ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure?')">
                           Delete
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

    </div>
</div>

<?php include "includes/footer.php"; ?>
<?php require_once(ROOT . '/views/layouts/header.php'); ?>

    <div class="container">
        <div class="row">
            <p>Are you sure you want to delete film «<?php echo htmlspecialchars($filmData['title']) ?>
                »?</p>
            <form action="/film/delete/<?php echo $filmData['id']; ?>" method="post">
                <a href="/" type="button" class="btn btn-dark">No</a>
                <button type="submit" name="submit" class="btn btn-danger">Delete
                </button>
            </form>
        </div>
    </div>

<?php require_once(ROOT . '/views/layouts/footer.php'); ?>
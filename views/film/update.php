<?php require_once(ROOT . '/views/layouts/header.php'); ?>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Edit film «<?php echo $filmData['title']; ?>»</h3>
                <form action="#" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" id="title"
                               placeholder="Input film title"
                               value="<?php echo $filmData['title']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="release_year" class="form-label">Release year</label>
                        <input type="text" name="release_year" class="form-control" id="release_year"
                               placeholder="Input film release year"
                               value="<?php echo $filmData['release_year']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="format" class="form-label">Format</label>
                        <input type="text" name="format" class="form-control" id="format"
                               placeholder="Input film format" value="<?php echo $filmData['format']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="stars_list" class="form-label">Изображение книги</label>
                        <input type="text" name="stars_list" class="form-control" id="stars_list"
                               placeholder="Input film stars" value="<?php echo $filmData['stars_list']; ?>">
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary mb-3" value="Update data">
                </form>
            </div>
        </div>
    </div>

<?php require_once(ROOT . '/views/layouts/footer.php'); ?>
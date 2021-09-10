<?php require_once(ROOT . '/views/layouts/header.php'); ?>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Create new film</h3>
                <form action="#" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" id="title"
                               placeholder="Input film title">
                    </div>
                    <div class="mb-3">
                        <label for="release_year" class="form-label">Release year</label>
                        <input type="text" name="release_year" class="form-control" id="release_year"
                               placeholder="Input film release year">
                    </div>
                    <div class="mb-3">
                        <label for="format" class="form-label">Format</label>
                        <input type="text" name="format" class="form-control" id="format"
                               placeholder="Input film format">
                    </div>
                    <div class="mb-3">
                        <label for="stars_list" class="form-label">Изображение книги</label>
                        <input type="text" name="stars_list" class="form-control" id="stars_list" placeholder="Input film stars">
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary mb-3" value="Create film">
                </form>
            </div>
        </div>
    </div>
<?php require_once(ROOT . '/views/layouts/footer.php'); ?>
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
                               value="<?php if (isset($_POST['title'])) echo $_POST['title'];
                               else echo $filmData['title']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="release_year" class="form-label">Release year</label>
                        <input type="text" name="release_year" class="form-control" id="release_year"
                               placeholder="Input film release year"
                               value="<?php if (isset($_POST['release_year'])) echo $_POST['release_year'];
                               else echo $filmData['release_year']; ?>">
                    </div>
                    <div class="mb-3">
                        <select name="format" class="form-select">
                            <option disabled>Select film format</option>
                            <?php foreach ($formatsList as $format): ?>
                                <option value="<?php echo $format ?>"
                                    <?php
                                    if (isset($_POST['format']) && $format == $_POST['format']) {
                                        echo 'selected="selected"';
                                    }
                                    ?>>
                                    <?php echo $format; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="stars_list" class="form-label">Stars list</label>
                        <input type="text" name="stars_list" class="form-control" id="stars_list"
                               placeholder="Input film stars"
                               value="<?php if (isset($_POST['stars_list'])) echo $_POST['stars_list'];
                               else echo $filmData['stars_list']; ?>">
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary mb-3" value="Update data">
                </form>
                <?php
                if (isset($errors)) {
                    foreach ($errors as $error) {
                        echo '<p class="alert-danger">' . $error . '</p>';
                    }
                }
                ?>
            </div>
        </div>
    </div>

<?php require_once(ROOT . '/views/layouts/footer.php'); ?>
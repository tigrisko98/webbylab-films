<?php require_once(ROOT . '/views/layouts/header.php'); ?>

    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="card" style="width: 36rem;">
                    <div class="card-body">
                        <h4><?php echo $filmData['title']; ?></h4>
                        <p class="card-text">Release year: <?php echo $filmData['release_year']; ?></p>
                        <p class="card-text">Format: <?php echo $filmData['format']; ?></p>
                        <p class="card-text">Stars: <?php echo $filmData['stars_list']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php require_once(ROOT . '/views/layouts/footer.php'); ?>
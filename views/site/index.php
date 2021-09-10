<?php require_once(ROOT . '/views/layouts/header.php'); ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <a href="#" data-bs-toggle="modal" data-bs-target="#uploadFilmsModal">
                Import films
            </a>
            <?php if (!empty($filmsList)): ?>
                <table class="table">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Release year</th>
                        <th scope="col">Format</th>
                        <th scope="col">Stars</th>
                        <th scope="col"></th>
                    </tr>
                    <?php foreach ($filmsList as $film): ?>
                        <tr>
                            <td><?php echo $film['id']; ?></td>
                            <td><?php echo $film['title']; ?></td>
                            <td><?php echo $film['release_year']; ?></td>
                            <td><?php echo $film['format']; ?></td>
                            <td><?php echo $film['stars_list']; ?></td>
                            <!-- <td><a href="/film/update/<?php echo $film['id']; ?>"
                                   class="btn btn-primary">Редактировать</a>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Удалить</button>
                            </td> -->
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>
                    Films have not been added yet.
                </p>
            <?php endif; ?>

            <div class="modal fade" id="uploadFilmsModal" tabindex="-1" aria-labelledby="uploadFilmsModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadFilmsModalLabel">Import films</h5><br>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <br>
                        </div>
                        <div class="modal-body">
                            <h6 id="uploadFilmsModalLabel">You can import films from .txt file.</h6>
                            <form action="#" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="text" class="form-label">Upload file</label>
                                    <input type="file" name="text" class="form-control" id="text" placeholder=""
                                           value="">
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-primary">Upload</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once(ROOT . '/views/layouts/footer.php'); ?>

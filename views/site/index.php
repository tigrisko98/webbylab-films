<?php require_once(ROOT . '/views/layouts/header.php'); ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <form class="row g-lg-3" action="#" method="post">
                <div class="col-auto">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" id="title"
                           placeholder="Input film title" value="<?php if (isset($_POST['title'])) {
                        echo $_POST['title'];
                    } ?>">
                </div>
                <div class="col-auto">
                    <label for="stars_list" class="form-label">Stars</label>
                    <input type="text" name="stars_list" class="form-control" id="stars_list"
                           placeholder="Input film stars" value="<?php if (isset($_POST['stars_list'])) {
                        echo $_POST['stars_list'];
                    } ?>">
                </div>
                <div class="col-auto">
                    <label for="sort_field" class="form-label">Sort by</label>
                    <select class="form-select" name="sort_field" id="sort_field">
                        <option selected disabled>--Select field to sort--</option>
                        <option value="id"
                            <?php if (isset($_POST['sort_field']) && $_POST['sort_field'] == "id") echo 'selected="selected"'; ?>>
                            ID
                        </option>
                        <option value="title"
                            <?php if (isset($_POST['sort_field']) && $_POST['sort_field'] == "title") echo 'selected="selected"'; ?>>
                            Title
                        </option>
                        <option value="release_year"
                            <?php if (isset($_POST['sort_field']) && $_POST['sort_field'] == "release_year") echo 'selected="selected"'; ?>>
                            Release year
                        </option>
                        <option value="stars_list"
                            <?php if (isset($_POST['sort_field']) && $_POST['sort_field'] == "stars_list") echo 'selected="selected"'; ?>>
                            Stars
                        </option>
                    </select>
                </div>
                <div class="col-auto">
                    <label for="direction" class="form-label">Direction</label>
                    <select class="form-select" name="direction">
                        <option selected disabled>--Select sort direction--</option>
                        <option value="ASC"
                            <?php if (isset($_POST['direction']) && $_POST['direction'] == "ASC") echo 'selected="selected"'; ?>>
                            A-Z
                        </option>
                        <option value="DESC"
                            <?php if (isset($_POST['direction']) && $_POST['direction'] == "DESC") echo 'selected="selected"'; ?>>
                            Z-A
                        </option>
                    </select>
                </div>
                <div class="col-auto">
                    <label for="submit_filters_and_sort" class="form-label" style="visibility: hidden">Submit</label>
                    <button type="submit" name="submit_filters_and_sort" class="form-control btn btn-primary">Search</button>
                </div>
            </form>
            <?php if (!empty($filmsList)): ?>
                <table class="table">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Release year</th>
                        <th scope="col">Format</th>
                        <th scope="col">Stars</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    <?php foreach ($filmsList as $film): ?>
                        <tr>
                            <td><?php echo $film['id']; ?></td>
                            <td><a href="/film/<?php echo $film['id']; ?>"><?php echo $film['title']; ?></a></td>
                            <td><?php echo $film['release_year']; ?></td>
                            <td><?php echo $film['format']; ?></td>
                            <td><?php echo $film['stars_list']; ?></td>
                            <td><a href="/film/update/<?php echo $film['id']; ?>"
                                   class="btn btn-primary">Update</a>
                            </td>
                            <td>
                                <a href="/film/delete/<?php echo $film['id']; ?>" type="button" class="btn btn-danger">Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>
                    No data to display.
                </p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once(ROOT . '/views/layouts/footer.php'); ?>

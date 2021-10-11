<?php require_once(ROOT . '/views/layouts/header.php'); ?>
<?php if(isset($_POST['submit']) && empty($errors)):?>
    <div class="alert alert-success" role="alert">
        Films has been successfully imported.
    </div>
<?php endif;?>

    <script type="text/javascript">
        function removeDisabledAttr(){
            $('input:submit').removeAttr('disabled');
        }
    </script>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Import films</h3>
                <h6>You can import .txt, .doc, .docx and .csv files!</h6>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="file" class="form-label">Import file</label>
                        <input type="file" name="file" class="form-control" id="file" placeholder="" onchange="removeDisabledAttr()">
                    </div>
                    <input type="submit" name="submit" id="submit" class="btn btn-primary mb-3" value="Import films" disabled>
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
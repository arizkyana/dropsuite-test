<?php
include "functions.php";
?>

<?php
    $base_url = $_SERVER['HTTP_HOST'] . "/dropsuite";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Test</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="text-center">
                <h1>Count Files</h1>
            </div>
            <form name="form" method="POST" action="index.php">
                <div class="input-group">
                    <input type="text" name="path" class="form-control input-lg"/>
                    <span class="input-group-btn">
							<button class="btn btn-primary btn-lg">Count</button>
						</span>
                </div>
            </form>
            <table class="table table-responsive table-condensed table-striped table-hover">
                <thead>
                <tr>
                    <th>Content</th>
                    <th>File's Counted</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($result)) : ?>
                    <tr>
                        <td><?php echo $result->content_item; ?></td>
                        <td><?php echo $result->count; ?></td>
                    </tr>
                <?php else : ?>
                    <tr>
                        <td colspan="2">No Information Available</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script
        src="http://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
        crossorigin="anonymous"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
</body>
</html>
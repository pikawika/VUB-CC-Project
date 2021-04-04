<?php
include 'layout/header.php';

//this is a dummy key for local instances
$key = "dummykey";


if ($_GET["key"] == $key) {
    include 'db/db_actions.php';

    //db_actions file function
    delete_tables();

    //db_actions file function
    create_tables();

    //write test images to db
    foreach (glob('images/test/*.*') as $path) {
        $filename = pathinfo($path, PATHINFO_FILENAME);
        $practice_data = 1;
        //db_actions file function
        create_image_record($filename, $path, $practice_data);
    }

    //write evaluation images to db
    foreach (glob('images/evaluation/*.*') as $path) {
        $filename = pathinfo($path, PATHINFO_FILENAME);
        $practice_data = 0;
        create_image_record($filename, $path, $practice_data);
    }


    echo '<div class="p-5 mb-4 bg-primary text-white text-center">';
    echo '<h1 class="mb-4">Setup done!</h1>';
    echo '<a href="index.php" class="btn btn-info w-100 mb-3">Start survey</a>';
    echo '</div>';

    include 'layout/footer.php';
} else {
    echo '<div class="p-5 mb-4 bg-primary text-white text-center">';
    echo "<h1 class='mb-4'>You don't belong here!</h1>";
    echo '<a href="index.php" class="btn btn-info w-100 mb-3">Go to survey</a>';
    echo '</div>';
}


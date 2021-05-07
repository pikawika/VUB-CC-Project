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

    //write grouped images to db
    foreach (glob('images/grouped/*.*') as $path) {
        $filename = pathinfo($path, PATHINFO_FILENAME);
        $grouped = 1;
        create_image_record($filename, $path, $grouped);
    }

    //write single images to db
    foreach (glob('images/single/*.*') as $path) {
        $filename = pathinfo($path, PATHINFO_FILENAME);
        $grouped = 0;
        create_image_record($filename, $path, $grouped);
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


<?php
include 'layout/header.php';

//this is a dummy key for local instances
$key = "dummykey";

if ($_GET["key"] == $key) {
    include 'db/db_actions.php';

    function show_download_screen()
    {
        ?>
        <div class="p-5 mb-4 bg-primary text-white text-center">
            <h1 class="mb-4">Export completed!</h1>
            <a href="results/images.csv" class="btn btn-info w-100 mb-3" download>Download images.csv &darr;</a>
            <a href="results/participants.csv" class="btn btn-info w-100 mb-3" download>Download participants.csv&darr;</a>
            <a href="results/ratings_grouped.csv" class="btn btn-info w-100 mb-3" download>Download ratings_grouped.csv &darr;</a>
            <a href="results/ratings_single.csv" class="btn btn-info w-100 mb-3" download>Download ratings_single.csv &darr;</a>
            <a href="results/bias.csv" class="btn btn-info w-100 mb-3" download>Download bias.csv &darr;</a>
        </div>
        <?php
    }


    function make_results_dir()
    {
        if (!is_dir('results')) {
            mkdir('results');
        }
    }

    function make_csv_files()
    {
        //participants
        $file = fopen("results/participants.csv", "w");
        fputcsv($file, array('participant_id', 'gender', 'age', 'expertise', 'colorblind', 'bad_vision'));
        $records = get_all_participants();
        while ($row = mysqli_fetch_assoc($records)) {
            fputcsv($file, $row);
        }
        fclose($file);

        //images
        $file = fopen("results/images.csv", "w");
        fputcsv($file, array('image_id', 'filename', 'path', 'grouped'));
        $records = get_all_images();
        while ($row = mysqli_fetch_assoc($records)) {
            fputcsv($file, $row);
        }
        fclose($file);

        // ratings grouped
        $file = fopen("results/ratings_grouped.csv", "w");
        fputcsv($file, array('participant_id', 'image_id', 'correspondence', 'realism', 'creative', 'made_by', 'note'));
        $records = get_all_ratings_grouped();
        while ($row = mysqli_fetch_assoc($records)) {
            fputcsv($file, $row);
        }
        fclose($file);

        // ratings grouped
        $file = fopen("results/ratings_single.csv", "w");
        fputcsv($file, array('participant_id', 'image_id', 'carlike', 'detail', 'realism', 'resemblence', 'creative', 'general_impression', 'note'));
        $records = get_all_ratings_single();
        while ($row = mysqli_fetch_assoc($records)) {
            fputcsv($file, $row);
        }
        fclose($file);

        // biased
        $file = fopen("results/bias.csv", "w");
        fputcsv($file, array('participant_id', 'biased', 'note'));
        $records = get_all_bias();
        while ($row = mysqli_fetch_assoc($records)) {
            fputcsv($file, $row);
        }
        fclose($file);
    }

    make_results_dir();

    make_csv_files();

    show_download_screen();

} else {
    echo '<div class="p-5 mb-4 bg-primary text-white text-center">';
    echo "<h1 class='mb-4'>You don't belong here!</h1>";
    echo '<a href="index.php" class="btn btn-info w-100 mb-3">Go to survey</a>';
    echo '</div>';
}

include 'layout/footer.php';
<?php
//below settings are dummy username and password for local instances of the app
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "cc";

function create_tables()
{
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "CREATE TABLE IF NOT EXISTS `participants` (
                participant_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                gender VARCHAR(255) NOT NULL,
                age INT NOT NULL,
                expertise BOOL NOT NULL,
                colorblind BOOL NOT NULL,
                bad_vision BOOL NOT NULL
                )";

    if ($conn->query($sql) !== TRUE) {
        die("table creation Participants failed: " . $conn->error);
    }

    $sql = "CREATE TABLE IF NOT EXISTS `images` (
                image_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                filename VARCHAR(255) NOT NULL,
                path VARCHAR(255) NOT NULL,
                grouped BOOL NOT NULL
                )";

    if ($conn->query($sql) !== TRUE) {
        die("table creation Images failed: " . $conn->error);
    }

    $sql = "CREATE TABLE IF NOT EXISTS `ratings_grouped` (
                participant_id INT NOT NULL,
                image_id INT NOT NULL,
                correspondence INT NOT NULL,
                realism INT NOT NULL,
                creative INT NOT NULL,
                made_by VARCHAR(255) NOT NULL,
                note VARCHAR(255) NULL,
                primary key (participant_id, image_id)
                )";

    if ($conn->query($sql) !== TRUE) {
        die("table creation Ratings grouped failed: " . $conn->error);
    }



    $sql = "CREATE TABLE IF NOT EXISTS `ratings_single` (
                participant_id INT NOT NULL,
                image_id INT NOT NULL,
                carlike INT NOT NULL,
                detail INT NOT NULL,
                realism INT NOT NULL,
                resemblence INT NOT NULL,
                creative INT NOT NULL,
                general_impression INT NOT NULL,
                made_by VARCHAR(255) NOT NULL,
                note VARCHAR(255) NULL,
                primary key (participant_id, image_id)
                )";

    if ($conn->query($sql) !== TRUE) {
        die("table creation Ratings single failed: " . $conn->error);
    }

    $sql = "CREATE TABLE IF NOT EXISTS `bias` (
                participant_id INT PRIMARY KEY,
                biased VARCHAR(255) NOT NULL,
                note VARCHAR(255) NOT NULL
                )";

    if ($conn->query($sql) !== TRUE) {
        die("table creation bias failed: " . $conn->error);
    }

    $conn->close();
}

function create_user_and_get_user_id($gender, $age, $expertise, $colorblind, $bad_vision)
{
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO participants(gender, age, expertise, colorblind, bad_vision) VALUES ('$gender', '$age', '$expertise', '$colorblind', '$bad_vision')";

    if ($conn->query($sql) !== TRUE) {
        die("insert user failed: " . $conn->error);
    } else {
        $participant_id = $conn->insert_id;
        $conn->close();
        return $participant_id;
    }


}

function create_image_record($filename, $path, $grouped)
{
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO images(filename, path, grouped) VALUES ('$filename', '$path', '$grouped')";

    if ($conn->query($sql) !== TRUE) {
        die("insert image failed: " . $conn->error);
    }

    $conn->close();
}

function delete_tables()
{
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DROP TABLE IF EXISTS `participants`";

    if ($conn->query($sql) !== TRUE) {
        die("table deletion Participants failed: " . $conn->error);
    }

    $sql = "DROP TABLE IF EXISTS `images`";

    if ($conn->query($sql) !== TRUE) {
        die("table deletion Images failed: " . $conn->error);
    }

    $sql = "DROP TABLE IF EXISTS `ratings_grouped`";

    if ($conn->query($sql) !== TRUE) {
        die("table deletion ratings_grouped failed: " . $conn->error);
    }

    $sql = "DROP TABLE IF EXISTS `ratings_single`";

    if ($conn->query($sql) !== TRUE) {
        die("table deletion ratings_single failed: " . $conn->error);
    }

    $sql = "DROP TABLE IF EXISTS `biased`";

    if ($conn->query($sql) !== TRUE) {
        die("table deletion biased failed: " . $conn->error);
    }

    $conn->close();
}

function get_all_images()
{
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT image_id, filename, path, grouped FROM images";
    $result = $conn->query($sql);

    $conn->close();
    return $result;
}

function get_all_participants()
{
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT participant_id, gender, age, expertise, colorblind, bad_vision FROM participants";
    $result = $conn->query($sql);

    $conn->close();
    return $result;
}

function get_all_ratings_grouped()
{
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT participant_id, image_id, correspondence, realism, creative, made_by, note FROM ratings_grouped";
    $result = $conn->query($sql);

    $conn->close();
    return $result;
}

function get_all_bias() {
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT participant_id, biased, note FROM bias";
    $result = $conn->query($sql);

    $conn->close();
    return $result;
}

function get_all_ratings_single()
{
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT participant_id, image_id, carlike, detail, realism, resemblence, creative, general_impression, made_by, note FROM ratings_single";
    $result = $conn->query($sql);

    $conn->close();
    return $result;
}

function get_all_user_rated_images_grouped($participant_id)
{
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM ratings_grouped WHERE participant_id=$participant_id";
    $result = $conn->query($sql);

    $conn->close();
    return $result;
}

function get_all_user_rated_images_single($participant_id)
{
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM ratings_single WHERE participant_id=$participant_id";
    $result = $conn->query($sql);

    $conn->close();
    return $result;
}

function add_user_rating_grouped($participant_id, $image_id, $correspondence, $realism, $creative, $made_by, $note)
{
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO ratings_grouped(participant_id, image_id, correspondence, realism, creative, made_by, note) VALUES ('$participant_id', '$image_id', '$correspondence', '$realism', '$creative','$made_by', '$note')";

    if ($conn->query($sql) !== TRUE) {
        die("insert rating failed: " . $conn->error);
    }

    $conn->close();
}

function add_user_rating_single($participant_id, $image_id, $carlike, $detail, $realism, $resemblence, $creative, $general_impression, $made_by, $note)
{
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO ratings_single(participant_id, image_id, carlike, detail, realism, resemblence, creative, general_impression, made_by, note) VALUES ('$participant_id', '$image_id', '$carlike', '$detail', '$realism','$resemblence', '$creative', '$general_impression', '$made_by', '$note')";

    if ($conn->query($sql) !== TRUE) {
        die("insert rating failed: " . $conn->error);
    }

    $conn->close();
}

function add_user_bias($participant_id, $biased, $note)
{
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO bias(participant_id, biased, note) VALUES ('$participant_id', '$biased', '$note')";

    if ($conn->query($sql) !== TRUE) {
        die("insert bias failed: " . $conn->error);
    }

    $conn->close();
}

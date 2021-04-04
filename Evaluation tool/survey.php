<?php
//header voorzien
ob_start();
include 'layout/header.php';

if (isset($_POST['submit_profile_form'])) {
    // user completed about you
    include 'db/db_actions.php';
    save_info_about_you_and_show_first_image();
} else if (isset($_POST['image_id']) && isset($_COOKIE['participant_id'])) {
    //user rated an image
    include 'db/db_actions.php';
    save_post_rating_image();
    show_next_iterative_photo_rating();
} else if (isset($_COOKIE['participant_id'])) {
    include 'db/db_actions.php';
    show_next_iterative_photo_rating();
} else {
    // initial screen to save user info
    show_info_about_you();
}

function save_info_about_you_and_show_first_image()
{
    // create a participant and save its id
    $participant_id = create_user_and_get_user_id($_POST['gender'], $_POST['age'], $_POST['expertise'], $_POST['colorblind'], $_POST['badvision']);
    // save id in cookie
    setcookie('participant_id', $participant_id, time() + (86400 * 30), "/");
    show_next_iterative_photo_rating($participant_id);
}

function show_next_iterative_photo_rating($participant_id = -1)
{
    if ($participant_id == -1) {
        $participant_id = ($_COOKIE['participant_id']);
    }
    setcookie('participant_id', $participant_id, time() + (86400 * 30), "/");

    $all_test_images = [];
    $all_real_images = [];
    $rated_images = [];
    $to_rate_test_images = [];
    $to_rate_real_images = [];

    $all_images_raw = get_all_images();
    $all_rated_images_raw = get_all_user_rated_images($participant_id);



    // save images as test or evaluation
    while ($row = $all_images_raw->fetch_assoc()) {
        if ($row["practice_data"] == 1) {
            array_push($all_test_images, $row);
        }
        if ($row["practice_data"] == 0) {
            array_push($all_real_images, $row);
        }
    }

    // save already rated images
    while ($row = $all_rated_images_raw->fetch_assoc()) {
        array_push($rated_images, $row);
    }


    // save list of already rated test images
    foreach ($all_test_images as $all_test_image) {
        $match = false;
        foreach ($rated_images as $rated_image) {
            if ($all_test_image['image_id'] == $rated_image['image_id']) {
                $match = true;
                break;
            }
        }

        if (!$match) {
            array_push($to_rate_test_images, $all_test_image);
        }
    }


    // save list of already rated evaluation images
    foreach ($all_real_images as $all_real_image) {
        $match = false;
        foreach ($rated_images as $rated_image) {
            if ($all_real_image['image_id'] == $rated_image['image_id']) {
                $match = true;
                break;
            }
        }

        if (!$match) {
            array_push($to_rate_real_images, $all_real_image);
        }
    }


    // show test images first
    if (sizeof($to_rate_test_images) != 0) {
        $random_index = array_rand($to_rate_test_images, 1);
        show_photo_rating($to_rate_test_images[$random_index]['image_id'], $to_rate_test_images[$random_index]['path']);
    } else if (sizeof($to_rate_real_images) != 0) {
        // show evaluation images of no test images remaining
        $random_index = array_rand($to_rate_real_images, 1);
        show_photo_rating($to_rate_real_images[$random_index]['image_id'], $to_rate_real_images[$random_index]['path']);
    } else {
        // no more images to rate, show thanks
        show_thanks_screen();
    }
}

function show_thanks_screen()
{
    //reset
    setcookie('participant_id', "", time() - 3600);
    ?>
    <div class="p-5 mb-4 bg-grey text-white">
        <h1 class="mb-4 text-white">Thanks for participating!</h1>
        <a href="index.php" class="btn btn-info w-100 mb-3">Return to the start of the survey</a>
    </div>
    <?php
}

function show_photo_rating($image_id, $path)
{
    $human = rand(0, 1);
    ?>
    <form enctype='multipart/form-data' method="post">
        <div class="p-5 mb-4 bg-grey text-white">
            <h1 class="mb-4">You are rating a <?php echo ["computer generated", "human made"][$human] ?> car design</h1>

            <div class="mb-5 row">
                <div class="col">
                    <img class="img_evaluation" src="<?php echo $path ?>"
                         data-zoom="<?php echo $path ?>">
                </div>
                <div class="col">
                    <p class="img_evaluation_zoomed">Move your cursor over the image to zoom in.</p>
                </div>
                <hr>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Quality</label>
                <div class="col-sm-10">

                    <div class="w-100">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="quality1" name="quality" value="1"
                                   required>
                            <label class="form-check-label" for="quality1">1 (-)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="quality2" name="quality" value="2">
                            <label class="form-check-label" for="quality2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="quality3" name="quality" value="3">
                            <label class="form-check-label" for="quality3">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="quality4" name="quality" value="4">
                            <label class="form-check-label" for="quality4">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="quality5" name="quality" value="5">
                            <label class="form-check-label" for="quality5">5 (+)</label>
                        </div>
                    </div>
                    <small>
                        An image is considered of good quality if it doesn't contain graphical glitches or artifacts
                        as explained in the introductory video.
                    </small>
                </div>
            </div>
            <hr>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Colors</label>
                <div class="col-sm-10">

                    <div class="w-100">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="color1" name="color" value="1"
                                   required>
                            <label class="form-check-label" for="color1">1 (-)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="color2" name="color" value="2">
                            <label class="form-check-label" for="color2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="color3" name="color" value="3">
                            <label class="form-check-label" for="color3">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="color4" name="color" value="4">
                            <label class="form-check-label" for="color4">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="color5" name="color" value="5">
                            <label class="form-check-label" for="color5">5 (+)</label>
                        </div>
                    </div>
                    <small>
                        Colors of an image are considered good if they are viable in real life.
                        Remember, some color combinations may be ugly to you but still realistic.
                        An image has bad colors if it has purple grass, red shadows...
                    </small>
                </div>
            </div>
            <hr>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Creativity</label>
                <div class="col-sm-10">

                    <div class="w-100">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="creativity1" name="creativity" value="1"
                                   required>
                            <label class="form-check-label" for="creativity1">1 (-)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="creativity2" name="creativity" value="2">
                            <label class="form-check-label" for="creativity2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="creativity3" name="creativity" value="3">
                            <label class="form-check-label" for="creativity3">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="creativity4" name="creativity" value="4">
                            <label class="form-check-label" for="creativity4">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="creativity5" name="creativity" value="5">
                            <label class="form-check-label" for="creativity5">5 (+)</label>
                        </div>
                    </div>
                    <small>
                        Whether you find the image creative is a subjective manner, if you recognize (elements of)
                        existing cars please leave them in the notes section. Remember some of the examples given in the
                        introduction video.
                    </small>
                </div>
            </div>
            <hr>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">General impression</label>
                <div class="col-sm-10">

                    <div class="w-100">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="general1" name="general" value="1"
                                   required>
                            <label class="form-check-label" for="general1">1 (-)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="general2" name="general" value="2">
                            <label class="form-check-label" for="general2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="general3" name="general" value="3">
                            <label class="form-check-label" for="general3">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="general4" name="general" value="4">
                            <label class="form-check-label" for="general4">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="general5" name="general" value="5">
                            <label class="form-check-label" for="color5">5 (+)</label>
                        </div>
                    </div>
                    <small>
                        An overall rating on how pleased you are with this car design. This is subjective,
                        feel free to leave reasoning in the notes.
                    </small>
                </div>
            </div>
            <hr>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Notes</label>
                <div class="col-sm-10">
                    <textarea class="col-sm-12" id="note" name="note" rows="5"></textarea>
                    <small>
                        This field can be used to discuss recognised cars, reasoning for exceptionally low or high
                        scores and more.
                    </small>
                </div>
            </div>

            <input type="hidden" name="image_id" value="<?php echo $image_id ?>">
            <input type="hidden" name="human" value="<?php echo $human ?>">


        </div>

        <button type="submit" name="submit_iterative_photo_rating_form" value="Submit"
                class="btn btn-outline-primary w-100">
            Beoordeel de volgende afbeelding
        </button>
    </form>
    <?php
}

function save_post_rating_image()
{
    add_user_rating($_COOKIE['participant_id'], $_POST['image_id'], $_POST['human'], $_POST['quality'], $_POST['color'], $_POST['creativity'], $_POST['general'], $_POST['note']);
}

function show_info_about_you()
{
    ?>
    <form enctype='multipart/form-data' method="post">
        <div class="p-5 mb-4 bg-grey text-white">
            <h1 class="mb-4">Information about you</h1>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Gender</label>
                <div class="col-sm-10">
                    <select class="custom-select" name="gender" required>
                        <option value="">Please select a gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Others / prefer not to say</option>
                    </select>
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Age group</label>
                <div class="col-sm-10">
                    <input type="number" step="5" name="age" class="w-100" min="0" max="140" placeholder="Age"
                           required/>
                    <small>
                        Nearest age group in increments of 5.
                    </small>
                </div>

            </div>
            <hr>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Expertise in domain</label>
                <div class="col-sm-10">

                    <div class="w-100">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="expertise1" name="expertise" value="1"
                                   required>
                            <label class="form-check-label" for="expertise1">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="expertise2" name="expertise" value="0">
                            <label class="form-check-label" for="expertise2">No</label>
                        </div>
                    </div>

                    <small>
                        You're considered to have expertise in the domain if you're able to recognize cars from
                        different brands in any angle, albeit since you're a passionate car love or work in a garage
                        or anything in between.
                    </small>
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Colorblind</label>
                <div class="col-sm-10">

                    <div class="w-100">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="colorblind1" name="colorblind"
                                   value="1"
                                   required>
                            <label class="form-check-label" for="colorblind1">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="colorblind2" name="colorblind" value="0">
                            <label class="form-check-label" for="colorblind2">No</label>
                        </div>
                    </div>

                    <small>Not sure if you're colorblind?
                        <a class="text-white" target="_blank"
                           href="https://www.colour-blindness.com/colour-blindness-tests/ishihara-colour-test-plates/">
                            Do a short test here.
                        </a>
                    </small>
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Bad vision</label>
                <div class="col-sm-10">

                    <div class="w-100">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="badvision1" name="badvision" value="1"
                                   required>
                            <label class="form-check-label" for="badvision1">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="badvision2" name="badvision" value="0">
                            <label class="form-check-label" for="badvision2">No</label>
                        </div>
                    </div>

                    <small>
                        If you have bad vision during this survey, please select yes. Bad vision is considered if you
                        normally wear glasses but don't have them on during this survey or suffer from bad vision in
                        any other way during this survey.
                    </small>
                </div>
            </div>
        </div>
        <button type="submit" name="submit_profile_form" value="Submit" class="btn btn-outline-primary w-100">
            The above data is correct, start rating images!
        </button>
    </form>
    <?php
}

//footer voorzien
include 'layout/footer.php';
ob_end_flush();
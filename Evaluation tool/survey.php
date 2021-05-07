<?php
//header voorzien
ob_start();
include 'layout/header.php';
include 'db/db_actions.php';

if (isset($_POST['submit_profile_form'])) {
    // user completed about you
    save_info_about_you_and_show_first_image();
} else if (isset($_POST['image_id']) && isset($_COOKIE['participant_id'])) {
    //user rated an image
    save_post_rating_image();
    show_next_iterative_photo_rating();
} else if (isset($_COOKIE['participant_id'])) {
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

    // To compute
    $all_grouped_images = [];
    $all_single_images = [];
    $rated_grouped_images = [];
    $rated_single_images = [];
    $to_rate_grouped_images = [];
    $to_rate_single_images = [];

    // in DB
    $all_images_raw = get_all_images();
    $all_rated_grouped_images_raw = get_all_user_rated_images_grouped($participant_id);
    $all_rated_single_images_raw = get_all_user_rated_images_single($participant_id);

    // save images as grouped or single
    while ($row = $all_images_raw->fetch_assoc()) {
        if ($row["grouped"] == 1) {
            array_push($all_grouped_images, $row);
        }
        if ($row["grouped"] == 0) {
            array_push($all_single_images, $row);
        }
    }

    // save already rated grouped images
    while ($row = $all_rated_grouped_images_raw->fetch_assoc()) {
        array_push($rated_grouped_images, $row);
    }

    // save already rated single images
    while ($row = $all_rated_single_images_raw->fetch_assoc()) {
        array_push($rated_single_images, $row);
    }

    // save list of to rate grouped images
    foreach ($all_grouped_images as $all_grouped_image) {
        $match = false;
        foreach ($rated_grouped_images as $rated_grouped_image) {
            if ($all_grouped_image['image_id'] == $rated_grouped_image['image_id']) {
                $match = true;
                break;
            }
        }

        if (!$match) {
            array_push($to_rate_grouped_images, $all_grouped_image);
        }
    }

    // save list of to rate single images
    foreach ($all_single_images as $all_single_image) {
        $match = false;
        foreach ($rated_single_images as $rated_single_image) {
            if ($all_single_image['image_id'] == $rated_single_image['image_id']) {
                $match = true;
                break;
            }
        }

        if (!$match) {
            array_push($to_rate_single_images, $all_single_image);
        }
    }

    // show grouped images first
    if (sizeof($to_rate_grouped_images) != 0) {
        $random_index = array_rand($to_rate_grouped_images, 1);
        show_grouped_photo_rating($to_rate_grouped_images[$random_index]['image_id'], $to_rate_grouped_images[$random_index]['path']);
    } else if (sizeof($to_rate_single_images) != 0) {
        // show evaluation images of no test images remaining
        $random_index = array_rand($to_rate_single_images, 1);
        show_single_photo_rating($to_rate_single_images[$random_index]['image_id'], $to_rate_single_images[$random_index]['path']);
    } else {
        // no more images to rate, show thanks
        show_thanks_screen();
    }


}

function show_thanks_screen()
{
    //reset
    setcookie('participant_id', "", time() - 3600, "/");
    ?>
    <div class="p-5 mb-4 bg-grey text-white">
        <h1 class="mb-4 text-white">Thanks for participating!</h1>
        <a href="index.php" class="btn btn-info w-100 mb-3">Return to the start of the survey</a>
    </div>
    <?php
}

function show_grouped_photo_rating($image_id, $path)
{
    ?>
    <form enctype='multipart/form-data' method="post">
        <div class="p-5 mb-4 bg-grey text-white">
            <h1 class="mb-4">Rate these modified car designs</h1>

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
                <label class="col-sm-2 col-form-label">Correspondence</label>
                <div class="col-sm-10">

                    <div class="w-100">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="correspondence1" name="correspondence" value="1"
                                   required>
                            <label class="form-check-label" for="correspondence1">1 (-)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="correspondence2" name="correspondence" value="2">
                            <label class="form-check-label" for="correspondence2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="correspondence3" name="correspondence" value="3">
                            <label class="form-check-label" for="correspondence3">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="correspondence4" name="correspondence" value="4">
                            <label class="form-check-label" for="correspondence4">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="correspondence5" name="correspondence" value="5">
                            <label class="form-check-label" for="correspondence5">5 (+)</label>
                        </div>
                    </div>
                    <small>
                        An image is considered of good correspondence (5) if the cars displayed in the row "start" are
                        clearly recognisable in the variants displayed below.
                    </small>
                </div>
            </div>
            <hr>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Realism</label>
                <div class="col-sm-10">

                    <div class="w-100">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="realism1" name="realism" value="1"
                                   required>
                            <label class="form-check-label" for="realism1">1 (-)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="realism2" name="realism" value="2">
                            <label class="form-check-label" for="realism2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="realism3" name="realism" value="3">
                            <label class="form-check-label" for="realism3">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="realism4" name="realism" value="4">
                            <label class="form-check-label" for="realism4">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="realism5" name="realism" value="5">
                            <label class="form-check-label" for="realism5">5 (+)</label>
                        </div>
                    </div>
                    <small>
                        An image is considered very realistic (5) if all cars displayed look as if a car designer has
                        professionally made it and you wouldn't doubt it could be a real car.
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
                        Whether you find the image/modifications creative is a subjective manner, if you recognize (elements of)
                        existing cars please leave them in the notes section. Remember some of the examples given in the
                        explanatory video.
                    </small>
                </div>
            </div>

            <hr>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Made by</label>
                <div class="col-sm-10">

                    <div class="w-100">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="made_by1" name="made_by" value="human"
                                   required>
                            <label class="form-check-label" for="made_by1">Human</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="made_by2" name="made_by" value="computer">
                            <label class="form-check-label" for="made_by2">Computer</label>
                        </div>
                    </div>
                    <small>
                        Whether you think the image/modifications are made by a human or a computer.
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

            <hr>

            <input type="hidden" name="image_id" value="<?php echo $image_id ?>">


        </div>

        <button type="submit" name="submit_iterative_photo_rating_form" value="Submit"
                class="btn btn-outline-primary w-100">
            Beoordeel de volgende afbeelding
        </button>
    </form>
    <?php
}

function show_single_photo_rating($image_id, $path)
{
    ?>
    <form enctype='multipart/form-data' method="post">
        <div class="p-5 mb-4 bg-grey text-white">
            <h1 class="mb-4">Rate this car design</h1>

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
                <label class="col-sm-2 col-form-label">Car</label>
                <div class="col-sm-10">

                    <div class="w-100">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="carlike1" name="carlike" value="1"
                                   required>
                            <label class="form-check-label" for="carlike1">1 (-)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="carlike2" name="carlike" value="2">
                            <label class="form-check-label" for="carlike2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="carlike3" name="carlike" value="3">
                            <label class="form-check-label" for="carlike3">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="carlike4" name="carlike" value="4">
                            <label class="form-check-label" for="carlike4">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="carlike5" name="carlike" value="5">
                            <label class="form-check-label" for="carlike5">5 (+)</label>
                        </div>
                    </div>
                    <small>
                        Rate from 0 - 5 how "car-like" the object shown is, does it have all required components in your opinion.
                        Try to keep this separate from realism.
                    </small>
                </div>
            </div>

            <hr>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Detail</label>
                <div class="col-sm-10">

                    <div class="w-100">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="detail1" name="detail" value="1"
                                   required>
                            <label class="form-check-label" for="detail1">1 (-)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="detail2" name="detail" value="2">
                            <label class="form-check-label" for="detail2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="detail3" name="detail" value="3">
                            <label class="form-check-label" for="detail3">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="detail4" name="detail" value="4">
                            <label class="form-check-label" for="detail4">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="detail5" name="detail" value="5">
                            <label class="form-check-label" for="detail5">5 (+)</label>
                        </div>
                    </div>
                    <small>
                        Rate from 0 - 5 how "detailed" the image shown is, are their minor details such as small badges,
                        door handles, dents, reflections, ... you notice or is it rather flat.
                    </small>
                </div>
            </div>

            <hr>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Realism</label>
                <div class="col-sm-10">

                    <div class="w-100">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="realism1" name="realism" value="1"
                                   required>
                            <label class="form-check-label" for="realism1">1 (-)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="realism2" name="realism" value="2">
                            <label class="form-check-label" for="realism2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="realism3" name="realism" value="3">
                            <label class="form-check-label" for="realism3">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="realism4" name="realism" value="4">
                            <label class="form-check-label" for="realism4">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="realism5" name="realism" value="5">
                            <label class="form-check-label" for="realism5">5 (+)</label>
                        </div>
                    </div>
                    <small>
                        An image is considered very realistic (5) if all cars displayed look as if a car designer has
                        professionally made it and you wouldn't doubt it could be a real car.
                    </small>
                </div>
            </div>

            <hr>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">resemblance</label>
                <div class="col-sm-10">

                    <div class="w-100">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="resemblence1" name="resemblence" value="1"
                                   required>
                            <label class="form-check-label" for="resemblence1">1 (-)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="resemblence2" name="resemblence" value="2">
                            <label class="form-check-label" for="resemblence2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="resemblence3" name="resemblence" value="3">
                            <label class="form-check-label" for="resemblence3">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="resemblence4" name="resemblence" value="4">
                            <label class="form-check-label" for="resemblence4">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="resemblence5" name="resemblence" value="5">
                            <label class="form-check-label" for="resemblence5">5 (+)</label>
                        </div>
                    </div>
                    <small>
                        An image is considered very resemblant (5) of another car if you clearly recognize a certain existing
                        car in the image. It's loosly resemblant (3) if you recognize style treats of a car or brand. Feel free
                        to discuss this further in the notes section.
                    </small>
                </div>
            </div>

            <hr>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Creativity</label>
                <div class="col-sm-10">

                    <div class="w-100">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="creative1" name="creative" value="1"
                                   required>
                            <label class="form-check-label" for="creative1">1 (-)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="creative2" name="creative" value="2">
                            <label class="form-check-label" for="creative2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="creative3" name="creative" value="3">
                            <label class="form-check-label" for="creative3">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="creative4" name="creative" value="4">
                            <label class="form-check-label" for="creative4">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="creative5" name="creative" value="5">
                            <label class="form-check-label" for="creative5">5 (+)</label>
                        </div>
                    </div>
                    <small>
                        Whether you find the image creative is a subjective manner, if you recognize (elements of)
                        existing cars please leave them in the notes section. Remember some of the examples given in the
                        explanatory video.
                    </small>
                </div>
            </div>

            <hr>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">General impression</label>
                <div class="col-sm-10">

                    <div class="w-100">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="general_impression1" name="general_impression" value="1"
                                   required>
                            <label class="form-check-label" for="general_impression1">1 (-)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="general_impression2" name="general_impression" value="2">
                            <label class="form-check-label" for="general_impression2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="general_impression3" name="general_impression" value="3">
                            <label class="form-check-label" for="general_impression3">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="general_impression4" name="general_impression" value="4">
                            <label class="form-check-label" for="general_impression4">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="general_impression5" name="general_impression" value="5">
                            <label class="form-check-label" for="general_impression5">5 (+)</label>
                        </div>
                    </div>
                    <small>
                        How would you rate this image in general, would you find it suited if it were shown in a car-related magazine?
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
    //determine if grouped or single rating
    if (isset($_POST['made_by'])) {
        // grouped image
        add_user_rating_grouped($_COOKIE['participant_id'], $_POST['image_id'], $_POST['correspondence'], $_POST['realism'], $_POST['creativity'], $_POST['made_by'], $_POST['note']);
    } else {
        // single image
        add_user_rating_single($_COOKIE['participant_id'], $_POST['image_id'], $_POST['carlike'], $_POST['detail'], $_POST['realism'], $_POST['resemblence'], $_POST['creative'], $_POST['general_impression'], $_POST['note']);
    }


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
                <label for="inputEmail3" class="col-sm-2 col-form-label">Age group (multiple of 10!)</label>
                <div class="col-sm-10">
                    <input type="number" step="10" name="age" class="w-100" min="0" max="140" placeholder="Age"
                           required/>
                    <small>
                        Nearest age group in increments of 10.
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
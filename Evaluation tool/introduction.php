<?php
//header
include 'layout/header.php';
?>
    <div class="p-5 mb-4 bg-grey text-white">
        <h1 class="mb-4">Explaining what is expected from you</h1>

        <p class="mb-4">
            During this survey, you will rate 2 types of images. Examples from both are given below and we'll shortly
            discuss what the different criteria mean.
        </p>

        <h2>Grouped images</h2>
        <p>
            With these images you'll rate the modification made to 4 different "start" images of cars.
            These modification are either made by a human or a computer, the guess is up to you.
            Be warned, backgrounds and logo's are tempered with on purpose as to not make your guess to easy.
        </p>
        <div class="mb-5 row">
            <div class="col-sm-6">
                <img class="img_evaluation" src="images/example/example_grouped.png"
                     data-zoom="images/example/example_grouped.png">
            </div>
            <div class="col-sm-6">
                <p class="img_evaluation_zoomed">Move your cursor over the image to zoom in.</p>
            </div>
            <hr>
        </div>

        <p>
            You will have to rate these images on the following criteria, from 1 (bad) to 5 (excellent).
        </p>
        <ul class="mb-4">
            <li>
                Correspondence: an image is considered of good correspondence (5) if the cars displayed in the row
                "start" are clearly recognisable in the variants displayed below and modifications performed are similar
                between all four cars. For this image, correspondence is excellent as the car is clearly recognisable
                between variants.
            </li>
            <li>
                Realism: an image is considered very realistic (5) if you wouldn't doubt it could be an image you'd see
                in a car magazine. This is subjective, but the cars in this image seem to be rather realistic.
            </li>
            <li>
                Creativity: whether you find the modifications creative is a subjective manner, if you recognize
                (elements of) existing cars you can leave them in the notes section. For example, one might find the
                second car from left very much looking like an old Volkswagen, by which he doesn't find it all that
                creative.
            </li>
            <li>
                Made by: Whether you think the modifications are made by a human or a computer. Only pay attention
                to the car for this, backgrounds, logo's and text are tempered with to not make it to easy for you!
            </li>
            <li>
                Notes: This field can be used to discuss recognised cars, what you think the performed modification is,
                reasoning for exceptionally low or high scores and more. In this example, not much seems changed
                between images, someone with a good eye might spot the size of the wheels has changed ever so slightly
                between images.
            </li>
        </ul>

        <h2>Single images</h2>
        <p>
            With these images you'll rate a singular image of a car, all be it made from 'scratch' of (heavily)
            modified from an existing car. Again, some are made by a human, others are made by a computer.
            Be warned, backgrounds and logo's are tempered with on purpose as to not make your guess to easy.
        </p>

        <div class="mb-5 row">
            <div class="col-sm-4">
                <img class="img_explanation" src="images/example/example_single1.png">
            </div>
            <div class="col-sm-4">
                <img class="img_explanation" src="images/example/example_single2.png">
            </div>
            <div class="col-sm-4">
                <img class="img_explanation" src="images/example/example_single3.png">
            </div>
            <hr>
        </div>

        <p>
            You will have to rate these images on the following criteria, from 1 (bad) to 5 (excellent).
        </p>
        <ul class="mb-4">
            <li>
                Car: rate from 0 - 5 how "car-like" the object shown is, does it have all required components in your
                opinion? Try to keep this separate from realism. All of these images seem to be pretty car-like and
                would most likely score pretty good.
            </li>
            <li>
                Detail: a detailed image (5) contains minor details such as small badges,
                door handles, dents, reflections, ... If you feel as if the image is rather "flat", you would
                give it a lower score. The right image seems to include many details and would score high, one might
                find the middle lacking in details since it has no mirrors and give it a lower score.
            </li>
            <li>
                Realism: same ideology as before.
            </li>
            <li>
                Resemblance: an image is considered very resemblant (5) of another car if you clearly recognize a
                certain existing car in the image. It's loosly resemblant (3) if you recognize style treats of a car or
                brand. Feel free to discuss this further in the notes section. For example, one might recognize a
                Peugeot 208 and Audi style elements in the left image, which gives it a mediocre score since those are
                two very distinct brands.
            </li>
            <li>
                Creativity: same ideology as before.
            </li>
            <li>
                General impression: how would you rate this image in general, would you find it suited if it were shown
                in a car-related magazine?
            </li>
            <li>
                Made by: same ideology as before.
            </li>
            <li>
                Notes: same ideology as before.
            </li>
        </ul>


        <p>
            If you would have any more questions don't hesitate to contact me:
        </p>
        <ul class="mb-4">
            <li>
                Email: <a href="mailto:info@lennertbontinck.com" target="_blank" class="white_color">info@lennertbontinck.com</a>
            </li>
            <li>
                Facebook: <a href="https://www.facebook.com/AmazingLennert" target="_blank" class="white_color">Lennert
                    Bontinck</a>
            </li>
            <li>
                Instagram: <a href="https://www.instagram.com/__lenerd__/" target="_blank" class="white_color">__LeNerd__</a>
            </li>
        </ul>
    </div>
    <button type="button" class="btn btn-outline-primary w-100" onclick="window.location.href='survey.php'">
        All clear, start the survey!
    </button>
<?php
//footer
include 'layout/footer.php';
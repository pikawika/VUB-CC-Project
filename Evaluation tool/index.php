<?php
//reset
setcookie('participant_id', "", time() - 3600, "/");
//header
include 'layout/header.php';
?>
    <div class="p-5 mb-4 bg-grey text-white">
        <h1 class="mb-4">Creative car design survey</h1>

        <p class="mb-2">Hello!</p>

        <p class="mb-2">Thanks for your interest in helping me, Lennert Bontinck, evaluate creative car designs.</p>
        <p class="mb-2">This survey consists of rating images of cars on multiple criteria.
            Some of the images you are about to see are created by a human through Adobe Photoshop,
            others are computer generated by an artificial intelligence.
        </p>
        <p class="mb-2">For this survey the following of your data will be stored and can be used in a publicly available paper:
        <ul>
            <li>
                Gender (optional)
            </li>
            <li>
                Age (rounded to nearest multiple of 10)
            </li>
            <li>
                Whether or not you have expertise in the domain
            </li>
            <li>
                Whether or not you are color blind
            </li>
            <li>
                Whether or not you have bad vision upon taking the survey
            </li>
            <li>
                The evaluation criteria you have assigned to the images
            </li>
        </ul>
        </p>
        <p class="mb-2">In total you'll rate 12 images, expect this to take around 15 minutes.</p>
    </div>
    <button type="button" class="btn btn-outline-primary w-100 mb-3" onclick="window.location.href='introduction.php'">
        I agree my data listed above will be stored and made publicly available
    </button>
<?php
//footer
include 'layout/footer.php';
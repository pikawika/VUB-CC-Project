<?php
//header
include 'layout/header.php';
?>
    <div class="p-5 mb-4 bg-grey text-white">
        <h1 class="mb-4">Explaining what is expected from you</h1>
        <p class="mb-4">
            The following short video will explain what is expected from you for this survey. Please watch it until the end.
        </p>
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
        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/tqx-hmzO4kQ"
                    allowfullscreen></iframe>
        </div>
    </div>
    <button type="button" class="btn btn-outline-primary w-100" onclick="window.location.href='survey.php'">
        All clear, start the survey!
    </button>
<?php
//footer
include 'layout/footer.php';
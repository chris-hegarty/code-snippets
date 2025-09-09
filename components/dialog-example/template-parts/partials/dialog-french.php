<?php

    ?>

<!-- Dialog element for survey: -->
<!-- TODO: Need to conditionally add French and Spanish versions.-->
<dialog id="survey" class="dialog" role="alertdialog">
    <button id="close" onclick="document.getElementById('survey').close()">
        <span class="fa fa-times-circle fa-lg"></span>
    </button>
    <div class="dialog-content">
        <h3>Nous aimerions connaître votre avis sur le site MyJobBenefits.</h3>
        <p>Veuillez répondre à quatre questions rapides sur votre expérience du site.</p>
        <a class="survey-link" href="https://forms.office.com/r/x7VPgWfA2a">
            <button class="button-survey">Cliquez ici pour commencer</button>
        </a>
    </div>
</dialog>

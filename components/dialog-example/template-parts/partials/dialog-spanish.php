<?php

    ?>

<!-- Dialog element for survey: -->
<!-- TODO: Need to conditionally add French and Spanish versions.-->
<dialog id="survey" class="dialog" role="alertdialog">
    <button id="close" onclick="document.getElementById('survey').close()">
        <span class="fa fa-times-circle fa-lg"></span>
    </button>
    <div class="dialog-content">
        <h3>Nos gustaría conocer su opinión sobre el sitio MyJobBenefits.</h3>
        <p>Responda a cuatro preguntas rápidas sobre su experiencia con el sitio.</p>
        <a class="survey-link" href="https://forms.office.com/r/Dv7wMm9Ct5">
            <button class="button-survey">Haga clic aquí para empezar.</button>
        </a>
    </div>
</dialog>

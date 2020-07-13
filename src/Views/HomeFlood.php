<?php

use Fvy\Group404\Components\Utils\HtmlHelpers;

?>

<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4"><?= $this->properties["pageName"]; ?></h1>
        <p class="lead"><strong><?= $this->properties["body"]; ?></strong>: Please wait a few minutes - too many request sent from your Browser</p>
    </div>
</div>

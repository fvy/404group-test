<?php

use Fvy\Group404\Components\Utils\HtmlHelpers;

?>
<table class="table table-hover">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col" width="80%">URL</th>
        <th scope="col">Short link</th>
    </tr>
    </thead>
    <tbody>
    <?
    print_r("<pre style='background-color: black; color: limegreen;'>");
    print_r($this->properties['urlsData']);
    print_r("</pre>");
    foreach ($this->properties['urlsData'] as $val) {
        ?>

        <tr data-toggle="tooltip" data-placement="top">
            <th scope="row"><?= $val['id'] ?></th>
            <td><?= HtmlHelpers::sanitizeField($val['url']); ?></td>
            <td><?= HtmlHelpers::textOnly($val['url_code']); ?></td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
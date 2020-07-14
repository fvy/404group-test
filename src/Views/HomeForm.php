<?php

use Fvy\Group404\Components\Utils\HtmlHelpers;

?>
<form autocomplete="off"
      action="/form/"
      method="post"
      class="!form-inline sandbox-form  <?= $this->properties['isUserActive'] ? "" : "urlform__disabled"; ?>"
      id="sandbox-container">
    <h4>Paste the URL to be shortened:</h4>
    <div class="row form-horizontal">
        <div class="span5 col-md-12" id="sandbox-container">
            <div class="span5 col-md-10">
                <input type="text"
                       name="url"
                       class="input-lg form-control"
                       placeholder="Enter the link here">
            </div>
            <div class="span5 col-md-2">
                <button type="submit" class="btn btn-primary btn-lg" <?= $this->properties['isUserActive'] ? "" : "disabled"; ?>>Shorten URL</button>
            </div>
        </div>
    </div>
    <input type="hidden" value="<?= $this->properties['token']; ?>" name="token">
</form>

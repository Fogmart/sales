<?php extract(get_query_var('wcs_admin')); ?>

<form class="wcs-settings-form">
    <div class="container">
        <h1><?= get_admin_page_title() ?>
            <div class="btn btn-primary btn-md float-right wcs-save">
                <?= __('Save') ?>
            </div>
        </h1>
    </div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#csettings"><?= __('Currencies Settings')?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#rendert"><?= __('Render Template') ?></a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active container" id="csettings">
            <div class="container wcs-currencies">
                <h3><?= __('Select currencies for switcher')?></h3>
                <?php foreach ($currencies as $code => $name) : ?>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input wcs-curr" data-symbol="<?= get_woocommerce_currency_symbol($code) ?>" data-name="<?= $name ?>" value="<?= $code ?>" style="margin-top: .3rem;margin-left: -1.25rem;" <?= WCS_Settings::getInstance()->isSelectedCurrency($code) ? 'checked' : ''?>>
                            <strong><?= $code ?></strong>
                            <?= $name ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="tab-pane container" id="rendert">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <textarea class="form-control wcs-template-main" rows="10" minlength="10" required><?= $mainTemplate ? $mainTemplate : ''?></textarea>
                    </div>
                    <div class="col jumbotron">
                        <h3><?= __('Write template for <span class="text-info">loop container</span>')?></h3>
                        <p class="text">
                            <?= __('<strong>@active</strong>
                            - active currency')?>
                        </p>
                        <p class="text">
                            <?= __('<strong>@all</strong>
                            - looped currencies, without active')?>
                        </p>
                        <p class="text">
                            <strong class="text-info">.wcs-container</strong> add this class to container element.
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <textarea class="form-control wcs-template-one" rows="3" minlength="10" required><?= $oneTemplate ? $oneTemplate : ''?></textarea>
                    </div>
                    <div class="col jumbotron">
                        <h3><?= __('Write template for <span class="text-info">one currency</span>')?></h3>
                        <p class="text">
                            <?= __('<strong>@name</strong>
                            - name of currency (Dominican peso)')?>
                        </p>
                        <p class="text">
                            <?= __('<strong>@symbol</strong>
                            - symbol of currency ($)')?>
                        </p>
                        <p class="text">
                            <?= __('<strong>@code</strong>
                            - code of currency (DOP)')?>
                        </p>
                        <p class="text">
                            <strong class="text-info">.wcs-curr</strong> add this class to currency switch element.
                        </p>
                        <p class="text">
                            <strong class="text-info">data-curr=@code</strong>
                            or 
                            <strong class="text-info">value=@code</strong>)
                            Add this to currency element to let the plugin know which currency to change.
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <textarea class="form-control wcs-template-active" rows="3" minlength="10" required><?= $activeTemplate ? $activeTemplate : ''?></textarea>
                    </div>
                    <div class="col jumbotron">
                        <h3><?= __('Write template for <span class="text-info">one active currency</span>')?></h3>
                        <p class="text">
                            <?= __('<strong>@name</strong>
                            - name of currency (Dominican peso)')?>
                        </p>
                        <p class="text">
                            <?= __('<strong>@symbol</strong>
                            - symbol of currency ($)')?>
                        </p>
                        <p class="text">
                            <?= __('<strong>@code</strong>
                            - code of currency (DOP)')?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
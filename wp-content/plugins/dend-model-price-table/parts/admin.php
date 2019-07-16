<form class="wcs-settings-form">
    <div class="container">
        <h1><?= get_admin_page_title() ?>
            <div class="btn btn-primary btn-md float-right mp-save">
                <?= __('Save') ?>
            </div>
        </h1>
    </div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#info"><?= __('Помощь') ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tables"><?= __('Таблицы') ?></a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active container" id="info">
            <div class="container mp-table-settings">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3><?= __('Описание:') ?></h3>
                    </div>
                    <div class="panel-body">
                        <p>Двойной клик для вкл/выкл редактирование ячейки.</p>
                        <p><span class="bg-warning">7000</span> индикатор колонки с возможностью редактирования</p>
                        <p>Для вставки таблицы на с страницу, шорткод -
                            <h6>
                                [model_price_table table="<span class="text-info">{название таблицы}</span>"]
                            </h6>
                        </p>
                        <small>Визуальные эффекты отключены в режиме редактирования</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane container" id="tables">
            <div class="container mp-table-settings">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3><?= __('Таблицы:') ?></h3>
                    </div>
                    <div class="panel-body">
                        <?php foreach(): ?>

                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>
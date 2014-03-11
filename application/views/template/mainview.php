<?php
!isset($title) ? $title = '' : '';
!isset($view_page) ? $view_page = 'template/noviewpage' : '';
!isset($view_model) ? $view_model = '' : '';
?>
<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?= $title ?></title>
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/foundation.css" />
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/app.css" />
        <script src="<?= base_url() ?>assets/js/vendor/modernizr.js"></script>
    </head>
    <body>
        <div class="sticky">
            <nav data-topbar class="top-bar fixed">
                <ul class="title-area">
                    <li class="name"><h1><a href="<?= base_url() ?>">CRUD Simple</a></h1></li>
                    <li class="toggle-topbar menu-icon"><a href="#"></a></li>
                </ul>
                <section class="top-bar-section">
                    <ul class="left">
                        <li class="divider"></li>
                        <li>
                            <a href="<?= base_url() ?>category">Category</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?= base_url() ?>thing">Thing</a>
                        </li>
                        <li class="divider"></li>
                    </ul>
                </section>
            </nav>

            <!-- Start of notification area           -->

            <div class="row">
                <div class="large-12 columns">
                    <!-- Start of flashdata notif -->
                    <?php
                    $is_success = $this->session->flashdata('is_success');
                    if ($is_success != NULL):
                        ?>
                        <div data-alert class="alert-box
                        <?php
                        if ($is_success === TRUE)
                            echo ' success';
                        else if ($is_success === FALSE)
                            echo ' alert';
                        ?>">
                                 <?= $this->session->flashdata('message') ?>
                            <a href="#" class="close">&times;</a>
                        </div>
                    <?php endif; ?>
                    <!-- End of flashdata notif -->

                    <!-- Start of form validation notif -->
                    <?php
                    $form_valid = validation_errors('<div data-alert class="alert-box alert">', '
                            <a href="#" class="close">&times;</a>
                        </div>');
                    if ($form_valid != ''):
                        ?>
                        <?= $form_valid ?>
                    <?php endif; ?>
                    <!-- End of form validation notif -->
                </div>
            </div>
            <!-- End of notification area           -->

        </div>

        <div class="row">
            <div class="large-12 columns">
                <h1><?= $title ?></h1>
            </div>
        </div>

        <div class="row">
            <div class="large-12 columns">
                <?php $this->load->view($view_page, $view_model) ?>
            </div>
        </div>
        <div class="row">
            <div class="large-12 columns">
                <hr>
                <p class="footer"><?= safe_mailto('admin@local.host', 'Contact Us') ?> | Page rendered in <strong>{elapsed_time}</strong> seconds</p>
            </div>
        </div>
        <script src="<?= base_url() ?>assets/js/vendor/jquery.js"></script>
        <script src="<?= base_url() ?>assets/js/foundation.min.js"></script>
        <script>
            $(document).foundation();
        </script>
    </body>
</html>

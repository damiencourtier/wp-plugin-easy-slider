<?php

/**
 * The form to be loaded on the plugin's admin page
 */
if( current_user_can( 'edit_users' ) ) {

    $icon_edit = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                </svg>';
    ?>
        <div class="wrap easy-slider">

            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-sm-6">
                            <h3><?= get_admin_page_title() ?> - <?php esc_html_e('Sliders list','easy-slider') ?></h3>
                        </div>
                        <div class="col-sm-6">
                            <div class="float-end">
                                <a href="<?= admin_url('admin.php?page='. $this->plugin_name . '-form') ?>" type="button" class="btn btn-outline-info btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                    </svg> <?php esc_html_e('Add a Slider','easy-slider') ?></a>
                            </div>
                        </div>
                    </div>

                    <div aria-live="polite" aria-atomic="true" class="bg-dark position-relative bd-example-toasts">
                        <div class="toast-container position-absolute p-3 top-0 end-0" id="toastPlacement">
                            <div class="toast text-white bg-primary">
                                <div class="toast-body text-center">
                                    <?php esc_html_e('copied shortcode !','easy-slider') ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-body display-alert">

                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th scope="col" class="col-sm-3"><?php esc_html_e('Title','easy-slider') ?></a></th>
                            <th scope="col" class="col-sm-3"><?php esc_html_e('ShortCode','easy-slider') ?></th>
                            <th scope="col" class="col-sm-5"></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach (Easy_Slider_Functions::getSlidersList() as $key => $s){ ?>
                                <tr>
                                    <td class="align-middle"><?= $s->title ?></td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <input type="text" id="content-copy-<?=$key?>" class="form-control" value='[<?= $this->plugin_name ?> name="<?= $s->slug ?>"]' readonly >
                                            <button class="btn btn-outline-primary btn-copy" type="button" data-target="content-copy-<?=$key?>"><?php esc_html_e('Copy','easy-slider') ?></button>
                                        </div>
                                    </td>
                                    <td class="text-end align-middle">
                                        <a href="<?= admin_url('admin.php?page='. $this->plugin_name . '-form&slider=' . $s->id_slider ) ?>" class="btn btn-sm btn-secondary"><?= $icon_edit ?> <?php esc_html_e('Edit','easy-slider') ?></a href="<?= admin_url('admin.php?page='. $this->plugin_name . '-form&slider=' . $s->id_slider ) ?>">
                                        <button class="btn btn-sm btn-danger btn-delete-slider" data-target="<?=$s->id_slider?>" data-nonce="<?=wp_create_nonce( 'delete_slider_nonce' )?>"><?php esc_html_e('Delete','easy-slider') ?></button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


<?php } else { ?>
    <p> <?php esc_html_e("You are not authorized to perform this operation.", 'easy-slider') ?> </p>
<?php }

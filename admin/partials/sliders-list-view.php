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
                <h5 class="card-header"><?= get_admin_page_title() ?> - Liste des sliders</h5>
                <div class="card-body display-alert">

                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Created_at</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach (Easy_Slider_Functions::getSlidersList() as $s){ ?>
                                <tr>
                                    <td><?= $s->title ?></td>
                                    <td><?= $s->slug ?></td>
                                    <td><?= $s->created_at ?></td>
                                    <td>
                                        <a href="<?= admin_url('admin.php?page='. $this->plugin_name . '-form&slider=' . $s->id_slider ) ?>" class="btn btn-secondary btn-sm"><?= $icon_edit ?> Edit</a href="<?= admin_url('admin.php?page='. $this->plugin_name . '-form&slider=' . $s->id_slider ) ?>">
                                        <button class="btn btn-danger btn-sm btn-delete-slider" data-target="<?=$s->id_slider?>" data-nonce="<?=wp_create_nonce( 'delete_slider_nonce' )?>">Delete</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
<?php } else { ?>
    <p> <?php __("You are not authorized to perform this operation.", $this->plugin_name) ?> </p>
<?php }

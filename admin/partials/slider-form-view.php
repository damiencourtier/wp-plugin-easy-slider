<?php

/**
 * The form to be loaded on the plugin's admin page
 */
if( current_user_can( 'edit_users' ) ) {
    ?>
    <div class="wrap easy-slider">

        <div class="card">
            <div class="card-header">
                <h5 class="float-left"><?= get_admin_page_title() ?> - Slider</h5>
                <?php if(!$this->new){ ?>
                    <div class="float-right">
                        <a href="<?= admin_url('admin.php?page='. $this->plugin_name . '-form&slider=' . $this->slider->id_slider . '&action_slider=delete' ) ?>" class="btn btn-danger btn-sm">Supprimer le slider</a>
                    </div>
                <?php } ?>
            </div>
            <div class="card-body display-alert">
                <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" id="slider_form_ajax" >

                    <input type="hidden" name="action" value="slider_form_response">
                    <input type="hidden" name="slider_nonce" value="<?= wp_create_nonce( 'slider_nonce' ) ?>" />
                    <input type="hidden" id="widgets-counter" value="<?= $this->index ?>">
                    <input type="hidden" id="slider_id" name="slider_id" value="<?= $_GET['slider'] ?>">

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="<?= $this->plugin_name ?>-title">Titre</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control form-control-sm" id="<?= $this->plugin_name ?>-title" name="<?= $this->plugin_name ?>[title]" required value="<?= (!$this->new?$this->slider->title:'')?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="<?= $this->plugin_name ?>-title">Titre</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control form-control-sm" id="<?= $this->plugin_name ?>-title" name="<?= $this->plugin_name ?>[title]" required value="<?= (!$this->new?$this->slider->title:'')?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    Choisir les images du slider :
                                    <div class="float-right"><button type="button" class="btn btn-outline-info btn-sm btn-add-slide"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                            </svg> Ajouter un slide</button>
                                    </div>
                                </div>
                                <div class="card-body slides-list">

                                    <?php
                                    if(!$this->new){
                                        foreach ($this->items as $key => $item){
                                            ?>
                                            <div class="form-group row border-bottom slide-<?= $key ?>">
                                                <label class="col-sm-2 col-form-label" for="<?= $this->plugin_name ?>-slide-<?= $key ?>"><?= ($key+1) ?></label>
                                                <div class="col-sm-8">
                                                    <button type="button" class="btn btn-light btn-sm btn-media">Choisir une image</button>
                                                    <div class="content-slide my-4">
                                                        <?php if( $image = wp_get_attachment_image_src( $item->post_id, 'medium' ) ) { ?>
                                                            <img width="300" src="<?=$image[0]?>">
                                                        <?php } ?>
                                                    </div>
                                                    <input type="hidden" class="hidden-slide" id="<?= $this->plugin_name ?>-slide-<?= $key ?>" name="<?= $this->plugin_name ?>[slides][<?= $key ?>]" value="<?= $item->post_id ?>">
                                                </div>
                                                <div class="col-sm-2 mb-2"><button type="button" class="btn btn-sm btn-danger btn-delete-slide" data-target="slide-<?= $key ?>">Supprimer</button></div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="<?= admin_url('admin.php?page='. $this->plugin_name ) ?>" class="btn btn-secondary btn-sm">Annuler</a>
                    <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>

                </form>
            </div>
        </div>

        <div class="witness-code" style="display: none;">
            <div class="form-group row border-bottom slide-index">
                <label class="col-sm-2 col-form-label" for="<?= $this->plugin_name ?>-slide-index">index</label>
                <div class="col-sm-8">
                    <button type="button" class="btn btn-light btn-sm btn-media">Choisir une image</button>
                    <div class="content-slide my-4"></div>
                    <input type="hidden" class="hidden-slide" id="<?= $this->plugin_name ?>-slide-index" name="<?= $this->plugin_name ?>[slides][index]" value="">
                </div>
                <div class="col-sm-2 mb-2"><button type="button" class="btn btn-sm btn-danger btn-delete-slide" data-target="slide-index">Supprimer</button></div>
            </div>
        </div>

    </div>
    <?php
}else {
    ?><p> <?php __("You are not authorized to perform this operation.", $this->plugin_name) ?> </p><?php
}
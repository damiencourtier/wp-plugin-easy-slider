<?php

/**
 * The form to be loaded on the plugin's admin page
 */
if( current_user_can( 'edit_users' ) ) {
    ?>
    <div class="wrap easy-slider">

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-7">
                        <h3><?= get_admin_page_title() ?> - <?php esc_html_e('Slider','easy-slider') ?></h3>
                    </div>
                    <div class="col-sm-5">
                        <a href="<?= admin_url('admin.php?page='. $this->plugin_name ) ?>" type="button" class="btn btn-sm btn-secondary float-end"><?php esc_html_e('Back to the list','easy-slider') ?></a>
                    </div>
                </div>
            </div>

            <div class="card-body display-alert card-body-background">
                <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" id="slider_form_ajax" >

                    <input type="hidden" name="action" value="slider_form_response">
                    <input type="hidden" name="slider_nonce" value="<?= wp_create_nonce( 'easy_slider_form_nonce' ) ?>" />
                    <input type="hidden" id="widgets-counter" value="<?= $this->index ?>">
                    <input type="hidden" id="slider_id" name="slider_id" value="<?= $_GET['slider'] ?>">

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label" for="<?= $this->plugin_name ?>-title"><?php esc_html_e('Title','easy-slider') ?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control form-control-sm" id="<?= $this->plugin_name ?>-title" name="<?= $this->plugin_name ?>[title]" required value="<?= (!$this->new?$this->slider->title:'')?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <h5 class="mb-0"><?php esc_html_e('Slider picture:','easy-slider') ?></h5>
                                            <p><i><?php esc_html_e('You can add up to 10 images in your slider.','easy-slider') ?></i></p>
                                            <p><i><?php esc_html_e('Tip: For best results, make sure all images have the same height and width.','easy-slider') ?></i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-emoji-smile" viewBox="0 0 16 16">
                                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                    <path d="M4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
                                                </svg></p>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="float-end">
                                                <button type="button" class="btn btn-outline-info btn-sm btn-add-slide"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                                    </svg> <?php esc_html_e('Add a picture','easy-slider') ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body slides-list">

                                    <?php
                                    if(!$this->new){
                                        foreach ($this->items as $key => $item){
                                            ?>
                                            <div class="mb-2 pb-2 row border-bottom slide-<?= $key ?> item">
                                                <label class="col-sm-2 col-form-label" for="<?= $this->plugin_name ?>-slide-<?= $key ?>"><?= ($key+1) ?></label>
                                                <div class="col-sm-8">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <button type="button" class="btn btn-light btn-sm btn-media"><?php esc_html_e('Choose a picture','easy-slider') ?></button>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="content-slide">
                                                                <?php if( $image = wp_get_attachment_image_src( $item->post_id, 'medium' ) ) { ?>
                                                                    <img src="<?=$image[0]?>">
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" class="hidden-slide" id="<?= $this->plugin_name ?>-slide-<?= $key ?>" name="<?= $this->plugin_name ?>[slides][<?= $key ?>]" value="<?= $item->post_id ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 mb-2"><button type="button" class="btn btn-sm btn-danger btn-delete-slide" data-target="slide-<?= $key ?>"><?php esc_html_e('Delete','easy-slider') ?></button></div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><?php esc_html_e('Slider options:','easy-slider') ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label" for="<?= $this->plugin_name ?>-slideshowSpeed"><?php esc_html_e('Slideshow speed:','easy-slider') ?></label>
                                <div class="col-sm-2">
                                    <input type="number" class="form-control" id="<?= $this->plugin_name ?>-slideshowSpeed" name="<?= $this->plugin_name ?>[slideshowSpeed]" placeholder="7000" value="<?= (!$this->new?$this->params->slideshowSpeed:'') ?>">
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-link popover-dismiss" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="<?php esc_html_e('Set the speed of the slideshow cycling, in milliseconds','easy-slider') ?>">
                                        <span class="dashicons dashicons-editor-help "></span>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label" for="<?= $this->plugin_name ?>-animationSpeed"><?php esc_html_e('Animation speed:','easy-slider') ?></label>
                                <div class="col-sm-2">
                                    <input type="number" class="form-control" id="<?= $this->plugin_name ?>-animationSpeed" name="<?= $this->plugin_name ?>[animationSpeed]" placeholder="600" value="<?= (!$this->new?$this->params->animationSpeed:'') ?>">
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-link popover-dismiss" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="<?php esc_html_e('Set the speed of animations, in milliseconds','easy-slider') ?>">
                                        <span class="dashicons dashicons-editor-help "></span>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label" for="<?= $this->plugin_name ?>-maxItems"><?php esc_html_e('Number visible pictures:','easy-slider') ?></label>
                                <div class="col-sm-2">
                                    <select id="<?= $this->plugin_name ?>-maxItems" name="<?= $this->plugin_name ?>[maxItems]" class="form-select form-select-sm maxItems" <?= (!$this->new && $this->params->controlNavThumbnail?'disabled':'') ?>>
                                        <?php for($i = 1; $i <= 10;$i++){ ?>
                                            <option <?= (!$this->new && $this->params->maxItems == $i?'selected':'') ?> value="<?= $i ?>"><?= $i ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-link popover-dismiss" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="<?php esc_html_e('Maximum number of pictures that should be visible','easy-slider') ?>">
                                        <span class="dashicons dashicons-editor-help "></span>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3 row content-itemWidth" <?= (!$this->new && $this->params->maxItems > 1?'':'style="display:none;"') ?>>
                                 <label class="col-sm-3 col-form-label" for="<?= $this->plugin_name ?>-itemWidth"><?php esc_html_e('Image width:','easy-slider') ?></label>
                                 <div class="col-sm-2">
                                     <input type="number" class="form-control" id="<?= $this->plugin_name ?>-itemWidth" name="<?= $this->plugin_name ?>[itemWidth]" placeholder="150" value="<?= (!$this->new?$this->params->itemWidth:'') ?>">
                                 </div>
                                 <div class="col-sm-1">
                                     <button type="button" class="btn btn-link popover-dismiss" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="<?php esc_html_e('Width of each image of the slider','easy-slider') ?>">
                                         <span class="dashicons dashicons-editor-help "></span>
                                     </button>
                                 </div>
                             </div>

                            <div class="mb-3 row">
                                <div class="col-sm-3"><?php esc_html_e('Activatable options:','easy-slider') ?></div>
                                <div class="col-sm-5">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input control-nav" type="checkbox" id="<?= $this->plugin_name ?>-controlNav" name="<?= $this->plugin_name ?>[controlNav]" <?= (!$this->new && $this->params->controlNav?'checked':'') ?> <?= (!$this->new && $this->params->controlNavThumbnail?'disabled':'') ?>>
                                        <label class="form-check-label" for="<?= $this->plugin_name ?>-controlNav"><?php esc_html_e('Navigation','easy-slider') ?></label>
                                        <button type="button" class="btn btn-link popover-dismiss" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="<?php esc_html_e('Create navigation for paging control of each slide','easy-slider') ?>">
                                            <span class="dashicons dashicons-editor-help "></span>
                                        </button>
                                    </div>
                                </div>

                            </div>
                            <div class="mb-3 row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input control-nav-thumbnail" type="checkbox" id="<?= $this->plugin_name ?>-controlNavThumbnail" name="<?= $this->plugin_name ?>[controlNavThumbnail]" <?= (!$this->new && $this->params->controlNavThumbnail?'checked':'') ?>>
                                        <label class="form-check-label" for="<?= $this->plugin_name ?>-controlNavThumbnail"><?php esc_html_e('Thumbnails','easy-slider') ?></label>
                                        <button type="button" class="btn btn-link popover-dismiss" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="<?php esc_html_e('Adds navigation for pagination control of each slide with thumbnail','easy-slider') ?>">
                                            <span class="dashicons dashicons-editor-help "></span>
                                        </button>
                                    </div>
                                </div>

                                <label class="col-sm-2 col-form-label" for="<?= $this->plugin_name ?>-maxItemsThumbnail"><?php esc_html_e('Number of thumbnails:','easy-slider') ?></label>
                                <div class="col-sm-2">
                                    <select id="<?= $this->plugin_name ?>-maxItemsThumbnail" name="<?= $this->plugin_name ?>[maxItemsThumbnail]" class="form-select form-select-sm maxItemsThumbnail" <?= (!$this->new && $this->params->controlNavThumbnail?'':'disabled') ?>>
                                        <?php for($i = 1; $i <= 10;$i++){ ?>
                                            <option <?= (!$this->new && $this->params->maxItemsThumbnail == $i?'selected':'') ?> value="<?= $i ?>"><?= $i ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-link popover-dismiss" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="<?php esc_html_e('Number of visible thumbnails','easy-slider') ?>">
                                        <span class="dashicons dashicons-editor-help "></span>
                                    </button>
                                </div>

                            </div>
                            <div class="mb-3 row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-5">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="<?= $this->plugin_name ?>-directionNav" name="<?= $this->plugin_name ?>[directionNav]" <?= (!$this->new && $this->params->directionNav?'checked':'') ?>>
                                        <label class="form-check-label" for="<?= $this->plugin_name ?>-directionNav"><?php esc_html_e('Navigation arrow','easy-slider') ?></label>
                                        <button type="button" class="btn btn-link popover-dismiss" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="<?php esc_html_e('Create previous/next arrow navigation','easy-slider') ?>">
                                            <span class="dashicons dashicons-editor-help "></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-5">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="<?= $this->plugin_name ?>-slideshow" name="<?= $this->plugin_name ?>[slideshow]" <?= (!$this->new && $this->params->slideshow?'checked':'') ?>>
                                        <label class="form-check-label" for="<?= $this->plugin_name ?>-slideshow"><?php esc_html_e('Slideshow','easy-slider') ?></label>
                                        <button type="button" class="btn btn-link popover-dismiss" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="<?php esc_html_e('Setup a slideshow for the slider to animate automatically','easy-slider') ?>">
                                            <span class="dashicons dashicons-editor-help "></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-5">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input randomize" type="checkbox" id="<?= $this->plugin_name ?>-randomize" name="<?= $this->plugin_name ?>[randomize]" <?= (!$this->new && $this->params->randomize?'checked':'') ?> <?= (!$this->new && $this->params->controlNavThumbnail?'disabled':'') ?>>
                                        <label class="form-check-label" for="<?= $this->plugin_name ?>-randomize"><?php esc_html_e('Randomize','easy-slider') ?></label>
                                        <button type="button" class="btn btn-link popover-dismiss" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="<?php esc_html_e('Randomize slide order, on load','easy-slider') ?>">
                                            <span class="dashicons dashicons-editor-help "></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="<?= admin_url('admin.php?page='. $this->plugin_name ) ?>" class="btn btn-secondary btn-sm"><?php esc_html_e('Cancel','easy-slider') ?></a>
                    <button type="submit" class="btn btn-primary btn-sm"><?php esc_html_e('Save','easy-slider') ?></button>

                </form>
            </div>
        </div>

        <div class="witness-code" style="display: none;">
            <div class="mb-2 pb-2 row border-bottom slide-index item">
                <label class="col-sm-2 col-form-label" for="<?= $this->plugin_name ?>-slide-index">index</label>
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-light btn-sm btn-media"><?php esc_html_e('Choose a picture','easy-slider') ?></button>
                        </div>
                        <div class="col-sm-8">
                            <div class="content-slide"></div>
                        </div>
                        <input type="hidden" class="hidden-slide" id="<?= $this->plugin_name ?>-slide-index" name="<?= $this->plugin_name ?>[slides][index]" value="">
                    </div>
                </div>
                <div class="col-sm-2 mb-2"><button type="button" class="btn btn-sm btn-danger btn-delete-slide" data-target="slide-index"><?php esc_html_e('Delete','easy-slider') ?></button></div>
            </div>
        </div>

    </div>
    <?php
}else {
    ?><p> <?php __('You are not authorized to perform this operation.','easy-slider') ?> </p><?php
}
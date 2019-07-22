<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once FL_BLOG_HEADER;
?>
<form class="form-horizontal form-label-left" name="frm-add-blog" id="frm-add-blog" enctype="multipart/form-data">
    <h2>Add New</h2>
    <div style="">
        <input type="text" id="txt-title" name="txt_title" required="required" class="form-control col-md-7 col-xs-12">
        <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor-one">
            <div class="btn-group">
                <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
                <ul class="dropdown-menu">
                </ul>
            </div>

            <div class="btn-group">
                <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a data-edit="fontSize 5">
                            <p style="font-size:17px">Huge</p>
                        </a>
                    </li>
                    <li>
                        <a data-edit="fontSize 3">
                            <p style="font-size:14px">Normal</p>
                        </a>
                    </li>
                    <li>
                        <a data-edit="fontSize 1">
                            <p style="font-size:11px">Small</p>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="btn-group">
                <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
            </div>

            <div class="btn-group">
                <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
                <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
            </div>

            <div class="btn-group">
                <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
            </div>

            <div class="btn-group">
                <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
                <div class="dropdown-menu input-append">
                    <input class="span2" placeholder="URL" type="text" data-edit="createLink" />
                    <button class="btn" type="button">Add</button>
                </div>
                <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
            </div>

            <!--<div class="btn-group">-->
            <!--    <a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="fa fa-picture-o"></i></a>-->
            <!--    <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />-->
            <!--</div>-->

            <div class="btn-group">
                <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
            </div>
        </div>

        <div id="editor-one" class="editor-wrapper"></div>

        <textarea name="txt_description" id="descr" style="display:none;"></textarea>
        <?php
        $args = array(
            'hide_empty' => false
        );
        $terms = get_terms('category', $args);
        ?>
        <p style="padding: 5px;">
            <?php foreach( $terms as $key => $val ) { ?>

                <input type="checkbox" name="txt_term[]" value="<?php echo $val->term_id; ?>" class="flat chk-categories" /> <?php echo $val->name; ?>
                <br />

            <?php } ?>
        <p>
        <div class="upload-btn-wrapper">
            <button class="btn">Upload a file<i class="fa fa-upload" aria-hidden="true"></i></button>
            <input type="file" name="featured_image"  id="featured-image"/>
            
        </div>
        <input type="hidden" name="pid" id="pid" value="0" />
        <div class="remove-featured">
            <i class="fa fa-times" aria-hidden="true"></i>
        </div>
        <div class="set-featured"></div>
        <input type="hidden" value="add_update_blog" name="action"/>
        <button type="submit"> Submit</button>
    </div>
    
</div>
</form>
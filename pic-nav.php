<?php

/**
 * 图片展示页
 *
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php'); ?>
<div class="page-wrap archive-page <?php if ($this->options->bcool_animate !== "close" || !empty($this->options->bcool_animate)) : ?>animate__animated animate__<?php $this->options->bcool_animate() ?><?php endif; ?>">
    <div class="archive-header">
        <div class="wrap wrap-center">
            <div class="wrap_float">
                <?php
                $options = Typecho_Widget::widget('Widget_Options');
                $thumbs = explode("|", $options->bcool_cover); /*获取文章封面*/
                $num = count($thumbs);
                shuffle($thumbs);
                ?>

                <div class="post-description">
                    共计<?php echo $num; ?>张图片
                </div>

            </div>
        </div>
    </div>

    <div class="archive-body">
        <div class="wrap">
            <div class="wrap_float grid">
                    <div class="portfolio">
                         <?php for($i=0;$i<$num;$i++) : ?>
                            <div class="portfolio-item p-2 col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <div class="content" href='<?php echo $thumbs[$i]?>'>
                                    <div class="thumb clearbg">
                                        <img class="lazy" src="<?php $this->options->themeUrl('./assets/img/loading.gif'); ?>"
                                             data-src="<?php echo $thumbs[$i]; ?>" error-src="<?php $this->options->themeUrl('./assets/img/404.jpg'); ?>" alt=""/>
                                    </div>
                                </div>
                            </div>
                        <?php endfor; ?>

                    </div>
                    
            </div>
        </div>
    </div>

<?php $this->need('footer.php'); ?>
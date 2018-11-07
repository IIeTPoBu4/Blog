<?php 
use yii\helpers\Url; 
use yii\widgets\LinkPager;
?>

<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <article class="post">
                    <div class="post-thumb">
                        <a href="blog.html"><img src=" <?= $article->getImage();?> " alt=""></a>
                    </div>
                    <div class="post-content">
                        <header class="entry-header text-center text-uppercase">
                            <h6><a href="<?= Url::toRoute(['site/category','id'=>$article->category->id])?>"> <?= $article->category->title?></a></h6>
                            <h1 class="entry-title"><a href="<?= Url::toRoute(['site/view','id'=>$article->id])?>"><?= $article->title?></a></h1>


                        </header>
                        <div class="entry-content">
                            <?= $article->content ?>
                            </p>
                        </div>
                        <div class="decoration">

                            <?php foreach($tags as $tag):?>
                            <a href="#" class="btn btn-default"><?= $tag->title;?></a>
                            <?php endforeach;?>
                        </div>

                        <div class="social-share">
							<span
                                    class="social-share-title pull-left text-capitalize"><?= $article->getDate(); ?></span>
                            
                        </div>
                    </div>
                </article>
               
               <?= $this->render('/partials/comment',[
                'article'=>$article,
                'comments'=>$comments,
                'commentForm'=>$commentForm
               ])?>
            </div>
            <?= $this->render('/partials/sidebar', [
            'popular'=>$popular,
            'recent'=>$recent,
            'categories'=>$categories
            ]);?>
        </div>
    </div>
</div>
<!-- end main content-->
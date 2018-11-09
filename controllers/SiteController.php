<?php
namespace app\controllers;
use app\models\Article;
use app\models\Category;
use app\models\CommentForm;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Tag;
use yii\helpers\ArrayHelper;


class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $data = Article::getAll(); 
        $popular = Article::getPopular();
        $recent = Article::getRecent();
        $categories = Category::getAll();
        //$tags = ArrayHelper::map($article->tags, 'id', 'title');

        return $this->render('index', [
                             'articles'=>$data['articles'],
                             'pagination'=>$data['pagination'],
                             'popular'=>$popular,
                             'recent'=>$recent,
                             'categories'=>$categories,
                             //'tags'=>$tags
                         ]);
    }

    public function actionView($id)
    {
        $article = Article::findOne($id);    
        $popular = Article::getPopular();
        $recent = Article::getRecent();
        $categories = Category::getAll();
        $tags = $article->tags;
        $comments = $article->getArticleComments();
        $commentForm= new CommentForm();
        $model = $this->findModel($id);
        $model->getCountViewPost();
        
        return $this->render('single',[
            'article'=>$article,
            'popular'=>$popular,
            'recent'=>$recent,
            'categories'=>$categories,
            'tags'=>$tags,
            'comments'=>$comments,
            'commentForm'=>$commentForm,
            'model'=>$model,
        ]);
    }

    public function actionCategory($id)
    {
        $data = Category::getArticlesByCategory($id);
        $popular = Article::getPopular();
        $recent = Article::getRecent();
        $categories = Category::getAll();
        

        
        return $this->render('category',[
            'articles'=>$data['articles'],
            'pagination'=>$data['pagination'],
            'popular'=>$popular,
            'recent'=>$recent,
            'categories'=>$categories
            
        ]);
    }
    /**
     * Login action.
     *
     * @return string
     */
    
    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }
    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionComment($id)
    {
        $model = new CommentForm();

        if(Yii::$app->request->isPost)

        {
            $model->load(Yii::$app->request->post());

            if($model->saveComment($id))
            {
                Yii::$app->getSession()->setFlash('comment','Your comment will be added soon! Thank you!');
                return $this->redirect(['site/view','id'=>$id]);
            }
        }
    }
}
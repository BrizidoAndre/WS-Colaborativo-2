<?php

namespace app\controllers\api\v1;

use app\models\Comment;
use app\models\LoginForm;
use app\models\Post;
use app\models\Posttag;
use app\models\RegisterPostForm;
use app\models\Tag;
use app\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

class PostsController extends \app\base\RestController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // remove authentication filter
        unset($behaviors['authenticator']);
        // re-add authentication filter
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'only' => ['POST create', 'GET mine']
        ];
        return $behaviors;
    }


    public function actionIndex($sortBy = 'popular', $page = 1, $pageSize = 10)
    {
        $query = Post::find();
        switch ($sortBy) {
            case 'popular':
                $query->leftJoin(Comment::tableName(), 'post.id = comment.postId');
                $query->groupBy('post.id')->orderBy(['COUNT(comment.id)' => SORT_DESC]);
                break;
            case 'unanswered':
                $query->leftJoin(Comment::tableName(), 'post.id = comment.postId');
                $query->groupBy('post.id')->having(['COUNT(comment.id)' => 0]);
                break;
            default:
                $query->orderBy(['createdAt' => SORT_DESC]);
                break;
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
                'page' => $page - 1
            ]
        ]);

        return [
            'totalCount' => $dataProvider->totalCount,
            'posts' => $this->formatList($dataProvider),
        ];
    }

    public function actionSearch($q)
    {
        $query = Post::find();
        $query->leftJoin(Posttag::tableName(), 'post.id = postTag.postId');
        $query->leftJoin(Tag::tableName(), 'postTag.tagId = tag.id');
        $query->groupBy('post.id');
        $query->where(['like', 'post.title', $q]);
        $query->orWhere(['like', 'post.description', $q]);
        $query->orWhere(['like', 'tag.title', $q]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
                'page' => 0
            ]
        ]);

        return [
            'totalCount' => $dataProvider->totalCount,
            'posts' => $this->formatList($dataProvider),
        ];
    }

    public function actionSingle($id)
    {
        if ($post = Post::findOne($id)) {
            return $this->formatSingle($post);
        } else throw new NotFoundHttpException('Post not found.');
    }

    public function actionMine($sortBy = 'popular', $page = 1, $pageSize = 10)
    {
        $query = Post::find();
        switch ($sortBy) {
            case 'popular':
                $query->leftJoin(Comment::tableName(), 'post.id = comment.postId');
                $query->groupBy('post.id')->orderBy(['COUNT(comment.id)' => SORT_DESC]);
                break;
            default:
                $query->orderBy(['createdAt' => SORT_DESC]);
                break;
        }
        $query->where(['post.userId' => Yii::$app->user->id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
                'page' => $page - 1
            ]
        ]);
        return [
            'totalCount' => $dataProvider->totalCount,
            'posts' => $this->formatList($dataProvider),
        ];
    }

    public function actionCreate()
    {
        $model = new RegisterPostForm();
        if ($model->load(\Yii::$app->request->post(), '') && $model->validate()) {
            $post = new Post([
                'title' => $model->title,
                'description' => $model->description,
                'content' => $model->content,
                'userId' => Yii::$app->user->id
            ]);
            if ($post->save()) {
                foreach ($model->tags as $tag) {
                    $postTag = new PostTag([
                        'postId' => $post->id,
                        'tagId' => $tag
                    ]);
                    $postTag->save();
                }
                $this->response->statusCode = 201;
                return [
                    'id' => $post->id
                ];
            }
            return 'ok';
        }
        $this->response->statusCode = 422;
        return [
            'errors' => $model->getErrors()
        ];
    }

    private function formatList($dataProvider)
    {
        $returnArray = [];
        foreach ($dataProvider->getModels() as $post) {
            $returnObj = $post->toArray();
            $returnObj['tags'] = $post->tags;
            $returnArray[] = $returnObj;
        }

        return $returnArray;
    }

    private function formatSingle($post)
    {
        $returnObj = $post->toArray();
        $returnObj['tags'] = $post->tags;
        $returnObj['author'] = $post->user->name;

        $returnComments = [];
        foreach ($post->comments as $comment) {
            $returnComment = $comment->toArray();
            $returnComment['author'] = $comment->user->name;
            $returnComment['score'] = $comment->getScore();
            $returnComment['myVote'] = $comment->getMyVote();
            $returnComments[] = $returnComment;
        }
        usort($returnComments, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });
        $returnObj['comments'] = $returnComments;

        return $returnObj;
    }
}
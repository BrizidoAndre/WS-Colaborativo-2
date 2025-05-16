<?php

namespace app\controllers\api\v1;

use app\models\Comment;
use app\models\CommentForm;
use app\models\LoginForm;
use app\models\Post;
use app\models\Posttag;
use app\models\RegisterPostForm;
use app\models\User;
use app\models\Vote;
use app\models\VoteForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;
use yii\web\UnprocessableEntityHttpException;

class CommentsController extends \app\base\RestController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // remove authentication filter
        unset($behaviors['authenticator']);
        // re-add authentication filter
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => ['options']
        ];
        return $behaviors;
    }

    public function actionCreate($id)
    {
        if (Post::findOne($id)) {
            $model = new CommentForm();
            if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
                $comment = new Comment([
                    'postId' => $id,
                    'userId' => Yii::$app->user->id,
                    'content' => $model->content
                ]);
                if ($comment->save()) {
                    Yii::$app->response->statusCode = 201;
                    return [
                        'id' => $comment->id
                    ];
                }
            }
            Yii::$app->response->statusCode = 422;
            return [
                'errors' => $model->errors
            ];
        } else throw new NotFoundHttpException('Post not found.');
    }

    public function actionVote($id)
    {
        if (Comment::findOne($id)) {
            $model = new VoteForm();
            if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
                if ($vote = Vote::findOne(['userId' => Yii::$app->user->id, 'commentId' => $id])) {
                    $vote->positive = $model->positive ? 1 : 0;
                    Yii::$app->response->statusCode = 200;
                } else {
                    $vote = new Vote([
                        'commentId' => $id,
                        'userId' => Yii::$app->user->id,
                        'positive' => $model->positive ? 1 : 0,
                    ]);
                    Yii::$app->response->statusCode = 201;
                }
                $vote->save();
                return [
                    'positive' => $vote->positive
                ];
            }
            Yii::$app->response->statusCode = 422;
            return [
                'errors' => $model->errors
            ];
        } else throw new NotFoundHttpException('Comment not found.');
    }
}